<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right" <?php if($superadmin==false) echo 'style="display:none"';?>>
				<a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button  type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i></button>
                <a onclick="location = document.URL" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i> <lbl class="s-mobile"><?php echo $button_refresh; ?></lbl></a>
			</div>
			<h3><?php echo $heading_title_catealbum; ?></h3>
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
									<td class="text-center" width="1" <?php if($superadmin==false) echo 'style="display:none"';?>><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
									<td class="text-center" width="70px"><?php echo $column_sort_order; ?></td>
									<td class="text-left"><?php echo $column_name; ?></td>
									<td class="text-center"><?php echo $column_status; ?></td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($categories) { ?>
								<?php foreach ($categories as $category) { ?>
								<tr>
									<td class="text-center" <?php if($superadmin==false) echo 'style="display:none"';?>>
										<?php //if($category['parent_id']!=1) {?>
										<?php if ($category['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" />
										<?php } ?>
										<?php //}?>
									</td>
									<td class="text-center"><input type="text" onkeypress="return checkIt(event);" style="width:25px" class="sort_order text-center" categoryid="<?php echo $category['category_id'];?>" value="<?php echo $category['sort_order'];?>" /></td>
									<td class="text-left"><?php echo $category['name']; ?></td>
									<td class="text-center">
										<?php if ($category['status_id']==1): ?>
											<input type="checkbox" checked="checked" class="status" categoryid="<?php echo $category['category_id'];?>" data-status="<?php echo $category['status_id'] ?>">
										<?php else: ?>
											<input type="checkbox" class="status" categoryid="<?php echo $category['category_id'];?>" data-status="<?php echo $category['status_id'] ?>">
										<?php endif ?>
									</td>
									<td class="text-right"><?php foreach ($category['action'] as $action) { ?>
										<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td class="text-right" ><?php echo $text_no_results; ?></td>
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
		/*$(".sort_order").click(function(){
			var id = $(this).attr('categoryid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				console.log(sort_order)
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=category&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order + '&cate_type=catealbum' + '&isclick=1',
					dataType: 'text',
					success: function(data) {
						
					}
				});
			}else{
				$(this).val(0);
			}
		});*/
		
		$(".sort_order").blur(function(){
			var id = $(this).attr('categoryid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=category&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order + '&cate_type=catealbum',
					dataType: 'text',
					success: function(data) {
						//window.location = document.URL;
					}
				});
			}else{
				$(this).val(0);
			}
		});

		$("#filter_category").change(function(){
			url = 'index.php?route=catalog/category&token=<?php echo $token; ?>';
			var filter_category = $(this).val();

			url += '&filter_category=' + encodeURIComponent(filter_category);

			location = url;
		});
	});
	/*
	$(document).ready(function(){
		$(".ishome").on('click', function(){
			var id = $(this).attr('categoryid');
			var ishome = $(this).attr('data-ishome');
			if (ishome==1) {
				ishome = 0 ;
			} else {
				ishome = 1;
			}
			if(isNaN(ishome)===false) {
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=category&id=' + encodeURIComponent(id) + '&ishome=' + ishome,
					dataType: 'text',
					success: function(data) {

					}
				});
			}
		});
	});
*/
$(document).ready(function(){
	$(".status").on('click', function(){
		var id = $(this).attr('categoryid');
		var status = $(this).attr('data-status');
		if (status==1) {
			status = 0 ;
			$(this).attr('data-status',0);
		} else {
			status = 1;
			$(this).attr('data-status',1);
		}
		if(isNaN(status)===false) {
			$.ajax({
				url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
				type: 'POST',
				data: 't=category&id=' + encodeURIComponent(id) + '&status=' + status,
				dataType: 'text',
				success: function(data) {

				}
			});
		}
	});
});
</script>
</div>
<?php echo $footer; ?>