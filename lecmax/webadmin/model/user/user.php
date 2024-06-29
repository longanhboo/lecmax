<?php
class ModelUserUser extends Model {
	private $permission = array('1'=>array(12,13,11), '12'=>array(13,11), '13'=>array(11), '11'=>array(0));

	public function addUser($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', password = '" . $this->db->escape(md5($data['password'])) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	}

	public function addSocialUser($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['social_username']) . "', social_password = '" . $this->db->escape(md5($data['social_password'])) . "', firstname = '" . $this->db->escape($data['social_firstname']) . "', lastname = '" . $this->db->escape($data['social_lastname']) . "', social_id = '" . $this->db->escape($data['social_id']) ."', email = '" . $this->db->escape($data['social_email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '1', date_added = NOW()");

		// $this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['social_username']) . "', social_password = '" . md5($data['s_social_password']) . "', firstname = '" . $data['social_firstname'] . "', lastname = '" . $data['social_lastname'] . "', social_id = '" . $data['social_id'] . "', email = '" . $data['social_email'] . "', user_group_id = '13', status = '0', date_added = NOW()");
	}

	public function editUser($user_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE user_id = '" . (int)$user_id . "'");

		if ($data['password']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE user_id = '" . (int)$user_id . "'");
		}
	}

	public function editPassword($user_id, $password) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET password = '" . $this->db->escape(md5($password)) . "' WHERE user_id = '" . (int)$user_id . "'");
	}

	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET code = '" . $this->db->escape($code) . "' WHERE email = '" . $this->db->escape($email) . "'");
	}

	public function deleteUser($user_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
	}

	public function getUser($user_id) {
		if($this->user->getId()!= 1){
			$str = "SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'";
			$cond = implode(',', $this->permission[$this->user->getGroupId()]);

			$str .= "  AND (user_group_id IN (" . $cond . ") OR user_id='" . $this->user->getId(). "')";
		}else{
			$str = "SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'";
		}


		$query = $this->db->query($str);

		return $query->row;
	}

	public function getUserByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

		return $query->row;
	}

	public function getUsers($data = array()) {
		$str = "";
		if($this->user->getId()!= 1){
			$str .= " WHERE user_id<>'1' ";
			/*
			$array=array(312, 401, 1599, 3);
			$toDelete=401;

			$array=array_diff($array, array($toDelete));
			*/
			if(	(int)$this->user->getGroupId()	!=1){
				$cond = implode(',', $this->permission[$this->user->getGroupId()]);
			//print_r($cond);
				$str .= "  AND (user_group_id IN (" . $cond . ") OR user_id='" . $this->user->getId(). "')";

			}else{
				if((int)$this->user->getGroupId()!=1){
					$str .= "  AND user_group_id='" . (int)$this->user->getGroupId() . "'";
				}
			}
		}

		$sql = "SELECT * FROM `" . DB_PREFIX . "user` $str ";

		$sort_data = array(
		                   'username',
		                   'status',
		                   'date_added'
		                   );

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY username";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalUsers() {
		$str = "";
		if($this->user->getId()!= 1){
			$str .= " WHERE user_id<>'1' ";
			$cond = implode(',', $this->permission[$this->user->getGroupId()]);
			$str .= "  AND (user_group_id IN (" . $cond . ") OR user_id='" . $this->user->getId(). "')";

			/*if((int)$this->user->getGroupId()!=1)
			$str .= "  AND user_group_id='" . (int)$this->user->getGroupId() . "'";*/
		}

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` $str ");

		return $query->row['total'];
	}

	public function getTotalUsersByGroupId($user_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE user_group_id = '" . (int)$user_group_id . "'");

		return $query->row['total'];
	}

	public function getTotalUsersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE email = '" . $this->db->escape($email) . "'");

		return $query->row['total'];
	}
}
?>