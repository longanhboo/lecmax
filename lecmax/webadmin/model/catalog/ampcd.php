<?php
class ModelCatalogAmpcd extends Model {
	public function addAmpcd($data,$copy=0) {
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

		
		if(isset($data['image_1x']))
			$str .= " image_1x = '" . $this->db->escape($data['image_1x']) . "',";
		else
			$str .= " image_1x = '',";
		
	      		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
            
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		if (isset($data['pagelist']) && !empty($data['pagelist']))
			$str .= " pagelist = '" . serialize($data['pagelist']) . "',";
		else
			$str .= " pagelist = '',";
		
		/*if (isset($data['pagelistcodong']) && !empty($data['pagelistcodong']))
			$str .= " pagelistcodong = '" . serialize($data['pagelistcodong']) . "',";
		else
			$str .= " pagelistcodong = '',";
		*/
		
		if (isset($data['pagelistproject']) && !empty($data['pagelistproject']))
			$str .= " pagelistproject = '" . serialize($data['pagelistproject']) . "',";
		else
			$str .= " pagelistproject = '',";
		
		if (isset($data['pagelistsolution']) && !empty($data['pagelistsolution']))
			$str .= " pagelistsolution = '" . serialize($data['pagelistsolution']) . "',";
		else
			$str .= " pagelistsolution = '',";
		
		if (isset($data['pagelistservice']) && !empty($data['pagelistservice']))
			$str .= " pagelistservice = '" . serialize($data['pagelistservice']) . "',";
		else
			$str .= " pagelistservice = '',";
		
		
		/*if (isset($data['pagelistlistpartner']) && !empty($data['pagelistlistpartner']))
			$str .= " pagelistlistpartner = '" . serialize($data['pagelistlistpartner']) . "',";
		else
			$str .= " pagelistlistpartner = '',";
		*/
		
		if (isset($data['pagelistrecruitment']) && !empty($data['pagelistrecruitment']))
			$str .= " pagelistrecruitment = '" . serialize($data['pagelistrecruitment']) . "',";
		else
			$str .= " pagelistrecruitment = '',";
		
		
		
		/*if (isset($data['pagelistbusiness']) && !empty($data['pagelistbusiness']))
			$str .= " pagelistbusiness = '" . serialize($data['pagelistbusiness']) . "',";
		else
			$str .= " pagelistbusiness = '',";
		*/
		
		/*if (isset($data['pagelistbrand']) && !empty($data['pagelistbrand']))
			$str .= " pagelistbrand = '" . serialize($data['pagelistbrand']) . "',";
		else
			$str .= " pagelistbrand = '',";
		*/
		
		/*if (isset($data['pagelistshowroom']) && !empty($data['pagelistshowroom']))
			$str .= " pagelistshowroom = '" . serialize($data['pagelistshowroom']) . "',";
		else
			$str .= " pagelistshowroom = '',";
		*/
		
		if (isset($data['pagelistproduct']) && !empty($data['pagelistproduct']))
			$str .= " pagelistproduct = '" . serialize($data['pagelistproduct']) . "',";
		else
			$str .= " pagelistproduct = '',";
		
		
		if (isset($data['pagelistaboutus']) && !empty($data['pagelistaboutus']))
			$str .= " pagelistaboutus = '" . serialize($data['pagelistaboutus']) . "',";
		else
			$str .= " pagelistaboutus = '',";
		
		if (isset($data['pagelistcontact']) && !empty($data['pagelistcontact']))
			$str .= " pagelistcontact = '" . serialize($data['pagelistcontact']) . "',";
		else
			$str .= " pagelistcontact = '',";
		
		if (isset($data['pagelistnews']) && !empty($data['pagelistnews']))
			$str .= " pagelistnews = '" . serialize($data['pagelistnews']) . "',";
		else
			$str .= " pagelistnews = '',";
		
		
        /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "ampcd SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "ampcd SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$ampcd_id = $this->db->getLastId();		
		
		foreach ($data['ampcd_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "description1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['description1'])) . "', ";
			
			$str_update .= "name1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name1'])) . "', ";
			$str_update .= "name2 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name2'])) . "', ";
			$str_update .= "name3 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name3'])) . "', ";
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['desc_short'])) . "', ";
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "ampcd_description SET 
			                 ampcd_id = '" . (int)$ampcd_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['description']))  . "'");
		}				
		
				if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ampcd_id=" . (int)$ampcd_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['ampcd_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ampcd_id=" . (int)$ampcd_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('ampcd');
	}
	
	public function editAmpcd($ampcd_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";

		if(isset($data['image_1x']))
			$str .= " image_1x = '" . $this->db->escape($data['image_1x']) . "',";
		else
			$str .= " image_1x = '',";
		
		
	      		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
            
            if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		
		if (isset($data['pagelist']) && !empty($data['pagelist']))
			$str .= " pagelist = '" . serialize($data['pagelist']) . "',";
		else
			$str .= " pagelist = '',";
		
		/*if (isset($data['pagelistcodong']) && !empty($data['pagelistcodong']))
			$str .= " pagelistcodong = '" . serialize($data['pagelistcodong']) . "',";
		else
			$str .= " pagelistcodong = '',";
		*/
		if (isset($data['pagelistproject']) && !empty($data['pagelistproject']))
			$str .= " pagelistproject = '" . serialize($data['pagelistproject']) . "',";
		else
			$str .= " pagelistproject = '',";
		
		if (isset($data['pagelistsolution']) && !empty($data['pagelistsolution']))
			$str .= " pagelistsolution = '" . serialize($data['pagelistsolution']) . "',";
		else
			$str .= " pagelistsolution = '',";
		
		
		if (isset($data['pagelistservice']) && !empty($data['pagelistservice']))
			$str .= " pagelistservice = '" . serialize($data['pagelistservice']) . "',";
		else
			$str .= " pagelistservice = '',";
		
		
		
		/*if (isset($data['pagelistlistpartner']) && !empty($data['pagelistlistpartner']))
			$str .= " pagelistlistpartner = '" . serialize($data['pagelistlistpartner']) . "',";
		else
			$str .= " pagelistlistpartner = '',";
		*/
		if (isset($data['pagelistrecruitment']) && !empty($data['pagelistrecruitment']))
			$str .= " pagelistrecruitment = '" . serialize($data['pagelistrecruitment']) . "',";
		else
			$str .= " pagelistrecruitment = '',";
		
		
		if (isset($data['pagelistnews']) && !empty($data['pagelistnews']))
			$str .= " pagelistnews = '" . serialize($data['pagelistnews']) . "',";
		else
			$str .= " pagelistnews = '',";
		
		
		/*if (isset($data['pagelistbusiness']) && !empty($data['pagelistbusiness']))
			$str .= " pagelistbusiness = '" . serialize($data['pagelistbusiness']) . "',";
		else
			$str .= " pagelistbusiness = '',";
		*/
		
		/*if (isset($data['pagelistbrand']) && !empty($data['pagelistbrand']))
			$str .= " pagelistbrand = '" . serialize($data['pagelistbrand']) . "',";
		else
			$str .= " pagelistbrand = '',";
		*/
		
		/*if (isset($data['pagelistshowroom']) && !empty($data['pagelistshowroom']))
			$str .= " pagelistshowroom = '" . serialize($data['pagelistshowroom']) . "',";
		else
			$str .= " pagelistshowroom = '',";
		*/
		
		if (isset($data['pagelistproduct']) && !empty($data['pagelistproduct']))
			$str .= " pagelistproduct = '" . serialize($data['pagelistproduct']) . "',";
		else
			$str .= " pagelistproduct = '',";
		
		if (isset($data['pagelistaboutus']) && !empty($data['pagelistaboutus']))
			$str .= " pagelistaboutus = '" . serialize($data['pagelistaboutus']) . "',";
		else
			$str .= " pagelistaboutus = '',";
		
		if (isset($data['pagelistcontact']) && !empty($data['pagelistcontact']))
			$str .= " pagelistcontact = '" . serialize($data['pagelistcontact']) . "',";
		else
			$str .= " pagelistcontact = '',";
		
		
		
        /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "ampcd SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE ampcd_id = '" . (int)$ampcd_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ampcd_description WHERE ampcd_id = '" . (int)$ampcd_id . "'");
		
		foreach ($data['ampcd_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "description1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['description1'])) . "', ";
			
			$str_update .= "name1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name1'])) . "', ";
			$str_update .= "name2 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name2'])) . "', ";
			$str_update .= "name3 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['name3'])) . "', ";
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['desc_short'])) . "', ";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "ampcd_description SET 
			                 ampcd_id = '" . (int)$ampcd_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', $value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'ampcd_id=" . (int)$ampcd_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ampcd_id=" . (int)$ampcd_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['ampcd_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ampcd_id=" . (int)$ampcd_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}	
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('ampcd');
	}
	
	public function copyAmpcd($ampcd_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE p.ampcd_id = '" . (int)$ampcd_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('ampcd_description' => $this->getAmpcdDescriptions($ampcd_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addAmpcd($data,1);
		}
	}

	public function deleteAmpcd($ampcd_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ampcd WHERE ampcd_id = '" . (int)$ampcd_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ampcd_description WHERE ampcd_id = '" . (int)$ampcd_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'ampcd_id=" . (int)$ampcd_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('ampcd');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getAmpcd($ampcd_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'ampcd_id=" . (int)$ampcd_id . "') AS keyword FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE p.ampcd_id = '" . (int)$ampcd_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($ampcd_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE p.ampcd_id = '" . (int)$ampcd_id . "'");
		
		return $query->rows;
	}
	
	public function getAmpcds($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$ampcd_data = $this->cache->get('ampcd.' . $this->config->get('config_language_id'));
			
			if (!$ampcd_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$ampcd_data = $query->rows;
				
				$this->cache->set('ampcd.' . $this->config->get('config_language_id'), $ampcd_data);
			}	
			
			return $ampcd_data;
		}
	}
	
	public function getAmpcdDescriptions($ampcd_id) {
		$ampcd_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ampcd_description WHERE ampcd_id = '" . (int)$ampcd_id . "'");
		
		foreach ($query->rows as $result) {
			$ampcd_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
				
				/*{MODEL_GET_DESCRIPTION}*/
				'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['description']),
				
				'name1'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['name1']),
				'name2'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['name2']),
				'name3'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['name3']),
				'desc_short'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['desc_short']),
				
				'description1'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, $result['description1'])
				);
		}
		
		return $ampcd_description_data;
	}
	
	public function getTotalAmpcds($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ampcd p LEFT JOIN " . DB_PREFIX . "ampcd_description pd ON (p.ampcd_id = pd.ampcd_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "ampcd WHERE ampcd_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "ampcd_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND ampcd_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>