<?php
class ModelCatalogStatus extends Model {

	public function updateStatus($data) {

		$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET status = '" . (int)$data['status'] . "'
		                 WHERE ".$data['table']."_id = '" . (int)$data['id'] . "'");
	}
}
?>