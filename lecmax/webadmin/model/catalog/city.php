<?php
class ModelCatalogCity extends Model {
	public function addCity($data,$copy=0) {
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
			$this->db->query("UPDATE " . DB_PREFIX . "city SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "city SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$city_id = $this->db->getLastId();		
		
		foreach ($data['city_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "city_description SET 
			                 city_id = '" . (int)$city_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('city');
	}
	
	public function editCity($city_id, $data) {
		$str = "";				
		/*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "city SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE city_id = '" . (int)$city_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
		
		foreach ($data['city_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "city_description SET 
			                 city_id = '" . (int)$city_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('city');
	}
	
	public function copyCity($city_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.city_id = '" . (int)$city_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('city_description' => $this->getCityDescriptions($city_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addCity($data,1);
		}
	}

	public function deleteCity($city_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$city_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('city');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getCity($city_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'city_id=" . (int)$city_id . "') AS keyword FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.city_id = '" . (int)$city_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($city_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.city_id = '" . (int)$city_id . "'");
		
		return $query->rows;
	}
	
	public function getCitys($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			/*{MODEL_FILTER}*/
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
			                   'pd.name',				
			                   'p.status',
			                   'p.sort_order'
			                   );	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY pd.name";	
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
			$city_data = $this->cache->get('city.' . $this->config->get('config_language_id'));
			
			if (!$city_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$city_data = $query->rows;
				
				$this->cache->set('city.' . $this->config->get('config_language_id'), $city_data);
			}	
			
			return $city_data;
		}
	}
	
	public function getCityDescriptions($city_id) {
		$city_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city_description WHERE city_id = '" . (int)$city_id . "'");
		
		foreach ($query->rows as $result) {
			$city_description_data[$result['language_id']] = array(
			                                                                     'name'             => $result['name'],
			                                                                     /*{MODEL_GET_DESCRIPTION}*/
			                                                                     'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
			                                                                     );
		}
		
		return $city_description_data;
	}
	
	public function getTotalCitys($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		/*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "city_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND city_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>