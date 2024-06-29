<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-contact" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
		<?php if (isset($success) && $success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
					<div class="tab-content">
						<!-- logo -->
						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_logo;?>"><?php echo $entry_logo;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_logo ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-logo" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_logo)) echo 'view/image/image.png'; else echo $preview_logo; ?>" alt="" title="" data-placeholder="<?php echo $image_logo; ?>" />
									</a>
									<input type="hidden" name="image_logo" value="<?php echo $image_logo; ?>" id="input-image-logo" />
								</label>
								<label class="radio-inline" >
									<input type="checkbox" name="image_delete_logo" value="1" <?php if($image_delete_logo==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_logo;?>"><?php echo $entry_logo_en;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_logo ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-logo-en" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_logo_en)) echo 'view/image/image.png'; else echo $preview_logo_en; ?>" alt="" title="" data-placeholder="<?php echo $image_logo_en; ?>" />
									</a>
									<input type="hidden" name="image_logo_en" value="<?php echo $image_logo_en; ?>" id="input-image-logo-en" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_logo_en" value="1" <?php if($image_delete_logo_en==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<!-- slogan -->
						<div class="form-group " style="display:none" >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_slogan;?>"><?php echo $entry_slogan;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_slogan ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-slogan" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_slogan)) echo 'view/image/image.png'; else echo $preview_slogan; ?>" alt="" title="" data-placeholder="<?php echo $image_slogan; ?>" />
									</a>
									<input type="hidden" name="image_slogan" value="<?php echo $image_slogan; ?>" id="input-image-slogan" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_slogan" value="1" <?php if($image_delete_slogan==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<div class="form-group" style="display:none"  >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_slogan;?>"><?php echo $entry_slogan_en;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_slogan ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-slogan-en" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_slogan_en)) echo 'view/image/image.png'; else echo $preview_slogan_en; ?>" alt="" title="" data-placeholder="<?php echo $image_slogan_en; ?>" />
									</a>
									<input type="hidden" name="image_slogan_en" value="<?php echo $image_slogan_en; ?>" id="input-image-slogan-en" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_slogan_en" value="1" <?php if($image_delete_slogan_en==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<!-- popup -->

						<div class="form-group"  >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_entry_popup;?>"><?php echo $entry_popup;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_entry_popup ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-popup" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_popup)) echo 'view/image/image.png'; else echo $preview_popup; ?>" alt="" title="" data-placeholder="<?php echo $image_popup; ?>" />
									</a>
									<input type="hidden" name="image_popup" value="<?php echo $image_popup; ?>" id="input-image-popup" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_popup" value="1" <?php if($image_delete_popup==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<div class="form-group"  >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_entry_popup;?>"><?php echo $entry_popup_en;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_entry_popup ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-popup-en" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_popup_en)) echo 'view/image/image.png'; else echo $preview_popup_en; ?>" alt="" title="" data-placeholder="<?php echo $image_popup_en; ?>" />
									</a>
									<input type="hidden" name="image_popup_en" value="<?php echo $image_popup_en; ?>" id="input-image-popup-en" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_popup_en" value="1" <?php if($image_delete_popup_en==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<!-- link_popup -->
						<div class="form-group"  >
							<label class="col-sm-2 control-label" for="config_link_popup"><?php echo $entry_link_popup ?> (VN)</label>
							<div class="col-sm-10">
								<input class="form-control" id="config_link_popup" type="text" name="config_link_popup" value="<?php echo $config_link_popup ?>" />
							</div>
						</div>
                        
                        <div class="form-group"  >
							<label class="col-sm-2 control-label" for="config_link_popup_en"><?php echo $entry_link_popup ?> (EN)</label>
							<div class="col-sm-10">
								<input class="form-control" id="config_link_popup_en" type="text" name="config_link_popup_en" value="<?php echo $config_link_popup_en ?>" />
							</div>
						</div>
                        
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_shareholder"><?php echo $entry_link_shareholder ?></label>
							<div class="col-sm-10">
								<input class="form-control" id="config_link_shareholder" type="text" name="config_link_shareholder" value="<?php echo $config_link_shareholder ?>" />
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_realtimetable"><?php echo $entry_link_realtimetable ?></label>
							<div class="col-sm-10">
								<input class="form-control" id="config_link_realtimetable" type="text" name="config_link_realtimetable" value="<?php echo $config_link_realtimetable ?>" />
							</div>
						</div>
                        
                        
						<!-- slogan (text) -->
						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_slogan"><?php echo $entry_link_slogan ?></label>
							<div class="col-sm-10">
								<input class="form-control" id="config_slogan" type="text" name="config_slogan" value="<?php echo $config_slogan ?>" />
							</div>
						</div>

						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_slogan_en"><?php echo $entry_link_slogan_en ?></label>
							<div class="col-sm-10">
								<input class="form-control" id="config_slogan_en" type="text" name="config_slogan_en" value="<?php echo $config_slogan_en ?>" />
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_360">Link VR-360</label>
							<div class="col-sm-10">
								<input class="form-control" id="config_link_360" type="text" name="config_link_360" value="<?php echo $config_link_360 ?>" />
							</div>
						</div>
                        
                        <!-- hotline -->
						<div class="form-group"  >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_image_hotline;?>"><?php echo $entry_image_hotline;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_image_hotline ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-hotline" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_hotline)) echo 'view/image/image.png'; else echo $preview_hotline; ?>" alt="" title="" data-placeholder="<?php echo $image_hotline; ?>" />
									</a>
									<input type="hidden" name="image_hotline" value="<?php echo $image_hotline; ?>" id="input-image-hotline" />
								</label>
								<label class="radio-inline" style="display:none">
									<input type="checkbox" name="image_delete_hotline" value="1" <?php if($image_delete_hotline==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>

						<div class="form-group"  >
							<label class="col-sm-2 control-label" >
								<span data-toggle="tooltip" title="<?php echo $help_image_hotline_en;?>"><?php echo $entry_image_hotline_en;?></span><br/>
								<p class="s-mobile s-mobile-help"><?php echo $help_image_hotline_en ?></p>
							</label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<a href="" id="thumb-image-hotline-en" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview_hotline_en)) echo 'view/image/image.png'; else echo $preview_hotline_en; ?>" alt="" title="" data-placeholder="<?php echo $image_hotline_en; ?>" />
									</a>
									<input type="hidden" name="image_hotline_en" value="<?php echo $image_hotline_en; ?>" id="input-image-hotline-en" />
								</label>
								<label class="radio-inline">
									<input type="checkbox" name="image_delete_hotline_en" value="1" <?php if($image_delete_hotline_en==1) echo 'checked="checked"';?> /> <?php echo $entry_delete_image;?>
								</label>
							</div>
						</div>
                        
                        <!-- hotline -->
                        <div class="form-group"  >
							<label class="col-sm-2 control-label" for="config_hotline"><?php echo $entry_hotline ?> 01 </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_hotline" type="text" name="config_hotline" value="<?php echo $config_hotline ?>" />
							</div>
						</div>
                        
                        <div class="form-group"  >
							<label class="col-sm-2 control-label" for="config_hotline1"><?php echo $entry_hotline ?> 02</label>
							<div class="col-sm-10">
								<input class="form-control" id="config_hotline1" type="text" name="config_hotline1" value="<?php echo $config_hotline1 ?>" />
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_email_contact_info"><?php echo $entry_email_contact ?> </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_email_contact_info" type="text" name="config_email_contact_info" value="<?php echo $config_email_contact_info ?>" />
							</div>
						</div>
                        
                        <!-- time -->
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_picture">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_tin_trangchu; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_picture" type="text" name="config_loop_picture" value="<?php echo $config_loop_picture ?>" />
                                <?php if (isset($error_loop_picture) && !empty($error_loop_picture)) { ?>
                                <div class="text-danger"><?php echo $error_loop_picture; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_home_nhamau">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_nhamau_trangchu; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_home_nhamau" type="text" name="config_loop_home_nhamau" value="<?php echo $config_loop_home_nhamau ?>" />
                                <?php if (isset($error_loop_home_nhamau) && !empty($error_loop_home_nhamau)) { ?>
                                <div class="text-danger"><?php echo $error_loop_home_nhamau; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_about_album">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_about_album; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_about_album" type="text" name="config_loop_about_album" value="<?php echo $config_loop_about_album ?>" />
                                <?php if (isset($error_loop_about_album) && !empty($error_loop_about_album)) { ?>
                                <div class="text-danger"><?php echo $error_loop_about_album; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_about_video">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_about_video; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_about_video" type="text" name="config_loop_about_video" value="<?php echo $config_loop_about_video ?>" />
                                <?php if (isset($error_loop_about_video) && !empty($error_loop_about_video)) { ?>
                                <div class="text-danger"><?php echo $error_loop_about_video; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        
                        <!--du an-->
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_project_tongquan">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_project_tongquan; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_project_tongquan" type="text" name="config_loop_project_tongquan" value="<?php echo $config_loop_project_tongquan ?>" />
                                <?php if (isset($error_loop_project_tongquan) && !empty($error_loop_project_tongquan)) { ?>
                                <div class="text-danger"><?php echo $error_loop_project_tongquan; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_project_quymo">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_project_quymo; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_project_quymo" type="text" name="config_loop_project_quymo" value="<?php echo $config_loop_project_quymo ?>" />
                                <?php if (isset($error_loop_project_quymo) && !empty($error_loop_project_quymo)) { ?>
                                <div class="text-danger"><?php echo $error_loop_project_quymo; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_project_tienich">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_project_tienich; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_project_tienich" type="text" name="config_loop_project_tienich" value="<?php echo $config_loop_project_tienich ?>" />
                                <?php if (isset($error_loop_project_tienich) && !empty($error_loop_project_tienich)) { ?>
                                <div class="text-danger"><?php echo $error_loop_project_tienich; ?></div>
                                <?php } ?>
							</div>
						</div>
                         
                        
                        <!--nha mau-->
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_house_model">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_house_model; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_house_model" type="text" name="config_loop_house_model" value="<?php echo $config_loop_house_model ?>" />
                                <?php if (isset($error_loop_house_model) && !empty($error_loop_house_model)) { ?>
                                <div class="text-danger"><?php echo $error_loop_house_model; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <!--thu vien-->
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_library_album">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_library_album; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_library_album" type="text" name="config_loop_library_album" value="<?php echo $config_loop_library_album ?>" />
                                <?php if (isset($error_loop_library_album) && !empty($error_loop_library_album)) { ?>
                                <div class="text-danger"><?php echo $error_loop_library_album; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_library_video">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_library_video; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_library_video" type="text" name="config_loop_library_video" value="<?php echo $config_loop_library_video ?>" />
                                <?php if (isset($error_loop_library_video) && !empty($error_loop_library_video)) { ?>
                                <div class="text-danger"><?php echo $error_loop_library_video; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_library_brochure">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_library_brochure; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_library_brochure" type="text" name="config_loop_library_brochure" value="<?php echo $config_loop_library_brochure ?>" />
                                <?php if (isset($error_loop_library_brochure) && !empty($error_loop_library_brochure)) { ?>
                                <div class="text-danger"><?php echo $error_loop_library_brochure; ?></div>
                                <?php } ?>
							</div>
						</div>
                        
                        <div class="form-group required" style="display:none" >
							<label class="col-sm-2 control-label" for="config_loop_library_phaply">
                            <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_loop_library_phaply; ?></span><br/>
                			<p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                            </label>
							<div class="col-sm-10">
								<input class="form-control" id="config_loop_library_phaply" type="text" name="config_loop_library_phaply" value="<?php echo $config_loop_library_phaply ?>" />
                                <?php if (isset($error_loop_library_phaply) && !empty($error_loop_library_phaply)) { ?>
                                <div class="text-danger"><?php echo $error_loop_library_phaply; ?></div>
                                <?php } ?>
							</div>
						</div>
                        

					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php echo $footer; ?>