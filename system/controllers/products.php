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

    $D->show_more = FALSE;
    $D->the_list_items = '';

    /****************************************************************************/

    $res = $this->db2->query("SELECT * FROM products WHERE idsell=".$this->user->info->iduser." ORDER BY idproduct DESC LIMIT 0, ".($K->ITEMS_PER_PAGE + 1));
    $total_items = $this->db2->num_rows();

    $count_regs = 0;
    while ($obj = $this->db2->fetch_object($res)) {

        $D->product = $obj;
        $D->product->name = stripslashes($D->product->name);
        $idcurrency = $D->product->currency;
        
        $idcurrency = $D->product->currency;
        
        $D->product->codepost = $this->db2->fetch_field('SELECT code FROM posts WHERE idpost='.$D->product->idpost.' LIMIT 1');
        
        $D->currency = $network->getCurrencySymbol($idcurrency);

        $D->product->price = number_format($D->product->price, 2);

        $D->product_last = FALSE;
        if ($total_items < $count_regs + 2) $D->product_last = TRUE;

        $D->the_list_items .= $this->load_template('ones/one-product.php', FALSE);

        $count_regs++;
        if ($count_regs >= $K->ITEMS_PER_PAGE) break;

    }

    if ($total_items > $K->ITEMS_PER_PAGE) $D->show_more = TRUE;

    /****************************************************************************/

    $D->id_menu = 'opt_ml_myproducts';
    
    /****************************************************************************/
    
    $this->load_extract_controller('_pre-dashboard');

    /****************************************************************************/

	if ($D->isPhantom) {

        $html = '';
        $this->load_extract_controller('_dashboard-menu-left');

		if ($D->layout_size == 'min') {
            $for_load = 'min/products.php';
		} else {
            $for_load = 'max/products.php';
		}

        $D->titlePhantom = $this->lang('dashboard_products_title_page');

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $this->load_extract_controller('_required-dashboard');
        $this->load_extract_controller('_dashboard-bar-top');
        $this->load_extract_controller('_dashboard-menu-left');

        $D->page_title = $this->lang('dashboard_products_title_page');

        $D->file_in_template = 'max/products.php';
        $this->load_template('dashboard-template.php');

    }

?>