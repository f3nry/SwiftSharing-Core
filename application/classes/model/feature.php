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
	
	public static function addUser($feature, $user_id) {
		$db = MangoDB::instance();
		
		if(!self::checkFeature($feature, $user_id)) {
			$db->insert('feature_' . $feature, array(
				'user_id' => (integer)$user_id
			));
			
			return true;
		} else {
			return false;
		}
	}
	
	public static function removeUser($feature, $user_id) {
		$db = MangoDB::instance();
		
		if(self::checkFeature($feature, $user_id)) {
			$db->remove('feature_' . $feature, array(
				'user_id' => (integer)$user_id
			));
			
			return true;
		} else {
			return false;
		}
	}
	
	public static function getUsers($feature) {
		$db = MangoDB::instance();
		
		$doc = $db->find('feature_' . $feature);
		
		$users = array();
		
		foreach($doc as $user) {
			$id = intval($user['user_id']);
			
			$users[$id] = $id;
		}
		
		$users = DB::select('id', 'username', 'firstname', 'lastname')
					->from('myMembers')
					->where('id', 'in', $users)
					->execute()
					->as_array();
		
		return $users;
	}
}