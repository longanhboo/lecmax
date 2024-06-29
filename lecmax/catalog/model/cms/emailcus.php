<?php
class ModelCmsEmailcus extends Model {

	//Lay tat ca
	public function getEmailcuss($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "emailcus p LEFT JOIN " . DB_PREFIX . "emailcus_description pd ON (p.emailcus_id = pd.emailcus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.emailcus_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['emailcus_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/emailcus','path='. $category_id .'_' . $row['category_id'] . '&emailcus_id='.$row['emailcus_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/emailcus','path='. $category_id . '&emailcus_id='.$row['emailcus_id']) .'.html';

			$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/

	//Lay dua vao id
	public function getEmailcus($emailcus_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "emailcus p LEFT JOIN " . DB_PREFIX . "emailcus_description pd ON (p.emailcus_id = pd.emailcus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.emailcus_id = '" . $emailcus_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['emailcus_id'];
		$data['name'] = $row['name'];
		$data['description'] = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['description']));
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function addEmailCus($data,$type=0,$filename=''){
		
		//$data['nameregister'] = isset($data['nameregister'])?$data['nameregister']:$data['emailregister'];
		//$data['name'] = isset($data['name'])?$data['name']:'';
		//$data['phoneregister'] = $data['commentregister'] = $data['phone'] = $data['comment'] = '';
		
		$this->db->query("UPDATE " . DB_PREFIX . "emailcus SET sort_order=sort_order+1 ");
		
		/*
			cmnd='".$this->db->escape($data['cmndregister'])."', 
			address='".$this->db->escape($data['addressregister'])."', 
			city='".$this->db->escape($data['cityregister'])."', 
			district='".$this->db->escape($data['districtregister'])."', 
			canhoquantam='".$this->db->escape($data['canhoquantamregister'])."', 
			giaquantam='".$this->db->escape($data['giaquantamregister'])."', 
		*/
		if($type==0){
			$data['nameregister'] = $data['name'];
			$data['addressregister'] = isset($data['address'])?$data['address']:'';
			$data['companyregister'] = isset($data['company'])?$data['company']:'';
			$data['phoneregister'] = $data['phone'];
			$data['commentregister'] = $data['comments'];
			$data['emailregister'] = $data['email'];
			$data['province'] = isset($data['center-province'])?$data['center-province']:0;
			$data['district'] = isset($data['center-district'])?$data['center-district']:0;
			$data['catalogue'] = '';
			
		}elseif($type==1){
			$data['nameregister'] = $data['name'];
			$data['addressregister'] = isset($data['address'])?$data['address']:'';
			$data['companyregister'] = isset($data['company'])?$data['company']:'';
			$data['phoneregister'] = $data['phone'];
			$data['commentregister'] = '';
			$data['emailregister'] = $data['email'];
			$data['province'] = isset($data['center-province'])?$data['center-province']:0;
			$data['district'] = isset($data['center-district'])?$data['center-district']:0;
			$data['catalogue'] = serialize($data['catalogue']);
		}
		
		$sql = "INSERT INTO " . DB_PREFIX . "emailcus 
			SET name='" . $this->db->escape($data['nameregister']) . "', 
			phone='".$this->db->escape($data['phoneregister'])."', 
			comment='".$this->db->escape($data['commentregister'])."', 
			address='".$this->db->escape($data['addressregister'])."', 
			company='".$this->db->escape($data['companyregister'])."', 
			city='".$this->db->escape($data['province'])."', 
			district='".$this->db->escape($data['district'])."', 
			email='".$this->db->escape($data['emailregister'])."', 
			catalogue='".$this->db->escape($data['catalogue'])."', 
			filename='".$this->db->escape($filename)."', 
			is_mail='".(int)$type."', 
			date_added=NOW()";
			
		$this->db->query($sql);
		
		$emailcus_id = $this->db->getLastId();		
		
		return $emailcus_id;
	}
	
	public function addUngvien($filename='',$data=array()){
		
		$this->db->query("UPDATE " . DB_PREFIX . "ungvien SET sort_order=sort_order+1 ");

		$sql = "INSERT INTO " . DB_PREFIX . "ungvien 
			SET name='" . $this->db->escape($data['name']) . "', 
			phone='".$this->db->escape($data['phone'])."', 
			email='".$this->db->escape($data['email'])."', 
			filename='".$this->db->escape($filename)."', 
			date_added=NOW()";
			
		$this->db->query($sql);
		
		$ungvien_id = $this->db->getLastId();		
		
		return $ungvien_id;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getEmailcusAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emailcus p LEFT JOIN " . DB_PREFIX . "emailcus_description pd ON (p.emailcus_id = pd.emailcus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.emailcus_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>