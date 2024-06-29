<?php
class ModelCatalogLog extends Model {
	public function add($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "log SET 			
		                 status = '1',
		                 name = '" . $this->db->escape($data['name']) . "',
		                 module = '" . $this->db->escape($data['module']) . "',
		                 ip = '" . $this->ipCheck() . "',
		                 user_id = '" . $this->user->getId() . "',
		                 dateadd = NOW()");		
	}
	
	public function ipCheck() {
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
	
	public function delete($log_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "log WHERE log_id = '" . (int)$log_id . "'");		
	}
	
	public function getlogs($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "log ORDER BY dateadd ASC"; 						
			
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
		} else {
			$log_data = $this->cache->get('log.' . $this->config->get('config_language_id'));
			
			if (!$log_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "log p LEFT JOIN " . DB_PREFIX . "log_description pd ON (p.log_id = pd.log_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$log_data = $query->rows;
				
				$this->cache->set('log.' . $this->config->get('config_language_id'), $log_data);
			}	
			
			return $log_data;
		}
	}
	
	
	public function getTotallogs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "log ";
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}		
}
?>