<?php

/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/27/11
 * Time: 2:40 PM
 * To change this template use File | Settings | File Templates.
 */
class Model_Member extends ORM {

    protected $_table_name = "myMembers";
    public $errors;

    public function save(Validation $validation = null) {
        parent::save($validation);

        if(Kohana::$environment == "production") {
            return true;
        }

        $db = MangoDB::instance();

        $document = $this->as_array();

        $regex = <<<'END'
/
  ( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
  | [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
  | [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
  | [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3
  )
| .                             # anything else
/x
END;

        $document['birthday'] = new MongoDate(strtotime($document['birthday']));
        $document['bio_body'] = preg_replace($regex, '$1', $document['bio_body']);

        if($db->find_one('members', array('id' => $document['id']))) {
            $db->update('members', array('id' => $document['id']), $document);
        } else {
            $db->insert('members', $document);
        }
    }

    public function __set($key, $value) {
        parent::__set($key, $value);
    }

    public function register($data) {
        $this->username = $data['username'];
        $this->firstname = $data['first_name'];
        $this->lastname = $data['last_name'];
        $this->gender = $data['gender'];
        $this->birthday = date("Y-m-d", strtotime($data['birthday']));
        $this->email = $data['email'];
        $this->password = md5($data['password']);
        $this->ipaddress = getenv('REMOTE_ADDR');
        $this->sign_up_date = date('Y-m-d H:i:s');

        $this->save();
    }

    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param array $array values to check
     * @param bool $save save the record when validation success
     * @return void
     */
    public function validate(array & $array, $recaptcha) {
        $this->filter($array);

        if (!$recaptcha->check($array)) {
            $this->errors = array('humancheck' => 'You must correctly enter the captcha in order to register.');

            return false;
        }

        $age = self::getAge(date("Y-m-d", strtotime($array['birthday'])));

        if($age < 13) {
            $this->errors = array('age' => 'You must be at least 13 years of age to join SwiftSharing.');

            return false;
        }

        $array = Validation::factory($array)
                        /**
                         * Username validations. Username can't be empty, must not be in the database,
                         * must be greater than 4 characters and less than 20 characters.
                         */
                        ->rule('username', 'not_empty')
                        ->rule('username', array($this, 'username_exists'))
                        ->rule('username', 'min_length', array(':field', 4))
                        ->rule('username', 'max_length', array(':field', 20))

                        /**
                         * First Name, Lastname, and gender validation.
                         */
                        ->rule('first_name', 'not_empty')
                        ->rule('last_name', 'not_empty')
                        ->rule('gender', 'not_empty')

                        /**
                         * Email validation. The email must be a valid email address, the email domain must have an MX record,
                         * email 1 can't match email 2, and the email can't already exist in the database.
                         */
                        ->rule('email', 'email')
                        ->rule('email', 'email_domain')
                        ->rule('email', array($this, 'email_exists'))

                        /**
                         * Password validation. The password must be longer than 6 characters, and less than 16 characters, and must
                         * match the second password.
                         */
                        ->rule('password', 'not_empty')
                        ->rule('password', 'min_length', array(':field', 4))
                        ->rule('password', 'max_length', array(':field', 16))
                        ->rule('password', 'matches', array(':validation', ':field', 'confirm_password'));

        if (!$array->check()) {
            $this->errors = $array->errors('member');

            return false;
        } else {
            return true;
        }
    }

    /**
     * Custom filtering function for POST data specific to this member.
     *
     * @param array $array POST data to check
     * @return void
     */
    public function filter(array & $array) {
        $array['username'] = preg_replace('#[^A-Za-z0-9]#i', '', $array['username']);
        $array['first_name'] = preg_replace('#[^A-Za-z]#i', '', $array['first_name']);
        $array['last_name'] = preg_replace('#[^A-Za-z]#i', '', $array['last_name']);
        $array['gender'] = preg_replace('#[^a-z]#i', '', @$array['gender']);

        foreach ($array as &$element) {
            $element = stripslashes($element);
            $element = strip_tags($element);
        }
    }

    /**
     * Quick check to see if the specified username already is in use.
     *
     * @param  $field The username to check for.
     * @return bool True if it exists, false if it does not.
     */
    public function username_exists($field) {
        return self::checkUsername($field);
    }
    
    public static function checkUsername($field) {
        if ((bool) DB::select(array(DB::expr('COUNT(id)'), 'total'))
                        ->from('myMembers')
                        ->where('username', '=', $field)
                        ->execute()
                        ->get('total')) {
            return false;
        }

        return true;
    }

    /**
     * Quick check to see if the specified email already is in use.
     *
     * @param  $field The email to check for.
     * @return bool True if it exists, false it it does not exist.
     */
    public function email_exists($field) {
        return self::checkEmail($field);
    }
    
    public static function checkEmail($field) {
        if ((bool) DB::select(array(DB::expr('COUNT(id)'), 'total'))
                        ->from('myMembers')
                        ->where('email', '=', $field)
                        ->execute()
                        ->get('total')) {
            return false;
        }

        return true;
    }

    /**
     * Upload new profile image to S3, and pre-cache resized versions.
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @static
     * @param  $id Member ID
     * @param  $localFileName The temporary filename located on this server.
     * @return bool
     */
    public static function updateProfileImage($id, $localFileName) {
        $s3 = new Amazon_S3();

        $success = $s3->uploadFile(Images::$bucket, 'members/' . $id . '/image01.jpg', $localFileName);

        /*$file218 = Images::resizeLocalTmpImage($localFileName, 'image01.jpg', 218, 0);
        $file50 = Images::resizeLocalTmpImage($localFileName, 'image01.jpg', 50, 0);
        $file50x50 = Images::resizeLocalTmpImage($localFileName, 'image01.jpg', 50, 50);
        $file54 = Images::resizeLocalTmpImage($localFileName, 'image01.jpg', 54, 0);
        $file75x75 = Images::resizeLocalTmpImage($localFileName, 'image01.jpg', 75, 75);

        $s3->uploadFile(Images::$bucket, 'members/' . $id . "/" . $file218['new_filename'],   $file218['tmp_path']);
        $s3->uploadFile(Images::$bucket, 'members/' . $id . "/" . $file50['new_filename'],    $file50['tmp_path']);
        $s3->uploadFile(Images::$bucket, 'members/' . $id . "/" . $file54['new_filename'],    $file54['tmp_path']);
        $s3->uploadFile(Images::$bucket, 'members/' . $id . '/' . $file75x75['new_filename'], $file75x75['tmp_path']);
        $s3->uploadFile(Images::$bucket, 'members/' . $id . '/' . $file50x50['new_filename'], $file50x50['tmp_path']);

        unlink($localFileName);
        unlink($file50['tmp_path']);
        unlink($file218['tmp_path']);
        unlink($file54['tmp_path']);
        unlink($file75x75['tmp_path']);
         *
         */
        
        Images::deleteCached($id, 'image01');

        if ($success) {
            $member = Model_Member::factory('member')->where('id', '=', $id)->find();

            $member->has_profile_image = true;
            $member->has_message_image = true;

            $member->save();
        }

        return $success;
    }

    /**
     * Updates the user's background image in S3.
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @param <type> $id
     * @param <type> $localFileName
     * @return <type>
     */
    public static function updateBackground($id, $localFileName) {
        $s3 = new Amazon_S3();

        $success = $s3->uploadFile(Images::$bucket, 'members/' . $id . '/image02.jpg', $localFileName);

        unlink($localFileName);

        if ($success) {
            $member = Model_Member::factory('member')->where('id', '=', $id)->find();

            $member->has_background_image = 1;

            $member->save();
        }

        return $success;
    }

    /**
     * Update the location values for the user $id.
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @static
     * @param  $id
     * @return void
     */
    public static function updateLocation($id, $data) {
        $member = self::factory('member')->where('id', '=', $id)->find();

        foreach($data as &$item) {
            $item = strip_tags($item);
        }

        $member->firstname = preg_replace('#[^A-Z a-z]#i', '', $data['firstname']);
        $member->lastname = preg_replace('#[^A-Z a-z]#i', '', $data['lastname']);
        $member->country = str_replace("'", "&#39;", strip_tags($data['country']));
        $member->country = str_replace("`", "&#39;", $member->country);
        $member->state = preg_replace('#[^A-Z a-z]#i', '', $data['state']);
        $member->city = preg_replace('#[^A-Z a-z]#i', '', $data['city']);
        $member->gender = preg_replace('#[m][f]#i', '', $data['gender']);

        $member->birthday = $data['birth_year'] . '-' . $data['birth_month'] . '-' . $data['birth_day'];

        if (strlen($data['password']) > 0) {
            $member->password = $data['password'];

            if (strlen($member->password) < 6) {
                return '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Your password is to short. It must be longer than or equal to 6 characters.';
            }

            $member->password = md5($member->password);
        }

        return $member->save();
    }

    /**
     * Update the user's interests section.
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @static
     * @param  $id
     * @param  $data
     * @return ORM
     */
    public static function updateInterests($id, $data) {
        $member = self::factory('member')->where('id', '=', $id)->find();

        foreach($data as &$item) {
            $item = strip_tags($item);
        }

        $member->music = $data['music'];
        $member->movies = $data['movies'];
        $member->tv = $data['tv'];
        $member->books = $data['books'];

        return $member->save();
    }

    /**
     * Update privacy for user $id
     * 
     * TODO: Put back in controller, doesn't need to be in model
     */
    public static function updatePrivacy($id, $data) {
        $member = self::factory('member')->where('id', '=', $id)->find();

        $member->privacy_option = $data['privacy_option'];

        return $member->save();
    }

    /**
     * Update the links for the user $id.
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @static
     * @param  $id
     * @param  $data
     * @return void
     */
    public static function updateLinks($id, $data) {
        $member = self::factory('member')->where('id', '=', $id)->find();

        foreach($data as &$item) {
            $item = strip_tags($item);
        }

        $member->website = $data['website'];
        $member->youtube = $data['youtube'];
        $member->facebook = $data['facebook'];
        $member->twitter = $data['twitter'];

        return $member->save();
    }

    /**
     * Update the bio for the user $id
     * 
     * TODO: Put back in controller, doesn't need to be in model
     *
     * @static
     * @param  $id
     * @param  $data
     * @return void
     */
    public static function updateBio($id, $data) {
        $member = self::factory('member')->where('id', '=', $id)->find();

        $member->bio_body = strip_tags($data['bio_body'], '<p><a><h1><h2><h3><h4><h5><h6><font><span>');

        return $member->save();
    }

    /**
     * Returns the properly formated member's name.
     *
     * @return <type>
     */
    public function getName() {
        if ($this->firstname) {
            return $this->firstname;
        } else {
            return $this->username;
        }
    }

    /**
     * Returns the properly formated member's full name.
     *
     * @return <type>
     */
    public function getFullName() {
        if($this->firstname && $this->lastname) {
            return $this->firstname . ' ' . $this->lastname;
        } else {
            return $this->username;
        }
    }

    /**
     * Load member from id
     *
     * @static
     * @param  $id The User id
     * @return Model_Member Object representing the user
     */
    public static function loadFromID($id) {
        return Model_Member::factory('member')->where('id', '=', $id)->find();
    }

    public static function loadFromEmail($email) {
        return Model_Member::factory('member')->where('email', '=', $email)->find();
    }

    public static function loadFromEmailAndUsername($username, $email) {
        return Model_Member::factory('member')
                    ->where('username', '=', $username)
                    ->where('email', '=', $email)
                    ->find();
    }

    /**
     * Builds a 6 member long friends list for the current member.
     * 
     * TODO: Put back in controller, doesn't need to be in model, and implement with a View
     *
     * @return string The generated list in HTML
     */
    public function generateShortFriendsList() {
        $friendCount = Model_Relationship::countByTo($this->id);

        $start = ($friendCount < 6) ? 0 : rand(0, $friendCount - 6);

        $friendObjects = Model_Relationship::findByTo($this->id, true, $start);

        $friendList .= '<div class="infoHeader" style="border-bottom: 1px solid #eeeeee;font-size:17px;color:#8B8989;width:218px;">' . $this->getName() . '\'s Friends (<a href="/ajax/profile/friends/' . $this->id . '" class="short_friends_list">' . ($friendCount) . '</a>)</div>';
        $i = 0; // create a varible that will tell us how many items we looped over
        $friendList .= '<div class="infoBody"><table id="friendTable" align="center" cellspacing="4"></tr>';
        foreach($friendObjects as $friendObject)  {
            $value = $friendObject->id;
            $i++; // increment $i by one each loop pass

            if ($friendObject->has_profile_image) {
                $frnd_pic = Images::getImage($value, 'image01.jpg', 50, 0, false, true);
            } else {
                $frnd_pic = '<img src="/content/images/image01.jpg" width="50px" border="1"/>';
            }

            if ($i % 6 == 4) {
                $friendList .= '<tr><td><div style="width:56px; height:68px; overflow:hidden;" title="' . $friendObject->firstname . '">
				<a href="/' . $friendObject->username . '">' . $friendObject->firstname . '<br />' . $frnd_pic . '</a>
				</div></td>';
            } else {
                $friendList .= '<td><div style="width:56px; height:68px; overflow:hidden;" title="' . $friendObject->firstname . '">
				<a href="/' . $friendObject->username . '">' . $friendObject->firstname . '<br />' . $frnd_pic . '</a>
				</div></td>';
            }
        }
        $friendList .= '</tr></table>
	 <div align="right" ><a href="/ajax/profile/friends/' . $this->id . '" class="short_friends_list">view all</a></div>
	 </div>';

        return $friendList;
    }

    /**
     * Generate a friends list.
     * 
     * TODO: Put back in controller, doesn't need to be in model, and use a view
     *
     * @param <type> $max
     * @param <type> $start
     */
    public function generateLongFriendsList($max = false, $start = 0) {
        $friendCount = Model_Relationship::countByTo($this->id);

        if(!$max) {
            $max = $friendCount;
        }

        $friendObjects = Model_Relationship::findByTo($this->id, true, $start, $max);

        $friendList = '<table id="friendPopBoxTable" width="200" align="center" cellpadding="6" cellspacing="0">';
        $i = 0;

        foreach ($friendObjects as $friend) {
            $i++;
            $frnd_pic = Model_Member::getProfileImageStatic($friend, 50, 0);

            $funame = ($friend->firstname) ? $friend->firstname : $friend->username;
            $ffname = $friend->firstname;
            $fcountry = $friend->country;
            $fstate = $friend->state;
            $fcity = $friend->city;
            
            if ($i % 2) {
                $friendList .= '<tr bgcolor="#F4F4F4"><td width="14%" valign="top">
                                            <div style="width:56px; height:56px; overflow:hidden;" title="' . $funame . '">' . $frnd_pic . '</div></td>
                                         <td width="86%" valign="top"><a href="/' . $friend->username . '">' . $funame . '</a><br /><font size="-2"><em>' . $fcity . '<br />' . $fstate . '<br />' . $fcountry . '</em></font></td>
                                        </tr>';
            } else {
                $friendList .= '<tr bgcolor="#E0E0E0"><td width="14%" valign="top">
                                            <div style="width:56px; height:56px; overflow:hidden;" title="' . $funame . '">' . $frnd_pic . '</div></td>
                                         <td width="86%" valign="top"><a href="/' . $friend->username . '">' . $funame . '</a><br /><font size="-2"><em>' . $fcity . '<br />' . $fstate . '<br />' . $fcountry . '</em></font></td>
                                        </tr>';
            }
        }

        return $friendList . '</table>';
    }

    /**
     * By-pass ORM to load one or more members.
     *
     * @param integer|array $id A single, or multiple ids.
     * @return Database_Result The resulting member(s) as a database result, as an object.
     */
    public static function quickLoad($id, $start = 1, $max = -1) {
        if(empty($id)) {
            return array();
        }

        if(is_array($id) || $id instanceof Database_MySQL_Result) {
            if($id[0] instanceof Model_Relationship) {
                $ids = "";

                for($i = $start - 1; $i < count($id) && (($i < ($start + $max)) || $max == -1); $i++) {
                    $ids .= $id[$i]->from . ",";
                }

                $ids = trim($ids, ', ');
            } else {
                $ids = trim(implode(',', $id), ', ');
            }

            if(!$ids) {
                $ids = -1;
            }

            return DB::query(Database::SELECT,
                    "SELECT * FROM myMembers
                        WHERE id IN ($ids)")
                    ->as_object()
                    ->execute();
        } else {
            return DB::select('*')
                        ->from('myMembers')
                        ->where('id', '=', $id)
                        ->as_object()
                        ->execute()
                        ->current();
        }
    }

    /**
     * Gets a quick message acount of the current member.
     *
     * @return integer The numeric count of the unread messages.
     */
    public function getUnreadMessageCount() {
        return DB::select(array(DB::expr('COUNT(message_id)'), 'total'))
                    ->from('private_conversation_messages')
                    ->where('read_to', '=', 0)
                    ->and_where('message_to', '=', Session::instance()->get('user_id'))
                    ->join('private_conversations')
                    ->on('private_conversations.id', '=', 'private_conversation_messages.conversation_id')
                    ->execute()
                    ->get('total');
    }

    /**
     * Get's the feed content for the member's friends.
     * 
     * TODO: Convert to use Util_Feed_Generator
     *
     * @return string The generated blabs in HTML
     */
    public function generateFriendBlabs() {
        $query = "SELECT DISTINCT(b.id), b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id
                    WHERE (b.type != 'COMMENT') AND (EXISTS (SELECT 1 FROM friend_relationships fr WHERE fr.to = {$this->id} AND fr.from = b.mem_id) OR b.mem_id = {$this->id})
                    ORDER BY date DESC LIMIT 15";

        return Model_Feed::getFeedContent(
                DB::query(Database::SELECT, $query)->execute()
            );
    }

    /**
     * Returns the total count of active members.
     *
     * @return int The total active members.
     */
    public static function getTotalCount() {
        return DB::query(Database::SELECT, 'SELECT COUNT(*) as total
                                            FROM `myMembers`
                                            WHERE `email_activated` = \'1\'')
                    ->execute()
                    ->get('total');
    }

    /**
     * Returns an array of members that match the string in $data.
     *
     * @param string $data The data to search by.
     * @param Util_Pager $pager Instance of a Util_Pager to use.
     * @return array Array of Model_Members
     */
    public static function doSearch($data, $pager) {
        if($data == "") {
            return Model_Member::factory('member')
                        ->where('email_activated', '=', true)
                        ->offset($pager->start)
                        ->limit($pager->itemsPerPage)
                        ->find_all();
        } else {
            if(count($names = explode(' ', $data)) > 1) {
                return Model_Member::factory('member')
                            ->where('email_activated', '=', 1)
                            ->and_where('username', 'LIKE', '%' . $data . '%')
                            ->or_where('firstname', 'LIKE', '%' . $names[0] . '%')
                            ->or_where('lastname', 'LIKE', '%' . implode(' ', array_slice($names, 1)) . '%')
                            ->offset($pager->start)
                            ->limit($pager->itemsPerPage)
                            ->find_all();
            }

            return Model_Member::factory('member')
                        ->where('email_activated', '=', 1)
                        ->and_where('username', 'LIKE', '%' . $data . '%')
                        ->or_where('firstname', 'LIKE', '%' . $data . '%')
                        ->or_where('lastname', 'LIKE', '%' . $data . '%')
                        ->offset($pager->start)
                        ->limit($pager->itemsPerPage)
                        ->find_all();
        }
    }

    /**
     * Returns the profile image of the user as HTML, given the width and height.
     * 
     * TODO: Implement a uploaded image versions table
     *
     * @param int $width The width of the image
     * @param int $height The height of the image
     * @return string the HTML of the image
     */
    public function getProfileImage($width = 50, $height = 0) {
        if(!$this->has_profile_image) {
            return "<img src=\"/content/images/image01.jpg\" width=\"$width\"/>";
        } else {
            return Images::getImage($this->id, 'image01.jpg', $width, $height, true, true);
        }
    }

    /**
     * Static version of getProfileImage.
     *
     * @param stdClass $member stdClass of a $member row.
     * @param int $width The width of the image
     * @param int $height The height of the image
     * @return <type>
     */
    public static function getProfileImageStatic($member, $width, $height) {
        if(!$member->has_profile_image) {
            return "<img src=\"/content/images/image01.jpg\" width=\"$width\"/>";
        } else {
            return Images::getImage($member->id, 'image01.jpg', $width, $height, true, true);
        }
    }

    /**
     * Static function to return the numeric age since $birthday.
     *
     * @param string $birthday YYYY-mm-DD formated date.
     * @return int The age.
     */
    public static function getAge($birthday) {
        list($year, $month, $day) = explode("-", $birthday);

        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;

        if($day_diff < 0 || $month_diff < 0) {
            $year_diff--;
        }

        return $year_diff;
    }

    /**
     * Return the privacy option of the user with the id of $id.
     *
     * @param integer $id User ID
     * @return string The text of the privacy option.
     */
    public static function getPrivacy($id) {
        return DB::select('privacy_option')
                    ->from('myMembers')
                    ->where('id', '=', $id)
                    ->execute()
                    ->get('privacy_option');
    }

    /**
     * Get a human-readable version of the gender.
     *
     * @param string $option Option to define tense
     * @return type string 
     */
    public function getNiceGender($option) {
        switch($option) {
            case 'his':
                if($this->gender == 'm') {
                    return 'his';
                } else {
                    return 'her';
                }
                break;
            case 'him':
                if($this->gender == 'm') {
                    return 'him';
                } else {
                    return 'her';
                }
                break;
        }
    }

    /**
     * Login the user into SwiftSharing
     * 
     * TODO: Right admin login functions
     */
    public function login($admin = false) {
        Session::instance()->set('user_id', $this->id);
        Session::instance()->set('username', $this->username);

		if($admin) {
			Session::instance()->set('is_admin', true);
		}
    }

    /**
     * Returns the latest post the user has made as an array
     * 
     * TODO: Return Model_Blab instead of array
     *
     * @return type 
     */
    public function getLatestPost() {
        return DB::query(Database::SELECT,
                         "SELECT blabs.id, text, type, f.title as feed_title, f.id as feed_id
                            FROM blabs
                            LEFT JOIN feeds f ON blabs.feed_id = f.id
                            WHERE blabs.mem_id = {$this->id} AND type != 'COMMENT' AND type != 'PROFILE' ORDER BY date DESC LIMIT 1")
                ->execute()
                ->as_array();
    }
    
    /**
     * Check if an id exists in the database
     *
     * @param integer $id The user id in the database
     * @return boolean
     */
    public function exists($id) {
        return DB::query(Database::SELECT, "SELECT COUNT(*) as total FROM myMembers WHERE id = :id")
                ->bind("id", $id)
                ->execute()
                ->get('total');
    }
    
    public function setBirthday($array) {
        $this->birthday = $array['birth_year'] . "-" . $array["birth_month"] . "-" . $array["birth_day"];
    }

	public function checkAdmin() {
		$email = $this->email;
		
		return DB::query(Database::SELECT, "SELECT COUNT(1) as total FROM admin WHERE email = :email LIMIT 1")
					->bind(":email", $email)
					->execute()
					->get('total');
	}
	
	public static function checkLogin($post, $admin = false) {
		 $member = Model_Member::factory('member')
                         ->where_open()
                            ->where('email', '=', $post['email'])
                            ->or_where('username', '=', $post['email'])
                         ->where_close()
                        ->and_where('password', '=', md5($post['pass']))
                        ->find();
			
   		if($member->is_loaded() && $member->email_activated == '1') {
			if($admin) {
				if(!$member->checkAdmin()) {
					return "Wrong email/password. Please try again.";
				}
			}
	
			return $member;
		} else if($member->is_loaded() && $member->email_activated == 0) {
			return "Your account is not activated yet. Please check your email.";
		} else {
			return "Wrong email/password. Please try again.";
		}
	}
}
