
function hideerror(){
	$(".formError").remove();
}
function hidemsg(){
	$(".contact-success").remove();
	$(".register-success").remove();
}
		
function checkEmail(id) {
	var email = document.getElementById(id);
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email.value)) {				
		return false;
	}
	return true;
}

function checkNull(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val().trim();
	if(name=='' || name==defaultvalue){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkPhone(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val().trim();
	if(name=='' || name==defaultvalue || name.length<10 || name.length>11){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkMail(id, mess, defaultvalue, left, top){
	if(!checkEmail(id)){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError" ><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkCaptcha(id, mess, defaultvalue, left, top){
	var captcha = $('#'+id).val().trim();
	var captcha_bk = $('#'+id+'_bk').val().trim();
	
	if(captcha!=captcha_bk ){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError" ><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkNullTwo(id,id1,mess,defaultvalue,defaultvalue1,left,top){var name=$('#'+id).val().trim();var name1=$('#'+id1).val().trim();if(name==''||name==defaultvalue || name1==''||name1==defaultvalue1){if($('#error_'+id).length>0){$('#error_'+id).html(mess);}else{$('#'+id).after('<div class="nameformError parentFormfrm_contact formError" ><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');}
return false;}
return true;}


function checkSelect(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val();
	if(name=='' || name==defaultvalue  || name==0){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkComment(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val().trim();
	
	if($('#other-check:checked').length && (name=='' || name==defaultvalue)){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		
		return false;
	}
	
	return true;
}

function checkNhucau(id, mess, defaultvalue, left, top){
	//var name = $('#'+id).val().trim();
	
	if(!$('#other-check:checked').length){
		if(!$('.'+id+':checked').length ){
			if($('#error_'+id).length>0){
				$('#error_'+id).html(mess);
			}else{
				$('.'+id+':first').after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
			}
			return false;
		}
		
	}
	
	return true;
}

function checkCheckbox(id, mess, defaultvalue, left, top){
	
	if(!$('.'+id+':checked').length ){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('.'+id+':first').after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
		

	
	return true;
}

function checkQuocTich(id, mess, defaultvalue, left, top){
	
	if(!$('.'+id+':checked').length ){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('.'+id+':first').parent().after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
		

	
	return true;
}

function checkCMND(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val().trim();
	if(name=='' || name==defaultvalue || (name.length!=9 && name.length!=12)){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function checkPassport(id, mess, defaultvalue, left, top){
	var name = $('#'+id).val().trim();
	if(name=='' || name==defaultvalue || name.length>12){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}
	
	return true;
}

function parseDate(str) {
  var mdy = str.split('/');
  return new Date(mdy[2], mdy[1], mdy[0]);
}

function checkDate(id, mess, defaultvalue, left, top, mess_old){
	var name = $('#'+id).val().trim();
	
	var arr_temp = name.split('/');
	
	var name1 = arr_temp[0] + '/' + arr_temp[1] + '/' + (parseInt(arr_temp[2])+2);
	var d = new Date();
	
	var startDate = parseDate(name1).getTime();
	var endDate = parseDate(d.getDate() + "/" + d.getMonth() + "/" + d.getFullYear()).getTime();
	

	if(name=='' || name==defaultvalue ){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess+'</div></div>');
		}
		return false;
	}else if(startDate > endDate){
		if($('#error_'+id).length>0){
			$('#error_'+id).html(mess_old);
		}else{
			$('#'+id).after('<div class="nameformError parentFormfrm_contact formError"><div id="error_'+id+'" class="formErrorContent">'+mess_old+'</div></div>');
		}
		return false;
	}
	
	return true;
}




////////////////////////////////////////////////////////////////////////


(function($) {

    var methods = {

        /**
         * Kind of the constructor, called before any action
         * @param {Map} user options
         */
        init: function(options) {               
            var form = this;			
            if (!form.data('jqv') || form.data('jqv') == null ) {		
                options = methods._saveOptions(form, options);                  				
				// bind all formError elements to close on click
				$(".formError").live("click", function() {
                  
					$(this).fadeOut(150, function() {
					 // remove prompt once invisible
					   $(this).parent('.formErrorOuter').remove();
					   $(this).remove();
					});
				});

            }
            return this;
        },
      
        attach: function(userOptions) {
			
            var form = this;
            var options;

            if(userOptions)
                options = methods._saveOptions(form, userOptions);
            else
                options = form.data('jqv');

			var validateAttribute = (form.find("[data-validation-engine*=validate]")) ? "data-validation-engine" : "class";
			
            if (!options.binded) {
				if (options.bindMethod == "bind"){
				
					// bind fields
                    form.find("[class*=validate]").not("[type=checkbox]").not("[type=radio]").not(".datepicker").bind(options.validationEventTrigger, methods._onFieldEvent);
                    form.find("[class*=validate][type=checkbox],[class*=validate][type=radio]").bind("click", methods._onFieldEvent);
					form.find("[class*=validate][class*=datepicker]").bind(options.validationEventTrigger,{"delay": 300}, methods._onFieldEvent);

                    // bind form.submit
                    form.bind("submit", methods._onSubmitEvent);
				} else if (options.bindMethod == "live") {
                    // bind fields with LIVE (for persistant state)
                    form.find("[class*=validate]").not("[type=checkbox]").not(".datepicker").live(options.validationEventTrigger, methods._onFieldEvent);
                    form.find("[class*=validate][type=checkbox]").live("click", methods._onFieldEvent);
					form.find("[class*=validate][class*=datepicker]").live(options.validationEventTrigger,{"delay": 300}, methods._onFieldEvent);

                    // bind form.submit
                    form.live("submit", methods._onSubmitEvent);
				}

               	options.binded = true;
	
				if (options.autoPositionUpdate) {
	    			$(window).bind("resize", {
						"noAnimation": true, 
						"formElem": form
	    				}, methods.updatePromptsPosition);
				}
		
           }
           return this;
        },
        /**
         * Unregisters any bindings that may point to jQuery.validaitonEngine
         */
        detach: function() {
            var form = this;
            var options = form.data('jqv');
            if (options.binded) {

                // unbind fields
                form.find("[class*=validate]").not("[type=checkbox]").unbind(options.validationEventTrigger, methods._onFieldEvent);
                form.find("[class*=validate][type=checkbox],[class*=validate][type=radio]").unbind("click", methods._onFieldEvent);

                // unbind form.submit
                form.unbind("submit", methods.onAjaxFormComplete);
                
                // unbind live fields (kill)
                form.find("[class*=validate]").not("[type=checkbox]").die(options.validationEventTrigger, methods._onFieldEvent);
                form.find("[class*=validate][type=checkbox]").die("click", methods._onFieldEvent);
                
				// unbind form.submit
                form.die("submit", methods.onAjaxFormComplete);
                
                form.removeData('jqv');
		
				if (options.autoPositionUpdate) {
		    		$(window).unbind("resize", methods.updatePromptsPosition)
				}
           	}
            return this;
        },
       
        validate: function() {
            return methods._validateFields(this);
        },
      
        validateField: function(el) {
            var options = $(this).data('jqv');
            var r = methods._validateField($(el), options);

            if (options.onSuccess && options.InvalidFields.length == 0)
                options.onSuccess();
            else if (options.onFailure && options.InvalidFields.length > 0)
                options.onFailure();

            return r;
        },
     
        validateform: function() {
            return methods._onSubmitEvent.call(this);
        },
		/**
         *  Redraw prompts position, useful when you change the DOM state when validating
         */
        updatePromptsPosition: function(event) {
	    
			if (event && this == window)
				var form = event.data.formElem, noAnimation = event.data.noAnimation;
		    else
				var form = $(this.closest('form'));
            
			var options = form.data('jqv');
	        // No option, take default one
		    form.find('[class*=validate]').not(':hidden').not(":disabled").each(function(){
			   	var field = $(this);
			   	var prompt = methods._getPrompt(field);
			   	var promptText = $(prompt).find(".formErrorContent").html();

			   	if(prompt)
					methods._updatePrompt(field, $(prompt), promptText, undefined, false, options, noAnimation);
		    })
	        return this;
        },
      
        showPrompt: function(promptText, type, promptPosition, showArrow) {

            var form = this.closest('form');
            var options = form.data('jqv');
            // No option, take default one
			if(!options) options = methods._saveOptions(this, options);
            if(promptPosition)
                options.promptPosition=promptPosition;
            options.showArrow = showArrow==true;

            methods._showPrompt(this, promptText, type, false, options);
            return this;
        },
        /**
         * Closes all error prompts on the page
         */
        hidePrompt: function() {
        	var promptClass =  "."+ methods._getClassName($(this).attr("id")) + "formError";
            $(promptClass).fadeTo("fast", 0.3, function() {
		$(this).parent('.formErrorOuter').remove();
                $(this).remove();
            });
            return this;
        },
        /**
         * Closes form error prompts, CAN be invidual
         */
        hide: function() {
			var closingtag;
        	if($(this).is("form")){
        		closingtag = "parentForm"+methods._getClassName($(this).attr("id"));
        	}else{
        		closingtag = methods._getClassName($(this).attr("id")) +"formError";
        	}
            $('.'+closingtag).fadeTo("fast", 0.3, function() {
		$(this).parent('.formErrorOuter').remove();
                $(this).remove();
            });
            return this;
        },
        /**
         * Closes all error prompts on the page
         */
        hideAll: function() {
            $('.formError').fadeTo("fast", 0.3, function() {
		$(this).parent('.formErrorOuter').remove();
                $(this).remove();
            });
            return this;
        },
        /**
         * Typically called when user exists a field using tab or a mouse click, triggers a field
         * validation
         */
        _onFieldEvent: function(event) {
            var field = $(this);
            var form = field.closest('form');
            var options = form.data('jqv');
            // validate the current field
			window.setTimeout(function() {
			    methods._validateField(field, options);
				if (options.InvalidFields.length == 0 && options.onSuccess) {
					options.onSuccess();
				} else if (options.InvalidFields.length > 0 && options.onFailure) {
					options.onFailure();
				}
			}, (event.data) ? event.data.delay : 0);
            
        },
        /**
         * Called when the form is submited, shows prompts accordingly
         *
         * @param {jqObject}
         *            form
         * @return false if form submission needs to be cancelled
         */
        _onSubmitEvent: function() {
            var form = $(this);
 			var options = form.data('jqv');
   
			// validate each field (- skip field ajax validation, no necessary since we will perform an ajax form validation)
            var r=methods._validateFields(form, true);
		
            if (r && options.ajaxFormValidation) {
                methods._validateFormWithAjax(form, options);
                return false;
            }

            if(options.onValidationComplete) {
                options.onValidationComplete(form, r);
                return false;
            }
            return r;
        },

        /**
         * Return true if the ajax field validations passed so far
         * @param {Object} options
         * @return true, is all ajax validation passed so far (remember ajax is async)
         */
        _checkAjaxStatus: function(options) {
            var status = true;
            $.each(options.ajaxValidCache, function(key, value) {
                if (!value) {
                    status = false;
                    // break the each
                    return false;
                }
            });
            return status;
        },
        /**
         * Validates form fields, shows prompts accordingly
         *
         * @param {jqObject}
         *            form
         * @param {skipAjaxFieldValidation}
         *            boolean - when set to true, ajax field validation is skipped, typically used when the submit button is clicked
         *
         * @return true if form is valid, false if not, undefined if ajax form validation is done
         */
        _validateFields: function(form, skipAjaxValidation) {
            var options = form.data('jqv');

            // this variable is set to true if an error is found
            var errorFound = false;
			
			// Trigger hook, start validation
			form.trigger("jqv.form.validating");
            // first, evaluate status of non ajax fields
			var first_err=null;
            form.find('[class*=validate]').not(':hidden').not(":disabled").each( function() {
                var field = $(this);
                errorFound |= methods._validateField(field, options, skipAjaxValidation);
				field.focus();
                if (options.doNotShowAllErrosOnSubmit)
                    return false;
		    if (errorFound && first_err==null) first_err=field; 
            });
            // second, check to see if all ajax calls completed ok
            // errorFound |= !methods._checkAjaxStatus(options);
			
            // thrird, check status and scroll the container accordingly
			form.trigger("jqv.form.result", [errorFound]);
			
		if (errorFound) {				
      		if (options.scroll) {	
				var destination=first_err.offset().top;
				var fixleft = first_err.offset().left;

				//prompt positioning adjustment support. Usage: positionType:Xshift,Yshift (for ex.: bottomLeft:+20 or bottomLeft:-20,+10)
				var positionType=options.promptPosition;
				if (typeof(positionType)=='string') {
					if (positionType.indexOf(":")!=-1) {
						positionType=positionType.substring(0,positionType.indexOf(":"));
					}
				}

				if (positionType!="bottomRight"&& 
				    positionType!="bottomLeft") {
					var prompt_err= methods._getPrompt(first_err);
					destination=prompt_err.offset().top;
				}

					// get the position of the first error, there should be at least one, no need to check this
                    //var destination = form.find(".formError:not('.greenPopup'):first").offset().top;
                 		if (options.isOverflown) {
                            	var overflowDIV = $(options.overflownDIV);
                                if(!overflowDIV.length) return false;
    	                        var scrollContainerScroll = overflowDIV.scrollTop();
          	                  	var scrollContainerPos = -parseInt(overflowDIV.offset().top);
    	
          	                  	destination += scrollContainerScroll + scrollContainerPos - 5;
                	            var scrollContainer = $(options.overflownDIV + ":not(:animated)");

                      	      	scrollContainer.animate({ scrollTop: destination }, 1100);
    					}else{
                                $("html:not(:animated),body:not(:animated)").animate({
                                    scrollTop: destination,
                                    scrollLeft: fixleft
                                 }, 1100, function(){
                                    if(options.focusFirstField) first_err.focus();      
                                });
                        }
                 
				} else if(options.focusFirstField)
				 	first_err.focus();
                return false;
            }
            return true;
        },
        /**
         * This method is called to perform an ajax form validation.
         * During this process all the (field, value) pairs are sent to the server which returns a list of invalid fields or true
         *
         * @param {jqObject} form
         * @param {Map} options
         */
        _validateFormWithAjax: function(form, options) {

            var data = form.serialize();
			var url = (options.ajaxFormValidationURL) ? options.ajaxFormValidationURL : form.attr("action");
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                dataType: "json",
                data: data,
                form: form,
                methods: methods,
                options: options,
                beforeSend: function() {
                    return options.onBeforeAjaxFormValidation(form, options);
                },
                error: function(data, transport) {
                    methods._ajaxError(data, transport);
                },
                success: function(json) {

                    if (json !== true) {

                        // getting to this case doesn't necessary means that the form is invalid
                        // the server may return green or closing prompt actions
                        // this flag helps figuring it out
                        var errorInForm=false;
                        for (var i = 0; i < json.length; i++) {
                            var value = json[i];
						
                            var errorFieldId = value[0];
                            var errorField = $($("#" + errorFieldId)[0]);
							
                            // make sure we found the element
                            if (errorField.length == 1) {
								
                                // promptText or selector
                                var msg = value[2];
								// if the field is valid
                                if (value[1] == true) {

                                    if (msg == ""  || !msg){
                                        // if for some reason, status==true and error="", just close the prompt
                                        methods._closePrompt(errorField);
                                    } else {
                                        // the field is valid, but we are displaying a green prompt
                                        if (options.allrules[msg]) {
                                            var txt = options.allrules[msg].alertTextOk;
                                            if (txt)
                                                msg = txt;
                                        }
                                        methods._showPrompt(errorField, msg, "pass", false, options, true);
                                    }

                                } else {
                                    // the field is invalid, show the red error prompt
                                    errorInForm|=true;
                                    if (options.allrules[msg]) {
                                        var txt = options.allrules[msg].alertText;
                                        if (txt)
                                            msg = txt;
                                    }
                                    methods._showPrompt(errorField, msg, "", false, options, true);
                                }
                            }
                        }
                        options.onAjaxFormComplete(!errorInForm, form, json, options);
                    } else
                        options.onAjaxFormComplete(true, form, "", options);
                }
            });

        },
        /**
         * Validates field, shows prompts accordingly
         *
         * @param {jqObject}
         *            field
         * @param {Array[String]}
         *            field's validation rules
         * @param {Map}
         *            user options
         * @return true if field is valid
         */
        _validateField: function(field, options, skipAjaxValidation) {
            if (!field.attr("id"))
                $.error("jQueryValidate: an ID attribute is required for this field: " + field.attr("name") + " class:" +
                field.attr("class"));

            var rulesParsing = field.attr('class');
            var getRules = /validate\[(.*)\]/.exec(rulesParsing);
			
            if (!getRules)
                return false;
            var str = getRules[1];
            var rules = str.split(/\[|,|\]/);
	
            // true if we ran the ajax validation, tells the logic to stop messing with prompts
            var isAjaxValidator = false;
            var fieldName = field.attr("name");
            var promptText = "";
			var required = false;
            options.isError = false;
            options.showArrow = true;

			var form = $(field.closest("form"));

            for (var i = 0; i < rules.length; i++) {
				// Fix for adding spaces in the rules
				rules[i] = rules[i].replace(" ", "")
                var errorMsg = undefined;
                switch (rules[i]) {

                    case "required":
                        required = true;
                        errorMsg = methods._required(field, rules, i, options);
                        break;
                    case "custom":
                        errorMsg = methods._customRegex(field, rules, i, options);
                        break;
					case "groupRequired":
						// Check is its the first of group, if not, reload validation with first field
						// AND continue normal validation on present field
						var classGroup = "[class*=" +rules[i + 1] +"]";	
						var firstOfGroup = form.find(classGroup).eq(0);
						if(firstOfGroup[0] != field[0]){
							methods._validateField(firstOfGroup, options, skipAjaxValidation)
							options.showArrow = true;
							continue;
						};
                        errorMsg = methods._groupRequired(field, rules, i, options);
						if(errorMsg) required = true;
						options.showArrow = false;
                        break;
                    case "ajax":
                        // ajax has its own prompts handling technique
						if(!skipAjaxValidation){
							methods._ajax(field, rules, i, options);
	                        isAjaxValidator = true;
						}
                        break;
                    case "minSize":
                        errorMsg = methods._minSize(field, rules, i, options);
                        break;
                    case "maxSize":
                        errorMsg = methods._maxSize(field, rules, i, options);
                        break;
                    case "min":
                        errorMsg = methods._min(field, rules, i, options);
                        break;
                    case "max":
                        errorMsg = methods._max(field, rules, i, options);
                        break;
                    case "past":
                        errorMsg = methods._past(field, rules, i, options);
                        break;
                    case "future":
                        errorMsg = methods._future(field, rules, i, options);
                        break;
                    case "dateRange":
                        var classGroup = "[class*=" + rules[i + 1] + "]";
                        var firstOfGroup = form.find(classGroup).eq(0);
                        var secondOfGroup = form.find(classGroup).eq(1);

                        //if one entry out of the pair has value then proceed to run through validation
                        if (firstOfGroup[0].value || secondOfGroup[0].value) {
                            errorMsg = methods._dateRange(firstOfGroup, secondOfGroup, rules, i, options);
                        }
                        if (errorMsg) required = true;
                        options.showArrow = false;
                        break;

                    case "dateTimeRange":
                        var classGroup = "[class*=" + rules[i + 1] + "]";
                        var firstOfGroup = form.find(classGroup).eq(0);
                        var secondOfGroup = form.find(classGroup).eq(1);

                        //if one entry out of the pair has value then proceed to run through validation
                        if (firstOfGroup[0].value || secondOfGroup[0].value) {
                            errorMsg = methods._dateTimeRange(firstOfGroup, secondOfGroup, rules, i, options);
                        }
                        if (errorMsg) required = true;
                        options.showArrow = false;
                        break;
                    case "maxCheckbox":
                        errorMsg = methods._maxCheckbox(form, field, rules, i, options);
                        field = $(form.find("input[name='" + fieldName + "']"));
                        break;
                    case "minCheckbox":
                        errorMsg = methods._minCheckbox(form, field, rules, i, options);
                        field = $(form.find("input[name='" + fieldName + "']"));
                        break;
                    case "equals":
                        errorMsg = methods._equals(field, rules, i, options);
                        break;
                    case "funcCall":
                        errorMsg = methods._funcCall(field, rules, i, options);
                        break;
                    case "creditCard":
                        errorMsg = methods._creditCard(field, rules, i, options);
                        break;

                    default:
                    //$.error("jQueryValidator rule not found"+rules[i]);
                }
                if (errorMsg !== undefined) {
                    promptText += errorMsg + "<br/>";
                    options.isError = true;
                }
            }
            // If the rules required is not added, an empty field is not validated
            if(!required && field.val() == "") options.isError = false;

            // Hack for radio/checkbox group button, the validation go into the
            // first radio/checkbox of the group
            var fieldType = field.prop("type");

            if ((fieldType == "radio" || fieldType == "checkbox") && form.find("input[name='" + fieldName + "']").size() > 1) {
                field = $(form.find("input[name='" + fieldName + "'][type!=hidden]:first"));
                options.showArrow = false;
            }
			
            if (fieldType == "text" && form.find("input[name='" + fieldName + "']").size() > 1) {
                field = $(form.find("input[name='" + fieldName + "'][type!=hidden]:first"));
                options.showArrow = false;
            }

            if (options.isError){
                methods._showPrompt(field, promptText, "", false, options);
            }else{
                if (!isAjaxValidator) methods._closePrompt(field);
            }
	    
            if (!isAjaxValidator) {
              field.trigger("jqv.field.result", [field, options.isError, promptText]);
            }

            /* Record error */
            var errindex = $.inArray(field[0], options.InvalidFields);
            if (errindex == -1) {
                if (options.isError)
                    options.InvalidFields.push(field[0]);
            } else if (!options.isError) {
                options.InvalidFields.splice(errindex, 1);
            }

            return options.isError;
        },
     
        _required: function(field, rules, i, options) {
            switch (field.prop("type")) {
                case "text":
                case "password":
                case "textarea":
                case "file":
                default:
                    if (!field.val())
                        return options.allrules[rules[i]].alertText;
                    break;
                case "radio":
                case "checkbox":
					var form = field.closest("form");
                    var name = field.attr("name");
                    if (form.find("input[name='" + name + "']:checked").size() == 0) {
                        if (form.find("input[name='" + name + "']").size() == 1)
                            return options.allrules[rules[i]].alertTextCheckboxe;
                        else
                            return options.allrules[rules[i]].alertTextCheckboxMultiple;
                    }
                    break;
                // required for <select>
                case "select-one":
                    // added by paul@kinetek.net for select boxes, Thank you
                    if (!field.val())
                        return options.allrules[rules[i]].alertText;
                    break;
                case "select-multiple":
                    // added by paul@kinetek.net for select boxes, Thank you
                    if (!field.find("option:selected").val())
                        return options.allrules[rules[i]].alertText;
                    break;
            }
        },
		
        _groupRequired: function(field, rules, i, options) {
            var classGroup = "[class*=" +rules[i + 1] +"]";
			var isValid = false;
			// Check all fields from the group
			field.closest("form").find(classGroup).each(function(){
				if(!methods._required($(this), rules, i, options)){
					isValid = true;
					return false;
				}
			})
			
			if(!isValid) return options.allrules[rules[i]].alertText;
        },
       
        _customRegex: function(field, rules, i, options) {
            var customRule = rules[i + 1];
			var rule = options.allrules[customRule];
			if(!rule) {
				alert("jqv:custom rule not found "+customRule);
				return;
			}
			
			var ex=rule.regex;
			if(!ex) {
				alert("jqv:custom regex not found "+customRule);
				return;
			}
            var pattern = new RegExp(ex);

            if (!pattern.test(field.val()))
                return options.allrules[customRule].alertText;
        },
       
        _funcCall: function(field, rules, i, options) {
            var functionName = rules[i + 1];
            var fn = window[functionName] || options.customFunctions[functionName];
            if (typeof(fn) == 'function')
                return fn(field, rules, i, options);

        },
      
        _equals: function(field, rules, i, options) {
            var equalsField = rules[i + 1];

            if (field.val() != $("#" + equalsField).val())
                return options.allrules.equals.alertText;
        },
       
        _maxSize: function(field, rules, i, options) {
            var max = rules[i + 1];
            var len = field.val().length;

            if (len > max) {
                var rule = options.allrules.maxSize;
                return rule.alertText + max + rule.alertText2;
            }
        },
       
        _minSize: function(field, rules, i, options) {
            var min = rules[i + 1];
            var len = field.val().length;

            if (len < min) {
                var rule = options.allrules.minSize;
                return rule.alertText + min + rule.alertText2;
            }
        },
        
        _min: function(field, rules, i, options) {
            var min = parseFloat(rules[i + 1]);
            var len = parseFloat(field.val());

            if (len < min) {
                var rule = options.allrules.min;
                if (rule.alertText2) return rule.alertText + min + rule.alertText2;
                return rule.alertText + min;
            }
        },
        
        _max: function(field, rules, i, options) {
            var max = parseFloat(rules[i + 1]);
            var len = parseFloat(field.val());

            if (len >max ) {
                var rule = options.allrules.max;
                if (rule.alertText2) return rule.alertText + max + rule.alertText2;
                //orefalo: to review, also do the translations
                return rule.alertText + max;
            }
        },
       
        _past: function(field, rules, i, options) {

            var p=rules[i + 1];
            var pdate = (p.toLowerCase() == "now")? new Date():methods._parseDate(p);
            var vdate = methods._parseDate(field.val());

            if (vdate > pdate ) {
                var rule = options.allrules.past;
                if (rule.alertText2) return rule.alertText + methods._dateToString(pdate) + rule.alertText2;
                return rule.alertText + methods._dateToString(pdate);
            }
        },
      
        _future: function(field, rules, i, options) {

            var p=rules[i + 1];
            var pdate = (p.toLowerCase() == "now")? new Date():methods._parseDate(p);
            var vdate = methods._parseDate(field.val());

            if (vdate < pdate ) {
                var rule = options.allrules.future;
                if (rule.alertText2) return rule.alertText + methods._dateToString(pdate) + rule.alertText2;
                return rule.alertText + methods._dateToString(pdate);
            }
        },
      
        _isDate: function (value) {
            var dateRegEx = new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/);
            if (dateRegEx.test(value)) {
                return true;
            }
            return false;
        },
       
        _isDateTime: function (value){
            var dateTimeRegEx = new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/);
            if (dateTimeRegEx.test(value)) {
                return true;
            }
            return false;
        },
        
        _dateCompare: function (start, end) {
            return (new Date(start.toString()) < new Date(end.toString()));
        },
        
        _dateRange: function (first, second, rules, i, options) {
            //are not both populated
            if ((!first[0].value && second[0].value) || (first[0].value && !second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }

            //are not both dates
            if (!methods._isDate(first[0].value) || !methods._isDate(second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }

            //are both dates but range is off
            if (!methods._dateCompare(first[0].value, second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }
        },


        _dateTimeRange: function (first, second, rules, i, options) {
            //are not both populated
            if ((!first[0].value && second[0].value) || (first[0].value && !second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }
            //are not both dates
            if (!methods._isDateTime(first[0].value) || !methods._isDateTime(second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }
            //are both dates but range is off
            if (!methods._dateCompare(first[0].value, second[0].value)) {
                return options.allrules[rules[i]].alertText + options.allrules[rules[i]].alertText2;
            }
        },
       
        _maxCheckbox: function(form, field, rules, i, options) {

            var nbCheck = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = form.find("input[name='" + groupname + "']:checked").size();
            if (groupSize > nbCheck) {
                options.showArrow = false;
                if (options.allrules.maxCheckbox.alertText2) return options.allrules.maxCheckbox.alertText + " " + nbCheck + " " + options.allrules.maxCheckbox.alertText2;
                return options.allrules.maxCheckbox.alertText;
            }
        },
       
        _minCheckbox: function(form, field, rules, i, options) {

            var nbCheck = rules[i + 1];
            var groupname = field.attr("name");
            var groupSize = form.find("input[name='" + groupname + "']:checked").size();
            if (groupSize < nbCheck) {
                options.showArrow = false;
                return options.allrules.minCheckbox.alertText + " " + nbCheck + " " + options.allrules.minCheckbox.alertText2;
            }
        },
      
        _creditCard: function(field, rules, i, options) {
            //spaces and dashes may be valid characters, but must be stripped to calculate the checksum.
            var valid = false, cardNumber = field.val().replace(/ +/g, '').replace(/-+/g, '');
        
            var numDigits = cardNumber.length;
            if (numDigits >= 14 && numDigits <= 16 && parseInt(cardNumber) > 0) {
        
                var sum = 0, i = numDigits - 1, pos = 1, digit, luhn = new String();
                do {
                    digit = parseInt(cardNumber.charAt(i));
                    luhn += (pos++ % 2 == 0) ? digit * 2 : digit;
                } while (--i >= 0)
        
                for (i = 0; i < luhn.length; i++) {
                    sum += parseInt(luhn.charAt(i));
                }
                valid = sum % 10 == 0;
            } 
            if (!valid) return options.allrules.creditCard.alertText;
        },
      
        _ajax: function(field, rules, i, options) {
			
            var errorSelector = rules[i + 1];
            var rule = options.allrules[errorSelector];
            var extraData = rule.extraData;
            var extraDataDynamic = rule.extraDataDynamic;

            if (!extraData)
                extraData = "";

            if (extraDataDynamic) {
              var tmpData = [];
              var domIds = String(extraDataDynamic).split(",");
              for (var i = 0; i < domIds.length; i++) {
                var id = domIds[i];
                if ($(id).length) {
                  var inputValue = field.closest("form").find(id).val();
                  var keyValue = id.replace('#', '') + '=' + escape(inputValue);
                  tmpData.push(keyValue);
                }
              }
              extraDataDynamic = tmpData.join("&");
            } else {
              extraDataDynamic = "";              
            }
                                
            if (!options.isError) {
                $.ajax({
                    type: "GET",
                    url: rule.url,
                    cache: false,
                    dataType: "json",
                    data: "fieldId=" + field.attr("id") + "&fieldValue=" + field.val() + "&extraData=" + extraData + "&" + extraDataDynamic,
                    field: field,
                    rule: rule,
                    methods: methods,
                    options: options,
                    beforeSend: function() {
                        // build the loading prompt
                        var loadingText = rule.alertTextLoad;
                        if (loadingText)
                            methods._showPrompt(field, loadingText, "load", true, options);
                    },
                    error: function(data, transport) {
                        methods._ajaxError(data, transport);
                    },
                    success: function(json) {
						
                        // asynchronously called on success, data is the json answer from the server
                        var errorFieldId = json[0];
                        var errorField = $($("#" + errorFieldId)[0]);
                        // make sure we found the element
                        if (errorField.length == 1) {
                            var status = json[1];
							// read the optional msg from the server
							var msg = json[2];
                            if (!status) {
                                // Houston we got a problem - display an red prompt
                                options.ajaxValidCache[errorFieldId] = false;
                                options.isError = true;

								// resolve the msg prompt
								if(msg) {
									if (options.allrules[msg]) {
                                    	var txt = options.allrules[msg].alertText;
                                    	if (txt)
                                    		msg = txt;
                                    }
								}
								else
                                    msg = rule.alertText;
                                
								methods._showPrompt(errorField, msg, "", true, options);
                            } else {
                                if (options.ajaxValidCache[errorFieldId] !== undefined)
                                    options.ajaxValidCache[errorFieldId] = true;

                                // resolves the msg prompt
								if(msg) {
									if (options.allrules[msg]) {
							           	var txt = options.allrules[msg].alertTextOk;
							           	if (txt)
							           		msg = txt;
							        }
								}
								else
							       	msg = rule.alertTextOk;                                

								// see if we should display a green prompt
                                if (msg)
                                    methods._showPrompt(errorField, msg, "pass", true, options);
                                else
                                    methods._closePrompt(errorField);
                            }
                        }
                        errorField.trigger("jqv.field.result", [errorField, !options.isError, msg]);
                    }
                });
            }
        },
       
        _ajaxError: function(data, transport) {
            if(data.status == 0 && transport == null)
                alert("The page is not served from a server! ajax call failed");
            else if(typeof console != "undefined")
                console.log("Ajax error: " + data.status + " " + transport);
        },
       
        _dateToString: function(date) {

            return date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
        },
       
        _parseDate: function(d) {

            var dateParts = d.split("-");
            if(dateParts==d)
                dateParts = d.split("/");
            return new Date(dateParts[0], (dateParts[1] - 1) ,dateParts[2]);
        },
     
        _showPrompt: function(field, promptText, type, ajaxed, options, ajaxform) {
            var prompt = methods._getPrompt(field);
			
			if(ajaxform) prompt = false;
            if (prompt)
                methods._updatePrompt(field, prompt, promptText, type, ajaxed, options);
            else
                methods._buildPrompt(field, promptText, type, ajaxed, options);
        },
        
        _buildPrompt: function(field, promptText, type, ajaxed, options) {
			
            // create the prompt
            var prompt = $('<div>');
            prompt.addClass(methods._getClassName(field.attr("id")) + "formError");
            // add a class name to identify the parent form of the prompt
            if(field.is(":input")) prompt.addClass("parentForm"+methods._getClassName(field.parents('form').attr("id")));
            prompt.addClass("formError");

            switch (type) {
                case "pass":
                    prompt.addClass("greenPopup");
                    break;
                case "load":
                    prompt.addClass("blackPopup");
                    break;
                default:
                    /* it has error  */
                    options.InvalidCount++;
            }
            if (ajaxed)
                prompt.addClass("ajaxed");

            // create the prompt content
            var promptContent = $('<div>').addClass("formErrorContent").html(promptText).appendTo(prompt);
            // create the css arrow pointing at the field
            // note that there is no triangle on max-checkbox and radio
            if (options.showArrow) {
                var arrow = $('<div>').addClass("formErrorArrow");

				//prompt positioning adjustment support. Usage: positionType:Xshift,Yshift (for ex.: bottomLeft:+20 or bottomLeft:-20,+10)
				var positionType=field.data("promptPosition") || options.promptPosition;
				if (typeof(positionType)=='string') {
					if (positionType.indexOf(":")!=-1) {
						positionType=positionType.substring(0,positionType.indexOf(":"));
					};
				};

				
             
            }

    	    if (options.relative) {
        		
        		var outer = $('<span>').css('position','relative').css('vertical-align','top').addClass('formErrorOuter').append(prompt.css('position','absolute'));
        		field.before(outer);
    	    } else if (options.isOverflown) {
               
                	field.before(prompt);
                } else {
                   $("body").append(prompt);
    	    }          
            var pos = methods._calculatePosition(field, prompt, options);
            prompt.css({
                "top": pos.callerTopPosition,
                "left": pos.callerleftPosition,
                "marginTop": pos.marginTopSize,
                "opacity": 0
            }).data("callerField", field);  

			if (options.autoHidePrompt) {   
                setTimeout(function(){ 
                    prompt.animate({
                       "opacity": 0
                    },function(){
                        prompt.closest('.formErrorOuter').remove();
                        prompt.remove();
                    }) 
                }, options.autoHideDelay)                			
                return prompt.animate({
				   "opacity": 0.87
				})
			} else {
				return prompt.animate({
				   "opacity": 0.87
				});			      
            }				
        },
       
        _updatePrompt: function(field, prompt, promptText, type, ajaxed, options, noAnimation) {
			
            if (prompt) {
				if (typeof type !== "undefined") {
	            	if (type == "pass")
        	            prompt.addClass("greenPopup");
                	else
					    prompt.removeClass("greenPopup");

					if (type == "load")
					    prompt.addClass("blackPopup");
					else
					    prompt.removeClass("blackPopup");
				}
				if (ajaxed)
				    prompt.addClass("ajaxed");
				else
				    prompt.removeClass("ajaxed");
		
                prompt.find(".formErrorContent").html(promptText);

                var pos = methods._calculatePosition(field, prompt, options);
				css = {"top": pos.callerTopPosition,
		               "left": pos.callerleftPosition,
		               "marginTop": pos.marginTopSize};
		
				if (noAnimation)
				 	prompt.css(css);
				else
				 	prompt.animate(css)
            }
        },
      
        _closePrompt: function(field) {

            var prompt = methods._getPrompt(field);
            if (prompt)
                prompt.fadeTo("fast", 0, function() {
		    prompt.parent('.formErrorOuter').remove();
                    prompt.remove();
                });
        },
        closePrompt: function(field) {
            return methods._closePrompt(field);
        },
        
  		  _getPrompt: function(field) {
		    var className = methods._getClassName(field.attr("id")) + "formError";
		    var match = $("." + methods._escapeExpression(className))[0];
		    if (match)
		      return $(match);
		  },
         
		  _escapeExpression: function (selector) {
		    return selector.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g, "\\$1");
		  },
		
		isRTL: function(field)
		{
			var $document = $(document);
			var $body = $('body');
			var rtl =
				(field && field.hasClass('rtl')) ||
				(field && (field.attr('dir') || '').toLowerCase()==='rtl') ||
				$document.hasClass('rtl') ||
				($document.attr('dir') || '').toLowerCase()==='rtl' ||
				$body.hasClass('rtl') ||
				($body.attr('dir') || '').toLowerCase()==='rtl';
			return Boolean(rtl);
		},
      
        _calculatePosition: function (field, promptElmt, options) {

            var promptTopPosition, promptleftPosition, marginTopSize;
            var fieldWidth = field.width();
            var promptHeight = promptElmt.height();

            var overflow = options.isOverflown || options.relative;
            if (overflow) {
                // is the form contained in an overflown container?
                promptTopPosition = promptleftPosition = 0;
                // compensation for the arrow
                marginTopSize = -promptHeight;
            } else {
                var offset = field.offset();
                promptTopPosition = offset.top;
                promptleftPosition = offset.left;
                marginTopSize = 0;
            }

			
			var positionType=field.data("promptPosition") || options.promptPosition;
			var shift1="";
			var shift2="";
			var shiftX=0;
			var shiftY=0;
			if (typeof(positionType)=='string') {
			//do we have any position adjustments ?
				if (positionType.indexOf(":")!=-1) {
					shift1=positionType.substring(positionType.indexOf(":")+1);
					positionType=positionType.substring(0,positionType.indexOf(":"));

					
					if (shift1.indexOf(",")!=-1) {
						shift2=shift1.substring(shift1.indexOf(",")+1);
						shift1=shift1.substring(0,shift1.indexOf(","));
						shiftY=parseInt(shift2);
						if (isNaN(shiftY)) {shiftY=0;};
					};
					
					shiftX=parseInt(shift1);
					if (isNaN(shift1)) {shift1=0;};
					
				};
			};

			if(!methods.isRTL(field))
			{
				switch (positionType) {
					default:
					case "topRight":
						if (overflow)
							// Is the form contained in an overflown container?
							promptleftPosition += fieldWidth - 30;
						else {
							promptleftPosition += fieldWidth - 30;
							promptTopPosition += -promptHeight -2;
						}
						break;
					case "topLeft":
						promptTopPosition += -promptHeight - 10;
						break;
					case "centerRight":
						if (overflow) {
                            promptTopPosition=field.outerHeight();
                            promptleftPosition=field.outerWidth(1)+5;
                        } else {
                            promptleftPosition+=field.outerWidth()+5;
                        }
						break;
					case "centerLeft":
						promptleftPosition -= promptElmt.width() + 2;
						break;
					case "bottomLeft":
						promptTopPosition = promptTopPosition + field.height() + 15;
						break;
					case "bottomRight":
						promptleftPosition += fieldWidth - 30;
						promptTopPosition += field.height() + 5;
				}
			}
			else
			{
				switch (positionType) {
					default:
					case "topLeft":
						if (overflow)
							// Is the form contained in an overflown container?
							promptleftPosition -= promptElmt.width() - 30;
						else {
							promptleftPosition -= promptElmt.width() - 30;
							promptTopPosition += -promptHeight -2;
						}
						break;
					case "topRight":
						if (overflow)
							// Is the form contained in an overflown container?
							promptleftPosition += fieldWidth - promptElmt.width();
						else {
							promptleftPosition += fieldWidth - promptElmt.width();
							promptTopPosition += -promptHeight -2;
						}
						break;
					case "centerRight":
						if (overflow) {
                            promptTopPosition=field.outerHeight();
                            promptleftPosition=field.outerWidth(1)+5;
                        } else {
                            promptleftPosition+=field.outerWidth()+5;
                        }
						break;
					case "centerLeft":
						promptleftPosition -= promptElmt.width() + 2;
						break;
					case "bottomLeft":
						promptleftPosition += -promptElmt.width() + 30;
						promptTopPosition = promptTopPosition + field.height() + 15;
						break;
					case "bottomRight":
						promptleftPosition += fieldWidth - promptElmt.width();
						promptTopPosition += field.height() + 15;
				}
			}

			//apply adjusments if any
			promptleftPosition += shiftX;
			promptTopPosition  += shiftY;

            return {
                "callerTopPosition": promptTopPosition + "px",
                "callerleftPosition": promptleftPosition + "px",
                "marginTopSize": marginTopSize + "px"
            };
        },
       
        _saveOptions: function(form, options) {

            // is there a language localisation ?
            if ($.validationEngineLanguage)
                var allRules = $.validationEngineLanguage.allRules;
            else
                $.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page");
			// --- Internals DO NOT TOUCH or OVERLOAD ---
			// validation rules and i18
			$.validationEngine.defaults.allrules = allRules;
			
            var userOptions = $.extend(true,{},$.validationEngine.defaults,options);
			jim = userOptions;
            // Needed to be retro compatible
            if (userOptions.isOverflown) userOptions.relative = true;
            if (userOptions.relative) userOptions.isOverflown = true;

            form.data('jqv', userOptions);
            return userOptions;
        },
        
        
        _getClassName: function(className) {
        	if(className) {
                return className.replace(/:/g, "_").replace(/\./g, "_");
            }    
        }
    };

   
    $.fn.validationEngine = function(method) {

        var form = $(this);
		if(!form[0]) return false;  // stop here if the form does not exist
		  
        if (typeof(method) == 'string' && method.charAt(0) != '_' && methods[method]) {

         
            if(method != "showPrompt" && method != "hidePrompt" && method != "hide" && method != "hideAll") 
            	methods.init.apply(form);

            return methods[method].apply(form, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method == 'object' || !method) {
	
           
			methods.init.apply(form, arguments);
            return methods.attach.apply(form);
        } else {
            $.error('Method ' + method + ' does not exist in jQuery.validationEngine');
        }
    };



	// LEAK GLOBAL OPTIONS
	$.validationEngine= {defaults:{

        // Name of the event triggering field validation
        validationEventTrigger: "blur",
        // Automatically scroll viewport to the first error
        scroll: true,
		// Focus on the first input
		focusFirstField:true,
        // Opening box position, possible locations are: topLeft,
        // topRight, bottomLeft, centerRight, bottomRight
        promptPosition: "topRight",
        bindMethod:"bind",
		// internal, automatically set to true when it parse a _ajax rule
		inlineAjax: false,
        // if set to true, the form data is sent asynchronously via ajax to the form.action url (get)
        ajaxFormValidation: false,
        // Ajax form validation callback method: boolean onComplete(form, status, errors, options)
        // retuns false if the form.submit event needs to be canceled.
		ajaxFormValidationURL: false,
        // The url to send the submit ajax validation (default to action)
        onAjaxFormComplete: $.noop,
        // called right before the ajax call, may return false to cancel
        onBeforeAjaxFormValidation: $.noop,
        // Stops form from submitting and execute function assiciated with it
        onValidationComplete: false,

	    // better relative positioning
	    relative: false,
        // Used when the form is displayed within a scrolling DIV
        isOverflown: false,
        overflownDIV: "",
		
		// Used when you have a form fields too close and the errors messages are on top of other disturbing viewing messages
        doNotShowAllErrosOnSubmit: false,

        // true when form and fields are binded
        binded: false,
        // set to true, when the prompt arrow needs to be displayed
        showArrow: true,
        // did one of the validation fail ? kept global to stop further ajax validations
        isError: false,
        // Caches field validation status, typically only bad status are created.
        // the array is used during ajax form validation to detect issues early and prevent an expensive submit
        ajaxValidCache: {},
        // Auto update prompt position after window resize
		autoPositionUpdate: false,

        InvalidFields: [],
		onSuccess: false,
		onFailure: false,
		// Auto-hide prompt
		autoHidePrompt: false,
		// Delay before auto-hide
		autoHideDelay: 10000
    }};
	$(function(){$.validationEngine.defaults.promptPosition = methods.isRTL()?'topLeft':"topRight"});
})(jQuery);

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('(2($){$.c.f=2(p){p=$.d({g:"!@#$%^&*()+=[]\\\\\\\';,/{}|\\":<>?~`.- ",4:"",9:""},p);7 3.b(2(){5(p.G)p.4+="Q";5(p.w)p.4+="n";s=p.9.z(\'\');x(i=0;i<s.y;i++)5(p.g.h(s[i])!=-1)s[i]="\\\\"+s[i];p.9=s.O(\'|\');6 l=N M(p.9,\'E\');6 a=p.g+p.4;a=a.H(l,\'\');$(3).J(2(e){5(!e.r)k=o.q(e.K);L k=o.q(e.r);5(a.h(k)!=-1)e.j();5(e.u&&k==\'v\')e.j()});$(3).B(\'D\',2(){7 F})})};$.c.I=2(p){6 8="n";8+=8.P();p=$.d({4:8},p);7 3.b(2(){$(3).f(p)})};$.c.t=2(p){6 m="A";p=$.d({4:m},p);7 3.b(2(){$(3).f(p)})}})(C);',53,53,'||function|this|nchars|if|var|return|az|allow|ch|each|fn|extend||alphanumeric|ichars|indexOf||preventDefault||reg|nm|abcdefghijklmnopqrstuvwxyz|String||fromCharCode|charCode||alpha|ctrlKey||allcaps|for|length|split|1234567890|bind|jQuery|contextmenu|gi|false|nocaps|replace|numeric|keypress|which|else|RegExp|new|join|toUpperCase|ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('|'),0,{}));






/////////////////////////////////////////////////////////



var httpserver = $('.httpserver').text();

function validatecontact(){
	hidemsg();
	var flag = true;
	var name = checkNull('name', $('#name').attr('data-error'),$('#name').attr('data-default'),'40','-270');
	var comments = checkNull('comments', $('#comments').attr('data-error'),$('#comments').attr('data-default'),'40','-270');
	var phone = checkPhone('phone', $('#phone').attr('data-error'),$('#phone').attr('data-default'),'40','-270');
	var email = checkMail('email', $('#email').attr('data-error'),$('#email').attr('data-default'),'40','-270');
	
	var address = province = district = true;
	if($('#address').length){
	var address = checkNull('address', $('#address').attr('data-error'),$('#address').attr('data-default'),'40','-270');
	}
	if($('#center-province').length){
	var province = checkSelect('center-province', $('#center-province').attr('data-error'),$('#center-province').attr('data-default'),'40','-270');
	}
	if($('#center-district').length){
	var district = checkSelect('center-district', $('#center-district').attr('data-error'),$('#center-district').attr('data-default'),'40','-270');
	}
	
	
	
	
	if(!name || !comments || !phone || !email  || !address  || !province  || !district ){
		if($('.contact-form').length){
				var delTop = 140;
				var top = $('.contact-form').offset().top - delTop;
				$('html, body').animate({ scrollTop: top}, 1000, 'easeInOutExpo');
		}
		flag = false;
		setTimeout(hideerror,5000);
	}
	return flag;
}
$('#btn-contact-submit').click(function(){ 	
	if(validatecontact()==true){
		$('#btn-contact-submit').attr('disabled','disabled');
		$('#btn-contact-submit').css('pointer-events','none');
		/*if(!$('.loadicon').hasClass('loader')){
				$('.loadicon').show();  
				$('.loadicon').addClass('loader');
				DrawLoad();
		}*/
		if(!$('.loadx').length){
		   $('body').append('<div class="loadx" style="display:block"></div>');
		}
		
		var datapost = $('#contact_form').serialize();
		
		$.ajax({  
		  type: "POST",  
		  url: httpserver + "send-contact.html",  
		  data: datapost,
		  dataType: 'json',
		  success: function(success) { 
			//$('.loadicon').removeClass('loader');
			//$('.loadicon').fadeOut(0);
			$('.loadx').remove();
			
		   	if(success.status=='200'){
				document.getElementById('contact_form').reset();
				$('.overlay-dark').after("<div  class='contact-success color-blue'>" + success.message + "</div>");
			}else{
				$('.overlay-dark').after("<div  class='contact-success color-red'>" + success.message + "</div>");;
			}
			
			grecaptcha.reset();
			$('#btn-contact-submit').removeAttr('disabled');
			$('#btn-contact-submit').css('pointer-events','auto');
			setTimeout(hidemsg,5000);
		  }  
		});  //end ajax 
		return false; 
	}//end if	
	$(".formError").click(function(){
		$(this).remove();	
	});
	return false;			
});
$('#btn-contact-reset').click(function(){
	hidemsg();
	hideerror();
});
$("#phone").numeric();
$('#contact_form').keydown(function(e) {
	if(!$("textarea").is(":focus")){
	if (e.keyCode == 13) {
		 $('#btn-contact-submit').trigger('click');
	}
	}
});


//////////////catalogue

function validatecatalogue(){
	hidemsg();
	var flag = true;
	var name_catalogue = checkNull('name', $('#name').attr('data-error'),$('#name').attr('data-default'),'40','-270');
	var address_catalogue = checkNull('address', $('#address').attr('data-error'),$('#address').attr('data-default'),'40','-270');
	var company_catalogue = checkNull('company', $('#company').attr('data-error'),$('#company').attr('data-default'),'40','-270');
	var phone_catalogue = checkPhone('phone', $('#phone').attr('data-error'),$('#phone').attr('data-default'),'40','-270');
	var email_catalogue = checkMail('email', $('#email').attr('data-error'),$('#email').attr('data-default'),'40','-270');
	
	var province = checkSelect('center-province', $('#center-province').attr('data-error'),$('#center-province').attr('data-default'),'40','-270');
	var district = checkSelect('center-district', $('#center-district').attr('data-error'),$('#center-district').attr('data-default'),'40','-270');
	
	if(!name_catalogue || !address_catalogue  || !company_catalogue || !phone_catalogue || !email_catalogue  || !province  || !district ){
		if($('.contact-form').length){
				var delTop = 80;
				var top = $('.contact-form').offset().top - delTop;
				$('html, body').animate({ scrollTop: top}, 1000, 'easeInOutExpo');
		}
		flag = false;
		setTimeout(hideerror,5000);
	}
	return flag;
}
$('#btn-catalogue-submit').click(function(){ 	
	if(validatecatalogue()==true){
		$('#btn-catalogue-submit').attr('disabled','disabled');
		/*if(!$('.loadicon').hasClass('loader')){
				$('.loadicon').show();  
				$('.loadicon').addClass('loader');
				DrawLoad();
		}*/
		if(!$('.loadx').length){
		   $('body').append('<div class="loadx" style="display:block"></div>');
		}
		
		var datapost = $('#catalogue_form').serialize();
		
		$.ajax({  
		  type: "POST",  
		  url: httpserver + "send-catalogue-ajax.html",  
		  data: datapost,
		  dataType: 'json',
		  success: function(success) { 
			//$('.loadicon').removeClass('loader');
			//$('.loadicon').fadeOut(0);
			$('.loadx').remove();
			
		   	if(success.status=='200'){
				document.getElementById('catalogue_form').reset();
				$('.select-box input').attr('checked', false);
				$('.overlay-dark').after("<div  class='contact-success color-blue'>" + success.message + "</div>");
			}else{
				$('.overlay-dark').after("<div  class='contact-success color-red'>" + success.message + "</div>");;
			}
			
			grecaptcha.reset();
			$('#btn-catalogue-submit').removeAttr('disabled');
			setTimeout(hidemsg,5000);
		  }  
		});  //end ajax 
		return false; 
	}//end if	
	$(".formError").click(function(){
		$(this).remove();	
	});
	return false;			
});
$('#btn-catalogue-reset').click(function(){
	hidemsg();
	hideerror();
});
$("#phone_catalogue").numeric();
$('#catalogue_form').keydown(function(e) {
	if(!$("textarea").is(":focus")){
	if (e.keyCode == 13) {
		 $('#btn-catalogue-submit').trigger('click');
	}
	}
});



//////////////recruitment

function validaterecruitment(){
	hidemsg();
	var flag = true;
	var name_recruitment = checkNull('name', $('#name').attr('data-error'),$('#name').attr('data-default'),'40','-270');
	var phone_recruitment = checkPhone('phone', $('#phone').attr('data-error'),$('#phone').attr('data-default'),'40','-270');
	var email_recruitment = checkMail('email', $('#email').attr('data-error'),$('#email').attr('data-default'),'40','-270');
	
	if(!name_recruitment || !phone_recruitment || !email_recruitment ){
		if($('.career-form').length){
				var delTop = 80;
				var top = $('.career-form').offset().top - delTop;
				$('html, body').animate({ scrollTop: top}, 1000, 'easeInOutExpo');
		}
		flag = false;
		setTimeout(hideerror,5000);
	}
	return flag;
}
$('#btn-recruitment-submit').click(function(){ 	
	if(validaterecruitment()==true){
		$('#btn-recruitment-submit').attr('disabled','disabled');
		
		if(!$('.loadx').length){
		   $('body').append('<div class="loadx" style="display:block"></div>');
		}
		
		$('#recruitment_form').submit();
		return false; 
	}//end if
	$(".formError").click(function(){
		$(this).remove();	
	});
	return false;			
});
$('#btn-recruitment-reset').click(function(){
	hidemsg();
	hideerror();
});
$("#phone_recruitment").numeric();
$('#recruitment_form').keydown(function(e) {
	if(!$("textarea").is(":focus")){
	if (e.keyCode == 13) {
		 $('#btn-recruitment-submit').trigger('click');
	}
	}
});


function stopUpload(success){
      var result = '';
	  $('.loadx').remove();
	  
	  if(success.status=='200'){
			result = "<div  class='contact-success color-blue'>" + success.message + "</div>";
		 	document.getElementById('recruitment_form').reset();
		}else{
			result = "<div  class='contact-success color-red'>" + success.message + "</div>";
		}
		
		/*
      if (success == 1){
         result = "<div  class='contact-success color-blue'>" + contact_form_contact_success + "</div>";
		 document.getElementById('frm_contact').reset();
      }
      else {
         result = "<div  class='contact-success color-red'>" + contact_form_contact_fail + "</div>";
      }*/
	  $('#btn-recruitment-submit').removeAttr('disabled');
	  
	  document.getElementById('file-name').innerHTML = document.getElementById('file-name').getAttribute('data-text');
	  document.getElementById('fileInput').value = '';
	  //document.getElementById('file-field').value = '';
	  //document.getElementById('browser-hide').value = '';
	  $('.overlay-dark').after(result);
	  //$('html, body').animate({scrollTop:0}, 'slow');
	  setTimeout(hidemsg,5000);    
      return true;   
}