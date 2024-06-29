<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="location = '<?php echo $export; ?>'" data-toggle="tooltip" title="Export" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> <lbl class="s-mobile">Export</lbl></a>
                <a style="display:none" onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
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
									<!--{COLUMN_IMAGE}-->
									<td class="text-left"><?php if ($sort == 'pd.name') { ?>
										<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
										<?php } ?>
									</td>
                                    <td class="text-left" style="display:none"><?php echo $column_cmnd; ?></td>
                                    <td class="text-left"><?php echo $column_email; ?></td>
              						<td class="text-left"><?php echo $column_phone; ?></td>
                                    <td class="text-left" style="display:none" ><?php echo $column_company; ?></td>
                                    <td class="text-left" style="display:none" ><?php echo $column_address; ?></td>
                                    <td class="text-left" style="display:none" ><?php echo $column_loai_mail; ?></td>
                                    <td class="text-center" style="display:none" ><?php echo $column_canho; ?></td>
                                    <td class="text-center" style="display:none" ><?php echo $column_gia; ?></td>
                                    <td class="text-left" ><?php echo $column_comment; ?></td>
                                    
                                    <td class="text-center" ><?php echo $column_date; ?></td>
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
								<tr>
									<td></td>
									<td></td>
									<!--{FILTER_IMAGE}-->
									<td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>"  class="form-control" /></td>
                                    <td style="display:none"><input type="text" id="filter_cmnd" name="filter_cmnd" value="<?php echo $filter_cmnd; ?>"  class="form-control" /></td>
                                    <td><input type="text" id="filter_email" name="filter_email" value="<?php echo $filter_email; ?>"  class="form-control" /></td>
                                    <td><input type="text" id="filter_phone" name="filter_phone" value="<?php echo $filter_phone; ?>"  class="form-control" /></td>
                                    <td style="display:none" ><input type="text" id="filter_company" name="filter_company" value="<?php echo $filter_company; ?>"  class="form-control" /></td>
                                    <td style="display:none" ><input type="text" id="filter_address" name="filter_address" value="<?php echo $filter_address; ?>"  class="form-control" />
                                    <br />
                                    <select id="filter_city" name="filter_city" class="form-control" style="max-width:100px">
										<option value="*">Tỉnh / Thành Phố</option>
										<?php foreach($citys as $item){?>
										<option value="<?php echo $item['city_id'];?>" <?php if($filter_city==$item['city_id']) echo ' selected="selected"';?>><?php echo $item['name'];?></option>
										<?php }?>
									</select>
                                    <br />
                                    <select id="filter_district" name="filter_district" class="form-control" style="max-width:100px">
										<option value="*">Quận / Huyện</option>
										<?php foreach($districts as $item){?>
										<option value="<?php echo $item['district_id'];?>" <?php if($filter_district==$item['district_id']) echo ' selected="selected"';?>><?php echo $item['name'];?></option>
										<?php }?>
									</select>
                                    
                                    
                                    </td>
                                    <td style="display:none" ><select id="filter_is_mail" name="filter_is_mail" class="form-control" style="max-width:100px">
										<option value="*"></option>
										<?php if ($filter_is_mail) { ?>
										<option value="1" selected="selected"><?php echo $text_lien_he; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_lien_he; ?></option>
										<?php } ?>
										<?php if (!is_null($filter_is_mail) && !$filter_is_mail) { ?>
										<option value="0" selected="selected"><?php echo $text_dat_cau_hoi; ?></option>
										<?php } else { ?>
										<option value="0"><?php echo $text_dat_cau_hoi; ?></option>
										<?php } ?>
									</select></td>
                                    <td style="display:none"></td>
                                    <td style="display:none"></td>
                                    <td ><input style="display:none" type="text" id="filter_comment" name="filter_comment" value="<?php echo $filter_comment; ?>"  class="form-control" /></td>
                                    
                                    <td align="text-center"><input type="text" id="filter_date_start" class="form-control date" name="filter_date_start" size="5" value="<?php echo $filter_date_start; ?>" /><br /><input type="text" id="filter_date_end" class="form-control date" name="filter_date_end" size="5" value="<?php echo $filter_date_end; ?>" /></td>
                                    <!--{FILTER}-->
									<td><select id="filter_status" name="filter_status" class="form-control" style="max-width:100px">
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
								<?php if ($emailcuss) { ?>
								<?php foreach ($emailcuss as $emailcus) { ?>
								<tr>
									<td class="text-center"><?php if ($emailcus['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $emailcus['emailcus_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $emailcus['emailcus_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-center"><input type="text" onkeypress="return checkIt(event);" style="width:25px" class="sort_order text-center" emailcusid="<?php echo $emailcus['emailcus_id'];?>" value="<?php echo $emailcus['sort_order'];?>" /></td>
									<!--{VALUE_IMAGE}-->
									<td class="text-left"><?php echo $emailcus['name']; ?></td>
                                    <td class="text-left" style="display:none"><?php echo $emailcus['cmnd']; ?></td>
                                    <td class="text-left"><?php echo $emailcus['email']; ?></td>
                                    <td class="text-left" ><?php echo $emailcus['phone']; ?></td>
                                    <td class="text-left" style="display:none" ><?php echo $emailcus['company']; ?></td>
                                    <td class="text-left" style="display:none" ><?php echo $emailcus['address']; ?><?php echo !empty($emailcus['district'])?' - ' . $emailcus['district']:'';?><?php echo !empty($emailcus['city'])?' - ' . $emailcus['city']:'';?><!-- - <?php echo $emailcus['district']; ?> - <?php echo $emailcus['city']; ?>--></td>
                                    <td class="text-left" style="display:none"><?php echo $emailcus['canhoquantam']; ?></td>
                                    <td class="text-left" style="display:none"><?php echo $emailcus['giaquantam']; ?></td>
                                    <td class="text-center" style="display:none" ><?php if($emailcus['is_mail']==1) echo $text_lien_he; else echo $text_dat_cau_hoi;?></td>
                                    <td class="text-left" ><?php echo $emailcus['comment']; ?></td>
                                    <td class="text-left"><?php echo $emailcus['date_added']; ?></td>
                                    <!--{VALUE}-->
                                    
									<td class="text-center" colspan="2" >
										<?php if ($emailcus['status_id']==1): ?>
											<input type="checkbox" checked="checked" class="status" emailcusid="<?php echo $emailcus['emailcus_id'];?>" data-status="<?php echo $emailcus['status_id'] ?>">
										<?php else: ?>
											<input type="checkbox" class="status" emailcusid="<?php echo $emailcus['emailcus_id'];?>" data-status="<?php echo $emailcus['status_id'] ?>">
										<?php endif ?>
									</td>
									<td class="text-right" style="display:none"><?php foreach ($emailcus['action'] as $action) { ?>
										<a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" <?php if($action['cls']=='btn_list') echo 'class="btn btn-default"'; else echo 'class="btn btn-primary"'; ?> ><?php if($action['cls']=='btn_list') echo '<!--<i class="fa fa-th-list"></i>-->'; else echo '<i class="fa fa-pencil"></i>'; ?> <lbl <?php if($action['cls']!='btn_list'){?>class="s-mobile"<?php }?> ><?php echo $action['text'] ?></lbl></a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="15"><?php echo $text_no_results; ?></td>
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
                
                <form action="" method="post" enctype="multipart/form-data" id="form1" style="display:none">        
                    <div class="table-responsive" style="display:none">    
                      <table  class="table table-bordered table-hover">
                        <!--{VIEW_FORM}-->
                        <tr  >
                          <td>Hiển thị Đăng Ký Nhận Tin</td>
                          <td>
                          <select name="config_dangkynhantin" class="form-control" style="min-width:100px">
                              <?php if ($config_dangkynhantin) { ?>
                              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                              <option value="0"><?php echo $text_disabled; ?></option>
                              <?php } else { ?>
                              <option value="1"><?php echo $text_enabled; ?></option>
                              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                              <?php } ?>
                            </select>
                          
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
			
			var filter_cmnd = $('#filter_cmnd').val();
			if (filter_cmnd) {
				url += '&filter_cmnd=' + encodeURIComponent(filter_cmnd);
			}
			
			var filter_address = $('#filter_address').val();
			if (filter_address) {
				url += '&filter_address=' + encodeURIComponent(filter_address);
			}
			
			var filter_city = $('#filter_city').val();
			if (filter_city != '*') {
				url += '&filter_city=' + encodeURIComponent(filter_city);
			}
			
			var filter_district = $('#filter_district').val();
			if (filter_district != '*') {
				url += '&filter_district=' + encodeURIComponent(filter_district);
			}
			
			var filter_company = $('#filter_company').val();
			if (filter_company) {
				url += '&filter_company=' + encodeURIComponent(filter_company);
			}
			
			var filter_email = $('#filter_email').val();
			if (filter_email) {
				url += '&filter_email=' + encodeURIComponent(filter_email);
			}
			
			var filter_phone = $('#filter_phone').val();
			if (filter_phone) {
				url += '&filter_phone=' + encodeURIComponent(filter_phone);
			}
			
			var filter_comment = $('#filter_comment').val();
			if (filter_comment) {
				url += '&filter_comment=' + encodeURIComponent(filter_comment);
			}
			
			
			var filter_date_start = $('#filter_date_start').val();
			if (filter_date_start) {
				url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
			}
			var filter_date_end = $('#filter_date_end').val();
			if (filter_date_end) {
				url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
			}
			
			var filter_is_mail = $('#filter_is_mail').val();

			if (filter_is_mail != '*') {
				url += '&filter_is_mail=' + encodeURIComponent(filter_is_mail);
			}
			
			/*{FILTER_SCRIPT}*/

			var filter_status = $('#filter_status').val();

			if (filter_status != '*') {
				url += '&filter_status=' + encodeURIComponent(filter_status);
			}

			location = url;
		}
	</script>
    
    <script>
		$('#filter_city').change(function(){
			var city_id = $(this).val();
			$.ajax({url: 'index.php?route=catalog/district/getdistrict&token=<?php echo $token; ?>', type: 'POST',
					data: '&city_id=' + city_id, cache: false, success: function(data) {
						console.log(data)
						var str = '<option value="*">Quận / Huyện</option>';
						var districts = JSON.parse(data);
						for(var i=0;i<districts.length;i++){
							str += '<option value="' + districts[i].district_id + '">' + districts[i].name + '</option>';
						}
				$('#filter_district').html(str);
			}});
			
		});
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
			var id = $(this).attr('emailcusid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=emailcus&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order + '&isclick=1',
					dataType: 'text',
					success: function(data) {

					}
				});
			}else{
				$(this).val(0);
			}
		});
		
		$(".sort_order").blur(function(){
			var id = $(this).attr('emailcusid');
			var sort_order = $(this).val();
			if(isNaN(sort_order)===false)
			{
				$.ajax({
					url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
					type: 'POST',
					data: 't=emailcus&id=' + encodeURIComponent(id) + '&sort_order=' + sort_order,
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
			var id = $(this).attr('emailcusid');
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
					data: 't=emailcus&id=' + encodeURIComponent(id) + '&ishome=' + ishome,
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
		var id = $(this).attr('emailcusid');
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
				data: 't=emailcus&id=' + encodeURIComponent(id) + '&status=' + status,
				dataType: 'text',
				success: function(data) {

				}
			});
		}
	});
});
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
</div>
<?php echo $footer; ?>