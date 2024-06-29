<?php
class ModelCatalogUninstall extends Model {

	public function getModules($frontend=2) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "module` WHERE frontend = '" . (int)$frontend . "'";
		$sql .= " AND name<>'header' AND name<>'footer' AND name<>'login' AND name<>'global' AND name<>'install' AND name<>'standard' AND name<>'lang' AND name<>'menu' AND name<>'adminmenu'";

		$query = $this->db->query($sql);

		return $query->rows;

	}

	public function uninstallLanguage($module){
		$sql = "DELETE FROM " . DB_PREFIX . "module WHERE `name` = '" . $this->db->escape($module) . "'";
		$this->db->query($sql);

		/*=======xoa du lieu==============*/
		$sql = "DELETE FROM " . DB_PREFIX . "lang_description WHERE `lang_id` IN (SELECT lang_id FROM " . DB_PREFIX . "lang WHERE `module`='" . $this->db->escape($module) . "')";
		$this->db->query($sql);
		$sql = "DELETE FROM " . DB_PREFIX . "lang WHERE `module` ='" . $this->db->escape($module) . "'";
		$this->db->query($sql);
	}

	public function uninstallDatabase($module){
		$sql = "DROP TABLE IF EXISTS `" . $module . "_description`";
		$this->db->query($sql);

		$sql = "DROP TABLE IF EXISTS `" . $module . "_image`";
		$this->db->query($sql);

		$sql = "DROP TABLE IF EXISTS `" . $module . "`";
		$this->db->query($sql);

		$query = $this->db->escape($module) . "_id=";
		$leng = strlen($query);

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE SUBSTR(`query`,1,".(int)$leng.") = '" . $query . "'");
		// sitemap
		$this->db->query("DELETE FROM " . DB_PREFIX . "sitemap WHERE name='" . $module ."'");

	}
}
?>