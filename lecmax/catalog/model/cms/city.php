<?php
class ModelCmsCity extends Model {

	//Lay tat ca
	public function getCitys($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY pd.name ASC, p.sort_order ASC, p.city_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['city_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/city','path='. $category_id .'_' . $row['category_id'] . '&city_id='.$row['city_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/city','path='. $category_id . '&city_id='.$row['city_id']) .'.html';
			
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
	public function getCity($city_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.city_id = '" . $city_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['city_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	//Lay dua vao id
	public function getTitle($city_id)	{
		$sql = "SELECT pd.name FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.city_id = '" . $city_id . "'";

		$query = $this->db->query($sql);
		$row = $query->row;
		return isset($row['name'])?$row['name']:'';
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getCityAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "city p LEFT JOIN " . DB_PREFIX . "city_description pd ON (p.city_id = pd.city_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.city_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>