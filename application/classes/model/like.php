<?php
 
class Model_Like extends ORM {
    public $_type = 'NORMAL';
    public $_parent_id = null;

    public function save(Validation $validation = null) {
        parent::save($validation);

        if(Kohana::$environment == "production") {
            return true;
        }

        $db = MangoDB::instance();

        $document = $this->as_array();

        foreach($document as $key => $field) {
            if(is_numeric($field)) {
                $document[$key] = intval($field);
            }
        }

        unset($document['blab_id']);
        unset($document['id']);

        if($this->_type == 'COMMENT') {
            $db->update('blabs',
                array('comments.id' => intval($this->blab_id)),
                    array('$addToSet' => array(
                        'comments.$.user_likes' => $document
                    )
                )
            );
        } else {
            $db->update('blabs',
                array('id' => intval($this->blab_id)),
                array('$addToSet' => array(
                        'user_likes' => $document
                    )
                )
            );
        }
    }

    /**
     * Generates a HTML likeBox for a blab
     * 
     * TODO: Convert to helper and View
     * 
     * @param integer $id ID of the blab
     * @param integer $likes Total likes
     * @param integer $showDelete Show a delete option
     * @return string The generated HTML
     */
    public static function generateLikeBox($id, $likes, $showDelete, $type = 'STATUS') {
        if($likes >= 0) {
            $likes = "+$likes";
        }

	      return View::factory('feed/like')
					      ->set('id', $id)
					      ->set('delete', $showDelete)
					      ->set('likes', $likes)
	              ->set('type', $type)
					      ->render();
    }

    /**
     * Create a new like
     *
     * @return Model_Like A blank like
     */
    public static function get_new() {
        return Model_Like::factory('like');
    }

    /**
     * Static helper to check if a specific user has already liked a post
     *
     * @param integer $mem_id The member id to look for
     * @param integer $blab_id The blab id to look for
     * @return boolean true or false depending on whether or not they've liked it 
     */
    public static function checkExists($mem_id, $blab_id) {
        return (boolean)
               DB::query(Database::SELECT,
                    "SELECT * FROM likes WHERE mem_id = $mem_id AND blab_id = $blab_id")
                    ->execute()
                    ->count();
    }

    /**
     * Static helper to get a quick count of all likes
     *
     * @return integer The total count
     */
    public static function getTotalCount() {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM likes")
                ->execute()
                ->get('total');
    }
}
