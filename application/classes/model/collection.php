<?php

/**
 * Description of photo_collection
 *
 * @author paul
 */
class Model_Collection extends App_ORM {

  protected $_table_name = "photo_collections";
  
  protected $_has_many = array(
      'photos' => array(
	  'model' => 'photo',
	  'foreign_key' => 'collection_id'
      )
  );

  public function getId() {
    return $this->id;
  }

  public function getCreatedBy() {
    return $this->created_by;
  }

  public function getName() {
    return $this->name;
  }

  public function setCreatedBy($created_by) {
    if($created_by instanceof Model_User) {
      $created_by = $created_by->id;
    }
    
    $this->created_by = $created_by;
  }

  public function setName($name) {
    $this->name = $name;
  }
  
  public function getPhotos() {
    return Model_Photo::factory('photo')
	    ->where('collection_id', '=', $this->id)
	    ->find_all();
  }
  
  public function publish() {
    $this->published = true;
    
    $this->save();
    
    $blab = new Model_Blab();
    
    $blab->mem_id = Session::instance()->get('user_id');
    $blab->text = $this->name;
    $blab->date = date("Y-m-d h:i:s");
    $blab->feed_id = Model_Feed::PHOTO_FEED;
    $blab->type = 'ALBUM';
    $blab->ref_id = $this->getId();
    
    $blab->save();
  }
}

?>
