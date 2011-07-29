<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 7/28/11
 * Time: 11:17 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_Util_Images extends Controller {
	public function action_get() {
		$id = $this->request->query('id');
		$path = $this->request->query('path');
		$width = $this->request->query('width');
		$height = $this->request->query('height');

		$url = Images::getImageViaUrl($path, $width, $height, false, false, $id, false);

		$this->request->redirect($url);
	}
}
