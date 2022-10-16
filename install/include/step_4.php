<?php
    
    $PAGE_TITLE = 'Website Settings';
    
    $s = &$_SESSION['INSTALL_DATA'];
    
    if (isset($_GET['back'])) {
        $_SESSION['INSTALL_STEP'] = 3;
        header('Location: ?next&r='.rand(0,99999));
    }
    
    if (!isset($s['SITE_URL'])) {

        $cad_http = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $cad_http = 'https://';
        
        $s['SITE_URL'] = $cad_http.trim($_SERVER['HTTP_HOST']);
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, 'install');
        if (FALSE !== $pos ) {
            $uri = substr($uri, 0, $pos);
            $uri = trim($uri, '/');
            $s['SITE_URL'] .= '/'.$uri;
            $s['SITE_URL'] = trim($s['SITE_URL'], '/');
        }
    }
    $s['SITE_URL'] = rtrim($s['SITE_URL'], '/');
    if (!isset($s['SITE_TITLE'])) {
        $s['SITE_TITLE'] = '';
    }
    if (!isset($s['IS_SUBDOMAIN'])) {
        $s['IS_SUBDOMAIN'] = 0;
    }
    
    $submit = FALSE;
    $error = FALSE;
    if (isset($_POST['SITE_URL'], $_POST['SITE_TITLE'], $_POST['IS_SUBDOMAIN']) ) {
        $submit = TRUE;
        $_SESSION['INSTALL_STEP'] = 3;
        $s['SITE_URL'] = strtolower(trim($_POST['SITE_URL']));
        $s['SITE_URL'] = trim($s['SITE_URL']);
        $s['SITE_URL'] = rtrim($s['SITE_URL'], '/');
        $s['SITE_URL'] = trim($s['SITE_URL']);
        $s['SITE_TITLE'] = trim($_POST['SITE_TITLE']);
        $s['IS_SUBDOMAIN'] = $_POST['IS_SUBDOMAIN'];
        if (empty($s['SITE_URL'])) {
            $error = TRUE;
            $errmsg = 'Please enter Site URL';
            $_SESSION['INSTALL_STEP'] = 3;
        }
        if (!$error) {
            if (!preg_match('/^(http|https)\:\/\/([a-z0-9-\.\_\/])+$/i', $s['SITE_URL'])) {
                $error = TRUE;
                $errmsg = 'Please enter valid Site URL.';
                $_SESSION['INSTALL_STEP'] = 3;
            }
        }
        if (!$error && empty($s['SITE_TITLE'])) {
            $error = TRUE;
            $errmsg = 'Please enter Website Title';
            $_SESSION['INSTALL_STEP'] = 3;
        }
        if (!$error) {
            $s['SITE_URL'] = rtrim($s['SITE_URL'], '/');
            $s['SITE_URL'] = $s['SITE_URL'].'/';
            $s['DOMAIN'] = preg_replace('/^(http|https)\:\/\//', '', $s['SITE_URL']);
            $s['DOMAIN'] = trim($s['DOMAIN'], '/');
            $s['DOMAIN'] = preg_replace('/\/.*$/', '', $s['DOMAIN']);
            $_SESSION['INSTALL_STEP'] = 4;
            header('Location: ?next&r='.rand(0,99999));
        }
    }
    
    if ($error ) {
        $html .= errorbox('Error', $errmsg, TRUE, 'margin-top:5px; margin-bottom:5px;');
    }
    $html .= '
            <div style="margin-top:25px;">
                <div>
                    <div class="greygrad">
                        <form method="post" action="">
                        
                            <div class="form-block">
                                <label for="SITE_URL">Site URL</label>
                                <input type="text" class="form-control" autocomplete="off" name="SITE_URL" value="'.htmlspecialchars($s['SITE_URL']).'" />
                            </div>

                            <div class="form-block">
                                <label for="IS_SUBDOMAIN">It is a subdomain?</label>
                                <select name="IS_SUBDOMAIN" class="form-control" />
                                    <option value="0" '.($s['IS_SUBDOMAIN'] == 0 ? 'selected="selected"' : '').'>No</option>
                                    <option value="1" '.($s['IS_SUBDOMAIN'] == 1 ? 'selected="selected"' : '').'>Yes</option>
                                </select>

                            </div>

                            <div class="form-block">
                                <label for="SITE_TITLE">Website Title</label>
                                <input type="text" class="form-control" autocomplete="off" name="SITE_TITLE" value="'.htmlspecialchars($s['SITE_TITLE']).'" />
                            </div>
                            
                            <div>
                                <input type="submit" name="submit" value="Next" class="bnext"/>
                                <span style="padding-left:50px;"><a href="?back&r='.rand(0,99999).'">Back</a></span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>';

?>