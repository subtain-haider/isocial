<?php
    
    function msgbox($title, $text, $closebtn=TRUE, $incss='')
    {
        $div_id	= 'tmpid'.rand(0,99999);
        $html	= '
                <div class="alert" style="'.$incss.'" id="'.$div_id.'">
                    <div class="alerttop"><div class="alerttop2"></div></div>
                    <div class="alertcontent">
                        <div class="alertcontent2">';
        if( $closebtn ) {
            $html	.= '
                            <a href="javascript:;" class="alertclose" onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';this.blur();"></a>
                            <script type="text/javascript">
                                msgbox_to_close.'.$div_id.'	= true;
                            </script>';
        }
        $html	.= '
                            <strong>'.$title.'</strong>
                            '.$text.'
                        </div>
                    </div>
                    <div class="alertbottom"><div class="alertbottom2"></div></div>
                </div>';
        return $html;
    }
        
    function errorbox($title, $text, $closebtn=TRUE, $incss='')
    {
        $div_id	= 'tmpid'.rand(0,99999);
        $html	= '
                <div class="alert red" style="'.$incss.'" id="'.$div_id.'">
                    <div class="alerttop"><div class="alerttop2"></div></div>
                    <div class="alertcontent">
                        <div class="alertcontent2">';
        if( $closebtn ) {
            $html	.= '
                            <a href="javascript:;" class="alertclose" onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';this.blur();"></a>
                            <script type="text/javascript">
                                msgbox_to_close.'.$div_id.'	= true;
                            </script>';
        }
        $html	.= '
                            <strong>'.$title.'</strong>
                            '.$text.'
                        </div>
                    </div>
                    <div class="alertbottom"><div class="alertbottom2"></div></div>
                </div>';
        return $html;
    }
    
    function str_cut($str, $mx)
    {
        return mb_strlen($str)>$mx ? mb_substr($str, 0, $mx-1).'..' : $str;
    }
    
    function nowrap($string)
    {
        return str_replace(' ', '&nbsp;', $string);
    }
    
    function br2nl($string)
    {
        return str_replace(array('<br />', '<br/>', '<br>'), "\r\n", $string);
    }
    
    function strip_url($url)
    {
        $url	= preg_replace('/^(http|https):\/\/(www\.)?/u', '', trim($url));
        $url	= preg_replace('/\/$/u', '', $url);
        return trim($url);
    }
    
    function my_ucwords($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE);
    }
    
    function my_ucfirst($str)
    {
        if( function_exists('mb_strtoupper') ) {
            return mb_strtoupper(mb_substr($str,0,1)).mb_substr($str,1);
        }
        else return $str;
    }
    
    function is_valid_email($email)
    {
        return preg_match('/^[a-zA-Z0-9._%-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,4}$/u', $email);
    }
    
    function is_valid_username($uname, $check_scripts=TRUE)
    {
        if( FALSE == preg_match('/^[a-zA-Z0-9\-]{4,20}$/', $uname) ) {
            return FALSE;
        }
        if( $check_scripts ) {
            if( file_exists(INCPATH.'../../system/controllers/'.strtolower($uname).'.php') ) {
                return FALSE;
            }
            if( file_exists(INCPATH.'../../'.strtolower($uname)) ) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function config_replace_variable($source, $variable, $value, $keep_quots=TRUE)
    {
        $pattern	= '/('.preg_quote($variable).'\s*\=\s*)\'([^\\\']*)(\'\s*)/su';
        if( $keep_quots ) {
            return preg_replace($pattern, '${1}\''.$value.'\'${2}', $source);
        }
        return preg_replace($pattern, '${1}'.$value.'${2}', $source);
    }
    
    function loadOldPreconfig()
    {
        $file = INCPATH.'../../system/preconfig.php';
        if (file_exists($file)) {
			$K = new stdClass;
			$K->INCPATH = realpath(INCPATH.'../../system/').'/';
			include($file);			
            return $K;
        }

        return new stdClass;
    }
    
    function directory_tree_delete($node)
    {
        $node	= realpath($node);
        if( ! $node ) {
            return;
        }
        if( ! is_dir($node) ) {
            @unlink($node);
            return;
        }
        $dir	= opendir($node);
        while($file = readdir($dir)) {
            if( $file == '.' || $file == '..' ) {
                continue;
            }
            directory_tree_delete($node.'/'.$file);
        }
        closedir($dir);
        @rmdir($node);
        return;
    }
    
    function myext() {
        $myext	= 'mysql';
        if( function_exists('mysqli_connect') ) {
            $myext	= 'mysqli';
        }
        global $s;
        if( isset($s['MYSQL_MYEXT']) ) {
            if( $s['MYSQL_MYEXT'] == 'mysqli' && function_exists('mysqli_connect') ) {
                $myext	= 'mysqli';
            }
            elseif( $s['MYSQL_MYEXT'] == 'mysql' && function_exists('mysql_connect') ) {
                $myext	= 'mysql';
            }
        }
        return $myext;
    }
    function my_mysql_connect($host, $user, $pass) {
        if( myext() == 'mysqli' ) {
            return @mysqli_connect($host, $user, $pass);
        }
        else {
            return @mysql_connect($host, $user, $pass);
        }
    }
    function my_mysql_select_db($dbname, $conn=FALSE) {
        if( myext() == 'mysqli' ) {
            return @mysqli_select_db($conn, $dbname);
        }
        else {
            return $conn ? @mysql_select_db($dbname, $conn) : @mysql_select_db($dbname);
        }
    }
    function my_mysql_query($query, $conn=FALSE)
    {
        if( myext() == 'mysqli' ) {
            return @mysqli_query($conn, $query);
        }
        else {
            return $conn ? @mysql_query($query, $conn) : @mysql_query($query);
        }
    }
    function my_mysql_num_rows($res) {
        if( myext() == 'mysqli' ) {
            return @mysqli_num_rows($res);
        }
        else {
            return @mysql_num_rows($res);
        }
    }
    function my_mysql_fetch_row($res) {
        if( myext() == 'mysqli' ) {
            return @mysqli_fetch_row($res);
        }
        else {
            return @mysql_fetch_row($res);
        }
    }
    function my_mysql_real_escape_string($str, $conn=FALSE) {
        if( myext() == 'mysqli' ) {
            return @mysqli_real_escape_string($conn, $str);
        }
        else {
            return $conn ? @mysql_real_escape_string($str, $conn) : @mysql_real_escape_string($str);
        }
    }
    
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

    function is_ssl() {
        if (isset( $_SERVER['HTTPS'])) {
            if ('on' == strtolower($_SERVER['HTTPS'])) {
                return true;
            }
     
            if ('1' == $_SERVER['HTTPS']) {
                return true;
            }
        } elseif (isset( $_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        return false;
    }
    
    function apiCallMCode($url){
        $headers = array("Content-type: application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');  
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $st = curl_exec($ch); 
        return $st;
    }
    
    function site_url($no_cad_http = FALSE) {

        $cad_http = 'http://';
        if (is_ssl()) $cad_http = 'https://';
        
        $site_url = $cad_http.trim($_SERVER['HTTP_HOST']);
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, 'install');
        if (FALSE !== $pos ) {
            $uri = substr($uri, 0, $pos);
            $uri = trim($uri, '/');
            $site_url .= '/'.$uri;
            $site_url = trim($site_url, '/');
        }

        $site_url = rtrim($site_url, '/');
        if (!isset($site_url)) {
            $site_url = '';
        }
        
        if ($no_cad_http) {
            $site_url = str_replace($cad_http, '', $site_url);
        }
        
        return $site_url;

    }

    
?>