<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
				<button style="display:none" type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default" onclick="$('#form').attr('action', '<?php echo $copy; ?>').submit()"><i class="fa fa-copy"></i> <lbl class="s-mobile"><?php echo $button_copy; ?></lbl></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i> <lbl class="s-mobile"><?php echo $button_delete; ?></lbl></button>
			</div>
			<h3><?php echo $heading_title; ?></h3>
			<ul class="breadcrumb" style="display:none">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-center" width="1" ><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
									<td class="text-center asc" width="70px"><?php echo $column_sort_order; ?></td>
									<td class="text-left"><?php echo $column_name; ?></td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($categories) { ?>
								<?php foreach ($categories as $adminmenu) { ?>
								<tr>
									<td class="text-center">
										<?php //if($adminmenu['parent_id']!=1) {?>
										<?php if ($adminmenu['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $adminmenu['adminmenu_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $adminmenu['adminmenu_id']; ?>" />
										<?php } ?>
										<?php //}?>
									</td>
									<td class="text-center"><input type="text" onkeypress="return checkIt(event);" style="width:25px" class="sort_order text-center" categoryid="<?php echo $adminmenu['adminmenu_id'];?>" value="<?php echo $adminmenu['sort_order'];?>" /></td>
									<td class="text-left"><?php echo $adminmenu['name']; ?></td>
									<td class="text-right"><?php foreach ($adminmenu['action'] as $action) { ?>
										<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>"  class="btn btn-primary" ><i class="fa fa-pencil"></i> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('#form input').keydown(function(e) {
			if (e.keyCode == 13) {
				filter();
			}
		});
	</script>
	<script type="text/javascript">
		function checkIt(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				//status = "This field accepts numbers only."
				return false;
			}
			//status = ""
			return true;
		}
	</script>

	<script>
		$(document).ready(function(){
			$(".sort_order").blur(function(){
				var id = $(this).attr('categoryid');
				var sort_order = $(this).val();
				if(isNaN(sort_order)===false){
					$.ajax({
						url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
						type: 'POST',
						data: 't=adminmenu&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order,
						dataType: 'text',
						success: function(data) {

						}
					});
				}else{
					$(this).val(0);
				}
			});

			$("#filter_adminmenu").change(function(){
				url = 'index.php?route=catalog/adminmenu&token=<?php echo $token; ?>';
				var filter_adminmenu = $(this).val();

				url += '&filter_adminmenu=' + encodeURIComponent(filter_adminmenu);

				location = url;
			});
		});
	</script>
</div>
<?php echo $footer; ?>