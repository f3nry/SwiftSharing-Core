<?php

class Controller_Ajax_Notifications extends Controller_Ajax {
	protected $no_record = true;
	
	public function action_poll() {
		$this->_requireAuth(array('error' => 'You\'re not logged in.'));
		
		$notifications = Model_Notification::getPollNotifications(Session::instance()->get('user_id'), true);
		
		return $this->json($notifications);
	}
}