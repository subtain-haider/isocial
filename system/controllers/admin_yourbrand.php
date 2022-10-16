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

    $D->img_top_logo_out = $K->LOGOTIPO_OUT;
    $D->img_top_logo_in = $K->LOGOTIPO_IN;
    $D->img_isotipo_out = $K->LOGOTIPO_RESP_OUT;
    $D->img_isotipo_in = $K->LOGOTIPO_RESP_IN;
    $D->img_welc_dash = $K->IMG_WELCOME_DASH;
    $D->img_favicon = $K->IMG_FAVICON;

    /****************************************************************/    
    /****************************************************************/

    $D->js_script_min = $this->designer->getStringJS('admin');

    $D->id_menu = 'opt_adm_yourbrand';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_admin-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/admin-yourbrand.php';

		} else {

            $for_load = 'max/admin-yourbrand.php';

		}

        $D->titlePhantom = $this->lang('admin_general_title_page');

        $html .= $this->load_template($for_load, FALSE);

        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_admin-menu-left');

		$D->page_title = $this->lang('admin_general_title_page');    	

        $D->file_in_template = 'max/admin-yourbrand.php';
        $this->load_template('dashboard-template.php');

	}

?>