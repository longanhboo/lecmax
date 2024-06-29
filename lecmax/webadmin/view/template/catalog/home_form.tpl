<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-home" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-home" class="form-horizontal">
					<!--{FORM_HIDDEN}-->
					<ul class="nav nav-tabs">
						<li style="display:none" ><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li  class="active" ><a href="#tab-video" data-toggle="tab"><?php echo $tab_video; ?></a></li>
                        <li style="display:none" ><a href="#tab-vitri" data-toggle="tab"><?php echo $tab_vitri; ?></a></li>
                        <li style="display:none" ><a href="#tab-tienich" data-toggle="tab"><?php echo $tab_tienich; ?></a></li>
                        <li style="display:none" ><a href="#tab-canho" data-toggle="tab"><?php echo $tab_canho; ?></a></li>
                        
                        <li style="display:none"><a href="#tab-daidiens" data-toggle="tab"><?php echo $tab_daidien; ?></a></li>
						<li  ><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                        
<!--{TAB_FORM}-->
					</ul>
					<div class="tab-content">
						<!-- tab_general -->
						<div class="tab-pane  " id="tab-general">
							<ul class="nav nav-tabs" id="language" style="display:none" >
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $language['language_id']; ?>" style="display:none">

									<div class="form-group required" style="display:none" >
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][name]"   id="input-name<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['name'] : ''; ?>" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    
                                    
                                    <div class="form-group required" style="display:none" >
										<label class="col-sm-2 control-label" for="input-name2<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][name2]" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['name2'] : ''; ?>"  id="input-name1<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name2[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name2[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-desc-short<?php echo $language['language_id']; ?>"><?php echo $entry_desc_short; ?></label>
										<div class="col-sm-10">
											<textarea rows="3" name="home_description[<?php echo $language['language_id']; ?>][desc_short]"  id="input-desc-short<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['desc_short'] : ''; ?></textarea>
										</div>
									</div>

									<div class="form-group" style="display:none" >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="home_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
                                
                                <div class="form-group  " >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                </a>
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                <br />
                <input type="checkbox" value="1" name="delete_image" /> <?php echo $entry_delete_image;?>
                <?php if (isset($error_image) && !empty($error_image)) { ?>
                <div class="text-danger"><?php echo $error_image; ?></div>
                <?php } ?>
              </div>
            </div>
                                
            
            
                      <div class="form-group "  >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_news; ?>"><?php echo $entry_image_news; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_news ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-news" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($previewnews)) echo 'view/image/image.png'; else echo $previewnews; ?>" alt="" title="" data-placeholder="<?php echo $imagenews; ?>" />
                </a>
                <input type="hidden" name="imagenews" value="<?php echo $imagenews; ?>" id="input-image-news" />
                <br />
                <input type="checkbox" value="1" name="delete_imagenews" /> <?php echo $entry_delete_image;?>
                <?php if (isset($error_imagenews) && !empty($error_imagenews)) { ?>
                <div class="text-danger"><?php echo $error_imagenews; ?></div>
                <?php } ?>
              </div>
            </div>  
            
            <div class="form-group  " style="display:none"  >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-1" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                </a>
                <input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image-1" />
                <br />
                <input type="checkbox" value="1" name="delete_image1" /> <?php echo $entry_delete_image;?>
                <?php if (isset($error_image1) && !empty($error_image1)) { ?>
                <div class="text-danger"><?php echo $error_image1; ?></div>
                <?php } ?>
              </div>
            </div>   
            
            <div class="form-group  " style="display:none">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_tienich; ?>"><?php echo $entry_image_tienich; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_tienich ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-tienich" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($previewtienich)) echo 'view/image/image.png'; else echo $previewtienich; ?>" alt="" title="" data-placeholder="<?php echo $imagetienich; ?>" />
                </a>
                <input type="hidden" name="imagetienich" value="<?php echo $imagetienich; ?>" id="input-image-tienich" />
                <br />
                <input type="checkbox" value="1" name="delete_imagetienich" /> <?php echo $entry_delete_image;?>
                <?php if (isset($error_imagetienich) && !empty($error_imagetienich)) { ?>
                <div class="text-danger"><?php echo $error_imagetienich; ?></div>
                <?php } ?>
              </div>
            </div> 
            
            
            <div class="form-group required" style="display:none" >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_chudautu; ?>"><?php echo $entry_image_chudautu; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_chudautu ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-chudautu" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($previewchudautu)) echo 'view/image/image.png'; else echo $previewchudautu; ?>" alt="" title="" data-placeholder="<?php echo $imagechudautu; ?>" />
                </a>
                <input type="hidden" name="imagechudautu" value="<?php echo $imagechudautu; ?>" id="input-image-chudautu" />
                <br />
                <!--<input type="checkbox" value="1" name="delete_imagechudautu" /> <?php echo $entry_delete_image;?>-->
                <?php if (isset($error_imagechudautu) && !empty($error_imagechudautu)) { ?>
                <div class="text-danger"><?php echo $error_imagechudautu; ?></div>
                <?php } ?>
              </div>
            </div>
            
            <div class="form-group" style="display:none" >
								<label class="col-sm-2 control-label" for="isshareholder"><?php echo $entry_isshareholder;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($isshareholder == "1") {?>
											<input id="isshareholder" value="1" type="checkbox" name="isshareholder" checked="checked"/>
											<?php } else {?>
											<input id="isshareholder" value="1" type="checkbox" name="isshareholder"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>        
							
								
            <!--{FORM_IMAGE}-->
            
            

								<div class="form-group" style="display:none">
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
                        
                        <!-- tab_vitri -->
                        <div class="tab-pane" id="tab-vitri">
							<ul class="nav nav-tabs sub-nav" id="languagevitri">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagevitri<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							
							<div class="tab-content">
                            	<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagevitri<?php echo $language['language_id']; ?>">
                                
                                    <div class="form-group required">
										<label class="col-sm-2 control-label" for="input-namevitri<?php echo $language['language_id']; ?>"><?php echo $entry_namevitri; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][namevitri]" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['namevitri'] : ''; ?>"  id="input-namevitri<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_namevitri[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_namevitri[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none">
										<label class="col-sm-2 control-label" for="input-name1vitri<?php echo $language['language_id']; ?>"><?php echo $entry_name1vitri; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][name1vitri]" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['name1vitri'] : ''; ?>"  id="input-name1vitri<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name1vitri[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name1vitri[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" >
										<label class="col-sm-2 control-label" for="input-desc-short-canho<?php echo $language['language_id']; ?>"><?php echo $entry_desc_short; ?></label>
										<div class="col-sm-10">
											<textarea name="home_description[<?php echo $language['language_id']; ?>][desc_short_canho]"  id="input-desc-short-canho<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['desc_short_canho'] : ''; ?></textarea>
										</div>
									</div>
                                    
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
                                
            
            
            
            
            
            
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-googlemap"><?php echo $entry_googlemap; ?></label>
									<div class="col-sm-10">
										<input type="text" name="googlemap" value="<?php echo $googlemap; ?>" id="input-googlemap" class="form-control" />
									</div>
								</div>
                                
                                

								
            			
             
            
            <div class="form-group required">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_chudautu; ?>"><?php echo $entry_image1_chudautu; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_chudautu ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image1-chudautu" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview1chudautu)) echo 'view/image/image.png'; else echo $preview1chudautu; ?>" alt="" title="" data-placeholder="<?php echo $image1chudautu; ?>" />
                </a>
                <input type="hidden" name="image1chudautu" value="<?php echo $image1chudautu; ?>" id="input-image1-chudautu" />
                <br />
                <!--<input type="checkbox" value="1" name="delete_image1chudautu" /> <?php echo $entry_delete_image;?>-->
                <?php if (isset($error_image1chudautu) && !empty($error_image1chudautu)) { ?>
                <div class="text-danger"><?php echo $error_image1chudautu; ?></div>
                <?php } ?>
              </div>
            </div>	
                                
            <!--{FORM_IMAGE}-->

								

							</div>
						</div>
                        
                        <!-- tab_canho -->
                        <div class="tab-pane" id="tab-canho">
							<ul class="nav nav-tabs sub-nav" id="languagecanho">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagecanho<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagecanho<?php echo $language['language_id']; ?>">
                                
                                    <div class="form-group required">
										<label class="col-sm-2 control-label" for="input-name1<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][name1]" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['name1'] : ''; ?>"  id="input-name1<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name1[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name1[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" >
										<label class="col-sm-2 control-label" for="input-namecanho<?php echo $language['language_id']; ?>"><?php echo $entry_namecanho; ?></label>
										<div class="col-sm-10">
											<textarea rows="4" name="home_description[<?php echo $language['language_id']; ?>][namecanho]"   id="input-namecanho<?php echo $language['language_id']; ?>" class="form-control" ><?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['namecanho'] : ''; ?></textarea>
                                            <?php if (isset($error_namecanho[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_namecanho[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    
                                    
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
                            
            					
                                <div class="form-group required"  >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_canho; ?>"><?php echo $entry_image_canho; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_canho ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-canho" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($previewcanho)) echo 'view/image/image.png'; else echo $previewcanho; ?>" alt="" title="" data-placeholder="<?php echo $imagecanho; ?>" />
                </a>
                <input type="hidden" name="imagecanho" value="<?php echo $imagecanho; ?>" id="input-image-canho" />
                <br />
                <!--<input type="checkbox" value="1" name="delete_imagecanho" /> <?php echo $entry_delete_image;?>-->
                <?php if (isset($error_imagecanho) && !empty($error_imagecanho)) { ?>
                <div class="text-danger"><?php echo $error_imagecanho; ?></div>
                <?php } ?>
              </div>
            </div>
            
            <div class="form-group required" style="display:none">
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image_canho; ?>"><?php echo $entry_image1_canho; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_canho ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image1-canho" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview1canho)) echo 'view/image/image.png'; else echo $preview1canho; ?>" alt="" title="" data-placeholder="<?php echo $image1canho; ?>" />
                </a>
                <input type="hidden" name="image1canho" value="<?php echo $image1canho; ?>" id="input-image1-canho" />
                <br />
                <!--<input type="checkbox" value="1" name="delete_image1canho" /> <?php echo $entry_delete_image;?>-->
                <?php if (isset($error_image1canho) && !empty($error_image1canho)) { ?>
                <div class="text-danger"><?php echo $error_image1canho; ?></div>
                <?php } ?>
              </div>
            </div>	
                                
            <!--{FORM_IMAGE}-->

								

							</div>
						</div>
                        
                        <!-- tab_tienich -->
                        <div class="tab-pane " id="tab-tienich">
							<ul class="nav nav-tabs sub-nav" id="languagetienich">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#languagetienich<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="languagetienich<?php echo $language['language_id']; ?>">
                                	
                                    <div class="form-group required">
										<label class="col-sm-2 control-label" for="input-nametienich<?php echo $language['language_id']; ?>"><?php echo $entry_nametienich; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][nametienich]"  id="input-nametienich<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['nametienich'] : ''; ?>" />
											<?php if (isset($error_nametienich[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_nametienich[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none">
										<label class="col-sm-2 control-label" for="input-name1tienich<?php echo $language['language_id']; ?>"><?php echo $entry_name1tienich; ?></label>
										<div class="col-sm-10">
											<input type="text" name="home_description[<?php echo $language['language_id']; ?>][name1tienich]" value="<?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['name1tienich'] : ''; ?>"  id="input-name1tienich<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name1tienich[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name1tienich[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group">
										<label class="col-sm-2 control-label" for="input-desc-short-tienich<?php echo $language['language_id']; ?>"><?php echo $entry_desc_short; ?></label>
										<div class="col-sm-10">
											<textarea rows="3" name="home_description[<?php echo $language['language_id']; ?>][desc_short_tienich]"  id="input-desc-short-tienich<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($home_description[$language['language_id']]) ? $home_description[$language['language_id']]['desc_short_tienich'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
                                
                                
            
            
            <!--{FORM_IMAGE}-->

							<div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-link-tongthe"><?php echo $entry_link_tongthe; ?></label>
									<div class="col-sm-10">
										<input type="text" name="link_tongthe" value="<?php echo $link_tongthe; ?>" id="input-link-tongthe" class="form-control" />
									</div>
								</div>	
                                
                                
                                
                              
            
            

							
                            
                            

							</div>
						</div>
                        
                        <!-- tab-video -->
						<div class="tab-pane active" id="tab-video" >
                        	
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
                            
                            <div class="form-group" style="display:none" >
								<label class="col-sm-2 control-label" for="isyoutube"><?php echo $entry_upload_youtube;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($isyoutube == "1") {?>
											<input id="isyoutube" value="1" type="checkbox" name="isyoutube" checked="checked"/>
											<?php } else {?>
											<input id="isyoutube" value="1" type="checkbox" name="isyoutube" checked="checked"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group display_youtube" style="display:none">
								<label class="col-sm-2 control-label" for="script">Link youtube: <!--<span data-toggle="tooltip" title="<?php echo $help_script_home;?>"><?php echo $entry_script;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_script_home ?></p>-->
								</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="script" id="script" value="<?php echo $script; ?>">
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

							<div class="form-group display_upload display_file">
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
                        
                        <div class="tab-pane" id="tab-daidiens" style="display:none">
                        <div class="table-responsive">
                            <table id="daidiens" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images_daidien; ?>"><?php echo $column_images_daidien;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images_daidien;?></p></td>
                                        <td class="text-left required " ><span data-toggle="tooltip" title="<?php echo $help_column_images1_daidien; ?>"><?php echo $column_images1_daidien;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1_daidien;?></p></td>
                                        <td class="text-left required"><?php echo $column_images_daidien_name; ?></td>
                                        <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                                        <td><?php if(isset($error_images_daidien)){?><div class="text-danger"><?php echo $error_images_daidien; ?></div><?php }?></td>
                                    </tr>
                                </thead>
                                <tbody id="image_row_daidien">
                                    <?php $image_row_daidien = 0; ?>
                                    <?php foreach ($home_daidiens as $home_daidien) { ?>
                                    <tr id="image-row-daidien<?php echo $image_row_daidien; ?>">
                                        <td class="text-left">
                                            <a href="" id="thumb-image-daidien<?php echo $image_row_daidien; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($home_daidien['preview_1'])) echo 'view/image/image.png'; else echo $home_daidien['preview_1']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="home_daidien[<?php echo $image_row_daidien; ?>][image]" value="<?php echo $home_daidien['image_1']; ?>" id="input-image-daidien<?php echo $image_row_daidien; ?>" />
                                        </td>
                                        <td class="text-left"  >
                                            <a href="" id="thumb-image-daidien-1<?php echo $image_row_daidien; ?>" data-toggle="image" class="img-thumbnail">
                                                <img src="<?php if(empty($home_daidien['preview_2'])) echo 'view/image/image.png'; else echo $home_daidien['preview_2']; ?>" alt="" title="" />
                                            </a>
                                            <input type="hidden" name="home_daidien[<?php echo $image_row_daidien; ?>][image1]" value="<?php echo $home_daidien['image_2']; ?>" id="input-image-daidien-1<?php echo $image_row_daidien; ?>" />
                                        </td>
                                        
                                        <td class="text-left" style="width:40%;min-width:150px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;" name="home_daidien[<?php echo $image_row_daidien; ?>][image_name]" class="form-control"><?php echo isset($home_daidien['image_name']) ? $home_daidien['image_name'] : ''; ?></textarea>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                                <textarea cols="30" rows="3" style="height:70px;resize:none;"  name="home_daidien[<?php echo $image_row_daidien; ?>][image_name_en]" class="form-control"><?php echo isset($home_daidien['image_name_en']) ? $home_daidien['image_name_en'] : ''; ?></textarea>
                                            </div>
                                        </td>
                
                                        <td class="text-left"><input style="width:40px" type="text" name="home_daidien[<?php echo $image_row_daidien; ?>][image_sort_order]" value="<?php echo $home_daidien['image_sort_order']; ?>" class="form-control"/></td>
                                        <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row-daidien<?php echo $image_row_daidien ?>').remove(); $('.tooltip').remove();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                                    </tr>
                                    <?php $image_row_daidien++; ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td  ></td>
                                        <td ></td>
                                        <td></td>
                                        <td class="text-left"><button type="button" onclick="addDaidien();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
						
        <div class="tab-pane  " id="tab-image">
        			<div class="tab-content">
                    
                    	
            
            
            
            
        				<!-- time -->
                        <div class="form-group required" >
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
                    <!--<font color="#FF0000"><?php echo $column_class_help; ?></font>-->
            <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left required "><span data-toggle="tooltip" title="<?php echo $help_column_images; ?>"><?php echo $column_images;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images;?></p></td>
                            <td class="text-left  " style="display:none" ><span data-toggle="tooltip" title="<?php echo $help_column_images1; ?>"><?php echo $column_images1;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images1;?></p></td>
                            <td class="text-left required " style="display:none" ><span data-toggle="tooltip" title="<?php echo $help_column_images2; ?>"><?php echo $column_images2;?></span><br /><p class="s-mobile s-mobile-help"><?php echo $help_column_images2;?></p></td>
                            <td class="text-left "  ><?php echo $column_images_name; ?></td>
                            <td class="text-left "  ><?php echo $column_images_desc; ?></td>
                            <td class="text-left " style="display:none" ><?php echo $column_images_info; ?></td>
                            <td class="text-left " style="display:none" ><?php echo $column_images_link; ?></td>
                            <td class="text-left" width="80px" style="display:none"  ><?php echo $column_class; ?></td>
                            <td class="text-left" width="70px"><?php echo $column_sort_order; ?></td>
                            <td ><?php if(isset($error_images)){?><div class="text-danger"><?php echo $error_images; ?></div><?php }?></td>
                        </tr>
                    </thead>
                    <tbody id="image_row">
                        <?php $image_row = 0; ?>
                        <?php foreach ($home_images as $home_image) { ?>
                        <tr id="image-row<?php echo $image_row; ?>">
                            <td class="text-left">
                                <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($home_image['preview_1'])) echo 'view/image/image.png'; else echo $home_image['preview_1']; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                                </a>
                                <input type="hidden" name="home_image[<?php echo $image_row; ?>][image]" value="<?php echo $home_image['image_1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            </td>
                            <td class="text-left" style="display:none" >
                                <a href="" id="thumb-image-1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($home_image['preview_2'])) echo 'view/image/image.png'; else echo $home_image['preview_2']; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                                </a>
                                <input type="hidden" name="home_image[<?php echo $image_row; ?>][image1]" value="<?php echo $home_image['image_2']; ?>" id="input-image-1<?php echo $image_row; ?>" />
                            </td>
                            
                            <td class="text-left" style="display:none" >
                                <a href="" id="thumb-image-i1<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                    <img src="<?php if(empty($home_image['preview_3'])) echo 'view/image/image.png'; else echo $home_image['preview_3']; ?>" alt="" title="" data-placeholder="<?php echo $image2; ?>" />
                                </a>
                                <input type="hidden" name="home_image[<?php echo $image_row; ?>][image2]" value="<?php echo $home_image['image_3']; ?>" id="input-image-i1<?php echo $image_row; ?>" />
                            </td>
                            
                            <td class="text-left" style="width:20%;min-width:150px; ">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;" name="home_image[<?php echo $image_row; ?>][image_name]" class="form-control"><?php echo isset($home_image['image_name']) ? $home_image['image_name'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;"  name="home_image[<?php echo $image_row; ?>][image_name_en]" class="form-control"><?php echo isset($home_image['image_name_en']) ? $home_image['image_name_en'] : ''; ?></textarea>
                                </div>
                            </td>
                            
                            <td class="text-left" style="width:20%;min-width:150px; ">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;" name="home_image[<?php echo $image_row; ?>][image_desc]" class="form-control"><?php echo isset($home_image['image_desc']) ? $home_image['image_desc'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;"  name="home_image[<?php echo $image_row; ?>][image_desc_en]" class="form-control"><?php echo isset($home_image['image_desc_en']) ? $home_image['image_desc_en'] : ''; ?></textarea>
                                </div>
                            </td>
                            
                            <td class="text-left" style="width:20%;min-width:150px; display:none ">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;" name="home_image[<?php echo $image_row; ?>][image_info]" class="form-control"><?php echo isset($home_image['image_info']) ? $home_image['image_info'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;"  name="home_image[<?php echo $image_row; ?>][image_info_en]" class="form-control"><?php echo isset($home_image['image_info_en']) ? $home_image['image_info_en'] : ''; ?></textarea>
                                </div>
                            </td>
                            
                            <td class="text-left" style="width:20%;min-width:150px; display:none ">
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/vn.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;" name="home_image[<?php echo $image_row; ?>][image_link]" class="form-control"><?php echo isset($home_image['image_link']) ? $home_image['image_link'] : ''; ?></textarea>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><img src="view/image/flags/gb.png" /></span>
                                    <textarea cols="30" rows="3" style="height:100px;resize:none;"  name="home_image[<?php echo $image_row; ?>][image_link_en]" class="form-control"><?php echo isset($home_image['image_link_en']) ? $home_image['image_link_en'] : ''; ?></textarea>
                                </div>
                            </td>
                            
                            <td class="text-left" style="width:20%;min-width:150px; display:none;">
                                <div class="input-group">
                            				<select name="home_image[<?php echo $image_row; ?>][product_id]" size="7" style="width:250px">
                                              <option value="0" style="padding:5px">-- Chọn --</option>
                                              <?php foreach ($products as $item) { ?>
                                              <?php if ($item['product_id'] == $home_image['product_id']) { ?>
                                              <option value="<?php echo $item['product_id']; ?>" selected="selected" style="padding:5px"><?php echo $item['name']; ?></option>
                                              <?php } else { ?>
                                              <option value="<?php echo $item['product_id']; ?>" style="padding:5px"><?php echo $item['name']; ?></option>
                                              <?php } ?>
                                              <?php } ?>
                                            </select>
                                 </div>
                            </td>
                            
                            <td class="text-left" style="display:none" >
                            <select name="home_image[<?php echo $image_row; ?>][image_class]" size="3" style="width:250px">
											  <!--<option value="" <?php if ($home_image['image_class'] == '') echo 'selected="selected"';?> style="padding:5px"><?php echo $entry_loai0; ?></option>-->
                                              <option value="01" <?php if ($home_image['image_class'] == '01') echo 'selected="selected"';?> style="padding:5px"><?php echo $entry_loai1; ?></option>
                                              <option value="02" <?php if ($home_image['image_class'] == '02') echo 'selected="selected"';?> style="padding:5px"><?php echo $entry_loai2; ?></option>
                                              <option value="03" <?php if ($home_image['image_class'] == '03') echo 'selected="selected"';?> style="padding:5px"><?php echo $entry_loai3; ?></option>
                                              <!--<option value="04" <?php if ($home_image['image_class'] == '04') echo 'selected="selected"';?> style="padding:5px"><?php echo $entry_loai4; ?></option>-->
                                            </select>
                                            
                            <!--<input style="width:80px" type="text" name="home_image[<?php echo $image_row; ?>][image_class]" value="<?php echo $home_image['image_class']; ?>" class="form-control"/>-->
                            </td>
    
                            <td class="text-left"><input style="width:40px" type="text" name="home_image[<?php echo $image_row; ?>][image_sort_order]" value="<?php echo $home_image['image_sort_order']; ?>" class="form-control"/></td>
                            <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove ?>" class="btn btn-danger" onclick="$('#image-row<?php echo $image_row ?>').remove(); $('.tooltip').remove();"><i class="fa fa-minus-circle"></i> <lbl class="s-mobile"><?php echo $button_remove ?></lbl></button></td>
                        </tr>
                        <?php $image_row++; ?>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr >
                            <td></td>
                            <td style="display:none"  ></td>
                            <td style="display:none" ></td>
                            <td  ></td>
                            <td  ></td>
                            <td style="display:none" ></td>
                            <td style="display:none" ></td>
                            <td style="display:none" ></td>
                            <td></td>
                            <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <lbl class="s-mobile"><?php echo $button_add_image; ?></lbl></button></td>
                        </tr>
                    </tfoot>
                </table>
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
		
			/*$("#input-nametienich<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'50px', styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'clear']],['history', ['undo', 'redo']],['style', ['style']],]
			});
			
			$('#input-nametienich' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');*/
			
			/*$("#input-desc-short<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'100px',toolbar: [['view', ['codeview']],['font', ['bold', 'italic', 'underline']],['insert', ['link']],['style', ['style']],]
			});
			
			$('#input-desc-short' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');*/
			/*$("#input-description<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}
			});*/
			/*$("#input-name<?php echo $language['language_id']; ?>").summernotetitle({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'50px', styleWithSpan: false,
				
				onChange: function(contents, $editable) {
					clean_html(this, "b", contents);
				}
			});*/
			<?php } ?>
		//
	</script>
	<!--{VIEW_SCRIPT}-->
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

<script type="text/javascript">
	/*Khong thay doi ten bien image_row*/
	var image_row = <?php echo $image_row; ?>;

	function addImage() {
		html  = '<tr id="image-row' + image_row + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_1)) echo "view/image/image.png"; else echo $preview_1; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" /><input type="hidden" name="home_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
		
		html += '  <td class="text-left" style="display:none"  ><a href="" id="thumb-image-1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_2)) echo "view/image/image.png"; else echo $preview_2; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" /><input type="hidden" name="home_image[' + image_row + '][image1]" value="" id="input-image-1' + image_row + '" /></td>';
		
		html += '  <td class="text-left" style="display:none" ><a href="" id="thumb-image-i1' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_3)) echo "view/image/image.png"; else echo $preview_3; ?>" alt="" title="" data-placeholder="<?php echo $image2; ?>" /><input type="hidden" name="home_image[' + image_row + '][image2]" value="" id="input-image-i1' + image_row + '" /></td>';

		html += '<td class="text-center" style="width:20%;min-width:150px;"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="home_image[' + image_row + '][image_name]" class="form-control" style="height:100px;resize:none;" cols="30" rows="3" ></textarea></div>';
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="home_image[' + image_row + '][image_name_en]"  class="form-control" style="height:100px;resize:none;" ></textarea></div></td>';
		
		
		html += '<td class="text-center" style="width:20%;min-width:150px;"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="home_image[' + image_row + '][image_desc]" class="form-control" style="height:100px;resize:none;" cols="30" rows="3" ></textarea></div>';
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="home_image[' + image_row + '][image_desc_en]"  class="form-control" style="height:100px;resize:none;" ></textarea></div></td>';
		
		html += '<td class="text-center" style="width:20%;min-width:150px;display:none;"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="home_image[' + image_row + '][image_info]" class="form-control" style="height:100px;resize:none;" cols="30" rows="3" ></textarea></div>';
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="home_image[' + image_row + '][image_info_en]"  class="form-control" style="height:100px;resize:none;" ></textarea></div></td>';
		
		html += '<td class="text-center" style="width:20%;min-width:150px;display:none"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="home_image[' + image_row + '][image_link]" class="form-control" style="height:100px;resize:none;" cols="30" rows="3" ></textarea></div>';
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="home_image[' + image_row + '][image_link_en]"  class="form-control" style="height:100px;resize:none;" ></textarea></div></td>';
		
		html += '<td class="text-center" style="width:20%;min-width:150px;display:none;"><div class="input-group"><select id="home_image_pro_' + image_row + '" name="home_image[' + image_row + '][product_id]" size="10" style="width:250px"><option value="0" style="padding:5px">-- Chọn --</option><?php foreach ($products as $item) { ?><option value="'+ "<?php echo $item['product_id']; ?>"+'" style="padding:5px">'+"<?php echo $item['name']; ?>"+'</option><?php } ?></select></div></td>';
		
		
		
		html += '  <td class="text-right"  style="display:none" >';
		html += '  <select name="home_image[' + image_row + '][image_class]" size="3" style="width:250px"><option selected="selected" value="01" style="padding:5px"><?php echo $entry_loai1; ?></option><option value="02" style="padding:5px"><?php echo $entry_loai2; ?></option><option value="03" style="padding:5px"><?php echo $entry_loai3; ?></option><!--<option value="04" style="padding:5px"><?php echo $entry_loai4; ?></option>--></select></td>';
											
		//<input style="width:80px" type="text" name="home_image[' + image_row + '][image_class]" value="" class="form-control" /></td>';
		
		html += '  <td class="text-right"><input style="width:40px" type="text" name="home_image[' + image_row + '][image_sort_order]" value="" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row' + image_row  + '\').remove(); $(\'.tooltip\').remove();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#images tbody').append(html);

		image_row++;
	}
</script>


<script type="text/javascript">
	/*Khong thay doi ten bien image_row*/
	var image_row_daidien = <?php echo $image_row_daidien; ?>;

	function addDaidien() {
		html  = '<tr id="image-row-daidien' + image_row_daidien + '">';
		html += '  <td class="text-left"><a href="" id="thumb-image-daidien' + image_row_daidien + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_daidien_1)) echo "view/image/image.png"; else echo $preview_daidien_1; ?>" alt="" title="" /><input type="hidden" name="home_daidien[' + image_row_daidien + '][image]" value="" id="input-image-daidien' + image_row_daidien + '" /></td>';
		
		html += '  <td class="text-left" ><a href="" id="thumb-image-daidien-1' + image_row_daidien + '"data-toggle="image" class="img-thumbnail"><img src="<?php if(empty($preview_daidien_2)) echo "view/image/image.png"; else echo $preview_daidien_2; ?>" alt="" title="" /><input type="hidden" name="home_daidien[' + image_row_daidien + '][image1]" value="" id="input-image-daidien-1' + image_row_daidien + '" /></td>';

		html += '<td class="text-center" style="width:40%;min-width:150px; "><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/vn.png" /></span><textarea name="home_daidien[' + image_row_daidien + '][image_name]" class="form-control" style="height:70px;resize:none;" cols="30" rows="3" ></textarea></div>';

		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/gb.png" /></span><textarea cols="30" rows="3" name="home_daidien[' + image_row_daidien + '][image_name_en]"  class="form-control" style="height:70px;resize:none;" ></textarea></div></td>';

		html += '  <td class="text-right"><input style="width:40px" type="text" name="home_daidien[' + image_row_daidien + '][image_sort_order]" value="" class="form-control" /></td>';
		html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="$(\'#image-row-daidien' + image_row_daidien  + '\').remove(); $(\'.tooltip\').remove();"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';

		$('#daidiens tbody').append(html);

		image_row_daidien++;
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
		$('#languagecanho a:first').tab('show');
		$('#languagetienich a:first').tab('show');
		$('#languagevitri a:first').tab('show');
		$('#language-seo a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>