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

    $D->_IN_SETTING_PANEL = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');
	$this->loadLanguage('settings.php');

    /****************************************************************/    
    /****************************************************************/

    $D->firstname = stripslashes($this->user->info->firstname);
    $D->lastname = stripslashes($this->user->info->lastname);
    $D->gender = $this->user->info->gender;
    $D->born = explode('-', $this->user->info->birthday);
    $D->hometown = stripslashes($this->user->info->hometown);
    $D->currentcity = stripslashes($this->user->info->currentcity);
    $D->aboutme = stripslashes($this->user->info->aboutme);

    /****************************************************************/    
    /****************************************************************/

    $D->id_menu = 'opt_set_profile';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_settings-menu-left');
            
		if ($D->layout_size == 'min') {

            $for_load = 'min/settings-profile.php';

		} else {

            $for_load = 'max/settings-profile.php';

		}

        $D->titlePhantom = $this->lang('setting_profile_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_settings-menu-left');

		$D->page_title = $this->lang('setting_profile_title_page');

        $D->file_in_template = 'max/settings-profile.php';
        $this->load_template('dashboard-template.php');

	}

?>