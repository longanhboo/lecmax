<?php
class ModelCatalogInstallcate extends Model {

	public function installcateLanguage($option=array()){
		$sql = "DELETE FROM " . DB_PREFIX . "lang WHERE `key` = 'heading_title_" . $this->db->escape($option['name']) . "'";
		$this->db->query($sql);
		
		$sql = "DELETE FROM " . DB_PREFIX . "lang WHERE `key` = 'help_entry_image_" . $this->db->escape($option['name']) . "'";
		$this->db->query($sql);
		
		$array_key = array();
		$array_key[] = array('key'=>'heading_title_' . $this->db->escape($option['name']),'name'=>'Quản lý ' . $this->db->escape($option['name']));
		$array_key[] = array('key'=>'help_entry_image_' . $this->db->escape($option['name']),'name'=>'Kích thước hình');
		
		foreach($array_key as $row){
			$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = 'menu', `frontend` = '2'" ;
			$this->db->query($sql);				
			$id = $this->db->getLastId();
			
			$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
			foreach($subquery->rows as $subrow){
				$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
				$this->db->query($sql);
			}
		}

	}
}
?>