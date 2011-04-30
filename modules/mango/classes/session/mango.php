<?php

/**
 * MongoDB Session Handler
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Session_Mango extends Session {
    /*
     * MongoDB object
     *
     * @var MangoDB
     */
    protected $_db;

    /**
     * Default collection in mongo
     *
     * @var string
     */
    protected $_collection = 'sessions';

    /**
     * Columns/fields in each session document
     *
     * @var array
     */
    protected $_columns = array(
        'session_id' => 'session_id',
        'last_active' => 'last_active',
        'contents' => 'contents'
    );

    /**
     * Number of requests between garbage collection op
     *
     * @var integer
     */
    protected $_gc = 500;

    /**
     * Current session id
     *
     * @var string
     */
    protected $_session_id;

    /**
     * Old sesion id
     *
     * @var string
     */
    protected $_update_id;

    /**
     * Open the session
     *
     * @param array $config Configurations variables
     * @param string $id Session id
     */
    public function  __construct(array $config = NULL, $id = NULL) {
        if( ! isset($config['group'])) {
            $config['group'] = 'default';
        }

        $this->_db = MangoDB::instance($config['group']);

        if (isset($config['collection'])) {
                // Set the table name
                $this->_collection = (string) $config['collection'];
        }

        if (isset($config['gc'])) {
                // Set the gc chance
                $this->_gc = (int) $config['gc'];
        }

        if (isset($config['columns'])) {
                // Overload column names
                $this->_columns = $config['columns'];
        }

        parent::__construct($config, $id);
    }

    /**
     * Get the ID of the current session
     *
     * @return string Session id
     */
    public function id() {
        return $this->_session_id;
    }

    /**
     * Read the contents of a session.
     *
     * @param string $id Session ID
     * @return string Session contents
     */
    protected function _read($id = null) {
        if($id || $id = Cookie::get($this->_name)) {
            $doc = $this->_db->find_one($this->_collection,
                array($this->_columns['session_id'] => $id)
            );

            if($doc != null) {
                $this->_session_id = $this->_update_id = $id;

                return $doc['contents'];
            }
        }

        $this->_regenerate();

        return null;
    }

    /**
     * Generate a new session id
     *
     * @return string New valid session id
     */
    protected function _regenerate() {
        do {
            $id = str_replace('.', '-', uniqid(null, true));

            $count = $this->_db->count($this->_collection,
                array('session_id' => $id)
            );
            
        } while($count);

        return $this->_session_id = $id;
    }

    /**
     * Write the session data to Mongo.
     */
    protected function _write() {
        if($this->_update_id === null) {
            $this->_db->insert($this->_collection,
                array(
                    $this->_columns['session_id'] => $this->_session_id,
                    $this->_columns['last_active'] => $this->_data['last_active'],
                    $this->_columns['contents'] => $this->__toString()
                )
            );
        } else {
            $this->_db->update($this->_collection,
                array(
                    $this->_columns['session_id'] => $this->_session_id,
                ),
                array(
                    '$set' => array(
                        $this->_columns['last_active'] => $this->_data['last_active'],
                        $this->_columns['contents'] => $this->__toString(),
                        $this->_columns['session_id'] => $this->_session_id
                    )
                ),
                array(
                    'multiple' => false
                )
            );
        }

        $this->_update_id = $this->_session_id;

        Cookie::set($this->_name, $this->_session_id, $this->_lifetime);

        return true;
    }

    /**
     * Destroy the session, in Mongo and in browser.
     *
     * @return boolean Success
     */
    protected function _destroy() {
        if($this->_update_id === null) {
            return true;
        }

        try {
            $this->_db->remove($this->_collection,
                array(
                    $this->_columns['session_id'] => $this->_session_id
                ),
                array(
                    'justOne' => true,
                    'fsync' => true
                )
            );

            Cookie::delete($this->_name);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Perform garbage collection
     */
    protected function _gc() {
        if($this->_lifetime) {
            $expires = $this->_lifetime;
        } else {
            $expires = Date::MONTH;
        }

        $this->_db->remove($this->_collection,
            array(
                'last_active' => array(
                    '$lt' => $expires
                )
            )
        );
    }
}