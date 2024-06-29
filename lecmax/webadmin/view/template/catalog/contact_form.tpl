<?php echo $header; ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnUR-5FrPxcYHMTkm_5xR1qca1i8NGRps&libraries=geometry" type="text/javascript"></script>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-contact" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <lbl class="s-mobile"><?php echo $button_save; ?></lbl></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-contact" class="form-horizontal">
					<input type="hidden" name="cate" value="<?php echo $cate;?>" />
					<ul class="nav nav-tabs" style="display:none" >
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li style="display:none" ><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo;?></a></li>
						<!--{TAB_FORM}-->
					</ul>
					<div class="tab-content">
						<!-- tab_general -->
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
											<input type="text" name="contact_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['name'] : ''; ?>"  id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>
                                    
                                    <div class="form-group display" style="display:none" >
										<label class="col-sm-2 control-label" for="input-name-1<?php echo $language['language_id']; ?>"><?php echo $entry_name1; ?></label>
										<div class="col-sm-10">
											<input type="text" name="contact_description[<?php echo $language['language_id']; ?>][name1]" id="input-name-1<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['name1'] : ''; ?>" />
											
										</div>
									</div>
                                    
                                    <div class="form-group" <?php if(!$cate) echo 'style="display:none"';?> >
										<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
										<div class="col-sm-10">
											<textarea name="contact_description[<?php echo $language['language_id']; ?>][description]"  id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['description'] : ''; ?></textarea>
										</div>
									</div>
                                    
                                    <div class="form-group" style="display:none" <?php if($contact_id!=5) echo 'style="display:none"';?> >
										<label class="col-sm-2 control-label" for="input-name2<?php echo $language['language_id']; ?>"><?php echo $entry_name2; ?></label>
										<div class="col-sm-10">
											<input type="text" name="contact_description[<?php echo $language['language_id']; ?>][name2]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['name2'] : ''; ?>"  id="input-name2<?php echo $language['language_id']; ?>" class="form-control" />
										</div>
									</div>
                                    
                                    
                                    
                                    <div class="form-group"  >
										<label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>"><?php echo $entry_address; ?></label>
										<div class="col-sm-10">
											<input type="text" name="contact_description[<?php echo $language['language_id']; ?>][address]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['address'] : ''; ?>"  id="input-address<?php echo $language['language_id']; ?>" class="form-control" />
											<?php if (isset($error_address[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_address[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>

									
									<!--{INSERT_FIELD_LANG}-->
								</div>
								<?php } ?>
								<!--{VIEW_FORM}-->
                                
                                <div class="form-group"  >
									<label class="col-sm-2 control-label" for="input-phonelist"><?php echo $entry_phone; ?></label>
									<div class="col-sm-10">
										<textarea name="phonelist" id="input-phonelist" class="form-control" ><?php echo $phonelist; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group"   >
									<label class="col-sm-2 control-label" for="input-faxlist"><?php echo $entry_fax; ?></label>
									<div class="col-sm-10">
										<textarea name="faxlist" id="input-faxlist" class="form-control" ><?php echo $faxlist; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group" style="display:none">
									<label class="col-sm-2 control-label" for="input-hotlinelist"><?php echo $entry_hotline; ?></label>
									<div class="col-sm-10">
										<textarea name="hotlinelist" id="input-hotlinelist" class="form-control" ><?php echo $hotlinelist; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" <?php if($contact_id==42 || $contact_id==43) echo 'style="display:none"';?>  >
									<label class="col-sm-2 control-label" for="input-emaillist"><?php echo $entry_email; ?></label>
									<div class="col-sm-10">
										<textarea name="emaillist" id="input-emaillist" class="form-control" ><?php echo $emaillist; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-tax"><?php echo $entry_tax; ?></label>
									<div class="col-sm-10">
										<input type="text" name="tax" value="<?php echo $tax; ?>"  id="input-tax" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" <?php if($contact_id==6 || $contact_id==1) echo 'style="display:none"';?> >
									<label class="col-sm-2 control-label" for="input-phone"><?php echo $entry_phone; ?> (1)</label>
									<div class="col-sm-10">
										<input type="text" name="phone" value="<?php echo $phone; ?>"  id="input-phone" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-phone1"><?php echo $entry_phone; ?> (2)</label>
									<div class="col-sm-10">
										<input type="text" name="phone1" value="<?php echo $phone1; ?>"  id="input-phone1" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-phoneviber"><?php echo $entry_phoneviber; ?></label>
									<div class="col-sm-10">
										<input type="text" name="phoneviber" value="<?php echo $phoneviber; ?>"  id="input-phoneviber" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-fax"><?php echo $entry_fax; ?> (1)</label>
									<div class="col-sm-10">
										<input type="text" name="fax" value="<?php echo $fax; ?>"  id="input-fax" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-fax1"><?php echo $entry_fax; ?> (2)</label>
									<div class="col-sm-10">
										<input type="text" name="fax1" value="<?php echo $fax1; ?>"  id="input-fax1" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-fax2"><?php echo $entry_fax; ?> (3)</label>
									<div class="col-sm-10">
										<input type="text" name="fax2" value="<?php echo $fax2; ?>"  id="input-fax2" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group"  style="display:none" >
									<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
									<div class="col-sm-10">
										<input type="text" name="email" value="<?php echo $email; ?>"  id="input-email" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-email1"><?php echo $entry_email; ?> (2)</label>
									<div class="col-sm-10">
										<input type="text" name="email1" value="<?php echo $email1; ?>"  id="input-email1" class="form-control" />
									</div>
								</div>
                                
                                <div class="form-group" <?php if(!$cate) echo 'style=""';?> >
									<label class="col-sm-2 control-label" for="input-googlemap"><?php echo $entry_googlemap; ?></label>
									<div class="col-sm-10">
										<textarea name="googlemap"  id="input-googlemap" class="form-control" ><?php echo $googlemap; ?></textarea>
									</div>
								</div>
                                
                                <div class="form-group display_home"  >
								<label class="col-sm-2 control-label" for="ishome"><?php echo $entry_ishome;?></label>
								<div class="col-sm-10">
									<div class="checkbox">
										<label>
											<?php if($ishome == "1") {?>
											<input id="ishome" value="1" type="checkbox" name="ishome" checked="checked"/>
											<?php } else {?>
											<input id="ishome" value="1" type="checkbox" name="ishome"/>
											<?php }?>
										</label>
									</div>
								</div>
							</div>
                                
                                <div class="form-group required display" style="display:none"  <?php if($contact_id==1) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image1; ?>"><?php echo $entry_image1; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image1 ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image1" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview1)) echo 'view/image/image.png'; else echo $preview1; ?>" alt="" title="" data-placeholder="<?php echo $image1; ?>" />
                </a>
                <input type="hidden" name="image1" value="<?php echo $image1; ?>" id="input-image1" />
                <?php if (isset($error_image1) && !empty($error_image1)) { ?>
                <div class="text-danger"><?php echo $error_image1; ?></div>
                <?php } ?>
              </div>
            </div>
            
            <div class="form-group required display" style="display:none" <?php if($contact_id==1) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image2; ?>"><?php echo $entry_image2; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image2 ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image2" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview2)) echo 'view/image/image.png'; else echo $preview2; ?>" alt="" title="" data-placeholder="<?php echo $image2; ?>" />
                </a>
                <input type="hidden" name="image2" value="<?php echo $image2; ?>" id="input-image2" />
                <?php if (isset($error_image1) && !empty($error_image2)) { ?>
                <div class="text-danger"><?php echo $error_image2; ?></div>
                <?php } ?>
              </div>
            </div>
            
            
								<div class="form-group required display" style="display:none" <?php if($contact_id==42 || $contact_id==43) echo 'style="display:none"';?> >
              <label class="col-sm-2 control-label">
                <span data-toggle="tooltip" title="<?php echo $help_entry_image; ?>"><?php echo $entry_image; ?></span><br/>
                <p class="s-mobile s-mobile-help"><?php echo $help_entry_image ?></p>
              </label>
              <div class="col-sm-10">
                <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                  <img src="<?php if(empty($preview)) echo 'view/image/image.png'; else echo $preview; ?>" alt="" title="" data-placeholder="<?php echo $image; ?>" />
                </a>
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                <?php if (isset($error_image) && !empty($error_image)) { ?>
                <div class="text-danger"><?php echo $error_image; ?></div>
                <?php } ?>
              </div>
            </div>
            
            <div class="form-group "  >
									<label class="col-sm-2 control-label" for="address_location"><?php echo $entry_address_location ?></label>
									<div class="col-sm-10">
										<input type="text" class="location_map" name="address_location" id="address_location" value="<?php echo $address_location; ?>" style="width:73%;"/> <input type="button"  value="<?php echo $text_getlonglat;?>" onclick="GetLongLat()" style="border: solid 1px gray; border-width:thin;width:25%;min-width:120px;"/>
										
									</div>
								</div>
            
            					<div class="form-group display"  >
									<label class="col-sm-2 control-label" for="location"><?php echo $entry_location ?></label>
									<div class="col-sm-10">
										<input type="text" name="location" id="location" value="<?php echo $location; ?>" style="width:73%;"/> <input type="button"  value="<?php echo $text_danhdaubando;?>" onclick="ShowGMapDialog()" style="border: solid 1px gray; border-width:thin;width:25%;min-width:120px;"/>
										<?php if(!empty($error_location)){?>
										<div class="text-danger"><?php echo $error_location; ?></div>
										<?php }?>
									</div>
								</div>
            
            					<div class="form-group" style="display:none" >
									<label class="col-sm-2 control-label" for="input-timeface">
                                    <span data-toggle="tooltip" title="<?php echo $help_loop_picture; ?>"><?php echo $entry_timeface; ?></span><br/>
                                    <p class="s-mobile s-mobile-help"><?php echo $help_loop_picture ?></p>
                                  	</label>
                                    
									<div class="col-sm-10">
										<input type="text" name="timeface" value="<?php echo $timeface; ?>" id="input-timeface" class="form-control" />
                                        <?php if (isset($error_timeface) && !empty($error_timeface)) { ?>
                                        <div class="text-danger"><?php echo $error_timeface; ?></div>
                                        <?php } ?>
									</div>
								</div>
            <!--{FORM_IMAGE}-->

								<div class="form-group"  >
									<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
									<div class="col-sm-10">
										<select name="status" id="input-status" class="form-control">
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

								<div class="form-group" >
									<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
									</div>
								</div>

							</div>
						</div>
						<!--{TAB_DATA}-->
                        
                        <div class="tab-pane " id="tab-seo">
              <ul class="nav nav-tabs" id="language-seo">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language-seo<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language-seo<?php echo $language['language_id']; ?>">

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact_description[<?php echo $language['language_id']; ?>][meta_title]"><?php echo $entry_meta_title ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" id="contact_description[<?php echo $language['language_id']; ?>][meta_title]" type="text" name="contact_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_title'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact_description[<?php echo $language['language_id']; ?>][meta_description]"><?php echo $entry_meta_description ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="contact_description[<?php echo $language['language_id']; ?>][meta_description]" id="contact_description[<?php echo $language['language_id']; ?>][meta_description]" ><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact_description[<?php echo $language['language_id']; ?>][meta_keyword]"><?php echo $entry_meta_keyword ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="contact_description[<?php echo $language['language_id']; ?>][meta_keyword]" id="contact_description[<?php echo $language['language_id']; ?>][meta_keyword]" ><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact_description[<?php echo $language['language_id']; ?>][meta_title_og]"><?php echo $entry_meta_title_og; ?></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="contact_description[<?php echo $language['language_id']; ?>][meta_title_og]" id="contact_description[<?php echo $language['language_id']; ?>][meta_title_og]" value="<?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_title_og'] : ''; ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo $entry_meta_description_og ?></label>
                    <div class="col-sm-10">
                      <textarea class="form-control"  name="contact_description[<?php echo $language['language_id']; ?>][meta_description_og]" id="contact_description[<?php echo $language['language_id']; ?>][meta_description_og]" ><?php echo isset($contact_description[$language['language_id']]) ? $contact_description[$language['language_id']]['meta_description_og'] : ''; ?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
										<label class="col-sm-2 control-label" for="contact_keyword[<?php echo $language['language_id']; ?>][keyword]" >
                                        <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
										<p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                                        </label>
										<div class="col-sm-10">
											<input class="form-control"  name="contact_keyword[<?php echo $language['language_id']; ?>][keyword]" id="contact_keyword[<?php echo $language['language_id']; ?>][keyword]" value="<?php echo isset($contact_keyword[$language['language_id']]) ? $contact_keyword[$language['language_id']]['keyword'] : ''; ?>" />
										</div>
									</div>

                </div>
                <?php } ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    <span data-toggle="tooltip" title="<?php echo $help_entry_image_og; ?>"><?php echo $entry_image_og; ?></span><br/>
                    <p class="s-mobile s-mobile-help"><?php echo $help_entry_image_og ?></p>
                  </label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <a href="" id="thumb-imageog" data-toggle="image" class="img-thumbnail">
                        <img src="<?php if(empty($preview_og)) echo 'view/image/image.png'; else echo $preview_og; ?>" alt="" title="" data-placeholder="<?php echo $image_og; ?>" />
                      </a>
                      <input type="hidden" name="image_og" value="<?php echo $image_og; ?>" id="input-imageog" />
                    </label>
                    <label class="radio-inline">
                      <input type="checkbox" name="delete_image_og" value="1" /> <?php echo $entry_delete_image;?>
                    </label>
                  </div>
                </div>
              </div>

              <!--<div class="form-group">
                <label class="col-sm-2 control-label" for="keyword">
                  <span data-toggle="tooltip" title="<?php echo $help_friendly_url; ?>"><?php echo $entry_friendly_url; ?></span><br/>
                  <p class="s-mobile s-mobile-help"><?php echo $help_friendly_url ?></p>
                </label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="form-control" />
                </div>
              </div>-->
            </div>
					</div>

				</form>
			</div>
		</div>
	</div>
    <script language="javascript" type="text/javascript">
		var map;
		function ShowGMapDialog(){
			if(!map || map.closed)
				map=window.open("./googlemap.html","_blank","height=550px, width=820px",null);
			map.focus();
		}
		function getCurrentLocation(){
			return  $('#location').attr('value');
		}
		function getLocation(v){
			$('#location').attr('value',v);
		}
		$(window).unload(function() {
			//console.log(map)
			//if(map ||!map.close)map.close();
		});
		
		function GetLongLat(){
			var geocoder = new google.maps.Geocoder();
			var address = $('#address_location').val();
			
			geocoder.geocode( { 'address': address}, function(results, status) {
			
			  if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				//alert(latitude);
				$('#location').attr('value',latitude + ',' + longitude);
				$('#location').val(latitude + ',' + longitude);
			  }else{
				  alert("<?php echo $error_address_map;?>");
			  }
			}); 


		}
	</script>
    
    <script>
/*$(document).ready(function() {	
	if($("#ishome:checked").val()=='1')
	{
		$(".display").show();
	}else
	{
		$(".display").hide();
	}
	$("#ishome").click(function(){
		if($("#ishome:checked").val()=='1')
		{
			$(".display").show();
		}else
		{
			$(".display").hide();
		}
	});
});*/
</script>

	<script type="text/javascript">
		<?php foreach ($languages as $language) { ?>
			$("#input-description<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'150px', styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'italic', 'underline','superscript', 'subscript', 'clear']],['history', ['undo', 'redo']],['insert', ['link']],['style', ['style']]],
			});
			$('#input-description' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');
			/*$("#input-name-1<?php echo $language['language_id']; ?>").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'50px', styleWithSpan: false,toolbar: [['view', ['codeview']],['font', ['bold', 'clear']],['history', ['undo', 'redo']],['style', ['style']],]
				
				//onChange: function(contents, $editable) {
//					clean_html(this, "b", contents);
//					clean_html(this, "p", contents);
//				}
			});
			$('#input-name-1' + <?php echo $language['language_id']; ?>).parent().find('.note-style.btn-group').css('display','none');*/
			
			<?php } ?>
			
			$("#input-phonelist").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'70px', styleWithSpan: false,toolbar: [['view', ['codeview']],['insert', ['link']],['style', ['style']],],
			});
			
			$("#input-hotlinelist").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'70px', styleWithSpan: false,toolbar: [['view', ['codeview']],['insert', ['link']],['style', ['style']],],
			});
			
			$("#input-faxlist").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'70px', styleWithSpan: false,toolbar: [['view', ['codeview']],['insert', ['link']],['style', ['style']],],
			});
			$("#input-emaillist").summernote({
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					setTimeout( function(){
						document.execCommand( 'insertText', false, bufferText );
					}, 10 );
				},'height':'70px', styleWithSpan: false,toolbar: [['view', ['codeview']],['insert', ['link']],['style', ['style']],],
			});
			
			$('#input-faxlist').parent().find('.note-style.btn-group').css('display','none');
			$('#input-emaillist').parent().find('.note-style.btn-group').css('display','none');
			$('#input-hotlinelist').parent().find('.note-style.btn-group').css('display','none');
			$('#input-phonelist').parent().find('.note-style.btn-group').css('display','none');
			
			
			
			
		//
	</script>
	<!--{VIEW_SCRIPT}-->
	
<!--{SCRIPT_IMAGE}-->
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
	<script type="text/javascript">
		$('#language a:first').tab('show');
		$('#language-seo a:first').tab('show');
		$('#option a:first').tab('show');
	</script>
</div>
<?php echo $footer; ?>