<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller Welcome
 *
 * Home pages for SwiftSharing
 */
class Controller_Home extends Controller_App {
    public $template = 'profile';

    public $layout = false;

    public $javascript = array(
        'feed'
    );

    public function before() {
        if(Session::instance()->get('user_id')) {
            $this->layout = 'layouts/template';
        } else {
            $this->template = 'home_logged_out';

            $this->layout = 'layouts/template';
        }

        parent::before();
    }

    public function action_index() {
        if(Session::instance()->get('username')) {
	        $this->template = View::factory('profile');

          $this->layout->hideContentPane = true;

					$this->template->member = Model_Member::factory('member')->where('id', '=', Session::instance()->get('user_id'))->find();

					if(!$this->template->member->is_loaded()) {
							$this->request->redirect('/404');
					}

					//$this->template->blabs = Model_Feed::getFeedContent('*', "'STATUS' OR b.type = 'PHOTO'", $this->template->member->id);

					$this->template->blabs = Util_Feed_Generator::factory()
													->set('feed_id', '*')
													->set('member', $this->template->member->id)
													->set('show_from', true)
													->set('types', array(
															'STATUS', 'PHOTO'
													))
													->load()
													->render();
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
