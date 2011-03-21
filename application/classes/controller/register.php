<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/26/11
 * Time: 1:21 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Register extends Controller_App {
    public $template = 'register';

    public function action_index() {
        if($this->request->post()) {
            $member = ORM::factory('member');

            $post = $this->request->post();

            if($member->validate($post)) {
                $member->register($post);

                $email = View::factory('emails/welcome')
                        ->set('id', $member->id)
                        ->set('firstname', $member->firstname)
                        ->set('email1', $member->email)
                        ->set('password', $post['pass1'])
                        ->render();

                $email = (string) $email;
                
                $headers = "From: noreply@swiftsharing.net\r\n";

                mail($member->email, '[SwiftSharing] Welcome to SwiftSharing!', $email, $headers);

                $this->request->redirect("/");
            } else {
                $this->template->errors = $member->errors;
                $this->template->data = $post;
            }
        } else {
            $this->template->data = array();
        }
    }
    
    public function action_activate() {
		$member = Model_Member::loadFromID($this->request->param('id'));
		
		$this->template = View::factory('activate');
		
		if($member) {
			if($member->password == $this->request->param('sequence') && $member->email_activated == false) {
				$member->email_activated = '1';
				
				$member->save();
				
				$this->template->message = 'Activation successful. <br/><br/>You may <a href="/login">Login</a> now.';
			} else {
				$this->template->message = 'Your activation is invalid.';
			}
		} else {
			$this->template->message = 'Sorry, that user does not exist.';
		}
	}
}
