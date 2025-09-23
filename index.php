<?php

/**
 * CodeIgniter Front Controller
 * (index.php di root project)
 */

//---------------------------------------------------------------
// APPLICATION ENVIRONMENT
//---------------------------------------------------------------
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

switch (ENVIRONMENT) {
	case 'development':
		// Untuk development, tampilkan semua error kecuali deprecated
		error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_STRICT & ~E_USER_DEPRECATED);
		ini_set('display_errors', 1);
		break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', true, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

//---------------------------------------------------------------
// PATHS
//---------------------------------------------------------------

// Path ke folder "system"
$system_path = 'system';

// Path ke folder "application"
$application_folder = 'application';

// Path ke folder "views"
$view_folder = '';

//---------------------------------------------------------------
// RESOLVE SYSTEM PATH
//---------------------------------------------------------------
if (defined('STDIN')) {
	chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== false) {
	$system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
	$system_path = rtrim($system_path, '/\\') . DIRECTORY_SEPARATOR;
}

if (!is_dir($system_path)) {
	header('HTTP/1.1 503 Service Unavailable.', true, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the file: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

//---------------------------------------------------------------
// MAIN PATH CONSTANTS
//---------------------------------------------------------------
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_path);
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));

// Path ke "application"
if (is_dir($application_folder)) {
	if (($_temp = realpath($application_folder)) !== false) {
		$application_folder = $_temp;
	} else {
		$application_folder = rtrim($application_folder, '/\\');
	}
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
	$application_folder = BASEPATH . rtrim($application_folder, '/\\');
} else {
	header('HTTP/1.1 503 Service Unavailable.', true, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open this file: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// Path ke "views"
if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
	if (($_temp = realpath($view_folder)) !== false) {
		$view_folder = $_temp;
	} else {
		$view_folder = rtrim($view_folder, '/\\');
	}
} elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
	$view_folder = APPPATH . rtrim($view_folder, '/\\');
} else {
	header('HTTP/1.1 503 Service Unavailable.', true, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open this file: ' . SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);

//---------------------------------------------------------------
// LOAD BOOTSTRAP
//---------------------------------------------------------------
require_once BASEPATH . 'core/CodeIgniter.php';
