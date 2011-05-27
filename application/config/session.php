<?php

Cookie::$salt = '1df4a';

return array(
    'database' => array(
        'name' => 'PHPSESSID',
        'encrypted' => false,
        'lifetime' => 43200,
        'group' => 'default',
        'table' => 'sessions',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
    'mango' => array(
        'name' => 'PHPSESSID',
        'encrypted' => false,
        'lifetime' => 43200,
        'group' => 'default',
        'collection' => 'sessions',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);