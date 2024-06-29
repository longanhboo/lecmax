<?php
class ModelCmsAudio extends Model {

	//Lay tat ca
	public function getAudios($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.audio_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['audio_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/audio','path='. $category_id .'_' . $row['category_id'] . '&audio_id='.$row['audio_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/audio','path='. $category_id . '&audio_id='.$row['audio_id']) .'.html';

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1'])? HTTP_IMAGE . $row['image'] : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
			
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

		//Lay dua vao danh muc
	public function getAudioByCate($category_id)	{	
		$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.category_id='" . (int)$category_id . "' ORDER BY p.sort_order ASC, p.audio_id DESC"; 
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['audio_id'];
			$data['name'] = $row['name'];
			$data['description'] = html_entity_decode((string)$row['description']);			
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1'])? HTTP_IMAGE . $row['image'] : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
			$data['filename_mp3'] = empty($row['filename_mp3']) || !is_file(DIR_AUDIO . $row['filename_mp3'])? '' : HTTP_AUDIO . $row['filename_mp3'];
			
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

		//ISHOME
	public function getHome()	{
		$this->load->model('cms/common');
		$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.audio_id DESC LIMIT 30"; 
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['audio_id'];
			$data['name'] = $row['name'];
			$data['category_id'] = $row['category_id'];
			$data['cate_name'] = $this->model_cms_common->getTitle($row['category_id']);
			$data['description'] = html_entity_decode((string)$row['description']);	
			$data['filename_mp3'] = empty($row['filename_mp3']) || !is_file(DIR_AUDIO . $row['filename_mp3'])? '' : HTTP_AUDIO . $row['filename_mp3'];
			if(!empty($data['filename_mp3'])){
			$data1[] = $data;
			}
		}

		return $data1;
	}

	//Lay dua vao id
	public function getAudio($audio_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.audio_id = '" . $audio_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['audio_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['image1'] = empty($row['image1'])? HTTP_IMAGE . $row['image'] : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
    
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

	public function getAudioAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "audio p LEFT JOIN " . DB_PREFIX . "audio_description pd ON (p.audio_id = pd.audio_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.audio_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>