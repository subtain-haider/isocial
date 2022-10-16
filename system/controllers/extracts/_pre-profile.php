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
    
    $D->html_ads_dashboard = '';
    $_theads = $this->network->getAdsAleat(2);
    if ($_theads) {
        
        if ($_theads->type_ads == 1) {
            $_theads->thefile = stripslashes($_theads->thefile);
            $_theads->theurl = stripslashes($_theads->theurl);
            $_theads->thetarget = '';
            if ($_theads->target == 1) $_theads->thetarget = '_blank';
            $D->html_ads_dashboard = '<a href="'.$_theads->theurl.'" target="'.$_theads->thetarget.'"><img src="'.$K->STORAGE_URL_ADS_BASIC.$_theads->thefile.'" alt=""></a>';
        }

        if ($_theads->type_ads == 2) {
            $_theads->the_html  = htmlspecialchars_decode($_theads->the_html);
            $D->html_ads_dashboard = $_theads->the_html;
        }
    }

    /************************************************/    
    
?>