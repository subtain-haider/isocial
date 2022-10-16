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

    $the_sanitaze = new sanitize(); // init sanitaze
    
    $error = FALSE;

    if ($ajax_action == 'change') {
    
        $lang = isset($_POST['lg']) ? (trim($_POST['lg'])) : '';
        $lang = $the_sanitaze->str_nohtml($lang, 2);
            
    	if (!$error && empty($lang)) { $error = TRUE; $txterror = 'Error. '; }

    }

    if ($error) {
        echo('ERROR:'.$txterror);
		return;
    } else {
        
        if ($ajax_action == 'change') {
            setcookie('lang-out', $lang, time()+ (10 * 365 * 24 * 60 * 60), '/');
            if ($user->is_logged) { 
                 $page->db2->query("UPDATE users SET language='".$lang."' WHERE iduser=".$user->info->iduser." LIMIT 1");
            }
            echo('OK');
            return;
        }
        
    }
?>