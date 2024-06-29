<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-contact" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
		<?php if (isset($success) && $success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
					<div class="tab-content">

						<div class="form-group"  >
							<label class="col-sm-2 control-label" for="email_contact"><?php echo $entry_emailcontact;?></label>
							<div class="col-sm-10">
								<input type="text" name="email_contact" id="email_contact" value="<?php echo $email_contact;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="email_contact"><?php echo $entry_emailcontactregister;?></label>
							<div class="col-sm-10">
								<input type="text" name="email_contact_register" id="email_contact_register" value="<?php echo $email_contact_register;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="email_order"><?php echo $entry_emailorder;?></label>
							<div class="col-sm-10">
								<input type="text" name="email_order" id="email_order" value="<?php echo $email_order;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="protocol"><?php echo $entry_protocol;?></label>
							<div class="col-sm-10">
								<select id="protocol" name="protocol" class="form-control">
									<?php if ($protocol=='mail') { ?>
									<option value="mail" selected="selected">mail</option>
									<option value="smtp">smtp</option>
									<?php } else { ?>
									<option value="mail">mail</option>
									<option value="smtp" selected="selected">smtp</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group" style="display:none">
							<label class="col-sm-2 control-label" for="email_contact"><?php echo $entry_parameter;?></label>
							<div class="col-sm-10">
								<input type="text" name="parameter" value="<?php echo $parameter;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group display" >
							<label class="col-sm-2 control-label" for="hostname"><span data-toggle="tooltip" title="ssl://smtp.gmail.com" ><?php echo $entry_hostname;?></span></label>
							<div class="col-sm-10">
								<input type="text" name="hostname" id="hostname" value="<?php echo $hostname;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group display" >
							<label class="col-sm-2 control-label" for="username"><?php echo $entry_username;?></label>
							<div class="col-sm-10">
								<input type="text" name="username" id="username" value="<?php echo $username;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group display"  >
							<label class="col-sm-2 control-label" for="password"><?php echo $entry_password;?></label>
							<div class="col-sm-10">
								<input type="password" name="password" id="password" value="<?php echo $password;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group display"  >
							<label class="col-sm-2 control-label" for="port"><?php echo $entry_port;?></label>
							<div class="col-sm-10">
								<input type="text" name="port" id="port" value="<?php echo $port;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group display"  >
							<label class="col-sm-2 control-label" for="timeout"><?php echo $entry_timeout;?></label>
							<div class="col-sm-10">
								<input type="text" name="timeout" id="timeout" value="<?php echo $timeout;?>" class="form-control"/>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		function changeType(){
			if($("#protocol").val()=='mail'){
				$(".display").hide();
			}else{
				$(".display").show();
			}
		}
		$(document).ready(function() {
			$("#protocol").change(function(){
				changeType();
			});
			changeType();
		});
	</script>
</div>
<?php echo $footer; ?>