<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/26/11
 * Time: 12:32 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_App extends Controller_Template {

    public function before() {
        parent::before();

        Util_Analytics_Engine::record($this->request);

        if($this->template) {
            $this->template->session = Session::instance();
        }

        if($this->layout) {
            $this->layout->session = Session::instance();
        }
    }

    public function after() {
        if(Session::instance()->get('user_id') && $this->layout && !isset($this->layout->member)) {
            $this->layout->member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        }

        parent::after();
    }

    /**
     * Check the session, whether it exists or not. Or whether it doesn't exist or not.
     *
     * @param  $redirPath Path to redirect too
     * @param bool $exists If true, redirect if session exists. If false, redirect if the session doesn't exist.
     * @return bool
     */
    protected function _checkSession($redirPath, $exists = false) {
        if($exists) {
            if(Session::instance()->get('user_id')) {
                $this->request->redirect($redirPath);
            } else {
                return true;
            }
        } else {
            if(!Session::instance()->get('user_id')) {
                $this->request->redirect($redirPath);
            } else {
                return true;
            }
        }
    }

    /**
     * Require that the user be logged in.
     *
     * @return bool
     */
    protected function _requireAuth() {
        return $this->_checkSession("/login", false);
    }
}
