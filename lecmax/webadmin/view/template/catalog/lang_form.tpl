<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="$('#form').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <lbl class="s-mobile"><?php echo $button_cancel; ?></lbl></a>
			</div>
			<h3><?php echo $heading_title; ?></h3>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="pull-right"><a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
			<button  type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i></button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
					<input name="frontend" value="<?php echo $frontend;?>" type="hidden" />
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">

								<div class="form-group">
									<label  class="col-sm-2 control-label" for="key"><?php echo $entry_key; ?></label>
									<div class="col-sm-10">
										<?php if($superadmin){?>
										<input type="text" id="key" name="key" value="<?php echo $key; ?>" class="form-control" />
										<?php }else{?>
										<input readonly="readonly" id="key" type="text" name="key" value="<?php echo $key; ?>" class="form-control" />
										<?php }?>

										<?php if (isset($error_key) && !empty($error_key)) { ?>
										<div class="text-danger"><?php echo $error_key; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group" <?php if(!$superadmin) echo 'style="display:none"';?>>
									<label  class="col-sm-2 control-label" for="key"><?php echo $entry_module; ?></label>
									<div class="col-sm-10">
										<select name="module"  class="form-control">
											<option value=""></option>
											<?php foreach($modules as $item){?>
											<option value="<?php echo $item['name']; ?>" <?php if($module==$item['name']) echo 'selected="selected"';?> ><?php echo $item['name']; ?></option>
											<?php }?>
										</select>
										<?php if (isset($error_module) && !empty($error_module)) { ?>
										<div class="text-danger"><?php echo $error_module; ?></div>
										<?php } ?>
									</div>
								</div>

								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
									<div class="form-group required">
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<textarea class="form-control"  name="lang_description[<?php echo $language['language_id']; ?>][name]" ><?php echo isset($lang_description[$language['language_id']]) ? $lang_description[$language['language_id']]['name'] : ''; ?></textarea>
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
								</div>
								<?php } ?>

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
	<script type="text/javascript">
		$('#language a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>