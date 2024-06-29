<?php
class ModelCatalogHome extends Model {
	public function addHome($data,$copy=0) {
		$str = "";		
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
		
		if(isset($data['delete_imagetienich']) && $data['delete_imagetienich']==1)
			$str .= " imagetienich = '',";
		elseif(isset($data['imagetienich']))
			$str .= " imagetienich = '" . $this->db->escape($data['imagetienich']) . "',";
		
		if(isset($data['delete_imagechudautu']) && $data['delete_imagechudautu']==1)
			$str .= " imagechudautu = '',";
		elseif(isset($data['imagechudautu']))
			$str .= " imagechudautu = '" . $this->db->escape($data['imagechudautu']) . "',";
		
		if(isset($data['delete_image1chudautu']) && $data['delete_image1chudautu']==1)
			$str .= " image1chudautu = '',";
		elseif(isset($data['image1chudautu']))
			$str .= " image1chudautu = '" . $this->db->escape($data['image1chudautu']) . "',";
		
		
		if(isset($data['delete_imagecanho']) && $data['delete_imagecanho']==1)
			$str .= " imagecanho = '',";
		elseif(isset($data['imagecanho']))
			$str .= " imagecanho = '" . $this->db->escape($data['imagecanho']) . "',";
		
		if(isset($data['delete_image1canho']) && $data['delete_image1canho']==1)
			$str .= " image1canho = '',";
		elseif(isset($data['image1canho']))
			$str .= " image1canho = '" . $this->db->escape($data['image1canho']) . "',";
		
		if(isset($data['delete_imagenews']) && $data['delete_imagenews']==1)
			$str .= " imagenews = '',";
		elseif(isset($data['imagenews']))
			$str .= " imagenews = '" . $this->db->escape($data['imagenews']) . "',";
		
		if(isset($data['isshareholder']))
			$str .= " isshareholder = '" . (int)$data['isshareholder'] . "',";
        else
			$str .= " isshareholder = '0',";
		
		
		if(isset($data['link_tongthe']))
			$str .= " link_tongthe = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['link_tongthe'])) . "',";
        else
			$str .= " link_tongthe = '',";
		
		if(isset($data['googlemap']))
			$str .= " googlemap = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['googlemap'])) . "',";
        else
			$str .= " googlemap = '',";
		
		if(isset($data['config_loop_picture']))
			$str .= " config_loop_picture = '" . (int)$data['config_loop_picture'] . "',";
        else
			$str .= " config_loop_picture = '5',";
	      /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "home SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "home SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$home_id = $this->db->getLastId();		
		
		foreach ($data['home_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			
			$str_update .= "namevitri = '" . $this->db->escape($value['namevitri']) . "', ";
			$str_update .= "name1vitri = '" . $this->db->escape($value['name1vitri']) . "', ";
			
			$str_update .= "namecanho = '" . $this->db->escape($value['namecanho']) . "', ";
			
			$str_update .= "nametienich = '" . $this->db->escape($value['nametienich']) . "', ";
			$str_update .= "name1tienich = '" . $this->db->escape($value['name1tienich']) . "', ";
			
			$str_update .= "desc_short = '" . $this->db->escape($value['desc_short']) . "', ";
			$str_update .= "desc_short_canho = '" . $this->db->escape($value['desc_short_canho']) . "', ";
			
			$str_update .= "desc_short_tienich = '" . $this->db->escape($value['desc_short_tienich']) . "', ";
			
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "home_description SET 
			                 home_id = '" . (int)$home_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['home_image'])) {
			foreach ($data['home_image'] as $image) {
				
				$str_image = "";
				if(isset($image['product_id'])){
					$str_image .= "product_id = '" . (int)$image['product_id'] . "',";
				}
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "home_image SET 
				home_id = '" . (int)$home_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
				image2 = '" . $this->db->escape($image['image2']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_desc = '" . $this->db->escape($image['image_desc']) . "',
                image_desc_en = '" . $this->db->escape($image['image_desc_en']) . "',
				image_info = '" . $this->db->escape($image['image_info']) . "',
                image_info_en = '" . $this->db->escape($image['image_info_en']) . "',
				image_class = '" . $this->db->escape($image['image_class']) . "',
				$str_image
				image_link = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$image['image_link'])) . "',
				image_link_en = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$image['image_link_en'])) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		if (isset($data['home_daidien'])) {
			foreach ($data['home_daidien'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "home_daidien SET 
				home_id = '" . (int)$home_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
		//=========================VIDEO
		if (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "home SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE home_id = '" . (int)$home_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE home_id = '" . (int)$home_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isyoutube = '0' WHERE home_id = '" . (int)$home_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "home SET script = '" . $this->db->escape($data['script']) . "' WHERE home_id = '" . (int)$home_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "home SET script = '' WHERE home_id = '" . (int)$home_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isftp = '1' WHERE home_id = '" . (int)$home_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isftp = '0' WHERE home_id = '" . (int)$home_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
		}
		
		//==============================
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('home');
	}
	
	public function editHome($home_id, $data) {
		
		$str = "";				
				if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['delete_image1']) && $data['delete_image1']==1)
			$str .= " image1 = '',";
		elseif(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "',";
		
		if(isset($data['delete_imagetienich']) && $data['delete_imagetienich']==1)
			$str .= " imagetienich = '',";
		elseif(isset($data['imagetienich']))
			$str .= " imagetienich = '" . $this->db->escape($data['imagetienich']) . "',";
		
		if(isset($data['delete_imagechudautu']) && $data['delete_imagechudautu']==1)
			$str .= " imagechudautu = '',";
		elseif(isset($data['imagechudautu']))
			$str .= " imagechudautu = '" . $this->db->escape($data['imagechudautu']) . "',";
		
		if(isset($data['delete_image1chudautu']) && $data['delete_image1chudautu']==1)
			$str .= " image1chudautu = '',";
		elseif(isset($data['image1chudautu']))
			$str .= " image1chudautu = '" . $this->db->escape($data['image1chudautu']) . "',";
		
		
		if(isset($data['delete_imagecanho']) && $data['delete_imagecanho']==1)
			$str .= " imagecanho = '',";
		elseif(isset($data['imagecanho']))
			$str .= " imagecanho = '" . $this->db->escape($data['imagecanho']) . "',";
		
		if(isset($data['delete_image1canho']) && $data['delete_image1canho']==1)
			$str .= " image1canho = '',";
		elseif(isset($data['image1canho']))
			$str .= " image1canho = '" . $this->db->escape($data['image1canho']) . "',";
		
		
		if(isset($data['delete_imagenews']) && $data['delete_imagenews']==1)
			$str .= " imagenews = '',";
		elseif(isset($data['imagenews']))
			$str .= " imagenews = '" . $this->db->escape($data['imagenews']) . "',";
		
		
		if(isset($data['link_tongthe']))
			$str .= " link_tongthe = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['link_tongthe'])) . "',";
        else
			$str .= " link_tongthe = '',";
		
		if(isset($data['isshareholder']))
			$str .= " isshareholder = '" . (int)$data['isshareholder'] . "',";
        else
			$str .= " isshareholder = '0',";
		
		
		if(isset($data['googlemap']))
			$str .= " googlemap = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['googlemap'])) . "',";
        else
			$str .= " googlemap = '',";
		
		if(isset($data['config_loop_picture']))
			$str .= " config_loop_picture = '" . (int)$data['config_loop_picture'] . "',";
        else
			$str .= " config_loop_picture = '5',";
		
	      /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "home SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE home_id = '" . (int)$home_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "home_description WHERE home_id = '" . (int)$home_id . "'");
		
		foreach ($data['home_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "name1 = '" . $this->db->escape($value['name1']) . "', ";
			$str_update .= "name2 = '" . $this->db->escape($value['name2']) . "', ";
			
			$str_update .= "namevitri = '" . $this->db->escape($value['namevitri']) . "', ";
			$str_update .= "name1vitri = '" . $this->db->escape($value['name1vitri']) . "', ";
			
			$str_update .= "namecanho = '" . $this->db->escape($value['namecanho']) . "', ";
			
			$str_update .= "nametienich = '" . $this->db->escape($value['nametienich']) . "', ";
			$str_update .= "name1tienich = '" . $this->db->escape($value['name1tienich']) . "', ";
			
			$str_update .= "desc_short = '" . $this->db->escape($value['desc_short']) . "', ";
			$str_update .= "desc_short_canho = '" . $this->db->escape($value['desc_short_canho']) . "', ";
			$str_update .= "desc_short_tienich = '" . $this->db->escape($value['desc_short_tienich']) . "', ";
			
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "home_description SET 
			                 home_id = '" . (int)$home_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "home_image WHERE home_id = '" . (int)$home_id . "'");
		if (isset($data['home_image'])) {
			foreach ($data['home_image'] as $image) {
				$str_image = "";
				if(isset($image['product_id'])){
					$str_image .= "product_id = '" . (int)$image['product_id'] . "',";
				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "home_image SET 
				home_id = '" . (int)$home_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
				image2 = '" . $this->db->escape($image['image2']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_desc = '" . $this->db->escape($image['image_desc']) . "',
                image_desc_en = '" . $this->db->escape($image['image_desc_en']) . "',
				image_info = '" . $this->db->escape($image['image_info']) . "',
                image_info_en = '" . $this->db->escape($image['image_info_en']) . "',
				image_class = '" . $this->db->escape($image['image_class']) . "',
				$str_image
				image_link = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$image['image_link'])) . "',
				image_link_en = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$image['image_link_en'])) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "home_daidien WHERE home_id = '" . (int)$home_id . "'");
		if (isset($data['home_daidien'])) {
			foreach ($data['home_daidien'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "home_daidien SET 
				home_id = '" . (int)$home_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
		//=========================VIDEO  
        if(isset($data['delete_image_video']) && $data['delete_image_video']==1){
        	$this->db->query("UPDATE " . DB_PREFIX . "home SET image_video = '' WHERE home_id = '" . (int)$home_id . "'");
        }elseif (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "home SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE home_id = '" . (int)$home_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE home_id = '" . (int)$home_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isyoutube = '0' WHERE home_id = '" . (int)$home_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "home SET script = '" . $this->db->escape($data['script']) . "' WHERE home_id = '" . (int)$home_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "home SET script = '' WHERE home_id = '" . (int)$home_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isftp = '1' WHERE home_id = '" . (int)$home_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "home SET isftp = '0' WHERE home_id = '" . (int)$home_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "home SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE home_id = '" . (int)$home_id . "'");
			}
		}
		
		//==============================
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('home');
	}
	
	public function copyHome($home_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.home_id = '" . (int)$home_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('home_description' => $this->getHomeDescriptions($home_id)));			
			
						$data = array_merge($data, array('home_image' => $this->getHomeImages($home_id)));
			
			$data['home_image'] = array();
			
			$results = $this->getHomeImages($home_id);
			
			foreach ($results as $result) {
				$data['home_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
			
			$data = array_merge($data, array('home_daidien' => $this->getHomeDaidiens($home_id)));
			
			$data['home_daidien'] = array();
			
			$results = $this->getHomeDaidiens($home_id);
			
			foreach ($results as $result) {
				$data['home_daidien'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addHome($data,1);
		}
	}

	public function deleteHome($home_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "home WHERE home_id = '" . (int)$home_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "home_description WHERE home_id = '" . (int)$home_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "home_daidien WHERE home_id = '" . (int)$home_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "home_image WHERE home_id = '" . (int)$home_id . "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('home');
	}
	
		public function gethomeImages($home_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home_image WHERE home_id = '" . (int)$home_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function gethomeDaidiens($home_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home_daidien WHERE home_id = '" . (int)$home_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home WHERE home_id = '" . (int)$id . "'");

		return $query->row;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getHome($home_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'home_id=" . (int)$home_id . "') AS keyword FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.home_id = '" . (int)$home_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($home_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.home_id = '" . (int)$home_id . "'");
		
		return $query->rows;
	}
	
	public function getHomes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$home_data = $this->cache->get('home.' . $this->config->get('config_language_id'));
			
			if (!$home_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$home_data = $query->rows;
				
				$this->cache->set('home.' . $this->config->get('config_language_id'), $home_data);
			}	
			
			return $home_data;
		}
	}
	
	public function getHomeDescriptions($home_id) {
		$home_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "home_description WHERE home_id = '" . (int)$home_id . "'");
		
		foreach ($query->rows as $result) {
			$home_description_data[$result['language_id']] = array(
				 'name'             => $result['name'],
				 'name1'             => $result['name1'],
				 'namevitri'             => $result['namevitri'],
				 'name1vitri'             => $result['name1vitri'],
				 
				 'nametienich'             => $result['nametienich'],
				 'name1tienich'             => $result['name1tienich'],
				 
				 'namecanho'             => $result['namecanho'],
				 
				 'name2'             => $result['name2'],
				 'desc_short'             => $result['desc_short'],
				 'desc_short_canho'             => $result['desc_short_canho'],
				 'desc_short_tienich'             => $result['desc_short_tienich'],
				 /*{MODEL_GET_DESCRIPTION}*/
				 'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description'])
				 );
		}
		
		return $home_description_data;
	}
	
	public function getTotalHomes($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "home WHERE home_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "home_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND home_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
}
?>