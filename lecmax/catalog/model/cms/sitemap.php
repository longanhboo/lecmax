<?php
class ModelCmsSitemap extends Model {

	public function getSitemapByName($sitemap_name='') {
		$sql = "SELECT * FROM " . DB_PREFIX . "sitemap WHERE name='$sitemap_name' AND `seo_url` = '1'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['sitemap_id'];
		$data['name'] = $row['name'];
		$data['frequencies'] = $row['frequencies'];
		$data['priority'] = $row['priority'];

		return $data;
	}

	public function getSitemaps() {
		$sql = "SELECT * FROM " . DB_PREFIX . "sitemap WHERE `seo_url` = '1'";

		$query = $this->db->query($sql);
		$data = array();

		//$row = $query->row;
		foreach($query->rows as $row){
			$data1 = array();
			$data1['id'] = $row['sitemap_id'];
			$data1['name'] = $row['name'];
			$data1['frequencies'] = $row['frequencies'];
			$data1['priority'] = $row['priority'];
			$data[] = $data1;
		}
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

}
?>