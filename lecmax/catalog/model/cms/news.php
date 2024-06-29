<?php
class ModelCmsNews extends Model {

	//Lay tat ca
	public function getNewss($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.news_id DESC";
		
		$news_data = $this->cache->get('newss.' . $this->config->get('config_language_id'));
		if (!$news_data) {
			$query = $this->db->query($sql);
			$news_data = $query->rows;
			$this->cache->set('newss.' . (int)$this->config->get('config_language_id'), $news_data);
		}
		
		//$query = $this->db->query($sql);
		$data1 = array();
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}

		foreach($news_data as $row){
			$data = array();
			$data['id'] = $row['news_id'];
			$data['name'] = $row['name'];
			$data['ishome'] = $row['ishome'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/news','path='. $category_id .'_' . $row['category_id'] . '&news_id='.$row['news_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/news','path='. $category_id . '&news_id='.$row['news_id']) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
			
			$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['desc_short']));
			$checkdes = strip_tags($des);
			$data['desc_short'] = !empty($checkdes)?$des:'';
			
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?$img_temp:$data['image'];
    
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
	
	//Lay tat ca
	public function getNewsByParent($category_id=0, $cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.news_id DESC";
		
		$data1 = array();
		
		$news_data = $this->cache->get('newsbyparent.' . $category_id . '.' . $this->config->get('config_language_id'));
		if (!$news_data) {
			$query = $this->db->query($sql);
			$news_data = $query->rows;
			
			if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
				$folder = HTTP_IMAGE_MOBILE;
				$folder_dir = DIR_IMAGE_MOBILE;
				$img_temp = PATH_IMAGE_THUMB_MOBILE;
			}else{
				$folder = HTTP_IMAGE;
				$folder_dir = DIR_IMAGE;
				$img_temp = PATH_IMAGE_THUMB;
			}
	
			foreach($news_data as $row){
				$data = array();
				$data['id'] = $row['news_id'];
				$data['name'] = $row['name'];
				$data['ishome'] = $row['ishome'];
	
				if(isset($row['category_id']))
					$data['href'] = $this->url->link('cms/news','path='. $category_id .'_' . $row['category_id'] . '&news_id='.$row['news_id']) .'.html';
				else
					$data['href'] = $this->url->link('cms/news','path='. $category_id . '&news_id='.$row['news_id']) .'.html';
	
				$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
				$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
				$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
				$checkdes = strip_tags($des);
				$data['description'] = !empty($checkdes)?$des:'';
				
				$data['desc_short'] = !empty($row['desc_short'])?trimwidth((string)$row['desc_short'],0,90,''):trimwidth(strip_tags(html_entity_decode((string)$row['description'])),0,200,'...');
				
				preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
				$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
				$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
				$data['image'] = empty($data['image'])?$img_temp:$data['image'];
		
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
			
			$news_data = $data1;
			
			$this->cache->set('newsbyparent.' . $category_id . '.' . (int)$this->config->get('config_language_id'), $data1);
		}
		
		//$query = $this->db->query($sql);
		
		
		

		return $news_data;
	}

		//Lay dua vao danh muc
	public function getNewsByCate($category_id, $index_news=-1)	{
		$str = '';
		if($index_news!=-1){
			$news_location = $index_news*PAGING_NEWS;
			$str .= ' LIMIT ' . $news_location . ', ' . PAGING_NEWS;
		}
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND p.cate='0' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.category_id='" . (int)$category_id . "' ORDER BY p.sort_order ASC, p.news_id DESC $str"; 
		//echo $sql;
		
		$data1 = array();
		
		//$news_data = $this->cache->get('newsbycate.' . $category_id . '.' . $this->config->get('config_language_id'));
		//if (!$news_data) {
			$query = $this->db->query($sql);
			$news_data = $query->rows;
			
			/*if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
				$folder = HTTP_IMAGE_MOBILE;
				$folder_dir = DIR_IMAGE_MOBILE;
				$img_temp = PATH_IMAGE_THUMB_MOBILE;
			}else{
				$folder = HTTP_IMAGE;
				$folder_dir = DIR_IMAGE;
				$img_temp = PATH_IMAGE_THUMB;
			}*/
			
			$folder = '';
			$folder_dir = DIR_IMAGE;
			$img_temp = str_replace(HTTP_SERVER,'HTTP_SERVER',PATH_IMAGE_THUMB);
	
			foreach($news_data as $row){
				$data = array();
				$data['id'] = $row['news_id'];
				$data['name'] = $row['name'];
				$data['ishome'] = $row['ishome'];
				$data['isnew'] = $row['isnew'];
				$data['date_insert'] = date('d/m/Y',strtotime($row['date_insert']));
				
				$search  = array('<div', '</div>', '<b>', '</b>');
				$replace = array('<p', '</p>', '<strong>', '</strong>');
				$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
				$checkdes = strip_tags($des);
				$data['description'] = !empty($checkdes)?$des:'';
				
				$data['desc_short'] = !empty($row['desc_short'])?trimwidth((string)$row['desc_short'],0,90,''):trimwidth(strip_tags(html_entity_decode((string)$row['description'])),0,200,'...');
				
				preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
				$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': $folder . str_replace(' ', '%20', (string)$row['image']);
				$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
				$data['image'] = empty($data['image'])?$img_temp:$data['image'];
				
				$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
				$data['meta_keyword'] = $row['meta_keyword'];
				$data['meta_description'] = $row['meta_description'];
				
				$data['image_og'] = $row['image_og'];
				$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
				$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
				/*{FRONTEND_DATA_ROW}*/
				$data1[] = $data;
			}
			
			$news_data = $data1;
			
			//$this->cache->set('newsbycate.' . $category_id . '.' . (int)$this->config->get('config_language_id'), $data1);
		//}
		
		//$query = $this->db->query($sql);
		
		
		

		return $news_data;
	}

	//ISHOME
public function getHome($category_id=0, $tapdoan=0)	{
	
	$str = '';
	if($tapdoan==1){
		$str .= " AND p.category_id=" . $category_id;
	}elseif($tapdoan==2){
		$str .= " AND p.category_id<>" . $category_id;
	}
	
	$sql = "SELECT  p.news_id, p.category_id, p.image, p.image_home, p.isnew, p.sort_order, p.date_modified, p.date_insert, p.category_id, pd.name, pd.desc_short, pd.description  FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' $str AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY  p.sort_order ASC, p.news_id DESC LIMIT 3"; 

	$query = $this->db->query($sql);
	$data1 = array();
	$this->load->model('cms/common');

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['news_id'];
		$data['name'] = $row['name'];//trimwidth($row['name'],0,60,'...');
		$data['isnew'] = $row['isnew'];
		$data['name_cate'] = $this->model_cms_common->getTitle($row['category_id']);
		$data['sort_order'] = $row['sort_order'];
		$data['date_modified'] = $row['date_modified'];
		$data['date_insert'] = date('d/m/Y',strtotime($row['date_insert']));
		$data['date_day'] = date('d',strtotime($row['date_insert']));
		$data['date_month'] = date('m',strtotime($row['date_insert']));
		$data['date_year'] = date('Y',strtotime($row['date_insert']));
		
		$data['desc_short'] = $row['desc_short'];//(trimwidth($row['desc_short'],0,90,''));
		
		$data['href'] = $this->url->link('cms/news','path='. ID_NEWS .'_' . $row['category_id'] . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'.html';
		$search  = array('<div', '</div>', '<b>', '</b>','HTTP_CATALOG');
		$replace = array('<p', '</p>', '<strong>', '</strong>',HTTP_SERVER);
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
		$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
		$data['image'] = empty($data['image'])?PATH_IMAGE_THUMB:$data['image'];
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getNews($news_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.news_id = '" . $news_id . "'";

		$query = $this->db->query($sql);
		$data = array();
		
		if(!isset($query->row['news_id'])){
			return $data;
		}
		
		if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
			$folder = HTTP_IMAGE_MOBILE;
			$folder_dir = DIR_IMAGE_MOBILE;
			$img_temp = PATH_IMAGE_THUMB_MOBILE;
		}else{
			$folder = HTTP_IMAGE;
			$folder_dir = DIR_IMAGE;
			$img_temp = PATH_IMAGE_THUMB;
		}
		
		$row = $query->row;

		$data['id'] = $row['news_id'];
		$data['news_id'] = $row['news_id'];
		$data['name'] = $row['name'];
		$data['category_id'] = $row['category_id'];
		$data['ishome'] = $row['ishome'];
		$data['sort_order'] = $row['sort_order'];
		$data['date_insert'] = $row['date_insert'];
		
		$data['href'] = $this->url->link('cms/news','path='. ID_NEWS .'_' . $row['category_id'] . '&news_id='.$row['news_id']) .'.html';
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		$checkdes = $des;//strip_tags($des);
		$data['description'] = !empty($checkdes)?$des:'';
		
		$des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['desc_short']));
		$checkdes = strip_tags($des);
		$data['desc_short'] = !empty($checkdes)?$des:'';
		
		preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
		$data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		//$data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
		//$data['image'] = empty($data['image'])?$img_temp:$data['image'];
		
		$data['pdf'] = empty($row['pdf']) || !is_file(DIR_PDF . $row['pdf'])?'': HTTP_PDF . $row['pdf'];
    
    	//$data['images'] = $this->getImages($data['id']);
    
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
	public function getImages($news_id){
		$query = "SELECT * FROM ".DB_PREFIX."news_image WHERE news_id='".(int)$news_id."' ORDER BY image_sort_order ASC";
		
		$news_data = $this->cache->get('news_images');
		if (!$news_data) {
			$query = $this->db->query($sql);
			$news_data = $query->rows;
			$this->cache->set('news_images', $news_data);
		}
		
		$data = array();
		foreach($news_data as $rs){
			$data1 = array();
			$data1['id'] = $rs['news_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': HTTP_IMAGE . str_replace(' ', '%20', (string)$rs['image1']);
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getNewsAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.news_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getNewsFixed($news_id,$select="*"){
		$sql = "SELECT {$select}
				FROM ".DB_PREFIX."news AS t1 JOIN ".DB_PREFIX."news_description AS t2 
				ON t1.news_id = t2.news_id 
				WHERE t1.status = 1 AND t2.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND t2.name<>'' AND t1.news_id = {$news_id}
				";
		$query = $this->db->query($sql);
		
		$data = $query->row;
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$query->row['description']));
		$checkdes = $des;//strip_tags($des);
		$data['description'] = !empty($checkdes)?$des:'';
		
		return $data;
	}
	
	public function getNewsByCateFixed($category_id,$select="*", $order_by = ' ORDER BY t1.date_insert DESC, t1.sort_order ASC, t1.news_id DESC', $index_page=-1, $array_tinmatdinh=array('id'=>0,'old'=>0,'new'=>0), $isamp=0, $limit=10){
		
		$str = '';
		$where_str = '';
		if($index_page!=-1){
			if($index_page==-2){
				if($array_tinmatdinh['id']){
					if (isset($array_tinmatdinh['new']) && $array_tinmatdinh['new']==1 && isset($array_tinmatdinh['id']) ) {
						$where_str .= " AND ( SELECT p.date_insert FROM  ".DB_PREFIX."news AS p WHERE p.news_id='" . $array_tinmatdinh['id'] . "') > t1.date_insert" ;
					}
					
					if ( isset($array_tinmatdinh['old']) && $array_tinmatdinh['old']==1 && isset($array_tinmatdinh['id']) ) {
						$where_str .= " AND ( SELECT p.date_insert FROM  ".DB_PREFIX."news AS p WHERE p.news_id='" . $array_tinmatdinh['id'] . "') < t1.date_insert  ";
					}
				}
				
				$str .= ' LIMIT ' . $limit;
			}else{
				$news_location = $index_page*PAGING_NEWS;
				$str .= ' LIMIT ' . $news_location . ', ' . PAGING_NEWS;
			}
		}
		
		if($isamp==1){
			$where_str .= " AND t1.isamp='1' ";
		}
		
		
		
		$sql = "SELECT {$select}
				FROM ".DB_PREFIX."news AS t1 LEFT JOIN ".DB_PREFIX."news_description AS t2 
				ON t1.news_id = t2.news_id 
				WHERE t1.status = 1 $where_str AND t2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t2.name<>'' AND t1.category_id = {$category_id} {$order_by}
				 $str
				";
		$query = $this->db->query($sql);
		return $query->rows;
		
	}
	
	public function getRelatedNews($path, $category_id=0, $news_id=0)	{
        $limit = 5;
		$str = '';
		if($category_id){
			$str .= " AND p.category_id = " . (int)$category_id;
		}
        $cache_file = 'newss.related.' . $this->config->get('config_language_id') . "." . $category_id . '.' . $news_id ;
        $news_data = $this->cache->get($cache_file);
        if (!$news_data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) ";
            $sql .= " WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ";
            $sql .= " $str " ;
            $sql .= " ORDER BY p.date_insert DESC, p.news_id DESC";
            $query = $this->db->query($sql);
            $tmp = $query->rows;
            $news_data = array();

            $total = count($tmp);
            $i=0;
            $start = 0;
            $length = 0;

            foreach($tmp as $item){
                if($item['news_id']==$news_id){
                    $start = ($i-$limit) > 0 ? ($i-$limit):0;
                    $end = ($i+1+$limit > count($tmp)) ? count($tmp) : $i+1+$limit;
                    $length = $end-$start;
                    break;
                }
                $i++;
            }

            if($news_id==0){
                $start=0;
                $length=$limit+1;
            }
            $news_data = array_slice($tmp, $start, $length);

            $this->cache->set($cache_file, $news_data);
        }

        //$query = $this->db->query($sql);
        $data1 = array();

        if(isset($_SESSION['scaleimg']) && $_SESSION['scaleimg']=='1'){
            $folder = HTTP_IMAGE_MOBILE;
            $folder_dir = DIR_IMAGE_MOBILE;
            $img_temp = PATH_IMAGE_THUMB_MOBILE;
        }else{
            $folder = HTTP_IMAGE;
            $folder_dir = DIR_IMAGE;
            $img_temp = PATH_IMAGE_THUMB;
        }

        foreach($news_data as $row){
            $path = $path ? $path : $this->model_cms_common->getPath($row['category_id']);
            $data = array();
            $data['id'] = $row['news_id'];
            $data['name'] = html_entity_decode((string)$row['name']);
            $data['ishome'] = $row['ishome'];
			$data['isnew'] = $row['isnew'];
            $data['date_insert'] = $row['date_insert'];
            $data['category_id'] = $row['category_id'];

            $data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/news','path='. $path . '&news_id='.$row['news_id'],$this->config->get('config_language')) .'.html');

            $search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
            $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
            $des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
            $checkdes = strip_tags($des);
            $data['description'] = !empty($checkdes)?$des:'';

            $des = str_replace('HTTP_CATALOG',HTTP_SERVER,html_entity_decode((string)$row['desc_short']));
            $checkdes = strip_tags($des);
            $data['desc_short'] = !empty($checkdes)?$des:'';

            preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
            $data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
            $data['image'] = empty($data['image'])&&isset($image['src'])&& !empty($image['src'])?$image['src']:$data['image'];
            $data['image'] = empty($data['image'])?'':str_replace(HTTP_IMAGE,'',(string)$data['image']);

            $data['image_home'] = empty($row['image_home']) || !is_file($folder_dir . $row['image_home'])?'': str_replace(' ', '%20', (string)$row['image_home']);

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

}
?>