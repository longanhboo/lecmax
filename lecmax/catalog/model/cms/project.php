<?php
class ModelCmsProject extends Model {

	//Lay tat ca
	public function getProjects($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.project_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['project_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/project','path='. $category_id .'_' . $row['category_id'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/project','path='. $category_id . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html';
			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
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

	/*{FRONTEND_GET_BY_CATE}*/
	
	public function getProjectByParent($category_id=0, $cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.project_id DESC";
		
		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['project_id'];
			$data['name'] = $row['name'];
			$data['name1'] = $row['name1'];
			$data['address'] = $row['address'];

			if(isset($row['category_id']))
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. $category_id .'_' . $row['category_id'] . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');
			else
				$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. $category_id  . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');
			
			$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
			$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			if(strpos($des,'<img')){
				$data['description'] = $des;
			}else{
				$checkdes = trim(strip_tags($des));
				$data['description'] = !empty($checkdes)?$des:'';
			}
			
			
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
			
			$data['images'] = $this->getImages($data['id']);
			if(!$cate){
				$data['child'] = $this->getProjectByParent($category_id,$data['id']);
			}
			
			
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
	$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' AND p.ishome='1' ORDER BY p.sort_order ASC, p.project_id DESC LIMIT 6"; 

	$query = $this->db->query($sql);
	$data1 = array();

	foreach($query->rows as $row){
		$data = array();
		$data['id'] = $row['project_id'];
		$data['name'] = $row['name'];
		$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
        $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
        $data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		
		$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');
		
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
		$data1[] = $data;
	}

	return $data1;
}

	//Lay dua vao id
	public function getProject($project_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.project_id = '" . $project_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['project_id'];
		$data['name'] = $row['name'];
		$data['name1'] = $row['name1'];
		
		$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT  . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])? '' : str_replace(' ', '%20', (string)$row['image1']);
		
		
		$data['images'] = $this->getImages($data['id']);
		
		if($row['cate']==0){
			$data['child'] = $this->getProjectByParent(ID_PROJECT, $data['id']);
		}else{
			$data['imagepros'] = $this->getImagepros($data['id']);
		}
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
		$data['meta_keyword'] = $row['meta_keyword'];
		$data['meta_description'] = $row['meta_description'];
		
		$data['image_og'] = $row['image_og'];
		$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
		$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
		
		/*{FRONTEND_DATA_ROW}*/
		return $data;
	}
	
	public function getProjectDefault($project_id)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.project_id = '" . $project_id . "'";
		
		$query = $this->db->query($sql);
		
		$data = array();

		$row = $query->row;

		$data['id'] = $row['project_id'];
		$data['name'] = $row['name'];
		$data['name1'] = $row['name1'];
		
		$data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. ID_PROJECT  . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>','</i></p>','</u></p>','</span></p>','</p>');
		$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		if(strpos($des,'<img')){
			$data['description'] = $des;
		}else{
			$checkdes = trim(strip_tags($des));
			$data['description'] = !empty($checkdes)?$des:'';
		}
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
		
		
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
	public function getImages($project_id){
		$sql = "SELECT * FROM ".DB_PREFIX."project_image WHERE project_id='".(int)$project_id."' ORDER BY image_sort_order ASC";
        
        $query = $this->db->query($sql);
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['project_image_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			
			$data1['name'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_name_en']))):trim(html_entity_decode(nl2br((string)$rs['image_name'])));
			
			$data[] = $data1;
		}
		return $data;
	}
	
	public function getImagepros($project_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."project_imagepro WHERE project_id='".(int)$project_id."' ORDER BY image_sort_order ASC");
		
		$data = array();
		foreach($query->rows as $rs){
			$data1 = array();
			$data1['id'] = $rs['project_imagepro_id'];
			$data1['image'] = empty($rs['image']) || !is_file(DIR_IMAGE . $rs['image'])?'': str_replace(' ', '%20', (string)$rs['image']);
			$data1['image1'] = empty($rs['image1']) || !is_file(DIR_IMAGE . $rs['image1'])? '': str_replace(' ', '%20', (string)$rs['image1']);
			
			$data1['name'] = ($this->config->get('config_language_id')==1)?trim(html_entity_decode(nl2br((string)$rs['image_name_en']))):trim(html_entity_decode(nl2br((string)$rs['image_name'])));
			
			$data[] = $data1;
		}
		return $data;
	}

	public function getProjectAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.project_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getRelatedProject($path, $category_id=0, $project_id=0)	{
        $limit = 3;
		$str = '';
		if($category_id){
			$str .= " AND p.cate = " . (int)$category_id;
		}
        $cache_file = 'projects.related.' . $this->config->get('config_language_id') . "." . $category_id . '.' . $project_id ;
        $project_data = $this->cache->get($cache_file);
        if (!$project_data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "project p LEFT JOIN " . DB_PREFIX . "project_description pd ON (p.project_id = pd.project_id) ";
            $sql .= " WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ";
            $sql .= " $str " ;
            $sql .= " ORDER BY p.sort_order ASC, p.project_id DESC";
            $query = $this->db->query($sql);
            $tmp = $query->rows;
            $project_data = array();

            $total = count($tmp);
            $i=0;
            $start = 0;
            $length = 0;

            foreach($tmp as $item){
                if($item['project_id']==$project_id){
                    $start = ($i-$limit) > 0 ? ($i-$limit):0;
                    $end = ($i+1+$limit > count($tmp)) ? count($tmp) : $i+1+$limit;
                    $length = $end-$start;
                    break;
                }
                $i++;
            }

            if($project_id==0){
                $start=0;
                $length=$limit+1;
            }
            $project_data = array_slice($tmp, $start, $length);

            $this->cache->set($cache_file, $project_data);
        }

        //$query = $this->db->query($sql);
        $data1 = array();
		
		$folder = HTTP_IMAGE;
		$folder_dir = DIR_IMAGE;
		$img_temp = PATH_IMAGE_THUMB;

        foreach($project_data as $row){
            $path = $path ? $path : $this->model_cms_common->getPath($row['category_id']);
            $data = array();
            $data['id'] = $row['project_id'];
            $data['name'] = html_entity_decode((string)$row['name']);
            

            $data['href'] = str_replace(HTTP_SERVER,'HTTP_SERVER',$this->url->link('cms/project','path='. $path . '&cateproject='.$row['cate'] . '&project_id='.$row['project_id'],$this->config->get('config_language')) .'.html');

            $search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
            $replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
            $des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
            $checkdes = strip_tags($des);
            $data['description'] = !empty($checkdes)?$des:'';

            preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
            $data['image'] = empty($row['image']) || !is_file($folder_dir . $row['image'])?'': str_replace(' ', '%20', (string)$row['image']);
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

}
?>