<?php

/**
 * ModelNotification
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Model_Notification extends ORM {
	
	/**
	 * Initiate a notification from the current member to $member. 
	 */
    public static function notify($member) {
        $notification = Model_Notification::factory('notification');

        if(is_numeric($member)) {
            $notification->to = $member;
        } else if(is_object($member) && $member instanceof Model_Member) {
            $notification->to = $member->id;
        } else if(is_object($member) && $member instanceof Model_Blab) {
			$notification->to = $member->getCommentees();
		}

		$notification->from = Session::instance()->get('user_id');
        
        $notification->unread = 1;

		$notification->created = date('Y-m-d h:i:s');

        return $notification;
    }
	
	/**
	 * Set the text for the current notification
	 */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }
	
	/**
	 * Set the ref id for the current notification
	 */
	public function setRef($id) {
		$this->ref = $id;
		
		return $this;
	}

	/**
	 * Set the type of notification for the current notification.
	 */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

	public function save(Validation $validation = null) {
		if(is_array($this->to)) {
			foreach($this->to as $id) {
				if($id != $this->from) {
					Model_Notification::notify($id)
                        	->setText($this->text)
							->setType($this->type)
                        	->setRef($this->ref)
                        	->save();
				}
			}
		} else {
			parent::save($validation);
		}
	}

	public function jsonify() {
		return array(
			"id"   => $this->id,
			"type" => $this->type,
			"text" => $this->text,
			"ref"  => $this->ref,
			"to"   => $this->to,
			"from" => $this->from
		);
	}
	
	public static function updateUnread($notifications) {
		$query = DB::update('notifications')->set(array('unread' => 0));
		
		$ids = array();
		
		foreach($notifications as $notification) {
			$ids[] = $notification["id"];
		}
		
		$query->where('id', 'in', $ids);
		
		if(count($ids) > 0) {
			return $query->execute();
		} else {
			return true;
		}
	}
	
	/**
	 * Get the notifications for the specified user
	 * 
	 * @param $user The user to look at
	 * @param $mark_unread Mark the notifications unread after reading them?
	 */
	public static function getPollNotifications($user, $mark_unread = true) {
		$notifications = Model_Notification::factory('notification')
			->where('to', '=', $user)
			->and_where('unread', '=', '1')
			->find_all();
			
		$notifications_array = array();
		
		foreach($notifications as $notification) {
			$notifications_array[] = $notification->jsonify();
		}
		
		self::updateUnread($notifications_array);
		
		return array("notifications" => $notifications_array);
	}
}