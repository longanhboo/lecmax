<?php
class ModelCmsBrochure extends Model {

	//Lay tat ca
	public function getBrochures($category_id=0)	{
		$sql = "SELECT p.brochure_id as id, p.image, pd.name, pd.pdf FROM " . DB_PREFIX . "brochure p LEFT JOIN " . DB_PREFIX . "brochure_description pd ON (p.brochure_id = pd.brochure_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.brochure_id DESC";

		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	/*{FRONTEND_GET_BY_CATE}*/
	public function getBrochureByCateHome($category_id=0)	{
		$sql = "SELECT p.brochure_id as id, p.image, pd.name, pd.pdf, pd.filepdf, p.date_insert FROM " . DB_PREFIX . "brochure p LEFT JOIN " . DB_PREFIX . "brochure_description pd ON (p.brochure_id = pd.brochure_id) WHERE p.status='1' AND p.category_id='$category_id' AND p.ishome='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.brochure_id DESC LIMIT 3";

		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getBrochureByCate($category_id=0,$tieuchuan_id=0)	{
		$str = "";
		if($tieuchuan_id){
			$str .= " AND p.tieuchuan_id='$tieuchuan_id' ";
		}
		$sql = "SELECT p.brochure_id as id, p.image, pd.name, pd.pdf, pd.filepdf, p.date_insert FROM " . DB_PREFIX . "brochure p LEFT JOIN " . DB_PREFIX . "brochure_description pd ON (p.brochure_id = pd.brochure_id) WHERE p.status='1' AND p.category_id='$category_id' $str AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.brochure_id DESC";

		$query = $this->db->query($sql);
		return $query->rows;
	}

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getBrochure($brochure_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "brochure p LEFT JOIN " . DB_PREFIX . "brochure_description pd ON (p.brochure_id = pd.brochure_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.brochure_id = '" . $brochure_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['brochure_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['pdf'] = empty($row['pdf'])? '' : HTTP_PDF . $row['pdf'];
    
    /*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getBrochureAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "brochure p LEFT JOIN " . DB_PREFIX . "brochure_description pd ON (p.brochure_id = pd.brochure_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.brochure_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>