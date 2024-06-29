<?php
class ModelCmsProduct extends Model {

	//Lay tat ca
	public function getProducts($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.product_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['product_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/product','path='. $category_id .'_' . $row['category_id'] . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/product','path='. $category_id . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
				$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
    
    	$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
    
    	$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : HTTP_PDF . $row['pdf'];
    
    	$data['images'] = $this->getImages($data['id']);
    
    	$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
	$data['meta_keyword'] = $row['meta_keyword'];
	$data['meta_description'] = $row['meta_description'];
    
	$data['image_og'] = $row['image_og'];
    $data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
    $data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];

	/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

		//Lay dua vao danh muc
	public function getProductByCate($category_id)	{
		$this->load->model('cms/common');	
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.category_id='" . (int)$category_id . "' ORDER BY p.sort_order ASC, p.product_id DESC"; 
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['product_id'];
			$data['name'] = $row['name'];
			
			
			$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($category_id) . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
			
			$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : $row['pdf'];
			
			//$data['images'] = $this->getImages($data['id']);
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
			/*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	//ISHOME
public function getHome()	{
	$this->load->model('cms/common');	
	$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.product_id DESC LIMIT 1"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['product_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
        $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
        $data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		
		$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($row['category_id']) . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
		
		
		$data['image'] = empty($row['image_home'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image_home']);
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getProduct($product_id)	{
		$this->load->model('cms/project');
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.product_id = '" . $product_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['product_id'];
		$data['name'] = $row['name'];
		
		$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($row['category_id']) . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['desc_short']));
		if(strpos($des,'<img')){
			$data['desc_short'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['desc_short'] = !empty($checkdes)?$des:'';
		}
		
		// thongso
		$data['namethongso'] = $row['namethongso'];
		
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		
		//banve
		$data['namebanve'] = $row['namebanve'];
		$des = str_replace($search,$replace,html_entity_decode((string)$row['descriptionbanve']));
		if(strpos($des,'<img')){
			$data['descriptionbanve'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['descriptionbanve'] = !empty($checkdes)?$des:'';
		}
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
		
		$data['image2'] = empty($row['image2']) || !is_file(DIR_IMAGE . $row['image2'])? '' : str_replace(' ', '%20', (string)$row['image2']);
		
		$data['image_banve'] = ($this->config->get('config_language_id')==1)?$data['image2']:$data['image1'];
		
		//imgpro
		$data['nameimgpro'] = $row['nameimgpro'];
		$des = str_replace($search,$replace,html_entity_decode((string)$row['descriptionimgpro']));
		if(strpos($des,'<img')){
			$data['descriptionimgpro'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['descriptionimgpro'] = !empty($checkdes)?$des:'';
		}
		
		//phukien
		$data['namephukien'] = $row['namephukien'];
		$des = str_replace($search,$replace,html_entity_decode((string)$row['descriptionphukien']));
		if(strpos($des,'<img')){
			$data['descriptionphukien'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['descriptionphukien'] = !empty($checkdes)?$des:'';
		}
		
		$product_category = (!empty($row['product_category'])?unserialize($row['product_category']):array());
		$data['products'] = array();
		if(count($product_category)>0){
			foreach($product_category as $item){
				$temp = $this->model_cms_product->getProductDefault($item);
				if(isset($temp['id'])){
					$data['products'][] = $temp;
				}
			}
		}
		
		
		
		//project
		$data['nameproject'] = $row['nameproject'];
		$des = str_replace($search,$replace,html_entity_decode((string)$row['descriptionproject']));
		if(strpos($des,'<img')){
			$data['descriptionproject'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['descriptionproject'] = !empty($checkdes)?$des:'';
		}
		
		$project_category = (!empty($row['project_category'])?unserialize($row['project_category']):array());
		$data['projects'] = array();
		if(count($project_category)>0){
			foreach($project_category as $item){
				$temp = $this->model_cms_project->getProjectDefault($item);
				if(isset($temp['id'])){
					$data['projects'][] = $temp;
				}
			}
		}
		
		
		
		
		$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])? '' : $row['pdf'];
		
		$data['images'] = $this->getImages($data['id']);
		$data['imagepros'] = $this->getImagepros($data['id']);
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getProductDefault($product_id)	{
		
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.product_id = '" . $product_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['product_id'];
		$data['name'] = $row['name'];
		
		$data['href'] = $this->url->link('cms/product','path='. $this->model_cms_common->getPath($row['category_id']) . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html';
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['desc_short']));
		if(strpos($des,'<img')){
			$data['desc_short'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['desc_short'] = !empty($checkdes)?$des:'';
		}
		
		
		// thongso
		$data['namethongso'] = $row['namethongso'];
		
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		
		
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}

		//Lay hinh dua vao id
	public function getImages($product_id){
		$sql = "SELECT * FROM ".DB_PREFIX."product_image WHERE product_id='".(int)$product_id."' ORDER BY image_sort_order ASC";
        
        $query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['product_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			$data1['name'] = ($this->config->get('config_language_id')==1)?nl2br((string)$rs['image_name_en']):nl2br((string)$rs['image_name']);
			
			$data[] = $data1;
		}
		return $data;
	}
	
	//Lay hinh dua vao id
	public function getImagepros($product_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."product_imagepro WHERE product_id='".(int)$product_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['product_imagepro_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			$data1['name'] = ($this->config->get('config_language_id')==1)?nl2br((string)$rs['image_name_en']):nl2br((string)$rs['image_name']);
			
			$data[] = $data1;
		}
		return $data;
	}
	
	public function getRelatedProduct($path, $category_id=0, $product_id=0)	{
        $limit = 3;
		$str = '';
		if($category_id){
			$str .= " AND p.category_id = " . (int)$category_id;
		}
        $cache_file = 'products.related.' . $this->config->get('config_language_id') . "." . $category_id . '.' . $product_id ;
        $product_data = $this->cache->get($cache_file);
        if (!$product_data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) ";
            $sql .= " WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ";
            $sql .= " $str " ;
            $sql .= " ORDER BY p.sort_order ASC, p.product_id DESC";
            $query = $this->db->query($sql);
            $tmp = $query->rows;
            $product_data = array();

            $total = count($tmp);
            $i=0;
            $start = 0;
            $length = 0;

            foreach($tmp as $item){
                if($item['product_id']==$product_id){
                    $start = ($i-$limit) > 0 ? ($i-$limit):0;
                    $end = ($i+1+$limit > count($tmp)) ? count($tmp) : $i+1+$limit;
                    $length = $end-$start;
                    break;
                }
                $i++;
            }
			
			if($length<($limit*2)+1){
				if($start>0){
					$start = $start - 1;
				}elseif($start<=count($tmp)){
					$end = $end + 1;
				}
				
				$length = $end-$start;
			}

            if($product_id==0){
                $start=0;
                $length=$limit+1;
            }
            $product_data = array_slice($tmp, $start, $length);

            $this->cache->set($cache_file, $product_data);
        }

        //$query = $this->db->query($sql);
        $data1 = array();
		
		$folder = HTTP_IMAGE;
		$folder_dir = DIR_IMAGE;
		$img_temp = PATH_IMAGE_THUMB;

        foreach($product_data as $row){
            $path = $path ? $path : $this->model_cms_common->getPath($row['category_id']);
            $data = array();
            $data['id'] = $row['product_id'];
            $data['name'] = html_entity_decode((string)$row['name']);
            

            $data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/product','path='. $path . '&product_id='.$row['product_id'],$this->config->get('config_language')) .'.html');

            $search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
            $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
            $des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
            $checkdes = strip_tags($des);
            $data['description'] = !empty($checkdes)?$des:'';

            preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
            $data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
            $data['image'] = empty($data['image'])?'':$data['image'];

            $data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
            $data['meta_keyword'] = $row['meta_keyword'];
            $data['meta_description'] = $row['meta_description'];

            $data['image_og'] = $row['image_og'];
            $data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
            $data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];

            /*{FRONTEND_DATA_ROW}*/
            $data1[] = $data;
        }

        return $data1;
    }

	public function getProductAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.product_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>