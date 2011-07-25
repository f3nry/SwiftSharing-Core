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

    if (Session::instance()->get('is_admin')) {
      $this->layout->logged_in = true;
    } else {
      $this->layout->logged_in = false;
    }
  }

  /**
   * Verify that the session is valid for an administrator
   *
   * @param type $redirPath
   * @param type $exists
   * @return type 
   */
  protected function _checkSession($redirPath, $exists = false) {
    if (!Session::instance()->get('is_admin') && !$exists) {
      $this->request->redirect($redirPath);

      return false;
    } else if (Session::instance()->get('is_admin') && $exists) {
      $this->request->redirect($redirPath);
    }

    return true;
  }

  /**
   * Require user to be logged in as an administrator
   *
   * @return type 
   */
  protected function _requireAuth($path = "/admin/login") {
    return $this->_checkSession($path);
  }

  public function action_login($admin = false) {
    if (Session::instance()->get("is_admin")) {
      $this->request->redirect("/admin");
    }

    parent::action_login(true);
  }

  public function action_index() {
    $this->_requireAuth();
  }

}
