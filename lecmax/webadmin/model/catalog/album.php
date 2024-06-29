<?php
class ModelCatalogAlbum extends Model {
	public function addAlbum($data,$copy=0) {
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

	          if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
		
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
			$this->db->query("UPDATE " . DB_PREFIX . "album SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "album SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$album_id = $this->db->getLastId();		
		
		foreach ($data['album_description'] as $language_id => $value) {
			$str_update = "";
			
			if(isset($value['pdf'])){
				$str_update .= "pdf ='".$value['pdf']."',";
			}
			if(isset($value['filepdf'])){
				$str_update .= "filepdf ='".$value['filepdf']."',";
			}
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "album_description SET 
			                 album_id = '" . (int)$album_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "album_image SET 
				album_id = '" . (int)$album_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		/*if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['album_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('album');
	}
	
	public function editAlbum($album_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

	          if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
		
		if(isset($data['category_id']))
			$str .= " category_id = '" . (int)$data['category_id'] . "',";
		
		
        /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "album SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE album_id = '" . (int)$album_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "album_description WHERE album_id = '" . (int)$album_id . "'");
		
		foreach ($data['album_description'] as $language_id => $value) {
			$str_update = "";
			
			if(isset($value['pdf'])){
				$str_update .= "pdf ='".$value['pdf']."',";
			}
			if(isset($value['filepdf'])){
				$str_update .= "filepdf ='".$value['filepdf']."',";
			}
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "album_description SET 
			                 album_id = '" . (int)$album_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "album_image WHERE album_id = '" . (int)$album_id . "'");
		if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "album_image SET 
				album_id = '" . (int)$album_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		/*$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$album_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['album_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/	
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('album');
	}
	
	public function copyAlbum($album_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.album_id = '" . (int)$album_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('album_description' => $this->getAlbumDescriptions($album_id)));			
			
						$data = array_merge($data, array('album_image' => $this->getAlbumImages($album_id)));
			
			$data['album_image'] = array();
			
			$results = $this->getAlbumImages($album_id);
			
			foreach ($results as $result) {
				$data['album_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addAlbum($data,1);
		}
	}

	public function deleteAlbum($album_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "album WHERE album_id = '" . (int)$album_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "album_description WHERE album_id = '" . (int)$album_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "album_image WHERE album_id = '" . (int)$album_id . "'");
        
        		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$album_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('album');
	}
	
		public function getalbumImages($album_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "album_image WHERE album_id = '" . (int)$album_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getAlbum($album_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$album_id . "') AS keyword FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.album_id = '" . (int)$album_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($album_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE p.album_id = '" . (int)$album_id . "'");
		
		return $query->rows;
	}
	
	public function getAlbums($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$album_data = $this->cache->get('album.' . $this->config->get('config_language_id'));
			
			if (!$album_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$album_data = $query->rows;
				
				$this->cache->set('album.' . $this->config->get('config_language_id'), $album_data);
			}	
			
			return $album_data;
		}
	}
	
	public function getAlbumDescriptions($album_id) {
		$album_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "album_description WHERE album_id = '" . (int)$album_id . "'");
		
		foreach ($query->rows as $result) {
			$album_description_data[$result['language_id']] = array(
					'name'             => $result['name'],
					
					'pdf'             => $result['pdf'],
					'filepdf'             => $result['filepdf'],
					
					'meta_title'     => $result['meta_title'],
					'meta_keyword'     => $result['meta_keyword'],
					'meta_description' => $result['meta_description'],
					'meta_title_og'     => $result['meta_title_og'],
					'meta_description_og' => $result['meta_description_og'],
					
					/*{MODEL_GET_DESCRIPTION}*/
					'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
					);
		}
		
		return $album_description_data;
	}
	
	public function getTotalAlbums($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "album p LEFT JOIN " . DB_PREFIX . "album_description pd ON (p.album_id = pd.album_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "album WHERE album_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "album_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND album_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>