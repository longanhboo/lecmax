<?php  
class ControllerCommonLogin extends Controller { 
	private $error = array();
	
	public function index() { 
		$username = $this->request->post['username'];
		$password = $this->request->post['password'];
		$redirect =  str_replace('amp;','',$this->request->post['redirect']);
		
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND user_group_id=11");

		if ($user_query->num_rows) {
			$this->session->data['user'] = array('user_id'=>$user_query->row['user_id'],'name'=>$user_query->row['username']);
			
			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];			

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			foreach (unserialize($user_group_query->row['permission']) as $key => $value) {
				$this->permissions[$key] = $value;
			}
			
			$this->redirect($this->request->server['HTTP_REFERER']);
			//return TRUE;
		} else {
			//return FALSE;
			$this->redirect($this->request->server['HTTP_REFERER']);
		}
	}

	
	private function validate() {
		if (isset($this->request->post['username']) && isset($this->request->post['password']) && !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}  
?>