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
	'index_file' => '',
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
// Log_Mongo will handle Log::Alert and Log::EMERGENCY
Kohana::$log->attach(new Log_File(APPPATH.'logs'),Log::DEBUG,Log::CRITICAL);
Kohana::$log->attach(new Log_Mongo(),array(Log::ALERT,Log::EMERGENCY));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	'oauth'        => MODPATH.'oauth',        // OAuth implementation for Kohana
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	 'swiftmailer' => MODPATH . 'swiftmailer',
	 'facebook' => MODPATH . 'facebook',
	 'twitter' => MODPATH . 'twitter',
        'freshbooks' => MODPATH . 'freshbooks',
        'automodeler'=>MODPATH.'auto-modeler'
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

// frontpage
// @todo change it to lead to the actual frontpage
Route::set('frontpage', '/')
	->defaults(array(
		'controller' => 'dashboard',
		'action'     => 'index',
	));

// login page
Route::set('login', 'login')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'new',
	));
// logout action
Route::set('logout', 'logout')
	->defaults(array(
		'controller' => 'session',
		'action'     => 'destroy',
	));

// Competition tab
Route::set('competition', 'competition')
	->defaults(array(
		'controller' => 'competition',
		'action'     => 'index',
	));
// Contact form
Route::set('contact', 'contact')
	->defaults(array(
		'controller' => 'contact',
		'action'     => 'index',
	));
// Dashboard page
Route::set('dashboard', 'dashboard')
	->defaults(array(
		'controller' => 'dashboard',
		'action'     => 'index',
	));
// Review tab
Route::set('review', 'review')
	->defaults(array(
		'controller' => 'review',
		'action'     => 'index',
	));
// Social activity tab
Route::set('social', 'social')
	->defaults(array(
		'controller' => 'social',
		'action'     => 'index',
	));
// Account settings
Route::set('account', 'account/<action>')
	->defaults(array(
		'controller' => 'account',
		'action'     => 'general',
	));


// API routes
Route::set('api_account_settings', 'api/settings')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'index',
	));
Route::set('api_account_settings_addemail', 'api/settings/addemail')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'addemail',
	));
Route::set('api_account_settings_changelocationlevel', 'api/settings/changelocationlevel')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'changelocationlevel',
	));
Route::set('api_account_settings_deleteemail', 'api/settings/deleteemail')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'deleteemail',
	));
Route::set('api_account_settings_deleteuser', 'api/settings/deleteuser')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'deleteuser',
	));
Route::set('api_account_settings_get', 'api/settings/get')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'get',
	));
Route::set('api_account_settings_getemails', 'api/settings/getemails')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'getemails',
	));
Route::set('api_account_settings_getuser', 'api/settings/getuser')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'getuser',
	));
Route::set('api_account_settings_socialdisconnect', 'api/settings/socialdisconnect')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'socialdisconnect',
	));
Route::set('api_account_settings_updatealert', 'api/settings/updatealert')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'updatealert',
	));
Route::set('api_account_settings_updategeneral', 'api/settings/updategeneral')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'updategeneral',
	));
Route::set('api_account_settings_updateuser', 'api/settings/updateuser')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'updateuser',
	));

// Twitter OAuth URLs
Route::set('oauth_twitter_connect', 'api/settings/twitterconnect(/loc/<location_id>)', array(
                'location_id' => '[[:digit:]]+',
        ))
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'twitterconnect',
	));
Route::set('oauth_twitter_callback', 'api/settings/twittercallback(/loc/<location_id>)', array(
                'location_id' => '[[:digit:]]+',
        ))
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'twittercallback',
	));

// static pages
Route::set('pages', 'pages(/<name>)')
	->defaults(array(
		'controller' => 'resources',
		'action' => 'index',
	));


// alerts
Route::set('alerts', 'alerts(/<name>)')
	->defaults(array(
		'controller' => 'alerts',
		'action' => 'index',
	));

// Account Settings URLs
// @todo Add remaining sections here
Route::set('account_settings_social', 'account/socials')
	->defaults(array(
		'controller' => 'account',
		'action' => 'socials',
	));

Route::set('dataprovider', '<directory>(/<controller>(/<action>(/<id>)))', array(
		'directory' => 'api/dataProvider'
	));
Route::set('api', '<directory>(/<controller>(/<action>(/<id>)))', array(
		'directory' => '(api)'
	));
Route::set('api_rest', '<directory>(/<controller>(/<action>/<field>(/<id>)))', array(
		'directory' => '(api)'
	));
  
    Route::set('admin', '<directory>(/<controller>(/<action>(/<id>)))', array(
		'directory' => '(admin)'
	));
//Route::set('default_dir', '<directory>(<controller>(/<action>(/<id>)))');

Route::set('default', '(<directory>/)(<controller>(/<action>(/<id>)))')
	->defaults(array(
        'directory'=>'',
		'controller' => 'dashboard',
		'action'     => 'index',
	));
