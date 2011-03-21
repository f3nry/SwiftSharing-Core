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

        $this->template->blabs = Model_Feed::getFeedContent('*', "'STATUS' OR type = 'PHOTO'", $this->template->member->id);
    }
    
    public function action_edit() {
        $this->_requireAuth();
        
        $this->template = View::factory('profile_edit');

        $this->layout->fullWidthLayout = true;

        if($post = $this->request->post()) {
            if($post['parse_var'] == 'pic') {
                if(!Model_Member::updateProfileImage(Session::instance()->get('user_id'),
                                                     $_FILES['fileField']['tmp_name'])) {
                    die('Failed to upload file.');
                } else {
                    $this->template->success_msg = "Your image was successfully uploaded. Please allow a few moments for the changes to take place.";
                }
            } else if($post['parse_var'] == 'location') {
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
}
