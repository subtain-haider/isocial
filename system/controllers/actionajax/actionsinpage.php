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

    global $K, $D;
    $user = & $GLOBALS['user'];
    $page = & $GLOBALS['page'];

    $page->loadLanguage('global.php');
    $page->loadLanguage('dashboard.php');

    if (!$user->is_logged) { 
        echo('ERROR:'.$page->lang('global_txt_no_session'));
        return;
    }

    $the_sanitaze = new sanitize(); // init sanitaze

    $error = FALSE;

    if ($ajax_action == 'like') {

        $codepage = isset($_POST['cpage']) ? (trim($_POST['cpage'])) : '';
        $codepage = $the_sanitaze->str_nohtml($codepage, 11);

    	if (!$error && empty($codepage)) { $error = TRUE; $txterror = 'Error. '; }

    }

    if ($ajax_action == 'unlike') {

        $codepage = isset($_POST['cpage']) ? (trim($_POST['cpage'])) : '';
        $codepage = $the_sanitaze->str_nohtml($codepage, 11);

    	if (!$error && empty($codepage)) { $error = TRUE; $txterror = 'Error. '; }

    }

    if ($error) {
        echo('ERROR:'.$txterror);
		return;
    } else {

        if ($ajax_action == 'like') {

            if (!$user->likePage($codepage)) {
                echo('ERROR:Error');
                return;
            }

            echo('OK');
            return;  

        }

        if ($ajax_action == 'unlike') {

            if (!$user->unlikePage($codepage)) {
                echo('ERROR:Error');
                return;
            }

            echo('OK');
            return;

        }

    }
?>