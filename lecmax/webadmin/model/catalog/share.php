<?php
class ModelCatalogShare extends Model {
	
	public function editShare($data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_facebook']) . "'
		                 WHERE `key` = 'config_link_facebook'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_linkedin']) . "'
		                 WHERE `key` = 'config_link_linkedin'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_twitter']) . "'
		                 WHERE `key` = 'config_link_twitter'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_email']) . "'
		                 WHERE `key` = 'config_link_email'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_youtube']) . "'
		                 WHERE `key` = 'config_link_youtube'");

		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_googleplus']) . "'
		                 WHERE `key` = 'config_link_googleplus'");

		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_nick_yahoo']) . "'
		                 WHERE `key` = 'config_nick_yahoo'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_nick_skype']) . "'
		                 WHERE `key` = 'config_nick_skype'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting
		                 SET `value` = '" . $this->db->escape($data['config_hotline']) . "'
		                 WHERE `key` = 'config_hotline'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_intergram']) . "'
		                 WHERE `key` = 'config_link_intergram'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['config_link_pinterest']) . "'
		                 WHERE `key` = 'config_link_pinterest'");
		
		
		
		
	}
}
?>