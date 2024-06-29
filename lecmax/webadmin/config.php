<?php
// HTTP
function getServer() {
	$protocol = 'http';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
		$protocol = 'https';
	}
	$host = $_SERVER['HTTP_HOST'];
	$baseUrl = $protocol . '://' . $host;
	if (substr($baseUrl, -1)=='/') {
		$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
	}
	return $baseUrl;
}

define('DEVERLOP', false);
define('COMPANY_NAME', 'Lecmax');
define('EMAIL', 'lecmax_dev@gmail.com');

define('HTTP_CATALOG', getServer() . '/');
define('HTTP_SERVER', HTTP_CATALOG . 'webadmin/');
define('HTTP_IMAGE', HTTP_CATALOG . 'pictures/');
define('HTTP_PDF', HTTP_CATALOG . 'pdf/');
define('HTTP_AUDIO', HTTP_CATALOG . 'audio/');
define('HTTP_DOWNLOAD', HTTP_CATALOG . 'download/');
define('HTTP_EXCEL', HTTP_CATALOG . 'excel/');
define('HTTP_IMAGE_MOBILE', HTTP_CATALOG . 'pictures/mobile/');

// HTTPS
define('HTTPS_SERVER', HTTP_CATALOG . 'webadmin/');
define('HTTPS_IMAGE', HTTP_CATALOG . 'pictures/');

// DIR
$root = dirname(dirname(__FILE__));
define('DIR_APPLICATION', $root . '/webadmin/');
define('DIR_SYSTEM', $root . '/system/');
define('DIR_DATABASE', $root . '/system/database/');
define('DIR_LANGUAGE', $root . '/webadmin/language/');
define('DIR_TEMPLATE', $root . '/webadmin/view/template/');
define('DIR_CONFIG', $root . '/system/config/');
define('DIR_IMAGE', $root . '/pictures/');
define('DIR_CACHE', $root . '/system/cache/');
define('DIR_DOWNLOAD', $root . '/download/');
define('DIR_BANTIN_VN', $root . '/ban-tin-an-cuong/');
define('DIR_BANTIN_EN', $root . '/an-cuong-news/');
define('DIR_TEMPLATES', $root . '/catalog/view/theme/default/template/cms/');
define('DIR_LOGS', $root . '/system/logs/');
define('DIR_CATALOG', $root . '/catalog/');
define('DIR_XML', $root . '/xml/');
define('DIR_PDF', $root . '/pdf/');
define('DIR_EXCEL', $root . '/excel/');
define('DIR_AUDIO', $root . '/audio/');
define('DIR_IMAGE_MOBILE', $root . '/pictures/mobile/');

define('DIR_INSTALL', $root . '/library/');

define('DIR_MODULE_TRANSLATE', $root . '/catalog/language/{current_language}/');
$arrmodule = array('cms');


define('FB_G_HIDDEN', true);
define('FB_APPID', '1642556749332922');
define('G_CLIENTID', '684615093825-l64naj09u4moo96nk8gus4ig7hcbcmr7');
define('G_APIKEY', 'AIzaSyBsRHKM_MDc5pG1Pu_RMql2VAlG_LEC6JY');


define('PATH_IMAGE_THUMB', HTTP_CATALOG . 'catalog/view/theme/default/images/logo_thumb.jpg');


define('ONESIGNAL_APPID', 'befc90c0-155e-4fb9-9023-9b0615eb3b79');
define('ONESIGNAL_APP_REST_API_KEY', 'Y2Y3YzlmMmMtODk0Ni00ZGUwLWFmNjEtOWVhNDM4ZmI2YTgz');

define('DIR_PICTURE_PRODUCT', 'catalog/products/5000x2500/');
define('DIR_PICTURE_PRODUCT_L', 'catalog/products/5000x2500-l/');


define('ID_HOME', 95);
define('ID_ABOUTUS', 96);
define('ID_PRODUCT', 93);
define('ID_GALLERY', 164);
define('ID_PROJECT', 330);
define('ID_NEWS', 94);
define('ID_CONTACT', 92);
define('ID_CATALOGUE', 329);
define('ID_SERVICE', 269);


define('ID_VIDEO', 402);
define('ID_DOCUMENT', 403);
define('ID_ALBUM', 163);
define('ID_BROCHURE', 257);

define('ID_RECRUITMENT', 335);



// DB
define('DB_DRIVER', 'mmysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'lecmax_us3r1');
define('DB_PASSWORD', 'Lecmax_pass#21');
define('DB_DATABASE', 'lecmax_db');
define('DB_PREFIX', '');
?>