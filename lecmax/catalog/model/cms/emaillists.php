<?php
class ModelCmsEmaillists extends Model {

	//Lay tat ca
	public function getEmaillistss($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "emaillists p LEFT JOIN " . DB_PREFIX . "emaillists_description pd ON (p.emaillists_id = pd.emaillists_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.emaillists_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['emaillists_id'];
			$data['name'] = $row['name'];
			$data['email'] = $row['email'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/emaillists','path='. $category_id .'_' . $row['category_id'] . '&emaillists_id='.$row['emaillists_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/emaillists','path='. $category_id . '&emaillists_id='.$row['emaillists_id']) .'.html';

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    /*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getEmaillists($emaillists_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "emaillists p LEFT JOIN " . DB_PREFIX . "emaillists_description pd ON (p.emaillists_id = pd.emaillists_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.emaillists_id = '" . $emaillists_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['emaillists_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    /*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getEmaillistsAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emaillists p LEFT JOIN " . DB_PREFIX . "emaillists_description pd ON (p.emaillists_id = pd.emaillists_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.emaillists_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>