<?php
class ControllerCatalogSortOrder extends Controller {
	public function index() {
		$table = isset($this->request->post['t'])?$this->request->post['t']:'';
		$id = isset($this->request->post['id'])?$this->request->post['id']:0;
		$sort_order = isset($this->request->post['sort_order'])?$this->request->post['sort_order']:0;
		$ishome = isset($this->request->post['ishome']) ? $this->request->post['ishome']:-1;
		$status = isset($this->request->post['status']) ? $this->request->post['status']:-1;
		$cate_type = isset($this->request->post['cate_type']) ? $this->request->post['cate_type']:'';
		$cate = isset($this->request->post['cate']) ? $this->request->post['cate']:-1;
		$project_id = isset($this->request->post['projectid']) ? $this->request->post['projectid']:-1;
		$category_id = isset($this->request->post['categoryid']) ? $this->request->post['categoryid']:-1;
		$parent_id = isset($this->request->post['parent_id']) ? $this->request->post['parent_id']:-1;

		$data = array('table'=>$table,'id'=>$id,'sort_order'=>$sort_order,'ishome'=>$ishome,'status'=>$status,'cate_type'=>$cate_type,'cate'=>$cate,'project_id'=>$project_id,'category_id'=>$category_id,'parent_id'=>$parent_id);
		
		if(isset($this->request->post['isclick']) && $this->request->post['isclick']==1){
			$this->session->data['stt_thaydoi'] = $sort_order;
			die;
		}

		if(!empty($table) && (int)$id>0 && $ishome!=-1) {
			$this->load->model('catalog/sortorder');
			$this->model_catalog_sortorder->updateIshome($data);
		} elseif (!empty($table) && (int)$id>0 && $status!=-1){
			$this->load->model('catalog/sortorder');
			$this->model_catalog_sortorder->updateStatus($data);
		} else {
			$this->load->model('catalog/sortorder');
			$this->model_catalog_sortorder->updateOrder($data);
		}
		if(!empty($table)){
			
			if($table=='news'){
				$this->load->model('catalog/news');
				$news_info                      = $this->model_catalog_news->getNews($data['id']);
                $category_id = isset($news_info['category_id'])?$news_info['category_id']:0;
				//print_r($news_info);
				//$this->buildcachenews(array('category_id'=>$category_id));
			}elseif($table=='service'){
				$this->load->model('catalog/service');
				$service_info                      = $this->model_catalog_service->getService($data['id']);
                $category_id = isset($service_info['category_id'])?$service_info['category_id']:0;
				//print_r($news_info);
				$this->buildcacheservice(array('category_id'=>$category_id));
			}elseif($table=='category'){
				if(isset($this->request->post['cate_type']) && $this->request->post['cate_type']=='catenews'){
				//$this->buildcachenews(array('category_id'=>$data['id']));
				}elseif(isset($this->request->post['cate_type']) && $this->request->post['cate_type']=='cateservice'){
				$this->buildcacheservice(array('category_id'=>$data['id']));
				}
				$this->cache->delete('');
			}elseif($table=='category' || $table=='floor' || $table=='apartment'  || $table=='apartmentinfo'){
				$this->cache->delete('');
			}
			
			$this->cache->delete($table);
		}
		echo "update sort order success";
		die;
		//$this->load->library('json');

		//$this->response->setOutput(Json::encode($json));
	}
}
?>