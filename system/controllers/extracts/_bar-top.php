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

$D->menu_top_out = array(
array('id_option' => 'opc_signup_top', 'url' => 'signup', 'rel' => '', 'target' => '', 'text_option' =>  $this->lang('global_txt_signup')),
array('id_option' => 'opc_login_top', 'url' => 'login', 'rel' => '', 'target' => '', 'text_option' =>  $this->lang('global_txt_login')),
);

$D->html_logo = $this->designer->loadLogo();

$D->html_menu_top = $this->designer->createMenuTopBasic($D->menu_top_out);
