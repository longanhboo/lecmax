<?php
class ModelCmsRelation extends Model {

	//Lay tat ca
	public function getRelations($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "relation p LEFT JOIN " . DB_PREFIX . "relation_description pd ON (p.relation_id = pd.relation_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.relation_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['relation_id'];
			$data['name'] = $row['name'];
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):$row['name'];
			$data['linkweb'] = str_replace('HTTP_CATALOG',HTTP_SERVER,((string)$row['linkweb']));

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/relation','path='. $category_id .'_' . $row['category_id'] . '&relation_id='.$row['relation_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/relation','path='. $category_id . '&relation_id='.$row['relation_id']) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getRelation($relation_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "relation p LEFT JOIN " . DB_PREFIX . "relation_description pd ON (p.relation_id = pd.relation_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.relation_id = '" . $relation_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['relation_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['image1'] = empty($row['image1'])? HTTP_IMAGE . $row['image'] : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
	$data['meta_keyword'] = $row['meta_keyword'];
	$data['meta_description'] = $row['meta_description'];
    
	$data['image_og'] = $row['image_og'];
    $data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
    $data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];

	/*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getRelationAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "relation p LEFT JOIN " . DB_PREFIX . "relation_description pd ON (p.relation_id = pd.relation_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.relation_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>