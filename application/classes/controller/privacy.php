<?php

class Controller_Privacy extends Controller_App {
	public $template = 'privacy';
	
	public function action_index() {
		$this->template->blah = "Foo";
	}
}