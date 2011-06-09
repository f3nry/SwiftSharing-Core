<?php

class Controller_Admin_Chat extends Controller_Admin {
	public function action_index() {
		$this->_requireAuth();
		
		$this->template->users = Model_Feature::getUsers('chat');
	}
	
	public function action_add() {
		$this->_requireAuth();
		
		if($this->request->param('id')) {
			Model_Feature::addUser("chat", $this->request->param('id'));
			
			$this->request->redirect('/admin/chat/add');
		}
	}
	
	public function action_remove() {
		$this->_requireAuth();
		
		if($this->request->param('id')) {
			Model_Feature::removeUser('chat', $this->request->param('id'));
			
			$this->request->redirect('/admin/chat');
		}
	}
}
