<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/1/11
 * Time: 12:12 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Profile extends Controller_App {
    public $template = "profile";

    public function action_index() {
        $this->layout->hideContentPane = true;

        $this->template->member = Model_Member::factory('member')->where('username', '=', $this->request->param('username'))->find();

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
    }
    
    public function action_photos() {
      $this->action_index();
      
      $this->template->photo = new Model_Photo(Session::instance()->get('photo_id'));
      $this->template->photo->loadCollection();
      //Session::instance()->delete('photo_id');
    }
    
    public function action_name() {
        $this->_requireAuth("You are not logged in, sorry.");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            $member->firstname = $this->request->post('firstname');
            $member->lastname  = $this->request->post('lastname');
            $member->email     = $this->request->post('email');
            
            $member->setBirthday($this->request->post());
            
            $member->gender  = $this->request->post('gender');
            $member->country = $this->request->post('country');
            $member->city    = $this->request->post('city');
            $member->state   = $this->request->post('state');
            
            $member->save();
            
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry.'));
        }
    }
    
    public function action_password() {
        $this->_requireAuth("You are not logged in, sorry.");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            if(md5($this->request->post('current_password')) != $member->password)  {
                echo json_encode(array('error' => 'The current password that you entered is incorrect. Please try again.'));
            } else {
                if($this->request->post('new_password') != $this->request->post('repeat_new_password')) {
                    echo json_encode(array('error' => 'The two passwords do not match. Please try again.'));
                } else {
                    if(strlen($this->request->post('new_password')) < 6) {
                        echo json_encode(array('error' => 'The password is to short. It must be at least 6 characters long.'));
                    } else {
                        $member->password = md5($this->request->post('new_password'));
                        
                        $member->save();
                        
                        echo json_encode(array('success' => true));
                    }
                }
            }
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry.'));
        }
    }
    
    public function action_links() {
        $this->_requireAuth("You are not logged in, sorry.");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            $member->facebook = $this->request->post('facebook');
            $member->website = $this->request->post('website');
            $member->twitter = $this->request->post('twitter');
            $member->youtube = $this->request->post('youtube');
            
            $member->save();
            
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry.'));
        }
    }
    
    public function action_bio() {
        $this->_requireAuth("You are not logged in, sorry");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            $member->bio_body = $this->request->post('bio_body');
            
            $member->save();
            
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry.'));
        }
    }
    
    public function action_interests() {
        $this->_requireAuth("You are not logged in, sorry.");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            $member->music = $this->request->post('music');
            $member->movies = $this->request->post('movies');
            $member->tv = $this->request->post('tv');
            $member->books = $this->request->post('books');
            
            $member->save();
            
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry.'));
        }
    }
    
    public function action_privacy() {
        $this->_requireAuth("You are not logged in, sorry.");
        
        $this->template = false;
        $this->layout = false;
        
        $member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        
        if($member->is_loaded()) {
            $member->privacy_option = $this->request->post('privacy');
            
            $member->save();
            
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => 'Could not find member, sorry'));
        }
    }
    
    public function action_picture() {
        $this->_requireAuth();
        
        $this->template = false;
        $this->layout = false;
        
        $post = $this->request->post();
        
        if(!Model_Member::updateProfileImage(Session::instance()->get('user_id'), $_FILES['fileField']['tmp_name'])) {
                    
        }
        
        $this->request->redirect('/profile/edit');
    }
    
    public function action_background() {
        $this->_requireAuth();
        
        $this->template = false;
        $this->layout = false;
        
        $post = $this->request->post();
        
        Model_Member::updateBackground(Session::instance()->get('user_id'), $_FILES['bgField']['tmp_name']);
        
        $this->request->redirect('/profile/edit');
    }
    
    public function action_edit() {
        $this->_requireAuth();
        
        $this->template = View::factory('profile_edit');

        $this->layout->hideContentPane = true;

        if($post = $this->request->post()) {
            if($post['parse_var'] == 'pic') {
                if(!Model_Member::updateLocation(Session::instance()->get('user_id'), $post)) {
                    
                } else {
                    $this->template->success_msg = "You information was successfully updated.";
                }
            } else if($post['parse_var'] == 'links') {
                if(!Model_Member::updateLinks(Session::instance()->get('user_id'), $post)) {

                } else {
                    $this->template->success_msg = "You information was successfully updated.";
                }
            } else if($post['parse_var'] == 'bio') {
                if(!Model_Member::updateBio(Session::instance()->get('user_id'), $post)) {

                } else {
                    $this->template->success_msg = "You information was successfully updated.";
                }
            } else if($post['parse_var'] == 'bg') {
                if(!Model_Member::updateBackground(Session::instance()->get('user_id'), $_FILES['bgField']['tmp_name'])) {
                    
                } else {
                    $this->template->success_msg = "Your image was successfully uploaded. Please allow a few moments for the changes to take place.";
                }
            } else if($post['parse_var'] == "interests") {
                if(!Model_Member::updateInterests(Session::instance()->get('user_id'), $post)) {

                } else {
                    $this->template->success_msg = "You information was successfully updated.";
                }
            } else if($post['parse_var'] == 'privacy') {
                if(!Model_Member::updatePrivacy(Session::instance()->get('user_id'), $post)) {

                } else {
                    $this->template->success_msg = "You information was successfully updated.";
                }
            }
        }

        $this->template->member = Model_Member::factory('member', Session::instance()->get('user_id'));
    }

	public function action_redirect() {
		$member = Model_Member::loadFromID($this->request->param('id'));
		
		$this->request->redirect('/' . $member->username);
	}
	
	public function action_request() {
		$this->layout = false;
		
		$request = Model_FriendRequest::findByID($this->request->param('id'));
		
		echo View::factory('profile/request')
					->set('request', $request)
					->render();
		
		die;
	}
}
