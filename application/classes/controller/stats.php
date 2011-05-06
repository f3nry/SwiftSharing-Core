<?php

class Controller_Stats extends Controller_App {
	public $template = 'stats';
	
	public function action_index() {
		$this->layout->hideContentPane = true;
	}
}
