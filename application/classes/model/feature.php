<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Feature extends Model {
	public static function checkFeature($feature, $user_id) {
		$db = MangoDB::instance();
		
		$doc = $db->find_one('feature_' . $feature, array(
			'user_id' => (integer)$user_id
		));
		
		if($doc) {
			return true;
		} else {
			return false;
		}
	}
}