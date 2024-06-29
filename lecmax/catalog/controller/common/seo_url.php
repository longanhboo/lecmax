<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			if($this->request->get['_route_']==$this->config->get('config_language').'/'){
			}else{
				foreach ($parts as $part) {
					if($part==$this->config->get('config_language')){
						$this->request->get['language'] = $part;
						continue;
					}
					
					if(strrchr($part,'.')=='.html')
						$part = substr($part,0,strlen($part)-5);
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
					
					$pagenews = mb_strcut($part,0,5);
					$pagenews_stt = str_ireplace($pagenews,'',$part);
				   
					if($pagenews=='page-')
					$this->request->get['page'] = $pagenews_stt;
					elseif($pagenews=='year-' || $pagenews=='nam--')
			   		$this->request->get['getyear'] = $pagenews_stt;
					else{
					if ($query->num_rows) {
						
						$url = explode('=', $query->row['query']);					                    
						
						if ($url[0] == 'aboutus_id') {
							$this->request->get['aboutus_id'] = $url[1];
						}
						
						if ($url[0] == 'subcateproduct_id') {
							$this->request->get['subcateproduct_id'] = $url[1];
						}
						
						if ($url[0] == 'solution_id') {
							$this->request->get['solution_id'] = $url[1];
						}
						
						if ($url[0] == 'document_id') {
							$this->request->get['document_id'] = $url[1];
						}
						
						if ($url[0] == 'khuvuc_id') {
							$this->request->get['khuvuc_id'] = $url[1];
						}
						
						if ($url[0] == 'distribution_id') {
							if (count($parts) > 2 && !isset($this->request->get['catedistribution'])) {
								$this->request->get['catedistribution'] = $url[1];
							}
							$this->request->get['distribution_id'] = $url[1];
						}
						
						if ($url[0] == 'showroom_id') {
							if (count($parts) > 2 && !isset($this->request->get['cateshowroom'])) {
								$this->request->get['cateshowroom'] = $url[1];
							}
							$this->request->get['showroom_id'] = $url[1];
						}
						
						if ($url[0] == 'gallery_id') {
							$this->request->get['gallery_id'] = $url[1];
						}
						
						if ($url[0] == 'news_id') {
							$this->request->get['news_id'] = $url[1];
						}
						
						if ($url[0] == 'service_id') {
							if (count($parts) > 2 && !isset($this->request->get['cateservice'])) {
								$this->request->get['cateservice'] = $url[1];
							}
							$this->request->get['service_id'] = $url[1];
						}
						
						if ($url[0] == 'product_id') {
							$this->request->get['product_id'] = $url[1];
						}
						
						if ($url[0] == 'projectprogress_id') {
							$this->request->get['projectprogress_id'] = $url[1];
						}
						
						if ($url[0] == 'accessories_id') {
							$this->request->get['accessories_id'] = $url[1];
						}
						
						if ($url[0] == 'project_id') {
							if (count($parts) > 2 && !isset($this->request->get['cateproject'])) {
								$this->request->get['cateproject'] = $url[1];
							}
							$this->request->get['project_id'] = $url[1];
						}
						
						if ($url[0] == 'contact_id') {
							$this->request->get['contact_id'] = $url[1];
						}
						
						if ($url[0] == 'business_id') {
							if (count($parts) > 2 && !isset($this->request->get['catebusiness'])) {
								$this->request->get['catebusiness'] = $url[1];
							}
							$this->request->get['business_id'] = $url[1];
						}
						
						if ($url[0] == 'recruitment_id') {
							if (count($parts) > 2 && !isset($this->request->get['caterecruitment'])) {
								$this->request->get['caterecruitment'] = $url[1];
							}
							$this->request->get['recruitment_id'] = $url[1];
						}
						
						if ($url[0] == 'floor_id') {
							/*if (count($parts) > 2 && !isset($this->request->get['catefloor'])) {
								$this->request->get['catefloor'] = $url[1];
							}*/
							$this->request->get['floor_id'] = $url[1];
						}
						
						if ($url[0] == 'category_id') {
							if (!isset($this->request->get['path'])) {															
								$this->request->get['path'] = $url[1];							
							} else {														
								$this->request->get['path'] .= '_' . $url[1];							
							}
						}
						
	
						if($url[0]=='route')
							$this->request->get['route'] = $url[1];	
					} else {
						$this->request->get['route'] = 'error/not_found';	
					}
					}
				}
			}
			if(!isset($this->request->get['path'])){
				$this->request->get['path']='';
			}
			if($this->request->get['_route_']==$this->config->get('config_language').'/'){
			}else{
				if(!isset($this->request->get['route'])){
					$tmp = explode('_',$this->request->get['path']);
					$pathend = end($tmp);
					$qr = $this->db->query("SELECT path FROM ".DB_PREFIX."category WHERE category_id='" .(int)$pathend. "'");
					
					if(empty($qr->row['path'])){
						$this->getRoute($pathend);
					}else{
						$this->request->get['route'] = 'cms/' . $qr->row['path'];
					}								                                           
				}
			}
			
			if(isset($this->request->get['route']) && $this->request->get['route']=='cms/amp'){
				
			}else{
			//if(isset($this->request->get['project_id']))
				//$this->request->get['route'] = $this->request->get['route'] . '/detail';
				
				if(isset($this->request->get['news_id']))
				$this->request->get['route'] = $this->request->get['route'] . '/detail';
				
				if(isset($this->request->get['accessories_id']))
				$this->request->get['route'] = $this->request->get['route'] . '/detail';
				
				if(isset($this->request->get['product_id']))
				$this->request->get['route'] = $this->request->get['route'] . '/detail';
				
				
			}
				
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		
		}
	}
	
	private function getRoute($id){
		$qr1 = $this->db->query("SELECT * FROM ".DB_PREFIX."category WHERE parent_id='" .(int)$id. "' ORDER BY sort_order ASC LIMIT 1");
		if(empty($qr1->row['path'])){
			$this->request->get['path'] .= '_' . $qr1->row['category_id'];
			$this->getRoute($qr1->row['category_id']);
		}else{
			$this->request->get['path'] .= '_' . $qr1->row['category_id'];
			$this->request->get['route'] = 'cms/' . $qr1->row['path'];
		}
	}
	
	public function rewrite($link,$language_code='') {
		//$language_id = $this->config->get('config_language_id');
		$query_lang = $this->registry->get('db')->query("SELECT * FROM " . DB_PREFIX . "language p  WHERE code='".$language_code . "'"); 
		$language_id = isset($query_lang->row['language_id'])?$query_lang->row['language_id']:2;

		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));
			
			$url = ''; 
			
			$data = array();
			
			parse_str($url_data['query'], $data);
			
			foreach ($data as $key => $value) {
				if ( ($key == 'contact_id')  || ($key == 'news_id') || ($key == 'aboutus_id') || ($key == 'recruitment_id') || ($key == 'accessories_id') || ($key == 'floor_id')  || ($key == 'project_id') || ($key == 'business_id') || ($key == 'service_id') || ($key == 'product_id') || ($key == 'projectprogress_id') || ($key == 'subcateproduct_id') || ($key == 'solution_id') || ($key == 'showroom_id') || ($key == 'distribution_id') || ($key == 'gallery_id') || ($key == 'khuvuc_id') || ($key == 'document_id')  ) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'  AND lang='".$language_id."'");
					
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						
						unset($data[$key]);
					}					
				} elseif ($key == 'language') {
                    $url .= '/' . $value;
                    unset($data['language']);
                } elseif ($key == 'caterecruitment') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'recruitment_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['caterecruitment']);
				} elseif ($key == 'cateservice') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'service_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['cateservice']);
				} elseif ($key == 'catebusiness') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'business_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['catebusiness']);
				} elseif ($key == 'cateproject') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'project_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['cateproject']);
				}elseif ($key == 'catedistribution') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'distribution_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['catedistribution']);
				} elseif ($key == 'cateshowroom') {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'showroom_id=" . (int) $value . "'  AND lang='".$language_id."'");
                    if ($query->num_rows) {
                        $url .= '/' . $query->row['keyword'];
                    }
                    unset($data['cateshowroom']);
				} elseif ($key == 'getyear') {
					if($language_id==1){
						$url .= '/year-' . $value;
					}else{
                    	$url .= '/nam--' . $value;
					}
                    unset($data['getyear']);
                } elseif ($key == 'page') {
                    $url .= '/page-' . $value;
                    unset($data['page']);
                } elseif ($key == 'path') {
					$categories = explode('_', $value);
					
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'  AND lang='".$language_id."'");
						
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						}							
					}
					
					unset($data[$key]);
				}
			}
			
			if ($url) {
				unset($data['route']);
				
				$query = '';
				
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}

				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}		
	}	
}
?>