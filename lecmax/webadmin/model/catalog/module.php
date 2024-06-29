<?php
class ModelCatalogModule extends Model {
	public function addModule($data,$copy=0) {	
		$this->db->query("INSERT INTO " . DB_PREFIX . "module SET 			
			`key` = '" . $this->db->escape($data['key']) . "', 			
			`module` = '" . $this->db->escape($data['module']) . "', 	
			`frontend` = '" . (int)$data['frontend'] . "')");
		
		$module_id = $this->db->getLastId();
		
		foreach ($data['module_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "module_description SET 
				module_id = '" . (int)$module_id . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($value['name']) . "'");
		}
						
		$this->cache->delete('module');
	}
	
	public function editModule($module_id, $data) {				
		$this->db->query("UPDATE " . DB_PREFIX . "module SET 
			`key` = '" . $this->db->escape($data['key']) . "',
			`module` = '" . $this->db->escape($data['module']) . "', 			
			frontend = '" . (int)$data['frontend'] . "' 
			WHERE module_id = '" . (int)$module_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "module_description WHERE module_id = '" . (int)$module_id . "'");
		
		foreach ($data['module_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "module_description SET 
				module_id = '" . (int)$module_id . "', 
				language_id = '" . (int)$language_id . "', 
				name = '" . $this->db->escape($value['name']) . "'");
		}				
						
		$this->cache->delete('module');
	}
	
	public function deleteModule($module_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$module_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "module_description WHERE module_id = '" . (int)$module_id . "'");
		
		$this->cache->delete('module');
	}
	
	
	public function getModules($frontend=1) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "module` WHERE frontend = '" . (int)$frontend . "'"; 
		if($this->user->getId()!=1){
			$sql .= " AND name<>'install' AND name<>'standard' AND name<>'lang'";	
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
		
	}
	
	public function getModuleForPage() {
		$sql = "SELECT * FROM `" . DB_PREFIX . "module` WHERE frontend = '2'  AND name<>'global' AND name<>'install' AND name<>'standard' AND name<>'lang' AND name<>'templates'  AND name<>'admin' AND name<>'adminmenu' AND name<>'header' AND name<>'footer' AND name<>'login'  AND name<>'emailcontact' AND name<>'share' AND name<>'logo' AND name<>'googleanalytics' AND name<>'menu'"; 
				
		$query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $item){
			$data[] = array(
						'path'=> strtolower($item['name']), 
						'name'=>ucfirst($item['name']));
			
		}
		
		return $data;
		
	}			
}
?>