<?php

    $PAGE_TITLE = 'Administrative Account';
    
    $s = & $_SESSION['INSTALL_DATA'];

    if (isset($_GET['back'])) {
        $_SESSION['INSTALL_STEP'] = 4;
        header('Location: ?next&r='.rand(0,99999));
    }
    
    $conn = my_mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
    $dbs = my_mysql_select_db($s['MYSQL_DBNAME'], $conn);
    if (!$conn || !$dbs) {
        $_SESSION['INSTALL_STEP'] = 3;
        header('Location: ?next&r='.rand(0,99999));
    }

    $res = my_mysql_query('SHOW TABLES FROM '.$s['MYSQL_DBNAME'], $conn);
    if (my_mysql_num_rows($res)) {
        $tables = array();
        while($tbl = my_mysql_fetch_row($res)) {
            $tables[] = $tbl[0];
        }
        sort($tables);
    }

    
    if (!isset($s['ADMIN_ID'])) {
        $s['ADMIN_ID'] = FALSE;
    }
    
    if (!isset($s['ADMIN_FIRSTNAME'])) {
        $s['ADMIN_FIRSTNAME'] = '';
    }
    if (!isset($s['ADMIN_LASTNAME'])) {
        $s['ADMIN_LASTNAME'] = '';
    }

    if (!isset($s['ADMIN_USER'])) {
        $s['ADMIN_USER'] = '';
    }
    if (!isset($s['ADMIN_PASS'])) {
        $s['ADMIN_PASS'] = '';
    }
    if (!isset($s['ADMIN_EMAIL'])) {
        $s['ADMIN_EMAIL'] = '';
    }
    
    $submit = FALSE;
    $error = FALSE;
    $errmsg = '';
    if (isset($_POST['ADMIN_FIRSTNAME'], $_POST['ADMIN_LASTNAME'], $_POST['ADMIN_USER'], $_POST['ADMIN_PASS'], $_POST['ADMIN_EMAIL'])) {
        $submit = TRUE;
        $_SESSION['INSTALL_STEP'] = 4;
        $s['ADMIN_ID'] = 0;
        $s['ADMIN_FIRSTNAME'] = trim($_POST['ADMIN_FIRSTNAME']);
        $s['ADMIN_LASTNAME'] = trim($_POST['ADMIN_LASTNAME']);
        $s['ADMIN_USER'] = trim($_POST['ADMIN_USER']);
        $s['ADMIN_PASS'] = trim($_POST['ADMIN_PASS']);
        $s['ADMIN_EMAIL'] = trim($_POST['ADMIN_EMAIL']);
        if (!$error && empty($s['ADMIN_FIRSTNAME'])) {
            $error = TRUE;
            $errmsg = 'Please enter first name.';
        }
        if (!$error && empty($s['ADMIN_LASTNAME'])) {
            $error = TRUE;
            $errmsg = 'Please enter last name.';
        }
        if (empty($s['ADMIN_USER'])) {
            $error = TRUE;
            $errmsg = 'Please enter Username.';
        }
        if (!$error && ! is_valid_username($s['ADMIN_USER'], TRUE)) {
            $error = TRUE;
            $errmsg = 'Please enter valid Username. The Username entered is not allowed.';
        }
        if (!$error) {
            $res = my_mysql_query('SELECT id FROM users WHERE username="'.addslashes($s['ADMIN_USER']).'" LIMIT 1', $conn);
            if ($res) {
                if (my_mysql_num_rows($res) > 0) {
                    $error = TRUE;
                    $errmsg = 'This username is already registered.';
                }
            }
        }
        if (!$error && strlen($s['ADMIN_PASS']) < 6) {
            $error = TRUE;
            $errmsg = 'Password must be at least 6 characters long.';
        }
        if (!$error && !is_valid_email($s['ADMIN_EMAIL'])) {
            $error = TRUE;
            $errmsg = 'Invalid E-mail address.';
        }
        if (!$error) {
            $res = my_mysql_query('SELECT id FROM users WHERE email="'.addslashes($s['ADMIN_EMAIL']).'" LIMIT 1', $conn);
            if ($res) {
                if (my_mysql_num_rows($res) > 0) {
                    $error = TRUE;
                    $errmsg = 'This e-mail is already registered.';
                }
            }
        }
        if (!$error) {
            $_SESSION['INSTALL_STEP'] = 5;
            header('Location: ?next&r='.rand(0,99999));
        }
    }
    
    $html .= '
            <div style="margin-top: 5px;">
                <div>
                    <div class="greygrad">
                        <p class="themsg-section">Create an Administrative account for accessing the Administration Panel.</p>';
    if ($error ) {
        $html .= errorbox('Error', $errmsg);
    }
    $html .= '
                        <form id="formendi" method="post" action="">
                        
                            <div class="subtitle_section">Personal information</div>
                        
                            <div class="form-block">
                                <label for="SITE_URL">Admin Firstname</label>
                                <input type="text" class="form-control" autocomplete="off" name="ADMIN_FIRSTNAME" value="'.htmlspecialchars($s['ADMIN_FIRSTNAME']).'" />
                            </div>

                            <div class="form-block">
                                <label for="SITE_URL">Admin Lastname</label>
                                <input type="text" class="form-control" autocomplete="off" name="ADMIN_LASTNAME" value="'.htmlspecialchars($s['ADMIN_LASTNAME']).'" />
                            </div>



                            <div class="subtitle_section">System Access Information</div>
                        
                            <div class="form-block">
                                <label for="SITE_URL">Admin Username</label>
                                <input type="text" class="form-control" autocomplete="off" name="ADMIN_USER" value="'.htmlspecialchars($s['ADMIN_USER']).'" />
                            </div>

                            <div class="form-block">
                                <label for="SITE_URL">Admin Password</label>
                                <input type="password" class="form-control" autocomplete="off" name="ADMIN_PASS" value="'.htmlspecialchars($s['ADMIN_PASS']).'" />
                            </div>



                            <div class="subtitle_section">Administrator Email</div>
                        
                            <div class="form-block">
                                <label for="SITE_URL">Email</label>
                                <input type="text" class="form-control" autocomplete="off" name="ADMIN_EMAIL" value="'.htmlspecialchars($s['ADMIN_EMAIL']).'" />
                            </div>
                            
                            <div style="margin:20px 0 20px;">Note: Installation process may take few minutes.</div>
                            
                            
                            <div>
                                <input type="submit" id="binstall" name="submit" value="Install Now!" class="bnext"/>
                                <span id="bbackend" style="padding-left:50px;"><a href="?back&r='.rand(0,99999).'">Back</a></span>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

<script>
    $(function() {        
        $( "#formendi" ).submit(function( event ) {
            $("#binstall").attr("disabled", true);
            $("#bbackend").hide();
        });
    });
</script>            
            
';
    
?>