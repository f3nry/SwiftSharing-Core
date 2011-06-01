<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/28/11
 * Time: 12:44 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Model_Blab extends ORM {
    protected $_belongs_to = array(
        'member' => array(
            'model' => 'member',
            'foreign_key' => 'mem_id'
        )
    );

    /**
     * Intercept saves, and send them to MongoDB as well.
     *
     * @param Validation $validation
     */
    public function save(Validation $validation = null) {
        parent::save($validation);

        if(Kohana::$environment == "production") {
            return true;
        }
        
        $db = MangoDB::instance();

        if($this->type == 'COMMENT') {
            $document = $this->as_array();

            unset($document['type']);
            unset($document['feed_id']);
            unset($document['_id']);

            $document = $this->_preProcessDocument($document);

            $comment = $db->find_one('blabs', array('comments.id' => intval($this->id)), array("comments" => 1));

            if($comment) {
                $document = $this->_preProcessDocument($document);

                $db->update('blabs',
                    array('comments.id' => intval($this->id)),
                    array(
                        '$set' => array(
                            'comments.$' => $document
                        )
                    )
                );
            } else {
                $document = $this->_preProcessDocument($document);

                $db->update('blabs',
                    array('id' => intval($this->feed_id)),
                    array(
                        '$addToSet' =>
                            array(
                                'comments' => $document
                            )
                    )
                );
            }
        } else {
            if(!$this->is_loaded()) {
                $db->insert('blabs', $document);
            } else {
                
            }

            $document = $this->as_array();

            $document['user_likes'] = array();
            $document['comments'] = array();

            $document = $this->_preProcessDocument($document);


        }
    }

    protected function _preProcessDocument($document) {
        foreach($document as $key => $value) {
            if(is_numeric($value)) {
                $document[$key] = intval($value);
            }

            if($key == "date") {
                $document[$key] = new MongoDate(strtotime($value));
            }
        }

        return $document;
    }

    /**
     * Get a blab based on the ID
     *
     * @param integer $id The numeric ID of a blab
     * @return Model_Blab|boolean A filled blab model or false
     */
    public static function getById($id) {
        return self::factory('blab')
            ->where('id', '=', $id)
            ->find();
    }

    /**
     * Static helper to get the total number of comments
     * 
     * TODO: Convert to non-static method
     *
     * @param type $id
     * @return type 
     */
    public static function getNumberComments($id) {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM blabs WHERE type = 'COMMENT' AND feed_id = $id")
                    ->execute()
                    ->get('total');
    }

    /**
     * Static helper to get the total number of non-comment posts
     *
     * @return integer The total posts
     */
    public static function getTotalCount() {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM blabs WHERE type != 'COMMENT'")
                ->execute()
                ->get('total');
    }

    /**
     * Delete the current blab from the cache
     */
    public function deleteFromCache() {
        $cache = Cache::instance();

        $cache->delete("blab-from-" . $this->id);
        $cache->delete("blab-non-from-" . $this->id);
        $cache->delete("blab-from-" . $this->mem_id . $this->id);
        $cache->delete("blab-non-from-" . $this->mem_id . $this->id);
    }
	
	/**
	 * Get a list of members who have commented on this blab.
	 */
	public function getCommentees() {
		$result = DB::query(Database::SELECT, "SELECT DISTINCT mem_id FROM blabs WHERE feed_id = {$this->id} AND type = 'COMMENT'")
						->execute();
		
		$ids = array();
		
		foreach($result as $row) {
			$ids[] = $row['mem_id'];
		}
		
		return $ids;
	}
}
