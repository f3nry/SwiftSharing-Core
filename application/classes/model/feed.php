<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 3/2/11
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

class Model_Feed extends ORM
{
    /**
     * Get an instance of the feed with the id of $id.
     *
     * @param integer $id Feed ID
     * @return Model_Feed
     */
    public static function getFeed($id) {
        return Model_Feed::factory('feed')->where('id', '=', $id)->find();
    }

    /**
     * Generates a list of all feeds.
     *
     * @return string The generated list
     */
    public static function generateFeedList()
    {
        $result = DB::select('id', 'title')->from('feeds')->where('mem_id', '=', '-1')->order_by('index', 'ASC')->execute();

        $output = "<ul id=\"navigationMenu\">";
        
        do {
            $class = strtolower($result->get('title'));
            $output .= "<li><a class=\"$class\" href=\"/feed/" . $result->get('id') . "\"><span>" . $result->get('title') . "</span></a></li>";
        } while($result->next());

        $output .= "</ul>";

        return $output;
    }

    /**
     * Returns the results for querying with the specified parameters
     *
     * @param integer $feed_id The feed to look for
     * @param string $type The where clause for a type
     * @param integer $member Specific member to look for
     * @param string $lastdate The date compare against
     * @param boolean $reverse Reverse the date query? true will return older blabs, false will return newer blabs.
     * @return <type>
     */
    public static function getFeedBlabs($feed_id, $type = "'STATUS'", $member = false, $lastdate = false, $reverse = false)
    {
        $where = "";

        if($member && is_numeric($member)) {
            $where = " AND (b.mem_id = $member OR b.type = 'PROFILE')";

            $type .= " OR (b.type = 'PROFILE' AND (b.feed_id = $member OR b.mem_id = $member))";
        }

        if($feed_id == '*') {
            $feed_id = "true";
        } else {
            $feed_id = "feed_id = $feed_id";
        }

        $query = "SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes,
                         f.title as feed_title,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                    FROM blabs b
                    LEFT JOIN myMembers m ON b.mem_id = m.id
                    LEFT JOIN feeds f ON f.id = b.feed_id";

        $privacy_option = Model_Member::getPrivacy(Session::instance()->get('user_id'));

        if($privacy_option == 'locked') {
            $query .= " LEFT JOIN friend_relationships fr ON fr.to = b.mem_id";

            $where .= " AND (b.mem_id = " . Session::instance()->get('user_id') . " OR fr.from = b.mem_id)";
        } else {
            $query .= " LEFT JOIN friend_relationships fr ON fr.to = b.mem_id";

            $where .= " AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited') OR ";
            $where .= " (b.mem_id = " . Session::instance()->get('user_id') . " OR fr.from = b.mem_id)) ";
        }

        $query .= " WHERE $feed_id AND (b.type = $type) ";

        if($lastdate) {
            if($reverse) {
                $query .= " AND b.date < '$lastdate'";
            } else {
                $query .= " AND b.date > '$lastdate'";
            }
        }

        $query .= "$where ORDER BY date DESC LIMIT 15";

        return DB::query(Database::SELECT, $query)->execute()->as_array();
    }

    public static function getFeedContent($feed_id, $type  = "'STATUS' OR b.type = 'PHOTO'", $member = false, $lastdate = false, $reverse = false) {
        if(is_object($feed_id) && $feed_id instanceof Database_Result) {
            $blabs = $feed_id;
        } else {
            $blabs = self::getFeedBlabs($feed_id, $type, $member, $lastdate, $reverse);
        }
        $content = "";

        foreach($blabs as $blab) {
            $content .= self::getBlab($blab, true, true, $member);
        }

        if(empty($content) && $lastdate == false) {
            if(strpos($type, "'STATUS'") !== false) {
                $content = "<p>No blabs! Be the first to post! :)</p>";
            } else {
                $content = "<p>No comments! Be the first to comment! :)</p>";
            }
        }

        return $content;
    }

    public static function getBlab($row, $show_id, $show_comment_link = true, $member = false)
    {
        if(is_numeric($row)) {
            $query = "SELECT b.id, b.type, feed_id, mem_id, text, `date`, b.likes as likes,
                         m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                        FROM blabs b
                        LEFT JOIN myMembers m ON mem_id = m.id
                        WHERE b.id = $row";

            $row = DB::query(Database::SELECT, $query)->execute()->as_array();

            $row = $row[0];
        }

        $blabid = $row["id"];
        $uid = $row["mem_id"];
        $the_blab = $row["text"];

        $blab_date = (string)$row["date"];
        $convertedTime = strtotime($blab_date);
        $whenBlab = Date::fuzzy_span($convertedTime);

        $username = $row["username"];
        $firstname = $row["firstname"];
        if ($firstname != "") {
            $username = $firstname;
        } // (I added usernames late in  my system, this line is not needed for you)

        $blabber_pic = '<div style="overflow:hidden; width:50px; height:50px;">' . Images::getImage($uid, 'image01.jpg', 50, 50, true, true) . '</div>';

        if ($show_id) {
            $blabid = "blab_" . $blabid;
            $comments = '<div style="font-size:90%; margin-top:0px;margin-bottom:6px"><a href="javascript:void()" onclick="openComments(' . $row["id"] . ')"><img src="/img/comments.png" alt="Comments" />&nbsp;<span style="height:16px;padding-bottom:6px;">Comment</span></a></div>';
        } else {
            $blabid = "";
            $comments = '';
        }

        $blab = '
            <div id="' . $blabid . '" class="postbody">
                <div class="img">';


        if($row['has_profile_image']) {
            $blab .= Images::getImage($uid, 'image01.jpg', 50, 0, true, true);
        } else {
            $blab .= "<img src=\"/content/images/image01.jpg\" height=\"50\" />";
        }

        $blab .= '
                </div>
                <div class="text">
                    ' . $the_blab;

        if($row['type'] == "PHOTO") {
            $image = Images::getImage($row['mem_id'], $row['id'] . '.jpg');
            $blab .= "<br/><a class=\"post_photo\" href=\"$image\" title=\"$the_blab\">" . Images::getImage($row['mem_id'], $row['id'] . '.jpg', 120, 0, true, true) . "</a>";
        }

        if($member) {
            if($row['type'] == 'PROFILE' && $row['feed_id'] == $member) {
                $blab .= '
                        <div class="time">' . $whenBlab . ', <a href="/' . $row['username'] . '">' . $username . '</a> wrote.</div>';
            } else if($row['type'] == 'PROFILE' && $row['mem_id'] == $member) {
                $otherMember = Model_Member::quickLoad($row['feed_id']);

                $blab .= '
                        <div class="time">' . $whenBlab . ', <a href="/' . $row['username'] . '">' . $username . '</a> wrote on <a href="' . $otherMember->username . '">' . $otherMember->firstname . '</a>\'s profile</div>';
            } else {
                $blab .= '
                        <div class="time">' . $whenBlab . ', by <a href="/' . $row["username"] . '">' . $username . '</a> in <a href="feed/' . $row['feed_id'] . '">' . $row['feed_title'] . '</a></div>';
            }
        } else {
            $blab .= '
                        <div class="time">' . $whenBlab . ', by <a href="/' . $row["username"] . '">' . $username . '</a></div>';
        }

        if($row['type'] != 'COMMENT') {
            $n_comments = Model_Blab::getNumberComments($row['id']);

            if($n_comments == 0) {
                $comments = "0 Comments";
            } else if($n_comments == 1) {
                $comments = "1 Comment";
            } else {
                $comments = "$n_comments Comments";
            }

            $blab .= '<div class="comment">
                        <a href="javascript:void()" onclick="openBlabComments(' . $row['id'] . ')">' . $comments . '</a>
                        <a href="#comment-dialog" style="display:none;" class="comments"></a>
                    </div>';
        }

        $blab .= '</div>
                <div class="likes">
                ' . Model_Like::generateLikeBox($row['id'], $row['likes'],
                    (Session::instance()->get('user_id') == $row['mem_id'] || ($row['type'] == 'PROFILE' && $row['feed_id'] == Session::instance()->get('user_id')))) . '
                </div>
                <div style="clear:both;height:4px;"></div>
                <div style="display:none;" id="blab_' . $row['id'] . '_timestamp">' . $convertedTime . '</div>
            </div>
        ';

        return $blab;
    }
}
