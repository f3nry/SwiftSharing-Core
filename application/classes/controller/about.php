<?php

class Controller_About extends Controller_App {
	public $template = 'pages/masthead';
	
	public function action_masthead() {
		
	}

	public function action_about() {
		$this->template = View::factory('pages/about');
	}
}
