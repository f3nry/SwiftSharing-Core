<?php

Route::set('admin_chat', 'admin/chat(/<action>(/<id>))')
		->defaults(array(
			'controller' => 'admin_chat',
			'action' => 'index'
		));
		
Route::set('admin_ajax', 'admin/ajax/<action>')
		->defaults(array(
			'controller' => 'admin_ajax',
			'action' => 'index'
		));

Route::set('admin', 'admin(/<action>)')
        ->defaults(array(
            'controller' => 'admin',
            'action' => 'index'
        ));