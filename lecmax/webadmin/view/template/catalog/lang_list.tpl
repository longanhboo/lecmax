<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right" <?php if($superadmin==false) echo 'style="display:none"';?>><a  onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i> <lbl class="s-mobile"><?php echo $button_delete; ?></lbl></button>
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
									<td class="text-center" width="1" style="<?php if(!$superadmin) echo 'display:none';?>"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="text-center" width="100px">
										<?php if ($sort == 'p.sort_order') { ?>
										<a href="<?php echo $sort_key; ?>" class="<?php echo strtolower($order); ?>"> <?php echo $column_key; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_key; ?>"> <?php echo $column_key; ?></a>
										<?php } ?>
									</td>
									<td class="text-left"><?php if ($sort == 'pd.name') { ?>
										<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
										<?php } ?>
									</td>
									<td class="text-center"><?php if ($sort == 'p.module') { ?>
										<a href="<?php echo $sort_module; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_module; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_module; ?>"><?php echo $column_module; ?></a>
										<?php } ?>
									</td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<tr class="filter">
									<td <?php if(!$superadmin) echo 'style="display:none"';?>></td>
									<td><input type="text" id="filter_key" name="filter_key" value="<?php echo $filter_key; ?>" class="form-control" /></td>
									<td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>" class="form-control" /></td>
									<td>
										<select id="filter_module" name="filter_module" class="form-control" style="min-width:150px;">
											<option value="*"></option>
											<?php foreach($modules as $item){?>
											<option value="<?php echo $item['name'];?>" <?php if($filter_module==$item['name']) echo ' selected="selected"';?>><?php echo $item['name'];?></option>
											<?php }?>
										</select>
										<input type="hidden" name="frontend" value="<?php echo $frontend;?>" id="frontend" />
									</td>
									<td class="text-right"><button onclick="filter();"  type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <lbl class="s-mobile"><?php echo $button_filter; ?></lbl></button></td>
								</tr>
								<?php if ($langs) { ?>
								<?php foreach ($langs as $lang) { ?>
								<tr>
									<td class="text-center;" <?php if(!$superadmin) echo 'style="display:none"';?>><?php if ($lang['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $lang['lang_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $lang['lang_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-left"><?php echo $lang['key']; ?></td>
									<td class="text-left"><?php echo $lang['name']; ?></td>
									<td class="text-center"><?php echo $lang['module']; ?></td>
									<td class="text-right"><?php foreach ($lang['action'] as $action) { ?>
										<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>"  class="btn btn-primary" ><i class="fa fa-pencil"></i> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function filter() {
			url = 'index.php?route=catalog/lang&token=<?php echo $token; ?>';

			var filter_name = $('#filter_name').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}

			var filter_key = $('#filter_key').val();

			if (filter_key) {
				url += '&filter_key=' + encodeURIComponent(filter_key);
			}

			var frontend = $('#frontend').val();

			if (frontend) {
				url += '&frontend=' + encodeURIComponent(frontend);
			}

			var filter_module = $('#filter_module').val();

			if (filter_module != '*') {
				url += '&filter_module=' + encodeURIComponent(filter_module);
			}

			location = url;
		}
	</script>
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
</div>
<?php echo $footer; ?>