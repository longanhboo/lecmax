<?php
class ModelCmsVideo extends Model {

	//Lay tat ca
	public function getVideos($category_id=0)	{
		$sql = "SELECT p.video_id as id, p.image, p.isyoutube, p.script, p.image_video, p.filename_mp4, pd.name FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.video_id DESC";

		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	//ISHOME
public function getHome()	{	
	$sql = "SELECT p.video_id, p.image, p.image_video, p.image_home, p.isyoutube, p.script, p.filename_mp4, pd.name FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.video_id DESC LIMIT 1"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['video_id'];
		$data['name'] = $row['name'];
		$data['image_video'] = empty($row['image_video'])?'': str_replace(' ', '%20', (string)$row['image_video']);
		$data['image'] = empty($row['image_home']) || !is_file(DIR_IMAGE . $row['image_home'])?$data['image_video']: str_replace(' ', '%20', (string)$row['image_home']);
		$data['isyoutube'] = $row['isyoutube'];
		
		$data['script'] = html_entity_decode((string)$row['script']);
		$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
		
		$data['href'] = 'view-video.html?id=' . $row['video_id'];
		
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getVideo($video_id)	{
		$sql = "SELECT p.video_id, p.image, p.image_video, p.isyoutube, p.script, p.filename_mp4, pd.name, pd.description FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.video_id = '" . $video_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['video_id'];
		$data['name'] = $row['name'];
		$data['image'] = empty($row['image_video']) || !is_file(DIR_IMAGE . $row['image_video'])?'':  str_replace(' ', '%20', (string)$row['image_video']);
		
		$data['isyoutube'] = $row['isyoutube'];
		
		$data['script'] = html_entity_decode((string)$row['script']);
		$data['filename_mp4'] = !empty($row['filename_mp4']) && is_file(DIR_DOWNLOAD . $row['filename_mp4'])?$row['filename_mp4']:'';
		
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getVideoAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "video p LEFT JOIN " . DB_PREFIX . "video_description pd ON (p.video_id = pd.video_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.video_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>