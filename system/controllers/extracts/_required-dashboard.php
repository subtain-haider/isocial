<?php 
/*
********************************************************
* @author "M Code Developer"
* @author_url 1: https://www.mcodedeveloper.com
* @author_url 2: http://codecanyon.net/user/MCodeDeveloper
* @author_email: m@mcodedeveloper.com
* @support_email: devs@mcodedeveloper.com
********************************************************
* iSocial - Social Networking Platform
* Copyright (c) 2020 "M Code Developer". All rights reserved.
********************************************************
*/
   
$D->string_js = array('var _WITH_NOTIFIER = '. $D->_WITH_NOTIFIER . ';', 'moment.locale("'.$K->LANGUAGE.'");');

$js_inlogin = array('jquery.min', 'core', 'base', 'modernizr.min', 'jquery.slimscroll.min', 'jquery-ui.min', 'moment.min', 'autosize.min', 'dashboard', 'dashboard-menutop', 'editor', 'livestamp.min', 'managed-chat', 'profile', 'settings', 'md5', 'title_notifier', 'mediaelement/mediaelement-and-player.min', 'videojs/video.min', 'zoomeer', 'theia-sticky-sidebar');

$js_innologin = array('jquery.min', 'base', 'modernizr.min', 'jquery.slimscroll.min', 'jquery-ui.min', 'moment.min', 'livestamp.min', 'mediaelement/mediaelement-and-player.min', 'videojs/video.min', 'login', 'md5', 'profile', 'recoverypass', 'signup', 'zoomeer', 'theia-sticky-sidebar');

$css_login = array('css', 'css-wide', 'css-tablet', 'css-mobile320', 'css-mobile480');
$css_nologin = array('css', 'css-wide', 'css-tablet', 'css-mobile320', 'css-mobile480');

$D->header_data = $this->designer->getMetaData();
$D->header_data .= $this->designer->getCSSData($css_nologin, $css_login);
$D->header_data .= $this->designer->loadFavicon();
$D->header_data .= $this->designer->getJSData($js_innologin, $js_inlogin);

/*************************************************************************/    
