<?php
class ModelCatalogSortOrder extends Model {

	public function updateOrder($data) {
		
		/*if($data['table']!='adminmenu'){
		if(isset($this->session->data['stt_thaydoi'])){
			$str = '';
			if(!empty($data['cate_type'])){
				
				if($data['cate_type']=='menu'){
					$str .= " AND parent_id='0' ";
				}else{
					$str .= " AND parent_id<>'0' AND path='" . str_replace('cate','',(string)$data['cate_type']) . "'  ";
				}
			}
			
			if(isset($data['cate']) && $data['cate']!=-1){
				$str .= " AND cate='" . $data['cate'] . "' ";
			}
			
			if(isset($data['category_id']) && $data['category_id']!=-1){
				$str .= " AND category_id='" . $data['category_id'] . "' ";
			}
			
			if(isset($data['parent_id']) && $data['parent_id']!=-1){
				$str .= " AND parent_id='" . $data['parent_id'] . "' ";
			}
			
			if(isset($data['project_id']) && $data['project_id']!=-1){
				$str .= " AND project_id='" . $data['project_id'] . "' ";
			}
			
			if($this->session->data['stt_thaydoi']<$data['sort_order']){
			
				$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET sort_order = sort_order-1
		                 WHERE sort_order>" . $this->session->data['stt_thaydoi'] . " AND sort_order<=" . $data['sort_order'] . " $str ");
			
			}else{
				
				$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET sort_order = sort_order+1
		                 WHERE sort_order<" . $this->session->data['stt_thaydoi'] . " AND sort_order>=" . $data['sort_order'] . " $str ");
			}
		}
		}*/

		$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET sort_order = '" . (int)$data['sort_order'] . "'
		                 WHERE ".$data['table']."_id = '" . (int)$data['id'] . "'");
	}

	public function updateIshome($data) {
		$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET ishome = '" . (int)$data['ishome'] . "'
		                 WHERE ".$data['table']."_id = '" .(int)$data['id'] . "'");
	}

	public function updateStatus($data) {
		$this->db->query("UPDATE `" . DB_PREFIX . $data['table']. "`
		                 SET status = '" . (int)$data['status'] . "'
		                 WHERE ".$data['table']."_id = '" .(int)$data['id'] . "'");
	}
}
?>