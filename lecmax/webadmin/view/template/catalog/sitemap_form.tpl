<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-sitemap" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
			<div class="panel-body ">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sitemap" class="form-horizontal">
					<div class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td>Change frequencies / Priorities</td>
								<td style="text-align:right; ">
									<?php foreach ($list_modules as $permission) { ?>
									<span style="color:#000; line-height:20px" ><?php echo $permission['name'];?></span><br /><br />
									<?php }?>
								</td>
								<td  style="width:150px;">
									<?php foreach ($list_modules as $permission) { ?>
									<input type="hidden" value="<?php echo $permission['sitemap_id'];?>" name="cf_id[]" />
									<select name="cf_name[]" style="width:150px;">
										<option <?php if($permission['frequencies']=='always') echo 'selected="selected"';?> value="always">Always</option>
										<option <?php if($permission['frequencies']=='hourly') echo 'selected="selected"';?> value="hourly">Hourly</option>
										<option <?php if($permission['frequencies']=='daily') echo 'selected="selected"';?> value="daily">Daily</option>
										<option <?php if($permission['frequencies']=='weekly') echo 'selected="selected"';?> value="weekly">Weekly</option>
										<option <?php if($permission['frequencies']=='monthly') echo 'selected="selected"';?> value="monthly">Monthly</option>
										<option <?php if($permission['frequencies']=='yearly') echo 'selected="selected"';?> value="yearly">Yearly</option>
										<option <?php if($permission['frequencies']=='never') echo 'selected="selected"';?> value="never">Never</option>
									</select><br /><br />
									<?php }?>
								</td>
								<td  style="width:50%;">
									<?php foreach ($list_modules as $permission) { ?>
									<select name="cf_priority[]" style="width:150px; ">
										<option <?php if($permission['priority']=='0.0') echo 'selected="selected"';?> value="0.0">0.0</option>
										<option <?php if($permission['priority']=='0.1') echo 'selected="selected"';?> value="0.1">0.1</option>
										<option <?php if($permission['priority']=='0.2') echo 'selected="selected"';?> value="0.2">0.2</option>
										<option <?php if($permission['priority']=='0.3') echo 'selected="selected"';?> value="0.3">0.3</option>
										<option <?php if($permission['priority']=='0.4') echo 'selected="selected"';?> value="0.4">0.4</option>
										<option <?php if($permission['priority']=='0.5') echo 'selected="selected"';?> value="0.5">0.5</option>
										<option <?php if($permission['priority']=='0.6') echo 'selected="selected"';?> value="0.6">0.6</option>
										<option <?php if($permission['priority']=='0.7') echo 'selected="selected"';?> value="0.7">0.7</option>
										<option <?php if($permission['priority']=='0.8') echo 'selected="selected"';?> value="0.8">0.8</option>
										<option <?php if($permission['priority']=='0.9') echo 'selected="selected"';?> value="0.9">0.9</option>
										<option <?php if($permission['priority']=='1.0') echo 'selected="selected"';?> value="1.0">1.0</option>
									</select><br /><br />
									<?php }?>
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		<?php foreach ($languages as $language) { ?>
			$('#input-description<?php echo $language['language_id']; ?>').summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				}
			});
			<?php } ?>
		//
	</script>
	<!--{VIEW_SCRIPT}-->
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