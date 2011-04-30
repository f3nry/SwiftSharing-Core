<?php

class Controller_Page extends Controller_App {
	public $template = 'page';
	
	public function action_index() {
	$this->layout->hideContentPane = true;
	}
}
