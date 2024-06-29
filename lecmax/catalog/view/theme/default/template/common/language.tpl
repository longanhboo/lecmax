<div class="language">
<form id="change_lang" enctype="multipart/form-data" method="post" action="<?php echo HTTP_SERVER;?>index.php?route=common/home">
<ul>
<?php foreach($languages as $language){ ?>
<li <?php if($language['code']==$lang_active) echo 'class="active"';?> ><a href="javascript:void(0);" onClick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code'];?>').submit();var tmp_url = document.URL;if(tmp_url=='<?php echo HTTP_SERVER;?>'){$('input[name=\'language_code\']').attr('value', '<?php echo $language['code'];?>').submit();$('input[name=\'redirect\']').attr('value', '<?php echo $language['redirect'];?>').submit();$('#change_lang').submit();return false;}else{var tmp_url_change = tmp_url.replace('/<?php echo $lang_active;?>/', '/<?php echo $language['code'];?>/');$('input[name=\'redirect\']').attr('value', tmp_url_change).submit();;$('#change_lang').submit();return false;}"><?php echo $language['code'];?></a></li>
<?php }?>
</ul>
	<input type="hidden" value="" name="language_code" />
    <input id="changlanguage_redirect" type="hidden" value="<?php echo $redirect;?>" name="redirect" />
</form>
</div>