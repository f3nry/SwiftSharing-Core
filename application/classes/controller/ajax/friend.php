<?php

class Controller_Ajax_Friend extends Controller_Ajax {
    public function action_accept() {
        $this->_requireAuth();
        
        Model_FriendRequest::confirmRequest($_POST['reqID']);
        
        return;
    }
    
    public function action_deny() {
        $this->_requireAuth();
        
        Model_FriendRequest::denyRequest($_POST['reqID']);
        
        return;
    }
    
    public function action_remove() {
        $this->_requireAuth();
        
        $to = preg_replace('#[^0-9]#i', '', $_POST['id']);
        $from = Session::instance()->get('user_id');

        if(!$to || !$from) {
            echo 'Error: Missing data.';
            exit;
        }

        if($to == $from) {
            echo 'Error: You cannot add yourself as a friend.';
            exit;
        }

        $fromMember = Model_Member::loadFromID($from);
        $toMember = Model_Member::loadFromID($to);

        if(!$fromMember) {
            echo 'Error: From Member doesn\'t exist';
            exit;
        }

        if(!$toMember) {
            echo 'Error: To Member doesn\'t exist';
            exit;
        }

        if(!Model_Relationship::findRelationship($to, $from)->is_loaded()) {
            echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This member is not your friend.';
            exit();
        }

        Model_Relationship::findRelationship($to, $from)->removeRelationship();

        echo 'You are no longer friends with this member.';
        exit();
    }

    public function action_request() {
        $this->_requireAuth();
        
        $to = preg_replace('#[^0-9]#i', '', $_POST['id']);
        $from = Session::instance()->get('user_id');

        if(!$to || !$from) {
            echo 'Error: Missing data.';
            exit;
        }

        if($to == $from) {
            echo 'Error: You cannot add yourself as a friend.';
            exit;
        }

        $fromMember = Model_Member::loadFromID($from);
        $toMember = Model_Member::loadFromID($to);

        if(!$fromMember) {
            echo 'Error: From Member doesn\'t exist';
            exit;
        }

        if(!$toMember) {
            echo 'Error: To Member doesn\'t exist';
            exit;
        }

        if(Model_Relationship::findRelationship($to, $from)->is_loaded()) {
            echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This member is already your friend.';
            exit();
        }

        if(Model_FriendRequest::checkFriendRequest($from, $to)) {
            echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> You have a Friend request pending for this member. Please be patient.';
            exit();
        }

        if(Model_FriendRequest::checkFriendRequest($to, $from)) {
            echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This user has requested you as a Friend already! Check your Requests on your profile.';
            exit();
        }

        if(!Model_FriendRequest::createNew($from, $to)) {
            die('Failed to insert friend request. Please try again later.');
        }

        echo '<img src="/content/images/round_success.png" width="20" height="20" alt="Success" /> Friend request sent successfully. This member must approve the request.';

        //Begin HTML Email Message
        $message = View::factory('emails/friend_request')
                ->set('toMember', $toMember)
                ->set('fromMember', $fromMember)
                ->render();
        
        Email::connect();
        Email::send($toMember->email, "noreply@swiftsharing.net", "[SwiftSharing] New Friend Request From " . $fromMember->getName() . "!", $message);

        exit;
    }

    public function action_index() {
        if($_POST['request'] == "acceptFriend") {
            Model_FriendRequest::confirmRequest($_POST['reqID']);
            
            return;
        } else if($_POST['request'] == "denyFriend") {
            Model_FriendRequest::denyRequest($_POST['reqID']);

            echo "Request Denied.";
            return;
        } else if($_POST['request'] == 'removeFriendship') {
            $to = preg_replace('#[^0-9]#i', '', $_POST['id']);
            $from = Session::instance()->get('user_id');

            if(!$to || !$from) {
                echo 'Error: Missing data.';
                exit;
            }

            if($to == $from) {
                echo 'Error: You cannot add yourself as a friend.';
                exit;
            }

            $fromMember = Model_Member::loadFromID($from);
            $toMember = Model_Member::loadFromID($to);

            if(!$fromMember) {
                echo 'Error: From Member doesn\'t exist';
                exit;
            }

            if(!$toMember) {
                echo 'Error: To Member doesn\'t exist';
                exit;
            }

            if(!Model_Relationship::findRelationship($to, $from)->is_loaded()) {
                echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This member is not your friend.';
                exit();
            }

            Model_Relationship::findRelationship($to, $from)->removeRelationship();

            echo 'You are no longer friends with this member.';
            exit();
        } else if($_POST['request'] == 'requestFriendship') {
            $to = preg_replace('#[^0-9]#i', '', $_POST['id']);
            $from = Session::instance()->get('user_id');

            if(!$to || !$from) {
                echo 'Error: Missing data.';
                exit;
            }

            if($to == $from) {
                echo 'Error: You cannot add yourself as a friend.';
                exit;
            }

            $fromMember = Model_Member::loadFromID($from);
            $toMember = Model_Member::loadFromID($to);

            if(!$fromMember) {
                echo 'Error: From Member doesn\'t exist';
                exit;
            }

            if(!$toMember) {
                echo 'Error: To Member doesn\'t exist';
                exit;
            }

            if(Model_Relationship::findRelationship($to, $from)->is_loaded()) {
                echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This member is already your friend.';
                exit();
            }

            if(Model_FriendRequest::checkFriendRequest($from, $to)) {
                echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> You have a Friend request pending for this member. Please be patient.';
                exit();
            }

            if(Model_FriendRequest::checkFriendRequest($to, $from)) {
                echo '<img src="/content/images/round_error.png" width="20" height="20" alt="Error" /> This user has requested you as a Friend already! Check your Requests on your profile.';
                exit();
            }

            if(!Model_FriendRequest::createNew($from, $to)) {
                die('Failed to insert friend request. Please try again later.');
            }

            echo '<img src="/content/images/round_success.png" width="20" height="20" alt="Success" /> Friend request sent successfully. This member must approve the request.';

            //Begin HTML Email Message
            $message = "Hi {$toMember->firstname},

    {$fromMember->firstname} would like to be your friend on SwiftSharing!

    You can respond to this request by visiting the following URL:

    http://swiftsharing.net/{$toMember->username}

    Thanks,
    The SwiftSharing Team";
           //end of message
            $headers  = "From: SwiftSharing <noreply@swiftsharing.net>\r\n";
            $headers .= "Content-type: text\r\n";

            mail($toMember->email, "New Friend Request From {$fromMember->firstname}", $message, $headers);

            exit;
        }
    }
}
