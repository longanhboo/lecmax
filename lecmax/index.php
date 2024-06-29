<?php
// Version
define('VERSION', '2.0.3.1');

// Config
require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application Classes
require_once(DIR_SYSTEM . 'library/trimwidth.php');
require_once(DIR_SYSTEM . 'library/gzip.php');
require_once(DIR_SYSTEM . 'library/f.php');
require_once(DIR_SYSTEM . 'library/lib/swift_required.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);


// Settings
$query_lang = $db->query("SELECT `key`,`value` FROM " . DB_PREFIX . "setting WHERE store_id = 0");
foreach ($query_lang->rows as $setting) {
	$config->set($setting['key'], $setting['value']);
}

$config->set('config_url', HTTP_SERVER);
$config->set('config_ssl', HTTPS_SERVER);

// Url
$url = new Url($config->get('config_url'), $config->get('config_ssl'));
$registry->set('url', $url);

// Log
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;

	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
		$error = 'Notice';
		break;
		case E_WARNING:
		case E_USER_WARNING:
		$error = 'Warning';
		break;
		case E_ERROR:
		case E_USER_ERROR:
		$error = 'Fatal Error';
		break;
		default:
		$error = 'Unknown';
		break;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}

	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response);

// Cache
$cache = new Cache();
$registry->set('cache', $cache);

// Session
$session = new Session();
$registry->set('session', $session);

// Language Detection
$languages = array();

$query = $db->query("SELECT * FROM " . DB_PREFIX . "language");

foreach ($query->rows as $result) {
	$languages[$result['code']] = $result;
}

$detect = '';

if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && ($request->server['HTTP_ACCEPT_LANGUAGE'])) {
	$browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);

	foreach ($browser_languages as $browser_language) {
		foreach ($languages as $key => $value) {
			if ($value['status']) {
				$locale = explode(',', $value['locale']);

				if (in_array($browser_language, $locale)) {
					$detect = $key;
				}
			}
		}
	}
}

$lang_temp = isset($request->get['_route_'])?($request->get['_route_']):'';
$lang_temp = explode('/',$lang_temp);

if (isset($request->get['language']) && array_key_exists($request->get['language'], $languages) && $languages[$request->get['language']]['status']) {
	$code = $request->get['language'];
} elseif (isset($lang_temp[0]) && array_key_exists($lang_temp[0], $languages) && $languages[$lang_temp[0]]['status']) {
	$code = $lang_temp[0];
} elseif (isset($session->data['language']) && array_key_exists($session->data['language'], $languages)) {
	$code = $session->data['language'];
} elseif (isset($request->post['language']) && array_key_exists($request->post['language'], $languages)) {
	$code = $request->post['language'];
//} elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $languages)) {
//	$code = $request->cookie['language'];
//} elseif ($detect) {
	//$code = $detect;
} else {
	$code = $config->get('config_language');
}

if (!isset($session->data['language']) || $session->data['language'] != $code) {
	$session->data['language'] = $code;
}

if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {
	//setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
	setcookie('language', $code,[
			'expires' => time() + 60 * 60 * 24 * 30,
			'path' => '/',
			'domain' => $request->server['HTTP_HOST'],
			'secure' => true,
			'httponly' => true,
			'samesite' => 'None',
		]);
}

$languages  = $db->query("SELECT language_id,code,directory FROM " . DB_PREFIX . "language WHERE code = '".$code."'")->rows;
$config->set('config_language_id', $languages[0]['language_id']);
$config->set('config_language', $languages[0]['code']);

// Language
$language = new Language($languages[0]['directory']);
//$language->load($languages[$code]['filename']);
$registry->set('language', $language);

// Document
$document = new Document();
$registry->set('document', $document);


// Front Controller
$controller = new Front($registry);

// Maintenance Mode
$controller->addPreAction(new Action('common/maintenance'));

// SEO URL's
$controller->addPreAction(new Action('common/seo_url'));

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
}


// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();
?>