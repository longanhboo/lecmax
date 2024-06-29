<?php
class ModelCatalogDocument extends Model {
	public function addDocument($data,$copy=0) {
		
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

        				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "document SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "document SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$document_id = $this->db->getLastId();		
		
		foreach ($data['document_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "document_description SET 
			                 document_id = '" . (int)$document_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['document_image'])) {
			foreach ($data['document_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "document_image SET 
				document_id = '" . (int)$document_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        foreach ($data['document_keyword'] as $language_id => $value) {		
		
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'document_id=" . (int)$document_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['document_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'document_id=" . (int)$document_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
        
        
        		//=========================VIDEO
		if (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "document SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE document_id = '" . (int)$document_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE document_id = '" . (int)$document_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isyoutube = '0' WHERE document_id = '" . (int)$document_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "document SET script = '" . $this->db->escape($data['script']) . "' WHERE document_id = '" . (int)$document_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "document SET script = '' WHERE document_id = '" . (int)$document_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isftp = '1' WHERE document_id = '" . (int)$document_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isftp = '0' WHERE document_id = '" . (int)$document_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('document');
	}
	
	public function editDocument($document_id, $data) {
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

        				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "document SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE document_id = '" . (int)$document_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "document_description WHERE document_id = '" . (int)$document_id . "'");
		
		foreach ($data['document_description'] as $language_id => $value) {
			$str_update = "";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "document_description SET 
			                 document_id = '" . (int)$document_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "document_image WHERE document_id = '" . (int)$document_id . "'");
		if (isset($data['document_image'])) {
			foreach ($data['document_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "document_image SET 
				document_id = '" . (int)$document_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'document_id=" . (int)$document_id. "'");
		foreach ($data['document_keyword'] as $language_id => $value) {
            if (!empty($value['keyword'])) {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
                
                if($query->num_rows==0)
                    $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'document_id=" . (int)$document_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
            }else{
                $keyword = convertAlias($data['document_description'][$language_id]['name']);
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
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'document_id=" . (int)$document_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
                
            }
		}
        
        		//=========================VIDEO  
        if(isset($data['delete_image_video']) && $data['delete_image_video']==1){
        	$this->db->query("UPDATE " . DB_PREFIX . "document SET image_video = '' WHERE document_id = '" . (int)$document_id . "'");
        }elseif (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "document SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE document_id = '" . (int)$document_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE document_id = '" . (int)$document_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isyoutube = '0' WHERE document_id = '" . (int)$document_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "document SET script = '" . $this->db->escape($data['script']) . "' WHERE document_id = '" . (int)$document_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "document SET script = '' WHERE document_id = '" . (int)$document_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isftp = '1' WHERE document_id = '" . (int)$document_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "document SET isftp = '0' WHERE document_id = '" . (int)$document_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "document SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE document_id = '" . (int)$document_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('document');
	}
	
	public function copyDocument($document_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE p.document_id = '" . (int)$document_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('document_description' => $this->getDocumentDescriptions($document_id)));			
			
						$data = array_merge($data, array('document_image' => $this->getDocumentImages($document_id)));
			
			$data['document_image'] = array();
			
			$results = $this->getDocumentImages($document_id);
			
			foreach ($results as $result) {
				$data['document_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addDocument($data,1);
		}
	}

	public function deleteDocument($document_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "document WHERE document_id = '" . (int)$document_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "document_description WHERE document_id = '" . (int)$document_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "document_image WHERE document_id = '" . (int)$document_id . "'");
        
        		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'document_id=" . (int)$document_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('document');
	}
	
		public function getdocumentImages($document_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "document_image WHERE document_id = '" . (int)$document_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "document WHERE document_id = '" . (int)$id . "'");

		return $query->row;
	}
    
    /*{MODEL_GET_VIDEO}*/
	
	public function getDocument($document_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'document_id=" . (int)$document_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE p.document_id = '" . (int)$document_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($document_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE p.document_id = '" . (int)$document_id . "'");
		
		return $query->rows;
	}
	
	public function getDocuments($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
						if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
            }
            
            			if (isset($data['cate']) && !is_null($data['cate'])) {
				$sql .= " AND p.cate = '" . (int)$data['cate'] . "'";
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
			$document_data = $this->cache->get('document.' . $this->config->get('config_language_id'));
			
			if (!$document_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$document_data = $query->rows;
				
				$this->cache->set('document.' . $this->config->get('config_language_id'), $document_data);
			}	
			
			return $document_data;
		}
	}
	
	public function getDocumentDescriptions($document_id) {
		$document_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "document_description WHERE document_id = '" . (int)$document_id . "'");
		
		foreach ($query->rows as $result) {
			$document_description_data[$result['language_id']] = array(
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
		
		return $document_description_data;
	}
	
	public function getDocumentKeyword($document_id) {
		$document_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'document_id=" . (int)$document_id . "'");
		
		foreach ($query->rows as $result) {
			$document_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $document_description_data;
	}
	
	public function getTotalDocuments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
					if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
            }
            
            			if (isset($data['cate']) && !is_null($data['cate'])) {
				$sql .= " AND p.cate = '" . (int)$data['cate'] . "'";
			}
            
            /*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "document WHERE document_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "document_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND document_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>