<?php

/**
 * engine
 *
 * @author Paul Henry <paulhenry@mphwebsystems.com>
 */
class Util_Analytics_Engine  {
    public static function record(Request $request) {
        try {
            $db = MangoDB::instance();

            $document = array(
                'datetime' => new MongoDate(),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'page' => $request->uri(),
                'browser' => $request->user_agent('browser'),
                'version' => $request->user_agent('version'),
                'platform' => $request->user_agent('platform'),
                'mobile' => $request->user_agent('mobile'),
                'robot' => $request->user_agent('robot'),
                'ajax' => $request->is_ajax(),
                'username' => Session::instance()->get('username'),
                'id' => Session::instance()->Get('user_id')
            );

            $db->insert('access_logs', $document);
        } catch(Exception $e) {}
    }
}