<?php echo $header; ?>
<div id="content" class="login-page">
  <div class="container-fluid"><br />
    <br />
    <div class="row">
      <div class="col-sm-offset-4 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-lock"></i> <?php echo $text_login; ?></h1>
          </div>
          <div class="panel-body">
            <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="login-form">
              <input type="hidden" name="flag" id="flag" value="0">
              <div class="form-group">
                <label for="input-username"><?php echo $entry_username; ?></label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label for="input-password"><?php echo $entry_password; ?></label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                </div>
                <?php if ($forgotten) { ?>
                <!-- <span class="help-block"><a href="<?php //echo $forgotten; ?>"><?php //echo $text_forgotten; ?></a></span> -->
                <?php } ?>
              </div>
              <div class="form-group" style="display:none">
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="social_username" id="input-social-username" class="form-control" />
                </div>
              </div>
              <div class="form-group" style="display:none">
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" name="social_password" id="input-social-password" class="form-control" />
                  <input type="password" name="s_social_password" id="input-social-spassword" class="form-control" />
                  <input type="hidden" name="social_email" id="input-social-email" class="form-control" />
                  <input type="hidden" name="social_id" id="input-social-id" class="form-control" />
                  <input type="hidden" name="social_lastname" id="input-social-lastname" class="form-control" />
                  <input type="hidden" name="social_firstname" id="input-social-firstname" class="form-control" />
                </div>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i><?php echo $button_login; ?></button>
                <?php if(FB_G_HIDDEN===false){?>
                <div style="display:none" id="fb" onclick="facebookLogin();" class="btn btn-primary"><?php echo $entry_facebook; ?></div>
                <div style="display:none" id="google-button" class="btn btn-primary"><?php echo $entry_google ?></div>
                <?php }?>
              </div>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
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
        console.log('The user has logged in!');
        FB.api('me/?fields=id, name, email, first_name, last_name', function(response) {
          $('#input-social-username').val(response.first_name);
          $('#input-social-password').val(response.email+response.id);
          $('#input-social-email').val(response.email);
          $('#input-social-id').val(response.id);
          $('#input-social-firstname').val(response.first_name);
          $('#input-social-lastname').val(response.last_name);
          $('#flag').val('1');
          $('#login-form').submit();
        });
      }
    });
  }

  function facebookRegister() {
    var FB = window.FB;

    FB.login(function(response) {
      if (response.status === 'connected') {
        console.log('The user has logged in!');
        FB.api('me/?fields=id, name, email, first_name, last_name', function(response) {
          $('#input-social-username').val(response.first_name);
          $('#input-social-password').val(response.email);
          $('#input-social-spassword').val(response.email+response.id);
          $('#input-social-email').val(response.email);
          $('#input-social-id').val(response.id);
          $('#input-social-firstname').val(response.first_name);
          $('#input-social-lastname').val(response.last_name);
          $('#social-flag').attr('value', '2');
          $('#login-form').submit();
        });
      }
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      // appId      : '824633104315895', (3graphic)
      appId      : '<?php echo FB_APPID;?>',
      // cookie     : true,
      xfbml      : true,
      version    : 'v2.5',
      oauth: true
    });
  };

  (function(d, s, id) {
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 } (document, 'script', 'facebook-jssdk'));
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
      //sign in success!
      if (flag == 1) {
        var authTimeout = (authResult.expires_in - 5 * 60) * 1000;
        setTimeout(checkAuth, authTimeout);
        makeApiCall();
      } else {
        flag = 1;
        authorizeButton.onclick = checkAuth;
      }
    } else {
      //not sign in
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
        $('#login-form').submit();
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
