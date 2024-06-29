<?php
class ModelCatalogEmailContact extends Model {
	
	public function editEmailContact($data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['email_contact']) . "'
		                 WHERE `key` = 'config_email_contact'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['email_contact_register']) . "'
		                 WHERE `key` = 'config_email_contact_register'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['email_order']) . "'
		                 WHERE `key` = 'config_email_order'");
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['protocol']) . "'
		                 WHERE `key` = 'config_mail_protocol'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['parameter']) . "'
		                 WHERE `key` = 'config_mail_parameter'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['hostname']) . "'
		                 WHERE `key` = 'config_smtp_host'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['username']) . "'
		                 WHERE `key` = 'config_smtp_username'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['password']) . "'
		                 WHERE `key` = 'config_smtp_password'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['port']) . "'
		                 WHERE `key` = 'config_smtp_port'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "setting 
		                 SET `value` = '" . $this->db->escape($data['timeout']) . "'
		                 WHERE `key` = 'config_smtp_timeout'");
		
	}
	
	public function getEmailContact() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'config_email_contact' || `key` = 'config_mail_protocol' || `key` = 'config_mail_parameter' || `key` = 'config_smtp_port' || `key` = 'config_smtp_timeout' || `key` = 'config_smtp_password' || `key` = 'config_smtp_username' || `key` = 'config_smtp_host'");
		
		return $query->rows;
	}
}
?>