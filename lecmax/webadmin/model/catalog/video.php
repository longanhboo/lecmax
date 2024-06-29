<?php
class ModelCatalogVideo extends Model {
	public function addVideo($data,$copy=0) {
		
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

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
		
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "video SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "video SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$video_id = $this->db->getLastId();		
		
		foreach ($data['video_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET 
			                 video_id = '" . (int)$video_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}	
		
		/*foreach ($data['video_keyword'] as $language_id => $value) {		
		
				if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['video_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}*/			
		
				/*if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['video_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/
        
        		//=========================VIDEO
		if (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "video SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE video_id = '" . (int)$video_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isyoutube = '0' WHERE video_id = '" . (int)$video_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET script = '" . $this->db->escape($data['script']) . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET script = '' WHERE video_id = '" . (int)$video_id . "'");
		
		if(isset($data['scripten']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET scripten = '" . $this->db->escape($data['scripten']) . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET scripten = '' WHERE video_id = '" . (int)$video_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isftp = '1' WHERE video_id = '" . (int)$video_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isftp = '0' WHERE video_id = '" . (int)$video_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('video');
	}
	
	public function editVideo($video_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

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
		
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "video SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE video_id = '" . (int)$video_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
		
		foreach ($data['video_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET 
			                 video_id = '" . (int)$video_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		/*$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id. "'");
		foreach ($data['video_keyword'] as $language_id => $value) {
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
		}else{
			$keyword = convertAlias($data['video_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
			
		}
		}*/
		
				/*$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['video_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/	
        
        		//=========================VIDEO  
        if(isset($data['delete_image_video']) && $data['delete_image_video']==1){
        	$this->db->query("UPDATE " . DB_PREFIX . "video SET image_video = '' WHERE video_id = '" . (int)$video_id . "'");
        }elseif (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "video SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE video_id = '" . (int)$video_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isyoutube = '0' WHERE video_id = '" . (int)$video_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET script = '" . $this->db->escape($data['script']) . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET script = '' WHERE video_id = '" . (int)$video_id . "'");
		
		if(isset($data['scripten']))
			$this->db->query("UPDATE " . DB_PREFIX . "video SET scripten = '" . $this->db->escape($data['scripten']) . "' WHERE video_id = '" . (int)$video_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "video SET scripten = '' WHERE video_id = '" . (int)$video_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isftp = '1' WHERE video_id = '" . (int)$video_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "video SET isftp = '0' WHERE video_id = '" . (int)$video_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "video SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE video_id = '" . (int)$video_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('video');
	}
	
	public function copyVideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.video_id = '" . (int)$video_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('video_description' => $this->getVideoDescriptions($video_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addVideo($data,1);
		}
	}

	public function deleteVideo($video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('video');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$id . "'");

		return $query->row;
	}
    
    /*{MODEL_GET_VIDEO}*/
	
	public function getVideo($video_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.video_id = '" . (int)$video_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($video_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.video_id = '" . (int)$video_id . "'");
		
		return $query->rows;
	}
	
	public function getVideos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$video_data = $this->cache->get('video.' . $this->config->get('config_language_id'));
			
			if (!$video_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$video_data = $query->rows;
				
				$this->cache->set('video.' . $this->config->get('config_language_id'), $video_data);
			}	
			
			return $video_data;
		}
	}
	
	public function getVideoDescriptions($video_id) {
		$video_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
		
		foreach ($query->rows as $result) {
			$video_description_data[$result['language_id']] = array(
			                                                                     'name'             => $result['name'],
			                                                                     				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
        'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
    
    /*{MODEL_GET_DESCRIPTION}*/
			                                                                     'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
			                                                                     );
		}
		
		return $video_description_data;
	}
	
	
	public function getTotalVideos($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
	
	public function getVideoKeyword($video_id) {
		$video_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");
		
		foreach ($query->rows as $result) {
			$video_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $video_description_data;
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "video_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND video_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
	
	//Lay tat ca
	public function getVideoForCache($category_id=0)	{
		$sql = "SELECT p.video_id, p.image, p.isyoutube, p.script, p.image_video, p.filename_mp4, pd.name FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.video_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['video_id'];
			$data['name'] = $row['name'];

			$data['href'] = HTTP_CATALOG . 'view-video.html?id='.$row['video_id'];
			$data['image'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_video']);
			$data['isyoutube'] = $row['isyoutube'];

			$data['script'] = html_entity_decode((string)$row['script']);
			$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?HTTP_DOWNLOAD.$row['filename_mp4']:'';

			$data1[] = $data;
		}

		return $data1;
	}
}
?>