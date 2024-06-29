var Xwidth = $(window).width();
var Yheight = $(window).height();

function ResizeWindows() {
var Xwidth = $(window).width();
var Yheight = $(window).height();


if(Xwidth <= 1024){
	if($('.login-page').length){
		$('.navbar-brand').css({'text-align':'center', 'width':'100%', 'max-width':'inherit'});
	}else{
		$('.navbar-brand').css({'text-align':'left', 'width':'auto', 'max-width':'80%'});
	}
	$('#content').css({'width':'100%', 'min-height':Yheight-135});
	$('#column-left').css({'height':'auto'});
	$('#column-left').removeClass('active');
	$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');
	$('#footer').css({'width':'100%'});
}else{
	if($('.login-page').length){
		$('#content').css({'width':'100%', 'min-height':'inherit'});
		$('#footer').css({'width':'100%'});
		$('.navbar-brand').css({'text-align':'center', 'width':'100%', 'max-width':'inherit'});
	}else{
	    $('#content').css({'width':Xwidth-235, 'min-height':'inherit'});
		$('#footer').css({'width':'auto'});
		$('.navbar-brand').css({'text-align':'left', 'width':'100%', 'max-width':'inherit'});
		
	}
	$('#column-left').css({'height':Yheight-49});
	$('#column-left').addClass('active');
	$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');
}

}

 
$(window).resize(function() {
    ResizeWindows();
}); 

function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

function CleanPastedHTML(input) {
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  output = output.replace(commentSripper, '');
  var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript', 'cite', 'div'];

  for (var i=0; i< badTags.length; i++) {
  	tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
  	output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start', 'class', 'id'];
  for (var i=0; i< badAttributes.length; i++) {
  	var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
  	output = output.replace(attributeStripper, '');
  }
  return output;
}

$(document).ready(function() {
	ResizeWindows();
	
	
	//hoang
	
	var files;

	// Add events
	$('input[type=file]').on('change', prepareUpload);
	
	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
	  files = event.target.files;
	}


	$(document).delegate('#button-linkfile','click', function() {
		var data = new FormData();
		$.each(files, function(key, value)
		{
			data.append(key, value);
		});
		
		$.ajax({
			url: 'index.php?route=common/filemanager/linkfile&token=' + getURLVar('token'),
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'html',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success: function(data, textStatus, jqXHR)
			{
				if(typeof data.error === 'undefined')
				{
					// Success so call function to process the form
					//submitForm(event, data);
					$('.note-link-url').val(data);
					document.getElementById('form_link_file').reset();
					$('.file_linkfile').val('');
					//console.log(data)
				}
				else
				{
					// Handle errors here
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				// STOP LOADING SPINNER
			}
		});
		
		
	});
	
	//Form Submit for IE Browser
	$('button[type=\'submit\']').on('click', function() {
		$("form[id*='form-']").submit();
	});

	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});

	// Set last page opened on the menu
	$('#menu a[href]').on('click', function() {
		sessionStorage.setItem('menu', $(this).attr('href'));
	});

	if (!sessionStorage.getItem('menu')) {
		$('#menu #dashboard').addClass('active');
	} else {
		// Sets active and open to selected page in the left column menu.
		$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active open');
	}

	if (localStorage.getItem('column-left') == 'active') {
		$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

		$('#column-left').addClass('active');

		// Slide Down Menu
		$('#menu li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li').not('.active').has('ul').children('ul').addClass('collapse');
	} else {
		$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

		$('#menu li li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li li').not('.active').has('ul').children('ul').addClass('collapse');
	}

	// Menu button
	$('#button-menu').on('click', function() {
		// Checks if the left column is active or not.
		if ($('#column-left').hasClass('active')) {
			localStorage.setItem('column-left', '');

			$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

			$('#column-left').removeClass('active');

			$('#menu > li > ul').removeClass('in collapse');
			$('#menu > li > ul').removeAttr('style');
		} else {
			localStorage.setItem('column-left', 'active');

			$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

			$('#column-left').addClass('active');

			// Add the slide down to open menu items
			$('#menu li.open').has('ul').children('ul').addClass('collapse in');
			$('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
		}
	});

	// Menu
	$('#menu').find('li').has('ul').children('a').on('click', function() {
		if ($('#column-left').hasClass('active')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		} else if (!$(this).parent().parent().is('#menu')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		}
	});


	
      $('#content').on('click', function() {
			if(Xwidth <= 1024){
			if ($('#column-left').hasClass('active')) {
				$('#column-left').removeClass('active');
				$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');
			}
			}
		
		});
		
		
		



	// Override summernotes image manager
	$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');

var selections;

	$(document).delegate('button[data-toggle=\'image\']', 'click', function() {
		$('#modal-image').remove();

		$(this).parents('.note-editor').find('.note-editable').focus();
		
		//hoang
		selections = document.getSelection();
		window.tempselections = selections.rangeCount;
		window.temp1selections = selections.getRangeAt(0);
		//hoang

		$.ajax({
			url: 'index.php?route=common/filemanager&directory=&iseditor=1&token=' + getURLVar('token'),
			dataType: 'html',
			beforeSend: function() {
				$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-image').prop('disabled', true);
			},
			complete: function() {
				$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-image').prop('disabled', false);
			},
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

				$('#modal-image').modal('show');
			}
		});
	});

	// Image Manager
	$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
		e.preventDefault();

		var element = this;
		var imageManagerUrl;

		var isnewspage = $(element).attr('data-isnewspage');

		$(element).popover('toggle');


		$('#modal-image').remove();

		if(!localStorage.getItem('lastFolder')) {
			
			if ($('#last-folder').val()== undefined) {
				imageManagerUrl = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id') + '&directory=' + '&isnewspage=' + isnewspage;
			} else {
				imageManagerUrl = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id') + '&directory=' + $('#last-folder').val() + '&isnewspage=' + isnewspage;
			}

		} else {
			var url = localStorage.getItem('lastFolder');
			var url_splitted =  url.split('&');
			if(url_splitted.length > 2){
			var directory = url_splitted[2];
			if(directory.search('directory')!=-1){
			imageManagerUrl = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id') + '&' + directory + '&isnewspage=' + isnewspage;
			}else{
				imageManagerUrl = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id') + '&directory=' + '&isnewspage=' + isnewspage;
			}
			}else{
				
				imageManagerUrl = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id') + '&directory=' + '&isnewspage=' + isnewspage;
			
			}
		}

		$('#modal-image').load($(this).attr('href'));

		$.ajax({
			url: imageManagerUrl,
			dataType: 'html',
			beforeSend: function() {
				$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-image').prop('disabled', true);
			},
			complete: function() {
				$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-image').prop('disabled', false);
			},
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

				$('#modal-image').modal('show');
			}
		});

		$(element).popover('hide');
		
	});

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});

	//added
	if (!$('#menu li:first-child').hasClass('active') && $('#menu li.active').length == 0) {
		$('#menu li:first-child').addClass('active open');
		$('#menu li:first-child').find('a').trigger('click');
	}
		if ($('#menu li.active').length < 1) {
		$('li#menu-86:first-child').addClass('active open');
	}
	if ($(window).width() > 1024 ) {
		localStorage.setItem('column-left', 'active');

		$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

		$('#column-left').addClass('active');

		// Add the slide down to open menu items
		$('#menu li.open').has('ul').children('ul').addClass('collapse in');
		$('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
	} else {
		localStorage.setItem('column-left', '');

		$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

		$('#column-left').removeClass('active');

		$('#menu > li > ul').removeClass('in collapse');
		$('#menu > li > ul').removeAttr('style');
	}

	$(window).on('resize' , function() {
		//768 - 22 (scroll-maximum)
		if ($(window).width() > 1024 ) {
			$('#column-left').addClass('active');
		} else {
			$('#column-left').removeClass('active');
		}
	});

	
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
					this.hide();
					break;
					default:
					this.request();
					break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			};

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			};

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			};

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			};

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			};

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
};
})(window.jQuery);