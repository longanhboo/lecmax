<?php       
class ControllerCommonLogout extends Controller {   
	public function index() { 
		$this->user->logout();
 		/*
 		$this->db->query("UPDATE " . DB_PREFIX . "setting 
					SET `value` = '" . $this->config->get('config_admin_language_default') . "'
					WHERE `key` = 'config_admin_language'");
		*/

		unset($this->session->data['token']);

		$this->redirect($this->url->link('common/login', '', '', 'SSL'));
	}
}  
?>