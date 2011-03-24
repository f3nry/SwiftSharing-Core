<?php

class Controller_Ajax_Inbox extends Controller_Ajax {

    public function action_new() {
        $this->_requireAuth();
        
        if ($_POST['message']) {
            $to = preg_replace('#[^0-9]#i', '', $_POST['to']);
            $from = Session::instance()->get('user_id');
            $subject = htmlspecialchars($_POST['subject']); // Convert html tags and such to html entities which are safer to store and display
            $message = htmlspecialchars($_POST['message']); // Convert html tags and such to html entities which are safer to store and display
            $subject = mysql_real_escape_string($subject); // Just in case anything malicious is not converted, we escape those characters here
            $message = mysql_real_escape_string($message); // Just in case anything malicious is not converted, we escape those characters here

            $data = array(
                'to' => $to,
                'subject' => $subject,
                'message' => $message
            );

            if (!Model_PrivateMessage::begin($data)) {
                echo '<img src="/content/images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  Could not send message! An insertion query error has occured.';
                exit();
            } else {
                echo '<img src="/content/images/round_success.png" alt="Success" width="31" height="30" /> &nbsp;&nbsp;&nbsp;<strong>Message sent successfully</strong>';
                exit();
            }
        }
    }
}

?>
