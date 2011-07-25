<?php

/**
 * Description of photo
 *
 * @author paul
 */
class Model_Photo extends App_ORM {
  public static $allowedExtensions = array('jpeg', 'png', 'jpg', 'gif');
  public static $sizeLimit = 10485760;
  
  public $collection;
  
  public function setCreatedBy($user) {
    if($user instanceof Model_User) {
      $user_id = $user->id;
    } else {
      $user_id = $user;
    }
    
    $this->created_by = $user_id;
  }
  
  public function getCreatedBy() {
    return $this->created_by;
  }
  
  public function setCollection($collection) {
    if($collection instanceof Model_PhotoCollection) {
      $collection_id = $collection->getId();
    } else {
      $collection_id = $collection;
    }
    
    $this->collection_id = $collection_id;
  }
  
  public function getCollection() {
    return $this->collection_id;
  }
  
  public function loadCollection() {
    $this->collection = new Model_Collection($this->getCollection());
  }
  
  public function previous() {
    $sql = "SELECT id FROM photos WHERE id < {$this->id} AND collection_id = {$this->getCollection()} ORDER BY id DESC LIMIT 1";
    
    return DB::query(Database::SELECT, $sql)
	    ->execute()
	    ->get('id', 0);
  }
  
  public function next() {
    $sql = "SELECT id FROM photos WHERE id > {$this->id} AND collection_id = {$this->getCollection()} LIMIT 1";
    
    return DB::query(Database::SELECT, $sql)
	    ->execute()
	    ->get('id', 0);
  }
  
  public function getUrl() {
    return Images::getImageViaUrl($this->url);
  }
  
  public function handleUpload() {
    $uploader = new qqFileUploader(self::$allowedExtensions, self::$sizeLimit);
    
    $result = $uploader->handleUpload("/tmp/uploads");
    
    if(isset($result['success'])) {
      $url = "members/" . Session::instance()->get('user_id') . "/albums/" . $this->getCollection() . "/" . uniqid();
      
      if(Images::uploadImage($url, $uploader->getFullFilePath())) {
	$this->url = $url;
	
	if(!$this->created_by) {
	  $this->created_by = Session::instance()->get('user_id');
	}
	
	return true;
      } else {
	return array('error' => 'Failed to upload image.');
      }
    } else {
      return $result;
    }
  }
}

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return uniqid() . $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return uniqid() . $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;
    
    protected $file_path;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    public function getName() {
      return $this->file->getName();
    }
    
    public function getFullFilePath() {
      return $this->file_path;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
	
	if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
	
	$this->file_path = $uploadDirectory . $filename . '.' . $ext;
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            return array('success'=>true);
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}

?>
