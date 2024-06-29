<?php
class ModelCmsTemplates extends Model {		
	
	//Lay tat ca
	public function getTemplatess($category_id=0)
	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.templates_id DESC"; 
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['templates_id'];
			$data['name'] = $row['name'];
			
			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/templates','path='. $category_id .'_' . $row['category_id'] . '&templates_id='.$row['templates_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/templates','path='. $category_id . '&templates_id='.$row['templates_id']) .'.html';
			
			$data['description'] = html_entity_decode((string)$row['description']);			
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . $row['image'];
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}
	
	/*{FRONTEND_GET_BY_CATE}*/	
	
	/*{FRONTEND_GET_HOME}*/
	
	//Lay dua vao id
	public function getTemplates($templates_id)
	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.templates_id = '" . $templates_id . "'"; 
		
		$query = $this->db->query($sql);
		$data = array();
		
		$row = $query->row;
		
		$data['id'] = $row['templates_id'];
		$data['name'] = $row['name'];
		$data['description'] = html_entity_decode((string)$row['description']);
		$data['image'] = empty($row['image'])?'': HTTP_IMAGE . $row['image'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	/*{FRONTEND_GET_IMAGES}*/		
	
}
?>