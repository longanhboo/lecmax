<?php
class ModelCatalogAboutus extends Model {
	public function addAboutus($data,$copy=0) {
		/*
		if($copy==0){
		if(isset($_SESSION['temp_pro']) && $_SESSION['temp_pro']<1){
			$_SESSION['temp_pro'] = (int)$_SESSION['temp_pro'] + 1;
		}else{
			$_SESSION['temp_pro'] = 0;
			return;
		}
		}
		*/
		
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
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
		
		if(isset($data['phone']))
			$str .= " phone = '" . $this->db->escape($data['phone']) . "',";
		else
			$str .= " phone = '',";
		
		if(isset($data['fax']))
			$str .= " fax = '" . $this->db->escape($data['fax']) . "',";
		else
			$str .= " fax = '',";
		
		if(isset($data['email']))
			$str .= " email = '" . $this->db->escape($data['email']) . "',";
		else
			$str .= " email = '',";
		
		if(isset($data['gioitinh']))
			$str .= " gioitinh = '" . (int)($data['gioitinh']) . "',";
		else
			$str .= " gioitinh = '0',";
		
		
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
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "aboutus SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$aboutus_id = $this->db->getLastId();		
		
		foreach ($data['aboutus_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			$str_update .= "desc_short = '" . $this->db->escape($value['desc_short']) . "', ";
			$str_update .= "desc_short1 = '" . $this->db->escape($value['desc_short1']) . "', ";
			$str_update .= "description1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description1'])) . "', ";
			$str_update .= "pdf ='".$value['pdf']."',";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "aboutus_description SET 
			                 aboutus_id = '" . (int)$aboutus_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['aboutus_image'])) {
			foreach ($data['aboutus_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "aboutus_image SET 
				aboutus_id = '" . (int)$aboutus_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_desc = '" . $this->db->escape($image['image_desc']) . "',
                image_desc_en = '" . $this->db->escape($image['image_desc_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		foreach ($data['aboutus_keyword'] as $language_id => $value) {		
		
				if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['aboutus_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
        
        		/*if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['aboutus_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/
        
        /*{MODEL_INSERT}*/
		
		//=========================VIDEO
		if (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isyoutube = '0' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET script = '" . $this->db->escape($data['script']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET script = '' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isftp = '1' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isftp = '0' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
		}
		
		$this->cache->delete('aboutus');
	}
	
	public function editAboutus($aboutus_id, $data) {
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
		
		if(isset($data['ishome']) && $data['ishome']==1){
			$str .= " ishome = '1',";
            if(isset($data['image_home'])){
                $str .= " image_home = '" . $this->db->escape($data['image_home']) . "',";
            }
		}else{
			$str .= " ishome = '0',";
            $str .= " image_home = '',";            
		}
		
		if(isset($data['phone']))
			$str .= " phone = '" . $this->db->escape($data['phone']) . "',";
		else
			$str .= " phone = '',";
		
		if(isset($data['fax']))
			$str .= " fax = '" . $this->db->escape($data['fax']) . "',";
		else
			$str .= " fax = '',";
		
		if(isset($data['email']))
			$str .= " email = '" . $this->db->escape($data['email']) . "',";
		else
			$str .= " email = '',";
		
		if(isset($data['gioitinh']))
			$str .= " gioitinh = '" . (int)($data['gioitinh']) . "',";
		else
			$str .= " gioitinh = '0',";
		
        				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE aboutus_id = '" . (int)$aboutus_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "aboutus_description WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
		foreach ($data['aboutus_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			$str_update .= "address = '" . $this->db->escape($value['address']) . "', ";
			$str_update .= "desc_short = '" . $this->db->escape($value['desc_short']) . "', ";
			$str_update .= "desc_short1 = '" . $this->db->escape($value['desc_short1']) . "', ";
			$str_update .= "description1 = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description1'])) . "', ";
			$str_update .= "pdf ='".$value['pdf']."',";
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "aboutus_description SET 
			                 aboutus_id = '" . (int)$aboutus_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "aboutus_image WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		if (isset($data['aboutus_image'])) {
			foreach ($data['aboutus_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "aboutus_image SET 
				aboutus_id = '" . (int)$aboutus_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_desc = '" . $this->db->escape($image['image_desc']) . "',
                image_desc_en = '" . $this->db->escape($image['image_desc_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'aboutus_id=" . (int)$aboutus_id. "'");
		foreach ($data['aboutus_keyword'] as $language_id => $value) {
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
		}else{
			$keyword = convertAlias($data['aboutus_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
			
		}
		}
        
        		/*$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'aboutus_id=" . (int)$aboutus_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['aboutus_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'aboutus_id=" . (int)$aboutus_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/	
		
		//=========================VIDEO  
        if(isset($data['delete_image_video']) && $data['delete_image_video']==1){
        	$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET image_video = '' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
        }elseif (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isyoutube = '0' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET script = '" . $this->db->escape($data['script']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET script = '' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isftp = '1' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET isftp = '0' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "aboutus SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE aboutus_id = '" . (int)$aboutus_id . "'");
			}
		}
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('aboutus');
	}
	
	public function copyAboutus($aboutus_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.aboutus_id = '" . (int)$aboutus_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('aboutus_description' => $this->getAboutusDescriptions($aboutus_id)));			
			
						$data = array_merge($data, array('aboutus_image' => $this->getAboutusImages($aboutus_id)));
			
			$data['aboutus_image'] = array();
			
			$results = $this->getAboutusImages($aboutus_id);
			
			foreach ($results as $result) {
				$data['aboutus_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_desc'=>$result['image_desc'], 'image_desc_en'=>$result['image_desc_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addAboutus($data,1);
		}
	}

	public function deleteAboutus($aboutus_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "aboutus WHERE aboutus_id = '" . (int)$aboutus_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "aboutus_description WHERE aboutus_id = '" . (int)$aboutus_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "aboutus_image WHERE aboutus_id = '" . (int)$aboutus_id . "'");
        
        		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'aboutus_id=" . (int)$aboutus_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('aboutus');
	}
	
		public function getaboutusImages($aboutus_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aboutus_image WHERE aboutus_id = '" . (int)$aboutus_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aboutus WHERE aboutus_id = '" . (int)$id . "'");

		return $query->row;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getAboutus($aboutus_id) {
		
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'aboutus_id=" . (int)$aboutus_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.aboutus_id = '" . (int)$aboutus_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($aboutus_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.aboutus_id = '" . (int)$aboutus_id . "'");
		
		return $query->rows;
	}
	
	public function getAboutuss($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$aboutus_data = $this->cache->get('aboutus.' . $this->config->get('config_language_id'));
			
			if (!$aboutus_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$aboutus_data = $query->rows;
				
				$this->cache->set('aboutus.' . $this->config->get('config_language_id'), $aboutus_data);
			}	
			
			return $aboutus_data;
		}
	}
	
	public function getAboutusDescriptions($aboutus_id) {
		$aboutus_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aboutus_description WHERE aboutus_id = '" . (int)$aboutus_id . "'");
		
		foreach ($query->rows as $result) {
			$aboutus_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'name1'             => $result['name1'],
				'name2'             => $result['name2'],
				'address'             => $result['address'],
				'desc_short'             => $result['desc_short'],
				'desc_short1'             => $result['desc_short1'],
				'description1'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description1']),
				'pdf'             => $result['pdf'],
				'meta_title'     => $result['meta_title'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
        		'meta_title_og'     => $result['meta_title_og'],
				'meta_description_og' => $result['meta_description_og'],
    
    			/*{MODEL_GET_DESCRIPTION}*/
				'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
				);
		}
		
		return $aboutus_description_data;
	}
	
	public function getTotalAboutuss($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
	
	public function getAboutusKeyword($aboutus_id) {
		$aboutus_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'aboutus_id=" . (int)$aboutus_id . "'");
		
		foreach ($query->rows as $result) {
			$aboutus_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $aboutus_description_data;
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "aboutus WHERE aboutus_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "aboutus_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND aboutus_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>