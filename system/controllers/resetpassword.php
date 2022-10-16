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
    
    $D->reset_key = '';
    if ($this->param('c')) $D->reset_key = $this->param('c');
    
    $D->cod = '';
    if ($this->param('cu')) $D->cod = $this->param('cu');
    
    if ($D->cod == '' || $D->reset_key == '') $D->status_reset = 0;
    else {
        $theuser = $this->db2->fetch("SELECT iduser, user_username FROM users WHERE code='".$this->db2->escape($D->cod)."' AND pass_reset_key='".$this->db2->escape($D->reset_key)."' LIMIT 1");
        if ($theuser) {
            $D->theusername = $theuser->user_username;
            $D->newpas = getCode(8, 1);            
            $this->db2->query("UPDATE users SET user_password='".md5($D->newpas)."', pass_reset_key=''  WHERE iduser=".$theuser->iduser." LIMIT 1");            
            $D->status_reset = 1;
        }
        else $D->status_reset = 0;    
    }

    $this->load_extract_controller('_bar-top');
    $this->load_extract_controller('_required-recovery');

    $D->page_title = $this->lang('login_reset_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));

	$this->load_template('resetpassword.php');
?>