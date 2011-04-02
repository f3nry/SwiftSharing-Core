<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/26/11
 * Time: 1:14 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Login extends Controller_App {
    public $template = 'login';

    public function action_index() {
        parent::_checkSession("/", true);

        $post = $this->request->post();

        if($post) {
            $member = ORM::factory('member')
                        ->where('email', '=', $post['email'])
                        ->and_where('password', '=', md5($post['pass']))
                        ->find();

            if($member->is_loaded() && $member->email_activated == '1') {
                Session::instance()->set('user_id', $member->id);
                Session::instance()->set('username', $member->username);

                $this->request->redirect("/");
            } else if($member->email_activated == '0') {
                $this->template->message = 'Your account is not activated yet. Please check your email.';
                $this->template->email = $post['email'];
            } else {
                $this->template->message = "Wrong username/password. Please try again.";
                $this->template->email = $post['email'];
            }
        }

        $this->layout->hideContentPane = true;
    }

    public function action_facebook() {
        parent::_checkSession("/", true);

        if(Kohana_Facebook::instance()->logged_in()) {
            $facebook_account = Kohana_Facebook::instance()->account();

            $member = Model_Member::loadFromEmail($facebook_account['email']);

            if(!$member->is_loaded()) {
                Session::instance()->set('from_facebook', true);

                $this->request->redirect("/register");
            } else {
                if($member->fb_authorized && $member->email_activated) {
                    $member->login();

                    $this->request->redirect("/");
                } else {
                    if(!$member->email_activated) {
                        $this->template->message = 'Your account is not activated yet. Please check your email.';
                    } else {
                        $this->template = View::factory('facebook/confirm');

                        if($this->request->post('pass')) {
                            if($member->password == md5($this->request->post('pass'))) {
                                $member->login();

                                $member->fb_authorized = true;
                                $member->save();

                                Session::instance()->set('flash_facebook', true);

                                $this->request->redirect("/");
                            } else {
                                $this->template->message = 'You entered the wrong password. Please try again.';
                            }
                        }

                        $this->template->member = $member;
                    }
                }
            }
        } else {
            $this->template->message = 'You have not authorized SwiftSharing access, and we are unable to log you in. Please try again.';
        }

        $this->layout->hideContentPane = true;
    }

    public function action_forgot() {
        parent::_checkSession("/", true);

        $post = $this->request->post();

        $this->template = View::factory('forgot_password');

        if($post) {
            $member = Model_Member::loadFromEmail($post['email']);

            if($member) {
                $emailcut = substr($member->email, 0, 4); // Takes first four characters from the user email address
                $randNum = rand();
                $tempPass = "$emailcut$randNum";
                $hashTempPass = md5($tempPass);

                $member->password = $hashTempPass;

                $member->save();

                Email::connect();

                $email = (string) View::factory('emails/forgot_password')
                        ->set('member', $member)
                        ->set('newPassword', $tempPass)
                        ->render();

                Email::send($member->email, 'noreply@swiftsharing.net', '[SwiftSharing] Password Reset', $email, true);

                $this->template->output = "<font color=\"#006600\"><strong>Your new password has been emailed to you.</strong></font>";
            } else {
                $this->template->output = '<font color="#FF0000">There is no account with that info<br />
                                                                                     in our records, please try again.</font>';
            }
        }
    }
}
