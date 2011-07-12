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
        $recaptcha = new Recaptcha();
        
        if($this->request->post()) {
            $member = ORM::factory('member');

            $post = $_POST;
            
            if($member->validate($post, $recaptcha)) {
                $member->register($post);

                if(!Session::instance()->get('from_facebook')) {
                    $email = View::factory('emails/welcome')
                            ->set('id', $member->id)
                            ->set('firstname', $member->firstname)
                            ->set('email1', $member->email)
                            ->set('password', $post['password'])
                            ->render();

                    $email = (string) $email;

                    $headers = "From: noreply@swiftsharing.net\r\n";

                    mail($member->email, '[SwiftSharing] Welcome to SwiftSharing!', $email, $headers);
                } else {
                    $member->email_activated = true;
                    $member->fb_authorized = true;

                    $member->save();
                    $member->login();

                    Session::instance()->set('flash_facebook', true);
                    Session::instance()->delete('from_facebook');
                }

                $this->request->redirect("/refer");
            } else {
                $this->template->errors = $member->errors;

                $post['birth_month_text'] = date('F', mktime(0, 0, 0, @$post['birth_month']));

                $this->template->data = $post;
            }
        } else {
            if(Session::instance()->get('from_facebook')) {
                $member = Kohana_Facebook::instance()->account();

                $this->template->data = array(
                    'username' => @$member['username'],
                    'firstname' => @$member['first_name'],
                    'lastname' => @$member['last_name'],
                    'email1' => @$member['email'],
                    'email2' => @$member['email'],
                    'humantext' => true
                );

                $this->template->message = 'Please fill out this quick registration page, to login to SwiftSharing. We\'ve already filled it out partially for you with information you gave us from Facebook.';
            } else {
                $this->template->data = array();
            }
        }
        
        if($this->template instanceof View) {
            $this->template->recaptcha = $recaptcha->html();
        }
    }
    
    public function action_activate() {
        $member = Model_Member::loadFromID($this->request->param('id'));

        $this->template = View::factory('activate');

        if($member) {
                if($member->password == $this->request->param('sequence') && $member->email_activated == false) {
                        $member->email_activated = '1';

                        $member->save();

                        Session::instance()->set('refer', true);

                        $this->template->message = 'Activation successful. <br/><br/>You may <a href="/login">Login</a> now.';
                } else {
                        $this->template->message = 'Your activation is invalid.';
                }
        } else {
                $this->template->message = 'Sorry, that user does not exist.';
        }
    }
    
    public function action_check() {
        if($this->request->param('field')) {
            $status = false;
            $field = $this->request->param('field');
            
            if($field == "username") {
                $status = Model_Member::checkUsername($_GET['fieldValue']);
            } else if($field == "email") {
                $status = Model_Member::checkEmail($_GET['fieldValue']);
            }
            
            echo json_encode(array(
                $field, $status
            ));
            
            exit;
        }
    }
}