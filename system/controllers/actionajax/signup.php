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

    global $db2, $D, $K;
	$user = & $GLOBALS['user'];
	$page = & $GLOBALS['page'];

	$page->loadLanguage('global.php');
	$page->loadLanguage('signup.php');

	$error = FALSE;
    $txterror = '';

    $the_sanitaze = new sanitize(); // init sanitaze

	$firstname = isset($_POST['fn']) ? (trim($_POST['fn'])) : '';
	$lastname = isset($_POST['ln']) ? (trim($_POST['ln'])) : '';
	$username = isset($_POST['un']) ? (trim($_POST['un'])) : '';
	$password = isset($_POST['pw']) ? (trim($_POST['pw'])) : '';
	$email = isset($_POST['em']) ? (strtolower(trim($_POST['em']))) : '';
	$bday = isset($_POST['bd']) ? ($_POST['bd']) : '';
	$bmonth = isset($_POST['bm']) ? ($_POST['bm']) : '';
	$byear = isset($_POST['by']) ? ($_POST['by']) : '';
	$gender = isset($_POST['ge']) ? ($_POST['ge']) : '';

	if (!$error && empty($firstname)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_firstname');
	}

	if (!$error && empty($lastname)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_lastname');
	}

	if (!$error && empty($username) && !validateUsername($username)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_username');
	}

	if (!$error && nameInConflict($username)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_username_conflict');
	}

	if (!$error && empty($password)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_password');
	}

	if (!$error && empty($email) && !emailValid($email)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_email');
	}

	$cadBirthday = '';
	if (!$error && ($bday == -1 || $bmonth == -1 || $byear == -1)) {
		$error = TRUE;
        $txterror = $page->lang('signup_error_age');
	} else {	

		$ageCurrent = getAge($bday, $bmonth, $byear);

		if ($K->SIGNUP_MIN_AGE > 0) {
			if ($ageCurrent < $K->SIGNUP_MIN_AGE) {
				$error = TRUE;
                $txterror = $page->lang('signup_error_agemin');
			}
		}

		if ($K->SIGNUP_MAX_AGE > 0) {
			if ($ageCurrent > $K->SIGNUP_MAX_AGE) {
				$error = TRUE;
                $txterror = $page->lang('signup_error_agemax');
			}
		}

		if (!$error) {
			$tmpday = $bday;
			$tmpmonth = $bmonth;
			if ($bday < 10) $tmpday = '0' + $bday;
			if ($bmonth < 10) $tmpmonth = '0' + $bmonth;
			$cadBirthday = $byear.'-'.$tmpmonth.'-'.$tmpday;
			$cadBirthday = " birthday='".$cadBirthday."', ";
		}
	}

	if (!$error) {

		$response = $db2->fetch_field("SELECT count(iduser) FROM users WHERE user_email='".$email."'");
		if ($response > 0) {
            $error = TRUE;
            $txterror = $page->lang('signup_error_emailused');
		}

    	if (!$error) {
            $response = $db2->fetch_field("SELECT count(iduser) FROM users WHERE user_username='".$username."'");
            if ($response > 0) {
                $error = TRUE;
                $txterror = $page->lang('signup_error_usernameused');
            }
        }

    	if (!$error) {
            $response = $db2->fetch_field("SELECT count(idpage) FROM pages WHERE puname='".$username."'");
            if ($response > 0) {
                $error = TRUE;
                $txterror = $page->lang('signup_error_usernameused');
            }
        }

    	if (!$error) {
            $response = $db2->fetch_field("SELECT count(idgroup) FROM groups WHERE guname='".$username."'");
            if ($response > 0) {
                $error = TRUE;
                $txterror = $page->lang('signup_error_usernameused');
            }
        }

        if (!$error) {

            $code = codeUniqueInTable(11, 1, 'users', 'code');

            $ip	= $db2->e(($_SERVER['REMOTE_ADDR']) );

            $cadValidation = '';
            if ($K->SIGNUP_WITH_VALIDATION) {
                $cadValidation = ', active=0, with_validation=1 ';
            }

            $db2->query("INSERT INTO users SET code='".$code."', firstname='".$firstname."', lastname='".$lastname."', user_username='".$username."', user_password='".$password."', user_email='" . $email."',".$cadBirthday." gender=".$gender.$cadValidation.", ipregister='" . $ip . "', registerdate='" . time() . "'");

            if ($K->SIGNUP_WITH_VALIDATION) {

                $page->loadLanguage('email.php');

                $to = $email;
                $subject = $page->lang('email_validation_subject', array('#SITE_TITLE#'=>$K->SITE_TITLE));
                $D->linkvalidation = $K->SITE_URL.'signup/validation/c:'.$code.'/e:'.$email;
                $message = $page->load_template('email/validate_email.php', FALSE);

                $from = $K->MAIL_FROM;
                if ($K->MAIL_WITH_PHPMAILER) {
                    sendMail_PHPMailer($to, $subject, $message);
                } else {
                    sendMail($from, $to, $subject, $message);
                }
                
                $msg_ok = '<div style="margin-top:50px; font-size:14px;">'.$page->lang('signup_msg_sender_email').'</div>';
                $msg_ok .= '<div style="margin:10px 0 70px; font-size:12px;">'.$page->lang('signup_msg_sender_email_spam').'</div>';
                $json_result = array('with_validation'=>1, 'msg_ok'=>$msg_ok);
                echo(json_encode($json_result));
                return;

            } else {

                $r = $user->login($username, $password);
                $json_result = array('with_validation'=>0);
                echo(json_encode($json_result));
                return;

            }

        }  else {
            echo('ERROR:'.$txterror);
            return;
        }

	} else {
        echo('ERROR:'.$txterror);
        return;
    }

?>