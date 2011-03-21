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
        if(Session::instance('database')->get('user_id')) {
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

            $this->template->feed_content = Model_Feed::getFeedContent(1);

            $this->template->feed = Model_Feed::getFeed(1);
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
