(function ($) {
	var methods = { on: $.fn.on, bind: $.fn.bind };
	$.each(methods, function(k){
	  $.fn[k] = function () {
	  var args = [].slice.call(arguments),
	  delay = args.pop(),
	  fn = args.pop(),
	  timer;
	  args.push(function () {
	  var self = this,
	  arg = arguments;
	  clearTimeout(timer);
	  timer = setTimeout(function(){
	  fn.apply(self, [].slice.call(arg));
	  }, delay);
	});
	  return methods[k].apply(this, isNaN(delay) ? arguments : args);
	 };
	});
}(jQuery));

var timex;
var show;
var News = 0;
var Details = 0;
var Videoload = 0;
var doWheel = true;
var doTouch = true;
var windscroll = $(document).scrollTop();
var Itemx = $('.nav li');
var timer;  
var Arrhash;
var pageCount = 0;
var loading = true;
var isFirst = true;
var timeSlide = $('.slide-pics').attr('data-time');
var CountPlay=0;
//END

$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top + 90;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + ($(window).height()  + 90);
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

function onScroll(){
var items = $('.ani-item');
$(items).each(function(index, element) {
  if($(element).isInViewport()){
	  $(element).addClass("on-show");
	 
   }
 });
}



function AnimationDelay(){
   var Itemx = $('.nav li')
   var Item = $('.ani-item')
   $(Itemx).each(function(index, element) {
		 var minDelay = 50;
         var maxDelay = 350;
		 var time = Math.floor(index) * (( maxDelay - minDelay )/2 - minDelay) + 150;
         $(element).css({'-webkit-animation-delay': time + 'ms', 'animation-delay': time + 'ms'});
   });
   $(Item).each(function(index, element) {
        var minDelay = 150;
        var maxDelay = 800;
        var time = Math.random(index) * (( maxDelay - minDelay ) - minDelay);
        $(element).css({'-webkit-animation-delay': time + 'ms', 'animation-delay': time + 'ms'});
    });
}


function NavClick() {

	$('.nav-click').bind('click', function() {
	if ($(this).hasClass('active')) {
	  $('.second-sub-menu').height(0);
	  $('.add').removeClass('active');
	  $('.overlay-menu-1, .navigation, .nav-click, .sub-menu').removeClass('active');
	  $('html, body').removeClass('no-scroll');
	  $('.nav > .wrap-header').scrollTop(0);
	  $('.navigation').on('mousewheel', function () {return true});
	} else {
	  $('.overlay-menu-1, .navigation, .nav-click').addClass('active');
	  $('html, body').addClass('no-scroll');
	  $('.nav > .wrap-header').scrollTop(0);
	   $('.navigation').on('mousewheel', function () {return true});
	   if($('.search-but').hasClass('active')){
		  $('.search-form, .search-but').removeClass('active');
	   }
	 }
		return false;
	});

	
	  $( ".nav li.has-sub" ).on('mouseover click',function() {
			$(this).addClass('active');
			$('.sub-menu, .overlay-menu').addClass('active');
		  
	    return false;
	  });
	
	$(".overlay-menu,.header").on('mouseenter click',function() {
	    	$('.nav li.active').removeClass('active');
			$('.sub-menu, .overlay-menu').removeClass('active');
	    return false;
	  }) 

	$('.add').bind({
		click: function(e) {
			 e.preventDefault();
			var ID = $(this).find('.hover-btn').attr('data-sub');
		   if(!$(this).hasClass('active')){
		       $(this).addClass('active');
			    var Height = $('.second-sub-menu[data-show= "' + ID + '"]').find('ul').innerHeight()
			  	 $('.second-sub-menu[data-show= "' + ID + '"]').height(Height);
		  }else{
			   $(this).removeClass('active');
			   $('.second-sub-menu[data-show= "' + ID + '"]').height(0);
			   $('.play').trigger('click');
			   
		  }
		   return false;
		},
	 });

	
	
	$('.overlay-menu-1').on('click',function(e){
	   if ($(window).width() <= 1100) {
		    $('.second-sub-menu').height(0);
	        $('.add').removeClass('active');
	        $('.overlay-menu-1, .navigation, .nav-click, .sub-menu').removeClass('active');
	        $('html, body').removeClass('no-scroll');
	         $('.nav > .wrap-header').scrollTop(0);
	   }
	   
	});
   
	$('.link-home,.link-load, .link-load-page').on("click" ,function() {
		$('.container').addClass('show')
   	});
   

}

function ScrollNiceA() {
	if($(window).width() > 1100 && TouchLenght == false  || $(window).width() > 1100 && !isTouchDevice){
		$('.scrollA').getNiceScroll().show();
        $('.scrollA').niceScroll({touchbehavior:true, horizrailenabled: false, cursordragontouch:true,grabcursorenabled: false,cursorcolor:"#fff",autohidemode:false, zindex:100});
		$('.scrollA').scrollTop(0);
	}else{
       $('.scrollA').getNiceScroll().remove();
	   $('.scrollA').css({'overflow':'visible'});
     }
	
}

function execSearch() {
    var qsearch = $('#qsearch').val();
    var href_search = $('#href_search').val();
	var defaultvalue = $('#defaultvalue').val();
	var error_search = $('#errorsearch').val();
	hidemsg();

    if (qsearch == defaultvalue || qsearch == '')
        return false;
	if(qsearch.length<=1){
		
		$('.overlay-dark').after("<div  class='contact-success color-red'>" + error_search + "</div>");
		setTimeout(hidemsg,5000);
		return false;
	}
	
    if (qsearch != '') {
        var url = href_search + '?qsearch=' + encodeURIComponent(qsearch)

        window.location = url;
        return false;
    }
}

function Search() {
	
    //$(document).on('click', '.search-but', function(e){
	$('.search-but').on("click" ,function(e) {
	  if($(this).hasClass('active')){
			  $('.search-form, .search-but').removeClass('active');
			  execSearch();
	  }else{
		 $('.search-form, .search-but').addClass('active');
		  document.getElementById("search").reset();
		    if($('.nav-click').hasClass('active')){
	         $('.nav-click').trigger('click');
           }
	  }
	  
});

$('#qsearch').keydown(function(e) {
  if (e.keyCode == 13) {
		  execSearch();
  }
});
		
}



function SlidePicture() {
	
	/*HOME PAGE*/
	
	if( $('.slide-mask').length){
	    
		 $('.slide-mask').addClass('show');
		 if($('.slide-mask').children().length>1){
		   var timeSlide = $('.slide-mask').attr('data-time');
		   if(!$('.stop').length){
		    $('.slide-mask').parent().prepend('<a class="stop" href="javascript:void(0)"></a><a class="play" href="javascript:void(0)"></a>');
		   }
	      }else{
		    var timeSlide = false; 
	     }
		 
	   if ($('.youtube-video').length) {
            var AutoHeight = true;
        } else {
            var AutoHeight = false;
        }
	
	  $('.slide-mask').BTQSlider({
			 animateOut: 'fadeout',
		     animateIn: 'fadein',
			 mouseDrag: false,
		     touchDrag: false,
			 pullDrag: false,
			// loop:true,
			 rewind: true,
			 margin:0,
			 video: false,
			 autoplay:true,
			 autoplayTimeout: timeSlide,
			 autoHeight: AutoHeight,
			 smartSpeed: 1500,
			 items:1,
			 nav: true,
			 dots: true, 
			 dotSvg:true,
			 responsiveRefreshRate : 400,
			
			  
          }).on('initialize.btq.slidebox', StartSync());
		  
		  $('.slide-mask').on('translate.btq.slidebox', function(e) {
		    $('.slide-mask .slide-item').removeClass('ani-text');
	     });
	  
	     $('.slide-mask').on( 'translated.btq.slidebox', function(e) {
			 $('.slide-mask .slide-item.active').addClass('ani-text'); 
			
			 if ($('.youtube-video').length) {
				 if($('.slide-mask .slide-item:first-child').hasClass('ani-text')){
					 $('.slide-mask .slide-pagination').addClass('no-display');
					  $('.play-button').trigger('click');
					   $('.slide-mask').trigger('stop.btq.autoplay');
				 }else{
					 $('.slide-mask .slide-pagination').removeClass('no-display');
					  $('.pause-button').trigger('click');
					  $('.slide-mask').trigger('play.btq.autoplay',[timeSlide]);
					  
				 }
			 }
			 
	    });
		
		$('.go-page').on('mouseover',function(e){
            $('.slide-mask').trigger('stop.btq.autoplay');
		});
		$('.go-page').on('mouseleave',function(e){
		    $('.slide-mask').trigger('play.btq.autoplay');
		}); 
		
		function StartSync(){
			// alert("ME") 
	   $('.slide-mask .slide-item.active').addClass('ani-text');
	   if(!$('.arrow').length){ 	
		 $('.slide-mask .slide-next').append('<svg viewBox="0 0 60 60"><path class="arrow" fill="currentColor" d="M24.5,42 22.5,40.2 33.6,30 22.5,19.8 24.5,18 37.5,30z"></path></svg>');
		 $('.slide-mask .slide-prev').append('<svg viewBox="0 0 60 60"><path class="arrow" fill="currentColor" d="M35.5,42 37.5,40.2 26.4,30 37.5,19.8 35.5,18 22.5,30z"></path></svg>');
		}
	   $('.circle-outer').css({'-webkit-animation-duration': (timeSlide * 10) + 'ms', 'animation-duration': (timeSlide * 10) + 'ms'}); 
	   
	         if ($('.youtube-video').length) {
				 //$('.pause-button').trigger('click');
				 if($('.slide-mask .slide-item:first-child').hasClass('ani-text')){
					 $('.slide-mask .slide-pagination').addClass('no-display');
					  $('.slide-mask').trigger('stop.btq.autoplay');
				 }else{
					 $('.slide-mask .slide-pagination').removeClass('no-display');
				 }
			 }
	   
       }
		 
		
		  
		 // TOUCH DRAP DEVICE
	 
		  $('.slide-mask').on('swipeleft', function(e, touch) {
			if (!doTouch) {
			  return;
		   }
			 doTouch = false;
			 if($('.slide-mask .slide-item').children().length>1){
				 $('.slide-mask').trigger('next.btq.slidebox');
			 }
			 setTimeout(turnWheelTouch, 500);
			   
		 }).on('swiperight', function(e) { 
			 if (!doTouch) {
			  return;
			 }
			  doTouch = false;
			   if($('.slide-mask .slide-item').children().length>1){
				 $('.slide-mask').trigger('prev.btq.slidebox');
			   }
			setTimeout(turnWheelTouch, 500);
	    });
	
        $('.play').on('click',function(){
			 $('.slide-mask').trigger('play.btq.autoplay',[timeSlide]);
			  $('.slide-mask .slide-buttons, .slide-mask .slide-pagination').removeClass('hide');
		})
		$('.stop').on('click',function(){
			 $('.slide-mask').trigger('stop.btq.autoplay');
			 $('.slide-mask .slide-buttons, .slide-mask .slide-pagination').addClass('hide');
			 
		})

     }

     if($('.slider-history').length){
		
		 var Time = $('.slider-history').attr('data-time');
		
		 var Year = new Swiper('.year-slider', {
			nextButton: '.slide-next',
            prevButton: '.slide-prev',	 
			slidesPerView: 1,
			speed: 600,
			spaceBetween: 0,
		 });
		
		  var SlideHistory = new Swiper('.slider-history', { 
		    nextButton: '.slide-next',
            prevButton: '.slide-prev',					
	    	slidesPerView: 1,
			speed: 800,
			spaceBetween: 0,
			//autoplay:Time,
			simulateTouch: true,
			effect: 'slide',
			parallax: true,
			grabCursor: true,
			keyboardControl: true,
		  
		   onInit: function (swiper) {
			  $('.box-history').eq(swiper.activeIndex).addClass('select-history'); 
				var Current = $('.select-history').index();
		        $('.time-line li a[data-index= "' + Current + '"]').parent().addClass('active');
		   },	
			
		   onTransitionStart: function (swiper) {
				 $('.box-history').removeClass('select-history');
				 $('.time-line li').removeClass('active');
		   },
		   
		   onTransitionEnd: function (swiper) {
			    $('.box-history').eq(swiper.activeIndex).addClass('select-history'); 
				var Current = $('.select-history').index();
				Year.slideTo(Current, 600, true);
		        $('.time-line li a[data-index= "' + Current + '"]').parent().addClass('active');
					detectBut();
		   }, 
		
	    });
		
		$('.time-line li a').on("click", function(e){
			e.preventDefault();
			var Index = $(this).parent().index();
			 SlideHistory.slideTo(Index, 800, true);
			 Year.slideTo(Index, 600, true);
		});
		
		setTimeout(function(){SlideHistory.once('onInit');} , 200);
		
		
    }
	


    $('.slider-al').each(function(index, element) {
		$(element).on('initialized.btq.slidebox', function () {
		 var Length =  $(element).find(".slide-item").length;

		if($(window).width() >= 1000){
	      if(Length <= 3){
				 $(element).addClass('center-slidebox');
			  }else{
				 $(element).removeClass('center-slidebox');
			  }
		  }else if($(window).width() < 1000 && $(window).width() >= 600){
			
			 if(Length <= 2){
				  $(element).addClass('center-slidebox');
			  }else{
				  $(element).removeClass('center-slidebox');
			  }
			  
		  }else{
			   $(element).removeClass('center-slidebox');
			  
		}
		  }).BTQSlider({
			margin:20,
			smartSpeed: 1000,
			nav : true,
			dots : false,
			rewind:true,
			responsive:{
			0:{
				items:1,
				nav : false,
				dots : true,
				margin:7,
			},
			600:{
				items:2,
				nav : false,
				dots : true,
				margin:7,
			},
			1000:{
				items:3,
			},

		  	}
          })
		  	 
     });

    $('.list-catalogue').each(function(index, element) {
		$(element).on('initialized.btq.slidebox', function () {
		 var Length =  $(element).find(".slide-item").length;

		if($(window).width() >= 1000){
	      if(Length <= 3){
				 $(element).addClass('center-slidebox');
			  }else{
				 $(element).removeClass('center-slidebox');
			  }
		  }else if($(window).width() < 1000 && $(window).width() >= 600){
			
			 if(Length <= 2){
				  $(element).addClass('center-slidebox');
			  }else{
				  $(element).removeClass('center-slidebox');
			  }
			  
		  }else{
			   $(element).removeClass('center-slidebox');
			  
		}
		  }).BTQSlider({
			smartSpeed: 1000,
			nav : true,
			dots : false,
			rewind:true,
			responsive:{
			0:{
				items:1,
				nav : false,
				dots : true,
				margin:7,
			},
			600:{
				items:2,
				nav : false,
				dots : true,
				margin:7,
			},
			1000:{
				items:3,
			},

		  	}
          })
		  	 
     });

    $('.slider-cus').each(function(index, element) {
		$(element).on('initialized.btq.slidebox', function () {
		 var Length =  $(element).find(".slide-item").length;

		if($(window).width() >= 1100){
	      if(Length <= 3){
				 $(element).addClass('center-slidebox');
			  }else{
				 $(element).removeClass('center-slidebox');
			  }
		  }else if($(window).width() < 1100 && $(window).width() >= 800){
			
			 if(Length <= 2){
				  $(element).addClass('center-slidebox');
			  }else{
				  $(element).removeClass('center-slidebox');
			  }
			  
		  }else{
			   $(element).removeClass('center-slidebox');
			  
		}
		  }).BTQSlider({
			margin:20,
			smartSpeed: 1000,
			nav : true,
			dots : false,
			rewind:true,
			responsive:{
			0:{
				items:2,
				nav : false,
				dots : true,
				margin:7,
			},
			500:{
				items:3,
				nav : false,
				dots : true,
				margin:7,
			},
			800:{
				items:4,
				nav : false,
				dots : true,
				margin:7,
			},
			1100:{
				items:6,
			},

		  	}
          })
		  	 
     });

    $('.slider-pic').each(function(index, element) {
		$(element).on('initialized.btq.slidebox', function () {
		 var Length =  $(element).find(".slide-item").length;

		if($(window).width() >= 800){
	      if(Length <= 2){
				 $(element).addClass('center-slidebox');
			  }else{
				 $(element).removeClass('center-slidebox');
			  }
		  }else{
			   $(element).removeClass('center-slidebox');
			  
		}
		  }).BTQSlider({
			smartSpeed: 1000,
			nav : true,
			dots : false,
			rewind:true,
			responsive:{
			0:{
				items:1,
				nav : false,
				dots : true,
				margin:7,
			},
			800:{
				items:2,
				nav : true,
				margin:20,
			},
		  	}
          })
		  	 
     });

    $('.slider-d').BTQSlider({
		smartSpeed: 1000,
		rewind:true,
		items:1,
		responsive:{
			0:{
				nav : false,
				dots : true,
			},
			1100:{
				nav : true,
				dots : false,
			},
		}
		
	});

	$('.list-slide-product').each(function(index, element) {
		$(element).on('initialized.btq.slidebox', function () {
			$(element).addClass('center-slidebox');

		  }).BTQSlider({
			smartSpeed: 1000,
			nav : true,
			dots : false,
			rewind:true,
			responsive:{
			0:{
				items:1,
				nav : false,
				dots : true,
				margin:4,
			},800:{
				items:2,
				nav : true,
				margin:5,
			},1100:{
				items:3,
				nav : true,
				margin:8,
			},
		  	}
          })
	
     });
		  	 

}
	
	

function AniText() {


	$('.title-page h1').children().children().each(function(i){
        var box = $(this);
       timex = setTimeout(function(){$(box).addClass('move')}, (i+1) * 80);
    });

}

// function AniText1() {
// 	clearTimeout(timex);
// 	$('.title-inner h2').each(function(index, element) {
// 	  	if($(element).isInViewport()){
// 			$(element).children().children().each(function(i){
// 				var box = $(this);
// 		    	timex = setTimeout(function(){$(box).addClass('move')}, (i+1) * 50);
// 			});
// 		}
// 	});
// }


function VideoLoad(idx, Source) {
    $.ajax({url: idx, cache: false, success: function(data) {
            $('.allvideo').append(data);
         
            
			 $('.video-wrap').append(Source)
             
            $('.loadx').fadeOut(400, 'linear', function() {
                $('.loadx').remove();
            });

            $('.close-video').on( 'click',function() {
               
                $('.allvideo').fadeOut(500, 'linear', function() {
                    $('.overlay-dark').removeClass('show');
                    $('.allvideo .video-list').remove();
                    $('html, body').removeClass('no-scroll');
					
					if($('body').hasClass('scroll')){
					   ScrollBody();
				    }

                    if($('.to-scrollV').length) {
                        var top = $('.to-scrollV').offset().top;
                        if($(window).width() < 1100) {
                            $('html, body').scrollTop(top);
                        }
						 $('.to-scrollV').removeClass('to-scrollV');
                    }


                });

            });
        }


    });
}

function thumbslider(url,num) {

	 if(TouchLenght == false  || !isTouchDevice){
		  if($('.slide-slidebox').length){
		   $('.slide-slidebox').trigger('stop.btq.autoplay');
		  }
     }
	
	   $('.detail-center').on('initialized.btq.slidebox', function () {
		   
		 $('.detail-center').find('.slide-item.active').addClass('selected'); 

	    }).BTQSlider({
	    animateOut: 'fadeout',
		animateIn: 'fadein',
		items:1,
		margin:0,
	    smartSpeed:600,
	    loop:false,
	    dots: false,
		nav:false,
		responsiveRefreshRate : 200,
		
        }).on('changed.btq.slidebox', function(el) {
		     if($('.thumbs').length){
			    syncPosition(el);
			 }
		}).on( 'translate.btq.slidebox', function(el) {
		    $('.detail-center').find('.slide-item').removeClass('selected');
	    }).on('translated.btq.slidebox', function(el) {
			 $('.detail-center').find('.slide-item.active').addClass('selected'); 
	    });
		
	  
	  
	  if($('#product-detail-page').length){
		$('.item-11 img').on('click', function(){
			$(this).parent().find('a').trigger('click');
		})
	  $('.thumbs').on('initialized.btq.slidebox', function () {
		  var Length =  $('.thumbs').find(".slide-item").length	


	      $('.thumbs').find(".slide-item").eq(0).addClass("current");
				}).BTQSlider({
				margin:5,
				smartSpeed:300,
				dots: false,
				nav:false,
				responsiveRefreshRate : 100,
				autoWidth: true,
				
	       });

	 	}
	  function syncPosition(el) {
				//set loop to true
				//var Current = Math.round(el.item.index - (el.item.Count/2) - .5);
				//set loop to false
				//var Current = el.item.index;
			
				var Count = el.item.Count-1;
				var Current = el.item.index;
			 
				  if(Current < 0) {
					 Current = Count;
				  }
				  if(Current > Count) {
					Current = 0;
				   }    
		
		   $('.thumbs').find(".slide-item").removeClass("current").eq(Current).addClass("current");
		   var Onscreen =  $('.thumbs').find('.slide-item.active').length - 1;
		   var Start =  $('.thumbs').find('.slide-item.active').first().index();
		   var End =  $('.thumbs').find('.slide-item.active').last().index();
			if (Current >= End -1 ) {
			   $('.thumbs').data('btq.slidebox').to(Current, 300, true);
			}
			
			if (Current <= Start) {
			   $('.thumbs').data('btq.slidebox').to(Current - Onscreen, 300, true);
			}
	   }
	
  
	 $('.thumbs').on("click", ".slide-item", function(e){
		e.preventDefault();
		var Num = $(this).index();
		$('.detail-center').data('btq.slidebox').to(Num, 1000, true);
	  });
	
	  
	  $('.center-detail').on('mousewheel', '.detail-center', function (e) {
			if (e.deltaY>0) {
				if (!doWheel) {
			     return;
		       }
			   doWheel = false;
				 $('.detail-center').trigger('prev.btq.slidebox');
				  setTimeout(turnWheelTouch, 500);
			} else {
					if (!doWheel) {
			     return;
		       }
			   doWheel = false;
				 $('.detail-center').trigger('next.btq.slidebox');
				  setTimeout(turnWheelTouch, 500);
			}
			e.preventDefault();
		});

}



//LOAD POPUP
function popupLoad(url) {
$.ajax({url: url, cache: false, success: function(data) {
	$('.details-content').remove();
	$('body').append(data);
	if($('form').length){
	   FocusText();
	}
  	if($(window).width() <= 840){
	   $('.details-text img').addClass('zoom-pic');
	   ZoomPic();
	}
	if($('.detail-center').length){
		thumbslider()
	}
	$('html, body').addClass('no-scroll');
    $('.overlay-dark').addClass('show');
  	$('.details-content').stop().animate({'opacity': 1}, 500, 'linear', function() {
		  $('.details-content').scrollTop(0);	
		  $('.details-center').addClass('fadeinup');
		  $('.loadx').fadeOut(400, 'linear', function() {
			
			$('.loadx').remove();
	});


	$('.browse-but').on("click" , function(){
		$('.details-content').remove();
		$('.upload-form').fadeIn(500, 'linear');
		document.getElementById("recruitment-send").reset();
		$('.outer-but').removeClass('ready');
		return false;
	});
	$('.close-form').on("click" , function() {
		$('.upload-form').fadeOut(500, 'linear');
		$('html, body, .container').removeClass('no-scroll');
		$('.overlay-dark').removeClass('show');
		return false;
	});
		  
  });
  
    
    $('.close-popup, .details-content span').on('click',function() {
		
		if($('#library-page').length){
			var tmpurl = $('.sub-nav li.current a').attr('href');
			var tmptitle = $('.sub-nav li.current a').attr('data-title');
			var tmpkeyword = $('.sub-nav li.current a').attr('data-keyword');
			var tmpdescription = $('.sub-nav li.current a').attr('data-description');
			var tmpdataname = $('.sub-nav li.current a').attr('data-name');
			changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,tmptitle,tmpdescription);
		}
				
		  $('.details-content').animate({'opacity': 0}, 500, 'linear', function() {
			  $('.details-content').remove();
			  $('.overlay-dark').removeClass('show');
			  $('html, body').removeClass('no-scroll');
		  });
		//STATIC
        //if (window.location.hash.length) {
        //    history.pushState('', document.title, location.href.replace(/#.*/, ''));
        //}
		  return false;
  
  });
		
}});
}




function PrintShare(){
//EVENTS: FAVORITE - PRINT - SHARE
var triggerBookmark = $('.save-but'); 
$(triggerBookmark).on('click', function(){
  if (window.sidebar && window.sidebar.addPanel) {
		window.sidebar.addPanel(document.title,window.location.href,'');
	} else if(window.external && ('AddFavorite' in window.external)) { 
		window.external.AddFavorite(location.href,document.title); 
	} else { 
	 alert('Nhấn ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL') + ' + D để tạo bookmark cho trang này.');
  }
  return false;
});
  
  $('.print-but').on('click', function(){
      window.print();
  });
  $('.share-but').on('mouseenter', function(){ 
      $(this).addClass('active');

  });
  
   $('.save-but, .print-but').on('mouseenter', function(){ 
       $('.share-but').removeClass('active');		
  });
  
  $('.print-box').on('mouseleave', function(){ 
      $('.share-but').removeClass('active');	
  }); 

}


function subNav(){

    $('.sub-nav li').on("click",function(e){
		e.preventDefault();
        var id = $(this).find('a').attr('data-name');
        if (!doWheel) {return;}
        doWheel = false;
        $('.sub-nav li').removeClass('current');
        $(".sub-nav li a[data-name='" + id + "']").parent().addClass('current');
		
		var tmpurl = $(this).find('a').attr('href');
		var tmptitle = $(this).find('a').attr('data-title');
		var tmpkeyword = $(this).find('a').attr('data-keyword');
		var tmpdescription = $(this).find('a').attr('data-description');
		var tmpdataname = $(this).find('a').attr('data-name');
		changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,tmptitle,tmpdescription);
		

		 if($(window).width() > 1100){
             var Top = $(".set-post[data-post='" + id + "']").offset().top - 50;
		  }else{
			  var Top = $(".set-post[data-post='" + id + "']").offset().top - ($('.header').height()+30);
		  }

        $('html, body').stop().animate({ scrollTop: Top  }, 1500, 'easeInOutExpo', function(){
            setTimeout(turnWheelTouch, 100);
             setTimeout(function(){detectBut()},500);
        
        });

        return false;
    });
	
	if($('.sub-nav:not(.release) li.subcurrent').length){
		$('.sub-nav:not(.release) li.subcurrent').trigger('click');
	}else{
    	$('.sub-nav:not(.release) li:nth-child(1)').addClass('current');
	}

}

function onChange(input) {
	$('.file-name').html(input.files[0].name);
	$('.file-value').val(input.value);
	$('.outer-but').addClass('ready');
}
function FocusText(){
  $('input, textarea').focus(function (e) {
	  if($(this).attr('data-holder') == $(this).val()) {
		  $(this).val("");
	  }
  }).focusout(function (e) {
	  if ($(this).val() == "") {
		  $(this).prev().removeClass('hide');
		  $(this).val($(this).attr('data-holder'));
	  }
  });
				
}




function LinkPage(){
	  $('.link-load, .link-home, .go-page, .more, .video-a').on('click',function(e){
	   e.preventDefault();
	   $('.load-bg').removeClass('finish').removeClass('show');
	     var linkLocation =  $(this).attr("href");
		 $('.container, .footer, .slogan, .go-top').stop().animate({'opacity':1},1000 ,'linear', function () {
		     window.location = linkLocation;
	     });
	 	return false;

	});
	
	$('.link-blank').on("click", function(e) {
            e.preventDefault();
            var  url = $(this).attr('href');
            window.open(url, '_blank');
            return false;
      });
	
}

function ContentLoad(){
	ResizeWindows();
	AniText()
	LinkPage();
	FocusText();
	NavClick();
	Option();
	Search();
	ZoomPic();
	AnimationDelay();
	onScroll();
	detectBut();

	if($(window).width() > 1100){
		initScroll()
	}

	  //SET CURRENT BUTTON
   var IDPage = $('.container').attr('id');
	/*if($('#project-detail-page').length){
		IDPage = "projects-page";
		$('.nav li a[data-name= "' + IDPage + '"]').parent().addClass('active-color');
	}else if($('#product-detail-page').length){
		IDPage = "products-page";
		$('.nav li a[data-name= "' + IDPage + '"]').parent().addClass('active-color');
	}else if($('#news-details-page').length){
		IDPage = "news-page";
		$('.nav li a[data-name= "' + IDPage + '"]').parent().addClass('active-color');
	}else{
		$('.nav li a[data-name= "' + IDPage + '"]').parent().addClass('current');
		$('.link-home[data-name= "' + IDPage + '"]').addClass('current');
	}*/
	
	if($('#project-detail-page, #news-details-page, #service-details-page').length){
		$('.nav li.current').addClass('active-color').removeClass('current');
	}else if($('#product-detail-page').length){
		$('.nav > ul > li.current').addClass('active-color').removeClass('current');
	}

	
  	$('.banner-inner').addClass('show');
  	$('html, body').removeClass('no-scroll'); 
  	
  	setTimeout(function(){$('.load-bg').addClass('finish');}, 1000);
  	setTimeout(function(){$('.fb_reset').addClass('show');}, 1000);
  	

	if($('.section-first').length){
		$('.section-first').addClass('on-show');
	}
	
	if(!$('#home-page').length){
		 $('.logo').css({'cursor':'pointer'});
		 $('.logo').on( 'click',function() {
			 $('.link-home').trigger('click');
		});
		
	}
	setTimeout(function(){ $('.header').addClass('show');},200);

	setTimeout(function(){ $('.control').addClass('show');},200);
	setTimeout(function(){ $('.title-page').addClass('show');},500);
	setTimeout(function(){$('.box-nav').addClass('show')},800);


	if($('.outer-nav')) {
		var NamePage =   $('.container').attr('data-page');
		$(".outer-nav li a[data-name='" + NamePage + "']").parent().addClass('current'); 
	}

	$('.video-box').on('click', function() {
		$(this).find('a').trigger('click');
	  });
  	
  	//HOME PAGE
	if($('#home-page').length){	
	   setTimeout(function(){$('.wheel').addClass('show');},1500);	
	     
	  if ($('.youtube-video').length) {
			setTimeout(function(){ 
			 $('#playpause').trigger('click');
			},2000);
	    }
	}

	/* ABOUT PAGE */
  	if($('#about-page').length){
  		subNav();
		
		/*if($('.sub-nav li.subcurrent').length){
		   $('.sub-nav li.subcurrent a').trigger('click');
	    }*/
  	}


	//NEWS DETAIL PAGE//
     if($('#news-details-page').length ){
        $('.link-page').on('click', function (e) {
            e.preventDefault();
            $('.list-news').addClass('no-link');
            $('.load-content').removeClass('show');

            if(!$('.loadx').length){
                $('body').append('<div class="loadx" style="display:block"></div>');
            }


            $('.link-page').removeClass('current');
            $(this).addClass('current');

             //STATIC 
			 var url = $(this).find('a').attr('href'); 
             var Detail = $(this).find('a').attr("data-details");
             //window.location.hash = Detail;
			 
			 var tmpurl = $(this).find('a').attr('href');
			var tmptitle = $(this).find('a').attr('data-title');
			var tmpkeyword = $(this).find('a').attr('data-keyword');
			var tmpdescription = $(this).find('a').attr('data-description');
			var tmpdataname = $(this).find('a').attr('data-name');
			changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,tmptitle,tmpdescription);

            var OpenTab = $('.load-data');
            $(OpenTab).addClass('normal-height');

            if(Details == 1){
                var Top = $('.load-content').offset().top - 120;
                $('html, body').stop().animate({ scrollTop: Top}, 1000, 'easeInOutExpo', function(){
                    $(OpenTab).stop().animate({'opacity': 0}, 500, 'linear', function() {
                        NewsLoad(url, OpenTab);
                    });
                });

            }else{

                $(OpenTab).stop().animate({'opacity': 0}, 500, 'linear', function() {
                    NewsLoad(url, OpenTab);
                });
            }

            return false;
        });
		
		//STATIC
		
        /*if(window.location.hash){
         	  LocationHash();*/
         if($('.link-page.current').length){
			 $('.link-page.current').trigger('click');
		 }else{
         	$('.list-news').find('.link-page').first().trigger('click');
         }
		
    }

    /* CONTACT PAGE */
  	if($('#contact-page').length){
  		//initialize();
  	}

  	/* SERVICE PAGE */
  	if($('#services-page').length){
  		if($('.print').length){
  			PrintShare();
  		}
	  }
	  
	 //SERVICE DETAIL PAGE//
	if($('#service-details-page').length ){
			
        $('.link-page').on('click', function (e) {
            e.preventDefault();
            $('.list-news').addClass('no-link');
            $('.load-content').removeClass('show');

            if(!$('.loadx').length){
                $('body').append('<div class="loadx" style="display:block"></div>');
            }

            $('.link-page').removeClass('current');
            $(this).addClass('current');

             //STATIC 
			 var url = $(this).find('a').attr('href');
             var Detail = $(this).find('a').attr("data-details");
             //window.location.hash = Detail;
			 
			 var tmpurl = $(this).find('a').attr('href');
			var tmptitle = $(this).find('a').attr('data-title');
			var tmpkeyword = $(this).find('a').attr('data-keyword');
			var tmpdescription = $(this).find('a').attr('data-description');
			var tmpdataname = $(this).find('a').attr('data-details');
			changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,tmptitle,tmpdescription);

			 var OpenTab = $('.load-data');
			 $(OpenTab).addClass('normal-height');
			 
            if(Details == 1){
                var Top = $('.load-content').offset().top - 120;
                $('html, body').stop().animate({ scrollTop: Top}, 1000, 'easeInOutExpo', function(){
                    $(OpenTab).stop().animate({'opacity': 0}, 500, 'linear', function() {
                        ServiceLoad(url, OpenTab);
                    });
                });

            }else{

                $(OpenTab).stop().animate({'opacity': 0}, 500, 'linear', function() {
                    ServiceLoad(url, OpenTab);
                });
            }

            return false;
        });
		
		//STATIC
		
        /*if(window.location.hash){
         	  LocationHash();*/
         if($('.link-page.current').length){
			 $('.link-page.current').trigger('click');
		 }else{
         	$('.list-news').find('.link-page').first().trigger('click');
         }
		 
	}


  	/* SERVICE PAGE */
  	if($('#library-page').length){
  		if($('.item-document').length){
  			$('.item-document a').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');

				$('html, body').addClass('no-scroll');

				hash = $(this).attr('data-name');
				//window.location.hash = hash;
				
				var tmpurl = $(this).attr('href');
				var tmptitle = $(this).attr('data-title');
				var tmpkeyword = $(this).attr('data-keyword');
				var tmpdescription = $(this).attr('data-description');
				var tmpdataname = $(this).attr('data-name');
				changeUrl(tmpurl,tmptitle,tmpdescription,tmpkeyword,tmpdataname,tmptitle,tmpdescription);

				if(!$('.loadicon').hasClass('loader') || !$('.loadx').length){
					 $('body').append('<div class="loadx" style="display:block"></div>');
					  $('.overlay-dark').addClass('show');
					  popupLoad(url);
				}
				
				return false;
			});
			/*if(window.location.hash){
				LocationHash();*/
			 if($('.item-document.current').length){
				 $('.item-document.current a').trigger('click');
			 }else{
				$('.loadx').fadeOut(400, 'linear', function() {
					$('.loadx').remove();
			     });
			 }

  		}
  	}
	
	/* PRODUCT PAGE */
	if($('#products-page, #product-detail-page').length){
		if($('.add').hasClass('current')){
		    var ID = $('.add.current').find('.hover-btn').attr('data-sub');
		    $('.add.current').addClass('active').removeClass('current');
			var Height = $('.second-sub-menu[data-show= "' + ID + '"]').find('ul').innerHeight()
			$('.second-sub-menu[data-show= "' + ID + '"]').height(Height);
	    }
	}
  	

  	/* PRODUCT DETAIL PAGE */
  	if($('#product-detail-page').length){
  		thumbslider();

  		$('.tab-des li a').on( 'click',function(){
			$('.tab-des li').removeClass('current');
			var Openpage = $(this).attr("data-target");
			$(this).parent().addClass('current');
			$('.tab-content').removeClass('active');
			var allItem = $('.tab-content').length;
            var widthItem = $('.tab-content').width();
            var heightItem = $('.all-tab-content .tab-content[data-tab= "' + Openpage + '"]').innerHeight(); 
            $('.all-tab-content').width(allItem * widthItem);
			var XCurrent = $('.all-tab-content').offset().left;
			var XItem = $('.tab-content[data-tab= "' + Openpage + '"]').offset().left;
			$('.all-tab-content').stop().animate({'left': XCurrent - XItem, 'height': heightItem}, 800, 'easeInOutExpo', function() { 
				$('.all-tab-content .tab-content[data-tab= "' + Openpage + '"]').addClass('active');
			});
		});

		$(".tab-des li:first-child a").trigger('click');

  	}
  	

}



function gird() {
	if($(window).width() <= 1100){
		 var Duration = '0.3s'
	}else{
		 var Duration = '0.6s'
	}
	  var $grid = $('.grid');
	  imagesLoaded($grid, function() {
		  $grid.isotope({
		   itemSelector: '.item-grid',
		   percentPosition: true,
		  
		   transitionDuration: Duration,
			 hiddenStyle: {
			  opacity: 0,
			},
			visibleStyle: {
			 opacity: 1,
			}
		 });
			  
	});
}


function videoSlide() {
$('.video-center').on("click", ".video-inner", function(){
	 //LOAD YOUTUBE API
	 onYouTubePlayerAPIReady();
  });



//YOUTUBE API
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var youTubeUrl = $('.video-inner').attr('data-src');
    var youTubeId;
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = youTubeUrl.match(regExp);
    if (match && match[2].length == 11) {
        youTubeId = match[2];
    } else {
        youTubeId = 'no video found';
    }	
	
var youTube = $('.video-inner');
var Source = "https://img.youtube.com/vi/"+  youTubeId +"/sddefault.jpg";
if(iOS){
var SRC = '<iframe id="VYT" src="https://www.youtube.com/embed/' + youTubeId + '?enablejsapi=1&controls=1&loop=0&playsinline=1&color=white&rel=0&cc_load_policy=1&playlist='+ youTubeId +'" frameborder="0"  allow="autoplay" allowfullscreen></iframe>';
}else{
var SRC = '<iframe id="VYT" src="https://www.youtube.com/embed/' + youTubeId + '?enablejsapi=1&controls=0&loop=0&playsinline=1&color=white&rel=0&cc_load_policy=1&playlist='+ youTubeId +'" frameborder="0"  allow="autoplay" allowfullscreen></iframe>';
}
$(youTube).append(SRC);

var player;

function onYouTubePlayerAPIReady() {
  player = new YT.Player('VYT', {
    events: {
      'onReady': onPlayerReady,
    }
  });
}
		
		
function onPlayerReady(event) {
$('.play-button').on('click', function (e) {
	e.preventDefault();
     player.playVideo();
 });
 
$('.pause-button').on('click', function (e) {
	e.preventDefault();
    player.pauseVideo();
 });
 
}		

}



function Zoom(elm){
		
			$('html, body').addClass('no-scroll');
			zoomPC = true;
			$(this).parent().addClass('to-scrollZ');
			
			if(!$('.loadicon').hasClass('loader')){
					$('.loadicon').show();
					$('.loadicon').addClass('loader');
					DrawLoad();					
			}
			
			$('.all-pics').addClass('show');
			$('.all-pics').append('<div class="full size-large"  style="display:block"></div>');
			
			$('.overlay-dark').addClass('show');
			
			var activePicLarge = $(elm).attr("src"); 
			$('.all-pics').find('.full').append('<img src ="'+(activePicLarge)+'" alt="pic" />');
			
			$('.all-pics').find('.full').append('<span></span>');
			$('body').append('<a class="close-pics" href="javascript:void(0);"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="currentColor" d="M50,54 27.2,76.8 23.2,72.8 46,50 23.2,27.2 27.2,23.2 50,46 72.8,23.2 76.8,27.2 54,50 76.8,72.8 72.8,76.8z"></path></svg></a>');
		    $('.all-pics').append('<div class="close-pics-small"></div>'); 
			
			$('.all-pics img').on( "load", function() {
					$('.all-pics').addClass('show');
					
					if(TouchLenght == false  || !isTouchDevice){ 
							$('.full').addClass('dragscroll');
							$('.dragscroll').draptouch();
							
					}else{
							$('.full').addClass('pinch-zoom');
							$('.pinch-zoom').each(function () {
									new Pic.PinchZoom($(this), {});
							});
					}
					
					if($('.full img').length>1){
							$('.full img').last().remove()
					}
					
					$('.loadicon').fadeOut(400, 'linear', function() {
							
							if(TouchLenght == false  || !isTouchDevice){ 
									detectMargin();
							}
							
							$('.full img').addClass('fadein');
							 $('.loadicon').removeClass('loader');
	                         $('.loadicon').removeClass('show'); 
							
					});
			
			});
			
			if($(window).width() > 1100) {
					$('.full span').on('click', function () {
							$('.close-pics').trigger('click');
					});
			}	
			
			$('.close-pics-small, .close-pics').on("click" ,function() {
					zoomPC = false;
					
					 $('.loadicon').removeClass('loader');
	                 $('.loadicon').removeClass('show'); 
					$('.full').fadeOut(300, 'linear', function() {
							$('.overlay-dark').removeClass('show');
							$('.all-pics .full,  .all-pics .pinch-zoom-container').remove();
							$('.close-pics-small, .close-pics').remove();
							$('.all-pics').removeClass('show');
							
							if(!$('.house').length){
									$('html, body').removeClass('no-scroll');
									
							  if($('.to-scrollZ').length) {
									  var top = $('.to-scrollZ').offset().top;
									  $('.to-scrollZ').removeClass('to-scrollZ');
											  if($(window).width() < 1100) {
													  $('html, body').scrollTop(top - 60);
											  }
							  }
							}
							
					});	
					
		});
			
}

 function ZoomPic() {

   $('img').on("click" ,function() {
					
  if($(this).hasClass('zoom-pic')){
		  $('html, body').addClass('no-scroll');
		  $(this).parent().addClass('to-scrollZ');
		  
			   if(!$('.loadx').length){
				   $('body').append('<div class="loadx" style="display:block"></div>');
			     }
		  
		  $('.all-pics').addClass('show');
		  $('.all-pics').append('<div class="full" style="display:block"></div>');
		  if(!$('.details-content').length){
		     $('.overlay-dark').addClass('show');
		  }else{
			  $('.overlay-dark').addClass('level-index-in'); 
		  }
		  var activePicLarge = $(this).attr("src");
		  
		  $('.all-pics').find('.full').append('<img src ="'+(activePicLarge)+'" alt="pic" />');
		  $('.all-pics').find('.full').append('<span></span>');
		  $('body').append('<a class="close-pics" href="javascript:void(0);"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="currentColor" d="M50,54 27.2,76.8 23.2,72.8 46,50 23.2,27.2 27.2,23.2 50,46 72.8,23.2 76.8,27.2 54,50 76.8,72.8 72.8,76.8z"></path></svg></a>');
		  $('.all-pics').append('<div class="close-pics-small"></div>'); 
		  
		  $('.all-pics img').on( "load", function() {
				  $('.all-pics').addClass('show');
				  
				  if(TouchLenght == false  || !isTouchDevice){ 
						  $('.full').addClass('dragscroll');
						  $('.dragscroll').draptouch();
						  
				  }else{
						  $('.full').addClass('pinch-zoom');
						 $('.pinch-zoom').each(function(index, element) {
					        new PinchZoom.default(element, {});
                         });
				  }
				  
				  if($('.full img').length>1){
						  $('.full img').last().remove()
				  }
				  
				  $('.loadx').fadeOut(400, 'linear', function() {
						  
						  if(TouchLenght == false  || !isTouchDevice){ 
								  detectMargin();
						  }
						  
						  $('.full img').addClass('fadein');
						  $('.loadx').remove();
						   
						  
				  });
		  
		  });
		  
		  if($(window).width() > 1100) {
				  $('.full span').on('click', function () {
						  $('.close-pics').trigger('click');
				  });
		  }	
							
	    $('.close-pics-small, .close-pics').on("click" ,function() {
		        $('.loadx').remove();
				$('.full').fadeOut(300, 'linear', function() {
				$('.all-pics .full,  .all-pics .pinch-zoom-container').remove();
				$('.close-pics-small, .close-pics').remove();
				$('.all-pics').removeClass('show');
				
				if(!$('.details-content').length){
			  	  $('html, body').removeClass('no-scroll');
				  $('.overlay-dark').removeClass('show');
				   if($('.to-scrollZ').length) {
				    var top = $('.to-scrollZ').offset().top;
				   $('.to-scrollZ').removeClass('to-scrollZ');
				     if($(window).width() < 1100) {
						$('html, body').scrollTop(top - 60);
				    }
		         }
              }else{
				    $('.overlay-dark').removeClass('level-index-in');
			  }

            });	

         });

      }
			
	 return false;
					
    });
		
}

//NEWS LOAD
function NewsLoad(url, OpenTab) {
    if($(OpenTab).children().length > 0){
        $(OpenTab).children().remove();
    }
	
	//DYNAMIC
    //url = '/ajaxnews' + url;

	//REMOVE THIS
	$('.link-page').addClass('display-none');
	 if($('.link-page.current').prevAll().length==0){
		 $('.link-page').last().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
	 	 $('.link-page.current').next().next().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==$('.link-page').length - 1){
		 $('.link-page').first().removeClass('display-none');
		 $('.link-page.current').prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==1){
		 $('.link-page.current').prev().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
	 	 $('.link-page.current').next().next().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==2){
		 $('.link-page.current').prev().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
	 	 if(!$('.link-page.current').next().next().length){
			 $('.link-page.current').prev().prev().removeClass('display-none');
		 }else{
	 	 	$('.link-page.current').next().next().removeClass('display-none');
		 }
	 }else{
		 $('.link-page.current').prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().prev().removeClass('display-none')
	 }

    $.ajax({url: url, cache: false, success: function(data) {

        $(OpenTab).html(data);
            $('.load-text a, .load-text p a').click(function(e){
                e.preventDefault();
                var  url = $(this).attr('href');
                window.open(url, '_blank');
                return false;
            });


            $('.load-text img').addClass('zoom-pic');
            ZoomPic();
            PrintShare();
            $(OpenTab).stop().animate({'opacity': 1}, 300, 'linear', function() {

            	if($(window).width() < 1100){
					detectBut();
				}
            	
                $('.list-news').removeClass('no-link');
                $(OpenTab).removeClass('normal-height');
                $('.loadx').fadeOut(400, 'linear', function() {
                    $('.loadx').remove();
                });
                onScroll();
                Details = 1;
			   $('.load-content').addClass('show');
				
            });



        }});

}

//SERVICE LOAD
function ServiceLoad(url, OpenTab) {
    if($(OpenTab).children().length > 0){
        $(OpenTab).children().remove();
    }
	
	//DYNAMIC
    //url = '/ajaxnews' + url;
	
	//REMOVE THIS
	$('.link-page').addClass('display-none');
	 if($('.link-page.current').prevAll().length==0){
		 $('.link-page').last().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
	 	 $('.link-page.current').next().next().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==$('.link-page').length - 1){
		 $('.link-page').first().removeClass('display-none');
		 $('.link-page.current').prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==1){
		 $('.link-page.current').prev().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
	 	 $('.link-page.current').next().next().removeClass('display-none');
	 }else if($('.link-page.current').prevAll().length==2){
		 $('.link-page.current').prev().removeClass('display-none');
		 $('.link-page.current').next().removeClass('display-none');
		 if(!$('.link-page.current').next().next().length){
			 $('.link-page.current').prev().prev().removeClass('display-none');
		 }else{
	 	 	$('.link-page.current').next().next().removeClass('display-none');
		 }
	 }else{
		 $('.link-page.current').prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().removeClass('display-none');
	 	 $('.link-page.current').prev().prev().prev().removeClass('display-none')
	 }
	 
    $.ajax({url: url, cache: false, success: function(data) {

        $(OpenTab).html(data);
            $('.load-text a, .load-text p a').click(function(e){
                e.preventDefault();
                var  url = $(this).attr('href');
                window.open(url, '_blank');
                return false;
            });


            $('.load-text img').addClass('zoom-pic');
            ZoomPic();
            PrintShare();
            $(OpenTab).stop().animate({'opacity': 1}, 300, 'linear', function() {

            	if($(window).width() < 1100){
					detectBut();
				}
            	
                $('.list-news').removeClass('no-link');
                $(OpenTab).removeClass('normal-height');
                $('.loadx').fadeOut(400, 'linear', function() {
                    $('.loadx').remove();
                });
                onScroll();
                Details = 1;
			   $('.load-content').addClass('show');
				
            });



        }});

}


function loadPage(url) {
	
    if($('.load-page-data').children().length > 0){
        $('.load-page-data').children().remove();
    }
	
    $.ajax({ url: url, cache: false, success: function (data) {

            $('.load-page-data').append(data);
         
		  	Loadpic()

            $('.load-page-data').stop().animate({ 'opacity': 1 }, 300, 'linear', function () {
                 $('.load-page-data').addClass('show set-post active');
				 Details = 1;
				 onScroll();   
            });
			$('.loadx').fadeOut(300, 'linear', function () {
                $('.loadx').remove();
            });

            var Goto = $('.slide-pagi a.current').parent().parent().index() - 1;
            setTimeout(function () { $('.slide-pagi').data('btq.slidebox').to(Goto, 300, true); }, 500);
            Option()
           	LinkPage();   
           
        }
    });

}


function Option() {
        
        $('.brochure-but, .item-catalogue a, .pdf-download').on("click", function(e) {
            e.preventDefault();
            var  url = $(this).attr('href');
            window.open(url, '_blank');
            return false;
            
        });

		$('.item-document, .product-new, .box-news, .big-news, .item-cer, .item-video, .item-news:not(.link-page), .item-pic, .item-project, .item-product').on("click", function(e) {
            $(this).find('a').trigger('click');
        });
		
		
    
		$('.view-video').on( 'click',function(e) {
	        e.preventDefault();
	        $(this).parent().addClass('to-scrollV');
			
	         var idx = $(this).attr('data-href') || $(this).attr('href');
			 
			  var youTubeUrl = $(this).attr('data-embed');
			  var youTubeId;
			  var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
			  var match = youTubeUrl.match(regExp);
			  if (match && match[2].length == 11) {
				  youTubeId = match[2];
			  } else {
				  youTubeId = 'no video found';
			  }	
	        
			
			var Source  = '<iframe id="VYT" src="https://www.youtube.com/embed/' + youTubeId + '?autoplay=1&enablejsapi=1&controls=1&loop=0&playsinline=1&color=white&rel=0&cc_load_policy=1&playlist='+ youTubeId +'" frameborder="0"  allow="autoplay" allowfullscreen></iframe>';
			//console.log(Source)
	        if(!$('.loadx').length){
	            $('body').append('<div class="loadx" style="display:block"></div>');
	        }

	        $('html, body').addClass('no-scroll');
	        $('.overlay-dark').addClass('show');

	        $('.allvideo').fadeIn(300, 'linear', function() {
	            VideoLoad(idx, Source);
	        });
	        return false;
	    });


  		$('.view-album, .view-zoom-al').on("click", function(e){
	  	
			e.preventDefault();
			var url = $(this).attr('data-href') || $(this).attr('href');
			
			var num = $(this).attr('data-go') || -1;
			if( $('.slide-pic').length){
			  $('.slide-pic').trigger('stop.btq.autoplay');
			}
			 
			if(!$('.loadx').length){
			   $('body').append('<div class="loadx" style="display:block"></div>');
		     }
			
			$('html, body').addClass('no-scroll');
			$('.overlay-dark').addClass('show');
			
			$('.all-album').fadeIn(300, 'linear', function() {
					AlbumLoad(url,num);
					
			});
			
			return false;
			
	
	});

          	 
    $('.zoom').on("click" ,function() {
					
					
					$('html, body').addClass('no-scroll');
					
					if(!$('.loadx').length){
				       $('body').append('<div class="loadx" style="display:block"></div>');
			        }
					
					$('.all-pics').addClass('show');
					$('.all-pics').append('<div class="full" style="display:block"></div>');
					$('.overlay-dark').addClass('show');
					
					var newActive = $(this).attr('data-pic') || $(this).parent().find('img').attr('src');
					var Text =  $(this).parent().find('h3').text();
					$('.all-pics').find('.full').append('<img src ="'+(newActive)+'" alt="pic" />');
					$('.all-pics').find('.full').append('<span></span>');
					$('body').append('<a class="close-pics" href="javascript:void(0);"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="currentColor" d="M50,54 27.2,76.8 23.2,72.8 46,50 23.2,27.2 27.2,23.2 50,46 72.8,23.2 76.8,27.2 54,50 76.8,72.8 72.8,76.8z"></path></svg></a>');
		  			$('.all-pics').append('<div class="close-pics-small"></div>');
					// $('.all-pics').prepend('<div class="text-length"><h3></h3></div>');	
					$('.text-length h3').text(Text);
					
					$('.all-pics img').on("load",function() {
					$('.all-pics').addClass('show');
					
					if(TouchLenght == false  || !isTouchDevice){ 
							$('.full').addClass('dragscroll');
							$('.dragscroll').draptouch();
					}else{
							$('.full').addClass('pinch-zoom');
							$('.pinch-zoom').each(function(index, element) {
					        new PinchZoom.default(element, {});
                         });
					}
					
					if($('.full img').length>1){
							$('.full img').last().remove()
					}
					
					    $('.loadx').fadeOut(400, 'linear', function() {
							
							if(TouchLenght == false  || !isTouchDevice){ 
									detectMargin();
							}
							
							    $('.full img, .text-length').addClass('fadein');
								 $('.loadx').remove();
									
							});
							
					});
					
					if($(window).width() > 1100) {
							$('.full span').on('click', function () {
									$('.close-pics').trigger('click');
							});
					}	
					
					
					$('.close-pics, .close-pics-small').on("click" ,function() {
							
							$('.loadx').remove();
							$('.full').fadeOut(300, 'linear', function() {
									 
									$('.overlay-dark').removeClass('show');
									$('.all-pics .full, .all-pics .text-length, .all-pics .pinch-zoom-container').remove();
									$('.close-pics, .close-pics-small').remove();
									$('.all-pics').removeClass('show');  
									$('html, body').removeClass('no-scroll');
									
							});
							
					});
					
					return false;
		});
	    
 

}

function AlbumLoad(url,num) {
     $.ajax({url: url, cache: false, success: function(data) {
	
	

	 if(TouchLenght == false  || !isTouchDevice){
		  if($('.slide-slidebox').length){
		   $('.slide-slidebox').trigger('stop.btq.autoplay');
		  }
     }
	
	  $('.all-album').append(data);
	  
	  if($('.all-album .album-load').length >1){
			  $('.all-album .album-load').last().remove();
	  }
	  
	  $(".pic-name > h3").lettering('words').children("span").lettering().children("span").lettering();
	  
	   $('.album-center').on('initialized.btq.slidebox', function () {
		   
		 $('.container-zoom').each(function(index, element) {
			  new PinchZoom.default(element, {draggableUnzoomed: false});
		  });
		  
		  if(num!=-1){
			  $('.album-center').find('.slide-item').eq(num).addClass('selected');
		  }else{
		  	  $('.album-center').find('.slide-item.active').addClass('selected'); 
		  }
		  
		 addText();
			 
	    }).BTQSlider({
	    animateOut: 'fadeout',
		animateIn: 'fadein',
		rewind:true,
		items:1,
		margin:0,
	    smartSpeed:600,
	    loop:false,
	    dots: true,
		nav:true,
		responsiveRefreshRate : 200,
			
        }).on('changed.btq.slidebox', function(el) {
		     if($('.thumbs').length){
			    syncPosition(el);
			 }
		}).on( 'translate.btq.slidebox', function(el) {
		    $('.album-center').find('.slide-item').removeClass('selected');
	    }).on('translated.btq.slidebox', function(el) {
			 $('.album-center').find('.slide-item.active').addClass('selected'); 
			 addText();

	    });
		
		
	    
	  
	  $('.thumbs').on('initialized.btq.slidebox', function () {
		  var Length =  $('.thumbs').find(".slide-item").length	
	 
	  if($(window).width() >= 600){
	      if(Length <= 6){
			   $('.thumbs').addClass('center-slidebox');
		  }else{
			  $('.thumbs').removeClass('center-slidebox');
		  }
	  }else{
		   if(Length <= 3){
			   $('.thumbs').addClass('center-slidebox');
		  }else{
			  $('.thumbs').removeClass('center-slidebox');
		  }
	  }
		  
      $('.thumbs').find(".slide-item").eq(0).addClass("current");
			}).BTQSlider({
			margin:5,
			smartSpeed:300,
			dots: false,
			nav:false,
			responsiveRefreshRate : 100,
			responsive:{
				0:{
					items:3,
					slideBy: 3,
				},
				
				600:{
					items:6,
					slideBy: 6,
				},
			 }
       });
	  
	 
	  function syncPosition(el) {
				//set loop to true
				//var Current = Math.round(el.item.index - (el.item.Count/2) - .5);
				//set loop to false
				//var Current = el.item.index;
			
				var Count = el.item.Count-1;
				var Current = el.item.index;
			 
				  if(Current < 0) {
					 Current = Count;
				  }
				  if(Current > Count) {
					Current = 0;
				   }
		
		   $('.thumbs').find(".slide-item").removeClass("current").eq(Current).addClass("current");
		   var Onscreen =  $('.thumbs').find('.slide-item.active').length - 1;
		   var Start =  $('.thumbs').find('.slide-item.active').first().index();
		   var End =  $('.thumbs').find('.slide-item.active').last().index();
			if (Current >= End -1 ) {
			   $('.thumbs').data('btq.slidebox').to(Current, 300, true);
			}
			
			if (Current <= Start) {
			   $('.thumbs').data('btq.slidebox').to(Current - Onscreen, 300, true);
			}
	   }
	
  
	 $('.thumbs').on("click", ".slide-item", function(e){
		e.preventDefault();
		var Num = $(this).index();
		$('.album-center').data('btq.slidebox').to(Num, 1000, true);
	  });
	
	  if(num!=-1){
		  $('.album-center').data('btq.slidebox').to(num, 0, true);
	  }
	  
	  $('.all-album').on('mousewheel', '.album-center', function (e) {
			if (e.deltaY>0) {
				if (!doWheel) {
			     return;
		       }
			   doWheel = false;
				 $('.album-center').trigger('prev.btq.slidebox');
				  setTimeout(turnWheelTouch, 500);
			} else {
					if (!doWheel) {
			     return;
		       }
			   doWheel = false;
				 $('.album-center').trigger('next.btq.slidebox');
				  setTimeout(turnWheelTouch, 500);
			}
			e.preventDefault();
		});
	   
	  function addText() {
			  clearTimeout(timex);
			  $('.pic-name').removeClass('move');	
			  $('.pic-name h3').children().children().removeClass('move');
			  $('.selected').find('.pic-name').addClass('move');
			  $('.move h3').children().children().each(function(i){
					  var box = $(this);
					  var timex = setTimeout(function(){$(box).addClass('move')}, (i+1) * 100);
			  });
	  
	  }
	  
	  
	  $('.album-load').animate({'opacity':1}, 100, 'linear', function() {
			  $('.loadx').fadeOut(400, 'linear', function() {
				  $('.loadx').remove();
			  });
	  });
	  

	  $('.close-album').on("click" ,function() {
			  $('.all-album').fadeOut(500, 'linear', function() {
					  $('.overlay-dark').removeClass('show');
					  $('.album-load').remove();
			  });
			  
				 if(TouchLenght == false  || !isTouchDevice){
						if($('.slide-slidebox').length){
		                $('.slide-slidebox').trigger('play.btq.autoplay');
	                    }
				}
				
			  $('html, body').removeClass('no-scroll');
			  return false;
			  
	   });

	  

   }});
}

function turnWheelTouch(){
	doWheel = true;
	doTouch = true;
}  


function detectBut() {


	if($(window).width() <= 1100 && $('.sub-nav li.current').length){
	  var Left  = $('.sub-nav ul').offset().left;
	  var XLeft = $('.sub-nav li.current').offset().left;
	  var Middle = $(window).width()/2 - $('.sub-nav li.current').width()/2;
	  $('.sub-nav').stop().animate({scrollLeft:  (XLeft-Middle) - Left}, 'slow');
	}

 
}


function detectMargin() {
var ImgW = $('.full img').width();
var ImgH = $('.full  img').height();
var Yheight = $(window).height();
var Xwidth = $(window).width();

	if (Xwidth > ImgW) {
		  $('.full img').css({'margin-left': Xwidth / 2 - ImgW / 2});
	  } else {
		  $('.full img').css({'margin-left': 0});
	  }
	  if (Yheight > ImgH) {
		  $('.full img').css({'margin-top': Yheight / 2 - ImgH / 2});
	  } else {
		  $('.full img').css({'margin-top':  0});
	  }
}


function initScroll() {
    $('.box-ser .pic-bg').paroller({
        factorXs: 0.12,
        factorSm: 0.12,
        factorMd: -0.12,
        factorLg: -0.12,
        factorXl: -0.12,
        factor: -0.12,
        type: 'foreground',
        direction: 'vertical',
        transition: 'transform .3s ease-out'
    });
}

$(document).ready(function () {

$('.container').on('click', function(){
   if($(window).width() > 1100){
		if($('.search-but').hasClass('active')){
		  $('.search-form, .search-but').removeClass('active');}
	   
	    if($('.nav-click').hasClass('active')){
		  $('.nav-click').trigger('click');}
   }
	
});

$('.hotline span').on('click', function(){
	$('.box-hotline').toggleClass('show');
});

$(document.documentElement).keyup(function (e) {
  	if (e.keyCode == 39)
	  {
	   e.preventDefault();
	   $('.album-center .slide-next').trigger('next.btq.slidebox');
	   $('.slide-mask .slide-next').trigger('next.btq.slidebox');
	   return false;
	  }

	  if (e.keyCode == 37)
	  {
	  	e.preventDefault();
	    $('.album-center .slide-prev').trigger('prev.btq.slidebox');
	    $('.slide-mask .slide-prev').trigger('next.btq.slidebox');
	    return false;
	  }
});

$('.select-header').bind("click", function () {
    if (!$('.select-header').hasClass('onclick')) {
        $(this).addClass('onclick');
        $(this).next('.select-box').fadeIn(100, 'linear');

        $(this).closest('.select-list').on("mouseleave", function () {
            $(this).find('.select-box').fadeOut(100, 'linear');
            $('.select-header').removeClass('onclick')
        });
    } else {
        $('.select-header').removeClass('onclick');
        $(this).next('.select-box').fadeOut(100, 'linear');
    }

});

$('.a-contact-in').bind("click", function () {
	$('.show-contact-in').addClass('show')
});

$('.close-contact').bind("click", function () {
	$('.show-contact-in').removeClass('show')
});


$(document).bind('scroll', function() {
		var currenttop = $(document).scrollTop();
		var scrollY = $(window).scrollTop();
		var Banner =  $('.slide-mask').innerHeight();
		var Head =  $('.header').innerHeight();

		if ($(window).width() <= 540) {
		    if (currenttop > 10) {
                $('.logo-value').addClass('hide');
            } else {
                $('.logo-value').removeClass('hide');
            }
        }

		 if(windscroll >= 70){
			 $('.header').addClass('hide');
			 $('.wheel').removeClass('show');
		 }else{
			 $('.header').removeClass('hide');
			 $('.wheel').addClass('show');
		}
		
		  if(currenttop > $(window).height()/2) {
		       $('.go-top').addClass('show');
	       }else {
		       $('.go-top').removeClass('show');
	       }

	     if ($('.second').length) {
	     	
	     	if ($(window).width() > 1100 ) {
	     		var fixed = (Banner - Head) + 40
	     	}else {
	     		var fixed = (Banner - Head) + 100
	     	}
            if(currenttop >=  fixed) {
                $('.second').addClass('fixed');
                $('.wheel').removeClass('show');
            }else{
                $('.second').removeClass('fixed');
                $('.wheel').addClass('show');
            }
        }
        
        
		window.requestAnimationFrame(function () {
            if ($(window).width() > 1100) {
                $('.bg-inner, .bg-home').css({ '-webkit-transform': 'translateY(' + scrollY * 0.3 + 'px)', 'transform': 'translateY(' + scrollY * 0.3 + 'px)' });
            }
            onScroll()
    	})


		//CURRENT SUB NAV
		$('.set-post').each(function(){
		  var top = $(this).offset().top - $(window).height()/2;
		  var Height = $(this).outerHeight();
		  var bottom = top + Height;

		  var SubNav = ($(window).height() - $('.sub-nav, .nav-scroll').height())/2 ;
		  var topNav = $(window).height() /2 ;

		  if (currenttop >= top && currenttop <= bottom) {
			  $('.set-post').removeClass('active');
			  $(".sub-nav li, .nav-scroll li").removeClass('color-active')
			  $(this).addClass('active');
			  if(doWheel == true){
					$('.sub-nav li, .nav-scroll li').removeClass('current');
					$('.sub-nav li a[data-name="' + $(this).attr('data-post') + '"], .nav-scroll li a[data-name="' + $(this).attr('data-post') + '"]').parent().addClass('current');
					detectBut()
			  }	

		  }
		});
		
		if(currenttop >= $(window).height()/2) {
			  
			  if ($('.youtube-video').length) {
			     $('.pause-button').trigger('click');
				 $('.control').addClass('hide');
			 }else{
				 $('.stop').trigger('click');
			 }
			 
		  }else if(currenttop <= 100){
			  
			  if ($('.youtube-video').length && $('.slide-mask .slide-item:first-child').hasClass('ani-text')) {
		 	    $('.play-button').trigger('click');
				$('.control').removeClass('hide');
			 }else{
				 $('.play').trigger('click');
			 }
			
		  }

		

		windscroll = currenttop;
		
 });
   

document.addEventListener( 'keydown', function(e) {
	 
	 var keyCode = e.keyCode || e.which;
	   if( keyCode === 38) {
		 $('.box-nav li.current').prev().trigger('click');
	   }
		if( keyCode === 40) {
		 $('.box-nav li.current').next().trigger('click');
	   }
	   if( keyCode === 27) {
		   if($('.content-popup-marterial').length){
		     $('.close-box').trigger('click');
		   }
		    if($('.full img').length){
		     $('.close-pics').trigger('click');
		   }
			
	   }
	 
});



$('.go-top').on( 'click',function(){
	if($(window).width() > 1100){
		if( $('.box-nav').length){
			$('.box-nav li:first-child').trigger('click')
		}else{
			$('html, body').animate({scrollTop:0},'slow');
		}
	}else{
		$('html, body').animate({scrollTop:0},'slow');
	}
});

 
// if($('#home-page').length){
// setTimeout(function(){if( Loadx == 0){ Loadx = 1;  Done();}}, 1500);
// }else {
// setTimeout(function(){if( Loadx == 0){ Loadx = 1;  Done();}}, 500);	
// }
if($('#home-page').length){
	setTimeout(function(){if( Loadx == 0){ Loadx = 1;  Done();}}, 1800);
 }else{
	 setTimeout(function(){if( Loadx == 0){ Loadx = 1;  Done();}}, 700);
 } 

});

window.onorientationchange = ResizeWindows;
$(window).on("orientationchange",function(){
 if ($(window).width() <= 1100) {
	 ScrollHoz();  
 }
 
});

$(window).resize(function () {
 if($(window).width() > 1100){
	 if( $('.news-text img').hasClass('zoom-pic')){ 
	   $('.close-pics-small').trigger('click');
	 }
 }

   
ResizeWindows();
	 
});	

$(window).on('resize', function() {
   ResizeWindows();
   detectMargin();
//-----------------------------			
//  DESKTOP 	
    if ($(window).width() > 1100) {
		var startAni = false;
			
		   	
		  
		 if($('.dragscroll').length){ 
		      detectMargin();
			  $('.dragscroll').draptouch();
			  
		 }
			

		if($('.tab-des li.current').length){
			$('.tab-des li.current a').trigger('click');
		}
	
			
if($('.news-list, .content-table, .sub-nav, .scroll-slide, sub-news, .nav-filter').hasClass('dragscroll')){
   $('.news-list, .content-table, .sub-nav, .scroll-slide, .sub-news, .nav-filter').removeClass('dragscroll draptouch-active draptouch-moving-left draptouch-moving-down');
   $('.news-list, .content-table, .sub-nav, .scroll-slide, .sub-news, .nav-filter').css({'overflow':'visible'});
}

		  
	       
//  DESKTOP 

//-----------------------------		
 
//  MOBILE 		
    } else {
		
		
		
		///////////////
		 
		var startAni = true;

		$('.tab-des li.current a').trigger('click');
		
        setTimeout(function(){ detectBut()}, 1000);
			
  }
	  
		 
	
//  MOBILE 	 
//-----------------------------	
 
/* ABOUT PAGE */
if ($('#about-page').length) {
	var heightauto = $('.toogle-history.active').find('.toogle-content').innerHeight();
	$('.toogle-history.active').find('.toogle-box').css('height', heightauto);
}	 
   
}, 250);




function LocationHash() {
		var PageActive = window.location.hash;
		PageActive = PageActive.slice(1);
		$(".link-page a[data-details='" + PageActive + "']").trigger('click');  	
		$(".table-re td a[data-name='" + PageActive + "']").trigger('click');
		$(".slide-pagi a[data-number='" + PageActive + "']").trigger('click');
}


//popstate
$(window).bind("popstate", function(e) {
	if($(window).width() > 1100){
	  e.preventDefault();
	}
	  var httpserver = $('.httpserver').text();
	  
	  if ( $(window).width() > 1100) {
		  
		  if (e.originalEvent.state !== null) {
			var tmp_url = e.originalEvent.state.path;
			var tmp_dataName = e.originalEvent.state.dataName;
			var tmptitle = e.originalEvent.state.title;
			var tmpurl = document.URL;
	
			changeUrl(tmp_url, tmptitle, '', '', tmp_dataName, '', '');
			
			var temp_url_1 = tmp_url.replace(httpserver, ""); 
			var tmp_1 = temp_url_1.split('/');
			
			if ($('#about-page, #library-page').length) {
				if($('.close-popup').length){
				  	$('.close-popup').trigger('click');
			  	}else{
					if($('.close-album').length){
						$('.close-album').trigger('click');
					}
					if($('.close-pics').length){
						$('.close-pics').trigger('click');
					}
					
					
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					
					$(".sub-nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
					
					$(".item-document a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			/*if ($('#distribution-page').length) {
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				$(".quick-box li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
				
			}*/
			
			if ($('#product-page').length) {
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
                $(".preload-product li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
                });
        	}
			
			/*if ($('#showroom-page').length) {
				if($('.close-album').length){
					$('.close-album').trigger('click');
				}
				if($('.iframe-showroom').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					$('.icon-360').each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
        	}*/
			
			
			if ($('#project-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					
					$(".sub-nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
					
					$(".view-details").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			if ($('#recruitment-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					
					//$(".career-list td a").each(function(index, element) {
					$(".career-title a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});

				}
				
			}
			
		
			
			if ($('#news-details-page, #service-details-page').length) {
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
			
				
				$(".link-page a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
			}
			
			
			
			
		  }else{
			  var tmpurl = document.URL;
			  
			  var temp_url_1 = tmpurl.replace(httpserver, ""); 
			  var tmp_1 = temp_url_1.split('/');
			  
			if ($('#about-page, #library-page').length) {
				if($('.close-popup').length){
				  $('.close-popup').trigger('click');
			    }else{
					if($('.close-album').length){
						$('.close-album').trigger('click');
					}
					if($('.close-pics').length){
						$('.close-pics').trigger('click');
					}
					
					
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							window.history.back();
						}
					});
					
					$(".sub-nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
					
					$(".item-document a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			/*if ($('#distribution-page').length) {
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						window.history.back();
					}
				});
				
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						window.history.back();
					}
				});
				
				$(".quick-box li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						$(element).trigger('click');
					}
				});
				
			}*/
			
			if ($('#product-page').length) {
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						window.history.back();
					}
				});
                $(".preload-product li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						$(element).trigger('click');
					}
                });
        	}
			
			/*if ($('#showroom-page').length) {
				if($('.close-album').length){
					$('.close-album').trigger('click');
				}
				if($('.iframe-showroom').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							window.history.back();
						}
					});
					$('.icon-360').each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
				}
        	}*/
			
			if ($('#project-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							window.history.back();
						}
					});
					
					$(".sub-nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
					
					$(".view-details").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			if ($('#recruitment-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							window.history.back();
						}
					});
					
					$(".career-title a").each(function(index, element) {
						if ($(element).attr('href') == tmpurl) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			
			
			if ($('#news-details-page, #service-details-page').length) {
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						window.history.back();
					}
				});
				
				$(".link-page a").each(function(index, element) {
					if ($(element).attr('href') == tmpurl) {
						$(element).trigger('click');
					}
				});
			}
			
			
			
		  }

	  }else{
		  
		  if (e.originalEvent.state !== null) {
			  var tmp_url = e.originalEvent.state.path;
		  }else{
			  var tmp_url = document.URL;
		  }
		  
		  var temp_url_1 = tmp_url.replace(httpserver, ""); 
		  var tmp_1 = temp_url_1.split('/');
		  
		  if ($('#about-page, #library-page').length) {
			  
			  if($('.close-popup').length){
				  $('.close-popup').trigger('click');
			  }else{
				if($('.close-album').length){
					$('.close-album').trigger('click');
				}
				if($('.close-pics').length){
					$('.close-pics').trigger('click');
				}
				
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
				
				$(".item-document a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
			  }
			}
			
			/*if ($('#distribution-page').length) {
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				$(".sub-nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				$(".quick-box li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
				});
				
			}*/
			
			if ($('#product-page').length) {
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
                $(".preload-product li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						$(element).trigger('click');
					}
                });
        	}
			
			/*if ($('#showroom-page').length) {
				if($('.close-album').length){
					$('.close-album').trigger('click');
				}
				if($('.iframe-showroom').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					$('.icon-360').each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
        	}*/
			
			if ($('#project-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					
					$(".sub-nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
					
					$(".view-details").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			if ($('#recruitment-page').length) {
				if($('.close-popup').length){
					$('.close-popup').trigger('click');
				}else{
					$(".nav li a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							window.history.back();
						}
					});
					
					$(".career-list td a").each(function(index, element) {
						if ($(element).attr('href') == tmp_url) {
							$(element).trigger('click');
						}
					});
				}
				
			}
			
			
			
			if ($('#news-details-page, #service-details-page').length) {
				
				$(".nav li a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.history.back();
					}
				});
				
				
				
				$(".link-page a").each(function(index, element) {
					if ($(element).attr('href') == tmp_url) {
						window.location = tmp_url;
					}
				});
			}

			
			
			
		  
	  }
	  
});

if(iOS || isFirefox) {
	$(window).bind("pageshow", function(event) {
		if (event.originalEvent.persisted) {
			window.location.reload();
		}
	});
}


