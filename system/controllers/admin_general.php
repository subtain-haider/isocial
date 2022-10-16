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
	if (!$D->_IS_LOGGED) $this->globalRedirect('login');
	if (!$D->_IS_ADMIN_USER) $this->globalRedirect('login');

    $D->_IN_ADMIN_PANEL = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');
	$this->loadLanguage('admin.php');

    /****************************************************************/    
    /****************************************************************/

    $D->site_status = $K->SITE_LIVE;
    $D->site_privacy = $K->SITE_PRIVACY;
    $D->site_company = stripslashes($K->COMPANY);
    $D->site_title = stripslashes($K->SITE_TITLE);
    $D->site_keywords = stripslashes($K->SEO_KEYWORDS);
    $D->site_description = stripslashes($K->SEO_DESCRIPTION);

    $D->email_validation = $K->SIGNUP_WITH_VALIDATION;
    $D->min_age = $K->SIGNUP_MIN_AGE;
    $D->max_age = $K->SIGNUP_MAX_AGE;
    $D->with_remember = $K->LOGIN_WITH_REMEMBER;

    $D->mail_fromname = stripslashes($K->MAIL_FROMNAME);
    $D->mail_from = stripslashes($K->MAIL_FROM);
    
    $D->mail_withphpmailer = $K->MAIL_WITH_PHPMAILER;
    $D->mail_host = stripslashes($K->MAIL_HOST);
    $D->mail_port = stripslashes($K->MAIL_PORT);
    $D->mail_username = stripslashes($K->MAIL_USERNAME);
    $D->mail_password = stripslashes($K->MAIL_PASSWORD);

    $D->fb_login = stripslashes($K->LOGIN_WITH_FACEBOOK);
    $D->fb_appid = stripslashes($K->FB_APPID);
    $D->fb_appsecret = stripslashes($K->FB_SECRET);
    
    $D->tw_login = stripslashes($K->LOGIN_WITH_TWITTER);
    $D->tw_appid = stripslashes($K->TW_APPID);
    $D->tw_appsecret = stripslashes($K->TW_SECRET);
    $D->tw_email = stripslashes($K->DOMAIN_EMAIL_TW);
    
    $D->api_key_google = stripslashes($K->KEY_API_GOOGLE);

    $D->m_with_pages = $K->WITH_PAGES;
    $D->m_with_groups = $K->WITH_GROUPS;
    $D->m_with_events = $K->WITH_EVENTS;
    $D->m_with_marketplace = $K->WITH_MARKETPLACE;
    $D->m_with_library = $K->WITH_LIBRARY;
    $D->m_with_games = $K->WITH_GAMES;

    $D->m_with_gdpr = $K->WITH_GDPR;

    $D->m_with_hashtag = $K->WITH_HASHTAGS;
    $D->m_with_hashtag_interval = $K->WITH_HASHTAGS_INTERVAL;
    $D->m_with_hashtag_limit = stripslashes($K->WITH_HASHTAGS_LIMIT);


    /****************************************************************/    
    /****************************************************************/

    $D->js_script_min = $this->designer->getStringJS('admin');

    $D->id_menu = 'opt_adm_general';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_admin-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/admin-general.php';

		} else {

            $for_load = 'max/admin-general.php';

		}

        $D->titlePhantom = $this->lang('admin_general_title_page');

        $html .= $this->load_template($for_load, FALSE);

        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_admin-menu-left');

		$D->page_title = $this->lang('admin_general_title_page');    	

        $D->file_in_template = 'max/admin-general.php';
        $this->load_template('dashboard-template.php');

	}

?>