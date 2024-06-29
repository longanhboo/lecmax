<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
	
	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}
	
	protected function getChild($child, $args = array()) {
		$action = new Action($child, $args);
		$file = $action->getFile();
		$class = $action->getClass();
		$method = $action->getMethod();
		//$args = $action->getArgs();
		
		if (file_exists($file)) {
			require_once($file);

			$controller = new $class($this->registry);
			
			$controller->$method($args);
			
			return $controller->output;
		} else {
			exit('Error: Could not load controller ' . $child . '!');
		}		
	}
	
	protected function render() {
		foreach ($this->children as $child) {
			$this->data[basename($child)] = $this->getChild($child);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->template)) {
			extract($this->data);
			
			ob_start();
			
			require(DIR_TEMPLATE . $this->template);
			
			$this->output = ob_get_contents();

			ob_end_clean();
			
			return $this->output;
		} else {
			exit('Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!');
		}
	}
        
        protected function render2($dir = DIR_TEMPLATE) {
		foreach ($this->children as $child) {
			$this->data[basename($child)] = $this->getChild($child);
		}
		
		if (file_exists($dir . $this->template)) {
			extract($this->data);
			
			ob_start();
			
			require($dir . $this->template);
			
			$this->output = ob_get_contents();

			ob_end_clean();
			
			return $this->output;
		} else {
			exit('Error: Could not load template ' . $dir . $this->template . '!');
		}
	}
        
        protected function render3($dir = DIR_TEMPLATE) {
		foreach ($this->children3 as $child) {
			$this->data3[basename($child)] = $this->getChild($child);
		}
		
		if (file_exists($dir . $this->template3)) {
			extract($this->data);
			
			ob_start();
			
			require($dir . $this->template3);
			
			$this->output3 = ob_get_contents();

			ob_end_clean();
			
			return $this->output3;
		} else {
			exit('Error: Could not load template ' . $dir . $this->template3 . '!');
		}
	}
        
        public function loadCache($params=NULL,$cache_time = 86400,$fullload = FALSE){
            
            if($params){
                $cache_file     = DIR_CACHE.md5($params).'.html'; // construct a cache file
            } else {
                $dynamic_url    = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // requested dynamic page (full url)
                $cache_file     = DIR_CACHE.md5($dynamic_url).'.html'; // construct a cache file
            }
            
            if (file_exists($cache_file) && time() - $cache_time < filemtime($cache_file)) { //check Cache exist and it's not expired.
                ob_start('ob_gzhandler'); //Turn on output buffering, "ob_gzhandler" for the compressed page with gzip.                
                if($fullload){
                    readfile($cache_file); //read Cache file
                    echo "\n".'<!-- cached page - '.date('l jS \of F Y h:i:s A', filemtime($cache_file)).' -->';
                    ob_end_flush(); 
                    exit();
                } else {
                    $fh             = fopen($cache_file, "rb");
                    $data           = fread($fh, filesize($cache_file));
                    fclose($fh); 
                }
                
                return array('success'=>true,'data'=>$data);
            } else {
                return array('success'=>false,'data'=>$cache_file);
            }            
            
        }
        
        public function endLoadCache($cache_file,$content){
            
            ob_start('ob_gzhandler');                        
            if (!is_dir(DIR_CACHE)) { //create a new folder if we need to
                mkdir(DIR_CACHE);
            }
            
            $fp = fopen($cache_file, 'w');  //open file for writing
            fwrite($fp, $content); //write contents of the output buffer in Cache file
            fclose($fp); //Close file pointer
            
            //ob_end_flush(); //Flush and turn off output buffering
            return true;
        }
        
        public function updateCache($url_files,$data){
            $cache_file     = DIR_CACHE.md5($url_files).'.html'; // construct a cache file
            if (file_exists($cache_file)){
                unlink($cache_file);
            }
            return $this->endLoadCache($cache_file,$data);
        }
        
        public function getSeoFixed($params1){
            $this->load->model('cms/common');
            $seo = $this->model_cms_common->getSeoFixed($params1);
            
            $this->document->setKeywords($seo['meta_keyword']);
            $this->document->setDescription($seo['meta_description']);
            $this->document->setTitle($seo['meta_title']);
            $this->document->setDescriptionog($seo['meta_description_og']);
            $this->document->setTitleog($seo['meta_title_og']);
            $this->document->setImageog($seo['image_og']);
            
        }
		
		public function buildcachenews($data=array()){
			$this->load->model('catalog/news');
			$this->load->model('catalog/category');
			
			$this->data['hrefpage'] = 'HTTP_CATALOG' . 'vi/' . $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS,'2') . '.html';
			
			$this->data['submenu']            = $this->model_catalog_category->getFrontendCategoryChild(ID_NEWS,'t2.category_id,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id','ORDER BY  t1.sort_order ASC, t1.category_id DESC');
			foreach($this->data['submenu'] as $key=>$item){
				$this->data['submenu'][$key]['href'] = 'HTTP_CATALOG' . 'vi/' . $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS,'2') . '/' . $this->model_catalog_news->getFriendlyUrl('category_id='.$item['category_id'],'2') . '.html';
				$this->data['submenu'][$key]['url_current'] = $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS,'2') . '/' . $this->model_catalog_news->getFriendlyUrl('category_id='.$item['category_id'],'2');
				
				$this->data['submenu'][$key]['newss'] = $this->model_catalog_news->getNewsByCateFixed($item['category_id'],'t2.news_id,t2.desc_short,t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew','ORDER BY  t1.sort_order ASC, t1.news_id DESC');
				
			}
			
			/*$this->data['url_current'] = $this->model_catalog_news->getFriendlyUrl('category_id='.ID_NEWS,'2') . '/' . $this->model_catalog_news->getFriendlyUrl('category_id='.$data['category_id'],'2');
			
			$this->data['newss'] = $this->model_catalog_news->getNewsByCateFixed($data['category_id'],'t2.news_id,t2.desc_short,t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew','ORDER BY  t1.sort_order ASC, t1.news_id DESC');
			*/
			//$cache_file     = DIR_CACHE.md5('news_index@1' . ID_NEWS . '.' . $data['category_id']).'.html';
			$cache_file     = DIR_CACHE.md5('news_index@1' . ID_NEWS).'.html';
            if (file_exists($cache_file)){
                unlink($cache_file);
            }
			$this->template                = 'catalog/news/news_page_slider.tpl';
			//$this->updateCache('news_index@' . $this->config->get('config_language_id') . ID_NEWS. '.' . $data['category_id'], $this->render());
			$this->updateCache('news_index@' . $this->config->get('config_language_id') . ID_NEWS, $this->render());
			
		}
		
		
		public function buildcacheservice($data=array()){
			$this->load->model('catalog/service');
			$this->load->model('catalog/category');
			
			$this->data['hrefpage'] = 'HTTP_CATALOG' . 'vi/' . $this->model_catalog_service->getFriendlyUrl('category_id='.ID_SERVICE,'2') . '.html';
			
			$this->data['submenu']            = $this->model_catalog_category->getFrontendCategoryChild(ID_SERVICE,'t2.category_id,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id','ORDER BY  t1.sort_order ASC, t1.category_id DESC');
			foreach($this->data['submenu'] as $key=>$item){
				$this->data['submenu'][$key]['href'] = 'HTTP_CATALOG' . 'vi/' . $this->model_catalog_service->getFriendlyUrl('category_id='.ID_SERVICE,'2') . '/' . $this->model_catalog_service->getFriendlyUrl('category_id='.$item['category_id'],'2') . '.html';
				$this->data['submenu'][$key]['url_current'] = $this->model_catalog_service->getFriendlyUrl('category_id='.ID_SERVICE,'2') . '/' . $this->model_catalog_service->getFriendlyUrl('category_id='.$item['category_id'],'2');
				
				$this->data['submenu'][$key]['services'] = $this->model_catalog_service->getServiceByCateFixed($item['category_id'],'t2.service_id,t2.desc_short,t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew','ORDER BY  t1.sort_order ASC, t1.service_id DESC');
				
			}
			
			/*$this->data['url_current'] = $this->model_catalog_service->getFriendlyUrl('category_id='.ID_SERVICE,'2') . '/' . $this->model_catalog_service->getFriendlyUrl('category_id='.$data['category_id'],'2');
			
			$this->data['services'] = $this->model_catalog_service->getServiceByCateFixed($data['category_id'],'t2.service_id,t2.desc_short,t2.description,t2.name,t2.meta_keyword,t2.meta_description,t2.meta_title,t2.meta_description_og,t2.meta_title_og,t1.image,t1.category_id, t1.isnew','ORDER BY  t1.sort_order ASC, t1.service_id DESC');
			*/
			//$cache_file     = DIR_CACHE.md5('service_index@1' . ID_SERVICE . '.' . $data['category_id']).'.html';
			$cache_file     = DIR_CACHE.md5('service_index@1' . ID_SERVICE).'.html';
            if (file_exists($cache_file)){
                unlink($cache_file);
            }
			$this->template                = 'catalog/service/service_page_slider.tpl';
			//$this->updateCache('service_index@' . $this->config->get('config_language_id') . ID_SERVICE. '.' . $data['category_id'], $this->render());
			$this->updateCache('service_index@' . $this->config->get('config_language_id') . ID_SERVICE, $this->render());
			
		}
}
?>