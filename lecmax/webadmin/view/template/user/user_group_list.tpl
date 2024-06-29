<?php echo $header; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user-group">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" class="text-center" style="display:none">
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
                  </td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                    <td class="text-right"><?php echo $column_action; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($user_groups) { ?>
                  <?php foreach ($user_groups as $user_group) { ?>
                  <tr>
                    <td class="text-center" style="display:none"><?php if ($user_group['selected']) { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $user_group['user_group_id']; ?>" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $user_group['user_group_id']; ?>" />
                      <?php } ?>
                    </td>
                    <td class="text-left"><?php echo $user_group['name']; ?></td>
                    <td class="text-right"><?php foreach ($user_group['action'] as $action) { ?>
                      <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>"  class="btn btn-primary" ><i class="fa fa-pencil"></i> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
                    <?php } ?></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </form>
          <div class="row">
            <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php echo $footer; ?>