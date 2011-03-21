<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/2/11
 * Time: 10:07 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Ajax extends Controller {
    public function before() {
        Session::$default = "database";
    }

    public function json($data) {
        echo json_encode($data);
    }
}
