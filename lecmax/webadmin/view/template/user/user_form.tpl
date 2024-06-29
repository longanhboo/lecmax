<?php echo $header; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <?php if(FB_G_HIDDEN===false){?>
        <a style="display:none" onclick="facebookLogin()"  data-toggle="tooltip" title="Facebook" class="btn btn-primary"><i class="fa fa-key"></i></a>
        <a style="display:none" id="google-button" data-toggle="tooltip" title="Google" class="btn btn-primary"><i class="fa fa-key"></i></a>
        <?php }?>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h3 ><?php echo $heading_title; ?></h3>
      <ul class="breadcrumb" style="display:none">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
          <input type="hidden" name="flag" id="flag" value="0">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control" />
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
          <div class="form-group" style="display:none">
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="text" name="social_username" id="input-social-username" class="form-control" />
              <input type="password" name="social_password" id="input-social-password" class="form-control" />
              <input type="text" name="social_email" id="input-social-email" class="form-control" />
              <input type="text" name="social_id" id="input-social-id" class="form-control" />
              <input type="text" name="social_lastname" id="input-social-lastname" class="form-control" />
              <input type="text" name="social_firstname" id="input-social-firstname" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_user_group; ?></label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user-group" class="form-control">
                <?php foreach ($user_groups as $user_group) { ?>
                <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" autocomplete="off" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php if(FB_G_HIDDEN===false){?>
  <!-- facebook -->
  <script>
    function facebookLogin() {
      var FB = window.FB;
      FB.login(function(response) {
        if (response.status === 'connected') {
          FB.api('me/?fields=id, name, email, first_name, last_name', function(response) {
            $('#input-social-username').val(response.first_name);
            $('#input-social-password').val(response.email+response.id);
            $('#input-social-email').val(response.email);
            $('#input-social-id').val(response.id);
            $('#input-social-firstname').val(response.first_name);
            $('#input-social-lastname').val(response.last_name);
            $('#flag').val('1');
            $('#form').submit();
          });
        }
      });
    }

    window.fbAsyncInit = function() {
      FB.init({
        // appId      : '824633104315895', (3graphic)
        appId      : '<?php echo FB_APPID;?>',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.5',
        oauth: true
      });
    };

    (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  </script>

  <!-- Google -->
  <script type="text/javascript">
    // var clientId = '684615093825-h8e0tj3ccovv60f2cmv56uqegeeshu1n';
    var clientId = '<?php echo G_CLIENTID;?>';

    // var apiKey = 'AIzaSyBY2UlQFog4Okjg9OA5ZH-c6iBvUN0OHXg';
    var apiKey = '<?php echo G_APIKEY;?>';

    var scopes = 'https://www.googleapis.com/auth/userinfo.email';

    var flag = 2;

    function handleClientLoad() {
      gapi.client.setApiKey(apiKey);
      window.setTimeout(checkAuth,1);
    }

    function checkAuth() {
      gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
    }

    function handleAuthResult(authResult) {
      var authorizeButton = document.getElementById('google-button');
      if (authResult && !authResult.error) {
        if (flag == 1) {
          var authTimeout = (authResult.expires_in - 5 * 60) * 1000;
          setTimeout(checkAuth, authTimeout);
          makeApiCall();
        } else {
          flag = 1;
          authorizeButton.onclick = checkAuth;
        }
      } else {
        authorizeButton.style.visibility = '';
        authorizeButton.onclick = handleAuthClick;
      }
    }

    function handleAuthClick(event) {
      // Step 3: get authorization to use private data
      gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
      flag = 1; //click sign in
      return false;
    }

    // Load the API and make an API call.  Display the results on the screen.
    function makeApiCall() {
      // Step 4: Load the Google+ API
      gapi.client.load('plus','v1', function(){
        // Step 5: Assemble the API request
        var request = gapi.client.plus.people.get({
          'userId': 'me'
        });
        // Step 6: Execute the API request
        request.then(function(resp) {
          $('#input-social-username').val(resp.result.name.givenName);
          $('#input-social-password').val(resp.result.emails[0].value+resp.result.id);
          $('#input-social-email').val(resp.result.emails[0].value);
          $('#input-social-id').val(resp.result.id);
          $('#input-social-firstname').val(resp.result.name.givenName);
          $('#input-social-lastname').val(resp.result.name.familyName);
          $('#flag').val('1');
          $('#form').submit();
        }, function(reason) {
          console.log('Error: ' + reason.result.error.message);
        });
      });
    }
  </script>
  <!-- Step 1: Load JavaScript client library -->
  <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
  <?php }?>
</div>
<?php echo $footer; ?>