<?php
class ModelCatalogTemplates extends Model {
	public function addTemplates($data,$copy=0) {
		$str = "";		
		if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['option_image']) && $data['option_image']==1)
			$str .= " option_image = '1',";
		else
			$str .= " option_image = '0',";
		
		if(isset($data['option_images']) && $data['option_images']==1)
			$str .= " option_images = '1',";
		else
			$str .= " option_images = '0',";
		
		if(isset($data['option_download']) && $data['option_download']==1)
			$str .= " option_download = '1',";
		else
			$str .= " option_download = '0',";
		
		if(isset($data['option_video']) && $data['option_video']==1)
			$str .= " option_video = '1',";
		else
			$str .= " option_video = '0',";
		
		/*{STRING_IMAGE}*/
		//stt tu dong tang neu stt=0
		if($copy==0 && $data['sort_order']==0)	
			$this->db->query("UPDATE " . DB_PREFIX . "templates SET sort_order=sort_order+1");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "templates SET 			
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 
		                 help_image = '" . $this->db->escape($data['help_image']) . "',
		                 help_image_1 = '" . $this->db->escape($data['help_image_1']) . "',
		                 help_image_2 = '" . $this->db->escape($data['help_image_2']) . "',
		                 module_download = '" . $this->db->escape($data['module_download']) . "',
		                 module_video = '" . $this->db->escape($data['module_video']) . "',
		                 
		                 $str
		                 date_added = NOW()");
		
		$templates_id = $this->db->getLastId();		
		
		foreach ($data['templates_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			$this->db->query("INSERT INTO " . DB_PREFIX . "templates_description SET 
			                 templates_id = '" . (int)$templates_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "',
			                 $str_update
			                 description = '" . $this->db->escape($value['description']) . "'");
		}				
		
				//=========================VIDEO

		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "templates SET isftp = '1' WHERE templates_id = '" . (int)$templates_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "templates SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE templates_id = '" . (int)$templates_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "templates SET isftp = '0' WHERE templates_id = '" . (int)$templates_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "templates SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE templates_id = '" . (int)$templates_id . "'");
			}
		}
		
		//==============================
		
		/*{MODEL_INSERT}*/
		
		$this->cache->delete('templates');
	}
	
	public function editTemplates($templates_id, $data) {
		$str = "";	
		
		if(isset($data['delete_image']) && $data['delete_image']==1)
			$str .= " image = '',";
		elseif(isset($data['image']))
			$str .= " image = '" . $this->db->escape($data['image']) . "',";
		
		if(isset($data['option_image']) && $data['option_image']==1)
			$str .= " option_image = '1',";
		else
			$str .= " option_image = '0',";
		
		if(isset($data['option_images']) && $data['option_images']==1)
			$str .= " option_images = '1',";
		else
			$str .= " option_images = '0',";
		
		if(isset($data['option_download']) && $data['option_download']==1)
			$str .= " option_download = '1',";
		else
			$str .= " option_download = '0',";
		
		if(isset($data['option_video']) && $data['option_video']==1)
			$str .= " option_video = '1',";
		else
			$str .= " option_video = '0',";    
		
		/*{STRING_IMAGE}*/				
		$this->db->query("UPDATE " . DB_PREFIX . "templates SET 
		                 status = '" . (int)$data['status'] . "', 			
		                 sort_order = '" . (int)$data['sort_order'] . "', 
		                 
		                 help_image = '" . $this->db->escape($data['help_image']) . "',
		                 help_image_1 = '" . $this->db->escape($data['help_image_1']) . "',
		                 help_image_2 = '" . $this->db->escape($data['help_image_2']) . "',
		                 module_download = '" . $this->db->escape($data['module_download']) . "',
		                 module_video = '" . $this->db->escape($data['module_video']) . "',
		                 
		                 $str
		                 date_modified = NOW() WHERE templates_id = '" . (int)$templates_id . "'");		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "templates_description WHERE templates_id = '" . (int)$templates_id . "'");
		
		foreach ($data['templates_description'] as $language_id => $value) {
			$str_update = "";
			/*{MODEL_INSERT_UPDATE}*/
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "templates_description SET 
			                 templates_id = '" . (int)$templates_id . "', 
			                 language_id = '" . (int)$language_id . "', 
			                 name = '" . $this->db->escape($value['name']) . "', 
			                 $str_update
			                 description = '" . $this->db->escape($value['description']) . "'");
		}
		
				//=========================VIDEO  
		
		if(isset($data['isftp']) && $data['isftp']==1){
			$this->db->query("UPDATE " . DB_PREFIX . "templates SET isftp = '1' WHERE templates_id = '" . (int)$templates_id . "'");
			
			if (isset($data['file_mp4_ftp'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "templates SET filename_mp4 = '" . $this->db->escape($data['file_mp4_ftp']) . "' WHERE templates_id = '" . (int)$templates_id . "'");
			}
			
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "templates SET isftp = '0' WHERE templates_id = '" . (int)$templates_id . "'");
			
			if (isset($data['video_mp4'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "templates SET filename_mp4 = '" . $this->db->escape($data['video_mp4']) . "' WHERE templates_id = '" . (int)$templates_id . "'");
			}
		}
		
		//==============================
		
		/*{MODEL_UPDATE}*/
		
		$this->cache->delete('templates');
	}
	
	public function copyTemplates($templates_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.templates_id = '" . (int)$templates_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
			
			$data = array_merge($data, array('templates_description' => $this->getTemplatesDescriptions($templates_id)));			
			
			/*{MODEL_COPY}*/
			
			$this->addTemplates($data,1);
		}
	}

	public function deleteTemplates($templates_id) {
		$query  = $this->db->query("SELECT * FROM ".DB_PREFIX."templates WHERE templates_id = '" . (int)$templates_id . "'");
		
		if(isset($query->row['filename_mp4'])){
			if(!empty($query->row['filename_mp4']) && file_exists(DIR_TEMPLATES . $query->row['filename_mp4']))
				@unlink(DIR_TEMPLATES . $query->row['filename_mp4']);
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "templates WHERE templates_id = '" . (int)$templates_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "templates_description WHERE templates_id = '" . (int)$templates_id . "'");
		/*{MODEL_DELETE}*/
		
		$this->cache->delete('templates');
	}
	
	/*{MODEL_GET_IMAGES}*/
	
	public function getVideoById($id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "templates WHERE templates_id = '" . (int)$id . "'");

		return $query->row;
	}
	
	/*{MODEL_GET_VIDEO}*/
	
	public function getTemplates($templates_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'templates_id=" . (int)$templates_id . "') AS keyword FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.templates_id = '" . (int)$templates_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPdf($templates_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE p.templates_id = '" . (int)$templates_id . "'");
		
		return $query->rows;
	}
	
	public function getTemplatess($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 						
			
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
				$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
			}
			
			/*{MODEL_FILTER}*/
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
			                   'pd.name',				
			                   'p.status',
			                   'p.sort_order'
			                   );	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY pd.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	

			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {
			$templates_data = $this->cache->get('templates.' . $this->config->get('config_language_id'));
			
			if (!$templates_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
				
				$templates_data = $query->rows;
				
				$this->cache->set('templates.' . $this->config->get('config_language_id'), $templates_data);
			}	
			
			return $templates_data;
		}
	}
	
	public function getTemplatesDescriptions($templates_id) {
		$templates_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "templates_description WHERE templates_id = '" . (int)$templates_id . "'");
		
		foreach ($query->rows as $result) {
			$templates_description_data[$result['language_id']] = array(
			                                                            'name'             => $result['name'],
			                                                            /*{MODEL_GET_DESCRIPTION}*/
			                                                            'description'      => $result['description']
			                                                            );
		}
		
		return $templates_description_data;
	}
	
	public function getTotalTemplatess($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$filter_name = mb_strtolower($this->db->escape($data['filter_name']),'utf8');
			$sql .= " AND LOWER(CONVERT(pd.name USING utf8)) LIKE '%$filter_name%'";
		}
		
		/*{MODEL_FILTER}*/
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getCateById($id){
		$sql = "SELECT category_id FROM " . DB_PREFIX . "templates WHERE templates_id = '" . (int)$id . "'"; 						
		
		$query = $this->db->query($sql);
		return isset($query->row['category_id'])?(int)$query->row['category_id']:0;
	}	
	
	public function getTitle($cate){
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "templates_description WHERE language_id = '".(int)$this->config->get('config_language_id')."' AND templates_id='".(int)$cate."'");
		
		return $query->row['name'];
	}	
	
	public function getTemplatesForPage() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "templates p LEFT JOIN " . DB_PREFIX . "templates_description pd ON (p.templates_id = pd.templates_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");

		
		return $query->rows;
	}	
	
	public function getDownloadOrVideos($module) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->db->escape($module) . " p LEFT JOIN " . DB_PREFIX .  $this->db->escape($module) . "_description pd ON (p." .$this->db->escape($module). "_id = pd.".$this->db->escape($module)."_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
		
		$data = array();
		
		foreach($query->rows as $item){
			$data[] = array('id'=>$item[$this->db->escape($module) . '_id'], 'name'=>$item['name']);
		}
		
		return $data;
	}	
}
?>