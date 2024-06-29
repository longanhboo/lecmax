<?php
class ModelCatalogLogo extends Model {

	public function editLogo($data) {
		/*SLOGAN*/
		if (isset($data['image_delete_slogan']) && $data['image_delete_slogan']==1) {
			if (isset($data['image_slogan'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_image_slogan'");
			}
		} else {
			if(isset($data['image_slogan'])){
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_slogan']) . "'
				                 WHERE `key` = 'config_image_slogan'");
			}
		}

		if (isset($data['image_delete_slogan_en']) && $data['image_delete_slogan_en']==1) {
			if (isset($data['image_slogan_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_image_slogan_en'");
			}
		} else {
			if (isset($data['image_slogan_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_slogan_en']) . "'
				                 WHERE `key` = 'config_image_slogan_en'");
			}
		}

		/*LOGO*/
		if (isset($data['image_delete_logo']) && $data['image_delete_logo']==1) {
			if (isset($data['image_logo'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_logo'");
			}
		} else {
			if (isset($data['image_logo'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_logo']) . "'
				                 WHERE `key` = 'config_logo'");
			}
		}

		if (isset($data['image_delete_logo_en']) && $data['image_delete_logo_en']==1) {
			if (isset($data['image_logo_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_logo_en'");
			}
		} else {
			if (isset($data['image_logo_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_logo_en']) . "'
				                 WHERE `key` = 'config_logo_en'");
			}
		}
		
		/*hotline*/
		if (isset($data['image_delete_hotline']) && $data['image_delete_hotline']==1) {
			if (isset($data['image_hotline'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_image_hotline'");
			}
		} else {
			if (isset($data['image_hotline'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_hotline']) . "'
				                 WHERE `key` = 'config_image_hotline'");
			}
		}

		if (isset($data['image_delete_hotline_en']) && $data['image_delete_hotline_en']==1) {
			if (isset($data['image_hotline_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_image_hotline_en'");
			}
		} else {
			if (isset($data['image_hotline_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_hotline_en']) . "'
				                 WHERE `key` = 'config_image_hotline_en'");
			}
		}

		/*POPUP*/
		if (isset($data['image_delete_popup']) && $data['image_delete_popup']==1) {
			if (isset($data['image_popup'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_popup'");
			}
		} else {
			if (isset($data['image_popup'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_popup']) . "'
				                 WHERE `key` = 'config_popup'");
			}
		}

		if (isset($data['image_delete_popup_en']) && $data['image_delete_popup_en']==1) {
			if (isset($data['image_popup_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = ''
				                 WHERE `key` = 'config_popup_en'");
			}
		} else {
			if (isset($data['image_popup_en'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting
				                 SET `value` = '" . $this->db->escape($data['image_popup_en']) . "'
				                 WHERE `key` = 'config_popup_en'");
			}
		}

		/*CONFIG*/
		/*popup*/
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['config_link_popup'])) . "'
		                 WHERE `key` = 'config_link_popup'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['config_link_popup_en'])) . "'
		                 WHERE `key` = 'config_link_popup_en'");
		
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['config_link_shareholder'])) . "'
		                 WHERE `key` = 'config_link_shareholder'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['config_link_realtimetable'])) . "'
		                 WHERE `key` = 'config_link_realtimetable'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape(str_replace(HTTP_CATALOG,'HTTP_CATALOG',(string)$data['config_link_360'])) . "'
		                 WHERE `key` = 'config_link_360'");
		
		
		/*slogan*/
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_slogan']) . "'
		                 WHERE `key` = 'config_slogan'");

		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_slogan_en']) . "'
		                 WHERE `key` = 'config_slogan_en'");
						 
		/*popup*/
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_hotline']) . "'
		                 WHERE `key` = 'config_hotline'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_email_contact_info']) . "'
		                 WHERE `key` = 'config_email_contact_info'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_hotline1']) . "'
		                 WHERE `key` = 'config_hotline1'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_picture']) . "'
			WHERE `key` = 'config_loop_picture'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_home_nhamau']) . "'
			WHERE `key` = 'config_loop_home_nhamau'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_about_video']) . "'
			WHERE `key` = 'config_loop_about_video'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_about_album']) . "'
			WHERE `key` = 'config_loop_about_album'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_project_tongquan']) . "'
			WHERE `key` = 'config_loop_project_tongquan'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_project_quymo']) . "'
			WHERE `key` = 'config_loop_project_quymo'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_project_tienich']) . "'
			WHERE `key` = 'config_loop_project_tienich'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_house_model']) . "'
			WHERE `key` = 'config_loop_house_model'");
		
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_library_phaply']) . "'
			WHERE `key` = 'config_loop_library_phaply'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_library_album']) . "'
			WHERE `key` = 'config_loop_library_album'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_library_video']) . "'
			WHERE `key` = 'config_loop_library_video'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
			SET `value` = '" . $this->db->escape($data['config_loop_library_brochure']) . "'
			WHERE `key` = 'config_loop_library_brochure'");
		
		
		
	}

	public function getLogo() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'config_logo' OR `key` = 'config_logo_en'");

		return $query->row;
	}
}
?>