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
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	'oauth'        => MODPATH.'oauth',        // OAuth implementation for Kohana
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	 'firephp'  => MODPATH. 'firephp',  // User guide and API documentation
	 'swiftmailer' => MODPATH . 'swiftmailer',
	 'facebook' => MODPATH . 'facebook',
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
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
Route::set('api_account_settings_getgeneral', 'api/settings/getgeneral')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'getgeneral',
	));
Route::set('api_account_settings_getuser', 'api/settings/getuser')
	->defaults(array(
		'directory' => 'api',
		'controller' => 'settings',
		'action' => 'getuser',
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


Route::set('dataprovider', '<directory>(/<controller>(/<action>(/<id>)))', array(
		'directory' => 'api/dataProvider'
	));
Route::set('api', '<directory>(/<controller>(/<action>(/<id>)))', array(
		'directory' => '(api)'
	));
Route::set('api_rest', '<directory>(/<controller>(/<action>/<field>(/<id>)))', array(
		'directory' => '(api)'
	));
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'dashboard',
		'action'     => 'index',
	));
