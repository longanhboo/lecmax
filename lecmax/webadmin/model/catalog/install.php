<?php
class ModelCatalogInstall extends Model {

	public function createTable($option=array()) {
		$sql = "DROP TABLE IF EXISTS `" . $this->db->escape($option['name']) . "`";
		$this->db->query($sql);

		$sql = "DROP TABLE IF EXISTS `" . $this->db->escape($option['name']) . "_description`";
		$this->db->query($sql);

		$str = "";
		if(isset($option['image']) && $option['image']==true) {
			$str .= "`image` varchar(255) collate utf8_bin default NULL, ";
			//$str .= "`preview` varchar(255) collate utf8_bin default NULL, ";
		}

		if(isset($option['image1']) && $option['image1']==true)
			$str .= "`image1` varchar(255) collate utf8_bin default NULL, ";

		if(isset($option['ishome']) && $option['ishome']==true){
			$str .= "`image_home` varchar(255) collate utf8_bin default NULL, ";
			$str .= "`ishome` int(1) default '0', ";
		}

		if(isset($option['video']) && $option['video']==true){
			$str .= "`image_video` varchar(255) collate utf8_bin default NULL, ";
			$str .= "`filename_mp4` varchar(255) collate utf8_bin default NULL, ";
			$str .= "`filename_webm` varchar(255) collate utf8_bin default NULL, ";
			$str .= "`isftp` int(1) default '0', ";
			$str .= "`isyoutube` int(1) default '0', ";
			$str .= "`script` text collate utf8_bin, ";
		}

		if(isset($option['category']) && $option['category']==true){
			$str .= "`". $this->db->escape($this->request->post['categoryname']) ."_id` varchar(255) collate utf8_bin default NULL, ";
		}

		if(isset($option['sublist']) && $option['sublist']==true){
			$str .= "`cate` int(11) default '0', ";
		}
		if(isset($option['seo']) && $option['seo']==1){
			$str .= "`image_og` varchar(255) collate utf8_bin default NULL, ";
		}

		$sql = "CREATE TABLE `". $this->db->escape($option['name']) ."` (`". $this->db->escape($option['name']) ."_id` int(11) NOT NULL auto_increment, $str `sort_order` int(11) NOT NULL default '0', `status` int(1) NOT NULL default '0', `date_added` datetime NOT NULL default '0000-00-00 00:00:00', `date_modified` datetime NOT NULL default '0000-00-00 00:00:00', `viewed` int(5) NOT NULL default '0', PRIMARY KEY  (`". $this->db->escape($option['name']) ."_id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		$this->db->query($sql);

		$strdes = "";

		if(isset($option['seo']) && $option['seo']==1){
			$strdes .= "`meta_title` varchar(255) collate utf8_bin default NULL, ";
			$strdes .= "`meta_description` varchar(255) collate utf8_bin default NULL, ";
			$strdes .= "`meta_keyword` varchar(255) collate utf8_bin default NULL, ";
			$strdes .= "`meta_description_og` varchar(255) collate utf8_bin default NULL, ";
			$strdes .= "`meta_title_og` varchar(255) collate utf8_bin default NULL, ";
		}

		if(isset($option['pdf']) && $option['pdf']==1){
			$strdes .= "`pdf` varchar(255) collate utf8_bin default NULL, ";
		}

		$sql = "CREATE TABLE `". $this->db->escape($option['name']) ."_description` ( `". $this->db->escape($option['name']) ."_id` int(11) NOT NULL auto_increment, `language_id` int(11) NOT NULL, `name` varchar(255) collate utf8_bin NOT NULL, `description` text collate utf8_bin, $strdes PRIMARY KEY  (`". $this->db->escape($option['name']) ."_id`,`language_id`), KEY `name` (`name`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		$this->db->query($sql);

		$sql = "DROP TABLE IF EXISTS `" . $this->db->escape($option['name']) . "_image`";
		$this->db->query($sql);

		if(isset($option['images']) && $option['images']==true){
			$sql = "CREATE TABLE `". $this->db->escape($option['name']) ."_image` ( `". $this->db->escape($option['name']) ."_image_id` int(11) NOT NULL auto_increment, `". $this->db->escape($option['name']) ."_id` int(11) NOT NULL, `image` varchar(255) collate utf8_bin default NULL, `image1` varchar(255) collate utf8_bin default NULL, `image_name` varchar(255) collate utf8_bin default NULL, `image_name_en` varchar(255) collate utf8_bin default NULL, `image_sort_order` int(11) NOT NULL default 0, PRIMARY KEY  (`". $this->db->escape($option['name']) ."_image_id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
			$this->db->query($sql);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE '". $this->db->escape($option['name']) . "_id=%'");
	}

	public function installLanguage($option=array()){
		$sql = "DELETE FROM " . DB_PREFIX . "module WHERE `name` = '" . $this->db->escape($option['name']) . "'";
		$this->db->query($sql);

		$sql = "INSERT INTO " . DB_PREFIX . "module SET `name` = '" . $this->db->escape($option['name']) . "', `frontend` = '1'" ;
		$this->db->query($sql);
		$sql = "INSERT INTO " . DB_PREFIX . "module SET `name` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
		$this->db->query($sql);

		//sitemap
		if(isset($option['seo']) && $option['seo']==1){
			$sql = "DELETE FROM " . DB_PREFIX . "sitemap WHERE `name` = '" . $this->db->escape($option['name']) . "'";
			$this->db->query($sql);

			$sql = "INSERT INTO " . DB_PREFIX . "sitemap SET `name` = '" . $this->db->escape($option['name']) . "', `frontend` = '1' , `seo_url` = '1', `frequencies` = 'always', `priority` = '0.5'" ;
			$this->db->query($sql);
		}

		/*=======xoa du lieu==============*/
		$sql = "DELETE FROM " . DB_PREFIX . "lang_description WHERE `lang_id` IN (SELECT lang_id FROM " . DB_PREFIX . "lang WHERE `module`='" . $this->db->escape($option['name']) . "')";
		$this->db->query($sql);
		$sql = "DELETE FROM " . DB_PREFIX . "lang WHERE `module` ='" . $this->db->escape($option['name']) . "'";
		$this->db->query($sql);

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "lang` WHERE module = 'standard'");

		if ($query->num_rows) {
			foreach($query->rows as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT * FROM `" . DB_PREFIX . "lang_description` WHERE lang_id = '" . (int)$row['lang_id']. "'");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($subrow['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		if(isset($option['image']) && $option['image']==true){
			$array_key = array();
			$array_key[] = array('key'=>'column_image','name'=>'Hình');
			$array_key[] = array('key'=>'entry_image','name'=>'Hình:');
			$array_key[] = array('key'=>'help_entry_image','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'error_image','name'=>'Vui lòng nhập hình');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		if(isset($option['image1']) && $option['image1']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_image1','name'=>'Hình 1:');
			$array_key[] = array('key'=>'help_entry_image1','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'error_image1','name'=>'Vui lòng nhập hình');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		if(isset($option['ishome']) && $option['ishome']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_ishome','name'=>'Hiển thị trang chủ:');
			$array_key[] = array('key'=>'column_ishome','name'=>'Hiển thị trang chủ');
			$array_key[] = array('key'=>'entry_image_home','name'=>'Hình trang chủ:');
			$array_key[] = array('key'=>'help_image_home','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'error_image_home','name'=>'Vui lòng nhập hình trang chủ');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =====================================images===============================*/
		if(isset($option['images']) && $option['images']==true){
			$array_key = array();
			$array_key[] = array('key'=>'column_images','name'=>'Hình');
			$array_key[] = array('key'=>'column_images1','name'=>'Hình 1');
			$array_key[] = array('key'=>'column_images_name','name'=>'Tiêu đề');
			$array_key[] = array('key'=>'column_sort_order','name'=>'STT');
			$array_key[] = array('key'=>'help_column_images','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'help_column_images1','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'error_list_image','name'=>'Vui lòng thêm hình');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =====================================SEO===============================*/
		if(isset($option['seo']) && $option['seo']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_meta_title','name'=>'Tiêu đề SEO:');
			$array_key[] = array('key'=>'entry_meta_keyword','name'=>'Từ khoá SEO:');
			$array_key[] = array('key'=>'entry_meta_description','name'=>'Mô tả SEO:');
			$array_key[] = array('key'=>'entry_friendly_url','name'=>'Đường link thân thiện:');
			$array_key[] = array('key'=>'help_friendly_url','name'=>'Đường link thân thiện phải duy nhất không được trùng');
			$array_key[] = array('key'=>'entry_meta_title_og','name'=>'Og:Title:');
			$array_key[] = array('key'=>'entry_meta_description_og','name'=>'Og:description:');
			$array_key[] = array('key'=>'entry_image_og','name'=>'Og:image:');
			//$array_key[] = array('key'=>'help_entry_image_og','name'=>'Kích thước hình 200 x 200:');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =================================DOWNLOAD===============================*/
		if(isset($option['pdf']) && $option['pdf']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_download','name'=>'Download file:');
			$array_key[] = array('key'=>'help_download','name'=>'Chỉ hổ trợ file pdf');
			$array_key[] = array('key'=>'entry_delete_file','name'=>'Xóa file:');
			$array_key[] = array('key'=>'error_pdf_no_support','name'=>'File không đúng định dạng');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =====================================VIDEO===============================*/
		if(isset($option['video']) && $option['video']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_image_video','name'=>'Hình video:');
			$array_key[] = array('key'=>'help_image_video','name'=>'Kích thước hình');
			$array_key[] = array('key'=>'entry_upload_ftp','name'=>'Upload dùng ftp:');
			$array_key[] = array('key'=>'entry_file_mp4','name'=>'File mp4:');
			$array_key[] = array('key'=>'help_file_mp4','name'=>'Chỉ hỗ trợ file: (.mp4)<br/>Kích thước tối đa 10M');
			$array_key[] = array('key'=>'entry_file_webm','name'=>'File webm');
			$array_key[] = array('key'=>'help_file_webm','name'=>'Chỉ hỗ trợ file: (.webm)<br/>Kích thước tối đa 10M');
			$array_key[] = array('key'=>'entry_file_mp4_ftp','name'=>'Tên file mp4:');
			$array_key[] = array('key'=>'help_file_mp4_ftp','name'=>'Tên file mp4 upload trong ftp');
			$array_key[] = array('key'=>'entry_file_webm_ftp','name'=>'Tên file webm:');
			$array_key[] = array('key'=>'help_file_webm_ftp','name'=>'Tên file webm upload trong ftp');

			$array_key[] = array('key'=>'error_file_mp4_ftp','name'=>'Vui lòng nhập tên file mp4 đã upload lên ftp');
			$array_key[] = array('key'=>'error_file_webm_ftp','name'=>'Vui lòng nhập tên file webm đã upload lên ftp');
			$array_key[] = array('key'=>'error_no_support','name'=>'File không hỗ trợ');
			$array_key[] = array('key'=>'error_big_file','name'=>'Kích thước file quá lớn!');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =================================CATEGORY===============================*/
		if(isset($option['category']) && $option['category']==true){
			$array_key = array();
			$array_key[] = array('key'=>'entry_category','name'=>'Danh mục:');
			$array_key[] = array('key'=>'column_category','name'=>'Danh mục');
			$array_key[] = array('key'=>'error_category','name'=>'Vui lòng chọn danh mục');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

		/* =================================SUBLIST===============================*/
		if(isset($option['sublist']) && $option['sublist']==true){
			$array_key = array();
			$array_key[] = array('key'=>'text_list','name'=>'Danh sách');
			$array_key[] = array('key'=>'text_back','name'=>'Trở lại');

			foreach($array_key as $row){
				$sql = "INSERT INTO " . DB_PREFIX . "lang SET `key` = '" . $this->db->escape($row['key']) . "',`module` = '" . $this->db->escape($option['name']) . "', `frontend` = '2'" ;
				$this->db->query($sql);
				$id = $this->db->getLastId();

				$subquery = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` ");
				foreach($subquery->rows as $subrow){
					$sql = "INSERT INTO " . DB_PREFIX . "lang_description SET `lang_id` = '" . (int)$id . "', `language_id` = '" . (int)$subrow['language_id'] . "',`name` = '" . $this->db->escape($row['name']) . "'" ;
					$this->db->query($sql);
				}
			}
		}

	}
}
?>