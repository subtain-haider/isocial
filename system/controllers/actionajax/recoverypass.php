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

    global $db2, $K, $D;
	$page = & $GLOBALS['page'];

	$page->loadLanguage('global.php');
	$page->loadLanguage('login.php');
    $page->loadLanguage('email.php');

    $the_sanitaze = new sanitize(); // init sanitaze

	$error = FALSE;
    $msgerror = '';

	$email = isset($_POST['em']) ? (strtolower(trim($_POST['em']))) : '';

	if (!$error && empty($email) && !emailValid($email)) {
		$error = TRUE;
		$msgerror = $page->lang('signup_error_email');
	}

	if ($error) {
        echo('ERROR:'.$msgerror);
        return;
	} else {

		$theUser = $db2->fetch("SELECT code, with_validation, validated, user_email FROM users WHERE user_email='".$email."' LIMIT 1");

		if (!$theUser) {
            echo('ERROR:'.$page->lang('login_reset_error_nonregistered'));
            return;
		} else {

			$sendMailRecovery = 0;
			if ($theUser->with_validation) {

				if (!$theUser->validated) {

					$to = $email;
					$subject = $page->lang('email_validation_subject', array('#SITE_TITLE#'=>$K->SITE_TITLE));
					$D->linkvalidation = $K->SITE_URL.'validation/c:'.$theUser->code.'/e:'.$theUser->user_email;
                    $message = $page->load_template('email/validate_email.php', FALSE);

					$from = $K->MAIL_FROM;

					if ($K->MAIL_WITH_PHPMAILER) {
						sendMail_PHPMailer($to, $subject, $message);
					} else {
						sendMail($from, $to, $subject, $message);
					}				
				} else $sendMailRecovery = 1;
			} else $sendMailRecovery = 1;

			if ($sendMailRecovery == 1) {
				$coderecovery = getCode(20, 0);		
				$db2->query("UPDATE users SET pass_reset_key='".$coderecovery."' WHERE code='".$theUser->code."' LIMIT 1");

				$D->linkresetpass = $K->SITE_URL.'resetpassword/c:'.$coderecovery.'/cu:'.$theUser->code;    

				$to = $email;
				$subject = $page->lang('email_recovery_subject', array('#SITE_TITLE#'=>$K->SITE_TITLE));

                $message = $page->load_template('email/reset_password.php', FALSE);

				$from = $K->MAIL_FROM;
				if ($K->MAIL_WITH_PHPMAILER) {
					sendMail_PHPMailer($to, $subject, $message);
				} else {
					sendMail($from, $to, $subject, $message);
				}
			}
            echo(json_encode(array('html'=>$page->lang('login_reset_ok'))));
            return;
		}	
	}
?>