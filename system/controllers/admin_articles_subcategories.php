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

    $the_sanitaze = new sanitize(); // init sanitaze
	$D->idcat = '';
	if ($this->param('c')) $D->idcat = $this->param('c');
    $D->idcat = $the_sanitaze->int($D->idcat);
    if ($D->idcat <= 0) $this->globalRedirect($K->SITE_URL.'admin/articles/categories');

	$this->loadLanguage('global.php');
	$this->loadLanguage('dashboard.php');
	$this->loadLanguage('admin.php');

    /****************************************************************/    
    /****************************************************************/

    $D->name_category = $this->db2->fetch_field("SELECT name FROM articles_cat WHERE idcategory=".$D->idcat." LIMIT 1");

    if (!$D->name_category) $this->globalRedirect($K->SITE_URL.'admin/articles/categories');

    $items = $this->db2->fetch_all("SELECT * FROM articles_cat WHERE idfather=".$D->idcat." ORDER BY name ASC");

    $D->html_items = '';

    foreach ($items as $oneitem) {
        $D->one = $oneitem;
        $D->one->name = stripslashes($oneitem->name);
        $D->html_items .= $this->load_template('ones/one-subcategory-article.php', FALSE);
    }

    /****************************************************************/    
    /****************************************************************/

    $D->js_script_min = $this->designer->getStringJS('admin');

    $D->id_menu = 'opt_adm_articles_categories';

	if ($D->isPhantom) {

        $html = '';

        $this->load_extract_controller('_admin-menu-left');

		if ($D->layout_size == 'min') {

            $for_load = 'min/admin-articles-subcategories.php';

		} else {

            $for_load = 'max/admin-articles-subcategories.php';

		}

        $D->titlePhantom = $this->lang('admin_articles_subcategories_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_admin-menu-left');

		$D->page_title = $this->lang('admin_articles_subcategories_title_page');    	

        $D->file_in_template = 'max/admin-articles-subcategories.php';
        $this->load_template('dashboard-template.php');

	}

?>