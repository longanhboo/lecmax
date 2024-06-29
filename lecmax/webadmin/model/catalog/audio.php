<?php
class ModelCatalogAudio extends Model {
	public function addAudio($data,$copy=0) {
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

	      		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
            
        		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        				if(isset($data['category_id']))
					$str .= " category_id = '" . (int)$data['category_id'] . "',";
                              
                /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "audio SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "audio SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$audio_id = $this->db->getLastId();		
		
		foreach ($data['audio_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "audio_description SET 
			                 audio_id = '" . (int)$audio_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'audio_id=" . (int)$audio_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['audio_description'][$this->config->get('config_language_id')]['name']);
			$keyword_tmp = $keyword;
			$i=0;
			$flag=0;
			
			while($flag!=1)
			{
				$kq = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $keyword_tmp . "'");
				if($kq->num_rows>0)
				{
					$i++;
					$keyword_tmp = $keyword .'-' . $i;
				}else
				{
					$flag=1;
				}
				
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'audio_id=" . (int)$audio_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}
        
        /*{MODEL_INSERT}*/
		
		if (isset($data['audio_mp3'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "audio SET filename_mp3 = '" . $this->db->escape($data['audio_mp3']) . "' WHERE audio_id = '" . (int)$audio_id . "'");
		}
		
		$this->cache->delete('audio');
	}
	
	public function editAudio($audio_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

	      		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
            
        		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        				if(isset($data['category_id']))
					$str .= " category_id = '" . (int)$data['category_id'] . "',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "audio SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE audio_id = '" . (int)$audio_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "audio_description WHERE audio_id = '" . (int)$audio_id . "'");
		
		foreach ($data['audio_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "audio_description SET 
			                 audio_id = '" . (int)$audio_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'audio_id=" . (int)$audio_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'audio_id=" . (int)$audio_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['audio_description'][$this->config->get('config_language_id')]['name']);
			$keyword_tmp = $keyword;
			$i=0;
			$flag=0;
			
			while($flag!=1)
			{
				$kq = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $keyword_tmp . "'");
				if($kq->num_rows>0)
				{
					$i++;
					$keyword_tmp = $keyword .'-' . $i;
				}else
				{
					$flag=1;
				}
				
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'audio_id=" . (int)$audio_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}	
        
        /*{MODEL_UPDATE}*/
		
		if (isset($data['audio_mp3'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "audio SET filename_mp3 = '" . $this->db->escape($data['audio_mp3']) . "' WHERE audio_id = '" . (int)$audio_id . "'");
		}
		
		$this->cache->delete('audio');
	}
	
	public function copyAudio($audio_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.audio_id = '" . (int)$audio_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('audio_description' => $this->getAudioDescriptions($audio_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addAudio($data,1);
		}
	}

	public function deleteAudio($audio_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "audio WHERE audio_id = '" . (int)$audio_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "audio_description WHERE audio_id = '" . (int)$audio_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'audio_id=" . (int)$audio_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('audio');
	}
	
	public function getAudioById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "audio WHERE audio_id = '" . (int)$id . "'");

		return $query->row;
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getAudio($audio_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'audio_id=" . (int)$audio_id . "') AS keyword FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.audio_id = '" . (int)$audio_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($audio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.audio_id = '" . (int)$audio_id . "'");
		
		return $query->rows;
	}
	
	public function getAudios($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
						if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
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
			$audio_data = $this->cache->get('audio.' . $this->config->get('config_language_id'));
			
			if (!$audio_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$audio_data = $query->rows;
				
				$this->cache->set('audio.' . $this->config->get('config_language_id'), $audio_data);
			}	
			
			return $audio_data;
		}
	}
	
	public function getAudioDescriptions($audio_id) {
		$audio_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "audio_description WHERE audio_id = '" . (int)$audio_id . "'");
		
		foreach ($query->rows as $result) {
			$audio_description_data[$result['language_id']] = array(
			                                                                     'name'             => $result['name'],
			                                                                     				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
        'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
    
    				'pdf'     => $result['pdf'],
    
    /*{MODEL_GET_IMAGES}*/
			                                                                     'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
			                                                                     );
		}
		
		return $audio_description_data;
	}
	
	public function getTotalAudios($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
					if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "audio WHERE audio_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "audio_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND audio_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>