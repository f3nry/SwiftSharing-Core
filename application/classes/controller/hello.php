<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/25/11
 * Time: 11:33 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Hello extends Controller_App {
    public $template = 'site';

    public function action_index() {
        $this->template->message = 'hello, world!';
    }
}
