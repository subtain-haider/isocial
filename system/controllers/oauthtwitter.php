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

if (!$K->LOGIN_WITH_TWITTER) {
	$this->redirect($K->SITE_URL);	
} else {	
	require_once("twitter/twitteroauth.php");

	$twitteroauth = new TwitterOAuth($K->TW_APPID, $K->TW_SECRET);

	$callBack = $K->SITE_URL.'oauthtwitterData';
	$request_token = $twitteroauth->getRequestToken($callBack);

	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

	if ($twitteroauth->http_code != 200) {
		die('You need to check the settings of your application on Twitter.');
	} else {
		$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
		header('Location: ' . $url);
	}
}
?>