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
	
	function validateUrl($url)
	{
		if (!preg_match('/^(http|https):\/\/((([a-z0-9.-]+\.)+[a-z]{2,4})|([0-9\.]{1,4}){4})(\/([a-zA-Z?-?0-9-_\?\:%\.\?\!\=\+\&\/\#\~\;\,\@]+)?)?$/', $url))
			return FALSE;
		else return TRUE;
	}
	
	//function that checks if a URL is or is not "http"
	function fitsUrl($url) 
	{
		
		if( ! preg_match('/^(ftp|http|https):\/\//', $url) ) {
			$url = 'http://'.$url;
		}
	
		if( !validateUrl($url) ) return FALSE;
		
		return $url;
	}
	
	// function that returns the code of a YouTube video
	function getCodeYoutube($url, $lencodyt)
	{
		if( preg_match('/^http(s)?\:\/\/(www\.|de\.)?youtu\.be\/([a-z0-9-\_]{3,})/i', $url, $resultado) ) {
			$codeyt = $resultado[3];
			if (strlen($codeyt)!=$lencodyt) return FALSE;
			else return $codeyt;
		}
		if( preg_match('/^http(s)?\:\/\/(www\.|de\.)?youtube\.com\/watch\?(feature\=player\_embedded&)?v\=([a-z0-9-\_]{3,})/i', $url, $resultado) ) {
			$codeyt = $resultado[4];
			if (strlen($codeyt)!=$lencodyt) return FALSE;
			else return $codeyt;
		}
		return FALSE;
	}

	/*******************************************************************************/

	function emailValid($e) {
		return preg_match('/^[a-zA-Z0-9._%-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,4}$/u', $e);
	}
	
	/*******************************************************************************/
	
	function getCode($numcharacters,$withrepeated) {
		$code = '';
		$characters = "0123456789abcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ";
		$i = 0;
		while ($i < $numcharacters) {
			$char = substr($characters, mt_rand(0, strlen($characters)-1), 1);	
			if ($withrepeated == 1) {
				$code .= $char;
				$i += 1;			
			} else {
				if(!strstr($code,$char)) {
					$code .= $char;
					$i += 1;
				}
			}
		}
		return $code;
	}


	/*******************************************************************************/

	function verifyCode($code, $table, $field) {			
		$db2 = $GLOBALS["db2"];
		
		$r = $db2->query("SELECT ".$field." FROM ".$table." WHERE ".$field."='".$code."' LIMIT 1");
		$numusers = $db2->num_rows($r);
	
		if ($numusers==0) return FALSE;
		else return TRUE;			
	}

	/*******************************************************************************/
	
	function codeUniqueInTable($numcharacters, $withrepeated, $table, $field) {
		$code = getCode($numcharacters, $withrepeated);
		while (verifyCode($code, $table, $field)) $code = getCode(11, 1);
		return $code;
	}
    
	//*************************************************************************
	
	function analyzeMessage($txtmsg) {
		global $K;
        global $network;
        global $D;

        $txtmsg = preg_replace('/(https?:\/\/[^\s]+)/', "<a target='_blank' class='link link-blue' href=\"$1\">$1</a>", $txtmsg);
        
        $regex_mentions = '/@([A-Za-z0-9_]+)/i';
        preg_match_all($regex_mentions, $txtmsg, $matches);
        foreach ($matches[1] as $match) {
            $match_id = $network->getUserByUsername($match, TRUE);
            if ($match_id) {
                $match_search  = '@' . $match;
                $match_replace = '<a href="'.$K->SITE_URL.$match.'" class="link link-blue" '.($D->_IS_LOGGED ? 'rel="phantom-max" target="dashboard-main-area"' : '') . '>' . $match . '</a>';
                $txtmsg = str_replace($match_search, $match_replace, $txtmsg);
            }
        }

        $txt_plain = htmlentities($txtmsg, ENT_QUOTES, 'utf-8');

        $pattern = '/(\s|^)((#|\x{ff03}){1}([0-9_\p{L}&;]*[_\p{L}&;][0-9_\p{L}&;]*))/u';
        $txt_plain = preg_replace_callback($pattern, function($matches) {
            global $K, $D;
            return $matches[1].'<a href="'.$K->SITE_URL.'hashtag/'.$matches[4].'" class="link link-blue" '.($D->_IS_LOGGED ? 'rel="phantom-max" target="dashboard-main-area"' : '') . '>'.$matches[2].'</a>';                
        }, $txt_plain);

        $txtmsg = htmlspecialchars_decode($txt_plain, ENT_QUOTES);

		require("smiles.php");
	
		foreach($smiles as $smiles => $img) {
			$txtmsg = str_replace($smiles, '<img src="'.getImageTheme('smiles/'.$img).'" height="16" width="16" />', $txtmsg);
		}
        
        return $txtmsg;

	}

	function analyzeMessageChat($txtmsg) {

		global $K;
        global $network;
        global $D;
        
        $regex_mentions = '/@([A-Za-z0-9_]+)/i';
        preg_match_all($regex_mentions, $txtmsg, $matches);
        foreach ($matches[1] as $match) {
            $match_id = $network->getUserByUsername($match, TRUE);
            if ($match_id) {
                $match_search  = '@' . $match;
                $match_replace = '<a href="'.$K->SITE_URL.$match.'" class="link link-blue" '.($D->_IS_LOGGED ? 'rel="phantom-max" target="dashboard-main-area"' : '') . '>' . $match . '</a>';
                $txtmsg = str_replace($match_search, $match_replace, $txtmsg);
            }
        }
                         
        $regex_hashtag = '/\#([\pL0-9_]{1,50})/iu';
        preg_match_all($regex_hashtag, $txtmsg, $matches);
        foreach ($matches[1] as $match) {
            if (!is_numeric($match)) {
                $match_search = '#' . $match;
                $match_replace = '<a href="'.$K->SITE_URL.'hashtag/'.$match.'" class="link link-blue" '.($D->_IS_LOGGED ? 'rel="phantom-max" target="dashboard-main-area"' : '') . '>#' . $match . '</a>';
                if (mb_detect_encoding($match_search, 'ASCII', true)) {
                    $txtmsg = preg_replace("/$match_search\b/i", $match_replace,  $txtmsg);
                } else {
                    $txtmsg = str_replace($match_search, $match_replace, $txtmsg);
                }
            }
        }
        
		require("smiles.php");
	
		foreach($smiles as $smiles => $img) {
			$txtmsg = str_replace($smiles, '<img src="'.getImageTheme('smiles/'.$img).'" height="16" width="16" />', $txtmsg);
		}
        
        return $txtmsg;

	}
    
	//*************************************************************************
	
	function str_cut($str, $mx) {
        return strlen($str)>$mx ? substr($str, 0, $mx-1).'...' : $str;
	}
	
	//*************************************************************************

	function clearnl($msg) {
		return preg_replace("/(\r?\n){2,}/", "\n\n", $msg);
	}
	
	//*************************************************************************
    
    function setFormatDateForDB($thedate, $theformat) {
    
        $array_date = explode('/', $thedate);
        
        $array_format = explode('/', $theformat);
        
        $count = 0;
        foreach($array_format as $oneblock) {
            if ($oneblock == 'yyyy') $yy = $array_date[$count];
            if ($oneblock == 'mm') $mm = $array_date[$count];
            if ($oneblock == 'dd') $dd = $array_date[$count];
            $count++;
        }
        
        return $mm.'/'.$dd.'/'.$yy;
    }
    
    function setFormatTheDate($theformat) {

        $array_format = explode('/', $theformat);

        $cad = '';
        foreach($array_format as $oneblock) {
            if ($oneblock == 'yyyy') $cade = 'Y';
            if ($oneblock == 'mm') $cade = 'm';
            if ($oneblock == 'dd') $cade = 'd';
            $cad .= $cade . '/';
        }
        $cad = trim($cad, '/');
        return $cad;
    }

    //*************************************************************************
	
 	function sendMail( $from, $to, $subject, $body ) {
		$headers = '';
		$headers .= "From: $from\n";
		$headers .= "Return-Path: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= "Date: " . date('r', time()) . "\n";
	
		mail( $to, $subject , $body, $headers );
	}
	
    function sendMail_PHPMailer($target, $subject, $message, $with_include = TRUE, $bg='') {
        date_default_timezone_set('UTC');
        if ($with_include) {
            require_once 'PHPMailer/class.smtp.php';
            require_once 'PHPMailer/class.phpmailer.php';
        }
        global $K;
        $mymail = new PHPMailer();
        $mybody = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Email from '.$K->MAIL_FROMNAME.'</title>
        </head><body '.$bg.'>';
        $mybody .= $message;
        $mybody .= '</body></html>';
        
        $mymail->Mailer = 'smtp';
        $mymail->SMTPAuth = TRUE;
        $mymail->SMTPSecure = "ssl";
        
        if ($K->MAIL_SSL) { // port 465
            $mymail->SMTPSecure = 'ssl';
        } else {
            $mymail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mymail->SMTPSecure = 'tls';
        }
        
        $mymail->Port = $K->MAIL_PORT;
    
        $mymail->Host = $K->MAIL_HOST;
        $mymail->Username = $K->MAIL_USERNAME;
        $mymail->Password = $K->MAIL_PASSWORD;
        $mymail->From = $K->MAIL_FROM;
        $mymail->FromName = $K->MAIL_FROMNAME;
        $mymail->AddAddress($target);
        $mymail->Subject = $subject;
    
        $mymail->Body = $mybody;
        
        $mymail->isHTML(true); 
            
        $exito = $mymail->Send();
        if(!$exito) return FALSE;//$mymail->ErrorInfo;
        else return TRUE;
    }


	function validateUsername($username) { 
    	return preg_match("/^[A-Za-z0-9][A-Za-z0-9_]{5,14}$/", $username);
	}
    
    function validateUsernamePageOrGroup($username) {
        return preg_match("/^[A-Za-z0-9][A-Za-z0-9_]{5,20}$/", $username);
    }
	

	/*******************************************************************************/

	function nameInConflict($username) {
		global $K;
		$error = FALSE;
		if (!$error && file_exists($K->INCPATH.'controllers/'.strtolower($username).'.php')) $error = TRUE;
		if (!$error && file_exists($K->INCPATH.'../'.strtolower($username))) $error = TRUE;
		return $error;
	}

	/*******************************************************************************/

    function getImageTheme($file_image) {
        global $K;
        $the_url = $K->SITE_URL;
        $url_theme = $the_url . 'themes/' . $K->THEME . '/';
        return $url_theme .'imgs/'. $file_image;
    }
    
	/*******************************************************************************/
    
	function strJS($text) {
		$text = addslashes($text);	
		$text = html_entity_decode($text);
		return $text;	
	}
    
	/*******************************************************************************/
	
	function getAge($bd, $bm, $by) { 
		// current date
		$td = date('j');
		$tm = date('n');
		$ty = date('Y');
		 
		if (($bm == $tm) && ($bd > $td)) $ty = $ty-1;
	
		if ($bm > $tm) $ty = $ty-1;
		 
		return ($ty-$by);
	}

	/*******************************************************************************/
    
    function jsonDecode($string, $toarray = false) {
        if(get_magic_quotes_gpc()) $string = stripslashes($string);
        if ($toarray) return json_decode($string, true);
        else return json_decode($string);
    }
    
	/*******************************************************************************/

    function isValidExtension($ext, $string_extensions) {
        $ext_allow = explode(',', $string_extensions);
        foreach ($ext_allow as $key => $value) {
            $ext_allow[$key] = trim(strtolower($value));
        }
        if(is_array($ext_allow) && in_array(strtolower($ext), $ext_allow)) return true;
        return false;
    }    

	/*******************************************************************************/

	function getStaticsFoot() {			
		$db2 = $GLOBALS["db2"];
		$statics = $db2->fetch_all("SELECT url, title FROM statics WHERE show_in_foot=1 ORDER BY title ASC");
	    return $statics;
	}

	/*******************************************************************************/
    
    function getAreaEmoticons($targetclick) {
		global $K;
		$smiles = array(':-)' => 'regular.png', ':-D' => 'teeth.png', ':-O' => 'omg.png', ':-P' => 'tongue.png', ';-)' => 'wink.png', ':((' => 'cry.png', ':-(' => 'sad.png', ':-|' => 'what.png', ':-$' => 'red.png', '(H)' => 'shades.png', ':-@' => 'angry.png', '(A)' => 'angel.png', '(6)' => 'devil.png', '8o|' => 'growl.png', '8-|' => 'nerd.png', '^o)' => 'sarcastic.png', '+o(' => 'sick.png', '*-)' => 'pensive.png', '8-)' => 'eyesrolled.png', '|-)' => 'sleepy.png', '(C)' => 'coffee.png', '(Y)' => 'thumbs_up.png', '(N)' => 'thumbs_down.png', '(B)' => 'beer_mug.png', '(D)' => 'martini.png', '({)' => 'guy_hug.png', '(})' => 'girl_hug.png', '(^)' => 'cake.png', '(L)' => 'heart.png', '(U)' => 'broken_heart.png', '(K)' => 'kiss.png', '(G)' => 'present.png', '(F)' => 'rose.png', '(S)' => 'moon.png', '(*)' => 'star.png', '(E)' => 'envelope.png', '(pl)' => 'dish.png', '(pi)' => 'pizza.png', '(so)' => 'ball.png', '(mo)' => 'money.png');

		$html_smiles = '';
		foreach($smiles as $smiles => $img) {
			$html_smiles .= '<span class="onesmile"><img onclick="insertSmiles(\''.$targetclick.'\', \''.$smiles.'\');" class="hand" title="'.$smiles.'" src="'.getImageTheme('smiles/'.$img).'" height="16" width="16" style="padding:4px;" /></span>';
		}
		return $html_smiles;
        
    }
    
    function getAreaStickers($codepost, $namefunction) {
        $cad_stickers = '';
        for ($ii = 0; $ii <= 44; $ii++) {
            $thefile = $ii;
            if ($ii <10) $thefile = '0'.$ii;
            $cad_stickers .= '<div class="onesticker"><img onclick="'.$namefunction.'(\''.$codepost.'\', \''.$thefile.'\');" class="hand" src="'.getImageTheme('stickers/min/'.$thefile.'').'.png" height="62" width="62"/></div>';
        }
        $cad_stickers .= '<div class="clear"></div>';
        return $cad_stickers;
    }
    
    
	/*******************************************************************************/
    
    function getCharsSpecials() {
        $charsEspecials = array(
            '?' => 'S', '?' => 's', '??' => 'Dj','?' => 'Z', '?' => 'z', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A',
            '??' => 'A', '??' => 'A', '??' => 'C', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'I', '??' => 'I', '??' => 'I',
            '??' => 'I', '??' => 'N', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'U', '??' => 'U',
            '??' => 'U', '??' => 'U', '??' => 'Y', '??' => 'B', '??' => 'Ss','??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a',
            '??' => 'a', '??' => 'a', '??' => 'c', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'i', '??' => 'i', '??' => 'i',
            '??' => 'i', '??' => 'o', '??' => 'n', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'u',
            '??' => 'u', '??' => 'u', '??' => 'y', '??' => 'y', '??' => 'b', '??' => 'y', '??' => 'f', ',' => '',  ':' => '', '.' => '',
            ';' => '',  '_' => '',  '<' => '',  '>' => '',  '\\'=> '',  '??' => '',  '??' => '',  '!' => '',  '|' => '',  '"' => '',
            '@' => '',  '??' => '',  '#' => '',  '$' => '',  '~' => '',  '%' => '',  '???' => '',  '&' => '',  '??' => '',  '/' => '',
            '(' => '',  ')' => '',  '=' => '',  '?' => '',  '\''=> '',  '??' => '',  '??' => '',  '`' => '',  '+' => '',  '??' => '',
            '??' => '',  '^' => '',  '*' => '',  '??' => '',  '??' => '',  '[' => '',  ']' => '',  '{' => '',  '}' => '',  '? '=> '-',
            
            
            // Latin symbols
            '??' => '(c)',
            // Greek
            '??' => 'A', '??' => 'B', '??' => 'G', '??' => 'D', '??' => 'E', '??' => 'Z', '??' => 'H', '??' => '8',
            '??' => 'I', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => '3', '??' => 'O', '??' => 'P',
            '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'Y', '??' => 'F', '??' => 'X', '??' => 'PS', '??' => 'W',
            '??' => 'A', '??' => 'E', '??' => 'I', '??' => 'O', '??' => 'Y', '??' => 'H', '??' => 'W', '??' => 'I',
            '??' => 'Y',
            '??' => 'a', '??' => 'b', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'z', '??' => 'h', '??' => '8',
            '??' => 'i', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => '3', '??' => 'o', '??' => 'p',
            '??' => 'r', '??' => 's', '??' => 't', '??' => 'y', '??' => 'f', '??' => 'x', '??' => 'ps', '??' => 'w',
            '??' => 'a', '??' => 'e', '??' => 'i', '??' => 'o', '??' => 'y', '??' => 'h', '??' => 'w', '??' => 's',
            '??' => 'i', '??' => 'y', '??' => 'y', '??' => 'i',
            // Turkish
            '??' => 'S', '??' => 'I', '??' => 'C', '??' => 'U', '??' => 'O', '??' => 'G',
            '??' => 's', '??' => 'i', '??' => 'c', '??' => 'u', '??' => 'o', '??' => 'g',
            // Russian
            '??' => 'A', '??' => 'B', '??' => 'V', '??' => 'G', '??' => 'D', '??' => 'E', '??' => 'Yo', '??' => 'Zh',
            '??' => 'Z', '??' => 'I', '??' => 'J', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => 'O',
            '??' => 'P', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U', '??' => 'F', '??' => 'H', '??' => 'C',
            '??' => 'Ch', '??' => 'Sh', '??' => 'Sh', '??' => '', '??' => 'Y', '??' => '', '??' => 'E', '??' => 'Yu',
            '??' => 'Ya',
            '??' => 'a', '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'yo', '??' => 'zh',
            '??' => 'z', '??' => 'i', '??' => 'j', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'o',
            '??' => 'p', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c',
            '??' => 'ch', '??' => 'sh', '??' => 'sh', '??' => '', '??' => 'y', '??' => '', '??' => 'e', '??' => 'yu',
            '??' => 'ya',
            // Ukrainian
            '??' => 'Ye', '??' => 'I', '??' => 'Yi', '??' => 'G',
            '??' => 'ye', '??' => 'i', '??' => 'yi', '??' => 'g',
            // Czech
            '??' => 'C', '??' => 'D', '??' => 'E', '??' => 'N', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U',
            '??' => 'Z',
            '??' => 'c', '??' => 'd', '??' => 'e', '??' => 'n', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u',
            '??' => 'z',
            // Polish
            '??' => 'A', '??' => 'C', '??' => 'e', '??' => 'L', '??' => 'N', '??' => 'o', '??' => 'S', '??' => 'Z',
            '??' => 'Z',
            '??' => 'a', '??' => 'c', '??' => 'e', '??' => 'l', '??' => 'n', '??' => 'o', '??' => 's', '??' => 'z',
            '??' => 'z',
            // Latvian
            '??' => 'A', '??' => 'C', '??' => 'E', '??' => 'G', '??' => 'i', '??' => 'k', '??' => 'L', '??' => 'N',
            '??' => 'S', '??' => 'u', '??' => 'Z',
            '??' => 'a', '??' => 'c', '??' => 'e', '??' => 'g', '??' => 'i', '??' => 'k', '??' => 'l', '??' => 'n',
            '??' => 's', '??' => 'u', '??' => 'z',
            
        );
        return $charsEspecials;
    }
    
    function sanitizeString($stringToClean) {
        $charsEspecials = getCharsSpecials();
        $stringToClean = str_replace('&', '-and-', $stringToClean);
        $stringToClean = str_replace('.', '', $stringToClean);
        $stringToClean = strtolower(strtr($stringToClean, $charsEspecials));
        $stringToClean = str_replace(' ', '-', $stringToClean);
        $stringToClean = str_replace('--', '-', $stringToClean);
        $stringToClean = str_replace('--', '-', $stringToClean);
        $stringToClean = preg_replace('/[^\w\d_ -]/si', '', $stringToClean);
        return trim($stringToClean);
    }
    
    function sanitizeNameFile($thenamefile) {
        $charsEspecials = getCharsSpecials();
        unset($charsEspecials['.']);
        unset($charsEspecials['_']);
        $thenamefile = str_replace('&', '-and-', $thenamefile);
        $thenamefile = strtolower(strtr($thenamefile, $charsEspecials));
        $thenamefile = str_replace(' ', '-', $thenamefile);
        $thenamefile = str_replace('--', '-', $thenamefile);
        $thenamefile = str_replace('--', '-', $thenamefile);
        return trim($thenamefile);
    }
    
	function decodeSlug($text) {
		$text	= str_ireplace(":"," ", $text);	
		$text	= str_ireplace("+"," ", $text);	
		$text	= str_ireplace("-"," ", $text);	
		$text	= str_ireplace("/"," - ", $text);	
		$text	= str_ireplace("%20"," ", $text);	
		$text	= urldecode($text);	
		return $text;
	}
    
	function cutStringCenter($text, $numchars) {
        $middle = round($numchars/2);
        if (strlen($text) > $numchars) {
            $sideleft = substr($text, 0, $middle - 2);
            $sideright = substr($text, -($middle-2), $middle - 2);
            $text = $sideleft . '...' . $sideright;
        }
        return $text;
    }
    
    
    
    function infoSocial($thevendor, $infosocial){
        $thename = $infosocial->firstName;
        if ($thevendor == 'Google') {
            $pre_email = 'go_';
            $thedomain = 'google.com';
        } else if ($thevendor == 'Facebook') {
            $pre_email = 'fa_';
            $thedomain = 'facebook.com';

            $thegender = 1;
            if (!empty($infosocial->gender)) {
                if ($infosocial->gender == 'male') {
                    $thegender = 1;
                } else if ($infosocial->gender == 'female') {
                    $thegender = 2;
                }
            }
            
            $firstname = $infosocial->firstName;
            $lastname = $infosocial->lastName;
            $displayname = $infosocial->displayName;

        } else if ($thevendor == 'Twitter') {
            $pre_email = 'tw_';
            $thedomain = 'twitter.com';
        } else if ($thevendor == 'LinkedIn') {
            $pre_email = 'li_';
            $thedomain = 'linkedin.com';
        } else if ($thevendor == 'Vkontakte') {
            $pre_email = 'vk_';
            $thedomain = 'vk.com';
        } else if ($thevendor == 'Instagram') {
            $pre_email = 'in_';
            $thedomain = 'instagram.com';
            $thename = $infosocial->displayName;
        }

        $theemail = $pre_email . $infosocial->identifier .'@'. $thedomain;
        if (!empty($infosocial->email)) $theemail = $infosocial->email;


        $theinfo = array();
        $theinfo['id'] = $infosocial->identifier;
        $theinfo['displayname'] = $displayname;
        $theinfo['email'] = $theemail;
        $theinfo['gender'] = $thegender;
        $theinfo['firstname'] = $firstname;
        $theinfo['lastname'] = $lastname;

        return $theinfo;
    }


    function cutLineJump($thestring) {
        $char_search = array(chr(13).chr(10), "\r\n", "\n", "\r");
        $char_replace = array("", "", "", "");
        return str_ireplace($char_search, $char_replace, $thestring);
    }
    
	function deleteFolder($folder) {
		foreach(glob($folder . "/*") as $files_folder) {
			if (is_dir($files_folder)) {
				deleteFolder($files_folder);
			} else {
				@unlink($files_folder);
			}
		} 
		rmdir($folder);
	}
    
    /*******************************************************************************/
    
    function myCopy($source, $dest) {
        $res = @copy($source, $dest);
        if ($res) {
            chmod($dest, 0777);
            return TRUE;
        }
        
        if( function_exists('curl_init') && preg_match('/^(http|https|ftp)\:\/\//u', $source) ) {
            global $K;
            $dst = fopen($dest, 'w');
            if( ! $dst ) {
                return FALSE;
            }
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_FILE => $dst,
                CURLOPT_HEADER => FALSE,
                CURLOPT_URL => $source,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_MAXREDIRS => 5,
                CURLOPT_REFERER => $K->SITE_URL,
                CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1',
            ));
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $res = curl_exec($ch);
            fclose($dst);
            if (!$res) {
                curl_close($ch);
                return FALSE;
            }
            if (curl_errno($ch)) {
                curl_close($ch);
                return FALSE;
            }
            curl_close($ch);
            chmod($dest, 0777);
            return TRUE;
        }
        return FALSE;
    }
    
    function copyImageFromUrl($url_source, $folder_target, $name_target) {
        if ( preg_match('/^(http|https|ftp)\:\/\//u', $url_source) ) {
            $tmp = $folder_target.$name_target;
            $res = myCopy($url_source, $tmp);
            return $name_target;
        }
        return FALSE;
    }
    
    /*******************************************************************************/
    
    function objectToArray($data) {
        if (is_array($data) || is_object($data)) {
            $output = array();
            foreach ($data as $key => $value) {
                $output[$key] = objectToArray($value);
            }
            $data = $output;
        }
        return $data;
    }
    
    function httpCurl($Link, $headersOnly = false) {
        $return = null;
        if (is_string($Link)) {
            // Start process
            $gZipHeader = false;
            // Default UserAgent string
            $UA =
                'Mozilla/5.0 (Windows NT 6.3; WOW64) ' .
                'AppleWebKit/537.36 (KHTML, like Gecko) ' .
                'Chrome/40.0.2214.115 Safari/537.36';
            // Prepare headers for HTTP request
            $Headers = array(
                'Referer' => $Link,
                'Accept-Language' => 'en-US,en;q=0.8,te;q=0.6',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'User-Agent' => $UA,
            );
            if (function_exists('gzencode') && function_exists('gzdecode')) {
                $gZipHeader = true;
                $Headers['Accept-Encoding'] = 'gzip';
            }
            $Headers['Connection'] = 'Close';
            // Pack all headers
            $HeadPack = '';
            foreach ($Headers as $K => $V) {
                $HeadPack .= "{$K}: {$V}\r\n";
            }
            // Create a stream
            $options = array(
                'http' => array(
                    'method' => 'GET',
                    'header' => $HeadPack,
                    'timeout' => 10,
                    'max_redirects' => 10,
                    'ignore_errors' => true,
                    'follow_location' => 1,
                    'protocol_version' => '1.0',
                )
            );
    
            // Pack options
            $context = stream_context_create($options);
            // Open HTTP connection
            if (is_resource($http = fopen($Link, 'r', null, $context))) {
                // Get response headers
                list($meta, $headers) = array(stream_get_meta_data($http), array());
                if (is_array($meta) && isset($meta['wrapper_data']) && is_array($meta['wrapper_data'])) {
                    $headers = $meta['wrapper_data'];
                    if (isset($headers['headers']) && is_array($headers['headers'])) {
                        $headers = $headers['headers'];
                    }
                }
                // Get headers from CURL
                if (count($headers) == 0 && function_exists('curl_version')) {
                    // Prepare CURL connection
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $Link);
                    curl_setopt($curl, CURLOPT_HEADER, true);
                    curl_setopt($curl, CURLOPT_NOBODY, true);
                    // Enable gZip
                    if ($gZipHeader) {
                        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
                    }
    
                    // Set content range
                    if (isset($_SERVER['HTTP_RANGE'])) {
                        curl_setopt($curl, CURLOPT_RANGE, str_replace('bytes=', '', $_SERVER['HTTP_RANGE']));
                    }
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $Headers);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                    // Get headers
                    $headers = explode("\n", str_replace("\r\n", "\n", curl_exec($curl)));
                }
                if ($headersOnly) {
                    // Get headers only
                    $return = $headers;
                } else {
                    // Download content
                    $content = '';
                    while (!feof($http)) {
                        $content .= fread($http, 1024 * 8);
                    }
                    // Decode gZiped content
                    $originalContent = $content;
                    $content = $gZipHeader ? @gzdecode($content) : null;
                    $content = is_string($content) ? $content : $originalContent;
                    // Check content
                    if (strlen($content) >= 1) {
                        $return = $content;
                    }
                }
                // Close HTTP connection
                fclose($http);
            }
        }
        return $return;
    }
    
    /*******************************************************************************/

    function getImageOG($theimage) {
        global $K;
        $root = $K->STORAGE_URL_ARTICLES.'min1/';
        $path = $K->STORAGE_DIR_ARTICLES.'min1/';
        
        $extension = explode('.', $theimage);
        
        $img_og = $extension[0].'-og.'.$extension[1];
        
        if (file_exists($path.$img_og)) return $root.$img_og;
        else return $root.$theimage;
    }

	/*******************************************************************************/
    
    function getImageMisc($file_image) {
        global $K;
        return $K->STORAGE_URL_MISC.$file_image;
    }
    

    /*******************************************************************************/
    
    function getTokenSocialFB($appId, $appSecret, $redirectUrl, $thecode) {
        
        $theurl = 'https://graph.facebook.com/oauth/access_token?client_id=';
        $theurl .= $appId;
        $theurl .= '&redirect_uri=';
        $theurl .= urlencode($redirectUrl);
        $theurl .= '&client_secret=';
        $theurl .= $appSecret;
        $theurl .= '&code=';
        $theurl .= $thecode;
        
        $theresponse = null;
        try {
            $thecontent = httpCurl($theurl);
            $theresponse = json_decode($thecontent, true);
        } catch(Exception $e) {
        }

        return $theresponse;
    }

	function getInfoUserFB($accessToken) {

        $theurl = 'https://graph.facebook.com/me?fields=id,email,first_name,picture,gender,last_name,link,locale,name,timezone,updated_time,verified';
        $theurl .= '&access_token=';
        $theurl .= $accessToken;

        $theresponse = null;
        try {
            $thecontent = httpCurl($theurl);
            $theresponse = json_decode($thecontent);
        } catch(Exception $e) {
        }
		
		if (isset($theresponse->name)) {
			return $theresponse;
		}
		return null;
	}

    /*******************************************************************************/    

?>