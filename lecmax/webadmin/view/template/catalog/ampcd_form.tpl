<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-ampcd" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <lbl class="s-mobile"><?php echo $button_cancel; ?></lbl></a>
			</div>
			<h3 ><?php echo $heading_title; ?></h3>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
        <?php 
        $entry_image = "Hình banner:";
        $help_entry_image = "Kích thước hình tương đối 2000 x 1125 px";
        ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-ampcd" class="form-horizontal">
					<!--{FORM_HIDDEN}-->
					<ul class="nav nav-tabs" style="display:none">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo;?></a></li>
<!--{TAB_FORM}-->
					</ul>
					<div class="tab-content">
						<!-- tab_general -->
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

									<div class="form-group required" style="display:none">
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group required" >
										<label class="col-sm-2 control-label" for="input-name1<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][name1]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['name1'] : ''; ?>"  id="input-name1<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>
                                    
                                    
                                    
                                    <div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-desc-short<?php echo $language['language_id']; ?>"><?php echo $entry_desc_short; ?></label>
										<div class="col-sm-10">
											<textarea name="ampcd_description[<?php echo $language['language_id']; ?>][desc_short]"  id="input-desc-short<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['desc_short'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none">
                    <label class="col-sm-2 control-label" for="ampcd_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" id="ampcd_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['meta_title'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group" style="display:none">
                    <label class="col-sm-2 control-label" for="ampcd_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="ampcd_description[<?php echo $language['language_id']; ?>][meta_description]" id="ampcd_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                                    
                                    <div class="form-group" style="display:none">
                    <label class="col-sm-2 control-label" for="ampcd_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="ampcd_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="ampcd_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                                    
                                    <div class="form-group required" style="display:none">
										<label class="col-sm-2 control-label" for="input-name2<?php echo $language['language_id']; ?>"><?php echo $entry_name2; ?></label>
										<div class="col-sm-10">
											<input type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][name2]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['name2'] : ''; ?>"  id="input-name2<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>
                                    
                                    <div class="form-group required" style="display:none">
										<label class="col-sm-2 control-label" for="input-name3<?php echo $language['language_id']; ?>"><?php echo $entry_name3; ?></label>
										<div class="col-sm-10">
											<input type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][name3]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['name3'] : ''; ?>"  id="input-name3<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" style="display:none" <?php if($ampcd_id!=4 && $ampcd_id!=7) echo 'style="display:none"';?> >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="ampcd_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-description-1<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?> (Đoạn 02)</label>
										<div class="col-sm-10">
											<textarea name="ampcd_description[<?php echo $language['language_id']; ?>][description1]"  id="input-description-1<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['description1'] : ''; ?></textarea>
										</div>
									</div>
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
								<div class="form-group required" <?php if($ampcd_id!=1) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
                </label>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                </a>
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                <?php if (isset($error_image) && !empty($error_image)) { ?>
                <div class="text-danger"><?php echo $error_image; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required" style="display:none" >
                <label class="col-sm-2 control-label">
                    <span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
                    </label><p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
                </label>
                <div class="col-sm-10">
                    <a href="" id="thumb-image-1" data-toggle="image" class="img-thumbnail">
                        <img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                    </a>
                    <input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-1" />
                    <!--<br />
                    <input type="checkbox" name="delete_image1" value="1" /> <?php echo $entry_delete_image;?>-->
                </div>
            </div>
            <!--{FORM_IMAGE}-->
            
            <div class="form-group" style="display:none" >
              <label class="col-sm-2 control-label">Vị trí hiển thị menu</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($categories as $category) { ?>
                <?php if(!$category['parent_id']){?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['category_id'], $pagelist)) { ?>
                      <input type="checkbox" name="pagelist[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelist[]" value="<?php echo $category['category_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
                <?php }?>
              </div>
              </div>
            </div>
            
            <div class="form-group" <?php if($ampcd_id!=4) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị giới thiệu</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($aboutuss as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['aboutus_id'], $pagelistaboutus)) { ?>
                      <input type="checkbox" name="pagelistaboutus[]" value="<?php echo $category['aboutus_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistaboutus[]" value="<?php echo $category['aboutus_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            <div class="form-group" <?php if($ampcd_id!=7) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị liên hệ</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($contacts as $category) { ?>
                <?php if($category['contact_id']!=3){?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['contact_id'], $pagelistcontact)) { ?>
                      <input type="checkbox" name="pagelistcontact[]" value="<?php echo $category['contact_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistcontact[]" value="<?php echo $category['contact_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
                <?php }?>
              </div>
              </div>
            </div>
            
            <!--<div class="form-group" <?php if($ampcd_id!=5) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị Lĩnh vực kinh doanh</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($businesss as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['business_id'], $pagelistbusiness)) { ?>
                      <input type="checkbox" name="pagelistbusiness[]" value="<?php echo $category['business_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistbusiness[]" value="<?php echo $category['business_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>-->
            
            <!--<div class="form-group" <?php if($ampcd_id!=10) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị Thương hiệu</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($brands as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['brand_id'], $pagelistbrand)) { ?>
                      <input type="checkbox" name="pagelistbrand[]" value="<?php echo $category['brand_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistbrand[]" value="<?php echo $category['brand_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>-->
            
            <!--<div class="form-group" <?php if($ampcd_id!=5) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị Showroom</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($showrooms as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['showroom_id'], $pagelistshowroom)) { ?>
                      <input type="checkbox" name="pagelistshowroom[]" value="<?php echo $category['showroom_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistshowroom[]" value="<?php echo $category['showroom_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>-->
            
            <div class="form-group" <?php if($ampcd_id!=5) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">Hiển thị Sản phẩm</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($products as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['product_id'], $pagelistproduct)) { ?>
                      <input type="checkbox" name="pagelistproduct[]" value="<?php echo $category['product_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistproduct[]" value="<?php echo $category['product_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            <div class="form-group" style="display:none" <?php if($ampcd_id!=6 && $ampcd_id!=1) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị dự án</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($projects as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['project_id'], $pagelistproject)) { ?>
                      <input type="checkbox" name="pagelistproject[]" value="<?php echo $category['project_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistproject[]" value="<?php echo $category['project_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            
            <div class="form-group" style="display:none" <?php if($ampcd_id!=8) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị Tin tức</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($newss as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['news_id'], $pagelistnews)) { ?>
                      <input type="checkbox" name="pagelistnews[]" value="<?php echo $category['news_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistnews[]" value="<?php echo $category['news_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            
            <div class="form-group"  <?php if($ampcd_id!=9) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị giải pháp</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($solutions as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['solution_id'], $pagelistsolution)) { ?>
                      <input type="checkbox" name="pagelistsolution[]" value="<?php echo $category['solution_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistsolution[]" value="<?php echo $category['solution_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            <!--<div class="form-group"  <?php if($ampcd_id!=9) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị đối tác</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($listpartners as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['listpartner_id'], $pagelistlistpartner)) { ?>
                      <input type="checkbox" name="pagelistlistpartner[]" value="<?php echo $category['listpartner_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistlistpartner[]" value="<?php echo $category['listpartner_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>-->
            
            <div class="form-group"  <?php if($ampcd_id!=10) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị Dịch vụ</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($services as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['service_id'], $pagelistservice)) { ?>
                      <input type="checkbox" name="pagelistservice[]" value="<?php echo $category['service_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistservice[]" value="<?php echo $category['service_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            <!--<div class="form-group" <?php if($ampcd_id!=10) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị cổ đông</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($categories_codong as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['category_id'], $pagelistcodong)) { ?>
                      <input type="checkbox" name="pagelistcodong[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistcodong[]" value="<?php echo $category['category_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>-->
            
            <div class="form-group"  <?php if($ampcd_id!=11) echo 'style="display:none"';?>  >
              <label class="col-sm-2 control-label">Hiển thị tuyển dụng</label>
              <div class="col-sm-10">
              <div class="well well-sm" style="height: 250px; overflow: auto;">
                <?php foreach ($recruitments as $category) { ?>
                <div class="checkbox">
                    <label>
                      <?php if (in_array($category['recruitment_id'], $pagelistrecruitment)) { ?>
                      <input type="checkbox" name="pagelistrecruitment[]" value="<?php echo $category['recruitment_id']; ?>" checked="checked" />
                      <?php echo $category['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="pagelistrecruitment[]" value="<?php echo $category['recruitment_id']; ?>" />
                      <?php echo $category['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                <?php }?>
              </div>
              </div>
            </div>
            
            

								<div class="form-group" >
									<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
									<div class="col-sm-10">
										<select name="status" id="input-status" class="form-control">
											<?php if ($status) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group" style="display:none">
									<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
									</div>
								</div>

							</div>
						</div>
						            <div class="tab-pane " id="tab-seo">
              <ul class="nav nav-tabs" id="language-seo">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language-seo<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language-seo<?php echo $language['language_id']; ?>">

                  

                  

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="ampcd_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="ampcd_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="ampcd_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="ampcd_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control"  name="ampcd_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="ampcd_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($ampcd_description[$language['language_id']]) ? $ampcd_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
                    </div>
                  </div>

                </div>
                <?php } ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    <span data-toggle="tooltip" title="<?php echo $help_entry_image_og; ?>"><?php echo $entry_image_og; ?></span><br/>
                    </label><p class="s-mobile s-mobile-help"><?php echo $help_entry_image_og ?></p>
                  </label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <a href="" id="thumb-imageog" data-toggle="image" class="img-thumbnail">
                        <img src="<?php if(empty($preview_og)) echo 'view/image/image.png'; else echo $preview_og; ?>" alt="" title="" data-placeholder="<?php echo $image_og; ?>" />
                      </a>
                      <input type="hidden" name="image_og" value="<?php echo $image_og; ?>" id="input-imageog" />
                    </label>
                    <label class="radio-inline">
                      <input type="checkbox" name="delete_image_og" value="1" /> <?php echo $entry_delete_image;?>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group" style="display:none">
                <label class="col-sm-2 control-label" for="keyword">
                  <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                  </label><p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                </label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <!--{TAB_DATA}-->
					</div>

				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		<?php foreach ($languages as $language) { ?>
			$("#input-description<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'italic', 'underline','superscript', 'subscript', 'clear']],['history', ['undo', 'redo']],['table', ['table']],['insert', ['link','picture']]],
			});
			
			$("#input-description-1<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'italic', 'underline','superscript', 'subscript', 'clear']],['history', ['undo', 'redo']],['insert', ['link']]],
			});
			<?php } ?>
		//
	</script>
	<!--{VIEW_SCRIPT}-->
	
<!--{SCRIPT_IMAGE}-->
	<script type="text/javascript">
		$('.date').datetimepicker({
			pickTime: false
		});

		$('.time').datetimepicker({
			pickDate: false
		});

		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});
	</script>
	<script type="text/javascript">
		$('#language a:first').tab('show');
		$('#language-seo a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>