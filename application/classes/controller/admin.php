<?php

/**
 * Controller to manage and administrator's account.
 * 
 * Controls the login, logout, and manage an adminstrators session.
 */
class Controller_Admin extends Controller_App {
    /**
     * Set the layout and call parent before()
     */
    public function before() {
        $this->layout = "layouts/admin";
        
        parent::before();
    }
    
    /**
     * Verify that the session is valid for an administrator
     *
     * @param type $redirPath
     * @param type $exists
     * @return type 
     */
    protected function _checkSession($redirPath, $exists = false) {
        if(!parent::_checkSession($redirPath, $exists)) {
            return false;
        } else {
            if(!Session::instance()->get('is_admin')) {
                $this->request->redirect($redirPath);
                
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Require user to be logged in as an administrator
     *
     * @return type 
     */
    protected function _requireAuth() {
        return $this->_checkSession("/admin/login");
    }
    
    public function action_login() {
        
    }
    
    public function action_index() {
        $this->_requireAuth();
        
        
    }
}
