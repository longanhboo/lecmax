<?php
class ModelCmsRecruitment extends Model {

	//Lay tat ca
	public function getRecruitments($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.recruitment_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['recruitment_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/recruitment','path='. $category_id .'_' . $row['category_id'] . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/recruitment','path='. $category_id . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : HTTP_PDF . $row['pdf'];
			
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
	
	
	public function getRecruitmentByParent($category_id=0,$cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.recruitment_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['recruitment_id'];
			$data['name'] = $row['name'];
			
			$data['diadiem'] = $row['diadiem'];
			$data['soluong'] = $row['soluong'];
			$data['date_insert'] = date('d/m/Y',strtotime($row['date_insert']));
			$data['tinhtrang'] = $row['tinhtrang'];
			
			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/recruitment','path='. $category_id .'_' . $row['category_id'] . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/recruitment','path='. ID_NEWS .'_' . $category_id . '&recruitment_id='.$row['recruitment_id'],$this->config->get('config_language')) .'.html');
			
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : $row['pdf'];
			$data['link'] = $row['link'];
			
			if($cate==0){
				$data['child'] = $this->getRecruitmentByParent($category_id,$row['recruitment_id']);
			}
			
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

	//ISHOME
public function getHome()	{	
	$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.recruitment_id DESC"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['recruitment_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
        $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
        $data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		$data['image'] = empty($row['image_home'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_home']);
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getRecruitment($recruitment_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.recruitment_id = '" . $recruitment_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['recruitment_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : HTTP_PDF . $row['pdf'];
    
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

	public function getRecruitmentAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "recruitment p LEFT JOIN " . DB_PREFIX . "recruitment_description pd ON (p.recruitment_id = pd.recruitment_id) WHERE p.status='1' AND p.cate<>0 AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.recruitment_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>