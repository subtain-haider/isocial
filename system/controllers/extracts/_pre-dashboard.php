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
    $D->html_know_people = '';
    $_peoples = $this->network->getUserAleat(6, $this->user->info->iduser);
    if ($_peoples) {
        foreach($_peoples as $onepeople) {
            $D->people_s = $onepeople;
            $D->people_s->firstname = stripslashes($D->people_s->firstname);
            $D->people_s->lastname = stripslashes($D->people_s->lastname);
            $D->people_s->username = $D->people_s->user_username;
            if (empty($D->people_s->avatar)) $D->people_s->avatar = $K->DEFAULT_AVATAR_USER;
            $base_url = $K->STORAGE_URL_AVATARS.'min4/';
            $D->the_avatar_people = $base_url.$D->people_s->avatar;
            if ($D->people_s->avatar != $K->DEFAULT_AVATAR_USER) $D->the_avatar_people = $base_url.$D->people_s->code.'/'.$D->people_s->avatar;
            $D->html_know_people .= $this->load_template('ones/one-know-people.php', FALSE);
        }
    }
    
    $D->SHOW_SUGGESTIONS_PEOPLE = TRUE;
    
    /************************************************/
    
    $D->html_ads_dashboard = '';
    $_theads = $this->network->getAdsAleat(1);
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

    $D->html_hashtags = '';

    $the_hashtags = $this->network->getTrendingHashtags();

    if ($the_hashtags) {
        foreach ($the_hashtags as $onehasht) {
            $D->oh_hashtag = stripslashes($onehasht->hashtag);
            $D->oh_frequency = $onehasht->frequency;
            $D->html_hashtags .= $this->load_template('ones/one-hashtag-wg.php', FALSE);
        }

    }
    
    
?>