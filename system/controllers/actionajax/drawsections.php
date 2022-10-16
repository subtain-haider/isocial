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
    $page->loadLanguage('activity.php');

    if (!$user->is_logged) { 
        $json_result = array('status'=>'ERROR', 'message'=>$page->lang('global_txt_no_session'));
        echo(json_encode($json_result));
        return;
    }
    
    $the_sanitaze = new sanitize(); // init sanitaze
    
    $error = FALSE;

    if ($ajax_action == 'postsinit') {}
	
    if ($ajax_action == 'savedpostinit') {}

    if ($error) {
        echo('ERROR:'.$txterror);
		return;
    } else {

        if ($ajax_action == 'postsinit') {

            $page->load_extract_controller('_dashboard-posts-init');

            $json_result = array('listactivities'=>$D->the_list_activities, 'showmore'=>$D->show_more);
            echo(json_encode($json_result));
            return;  
            
        }
		
        if ($ajax_action == 'savedpostinit') {

            $page->load_extract_controller('_saved-posts-init');

            $json_result = array('listactivities'=>$D->the_list_activities, 'showmore'=>$D->show_more);
            echo(json_encode($json_result));
            return;  
            
        }

        
    }
?>