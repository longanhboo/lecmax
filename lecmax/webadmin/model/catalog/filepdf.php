<?php
class ModelCatalogFilepdf extends Model {
	public function addFilepdf($data,$copy=0) {
		
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['link']))
			$str .= " link = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$data['link'])) . "',";
		else
			$str .= " link = '',";
		
		if(isset($data['isnew']) && $data['isnew']==1){
			$str .= " isnew = '1',";
		}else{
			$str .= " isnew = '0',";       
		}
		

	      /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "filepdf SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "filepdf SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$filepdf_id = $this->db->getLastId();		
		
		foreach ($data['filepdf_description'] as $language_id => $value) {
			$str_update = "";
							$str_update .= "pdf ='".$value['pdf']."',";
							
							$str_update .= "linkpdf ='".$value['linkpdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "filepdf_description SET 
			                 filepdf_id = '" . (int)$filepdf_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('filepdf');
	}
	
	public function editFilepdf($filepdf_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		
		if(isset($data['link']))
			$str .= " link = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$data['link'])) . "',";
		else
			$str .= " link = '',";
		
		if(isset($data['isnew']) && $data['isnew']==1){
			$str .= " isnew = '1',";
		}else{
			$str .= " isnew = '0',";       
		}
		
		
		
	      /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "filepdf SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE filepdf_id = '" . (int)$filepdf_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "filepdf_description WHERE filepdf_id = '" . (int)$filepdf_id . "'");
		
		foreach ($data['filepdf_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "linkpdf ='".$value['linkpdf']."',";
							$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "filepdf_description SET 
			                 filepdf_id = '" . (int)$filepdf_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('filepdf');
	}
	
	public function copyFilepdf($filepdf_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.filepdf_id = '" . (int)$filepdf_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('filepdf_description' => $this->getFilepdfDescriptions($filepdf_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addFilepdf($data,1);
		}
	}

	public function deleteFilepdf($filepdf_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "filepdf WHERE filepdf_id = '" . (int)$filepdf_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "filepdf_description WHERE filepdf_id = '" . (int)$filepdf_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('filepdf');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getFilepdf($filepdf_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'filepdf_id=" . (int)$filepdf_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.filepdf_id = '" . (int)$filepdf_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($filepdf_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.filepdf_id = '" . (int)$filepdf_id . "'");
		
		return $query->rows;
	}
	
	public function getFilepdfs($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			if (isset($data['filter_isnew']) && !is_null($data['filter_isnew'])) {
                $sql .= " AND p.isnew = '" . (int)$data['filter_isnew'] . "'";
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
			$filepdf_data = $this->cache->get('filepdf.' . $this->config->get('config_language_id'));
			
			if (!$filepdf_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$filepdf_data = $query->rows;
				
				$this->cache->set('filepdf.' . $this->config->get('config_language_id'), $filepdf_data);
			}	
			
			return $filepdf_data;
		}
	}
	
	public function getFilepdfDescriptions($filepdf_id) {
		$filepdf_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filepdf_description WHERE filepdf_id = '" . (int)$filepdf_id . "'");
		
		foreach ($query->rows as $result) {
			$filepdf_description_data[$result['language_id']] = array(
					'name'             => $result['name'],
					'pdf'     => $result['pdf'],
					'linkpdf'     => $result['linkpdf'],
					
					/*{MODEL_GET_IMAGES}*/
					'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
					);
		}
		
		return $filepdf_description_data;
	}
	
	public function getFilepdfKeyword($filepdf_id) {
		$filepdf_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'filepdf_id=" . (int)$filepdf_id . "'");
		
		foreach ($query->rows as $result) {
			$filepdf_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $filepdf_description_data;
	}
	
	public function getTotalFilepdfs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		if (isset($data['filter_isnew']) && !is_null($data['filter_isnew'])) {
                $sql .= " AND p.isnew = '" . (int)$data['filter_isnew'] . "'";
            }
		
		/*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "filepdf WHERE filepdf_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "filepdf_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND filepdf_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>