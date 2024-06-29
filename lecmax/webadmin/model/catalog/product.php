<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data,$copy=0) {
		
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
        
		if (isset($data['project_category'])) {
			$str .= " project_category = '" . serialize($data['project_category']) . "',";
		}else{
			$str .= " project_category = '',";
		}
		
		if (isset($data['product_category'])) {
			$str .= " product_category = '" . serialize($data['product_category']) . "',";
		}else{
			$str .= " product_category = '',";
		}
		
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

        				if(isset($data['category_id']))
					$str .= " category_id = '" . (int)$data['category_id'] . "',";
                              
                				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		
		$where = " WHERE 1=1 ";
		/*if(isset($data['category_id']))
			$where .= " AND category_id='" . $data['category_id'] . "'";
		
		if(isset($data['cate']))
			$where .= " AND cate='".(int)$data['cate']."'";	
		*/
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "product SET sort_order=sort_order+1 $where ");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_added = NOW()");
		
		$product_id = $this->db->getLastId();		
		
		foreach ($data['product_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['desc_short'])) . "', ";
			
			//thongso
			$str_update .= "namethongso = '" . $this->db->escape($value['namethongso']) . "', ";
			
			//banve
			$str_update .= "namebanve = '" . $this->db->escape($value['namebanve']) . "', ";
			$str_update .= "descriptionbanve = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionbanve'])) . "', ";
			
			//imgpro
			$str_update .= "nameimgpro = '" . $this->db->escape($value['nameimgpro']) . "', ";
			$str_update .= "descriptionimgpro = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionimgpro'])) . "', ";
			
			//phukien
			$str_update .= "namephukien = '" . $this->db->escape($value['namephukien']) . "', ";
			$str_update .= "descriptionphukien = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionphukien'])) . "', ";
			
			//project
			$str_update .= "nameproject = '" . $this->db->escape($value['nameproject']) . "', ";
			$str_update .= "descriptionproject = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionproject'])) . "', ";
			
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET 
			                 product_id = '" . (int)$product_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}				
		
				if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET 
				product_id = '" . (int)$product_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		if (isset($data['product_imagepro'])) {
			foreach ($data['product_imagepro'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_imagepro SET 
				product_id = '" . (int)$product_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        foreach ($data['product_keyword'] as $language_id => $value) {		
		
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['product_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
        
        
        		//=========================VIDEO
		if (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE product_id = '" . (int)$product_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isyoutube = '0' WHERE product_id = '" . (int)$product_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "product SET script = '" . $this->db->escape($data['script']) . "' WHERE product_id = '" . (int)$product_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "product SET script = '' WHERE product_id = '" . (int)$product_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isftp = '1' WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isftp = '0' WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_INSERT}*/
		
		$this->cache->delete('product');
	}
	
	public function editProduct($product_id, $data) {
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
        
		if (isset($data['project_category'])) {
			$str .= " project_category = '" . serialize($data['project_category']) . "',";
		}else{
			$str .= " project_category = '',";
		}
		
		if (isset($data['product_category'])) {
			$str .= " product_category = '" . serialize($data['product_category']) . "',";
		}else{
			$str .= " product_category = '',";
		}
		
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

        				if(isset($data['category_id']))
					$str .= " category_id = '" . (int)$data['category_id'] . "',";
                              
                				if(isset($data['cate']) && !empty($data['cate']))
                    $str .= " cate = '".(int)$data['cate']."',";
                else
                    $str .= " cate='0',";
                              
                /*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "product SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 $str
		                 date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($data['product_description'] as $language_id => $value) {
			$str_update = "";
			
			$str_update .= "desc_short = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['desc_short'])) . "', ";
			
			//thongso
			$str_update .= "namethongso = '" . $this->db->escape($value['namethongso']) . "', ";
			
			//banve
			$str_update .= "namebanve = '" . $this->db->escape($value['namebanve']) . "', ";
			$str_update .= "descriptionbanve = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionbanve'])) . "', ";
			
			//imgpro
			$str_update .= "nameimgpro = '" . $this->db->escape($value['nameimgpro']) . "', ";
			$str_update .= "descriptionimgpro = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionimgpro'])) . "', ";
			
			//phukien
			$str_update .= "namephukien = '" . $this->db->escape($value['namephukien']) . "', ";
			$str_update .= "descriptionphukien = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionphukien'])) . "', ";
			
			//project
			$str_update .= "nameproject = '" . $this->db->escape($value['nameproject']) . "', ";
			$str_update .= "descriptionproject = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['descriptionproject'])) . "', ";
			
			
			                $str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
                $str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
                $str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";
                
                $str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
                $str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
                              
                				$str_update .= "pdf ='".$value['pdf']."',";
                              
                /*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET 
			                 product_id = '" . (int)$product_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description']))  . "'");
		}
		
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET 
				product_id = '" . (int)$product_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_imagepro WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['product_imagepro'])) {
			foreach ($data['product_imagepro'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_imagepro SET 
				product_id = '" . (int)$product_id . "', 
				image = '" . $this->db->escape($image['image']) . "',
				image1 = '" . $this->db->escape($image['image1']) . "',
                image_name = '" . $this->db->escape($image['image_name']) . "',
                image_name_en = '" . $this->db->escape($image['image_name_en']) . "',
				image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
        
        		
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		foreach ($data['product_keyword'] as $language_id => $value) {
            if (!empty($value['keyword'])) {
                $query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
                
                if($query->num_rows==0)
                    $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
            }else{
                $keyword = convertAlias($data['product_description'][$language_id]['name']);
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
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
                
            }
		}
        
        		//=========================VIDEO  
        if(isset($data['delete_image_video']) && $data['delete_image_video']==1){
        	$this->db->query("UPDATE " . DB_PREFIX . "product SET image_video = '' WHERE product_id = '" . (int)$product_id . "'");
        }elseif (isset($data['image_video'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image_video = '" . $this->db->escape($data['image_video']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
        
        if(isset($data['isyoutube']))
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isyoutube = '" . (int)$data['isyoutube'] . "' WHERE product_id = '" . (int)$product_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isyoutube = '0' WHERE product_id = '" . (int)$product_id . "'");
		
		if(isset($data['script']))
			$this->db->query("UPDATE " . DB_PREFIX . "product SET script = '" . $this->db->escape($data['script']) . "' WHERE product_id = '" . (int)$product_id . "'");
		else
			$this->db->query("UPDATE " . DB_PREFIX . "product SET script = '' WHERE product_id = '" . (int)$product_id . "'");
		
        
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isftp = '1' WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
			
			if (isset($data['file_webm_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_webm = '" . $this->db->escape($data['file_webm_ftp']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "product SET isftp = '0' WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
				
			if (isset($data['video_webm'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product SET filename_webm = '" . $this->db->escape($data['video_webm']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
		}
		
		//==============================
        
        /*{MODEL_UPDATE}*/
		
		$this->cache->delete('product');
	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			
						$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));
			
			$data['product_image'] = array();
			
			$results = $this->getProductImages($product_id);
			
			foreach ($results as $result) {
				$data['product_image'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
			
			$data = array_merge($data, array('product_imagepro' => $this->getProductImagepros($product_id)));
			$data['product_imagepro'] = array();
			$results = $this->getProductImagepros($product_id);
			foreach ($results as $result) {
				$data['product_imagepro'][] = array('image'=>$result['image'], 'image1'=>$result['image1'], 'image_name'=>$result['image_name'], 'image_name_en'=>$result['image_name_en'], 'image_sort_order'=>$result['image_sort_order']);
			}
            
            /*{MODEL_COPY}*/
			
			$this->addProduct($data,1);
		}
	}

	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_imagepro WHERE product_id = '" . (int)$product_id . "'");
        
        		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
        
        /*{MODEL_DELETE}*/
		
		$this->cache->delete('product');
	}
	
		public function getproductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function getproductImagepros($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_imagepro WHERE product_id = '" . (int)$product_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
    
    /*{MODEL_GET_IMAGES}*/
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$id . "'");

		return $query->row;
	}
    
    /*{MODEL_GET_VIDEO}*/
	
	public function getProduct($product_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProducts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			$product_data = $this->cache->get('product.' . $this->config->get('config_language_id'));
			
			if (!$product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$product_data = $query->rows;
				
				$this->cache->set('product.' . $this->config->get('config_language_id'), $product_data);
			}	
			
			return $product_data;
		}
	}
	
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				
				'desc_short'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['desc_short']),
				
				//thongso
				'namethongso'             => $result['namethongso'],
				
				//banve
				'namebanve'             => $result['namebanve'],
				'descriptionbanve'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['descriptionbanve']),
				
				//imgpro
				'nameimgpro'             => $result['nameimgpro'],
				'descriptionimgpro'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['descriptionimgpro']),
				
				//phukien
				'namephukien'             => $result['namephukien'],
				'descriptionphukien'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['descriptionphukien']),
				
				//project
				'nameproject'             => $result['nameproject'],
				'descriptionproject'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['descriptionproject']),
				
				
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
		
		return $product_description_data;
	}
	
	public function getProductKeyword($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $product_description_data;
	}
	
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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
		$sql = "SELECT category_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND product_id='".(int)$cate."'");
		
		return $query->row['name'];
	}			
	
	
	public function getProductByPK($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
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
			
			if (isset($data['array_cate']) && !is_null($data['array_cate'])) {
                $sql .= " AND p.category_id IN (" . $data['array_cate'] . ") ";
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
			$product_data = $this->cache->get('product.' . $this->config->get('config_language_id'));
			
			if (!$product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$product_data = $query->rows;
				
				$this->cache->set('product.' . $this->config->get('config_language_id'), $product_data);
			}	
			
			return $product_data;
		}
	}
}
?>