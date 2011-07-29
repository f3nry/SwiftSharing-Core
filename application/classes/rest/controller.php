<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author paul
 */
class Rest_Controller extends Controller {  
  public function __construct() {
    header('Content-type: text/json');
    parent::__construct();
  }
  
  public function __call($entity, $params) {
    $entity = ORM::factory($entity, $params[0]);
    
    $get = $this->input->get();
    $post = $this->input->post();
    
    if(count($post) == 0) {
      return $this->get($entity);
    } else {
      switch($post['action']) {
	case 'delete':
	  $this->delete($entity);
	  break;
	case 'update':
	  $this->update($entity);
	case 'create':
	  $this->create($entity, $params[0], $post);
	  break;
	default:
	  break;
      }
    }
  }
  
  protected function get(ORM $entity) {
    
  }
  
  protected function update(ORM $entity, Array $post) {
    
  }
  
  protected function create(ORM $entity, $identifier, Array $post) {
    
  }
  
  public function delete() {
    
  }
}
