<?php

class Controller_About extends Controller_App {
	public $template = 'about';
	
	public function action_index() {
		$this->template->blah = "Foo";
	}
}