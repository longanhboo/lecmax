<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
				<button style="display:none" type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default" onclick="$('#form').attr('action', '<?php echo $copy; ?>').submit()"><i class="fa fa-copy"></i> <lbl class="s-mobile"><?php echo $button_copy; ?></lbl></button>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form').submit();"><i class="fa fa-trash-o"></i> <lbl class="s-mobile"><?php echo $button_delete; ?></lbl></button>
                <a onclick="location = document.URL" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i> <lbl class="s-mobile"><?php echo $button_refresh; ?></lbl></a>
                <!--{BUTTON_BACK}-->
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
		<?php if ($success && isset($success)) { ?>
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
									<td class="text-center"  width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
									<td class="text-center"  width="70px">
										<?php if ($sort == 'p.sort_order') { ?>
										<a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"> <?php echo $column_stt; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_order; ?>"> <?php echo $column_stt; ?></a>
										<?php } ?>
									</td>
									<td class="text-center"><?php echo $column_image; ?></td>
									<td class="text-left"><?php if ($sort == 'pd.name') { ?>
										<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
										<?php } ?>
									</td>
                                    <td class="text-left" style="display:none"><?php echo $column_category;?></td>
                                    <td class="text-center" ><?php echo $column_ishome;?></td>
									<!--{COLUMN}-->
									<td class="text-center"><?php if ($sort == 'p.status') { ?>
										<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
										<?php } ?>
									</td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<tr style="display:none">
									<td></td>
									<td></td>
									<td></td>
									<td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>"  class="form-control" /></td>
                                    
                                    <td style="display:none" >
              <select class="form-control" style="min-width:100px" id="filter_category" name="filter_category">
                  <option value="*"></option>
                  <?php foreach($categories as $item){?>
                  <?php if($item['parent_id']!=93){?>
                  	<option value="<?php echo $item['category_id'];?>" <?php if($filter_category==$item['category_id']) echo ' selected="selected"';?>><?php echo $item['name'];?></option>
                    <?php }?>
                  <?php }?>
                  
                </select>
                
             </td>
             
                                    <td style="display:none" ><select id="filter_ishome" name="filter_ishome" class="form-control" style="min-width:100px">
                                    <option value="*"></option>
                                      <?php if ($filter_ishome) { ?>
                                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                      <?php } else { ?>
                                      <option value="1"><?php echo $text_enabled; ?></option>
                                      <?php } ?>
                                      <?php if (!is_null($filter_ishome) && !$filter_ishome) { ?>
                                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                      <?php } else { ?>
                                      <option value="0"><?php echo $text_disabled; ?></option>
                                      <?php } ?>
                                    </select></td>
                                    <!--{FILTER}-->
									<td><select id="filter_status" name="filter_status" class="form-control" style="min-width:100px">
										<option value="*"></option>
										<?php if ($filter_status) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<?php } ?>
										<?php if (!is_null($filter_status) && !$filter_status) { ?>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select></td>
									<td class="text-right"><button onclick="filter();" data-toggle="tooltip" title="<?php echo $button_filter; ?>" type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <lbl class="s-mobile"><?php echo $button_filter; ?></lbl></button></td>

								</tr>
								<?php if ($albums) { ?>
								<?php foreach ($albums as $album) { ?>
								<tr>
									<td class="text-center"><?php if ($album['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $album['album_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $album['album_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-center"><input type="text" onkeypress="return checkIt(event);" style="width:25px" class="sort_order text-center" albumid="<?php echo $album['album_id'];?>" value="<?php echo $album['sort_order'];?>" /></td>
									<td class="text-center"><?php if(!empty($album['image'])){?><img src="<?php echo $album['image']; ?>" alt="<?php echo $album['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /><?php }?></td>
									<td class="text-left"><?php echo $album['name']; ?></td>
                                    <td class="text-left"  style="display:none" ><?php echo $album['category']; ?></td>
                                    <td class="text-center"  ><?php echo $album['ishome']; ?></td>
                                    <!--{VALUE}-->
									<td class="text-center">
										<?php if ($album['status_id']==1): ?>
											<input type="checkbox" checked="checked" class="status" albumid="<?php echo $album['album_id'];?>" data-status="<?php echo $album['status_id'] ?>">
										<?php else: ?>
											<input type="checkbox" class="status" albumid="<?php echo $album['album_id'];?>" data-status="<?php echo $album['status_id'] ?>">
										<?php endif ?>
									</td>
									<td class="text-right"><?php foreach ($album['action'] as $action) { ?>
										<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" <?php if($action['cls']=='btn_list') echo 'class="btn btn-default"'; else echo 'class="btn btn-primary"'; ?> ><?php if($action['cls']=='btn_list') echo '<i class="fa fa-th-list"></i>'; else echo '<i class="fa fa-pencil"></i>'; ?> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
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
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
                
                <form style="display:none" action="" method="post" enctype="multipart/form-data" id="form1" >        
        			<div class="table-responsive" style="display:none" >    
                      <table  class="table table-bordered table-hover">
                        <tr>
                          <td>
                          <label class="col-sm-2 control-label"  style="width:100% !important;">
                            <span data-toggle="tooltip" title="<?php echo $help_entry_image_album; ?>"><?php echo $entry_image_album; ?></span><br/>
                            <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_album ?></p>
                          </label>
                          </td>
                          <td>
                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                </a>
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                <?php if (isset($error_image) && !empty($error_image)) { ?>
                <div class="text-danger"><?php echo $error_image; ?></div>
                <?php } ?>
                          </td>
                        </tr>
                        
                        
                        <tr><td></td><td class="buttons"><a onclick="$('#form1').submit();" data-toggle="tooltip" title="<?php echo $button_save ?>" class="btn btn-primary"><i class="fa fa-save"></i><lbl class="s-mobile"><?php echo $button_save ?></lbl></a></td></tr>
                      </table>
                    </div>
             
        
      </form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function filter() {
			url = '<?php echo $filter;?>';

			var cate = getURLVar('cate');
			cate = parseInt(cate);

			if(cate>0)
				url += '&cate=' + cate;

			var filter_name = $('#filter_name').val();

			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}
			
			var filter_ishome = $('#filter_ishome').val();

    if (filter_ishome != '*') {
        url += '&filter_ishome=' + encodeURIComponent(filter_ishome);
    }
			
			/*{FILTER_SCRIPT}*/

			var filter_status = $('#filter_status').val();

			if (filter_status != '*') {
				url += '&filter_status=' + encodeURIComponent(filter_status);
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
	$(document).ready(function(){
		$(".sort_order").click(function(){
			var id = $(this).attr('albumid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=album&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order + '&isclick=1',
					dataType: 'text',
					success: function(data) {

					}
				});
			}else{
				$(this).val(0);
			}
		});
		$(".sort_order").blur(function(){
			var id = $(this).attr('albumid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=album&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order,
					dataType: 'text',
					success: function(data) {
						window.location = document.URL;
					}
				});
			}else{
				$(this).val(0);
			}
		});
	});
	/*
	$(document).ready(function(){
		$(".ishome").on('click', function(){
			var id = $(this).attr('albumid');
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
					data: 't=album&id=' + encodeURIComponent(id) + '&ishome=' + ishome,
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
		var id = $(this).attr('albumid');
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
				data: 't=album&id=' + encodeURIComponent(id) + '&status=' + status,
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