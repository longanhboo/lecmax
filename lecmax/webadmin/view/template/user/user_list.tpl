<?php echo $header; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a onclick="location = '<?php echo $insert; ?>'" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <lbl class="s-mobile"><?php echo $button_insert; ?></lbl></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('#form-user').submit();"><i class="fa fa-trash-o"></i> <lbl class="s-mobile"><?php echo $button_delete; ?></lbl></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'username') { ?>
                    <a href="<?php echo $sort_username; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_username; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_username; ?>"><?php echo $column_username; ?></a>
                    <?php } ?>
                  </td>
                  <td>Nhóm</td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php if ($sort == 'date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($users) { ?>
                <?php foreach ($users as $user) { ?>
                <tr>
                  <td class="text-center"><?php if ($user['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" />
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $user['username']; ?></td>
                  <td class="text-left"><?php echo $user['groupname']; ?></td>
                  <td class="text-center">
                    <?php if ($user['status_id']==1): ?>
                      <input type="checkbox" checked="checked" class="status" userid="<?php echo $user['user_id'];?>" data-status="<?php echo $user['status_id'] ?>">
                    <?php else: ?>
                      <input type="checkbox" class="status" userid="<?php echo $user['user_id'];?>" data-status="<?php echo $user['status_id'] ?>">
                    <?php endif ?>
                  </td>
                  <td class="text-left"><?php echo $user['date_added']; ?></td>
                  <td class="text-right"><?php foreach ($user['action'] as $action) { ?>
                    <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>"  class="btn btn-primary" ><i class="fa fa-pencil"></i> <lbl class="s-mobile"><?php echo $action['text'] ?></lbl></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
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
  <script type="text/javascript">
    $(document).ready(function(){
      $(".status").on('click', function(){
        var id = $(this).attr('userid');
        var status = $(this).attr('data-status');
        if (status==1) {
          status = 0 ;
        } else {
          status = 1;
        }
        if(isNaN(status)===false) {
          $.ajax({
            url: 'index.php?route=catalog/sortorder&token=<?php echo $token; ?>',
            type: 'POST',
            data: 't=user&id=' + encodeURIComponent(id) + '&status=' + status,
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