<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-project" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-project" class="form-horizontal">
					<input type="hidden" name="cate" value="<?php echo $cate;?>" />
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                        <li <?php if(!$cate) echo 'style="display:none"';?> ><a href="#tab-imagepros" data-toggle="tab"><?php echo $tab_imagepros; ?></a></li>
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

									<div class="form-group required">
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="project_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" <?php if($cate) echo 'style="display:none"';?> >
										<label class="col-sm-2 control-label" for="input-name1<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="project_description[<?php echo $language['language_id']; ?>][name1]" value="<?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['name1'] : ''; ?>"  id="input-name1<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>"><?php echo $entry_address; ?></label>
										<div class="col-sm-10">
											<input type="text" name="project_description[<?php echo $language['language_id']; ?>][address]" value="<?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['address'] : ''; ?>"  id="input-address<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

									<div class="form-group" <?php if(!$cate) echo 'style="display:none"';?> >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="project_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
								<div class="form-group required" <?php if(!$cate) echo 'style="display:none"';?> >
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
            <div class="form-group required" <?php if(!$cate) echo 'style="display:none"';?> >
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
              </div>
            </div>
            <div class="form-group display_home" <?php if(!$cate) echo 'style="display:none"';?> >
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
						
        <div class="tab-pane" id="tab-image">
            <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images; ?>"><?php echo $column_images;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images;?></p></td>
                            <td class="text-left required " style="display:none"><span data-toggle="tooltip" title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1;?></p></td>
                            <td class="text-left required" style="display:none" ><?php echo $column_images_name; ?></td>
                            <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                            <td><?php if(isset($error_images)){?><div class="text-danger"><?php echo $error_images; ?></div><?php }?></td>
                        </tr>
                    </thead>
                    <tbody id="image_row">
                        <?php $image_row = 0; ?>
                        <?php foreach ($project_images as $project_image) { ?>
                        <tr id="image-row<?php echo $image_row; ?>">
                            <td class="text-left">
                                <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($project_image['preview_1'])) echo 'view/image/image.png'; else echo $project_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                                </a>
                                <input type="hidden" name="project_image[<?php echo $image_row; ?>][image]" value="<?php echo $project_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            </td>
                            <td class="text-left" style="display:none">
                                <a href="" id="thumb-image-1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($project_image['preview_2'])) echo 'view/image/image.png'; else echo $project_image['preview_2']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                                </a>
                                <input type="hidden" name="project_image[<?php echo $image_row; ?>][image1]" value="<?php echo $project_image['image_2']; ?>" id="input-image-1<?php echo $image_row; ?>" />
                            </td>
                            
                            <td class="text-left" style="width:70%;min-width:150px;display:none">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;" name="project_image[<?php echo $image_row; ?>][image_name]" class="form-control"><?php echo isset($project_image['image_name']) ? $project_image['image_name'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="project_image[<?php echo $image_row; ?>][image_name_en]" class="form-control"><?php echo isset($project_image['image_name_en']) ? $project_image['image_name_en'] : ''; ?></textarea>
                                </div>
                            </td>
    
                            <td class="text-left"><input style="width:40px" type="text" name="project_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $project_image['image_sort_order']; ?>" class="form-control"/></td>
                            <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row<?php echo $image_row ?>').remove(); $('.tooltip').remove();checkMaxBackground();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                        </tr>
                        <?php $image_row++; ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td style="display:none"></td>
                            <td style="display:none" ></td>
                            <td></td>
                            <td class="text-left"><button type="button" id="add_button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="tab-pane" id="tab-imagepros">
                        <div class="table-responsive">
                            <table id="imagepros" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images_imagepro; ?>"><?php echo $column_images_imagepro;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images_imagepro;?></p></td>
                                        <td class="text-left required " style="display:none"><span data-toggle="tooltip" title="<?php echo $help_column_images1_imagepro; ?>"><?php echo $column_images1_imagepro;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1_imagepro;?></p></td>
                                        <td class="text-left required" ><?php echo $column_images_imagepro_name; ?></td>
                                        <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                                        <td><?php if(isset($error_images_imagepro)){?><div class="text-danger"><?php echo $error_images_imagepro; ?></div><?php }?></td>
                                    </tr>
                                </thead>
                                <tbody id="image_row_imagepro">
                                    <?php $image_row_imagepro = 0; ?>
                                    <?php foreach ($project_imagepros as $project_imagepro) { ?>
                                    <tr id="image-row-imagepro<?php echo $image_row_imagepro; ?>">
                                        <td class="text-left">
                                            <a href="" id="thumb-image-imagepro<?php echo $image_row_imagepro; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($project_imagepro['preview_1'])) echo 'view/image/image.png'; else echo $project_imagepro['preview_1']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="project_imagepro[<?php echo $image_row_imagepro; ?>][image]" value="<?php echo $project_imagepro['image_1']; ?>" id="input-image-imagepro<?php echo $image_row_imagepro; ?>" />
                                        </td>
                                        <td class="text-left"  style="display:none">
                                            <a href="" id="thumb-image-imagepro-1<?php echo $image_row_imagepro; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($project_imagepro['preview_2'])) echo 'view/image/image.png'; else echo $project_imagepro['preview_2']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="project_imagepro[<?php echo $image_row_imagepro; ?>][image1]" value="<?php echo $project_imagepro['image_2']; ?>" id="input-image-imagepro-1<?php echo $image_row_imagepro; ?>" />
                                        </td>
                                        
                                        <td class="text-left" style="width:70%;min-width:150px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;" name="project_imagepro[<?php echo $image_row_imagepro; ?>][image_name]" class="form-control"><?php echo isset($project_imagepro['image_name']) ? $project_imagepro['image_name'] : ''; ?></textarea>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="project_imagepro[<?php echo $image_row_imagepro; ?>][image_name_en]" class="form-control"><?php echo isset($project_imagepro['image_name_en']) ? $project_imagepro['image_name_en'] : ''; ?></textarea>
                                            </div>
                                        </td>
                
                                        <td class="text-left"><input style="width:40px" type="text" name="project_imagepro[<?php echo $image_row_imagepro; ?>][image_sort_order]" value="<?php echo $project_imagepro['image_sort_order']; ?>" class="form-control"/></td>
                                        <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row-imagepro<?php echo $image_row_imagepro ?>').remove(); $('.tooltip').remove();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                                    </tr>
                                    <?php $image_row_imagepro++; ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td  style="display:none"></td>
                                        <td ></td>
                                        <td></td>
                                        <td class="text-left"><button type="button" onclick="addImagepro();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
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
                    <label class="col-sm-2 control-label" for="project_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" id="project_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="project_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['meta_title'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="project_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="project_description[<?php echo $language['language_id']; ?>][meta_description]" id="project_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="project_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="project_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="project_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="project_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="project_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="project_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="project_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control"  name="project_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="project_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($project_description[$language['language_id']]) ? $project_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="project_keyword[<?php echo $language['language_id']; ?>][keyword]" >
                    <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control"  name="project_keyword[<?php echo $language['language_id']; ?>][keyword]" id="project_keyword[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($project_keyword[$language['language_id']]) ? $project_keyword[$language['language_id']]['keyword'] : ''; ?>" />
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
				}, styleWithSpan: false
			});
			<?php } ?>
		//
	</script>
	<!--{VIEW_SCRIPT}-->
	
<script>
/*$(document).ready(function() {	
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
});*/
</script>

<script>
$(document).ready(function() {	
	checkMaxBackground();
});
</script>


<script type="text/javascript">

function checkMaxBackground(){
	var row = $('#images tbody tr').length;
	var cate = <?php echo $cate; ?>;
	//if(cate){
		/*if(row>4)
			$('#add_button').hide();
		else
			$('#add_button').show();*/
	//}else
	{
		if(row>4)
			$('#add_button').hide();
		else
			$('#add_button').show();

	}
	
}

	/*Khong thay doi ten bien image_row*/
	var image_row = <?php echo $image_row; ?>;
	
	var cate = <?php echo $cate; ?>;
	var display_name = '';
	//if(!cate) 
	display_name = 'display:none';

	function addImage() {
		html  = '<tr id="image-row' + image_row + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo "view/image/image.png"; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" /><input type="hidden" name="project_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
		
		html += '  <td class="text-left" style="display:none"><a href="" id="thumb-image-1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo "view/image/image.png"; else echo $preview_2; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" /><input type="hidden" name="project_image[' + image_row + '][image1]" value="" id="input-image-1' + image_row + '" /></td>';

		html += '<td class="text-center" style="width:70%;min-width:150px;' + display_name + '"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="project_image[' + image_row + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="project_image[' + image_row + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="project_image[' + image_row + '][image_sort_order]" value="' + image_row + '" class="form-control" /></td>';
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
		html += '  <td class="text-left"><a href="" id="thumb-image-imagepro' + image_row_imagepro + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_imagepro_1)) echo "view/image/image.png"; else echo $preview_imagepro_1; ?>" alt="" title="" /><input type="hidden" name="project_imagepro[' + image_row_imagepro + '][image]" value="" id="input-image-imagepro' + image_row_imagepro + '" /></td>';
		
		html += '  <td class="text-left" style="display:none"><a href="" id="thumb-image-imagepro-1' + image_row_imagepro + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_imagepro_2)) echo "view/image/image.png"; else echo $preview_imagepro_2; ?>" alt="" title="" /><input type="hidden" name="project_imagepro[' + image_row_imagepro + '][image1]" value="" id="input-image-imagepro-1' + image_row_imagepro + '" /></td>';

		html += '<td class="text-center" style="width:70%;min-width:150px; "><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="project_imagepro[' + image_row_imagepro + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="project_imagepro[' + image_row_imagepro + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="project_imagepro[' + image_row_imagepro + '][image_sort_order]" value="' + image_row_imagepro + '" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row-imagepro' + image_row_imagepro  + '\').remove(); $(\'.tooltip\').remove();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#imagepros tbody').append(html);

		image_row_imagepro++;
	}
</script>
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