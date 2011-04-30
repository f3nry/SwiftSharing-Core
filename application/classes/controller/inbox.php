<?php

class Controller_Inbox extends Controller_App {

    public $template = 'inbox';

    public function action_index() {
        $this->_requireAuth();
    }
    
    public function action_view() {
        $this->_requireAuth();

        $this->template->message = Model_PrivateMessage::loadMessage($this->request->param('id'));
    }

    public function action_reply() {
        $this->_requireAuth();

        $conversation = Model_PrivateMessage::loadMessage($this->request->param('id'));

        if($conversation) {
            $data = $this->request->post();

            if($data['from'] == $conversation->from->id) {
                $to = $conversation->to->id;
            } else if($data['from'] == $conversation->to->id) {
                $to = $conversation->from->id;
            } else {
                die('Error: You are not appart of this conversation.');
            }

            if(!Model_PrivateMessage::sendMessage($conversation->id, $data['message'], $data['from'], $to)) {
                die('Error: Failed to send message.');
            }

            $this->request->redirect('/inbox/view/' . $conversation->id);
        } else {
            die('Error: Can\'t find specified conversation.');
        }
    }

}