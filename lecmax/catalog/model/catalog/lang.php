<?php
class ModelCatalogLang extends Model {
	
	public function addLang($data,$copy=0) {	
		$this->db->query("INSERT INTO " . DB_PREFIX . "lang SET 			
		                 `key` = '" . $this->db->escape($data['key']) . "', 			
		                 `module` = '" . $this->db->escape($data['module']) . "', 	
		                 `frontend` = '" . (int)$data['frontend'] . "'");
		
		$lang_id = $this->db->getLastId();
		
		foreach ($data['lang_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "lang_description SET 
			                 lang_id = '" . (int)$lang_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('lang');
	}
	
	public function keyExists($key,$module,$frontend=1,$edit=false){
		$query = $this->db->query("SELECT `key` FROM ".DB_PREFIX."lang WHERE `key`='".$this->db->escape($key)."' AND `module`='".$this->db->escape($module)."' AND frontend='".(int)$frontend."'");
		
		if($edit)
			return ($query->num_rows>1)?true:false;
		else
			return ($query->num_rows>0)?true:false;
	}
	
	public function editLang($lang_id, $data) {				
		$this->db->query("UPDATE " . DB_PREFIX . "lang SET 
		                 `key` = '" . $this->db->escape($data['key']) . "',
		                 `module` = '" . $this->db->escape($data['module']) . "', 			
		                 frontend = '" . (int)$data['frontend'] . "' 
		                 WHERE lang_id = '" . (int)$lang_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "lang_description WHERE lang_id = '" . (int)$lang_id . "'");
		
		foreach ($data['lang_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "lang_description SET 
			                 lang_id = '" . (int)$lang_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "'");
		}				
		
		$this->cache->delete('lang');
	}
	
	public function deleteLang($lang_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "lang WHERE lang_id = '" . (int)$lang_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "lang_description WHERE lang_id = '" . (int)$lang_id . "'");
		
		$this->cache->delete('lang');
	}
	
	public function getLang($lang_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'lang_id=" . (int)$lang_id . "') AS keyword FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE p.lang_id = '" . (int)$lang_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getLangByModule($module,$frontend=1,$global=true){
		if($global){
			$sql = "SELECT * FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.module='global' AND p.frontend = '" .(int)$frontend. "'"; 						
			
			$query = $this->db->query($sql);
			
			$data = $query->rows;		
		}
		$sql = "SELECT * FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.module = '". $this->db->escape($module) ."' AND p.frontend = '" .(int)$frontend. "'"; 						
		
		$query = $this->db->query($sql);

		$data1 = $query->rows;
		
		if($global)		
			return array_merge($data,$data1);
		else
			return $data1;
	}
	
	public function getLangs($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			
			if (isset($data['frontend']) && !is_null($data['frontend'])) {				
				$sql .= " AND p.frontend = '" . $data['frontend'] . "'";
			}
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			if (isset($data['filter_key']) && !is_null($data['filter_key'])) {
				$sql .= " AND p.key = '" . $this->db->escape($data['filter_key']) . "'";
			}
			
			if (isset($data['filter_module']) && !is_null($data['filter_module'])) {
				$sql .= " AND p.module = '" . $this->db->escape($data['filter_module']) . "'";
			}

			$sort_data = array(
			                   'pd.name',				
			                   'p.module',
			                   'p.key'
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
			$lang_data = $this->cache->get('manager_lang.' . $this->config->get('config_language_id'));
			
			if (!$lang_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE p.frontend='1' pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$lang_data = $query->rows;
				
				$this->cache->set('manager_lang.' . $this->config->get('config_language_id'), $lang_data);
			}	
			
			return $lang_data;
		}
	}
	
	public function getLangDescriptions($lang_id) {
		$lang_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lang_description WHERE lang_id = '" . (int)$lang_id . "'");
		
		foreach ($query->rows as $result) {
			$lang_description_data[$result['language_id']] = array(
			                                                       'name'             => $result['name']
			                                                       );
		}
		
		return $lang_description_data;
	}

	
	public function getTotalLangs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "lang p LEFT JOIN " . DB_PREFIX . "lang_description pd ON (p.lang_id = pd.lang_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		if (isset($data['frontend']) && !is_null($data['frontend'])) {
			$sql .= " AND p.frontend = '" . (int)$data['frontend'] . "'";
		}
		
		if (isset($data['filter_key']) && !is_null($data['filter_key'])) {
			$sql .= " AND p.key = '" . $this->db->escape($data['filter_key']) . "'";
		}
		
		if (isset($data['filter_module']) && !is_null($data['filter_module'])) {
			$sql .= " AND p.module = '" . $this->db->escape($data['filter_module']) . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}			
}
?>