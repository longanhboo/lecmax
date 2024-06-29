<?php
class ModelCatalogProject extends Model {
	public function addProject($data,$copy=0) {
		
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
			$this->db->query("UPDATE " . DB_PREFIX . "project SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$project_id = $this->db->getLastId();		
		
		foreach ($data['project_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
			                 project_id = '" . (int)$project_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['project_image'])) {
			foreach ($data['project_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "project_image SET 
				project_id = '" . (int)$project_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		if (isset($data['project_imagepro'])) {
			foreach ($data['project_imagepro'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "project_imagepro SET 
				project_id = '" . (int)$project_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        foreach ($data['project_keyword'] as $language_id => $value) {		
		
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'project_id=" . (int)$project_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['project_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'project_id=" . (int)$project_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
        
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('project');
	}
	
	public function editProject($project_id, $data) {
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
		$this->db->query("UPDATE " . DB_PREFIX . "project SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE project_id = '" . (int)$project_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
		
		foreach ($data['project_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "project_description SET 
			                 project_id = '" . (int)$project_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "project_image WHERE project_id = '" . (int)$project_id . "'");
		if (isset($data['project_image'])) {
			foreach ($data['project_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "project_image SET 
				project_id = '" . (int)$project_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "project_imagepro WHERE project_id = '" . (int)$project_id . "'");
		if (isset($data['project_imagepro'])) {
			foreach ($data['project_imagepro'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "project_imagepro SET 
				project_id = '" . (int)$project_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id. "'");
		foreach ($data['project_keyword'] as $language_id => $value) {
            if (!empty($value['keyword'])) {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
                
                if($query->num_rows==0)
                    $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'project_id=" . (int)$project_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
            }else{
                $keyword = convertAlias($data['project_description'][$language_id]['name']);
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
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'project_id=" . (int)$project_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
                
            }
		}
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('project');
	}
	
	public function copyProject($project_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.project_id = '" . (int)$project_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('project_description' => $this->getProjectDescriptions($project_id)));			
			
						$data = array_merge($data, array('project_image' => $this->getProjectImages($project_id)));
			
			$data['project_image'] = array();
			
			$results = $this->getProjectImages($project_id);
			
			foreach ($results as $result) {
				$data['project_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
			
			$data = array_merge($data, array('project_imagepro' => $this->getProjectImagepros($project_id)));
			$data['project_imagepro'] = array();
			$results = $this->getProjectImagepros($project_id);
			foreach ($results as $result) {
				$data['project_imagepro'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addProject($data,1);
		}
	}

	public function deleteProject($project_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "project_image WHERE project_id = '" . (int)$project_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "project_imagepro WHERE project_id = '" . (int)$project_id . "'");
        
        		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('project');
	}
	
		public function getprojectImages($project_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_image WHERE project_id = '" . (int)$project_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function getprojectImagepros($project_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_imagepro WHERE project_id = '" . (int)$project_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getProject($project_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.project_id = '" . (int)$project_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($project_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.project_id = '" . (int)$project_id . "'");
		
		return $query->rows;
	}
	
	public function getProjects($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$project_data = $this->cache->get('project.' . $this->config->get('config_language_id'));
			
			if (!$project_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$project_data = $query->rows;
				
				$this->cache->set('project.' . $this->config->get('config_language_id'), $project_data);
			}	
			
			return $project_data;
		}
	}
	
	public function getProjectDescriptions($project_id) {
		$project_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project_description WHERE project_id = '" . (int)$project_id . "'");
		
		foreach ($query->rows as $result) {
			$project_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'name1'             => $result['name1'],
				
				'address'             => $result['address'],
				
				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
				
				/*{MODEL_GET_DESCRIPTION}*/
				'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
				);
		}
		
		return $project_description_data;
	}
	
	public function getProjectKeyword($project_id) {
		$project_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'project_id=" . (int)$project_id . "'");
		
		foreach ($query->rows as $result) {
			$project_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $project_description_data;
	}
	
	public function getTotalProjects($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "project_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND project_id='".(int)$cate."'");
		
		return $query->row['name'];
	}	
	
	public function getProjectsChild($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE  p.cate<>'0' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$project_data = $this->cache->get('project.' . $this->config->get('config_language_id'));
			
			if (!$project_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$project_data = $query->rows;
				
				$this->cache->set('project.' . $this->config->get('config_language_id'), $project_data);
			}	
			
			return $project_data;
		}
	}		
}
?>