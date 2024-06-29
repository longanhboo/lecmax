<?php
class ModelCatalogCategory extends Model {

	public function addCategory($data) {
		
		$str = "";
		if(isset($data['mainmenu']) && $data['mainmenu'] ==1)
			$str .= " mainmenu = '" . (int)$data['mainmenu'] . "', ";
		else
			$str .= " mainmenu = '0', ";

		/*if(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "', ";
		else
			$str .= " image = '', ";
		*/
		if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
        
		
		if(isset($data['mausac']))
			$str .= " mausac = '" . (int)($data['mausac']) . "', ";
		
		if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";


		if(isset($data['type_id'])){
			$str .= " type_id = '" . $this->db->escape($data['type_id']) . "', ";

			if($data['type_id']=='page')
				$data['path'] = 'page';
		}
		
		if(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "', ";
		else
			$str .= " image1 = '', ";
		
		if(isset($data['iscateproduct'])){
			if($data['iscateproduct']==1){
				$str .= " ishome = '0', ";
			}else{
				$str .= " ishome = '" . (int)($data['ishome']) . "', ";
			}
		}else{
			if(isset($data['ishome']))
				$str .= " ishome = '" . (int)($data['ishome']) . "', ";
			else
				$str .= " ishome = '0', ";
		}
		if(isset($data['subcateproduct_id']))
			$str .= " subcateproduct_id = '" . (int)$data['subcateproduct_id'] . "',";
		else
			$str .= " subcateproduct_id = '0', ";
		
		if(isset($data['iconsvg']))
			$str .= " iconsvg = '" . $this->db->escape($data['iconsvg']) . "', ";
		else
			$str .= " iconsvg = '', ";
		
		
		if(isset($data['config_loop_picture']))
			$str .= " config_loop_picture = '" . (int)$data['config_loop_picture'] . "',";
        else
			$str .= " config_loop_picture = '5',";

		if(isset($data['template']))
			$str .= " template = '" . (int)$data['template'] . "', ";

		if(isset($data['download']))
			$str .= " download = '" . (int)$data['download'] . "', ";

		if(isset($data['video']))
			$str .= " video = '" . (int)$data['video'] . "', ";
		
		if(isset($data['parent_default'])){
			if($data['sort_order']==0)	{
				$list_temp = $this->getCategories($data['parent_default'],5);
				foreach($list_temp as $item){
					$this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order=sort_order+1 WHERE category_id='" . (int)$item['category_id'] . "' ");
				}
				//$this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order=sort_order+1 WHERE parent_id='" . (int)$data['parent_default'] . "' ");
			}
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "category
		                 SET parent_id = '" . (int)$data['parent_id'] . "',
		                 `path` = '" . $this->db->escape($data['path']) . "',
		                 $str
		                 `class` = '" . $this->db->escape($data['class']) . "',
		                 sort_order = '" . (int)$data['sort_order'] . "',
		                 status = '" . (int)$data['status'] . "',
		                 date_modified = NOW(),
		                 date_added = NOW()");

		$category_id = $this->db->getLastId();


		foreach ($data['category_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
			$str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
			$str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";

			$str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
			$str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
			
			if(isset($value['pdf'])) $str_update .= "pdf ='".$value['pdf']."',";
			if(isset($value['filepdf'])) $str_update .= "filepdf ='".$value['filepdf']."',";
			if(isset($value['name1'])) $str_update .= "name1 ='".$this->db->escape($value['name1'])."',";
			if(isset($value['name2'])) $str_update .= "name2 ='".$this->db->escape($value['name2'])."',";
			if(isset($value['desc_short'])) $str_update .= "desc_short ='".$this->db->escape($value['desc_short'])."',";

			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET
			                 category_id = '" . (int)$category_id . "',
			                 language_id = '" . (int)$language_id . "',
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description'])) . "'");
		}

		if (isset($data['category_image'])) {
			foreach ($data['category_image'] as $image) {
				
				$str_image = '';
				if(isset($image['image_name'])){
					$str_image .= "image_name = '" . $this->db->escape($image['image_name']) . "',";
				}
				if(isset($image['image_name_en'])){
					$str_image .= "image_name_en = '" . $this->db->escape($image['image_name_en']) . "',";
				}
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_image SET
				                 category_id = '" . (int)$category_id . "',
				                 image = '" . $this->db->escape($image['image']) . "',
				                 image1 = '" . $this->db->escape($image['image1']) . "',
								 $str_image
				                 image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}

		foreach ($data['category_keyword'] as $language_id => $value) {		
		
				if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang = '".$language_id."'");
		}else{
			$keyword = convertAlias($data['category_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "' , lang = '".$language_id."'");
		}
		
		}
		
		/*if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");

			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['category_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/

		$this->cache->delete('category');
	}

	public function editCategory($category_id, $data) {
		$str = "";
		if(isset($data['mainmenu']) && $data['mainmenu'] ==1)
			$str .= " mainmenu = '" . (int)$data['mainmenu'] . "', ";
		else
			$str .= " mainmenu = '0', ";

		/*if(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "', ";
		else
			$str .= " image = '', ";
		*/
		if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
        
		
		if(isset($data['mausac']))
			$str .= " mausac = '" . (int)($data['mausac']) . "', ";
		
		if(isset($data['iscateproduct'])){
			if($data['iscateproduct']==1){
				$str .= " ishome = '0', ";
			}else{
				$str .= " ishome = '" . (int)($data['ishome']) . "', ";
			}
		}else{
			if(isset($data['ishome']))
				$str .= " ishome = '" . (int)($data['ishome']) . "', ";
			else
				$str .= " ishome = '0', ";
		}
		
		if(isset($data['subcateproduct_id']))
			$str .= " subcateproduct_id = '" . (int)$data['subcateproduct_id'] . "',";
		else
			$str .= " subcateproduct_id = '0', ";
		
		if(isset($data['iconsvg']))
			$str .= " iconsvg = '" . $this->db->escape($data['iconsvg']) . "', ";
		else
			$str .= " iconsvg = '', ";
		
		
		
		if(isset($data['delete_image_og']) && $data['delete_image_og']==1)
			$str .= " image_og = '',";
		elseif(isset($data['image_og']))
			$str .= " image_og = '" . $this->db->escape($data['image_og']) . "',";


		if(isset($data['type_id'])){
			$str .= " type_id = '" . $this->db->escape($data['type_id']) . "', ";

			if($data['type_id']=='page')
				$data['path'] = 'page';
		}
		
		if(isset($data['image1']))
			$str .= " image1 = '" . $this->db->escape($data['image1']) . "', ";
		else
			$str .= " image1 = '', ";
		
		if(isset($data['config_loop_picture']))
			$str .= " config_loop_picture = '" . (int)$data['config_loop_picture'] . "',";
        else
			$str .= " config_loop_picture = '5',";

		if(isset($data['template']))
			$str .= " template = '" . (int)$data['template'] . "', ";

		if(isset($data['download']))
			$str .= " download = '" . (int)$data['download'] . "', ";

		if(isset($data['video']))
			$str .= " video = '" . (int)$data['video'] . "', ";

		$this->db->query("UPDATE " . DB_PREFIX . "category
		                 SET parent_id = '" . (int)$data['parent_id'] . "',
		                 `path` = '" . $this->db->escape($data['path']) . "',
		                 $str
		                 `class` = '" . $this->db->escape($data['class']) . "',
		                 sort_order = '" . (int)$data['sort_order'] . "',
		                 status = '" . (int)$data['status'] . "',
		                 date_modified = NOW()
		                 WHERE category_id = '" . (int)$category_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$str_update = "";
			$str_update .= "meta_title = '" . $this->db->escape($value['meta_title']) . "', ";
			$str_update .= "meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', ";
			$str_update .= "meta_description = '" . $this->db->escape($value['meta_description']) . "', ";

			$str_update .= "meta_title_og = '" . $this->db->escape($value['meta_title_og']) . "', ";
			$str_update .= "meta_description_og = '" . $this->db->escape($value['meta_description_og']) . "', ";
			
			if(isset($value['pdf'])) $str_update .= "pdf ='".$value['pdf']."',";
			if(isset($value['filepdf'])) $str_update .= "filepdf ='".$value['filepdf']."',";
			if(isset($value['name1'])) $str_update .= "name1 ='".$this->db->escape($value['name1'])."',";
			if(isset($value['name2'])) $str_update .= "name2 ='".$this->db->escape($value['name2'])."',";
			if(isset($value['desc_short'])) $str_update .= "desc_short ='".$this->db->escape($value['desc_short'])."',";

			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description
			                 SET category_id = '" . (int)$category_id . "',
			                 language_id = '" . (int)$language_id . "',
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG', (string)$value['description'])) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_image WHERE category_id = '" . (int)$category_id . "'");
		if (isset($data['category_image'])) {
			foreach ($data['category_image'] as $image) {
				$str_image = '';
				if(isset($image['image_name'])){
					$str_image .= "image_name = '" . $this->db->escape($image['image_name']) . "',";
				}
				if(isset($image['image_name_en'])){
					$str_image .= "image_name_en = '" . $this->db->escape($image['image_name_en']) . "',";
				}
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_image SET
				                 category_id = '" . (int)$category_id . "',
				                 image = '" . $this->db->escape($image['image']) . "',
				                 image1 = '" . $this->db->escape($image['image1']) . "',
								 $str_image
				                 image_sort_order = '" . $this->db->escape($image['image_sort_order']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");
		foreach ($data['category_keyword'] as $language_id => $value) {
		if (!empty($value['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $value['keyword'] . "'");
			
			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($value['keyword']) . "', lang='".$language_id."'");
		}else{
			$keyword = convertAlias($data['category_description'][$language_id]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "', lang='".$language_id."'");
			
		}
		}

		/*$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");
		if (!empty($data['keyword'])) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."url_alias WHERE keyword='" . $data['keyword'] . "'");

			if($query->num_rows==0)
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}else{
			$keyword = convertAlias($data['category_description'][$this->config->get('config_language_id')]['name']);
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
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword_tmp) . "'");
		}*/

		$this->cache->delete('category');
	}

	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");

		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}

		$this->cache->delete('category');
	}

	public function getCategory($category_id) {
		//, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");

		return $query->row;
	}
	
	private function getCountChild($parent_id=0)
	{	
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category p WHERE p.parent_id='".(int)$parent_id."'");
		return $query->row['total'];
	}
	
	public function getCategoriesForProduct($parent_id,$level=NULL,$lv=0) {
		$category_data = array();
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

			$level = ($level===NULL)?NULL:($level-1);

			foreach ($query->rows as $result) {
				if($this->getCountChild($result['category_id'])==0)
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'parent_id'   => $result['parent_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'mainmenu'  	  => $result['mainmenu'],
					'module'  	  => $result['path'],
					'type'  	  => $result['type_id'],
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order'],
					'level'		  =>$lv
				);
				
				if($level>0 || $level===NULL){
					$category_data = array_merge($category_data, $this->getCategoriesForProduct($result['category_id'],$level,($lv+1)));
				}
				
			}	
		}
		
		return $category_data;
	}

	public function getCategories($parent_id,$level=NULL,$lv=0) {
		$category_data = array();//$this->cache->get('category.' . $this->config->get('config_language_id') . '.' . $parent_id);
		if (!$category_data) {
			$category_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

			$level = ($level===NULL)?NULL:($level-1);

			foreach ($query->rows as $result) {
				$category_data[] = array(
				                         'category_id' => $result['category_id'],
				                         'parent_id'   => $result['parent_id'],
				                         'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
				                         'mainmenu'  	  => $result['mainmenu'],
				                         'module'  	  => $result['path'],
				                         'type'  	  => $result['type_id'],
				                         'status'  	  => $result['status'],
				                         'sort_order'  => $result['sort_order'],
				                         'level'		  =>$lv
				                         );

				if($level>0 || $level===NULL){
					$category_data = array_merge($category_data, $this->getCategories($result['category_id'],$level,($lv+1)));
				}

			}

			//$this->cache->set('category.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		}

		return $category_data;
	}

	public function getPath($category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");


		$category_info = $query->row;//af02e765abf4 PA-184871

		if($category_info){
			if ($category_info['parent_id']) {
				return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . ' &gt; ' . $category_info['name'];
			} else {
				return $category_info['name'];
			}
		}else{
			return '';
		}
	}

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
			   'name'             => $result['name'],
			   'pdf'             => $result['pdf'],
			   'filepdf'             => $result['filepdf'],
			   'name1'             => $result['name1'],
			   'name2'             => $result['name2'],
			   'desc_short'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['desc_short']),
			   'description'      => str_replace('HTTP_CATALOG',HTTP_CATALOG, (string)$result['description']),
			   'meta_title'     => $result['meta_title'],
			   'meta_title_og'     => $result['meta_title_og'],
			   'meta_keyword'     => $result['meta_keyword'],
			   'meta_description' => $result['meta_description'],
			   'meta_description_og' => $result['meta_description_og']
			   );
		}

		return $category_description_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}
	
	public function getCategoryKeyword($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['lang']] = array(
				'keyword'             => $result['keyword']
			);
		}
		
		return $category_description_data;
	}

	public function getCategoryImages($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_image WHERE category_id = '" . (int)$category_id . "' ORDER BY image_sort_order ASC");

		return $query->rows;
	}

	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND category_id='".$cate."'");

		return $query->row['name'];
	}
	
	public function updateStatus($category_id,$module='product', $status=0, $lev=0) {
		if($module == 'news'){
			$this->load->model('catalog/news');
		}elseif($module == 'project'){
			$this->load->model('catalog/project');
		}else{
			$this->load->model('catalog/product');
		}
		
		$categories = $this->getCategories($category_id,1);
		foreach($categories as $item){
			if($module == 'news'){
				$this->model_catalog_news->updateStatusByCate($item['category_id']);
			}elseif($module =='project'){
				$this->model_catalog_project->updateStatusByCate($item['category_id']);
			}else{
				$this->model_catalog_product->updateStatusByCate($item['category_id']);
			}
			$this->updateStatus($item['category_id']);
		}
		
		if($module == 'news'){
			$this->model_catalog_news->updateStatusByCate($category_id);
		}elseif($module == 'project'){
			$this->model_catalog_project->updateStatusByCate($category_id);
		}else{
			$this->model_catalog_product->updateStatusByCate($category_id);
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "category
		                 SET status = '" . $status . "',
		                 date_modified = NOW()
		                 WHERE category_id = '" . (int)$category_id . "'");

		$this->cache->delete('category');
	}
	
	public function getFrontendCategoryChild($category_id,$select="*",$order_by="ORDER BY t1.category_id DESC"){
		$sql = "SELECT {$select}
				FROM ".DB_PREFIX."category AS t1 LEFT JOIN ".DB_PREFIX."category_description AS t2 
				ON t1.category_id = t2.category_id 
				WHERE t1.status = 1 AND t2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t1.parent_id = {$category_id}
				".$order_by."
				";
		$query = $this->db->query($sql);
		return $query->rows;   
	}
}
?>