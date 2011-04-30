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

    public static function generateLikeBox($id, $likes, $showDelete) {
        if($likes >= 0) {
            $likes = "+$likes";
        }

        if($showDelete) {
            $delete = '<a href="javascript:void()" onclick="deleteBlab(' . $id . ')" style="float:right;padding-left:5px;"><img src="/content/images/delete.jpg" /></a>';
        } else {
            $delete = '';
        }

        return <<<RETURN
        <div id="thumbsup_$id" class="thumbsup_template_mini-thumbs">
            <form method="post">
                <input type="hidden" name="thumbsup_id" value="$id" />

                <span class="thumbsup_hide">Score:</span>
                $delete
                <input class="vote_up" name="thumbsup_rating" value="+1" type="submit" title="Vote up" />
                <input class="vote_down" name="thumbsup_rating" value="-1" type="submit" title="Vote down" />
                <strong class="votes_balance">$likes</strong>
            </form>
        </div>
RETURN;
    }

    public static function get_new() {
        return Model_Like::factory('like');
    }

    public static function checkExists($mem_id, $blab_id) {
        return (boolean)
               DB::query(Database::SELECT,
                    "SELECT * FROM likes WHERE mem_id = $mem_id AND blab_id = $blab_id")
                    ->execute()
                    ->count();
    }

    public static function getTotalCount() {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM likes")
                ->execute()
                ->get('total');
    }
}
