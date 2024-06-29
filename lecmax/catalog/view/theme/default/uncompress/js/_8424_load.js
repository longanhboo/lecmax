var ua = navigator.userAgent;
var match = ua.match('MSIE (.)');
var versions = match && match.length > 1 ? match[1] : 'unknown';
var isTouchDevice =  "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch  || (navigator.msMaxTouchPoints>0) || (navigator.maxTouchPoints > 0);
var isDesktop = $(window).width() != 0 && !isTouchDevice ? true : false;
var IEMobile = ua.match(/IEMobile/i);
var isIE9 = /MSIE 9/i.test(ua); 
var isIE10 = /MSIE 10/i.test(ua);
var isIE11 = /rv:11.0/i.test(ua) && !IEMobile  ? true : false;
var isEge = /Edge\/12./i.test(navigator.userAgent)
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || ua.indexOf(' OPR/') >= 0;
var isFirefox = typeof InstallTrigger !== 'undefined';
var isIE = false || !!document.documentMode;
var isEdge = !isIE && !!window.StyleMedia && !isIE11;
var isChrome = !!window.chrome && !!window.chrome.webstore ;
var isBlink = (isChrome || isOpera) && !!window.CSS;
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || !isChrome && !isOpera && window.webkitAudioContext !== undefined;
var isSafari5 = ua.match('Safari/') && !ua.match('Chrome') && ua.match(' Version/5.');
// Check Android version 
var AndroidVersion = parseFloat(ua.slice(ua.indexOf("Android")+8)); 
var Version = ua.match(/Android\s([0-9\.]*)/i);
// Check iOS8 version 
var isIOS8 = function() {
  var deviceAgent = navigator.userAgent.toLowerCase();
  return /iphone os 8_/.test(deviceAgent);
}
// Check iOS version 
function iOSversion() {
    if (/iP(hone|od|ad)/.test(navigator.platform)) {
        var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
        return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
    }
}
var iOS = iOSversion();

var ios, android, blackBerry, UCBrowser, Operamini, firefox, windows, smartphone, tablet,touchscreen, all;
var isMobile = {
  ios: (function(){
    return ua.match(/iPhone|iPad|iPod/i);
  }()),
  android: (function(){
    return ua.match(/Android/i);
  }()),
  blackBerry: (function(){
    return ua.match(/BB10|Tablet|Mobile/i);
  }()),
  UCBrowser: (function(){
    return ua.match(/UCBrowser/i);
  }()),
  Operamini: (function(){
    return ua.match(/Opera Mini/i);
  }()),
  
  windows: (function(){
    return ua.match(/IEMobile/i);
  }()),
  smartphone: (function(){
	return (ua.match(/Android|BlackBerry|Tablet|Mobile|iPhone|iPad|iPod|Opera Mini|IEMobile/i) && window.innerWidth <= 440 && window.innerHeight <= 740);
  }()),
  tablet: (function(){
    return (ua.match(/Android|BlackBerry|Tablet|Mobile|iPhone|iPad|iPod|Opera Mini|IEMobile/i) && window.innerWidth <= 1366 && window.innerHeight <= 800);
  }()),

  all: (function(){
    return ua.match(/Android|BlackBerry|Tablet|Mobile|iPhone|iPad|iPod|Opera Mini|IEMobile/i);
  }())
};

function changeUrl(url, title, description, keyword, dataName, titleog, descriptionog) {
    if (window.history.pushState !== undefined) {
        var c_href = document.URL;
        if (c_href != url && url!='')
            window.history.pushState({path: url, dataName: dataName, title: title, keyword: keyword, description: description, titleog: titleog, descriptionog: descriptionog}, "", url);
    }
    if (title != '') {
        $('#hdtitle').html(title);
        $('meta[property="og:description"]').remove();
        $('#hdtitle').after('<meta property="og:description" content="' + descriptionog + '">');
        $('meta[property="og:title"]').remove();
        $('#hdtitle').after('<meta property="og:title" content="' + titleog + '">');
        $('meta[property="og:url"]').remove();
        $('#hdtitle').after('<meta property="og:url" content="' + url + '">');
        $('meta[name=keywords]').remove();
        $('#hdtitle').after('<meta name="keywords" content="' + keyword + '">');
        $('meta[name=description]').remove();
        $('#hdtitle').after('<meta name="description" content="' + description + '">');
    }
    $('#changlanguage_redirect').val(url);
}

if(isTouchDevice  && isMobile.all !== null){
	var TouchLenght = true;
}else if(isMobile.tablet && isFirefox || isMobile.smartphone && isFirefox ){
	var TouchLenght = true;
}else{
	var TouchLenght = false;
}
if(isMobile.Operamini){
	alert('Please disable Data Savings Mode');
}


/*if(TouchLenght == true){
alert('Me')
}
*/

var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
 
//EXAMPLE ANIMATION CSS
/*$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});
$('#yourElement').animateCss('bounce');
*/


var Loadx = 0;



function ResizeWindows() {
var Portrait = $(window).height() >= $(window).width();
var Landscape = $(window).height() < $(window).width();
var Xwidth = $(window).width();
var Yheight = $(window).height();
var RatioScreeen = Yheight / Xwidth; 
var RatioIMG = 1125 / 2000;
var RatioInner = 740 / 2000;
var RatioV = 1080 / 1920;
var RatioBanner = 2000/1125;

var percent1 = Xwidth/1900;
var percent2 = Xwidth/1600;
var percent3 = Xwidth/1700;
var percent4 = Xwidth/1500;

var HB = $('.slide-mask').innerHeight();

    
		       if(Xwidth <= 1100){
					$('.bg-inner, .bg-home').css({'-webkit-transform': 'translateY(0)', 'transform': 'translateY(0)'})
					$('.all-tab-content, .tab-content').css({'width': '100%'});
					$('.all-tab-content').height('auto')

				 }else if( Xwidth > 1100){
				 	var WidthDetail = $('.box-product-detail').width();
                    $('.tab-content').width(WidthDetail);
					$('.load-text img, .details-text img').removeClass('zoom-pic');
				 }
				 

}



function DrawLoad() {
	var Stroke = $('.load-present');
    var Paths = $(Stroke).find('path');

     $(Paths).each(function(index, element) {
		  var totalLength = this.getTotalLength();
		 if(isIE9 || isIE10 || isIE11 || isEdge){
			
               $(this).css({'stroke-dasharray': totalLength + ' ' + totalLength});
			    $(this).css({ 'stroke-dashoffset': totalLength, 'stroke-dasharray': totalLength + ' ' + totalLength});
			   $(this).stop().animate({'stroke-dashoffset': 0}, 1000, 'linear', function() {
				  $(this).stop().animate({'stroke-dashoffset': totalLength}, 1000, 'linear');
		       });
		   }
      });
	  
	 setTimeout(function(){ $('.loadicon').addClass('hide')}, 1100);
	 
}


function ScrollHoz() {
	var Scroll = $('.sub-nav, .scroll-slide, .content-table, .sub-nav, .info-facilities, .sub-news, .nav-filter');
	if($(window).width() <= 1100){
		
       $(Scroll).css({'overflow-x':'scroll','overflow-y':'hidden','-ms-touch-action': 'auto','-ms-overflow-style' :'none', 'overflow':' -moz-scrollbars-none'});
	   $(Scroll).animate({scrollLeft: "0px"});
	   if(TouchLenght == false  || !isTouchDevice){ 
		   if($(window).width() <= 1100){
			  $(Scroll).mousewheel(function(e, delta) {
				  e.preventDefault();
				 if ($(window).width() <= 1100) {
				   this.scrollLeft -= (delta * 40);
				 }
			   });
			  
			    $(Scroll).addClass('dragscroll');
				$('.dragscroll').draptouch();
		   }
	   }
	    
	}
	 
}



function Done() {
ResizeWindows();
SlidePicture();
ScrollHoz();

 
 $('.go-top').removeClass('show');


  $('.container').stop().animate({'opacity':1}, 600 ,'linear', function () {
	 $('html, body').animate({scrollTop:0}, 1);  
	 $('.load-bg').addClass('show'); 
     ContentLoad();
	
   });

	if($('#home-page').length){
		if($('.loadicon').length){
			$('.loadicon').fadeOut(500, function () {
				$('.loadicon').removeClass('loader');
				$('.loadicon').removeClass('show');
				$('.loadicon').removeClass('hide');
			});
		}
	}else{
		$('.loadx').fadeOut(400, 'linear', function() {
			 $('.loadx').remove();
		});
	}
  Loadpic()
}


function Loadpic(){
 $('.pic-img, .item-pic').each(function(index, element) {
 $(element).append('<div class="pic-bg"></div>')
 var IMG  = $(element).find('img').attr('src');
  if(IMG){
   var SRC = IMG.replace(/(^url\()|(\)$|[\"\'])/g, '');
   $(element).find('.pic-bg').css({'background-image': 'url(' + SRC + ')'});
 }
});

}




$(document).ready(function () {
  ResizeWindows();
 $('html, body').animate({scrollTop:0}, 1);
$(".title-page h1").lettering('words').children('span').lettering().children('span').lettering();

if($('#home-page').length){
	if(!$('.loadicon').hasClass('loader')){
	   $('.loadicon').show();  
	   $('.loadicon').addClass('loader');
	   setTimeout(function(){$('.loadicon').addClass('color');}, 1300);
	   DrawLoad();
	}
}else{
	if(!$('.loadx').length){
		$('body').append('<div class="loadx" style="display:block"></div>');
	}
}

 // if($('#home-page').length){
 //   	if(!$('.loadicon').hasClass('loader')){
 //       $('.loadicon').show();  
 //       $('.loadicon').addClass('loader');
 //       setTimeout(function(){$('.loadicon').addClass('color');}, 1300);
	//    DrawLoad();
 // 	}
	 
 // }else{
	// if(!$('.loadx').length){
	//        $('body').append('<div class="loadx" style="display:block"></div>');
	//     }
		 
 // }
  
 
 	
  if( isIE10 || isIE11){
	  $('body').addClass('is-IE');
   }else if(isEdge){	
	  $('body').addClass('is-Edge');
  }else if(iOS){
	  $('body').addClass('is-IOS');
   }else if(isSafari){
	  $('body').addClass('is-Safari');	  
  }else if(isChrome){
	  $('body').addClass('is-Chrome');
  }	
  

  if($(".outer-nav").length ){
	   function CloneSub() {
		  var Clone = $(".outer-nav").clone();
		  $(".container").prepend(Clone);
		  $(Clone).addClass('second');
	  }

    CloneSub();
   }

		
});



$(window).on('beforeunload', function(){
  $(window).scrollTop(0);
});

if($('.ani-item').length){
var el = document.querySelector('.ani-item:not(.thumb-pic)');
el.addEventListener('mouseenter', hintBrowser);
el.addEventListener('animationEnd', removeHint);

function hintBrowser() {
  this.style.willChange = 'transform, opacity';
}
function removeHint() {
  this.style.willChange = 'auto';
}

}

if($('.youtube-video').length){
	
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var youTubeUrl = $('.youtube-video').attr('data-embed');
    var youTubeId;
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = youTubeUrl.match(regExp);
    if (match && match[2].length == 11) {
        youTubeId = match[2];
    } else {
        youTubeId = 'no video found';
    }	
	
var youTube = $('.youtube-video');
var Source = "https://img.youtube.com/vi/"+  youTubeId +"/sddefault.jpg";
if(iOS){
var SRC = '<iframe id="VYT" src="https://www.youtube.com/embed/' + youTubeId + '?autoplay=1&enablejsapi=1&controls=1&loop=0&playsinline=1&color=white&rel=0&cc_load_policy=1&playlist='+ youTubeId +'" frameborder="0"  allow="autoplay" allowfullscreen></iframe>';
}else{
var SRC = '<iframe id="VYT" src="https://www.youtube.com/embed/' + youTubeId + '?autoplay=1&enablejsapi=1&controls=0&loop=0&playsinline=1&color=white&rel=0&cc_load_policy=1&playlist='+ youTubeId +'" frameborder="0"  allow="autoplay" allowfullscreen></iframe>';
}
$(youTube).append(SRC);
if($('.play-button').attr('data-image')!=''){
	BG = $('.play-button').attr('data-image');
}else{
	var BG = Source.replace(/(^url\()|(\)$|[\"\'])/g, '');
}
$(youTube).parent().append('<div class="bg-video" style="background-image:url(' + BG + ')"></div>');		


var player;
time_update = 0;

function onYouTubeIframeAPIReady() {
  player = new YT.Player('VYT', {
	events: {
	  'onReady': onPlayerReady,
	  'onStateChange': onPlayerStateChange
	}
  });
}


//TRACK
function cleanTime(){
    return Math.round(player.getCurrentTime())
};


function updateTimerDisplay(){
    $('#current-time').text(formatTime( player.getCurrentTime() ));
    $('#duration').text(formatTime( player.getDuration() ));
	
	var D =  $('#duration').text();
	var C =  $('#current-time').text();
	if(D == C){
		clearInterval(time_update);
		$('.bg-video').removeClass('hide');
		$('.slide-mask').trigger('next.btq.slidebox');
	}
	
}
function formatTime(time){
    time = Math.round(time);
    var minutes = Math.floor(time / 60),
        seconds = time - minutes * 60;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    return minutes + ":" + seconds;
}


$('#progress-bar').on('mouseup touchend', function (e) {
    var newTime = player.getDuration() * (e.target.value / 100);
    player.seekTo(newTime);
	if(!$('.bg-video').hasClass('hide')){
	$('.bg-video').addClass('hide');
	}

});
function updateProgressBar(){
    $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
}

$('#playpause').bind('click', function () {
	var Data = $(this).attr('data-state');
if(Data == "play"){
   player.playVideo();
   $(this).attr('data-state', 'pause');
   $('.bg-video').addClass('hide');
   $('.play-button').removeClass('show');
}else{
   player.pauseVideo();
   $(this).attr('data-state', 'play');
   $('.play-button').addClass('show');
  
}
    
});



$('#mutetoggle').bind('click', function() {
   var Data = $(this).attr('data-state');
    if(Data == "unmute"){
        player.unMute();
		 $(this).attr('data-state', 'mute');
    } else{
        player.mute();
       $(this).attr('data-state', 'unmute');
    }
});

$('#fullscreen').bind('click', function ()  {

	 var Data = $(this).attr('data-state');
	  if(Data == "go-fullscreen"){
		 
		  $(this).attr('data-state', 'cancel-fullscreen');
		  $('.video-youtube-full').addClass('full-frame');
	     if(!iOS){
		   screenfull.request($('.video-youtube-full')[0]);
		  }
		   
	  }else{
		   $(this).attr('data-state', 'go-fullscreen');
		   $('.video-youtube-full').removeClass('full-frame');  
		 if(!iOS){
			screenfull.exit();
		  }  
		   
      }
 
});
 


$('.play-button').on('click', function (e) {
	e.preventDefault();
	player.playVideo();
	$(this).removeClass('show');
	$('#playpause').attr('data-state', 'pause');
    $('.bg-video').addClass('hide');
    
 });
 
 $('.pause-button').on('click', function (e) {
	e.preventDefault();
	player.pauseVideo();
	$('.play-button').addClass('show');
	$('#playpause').attr('data-state', 'play');
	 
    
 });
 
  $('.youtube-video').on( 'click',function(e) {
	e.preventDefault();
	$('#playpause').trigger('click');
 });



function onPlayerReady(event) {
//if(TouchLenght == true  || isTouchDevice){
	event.target.mute();
	$('#mutetoggle').attr('data-state', 'unmute');
//}
   
   $('.pause-button').trigger('click');
    
    updateTimerDisplay();
    updateProgressBar();
    clearInterval(time_update);
    time_update = setInterval(function () {
        updateTimerDisplay();
        updateProgressBar();
    }, 500);
	
}


function onPlayerStateChange(event) {
    switch (event.data) {
        case YT.PlayerState.PLAYING:
			$('.play-button').removeClass('show');
			$('#playpause').attr('data-state', 'pause');
            break;
        case YT.PlayerState.PAUSED:
			$('.play-button').addClass('show');
			$('#playpause').attr('data-state', 'play');
            break;
         case YT.PlayerState.ENDED:
            break;
    };
	

};

   
}

/*GOOGLE MAP*/

var agenMarker = []; 
var agenShowInfo = []; 
var Local = [];

if ($(".json-map").length > 0) {
	Local = JSON.parse($(".json-map").text());
}
/*var Local = [
        {id:'agen_01',
        lat:20.977107, 
        lng:105.783476,
        html:'<h3>Hà Nội</h3><p><strong>A</strong> T28, Tòa nhà Ellipse, 110 Trần Phú, Hà Đông<br><strong>T</strong> 84 24 7301 2678<br><strong>F</strong> 84 24 3354 5267</p>'
		},
		{id:'agen_02',
        lat:10.834730, 
        lng:106.761534,
        html:'<h3>Hồ Chí Minh</h3><p><strong>A</strong> 25, đường số 3, khu phố 6, P. Trường Thọ, Thủ Đức<br><strong>T</strong>: 84 28 38941 836 84  <br><strong>F</strong> 28 38941 845</p>'
		},
		{id:'agen_03',
        lat:20.528998, 
        lng:105.901500,
        html:'<h3>Nhà máy</h3><p><strong>A</strong> Lô D, KCN Châu Sơn, Tp. Phủ Lý, tỉnh Hà Nam<br><strong>T</strong> 84 226 6284 485<br><strong>F</strong> 84 226 6284 487</p>'
		},
		{id:'agen_04',
        lat:16.031919, 
        lng:108.214119,
        html:'<h3>Đà Nẵng</h3><p><strong>A</strong>Tòa nhà MEICO số 224 Xô Viết Nghệ Tĩnh, Phường Khuê Trung, Quận Cẩm Lệ<br><strong>T</strong> 02363 697 234<br><strong>F</strong> 02363 621 544</p>'
		},
]*/
function initialize() {
	var httpserver = $('.httpserver').text();
	var httptemplate = $('.httptemplate').text();
	var URL = $('.sub-nav li.current a').attr('data-name');
	
	var agenLocations = Local;
	var Center = new google.maps.LatLng(16.0319026, 108.2119319);
	var Zoom = 6;
	var marker;
	var markers = [];

	  var styles = [
			{
			  stylers: [
				 // { hue: "#929292"},
				  { saturation: -30 }
			  ]
			},{
			  featureType: "road",
			  elementType: "geometry",
			  stylers: [
				 { lightness:-5},
				 { visibility: "simplified" }
			  ]
			},{
			  featureType: "road",
			  elementType: "labels",
			  stylers: [
				{ visibility: "on" }
			  ]
			}
	  ];
	  
	  var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
	  
	
	
     var mapOptions = {
		center: Center,
		zoom:6,
		disableDefaultUI: true,
	    clickableIcons: false,
		scrollwheel: false,
		fullscreenControl: true,
	    gestureHandling: 'cooperative',
		mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'],
			position: google.maps.ControlPosition.TOP_RIGHT
		}
	};
	
	
	google.maps.event.addDomListener(window, "resize", function() {
		google.maps.event.trigger(map, "resize")
		map.setCenter(Center);
		map.setZoom(Zoom);
	});
        
	var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
	map.mapTypes.set('map_style', styledMap);
	map.setMapTypeId('map_style');
	
	var styledMapOptions = { name: "LecMax" };
    var logo = httptemplate + 'default/images/marker2.svg';
	
	
   
     for (var i = 0; i < agenLocations.length; ++i) {
         var Id = agenLocations[i].id;
         var Lat = agenLocations[i].lat;
         var Lng = agenLocations[i].lng;
         var Html = agenLocations[i].html;
         var Index = i;
		 var showInfo = new google.maps.InfoWindow();
		 var infobox = "<div class='infobox'><div class='infobox-inner'>"+ Html +"</div><span class='close-box-map'></span></div>";
	
         agenMarker[Index] = new google.maps.Marker({
              position: {
                lat: Lat,
                lng: Lng
              },
              icon: logo,
              map: map,
			  info: infobox,
			  draggable:false,
			  animation: google.maps.Animation.DROP,
		});
		
		    agenMarker[Index].id = Id;
			agenInfo(map,agenMarker[i],Index,Id,Html); 

			

		
	    }
		  
	
	function agenInfo(map,marker,Index,Id,Html) {
			
		      google.maps.event.addListener(marker, 'click', function(){
			    showInfo.setContent(this.info);
				showInfo.open(map, this);
				map.setZoom(11);
		        map.setCenter(marker.getPosition());
				closeInfobox(map);
				for (var i = 0; i < agenMarker.length; ++i) {
					agenMarker[i].setAnimation(null);
				}
				marker.setAnimation(google.maps.Animation.BOUNCE);

			});

			 
		
	      function closeInfobox(map) {
		  $('#map-canvas').on('click', '.close-box-map', function(){
				showInfo.close(map, this);
				marker.setAnimation(null);
				map.setZoom(6);
		   });
	     }
			
	}
	

	   function setMapAll(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
         }
      }
	
	   function clearMarkers() {
        setMapAll(null);
      }

      function showMarkers() {
        setMapAll(map);
      }

      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

	
    if (screenfull.enabled) {
	  screenfull.on('change', function(){
		if(screenfull.isFullscreen){
			 $('.map-box, .map-view').addClass('full-screen');
			   map.setOptions({scrollwheel:true});
		}else{
			 $('.map-box, .map-view').removeClass('full-screen'); 
			  map.setOptions({scrollwheel:false});
			  map.setCenter(Center);
		}
	 });
   }  
	 
	ZoomControl(map);
}



function ZoomControl(map) {
  $('.zoom-control a').on('click', function ()  {
   var zoom = map.getZoom();
  switch ($(this).attr("id")) {
  case "zoom-in":
    map.setZoom(++zoom);
    break;
  case "zoom-out":
    map.setZoom(--zoom);
    break;
  default:
    break
  }
  return false
  
 });
 
 
}

