<?php
class ModelCmsStatus extends Model {

	//Lay tat ca
	public function getStatuss($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "status p LEFT JOIN " . DB_PREFIX . "status_description pd ON (p.status_id = pd.status_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.status_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['status_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/status','path='. $category_id .'_' . $row['category_id'] . '&status_id='.$row['status_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/status','path='. $category_id . '&status_id='.$row['status_id']) .'.html';

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getStatus($status_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "status p LEFT JOIN " . DB_PREFIX . "status_description pd ON (p.status_id = pd.status_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.status_id = '" . $status_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['status_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getStatusAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "status p LEFT JOIN " . DB_PREFIX . "status_description pd ON (p.status_id = pd.status_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.status_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>