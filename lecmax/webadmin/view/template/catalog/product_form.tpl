<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
					<input type="hidden" name="cate" value="<?php echo $cate;?>" />
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                        <li><a href="#tab-imagepros" data-toggle="tab"><?php echo $tab_imageproduct; ?></a></li>
                        <li><a href="#tab-thongso" data-toggle="tab"><?php echo $tab_thongso; ?></a></li>
                        <li><a href="#tab-banvekythuat" data-toggle="tab"><?php echo $tab_banvekythuat; ?></a></li>
                        <li><a href="#tab-imgpro" data-toggle="tab"><?php echo $tab_imgpro; ?></a></li>
                        <li><a href="#tab-phukien" data-toggle="tab"><?php echo $tab_phukien; ?></a></li>
                        <li><a href="#tab-project" data-toggle="tab"><?php echo $tab_project; ?></a></li>
<li><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo;?></a></li>
<li style="display:none"><a href="#tab-video" data-toggle="tab"><?php echo $tab_video; ?></a></li>
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

									<div class="form-group required">
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" >
										<label class="col-sm-2 control-label" for="input-desc-short<?php echo $language['language_id']; ?>"><?php echo $entry_desc_short; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][desc_short]"  id="input-desc-short<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['desc_short'] : ''; ?></textarea>
										</div>
									</div>

									
																		<div class="form-group" style="display:none">
										<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_download;?>"><?php echo $entry_download;?></span><br/>
											<p class="s-mobile s-mobile-help"><?php echo $help_download;?></p>
										</label>
										<div class="col-sm-10">
											<input type="file" name="product_description[<?php echo $language['language_id']; ?>][pdf]" />
											<?php
											$old_file[$language['language_id']] = isset($product_description[$language['language_id']]['pdf'])?$product_description[$language['language_id']]['pdf']:'';

											if(isset($product_description[$language['language_id']]['old_file'])){

												$old_file[$language['language_id']] = $product_description[$language['language_id']]['old_file'];
											}
											?>
											<span class="help"><?php echo $old_file[$language['language_id']]; ?></span>
											<input type="hidden" value="<?php echo $old_file[$language['language_id']]; ?>" name="product_description[<?php echo $language['language_id']; ?>][old_file]" />
											<br />
											<input type="checkbox" value="1" name="product_description[<?php echo $language['language_id']; ?>][delete_pdf]" /> <?php echo $entry_delete_file;?>

											<?php if (isset($error_pdf[$language['language_id']]) && !empty($error_pdf[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_pdf[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
								            <?php if($sublist_cate>0){?>
            <input type="hidden" name="category_id" value="<?php echo $sublist_cate;?>" class="form-control" />
            <?php }else{?>
            <?php $array_phukien = array();?>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="category_id"><?php echo $entry_category; ?></label>
              <div class="col-sm-10">
                <select name="category_id" id="category_id" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $item) { ?>
                  <?php if($item['level']!=0){?>
                  <?php if($item['parent_id']==407){?>
                  <?php $array_phukien[] = $item['category_id'];?>
                  <?php }?>
                  
                  <?php if ($item['category_id'] == $category_id) { ?>
                  <option value="<?php echo $item['category_id']; ?>" selected="selected"><?php echo $item['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $item['category_id']; ?>"><?php echo $item['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if (isset($error_category_id) && !empty($error_category_id)) { ?>
                <div class="text-danger"><?php echo $error_category_id; ?></div>
                <?php } ?>
              </div>
            </div>
            <?php }?>

            <div class="form-group required">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
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
            
            <div class="form-group display_home">
								<label class="col-sm-2 control-label" for="ishome"><?php echo $entry_ishome;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($ishome == "1") {?>
											<input id="ishome" value="1" type="checkbox" name="ishome" checked="checked"/>
											<?php } else {?>
											<input id="ishome" value="1" type="checkbox" name="ishome"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>
                            
                            <div class="form-group required display" style="display:none">
                              <label class="col-sm-2 control-label">
                                <span data-toggle="tooltip" title="<?php echo $help_image_home; ?>"><?php echo $entry_image_home; ?></span><br/>
                                <p class="s-mobile s-mobile-help"><?php echo $help_image_home ?></p>
                              </label>
                              <div class="col-sm-10">
                                <a href="" id="thumb-image-home" data-toggle="image" class="img-thumbnail">
                                  <img src="<?php if(empty($preview_home)) echo 'view/image/image.png'; else echo $preview_home; ?>" alt="" title="" data-placeholder="<?php echo $image_home; ?>" />
                                </a>
                                <input type="hidden" name="image_home" value="<?php echo $image_home; ?>" id="input-image-home" />
                                <?php if (isset($error_image_home) && !empty($error_image_home)) { ?>
                                <div class="text-danger"><?php echo $error_image_home; ?></div>
                                <?php } ?>
                              </div>
                            </div>
            				
            				<!--{FORM_IMAGE}-->


								<div class="form-group">
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

								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
									</div>
								</div>

							</div>
						</div>
                        
                        <!-- tab_thongso -->
                        <div class="tab-pane" id="tab-thongso">
							<ul class="nav nav-tabs sub-nav" id="languagethongso">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagethongso<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagethongso<?php echo $language['language_id']; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-namethongso<?php echo $language['language_id']; ?>"><?php echo $entry_namethongso; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][namethongso]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['namethongso'] : ''; ?>"  id="input-namethongso<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
																		

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
								

							</div>
						</div>
                        
                        <!-- tab_banvekythuat -->
                        <div class="tab-pane" id="tab-banvekythuat">
							<ul class="nav nav-tabs sub-nav" id="languagebanve">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagebanve<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagebanve<?php echo $language['language_id']; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-namebanve<?php echo $language['language_id']; ?>"><?php echo $entry_namebanve; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][namebanve]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['namebanve'] : ''; ?>"  id="input-namebanve<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" >
										<label class="col-sm-2 control-label" for="input-descriptionbanve<?php echo $language['language_id']; ?>"><?php echo $entry_descriptionbanve; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][descriptionbanve]"  id="input-descriptionbanve<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['descriptionbanve'] : ''; ?></textarea>
										</div>
									</div>
																		

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
							
            <div class="form-group">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-img1" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                </a>
                <input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-img1" />
                <?php if (isset($error_image1) && !empty($error_image1)) { ?>
                <div class="text-danger"><?php echo $error_image1; ?></div>
                <?php } ?>
                <br>
                <input type="checkbox" value="1" name="delete_image1"> <?php echo $entry_delete_image;?>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image2; ?>"><?php echo $entry_image2; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image2 ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-img2" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview2)) echo 'view/image/image.png'; else echo $preview2; ?>" alt="" title="" data-placeholder="<?php echo $image2; ?>" />
                </a>
                <input type="hidden" name="image2" value="<?php echo $image2; ?>" id="input-image-img2" />
                <?php if (isset($error_image2) && !empty($error_image2)) { ?>
                <div class="text-danger"><?php echo $error_image2; ?></div>
                <?php } ?>
                <br>
                <input type="checkbox" value="1" name="delete_image2"> <?php echo $entry_delete_image;?>
              </div>
            </div>
            

							</div>
						</div>
                        
                        <!-- tab_imgpro -->
                        <div class="tab-pane" id="tab-imgpro">
							<ul class="nav nav-tabs sub-nav" id="languageimgpro">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languageimgpro<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languageimgpro<?php echo $language['language_id']; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-nameimgpro<?php echo $language['language_id']; ?>"><?php echo $entry_nameimgpro; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][nameimgpro]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['nameimgpro'] : ''; ?>"  id="input-nameimgpro<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" >
										<label class="col-sm-2 control-label" for="input-descriptionimgpro<?php echo $language['language_id']; ?>"><?php echo $entry_descriptionimgpro; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][descriptionimgpro]"  id="input-descriptionimgpro<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['descriptionimgpro'] : ''; ?></textarea>
										</div>
									</div>
																		

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
								

							</div>
						</div>
                        
                        <!-- tab_phukien -->
                        <div class="tab-pane" id="tab-phukien">
							<ul class="nav nav-tabs sub-nav" id="languagephukien">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagephukien<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagephukien<?php echo $language['language_id']; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-namephukien<?php echo $language['language_id']; ?>"><?php echo $entry_namephukien; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][namephukien]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['namephukien'] : ''; ?>"  id="input-namephukien<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-descriptionphukien<?php echo $language['language_id']; ?>"><?php echo $entry_descriptionphukien; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][descriptionphukien]"  id="input-descriptionphukien<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['descriptionphukien'] : ''; ?></textarea>
										</div>
									</div>
																		

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
                                
                                <div class="form-group" >
                                <input type="hidden" name="array_phukien" id="array_phukien" value="<?php echo implode(',',$array_phukien);?>"  class="form-control" />
									<label class="col-sm-2 control-label" for="input-tensanpham"><?php echo $entry_product;?></label>
									<div class="col-sm-10">
										<input type="text" name="tensanpham" value="" id="input-tensanpham" class="form-control" autocomplete="off" />
                                        
                                        <div id="product-category" class="well well-sm" style="height: 300px; overflow: auto;">
                    <?php foreach ($product_categories as $product_category) { ?>
                    <div  class="product-category-id"  id="product-category<?php echo $product_category['product_id']; ?>" ><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                      <input type="hidden" name="product_category[]" value="<?php echo $product_category['product_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                  
                  
									</div>
								</div>
				
            

							</div>
						</div>
                        
                        <!-- tab_project -->
                        <div class="tab-pane" id="tab-project">
							<ul class="nav nav-tabs sub-nav" id="languageproject">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languageproject<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languageproject<?php echo $language['language_id']; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-nameproject<?php echo $language['language_id']; ?>"><?php echo $entry_nameproject; ?></label>
										<div class="col-sm-10">
											<input type="text" name="product_description[<?php echo $language['language_id']; ?>][nameproject]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['nameproject'] : ''; ?>"  id="input-nameproject<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-descriptionproject<?php echo $language['language_id']; ?>"><?php echo $entry_descriptionproject; ?></label>
										<div class="col-sm-10">
											<textarea name="product_description[<?php echo $language['language_id']; ?>][descriptionproject]"  id="input-descriptionproject<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['descriptionproject'] : ''; ?></textarea>
										</div>
									</div>
																		

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
				
            					<div class="form-group" >
									<label class="col-sm-2 control-label" for="input-tenduan"><?php echo $entry_project;?></label>
									<div class="col-sm-10">
										<input type="text" name="tenduan" value="" id="input-tenduan" class="form-control" autocomplete="off" />
                                        
                                        <div id="project-category" class="well well-sm" style="height: 300px; overflow: auto;">
                    <?php foreach ($project_categories as $project_category) { ?>
                    <div  class="project-category-id"  id="project-category<?php echo $project_category['project_id']; ?>" ><i class="fa fa-minus-circle"></i> <?php echo $project_category['name']; ?>
                      <input type="hidden" name="project_category[]" value="<?php echo $project_category['project_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                  
                  
									</div>
								</div>

							</div>
						</div>
						
                        <!-- tab_imagepro -->
                        <div class="tab-pane" id="tab-imagepros">
                        <div class="table-responsive">
                            <table id="imagepros" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images_imagepro; ?>"><?php echo $column_images_imagepro;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images_imagepro;?></p></td>
                                        <td class="text-left required " ><span data-toggle="tooltip" title="<?php echo $help_column_images1_imagepro; ?>"><?php echo $column_images1_imagepro;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1_imagepro;?></p></td>
                                        <td class="text-left required" style="display:none"><?php echo $column_images_imagepro_name; ?></td>
                                        <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                                        <td><?php if(isset($error_images_imagepro)){?><div class="text-danger"><?php echo $error_images_imagepro; ?></div><?php }?></td>
                                    </tr>
                                </thead>
                                <tbody id="image_row_imagepro">
                                    <?php $image_row_imagepro = 0; ?>
                                    <?php foreach ($product_imagepros as $product_imagepro) { ?>
                                    <tr id="image-row-imagepro<?php echo $image_row_imagepro; ?>">
                                        <td class="text-left">
                                            <a href="" id="thumb-image-imagepro<?php echo $image_row_imagepro; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($product_imagepro['preview_1'])) echo 'view/image/image.png'; else echo $product_imagepro['preview_1']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="product_imagepro[<?php echo $image_row_imagepro; ?>][image]" value="<?php echo $product_imagepro['image_1']; ?>" id="input-image-imagepro<?php echo $image_row_imagepro; ?>" />
                                        </td>
                                        <td class="text-left" >
                                            <a href="" id="thumb-image-imagepro-1<?php echo $image_row_imagepro; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($product_imagepro['preview_2'])) echo 'view/image/image.png'; else echo $product_imagepro['preview_2']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="product_imagepro[<?php echo $image_row_imagepro; ?>][image1]" value="<?php echo $product_imagepro['image_2']; ?>" id="input-image-imagepro-1<?php echo $image_row_imagepro; ?>" />
                                        </td>
                                        
                                        <td class="text-left" style="width:70%;min-width:150px; display:none">
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;" name="product_imagepro[<?php echo $image_row_imagepro; ?>][image_name]" class="form-control"><?php echo isset($product_imagepro['image_name']) ? $product_imagepro['image_name'] : ''; ?></textarea>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="product_imagepro[<?php echo $image_row_imagepro; ?>][image_name_en]" class="form-control"><?php echo isset($product_imagepro['image_name_en']) ? $product_imagepro['image_name_en'] : ''; ?></textarea>
                                            </div>
                                        </td>
                
                                        <td class="text-left"><input style="width:40px" type="text" name="product_imagepro[<?php echo $image_row_imagepro; ?>][image_sort_order]" value="<?php echo $product_imagepro['image_sort_order']; ?>" class="form-control"/></td>
                                        <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row-imagepro<?php echo $image_row_imagepro ?>').remove(); $('.tooltip').remove();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                                    </tr>
                                    <?php $image_row_imagepro++; ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="display:none"></td>
                                        <td></td>
                                        <td class="text-left"><button type="button" onclick="addImagepro();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
        <div class="tab-pane" id="tab-image">
            <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images; ?>"><?php echo $column_images;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images;?></p></td>
                            <td class="text-left required " style="display:none"><span data-toggle="tooltip" title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1;?></p></td>
                            <td class="text-left required" style="display:none"><?php echo $column_images_name; ?></td>
                            <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                            <td><?php if(isset($error_images)){?><div class="text-danger"><?php echo $error_images; ?></div><?php }?></td>
                        </tr>
                    </thead>
                    <tbody id="image_row">
                        <?php $image_row = 0; ?>
                        <?php foreach ($product_images as $product_image) { ?>
                        <tr id="image-row<?php echo $image_row; ?>">
                            <td class="text-left">
                                <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($product_image['preview_1'])) echo 'view/image/image.png'; else echo $product_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                                </a>
                                <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            </td>
                            <td class="text-left" style="display:none">
                                <a href="" id="thumb-image-1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($product_image['preview_2'])) echo 'view/image/image.png'; else echo $product_image['preview_2']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                                </a>
                                <input type="hidden" name="product_image[<?php echo $image_row; ?>][image1]" value="<?php echo $product_image['image_2']; ?>" id="input-image-1<?php echo $image_row; ?>" />
                            </td>
                            
                            <td class="text-left" style="width:70%;min-width:150px;display:none">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;" name="product_image[<?php echo $image_row; ?>][image_name]" class="form-control"><?php echo isset($product_image['image_name']) ? $product_image['image_name'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="product_image[<?php echo $image_row; ?>][image_name_en]" class="form-control"><?php echo isset($product_image['image_name_en']) ? $product_image['image_name_en'] : ''; ?></textarea>
                                </div>
                            </td>
    
                            <td class="text-left"><input style="width:40px" type="text" name="product_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $product_image['image_sort_order']; ?>" class="form-control"/></td>
                            <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row<?php echo $image_row ?>').remove(); $('.tooltip').remove();checkMaxBackground();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                        </tr>
                        <?php $image_row++; ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td style="display:none"></td>
                            <td style="display:none"></td>
                            <td></td>
                            <td class="text-left"><button type="button" id="add_button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
                        </tr>
                    </tfoot>
                </table>
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
                    <label class="col-sm-2 control-label" for="product_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" id="product_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="product_description[<?php echo $language['language_id']; ?>][meta_description]" id="product_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="product_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control"  name="product_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="product_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_keyword[<?php echo $language['language_id']; ?>][keyword]" >
                    <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control"  name="product_keyword[<?php echo $language['language_id']; ?>][keyword]" id="product_keyword[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($product_keyword[$language['language_id']]) ? $product_keyword[$language['language_id']]['keyword'] : ''; ?>" />
                    </div>
                </div>

                </div>
                <?php } ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    <span data-toggle="tooltip" title="<?php echo $help_entry_image_og; ?>"><?php echo $entry_image_og; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_og ?></p>
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

              <!--<div class="form-group">
                <label class="col-sm-2 control-label" for="keyword">
                  <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                  <p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                </label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="form-control" />
                </div>
              </div>-->
            </div>
            <!-- tab-video -->
						<div class="tab-pane" id="tab-video">

							<div class="form-group" >
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_image_video; ?>"><?php echo $entry_image_video; ?></span><br/>
                                    <p class="s-mobile s-mobile-help"><?php echo $help_image_video ?></p>
                                </label>
                                <div class="col-sm-10">
                                    <a href="" id="thumb-image-video" data-toggle="image" class="img-thumbnail">
                                        <img src="<?php if(empty($preview_video)) echo 'view/image/image.png'; else echo $preview_video; ?>" alt="" title="" data-placeholder="<?php echo $image_video; ?>" />
                                    </a>
                                    <input type="hidden" name="image_video" value="<?php echo $image_video; ?>" id="input-image-video" />
                                    <br />
                                    <input type="checkbox" name="delete_image_video" value="1" /> <?php echo $entry_delete_image;?>
                                </div>
                            </div>
                            
                            <div class="form-group">
								<label class="col-sm-2 control-label" for="isyoutube"><?php echo $entry_upload_youtube;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($isyoutube == "1") {?>
											<input id="isyoutube" value="1" type="checkbox" name="isyoutube" checked="checked"/>
											<?php } else {?>
											<input id="isyoutube" value="1" type="checkbox" name="isyoutube"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group display_youtube">
								<label class="col-sm-2 control-label" for="script"><span data-toggle="tooltip" title="<?php echo $help_script;?>"><?php echo $entry_script;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_script ?></p>
								</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="script" id="script"><?php echo $script; ?></textarea>
								</div>
							</div>

							<div class="form-group display_file">
								<label class="col-sm-2 control-label" for="isftp"><?php echo $entry_upload_ftp;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($isftp == "1") {?>
											<input id="isftp" value="1" type="checkbox" name="isftp" checked="checked"/>
											<?php } else {?>
											<input id="isftp" value="1" type="checkbox" name="isftp"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group required display_upload display_file">
								<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_file_mp4;?>"><?php echo $entry_file_mp4;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_mp4 ?></p>
								</label>
								<div class="col-sm-10">
									<input type="file" name="video_mp4" value="" />
									<input type="hidden" name="video_mp4_old" value="<?php echo $filename_mp4;?>" />
									<br/>
									<span class="help"><?php echo $filename_mp4; ?></span>
									<?php if ($error_video_mp4 && !empty($error_video_mp4)) { ?>
									<div class="text-danger"><?php echo $error_video_mp4; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group required" style="display:none">
								<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_file_webm;?>"><?php echo $entry_file_webm;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_webm ?></p>
								</label>
								<div class="col-sm-10">
									<input type="file" name="video_webm" value="" />
									<input type="hidden" name="video_webm_old" value="<?php echo $filename_webm;?>" />
									<br/>
									<span class="help"><?php echo $filename_webm; ?></span>
									<?php if ($error_video_webm && !empty($error_video_webm)) { ?>
									<div class="text-danger"><?php echo $error_video_webm; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group display_ftp" style="display:none">
								<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_file_mp4_ftp;?>"><?php echo $entry_file_mp4_ftp;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_mp4_ftp ?></p>
								</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" name="file_mp4_ftp" value="<?php echo $file_mp4_ftp;?>" />
									<?php if ($error_file_mp4_ftp && !empty($error_file_mp4_ftp)) { ?>
									<div class="text-danger"><?php echo $error_file_mp4_ftp; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group" style="display:none">
								<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_file_webm_ftp;?>"><?php echo $entry_file_webm_ftp;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_webm_ftp ?></p>
								</label>
								<div class="col-sm-10">
									<input class="form-control" type="text" name="file_webm_ftp" value="<?php echo $file_webm_ftp;?>" />
									<?php if ($error_file_webm_ftp && !empty($error_file_webm_ftp)) { ?>
									<div class="text-danger"><?php echo $error_file_webm_ftp; ?></div>
									<?php } ?>
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
			/*$("#input-description<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false
			});*/
			$("#input-description<?php echo $language['language_id']; ?>").summernote('code', {stripTags: true});
			
			$("#input-desc-short<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false, 'height': '150px',toolbar: [['view', ['codeview']],['font', ['bold', 'italic', 'underline','superscript', 'subscript', 'clear']],['history', ['undo', 'redo']],['insert', ['link']],['style', ['style']],]
			});
			$('#input-desc-short' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');
			
			/*$("#input-descriptionbanve<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false
			});*/
			$("#input-descriptionbanve<?php echo $language['language_id']; ?>").summernote('code', {stripTags: true});
			
			/*$("#input-descriptionimgpro<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false
			});*/
			$("#input-descriptionimgpro<?php echo $language['language_id']; ?>").summernote('code', {stripTags: true});
			
			/*$("#input-descriptionphukien<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false
			});*/
			$("#input-descriptionphukien<?php echo $language['language_id']; ?>").summernote('code', {stripTags: true});
			
			/*$("#input-descriptionproject<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}, styleWithSpan: false
			});*/
			$("#input-descriptionproject<?php echo $language['language_id']; ?>").summernote('code', {stripTags: true});
			
			<?php } ?>
		//
	</script>
	<script> 
$(document).ready(function() {
		if($("#isftp:checked").val()=='1')
		{
			if($("#isyoutube:checked").val()=='1'){
				$(".display_ftp").hide();
				$(".display_upload").hide();
			}else{
				$(".display_ftp").show();
				$(".display_upload").hide();
			}
		}else
		{
			$(".display_ftp").hide();
			$(".display_upload").show();
		}
		
		$("#isftp").click(function(){
			if($("#isftp:checked").val()=='1')
			{
				$(".display_ftp").show();
				$(".display_upload").hide();
			}else
			{
				$(".display_ftp").hide();
				$(".display_upload").show();
			}
		});
		
		if($("#isyoutube:checked").val()=='1')
		{
			$(".display_youtube").show();
			$(".display_file").hide();
		}else
		{
			$(".display_youtube").hide();
			$(".display_file").show();
			
			if($("#isftp:checked").val()=='1')
			{
				$(".display_ftp").show();
				$(".display_upload").hide();
			}else
			{
				$(".display_ftp").hide();
				$(".display_upload").show();
			}
		}
		
		$("#isyoutube").click(function(){
			if($("#isyoutube:checked").val()=='1')
			{
				$(".display_youtube").show();
				$(".display_file").hide();
				
				$(".display_ftp").hide();
				$(".display_upload").hide();
			}else
			{
				$(".display_youtube").hide();
				$(".display_file").show();
				
				if($("#isftp:checked").val()=='1')
				{
					$(".display_ftp").show();
					$(".display_upload").hide();
				}else
				{
					$(".display_ftp").hide();
					$(".display_upload").show();
				}
			}
		});
});
</script> 

<!--{VIEW_SCRIPT}-->
	
<script>
$(document).ready(function() {	
	if($("#ishome:checked").val()=='1')
	{
		$(".display").show();
	}else
	{
		$(".display").hide();
	}
	$("#ishome").click(function(){
		if($("#ishome:checked").val()=='1')
		{
			$(".display").show();
		}else
		{
			$(".display").hide();
		}
	});
});
</script>

<script>
function checkMaxBackground(){
	var row = $('#images tbody tr').length;
	//var category_id = "<?php echo $category_id;?>";
	
	/*if(category_id==1){
		if(row>9)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}else*/{
		if(row>10)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}
}

$(document).ready(function() {	
	checkMaxBackground();
	
});
</script>

<script type="text/javascript">
	/*Khong thay doi ten bien image_row*/
	var image_row = <?php echo $image_row; ?>;

	function addImage() {
		html  = '<tr id="image-row' + image_row + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo "view/image/image.png"; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" /><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
		
		html += '  <td class="text-left" style="display:none"><a href="" id="thumb-image-1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo "view/image/image.png"; else echo $preview_2; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" /><input type="hidden" name="product_image[' + image_row + '][image1]" value="" id="input-image-1' + image_row + '" /></td>';

		html += '<td class="text-center" style="width:70%;min-width:150px;display:none"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="product_image[' + image_row + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="product_image[' + image_row + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="product_image[' + image_row + '][image_sort_order]" value="' + image_row  + '" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row' + image_row  + '\').remove(); $(\'.tooltip\').remove();checkMaxBackground();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#images tbody').append(html);

		image_row++;
		checkMaxBackground();
	}
</script>

<script type="text/javascript">
	/*Khong thay doi ten bien image_row*/
	var image_row_imagepro = <?php echo $image_row_imagepro; ?>;

	function addImagepro() {
		html  = '<tr id="image-row-imagepro' + image_row_imagepro + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image-imagepro' + image_row_imagepro + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_imagepro_1)) echo "view/image/image.png"; else echo $preview_imagepro_1; ?>" alt="" title="" /><input type="hidden" name="product_imagepro[' + image_row_imagepro + '][image]" value="" id="input-image-imagepro' + image_row_imagepro + '" /></td>';
		
		html += '  <td class="text-left" ><a href="" id="thumb-image-imagepro-1' + image_row_imagepro + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_imagepro_2)) echo "view/image/image.png"; else echo $preview_imagepro_2; ?>" alt="" title="" /><input type="hidden" name="product_imagepro[' + image_row_imagepro + '][image1]" value="" id="input-image-imagepro-1' + image_row_imagepro + '" /></td>';

		html += '<td class="text-center" style="width:70%;min-width:150px; display:none;"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="product_imagepro[' + image_row_imagepro + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="product_imagepro[' + image_row_imagepro + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="product_imagepro[' + image_row_imagepro + '][image_sort_order]" value="' + image_row_imagepro + '" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row-imagepro' + image_row_imagepro  + '\').remove(); $(\'.tooltip\').remove();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#imagepros tbody').append(html);

		image_row_imagepro++;
	}
</script>

<style>
.nav-tabs > li > a{padding:10px 15px;}
</style>

<script type="text/javascript"><!--
// Category
$('input[name=\'tenduan\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/project/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['project_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'tenduan\']').val('');
		
		$('#project-category' + item['value']).remove();
		
		$('#project-category').append('<div class="project-category-id" id="project-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="project_category[]" value="' + item['value'] + '" /></div>');	
	}
});

$('#project-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

//--></script>


<script type="text/javascript"><!--
// Category
$('input[name=\'tensanpham\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request) + '&array_phukien=' +  encodeURIComponent($('#array_phukien').val()),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'tensanpham\']').val('');
		
		$('#product-category' + item['value']).remove();
		
		$('#product-category').append('<div class="product-category-id" id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');	
	}
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

//--></script>


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
		$('#languagethongso a:first').tab('show');
		$('#languageimgpro a:first').tab('show');
		$('#languagebanve a:first').tab('show');
		$('#languagephukien a:first').tab('show');
		$('#languageproject a:first').tab('show');
		$('#language-seo a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>