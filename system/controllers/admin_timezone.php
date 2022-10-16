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

    $D->menu_timezones	= array();
    if( floatval(substr(phpversion(),0,3)) >= 5.2 ) {
        $tmp = array();
        foreach (timezone_identifiers_list() as $v) {
            if (substr($v, 0, 4) == 'Etc/') { continue; }
            if (FALSE === strpos($v, '/')) { continue; }
            $sdf = new DateTimeZone($v);
            if (!$sdf) { continue; }
            $tmp[$v] = $sdf->getOffset(new DateTime("now", $sdf));
        }
        asort($tmp);
        foreach($tmp as $k=>$v) {
            $D->menu_timezones[$k] = str_replace(array('/','_'), array(' / ',' '), $k);
        }
        asort($D->menu_timezones);
    }
    
    $D->the_timezone = $K->TIMEZONE;

    /****************************************************************/    
    /****************************************************************/

    $D->js_script_min = $this->designer->getStringJS('admin');

    $D->id_menu = 'opt_adm_timez';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_admin-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/admin-timezone.php';

		} else {

            $for_load = 'max/admin-timezone.php';

		}

        $D->titlePhantom = $this->lang('admin_timezone_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_admin-menu-left');

		$D->page_title = $this->lang('admin_timezone_title_page');    	

        $D->file_in_template = 'max/admin-timezone.php';

        $this->load_template('dashboard-template.php');

	}

?>