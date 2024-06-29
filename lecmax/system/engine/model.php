<?php
abstract class Model {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
        
        public function getFriendlyUrl($string='',$lang=2){
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($string) . "' AND lang='".$lang."'";
		$query = $this->db->query($sql);
		return isset($query->row['keyword'])?$query->row['keyword']:'';
	}
	
	public function getStatus($table, $id, $language_id, $check_desc=false){
		$result = '';
		
		$query = $this->db->query("SELECT name, description FROM " . DB_PREFIX . $table . "_description WHERE " . $table . "_id = '" . (int)$id . "' AND language_id = '" . (int)$language_id . "'");
		
		if(isset($query->row['name']) && !empty($query->row['name'])){
			if($check_desc){
				$desc = trim(strip_tags(html_entity_decode($query->row['description'])));
				if(!empty($desc)){
					$result = 'Đã dịch';
				}else{
					$result = '<span style="color:red">Chưa dịch</span>';
				}
			}else{
				$result = 'Đã dịch';
			}
		}else
			$result = '<span style="color:red">Chưa dịch</span>';
		
		return $result;
	}
}
?>