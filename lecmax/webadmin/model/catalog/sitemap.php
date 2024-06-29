<?php
class ModelCatalogSitemap extends Model {
	
	public function editSitemap($data) {
		//print_r($data);
		foreach($data['cf_name'] as $key=>$item){
			$this->db->query("UPDATE " . DB_PREFIX . "sitemap SET 
				`frequencies` = '" . $this->db->escape($item) . "',
				`priority` = '" . $data['cf_priority'][$key] . "'
				WHERE sitemap_id = '" . (int)$data['cf_id'][$key] . "'");		
		}
		//die;
		
	}
	
	public function getSitemap($frontend=1) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "sitemap` WHERE frontend = '" . (int)$frontend . "' AND seo_url='1'"; 
		
		$query = $this->db->query($sql);
		
		return $query->rows;
		
	}
}
?>