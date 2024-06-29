<?php
class ControllerCatalogStatus extends Controller {
	public function index() {
		$table = isset($this->request->post['t'])?$this->request->post['t']:'';
		$id = isset($this->request->post['id'])?$this->request->post['id']:0;
		$sort_status = isset($this->request->post['status'])?$this->request->post['status']:0;;

		$data = array('table'=>$table,'id'=>$id,'status'=>$sort_status);

		if (!empty($table) && (int)$id>0) {
			$this->load->model('catalog/status');
			$this->model_catalog_status->updateStatus($data);
			$this->cache->delete($table);
		}
		echo "update status success";
		die;
		//$this->load->library('json');

		//$this->response->setOutput(Json::encode($json));
	}
}
?>