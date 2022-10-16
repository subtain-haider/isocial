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
    if ($D->_IS_LOGGED) $this->globalRedirect('dashboard'); 

	$this->loadLanguage('global.php');
	$this->loadLanguage('login.php');

    $this->load_extract_controller('_bar-top');
    $this->load_extract_controller('_required-recovery');

    $D->page_title = $this->lang('login_reset_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));

	$this->load_template('login-recovery.php');
?>