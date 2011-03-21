<?php
 
class Model_FriendRequest extends Model {
    /**
     * Check if the user with the id of $from has any active requests for the user with the
     * id of $to.
     *
     * @static
     * @param  $from User ID of the user the friend request is from
     * @param  $to User ID of the user the friend request is to
     * @return mixed
     */
    public static function checkFriendRequest($from, $to) {
        return DB::select(array(DB::expr('COUNT(id)'), 'total'))
                    ->from('friends_requests')
                    ->where('mem1', '=', $from)
                    ->where('mem2', '=', $to)
                    ->execute()
                    ->get('total');
    }

    /**
     * Add a new friend request from $from and to $to.
     *
     * @static
     * @param  $from User ID of the user the friend request is from
     * @param  $to User ID of the user the friend request is to
     * @return Database_Result|object
     */
    public static function createNew($from, $to) {
        return DB::insert('friends_requests')
                    ->columns(array('mem1', 'mem2', 'timedate'))
                    ->values(array($from, $to, DB::expr('NOW()')))
                    ->execute();
    }

    /**
     * Deny the request with the id of $id.
     *
     * @static
     * @param  $id The actual ID of the request.
     * @return void
     */
    public static function denyRequest($id) {
        DB::delete('friends_requests')->where('id', '=', $id)->execute();
    }

    public static function confirmRequest($id) {
        $request = DB::select("*")
                        ->from('friends_requests')
                        ->where('id', '=', $id)
                        ->execute();

        $fromMember = Model_Member::loadFromID($request->get('mem1'));
        $toMember = Model_Member::loadFromID($request->get('mem2'));

        $fromMemberFriendArray = explode(",", $fromMember->friend_array);
        $toMemberFriendArray = explode(",", $toMember->friend_array);

        if(in_array($fromMember->id, $toMemberFriendArray)) {
            echo 'This member is already your Friend.';
            return;
        }

        if(in_array($toMember->id, $fromMemberFriendArray)) {
            echo 'This member is already your Friend.';
            return;
        }

        if($fromMember->friend_array != "") {
            $fromMember->friend_array .= "," . $toMember->id;
        } else {
            $fromMember->friend_array = $toMember->id;
        }

        if($toMember->friend_array != "") {
            $toMember->friend_array .= "," . $fromMember->id;
        } else {
            $toMember->friend_array = $fromMember->id;
        }

        $fromMember->save();
        $toMember->save();

        DB::delete('friends_requests')->where('id', '=', $id)->execute();

        echo "You are now friends with this member!";
        return;
    }

    /**
     * Get a count of all the friend request to $user
     *
     * @static
     * @param  $user The ID of the user who the friend requests are to
     * @return mixed A count of the friend requests
     */
    public static function getCountRequestsTo($user, $as_text) {
        $count = DB::select(array(DB::expr('COUNT(id)'), 'total'))
                    ->from('friends_requests')
                    ->where('mem2', '=', $user)
                    ->execute()
                    ->get('total');

        if($as_text) {
            if($count == 0) {
                return "No Friend Requests";
            } else if($count == 1) {
                return "1 Friend Request";
            } else {
                return "$count Friend Requests";
            }
        } else {
            return $count;
        }
    }

    public static function getRequestHTML($user) {
		
		if($user) {
			$result = DB::query(Database::SELECT,
								"SELECT f.id, f.mem1, f.mem2, m.username, m.has_profile_image
									FROM friends_requests f
									JOIN myMembers m ON m.id = f.mem1
								 WHERE f.mem2 = $user
								 ORDER BY f.timedate DESC
								 LIMIT 50")
							->execute();
		} else {
			return 'No friend requests!';
		}

        $requestList = "";

        if($result->count()) {
            do {
                $pic = "";
                if($result->get('has_profile_image')) {
                    $pic = "<a href=\"/" . $result->get('username') . "\">" . Images::getImage($result->get('mem1'), 'image01.jpg', 50, 0, true, true) . "</a>";
                } else {
                    $pic = "<a href=\"/" . $result->get('username') . "\"><img src=\"/content/images/image01.jpg\" width=\"50\" /></a>";
                }

                $requestList .= '
                    <table width="100%" cellpadding="5" ><tr><td width="17%" align="left"><div style="overflow:hidden; height:50px;"> ' . $pic . '</div></td>
                        <td width="83%"><a href="/' . $result->get('username') . '">' . $result->get('username') . '</a> wants to be your Friend!<br /><br />
                        <span id="req' . $result->get('id') . '">
                        <a href="#" onclick="return false" onmousedown="javascript:acceptFriendRequest(' . $result->get('id') . ');" >Accept</a>
                        &nbsp; &nbsp; OR &nbsp; &nbsp;
                        <a href="#" onclick="return false" onmousedown="javascript:denyFriendRequest(' . $result->get('id') . ');" >Deny</a>
                        </span></td>
                        </tr>
                    </table>';

            } while($result->next());
        } else {
            $requestList = 'No friend requests!';
        }

        return $requestList;
    }
}
