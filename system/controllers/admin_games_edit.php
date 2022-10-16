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


    /************************************************/

    $the_sanitaze = new sanitize(); // init sanitaze
	$D->codegame = '';
	if ($this->param('g')) $D->codegame = $this->param('g');
    $D->codegame = $the_sanitaze->str_nohtml($D->codegame);
    if (strlen($D->codegame) != 11) $this->globalRedirect($K->SITE_URL.'admin/games');

    $thegame = $this->db2->fetch("SELECT * FROM games WHERE code='".$D->codegame."' LIMIT 1");

    if (!$thegame) $this->globalRedirect($K->SITE_URL.'admin/games');

    $D->idgame = $thegame->idgame;
    $D->name = stripslashes($thegame->name);
    $D->urlgame = stripslashes($thegame->url_game);
    $D->urlowner = stripslashes($thegame->url_owner);
    $D->thumbnail = stripslashes($thegame->thumbnail);
    $D->status = $thegame->status;

    /************************************************/


    $D->js_script_min = $this->designer->getStringJS('admin');

    $D->id_menu = 'opt_adm_games';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_admin-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/admin-games-edit.php';

		} else {

            $for_load = 'max/admin-games-edit.php';

		}

        $D->titlePhantom = $this->lang('admin_games_edit_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_admin-menu-left');

		$D->page_title = $this->lang('admin_games_edit_title_page');    	

        $D->file_in_template = 'max/admin-games-edit.php';
        $this->load_template('dashboard-template.php');

	}

?>