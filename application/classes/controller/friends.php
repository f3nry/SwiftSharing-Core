<?php
/**
 * Description of Controller_Friends
 *
 * @author Paul <paulhenry@mphwebsystems.com
 */
class Controller_Friends extends Controller_App {
    public $template = "feed";

    public function action_index() {
        $this->_requireAuth();

        $feed = Model_Feed::factory('feed');
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));

        $feed->full_title = 'Your Friend\'s posts';

        $this->template->feed = $feed;
        $this->template->feed_content = $member->generateFriendBlabs();
        $this->template->feed_list = Model_Feed::generateFeedList();

        $this->layout->hideContentPane = true;
        $this->template->hideShareForm = true;
    }
}
?>
