<?php
class ModelCatalogNews extends Model {
	public function addNews($data,$copy=0) {
		
		
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
		
		if(isset($data['isamp']) && $data['isamp']==1){
			$str .= " isamp = '1',";
            if(isset($data['image_amp'])){
                $str .= " image_amp = '" . $this->db->escape($data['image_amp']) . "',";
            }
		}else{
			$str .= " isamp = '0',";
            $str .= " image_amp = '',";            
		}
		
		if(isset($data['isnew']) && $data['isnew']==1){
			$str .= " isnew = '1',";
		}else{
			$str .= " isnew = '0',";       
		}
		
		if(empty($data['date_insert']))
			$str .= " date_insert = NOW(),";
		else
			$str .= " date_insert = '" . date('Y-m-d H:i:s', strtotime($this->db->escape($data['date_insert']))) . "',";
		
                
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
			$this->db->query("UPDATE " . DB_PREFIX . "news SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$news_id = $this->db->getLastId();		
		
		foreach ($data['news_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "pdf ='".$value['pdf']."',";
			
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['desc_short'])) . "', ";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET 
			                 news_id = '" . (int)$news_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}		
		
		foreach ($data['news_keyword'] as $language_id => $value) {		
		
				if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['news_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}		
		
				/*if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['news_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('news');
	}
	
	public function editNews($news_id, $data) {
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
		
		if(isset($data['isamp']) && $data['isamp']==1){
			$str .= " isamp = '1',";
            if(isset($data['image_amp'])){
                $str .= " image_amp = '" . $this->db->escape($data['image_amp']) . "',";
            }
		}else{
			$str .= " isamp = '0',";
            $str .= " image_amp = '',";            
		}
		
		if(isset($data['isnew']) && $data['isnew']==1){
			$str .= " isnew = '1',";
		}else{
			$str .= " isnew = '0',";       
		}
		
		if(empty($data['date_insert']))
			$str .= " date_insert = NOW(),";
		else
			$str .= " date_insert = '" . date('Y-m-d H:i:s', strtotime($this->db->escape($data['date_insert']))) . "',";
		
                
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";

        				if(isset($data['category_id']))
					$str .= " category_id = '" . (int)$data['category_id'] . "',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "news SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE news_id = '" . (int)$news_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($data['news_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "pdf ='".$value['pdf']."',";
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['desc_short'])) . "', ";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET 
			                 news_id = '" . (int)$news_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		foreach ($data['news_keyword'] as $language_id => $value) {
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
		}else{
			$keyword = convertAlias($data['news_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
			
		}
		}
		
			/*	$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['news_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}	*/
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('news');
	}
	
	public function copyNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.news_id = '" . (int)$news_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('news_description' => $this->getNewsDescriptions($news_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addNews($data,1);
		}
	}

	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('news');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getNews($news_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.news_id = '" . (int)$news_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.news_id = '" . (int)$news_id . "'");
		
		return $query->rows;
	}
	
	public function getNewss($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
						if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
            }
			
			if (isset($data['filter_isamp']) && !is_null($data['filter_isamp'])) {
                $sql .= " AND p.isamp = '" . (int)$data['filter_isamp'] . "'";
            }
			
			if (isset($data['filter_isnew']) && !is_null($data['filter_isnew'])) {
                $sql .= " AND p.isnew = '" . (int)$data['filter_isnew'] . "'";
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
			$news_data = $this->cache->get('news.' . $this->config->get('config_language_id'));
			
			if (!$news_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$news_data = $query->rows;
				
				$this->cache->set('news.' . $this->config->get('config_language_id'), $news_data);
			}	
			
			return $news_data;
		}
	}
	
	public function getNewsDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'pdf'     => $result['pdf'],
				'desc_short'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['desc_short']),
				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
        		'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
    
    			/*{MODEL_GET_DESCRIPTION}*/
				'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
				);
		}
		
		return $news_description_data;
	}
	
	public function getTotalNewss($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
					if (isset($data['filter_ishome']) && !is_null($data['filter_ishome'])) {
                $sql .= " AND p.ishome = '" . (int)$data['filter_ishome'] . "'";
            }
			
			if (isset($data['filter_isamp']) && !is_null($data['filter_isamp'])) {
                $sql .= " AND p.isamp = '" . (int)$data['filter_isamp'] . "'";
            }
			
			if (isset($data['filter_isnew']) && !is_null($data['filter_isnew'])) {
                $sql .= " AND p.isnew = '" . (int)$data['filter_isnew'] . "'";
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
	
	public function getNewsKeyword($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $news_description_data;
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	
	public function getNewsByCate($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
		
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
	
	}
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "news_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND news_id='".(int)$cate."'");
		
		return $query->row['name'];
	}
	
	public function updateStatusByCate($category_id, $status=0) {
		$this->db->query("UPDATE " . DB_PREFIX . "news
		                 SET status = '" . (int)$status . "',
		                 date_modified = NOW()
		                 WHERE category_id = '" . (int)$category_id . "'");

		$this->cache->delete('news');
	}
	
	public function getNewsByCateFixed($category_id,$select="*",$order_by="ORDER BY t1.news_id DESC"){
		$sql = "SELECT {$select}
				FROM ".DB_PREFIX."news AS t1 LEFT JOIN ".DB_PREFIX."news_description AS t2 
				ON t1.news_id = t2.news_id 
				WHERE t1.status = 1 AND t2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t1.category_id = {$category_id}
				".$order_by."
				";
		$query = $this->db->query($sql);
		return $query->rows;   
	}
	
}
?>