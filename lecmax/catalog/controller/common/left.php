<?php  
class ControllerCommonLeft extends Controller {
	public function index() {
		
		$this->load->model('cms/common');
		$this->data['menus'] = $this->model_cms_common->getMenu(0,1);

		$path = isset($this->request->get['path'])?$this->request->get['path']:0;
		$tmp_paths = explode('_', $path);
		/*if((int)$tmp_paths[0]==0)		
		$this->redirect($this->url->link('error/not_found'));	*/	
		$this->data['menu_active'] = $tmp_paths[0];		


		$query = $this->registry->get('db')->query("SELECT * FROM " . DB_PREFIX . "language WHERE code<>'".$this->config->get('config_language')."'"); 

		$this->data['languages'] = $query->rows;

		$this->data['lang'] = ($this->config->get('config_language')=='vi')?'':'en';
		
		$this->data['action'] = $this->url->link('common/home');

		if (!isset($this->request->get['route'])) {
			$this->data['redirect'] = $this->url->link('common/home');
		} else {
			$data = $this->request->get;

			unset($data['_route_']);

			$route = $data['route'];

			unset($data['route']);

			$url = '';

			if ($data) {
				$url = '&' . urldecode(http_build_query($data));
			}

			$this->data['redirect'] = $this->url->link($route, $url) . '.html';		

		}		

		$this->data['enter'] = HTTP_SERVER;
		/*
		if($tmp_paths[0]==28)
			$this->data['enter'] = HTTP_SERVER;
		else
			$this->data['enter'] = $this->url->link('cms/home','path=28').'.html';
		*/
			$this->data['logo'] = ($this->config->get('language_code')=='en')? HTTP_IMAGE . $this->config->get('config_logo_en'): HTTP_IMAGE . $this->config->get('config_logo');	

			if(isset($this->request->get['route']) && $this->request->get['route']=='cms/parents'){
				$this->data['menu_parents'] = $this->model_cms_common->getMenu($tmp_paths[0],0);
				if(isset($tmp_paths[1]))
					$this->data['cur_parent'] = $tmp_paths[1];
				else{
					$tmp = reset($this->data['menu_parents']);
					$this->data['cur_parent'] = $tmp['id'];
				}

				$this->data['background'] = $this->model_cms_common->getBackground($this->data['cur_parent']);
				$template = 'left_forparent.tpl';
			}else
			$template = 'left.tpl';

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $template)) {
				$this->template = $this->config->get('config_template') . '/template/common/' . $template;
			} else {
				$this->template = 'default/template/common/' . $template;
			}

			$this->render();
		}
	}
	?>