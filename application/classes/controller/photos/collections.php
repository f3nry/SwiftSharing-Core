<?php

/**
 * Description of collection
 *
 * @author paul
 */
class Controller_Photos_Collections extends Controller_Ajax {

  public function action_new() {
    $this->_requireAuth();

    $collection = new Model_Collection();

    $post = $this->request->post();

    if ($post) {
      $name = $post['name'];

      if (empty($name)) {
	return $this->json(array('error' => 'You must specify a name for the Photo Album'));
      } else {
	$collection->setName($name);
	$collection->setCreatedBy(Session::instance()->get('user_id'));

	$collection->save();

	return $this->json(array('success' => true, 'collection_id' => $collection->getId()));
      }
    } else {
      return $this->json(array('error' => 'No data to create Photo Collection with.'));
    }
  }

  public function action_add() {
    $this->_requireAuth();

    $collection = new Model_Collection($this->request->query('collection_id'));

    if ($collection->getId()) {
      $photo = new Model_Photo();

      $photo->setCollection($collection->getId());

      $result = $photo->handleUpload();

      if (is_array($result)) {
	return $this->json($result);
      } else {
	$photo->save();

	return $this->json(array('success' => true, 'url' => $photo->getUrl()));
      }
    } else {
      return $this->json(array('error' => 'Could not find collection.'));
    }
  }
  
  public function action_update() {
    $this->_requireAuth();
    
    $collection = new Model_Collection($this->request->post('collection_id'));
    
    if ($collection->getId()) {
      $collection->name = $this->request->post('name');
      
      $collection->save();
      
      return $this->json(array('success' => true));
    } else {
      return $this->json(array('error' => 'Invalid collection'));
    }
  }
  
  public function action_publish() {
    $this->_requireAuth();
    
    $collection = new Model_Collection($this->request->post('collection_id'));
    
    if($collection->getId()) {
      $collection->publish();
      
      return $this->json(array('success' => true));
    } else {
      return $this->json(array('error' => 'Invalid collection'));
    }
  }
  
  public function action_link() {
    $photo = new Model_Photo($this->request->param('id'));
    
    $user = new Model_Member($photo->created_by);
    
    Session::instance()->set('photo_id', $photo->id);
    
    $this->request->redirect('/' . $user->username . "/photos");
  }

}

?>
