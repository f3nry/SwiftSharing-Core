<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller Welcome
 *
 * Home pages for SwiftSharing
 */
class Controller_Home extends Controller_App {
    public $template = 'home';

    public $layout = false;

    public $javascript = array(
        'feed'
    );

    public function before() {
        if(Session::instance('mango')->get('user_id')) {
            $this->template = 'dashboard';

            $this->layout = 'layouts/template';
        } else {
            $this->template = 'home_logged_out';

            $this->layout = 'layouts/template';
        }

        parent::before();
    }

    public function action_index() {
        if(Session::instance()->get('username')) {
            $this->layout->hideContentPane = false;

            $this->template->feed_list = Model_Feed::generateFeedList();

            $member = Model_Member::loadFromID(Session::instance()->get('user_id'));

            $this->template->member = $member;
            $this->template->latest_post = $member->getLatestPost();
            $this->template->latest_post = @$this->template->latest_post[0];

            $this->template->friend_suggestions = Model_Member::factory('member')
                    ->where('email_activated', '=', '1')
                    ->and_where('', 'NOT', DB::expr('EXISTS(SELECT 1 FROM friend_relationships fr WHERE myMembers.id = fr.from AND fr.to = ' . $member->id . ')'))
                    ->order_by(DB::expr('RAND()'))
                    ->limit(4)
                    ->find_all();
        } else {
            $this->layout->styles = array('home');
        }

        $this->layout->hideContentPane = true;
    }
    
    public function action_404() {
		$this->template = View::factory('404');
		
		$this->layout->hideContentPane = true;
	}
} // End Welcome
