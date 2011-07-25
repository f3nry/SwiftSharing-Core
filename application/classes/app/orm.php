<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orm
 *
 * @author paul
 */
class App_ORM extends ORM {
  public function save(Validation $validation = null) {
    $this->updated_date = date("Y-m-d h:i:s");
    
    if(!$this->loaded()) {
      $this->created_date = date("Y-m-d h:i:s");
    }
    
    parent::save($validation);
  }
}

?>
