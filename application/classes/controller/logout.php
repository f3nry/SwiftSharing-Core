<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/27/11
 * Time: 10:38 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Logout extends Controller_App {
    public function action_index() {
        $this->_checkSession("/login", false);

        Session::instance()->destroy();

        $this->request->redirect("/");
    }
}
