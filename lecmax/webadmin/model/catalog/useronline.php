<?php

class ModelCatalogUseronline extends Model {
	var $timeout = 600;
	var $count = 0;
	
	public function usersOnline() {
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
		$this->count_users();
	}
	
	public function ipCheck() {
		/*
		This function checks if user is coming behind proxy server. Why is this important?
		If you have high traffic web site, it might happen that you receive lot of traffic
		from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
		This function tryes to get real IP address.
		Note that getenv() function doesn't work when PHP is running as ISAPI module
		*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function new_user() {
		//$count = $this->db->query("SELECT * FROM ".DB_PREFIX ."useronline WHERE ip='".$this->ip."'");

		$insert =  $this->db->query("INSERT INTO ".DB_PREFIX ."useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
		//if($count->num_rows==0)
		$insert =  $this->db->query("INSERT INTO ".DB_PREFIX ."useronlineacess(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
	}

	public function delete_user() {
		$delete =  $this->db->query("DELETE FROM ".DB_PREFIX ."useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
	}

	public function count_users() {
		$count = $this->db->query("SELECT ip FROM ".DB_PREFIX ."useronline");
		return $count->num_rows;
	}
	public function count_all_access(){
		$count = $this->db->query("SELECT * FROM ".DB_PREFIX ."useronlineacess");
		return $count->num_rows;	
	}
}
?>