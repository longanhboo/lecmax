<?php
class ModelCatalogRecruitment extends Model {
	public function addRecruitment($data,$copy=0) {
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
		
		if(isset($data['tinhtrang']) && $data['tinhtrang']==1){
			$str .= " tinhtrang = '1',";
		}else{
			$str .= " tinhtrang = '0',";
		}
		
		if(isset($data['soluong'])){
			$str .= " soluong = '" . $this->db->escape($data['soluong']) . "',";
		}else{
			$str .= " soluong = '',";
		}
		
		if(empty($data['date_insert']))
			$str .= " date_insert = NOW(),";
		else
			$str .= " date_insert = '" . date('Y-m-d H:i:s', strtotime($this->db->escape($data['date_insert']))) . "',";
		
                
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
			$this->db->query("UPDATE " . DB_PREFIX . "recruitment SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "recruitment SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$recruitment_id = $this->db->getLastId();		
		
		foreach ($data['recruitment_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "diadiem = '" . $this->db->escape($value['diadiem']) . "', ";
			 
			 
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
								$str_update .= "`link` ='".str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['link'])."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "recruitment_description SET 
			                 recruitment_id = '" . (int)$recruitment_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				
        foreach ($data['recruitment_keyword'] as $language_id => $value) {		
		
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'recruitment_id=" . (int)$recruitment_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['recruitment_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'recruitment_id=" . (int)$recruitment_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
        
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('recruitment');
	}
	
	public function editRecruitment($recruitment_id, $data) {
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
		
		if(isset($data['tinhtrang']) && $data['tinhtrang']==1){
			$str .= " tinhtrang = '1',";
		}else{
			$str .= " tinhtrang = '0',";
		}
		
		if(isset($data['soluong'])){
			$str .= " soluong = '" . $this->db->escape($data['soluong']) . "',";
		}else{
			$str .= " soluong = '',";
		}
		
		if(empty($data['date_insert']))
			$str .= " date_insert = NOW(),";
		else
			$str .= " date_insert = '" . date('Y-m-d H:i:s', strtotime($this->db->escape($data['date_insert']))) . "',";
		
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "recruitment SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE recruitment_id = '" . (int)$recruitment_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "recruitment_description WHERE recruitment_id = '" . (int)$recruitment_id . "'");
		
		foreach ($data['recruitment_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "diadiem = '" . $this->db->escape($value['diadiem']) . "', ";
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
								$str_update .= "`link` ='".str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['link'])."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "recruitment_description SET 
			                 recruitment_id = '" . (int)$recruitment_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'recruitment_id=" . (int)$recruitment_id. "'");
		foreach ($data['recruitment_keyword'] as $language_id => $value) {
            if (!empty($value['keyword'])) {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
                
                if($query->num_rows==0)
                    $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'recruitment_id=" . (int)$recruitment_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
            }else{
                $keyword = convertAlias($data['recruitment_description'][$language_id]['name']);
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
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'recruitment_id=" . (int)$recruitment_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
                
            }
		}
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('recruitment');
	}
	
	public function copyRecruitment($recruitment_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.recruitment_id = '" . (int)$recruitment_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('recruitment_description' => $this->getRecruitmentDescriptions($recruitment_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addRecruitment($data,1);
		}
	}

	public function deleteRecruitment($recruitment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "recruitment WHERE recruitment_id = '" . (int)$recruitment_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "recruitment_description WHERE recruitment_id = '" . (int)$recruitment_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'recruitment_id=" . (int)$recruitment_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('recruitment');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getRecruitment($recruitment_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'recruitment_id=" . (int)$recruitment_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.recruitment_id = '" . (int)$recruitment_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($recruitment_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.recruitment_id = '" . (int)$recruitment_id . "'");
		
		return $query->rows;
	}
	
	public function getRecruitments($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$recruitment_data = $this->cache->get('recruitment.' . $this->config->get('config_language_id'));
			
			if (!$recruitment_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$recruitment_data = $query->rows;
				
				$this->cache->set('recruitment.' . $this->config->get('config_language_id'), $recruitment_data);
			}	
			
			return $recruitment_data;
		}
	}
	
	public function getRecruitmentDescriptions($recruitment_id) {
		$recruitment_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recruitment_description WHERE recruitment_id = '" . (int)$recruitment_id . "'");
		
		foreach ($query->rows as $result) {
			$recruitment_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				
				'diadiem'             => $result['diadiem'],
				'link'             => str_replace('HTTP_CATALOG',HTTP_CATALOG,(string)$result['link']),
				
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
		
		return $recruitment_description_data;
	}
	
	public function getRecruitmentKeyword($recruitment_id) {
		$recruitment_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'recruitment_id=" . (int)$recruitment_id . "'");
		
		foreach ($query->rows as $result) {
			$recruitment_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $recruitment_description_data;
	}
	
	public function getTotalRecruitments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "recruitment WHERE recruitment_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "recruitment_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND recruitment_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>