<?php

/**
 * Feed Generator
 * 
 * Allows for the generation of groups of posts, limit of 10.
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Util_Feed_Generator {

    /**
     * The configuration for the generator.
     *
     * @var array
     */
    protected $config = array(
        'feed_id' => 1,
        'types' => array(
            'STATUS'
        ),
        'lastdate' => false,
        'reverse' => false,
        'member' => false,
        'show_from' => false,
        'blab_id' => false,
        'ignore_privacy' => false,
        'view' => 'feed/blabs'
    );
        
    /**
     * @var array The found blabs
     */
    protected $blabs = array();

    public static function factory() {
        return new Util_Feed_Generator();
    }


    /**
     * Set configuration parameter for this generator.
     *
     * @param string $param Parameter name
     * @param string $value Actual value for the parameter
     * @return Util_Feed_Generator 
     */
    public function set($param, $value) {
        $this->config[$param] = $value;

        return $this;
    }

    /**
     * Loads the blab data into $this->blabs
     *
     * @return Util_Feed_Generator
     */
    public function load($blabs = null) {
        if ($blabs == null) {
            //Initial query
            $query = "SELECT b.id, b.mem_id, b.type, b.feed_id, b.text, b.`date`, b.likes as likes, b.ref_id,
                             f.title as feed_title,
                             m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                        FROM blabs b
                        INNER JOIN myMembers m ON b.mem_id = m.id
                        LEFT JOIN feeds f ON f.id = b.feed_id";

            if (@$this->config['friends_only']) {
                $addQuery = "";

                $id = Session::instance()->get('user_id');

                $where = " AND (EXISTS (SELECT 1 FROM friend_relationships fr WHERE fr.to = {$id} AND fr.from = b.mem_id) OR b.mem_id = {$id})";
            } else if (!$this->config['ignore_privacy']) {
                $where = $this->getPrivacyQuery();
            } else {
                $addQuery = "";
                $where = "";
            }

            if ($this->config['member']) {
                $member = $this->config['member'];

                $where .= " AND (b.mem_id = $member OR b.type = 'PROFILE')";

                $where .= " OR (b.type = 'PROFILE' AND (b.feed_id = $member OR b.mem_id = $member))";
            }

            $query .= "" . $this->getSQLFilter();
            $query .= $where . ")";

            if ($this->config['lastdate']) {
                if ($this->config['reverse']) {
                    $query .= " AND b.date < '" . $this->config['lastdate'] . "'";
                } else {
                    $query .= " AND b.date > '" . $this->config['lastdate'] . "'";
                }
            }

            $query .= " ORDER BY b.date DESC LIMIT 10";
            
            try {
                $this->blabs = DB::query(Database::SELECT, $query)->execute()->as_array();
            } catch (Database_Exception $e) {
                return array();
            }

        } else {
            if (is_numeric($blabs)) {
                $query = "SELECT b.id, b.type, feed_id, mem_id, text, `date`, b.likes as likes, b.ref_id,
                             m.username as username, m.firstname as firstname, m.lastname as lastname, m.friend_array as friends, m.privacy_option as privacy_option, m.has_profile_image
                            FROM blabs b
                            LEFT JOIN myMembers m ON mem_id = m.id
                            WHERE b.id = $blabs";

                $this->blabs = DB::query(Database::SELECT, $query)->execute()->as_array();
            } else {
                $this->blabs = $blabs;
            }
        }

        return $this;
    }

    public function render() {
        return View::factory($this->config['view'])
                ->bind('blabs', $this->blabs)
                ->bind('config', $this->config)
                ->render();
    }

    protected function getSQLFilter() {
        $query = " WHERE (";

        if ($this->config['feed_id'] == '*') {
            $query .= "true";
        } else {
            if(is_numeric($this->config['feed_id'])) {
                $query .= "feed_id = {$this->config['feed_id']}";
            } else {
                $query .= "feed_id = 1";
            }
        }

        $query .= " AND (";

        foreach ($this->config['types'] as $type) {
            $query .= " b.type = '$type' OR";
        }

        $query .= " false )";

        return $query;
    }

    protected function getPrivacyQuery() {
        $member = Session::instance()->get('user_id');

        if (!$member) {
            $member = -1;
        }

        $privacy_option = Model_Member::getPrivacy($member);
        $query = "";
        $where = "";

        if ($privacy_option == 'locked') {
            $where = " AND (EXISTS (SELECT 1 FROM friend_relationships fr WHERE fr.to = {$member} AND fr.from = b.mem_id) OR b.mem_id = {$member})";
        } else {
            $where .= " AND ((m.privacy_option != 'locked' AND m.privacy_option != 'limited')";
            $where .= " OR (EXISTS (SELECT 1 FROM friend_relationships fr WHERE fr.to = {$member} AND fr.from = b.mem_id) OR b.mem_id = {$member}))";
        }

        return $where;
    }

}