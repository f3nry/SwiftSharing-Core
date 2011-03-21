<?php

class Controller_Help extends Controller_App {
	public $template = 'help';
	
	public function action_index() {
		$this->template->blah = "Foo";
	}
}