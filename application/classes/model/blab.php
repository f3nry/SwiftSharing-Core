<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/28/11
 * Time: 12:44 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Model_Blab extends ORM {
    public static function getById($id) {
        return self::factory('blab')->where('id', '=', $id)->find();
    }

    public static function getNumberComments($id) {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM blabs WHERE type = 'COMMENT' AND feed_id = $id")
                    ->execute()
                    ->get('total');
    }
}
