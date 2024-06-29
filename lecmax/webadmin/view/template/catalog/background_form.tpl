<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"> <?php echo $button_save; ?></lbl></button>
				<a style="display:none" href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <lbl class="s-mobile"> <?php echo $button_cancel; ?></lbl></a>
			</div>
			<h3><?php echo $heading_title; ?></h3>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
					<ul class="nav nav-tabs">
                    	<li  class="active"><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
						<li style="display:none"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li style="display:none"><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo;?></a></li>
					</ul>
					<div class="tab-content">
						<!-- tab_general -->
						<div class="tab-pane" id="tab-general">
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
											<input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group">
										<label class="col-sm-2 control-label" for="input-name1<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="category_description[<?php echo $language['language_id']; ?>][name1]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name1'] : ''; ?>"  id="input-name1<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name1[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name1[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group  display" <?php if($category_id!=269 && $category_id!=329) echo 'style="display:none"';?>  >
										<label class="col-sm-2 control-label" for="input-name-2<?php echo $language['language_id']; ?>"><?php echo $entry_name2_cateproduct; ?></label>
										<div class="col-sm-10">
											<textarea name="category_description[<?php echo $language['language_id']; ?>][name2]"   id="input-name-2<?php echo $language['language_id']; ?>" class="form-control" ><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name2'] : ''; ?></textarea>
											
										</div>
									</div>

									<div class="form-group option_type option_page"  style="display:none" >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="category_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>

								</div>
								<?php } ?>
								<div class="form-group" <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label class="col-sm-2 control-label" id="parent_id"><?php echo $entry_parent ?></label>
									<div class="col-sm-10">
										<select name="parent_id" id="parent_id" class="form-control">
											<option value="<?php if(isset($parent_default)){echo (int)$parent_default;}else {echo "0";}?>"><?php echo $text_none; ?></option>
											<?php foreach ($categories as $category) { ?>
											<?php if ($category['category_id'] == $parent_id) { ?>
											<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<?php if (isset($error_parent_id) && !empty($error_parent_id)) { ?>
										<div class="text-danger"><?php echo $error_parent_id; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group required" <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label class="col-sm-2 control-label" for="type_id"><?php echo $entry_type; ?></label>
									<div class="col-sm-10">
										<select id="type_id" name="type_id" class="form-control">
											<option value=""></option>
											<option <?php if($type_id=='category') echo 'selected="selected"';?> value="category"><?php echo $option_category;?></option>
											<option <?php if($type_id=='page') echo 'selected="selected"';?> value="page"><?php echo $option_page;?></option>
											<option <?php if($type_id=='module') echo 'selected="selected"';?> value="module"><?php echo $option_module;?></option>
										</select>
										<?php if (isset($error_type_id) && !empty($error_type_id)) { ?>
										<div class="text-danger"><?php echo $error_type_id; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group required <?php if($superadmin) echo 'option_type option_page';?>" style="display:none">
									<label class="col-sm-2 control-label" for="template"><?php echo $entry_template ?></label>
									<div class="col-sm-10">
										<select id="template" name="template" class="form-control">
											<option value=""></option>
											<?php foreach($templates as $item){?>
											<option <?php if($item['option_image']==1) echo 'option_image="'.$item['help_image'].'"';?> <?php if($item['option_images']==1) echo 'option_images="'.$item['help_image_1'].';'.$item['help_image_2'].'"';?> <?php if($item['option_download']==1) echo 'option_download="'.$item['module_download'].'"';?> <?php if($item['option_video']==1) echo 'option_video="'.$item['module_video'].'"';?> <?php if($template==$item['templates_id']) echo 'selected="selected"';?> value="<?php echo $item['templates_id'];?>"><?php echo $item['name'];?></option>
											<?php }?>
										</select>

										<?php if (isset($error_template) && !empty($error_template)) { ?>
										<div class="text-danger"><?php echo $error_template; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group <?php if($superadmin) echo 'option_type option_module';?>" style="display:none">
									<label class="col-sm-2 control-label" for="path"><?php echo $entry_path; ?></label>
									<div class="col-sm-10">
										<select name="path" id="path" class="form-control">
											<option value=""></option>
											<?php foreach($modules as $item){?>
											<option <?php if($path==$item['path']) echo 'selected="selected"';?> value="<?php echo $item['path'];?>"><?php echo $item['name'];?></option>
											<?php }?>
										</select>
										<?php if (isset($error_path) && !empty($error_path)) { ?>
										<div class="text-danger"><?php echo $error_path; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group option_type" id="template_image" style="display:none" >
									<label class="col-sm-2 control-label">
										<span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
									</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
											<img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
										</a>
										<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
										<?php if (isset($error_image)) { ?>
										<div class="text-danger"><?php echo $error_image; ?></div>
										<?php } ?>
									</div>
								</div>
                                
                                <div class="form-group " <?php if($category_id!=269 && $category_id!=329) echo 'style="display:none"';?> >
									<label class="col-sm-2 control-label" for="ishome"><?php echo $entry_ishome; ?></label>
									<div class="col-sm-10">
										<div class="checkbox">
											<label>
												<input class="form-control" type="checkbox" name="ishome" id="ishome" value="1" <?php if($ishome) echo 'checked="checked"';?> />
											</label>
										</div>
									</div>
								</div>
                                
                                <div class="form-group display" style="display:none">
									<label class="col-sm-2 control-label" for="input-iconsvg"><?php echo $entry_iconsvg; ?></label>
									<div class="col-sm-10">
										<textarea name="iconsvg" rows="5" id="input-iconsvg" class="form-control" ><?php echo $iconsvg; ?></textarea>
									</div>
								</div>

								<div class="form-group option_type" id="template_video" style="display:none">
									<label class="col-sm-2 control-label" for="video"><?php echo $entry_video; ?></label>
									<div class="col-sm-10">
										<select id="video" name="video" class="form-control">
											<!--<option value=""></option>
											<?php foreach($modules as $item){?>
											<option value="<?php echo $item['path'];?>"><?php echo $item['name'];?></option>
											<?php }?>-->
										</select>
									</div>
								</div>

								<div class="form-group" <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label class="col-sm-2 control-label" for="mainmenu"><?php echo $entry_mainmenu; ?></label>
									<div class="col-sm-10">
										<div class="checkbox">
											<label>
												<input class="form-control" type="checkbox" name="mainmenu" id="mainmenu" value="1" <?php if($mainmenu) echo 'checked="checked"';?> />
											</label>
										</div>
									</div>
								</div>

								<div class="form-group"  <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label class="col-sm-2 control-label" for="class"><?php echo $entry_class; ?></label>
									<div class="col-sm-10">
										<input class="form-control" type="text" name="class" id="class" value="<?php echo $class; ?>" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sort_order" value="<?php echo $sort_order; ?>"  id="input-sort-order" class="form-control" />
									</div>
								</div>

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
							</div>
						</div>

						<!-- tab-image -->
						<div class="tab-pane active" id="tab-image">
                        	<div class="tab-content">
                            	
                                <div class="form-group required" <?php if($category_id!=1 && $category_id!=2) echo 'style="display:none"';?> >
									<label class="col-sm-2 control-label">
										<span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
									</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image-1" data-toggle="image" class="img-thumbnail">
											<img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
										</a>
										<input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-1" />
										<?php if (isset($error_image1) && !empty($error_image1)) { ?>
										<div class="text-danger"><?php echo $error_image1; ?></div>
										<?php } ?>
									</div>
								</div>
                                
                                <!-- time -->
                                <div class="form-group required" <?php if($category_id==1) echo ' style="display:none"';?> >
                                    <label class="col-sm-2 control-label" for="config_loop_picture">
                                    <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_picture; ?></span><br/>
                                    <p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                                    </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="config_loop_picture" type="text" name="config_loop_picture" value="<?php echo $config_loop_picture ?>" />
                                        <?php if (isset($error_loop_picture) && !empty($error_loop_picture)) { ?>
                                        <div class="text-danger"><?php echo $error_loop_picture; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                    
							<div class="table-responsive">
								<table id="images" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left required">
                                            	<span data-toggle="tooltip" title="<?php echo $help_column_images; ?>"><?php echo $column_images;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images;?></p>
											</td>
                                            <td class="text-left required"  style="display:none" ><!--<?php if($category_id!=96 && $category_id!=97) echo 'style="display:none"';?>-->
                                            	<span data-toggle="tooltip" title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1;?></p>
											</td>
                                            <td class="text-left required" style="display:none" <?php if($category_id!=95) echo 'style="display:none"';?> ><!--<?php if($category_id!=95) echo 'style="display:none"';?>--><?php echo $column_images_name; ?></td>
											<td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $image_row = 0; ?>
										<?php foreach ($category_images as $category_image) { ?>
										<tr id="image-row<?php echo $image_row; ?>">
                                        
                                        	<td class="text-left">
                                                <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php if(empty($category_image['preview_1'])) echo 'view/image/image.png'; else echo $category_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                                                </a>
                                                <input type="hidden" name="category_image[<?php echo $image_row; ?>][image]" value="<?php echo $category_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
                                            </td>
                                            
                                            <td class="text-left"  style="display:none" >
                                                <a href="" id="thumb-image-1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php if(empty($category_image['preview_2'])) echo 'view/image/image.png'; else echo $category_image['preview_2']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                                                </a>
                                                <input type="hidden" name="category_image[<?php echo $image_row; ?>][image1]" value="<?php echo $category_image['image_2']; ?>" id="input-image-1<?php echo $image_row; ?>" />
                                            </td>
                                            
                                            <td class="text-left" style="width:20%;min-width:250px; display:none; <?php if($category_id!=95) echo 'display:none';?>">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                                    <textarea cols="30" rows="3" style="height:70px;resize:none;" name="category_image[<?php echo $image_row; ?>][image_name]" class="form-control"><?php echo isset($category_image['image_name']) ? $category_image['image_name'] : ''; ?></textarea>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                                    <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="category_image[<?php echo $image_row; ?>][image_name_en]" class="form-control"><?php echo isset($category_image['image_name_en']) ? $category_image['image_name_en'] : ''; ?></textarea>
                                                </div>
                                            </td>
                                            
                                            <td class="text-left"><input style="width:40px" type="text" name="category_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $category_image['image_sort_order']; ?>" class="form-control"/></td>
                                            
											<td class="text-left" ><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();checkMaxBackground();" data-toggle="tooltip" title="<?php //echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										</tr>
										<?php $image_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr >
											<td ></td>
                                            <td  style="display:none" ></td>
                                            <td ></td>
                                            <td style="display:none"  <?php if($category_id!=95) echo 'style="display:none"';?> ></td>
											<td class="text-left"><button type="button" id="add_button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>

						<!-- tab-seo -->
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
										<label class="col-sm-2 control-label" for="category_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
										<div class="col-sm-10">
											<input class="form-control" id="category_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" for="category_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
										<div class="col-sm-10">
											<textarea class="form-control" name="category_description[<?php echo $language['language_id']; ?>][meta_description]" id="category_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" for="category_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
										<div class="col-sm-10">
											<textarea class="form-control" name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" for="category_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
										<div class="col-sm-10">
											<input class="form-control" type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="category_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" for="category_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
										<div class="col-sm-10">
											<textarea class="form-control"  name="category_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="category_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    <div class="form-group">
										<label class="col-sm-2 control-label" for="category_keyword[<?php echo $language['language_id']; ?>][keyword]" >
                                        <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                                        </label>
										<div class="col-sm-10">
											<input class="form-control"  name="category_keyword[<?php echo $language['language_id']; ?>][keyword]" id="category_keyword[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($category_keyword[$language['language_id']]) ? $category_keyword[$language['language_id']]['keyword'] : ''; ?>" />
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

					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		<?php foreach ($languages as $language) { ?>
			$('#input-description<?php echo $language['language_id']; ?>').summernote({
				onpaste: function(e) {
					var thisNote = $(this);
					var updatePastedText = function(someNote){
						var original = someNote.code();
						var cleaned = CleanPastedHTML(original);
						someNote.code('').html(cleaned);
					};
					setTimeout(function () {
						updatePastedText(thisNote);
					}, 10);
				}
			});
			<?php } ?>
		//
	</script>
	<script type="text/javascript">
	
function checkMaxBackground(){
	var row = $('#images tbody tr').length;
	var category_id = "<?php echo $category_id;?>";
	
	if(category_id==1){
		if(row>9)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}else{
		if(row>10)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}
}
		var image_row = <?php echo $image_row; ?>;
		var parent_id = "<?php echo $parent_id; ?>";
		var category_id = "<?php echo $category_id;?>";
		var display = '';
		
		if(category_id!=295) {
			display = "display:none";
		}

		function addImage() {
			html  = '<tr id="image-row' + image_row + '">';
			html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo 'view/image/image.png'; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" /><input type="hidden" name="category_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
			html += '  <td class="text-left" style="display:none' + '" ><a href="" id="thumb-image-1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo 'view/image/image.png'; else echo $preview_2; ?>" alt="" title=""  /><input type="hidden" name="category_image[' + image_row + '][image1]" value="" id="input-image-1' + image_row + '" /></td>';
			
			html += '<td class="text-center" style="width:20%;min-width:250px;display:none; <?php if($category_id!=95) echo "display:none";?>"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="category_image[' + image_row + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';
			html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="category_image[' + image_row + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';
			
			html += '  <td class="text-right"><input type="text" name="category_image[' + image_row + '][image_sort_order]" value=""   class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();checkMaxBackground();" data-toggle="tooltip" title="<?php //echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#images tbody').append(html);

			image_row++;
			checkMaxBackground();
		}
	</script>
	<script>
		var display_image2 = false;

		function changeType(id){
			var val = $(id).val();

			//$('#template').val('');
			$('.option_type').hide();
			$('.option_' + val).show();
		}

		function changeTemplate(id){

			var element =  $('option:selected', id);

			var helpimage = element.attr('option_image');
			if(helpimage){
				$('#help_image').html(helpimage);
				$('#template_image').show();
			}else{
				$('#template_image').hide();
			}
			var helpimages = element.attr('option_images');


			if(helpimages){
				helpimages = helpimages.split(';');
				$('#help_image_1').html(helpimages[0]);
				if(helpimages[1]){
					$('.images_2').show();
					$('#help_image_2').html(helpimages[1]);
					display_image2 = true;
				}else{
					$('.images_2').hide();
					display_image2 = false;
				}

				$('#template_images').show();
			}else{
				$('#template_images').hide();
			}

			var module_download = element.attr('option_download');
			if(module_download){
				$.ajax({
					url: 'index.php?route=catalog/menu/getdownloadorvideo&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'module=' + module_download,
					dataType: 'json',
					success: function(data) {
						if(data.length>0){
							$('#download').empty();
							$('#download').append('<option value="" ></option>');
							for(i=0; i<data.length;i++){
								if('<?php echo $download;?>'==data[i]['id']){
									$('#download').append('<option selected="selected" value="'+data[i]['id']+'" >'+data[i]['name']+'</option>');
								}else{
									$('#download').append('<option value="'+data[i]['id']+'" >'+data[i]['name']+'</option>');
								}
							}
						}
					}
				});
				$('#template_download').show();
			}else{
				$('#template_download').hide();
			}
			var module_video = element.attr('option_video');
			if(module_video){
				$.ajax({
					url: 'index.php?route=catalog/menu/getdownloadorvideo&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'module=' + module_video,
					dataType: 'json',
					success: function(data) {
						if(data.length>0){
							$('#video').empty();
							$('#video').append('<option value="" ></option>');
							for(i=0; i<data.length;i++){
								if('<?php echo $video;?>'==data[i]['id']){
									$('#video').append('<option selected="selected" value="'+data[i]['id']+'" >'+data[i]['name']+'</option>');
								}else{
									$('#video').append('<option value="'+data[i]['id']+'" >'+data[i]['name']+'</option>');
								}
							}
						}
					}
				});

				$('#template_video').show();
			}else{
				$('#template_video').hide();
			}
		}

		$(document).ready(function() {
			checkMaxBackground();
			changeType('#type_id');
			changeTemplate('#template');

			$('#type_id').change(function(){
				changeType(this);
			});

			$('#template').change(function(){
				changeTemplate(this);
			});

		});
	</script>
    
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
		$('#language-seo a').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>