<?php
final class User {
	private $user_id;
	private $username;
	private $group;
	private $permission = array();

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->group = $user_query->row['user_group_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = unserialize($user_group_query->row['permission']);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password, $backend=true) {
		if($backend){
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(username) = '" . $this->db->escape(strtolower($username)) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND user_group_id<>11 AND status=1");
		}else{
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(username) = '" . $this->db->escape(strtolower($username)) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND user_group_id=11 AND status=1");
		}
		/*$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(username) = '" . $this->db->escape(strtolower($username)) . "' AND password = '" . $this->db->escape(md5($password)) . "'");*/

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->group = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = unserialize($user_group_query->row['permission']);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function social_login($social_id, $password, $backend=true) {
		if ($backend) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(social_id) = '" . $this->db->escape(strtolower($social_id)) . "' AND social_password = '" . $this->db->escape(md5($password)) . "' AND user_group_id<>11 AND status=1");
		} else {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(social_id) = '" . $this->db->escape(strtolower($social_id)) . "' AND social_password = '" . $this->db->escape(md5($password)) . "' AND user_group_id=11 AND status=1");
		}

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->group = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = unserialize($user_group_query->row['permission']);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function check_social_login($social_id, $password, $backend=true) {
		if ($backend) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(social_id) = '" . $this->db->escape(strtolower($social_id)) . "' AND social_password = '" . $this->db->escape(md5($password)) . "' AND user_group_id<>11");
		} else {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE LOWER(username) = '" . $this->db->escape(strtolower($username)) . "' AND social_password = '" . $this->db->escape(md5($password)) . "' AND user_group_id=11");
		}

		if ($user_query->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';

		session_destroy();
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId(){
		return $this->group;
	}
}
?>