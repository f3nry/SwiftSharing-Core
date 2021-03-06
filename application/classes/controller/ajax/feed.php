<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/2/11
 * Time: 10:07 PM
 * To change this template use File | Settings | File Templates.
 */

class Controller_Ajax_Feed extends Controller_Ajax
{
	public function action_index()
	{

	}

	public function action_new()
	{
		$this->_requireAuth();

		$post = $_POST;

		if ($post) {
			$feed = Model_Feed::getFeed($post['feed_id']);

			$blab = ORM::factory('blab');

			if (!$blab->type) {
				$blab->type = 'STATUS';
			}

			$blab->mem_id = Session::instance()->get('user_id');
			$blab->date = date('Y-m-d H:i:s');
			$blab->text = trim($post['text']);
			$blab->feed_id = $post['feed_id'];
			$blab->type = (isset($post['type']) && ($post['type'] == 'PROFILE' || $post['type'] == 'PHOTO' || $post['type'] == 'COMMENT'))
							? $post['type'] : "STATUS";

			if (empty($blab->text)) {
				return;
			}

			$blab->save();

			if ($blab->type == "PHOTO" && isset($_FILES['photo'])) {
				$s3 = new Amazon_S3();

				$photo = Images::resizeLocalTmpImage($_FILES['photo']['tmp_name'], $blab->id . '.jpg', 120, 0);

				$s3->uploadFile(Images::$bucket, 'members/' . Session::instance()->get('user_id') . '/' . $photo['new_filename'], $photo['tmp_path'], true);
				$s3->uploadFile(Images::$bucket, 'members/' . Session::instance()->get('user_id') . '/' . $blab->id . '.jpg', $_FILES['photo']['tmp_name'], true);

				$this->request->redirect('/feed/' . $blab->feed_id);

				exit;
			}

			if ($blab->type == "COMMENT") {
				$parent_blab = Model_Blab::getById($post['feed_id']);

				$parent_blab->deleteFromCache();

				if ($blab->mem_id != $parent_blab->mem_id) {
					Model_Notification::notify($parent_blab->mem_id)
									->setText($blab->member->getName() . " commented on your post.")
									->setType("COMMENT")
									->setRef($parent_blab->id)
									->save();
				} else {
					Model_Notification::notify($parent_blab)
									->setText($blab->member->getName() . " commented on your post.")
									->setType("COMMENT")
									->setRef($parent_blab->id)
									->save();
				}
			} else if ($blab->type == "PROFILE") {
				if ($blab->feed_id != Session::instance()->get('user_id')) {
					$member = Model_Member::loadFromID(Session::instance()->get('user_id'));

					Model_Notification::notify($blab->feed_id)
									->setText($member->getName() . " wrote on your profile.")
									->setType("WALL")
									->setRef($blab->id)
									->save();
				}
			}

			echo Util_Feed_Generator::factory()
							->load($blab->id)
							->render();
		}
	}

	public function action_more()
	{
		$this->_requireAuth();

		$blab = Model_Blab::getById($_POST['lastmsg']);

		if ($blab) {
			echo Util_Feed_Generator::factory()
							->set('feed_id', $blab->feed_id)
							->set('member', false)
							->set('lastdate', $blab->date)
							->set('reverse', false)
							->set('types', array(
							                    'STATUS', 'PHOTO'
							               ))
							->load()
							->render();
			exit;
		}
	}

	public function action_past()
	{
		$this->_requireAuth();

		$blab = Model_Blab::getById($_POST['lastmsg']);

		if ($blab) {
			if (isset($_POST['profile_flag']) && $_POST['profile_flag']) {
				echo Util_Feed_Generator::factory()
								->set('feed_id', '*')
								->set('member', $_POST['feed_id'])
								->set('lastdate', $blab->date)
								->set('reverse', true)
								->set('show_from', true)
								->set('types', array(
								                    'STATUS', 'PHOTO'
								               ))
								->load()
								->render();
			} else if (isset($_POST['friends_flag']) && $_POST['friends_flag']) {
				echo Util_Feed_Generator::factory()
								->set('feed_id', '*')
								->set('lastdate', $blab->date)
								->set('friends_only', true)
								->set('reverse', true)
								->set('show_from', true)
								->set('types', array(
								                    'STATUS', 'PHOTO'
								               ))
								->load()
								->render();
			} else {
				echo Util_Feed_Generator::factory()
								->set('feed_id', $blab->feed_id)
								->set('member', false)
								->set('lastdate', $blab->date)
								->set('reverse', true)
								->set('types', array(
								                    'STATUS', 'PHOTO'
								               ))
								->load()
								->render();
			}

			exit;
		}
	}

	public function action_delete()
	{
		$this->_requireAuth();

		if($this->request->post('type') == "ALBUM") {
			$collection = new Model_Collection($this->request->post('id'));

			if(Session::instance()->get('user_id') != $collection->created_by) {
				echo json_encode(array(
																"success" => false,
																"message" => "Sorry, you don't own that blab, and so you cannot delete it."
													 ));
			} else {
				$collection->delete();

				echo json_encode(array(
																'success' => true,
													 ));
			}
		} else {
			$blab = Model_Blab::getById($this->request->post('id'));

			if ($blab) {
				if (Session::instance()->get('user_id') != $blab->mem_id && !($blab->type == 'PROFILE' && $blab->feed_id == Session::instance()->get('user_id'))) {
					echo json_encode(array(
																"success" => false,
																"message" => "Sorry, you don't own that blab, and so you cannot delete it."
													 ));
				} else {
					if ($blab->type == "COMMENT") {
						$parent_blab = Model_Blab::getById($blab->feed_id);
						$parent_blab->deleteFromCache();
					}

					$blab->delete();

					echo json_encode(array(
																'success' => true,
													 ));
				}
			} else {
				echo json_encode(array(
															'success' => false,
															"message" => "That blab does not exist, sorry."
												 ));
			}
		}
	}

	public function comment()
	{
		$this->_requireAuth();

		$post = $_POST;

		if ($post) {
			$blab = ORM::factory('blab');

			if (!$blab->type) {
				$blab->type = 'STATUS';
			}

			$blab->mem_id = Session::instance()->get('user_id');
			$blab->date = date('Y-m-d H:i:s');
			$blab->text = $post['text'];
			$blab->feed_id = $post['feed_id'];
			$blab->type = "STATUS";

			$blab->save();

			echo Util_Feed_Generator::factory()
							->load($blab->id)
							->render();

		}
	}
}
