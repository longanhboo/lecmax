<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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

						<div class="form-group" >
							<label class="col-sm-2 control-label" for="config_link_facebook"><?php echo $entry_facebook;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_facebook" id="config_link_facebook" value="<?php echo $config_link_facebook;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_linkedin"><?php echo $entry_linkedin;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_linkedin" id="config_link_linkedin" value="<?php echo $config_link_linkedin;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group"  >
							<label class="col-sm-2 control-label" for="config_link_youtube"><?php echo $entry_youtube;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_youtube" id="config_link_youtube" value="<?php echo $config_link_youtube;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group" style="display:none">
							<label class="col-sm-2 control-label" for="config_link_twitter"><?php echo $entry_twitter;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_twitter" id="config_link_twitter" value="<?php echo $config_link_twitter;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group" style="display:none">
							<label class="col-sm-2 control-label" for="config_link_googleplus"><?php echo $entry_googleplus;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_googleplus" id="config_link_googleplus" value="<?php echo $config_link_googleplus;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_email"><?php echo $entry_email;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_email" id="config_link_email" value="<?php echo $config_link_email;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_nick_yahoo"><?php echo $entry_yahoo;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_nick_yahoo" id="config_nick_yahoo" value="<?php echo $config_nick_yahoo;?>" class="form-control"/>
							</div>
						</div>

						<div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_nick_skype"><?php echo $entry_skype;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_nick_skype" id="config_nick_skype" value="<?php echo $config_nick_skype;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none"  >
							<label class="col-sm-2 control-label" for="config_hotline"><?php echo $entry_hotline ?></label>
							<div class="col-sm-10">
								<input class="form-control" id="config_hotline" type="text" name="config_hotline" value="<?php echo $config_hotline ?>" />
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_intergram"><?php echo $entry_intergram;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_intergram" id="config_link_intergram" value="<?php echo $config_link_intergram;?>" class="form-control"/>
							</div>
						</div>
                        
                        <div class="form-group" style="display:none" >
							<label class="col-sm-2 control-label" for="config_link_pinterest"><?php echo $entry_pinterest;?></label>
							<div class="col-sm-10">
								<input type="text" name="config_link_pinterest" id="config_link_pinterest" value="<?php echo $config_link_pinterest;?>" class="form-control"/>
							</div>
						</div>
                        

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>