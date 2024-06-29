<?php echo $header; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-adminmenu" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <lbl class="s-mobile"><?php echo $button_cancel; ?></lbl></a>
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
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-adminmenu" class="form-horizontal">
					<div class="tab-content">
						<!-- tab-general -->
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

									<div class="form-group required">
										<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
										<div class="col-sm-10">
											<input type="text" name="adminmenu_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($adminmenu_description[$language['language_id']]) ? $adminmenu_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>

									<div class="form-group" style="display:none">
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="adminmenu_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($adminmenu_description[$language['language_id']]) ? $adminmenu_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
								</div>
								<?php } ?>

								<div class="form-group required">
									<label class="col-sm-2 control-label" for="path"><?php echo $entry_path; ?></label>
									<div class="col-sm-10">
										<input type="text" name="path" id="path" value="<?php echo $path;?>" class="form-control" />
										<?php if (isset($error_path) && !empty($error_path)) { ?>
										<div class="text-danger"><?php echo $error_path; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" id="parent_id"><?php echo $entry_parent; ?></label>
									<div class="col-sm-10">
										<select name="parent_id" id="parent_id" class="form-control" >
											<option value="<?php if(isset($parent_default)){echo (int)$parent_default;}else {echo "0";}?>"><?php echo $text_none; ?></option>
											<?php foreach ($categories as $adminmenu) { ?>
											<?php if ($adminmenu['adminmenu_id'] == $parent_id) { ?>
											<option value="<?php echo $adminmenu['adminmenu_id']; ?>" selected="selected"><?php echo $adminmenu['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $adminmenu['adminmenu_id']; ?>"><?php echo $adminmenu['name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<?php if (isset($error_parent_id) && !empty($error_parent_id)) { ?>
										<div class="text-danger"><?php echo $error_parent_id; ?></div>
										<?php } ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="cate_id">
										<span data-toggle="tooltip" title="<?php echo $help_show_category;?>"><?php echo $entry_show_category;?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_show_category ?></p>
									</label>
									<div class="col-sm-10">
										<input type="text" name="cate_id" id="cate_id" value="<?php echo $cate_id; ?>" class="form-control" />
									</div>
								</div>

								<div class="form-group" style="display:none">
									<label class="col-sm-2 control-label" for="input-top"><?php echo $entry_top;?></label>
									<div class="col-sm-10">
										<div class="checkbox">
											<?php if ($top) { ?>
											<input type="checkbox" name="top" value="1" checked="checked" id="input-top" />
											<?php } else { ?>
											<input type="checkbox" name="top" value="1" id="input-top" />
											<?php } ?>
										</div>
									</div>
								</div>

								<div class="form-group" style="display:none">
									<label class="col-sm-2 control-label" for="column"><?php echo $entry_column; ?></label>
									<div class="col-sm-10">
										<input type="text" name="column" id="column" value="<?php echo $column; ?>" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="sort_order"><?php echo $entry_sort_order; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sort_order" id="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="status"><?php echo $entry_status; ?></label>
									<div class="col-sm-10">
										<select name="status" class="form-control" id="status">
											<?php if ($status) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('#language a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>