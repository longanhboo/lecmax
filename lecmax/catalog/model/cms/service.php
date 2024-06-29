<?php
class ModelCmsService extends Model {

	//Lay tat ca
	public function getServices($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.service_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['service_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/service','path='. $category_id .'_' . $row['category_id'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/service','path='. $category_id . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
			$data['images'] = $this->getImages($data['id']);
			
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
	
	
	public function getServiceByParent($category_id=0, $cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.service_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['service_id'];
			$data['name'] = $row['name'];
			$data['typeservice'] = $row['typeservice'];
			$data['typedesign'] = $row['typedesign'];
			$data['cate'] = $row['cate'];

			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/service','path='. $category_id .'_' . $row['category_id'] . '&cateservice='.$row['cate'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/service','path='. $category_id  . '&cateservice='.$row['cate'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html');
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			if(strpos($des,'<img')){
				$data['description'] = $des;
			}else{
				$checkdes = trim(strip_tags($des));
				$data['description'] = !empty($checkdes)?$des:'';
			}
			
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
			
			if($cate==0){
				$data['child'] = $this->getServiceByParent($category_id,$data['id']);
			}
			
			if($cate==0 || $data['typedesign']==1){
				$data['images'] = $this->getImages($data['id']);
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
	$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.service_id DESC"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['service_id'];
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
	public function getService($service_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.service_id = '" . $service_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['service_id'];
		$data['name'] = $row['name'];
		$data['typeservice'] = $row['typeservice'];
		$data['typedesign'] = $row['typedesign'];
		$data['cate'] = $row['cate'];
		
		$data['href'] = $this->url->link('cms/service','path='. ID_SERVICE . '&cateservice='.$row['cate'] . '&service_id='.$row['service_id'],$this->config->get('config_language')) .'.html';
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
		
		
		if($data['cate']==0){
			$data['child'] = $this->getServiceByParent(ID_SERVICE,$data['id']);
		}
		if($data['cate']==0 || $data['typedesign']==1){
			$data['images'] = $this->getImages($data['id']);
		}
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}

		//Lay hinh dua vao id
	public function getImages($service_id){
		$sql = "SELECT * FROM ".DB_PREFIX."service_image WHERE service_id='".(int)$service_id."' ORDER BY image_sort_order ASC";
        
        $query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['service_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			$data1['name'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_name_en']))):trim(html_entity_decode(nl2br((string)$rs['image_name'])));
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getServiceAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND (p.cate=0 OR p.cate=2) AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.service_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>