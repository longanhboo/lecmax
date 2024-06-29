<?php
class ModelCatalogAdminmenu extends Model {

	public function addAdminmenu($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "adminmenu SET cate_id = '" . (int)$data['cate_id'] . "', parent_id = '" . (int)$data['parent_id'] . "', `path` = '" . $this->db->escape($data['path']) . "' , sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$adminmenu_id = $this->db->getLastId();

		foreach ($data['adminmenu_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "adminmenu_description SET 
			                 adminmenu_id = '" . (int)$adminmenu_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->cache->delete('adminmenu');
	}
	
	public function editAdminmenu($adminmenu_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "adminmenu SET cate_id = '" . (int)$data['cate_id'] . "', parent_id = '" . (int)$data['parent_id'] . "', `path` = '" . $this->db->escape($data['path']). "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "adminmenu_description WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");

		foreach ($data['adminmenu_description'] as $language_id => $value) {
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "adminmenu_description SET adminmenu_id = '" . (int)$adminmenu_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', 
			                 description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->cache->delete('adminmenu');
	}
	
	public function deleteAdminmenu($adminmenu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "adminmenu WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "adminmenu_description WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");
		
		$query = $this->db->query("SELECT adminmenu_id FROM " . DB_PREFIX . "adminmenu WHERE parent_id = '" . (int)$adminmenu_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteAdminmenu($result['adminmenu_id']);
		}
		
		$this->cache->delete('adminmenu');
	} 

	public function getAdminmenu($adminmenu_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'adminmenu_id=" . (int)$adminmenu_id . "') AS keyword FROM " . DB_PREFIX . "adminmenu WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");
		
		return $query->row;
	} 
	
	public function getBanner($adminmenu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "adminmenu WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories($parent_id,$level=NULL,$lv=0) {
		$adminmenu_data = array();//$this->cache->get('adminmenu.' . $this->config->get('config_language_id') . '.' . $parent_id);
		if (!$adminmenu_data) {
			$adminmenu_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "adminmenu c LEFT JOIN " . DB_PREFIX . "adminmenu_description cd ON (c.adminmenu_id = cd.adminmenu_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

			$level = ($level===NULL)?NULL:($level-1);

			foreach ($query->rows as $result) {
				$adminmenu_data[] = array(
				                          'adminmenu_id' => $result['adminmenu_id'],
				                          'parent_id'   => $result['parent_id'],
				                          'name'        => $this->getPath($result['adminmenu_id'], $this->config->get('config_language_id')),
				                          'status'  	  => $result['status'],
				                          'sort_order'  => $result['sort_order'],
				                          'level'		  =>$lv
				                          );
				
				if($level>0 || $level===NULL){
					$adminmenu_data = array_merge($adminmenu_data, $this->getCategories($result['adminmenu_id'],$level,($lv+1)));
				}
				
			}	

			//$this->cache->set('adminmenu.' . $this->config->get('config_language_id') . '.' . $parent_id, $adminmenu_data);
		}
		
		return $adminmenu_data;
	}
	
	public function getPath($adminmenu_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "adminmenu c LEFT JOIN " . DB_PREFIX . "adminmenu_description cd ON (c.adminmenu_id = cd.adminmenu_id) WHERE c.adminmenu_id = '" . (int)$adminmenu_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		

		$adminmenu_info = $query->row;
		
		if($adminmenu_info){
			if ($adminmenu_info['parent_id']) {
				return $this->getPath($adminmenu_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $adminmenu_info['name'];
			} else {
				return $adminmenu_info['name'];
			}
		}else{
			return '';
		}
	}
	
	public function getAdminmenuDescriptions($adminmenu_id) {
		$adminmenu_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "adminmenu_description WHERE adminmenu_id = '" . (int)$adminmenu_id . "'");
		
		foreach ($query->rows as $result) {
			$adminmenu_description_data[$result['language_id']] = array(
			                                                            'name'             => $result['name'],							
			                                                            'description'      => $result['description']
			                                                            );
		}
		
		return $adminmenu_description_data;
	}	

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "adminmenu");
		
		return $query->row['total'];
	}	

	public function getTotalCategoriesByImageId($image_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "adminmenu WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}	
	
	public function getListProject($parent_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "adminmenu p LEFT JOIN " . DB_PREFIX . "adminmenu_description pd ON (p.adminmenu_id = pd.adminmenu_id) WHERE p.status='1' AND p.parent_id='".(int)$parent_id."' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order ASC, p.adminmenu_id DESC");

		return $query->rows;
	}	
	
	public function getImages($adminmenu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "adminmenu_image WHERE adminmenu_id = '" . (int)$adminmenu_id . "' ORDER BY image_sort_order ASC");
		
		return $query->rows;
	}
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "adminmenu_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND adminmenu_id='".$cate."'");
		
		return $query->row['name'];
	}
	
	public function getMenus($parent_id=0){
		$data = array();//$this->cache->get('menu_admin.' . $this->config->get('config_language_id') . '.' . $parent_id);
		
		if(!$data){
			$query = $this->db->query("SELECT c.adminmenu_id, parent_id, name, path, cate_id FROM " . DB_PREFIX . "adminmenu c LEFT JOIN " . DB_PREFIX . "adminmenu_description cd ON (c.adminmenu_id = cd.adminmenu_id) WHERE c.status='1' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.parent_id = '" .(int)$parent_id. "' ORDER BY c.sort_order, cd.name ASC");
			
			$data = array();
			
			//print_r($query->rows);
			foreach($query->rows as $row){
				//get menu category
				$data_tmp = array();
				if($row['cate_id']>0){
					/*if($row['cate_id']==99){
						$querycate = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel c LEFT JOIN " . DB_PREFIX . "hotel_description cd ON (c.hotel_id = cd.hotel_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
						
						foreach($querycate->rows as $item){
							$data_tmp[] = array('adminmenu_id'=>$item['hotel_id'], 'parent_id'=>$row['cate_id'], 'name'=> $item['name'], 'path'=>$row['path'] . '&filter_category=' . $item['hotel_id'],'child'=>array());
						}
					}else{
						$querycate = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$row['cate_id'] . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
						
						foreach($querycate->rows as $item){
							$data_tmp[] = array('adminmenu_id'=>$item['category_id'], 'parent_id'=>$row['cate_id'], 'name'=> $item['name'], 'path'=>$row['path'] . '&filter_category=' . $item['category_id'],'child'=>array());
						}
					}*/
					$querycate = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$row['cate_id'] . "'  AND c.status='1' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
					
					foreach($querycate->rows as $item){
							$data_tmp_child = array();
							$querycatechild = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$item['category_id'] . "' AND c.status='1' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
							foreach($querycatechild->rows as $item_child){
								$data_tmp_child[] = array('id' => $item['category_id'],'adminmenu_id'=>$item_child['category_id'], 'parent_id'=>$item_child['parent_id'], 'name'=> $item_child['name'], 'path'=>$row['path'] . '&filter_category=' . $item_child['category_id'],'child'=>array());
							}
							
						$data_tmp[] = array('id' => $item['category_id'],'adminmenu_id'=>$item['category_id'], 'parent_id'=>$row['cate_id'], 'name'=> $item['name'], 'path'=>$row['path'] . '&filter_category=' . $item['category_id'],'child'=>$data_tmp_child);
					}
				}
				$data1 = array();
				$data1['id'] = $row['adminmenu_id'];
				$data1['parent_id'] = $row['parent_id'];
				$data1['name'] = $row['name'];
				$data1['path'] = $row['path'];
				$data1['child'] = array_merge($data_tmp, $this->getMenus($row['adminmenu_id']));
				$data[] = $data1;
			}
			
			//$this->cache->set('menu_admin.' . $this->config->get('config_language_id') . '.' . $parent_id, $data);
		}
		
		return $data;
	}
}
?>