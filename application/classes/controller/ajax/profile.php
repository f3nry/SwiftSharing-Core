<?php

/**
 * Controller_Ajax_Profile
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Controller_Ajax_Profile extends Controller_Ajax {
    public function action_friends() {
        $this->_requireAuth();
        
        $member = Model_Member::loadFromID($this->request->param('id'));
        
        echo $member->generateLongFriendsList();

        exit;
    }
}