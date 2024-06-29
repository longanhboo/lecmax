<?php
class ControllerCmsSitemap extends Controller {
	private $error = array();
	private $lang_url = '';
	private $languages = array();
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('header',1);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
		
		$this->lang_url = isset($session->data['language'])?$session->data['language']:$this->config->get('config_language');
		
		$query = $this->registry->get('db')->query("SELECT p.code, p.name, p.language_id, p.locale, p.image, p.status, p.sort_order FROM " . DB_PREFIX . "language p  WHERE status='1'"); 
		$this->languages = $query->rows;
	}

	function Path ($p) {
		$a = explode ("/", $p);
		$len = strlen ($a[count ($a) - 1]);
		return (substr ($p, 0, strlen ($p) - $len));
	}

	function GetUrl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function Scan($url) {
		global $scanned, $pf, $extension, $skip, $freq, $priority;

		$temp_str = '';
		array_push ($scanned, $url);
		$html = $this->GetUrl ($url);
		$a1 = explode ("<img", $html);
		foreach ($a1 as $key => $val)
		{
			if($key==0)
				continue;
			$parts = explode (">", $val);
			$a = $parts[0];
			$aparts = explode ("src=", $a);
			if(isset($aparts[1])){
				$hrefparts = explode (" ", $aparts[1]);
			}else{
				$hrefparts = explode (" ", $aparts[0]);
			}
			$hrefparts2 = explode ("#", $hrefparts[0]);
			$href = str_replace ("\"", "", $hrefparts2[0]);
			if ((substr ($href, 0, 7) != "http://") && (substr ($href, 0, 8) != "https://") && (substr ($href, 0, 6) != "ftp://"))
			{
				if ($href == '/')
					$href = "$scanned[0]$href";
				else
					$href = $this->Path ($url) . $href;
			}
			if (substr ($href, 0, strlen ($scanned[0])) == $scanned[0])
			{
				$ignore = false;
				if (isset ($skip)){
					foreach ($skip as $k => $v)
						if (substr ($href, 0, strlen ($v)) == $v)
							$ignore = true;
					}
					if ((!$ignore) && (!in_array ($href, $scanned)) && (strpos ($href, $extension) > 0)	){}
						$temp_str .= "\t\t<image>\n";
					$temp_str .= "\t\t\t<image:loc>" . $href . "</image:loc>\n";
				/*if ( isset( $img['title'] ) && ! empty( $img['title'] ) ) {
					$temp_str .= "\t\t\t<image:title><![CDATA[" . _wp_specialchars( html_entity_decode( $img['title'], ENT_QUOTES, $this->charset ) ) . "]]></image:title>\n";
				}
				if ( isset( $img['alt'] ) && ! empty( $img['alt'] ) ) {
					$temp_str .= "\t\t\t<image:caption><![CDATA[" . _wp_specialchars( html_entity_decode( $img['alt'], ENT_QUOTES, $this->charset ) ) . "]]></image:caption>\n";
				}*/
				$temp_str .= "\t\t</image>\n";
			}
		}
		return $temp_str;
	}

	public function index() {
		$this->load->model('cms/common');
		$this->load->model('cms/sitemap');
		$output = '';

		//$this->data['startTime'] = microtime(true);
		//$startTime = microtime(true);

		$format = isset($this->request->get['format']) && !empty($this->request->get['format'])?$this->request->get['format']:'index';
		$module_active = str_replace('-','',$format);
		if(!in_array($format, array("sitemap", "index"))) $format = "sitemap";

		$this->data['category'] = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<?xml-stylesheet type="text/xsl" href="'.PATH_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.xsl'.'"?>' . "\n";

		switch($format) {
			case "sitemap":
			$this->data['category'] .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
			break;
			case "index":
			$this->data['category'] .= '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
			break;
		}

		$results = $this->getCategorieslist(0);
		
		$date_modified = array();
		foreach ($results as $key => $row) {
			if($row['date_modified']=='0000-00-00 00:00:00'){
				$date_modified[$key] = $row['date_added'];
			}else{
				$date_modified[$key] = $row['date_modified'];
			}
		}
		array_multisort($date_modified, SORT_DESC, $results);
        		
        // GetNewsAll sitemap        
        $this->load->model('cms/news');
		$newss = $this->model_cms_news->getNewsAll(ID_NEWS);
		// End GetNewsAll

        		
        // GetAboutusAll sitemap        
        $this->load->model('cms/aboutus');
		$aboutuss = $this->model_cms_aboutus->getAboutusAll(ID_ABOUTUS);
		// End GetAboutusAll
        		
        
        		
        // GetContactAll sitemap        
        $this->load->model('cms/contact');
		$contacts = $this->model_cms_contact->getContactAll(ID_CONTACT);
		// End GetContactAll
		
        		
        /*// GetBusinessAll sitemap        
        $this->load->model('cms/business');
		$businesss = $this->model_cms_business->getBusinessAll(ID_BUSINESS);
		// End GetBusinessAll
*/
        		
        // GetProjectAll sitemap        
        $this->load->model('cms/project');
		$projects = $this->model_cms_project->getProjectAll(ID_PROJECT);
		// End GetProjectAll

        	
        // GetRecruitmentAll sitemap        
        $this->load->model('cms/recruitment');
		$recruitments = $this->model_cms_recruitment->getRecruitmentAll(ID_NEWS);
		// End GetRecruitmentAll

        		
        // GetGalleryAll sitemap        
        //$this->load->model('cms/gallery');
		//$gallerys = $this->model_cms_gallery->getGalleryAll(ID_GALLERY);
		// End GetGalleryAll

        		
        // GetShowroomAll sitemap        
        //$this->load->model('cms/showroom');
		//$showrooms = $this->model_cms_showroom->getShowroomAll(ID_SHOWROOM);
		// End GetShowroomAll

        		
        /*// GetBrandAll sitemap        
        $this->load->model('cms/brand');
		$brands = $this->model_cms_brand->getBrandAll(ID_BRAND);
		// End GetBrandAll
*/
        		
        /*// GetCatebrandAll sitemap        
        $this->load->model('cms/catebrand');
		$catebrands = $this->model_cms_catebrand->getCatebrandAll(ID_CATEBRAND);
		// End GetCatebrandAll
*/
        		
        // GetProductAll sitemap        
        $this->load->model('cms/product');
		$products = $this->model_cms_product->getProductAll(ID_PRODUCT);
		// End GetProductAll

        		
        // GetServiceAll sitemap        
        $this->load->model('cms/service');
		$services = $this->model_cms_service->getServiceAll(ID_SERVICE);
		// End GetServiceAll

        		
        // GetSolutionAll sitemap        
        //$this->load->model('cms/solution');
		//$solutions = $this->model_cms_solution->getSolutionAll(ID_SOLUTION);
		// End GetSolutionAll

        		
        // GetProductbematAll sitemap        
        //$this->load->model('cms/productbemat');
		//$productbemats = $this->model_cms_productbemat->getProductbematAll(ID_PRODUCTBEMAT);
		// End GetProductbematAll

        		
        // GetAccessoriesAll sitemap        
        //$this->load->model('cms/accessories');
		//$accessoriess = $this->model_cms_accessories->getAccessoriesAll(ID_SERVICE);
		// End GetAccessoriesAll

        		
        // GetDistributionAll sitemap        
        //$this->load->model('cms/distribution');
		//$distributions = $this->model_cms_distribution->getDistributionAll(ID_DISTRIBUTION);
		// End GetDistributionAll

        		
        // GetSubcateproductAll sitemap        
        //$this->load->model('cms/subcateproduct');
		//$subcateproducts = $this->model_cms_subcateproduct->getSubcateproductAll(ID_PRODUCT);
		// End GetSubcateproductAll

        		
        // GetKhuvucAll sitemap        
        //$this->load->model('cms/khuvuc');
		//$khuvucs = $this->model_cms_khuvuc->getKhuvucAll(ID_KHUVUC);
		// End GetKhuvucAll

        		
        // GetDocumentAll sitemap        
        $this->load->model('cms/document');
		$documents = $this->model_cms_document->getDocumentAll(ID_DOCUMENT);
		// End GetDocumentAll

        		
        // GetCustomersAll sitemap        
        //$this->load->model('cms/customers');
		//$customerss = $this->model_cms_customers->getCustomersAll(ID_CUSTOMERS);
		// End GetCustomersAll

        /*{INCLUDE_SITEMAP_LOAD_MODULE_GETALL}*/
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
		switch($format) {
			case "index":
			$sitemaps = $this->model_cms_sitemap->getSitemaps();
			foreach($sitemaps as $item){
				switch($item['name']) {
					case "category":
					$tmp = reset($results);
					break;
							
        			// Switch case index News sitemap
					case "news":
						$tmp = reset($newss);
						break;
					// End Switch case index News
        
        					
        			// Switch case index Aboutus sitemap
					case "aboutus":
						$tmp = reset($aboutuss);
						break;
					// End Switch case index Aboutus
        			
        					
        			// Switch case index Contact sitemap
					case "contact":
						$tmp = reset($contacts);
						break;
					// End Switch case index Contact
					
        					
        			/*// Switch case index Business sitemap
					case "business":
						$tmp = reset($businesss);
						break;
					// End Switch case index Business
        */
        					
        			// Switch case index Project sitemap
					case "project":
						$tmp = reset($projects);
						break;
					// End Switch case index Project
        
        			
        					
        			// Switch case index Recruitment sitemap
					case "recruitment":
						$tmp = reset($recruitments);
						break;
					// End Switch case index Recruitment
        
        					
        			// Switch case index Gallery sitemap
					/*case "gallery":
						$tmp = reset($gallerys);
						break;*/
					// End Switch case index Gallery
        
        					
        			// Switch case index Showroom sitemap
					/*case "showroom":
						$tmp = reset($showrooms);
						break;*/
					// End Switch case index Showroom
        
        					
        			/*// Switch case index Brand sitemap
					case "brand":
						$tmp = reset($brands);
						break;
					// End Switch case index Brand
        */
        			/*		
        			// Switch case index Catebrand sitemap
					case "catebrand":
						$tmp = reset($catebrands);
						break;
					// End Switch case index Catebrand
        */
        					
        			// Switch case index Product sitemap
					case "product":
						$tmp = reset($products);
						break;
					// End Switch case index Product
        
        					
        			// Switch case index Service sitemap
					case "service":
						$tmp = reset($services);
						break;
					// End Switch case index Service
        
        					
        			// Switch case index Solution sitemap
					/*case "solution":
						$tmp = reset($solutions);
						break;*/
					// End Switch case index Solution
        
        					
        			// Switch case index Productbemat sitemap
					/*case "productbemat":
						$tmp = reset($productbemats);
						break;*/
					// End Switch case index Productbemat
        
        					
        			// Switch case index Accessories sitemap
					/*case "accessories":
						$tmp = reset($accessoriess);
						break;*/
					// End Switch case index Accessories
        
        					
        			// Switch case index Distribution sitemap
					/*case "distribution":
						$tmp = reset($distributions);
						break;*/
					// End Switch case index Distribution
        
        					
        			// Switch case index Subcateproduct sitemap
					/*case "subcateproduct":
						$tmp = reset($subcateproducts);
						break;*/
					// End Switch case index Subcateproduct
        
        					
        			// Switch case index Khuvuc sitemap
					/*case "khuvuc":
						$tmp = reset($khuvucs);
						break;*/
					// End Switch case index Khuvuc
        
        					
        			// Switch case index Document sitemap
					case "document":
						$tmp = reset($documents);
						break;
					// End Switch case index Document
        
        					
        			// Switch case index Customers sitemap
					/*case "customers":
						$tmp = reset($customerss);
						break;*/
					// End Switch case index Customers
        
        			/*{INCLUDE_SITEMAP_CASE_INDEX}*/
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
				}
				$date_modified = $tmp['date_modified'];
				if(isset($tmp['date_modified'])){
					if($tmp['date_modified']=='0000-00-00 00:00:00'){
						$date_modified = $tmp['date_added'];
					}else{
						$date_modified = $tmp['date_modified'];
					}
					//$date_modified = $tmp['date_modified'];
				}else{
					$date_today = getdate();
					$date_modified = date('Y-m-d H:i:s',$date_today[0]);
				}

				$output .= "\t<sitemap>\n";
				$output .= "\t\t<loc>";
				$output .= HTTP_SERVER . 'sitemap-' . $item['name']. '.xml';
				$output .= "</loc>\n";
				$output .= "\t\t<lastmod>";
				$output .= date('Y-m-d\TH:i:s+00:00', strtotime($date_modified));
				$output .= "</lastmod>\n";
				$output .= "\t</sitemap>\n";
			}
			break;
			case "sitemap":
			switch($module_active) {
				case "category":
				$list_item_module = ($results);
				$id_module = 0;
				break;
        				
        		// Switch case page News sitemap
				case "news":
					$list_item_module = ($newss);
					$id_module = ID_NEWS;
					break;
				
                // End Switch case page News
        
        				
        		// Switch case page Aboutus sitemap
				case "aboutus":
					$list_item_module = ($aboutuss);
					$id_module = ID_ABOUTUS;
					break;
				
                // End Switch case page Aboutus
        			
        		// Switch case page Contact sitemap
				case "contact":
					$list_item_module = ($contacts);
					$id_module = ID_CONTACT;
					break;
				
                // End Switch case page Contact
						
        		/*// Switch case page Business sitemap
				case "business":
					$list_item_module = ($businesss);
					$id_module = ID_BUSINESS;
					break;
				
                // End Switch case page Business
        */
        				
        		// Switch case page Project sitemap
				case "project":
					$list_item_module = ($projects);
					$id_module = ID_PROJECT;
					break;
				
                // End Switch case page Project
        
        			
        		// Switch case page Recruitment sitemap
				case "recruitment":
					$list_item_module = ($recruitments);
					$id_module = ID_NEWS;
					break;
				
                // End Switch case page Recruitment
        
        				
        		// Switch case page Gallery sitemap
				/*case "gallery":
					$list_item_module = ($gallerys);
					$id_module = ID_GALLERY;
					break;
				*/
                // End Switch case page Gallery
        
        				
        		// Switch case page Showroom sitemap
				/*case "showroom":
					$list_item_module = ($showrooms);
					$id_module = ID_SHOWROOM;
					break;
				*/
                // End Switch case page Showroom
        
        				
        		/*// Switch case page Brand sitemap
				case "brand":
					$list_item_module = ($brands);
					$id_module = ID_BRAND;
					break;
				
                // End Switch case page Brand
        */
        		/*		
        		// Switch case page Catebrand sitemap
				case "catebrand":
					$list_item_module = ($catebrands);
					$id_module = ID_CATEBRAND;
					break;
				
                // End Switch case page Catebrand
        */
        				
        		// Switch case page Product sitemap
				case "product":
					$list_item_module = ($products);
					$id_module = ID_PRODUCT;
					break;
				
                // End Switch case page Product
        
        				
        		// Switch case page Service sitemap
				case "service":
					$list_item_module = ($services);
					$id_module = ID_SERVICE;
					break;
				
                // End Switch case page Service
        
        				
        		// Switch case page Solution sitemap
				/*case "solution":
					$list_item_module = ($solutions);
					$id_module = ID_SOLUTION;
					break;
				*/
                // End Switch case page Solution
        
        				
        		// Switch case page Productbemat sitemap
				/*case "productbemat":
					$list_item_module = ($productbemats);
					$id_module = ID_PRODUCTBEMAT;
					break;
				*/
                // End Switch case page Productbemat
        
        				
        		// Switch case page Accessories sitemap
				/*case "accessories":
					$list_item_module = ($accessoriess);
					$id_module = ID_SERVICE;
					break;*/
				
                // End Switch case page Accessories
        
        				
        		// Switch case page Distribution sitemap
				/*case "distribution":
					$list_item_module = ($distributions);
					$id_module = ID_DISTRIBUTION;
					break;
				*/
                // End Switch case page Distribution
        
        				
        		// Switch case page Subcateproduct sitemap
				/*case "subcateproduct":
					$list_item_module = ($subcateproducts);
					$id_module = ID_PRODUCT;
					break;
				*/
                // End Switch case page Subcateproduct
        
        				
        		// Switch case page Khuvuc sitemap
				/*case "khuvuc":
					$list_item_module = ($khuvucs);
					$id_module = ID_KHUVUC;
					break;
				*/
                // End Switch case page Khuvuc
        
        				
        		// Switch case page Document sitemap
				case "document":
					$list_item_module = ($documents);
					$id_module = ID_DOCUMENT;
					break;
				
                // End Switch case page Document
        
        				
        		// Switch case page Customers sitemap
				/*case "customers":
					$list_item_module = ($customerss);
					$id_module = ID_CUSTOMERS;
					break;
				*/
                // End Switch case page Customers
        
        		/*{INCLUDE_SITEMAP_CASE_PAGE}*/
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
			}
			if($module_active=='category'){
				//$this->data['category'] .= $this->getCategoriessitemap(0);
				
				foreach($this->languages as $lng){
					$this->data['category'] .= $this->getCategoriessitemap(0,'',$lng['code']);
				}
			}else{
				$sitemap = $this->model_cms_sitemap->getSitemapByName($module_active);
				foreach($this->languages as $lng_temp){
					foreach ($list_item_module as $result) {
						$date_modified = $result['date_modified'];
						if($result['date_modified']=='0000-00-00 00:00:00'){
							$date_modified = $result['date_added'];
						}
						if (isset($result['category_id']) && $result['category_id']) {
							////$new_path = $id_module . '_' . $result['category_id'];
							//if($id_module!=ID_PRODUCT){
								$new_path = $this->model_cms_common->getPath($result['category_id']);
							//}else{
							//	$new_path = $id_module;
							//}
						} else {
							if($id_module==ID_DOCUMENT){
								$new_path = $this->model_cms_common->getPath(ID_DOCUMENT);
							}else{
							$new_path = $id_module;
							}
						}
						
						if($module_active=='recruitment'){
							$new_path .= '_' . ID_RECRUITMENT;
						}
						
						
						if($module_active!='aboutus' && $module_active!='recruitment' ){
						if (isset($result['cate']) && $result['cate']) {
							$new_path .= '&cate' . $module_active . '=' . $result['cate'];
						}
						}
						
						
						//if($id_module==ID_APARTMENT){
							
							//$this->load->model('cms/floor');
							//$temp_floor = $this->model_cms_floor->getFloor($result['floor_id']);
							//$new_path .= '&floor_id' . '=' . $result['floor_id'];
						//}
						$output .= "\t<url>\n";
						$output .= "\t\t<loc>";
						if($id_module==0){
							$href_url = $this->url->link(HTTP_SERVER . 'index.php?route=cms/'. $module_active . '&path=' . $new_path,'',$lng_temp['code']) . '.html';
							$output .= $href_url;
						}else{
							//if($id_module==ID_SUSTAINABLE){
							//	$href_url = $this->url->link(HTTP_SERVER . 'index.php?route=cms/'. $module_active . '&path=' . $new_path ,'',$this->lang_url) . '.html';
							//}else{
								$href_url = $this->url->link(HTTP_SERVER . 'index.php?route=cms/'. $module_active . '&path=' . $new_path . '&' . $module_active . '_id=' . $result[$module_active . '_id'],'',$lng_temp['code']) . '.html';
							//}
							$output .= $href_url;
						}
						$output .= "</loc>\n";
						foreach($this->languages as $lng){
						$output .= '<xhtml:link 
									   rel="alternate"
									   hreflang="' . $lng['code'] . '" 
									   href="'. $this->url->link(HTTP_SERVER . 'index.php?route=cms/'. $module_active . '&path=' . $new_path . '&' . $module_active . '_id=' . $result[$module_active . '_id'],'',$lng['code']) . '.html' . '"/>' . "\n";
						}
						$output .= "\t\t<lastmod>";
						$output .= date('Y-m-d\TH:i:s+00:00', strtotime($date_modified));
						$output .= "</lastmod>\n";
						if(!empty($sitemap['frequencies'])){
							$output .= "\t\t<changefreq>";
							$output .= $sitemap['frequencies'];
							$output .= "</changefreq>\n";
						}
						if(!empty($sitemap['priority'])){
							$output .= "\t\t<priority>";
							$output .= $sitemap['priority'];
							$output .= "</priority>\n";
						}
							//$output .= $this->Scan ($href_url);
						$output .= "\t</url>\n";
					}
				}
			}
			break;
		}

		//$this->data['endTime'] = microtime(true);
		$endTime = microtime(true);

		/*$output .= "<!--";
		$output .= " Seconds: " . round($endTime - $startTime,2);
		$output .= " ; Total memory: " . (memory_get_peak_usage(true) / 1024 / 1024) . "MB";
		$output .= "-->";*/

		$this->data['category'] .= $output;

		switch($format) {
			case "sitemap":
			$this->data['category'] .= "</urlset>";
			break;
			case "index":
			$this->data['category'] .= "</sitemapindex>";
			break;
		}


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/sitemap.tpl';
		} else {
			$this->template = 'default/template/information/sitemap.tpl';
		}

		$this->response->addHeader("Content-type: text/xml");
		$this->response->setOutput($this->render());
	}

	protected function getCategorieslist($parent_id, $current_path = '') {
		$output = '';
		$output_list = array();
		$results = $this->model_cms_common->getCategories($parent_id);
		$sitemap = $this->model_cms_sitemap->getSitemapByName('category');

		foreach ($results as $result) {
			$date_modified = $result['date_modified'];
			if($result['date_modified']=='0000-00-00 00:00:00'){
				$date_modified = $result['date_added'];
			}
			if($result['category_id']==ID_HOME){
				$output_list[] = $result;
			}else{
				if (!$current_path) {
					$new_path = $result['category_id'];
				} else {
					$new_path = $current_path . '_' . $result['category_id'];
				}
				$output_list[] = $result;
				$temp = $this->getCategorieslist($result['category_id'], $new_path);
				foreach($temp as $item){
					$output_list[] = $item;
				}
			}
		}
		return $output_list;
	}

	protected function getCategoriessitemap($parent_id, $current_path = '', $lang_code='') {
		$output = '';

		$results = $this->model_cms_common->getCategories($parent_id);
		$sitemap = $this->model_cms_sitemap->getSitemapByName('category');

		foreach ($results as $result) {
			$date_modified = $result['date_modified'];
			if($result['date_modified']=='0000-00-00 00:00:00'){
				$date_modified = $result['date_added'];
			}
			if ($result['category_id']==ID_HOME) {
				if($lang_code=='vi'){
					$output .= "\t<url>\n";
					$output .= "\t\t<loc>";
					$output .= HTTP_SERVER;
					$output .= "</loc>\n";
					foreach($this->languages as $lng){
							$output .= '<xhtml:link 
										   rel="alternate"
										   hreflang="' . $lng['code'] . '" 
										   href="'. HTTP_SERVER . '"/>' . "\n";
							}
					$output .= "\t\t<lastmod>";
					$output .= date('Y-m-d\TH:i:s+00:00', strtotime($date_modified));
					$output .= "</lastmod>\n";
					if(!empty($sitemap['frequencies'])){
						$output .= "\t\t<changefreq>";
						$output .= $sitemap['frequencies'];
						$output .= "</changefreq>\n";
					}
					$output .= "\t\t<priority>";
					$output .= '1.0';
					$output .= "</priority>\n";
					$output .= "\t</url>\n";
				}
				$output .= "\t<url>\n";
				$output .= "\t\t<loc>";
				$output .= HTTP_SERVER . $lang_code . '/';
				$output .= "</loc>\n";
				foreach($this->languages as $lng){
							$output .= '<xhtml:link 
										   rel="alternate"
										   hreflang="' . $lng['code'] . '" 
										   href="'. HTTP_SERVER . $lng['code'] . '/' . '"/>' . "\n";
							}
				$output .= "\t\t<lastmod>";
				$output .= date('Y-m-d\TH:i:s+00:00', strtotime($date_modified));
				$output .= "</lastmod>\n";
				if(!empty($sitemap['frequencies'])){
					$output .= "\t\t<changefreq>";
					$output .= $sitemap['frequencies'];
					$output .= "</changefreq>\n";
				}
				$output .= "\t\t<priority>";
				$output .= '1.0';
				$output .= "</priority>\n";
				$output .= "\t</url>\n";
			}else{
				//
				//if ($result['category_id']!=ID_DESIGNTOOL && $result['parent_id']!=ID_SHAREHOLDER) {
				if (!$current_path) {
					$new_path = $result['category_id'];
				} else {
					$new_path = $current_path . '_' . $result['category_id'];
				}
				////if($result['parent_id']!=ID_SHAREHOLDER){
						if($result['category_id']!=ID_HOME ){
						$output .= "\t<url>\n";
						$output .= "\t\t<loc>";
						$output .= $this->url->link(HTTP_SERVER . 'index.php?route=product/category&path=' . $new_path,'',$lang_code) . '.html' ;
						$output .= "</loc>\n";
						foreach($this->languages as $lng){
							$output .= '<xhtml:link 
										   rel="alternate"
										   hreflang="' . $lng['code'] . '" 
										   href="'. $this->url->link(HTTP_SERVER . 'index.php?route=product/category&path=' . $new_path,'',$lng['code']) . '.html' . '"/>' . "\n";
							}
						$output .= "\t\t<lastmod>";
						$output .= date('Y-m-d\TH:i:s+00:00', strtotime($date_modified));
						$output .= "</lastmod>\n";
						if(!empty($sitemap['frequencies'])){
							$output .= "\t\t<changefreq>";
							$output .= $sitemap['frequencies'];
							$output .= "</changefreq>\n";
						}
						if(!empty($sitemap['priority'])){
							$output .= "\t\t<priority>";
							$output .= $sitemap['priority'];
							$output .= "</priority>\n";
						}
						$output .= "\t</url>\n";
						}
						$output .= $this->getCategoriessitemap($result['category_id'], $new_path, $lang_code);
				//
				//}
			}
		}

		return $output;
	}

	private function GetTimestampFromMySql($mysqlDateTime) {
		list($date, $hours) = explode(' ', $mysqlDateTime);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $min, $sec) = explode(':', $hours);
		return mktime(intval($hour), intval($min), intval($sec), intval($month), intval($day), intval($year));
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_cms_common->getCategories($parent_id);
		if ($results) {
			$output .= '<ul>';
		}

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<li>';

			$output .= '<a href="' . $this->url->link(HTTP_SERVER . 'index.php?route=product/category&path=' . $new_path,'',$this->lang_url)  . '">' . $result['name'] . '</a>';

			$output .= $this->getCategories($result['category_id'], $new_path);

			$output .= '</li>';
		}

		if ($results) {
			$output .= '</ul>';
		}

		return $output;
	}

	public function robots() {

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/robots.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/robots.tpl';
		} else {
			$this->template = 'default/template/information/robots.tpl';
		}

		$this->response->addHeader("Content-type: text/plain");
		$this->response->setOutput($this->render());
	}


}
?>