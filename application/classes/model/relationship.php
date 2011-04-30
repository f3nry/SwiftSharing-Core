<?php

/**
 * Model_Relationship
 *
 * Repsents a relationship between two users.
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Model_Relationship extends ORM {
    protected $_table_name = 'friend_relationships';

    /**
     * Creates a new relationships between $to, and $from. Automatically does
     * a two way link between the users. Only call this once for one relationship.
     *
     * @param int $to ID of the relationship it is to.
     * @param int $from ID of the relationships that it is from.
     * @return <type>
     */
    public static function addRelationship($to, $from) {
        if(self::findRelationship($to, $from)->is_loaded()) {
            return false;
        }

        $relationship = Model_Relationship::factory('relationship');

        $relationship->from = $from;
        $relationship->to = $to;

        if(!$relationship->save()) {
            return false;
        }

        $relationship = Model_Relationship::factory('relationship');

        $relationship->to = $from;
        $relationship->from = $to;

        if(!$relationship->save()) {
            DB::query(Database::DELETE, "DELETE FROM friend_relationships WHERE (`from` = $from AND from = $to)")
                    ->execute();

            return false;
        }

        return true;
    }

    /**
     * Remove the relationship.
     *
     * @return boolean True if success, false if failure.
     */
    public function removeRelationship() {
        $to = $this->to;
        $from = $this->from;

        if(!$to || !$from) {
            return false;
        }
        
        return DB::query(Database::DELETE, "DELETE FROM friend_relationships WHERE (`from` = $from AND `to` = $to) OR (`from` = $to AND `to` = $from)")
                    ->execute();
    }

    /**
     * Find an existing relationship.
     *
     * @param integer $to User to
     * @param integer $from User from
     * @return boolean|Model_Relationship
     */
    public static function findRelationship($to, $from) {
        return Model_Relationship::factory('relationship')
                                    ->where('to', '=', $to)
                                    ->and_where('from', '=', $from)
                                    ->find();
    }

    /**
     * Find all relationships for $to
     *
     * @param integer $to To ID
     * @return array
     */
    public static function findByTo($to, $as_member_objects = false, $start = 0, $max = 6) {
        if($as_member_objects) {
            return Model_Member::factory('member')
                    ->join('friend_relationships', 'INNER')
                    ->on('friend_relationships.from', '=', 'myMembers.id')
                    ->where('friend_relationships.to', '=', $to)
                    ->limit($max)
                    ->offset($start)
                    ->find_all();
        } else {
            return Model_Relationship::factory('relationship')
                                ->where('to', '=', $to)
                                ->find_all();
        }
    }

    public static function countByTo($to) {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM friend_relationships WHERE `to` = $to")
                    ->execute()
                    ->get('total');
    }

    /**
     * Find all relationships for $from
     *
     * @param integer $from To ID
     * @return array
     */
    public static function findByFrom($from) {
        return Model_Relationship::factory('relationship')
                    ->where('from', '=', $from)
                    ->find_all();
    }
}