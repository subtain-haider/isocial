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
	$this->loadLanguage('signup.php');
    
    /*************************************************************************/
    
    $D->cod = '';
    if ($this->param('c')) $D->cod = $this->param('c');;
    
    $D->eml = '';
    if ($this->param('e')) $D->eml = $this->param('e');
    
    if ($D->cod == '' || $D->eml == '') $D->status_val = 0;
    else {
        
        $iduser = $this->db2->fetch_field("SELECT iduser FROM users WHERE code='".$this->db2->escape($D->cod)."' AND user_email='".$this->db2->escape($D->eml)."' LIMIT 1");
        
        if ($iduser) {
            $isvalidate = $this->db2->fetch_field("SELECT validated FROM users WHERE code='".$this->db2->escape($D->cod)."' AND user_email='".$this->db2->escape($D->eml)."' LIMIT 1");
            if ($isvalidate) $D->status_val = 1;
            else {
                $this->db2->query("UPDATE users SET active=1, validated=1, datevalidated='".time()."' WHERE code='".$this->db2->escape($D->cod)."' AND user_email='".$this->db2->escape($D->eml)."' LIMIT 1");
                $D->status_val = 2;
            }
        }
    }
    
    /*************************************************************************/

    $this->load_extract_controller('_bar-top');
    $this->load_extract_controller('_required-signup');

    $D->page_title = $this->lang('signup_title_page', array('#SITE_TITLE#'=>$K->SITE_TITLE));

	$this->load_template('signup-validation.php');

?>