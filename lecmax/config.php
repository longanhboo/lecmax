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

define('HTTP_SERVER', getServer() . '/');
define('HTTP_IMAGE', HTTP_SERVER . 'pictures/');
define('HTTP_IMAGE_IPAD', HTTP_SERVER . 'pictures_ipad/');
define('HTTP_ADMIN', HTTP_SERVER . 'admin/');
define('HTTP_PDF', HTTP_SERVER . 'pdf/');
define('HTTP_AUDIO', HTTP_SERVER . 'audio/');
define('HTTP_DOWNLOAD', HTTP_SERVER . 'download/');
define('HTTP_BANTIN_VN', HTTP_SERVER . 'ban-tin-an-cuong/');
define('HTTP_BANTIN_EN', HTTP_SERVER . 'an-cuong-news/');
define('HTTP_IMAGE_MOBILE', HTTP_SERVER . 'pictures/mobile/');

// HTTPS
define('HTTPS_SERVER', HTTP_SERVER);
define('HTTPS_IMAGE', HTTP_SERVER . 'pictures/');
define('HTTPS_PDF', HTTP_SERVER . 'pdf/');


define('PATH_TEMPLATE', HTTP_SERVER . 'catalog/view/theme/');
define('PATH_IMAGE_THUMB', HTTP_SERVER . 'catalog/view/theme/default/images/logo_thumb.jpg');
define('PATH_IMAGE_THUMB_MOBILE', HTTP_SERVER . 'catalog/view/theme/default/images/logo_thumb_m.jpg');
define('PATH_IMAGE_BG', HTTP_SERVER . 'catalog/view/theme/default/images/bg_temp.jpg');

// DIR
$root = dirname(__FILE__);
define('DIR_SERVER', $root . '/');
define('DIR_APPLICATION', $root . '/catalog/');
define('DIR_SYSTEM', $root . '/system/');
define('DIR_DATABASE', $root . '/system/database/');
define('DIR_LANGUAGE', $root . '/catalog/language/');
define('DIR_TEMPLATE', $root . '/catalog/view/theme/');
define('DIR_CONFIG', $root . '/system/config/');
define('DIR_IMAGE', $root . '/pictures/');
define('DIR_IMAGE_IPAD', $root . '/pictures_ipad/');
define('DIR_CACHE', $root . '/system/cache/');
define('DIR_DOWNLOAD', $root . '/download/');
define('DIR_BANTIN_VN', $root . '/ban-tin-an-cuong/');
define('DIR_BANTIN_EN', $root . '/an-cuong-news/');
define('DIR_LOGS', $root . '/system/logs/');
define('DIR_DOCUMENT', $root . '/document/');
define('DIR_PDF', $root . '/pdf/');
define('DIR_AUDIO', $root . '/audio/');
define('DIR_IMAGE_MOBILE', $root . '/pictures/mobile/');

define('PAGING_NEWS', 9);
define('SL_TIN', 100);
define('PAGING_PRODUCT', 9);
define('PAGING_DECOR', 4);
define('CACHE_TIME', 2592000);
define('VER', '1.0.2');


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


define('api_url', 'https://www.google.com/recaptcha/api/siteverify');
define('site_key', '6LfWNLwUAAAAACDEP75KS0BrDRV_Ywz6RIDfTeC9');
define('secret_key', '6LfWNLwUAAAAAFNLJmF504oVBKaFqNrX5Z7C-dqQ');

// DB
define('DB_DRIVER', 'mmysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'lecmax_us3r1');
define('DB_PASSWORD', 'Lecmax_pass#21');
define('DB_DATABASE', 'lecmax_db');
define('DB_PREFIX', '');

?>