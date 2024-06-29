<?php
class ModelCmsCustomers extends Model {

	//Lay tat ca
	public function getCustomerss($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "customers p LEFT JOIN " . DB_PREFIX . "customers_description pd ON (p.customers_id = pd.customers_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.customers_id DESC";
		
		$customers_data = $this->cache->get('customerss.' . $this->config->get('config_language_id'));
		if (!$customers_data) {
			$query = $this->db->query($sql);
			$customers_data = $query->rows;
			$this->cache->set('customerss.' . (int)$this->config->get('config_language_id'), $customers_data);
		}
		
		$data1 = array();

		foreach($customers_data as $row){
			$data = array();
			$data['id'] = $row['customers_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/customers','path='. $category_id .'_' . $row['category_id'] . '&customers_id='.$row['customers_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/customers','path='. $category_id . '&customers_id='.$row['customers_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
				$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
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
	public function getCustomers($customers_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "customers p LEFT JOIN " . DB_PREFIX . "customers_description pd ON (p.customers_id = pd.customers_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.customers_id = '" . $customers_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['customers_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
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

	public function getCustomersAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customers p LEFT JOIN " . DB_PREFIX . "customers_description pd ON (p.customers_id = pd.customers_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.customers_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>