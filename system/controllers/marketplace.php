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
    
    if (!$K->WITH_MARKETPLACE) {
        if ($D->_IS_LOGGED) $this->globalRedirect('dashboard');
        else $this->globalRedirect('home');
    }

    if ($D->_IS_LOGGED) $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');
    
	$this->loadLanguage('global.php');
    $this->loadLanguage('marketplace.php');
    if ($D->_IS_LOGGED) {
        $this->loadLanguage('dashboard.php');
    	$D->me = $this->user->info;
    }
    
    /************************************************/
    $the_sanitaze = new sanitize(); // init sanitaze

    $cad_cat = '';
    $cad_subcat = '';

	$D->m_category = -1;
	$D->m_subcategory = -1;
	if ($this->param('c')) $D->m_category = $this->param('c');
	if ($this->param('s')) $D->m_subcategory = $this->param('s');
    if ($D->m_category != 'all') {
        $D->m_category = $the_sanitaze->int($D->m_category);
        if ($D->m_category > 0) $cad_cat = ' AND idcategory='.$D->m_category.' ';
        else $D->m_category = -1;
    } else $D->m_category = -1;
    
    if ($D->m_subcategory != 'all') {
        $D->m_subcategory = $the_sanitaze->int($D->m_subcategory);
        if ($D->m_subcategory > 0) $cad_subcat = ' AND idsubcategory='.$D->m_subcategory.' ';
        else $D->m_subcategory = -1;
    } else $D->m_subcategory = -1;
    
    $D->open_filter = FALSE;
    if (!empty($cad_cat) || !empty($cad_subcat)) $D->open_filter = TRUE;
    
    /************************************************/
    
    $D->show_more = FALSE;
    $D->the_list_items = '';
    
    $K->ITEMS_PER_PAGE = $K->ITEMS_PER_PAGE_MARKETPLACE;
    
    $total_items = 0;
    
    $products = $this->db2->fetch_all("SELECT * FROM products WHERE 1=1 ".$cad_cat.$cad_subcat." ORDER BY idproduct DESC LIMIT 0, ".($K->ITEMS_PER_PAGE + 1));
    if ($products) {
        $total_items = count($products);
        $count_regs = 0;
        foreach($products as $oneproduct) {
            
            $D->product = $oneproduct;
            $D->product->name = stripslashes($D->product->name);
            $idcurrency = $D->product->currency;
            
            $D->currency = $network->getCurrencySymbol($idcurrency);
    
            $D->product->price = number_format($D->product->price, 2);

            $D->photo = array();
            $photos_prod = $this->db2->fetch_all("SELECT * FROM products_images WHERE idproduct=".$D->product->idproduct);
            if ($photos_prod) {
                foreach ($photos_prod as $onephoto) {
                    $D->photo[] = $onephoto->photo;
                }
            }
            $D->photo_product = $K->STORAGE_URL_PRODUCTS .'min2/'. $D->photo[0];
            
            $D->product->location = stripslashes($D->product->location);
            
            $theusername_of_sell = $this->db2->fetch_field("SELECT user_username FROM users WHERE iduser=".$D->product->idsell." LIMIT 1");
            $code_post_prod = $this->db2->fetch_field("SELECT code FROM posts WHERE idpost=".$D->product->idpost." LIMIT 1");
            
            $D->product->url = $K->SITE_URL.$theusername_of_sell.'/post/'.$code_post_prod;
            

            $D->the_list_items .= $this->load_template('ones/one-product-market.php', FALSE);

            $count_regs++;
            if ($count_regs >= $K->ITEMS_PER_PAGE) break;
        
        }

        if ($total_items > $K->ITEMS_PER_PAGE) $D->show_more = TRUE;
        
    }
    
    /************************************************/
        
    $D->OG_show = TRUE;
    $D->OG_type = 'website';
    $D->OG_title = $this->lang('marketplace_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));
    $D->OG_description = $this->lang('marketplace_description', array('#SITE_TITLE#'=>$K->SITE_TITLE));
    $D->OG_url = $K->SITE_URL.'marketplace';
    $D->OG_image = $K->STORAGE_URL_OGS.'og-marketplace.png';


    $D->id_menu = 'opt_ml_marketplace';

    $D->id_container = 'site';
    
    $D->js_script_min = $this->designer->getStringJS('marketplace');
    
    $D->menu_footer = TRUE;

	if ($D->isPhantom) {

        $html = '';
        
        if ($D->_IS_LOGGED) {
            
            $D->id_container = 'dashboard';
            $this->load_extract_controller('_dashboard-menu-left');

        }

		if ($D->layout_size == 'min') {
            $for_load = 'min/marketplace.php';
		} else {
            $for_load = 'max/marketplace.php';
		}

        $D->titlePhantom = $this->lang('marketplace_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {
        
        $D->page_title = $this->lang('marketplace_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));
        
        if ($D->_IS_LOGGED) {
            
            $this->load_extract_controller('_required-dashboard');
            $this->load_extract_controller('_dashboard-bar-top');

            $this->load_extract_controller('_dashboard-menu-left');

            $D->id_container = 'dashboard';
            $D->file_in_template = 'max/marketplace.php';
            $this->load_template('dashboard-template.php');

        } else {
            
            if (!isset($D->string_js) || !is_array($D->string_js)) $D->string_js = array();
            array_push($D->string_js, 'moment.locale("'.$K->LANGUAGE.'");');
            
            $this->load_extract_controller('_bar-top');
            $this->load_extract_controller('_required-out');
            
            $D->file_in_template = 'max/marketplace.php';
            $this->load_template('site-template.php');
            
        }

    }

?>