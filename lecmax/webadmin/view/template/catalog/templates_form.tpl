<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
		<?php if (isset($success) && $success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option;?></a></li>
					</ul>
					<div class="tab-content">
						<!-- tab-general -->
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

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="category_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>

								</div>
								<?php } ?>

							</div>

						</div>

						<!-- tab-data -->
						<div class="tab-pane" id="tab-data">

							<div class="form-group">
								<label class="col-sm-2 control-label">
									<span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
								</label>
								<div class="col-sm-10">
									<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
										<img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
									</a>
									<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
									<div class="checkbox">
										<label>
											<input type="checkbox" name="delete_image" value="1" /> <?php echo $entry_delete_image;?>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group" style="display:none">
								<label class="col-sm-2 control-label">
									<span data-toggle="tooltip" title="<?php echo $help_image_video; ?>" ><?php echo $entry_image_video;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_image_video ?></p>
								</label>
								<div class="col-sm-10">
									<a href="" id="thumb-image_video" data-toggle="image" class="img-thumbnail">
										<img src="<?php echo $preview_video; ?>" alt="" title="" data-placeholder="<?php echo $image_video; ?>" />
									</a>
									<input type="hidden" name="image" value="<?php echo $image_video; ?>" id="input-image_video" />
									<div class="checkbox">
										<label>
											<input type="checkbox" name="delete_image_video" value="1" /> <?php echo $entry_delete_image;?>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="isftp"><?php echo $entry_upload_ftp;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($isftp == "1") {?>
											<input id="isftp" value="1" type="checkbox" name="isftp" checked="checked" />
											<?php } else {?>
											<input id="isftp" value="1" type="checkbox" name="isftp"/>
											<?php }?>
										</label>
									</div>

								</div>
							</div>

							<div class="form-group display_upload required">
								<label class="col-sm-2 control-label">
									<span data-toggle="tooltip" title="<?php echo $help_file_mp4;?>"><?php echo $entry_file_mp4;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_mp4 ?></p>
								</label>
								<div class="col-sm-10">
									<input type="file" name="video_mp4" value=""/>
									<input type="hidden" name="video_mp4_old" value="<?php echo $filename_mp4;?>" />
									<span class="help"><?php echo $filename_mp4; ?></span>
									<?php if ($error_video_mp4) { ?>
									<div class="text-danger"><?php echo $error_video_mp4; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group required" style="display:none">
								<label class="col-sm-2 control-label">
									<span data-toggle="tooltip" title="<?php echo $help_file_webm;?>"><?php echo $entry_file_webm;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_webm ?></p>
								</label>
								<div class="col-sm-10">
									<input type="file" name="video_webm" value="" />
									<input type="hidden" name="video_webm_old" value="<?php echo $filename_webm;?>" />
									<br/>
									<span class="help"><?php echo $filename_webm; ?></span>
									<?php if ($error_video_webm) { ?>
									<div class="text-danger"><?php echo $error_video_webm; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group display_ftp" style="display:none" >
								<label class="col-sm-2 control-label" for="file_mp4_ftp">
									<span data-toggle="tooltip" title="<?php echo $help_file_mp4_ftp;?>"><?php echo $entry_file_mp4_ftp;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_mp4_ftp ?></p>
								</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="file_mp4_ftp" id="file_mp4_ftp" value="<?php echo $file_mp4_ftp;?>" />
									<?php if ($error_file_mp4_ftp) { ?>
									<div class="text-danger"><?php echo $error_file_mp4_ftp; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group" style="display:none">
								<label class="col-sm-2 control-label" for="file_webm_ftp">
									<span data-toggle="tooltip" title="<?php echo $help_file_webm_ftp;?>"><?php echo $entry_file_webm_ftp;?></span><br/>
									<p class="s-mobile s-mobile-help"><?php echo $help_file_webm_ftp ?></p>
								</label>
								<div class="col-sm-10">
									<input type="text"  class="form-control" name="file_webm_ftp" value="<?php echo $file_webm_ftp;?>" />
									<?php if ($error_file_webm_ftp) { ?>
									<div class="text-danger"><?php echo $error_file_webm_ftp; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
								<div class="col-sm-10">
									<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" id="input-sort-order" class="form-control" />
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

						<!-- tab-option -->
						<div class="tab-pane " id="tab-option">

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_option_image; ?></label>
								<div class="col-sm-1">
									<div class="checkbox">
										<label>
											<?php if($option_image==1){?>
											<input checked="checked" type="checkbox" name="option_image" value="1" />
											<?php }else{?>
											<input type="checkbox" name="option_image" value="1" />
											<?php }?>
										</label>
									</div>
								</div>
								<div class="col-sm-9">
									<input type="text" name="help_image" value="<?php echo $help_image;?>" class="form-control" />
									<?php if (isset($error_help_image) && !empty($error_help_image)) { ?>
									<div class="text-danger"><?php echo $error_help_image; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_option_images; ?></label>
								<div class="col-sm-1">
									<div class="checkbox">
										<label>
											<?php if($option_images==1){?>
											<input checked="checked" type="checkbox" name="option_images" value="1" />
											<?php }else{?>
											<input type="checkbox" name="option_images" value="1" />
											<?php }?>
										</label>
									</div>
								</div>
								<div class="col-sm-9">
									<input type="text" name="help_image_1" value="<?php echo $help_image_1;?>" class="form-control" />
									<?php if (isset($error_help_image_1) && !empty($error_help_image_1)) { ?>
									<div class="text-danger"><?php echo $error_help_image_1; ?></div>
									<?php } ?>
									<br/>
									<input type="text" name="help_image_2" value="<?php echo $help_image_2;?>" class="form-control" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_option_download; ?></label>
								<div class="col-sm-1">
									<div class="checkbox">
										<label>
											<?php if($option_download==1){?>
											<input checked="checked" type="checkbox" name="option_download" value="1" />
											<?php }else{?>
											<input type="checkbox" name="option_download" value="1" />
											<?php }?>
										</label>
									</div>
								</div>
								<div class="col-sm-9">
									<select name="module_download" class="form-control">
										<option value=""></option>
										<?php foreach($modules as $item){?>
										<option <?php  if($module_download==$item['path']) echo 'selected="selected"';?> value="<?php echo $item['path'];?>"><?php echo $item['name'];?></option>
										<?php }?>
									</select>
									<?php if (isset($error_module_download) && !empty($error_module_download)) { ?>
									<div class="text-danger"><?php echo $error_module_download; ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_option_video; ?></label>
								<div class="col-sm-1">
									<div class="checkbox">
										<label>
											<?php if($option_video==1){?>
											<input checked="checked" type="checkbox" name="option_video" value="1" />
											<?php }else{?>
											<input type="checkbox" name="option_video" value="1" />
											<?php }?>
										</label>
									</div>
								</div>
								<div class="col-sm-9">
									<select name="module_video" class="form-control">
										<option value=""></option>
										<?php foreach($modules as $item){?>
										<option <?php  if($module_video==$item['path']) echo 'selected="selected"';?> value="<?php echo $item['path'];?>"><?php echo $item['name'];?></option>
										<?php }?>
									</select>
									<?php if (isset($error_module_video) && !empty($error_module_video)) { ?>
									<div class="text-danger"><?php echo $error_module_video; ?></div>
									<?php } ?>
								</div>
							</div>

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
	<script type="text/javascript">
		$('#language a:first').tab('show');
		$('#language-seo a').tab('show');
		$('#option a:first').tab('show');
	</script>
	<script>
		$(document).ready(function() {
			if($("#isftp:checked").val()=='1')
			{
				$(".display_ftp").show();
				$(".display_upload").hide();
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
		});
	</script>
	<script type="text/javascript">
		var step = new Array();
		var total = 0;

		$('#button-upload').on('click', function() {
			$('#form-upload').remove();

			$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

			$('#form-upload input[name=\'file\']').trigger('click');

			if (typeof timer != 'undefined') {
				clearInterval(timer);
			}

			timer = setInterval(function() {
				if ($('#form-upload input[name=\'file\']').val() != '') {
					clearInterval(timer);

					// Reset everything
					$('.alert').remove();
					$('#progress-bar').css('width', '0%');
					$('#progress-bar').removeClass('progress-bar-danger progress-bar-success');
					$('#progress-text').html('');

					$.ajax({
						url: 'index.php?route=extension/installer/upload&token=<?php echo $token; ?>',
						type: 'post',
						dataType: 'json',
						data: new FormData($('#form-upload')[0]),
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function() {
							$('#button-upload').button('loading');
						},
						complete: function() {
							$('#button-upload').button('reset');
						},
						success: function(json) {
							if (json['error']) {
								$('#progress-bar').addClass('progress-bar-danger');
								$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
							}

							if (json['step']) {
								step = json['step'];
								total = step.length;

								if (json['overwrite'].length) {
									html = '';

									for (i = 0; i < json['overwrite'].length; i++) {
										html += json['overwrite'][i] + "\n";
									}

									$('#overwrite').html(html);

									$('#button-continue').prop('disabled', false);
								} else {
									next();
								}
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
					/*
					*/
				}
			}, 500);
			/*
			*/
		});

$('#button-continue').on('click', function() {
	next();

	$('#button-continue').prop('disabled', true);
});

function next() {
	data = step.shift();

	if (data) {
		$('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');
		$('#progress-text').html('<span class="text-info">' + data['text'] + '</span>');

		$.ajax({
			url: data.url,
			type: 'post',
			dataType: 'json',
			data: 'path=' + data.path,
			success: function(json) {
				if (json['error']) {
					$('#progress-bar').addClass('progress-bar-danger');
					$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
					$('#button-clear').prop('disabled', false);
				}

				if (json['success']) {
					$('#progress-bar').addClass('progress-bar-success');
					$('#progress-text').html('<span class="text-success">' + json['success'] + '</span>');
				}

				if (!json['error'] && !json['success']) {
					next();
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$('#button-clear').bind('click', function() {
	$.ajax({
		url: 'index.php?route=extension/installer/clear&token=<?php echo $token; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-clear').button('loading');
		},
		complete: function() {
			$('#button-clear').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#button-clear').prop('disabled', true);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
</script>
</div>

<?php echo $footer; ?>