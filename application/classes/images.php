<?php
 
class Images {
    const DEFAULT_BUCKET = 'swiftsharing-cdn-dev';

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
        $image = new Imagick($tmp_path);

        if($width == 0 || $height == 0 || !$crop) {
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
        
        if(!$s3->downloadFile(self::DEFAULT_BUCKET, $remote_file_path, $local_file_path)) {
            return false;
        }

        $new_file = self::resizeLocalTmpImage($local_file_path, $image, $width, $height, $crop);

        $status = $s3->uploadFile(self::DEFAULT_BUCKET, "members/" . $id . "/" . $new_file['new_filename'], $new_file['tmp_path'], true);

        unlink($local_file_path);
        unlink($new_file['tmp_path']);

        return $status;
    }

    /**
     * Get the requested image from S3
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

        $filename = strip_filename($real_image_path);
        $extension = strip_extension($real_image_path);
        $path = strip_path($real_image_path);

        if(!$width && !$height) {
            $path = "https://s3.amazonaws.com/" . self::DEFAULT_BUCKET . "/" . $path . "/" . $filename . "." . $extension;
        } else {
            $path = "https://s3.amazonaws.com/" . self::DEFAULT_BUCKET . "/" . $path . "/" . $filename . "x$width"."x$height" . "xed." . $extension;
        }

        if($asHTML) {
            return "<img src=\"$path\" />";
        } else {
            return $path;
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
