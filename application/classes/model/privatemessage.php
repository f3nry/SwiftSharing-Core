<?php

/**
 * TODO: Add support for pagination and ajaxination
 */
class Model_PrivateMessage extends ORM {

    protected $_table_name = "private_conversations";

    public $responses = array();

    /**
     * Begins a conversation, and sends the first message.
     *
     * @param array $data Array of filtered message data
     * @return bool
     */
    public static function begin($data) {
        Database::instance()->begin();

        $conversation = DB::query(Database::INSERT,
                "INSERT INTO private_conversations VALUES
                    (0, :from, :to, NOW(), NOW(), :subject)");

        $from = Session::instance()->get('user_id');

        $conversation->bind(':from', $from)
                     ->bind(':to', $data['to'])
                     ->bind(':subject', $data['subject']);

        list($conversation_id, $rows) = $conversation->execute();

        if(!$conversation_id) {
            return false;
        }

        if(!self::sendMessage(
                $conversation_id,
                $data['message'],
                $from,
                $data['to'])) {
            Database::instance()->rollback();

            return false;
        } else {
            Database::instance()->commit();

            return true;
        }
        
    }

    /**
     * Send a new private message.
     *
     * @param integer|object $conversation Instance of PrivateMessage, or id of message conversation.
     * @param string $message Text of message
     * @param integer $from_id ID of the sender
     * @return bool
     */
    public static function sendMessage($conversation, $message, $from_id, $to_id) {
        $first_message = DB::query(Database::INSERT,
                "INSERT INTO private_conversation_messages (message_id, conversation_id, message, date_sent, message_from, message_to, read_to)
                    VALUES (0, :conversation_id, :message, NOW(), :from_id, :to_id, 0)");

        if(is_numeric($conversation)) {
            $conversation_id = $conversation;
        } else if(is_object($conversation)) {
            $conversation_id = $conversation->conversation_id;
        } else {
            return false;
        }
        
        $first_message->bind(':conversation_id', $conversation_id)
                      ->bind(':message', $message)
                      ->bind(':from_id', $from_id)
                      ->bind(':to_id', $to_id);

        list($message_id, $rows) = $first_message->execute();

        if(!$message_id) {
            return false;
        } else {
			$member = Model_Member::loadFromID($from_id);
		
			Model_Notification::notify($to_id)
				->setText($member->getName() . " sent you a message!")
				->setType("MESSAGE")
				->setRef($conversation_id)
				->save();
	
            DB::query(Database::UPDATE, "UPDATE private_conversations SET date_updated = NOW() WHERE id = $conversation_id")->execute();

            return true;
        }
    }

    /**
     * Generates a recent message list for the current user.
     * 
     * TODO: Convert to helper and View
     *
     * @return string The generated message list.
     */
    public static function generateRecentMessageList() {
        $member_to = Session::instance()->get('user_id');

        $query = "SELECT pc.id, pc.date_updated, pc.subject,
                       pcm.message,
                       m.id as member_from_id, m.username as member_from_username, m.firstname as member_from_firstname, m.lastname as member_from_lastname, m.has_profile_image as has_profile_image
                  FROM private_conversations pc
                  JOIN (
                       SELECT * FROM private_conversation_messages ORDER BY date_sent DESC
                  ) as pcm ON pcm.conversation_id = pc.id
                  JOIN myMembers m ON m.id = pcm.message_from
                  WHERE pc.to = $member_to OR pc.from = $member_to
                  GROUP BY pc.id
                  ORDER BY pc.date_updated DESC
                  LIMIT 8";

        $result = DB::query(Database::SELECT, $query)->as_object()->execute();

        $list = "";

        foreach($result as $row) {
            if(strlen($row->message) > 25) {
                $row->message = substr($row->message, 0, 25) . "...";
            }

            if($row->has_profile_image) {
                $photo = Images::getImage($row->member_from_id, 'image01.jpg', 50, 50, true, true);
            } else {
                $photo = "<img src=\"/content/images/image01.jpg\" width=\"50\" height\"50\" />";
            }

            $list .= '<div class="section">
                <div class="photo">' . $photo . '</div>
                <div class="half">
                    <div class="sub">' . $row->subject . '</div>
                    <div class="msg">' . stripslashes($row->message) . '</div>
                    <div class="person"><a href="/' . $row->member_from_username . '">' . $row->member_from_firstname . ' ' . $row->member_from_lastname . '</a></div>
                    <div class="read"><a href="/inbox/view/' . $row->id . '">Read</a></div>
                </div>
            </div>';
        }

        return $list;
    }

	public static function getRecentMessagesQuickly() {
		$member_to = Session::instance()->get('user_id');

		$query = "SELECT pc.id, pc.date_updated, pc.subject,
                       pcm.message,
                       m.id as member_from_id, m.username as member_from_username, m.firstname as member_from_firstname, m.lastname as member_from_lastname, m.has_profile_image as has_profile_image
                  FROM private_conversations pc
                  JOIN (
                       SELECT * FROM private_conversation_messages ORDER BY date_sent DESC
                  ) as pcm ON pcm.conversation_id = pc.id
                  JOIN myMembers m ON m.id = pcm.message_from
                  WHERE pc.to = $member_to OR pc.from = $member_to
                  GROUP BY pc.id
                  ORDER BY pc.date_updated DESC
                  LIMIT 8";

		return DB::query(Database::SELECT, $query)->as_object()->execute();
	}

    /**
     * Load responses for the current private message
     */
    public function loadResponses() {
        $this->responses = DB::select('*')
                    ->from('private_conversation_messages')
                    ->where('conversation_id', '=', $this->id)
                    ->order_by('date_sent', 'DESC')
                    ->as_object()
                    ->execute();

        foreach($this->responses as $response) {
            if($response->message_to == Session::instance()->get('user_id') && $response->read_to == false) {
                DB::update('private_conversation_messages')
                    ->value('read_to', true)
                    ->where('message_id', '=', $response->message_id)
                    ->execute();
            }
        }
    }

    /**
     * Return the opposite member in this conversation from what is passed in
     *
     * @param integer $id The member id to look for
     * @return integer If $id == $this->from->id, return $this->to->id, etc
     */
    public function getMember($id) {
        if($this->from->id == $id) {
            return $this->from;
        } else if($this->to->id == $id) {
            return $this->to;
        } else {
            return false;
        }
    }

    /**
     * Load a specific message, and it's responses.
     *
     * @param integer $id The numeric id for the conversation
     * @return Model_PrivateMessage The loaded message, with all responses
     */
    public static function loadMessage($id, $responses = true) {
        $message = Model_PrivateMessage::factory('privatemessage')
                        ->where('id', '=', $id)
                        ->and_where_open()
                            ->or_where('from', '=', Session::instance()->get('user_id'))
                            ->or_where('to', '=', Session::instance()->get('user_id'))
                        ->and_where_close()
                        ->find();

        if($message) {
            $message->from = Model_Member::loadFromID($message->from);
            $message->to = Model_Member::loadFromID($message->to);

            if($responses) {
                $message->loadResponses();
            }

            return $message;
        } else {
            return false;
        }
    }
}

