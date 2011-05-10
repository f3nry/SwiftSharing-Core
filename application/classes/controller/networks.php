<?php

class Controller_Networks extends Controller_App {
	public $template = 'networks';
	
	public function action_index() {
	$this->layout->hideContentPane = true;
	}
}