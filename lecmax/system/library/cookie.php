<?php
final class Cookie {
	public $data = array();
	
	public function __construct() {		
		$exp = time()+60*60*24*30;
		if (!session_id()) {
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			
			ini_set('session.cookie_httponly', 1);
			ini_set('session.cookie_secure', 1);
			ini_set('session.cookie_samesite', 'None');
			session_name('__Secure-PHPSESSID');
			
			
			session_set_cookie_params($exp, '/');
			session_start();
		}
		
		$this->data =& $_SESSION;
	}
}
?>