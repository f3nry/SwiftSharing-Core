<?php

Route::set('feed_ajax', 'ajax/feed(/<action>)')
        ->defaults(array(
            'controller' => 'ajax_feed',
            'action' => 'index'
        ));

Route::set('feed', 'feed/<id>(/<action>)')
        ->defaults(array(
            'controller' => 'feed',
            'action' => 'index'
        ));

Route::set('likes', 'likes')
        ->defaults(array(
            'controller' => 'ajax_like',
            'action' => 'index'
        ));
