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

    $D->me = $this->user->info;

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');
    $this->loadLanguage('activity.php');

    $D->_IN_DASHBOARD = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

    $D->posted_in_editor = 0;
    $D->code_wall_editor = $user->info->code;
    $D->code_writer_editor = $user->info->code;
    $D->type_writer_editor = 0;
    $D->for_who_editor = 1;

    $D->placeholder_textarea_editor = $this->lang('dashboard_newactivity_ph_textarea');

    $D->editor_for = 0; //0: User  1: Page   2: Group

    $D->view_selector_who = TRUE;

    $D->id_menu = 'opt_ml_newsfeed';

    /****************************************************************************/

    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/dashboard.php';

		} else {

            $for_load = 'max/dashboard.php';

		}

        $D->titlePhantom = $this->lang('dashboard_title', array('#SITE_TITLE#'=>$K->SITE_TITLE));

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_title', array('#SITE_TITLE#'=>$K->SITE_TITLE));

        $D->file_in_template = 'max/dashboard.php';
        $this->load_template('dashboard-template.php');

    }

?>