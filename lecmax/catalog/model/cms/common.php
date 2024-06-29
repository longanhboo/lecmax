<?php
class ModelCmsCommon extends Model {	
	/*==================================Menu======================================*/
	public function getMenu($parent_id=0,$pos=1, $index_c=-1, $issub=0)
	{
		$limit = '';
		
		/*if($index_c!=-1){
			$news_location = $index_c*PAGING_DECOR;
			$limit .= ' LIMIT ' . $news_location . ', ' . PAGING_DECOR;
		}
		*/
		
		if($parent_id==0)
			$str = " AND p.mainmenu = '".$pos."'";
		else
			$str = "";
		
		if($issub==0){
			$str .= " AND p.submenu = '".$issub."'";
		}elseif($issub==1){
			$str .= " AND p.submenu = '".$issub."'";
		}
		
			
		$sql = "SELECT p.category_id, p.path, p.link, p.class, p.mausac, p.location, p.image, p.image1, p.image_og, p.parent_id, p.sort_order, pd.name, pd.name1, pd.name2, pd.pdf, pd.filepdf, pd.desc_short, pd.description, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.parent_id='".(int)$parent_id."' $str ORDER BY p.sort_order ASC, p.category_id DESC $limit"; 

		$query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $menu){
			$child = $this->getMenu($menu['category_id']);
			$path = $this->getPath($menu['category_id']);				
			$search  = array('<div', '</div>', '<b>', '</b>');
			$replace = array('<p', '</p>', '<strong>', '</strong>');
			$des = str_replace($search,$replace,html_entity_decode((string)$menu['description']));
			$checkdes = strip_tags($des);
			
			$search  = array('<div>', '</div>','<p>', '</p>', '<b>', '</b>');
			$replace = array('', '', '', '', '<strong>', '</strong>');
			$name1 = strip_tags(html_entity_decode((string)$menu['name1']));
			$pdf = empty($menu['pdf']) || !is_file(DIR_PDF . $menu['pdf'])?'': $menu['pdf'];
			$filepdf = empty($menu['filepdf']) || !is_file(DIR_PDF . $menu['filepdf'])?'': $menu['filepdf'];
			
			$file_pdf = !empty($filepdf)?$filepdf:$pdf;
			
			$data[] = array('path'=> $menu['path'], 'link'=> $menu['link'], 'class'=> $menu['class'], 'mausac'=> $menu['mausac'], 'pdf'=>$file_pdf, 'location'=> $menu['location'], 'image'=> empty($menu['image']) || !is_file(DIR_IMAGE . $menu['image'])?'':$menu['image'], 'image1'=> empty($menu['image1']) || !is_file(DIR_IMAGE . $menu['image1'])?'':$menu['image1'], 'name'=>$menu['name'], 'name1'=>!empty($name1)?str_replace($search,$replace,html_entity_decode((string)$menu['name1'])):$menu['name'], 'name2'=>!empty($menu['name2'])?html_entity_decode((string)$menu['name2']):$menu['name'], 'desc_short'=>$menu['desc_short'],'des'=>!empty($checkdes)?$des:'', 'images' => $this->getBackgrounds($menu['category_id']), 'sort_order'=> $menu['sort_order'],'meta_title'=>!empty($menu['meta_title'])?$menu['meta_title']:$menu['name'], 'meta_description'=>$menu['meta_description'], 'meta_keyword'=>$menu['meta_keyword'],'href'=>str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/home','path='.$path,$this->config->get('config_language')).'.html'),'id'=>$menu['category_id'],'child'=>$child);
			
		}

		return $data;
	}
	
	public function getSubMenu($parent_id=0,$pos=1)
	{
		$str = "";
		$str .= " AND p.mainmenu='" . $pos . "' ";
		
		$sql = "SELECT * FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.parent_id='".(int)$parent_id."' $str ORDER BY p.sort_order ASC, p.category_id DESC"; 

		$query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $menu){
			//$child = array();
			$child = $this->getMenu($menu['category_id']);
			$path = $this->getPath($menu['category_id']);				
			$data[] = array('path'=> $menu['path'], 'link'=> $menu['link'], 'class'=> $menu['class'], 'image'=> empty($menu['image'])?'':$menu['image'], 'name'=>$menu['name'], 'name1'=>!empty($menu['name1'])?html_entity_decode((string)$menu['name1']):$menu['name'],'des'=>html_entity_decode((string)$menu['description']),'meta_title'=>!empty($menu['meta_title'])?$menu['meta_title']:$menu['name'], 'meta_description'=>$menu['meta_description'], 'meta_keyword'=>$menu['meta_keyword'],'href'=>str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/home','path='.$path,$this->config->get('config_language')).'.html'),'id'=>$menu['category_id'],'child'=>$child);
			
		}

		return $data;
	}	
	
	public function getPath($id){

		$query = $this->db->query("SELECT category_id, parent_id FROM ".DB_PREFIX."category WHERE category_id='".(int)$id . "'");

		$path = '';
		if(isset($query->row['parent_id']) && $query->row['parent_id']>0)
			$path .= $this->getPath($query->row['parent_id']) . '_';
			
		$path .= isset($query->row['category_id'])? $query->row['category_id'] :'';
		return trim($path,'_');
	}
	
	public function getHome(){
		$this->load->model('cms/common');
		$sql = "SELECT p.category_id, p.parent_id, p.iconsvg, p.image, pd.name, pd.name2, pd.description FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.ishome='1' AND pd.name<>''  ORDER BY p.parent_id DESC, p.sort_order ASC, p.category_id DESC  LIMIT 5  "; 
		
		$query = $this->db->query($sql);
		$data1 = array();
		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['category_id'];
			$data['name'] = $row['name'];
			$data['name2'] = nl2br((string)$row['name2']);
			$data['iconsvg'] = html_entity_decode((string)$row['iconsvg']);
			
			$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($row['category_id']),$this->config->get('config_language')) .'.html';
			
			
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . str_replace(' ', '%20', (string)$row['image']))?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			$data1[] = $data;
		}
		
		
		return $data1;
	}
	
	public function getTitle($cate_id, $value=false){
		$sql = "SELECT name,name1 FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id='".(int)$cate_id ."'"; 
		
		$query = $this->db->query($sql);
		
		
		if($value){
			if(isset($query->row['name1'])){
				$search  = array('<div>', '</div>','<p>', '</p>', '<b>', '</b>');
				$replace = array('', '', '', '', '<strong>', '</strong>');
				$name1 = strip_tags(html_entity_decode((string)$query->row['name1']));
			}
			return isset($query->row['name1'])&&!empty($name1)?str_replace($search,$replace,html_entity_decode((string)$query->row['name1'])):$query->row['name'];
		}
		return isset($query->row['name'])?$query->row['name']:'';
	}
	
	public function getBackground($cate_id){
		$sql = "SELECT image FROM " . DB_PREFIX . "category WHERE category_id='".(int)$cate_id ."'"; 
		
		$query = $this->db->query($sql);
		
		return isset($query->row['image'])? $query->row['image']:'';
	}
	
	public function getFriendlyUrl($string='', $lang=2){
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($string) . "'  AND lang='".$lang."'"; 		
		$query = $this->db->query($sql);		
		
		return isset($query->row['keyword'])?$query->row['keyword']:'';
	}
	
	public function getSeo($category_id){
		$sql = "SELECT pd.name, pd.meta_title,pd.meta_keyword,pd.meta_description, pd.meta_title_og, pd.meta_description_og, p.image_og FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id='".(int)$category_id."'"; 
		
		$query = $this->db->query($sql);
		$row = $query->row;

		$data = array();
		if($row){
			$data['name'] = $row['name'];
			//$data['image'] = HTTP_IMAGE . $row['image'];
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = $row['meta_title_og'];
			$data['meta_description_og'] = $row['meta_description_og'];
		}
		return $data;
	}
	
	
	public function getBackgroundPage($category_id=0)
	{
		$sql = "SELECT p.category_id, p.mausac, p.subcateproduct_id, p.config_loop_picture, p.class, p.image, p.image1, p.image_og, pd.name, pd.name1, pd.name2, pd.description, pd.pdf, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id='".(int)$category_id."'"; 

		$query = $this->db->query($sql);
		$data = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
		}*/
		$folder = '';
		$folder_dir = DIR_IMAGE;
		
		if(count($query->row)>0){
			$data = $query->row;
			$data['category_id'] = $query->row['category_id'];
			$data['id'] = $query->row['category_id'];
			$data['name'] = $query->row['name'];
			$data['class'] = $query->row['class'];
			$data['subcateproduct_id'] = $query->row['subcateproduct_id'];
			$data['mausac'] = $query->row['mausac'];
			$data['name1'] = !empty($query->row['name1'])?html_entity_decode((string)$query->row['name1']):$query->row['name'];
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$query->row['description']));
			$checkdes = strip_tags($des);
			$data['des'] = !empty($checkdes)?$des:'';
			$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/home','path='.$this->getPath($query->row['category_id']),$this->config->get('config_language')).'.html');
			$data['config_loop_picture'] = $query->row['config_loop_picture'];
			$data['image1'] = (!empty($query->row['image1']) && is_file($folder_dir. $query->row['image1']))?$folder.str_replace(' ', '%20', (string)$query->row['image1']):'';
			$data['pdf'] = empty($query->row['pdf']) || !is_file(DIR_PDF . $query->row['pdf'])?'':$query->row['pdf'];
			$data['images'] = $this->getBackgrounds($category_id);
			
			$data['meta_title'] = empty($query->row['meta_title'])?$query->row['name']:$query->row['meta_title'];
			$data['meta_keyword'] = $query->row['meta_keyword'];
			$data['meta_description'] = $query->row['meta_description'];
			
			$data['image_og'] = $query->row['image_og'];
			$data['meta_title_og'] = $query->row['meta_title_og'];
			$data['meta_description_og'] = $query->row['meta_description_og'];
		}

		return $data;
	}
	
	public function getBackgrounds($category_id){
		$query = $this->db->query("SELECT image, image1, image_name, image_name_en FROM ".DB_PREFIX."category_image WHERE category_id = '".(int)$category_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		
		/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
		}*/
		$folder = '';
		$folder_dir = DIR_IMAGE;

		foreach($query->rows as $row){
			$data[] = array('image'=>(!empty($row['image']) && is_file($folder_dir . $row['image']))?$folder . str_replace(' ', '%20',(string)$row['image']):'', 'image1'=>(!empty($row['image1']) && is_file($folder_dir . $row['image1']))?$folder . str_replace(' ', '%20',(string)$row['image1']):'', 'name' => ($this->config->get('config_language_id')==1)?$row['image_name_en']:$row['image_name']);
		}
		
		return $data;		
	}
		
	/*
	public function getDownload(){
		$sql = "SELECT * FROM " . DB_PREFIX . "download p LEFT JOIN " . DB_PREFIX . "download_description pd ON (p.download_id = pd.download_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.download_id IN(162,163,164)"; 
		
		$query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $rs){
			$data[$rs['download_id']] = empty($rs['download'])?'':HTTP_PDF . $rs['download'];
		}
		
		return $data;
	}
	
	public function getBackgrounds($module){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."background_image WHERE background_id = (SELECT background_id FROM ".DB_PREFIX."background WHERE module='".$this->db->escape($module)."'  LIMIT 1) ORDER BY image_sort_order ASC");
		$data = array();

		foreach($query->rows as $row){
			$data[] = HTTP_IMAGE . $row['image'];
		}
		
		return $data;
		
	}
	*/
	
	public function getIntro($category_id=0)
	{
		$sql = "SELECT p.category_id, p.mausac, p.class, p.config_loop_picture, p.image, p.image1, p.image_og, pd.name, pd.name1, pd.name2, pd.description, pd.pdf, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.category_id='".(int)$category_id."'"; 

		$query = $this->db->query($sql);
		$data = array();
		
		if(count($query->row)>0){
			$data = $query->row;
			$data['category_id'] = $query->row['category_id'];
			$data['name'] = $query->row['name'];
			
			$search  = array('<div>', '</div>','<p>', '</p>', '<b>', '</b>');
			$replace = array('', '', '', '', '<strong>', '</strong>');
			$name1 = strip_tags(html_entity_decode((string)$query->row['name1']));
			if(!empty($name1)){
				$data['name1'] = str_replace($search,$replace,html_entity_decode((string)$query->row['name1']));
			}
			
			$data['name2'] = !empty($query->row['name2'])?html_entity_decode((string)$query->row['name2']):$query->row['name'];
			$data['class'] = $query->row['class'];
			$search  = array('<div', '</div>', '<b>', '</b>','<br></i></p>','<br></u></p>','<br></span></p>');
			$replace = array('<p', '</p>', '<strong>', '</strong>','</i></p>','</u></p>','</span></p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$query->row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$data['pdf'] = empty($query->row['pdf']) || !is_file(DIR_PDF . $query->row['pdf'])?'':$query->row['pdf'];
			
			$data['image'] = empty($query->row['image'])?'':$query->row['image'];
			$data['image1'] = empty($query->row['image1'])?'':$query->row['image1'];
			$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/home','path='.$this->getPath($query->row['category_id']),$this->config->get('config_language')).'.html');
			
			$data['meta_title'] = empty($query->row['meta_title'])?$query->row['name']:$query->row['meta_title'];
			$data['meta_keyword'] = $query->row['meta_keyword'];
			$data['meta_description'] = $query->row['meta_description'];
			
			$data['image_og'] = $query->row['image_og'];
			$data['meta_title_og'] = $query->row['meta_title_og'];
			$data['meta_description_og'] = $query->row['meta_description_og'];
		}

		return $data;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND c.status = '1' ORDER BY c.date_modified DESC, c.date_added DESC, c.sort_order, LCASE(cd.name)");
		
		return $query->rows;
	}
	
	public function getMenuBySubcateproduct($subcateproduct_id=0)
	{
		$sql = "SELECT p.category_id, p.path, p.link, p.class, p.mausac, p.location, p.image, p.image1, p.image_og, p.parent_id, p.sort_order, pd.name, pd.name1, pd.name2, pd.pdf, pd.filepdf, pd.desc_short, pd.description, pd.meta_title, pd.meta_description, pd.meta_keyword, pd.meta_title_og, pd.meta_description_og FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description pd ON (p.category_id = pd.category_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.subcateproduct_id='".(int)$subcateproduct_id."' ORDER BY p.sort_order ASC, p.category_id DESC"; 

		$query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $menu){
			$path = $this->getPath($menu['category_id']);				
			$search  = array('<div', '</div>', '<b>', '</b>');
			$replace = array('<p', '</p>', '<strong>', '</strong>');
			$des = str_replace($search,$replace,html_entity_decode((string)$menu['description']));
			$checkdes = strip_tags($des);
			
			$search  = array('<div>', '</div>','<p>', '</p>', '<b>', '</b>');
			$replace = array('', '', '', '', '<strong>', '</strong>');
			$name1 = strip_tags(html_entity_decode((string)$menu['name1']));
			$pdf = empty($menu['pdf']) || !is_file(DIR_PDF . $menu['pdf'])?'': $menu['pdf'];
			$filepdf = empty($menu['filepdf']) || !is_file(DIR_PDF . $menu['filepdf'])?'': $menu['filepdf'];
			
			$file_pdf = !empty($filepdf)?$filepdf:$pdf;
			
			$data[] = array('path'=> $menu['path'], 'link'=> $menu['link'], 'class'=> $menu['class'], 'mausac'=> $menu['mausac'], 'pdf'=>$file_pdf, 'location'=> $menu['location'], 'image'=> empty($menu['image']) || !is_file(DIR_IMAGE . $menu['image'])?'':$menu['image'], 'image1'=> empty($menu['image1']) || !is_file(DIR_IMAGE . $menu['image1'])?'':$menu['image1'], 'name'=>$menu['name'], 'name1'=>!empty($name1)?str_replace($search,$replace,html_entity_decode((string)$menu['name1'])):$menu['name'], 'name2'=>!empty($menu['name2'])?html_entity_decode((string)$menu['name2']):$menu['name'], 'desc_short'=>$menu['desc_short'],'des'=>!empty($checkdes)?$des:'', 'images' => $this->getBackgrounds($menu['category_id']), 'sort_order'=> $menu['sort_order'],'meta_title'=>!empty($menu['meta_title'])?$menu['meta_title']:$menu['name'], 'meta_description'=>$menu['meta_description'], 'meta_keyword'=>$menu['meta_keyword'],'href'=>str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/home','path='.$path,$this->config->get('config_language')).'.html'),'id'=>$menu['category_id']);
			
		}

		return $data;
	}
}
?>