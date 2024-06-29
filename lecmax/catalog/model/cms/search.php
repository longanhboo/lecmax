<?php
class ModelCmsSearch extends Model {		
	
	public function getSearchs($qsearch){
		$data = array();
		$q = mb_strtolower($this->db->escape($qsearch),'utf8');
		
		$this->load->model('cms/common');
		$this->load->model('cms/product');
		$q_temp = htmlentities($q);
		
		
		//product		
		
		//, (SELECT td.name FROM " . DB_PREFIX . "product t LEFT JOIN " . DB_PREFIX . "product_description td ON (t.product_id = td.product_id) WHERE t.status='1' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t.product_id=p.cate ) as pname
		$sql = "SELECT p.product_id, p.category_id, pd.name, pd.desc_short, pd.description, p.date_modified, p.date_added FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%'  OR LOWER(CONVERT(pd.desc_short USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.namethongso USING utf8)) LIKE '%$q_temp%' 
		OR LOWER(CONVERT(pd.namebanve USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.descriptionbanve USING utf8)) LIKE '%$q_temp%' 
		OR LOWER(CONVERT(pd.nameimgpro USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.descriptionimgpro USING utf8)) LIKE '%$q_temp%' 
		OR LOWER(CONVERT(pd.namephukien USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.descriptionphukien USING utf8)) LIKE '%$q_temp%' 
		OR LOWER(CONVERT(pd.nameproject USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.descriptionproject USING utf8)) LIKE '%$q_temp%' 
		
		 ) ORDER BY p.sort_order ASC, p.product_id DESC"; 
		
		$query = $this->db->query($sql);
		$arr_temp = array();
		$i=0;
		foreach($query->rows as $item){
			
					$des=strip_tags(str_replace(array('</p><p>','<br>'),array('</p> - <p>',' - '),html_entity_decode((string)$item['desc_short'])));
					$data[] = array('name'=>$item['name'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/product','path='. $this->model_cms_common->getPath($item['category_id']) . '&product_id=' . $item['product_id'],$this->config->get('config_language')) . '.html');
				
		}
		
		
		
		//project		
		$sql = "SELECT p.project_id, p.cate, pd.name, pd.address, pd.description, p.date_modified, p.date_added FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%'  OR LOWER(CONVERT(pd.address USING utf8)) LIKE '%$q_temp%'  
		
		) ORDER BY p.sort_order ASC, p.project_id DESC"; 
		
		$query = $this->db->query($sql);
		foreach($query->rows as $item){
			$des=strip_tags(html_entity_decode((string)$item['description']));
			$data[] = array('name'=>$item['name'],'desc_short'=>!empty($item['address'])?$item['address']:trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/project','path='. ID_PROJECT . '&cateproject=' . $item['cate'] . '&project_id=' . $item['project_id'],$this->config->get('config_language')) . '.html');
		}
		
		//service		
		$sql = "SELECT p.service_id, p.cate, p.typeservice, pd.name, pd.description, p.date_modified, p.date_added, (SELECT td.name FROM " . DB_PREFIX . "service t LEFT JOIN " . DB_PREFIX . "service_description td ON (t.service_id = td.service_id) WHERE t.status='1' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t.service_id=p.cate ) as pname FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%' 
		
		) ORDER BY p.sort_order ASC, p.service_id DESC"; 
		
		$query = $this->db->query($sql);
		$arr_temp = array();
		$i=0;
		//print_r($query->rows);die;
		foreach($query->rows as $item){
			$des=strip_tags(html_entity_decode((string)$item['description']));
			if(!$item['cate']){
				if(!in_array($item['service_id'],$arr_temp)){
					$arr_temp[$i] = $item['service_id'];
					$i++;
					$data[] = array('name'=>$item['name'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/service','path='. ID_SERVICE . '&service_id=' . $item['service_id'],$this->config->get('config_language')) . '.html');
				}
			}else{
				if($item['cate']==2){
					$data[] = array('name'=>$item['name'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/distribution','path='. ID_SERVICE . '&cateservice=' . $item['cate'] . '&service_id=' . $item['service_id'],$this->config->get('config_language')) . '.html');
					//}
				}else{
					if(!in_array($item['cate'],$arr_temp)){
						$arr_temp[$i] = $item['cate'];
					$i++;
					$data[] = array('name'=>$item['pname'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/service','path='. ID_SERVICE . '&service_id=' . $item['cate'],$this->config->get('config_language')) . '.html');
					}
				}
			}
		}
		
		//document		
		$sql = "SELECT p.document_id, p.cate, pd.name, pd.description, p.date_modified, p.date_added FROM " . DB_PREFIX . "document p LEFT JOIN " . DB_PREFIX . "document_description pd ON (p.document_id = pd.document_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%'    
		
		) ORDER BY p.sort_order ASC, p.document_id DESC"; 
		
		$query = $this->db->query($sql);
		foreach($query->rows as $item){
			$des=strip_tags(html_entity_decode((string)$item['description']));
			$data[] = array('name'=>$item['name'],'desc_short'=>!empty($item['address'])?$item['address']:trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/document','path='. ID_GALLERY . '_' . ID_DOCUMENT . '&document_id=' . $item['document_id'],$this->config->get('config_language')) . '.html');
		}
		
		
		//news		
		$sql = "SELECT p.news_id, p.category_id, pd.name, pd.desc_short, pd.description, p.date_modified, p.date_added  FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%' OR 
		LOWER(CONVERT(pd.desc_short USING utf8)) LIKE '%$q%' ) ORDER BY p.sort_order ASC, p.news_id DESC"; 
		
		$query = $this->db->query($sql);
		foreach($query->rows as $item){
			
			$des=strip_tags(html_entity_decode((string)$item['description']));
			$data[] = array('name'=>$item['name'],'desc_short'=>!empty($item['desc_short'])?$item['desc_short']:trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/news','path='. ID_NEWS . '_' . $item['category_id'] . '&news_id=' . $item['news_id'],$this->config->get('config_language')) . '.html');
		}
		
		//filepdf		
		$sql = "SELECT p.filepdf_id, pd.name, pd.description, pd.pdf, pd.linkpdf, p.date_modified, p.date_added FROM " . DB_PREFIX . "filepdf p LEFT JOIN " . DB_PREFIX . "filepdf_description pd ON (p.filepdf_id = pd.filepdf_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( 
		LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%' 
		 ) ORDER BY p.sort_order ASC, p.filepdf_id DESC"; 
		
		$query = $this->db->query($sql);
		foreach($query->rows as $item){
			$filepdf = !empty($item['linkpdf'])?$item['linkpdf']:$item['pdf'];
			if(!empty($filepdf)){
				$des=strip_tags(html_entity_decode((string)$item['description']));
				$data[] = array('name'=>$item['name'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>HTTP_PDF . $filepdf,'is_pdf'=>true);
			
			}
			
		}
		
		//aboutus		
		$sql = "SELECT pd.name, p.cate, p.aboutus_id , pd.description, p.date_modified, p.date_added, (SELECT td.name FROM " . DB_PREFIX . "aboutus t LEFT JOIN " . DB_PREFIX . "aboutus_description td ON (t.aboutus_id = td.aboutus_id) WHERE t.status='1' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t.aboutus_id=p.cate ) as pname FROM " . DB_PREFIX . "aboutus p LEFT JOIN " . DB_PREFIX . "aboutus_description pd ON (p.aboutus_id = pd.aboutus_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.name1 USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.name2 USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.desc_short USING utf8)) LIKE '%$q_temp%' ) ORDER BY p.sort_order ASC, p.aboutus_id DESC"; 
		
		$query = $this->db->query($sql);
		$arr_temp = array();
		$i=0;
		foreach($query->rows as $item){
			$des=strip_tags(html_entity_decode((string)$item['description']));
			if(!$item['cate']){
				if(!in_array($item['aboutus_id'],$arr_temp)){
					$arr_temp[$i] = $item['aboutus_id'];
					$i++;
					$data[] = array('name'=>$item['name'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/aboutus','path='. ID_ABOUTUS . '&aboutus_id=' . $item['aboutus_id'],$this->config->get('config_language')) . '.html');
				}
			}else{
				if(!in_array($item['cate'],$arr_temp)){
					$arr_temp[$i] = $item['cate'];
				$i++;
				$data[] = array('name'=>$item['pname'],'desc_short'=>trimwidth($des,0,200,'...'),'date_modified'=>($item['date_modified']!='0000-00-00 00:00:00')?$item['date_modified']:$item['date_added'],'href'=>$this->url->link('cms/aboutus','path='. ID_ABOUTUS . '&aboutus_id=' . $item['cate'],$this->config->get('config_language')) . '.html');
				}
			}
		}
		
		//contact		
		$sql = "SELECT pd.name, p.contact_id , pd.address , pd.description, p.date_modified, p.date_added FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pd.name<>'' AND  ( LOWER(CONVERT(pd.name USING utf8)) LIKE '%$q%'  OR LOWER(CONVERT(pd.description USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(pd.address USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(p.phonelist USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(p.faxlist USING utf8)) LIKE '%$q_temp%' OR LOWER(CONVERT(p.emaillist USING utf8)) LIKE '%$q_temp%'  ) ORDER BY p.sort_order ASC, p.contact_id DESC"; 
		
		$query = $this->db->query($sql);
		if(count($query->rows)>0){
			$data[] = array('name'=>$this->model_cms_common->getTitle(ID_CONTACT),'desc_short'=>$query->rows[0]['address'],'date_modified'=>($query->rows[0]['date_modified']!='0000-00-00 00:00:00')?$query->rows[0]['date_modified']:$query->rows[0]['date_added'],'href'=>$this->url->link('cms/contact','path='.ID_CONTACT,$this->config->get('config_language')) . '.html');
		
		}
		
		
		
		
		return $data;
		
	}		
}
?>