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

        if($this->template instanceof View) {
            $this->template->session = Session::instance();
        }

        if($this->layout instanceof View) {
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
                $this->_protectedRedirect($redirPath);
            } else {
                return true;
            }
        } else {
            if(!Session::instance()->get('user_id')) {
                $this->_protectedRedirect($redirPath);
            } else {
                return true;
            }
        }
    }
    
    protected function _protectedRedirect($redirectPath) {
        if($this->request->is_ajax()) {
            echo json_encode(array('error' => $redirPath));
            
            exit;
        } else {
            $this->request->redirect($redirPath);
        }
    }

    /**
     * Require that the user be logged in.
     *
     * @return bool
     */
    protected function _requireAuth($path = "/login") {
        return $this->_checkSession($path, false);
    }
}
