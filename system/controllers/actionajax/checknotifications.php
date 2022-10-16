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

    global $db2, $K;

    $user = & $GLOBALS['user'];
    $page = & $GLOBALS['page'];

    $page->loadLanguage('global.php');

    if (!$user->is_logged) { 
        echo('ERROR:'.$page->lang('global_txt_no_session'));
        return;
    }
    
    $the_sanitaze = new sanitize(); // init sanitaze

    $error = FALSE;
    
    if ($ajax_action == 'people') { }
    if ($ajax_action == 'global') { }
    if ($ajax_action == 'messages') { }
    
    if ($error) {
        die();
    } else {
        if ($ajax_action == 'people') {
            $r = $db2->fetch_field("SELECT num_notifications_people FROM users WHERE iduser=".$user->info->iduser." LIMIT 1");
            if ($r > 0) {

                $json_result = array('html'=>$r);            
                echo(json_encode($json_result));
                return;

            } else {
          
                echo('ERROR:0');
                return;

            }
        }

        if ($ajax_action == 'global') {
            $r = $db2->fetch_field("SELECT num_notifications_global FROM users WHERE iduser=".$user->info->iduser." LIMIT 1");
            if ($r > 0) {
                
                $json_result = array('html'=>$r);            
                echo(json_encode($json_result));
                return;

            } else {
                
                echo('ERROR:0');
                return;

            }
            
        }
        if ($ajax_action == 'messages') {
            $r = $db2->fetch_field("SELECT num_notifications_messages FROM users WHERE iduser=".$user->info->iduser." LIMIT 1");
            if ($r > 0) {
                
                $json_result = array('html'=>$r);            
                echo(json_encode($json_result));
                return;

            } else {
                
                echo('ERROR:0');
                return;

            }

        }
    }
?>