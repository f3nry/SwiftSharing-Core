<?php

if(Kohana::$environment == Kohana::PRODUCTION) {
	Images::$bucket = "swiftsharing-cdn";
} else {
	Images::$bucket = "swiftsharing-cdn-dev";
}

/**
 * Class for handling interactions with Amazon S3
 * 
 * Includes management of caching resized images, and uploading/resizing images
 * out of Amazon S3
 */
class Images {
  public static $bucket = 'swiftsharing-cdn';
  
  public static function uploadImage($remote_path, $local_path) {
    $s3 = new Amazon_S3();
    
    return $s3->uploadFile(Images::$bucket, $remote_path, $local_path);
  }

  /**
   * Resize a local temporary file.
   *
   * @static
   * @param  $tmp_path Local filesystem path of the file
   * @param  $filename Actual filename
   * @param int $width Width of the image
   * @param int $height Height of the image
   * @return array
   */
  public static function resizeLocalTmpImage($tmp_path, $filename, $width = 0, $height = 0, $crop = false) {
    try {
        $image = new Imagick($tmp_path);
    } catch(ImagickException $e) {
        return false;
    }

    if ($width == 0 || $height == 0 || !$crop) {
      $image->thumbnailImage($width, $height);
    } else {
      $image->cropImage($width, $height, 0, 0);
    }

    $filename = strip_filename($filename);
    $newTmpPath = strip_path($tmp_path) . "/" . uniqid(time());

    $image->writeImage($newTmpPath);

    return array(
        'tmp_path' => $newTmpPath,
        'new_filename' => $filename . "x$width" . "x$height" . "xed.jpg"
    );
  }

  /**
   * Downloads, resizes, and uploads an image from Amazon S3
   *
   * @param integer $id Member ID
   * @param string $image The name of the file in the member's directory.
   * @param integer $width Width of the new image
   * @param integer $height Height of the new image
   * @param bool $crop Crop the photo, or just thumbnail it?
   * @return bool True if success, false if failure.
   */
  public static function downloadResizeAndUpload($id, $image, $width, $height, $crop = false) {
    $s3 = new Amazon_S3();

    $local_file_path = "/tmp/" . uniqid(microtime());
    $remote_file_path = "members/" . $id . "/" . $image;

    if (!$s3->downloadFile(self::$bucket, $remote_file_path, $local_file_path)) {
      return false;
    }

    $new_file = self::resizeLocalTmpImage($local_file_path, $image, $width, $height, $crop);
    
    if(!$new_file) {
        return false;
    }
    
    $status = $s3->uploadFile(self::$bucket, "members/" . $id . "/" . $new_file['new_filename'], $new_file['tmp_path'], true);

    unlink($local_file_path);
    unlink($new_file['tmp_path']);

    return $status;
  }

  /**
   * Get the requested image from S3
   * 
   * MongoStructure:
   * 
   * {
   *  "member": 1
   *  "path": "image01.jpg"
   *  "width": 50,
   *  "height": 50,
   * }
   *
   * @static
   * @param  $id Member ID
   * @param  $image File path in the member's data directory
   * @param  $width Width of the image
   * @param  $height Height of the image
   * @param bool $noCache
   * @param bool $asHTML
   * @return void
   */
  public static function getImage($id, $image, $width = 0, $height = 0, $noCache = false, $asHTML = false) {
    $real_image_path = 'members/' . $id . '/' . $image;
    
    return self::getImageViaUrl($real_image_path, $width, $height, $noCache, $asHTML, $id, $image);
  }
  
  public static function getImageViaUrl($url, $width = 0, $height = 0, $forceCache = false, $asHTML = false, $id = 0, $image = false) {
    $real_image_path = $url;
    
    $filename = strip_filename($real_image_path);
    $extension = strip_extension($real_image_path);
    $path = strip_path($real_image_path);
    
    if($extension) {
      $extension = "." . $extension;
    }
    
    if($width != 0 || $height != 0) {
      if(!self::checkCached($id, $filename, $width, $height)) {
	      if($forceCache) {
					$path = "/images/get";
					$path .= URL::query(array(
						'id' => $id,
						'path' => $url,
						'width' => $width,
						'height' => $height,
						'images' => $image
					));

					if($asHTML) {
						return "<img src=\"$path\" />";
					} else {
						return $path;
					}
		    }

        self::downloadResizeAndUpload($id, $image, $width, $height);

        self::setImageCached($id, $filename, $width, $height);
      }
    }

		if (!$width && !$height) {
			$path = "https://s3.amazonaws.com/" . self::$bucket . "/" . $path . "/" . $filename . $extension;
		} else {
			$path = "https://s3.amazonaws.com/" . self::$bucket . "/" . $path . "/" . $filename . "x$width" . "x$height" . "xed" . $extension;
		}

    if ($asHTML) {
      return "<img src=\"$path\" />";
    } else {
      return $path;
    }
  }
  
  /**
   * Deletes any images that were recorded as being cached
   *
   * @param Integer $id The ID of the user to be cached
   * @param string $filename The actual name of the filename to be cached
   * @return boolean
   */
  public static function deleteCached($id, $filename) {
    return MangoDB::instance()->remove('images', array(
        'member' => (integer)$id,
        'filename' => $filename
    ));
  }
  
  /**
   * Sets the specified image, and id, with the specified width and height as
   * sucessfully cached on Amazon S3.
   *
   * @param integer $id The ID of the member to use
   * @param string $filename The actual file name
   * @param integer $width The width of the image
   * @param integer $height The height of the image
   * @return type 
   */
  protected static function setImageCached($id, $filename, $width, $height) {
    $document = array(
        'member'   => (integer)$id,
        'bucket'   => self::$bucket,
        'filename' => $filename,
        'width'    => (integer)$width,
        'height'   => (integer)$height
    );
    
    return MangoDB::instance()->insert('images', $document);
  }
  
  /**
   * Check and see if we have record of caching the specified image
   * belong to the specified user, with the specified width and height in
   * MongoDB
   *
   * @param integer $id The literal id of the member
   * @param string $filename The filename to look for
   * @param integer $width The width of the image
   * @param integer $height The height of the image
   * @return type 
   */
  protected static function checkCached($id, $filename, $width, $height) {
    $db = MangoDB::instance();

    $file = $db->find_one('images', array(
                'member'   => (integer)$id,
                'bucket'   => self::$bucket,
                'filename' => $filename,
                'width'    => (integer) $width,
                'height'   => (integer) $height
            )
          );

    if ($file) {
      return true;
    } else {
      return false;
    }
  }
}

function strip_filename($path) {
  return pathinfo($path, PATHINFO_FILENAME);
}

function strip_extension($path) {
  return pathinfo($path, PATHINFO_EXTENSION);
}

function strip_path($path) {
  return pathinfo($path, PATHINFO_DIRNAME);
}
