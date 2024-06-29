<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right" style="display:none"><a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
				<button style="display:none" type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default" onclick="$('#form').attr('action', '<?php echo $copy; ?>').submit()"><i class="fa fa-copy"></i> <lbl class="s-mobile"><?php echo $button_copy; ?></lbl></button>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i> <lbl class="s-mobile"><?php echo $button_delete; ?></lbl></button>
                <a onclick="location = document.URL" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i> <lbl class="s-mobile"><?php echo $button_refresh; ?></lbl></a>
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
									<td class="text-center;" width="1" style="display:none"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="text-center" style="display:none" width="70px"><?php echo $column_sort_order; ?></td>
									<td class="text-left"><?php echo $column_name; ?></td>
									<td class="text-center" style="display:none"><?php echo $column_type; ?></td>
									<td class="text-center" style="display:none"><?php echo $column_mainmenu; ?></td>
									<td class="text-center" style="display:none"><?php echo $column_status; ?></td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($categories) { ?>
								<?php foreach ($categories as $category) { ?>
								<tr>
									<td class="text-center;" style="display:none">
										<?php if ($category['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-center" style="display:none"><input type="text" onkeypress="return checkIt(event);" style="width:25px" class="sort_order text-center" categoryid="<?php echo $category['category_id'];?>" value="<?php echo $category['sort_order'];?>" /></td>
									<td class="text-left"><?php echo $category['name']; ?></td>
									<td class="text-center" style="display:none"><?php echo $category['type']; ?></td>
									<td class="text-center" style="display:none"><?php echo $category['mainmenu']; ?></td>
									<td class="text-center" style="display:none">
										<?php if ($category['status_id']==1): ?>
											<input type="checkbox" checked="checked" class="status" categoryid="<?php echo $category['category_id'];?>" data-status="<?php echo $category['status_id'] ?>">
										<?php else: ?>
											<input type="checkbox" class="status" categoryid="<?php echo $category['category_id'];?>" data-status="<?php echo $category['status_id'] ?>">
										<?php endif ?>
									</td>
									<td class="text-right"><?php foreach ($category['action'] as $action) { ?>
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
		$('#button-filter').on('click', function() {
			var url = 'index.php?route=catalog/category&token=<?php echo $token; ?>';

			var filter_name = $('input[name=\'filter_name\']').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			var filter_model = $('input[name=\'filter_model\']').val();

			if (filter_model) {
				url += '&filter_model=' + encodeURIComponent(filter_model);
			}

			var filter_price = $('input[name=\'filter_price\']').val();

			if (filter_price) {
				url += '&filter_price=' + encodeURIComponent(filter_price);
			}

			var filter_quantity = $('input[name=\'filter_quantity\']').val();

			if (filter_quantity) {
				url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
			}

			var filter_status = $('select[name=\'filter_status\']').val();

			if (filter_status != '*') {
				url += '&filter_status=' + encodeURIComponent(filter_status);
			}

			location = url;
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
	<script type="text/javascript">
		$('input[name=\'filter_name\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'filter_name\']').val(item['label']);
			}
		});

		$('input[name=\'filter_model\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['model'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'filter_model\']').val(item['label']);
			}
		});
		$(document).ready(function(){
			$(".sort_order").click(function(){
				var id = $(this).attr('categoryid');
				var sort_order = $(this).val();
				if(isNaN(sort_order)===false)
				{
					$.ajax({
						url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
						type: 'POST',
						data: 't=category&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order + '&isclick=1',
						dataType: 'text',
						success: function(data) {
	
						}
					});
				}else{
					$(this).val(0);
				}
			});
			
			$(".sort_order").blur(function(){
				var id = $(this).attr('categoryid');
				var sort_order = $(this).val();
				if(isNaN(sort_order)===false)
				{
					$.ajax({
						url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
						type: 'POST',
						data: 't=category&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order,
						dataType: 'text',
						success: function(data) {
							window.location = document.URL;
						}
					});
				}else{
					$(this).val(0);
				}
			});
			
			
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
				console.log(status);
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