<!doctype html>
<html ⚡="" lang="<?php echo $lang1;?>">
<head>
<meta charset="utf-8">
<title><?php echo !empty($ampcd['meta_title'])?$ampcd['meta_title']:$ampcd['name1'];?></title>
<meta name="description" content="<?php echo $ampcd['meta_description']; ?>">
<meta name="keywords" content="<?php echo $ampcd['meta_keyword']; ?>">
<link rel="canonical" href="<?php echo $ampcd['href']; ?>">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<script async src="https://cdn.ampproject.org/v0.js"></script>

<style amp-boilerplate="">body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate="">body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

<script custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js" async></script>
<script custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js" async></script>
<script custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js" async></script>
<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>

<script type="application/ld+json">{"@context": "http://schema.org","@type": "Organization",  "url": "<?php echo HTTP_SERVER;?>","name": "CASA BELLA","logo": ["<?php echo PATH_TEMPLATE;?>default/images/social-share.png"], "contactPoint": {"@type": "ContactPoint",  "telephone": "+84-28-6262-2950","contactType": "Customer service"}}</script>


<!--<link href="<?php echo PATH_TEMPLATE;?>default/css/style_amp.css" rel="stylesheet" type="text/css">-->

<style amp-custom="">

* { box-sizing: border-box }
html { font-family: sans-serif;  font-size:16px;line-height: 1.15; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
body { background-color:#fff;margin:0;color: #4a4a4a; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, Arial, sans-serif; min-width: 315px; overflow-x: hidden; font-smooth: always; -webkit-font-smoothing: antialiased;line-height: 1.6}
main { max-width: 700px; margin: 0 auto }
p {padding:0; margin: 0 }
.display-none { display: none }
article, aside, footer, header, nav, section { display: block }
figcaption, figure, main { display: block }
figure { margin: 1em 40px }
hr { box-sizing: content-box; height: 0; overflow: visible }
pre { font-family: monospace, monospace; font-size: 1em }
a { background-color: transparent; -webkit-text-decoration-skip: objects }
a:active, a:hover { outline-width: 0 }
abbr[title] { border-bottom: none; text-decoration: underline; text-decoration: underline dotted }
b, strong { font-weight: inherit; font-weight: bolder }
code, kbd, samp { font-family: monospace, monospace; font-size: 1em }
dfn { font-style: italic }
mark { background-color: #ff0; color: #000 }
small { font-size: 80% }
sub, sup { font-size: 75%; line-height: 0; position: relative; vertical-align: baseline }
sub { bottom: -.25em }
sup { top: -.5em }
audio, video { display: inline-block }
audio:not([controls]) { display: none; height: 0 }
img { border-style: none }
svg:not(:root) { overflow: hidden }
button, input, optgroup, select, textarea { font-family: sans-serif; font-size: 100%; line-height: 1.15; margin: 0 }
button, input { overflow: visible }
button, select { text-transform: none }
[type=reset], [type=submit], button, html [type=button] {-webkit-appearance:button}
[type=button]::-moz-focus-inner, [type=reset]::-moz-focus-inner, [type=submit]::-moz-focus-inner, button::-moz-focus-inner {border-style:none;padding:0}
[type=button]:-moz-focusring, [type=reset]:-moz-focusring, [type=submit]:-moz-focusring, button:-moz-focusring {outline:1px dotted ButtonText}
fieldset { border: 1px solid silver; margin: 0 2px; padding: .35em .625em .75em }
legend { box-sizing: border-box; color: inherit; display: table; max-width: 100%; padding: 0; white-space: normal }
progress { display: inline-block; vertical-align: baseline }
textarea { overflow: auto }
[type=checkbox], [type=radio] {box-sizing:border-box;padding:0}
[type=number]::-webkit-inner-spin-button, [type=number]::-webkit-outer-spin-button {height:auto}
[type=search] {-webkit-appearance:textfield;outline-offset:-2px}
[type=search]::-webkit-search-cancel-button, [type=search]::-webkit-search-decoration {-webkit-appearance:none}
::-webkit-file-upload-button {-webkit-appearance:button;font:inherit}
details, menu { display: block }
summary { display: list-item }
canvas { display: inline-block }
[hidden], template {display:none}
.h1, h1 { font-size: 3rem; line-height: 3.5rem }
.h2, h2 { font-size: 2rem; line-height: 2.5rem }
.h3, h3 { font-size: 1.5rem; line-height: 2rem }
.h4, h4 { font-size: 1.125rem; line-height: 1.5rem }
.h5, h5 {font-size:.875rem; line-height: 1.125rem }
.h6, h6 {font-size:.75rem; line-height: 1rem }
h1, h2, h3, h4, h5, h6 { margin: 0; padding: 0; font-weight: 400;}
a, a:active, a:visited { color: inherit }
.font-family-inherit { font-family: inherit }
.font-size-inherit { font-size: inherit }
.text-decoration-none { text-decoration: none }
.bold { font-weight: 900; letter-spacing: -1px }
.regular { font-weight: 400 ;}
.italic { font-style: italic }
.caps { text-transform: uppercase; letter-spacing: .2em }
.uppercase {text-transform: uppercase;}
.left-align { text-align: left }
.center { text-align: center }
.right-align { text-align: right }
.justify { text-align: justify }
.nowrap { white-space: nowrap }
.break-word { word-wrap: break-word }
.line-height-1 { line-height: 1rem }
.line-height-2 { line-height: 1.125rem }
.line-height-3 { line-height: 1.5rem }
.line-height-4 { line-height: 2rem }
.list-style-none { list-style: none }
.underline { text-decoration: underline }
.truncate { max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap }
.list-reset { list-style: none; padding-left: 0 }
.inline { display: inline }
.block { display: block }
.inline-block { display: inline-block }
.table { display: table }
.table-cell { display: table-cell }
.overflow-hidden { overflow: hidden }
.overflow-scroll { overflow: scroll }
.overflow-auto { overflow: auto }
.clearfix:after, .clearfix:before { content: " "; display: table }
.clearfix:after { clear: both }
.left { float: left }
.right { float: right }
.fit { max-width: 100vw }
.max-width-1 { max-width: 24rem }
.max-width-2 { max-width: 32rem }
.max-width-3 { max-width: 48rem }
.max-width-4 { max-width: 64rem }
.border-box { box-sizing: border-box }
.align-baseline { vertical-align: baseline }
.align-top { vertical-align: top }
.align-middle { vertical-align: middle }
.align-bottom { vertical-align: bottom }
.m0 { margin: 0 }
.mt0 { margin-top: 0 }
.mr0 { margin-right: 0 }
.mb0 { margin-bottom: 0 }
.ml0, .mx0 { margin-left: 0 }
.mx0 { margin-right: 0 }
.my0 { margin-top: 0; margin-bottom: 0 }
.m1 { margin:.5rem}
.mt1 { margin-top:.5rem}
.mr1 { margin-right:.5rem}
.mb1 { margin-bottom:.5rem}
.ml1, .mx1 { margin-left:.5rem}
.mx1 { margin-right:.5rem}
.my1 { margin-top:.5rem;margin-bottom:.5rem}
.m2 { margin: 1rem }
.mt2 { margin-top: 1rem }
.mr2 { margin-right: 1rem }
.mb2 { margin-bottom: 1rem }
.ml2, .mx2 { margin-left: 1rem }
.mx2 { margin-right: 1rem }
.my2 { margin-top: 1rem; margin-bottom: 1rem }
.m3 { margin: 1.5rem }
.mt3 { margin-top: 1.5rem }
.mr3 { margin-right: 1.5rem }
.mb3 { margin-bottom: 1.5rem }
.ml3, .mx3 { margin-left: 1.5rem }
.mx3 { margin-right: 1.5rem }
.my3 { margin-top: 1.5rem; margin-bottom: 1.5rem }
.m4 { margin: 2rem }
.mt4 { margin-top: 2rem }
.mr4 { margin-right: 2rem }
.mb4 { margin-bottom: 2rem }
.ml4, .mx4 { margin-left: 2rem }
.mx4 { margin-right: 2rem }
.my4 { margin-top: 2rem; margin-bottom: 2rem }
.mxn1 { margin-left:-.5rem;margin-right:-.5rem}
.mxn2 { margin-left: -1rem; margin-right: -1rem }
.mxn3 { margin-left: -1.5rem; margin-right: -1.5rem }
.mxn4 { margin-left: -2rem; margin-right: -2rem }
.ml-auto { margin-left: auto }
.mr-auto, .mx-auto { margin-right: auto }
.mx-auto { margin-left: auto }
.p0 { padding: 0 }
.pt0 { padding-top: 0 }
.pr0 { padding-right: 0 }
.pb0 { padding-bottom: 0 }
.pl0, .px0 { padding-left: 0 }
.px0 { padding-right: 0 }
.py0 { padding-top: 0; padding-bottom: 0 }
.p1 { padding:.5rem}
.pt1 { padding-top:.5rem}
.pr1 { padding-right:.5rem}
.pb1 { padding-bottom:.5rem}
.pl1 { padding-left:.5rem}
.py1 { padding-top:.5rem;padding-bottom:.5rem}
.px1 { padding-left:.5rem;padding-right:.5rem}
.p2 { padding: 1rem }
.pt2 { padding-top: 1rem }
.pr2 { padding-right: 1rem }
.pb2 { padding-bottom: 1rem }
.pl2 { padding-left: 1rem }
.py2 { padding-top: 1rem; padding-bottom: 1rem }
.px2 { padding-left: 1rem; padding-right: 1rem }
.p3 { padding: 1.5rem }
.pt3 { padding-top: 1.5rem }
.pr3 { padding-right: 1.5rem }
.pb3 { padding-bottom: 1.5rem }
.pl3 { padding-left: 1.5rem }
.py3 { padding-top: 1.5rem; padding-bottom: 1.5rem }
.px3 { padding-left: 1.5rem; padding-right: 1.5rem }
.p4 { padding: 2rem }
.pt4 { padding-top: 2rem }
.pr4 { padding-right: 2rem }
.pb4 { padding-bottom: 2rem }
.pl4 { padding-left: 2rem }
.py4 { padding-top: 2rem; padding-bottom: 2rem }
.px4 { padding-left: 2rem; padding-right: 2rem }
.col { float: left }
.col, .col-right { box-sizing: border-box }
.col-right { float: right }
.col-1 { width: 8.33333% }
.col-2 { width: 16.66667% }
.col-3 { width: 25% }
.col-4 { width: 33.33333% }
.col-5 { width: 41.66667% }
.col-6 { width: 50% }
.col-7 { width: 58.33333% }
.col-8 { width: 66.66667% }
.col-9 { width: 75% }
.col-10 { width: 83.33333% }
.col-11 { width: 91.66667% }
.col-12 { width: 100% }

.flex { display: -webkit-box; display: -ms-flexbox; display: flex }
.flex-column { -webkit-box-orient: vertical; -webkit-box-direction: normal; -ms-flex-direction: column; flex-direction: column }
.flex-wrap { -ms-flex-wrap: wrap; flex-wrap: wrap }
.items-start { -webkit-box-align: start; -ms-flex-align: start; align-items: flex-start }
.items-end { -webkit-box-align: end; -ms-flex-align: end; align-items: flex-end }
.items-center { -webkit-box-align: center; -ms-flex-align: center; align-items: center }
.items-baseline { -webkit-box-align: baseline; -ms-flex-align: baseline; align-items: baseline }
.items-stretch { -webkit-box-align: stretch; -ms-flex-align: stretch; align-items: stretch }
.self-start { -ms-flex-item-align: start; align-self: flex-start }
.self-end { -ms-flex-item-align: end; align-self: flex-end }
.self-center { -ms-flex-item-align: center; -ms-grid-row-align: center; align-self: center }
.self-baseline { -ms-flex-item-align: baseline; align-self: baseline }
.self-stretch { -ms-flex-item-align: stretch; -ms-grid-row-align: stretch; align-self: stretch }
.justify-start { -webkit-box-pack: start; -ms-flex-pack: start; justify-content: flex-start }
.justify-end { -webkit-box-pack: end; -ms-flex-pack: end; justify-content: flex-end }
.justify-center { -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center }
.justify-between { -webkit-box-pack: justify; -ms-flex-pack: justify; justify-content: space-between }
.justify-around { -ms-flex-pack: distribute; justify-content: space-around }
.content-start { -ms-flex-line-pack: start; align-content: flex-start }
.content-end { -ms-flex-line-pack: end; align-content: flex-end }
.content-center { -ms-flex-line-pack: center; align-content: center }
.content-between { -ms-flex-line-pack: justify; align-content: space-between }
.content-around { -ms-flex-line-pack: distribute; align-content: space-around }
.content-stretch { -ms-flex-line-pack: stretch; align-content: stretch }
.flex-auto { -webkit-box-flex: 1; -ms-flex: 1 1 auto; flex: 1 1 auto; min-width: 0; min-height: 0 }
.flex-none { -webkit-box-flex: 0; -ms-flex: none; flex: none }
.order-0 { -webkit-box-ordinal-group: 1; -ms-flex-order: 0; order: 0 }
.order-1 { -webkit-box-ordinal-group: 2; -ms-flex-order: 1; order: 1 }
.order-2 { -webkit-box-ordinal-group: 3; -ms-flex-order: 2; order: 2 }
.order-3 { -webkit-box-ordinal-group: 4; -ms-flex-order: 3; order: 3 }
.order-last { -webkit-box-ordinal-group: 100000; -ms-flex-order: 99999; order: 99999 }
.relative { position: relative }
.absolute { position: absolute }
.fixed { position: fixed }
.top-0 { top: 0 }
.right-0 { right: 0 }
.bottom-0 { bottom: 0 }
.left-0 { left: 0 }
.z1 { z-index: 1 }
.z2 { z-index: 2 }
.z3 { z-index: 3 }
.z4 { z-index: 4 }
.border { border-style: solid; border-width: 1px }
.border-top { border-top-style: solid; border-top-width: 1px }
.border-right { border-right-style: solid; border-right-width: 1px }
.border-bottom { border-bottom-style: solid; border-bottom-width: 1px }
.border-left { border-left-style: solid; border-left-width: 1px }
.border-none { border: 0 }
.rounded { border-radius: 3px }
.circle { border-radius: 50% }
.rounded-top { border-radius: 3px 3px 0 0 }
.rounded-right { border-radius: 0 3px 3px 0 }
.rounded-bottom { border-radius: 0 0 3px 3px }
.rounded-left { border-radius: 3px 0 0 3px }
.not-rounded { border-radius: 0 }
.hide { position: absolute; height: 1px; width: 1px; overflow: hidden; clip: rect(1px,1px,1px,1px) }
figure { margin: 0 }
.title-page { font-weight: 900; line-height: 1; width: 100%; height:auto; padding:0 5%; font-size:3rem; pointer-events: none; color:#fff; text-align:center; z-index:10  }

/*AMP SLIDEBAR*/
.ampstart-headerbar { width:100%;height:70px; background-color:#fff; color:#000;  box-shadow: 0 0 20px rgba(0,0,0,0.2) ; z-index:50; }
.ampstart-sidebar-header {height:70px }
.ampstart-headerbar-text {font-size:1rem; line-height:68px; color:#000;left:75px; top:0;}
.ampstart-sidebar { width: 320px; padding-top:0;padding-right:0; box-sizing: content-box }
.ampstart-nav-link { display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-line-pack: center; align-content: center; -webkit-box-align: center; -ms-flex-align: center; align-items: center }
.ampstart-sidebar-nav {  display: -webkit-box; display: -ms-flexbox; display: flex;-webkit-box-orient: vertical; -webkit-box-direction: normal; -ms-flex-direction: column; flex-direction: column; background-color: #fff }
.ampstart-nav-link { display: -webkit-box; display: -ms-flexbox; display: flex;-webkit-box-flex: 0; -ms-flex: none; flex: none; -webkit-box-align: center; -ms-flex-align: center; align-items: center; font-size: 1.5rem; font-weight: 100; text-transform: none; -webkit-font-smoothing: antialiased; line-height: 1.2; text-decoration: none;white-space: nowrap; position: relative;-webkit-tap-highlight-color: rgba(0,0,0,0); text-decoration: none; padding:1.5rem 0 1.5rem 2.5rem; border-bottom: 1px solid rgba(0,0,0,.1) }
.ampstart-nav-link:after { content: ""; position: absolute; top: 0; left: 0; bottom: 0; right: 0; -webkit-transform: scaleX(0) translateZ(0); transform: scaleX(0) translateZ(0); -webkit-transform-origin: left center; transform-origin: left center; -webkit-transition: -webkit-transform .24s ease-in-out; transition: -webkit-transform .24s ease-in-out; transition: transform .24s ease-in-out; transition: transform .24s ease-in-out, -webkit-transform .24s ease-in-out }
.ampstart-nav-link:hover::after { display: block; content: ""; -webkit-transform: scaleX(1) translateZ(0); transform: scaleX(1) translateZ(0) }
.ampstart-nav-item { margin-left: -2.5rem }
.ampstart-nav-item:nth-child(2) .ampstart-nav-link {border-top: 1px solid rgba(0,0,0,.1);border-bottom: 1px solid rgba(0,0,0,.1)}
.ampstart-nav-item .ampstart-nav-link::after { background-color:#00b2ff; top: -1px; bottom: -1px }
.ampstart-nav-item .ampstart-sidebar-nav-item-image {background-color: #00b2ff }
.ampstart-navbar-trigger { -webkit-box-flex: 0; -ms-flex: none; flex: none; cursor: pointer; line-height:1; height:50px; width:50px;  }
.ampstart-navbar-trigger:active, .ampstart-navbar-trigger:focus {outline:none;}
.ampstart-navbar-trigger[aria-label="close sidebar"]{ margin:0  0 0 1.5rem;}
.ampstart-sidebar-nav-logo {width:100%; top:8px; left:0;  font-size:0; line-height:0; text-indent:-9999px; color:#00b2ff; pointer-events:none}
.ampstart-sidebar-nav-logo svg{width:160px; height:55px; display:block; margin:0 auto;}
.ampstart-sidebar-nav-item-image { -webkit-box-flex: 0; -ms-flex: none; flex: none; width:40px; height:40px; margin: -1rem 0; border-radius: 50%; z-index: 1; -webkit-transition: box-shadow .1s, -webkit-transform .1s; transition: box-shadow .1s, -webkit-transform .1s; transition: transform .1s, box-shadow .1s; transition: transform .1s, box-shadow .1s, -webkit-transform .1s; box-shadow: 0 0 0 rgba(6,7,22,.2) }
.ampstart-sidebar-nav-item-image, .ampstart-sidebar-nav-item-image img { -o-object-fit: cover; object-fit: cover }
.ampstart-sidebar-nav-item-icon { -webkit-box-flex: 0; -ms-flex: none; flex: none; width: 1rem; height: 1rem; margin:0 1rem;color:#333; z-index: 1  }
.ampstart-sidebar-nav-item-icon svg{ stroke-width: 2; display:block; width: 1rem; height: 1rem;}
.ampstart-sidebar-nav-item-text { -webkit-box-flex: 1; -ms-flex: auto; flex: auto; margin:0 1rem; color:#000;-webkit-font-smoothing: antialiased;z-index: 1}
.ampstart-sidebar[side] { background: #fff; -webkit-transition: box-shadow .3s, -webkit-transform .3s cubic-bezier(0, 0, .21, 1); transition: box-shadow .3s, -webkit-transform .3s cubic-bezier(0, 0, .21, 1); transition: transform .3s cubic-bezier(0, 0, .21, 1), box-shadow .3s; transition: transform .3s cubic-bezier(0, 0, .21, 1), box-shadow .3s, -webkit-transform .3s cubic-bezier(0, 0, .21, 1) }
.ampstart-sidebar[open] { box-shadow: 0 0 2rem rgba(6,7,22,.15) }

/*BANNER*/
.ampstart-image-banner{width:100%; height:auto;}
.ampstart-image-banner header{padding:3rem}
.ampstart-image-banner footer{position:absolute;left:0;right:0;bottom:-7rem; z-index:6}
.ampstart-image-banner::after{content:"";position:absolute;left:-10px;width:calc(50% + 20px); height:9rem;bottom:-4.5rem;-webkit-transform:skewY(8deg); transform:skewY(8deg); background-color:#fff; z-index:1}
.ampstart-image-banner::before{content:"";position:absolute;right:-10px;width:calc(50% + 20px); height:9rem;bottom:-4.5rem;-webkit-transform:skewY(-8deg); transform:skewY(-8deg); background-color:#fff;z-index:1}
.ampstart-image-banner > amp-img {height:calc(900/1920 * 100vw); max-height:860px}
.ampstart-image-banner > amp-img img{-o-object-fit:cover;object-fit:cover}
.ampstart-image-banner > figcaption{left:0;bottom:0;right:0;margin:1.5rem;color:#fff}
.ampstart-readmore{background:none;display:block;margin:2rem 0;padding:2rem 0 }
.ampstart-readmore:after{content:" ";border:2px solid #ddd;border-width:0 1px 1px 0;bottom:1rem;display:block;height:30px;left:calc(50% - 15px);position:absolute;-webkit-transform:rotate(45deg);transform:rotate(45deg);width:30px}
.line-worker{width:100vw; height:calc(900/1920 * 100vw); max-height:800px; display:block; left:0; top:0; pointer-events:none; padding:8% 10% 12% 0;  z-index:3 }
.line-worker:not(.transform){-webkit-transform:perspective(650px) rotateY(-20deg) rotateZ(0deg) rotateX(10deg) skewY(12deg) skewX(-8deg) ; transform:perspective(650px) rotateY(-20deg) rotateZ(0deg) rotateX(10deg) skewY(12deg) skewX(-8deg) ; }
.line-worker.transform{-webkit-transform:perspective(800px) rotateY(18deg) rotateZ(8deg) rotateX(8deg) skewY(-14deg) skewX(29deg);  transform:perspective(800px) rotateY(18deg) rotateZ(8deg) rotateX(8deg) skewY(-14deg) skewX(29deg);padding: 8% 30% 12% 35%;}

.line-worker.no-transform{-webkit-transform:none; transform:none ; padding: 8% 3% 12% 56%;}

.line-worker svg{width:100%; height:100%; position:relative; display:inline-block; max-width:800px; max-height:550px; margin:0 -5px}
.stroke-number{fill:none; stroke:#fff;stroke-miterlimit:10;stroke-width:1;stroke-dasharray:800; stroke-dashoffset:800;-webkit-animation-delay: 1200ms;animation-delay: 1200ms; -webkit-animation-name: DrawStroke;  animation-name:DrawStroke;  -webkit-animation-duration: 3000ms;  animation-duration: 3000ms;  -webkit-animation-fill-mode:forwards;  animation-fill-mode:forwards; -webkit-animation-iteration-count:1;animation-iteration-count:1;-webkit-animation-direction: normal; animation-direction: normal;-webkit-animation-timing-function: linear;  animation-timing-function: linear;}



/*GALLERY*/
.gallery-landing-wall-scroll { width:100%; height: auto; margin: 10px auto 5rem auto; }
.gallery-landing-image-wrapped { width: 45vw; max-width:580px; height:auto; position:relative; display:inline-block; vertical-align:top; margin:5px 2px;-webkit-tap-highlight-color: rgba(0,0,0,0) }
.gallery-landing-image-wrapped amp-img { -o-object-fit: cover; object-fit: cover; box-shadow: 1vh 6vh 5vh rgba(6,7,22,.15); pointer-events: none;background-color: #00b2ff }
.gallery-landing-image-transform { width: 100%; height: 100%; -webkit-transition: all .3s ease-in-out; transition: all .3s ease-in-out; overflow:hidden;z-index:-1 }
.gallery-landing-image-caption { position: absolute; top:0; left:0;  color: #fff;padding: .7em 1.2em;   background-color:#003768 ;  -webkit-transition: all .2s ease-in-out; transition: all .2s ease-in-out; z-index:2; }
.gallery-landing-image-caption::after { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%;background-color:#00b2ff ; -webkit-transform: scaleX(0) rotateX(1turn); transform: scaleX(0) rotateX(1turn); -webkit-transform-origin: top left; transform-origin: top left;z-index: -1 }
.gallery-landing-caption-link { color: #fff; font-weight: 300;  text-decoration: none; font-size:1rem; line-height: 1.2; margin: 0 0 .25em 0;  }
.gallery-landing-image-wrapped:hover .gallery-landing-image-caption {left:10px; top:10px;box-shadow:1rem 1rem 2rem rgba(0,0,0,.3);}
.gallery-landing-image-wrapped:hover .gallery-landing-image-caption:after {-webkit-animation-name:goLeft; animation-name:goLeft; -webkit-animation-duration: .5s; animation-duration: .5s; -webkit-animation-timing-function: ease-in-out; animation-timing-function: ease-in-out }
.gallery-landing-image-wrapped:hover .gallery-landing-image-transform { padding:10px ;} 
.gallery-landing-image-wrapped:hover .gallery-landing-image-transform img{ border:10px solid #4dc1ff;-webkit-transform: translateZ(0); transform: translateZ(0); -webkit-transform-origin:50% 50%; transform-origin: 50% 50%; -webkit-animation-name: Ani; animation-name: Ani; -webkit-animation-duration: 10s; animation-duration: 10s; -webkit-animation-iteration-count: infinite; animation-iteration-count: infinite; -webkit-animation-timing-function: ease-in-out; animation-timing-function: ease-in-out; -webkit-animation-fill-mode: both; animation-fill-mode: both;} 
.gallery-landing-image-link { position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 2 }


/*CONTENT*/
.content-post{width:100%; max-width:1200px;padding:3rem 0 0 0;margin:70px auto 2rem auto;  z-index:5}
.content-post h1{ color:#00b2ff}
.content-post h2{ font-weight:900; margin:1rem 0; font-size:5rem; line-height:1; color:#eee; z-index:5 }
.content-post h2::before{content:"";position:absolute;left:calc(50% - 1px);width:2px; height:3rem;top:-4rem; background-color:#eee; z-index:1}
.post-text{ width:100%; height:auto;}
.post-text::after{content:"";position:absolute;left:-10px;width:calc(50% + 20px); height:3rem;top:-1rem;-webkit-transform:skewY(-3deg); transform:skewY(-3deg); background-color:#fff; z-index:1}
.post-text::before{content:"";position:absolute;right:-10px;width:calc(50% + 20px); height:3rem;top:-1rem;-webkit-transform:skewY(3deg); transform:skewY(3deg); background-color:#fff;z-index:1}
.post-text p, .post-text a{line-height:1.6;margin-bottom:1rem;font-size:1.4rem; font-weight:300;}
.post-text a{padding:0 .5rem}
.post-text p strong{ font-weight:500}
.post-text amp-img{margin-bottom:1rem;max-width:100%}
.post-text h3 {margin:1rem 0;line-height:1.2;font-size:2rem;  font-weight:700; z-index:5}
.ampstart-article-summary::after{content:"";position:absolute;left:-1px;width:calc(50% + 2px); height:3rem;bottom:-1.5rem;-webkit-transform:skewY(3deg); transform:skewY(3deg); background-color:#fff; z-index:1}
.ampstart-article-summary::before{content:"";position:absolute;right:-1px;width:calc(50% + 2px); height:3rem;bottom:-1.5rem;-webkit-transform:skewY(-3deg); transform:skewY(-3deg); background-color:#fff;z-index:1}
.ampstart-article-summary {  padding:5rem 5%; background-color:#ffeac1;  color:#4a4a4a}
.ampstart-article-summary:nth-child(odd) {background-color:#0094ca;color:#fff;}

.post-text ul{width:100%; height:auto; position:relative; display:block; margin:0;padding:0;}
.post-text li{ width:100%; height:auto; position:relative; display:block;margin:0 0 1rem 0;}
.post-text li p{display:inline-block; vertical-align:middle; margin:0; max-width:calc(100% - 5rem); position:relative}
.post-text small{ font-weight:100; font-size:300%;display:inline-block; vertical-align:middle; margin:0 1rem 0 0; opacity:.3}
.post-text .icon{ width:3rem; height:3rem; fill:currentColor; display:inline-block; vertical-align:top;margin:0 .5rem 0 0; }

/*hoang*/
.ampstart-image-with-caption figcaption{left:0;right:0;bottom:0;padding:1.5rem;background-color:rgba(0,0,0,0.3);color:#fff}
.content-post article:nth-child(odd) h2{ font-weight:900; margin:1rem 0; font-size:3rem; line-height:1; color:#eee; z-index:5 }
.content-post article:nth-child(even) h2{ font-weight:900; margin:1rem 0; font-size:3rem; line-height:1; color:#4a4a4a; z-index:5 }
.content-post article h2::before{content:normal;}

.box-video-center{text-align:center}

.stroke-01{fill:#003767;-webkit-transition:all 1s ease-in-out;transition:all 1s ease-in-out}
.stroke-02{fill:#00AEEF;-webkit-transition:all 1s ease-in-out;transition:all 1s ease-in-out}
.logo-company.white .stroke-01,.logo-company.white .stroke-02{fill:currentColor}



.achivement-text{text-align:center}
.partner-list{position:relative;display:block;width:90%;height:auto;max-width:900px;margin:0 auto;}
.partner-list ul{position:relative;display:block;width:100%;height:auto;overflow:hidden}

.partner-list li{display:block;float:left;width:48.99%;padding:20px;-webkit-transition:transform 0.3s ease-in-out;transition:transform 0.3s ease-in-out}
.partner-list li:hover{-webkit-transform:scale(.92);transform:scale(.92)}
.partner-list li a{display:block}
.partner-list li img{display:block;width:100%;height:auto}

.year{margin:3rem 0 0.5rem 0;font-weight:700;line-height: 1.6;font-size: 1.4rem;}


.service-list{margin-left:3rem;}
.service-list li{display:list-item}
.post-text .service-text p{max-width:calc(100% - 3rem)}




@media (max-width:64.06rem) {
html {font-size:12px; }
/*BANNER*/
.ampstart-image-banner{margin:70px 0 0 0}
.ampstart-image-banner::after{height:6rem;bottom:-3rem;}
.ampstart-image-banner::before{height:6rem;bottom:-3rem;}
.line-worker svg{max-width:600px; max-height:310px;}
.line-worker { padding:10% 10% 10% 0;}
/*GALLERY*/
.gallery-landing-image-caption-content { -webkit-transform: none; transform: none; -webkit-transition: none; transition: none }
.gallery-landing-image-transform, .gallery-landing-image-caption { -webkit-transition: none; transition: none }
.gallery-landing-image-caption::after { display:none}
.gallery-landing-image-wrapped:hover .gallery-landing-image-caption {left:0; top:0;box-shadow:none;}
.gallery-landing-image-wrapped:hover .gallery-landing-image-transform { padding:0 ;} 
.gallery-landing-image-wrapped:hover .gallery-landing-image-caption:after {-webkit-animation:none; animation:none; -webkit-animation-duration: 0s; animation-duration: 0s; }
.gallery-landing-image-wrapped:hover .gallery-landing-image-transform img{ border:none; -webkit-animation:none; animation:none; -webkit-animation-duration: 0s; animation-duration: 0s;} 

/*CONTENT*/
.content-post h2{  font-size:4rem }

/*hoang*/
.ampstart-image-with-caption figcaption{padding:1rem 1.5rem}
.content-post article:nth-child(odd)  h2, .content-post article:nth-child(even)  h2{  font-size:3rem }

.manager{padding:20px 0}
.manager-box{margin:0 auto 30px auto;white-space: nowrap;overflow: hidden;padding-bottom:10px;overflow-x: auto;-webkit-overflow-scrolling:touch}
.leader-box{margin:0 2%;min-width:200px}
.leader-txt{white-space: normal}

.main-cate{padding:50px 0}
.group-box h3{font-size:26px;padding:40px 5%}
    
.main-pic{display:block;width:100%;margin:0 auto 20px auto;max-width:500px}
.main-item:nth-child(odd) .main-pic{left: auto}    
.main-item:nth-child(even){left:auto}

.main-item > h3{display: block;margin-bottom:20px; font-family:'Montserrat',sans-serif;font-weight:700;font-size:30px;text-transform: uppercase;text-align: center}
.main-txt h3{display: none}
.main-txt{display: block;width: 100%;height: auto;margin:0 auto;max-width: 600px}
.main-item:nth-child(even) .main-txt, .main-item:nth-child(odd) .main-txt, .main-txt{padding:5vw}


.partner-list li{padding:10px}

.post-text .service-text p{max-width:calc(100% - 2rem) }

}

@media (max-width:40.06rem) {
.title-page{color:#00b2ff; font-size:2rem;}
.ampstart-headerbar-text { display:none}
.ampstart-sidebar-nav-logo {padding-left:1.5rem}

/*BANNER*/
.ampstart-image-banner::after{bottom:-5rem;}
.ampstart-image-banner::before{height:6rem;bottom:-5rem;}
.ampstart-image-banner > figcaption{margin:0; bottom:-7rem}
.stroke-number{stroke-width:2;}
.ampstart-image-banner footer{ display:none}
/*GALLERY*/
.gallery-landing-image-wrapped { width: 90vw; max-width:inherit;}
/*CONTENT*/
.content-post h2{  font-size:2rem }
.post-text .icon{ width:2rem; height:2rem;}

.content-post article:nth-child(odd)  h2, .content-post article:nth-child(even)  h2{  font-size:2.2rem }



.partner-list li{padding:10px 5px}

.factory-slider .partner-list li{display:block;float:left;width:99%;padding:20px;-webkit-transition:transform 0.3s ease-in-out;transition:transform 0.3s ease-in-out}

.post-text .service-text p{max-width:calc(100% - 1rem)}

}


/*ANIMATION*/
@-webkit-keyframes DrawStroke {
100%{ stroke-dashoffset:0;stroke-dasharray:800;}
}
@keyframes DrawStroke {
100%{stroke-dashoffset:0;stroke-dasharray:800;}
}

@-webkit-keyframes Ani {
0% {-webkit-transform: scale(1);}
70% {-webkit-transform: scale(1.1);}
100% {-webkit-transform: scale(1);}
}

@keyframes Ani {
0% { transform: scale(1);}
70% {transform: scale(1.1);}
100% {transform: scale(1);}
}

@-webkit-keyframes goLeft { 
0% {-webkit-transform:scaleX(0) rotate(1turn);transform:scaleX(0) rotate(1turn);-webkit-transform-origin:top left;transform-origin:top left}
48% {-webkit-transform:scaleX(1) rotate(1turn);transform:scaleX(1) rotate(1turn);-webkit-transform-origin:top left;transform-origin:top left}
52% {-webkit-transform:scaleX(1) rotate(1turn);transform:scaleX(1) rotate(1turn);-webkit-transform-origin:top right;transform-origin:top right}
to { -webkit-transform: scaleX(0) rotate(1turn); transform: scaleX(0) rotate(1turn); -webkit-transform-origin: top right; transform-origin: top right }
}
@keyframes goLeft { 
0% {-webkit-transform:scaleX(0) rotate(1turn);transform:scaleX(0) rotate(1turn);-webkit-transform-origin:top left;transform-origin:top left}
48% {-webkit-transform:scaleX(1) rotate(1turn);transform:scaleX(1) rotate(1turn);-webkit-transform-origin:top left;transform-origin:top left}
52% {-webkit-transform:scaleX(1) rotate(1turn);transform:scaleX(1) rotate(1turn);-webkit-transform-origin:top right;transform-origin:top right}
to { -webkit-transform: scaleX(0) rotate(1turn); transform: scaleX(0) rotate(1turn); -webkit-transform-origin: top right; transform-origin: top right }
}


</style>
</head>