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

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');


    $D->_IN_DASHBOARD = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');
    
    /****************************************************************************/
    
    $the_sanitaze = new sanitize(); // init sanitaze
	$D->codealbum = '';
	if ($this->param('a')) $D->codealbum = $this->param('a');
    $D->codealbum = $the_sanitaze->str_nohtml($D->codealbum);
    if (empty($D->codealbum)) $this->globalRedirect($K->SITE_URL.'albums');

    $info_album = $this->db2->fetch("SELECT * FROM albums WHERE code='".$D->codealbum."' LIMIT 1");

    if (!$info_album) $this->globalRedirect($K->SITE_URL.'albums');

    $D->idalbum = $info_album->idalbum;
    $D->title = stripslashes($info_album->title);
    $D->description = stripslashes($info_album->description);
    $D->privacy = $info_album->privacy;
    
    /****************************************************************************/

    $D->id_menu = 'opt_ml_albums';

    /****************************************************************************/
    
    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');
		
        if ($D->layout_size == 'min') {
            $for_load = 'min/albums-edit.php';
		} else {
            $for_load = 'max/albums-edit.php';
		}

        $D->titlePhantom = $this->lang('dashboard_albums_edit_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_albums_edit_title_page');

        $D->file_in_template = 'max/albums-edit.php';
        $this->load_template('dashboard-template.php');

    }

?>