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
    if ($this->user->is_logged) { $this->redirect('admin/general'); }

    if (isset($_POST['login']) && $_POST['login'] == 'ok') {

        $the_sanitaze = new sanitize();

        $username = $the_sanitaze->str_nohtml($_POST['username']);

        $password = $the_sanitaze->str_nohtml($_POST['password']);

        if ($this->user->login($username, md5($password))) $this->redirect('admin/general');

    }



	$this->loadLanguage('off.php');

    

    $D->page_title = $K->SITE_TITLE;



	$this->load_template('loginoff.php');

?>