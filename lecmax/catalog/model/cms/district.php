<?php
class ModelCmsDistrict extends Model {

	//Lay tat ca
	public function getDistricts($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.district_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['district_id'];
			$data['name'] = $row['name'];
			$data['city_id'] = $row['category_id'];

			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	public function getDistrictByCity($city_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.status='1' AND p.category_id='$city_id' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.district_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['district_id'];
			$data['name'] = $row['name'];
			$data['city_id'] = $row['category_id'];

			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getDistrict($district_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.district_id = '" . $district_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['district_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	//Lay dua vao id
	public function getTitle($district_id)	{
		$sql = "SELECT pd.name FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.district_id = '" . $district_id . "'";

		$query = $this->db->query($sql);

		$row = $query->row;
		return isset($row['name'])?$row['name']:'';
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getDistrictAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "district p LEFT JOIN " . DB_PREFIX . "district_description pd ON (p.district_id = pd.district_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.district_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>