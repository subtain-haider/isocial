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

    if (!$K->WITH_MARKETPLACE) $this->globalRedirect('dashboard');

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');


    $D->_IN_DASHBOARD = TRUE;
    $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');
    
    $D->currencies = '';
    $currencies = $this->db2->fetch_all("SELECT * FROM currencies ORDER BY code_iso ASC");
    if ($currencies) {
        foreach ($currencies as $onecurrency) {
            $D->currencies .= '<option value="'.$onecurrency->idcurrency.'">'.$onecurrency->code_iso.' ('.$onecurrency->symbol.')</option>';
        }
    }

    $D->id_menu = 'opt_ml_products';
    
    /****************************************************************************/
    
    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');
		
        if ($D->layout_size == 'min') {
            $for_load = 'min/products-create.php';
		} else {
            $for_load = 'max/products-create.php';
		}

        $D->titlePhantom = $this->lang('dashboard_products_create_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_products_create_title_page');

        $D->file_in_template = 'max/products-create.php';
        $this->load_template('dashboard-template.php');

    }

?>