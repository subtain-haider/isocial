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

global $db2, $K;

$user = & $GLOBALS['user'];
$page = & $GLOBALS['page'];

$page->loadLanguage('global.php');
$page->loadLanguage('login.php');

$the_sanitaze = new sanitize(); // init sanitaze

$error = FALSE;
$txterror = '';

$username = isset($_POST['un']) ? (trim($_POST['un'])) : '';
$password = isset($_POST['pw']) ? (trim($_POST['pw'])) : '';
$rememberme = isset($_POST['r']) ? (trim($_POST['r'])) : 0;

if (!$error && empty($username)) {
    $error = TRUE;
    $txterror = $page->lang('login_error_username');
}

if (!$error && empty($password)) {
    $error = TRUE;
    $txterror = $page->lang('login_error_password');
}

if (!$error) {

    if (!$user->login($username, $password, $rememberme) ) {
        echo('ERROR:'.$page->lang('login_error_incorrect'));
        return;
    } else {
        echo('OK');
        return;
    }

} else {
    echo('ERROR:'.$txterror);
    return;
}
?>