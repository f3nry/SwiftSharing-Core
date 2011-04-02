<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
    'index_file' => false
 ));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
         'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
         'email' => MODPATH.'email',
         'amazon' => MODPATH.'aws',
         'mango' => MODPATH.'mango'
    ));

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

Route::set('feed_ajax', 'ajax/feed(/<action>)')
        ->defaults(array(
            'controller' => 'ajax_feed',
            'action' => 'index'
        ));

Route::set('friend_ajax', 'ajax/friend')
        ->defaults(array(
            'controller' => 'ajax_friend',
            'action' => 'index'
        ));

Route::set('inbox_ajax', 'ajax/inbox(/<action>)')
        ->defaults(array(
            'controller' => 'ajax_inbox',
            'action' => 'index'
        ));

Route::set('profile_ajax', 'ajax/profile/<action>/<id>')
        ->defaults(array(
            'controller' => 'ajax_profile',
            'action' => 'index'
        ));

Route::set('feed', 'feed/<id>(/<action>)')
        ->defaults(array(
            'controller' => 'feed',
            'action' => 'index'
         ));

Route::set('friends', 'friends')
        ->defaults(array(
            'controller' => 'friends',
            'action' => 'index'
        ));

Route::set('profile_edit', 'profile/edit')
        ->defaults(array(
            'controller' => 'profile',
            'action' => 'edit'
        ));

Route::set('members', 'members(/<action>(/page/<page_number>))')
        ->defaults(array(
            'controller' => 'members',
            'action' => 'index'
        ));
        
Route::set('about', 'about')
        ->defaults(array(
            'controller' => 'about',
            'action' => 'index'
        ));

Route::set('page', 'page')
        ->defaults(array(
            'controller' => 'page',
            'action' => 'index'
        ));

Route::set('help', 'help')
		->defaults(array(
			'controller' => 'help',
			'action' => 'index'
		));
Route::set('refer', 'refer')
		->defaults(array(
			'controller' => 'refer',
			'action' => 'index'
		));
		
Route::set('privact', 'privacy')
		->defaults(array(
			'controller' => 'privacy',
			'action' => 'index'
		));

Route::set('dashboard', 'dashboard')
        ->defaults(array(
            'controller' => 'dashboard',
            'action' => 'index'
        ));
        
Route::set('inbox', 'inbox(/<action>/<id>)',
        array(
            'id' => '\d+',
            'action' => '(view|delete|new)'
        ))
        ->defaults(array(
            'controller' => 'inbox',
            'action' => 'index'
        ));

        
Route::set('likes', 'likes')
		->defaults(array(
			'controller' => 'ajax_like',
			'action' => 'index'
		));

Route::set('friends', 'friends(/<page>)')
        ->defaults(array(
            'controller' => 'friends',
            'action' => 'index'
        ));
        
Route::set('activate', 'activate/<id>/<sequence>')
		->defaults(array(
			'controller' => 'register',
			'action' => 'activate'
		));
		
Route::set('404', '404')
		->defaults(array(
			'controller' => 'home',
			'action' => '404'
		));
        
Route::set('profile', '<username>(/<action>)',
    array(
        'username' => '\w{4,20}'
    ))
    ->defaults(array(
        'controller' => 'profile',
        'action' => 'index'
    ));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
	));
