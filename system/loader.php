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

    ini_set('upload_max_filesize', '10M');
    chdir(dirname(__FILE__));

	session_start();

	require_once('helpers/functions.php');    
    require_once('classes/class_mysql.php');    
    require_once('classes/class_sanitize.php');
    require_once('classes/class_network.php');
    require_once('classes/class_user.php');
    require_once('classes/class_designer.php');
    require_once('classes/class_page.php');
    require_once('classes/class_post.php');
    require_once('classes/class_newpost.php');
    require_once('classes/class_imagen.php');
    require_once('classes/class_comment.php');
    require_once('classes/class_media.php');
    
	require_once('config.php');

	$db1 = new mysql($K->DB_HOST, $K->DB_USER, $K->DB_PASS, $K->DB_NAME);
	$db2 = &$db1;

	$network = new network();
	$network->load();

    if (function_exists('date_default_timezone_set')) date_default_timezone_set($K->TIMEZONE);

	$user = new user();
	$user->load();

	$page = new page();
	$page->load();

?>