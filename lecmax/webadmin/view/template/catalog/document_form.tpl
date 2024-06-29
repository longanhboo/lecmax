<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-document" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-document" class="form-horizontal">
					<input type="hidden" name="cate" value="<?php echo $cate;?>" />
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li style="display:none"><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
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
											<input type="text" name="document_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>

									<div class="form-group" >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="document_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
																		<div class="form-group" style="display:none">
										<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_download;?>"><?php echo $entry_download;?></span><br/>
											<p class="s-mobile s-mobile-help"><?php echo $help_download;?></p>
										</label>
										<div class="col-sm-10">
											<input type="file" name="document_description[<?php echo $language['language_id']; ?>][pdf]" />
											<?php
											$old_file[$language['language_id']] = isset($document_description[$language['language_id']]['pdf'])?$document_description[$language['language_id']]['pdf']:'';

											if(isset($document_description[$language['language_id']]['old_file'])){

												$old_file[$language['language_id']] = $document_description[$language['language_id']]['old_file'];
											}
											?>
											<span class="help"><?php echo $old_file[$language['language_id']]; ?></span>
											<input type="hidden" value="<?php echo $old_file[$language['language_id']]; ?>" name="document_description[<?php echo $language['language_id']; ?>][old_file]" />
											<br />
											<input type="checkbox" value="1" name="document_description[<?php echo $language['language_id']; ?>][delete_pdf]" /> <?php echo $entry_delete_file;?>

											<?php if (isset($error_pdf[$language['language_id']]) && !empty($error_pdf[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_pdf[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>

            <!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
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
            <div class="form-group" style="display:none" >
                <label class="col-sm-2 control-label">
                    <span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
                </label>
                <div class="col-sm-10">
                    <a href="" id="thumb-image-img1" data-toggle="image" class="img-thumbnail">
                        <img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                    </a>
                    <input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-img1" />
                    <br />
                    <input type="checkbox" name="delete_image1" value="1" /> <?php echo $entry_delete_image;?>
                </div>
            </div>
            <div class="form-group display_home" style="display:none">
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
                            <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1;?></p></td>
                            <td class="text-left required"><?php echo $column_images_name; ?></td>
                            <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                            <td><?php if(isset($error_images)){?><div class="text-danger"><?php echo $error_images; ?></div><?php }?></td>
                        </tr>
                    </thead>
                    <tbody id="image_row">
                        <?php $image_row = 0; ?>
                        <?php foreach ($document_images as $document_image) { ?>
                        <tr id="image-row<?php echo $image_row; ?>">
                            <td class="text-left">
                                <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($document_image['preview_1'])) echo 'view/image/image.png'; else echo $document_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                                </a>
                                <input type="hidden" name="document_image[<?php echo $image_row; ?>][image]" value="<?php echo $document_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            </td>
                            <td class="text-left">
                                <a href="" id="thumb-image-1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($document_image['preview_2'])) echo 'view/image/image.png'; else echo $document_image['preview_2']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                                </a>
                                <input type="hidden" name="document_image[<?php echo $image_row; ?>][image1]" value="<?php echo $document_image['image_2']; ?>" id="input-image-1<?php echo $image_row; ?>" />
                            </td>
                            
                            <td class="text-left" style="width:70%;min-width:150px;">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;" name="document_image[<?php echo $image_row; ?>][image_name]" class="form-control"><?php echo isset($document_image['image_name']) ? $document_image['image_name'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="document_image[<?php echo $image_row; ?>][image_name_en]" class="form-control"><?php echo isset($document_image['image_name_en']) ? $document_image['image_name_en'] : ''; ?></textarea>
                                </div>
                            </td>
    
                            <td class="text-left"><input style="width:40px" type="text" name="document_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $document_image['image_sort_order']; ?>" class="form-control"/></td>
                            <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row<?php echo $image_row ?>').remove(); $('.tooltip').remove();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                        </tr>
                        <?php $image_row++; ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
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
                    <label class="col-sm-2 control-label" for="document_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" id="document_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="document_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['meta_title'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="document_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="document_description[<?php echo $language['language_id']; ?>][meta_description]" id="document_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="document_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="document_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="document_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="document_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="document_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="document_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="document_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control"  name="document_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="document_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($document_description[$language['language_id']]) ? $document_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="document_keyword[<?php echo $language['language_id']; ?>][keyword]" >
                    <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control"  name="document_keyword[<?php echo $language['language_id']; ?>][keyword]" id="document_keyword[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($document_keyword[$language['language_id']]) ? $document_keyword[$language['language_id']]['keyword'] : ''; ?>" />
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


<script type="text/javascript">
	/*Khong thay doi ten bien image_row*/
	var image_row = <?php echo $image_row; ?>;

	function addImage() {
		html  = '<tr id="image-row' + image_row + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo "view/image/image.png"; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" /><input type="hidden" name="document_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
		
		html += '  <td class="text-left"><a href="" id="thumb-image-1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo "view/image/image.png"; else echo $preview_2; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" /><input type="hidden" name="document_image[' + image_row + '][image1]" value="" id="input-image-1' + image_row + '" /></td>';

		html += '<td class="text-center" style="width:70%;min-width:150px;"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="document_image[' + image_row + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="document_image[' + image_row + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="document_image[' + image_row + '][image_sort_order]" value="" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row' + image_row  + '\').remove(); $(\'.tooltip\').remove();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#images tbody').append(html);

		image_row++;
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