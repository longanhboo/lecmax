<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-adminmenu" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <lbl class="s-mobile"><?php echo $button_cancel; ?></lbl></a>
			</div>
			<h3 ><?php echo $heading_title_cateproduct; ?></h3>
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
                <input type="hidden" name="parent_default" value="<?php if(isset($parent_default)){echo (int)$parent_default;}else {echo "0";}?>" class="form-control" />
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li class="subcateproduct_id" style="display:none" <?php if($category_id==160) echo 'style="display:none"';?>  ><a href="#tab-image" data-toggle="tab"><?php echo $tab_image_cateproduct; ?></a></li>
						<li ><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo;?></a></li>
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
											<input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group " style="display:none" >
										<label class="col-sm-2 control-label" for="input-name-1<?php echo $language['language_id']; ?>"><?php echo $entry_name1_cateproduct; ?></label>
										<div class="col-sm-10">
											<input type="text" name="category_description[<?php echo $language['language_id']; ?>][name1]"   id="input-name-1<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name1'] : ''; ?>" >
											<?php if (isset($error_name1[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name1[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group display " style="display:none"  >
										<label class="col-sm-2 control-label" for="input-name-2<?php echo $language['language_id']; ?>"><?php echo $entry_name2_cateproduct; ?></label>
										<div class="col-sm-10">
											<textarea name="category_description[<?php echo $language['language_id']; ?>][name2]"   id="input-name-2<?php echo $language['language_id']; ?>" class="form-control" ><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name2'] : ''; ?></textarea>
											
										</div>
									</div>

									<div class="form-group " style="display:none" >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="category_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control" rows="5"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    <div class="form-group display_image_pdf" style="display:none">
										<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_download;?>"><?php echo $entry_download;?></span><br/>
											<p class="s-mobile s-mobile-help"><?php echo $help_download;?></p>
										</label>
										<div class="col-sm-10">
											<input type="file" name="category_description[<?php echo $language['language_id']; ?>][pdf]" />
											<?php
											$old_file[$language['language_id']] = isset($category_description[$language['language_id']]['pdf'])?$category_description[$language['language_id']]['pdf']:'';

											if(isset($category_description[$language['language_id']]['old_file'])){

												$old_file[$language['language_id']] = $category_description[$language['language_id']]['old_file'];
											}
											?>
											<span class="help"><?php echo $old_file[$language['language_id']]; ?></span>
											<input type="hidden" value="<?php echo $old_file[$language['language_id']]; ?>" name="category_description[<?php echo $language['language_id']; ?>][old_file]" />
											<br />
											<input type="checkbox" value="1" name="category_description[<?php echo $language['language_id']; ?>][delete_pdf]" /> <?php echo $entry_delete_file;?>

											<?php if (isset($error_pdf[$language['language_id']]) && !empty($error_pdf[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_pdf[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group display_image_pdf" style="display:none">
										<label class="col-sm-2 control-label" for="input-filepdf<?php echo $language['language_id']; ?>">Tên file pdf đã được upload bằng ftp (trong thư mục pdf)</label>
										<div class="col-sm-10">
											<input type="text" name="category_description[<?php echo $language['language_id']; ?>][filepdf]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['filepdf'] : ''; ?>"  id="input-filepdf<?php echo $language['language_id']; ?>" class="form-control" />
											
										</div>
									</div>

								</div>
								<?php } ?>
								<div class="form-group" >
									<label class="col-sm-2 control-label"><?php echo $entry_parent ?></label>
									<div class="col-sm-10">
										<select name="parent_id" class="form-control" id="parent_id">
											<option value="<?php if(isset($parent_default)){echo (int)$parent_default;}else {echo "0";}?>"><?php echo $text_none; ?></option>
											<?php foreach ($categories as $category) { ?>
                                            
                                            <?php //if($category['category_id']!=160 && $category['category_id']!=161 && $category['category_id']!=168){?>
                                            <?php if($category['parent_id']==93 && $category['category_id']!=168 ){?>
                                            
											<?php if ($category['category_id'] == $parent_id) { ?>
											<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
											<?php } ?>
                                            <?php }else{?>
                                            <!--<?php if ($category['category_id'] == $parent_id) { ?>
											<option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
											<?php } ?>-->
                                            
                                            <?php } ?>
											<?php } ?>
										</select>
										<?php if (isset($error_parent_id) && !empty($error_parent_id)) { ?>
										<div class="text-danger"><?php echo $error_parent_id; ?></div>
										<?php } ?>
									</div>
								</div>
                                
                                <div class="form-group  " style="display:none" >
              <label class="col-sm-2 control-label" for="category_id"><?php echo $entry_subcateproduct; ?></label>
              <div class="col-sm-10">
                <select name="subcateproduct_id" id="subcateproduct_id" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($subcateproducts as $item) { ?>
                  <?php if ($item['subcateproduct_id'] == $subcateproduct_id) { ?>
                  <option value="<?php echo $item['subcateproduct_id']; ?>" selected="selected"><?php echo $item['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $item['subcateproduct_id']; ?>"><?php echo $item['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if (isset($error_subcateproduct_id) && !empty($error_subcateproduct_id)) { ?>
                <div class="text-danger"><?php echo $error_subcateproduct_id; ?></div>
                <?php } ?>
              </div>
            </div>
                                
                                <div class="form-group subcateproduct_name" style="display:none" >
									<label class="col-sm-2 control-label" for="ishome"><?php echo $entry_ishome; ?></label>
									<div class="col-sm-10">
										<div class="checkbox">
											<label>
												<input class="form-control" type="checkbox" name="ishome" id="ishome" value="1" <?php if($ishome) echo 'checked="checked"';?> />
											</label>
										</div>
									</div>
								</div>

								<div class="form-group  "  style="display:none">
									<label class="col-sm-2 control-label">
										<span data-toggle="tooltip" title="<?php echo $help_entry_image_cateproduct; ?>"><?php echo $entry_image_cateproduct; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_entry_image_cateproduct ?></p>
									</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
											<img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
										</a>
										<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
										<?php if (isset($error_image) && !empty($error_image)) { ?>
										<div class="text-danger"><?php echo $error_image; ?></div>
										<?php } ?>
                                        <br />
                                        <input type="checkbox" value="1" name="delete_image" /> <?php echo $entry_delete_image;?>
									</div>
								</div>
                                
                                <div class="form-group display " style="display:none">
									<label class="col-sm-2 control-label" for="input-iconsvg"><?php echo $entry_iconsvg; ?></label>
									<div class="col-sm-10">
										<textarea name="iconsvg" rows="5" id="input-iconsvg" class="form-control" ><?php echo $iconsvg; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group required "  style="display:none" >
									<label class="col-sm-2 control-label">
										<span data-toggle="tooltip" title="<?php echo $help_entry_image1_cateproduct; ?>"><?php echo $entry_image1_cateproduct; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_entry_image1_cateproduct ?></p>
									</label>
									<div class="col-sm-10">
										<a href="" id="thumb-image-1" data-toggle="image" class="img-thumbnail">
											<img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
										</a>
										<input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-1" />
										<?php if (isset($error_image1) && !empty($error_image1)) { ?>
										<div class="text-danger"><?php echo $error_image1; ?></div>
										<?php } ?>
                                        <br />
                                        <!--<input type="checkbox" value="1" name="delete_image1" /> <?php echo $entry_delete_image;?>-->
									</div>
								</div>
                                
                                

								<div class="form-group  required" <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label class="col-sm-2 control-label" for="path"><?php echo $entry_path; ?></label>
									<div class="col-sm-10">
										<input type="text" name="path" value="<?php echo $path; ?>" class="form-control" />
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
										<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
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
						<div class="tab-pane" id="tab-image">
                        	<div class="tab-content">
                            	
                                
                                
                                <!-- time -->
                                <div class="form-group required" style="display:none" >
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
											<td class="text-left  required">
												<span data-toggle="tooltip" title="<?php echo $help_column_images_product; ?>"><?php echo $column_images_cateproduct;?></span><br/>
												<p class="s-mobile s-mobile-help"><?php echo $help_column_images_product ?></p>
											</td>
											<td class="text-left" style="display:none">
												<span title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br/>
												<p class="s-mobile s-mobile-help"><?php echo $help_column_images1 ?></p>
											</td>
											<td class="text-left"><?php echo $column_sort_order; ?></td>
											<td><?php if (isset($error_category_image)) { ?>
												<div class="text-danger"><?php echo $error_category_image; ?></div>
												<?php }?>
											</td>
										</tr>
									</thead>
									<tbody id="image_row">
										<?php $image_row = 0; ?>
										<?php foreach ($category_images as $category_image) { ?>
										<tr id="image-row<?php echo $image_row; ?>">
											<td class="text-left">
												<a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
													<img src="<?php if(empty($category_image['preview_1'])) echo 'view/image/image.png'; else echo $category_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
												</a>
												<input type="hidden" name="category_image[<?php echo $image_row; ?>][image]" value="<?php echo $category_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
											</td>
											<td class="text-left" style="display:none"><a href="" id="thumb-image1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($category_image['preview1'])) echo 'view/image/image.png'; else echo $category_image['preview1']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" /></a><input type="hidden" name="category_image[<?php echo $image_row; ?>][image1]" value="<?php echo $category_image['image_2']; ?>" id="input-image1<?php echo $image_row; ?>" /></td>
											<td class="text-right"><input type="text" name="category_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $category_image['image_sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
											<td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();checkMaxBackground();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										</tr>
										<?php $image_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td style="display:none"></td>
											<td></td>
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
										<a href="" id="thumb-image_og" data-toggle="image" class="img-thumbnail">
											<img src="<?php if(empty($preview_og)) echo 'view/image/image.png'; else echo $preview_og; ?>" alt="" title="" data-placeholder="<?php echo $image_og; ?>" />
										</a>
										<input type="hidden" name="image_og" value="<?php echo $image_og; ?>" id="input-image_og" />
										<input type="checkbox" name="delete_image_og" value="1" /> <?php echo $entry_delete_image;?>
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
			$("#input-description<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}
			});
			
			/*$("#input-name-1<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'50px', styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'clear']],['history', ['undo', 'redo']],['style', ['style']],]
			});
			
			$('#input-name-1' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');
			*/
			
			<?php } ?>
		//
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
	$(document).ready(function() {
		
		var parent_id = '<?php echo $parent_id;?>';
		var category_id = '<?php echo $category_id;?>';
		//var data_cate = $('#parent_id').find('option:selected').attr('data-cate');
		
		
		if(parent_id==93 || parent_id==0 ){
			$('.subcateproduct_name').show();
			//$('.display_image_1').show();
			$('.subcateproduct_id').hide();
		}else if(parent_id==328 || parent_id==295 ){
			$('.subcateproduct_name').show();
			//$('.display_image_1').hide();
			$('.subcateproduct_id').show();
		}else{
			$('.subcateproduct_name').hide();
			//$('.display_image_1').hide();
			$('.subcateproduct_id').show();
		}

		
		$('#parent_id').change(function(){
			var parent_id = $(this).val();
			//var data_cate = $(this).find('option:selected').attr('data-cate');
			
			
			if(parent_id==93 ){
				$('.subcateproduct_name').show();
				//$('.display_image_1').show();
				$('.subcateproduct_id').hide();
			}else if(parent_id==328 || parent_id==295 ){
				$('.subcateproduct_name').show();
				//$('.display_image_1').hide();
				$('.subcateproduct_id').show();
			}else{
				$('.subcateproduct_name').hide();
				//$('.display_image_1').hide();
				$('.subcateproduct_id').show();
			}
		});
			
	});
	</script>

	<script type="text/javascript">
	
function checkMaxBackground(){
	var row = $('#images tbody tr').length;
	var category_id = "<?php echo $category_id;?>";
	
	if(category_id==92){
		if(row>9)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}else{
		if(row>5)
			$('#add_button').hide();
		else
			$('#add_button').show();
	}
}

		var image_row = <?php echo $image_row; ?>;
		function addImage() {
			html  = '<tr id="image-row' + image_row + '">';
			html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo "view/image/image.png"; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image_1; ?>" /><input type="hidden" name="category_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
			html += '  <td class="text-left" style="display:none"><a href="" id="thumb-image1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo "view/image/image.png"; else echo $preview_2; ?>" alt="" title="" data-placeholder="<?php echo $image_2; ?>" /><input type="hidden" name="category_image[' + image_row + '][image1]" value="" id="input-image1' + image_row + '" /></td>';
			html += '  <td class="text-right"><input type="text" name="category_image[' + image_row + '][image_sort_order]" value=""   class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();checkMaxBackground();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';

			$('#images tbody').append(html);

			image_row++;
			checkMaxBackground();
		}
	</script>
    
    <script type="text/javascript">
	$(document).ready(function() {
		checkMaxBackground();
		
		/*var parent_id = '<?php echo $parent_id;?>';
		var category_id = '<?php echo $category_id;?>';
		//var data_cate = $('#parent_id').find('option:selected').attr('data-cate');
		
		
		if(parent_id==93 || parent_id==0 ){
			$('.display_image').show();
			$('.display_image_1').show();
			$('.display_image_pdf').hide();
		}else if(parent_id==266 || parent_id==160 || parent_id==259 ){
			$('.display_image').hide();
			$('.display_image_1').show();
			$('.display_image_pdf').show();
		}else{
			$('.display_image').hide();
			$('.display_image_1').hide();
			$('.display_image_pdf').hide();
		}

		
		$('#parent_id').change(function(){
			var parent_id = $(this).val();
			//var data_cate = $(this).find('option:selected').attr('data-cate');
			
			
			if(parent_id==93 ){
				$('.display_image').show();
				$('.display_image_1').show();
				$('.display_image_pdf').hide();
			}else if(parent_id==266 || parent_id==160 || parent_id==259 ){
				$('.display_image').hide();
				$('.display_image_1').show();
				$('.display_image_pdf').show();
			}else{
				$('.display_image').hide();
				$('.display_image_1').hide();
				$('.display_image_pdf').hide();
			}
		});*/
			
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
		$('#language-seo a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>