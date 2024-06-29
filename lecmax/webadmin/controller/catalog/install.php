<?php
class ControllerCatalogInstall extends Controller {
	private $error = array();

	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('install',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
	}

	public function index() {
		/*$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('install',2);
		foreach($langs as $lang){
			$this->data[$lang['key']] = $lang['name'];
		}
		*/
		$this->document->setTitle($this->data['heading_title']);

		$this->getForm();
	}

	private function installController(){
		/*===================FRONTEND========================*/
		$controller_source_frontend = DIR_INSTALL . 'controller\catalog\frontend.php';
		$controller_destination_frontend = DIR_CATALOG . 'controller\cms\\' . $this->request->post['name'] . '.php';

		$str_controller_frontend = implode('', file($controller_source_frontend));

		$str_controller_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller_frontend);
		$str_controller_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller_frontend);
		$this->saveFile($controller_destination_frontend, $str_controller_frontend);

		/*===================SITEMAP========================*/
		if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$controller_sitemap_frontend = DIR_CATALOG . 'controller\cms\sitemap.php';
			$str_controller_sitemap_frontend = implode('', file($controller_sitemap_frontend));

			if(strpos($str_controller_sitemap_frontend, '// ' . ucfirst($this->request->post['name']) . ' sitemap') === false){

				$str_controller_sitemap_frontend = str_replace('/*{INCLUDE_SITEMAP_MODULE}*/', implode('',file(DIR_INSTALL . 'sitemap/sitemap_module.php'))  , $str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_upper}',strtoupper($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller_sitemap_frontend);

				//$this->saveFile($controller_sitemap_frontend, $str_controller_sitemap_frontend);
			}

			if(strpos($str_controller_sitemap_frontend, '// Get' . ucfirst($this->request->post['name']) . 'All sitemap') === false){

				$str_controller_sitemap_frontend = str_replace('/*{INCLUDE_SITEMAP_LOAD_MODULE_GETALL}*/', implode('',file(DIR_INSTALL . 'sitemap/sitemap_load_module_getall.php'))  , $str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_upper}',strtoupper($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller_sitemap_frontend);

				//$this->saveFile($controller_sitemap_frontend, $str_controller_sitemap_frontend);
			}

			if(strpos($str_controller_sitemap_frontend, '// Switch case index ' . ucfirst($this->request->post['name']) . ' sitemap') === false){

				$str_controller_sitemap_frontend = str_replace('/*{INCLUDE_SITEMAP_CASE_INDEX}*/', implode('',file(DIR_INSTALL . 'sitemap/sitemap_case_index.php'))  , $str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_upper}',strtoupper($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller_sitemap_frontend);

				//$this->saveFile($controller_sitemap_frontend, $str_controller_sitemap_frontend);
			}

			if(strpos($str_controller_sitemap_frontend, '// Switch case page ' . ucfirst($this->request->post['name']) . ' sitemap') === false){

				$str_controller_sitemap_frontend = str_replace('/*{INCLUDE_SITEMAP_CASE_PAGE}*/', implode('',file(DIR_INSTALL . 'sitemap/sitemap_case_page.php'))  , $str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername_upper}',strtoupper($this->request->post['name']),$str_controller_sitemap_frontend);
				$str_controller_sitemap_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller_sitemap_frontend);

				//$this->saveFile($controller_sitemap_frontend, $str_controller_sitemap_frontend);
			}
			$this->saveFile($controller_sitemap_frontend, $str_controller_sitemap_frontend);
		}

		/*===================BACKEND====controller_destination_frontend==================*/
		$controller_source = DIR_INSTALL . 'controller\catalog\chuan.php';
		$controller_destination = DIR_APPLICATION . 'controller\catalog\\' . $this->request->post['name'] . '.php';

		$str_controller = implode('', file($controller_source));

		/*=====================================Hình========================================*/
		if(isset($this->request->post['image']) && $this->request->post['image']==1){
			$str_controller = str_replace('/*{INCLUDE_IMAGE_TOOL}*/', implode('',file(DIR_INSTALL . 'image/include_image_tool.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_LIST}*/', implode('',file(DIR_INSTALL . 'image/image_list.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_LIST_ARRAY}*/', implode('',file(DIR_INSTALL . 'image/image_list_array.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'image/image_form.php'))  , $str_controller);

			if(isset($this->request->post['validate_image']) && $this->request->post['validate_image']){
				$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'image/error_image.php'))  , $str_controller);
				$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'image/validate_error_image.php'))  , $str_controller);
			}
		}

		/*=====================================Hình 1========================================*/
		if(isset($this->request->post['image1']) && $this->request->post['image1']==1){
			$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'image1/image_form.php'))  , $str_controller);

			if(isset($this->request->post['validate_image1']) && $this->request->post['validate_image1']){
				$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'image1/error_image.php'))  , $str_controller);
				$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'image1/validate_error_image.php'))  , $str_controller);
			}
		}
		/*=====================================Hiển thị trang chủ========================================*/
		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){
			if(isset($this->request->post['ishome_image']) && $this->request->post['ishome_image']==1){

				$str_controller = str_replace('/*{INCLUDE_IMAGE_TOOL}*/', implode('',file(DIR_INSTALL . 'imagehome/include_image_tool.php'))  , $str_controller);

				$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'imagehome/image_form_with_image.php'))  , $str_controller);

				$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'imagehome/error_image.php'))  , $str_controller);
				$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'imagehome/validate_error_image.php'))  , $str_controller);

			}else{
				$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'imagehome/image_form_no_image.php'))  , $str_controller);
			}

			$str_controller = str_replace('/*{FILTER_URL}*/', implode('',file(DIR_INSTALL . 'imagehome/filter_url.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_DATA}*/', implode('',file(DIR_INSTALL . 'imagehome/filter_data.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_PARAM}*/', implode('',file(DIR_INSTALL . 'imagehome/filter_param.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_VALUE}*/', implode('',file(DIR_INSTALL . 'imagehome/filter_value.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_LIST_ARRAY}*/', implode('',file(DIR_INSTALL . 'imagehome/image_list_array.php'))  , $str_controller);
		}

		/*=====================================Danh sach hinh========================================*/
		if(isset($this->request->post['images']) && $this->request->post['images']==1){
			$str_controller = str_replace('/*{INCLUDE_IMAGE_TOOL}*/', implode('',file(DIR_INSTALL . 'images/include_image_tool.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'images/form_controller.php'))  , $str_controller);

			if(isset($this->request->post['validate_images']) && $this->request->post['validate_images']==1){

				$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'images/error.php'))  , $str_controller);
				$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'images/validate.php'))  , $str_controller);
			}
		}

		/*=====================================SEO========================================*/
		if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'seo/form_controller.php'))  , $str_controller);
		}

		/*=====================================VIDEO=================================*/
		if(isset($this->request->post['video']) && $this->request->post['video']==1){
			$str_controller = str_replace('/*{INSERT_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'video/controller_insert.php'))  , $str_controller);
			$str_controller = str_replace('/*{UPDATE_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'video/controller_update.php'))  , $str_controller);
			$str_controller = str_replace('/*{DELETE_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'video/controller_delete.php'))  , $str_controller);
			$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'video/controller_validate.php'))  , $str_controller);
			$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'video/controller_getform_1.php'))  , $str_controller);
			$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'video/controller_getform_2.php'))  , $str_controller);
		}


		/*=====================================DOWNLOAD PDF=================================*/
		if(isset($this->request->post['download']) && $this->request->post['download']==1){
			$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'pdf/error.php'))  , $str_controller);
			$str_controller = str_replace('/*{VALIDATE_PDF}*/', implode('',file(DIR_INSTALL . 'pdf/validate.php'))  , $str_controller);
			$str_controller = str_replace('/*{INSERT_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'pdf/insert_controller.php'))  , $str_controller);
			$str_controller = str_replace('/*{UPDATE_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'pdf/update_controller.php'))  , $str_controller);
			$str_controller = str_replace('/*{DELETE_CONTROLLER}*/', implode('',file(DIR_INSTALL . 'pdf/delete_controller.php'))  , $str_controller);
		}



		/*=====================================CATEGORY=================================*/
		if(isset($this->request->post['category']) && $this->request->post['category']==1){
			$str_controller = str_replace('/*{$CHANGE_TITLE}*/', implode('',file(DIR_INSTALL . 'category/change_title.php'))  , $str_controller);
			$str_controller = str_replace('/*{ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'category/error.php'))  , $str_controller);
			$str_controller = str_replace('/*{VALIDATE_ERROR_IMAGE}*/', implode('',file(DIR_INSTALL . 'category/validate.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_URL}*/', implode('',file(DIR_INSTALL . 'category/filter_url.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_DATA}*/', implode('',file(DIR_INSTALL . 'category/filter_data.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_PARAM}*/', implode('',file(DIR_INSTALL . 'category/filter_param.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_VALUE}*/', implode('',file(DIR_INSTALL . 'category/filter_value.php'))  , $str_controller);

			if(isset($this->request->post['displaycategory']) && $this->request->post['displaycategory']==1){
				$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'category/form_controller.php'))  , $str_controller);
			}else{
				$str_controller = str_replace('/*{INCLUDE_CATEGORY}*/', implode('',file(DIR_INSTALL . 'category/include_category.php'))  , $str_controller);
				$str_controller = str_replace('/*{IMAGE_LIST_ARRAY}*/', implode('',file(DIR_INSTALL . 'category/image_list_array.php'))  , $str_controller);
				$str_controller = str_replace('/*{IMAGE_FORM}*/', implode('',file(DIR_INSTALL . 'category/include_category_form.php'))  , $str_controller);
			}

			$str_controller = str_replace('/*{CATEGORY_ID}*/', (int)$this->request->post['categoryid']  , $str_controller);

			$str_controller = str_replace('/*{controllercatename_lower}*/', $this->db->escape($this->request->post['categoryname'])  , $str_controller);
		}
		/*=====================================SUB LIST=================================*/
		if(isset($this->request->post['sublist']) && $this->request->post['sublist']==1){
			if($this->request->post['array_id']==0){
				$strtmp = '$cate==0';
			}else{
				$arr = explode(';', $this->request->post['array_id']);
				$strtmp = "1==2 ";
				foreach($arr as $id){
					$strtmp .= ' || $result["{$controllername_lower}_id"]==' . (int)$id ;
				}
			}

			$str_controller = str_replace('/*{SUBLIST}*/', implode('',file(DIR_INSTALL . 'sublist/sublist.php'))  , $str_controller);
			$str_controller = str_replace('/*{CONDITION}*/', $strtmp  , $str_controller);
			$str_controller = str_replace('/*{BACK}*/', implode('',file(DIR_INSTALL . 'sublist/back.php'))  , $str_controller);
			$str_controller = str_replace('/*{FORM_DATA}*/', implode('',file(DIR_INSTALL . 'sublist/form_data.php'))  , $str_controller);
			$str_controller = str_replace('/*{$CHANGE_TITLE}*/', implode('',file(DIR_INSTALL . 'sublist/change_title.php'))  , $str_controller);

			$str_controller = str_replace('/*{FILTER_URL}*/', implode('',file(DIR_INSTALL . 'sublist/filter_url.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_DATA}*/', implode('',file(DIR_INSTALL . 'sublist/filter_data.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_PARAM}*/', implode('',file(DIR_INSTALL . 'sublist/filter_param.php'))  , $str_controller);
			$str_controller = str_replace('/*{FILTER_VALUE}*/', implode('',file(DIR_INSTALL . 'sublist/filter_value.php'))  , $str_controller);
		}

		$str_controller = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_controller);
		$str_controller = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_controller);
		$this->saveFile($controller_destination, $str_controller);
	}

	private function installRewriteUrl(){
		//$source = DIR_INSTALL . 'rewrite\seo_url.php';
		$source = DIR_CATALOG . 'controller\common\seo_url.php';
		$destination = DIR_CATALOG . 'controller\common\seo_url.php';

		$str = implode('', file($source));

		$str = str_replace('/*{ID}*/', implode('',file(DIR_INSTALL . 'rewrite/id.php'))  , $str);
		$str = str_replace('/*{ROUTE}*/', implode('',file(DIR_INSTALL . 'rewrite/route.php'))  , $str);
		$str = str_replace('/*{KEY}*/', implode('',file(DIR_INSTALL . 'rewrite/key.php'))  , $str);

		$str = str_replace('{$controllername}',strtolower($this->request->post['name']),$str);

		$this->saveFile($destination, $str);
	}

	private function installModel(){
		/*===================FRONTEND========================*/
		$model_source_frontend = DIR_INSTALL . 'model\catalog\frontend.php';
		$model_destination_frontend = DIR_CATALOG . 'model\cms\\' . $this->request->post['name'] . '.php';

		$str_model_frontend = implode('', file($model_source_frontend));

		if(isset($this->request->post['category']) && $this->request->post['category']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_GET_BY_CATE}*/', implode('',file(DIR_INSTALL . 'frontend/get_by_cate.php'))  , $str_model_frontend);
			$str_model_frontend = str_replace('{$controllercatename_lower}', $this->db->escape($this->request->post['categoryname'])  , $str_model_frontend);
		}

		if(isset($this->request->post['image']) && $this->request->post['image']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_DATA_ROW}*/', implode('',file(DIR_INSTALL . 'frontend/data_row_image.php'))  , $str_model_frontend);
		}

		if(isset($this->request->post['image1']) && $this->request->post['image1']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_DATA_ROW}*/', implode('',file(DIR_INSTALL . 'frontend/data_row_image1.php'))  , $str_model_frontend);
		}

		if(isset($this->request->post['download']) && $this->request->post['download']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_DATA_ROW}*/', implode('',file(DIR_INSTALL . 'frontend/data_row_pdf.php'))  , $str_model_frontend);
		}

		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){
			if(isset($this->request->post['ishome_image']) && $this->request->post['ishome_image']==1){
				$str_model_frontend = str_replace('/*{FRONTEND_GET_HOME}*/', implode('',file(DIR_INSTALL . 'frontend/get_home_with_image.php'))  , $str_model_frontend);
			}else{
				$str_model_frontend = str_replace('/*{FRONTEND_GET_HOME}*/', implode('',file(DIR_INSTALL . 'frontend/get_home_no_image.php'))  , $str_model_frontend);
			}
		}

		if(isset($this->request->post['images']) && $this->request->post['images']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_GET_IMAGES}*/', implode('',file(DIR_INSTALL . 'frontend/get_images.php'))  , $str_model_frontend);
			$str_model_frontend = str_replace('/*{FRONTEND_DATA_ROW}*/', implode('',file(DIR_INSTALL . 'frontend/data_row_images.php'))  , $str_model_frontend);
		}

		if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$str_model_frontend = str_replace('/*{FRONTEND_DATA_ROW}*/', implode('',file(DIR_INSTALL . 'frontend/data_row_seo.php'))  , $str_model_frontend);
		}

		$str_model_frontend = str_replace('{$controllername_lower}',strtolower($this->request->post['name']),$str_model_frontend);
		$str_model_frontend = str_replace('{$controllername}',ucfirst($this->request->post['name']),$str_model_frontend);
		$this->saveFile($model_destination_frontend, $str_model_frontend);

		/*===================BACKEND========================*/
		$model_source = DIR_INSTALL . 'model\catalog\chuan.php';
		$model_destination = DIR_APPLICATION . 'model\catalog\\' . $this->request->post['name'] . '.php';
		$str_model = implode('', file($model_source));

		if(isset($this->request->post['image']) && $this->request->post['image']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'image/string_image.php'))  , $str_model);
		}

		if(isset($this->request->post['image1']) && $this->request->post['image1']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'image1/string_image.php'))  , $str_model);
		}

		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'imagehome/string_image.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_FILTER}*/', implode('',file(DIR_INSTALL . 'imagehome/model_filter.php'))  , $str_model);
		}

		if(isset($this->request->post['images']) && $this->request->post['images']==1){
			$str_model = str_replace('/*{MODEL_INSERT}*/', implode('',file(DIR_INSTALL . 'images/model_insert.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_UPDATE}*/', implode('',file(DIR_INSTALL . 'images/model_update.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_COPY}*/', implode('',file(DIR_INSTALL . 'images/model_copy.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_DELETE}*/', implode('',file(DIR_INSTALL . 'images/model_delete.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_GET_IMAGES}*/', implode('',file(DIR_INSTALL . 'images/model_get_image.php'))  , $str_model);
		}

		if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'seo/string_image.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_INSERT}*/', implode('',file(DIR_INSTALL . 'seo/model_insert.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_UPDATE}*/', implode('',file(DIR_INSTALL . 'seo/model_update.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_DELETE}*/', implode('',file(DIR_INSTALL . 'seo/model_delete.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_GET_DESCRIPTION}*/', implode('',file(DIR_INSTALL . 'seo/model_get_description.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_INSERT_UPDATE}*/', implode('',file(DIR_INSTALL . 'seo/update_insert_edit.php'))  , $str_model);
		}

		if(isset($this->request->post['download']) && $this->request->post['download']==1){
			$str_model = str_replace('/*{MODEL_INSERT_UPDATE}*/', implode('',file(DIR_INSTALL . 'pdf/update_insert_edit.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_GET_DESCRIPTION}*/', implode('',file(DIR_INSTALL . 'pdf/model_get_description.php'))  , $str_model);
		}

		if(isset($this->request->post['video']) && $this->request->post['video']==1){
			$str_model = str_replace('/*{MODEL_INSERT}*/', implode('',file(DIR_INSTALL . 'video/model_insert.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_UPDATE}*/', implode('',file(DIR_INSTALL . 'video/model_update.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_GET_VIDEO}*/', implode('',file(DIR_INSTALL . 'video/model_get_video.php'))  , $str_model);
		}

		if(isset($this->request->post['category']) && $this->request->post['category']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'category/update_insert_edit.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_FILTER}*/', implode('',file(DIR_INSTALL . 'category/model_filter.php'))  , $str_model);
			$str_model = str_replace('/*{modelcatename_lower}*/',$this->db->escape($this->request->post['categoryname'])  , $str_model);
		}

		if(isset($this->request->post['sublist']) && $this->request->post['sublist']==1){
			$str_model = str_replace('/*{STRING_IMAGE}*/', implode('',file(DIR_INSTALL . 'sublist/update_insert_edit.php'))  , $str_model);
			$str_model = str_replace('/*{MODEL_FILTER}*/', implode('',file(DIR_INSTALL . 'sublist/model_filter.php'))  , $str_model);
		}

		$str_model = str_replace('{$modelname_lower}',strtolower($this->request->post['name']),$str_model);
		$str_model = str_replace('{$modelname}',ucfirst($this->request->post['name']),$str_model);
		$this->saveFile($model_destination, $str_model);
	}

	private function installView(){
		/*=====================FRONT_END====================*/
		$view_source_frontend = DIR_INSTALL . 'view\template\catalog\frontend.tpl';
		$view_source_frontend_detail = DIR_INSTALL . 'view\template\catalog\frontend_detail.tpl';

		$view_destination_frontend = DIR_CATALOG . 'view\theme\default\template\cms\\' . $this->request->post['name'] . '.tpl';
		$view_destination_frontend_detail = DIR_CATALOG . 'view\theme\default\template\cms\\' . $this->request->post['name'] . '_detail.tpl';

		$str_view_frontend = implode('', file($view_source_frontend));
		$str_view_frontend = str_replace('{$viewname_lower}',strtolower($this->request->post['name']),$str_view_frontend);

		$str_view_frontend_detail = implode('', file($view_source_frontend_detail));
		$str_view_frontend_detail = str_replace('{$viewname_lower}',strtolower($this->request->post['name']),$str_view_frontend_detail);

		$this->saveFile($view_destination_frontend, $str_view_frontend);
		$this->saveFile($view_destination_frontend_detail, $str_view_frontend_detail);

		/*======================================FORM=====================================================*/
		$view_source = DIR_INSTALL . 'view\template\catalog\chuan_form.tpl';
		$view_destination = DIR_APPLICATION . 'view\template\catalog\\' . $this->request->post['name'] . '_form.tpl';
		$str_view = implode('', file($view_source));

		/*==============category============*/
		if(isset($this->request->post['category']) && $this->request->post['category']==1){
			if(isset($this->request->post['displaycategory']) && $this->request->post['displaycategory']==1){
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'category/form.php'))  , $str_view);
			}else{
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'category/form1.php'))  , $str_view);
			}

			$str_view = str_replace('<!--{viewcatename_lower}-->', $this->db->escape($this->request->post['categoryname'])  , $str_view);
		}

		/*=========================Hình==================*/
		if(isset($this->request->post['image']) && $this->request->post['image']==1){
			$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/script_image.php'))  , $str_view);

			if(isset($this->request->post['validate_image']) && $this->request->post['validate_image']){
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/form_image_validate.php'))  , $str_view);
			}else{
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/form_image_no_validate.php'))  , $str_view);
			}
		}

		/*======================Hình 1==================*/
		if(isset($this->request->post['image1']) && $this->request->post['image1']==1){

			if(isset($this->request->post['validate_image1']) && $this->request->post['validate_image1']){
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'image1/form_image_validate.php'))  , $str_view);
			}else{
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'image1/form_image_no_validate.php'))  , $str_view);
			}
		}

		/*====================Hiển thị trang chủ =============*/
		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){

			if(isset($this->request->post['ishome_image']) && $this->request->post['ishome_image']){
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'imagehome/form_ishome_with_image.php'))  , $str_view);
				//add script
				if(isset($this->request->post['image']) && $this->request->post['image']==1){
					$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'imagehome/script_image_ishome.php'))  , $str_view);
				}else{
					$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'imagehome/script_image.php'))  , $str_view);
					$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'imagehome/script_image_ishome.php'))  , $str_view);
				}
			}else{
				$str_view = str_replace('<!--{FORM_IMAGE}-->', implode('',file(DIR_INSTALL . 'imagehome/form_ishome_no_image.php'))  , $str_view);
			}
		}

		/*==============Images============*/
		if(isset($this->request->post['images']) && $this->request->post['images']==1){
			$str_view = str_replace('<!--{TAB_FORM}-->', implode('',file(DIR_INSTALL . 'images/tab_form.php'))  , $str_view);
			$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'images/script_add_image.php'))  , $str_view);

			if(isset($this->request->post['validate_images']) && $this->request->post['validate_images']){
				$str_view = str_replace('<!--{TAB_DATA}-->', implode('',file(DIR_INSTALL . 'images/form_validate.php'))  , $str_view);
			}else{
				$str_view = str_replace('<!--{TAB_DATA}-->', implode('',file(DIR_INSTALL . 'images/form.php'))  , $str_view);
			}

			if(!isset($this->request->post['image']) || $this->request->post['images']!=1){
				$str_view = str_replace('<!--{SCRIPT_IMAGE}-->', implode('',file(DIR_INSTALL . 'images/script_image.php'))  , $str_view);
			}
		}

		/*==============SEO============*/
		if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
			$str_view = str_replace('<!--{TAB_FORM}-->', implode('',file(DIR_INSTALL . 'seo/tab_form.php'))  , $str_view);
			$str_view = str_replace('<!--{TAB_DATA}-->', implode('',file(DIR_INSTALL . 'seo/form.php'))  , $str_view);
		}

		/*==============VIDEO============*/
		if(isset($this->request->post['video']) && $this->request->post['video']==1){
			$str_view = str_replace('<!--{TAB_FORM}-->', implode('',file(DIR_INSTALL . 'video/view_tab_form.php'))  , $str_view);
			$str_view = str_replace('<!--{TAB_DATA}-->', implode('',file(DIR_INSTALL . 'video/view_form.php'))  , $str_view);
			$str_view = str_replace('<!--{VIEW_SCRIPT}-->', implode('',file(DIR_INSTALL . 'video/view_script.php'))  , $str_view);
		}

		/*==============PDF============*/
		if(isset($this->request->post['download']) && $this->request->post['download']==1){
			$str_view = str_replace('<!--{INSERT_FIELD_LANG}-->', implode('',file(DIR_INSTALL . 'pdf/form.php'))  , $str_view);
		}

		/*==============sublist============*/
		if(isset($this->request->post['sublist']) && $this->request->post['sublist']==1){
			$str_view = str_replace('<!--{FORM_HIDDEN}-->', implode('',file(DIR_INSTALL . 'sublist/form_hidden.php'))  , $str_view);
		}

		$str_view = str_replace('{$viewname_lower}',strtolower($this->request->post['name']),$str_view);
		$this->saveFile($view_destination, $str_view);

		/*======================================LIST=====================================================*/
		$view_source = DIR_INSTALL . 'view\template\catalog\chuan_list.tpl';
		$view_destination = DIR_APPLICATION . 'view\template\catalog\\' . $this->request->post['name'] . '_list.tpl';
		$str_view = implode('', file($view_source));

		if(isset($this->request->post['image']) && $this->request->post['image']==1 && isset($this->request->post['validate_image']) && $this->request->post['validate_image']==1){
			$str_view = str_replace('<!--{COLUMN_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/column_image.php'))  , $str_view);
			$str_view = str_replace('<!--{FILTER_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/filter_image.php'))  , $str_view);
			$str_view = str_replace('<!--{VALUE_IMAGE}-->', implode('',file(DIR_INSTALL . 'image/value_image.php'))  , $str_view);
		}

		if(isset($this->request->post['category']) && $this->request->post['category']==1){
			if(isset($this->request->post['displaycategory']) && $this->request->post['displaycategory']==1){
				//nothing
			}else{
				$str_view = str_replace('<!--{COLUMN}-->', implode('',file(DIR_INSTALL . 'category/column.php'))  , $str_view);
				$str_view = str_replace('<!--{FILTER}-->', implode('',file(DIR_INSTALL . 'category/filter.php'))  , $str_view);
				$str_view = str_replace('<!--{VALUE}-->', implode('',file(DIR_INSTALL . 'category/value.php'))  , $str_view);

				$str_view = str_replace('/*{FILTER_SCRIPT}*/', implode('',file(DIR_INSTALL . 'category/filter_script.php'))  , $str_view);
			}
		}

		if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){
			$str_view = str_replace('<!--{COLUMN}-->', implode('',file(DIR_INSTALL . 'imagehome/column.php'))  , $str_view);
			$str_view = str_replace('<!--{FILTER}-->', implode('',file(DIR_INSTALL . 'imagehome/filter.php'))  , $str_view);
			$str_view = str_replace('<!--{VALUE}-->', implode('',file(DIR_INSTALL . 'imagehome/value.php'))  , $str_view);
			$str_view = str_replace('/*{FILTER_SCRIPT}*/', implode('',file(DIR_INSTALL . 'imagehome/filter_script.php'))  , $str_view);
		}


		if(isset($this->request->post['sublist']) && $this->request->post['sublist']==1){
			$str_view = str_replace('<!--{BUTTON_BACK}-->', implode('',file(DIR_INSTALL . 'sublist/button_back.php'))  , $str_view);
		}

		$str_view = str_replace('<!--{viewcatename_lower}-->',strtolower($this->request->post['categoryname']),$str_view);

		$str_view = str_replace('{$viewname_lower}',strtolower($this->request->post['name']),$str_view);
		$this->saveFile($view_destination, $str_view);
	}

	private function installDatabase($option=array()){
		$this->load->model('catalog/install');

		$this->model_catalog_install->createTable($option);
	}

	private function installLanguage($option=array()){
		//install trong table module
		$this->load->model('catalog/install');

		$this->model_catalog_install->installLanguage($option);
	}

	public function insert() {

		$this->document->setTitle($this->data['heading_title']);
		//$this->load->model('catalog/install');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$option = array();
			$option['name'] = $this->request->post['name'];

			if(isset($this->request->post['image']) && $this->request->post['image']==1){
				$option['image'] = true;
			}

			if(isset($this->request->post['image1']) && $this->request->post['image1']==1){
				$option['image1'] = true;
			}

			if(isset($this->request->post['ishome']) && $this->request->post['ishome']==1){
				$option['ishome'] = true;
			}

			if(isset($this->request->post['images']) && $this->request->post['images']==1){
				$option['images'] = true;
			}

			if(isset($this->request->post['seo']) && $this->request->post['seo']==1){
				$option['seo'] = true;
			}

			if(isset($this->request->post['download']) && $this->request->post['download']==1){
				$option['pdf'] = true;
			}

			if(isset($this->request->post['category']) && $this->request->post['category']==1){
				$option['category'] = true;
			}

			if(isset($this->request->post['video']) && $this->request->post['video']==1){
				$option['video'] = true;
			}

			if(isset($this->request->post['sublist']) && $this->request->post['sublist']==1){
				$option['sublist'] = true;
			}
			/* install rewrite url*/
			$this->installRewriteUrl();

			/* install controller */

			$this->installController();

			/* install model */

			$this->installModel();

			/* install view */

			$this->installView();

			/* install database */

			$this->installDatabase($option);

			/* install language */

			$this->installLanguage($option);

			$this->session->data['success'] = $this->data['text_success'];

			$this->redirect($this->url->link('catalog/install', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		$this->getForm();
	}

	private function getForm() {

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->data['action'] = $this->url->link('catalog/install/insert', 'token=' . $this->session->data['token'], '', 'SSL');

		$this->data['token'] = $this->session->data['token'];


		$this->template = 'catalog/install_form.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/install')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if(empty($this->request->post['name'])){
			$this->error['name'] = $this->data['error_name'];
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->data['error_warning'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/install')) {
			$this->error['warning'] = $this->data['error_permission'];
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function saveFile($file,$content)	{
		$fp = fopen($file, "w");
		fputs($fp, $content);

		fclose($fp);

	}

}
?>