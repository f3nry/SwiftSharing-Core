<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/2/11
 * Time: 10:07 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Ajax_Feed extends Controller_Ajax {
    public function action_index() {

    }

    public function action_new() {
        $this->_requireAuth();

        $post = $_POST;

        if($post) {
            $feed = Model_Feed::getFeed($post['feed_id']);

            $blab = ORM::factory('blab');

            if(!$blab->type) {
                $blab->type = 'STATUS';
            }

            $blab->mem_id = Session::instance()->get('user_id');
            $blab->date = date('Y-m-d H:i:s');
            $blab->text = $post['text'];
            $blab->feed_id = $post['feed_id'];
            $blab->type = (isset($post['type']) && ($post['type'] == 'PROFILE' || $post['type'] == 'PHOTO' || $post['type'] == 'COMMENT')) ? $post['type'] : "STATUS";

            $blab->save();

            if($blab->type == "PHOTO" && isset($_FILES['photo'])) {
                $s3 = new Amazon_S3();

                $photo = Images::resizeLocalTmpImage($_FILES['photo']['tmp_name'], $blab->id . '.jpg', 120, 0);

                $s3->uploadFile(Images::DEFAULT_BUCKET, 'members/' . Session::instance()->get('user_id') . '/' . $photo['new_filename'], $photo['tmp_path'], true);
                $s3->uploadFile(Images::DEFAULT_BUCKET, 'members/' . Session::instance()->get('user_id') . '/' . $blab->id . '.jpg', $_FILES['photo']['tmp_name'], true);

                $this->request->redirect('/feed/' . $blab->feed_id);

                exit;
            }

            echo Model_Feed::getBlab($blab->id, true);
        }
    }

    public function action_more() {
        $this->_requireAuth();

        $blab = Model_Blab::getById($_POST['lastmsg']);

        if($blab) {
            echo Model_Feed::getFeedContent($blab->feed_id, "'STATUS' OR b.type = 'PHOTO'", false, $blab->date);

            exit;
        }
    }

    public function action_past() {
        $this->_requireAuth();

        $blab = Model_Blab::getById($_POST['lastmsg']);

        if($blab) {
            if($_POST['profile_flag']) {
                echo Model_Feed::getFeedContent('*', "'STATUS' OR b.type = 'PHOTO'", $_POST['feed_id'], $blab->date, true);
            } else {
                echo Model_Feed::getFeedContent($blab->feed_id, "'STATUS' OR type = 'PHOTO'", false, $blab->date, true);
            }
            
            exit;
        }
    }

    public function action_delete() {
        $this->_requireAuth();
        
        $blab = Model_Blab::getById($this->request->post('id'));

        if($blab) {
            if(Session::instance()->get('user_id') != $blab->mem_id && !($blab->type == 'PROFILE' && $blab->feed_id == Session::instance()->get('user_id'))) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Sorry, you don't own that blab, and so you cannot delete it."
                ));
            } else {
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

    public function comment() {
        $this->_requireAuth();
        
        $post = $_POST;

        if($post) {
            $blab = ORM::factory('blab');

            if(!$blab->type) {
                $blab->type = 'STATUS';
            }

            $blab->mem_id = Session::instance()->get('user_id');
            $blab->date = date('Y-m-d H:i:s');
            $blab->text = $post['text'];
            $blab->feed_id = $post['feed_id'];
            $blab->type = "STATUS";

            $blab->save();

            echo Model_Feed::getBlab($blab->id, true);
        }
    }
}
