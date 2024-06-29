<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $heading_title; ?></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-sm-5">
					<a href="<?php echo $parent; ?>" data-toggle="tooltip" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a>
					<a href="<?php echo $refresh; ?>" data-toggle="tooltip" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
					<button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" id="button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
					<button type="button" data-toggle="tooltip" title="<?php echo $button_folder; ?>" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
                    <button type="button" data-toggle="tooltip" title="Đổi tên" id="button-rename" class="btn btn-default"><i class="fa fa-pencil"></i></button>
					<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
					<!--<button type="button" data-toggle="tooltip" title="<?php echo $button_insert ?>" id="multiple-insert" class="btn btn-success"><i class="fa fa-files-o"></i></button>-->
                    <button type="button" data-toggle="tooltip" title="Chọn danh sách hình trong editor." id="multiple-insert-editor" class="btn btn-success"><i class="fa fa-files-o"></i></button>
				</div>
				<div class="col-sm-7">
					<div class="input-group">
						<input type="text" name="search" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_search; ?>" class="form-control">
						<span class="input-group-btn">
							<button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-sm-5 breadcrumbs-file">
                <?php 
                	$str_path = '';
                    $breadcrumbs_list = '<a class="button-breadcrumbs" href="' . HTTP_SERVER . 'index.php?route=common/filemanager&token=' . $token . '&isnewspage=1">catalog</a> /';
                	if(isset($this->session->data['directory'])){
                    	$dir_temp = DIR_IMAGE . 'catalog/';
                        if($this->session->data['directory']==DIR_IMAGE . 'catalog'){
                        	$dir_temp = DIR_IMAGE . 'catalog';
                        }
                    	$arr_path = explode('/',str_replace($dir_temp,'',$this->session->data['directory']));
                        foreach($arr_path as $key=>$item){
                        	$str_path .= $item;
                            if($key<count($arr_path)-1){
                            	$str_path .= '/';
                            }
                        	$breadcrumbs_list .= ' <a class="button-breadcrumbs" href="' . HTTP_SERVER . 'index.php?route=common/filemanager&token=' . $token . '&isnewspage=1&directory=' . $str_path . '">' . $item . '</a>';
                            
                            if($key<count($arr_path)-1){
                            	$breadcrumbs_list .= ' /';
                            }
                        }
                    }
                ?>
					<?php echo $breadcrumbs_list;?>
				</div>
				
			</div>
			<hr />
			<?php $image_row=1; foreach (array_chunk($images, 6) as $image) { ?>
			<div class="row">
				<?php foreach ($image as $image) { ?>
				<div class="col-sm-2 text-center">
					<?php if ($image['type'] == 'directory') { ?>
					<div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
					<label>
						<input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" id="image-to-select" class="folder-to-select" />
						<a href="javascript:void(0);" class="href-to-select"><?php echo $image['name']; ?></a>
					</label>
					<?php } ?>
					<?php if ($image['type'] == 'image') { ?>
					<a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
					<label>
						<input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" id="image-to-select" />
						<a href="javascript:void(0);" class="href-to-select"><?php echo $image['name']; ?><br /><?php echo $image['size']; ?></a>
					</label>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<br />
			<?php } ?>
			<div id="upload-progress" class="hide" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgba(100, 100, 100, .8); z-index: 99999;">
				<table style="width: 80%; height: 100%; margin: auto;">
					<tr>
						<td style="vertical-align: middle;">
							<div class="progress">
								<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="modal-footer"><?php echo $pagination; ?></div>
	</div>
</div>
<!-- input Last Folder Remember -->

<script type="text/javascript">
	$('a.thumbnail').on('click', function(e) {
		e.preventDefault();

		<?php if ($thumb) : ?>
		$('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));<?php endif ?>

		<?php if ($target) : ?>
		$('#<?php echo $target; ?>').attr('value', $(this).parent().find('input').attr('value'));<?php else : ?>
		var range, sel = document.getSelection();
		
		//hoang
		var a_tempselections = window.tempselections;
		var a_temp1selections = window.temp1selections;
		
		if (a_tempselections) {
			var img = document.createElement('img');
			img.src = $(this).attr('href');
			img.alt = $(this).find('img').attr('title');

			range = a_temp1selections;
			range.insertNode(img);
		}
		//hoang

		/*if (sel.rangeCount) {
			var img = document.createElement('img');
			img.src = $(this).attr('href');
			img.alt = $(this).find('img').attr('title');

			range = sel.getRangeAt(0);
			range.insertNode(img);
		}*/
		<?php endif ?>

		$('#modal-image').modal('hide');
	});

	$('a.directory').on('click', function(e) {
		e.preventDefault();
    // Storing last folder into local storage
    localStorage.setItem('lastFolder', $(this).attr('href'));

    $('#modal-image').load($(this).attr('href'));
  });

	$('.pagination a').on('click', function(e) {
		e.preventDefault();
    // Storing last folder and page into local storage
    localStorage.setItem('lastFolder', $(this).attr('href'));


    $('#modal-image').load($(this).attr('href'));
  });

	$('#button-parent').on('click', function(e) {
		e.preventDefault();
    // Storing last folder into local storage
    localStorage.setItem('lastFolder', $(this).attr('href'));

    $('#modal-image').load($(this).attr('href'));
  });
  
  $('.button-breadcrumbs').on('click', function(e) {
		e.preventDefault();
    // Storing last folder into local storage
    localStorage.setItem('lastFolder', $(this).attr('href'));

    $('#modal-image').load($(this).attr('href'));
  });

	$('#button-refresh').on('click', function(e) {
		e.preventDefault();

		$('#modal-image').load($(this).attr('href'));
		return false;
	});

	$('input[name=\'search\']').on('keydown', function(e) {
		if (e.which == 13) {
			$('#button-search').trigger('click');
		}
	});

	$('#button-search').on('click', function(e) {
		var url = 'index.php?route=common/filemanager&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>&isnewspage=<?php echo $isnewspage; ?>';

		var filter_name = $('input[name=\'search\']').val();

		if (filter_name) {
			url += '&filter_name=' + encodeURIComponent(filter_name);
		}

		<?php if ($thumb) : ?>
		url += '&thumb=' + '<?php echo $thumb; ?>';<?php endif ?>

		<?php if ($target) : ?>
		url += '&target=' + '<?php echo $target; ?>';<?php endif ?>

		$('#modal-image').load(url);
	});
</script>

<script type="text/javascript">
	$('#button-upload').on('click', function () {
		$('#form-upload').remove();

		$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

		$('#form-upload input[name=\'file[]\']').trigger('click');
		
		if (typeof timer != 'undefined') {
			clearInterval(timer);
		}
		
		timer = setInterval(function () {
			if ($('#form-upload input[name=\'file[]\']').val() != '') {
				clearInterval(timer);

				$.ajax({
					url: 'index.php?route=common/filemanager/upload&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>&isnewspage=<?php echo $isnewspage; ?>',
					type: 'post',
					dataType: 'json',
					data: new FormData($('#form-upload')[0]),
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
						$('#button-upload').prop('disabled', true);
						$('#upload-progress').removeClass('hide');
					},
					complete: function () {
						$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
						$('#button-upload').prop('disabled', false);
						$('#upload-progress').addClass('hide');
					},
					success: function (json) {
						if (json['error']) {
							alert(json['error']);
						}

						if (json['success']) {
							alert(json['success']);

							setTimeout(function(){
							$('#button-refresh').trigger('click');
							},500);
							return false;
						}
					},
					xhr: function() {
						var xhr = new window.XMLHttpRequest();

						xhr.upload.addEventListener("progress", function(evt) {
							if (evt.lengthComputable) {
								var percentComplete = evt.loaded / evt.total;
								percentComplete = parseInt(percentComplete * 100);
								// console.log(percentComplete);
								$('.progress-bar').html(percentComplete + '%').attr('aria-valuenow', percentComplete).css('width', percentComplete + '%');
							}
						}, false);

						return xhr;
					},
					error: function (xhr, ajaxOptions, thrownError) {
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
	/*
	*/

	$('#button-folder').popover({
		html: true,
		placement: 'bottom',
		trigger: 'click',
		title: '<?php echo $entry_folder; ?>',
		content: function() {
			html  = '<div class="input-group">';
			html += '  <input type="text" name="folder" value="" placeholder="<?php echo $entry_folder; ?>" class="form-control">';
			html += '  <span class="input-group-btn"><button type="button" title="<?php echo $button_folder; ?>" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
			html += '</div>';

			return html;
		}
	});

	$('#button-folder').on('shown.bs.popover', function() {
		$('#button-create').on('click', function() {
			$.ajax({
				url: 'index.php?route=common/filemanager/folder&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>&isnewspage=<?php echo $isnewspage; ?>',
				type: 'post',
				dataType: 'json',
				data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
				beforeSend: function() {
					$('#button-create').prop('disabled', true);
				},
				complete: function() {
					$('#button-create').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	});
	
	
	//hoang
	$('#button-rename').popover({
		html: true,
		placement: 'bottom',
		trigger: 'click',
		title: 'Đổi tên',
		content: function() {
			html  = '<div class="input-group">';
			html += '  <input type="text" name="folder" value="" placeholder="Tên" class="form-control">';
			html += '  <span class="input-group-btn"><button type="button" title="Đổi tên" id="button-edit" class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>';
			html += '</div>';

			return html;
		}
	});

	$('#button-rename').on('shown.bs.popover', function() {
		$('#button-edit').on('click', function() {
			$.ajax({
				url: 'index.php?route=common/filemanager/renamefile&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>&isnewspage=<?php echo $isnewspage; ?>&name_new=' + encodeURIComponent($('input[name=\'folder\']').val()),
				type: 'post',
				dataType: 'json',
				data: $('input[name^=\'path\']:checked'),
				beforeSend: function() {
					$('#button-edit').prop('disabled', true);
				},
				complete: function() {
					$('#button-edit').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	});
	// end hoang

	$('#modal-image #button-delete').on('click', function(e) {
		if (confirm('<?php echo $text_confirm; ?>')) {
			$.ajax({
				url: 'index.php?route=common/filemanager/delete&token=<?php echo $token; ?>&isnewspage=<?php echo $isnewspage; ?>',
				type: 'post',
				dataType: 'json',
				data: $('input[name^=\'path\']:checked'),
				beforeSend: function() {
					$('#button-delete').prop('disabled', true);
				},
				complete: function() {
					$('#button-delete').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}

					if (json['success']) {
						alert(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	});
</script>

<script type="text/javascript">

$('.href-to-select').click(function() {
	if($(this).parent().find('input').is(":checked")){
		$(this).parent().find('input').prop('checked', false);
	}else{
		$(this).parent().find('input').prop('checked', true);
	}
});

$('#multiple-insert-editor').click(function() {
	var mess_folder = "<?php echo $text_error_insert_folder ?>";
		//check folder selected
		if ($('.folder-to-select:checked').length) {
			alert(mess_folder);
			$('.folder-to-select:checked').attr('checked', false);
			return false;
		}
		
		<?php if ($thumb) : ?>
		$('#image-to-select:checked').each(function(i){
			$('#<?php echo $thumb; ?>').find('img').attr('src', $(this).parent().parent().find('img').attr('src'));
		});

		<?php endif ?>

		<?php if ($target) : ?>
		$('#image-to-select:checked').each(function(i){
			$('#<?php echo $target; ?>').attr('value', $(this).parent().find('input').attr('value'));
		});
		<?php else : ?>
		$('#image-to-select:checked').each(function(i){
			//var thumb = $(this).parent().parent();
			//var thumb_image = $(this).parent().parent().find('a').attr('href');
			var range, sel = document.getSelection();
			
			//hoang
			var a_tempselections = window.tempselections;
			var a_temp1selections = window.temp1selections;
			
			if (a_tempselections) {
				var img = document.createElement('img');
				img.src = $(this).parent().parent().find('a').attr('href');
				img.alt = $(this).parent().parent().find('img').attr('title');
	
				range = a_temp1selections;
				range.insertNode(img);
			}
			//hoang
			
			
			/*if (sel.rangeCount) {
				var img = document.createElement('img');
				img.src = $(this).parent().parent().find('a').attr('href');
				img.alt = $(this).parent().parent().find('img').attr('title');
	
				range = sel.getRangeAt(0);
				range.insertNode(img);
			}*/
		});
		<?php endif ?>

		
		
		$('#modal-image').modal('hide');
});

</script>

<!-- Multiple images select and insert into product form  -->
<script type="text/javascript">
  // Green button - Insert images into form - default order
  var mess = "<?php echo $text_error_insert ?>";
  var mess_folder = "<?php echo $text_error_insert_folder ?>";
  var mess_select = "<?php echo $text_error_select ?>";
  var mess_second_type = "<?php echo $text_error_second_type ?>";

  <?php if($thumb) { ?>
  	var id = $('#<?php echo $thumb; ?>').attr('id');
  	var tab = 	$('#<?php echo $thumb; ?>').parent().parent().parent().parent().parent().parent().attr('id');
  	var img_row = $('#<?php echo $thumb; ?>').parent().parent().parent().attr('id');
  	var func = $('#<?php echo $thumb; ?>').parent().parent().parent().parent().find('tfoot button');
  	var types = id.split('-');
  	var type;
  	if (types[1].length>5) {
  		type = types[1].substring(5,6);
  	} else {
  		type = 0;
  	}
  	<?php } else { ?>
  		var tab = 'tab-image';
  		var img_row = 'image_row';
  		var func = 'addImage()';
  		var type = 0;
  		<?php } ?>
  //
  $('#multiple-insert').click(function() {
		//check folder selected
		if ($('.folder-to-select:checked').length) {
			alert(mess_folder);
			$('.folder-to-select:checked').attr('checked', false);
			return false;
		}

		if ($('.nav-tabs li a[href="#' + tab + '"]').parent().hasClass('active').length < 1) {
  		//check image selected
  		alert(mess);
  		$('.folder-to-select:checked').attr('checked', false);
  		$('#image-to-select:checked').attr('checked', false);
  		return false;
  	}

  	if ($('#'+img_row + ' tr:last-child').attr('id') == undefined) {
			//check image selected
			if ($('#image-to-select:checked').length>1) {
				alert(mess_select);
				$('#image-to-select:checked').attr('checked', false);
				return false;
			}
		}
		// 2nd column image (cannot use this function for 2nd column image)
		if (type > 0) {
			alert(mess_second_type);
			return false;
		}

		var row;
		var images = [];
		var thumbs = [];

		$('#image-to-select:checked').each(function(i){
			var thumb = $(this).parent().parent();
			var thumb_image = $(this).parent().parent().find('a').attr('href');
			var httpserver = $('#footer a').attr('href');
			thumb_image = thumb_image.replace(httpserver+'pictures/', '');

			thumbs[i] = thumb_image;
			$(this).attr('checked', false);

			images[i] = thumb.find('img').attr('src');
			$(this).attr('checked', false);
		});

		var len = ($('#'+img_row + ' tr:last-child').attr('id')).length;
		for(var i = 0; i < images.length; i++) {
			row = $('#'+img_row + ' tr:last-child').attr('id').substr(len-1);
			$('#input-image-' + img_row + row).val(thumbs[i]);
			$('#thumb-image-' + img_row + row + ' img').attr('src',images[i]).css('max-width', '100px');
			if (i < images.length-1) {
				func.trigger('click');
			}
		}

		$('#modal-image').modal('hide');
	})

  // Adding images while choosing main image
  $(document).ready(function() {

  	$(document).on('click', '#select-main', function () {

  		var main_image = $(this).parent().find('input').val();
  		// console.log(main_image);

      // Getting checked images
      var images = [];
      $('#image-to-select:checked').each(function(i){
      	images[i] = $(this).val();
      });

      // Remove main image from array of checked ones
      var index = images.indexOf(main_image);
      if (index > -1) {
      	images.splice(index, 1);
      }
      // console.log(images + images.length)
      // Adding main image into form
      // $('#input-image').val(main_image);
      // $('#thumb-image img').attr('src', <?php HTTP_IMAGE ?> + main_image).css('max-width', '100px');


  		// Additional images to form
  		if(images.length == 1) {
  			addImage();
  			$('#input-image0').val(images[0]);
  			$('#thumb-image0' + ' img').attr('src', <?php HTTP_IMAGE ?> + images[0]).css('max-width', '100px');

  		} else {
  			for(var i = 0; i <= images.length-1; i++) {

  				addImage();
  				$('#input-image' + i).val(images[i]);
  				$('#thumb-image' + i + ' img').attr('src', <?php HTTP_IMAGE ?> + images[i]).css('max-width', '100px');
  			}
  		}

  		$('#modal-image').modal('hide');

  	});
		/*
		*/
	});
	/*
	*/
</script>
