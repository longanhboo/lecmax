<?php
final class Session {
	public $data = array();
	
	public function __construct() {		
		if (!session_id()) {
			ini_set('session.use_cookies', 'On');
			ini_set('session.use_trans_sid', 'Off');
			
			//session_set_cookie_params(0, '/');
			
			/****/
			ini_set('session.cookie_httponly', 1);
			ini_set('session.cookie_secure', 1);
			ini_set('session.cookie_samesite', 'None');
			session_name('__Secure-PHPSESSID');
			
			ini_set('session.gc_maxlifetime', 1440);
			ini_set('session.gc_divisor', 100);
			ini_set('session.gc_probability', 1);
			session_set_cookie_params(0, '/');
			
			
			//ini_set('session.save_path',  DIR_SYSTEM .'session');
			/****/
			session_start();
		}
		
		$this->data =& $_SESSION;
	}
}
?>