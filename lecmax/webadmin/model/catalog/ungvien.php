<?php
class ModelCatalogUngvien extends Model {
	public function addUngvien($data,$copy=0) {
		$str = "";		
		/*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "ungvien SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "ungvien SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$ungvien_id = $this->db->getLastId();		
		
		foreach ($data['ungvien_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "ungvien_description SET 
			                 ungvien_id = '" . (int)$ungvien_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('ungvien');
	}
	
	public function editUngvien($ungvien_id, $data) {
		$str = "";				
		/*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "ungvien SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE ungvien_id = '" . (int)$ungvien_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ungvien_description WHERE ungvien_id = '" . (int)$ungvien_id . "'");
		
		foreach ($data['ungvien_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "ungvien_description SET 
			                 ungvien_id = '" . (int)$ungvien_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('ungvien');
	}
	
	public function copyUngvien($ungvien_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ungvien p LEFT JOIN " . DB_PREFIX . "ungvien_description pd ON (p.ungvien_id = pd.ungvien_id) WHERE p.ungvien_id = '" . (int)$ungvien_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('ungvien_description' => $this->getUngvienDescriptions($ungvien_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addUngvien($data,1);
		}
	}

	public function deleteUngvien($ungvien_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ungvien WHERE ungvien_id = '" . (int)$ungvien_id . "'");		
		//$this->db->query("DELETE FROM " . DB_PREFIX . "ungvien_description WHERE ungvien_id = '" . (int)$ungvien_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('ungvien');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getUngvien($ungvien_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'ungvien_id=" . (int)$ungvien_id . "') AS keyword FROM " . DB_PREFIX . "ungvien p LEFT JOIN " . DB_PREFIX . "ungvien_description pd ON (p.ungvien_id = pd.ungvien_id) WHERE p.ungvien_id = '" . (int)$ungvien_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($ungvien_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ungvien p LEFT JOIN " . DB_PREFIX . "ungvien_description pd ON (p.ungvien_id = pd.ungvien_id) WHERE p.ungvien_id = '" . (int)$ungvien_id . "'");
		
		return $query->rows;
	}
	
	public function getUngviens($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "ungvien p WHERE 1=1 "; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			if (isset($data['filter_address']) && !is_null($data['filter_address'])) {
				$filter_address = mb_strtolower($this->db->escape($data['filter_address']),'utf8');
				$sql .= " AND (LOWER(CONVERT(p.address USING utf8)) LIKE '%$filter_address%' OR LOWER(CONVERT(p.city USING utf8)) LIKE '%$filter_address%' OR LOWER(CONVERT(p.district USING utf8)) LIKE '%$filter_address%') ";
			}
			
			if (isset($data['filter_company']) && !is_null($data['filter_company'])) {
				$filter_company = mb_strtolower($this->db->escape($data['filter_company']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.company USING utf8)) LIKE '%$filter_company%'";
			}
			
			if (isset($data['filter_cmnd']) && !is_null($data['filter_cmnd'])) {
				$filter_cmnd = mb_strtolower($this->db->escape($data['filter_cmnd']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.cmnd USING utf8)) LIKE '%$filter_cmnd%'";
			}
			
			if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
				$filter_email = mb_strtolower($this->db->escape($data['filter_email']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.email USING utf8)) LIKE '%$filter_email%'";
			}
			
			if (isset($data['filter_comment']) && !is_null($data['filter_comment'])) {
				$filter_comment = mb_strtolower($this->db->escape($data['filter_comment']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.comment USING utf8)) LIKE '%$filter_comment%'";
			}
			
			if (isset($data['filter_phone']) && !is_null($data['filter_phone'])) {
				$filter_phone = mb_strtolower($this->db->escape($data['filter_phone']),'utf8');
				$sql .= " AND LOWER(CONVERT(p.phone USING utf8)) LIKE '%$filter_phone%'";
			}
			
			if (isset($data['filter_date_start']) && !is_null($data['filter_date_start']) && isset($data['filter_date_end']) && !is_null($data['filter_date_end'])) {
				$sql .= " AND p.date_added >= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_start']))) . ' 00:00:00' . "' AND p.date_added <=  '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_end']))) . ' 23:59:59' . "'";
			}elseif (isset($data['filter_date_start']) && !is_null($data['filter_date_start'])) {
				$sql .= " AND p.date_added >= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_start']))) . ' 00:00:00' . "'";
			}elseif (isset($data['filter_date_end']) && !is_null($data['filter_date_end'])) {
				$sql .= " AND p.date_added <= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_end']))) . ' 23:59:59' . "'";
			}
			
			if (isset($data['filter_is_mail']) && !is_null($data['filter_is_mail'])) {
				$sql .= " AND p.is_mail = '" . (int)$data['filter_is_mail'] . "'";
			}
			
			/*{MODEL_FILTER}*/
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
			                   'p.name',				
			                   'p.status',
			                   'p.sort_order'
			                   );	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY p.name";	
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
		} else {
			$ungvien_data = $this->cache->get('ungvien.' . $this->config->get('config_language_id'));
			
			if (!$ungvien_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ungvien p  WHERE 1=1 ORDER BY p.name ASC");
				
				$ungvien_data = $query->rows;
				
				$this->cache->set('ungvien.' . $this->config->get('config_language_id'), $ungvien_data);
			}	
			
			return $ungvien_data;
		}
	}
	
	public function getUngvienDescriptions($ungvien_id) {
		$ungvien_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ungvien_description WHERE ungvien_id = '" . (int)$ungvien_id . "'");
		
		foreach ($query->rows as $result) {
			$ungvien_description_data[$result['language_id']] = array(
			                                                                     'name'             => $result['name'],
			                                                                     /*{MODEL_GET_DESCRIPTION}*/
			                                                                     'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
			                                                                     );
		}
		
		return $ungvien_description_data;
	}
	
	public function getTotalUngviens($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ungvien p  WHERE 1=1 ";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		if (isset($data['filter_cmnd']) && !is_null($data['filter_cmnd'])) {
			$filter_cmnd = mb_strtolower($this->db->escape($data['filter_cmnd']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.cmnd USING utf8)) LIKE '%$filter_cmnd%'";
		}
		
		if (isset($data['filter_address']) && !is_null($data['filter_address'])) {
			$filter_address = mb_strtolower($this->db->escape($data['filter_address']),'utf8');
			//$sql .= " AND LOWER(CONVERT(p.address USING utf8)) LIKE '%$filter_address%'";
			$sql .= " AND (LOWER(CONVERT(p.address USING utf8)) LIKE '%$filter_address%' OR LOWER(CONVERT(p.city USING utf8)) LIKE '%$filter_address%' OR LOWER(CONVERT(p.district USING utf8)) LIKE '%$filter_address%') ";
		}
		
		if (isset($data['filter_company']) && !is_null($data['filter_company'])) {
			$filter_company = mb_strtolower($this->db->escape($data['filter_company']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.company USING utf8)) LIKE '%$filter_company%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$filter_email = mb_strtolower($this->db->escape($data['filter_email']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.email USING utf8)) LIKE '%$filter_email%'";
		}
		
		if (isset($data['filter_comment']) && !is_null($data['filter_comment'])) {
			$filter_comment = mb_strtolower($this->db->escape($data['filter_comment']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.comment USING utf8)) LIKE '%$filter_comment%'";
		}
		
		if (isset($data['filter_phone']) && !is_null($data['filter_phone'])) {
			$filter_phone = mb_strtolower($this->db->escape($data['filter_phone']),'utf8');
			$sql .= " AND LOWER(CONVERT(p.phone USING utf8)) LIKE '%$filter_phone%'";
		}
		
		if (isset($data['filter_date_start']) && !is_null($data['filter_date_start']) && isset($data['filter_date_end']) && !is_null($data['filter_date_end'])) {
			$sql .= " AND p.date_added >= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_start']))) . ' 00:00:00' . "' AND p.date_added <=  '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_end']))) . ' 23:59:59' . "'";
		}elseif (isset($data['filter_date_start']) && !is_null($data['filter_date_start'])) {
			$sql .= " AND p.date_added >= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_start']))) . ' 00:00:00' . "'";
		}elseif (isset($data['filter_date_end']) && !is_null($data['filter_date_end'])) {
			$sql .= " AND p.date_added <= '" . date('Y-m-d', strtotime($this->db->escape($data['filter_date_end']))) . ' 23:59:59' . "'";
		}
		
		if (isset($data['filter_is_mail']) && !is_null($data['filter_is_mail'])) {
			$sql .= " AND p.is_mail = '" . (int)$data['filter_is_mail'] . "'";
		}
		
		/*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "ungvien WHERE ungvien_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "ungvien_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND ungvien_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>