<?php

class Controller_Refer extends Controller_App {
	public $template = 'refer';
	
	public function action_index() {
	$this->layout->hideContentPane = true;
	}
}