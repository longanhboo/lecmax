<?php
class ModelCmsContact extends Model {

	//Lay tat ca
	public function getContacts($category_id=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.contact_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['contact_id'];
			$data['name'] = $row['name'];

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/contact','path='. $category_id .'_' . $row['category_id'] . '&contact_id='.$row['contact_id'],$this->config->get('config_language')) .'.html';
			else
				$data['href'] = $this->url->link('cms/contact','path='. $category_id . '&contact_id='.$row['contact_id'],$this->config->get('config_language')) .'.html';

			$data['name2'] = $row['name2'];
			$data['name1'] = !empty($row['name1'])?html_entity_decode((string)$row['name1']):$row['name'];
			$data['address'] = $row['address'];
			$data['phone'] = $row['phone'];
			$data['email'] = $row['email'];
			$data['phoneviber'] = $row['phoneviber'];
			$data['fax'] = $row['fax'];
			$data['googlemap'] = html_entity_decode((string)$row['googlemap']);
			$data['timeface'] = $row['timeface'];
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$phonelist = strip_tags(html_entity_decode((string)$row['phonelist']));
			$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode((string)$row['phonelist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,((string)$row['phonelist'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$emaillist = strip_tags(html_entity_decode((string)$row['emaillist']));
			$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode((string)$row['emaillist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,((string)$row['emaillist'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$faxlist = strip_tags(html_entity_decode((string)$row['faxlist']));
			$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode((string)$row['faxlist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,((string)$row['faxlist'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$hotlinelist = strip_tags(html_entity_decode((string)$row['hotlinelist']));
			$data['hotlinelist'] = !empty($hotlinelist)?str_replace($search,$replace,html_entity_decode((string)$row['hotlinelist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['hotlinelist_infobox'] = !empty($hotlinelist)?str_replace($search,$replace,((string)$row['hotlinelist'])):'';
			
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['name1_infobox'] = !empty($name1)?str_replace($search,$replace,((string)$row['name1'])):'';
			
			
			$data['location'] = array();
			if(isset($row['location'])){
				$location = $row['location'];
				$arr_loc = explode(',',$location);
				$data['location'] = $arr_loc;
			}

			
			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
    		
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& is_file(DIR_IMAGE . $image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?PATH_IMAGE_THUMB:$data['image'];
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
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
	public function getContactByParent($category_id=0,$cate=0)	{
		$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND p.cate='$cate' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.contact_id DESC";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['contact_id'];
			$data['name'] = $row['name'];
			$data['name1'] = !empty($row['name1'])?html_entity_decode((string)$row['name1']):$row['name'];
			$data['address'] = $row['address'];
			$data['phone'] = $row['phone'];
			$data['email'] = $row['email'];
			$data['phoneviber'] = $row['phoneviber'];
			$data['fax'] = $row['fax'];
			$data['googlemap'] = html_entity_decode((string)$row['googlemap']);
			$data['timeface'] = $row['timeface'];
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$phonelist = strip_tags(html_entity_decode((string)$row['phonelist']));
			$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode((string)$row['phonelist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,((string)$row['phonelist'])):'';
			
			$search  = array('<', '>','"');
			$replace = array('\u003c', '\u003e','\"');
			mb_internal_encoding('utf-8');
			$data['phonelist_json'] = preg_replace('/\s+/u', ' ',str_replace($search,$replace,((string)$data['phonelist'])));
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$emaillist = strip_tags(html_entity_decode((string)$row['emaillist']));
			$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode((string)$row['emaillist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,((string)$row['emaillist'])):'';
			
			$search  = array('<', '>','"');
			$replace = array('\u003c', '\u003e','\"');
			mb_internal_encoding('utf-8');
			$data['emaillist_json'] = preg_replace('/\s+/u', ' ',str_replace($search,$replace,((string)$data['emaillist'])));
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$faxlist = strip_tags(html_entity_decode((string)$row['faxlist']));
			$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode((string)$row['faxlist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,((string)$row['faxlist'])):'';
			
			$search  = array('<', '>','"');
			$replace = array('\u003c', '\u003e','\"');
			mb_internal_encoding('utf-8');
			$data['faxlist_json'] = preg_replace('/\s+/u', ' ',str_replace($search,$replace,((string)$data['faxlist'])));
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$hotlinelist = strip_tags(html_entity_decode((string)$row['hotlinelist']));
			$data['hotlinelist'] = !empty($hotlinelist)?str_replace($search,$replace,html_entity_decode((string)$row['hotlinelist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['hotlinelist_infobox'] = !empty($hotlinelist)?str_replace($search,$replace,((string)$row['hotlinelist'])):'';
			
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['name1_infobox'] = !empty($name1)?str_replace($search,$replace,((string)$row['name1'])):'';
			
			$data['location'] = array();
			if(isset($row['location'])){
				$location = $row['location'];
				$arr_loc = explode(',',$location);
				$data['location'] = $arr_loc;
			}

			if(isset($row['category_id']))
				$data['href'] = $this->url->link('cms/contact','path='. $category_id .'_' . $row['category_id'] . '&contact_id='.$row['contact_id']) .'.html';
			else
				$data['href'] = $this->url->link('cms/contact','path='. $category_id . '&contact_id='.$row['contact_id']) .'.html';

			$search  = array('<div', '</div>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('<p', '</p>', '<strong>', '</strong>', HTTP_SERVER);
			$des = str_replace($search,$replace,html_entity_decode((string)$row['description']));
			$checkdes = strip_tags($des);
			$data['description'] = !empty($checkdes)?$des:'';
    		
			preg_match('/<img.+src=[\'"](?P<src>[^\s\'"]*)[\'"].?.*>/i', $data['description'], $image);
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			$data['image'] = empty($data['image'])&&isset($image['src'])&& is_file(DIR_IMAGE . $image['src'])?$image['src']:$data['image'];
			$data['image'] = empty($data['image'])?PATH_IMAGE_THUMB:$data['image'];
			
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
			$data['child'] = $this->getContactByParent($category_id, $data['id']);
    
    /*{FRONTEND_DATA_ROW}*/
			$data1[] = $data;
		}

		return $data1;
	}

	/*{FRONTEND_GET_BY_CATE}*/

	/*{FRONTEND_GET_HOME}*/
	public function getHome()	{
		$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND p.ishome='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.sort_order ASC, p.contact_id DESC LIMIT 4";

		$query = $this->db->query($sql);
		$data1 = array();

		foreach($query->rows as $row){
			$data = array();
			$data['id'] = $row['contact_id'];
			$data['name'] = $row['name'];
			$data['address'] = $row['address'];
			$data['googlemap'] = $row['googlemap'];

			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$phonelist = strip_tags(html_entity_decode((string)$row['phonelist']));
			$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode((string)$row['phonelist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,((string)$row['phonelist'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$emaillist = strip_tags(html_entity_decode((string)$row['emaillist']));
			$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode((string)$row['emaillist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,((string)$row['emaillist'])):'';
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$faxlist = strip_tags(html_entity_decode((string)$row['faxlist']));
			$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode((string)$row['faxlist'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,((string)$row['faxlist'])):'';
			
			
			$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
			$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
			$name1 = strip_tags(html_entity_decode((string)$row['name1']));
			$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';
			$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
			$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
			$data['name1_infobox'] = !empty($name1)?str_replace($search,$replace,((string)$row['name1'])):'';
			
			
			
			$data['location'] = $row['location'];
			
			$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image']);
			$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'': HTTP_IMAGE . str_replace(' ', '%20', (string)$row['image1']);
			
			$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
			
			$data1[] = $data;
		}

		return $data1;
	}

	//Lay dua vao id
	public function getContact($contact_id)	{
		$sql = "SELECT p.contact_id, p.tax, p.phone, p.phone1, p.email, p.email1, p.phoneviber, p.fax, p.fax1, p.fax2, p.googlemap, p.location, p.image, p.image, p.image1, p.image2, p.image_og, p.phonelist, p.faxlist, p.hotlinelist, p.emaillist, pd.name, pd.name1, pd.name2, pd.address, pd.description, pd.meta_title, pd.meta_keyword, pd.meta_description, pd.meta_title_og, pd.meta_description_og  FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.contact_id = '" . $contact_id . "'";

		$query = $this->db->query($sql);
		$data = array();

		$row = $query->row;

		$data['id'] = $row['contact_id'];
		$data['name'] = $row['name'];
		$data['name2'] = $row['name2'];
		$data['name1'] = !empty($row['name1'])?html_entity_decode((string)$row['name1']):$row['name'];
		$data['address'] = $row['address'];
		$data['phone'] = $row['phone'];
		$data['phone_tel'] = $this->remove_symbols($row['phone']);
		$data['phone1'] = $row['phone1'];
		$data['phone1_tel'] = $this->remove_symbols($row['phone1']);
		$data['email'] = $row['email'];
		$data['email1'] = $row['email1'];
		$data['phoneviber'] = $row['phoneviber'];
		$data['phoneviber_tel'] = $this->remove_symbols($row['phoneviber']);
		$data['fax'] = $row['fax'];
		$data['fax_tel'] = $this->remove_symbols($row['fax']);
		$data['fax1'] = $row['fax1'];
		$data['fax1_tel'] = $this->remove_symbols($row['fax1']);
		$data['fax2'] = $row['fax2'];
		$data['fax2_tel'] = $this->remove_symbols($row['fax2']);
		$data['googlemap'] = $row['googlemap'];
		$data['tax'] = $row['tax'];
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$phonelist = strip_tags(html_entity_decode((string)$row['phonelist']));
		$data['phonelist'] = !empty($phonelist)?str_replace($search,$replace,html_entity_decode((string)$row['phonelist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['phonelist_infobox'] = !empty($phonelist)?str_replace($search,$replace,((string)$row['phonelist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$emaillist = strip_tags(html_entity_decode((string)$row['emaillist']));
		$data['emaillist'] = !empty($emaillist)?str_replace($search,$replace,html_entity_decode((string)$row['emaillist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['emaillist_infobox'] = !empty($emaillist)?str_replace($search,$replace,((string)$row['emaillist'])):'';
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$faxlist = strip_tags(html_entity_decode((string)$row['faxlist']));
		$data['faxlist'] = !empty($faxlist)?str_replace($search,$replace,html_entity_decode((string)$row['faxlist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['faxlist_infobox'] = !empty($faxlist)?str_replace($search,$replace,((string)$row['faxlist'])):'';
		
		$search  = array('<div>', '</div>', '</p><p>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '<br>', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$hotlinelist = strip_tags(html_entity_decode((string)$row['hotlinelist']));
		$data['hotlinelist'] = !empty($hotlinelist)?str_replace($search,$replace,html_entity_decode((string)$row['hotlinelist'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;', '&lt;/p&gt;&lt;p&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '', '&lt;br&gt;','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['hotlinelist_infobox'] = !empty($hotlinelist)?str_replace($search,$replace,((string)$row['hotlinelist'])):'';
		
		
		$search  = array('<div>', '</div>', '<p>', '</p>', '<b>', '</b>', 'HTTP_CATALOG');
		$replace = array('', '', '', '', '<strong>', '</strong>', HTTP_SERVER);
		$name1 = strip_tags(html_entity_decode((string)$row['name1']));
		$data['name1'] = !empty($name1)?str_replace($search,$replace,html_entity_decode((string)$row['name1'])):'';
		$search  = array('&lt;div&gt;', '&lt;/div&gt;','&lt;p&gt;', '&lt;/p&gt;', '&lt;b&gt;', '&lt;/b&gt;', 'HTTP_CATALOG');
		$replace = array('', '','', '', '&lt;strong&gt;', '&lt;/strong&gt;', HTTP_SERVER);
		$data['name1_infobox'] = !empty($name1)?str_replace($search,$replace,((string)$row['name1'])):'';
		
		$data['location'] = array();
		if(isset($row['location'])){
			$location = $row['location'];
			$arr_loc = explode(',',$location);
			$data['location'] = $arr_loc;
		}
		
		$search  = array('<div', '</div>', '<b>', '<b ', '</b>', 'HTTP_CATALOG','<br></i></p>','<br></u></p>','<br></span></p>','<br></p>');
		$replace = array('<p', '</p>', '<strong>', '<strong ', '</strong>', HTTP_SERVER,'</i></p>','</u></p>','</span></p>','</p>');
		$data['description'] = str_replace($search,$replace,html_entity_decode((string)$row['description']));
		$data['image'] = empty($row['image']) || !is_file(DIR_IMAGE . $row['image'])?'':  str_replace(' ', '%20', (string)$row['image']);
		$data['image1'] = empty($row['image1']) || !is_file(DIR_IMAGE . $row['image1'])?'':  str_replace(' ', '%20', (string)$row['image1']);
		$data['image2'] = empty($row['image2']) || !is_file(DIR_IMAGE . $row['image2'])?'':  str_replace(' ', '%20', (string)$row['image2']);
		
		$data['meta_title'] = empty($row['meta_title'])?$row['name']:$row['meta_title'];
			$data['meta_keyword'] = $row['meta_keyword'];
			$data['meta_description'] = $row['meta_description'];
			
			$data['image_og'] = $row['image_og'];
			$data['meta_title_og'] = empty($row['meta_title_og'])?$row['meta_title']:$row['meta_title_og'];
			$data['meta_description_og'] = empty($row['meta_description_og'])?$row['meta_description']:$row['meta_description_og'];
    
    /*{FRONTEND_DATA_ROW}*/
		return $data;
	}

	/*{FRONTEND_GET_IMAGES}*/

	public function getContactAll($category_id=0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contact p LEFT JOIN " . DB_PREFIX . "contact_description pd ON (p.contact_id = pd.contact_id) WHERE p.status='1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND pd.name<>'' ORDER BY p.date_modified DESC, p.date_added DESC, p.sort_order ASC, p.contact_id DESC";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	function remove_symbols ( $string )
	{
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens. -
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one. -
	}

}
?>