<?php

/**
 * ModelNotification
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Model_Notification extends ORM {
    public static function notify($member) {
        $notification = Model_Notification::factory('notification');

        if(is_numeric($member)) {
            $notification->mem_id = $member;
        } else if(is_object($member) && $member instanceof Model_Member) {
            $notification->mem_id = $member->id;
        }
        
        $notification->unread = 1;

        return $notification;
    }

    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    public function setType($type) {
        $this->type = $type;

        return $this;
    }
}