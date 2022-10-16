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

    $D->_IN_DASHBOARD = FALSE;
	if ($D->_IS_LOGGED) $D->_WITH_NOTIFIER = TRUE;

	$D->isPhantom = FALSE;
	if ($this->param('phantom') && $this->param('phantom')=='yes') $D->isPhantom = TRUE;

	$D->layout_size = 'min';
	if ($this->param('lysize')) $D->layout_size = $this->param('lysize');
    
	$this->loadLanguage('global.php');
    $this->loadLanguage('article.php');
    if ($D->_IS_LOGGED) {
        $this->loadLanguage('dashboard.php');
    	$D->me = $this->user->info;
    }
    
    $the_sanitaze = new sanitize(); // init sanitaze
	$D->codearticle = '';
	if ($this->param('codearticle')) $D->codearticle = $this->param('codearticle');
    $D->codearticle = $the_sanitaze->str_nohtml($D->codearticle, 11);
    
    if (strlen($D->codearticle) != 11) $this->globalRedirect($K->SITE_URL.'library');

    $the_article = $this->db2->fetch("SELECT * FROM articles WHERE code='".$D->codearticle."' LIMIT 1");  
    
    if (!$the_article) $this->globalRedirect($K->SITE_URL.'library');
    
    /************************************************/
    

        
    $D->article = $the_article;
    $D->article->title = stripslashes($D->article->title);
    $D->article->summary = stripslashes($D->article->summary);
    $D->article->text_article = htmlspecialchars_decode(stripslashes($D->article->text_article));
    
    $D->article->photo_normal = $K->STORAGE_URL_ARTICLES.'min1/'.$D->article->photo;
    $D->article->photo_od = getImageOG($D->article->photo);
    $D->article->photo_max = $K->STORAGE_URL_ARTICLES.$D->article->photo;
    
    $thecategories = $network->getCategoriesArticle($D->article->idarticle, FALSE);
    $D->category_article = stripslashes($thecategories->category);
    $D->subcategory_article = stripslashes($thecategories->subcategory);
    
    $D->the_writer_a = $this->db2->fetch("SELECT code, user_username, firstname, lastname, avatar, num_friends FROM users WHERE iduser=".$D->article->idwriter." LIMIT 1");

    $base_url = $K->STORAGE_URL_AVATARS.'min2/';
    if (empty($D->the_writer_a->avatar)) $D->the_writer_a->avatar = $K->DEFAULT_AVATAR_USER;
    $D->url_avatar = $base_url.$D->the_writer_a->avatar;
    if ($D->the_writer_a->avatar != $K->DEFAULT_AVATAR_USER) $D->url_avatar = $base_url.$D->the_writer_a->code.'/'.$D->the_writer_a->avatar;
    
    $D->writer_username = $D->the_writer_a->user_username;
    $D->writer_a = $D->the_writer_a->firstname.' '.$D->the_writer_a->lastname;
    $D->num_friends_a = $D->the_writer_a->num_friends;
    
    /************************************************/
    
    $D->html_sugestion = '';
    $sugestion = $network->getArticlesAleat(5, $D->article->idarticle);
    if ($sugestion) {
        foreach($sugestion as $onesugestion) {

            $D->article_sug = $onesugestion;
            $D->article_sug->title = stripslashes($D->article_sug->title);
            $D->article_sug->photo = $K->STORAGE_URL_ARTICLES.'min2/'.$D->article_sug->photo;

            $D->the_writer_a = $this->db2->fetch("SELECT code, user_username, firstname, lastname FROM users WHERE iduser=".$D->article_sug->idwriter." LIMIT 1");
        
            $D->html_sugestion .= $this->load_template('ones/one-sugestion-article.php', FALSE);
        }
    }
    
    /****************************************************************************/

    $D->id_menu = 'opt_ml_library';

    $D->id_container = 'site';
    
    $D->menu_footer = TRUE;
    
    $D->OG_show = TRUE;
    $D->OG_type = 'article';
    $D->OG_title = $D->article->title;
    $D->OG_description = $D->article->summary;
    $D->OG_url = $K->SITE_URL.'article/'.$D->codearticle;
    $D->OG_image = $D->article->photo_od;

	if ($D->isPhantom) {

        $html = '';
        if ($D->_IS_LOGGED) {
            $D->id_container = 'dashboard';
            $this->load_extract_controller('_dashboard-menu-left');
        }

		if ($D->layout_size == 'min') {
            $for_load = 'min/article.php';
		} else {
            $for_load = 'max/article.php';
		}

        $D->titlePhantom = $D->article->title;

        $html .= $this->load_template($for_load, FALSE);
        echo $html;

	} else {
        $D->page_title = $D->article->title;
        
        if ($D->_IS_LOGGED) {
            
            $this->load_extract_controller('_required-dashboard');
            $this->load_extract_controller('_dashboard-bar-top');
            $this->load_extract_controller('_dashboard-menu-left');

            $D->id_container = 'dashboard';
            $D->file_in_template = 'max/article.php';
            $this->load_template('dashboard-template.php');

        } else {
            
            if (!isset($D->string_js) || !is_array($D->string_js)) $D->string_js = array();
            array_push($D->string_js, 'moment.locale("'.$K->LANGUAGE.'");');
            
            $this->load_extract_controller('_bar-top');
            $this->load_extract_controller('_required-out');
            
            $D->file_in_template = 'max/article.php';
            $this->load_template('site-template.php');
            
        }

    }

?>