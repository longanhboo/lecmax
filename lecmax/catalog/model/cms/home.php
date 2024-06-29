<?php
class ModelCmsHome extends Model {

	//Lay tat ca
	public function getHomes($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.home_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['home_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/home','path='. $category_id .'_' . $row['category_id'] . '&home_id='.$row['home_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/home','path='. $category_id . '&home_id='.$row['home_id']) .'.html';

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    		$data['images'] = $this->getImages($data['id']);
    
    		/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getHome($home_id)	{
		$sql = "SELECT p.home_id, p.isshareholder, p.image, p.image1, p.imagenews, p.imagetienich, p.imagechudautu, p.image1chudautu, p.imagecanho, p.image1canho, p.image_video, p.isyoutube, p.script, p.filename_mp4, p.config_loop_picture, pd.name, pd.name1, pd.namevitri, pd.desc_short, pd.desc_short_canho, pd.namecanho, pd.nametienich, pd.desc_short_tienich, pd.namecanho FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.home_id = '" . $home_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['home_id'];
		$data['name'] = html_entity_decode((string)$row['name']);
		$data['desc_short'] = html_entity_decode(nl2br((string)$row['desc_short']));
		
		$data['isshareholder'] = $row['isshareholder'];
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': str_replace(' ', '%20', (string)$row['image1']);
		$data['image_contact'] = empty($row['imagetienich']) || !is_file(DIR_IMAGE . $row['imagetienich'])?'': str_replace(' ', '%20', (string)$row['imagetienich']);
		
		$data['imagenews'] = empty($row['imagenews']) || !is_file(DIR_IMAGE . $row['imagenews'])?'': str_replace(' ', '%20', (string)$row['imagenews']);
		
		$data['image_popup'] = empty($row['imagechudautu']) || !is_file(DIR_IMAGE . $row['imagechudautu'])?'': str_replace(' ', '%20', (string)$row['imagechudautu']);
		
		//location
		$data['name_location'] = html_entity_decode((string)$row['namevitri']);
		$data['desc_short_location'] = html_entity_decode(nl2br((string)$row['desc_short_canho']));
		
		$data['image_location_left'] = empty($row['imagechudautu']) || !is_file(DIR_IMAGE . $row['imagechudautu'])?'': str_replace(' ', '%20', (string)$row['imagechudautu']);
		$data['image_location_right'] = empty($row['image1chudautu']) || !is_file(DIR_IMAGE . $row['image1chudautu'])?'': str_replace(' ', '%20', (string)$row['image1chudautu']);
		
		//video
		$data['image_video'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'': str_replace(' ', '%20', (string)$row['image_video']);
		
		$data['isyoutube'] = $row['isyoutube'];
		$data['script'] = str_replace('<iframe ','<iframe id="video-youtube" ',html_entity_decode((string)$row['script']));
		$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
		
		//facilities
		$data['name_facilities'] = html_entity_decode((string)$row['nametienich']);
		$data['desc_short_facilities'] = html_entity_decode(nl2br((string)$row['desc_short_tienich']));
		
		$data['image_facilities_left'] = empty($row['imagetienich']) || !is_file(DIR_IMAGE . $row['imagetienich'])?'': str_replace(' ', '%20', (string)$row['imagetienich']);
		$data['image_facilities_right'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': str_replace(' ', '%20', (string)$row['image1']);
		
		//apartment
		$data['name_apartment'] = html_entity_decode((string)$row['name1']);
		$data['desc_short_apartment'] = html_entity_decode(nl2br((string)$row['namecanho']));
		
		$data['image_apartment_left'] = empty($row['imagecanho']) || !is_file(DIR_IMAGE . $row['imagecanho'])?'': str_replace(' ', '%20', (string)$row['imagecanho']);
		$data['image_apartment_right'] = empty($row['image1canho']) || !is_file(DIR_IMAGE . $row['image1canho'])?'': str_replace(' ', '%20', (string)$row['image1canho']);
		
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', '&lt;/p&gt;&lt;p&gt;');
		$replace = array('&lt;p&gt;', '&lt;/p&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;strong&gt;', '&lt;/strong&gt;', '&lt;br&gt;');
		
		$data['config_loop_picture'] = $row['config_loop_picture'];
    	$data['images'] = $this->getImages($data['id']);
    
    /*{FRONTEND_DATA_ROW}*/
		return $data;
	}

		//Lay hinh dua vao id
	public function getImages($home_id){
		$query = $this->db->query("SELECT home_image_id, image, image1, image_class as class, image_name, image_name_en, image_desc, image_desc_en, image_link, image_link_en, product_id  FROM ".DB_PREFIX."home_image WHERE home_id='".(int)$home_id."' ORDER BY image_sort_order ASC");
		
		return $query->rows;
		
	}
	
	//Lay hinh dua vao id
	public function getDaidiens($home_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."home_daidien WHERE home_id='".(int)$home_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['home_daidien_id'];
			$data1['image'] = !empty($rs['image']) && is_file(DIR_IMAGE . $rs['image'])?HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image']):'';
			$data1['image1'] = !empty($rs['image1']) && is_file(DIR_IMAGE . $rs['image1'])?HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image1']):$data1['image'];
			$data1['name'] = ($this->config->get('config_language_id')==1)?$rs['image_name_en']:$rs['image_name'];
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getHomeAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "home p LEFT JOIN " . DB_PREFIX . "home_description pd ON (p.home_id = pd.home_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.home_id DESC"; 

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>