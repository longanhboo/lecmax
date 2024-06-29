<?php
class ModelCatalogContact extends Model {
	public function addContact($data,$copy=0) {
		
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
		
		if(isset($data['delete_image2']) && $data['delete_image2']==1)
			$str .= " image2 = '',";
		elseif(isset($data['image2']))
			$str .= " image2 = '" . $this->db->escape($data['image2']) . "',";
		
		
		if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		if(isset($data['address_location']))
			$str .= " address_location = '" . $this->db->escape($data['address_location']) . "',";
		else
			$str .= " address_location = '',";
		
		
		if(isset($data['phonelist']))
			$str .= " phonelist = '" . $this->db->escape($data['phonelist']) . "',";
		else
			$str .= " phonelist = '',";
		
		if(isset($data['hotlinelist']))
			$str .= " hotlinelist = '" . $this->db->escape($data['hotlinelist']) . "',";
		else
			$str .= " hotlinelist = '',";
		
		if(isset($data['faxlist']))
			$str .= " faxlist = '" . $this->db->escape($data['faxlist']) . "',";
		else
			$str .= " faxlist = '',";
		
		if(isset($data['emaillist']))
			$str .= " emaillist = '" . $this->db->escape($data['emaillist']) . "',";
		else
			$str .= " emaillist = '',";
		
		if(isset($data['tax']))
			$str .= " tax = '" . $this->db->escape($data['tax']) . "',";
		else
			$str .= " tax = '',";
		
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
		}else{
			$str .= " ishome = '0',";
		}
		
		if(isset($data['phone']))
			$str .= " phone = '" . $this->db->escape($data['phone']) . "',";
		else
			$str .= " phone = '',";
		
		if(isset($data['phone1']))
			$str .= " phone1 = '" . $this->db->escape($data['phone1']) . "',";
		else
			$str .= " phone1 = '',";
		
		if(isset($data['googlemap']))
			$str .= " googlemap = '" . $this->db->escape($data['googlemap']) . "',";
		else
			$str .= " googlemap = '',";
		
		if(isset($data['phoneviber']))
			$str .= " phoneviber = '" . $this->db->escape($data['phoneviber']) . "',";
		else
			$str .= " phoneviber = '',";
		
		if(isset($data['fax']))
			$str .= " fax = '" . $this->db->escape($data['fax']) . "',";
		else
			$str .= " fax = '',";
		
		if(isset($data['fax1']))
			$str .= " fax1 = '" . $this->db->escape($data['fax1']) . "',";
		else
			$str .= " fax1 = '',";
		
		if(isset($data['fax2']))
			$str .= " fax2 = '" . $this->db->escape($data['fax2']) . "',";
		else
			$str .= " fax2 = '',";
		
		if(isset($data['email']))
			$str .= " email = '" . $this->db->escape($data['email']) . "',";
		else
			$str .= " email = '',";
		
		if(isset($data['email1']))
			$str .= " email1 = '" . $this->db->escape($data['email1']) . "',";
		else
			$str .= " email1 = '',";
		
		if(isset($data['timeface']))
			$str .= " timeface = '" . $this->db->escape($data['timeface']) . "',";
		else
			$str .= " timeface = '2',";
		
		
		
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
			$this->db->query("UPDATE " . DB_PREFIX . "contact SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "contact SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
						 location = '" . $this->db->escape($data['location']) . "',
		                 $str
		                 date_added = NOW()");
		
		$contact_id = $this->db->getLastId();		
		
		foreach ($data['contact_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			
			$str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
				
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "contact_description SET 
			                 contact_id = '" . (int)$contact_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		foreach ($data['contact_keyword'] as $language_id => $value) {		
		
				if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'contact_id=" . (int)$contact_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['contact_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'contact_id=" . (int)$contact_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('contact');
	}
	
	public function editContact($contact_id, $data) {
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
		
		if(isset($data['delete_image2']) && $data['delete_image2']==1)
			$str .= " image2 = '',";
		elseif(isset($data['image2']))
			$str .= " image2 = '" . $this->db->escape($data['image2']) . "',";
		
		
		if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";
		
		if(isset($data['address_location']))
			$str .= " address_location = '" . $this->db->escape($data['address_location']) . "',";
		else
			$str .= " address_location = '',";
		
		
		if(isset($data['phonelist']))
			$str .= " phonelist = '" . $this->db->escape($data['phonelist']) . "',";
		else
			$str .= " phonelist = '',";
		
		if(isset($data['hotlinelist']))
			$str .= " hotlinelist = '" . $this->db->escape($data['hotlinelist']) . "',";
		else
			$str .= " hotlinelist = '',";
		
		
		if(isset($data['faxlist']))
			$str .= " faxlist = '" . $this->db->escape($data['faxlist']) . "',";
		else
			$str .= " faxlist = '',";
		
		if(isset($data['emaillist']))
			$str .= " emaillist = '" . $this->db->escape($data['emaillist']) . "',";
		else
			$str .= " emaillist = '',";
		
		if(isset($data['tax']))
			$str .= " tax = '" . $this->db->escape($data['tax']) . "',";
		else
			$str .= " tax = '',";
		
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
		}else{
			$str .= " ishome = '0',";
		}
		
		if(isset($data['phone']))
			$str .= " phone = '" . $this->db->escape($data['phone']) . "',";
		else
			$str .= " phone = '',";
		
		if(isset($data['phone1']))
			$str .= " phone1 = '" . $this->db->escape($data['phone1']) . "',";
		else
			$str .= " phone1 = '',";
		
		if(isset($data['googlemap']))
			$str .= " googlemap = '" . $this->db->escape($data['googlemap']) . "',";
		else
			$str .= " googlemap = '',";
		
		if(isset($data['phoneviber']))
			$str .= " phoneviber = '" . $this->db->escape($data['phoneviber']) . "',";
		else
			$str .= " phoneviber = '',";
		
		if(isset($data['fax']))
			$str .= " fax = '" . $this->db->escape($data['fax']) . "',";
		else
			$str .= " fax = '',";
		
		if(isset($data['fax1']))
			$str .= " fax1 = '" . $this->db->escape($data['fax1']) . "',";
		else
			$str .= " fax1 = '',";
		
		if(isset($data['fax2']))
			$str .= " fax2 = '" . $this->db->escape($data['fax2']) . "',";
		else
			$str .= " fax2 = '',";
		
		if(isset($data['email']))
			$str .= " email = '" . $this->db->escape($data['email']) . "',";
		else
			$str .= " email = '',";
		
		if(isset($data['email1']))
			$str .= " email1 = '" . $this->db->escape($data['email1']) . "',";
		else
			$str .= " email1 = '',";
		
		if(isset($data['timeface']))
			$str .= " timeface = '" . $this->db->escape($data['timeface']) . "',";
		else
			$str .= " timeface = '2',";
		
		
		
	      				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "contact SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
						 location = '" . $this->db->escape($data['location']) . "',
		                 $str
		                 date_modified = NOW() WHERE contact_id = '" . (int)$contact_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "contact_description WHERE contact_id = '" . (int)$contact_id . "'");
		
		foreach ($data['contact_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			
			$str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "contact_description SET 
			                 contact_id = '" . (int)$contact_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'contact_id=" . (int)$contact_id. "'");
		foreach ($data['contact_keyword'] as $language_id => $value) {
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'contact_id=" . (int)$contact_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
		}else{
			$keyword = convertAlias($data['contact_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'contact_id=" . (int)$contact_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
			
		}
		}
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('contact');
	}
	
	public function copyContact($contact_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.contact_id = '" . (int)$contact_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('contact_description' => $this->getContactDescriptions($contact_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addContact($data,1);
		}
	}

	public function deleteContact($contact_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contact WHERE contact_id = '" . (int)$contact_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "contact_description WHERE contact_id = '" . (int)$contact_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('contact');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getContact($contact_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'contact_id=" . (int)$contact_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.contact_id = '" . (int)$contact_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($contact_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.contact_id = '" . (int)$contact_id . "'");
		
		return $query->rows;
	}
	
	public function getContacts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
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
			$contact_data = $this->cache->get('contact.' . $this->config->get('config_language_id'));
			
			if (!$contact_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$contact_data = $query->rows;
				
				$this->cache->set('contact.' . $this->config->get('config_language_id'), $contact_data);
			}	
			
			return $contact_data;
		}
	}
	
	public function getContactDescriptions($contact_id) {
		$contact_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact_description WHERE contact_id = '" . (int)$contact_id . "'");
		
		foreach ($query->rows as $result) {
			$contact_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'name1'             => $result['name1'],
				'name2'             => $result['name2'],
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
		
		return $contact_description_data;
	}
	
	public function getTotalContacts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
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
	
	public function getContactKeyword($contact_id) {
		$contact_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'contact_id=" . (int)$contact_id . "'");
		
		foreach ($query->rows as $result) {
			$contact_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $contact_description_data;
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "contact WHERE contact_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "contact_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND contact_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>