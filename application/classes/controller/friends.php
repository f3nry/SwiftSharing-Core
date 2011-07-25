<?php

/**
 * Description of Controller_Friends
 *
 * @author Paul <paulhenry@mphwebsystems.com>
 */
class Controller_Friends extends Controller_App {

  public $template = "feed";

  public function action_index() {
    $this->_requireAuth();

    $feed = Model_Feed::factory('feed');
    $member = Model_Member::loadFromID(Session::instance()->get('user_id'));

    $feed->full_title = 'Your Friend\'s posts';

    $this->template->feed = $feed;
    $this->template->feed_content = Util_Feed_Generator::factory()
	    ->set('feed_id', '*')
	    ->set('friends_only', true)
	    ->set('show_from', true)
	    ->set('types', array(
		'STATUS', 'PHOTO'
	    ))
	    ->load()
	    ->render();

    $this->template->feed_list = Model_Feed::generateFeedList();

    $this->layout->hideContentPane = true;
    $this->template->hideShareForm = true;
    $this->template->onlyFriends = true;
  }
}
