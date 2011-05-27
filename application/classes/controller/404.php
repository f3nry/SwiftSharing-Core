<?php

/**
 * 404
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Controller_404 extends Controller_App {
    public $template = "pages/404";

    public function index() {
        $this->layout->hideContentPane = true;
    }
}