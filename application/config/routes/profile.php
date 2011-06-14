<?php

Route::set('login', 'login(/<action>)')
        ->defaults(array(
            'controller' => 'login',
            'action' => 'index'
        ));

Route::set('logout', 'logout')
        ->defaults(array(
            'controller' => 'logout',
            'action' => 'index'
        ));

Route::set('register', 'register')
        ->defaults(array(
            'controller' => 'register',
            'action' => 'index'
        ));

Route::set('profile_edit', 'profile/edit(/<action>)')
        ->defaults(array(
            'controller' => 'profile',
            'action' => 'edit'
        ));

Route::set('activate', 'activate/<id>/<sequence>')
        ->defaults(array(
            'controller' => 'register',
            'action' => 'activate'
        ));

Route::set('members', 'members(/<action>(/page/<page_number>))')
       ->defaults(array(
           'controller' => 'members',
           'action' => 'index'
       ));
       
Route::set('profile_ajax', 'ajax/profile/friends/<id>')
				->defaults(array(
					'controller' => 'ajax_profile',
					'action' => 'friends'
				));

Route::set('profile', '<username>(/<action>)', array(
            'username' => '\w{2,40}'
        ))
        ->defaults(array(
            'controller' => 'profile',
            'action' => 'index'
        ));