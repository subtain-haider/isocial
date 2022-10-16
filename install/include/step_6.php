<?php

    ini_set('memory_limit', -1);
    
    $PAGE_TITLE = 'Installation completed!';
    
    $s = &$_SESSION['INSTALL_DATA'];
    
    $error = FALSE;
    
    if (isset($s['INSTALLED']) && $s['INSTALLED']) {
        $configfile = INCPATH.'../../system/preconfig.php';
        $is_ok = FALSE;
        if (file_exists($configfile)) {
            $K = new stdClass;
            $K->INCPATH = realpath(INCPATH.'../../system/').'/';
            include($configfile);
            if ($K->INSTALLED == TRUE) {
                $is_ok = TRUE;
            }
        }
        if (!$is_ok) {
            unset($s['INSTALLED']);
            $_SESSION['INSTALL_STEP'] = 1;
            header('Location: ?reset');
            exit;
        }
    }
    
    $error = FALSE;
    $errmsg = '0';
    
    if (!isset($s['INSTALLED']) || !$s['INSTALLED']) {

        $s['SITE_URL'] = rtrim($s['SITE_URL'],'/').'/';
        
        if (!$error) {
            $rwbase = '/';
            $tmp = preg_replace('/^http(s)?\:\/\//', '', $s['SITE_URL']);
            $tmp = trim($tmp, '/');
            $pos = strpos($tmp, '/');
            if (FALSE !== $pos) {
                $tmp = substr($tmp, $pos);
                $tmp = '/'.trim($tmp,'/').'/';
                $rwbase = $tmp;
            }
            $htaccess = '<IfModule mod_rewrite.c>'."\n";
            $htaccess .= ' RewriteEngine On'."\n";

            if (!$s['IS_SUBDOMAIN'] && (strpos($s['SITE_URL'], 'http://localhost') === FALSE && strpos($s['SITE_URL'], 'https://localhost') === FALSE)) {
                $htaccess .= ' RewriteCond %{HTTP_HOST} !^$'."\n";
                $htaccess .= ' RewriteCond %{HTTP_HOST} !^www\. [NC]'."\n";
                $htaccess .= ' RewriteCond %{HTTPS}s ^on(s)|'."\n";
                $htaccess .= ' RewriteRule ^ http%1://www.%{HTTP_HOST}%{REQUEST_URI} [R=301,L]'."\n";
                
                if (strpos($s['SITE_URL'], 'https://www.') === FALSE) $s['SITE_URL'] = str_replace('https://','https://www.',$s['SITE_URL']);
                if (strpos($s['SITE_URL'], 'http://www.') === FALSE) $s['SITE_URL'] = str_replace('http://','http://www.',$s['SITE_URL']);
                
            } else {
                if (is_ssl()) {
                    $htaccess .= ' RewriteCond %{HTTPS} !=on'."\n";
                    $htaccess .= ' RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]'."\n";
                }
            }

            $htaccess .= ' RewriteBase '.$rwbase."\n";            
            $htaccess .= ' RewriteCond %{REQUEST_FILENAME} !-f'."\n";
            $htaccess .= ' RewriteCond %{REQUEST_FILENAME} !-d'."\n";
            $htaccess .= ' RewriteRule ^(.*)$ index.php?%{QUERY_STRING} [NE,L]'."\n";
            $htaccess .= ' RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]'."\n";
            $htaccess .= '</IfModule>'."\n";
            $filename = INCPATH.'../../.htaccess';
            $res = file_put_contents($filename, $htaccess);
            if (! $res) {
                $error = TRUE;
                $errmsg = 'Could not create .htaccess file (01).';
            }
            @chmod($filename, 0777);
        }
        
        if (!$error) {
            $conn = my_mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
            $dbs = my_mysql_select_db($s['MYSQL_DBNAME'], $conn);
            if (!$conn || !$dbs) {
                $_SESSION['INSTALL_STEP'] = 1;
                header('Location: ?next&r='.rand(0,99999));
            }
            my_mysql_query('SET NAMES utf8', $conn);
            my_mysql_query("SET SESSION sql_mode=''", $conn);
            
            $tables = array();
            $res = my_mysql_query('SHOW TABLES FROM '.$s['MYSQL_DBNAME'], $conn);
            if (my_mysql_num_rows($res)) {
                while($tbl = my_mysql_fetch_row($res)) {
                    $tables[] = $tbl[0];
                }
            }
            
            $thesql = file_put_contents($s['CODEP'], base64_decode(file_get_contents($s['CODEP'])));
            
            if ($thesql) {

                $templine = '';
                $lines = file($s['CODEP']);
                foreach ($lines as $line) {
                   if (substr($line, 0, 2) == '--' || $line == '') continue;

                   $templine .= $line;
                   $query = false;

                   if (substr(trim($line), -1, 1) == ';') {
                      $query = mysqli_query($conn, $templine);
                      $templine = ''; 
                   }
                }
                
                @unlink($s['CODEP']);
                
                if ($s['ADMIN_ID'] == 0) {
                    
                    $res = $res && my_mysql_query("
                        INSERT INTO `users` SET
                        iduser=1,
                        code='".getCode(11,0)."',
                        firstname='".my_mysql_real_escape_string($s['ADMIN_FIRSTNAME'],$conn)."',
                        lastname='".my_mysql_real_escape_string($s['ADMIN_LASTNAME'],$conn)."',
                        user_email='".my_mysql_real_escape_string($s['ADMIN_EMAIL'],$conn)."',
                        user_username='".my_mysql_real_escape_string($s['ADMIN_USER'],$conn)."',
                        user_password='".my_mysql_real_escape_string(hash('md5', $s['ADMIN_PASS'], false),$conn)."',
                        avatar='',
                        avatar_media='',
                        gender=1,
                        birthday='1973-11-16',
                        aboutme='About me ;-)',
                        currentcity='Earth',
                        hometown='Mars',
                        language='en',
                        timezone='America/New_York',
                        num_followers=0,
                        num_following=0,
                        num_albums=0,
                        validated=0,
                        verified=1,
                        active=1,
                        registerdate='".time()."',
                        ipregister='".ip2long($_SERVER['REMOTE_ADDR'])."',
                        previousaccess='".time()."',
                        ippreviousaccess='".ip2long($_SERVER['REMOTE_ADDR'])."',
                        lastaccess='".time()."',
                        iplastaccess='".ip2long($_SERVER['REMOTE_ADDR'])."',
                        is_admin=1,
                        leveladmin=2;
                    ", $conn);
                }
                
            } else {
                $error = TRUE;
                $errmsg = 'An error was generated while generating the Database (02).';
            }

        }

        if (!$error) {
            
            $config = base64_decode(file_get_contents($s['CODEP'].'e'));
            
            if (!$config) {
                $error = TRUE;
                $errmsg = 'Configuration file not found (03).';
            }
            if (!$error) {
                $rndkey = substr(md5(time().rand()),0,5);
                $config = config_replace_variable($config, '$K->VERSION', VERSION);
                $config = config_replace_variable($config, '$K->SITE_URL', $s['SITE_URL']);
                $config = config_replace_variable($config, '$K->DB_HOST', $s['MYSQL_HOST']);
                $config = config_replace_variable($config, '$K->DB_USER', $s['MYSQL_USER']);
                $config = config_replace_variable($config, '$K->DB_PASS', $s['MYSQL_PASS']);
                $config = config_replace_variable($config, '$K->DB_NAME', $s['MYSQL_DBNAME']);
                $config = config_replace_variable($config, '$K->DB_MYEXT', $s['MYSQL_MYEXT']);
                $config = config_replace_variable($config, '$K->INSTALLED', 'TRUE', FALSE);

                $filename = INCPATH.'../../system/preconfig.php';
                $res = file_put_contents($filename, $config);
                
                @unlink($s['CODEP'].'e');
                
                if (!$res) {
                    $error = TRUE;
                    $errmsg = 'Could not create configuration file (04).';
                }
            }
        }

        if (!$error) {
            $url = $s['SITE_URL'];
            $url = rtrim($url,'/').'?installed=ok';
            session_unset();
            session_destroy();
            header('Location: '.$url);
        }
    }

    $PAGE_TITLE = 'Installation Failed!';    

    $html .= errorbox('Installation Failed! ', $errmsg.' Please <a href="?reset" style="font-size:inherit;">try again</a> or contact our team for help.', FALSE, 'margin-top:35px;');

?>