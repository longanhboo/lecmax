<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-contact" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
                <a style="display:none" onclick="$('#form-backup').submit();" href="<?php echo $backup; ?>" data-toggle="tooltip" title="Backup" class="btn btn-default"><i class="fa fa-download"></i> <lbl class="s-mobile">Backup</lbl></a>
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
            	<form style="display:none" action="<?php echo $backup; ?>" method="post" enctype="multipart/form-data" id="form-backup" class="form-horizontal">
          			<div class="form-group" style="display:none" >
                        <label class="col-sm-2 control-label">Backup</label>
            			<div class="col-sm-10">
                            <div class="well well-sm" style="height: 150px; overflow: auto;">
                            <?php foreach ($tables as $table) { ?>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="backup[]" value="<?php echo $table; ?>" checked="checked" />
                                <?php echo $table; ?></label>
                            </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">

					<div class="tab-content">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="google_analytics"><?php echo $entry_google_analytics;?></label>
							<div class="col-sm-10">
								<textarea name="google_analytics" id="google_analytics" rows="20" class="form-control"><?php echo $google_analytics;?></textarea>
							</div>
						</div>
					</div>
                    
                    <div class="tab-content">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="google_tag_manager"><?php echo $entry_google_tag_manager;?></label>
							<div class="col-sm-10">
								<textarea name="google_tag_manager" id="google_tag_manager" rows="20" class="form-control"><?php echo $google_tag_manager;?></textarea>
							</div>
						</div>
					</div>
				</form>
                
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>