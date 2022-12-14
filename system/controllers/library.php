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
    if (!$K->WITH_LIBRARY) {
        if ($D->_IS_LOGGED) $this->globalRedirect('dashboard');
        else $this->globalRedirect('home');
    }

	if ($D->_IS_LOGGED) $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');
    
	$this->loadLanguage('global.php');
    $this->loadLanguage('library.php');
    if ($D->_IS_LOGGED) {
        $this->loadLanguage('dashboard.php');
    	$D->me = $this->user->info;
    }
    
    /************************************************/
    $the_sanitaze = new sanitize(); // init sanitaze

    $cad_cat = '';
    $cad_subcat = '';

	$D->l_category = -1;
	$D->l_subcategory = -1;
	if ($this->param('c')) $D->l_category = $this->param('c');
	if ($this->param('s')) $D->l_subcategory = $this->param('s');
    if ($D->l_category != 'all') {
        $D->l_category = $the_sanitaze->int($D->l_category);
        if ($D->l_category > 0) $cad_cat = ' AND idcategory='.$D->l_category.' ';
        else $D->l_category = -1;
    } else $D->l_category = -1;
    
    if ($D->l_subcategory != 'all') {
        $D->l_subcategory = $the_sanitaze->int($D->l_subcategory);
        if ($D->l_subcategory > 0) $cad_subcat = ' AND idsubcategory='.$D->l_subcategory.' ';
        else $D->l_subcategory = -1;
    } else $D->l_subcategory = -1;
    
    $D->open_filter = FALSE;
    if (!empty($cad_cat) || !empty($cad_subcat)) $D->open_filter = TRUE;
    
    /************************************************/
    
    $D->show_more = FALSE;
    $D->the_list_items = '';
    
    $K->ITEMS_PER_PAGE = $K->ITEMS_PER_PAGE_LIBRARY;
    
    $D->category = 0;
    $D->subcategory = 0;
    
    $total_items = 0;
    
    $articles = $this->db2->fetch_all("SELECT * FROM articles WHERE 1=1 ".$cad_cat.$cad_subcat." ORDER BY idarticle DESC LIMIT 0, ".($K->ITEMS_PER_PAGE + 1));
    if ($articles) {
        $total_items = count($articles);
        $count_regs = 0;
        foreach($articles as $onearticle) {
            
            $D->article = $onearticle;
            $D->article->title = stripslashes($D->article->title);
            $D->article->photo = $K->STORAGE_URL_ARTICLES.'min1/'.$D->article->photo;
            
            $thecategories = $network->getCategoriesArticle($D->article->idarticle, FALSE);
            $D->subcategory_article = stripslashes($thecategories->subcategory);
            

            $D->the_writer_a = $this->db2->fetch("SELECT code, user_username, firstname, lastname FROM users WHERE iduser=".$D->article->idwriter." LIMIT 1");
            

            $D->the_list_items .= $this->load_template('ones/one-article-library.php', FALSE);

            $count_regs++;
            if ($count_regs >= $K->ITEMS_PER_PAGE) break;
        
        }

        if ($total_items > $K->ITEMS_PER_PAGE) $D->show_more = TRUE;
        
    }
    
    /************************************************/

    $D->OG_show = TRUE;
    $D->OG_type = 'website';
    $D->OG_title = $this->lang('library_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));
    $D->OG_description = $this->lang('library_description', array('#SITE_TITLE#'=>$K->SITE_TITLE));
    $D->OG_url = $K->SITE_URL.'library';
    $D->OG_image = $K->STORAGE_URL_OGS.'og-library.png';;


    $D->id_menu = 'opt_ml_library';
    
    $D->id_container = 'site';
    
    $D->js_script_min = $this->designer->getStringJS('library');
    
    $D->menu_footer = TRUE;

	if ($D->isPhantom) {

        $html = '';
        if ($D->_IS_LOGGED) {
            
            $D->id_container = 'dashboard';
            $this->load_extract_controller('_dashboard-menu-left');

        }

		if ($D->layout_size == 'min') {
            $for_load = 'min/library.php';
		} else {
            $for_load = 'max/library.php';
		}

        $D->titlePhantom = $this->lang('library_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {

        $D->page_title = $this->lang('library_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));
        
        if ($D->_IS_LOGGED) {
            
            $this->load_extract_controller('_required-dashboard');
            $this->load_extract_controller('_dashboard-bar-top');

            $this->load_extract_controller('_dashboard-menu-left');

            $D->id_container = 'dashboard';
            $D->file_in_template = 'max/library.php';
            $this->load_template('dashboard-template.php');

        } else {
            
            if (!isset($D->string_js) || !is_array($D->string_js)) $D->string_js = array();
            array_push($D->string_js, 'moment.locale("'.$K->LANGUAGE.'");');
            
            $this->load_extract_controller('_bar-top');
            $this->load_extract_controller('_required-out');
            
            $D->file_in_template = 'max/library.php';
            $this->load_template('site-template.php');
            
        }
        

    }

?>