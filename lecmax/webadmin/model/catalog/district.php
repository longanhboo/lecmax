<?php
class ModelCatalogDistrict extends Model {
	public function addDistrict($data,$copy=0) {
		$str = "";		
		/*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		if(isset($data['category_id']))
			$str .= " category_id = '" . (int)$data['category_id'] . "',";
			
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "district SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "district SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$district_id = $this->db->getLastId();		
		
		foreach ($data['district_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "district_description SET 
			                 district_id = '" . (int)$district_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('district');
	}
	
	public function editDistrict($district_id, $data) {
		$str = "";	
		
		if(isset($data['category_id']))
			$str .= " category_id = '" . (int)$data['category_id'] . "',";
					
		/*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "district SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE district_id = '" . (int)$district_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "district_description WHERE district_id = '" . (int)$district_id . "'");
		
		foreach ($data['district_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "district_description SET 
			                 district_id = '" . (int)$district_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('district');
	}
	
	public function copyDistrict($district_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.district_id = '" . (int)$district_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('district_description' => $this->getDistrictDescriptions($district_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addDistrict($data,1);
		}
	}

	public function deleteDistrict($district_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "district WHERE district_id = '" . (int)$district_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "district_description WHERE district_id = '" . (int)$district_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('district');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getDistrict($district_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'district_id=" . (int)$district_id . "') AS keyword FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.district_id = '" . (int)$district_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getDistrictByCity($city_id){
		$sql = "SELECT p.district_id as district_id, name FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id ='" .(int)$city_id. "' ORDER BY p.sort_order ASC"; 						
			
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getPdf($district_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.district_id = '" . (int)$district_id . "'");
		
		return $query->rows;
	}
	
	public function getDistricts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
                $sql .= " AND p.category_id = '" . (int)$data['filter_category'] . "'";
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
			$district_data = $this->cache->get('district.' . $this->config->get('config_language_id'));
			
			if (!$district_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$district_data = $query->rows;
				
				$this->cache->set('district.' . $this->config->get('config_language_id'), $district_data);
			}	
			
			return $district_data;
		}
	}
	
	public function getDistrictDescriptions($district_id) {
		$district_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "district_description WHERE district_id = '" . (int)$district_id . "'");
		
		foreach ($query->rows as $result) {
			$district_description_data[$result['language_id']] = array(
			                                                                     'name'             => $result['name'],
			                                                                     /*{MODEL_GET_DESCRIPTION}*/
			                                                                     'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
			                                                                     );
		}
		
		return $district_description_data;
	}
	
	public function getTotalDistricts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
			$sql .= " AND p.category_id = '" . (int)$data['filter_category'] . "'";
		}
		
		/*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "district WHERE district_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "district_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND district_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>