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
    $D->_IN_PROFILE = FALSE;

    if ($D->_IS_LOGGED) $D->_WITH_NOTIFIER = TRUE;

    /******************************************************************/

    $the_sanitaze = new sanitize(); // init sanitaze

	$D->thephoto_code = '';
	if (isset($this->params->codphoto) && !empty($this->params->codphoto)) $D->thephoto_code = $this->params->codphoto;
    $D->thephoto_code = $the_sanitaze->str_nohtml($D->thephoto_code, 11);
    if (empty($D->thephoto_code) || strlen($D->thephoto_code) < 11) $this->globalRedirect($K->SITE_URL.$this->params->username);

    $D->thepost_username = $the_sanitaze->str_nohtml($this->params->username);

    /******************************************************************/

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

	$this->loadLanguage('global.php');

    if ($D->_IS_LOGGED) {
        $this->loadLanguage('dashboard.php');
        $this->loadLanguage('settings.php');
    }

	$this->loadLanguage('profile.php');
    $this->loadLanguage('activity.php');

    $thepage = $network->getPageById($this->params->page);
    $D->idpage = $thepage->idpage;
    $D->codepage = $thepage->code;
    $D->idcreator = $thepage->idcreator;
    $D->username = $thepage->puname;
    $D->the_title = $thepage->title;
    $D->description = $thepage->description;
    $D->idcat = $thepage->idcat;
    $D->idsubcat = $thepage->idsubcat;
    $D->nameCategory = $network->getNameCategory($D->idsubcat);

    $D->the_avatar_real = $thepage->avatar;
    $D->the_avatar_page = $K->STORAGE_URL_AVATARS_PAGE.'min4/'.($thepage->avatar == $K->DEFAULT_AVATAR_PAGE ? '' : $thepage->code.'/') . $D->the_avatar_real;

    $D->posted_in = 1;
    $D->code_wall = $D->codepage;
    $D->code_writer = $D->codepage;
    $D->type_writer = 1;
    $D->for_who = 0;

    $D->is_my_page = FALSE;
    $D->like_me_page = FALSE;

    if ($D->_IS_LOGGED) {
		$D->me = $this->user->info;
		$D->is_my_page = ($D->idcreator == $D->me->iduser);
        $D->like_me_page = $this->user->likeMePage($D->idpage);
    }

    $D->menu_footer = FALSE;

    $D->id_container = 'site';

    /******************************************************************/

    $D->post_is_showeable = TRUE;

    $obj_media = $this->db2->fetch("SELECT * FROM medias WHERE code='".$D->thephoto_code."'");
    if (!$obj_media) $this->globalRedirect($K->SITE_URL.$this->params->username);

    $obj_post = $this->db2->fetch("SELECT * FROM posts WHERE code='".$obj_media->codecontainer."'");
    if (!$obj_post) $this->globalRedirect($K->SITE_URL.$this->params->username);

    $D->html_media = '';
    if ($D->post_is_showeable) {
        $the_media = new media($obj_media->idmedia);
        $D->html_media = $the_media->draw();
    }

    /****************************************************************************/

    $this->load_extract_controller('_pre-dashboard-alone');

    /****************************************************************************/

	if ($D->isPhantom) {

        $html = '';

        if ($D->_IS_LOGGED) {

            $D->id_container = 'dashboard';
            $this->load_extract_controller('_dashboard-menu-left');
            
        }

        if ($D->layout_size == 'min') {
            $for_load = 'min/page-photo.php';
        } else {
            $for_load = 'max/page-photo.php';
        }

        if ($D->post_is_showeable) {
            $D->titlePhantom = $D->the_title.' | '.$K->SITE_TITLE;
        } else {
            $D->titlePhantom = $this->lang('activity_txt_no_available').' | '.$K->SITE_TITLE;
        }

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        if ($D->post_is_showeable) {
            $D->page_title = $D->the_title.' | '.$K->SITE_TITLE;
        } else {
            $D->page_title = $this->lang('activity_txt_no_available').' | '.$K->SITE_TITLE;
        }

        if ($D->_IS_LOGGED) {

            $this->load_extract_controller('_required-dashboard');
            $this->load_extract_controller('_dashboard-bar-top');

            $D->id_container = 'dashboard';
            $this->load_extract_controller('_dashboard-menu-left');
            $D->file_in_template = 'max/page-photo.php';            

            $this->load_template('dashboard-template.php');

        } else {

            if (!isset($D->string_js) || !is_array($D->string_js)) $D->string_js = array();
            array_push($D->string_js, 'moment.locale("'.$K->LANGUAGE.'");');

            $this->load_extract_controller('_bar-top');
            $this->load_extract_controller('_required-out');

            $D->file_in_template = 'max/page-photo.php';
            $this->load_template('site-template.php');

        }

    }

?>