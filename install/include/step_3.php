<?php
 
    $PAGE_TITLE = 'Database Settings';
    
    $s = &$_SESSION['INSTALL_DATA'];
    $conn = FALSE;
    
    if (!isset($s['MYSQL_HOST'])) $s['MYSQL_HOST'] = 'localhost';
    if (!isset($s['MYSQL_USER'])) $s['MYSQL_USER'] = '';
    if (!isset($s['MYSQL_PASS'])) $s['MYSQL_PASS'] = '';
    if (!isset($s['MYSQL_DBNAME'])) $s['MYSQL_DBNAME'] = '';
    if (!isset($s['MYSQL_MYEXT'])) $s['MYSQL_MYEXT'] = myext();
    
    $submit = FALSE;
    $error = FALSE;
    $errmsg = '';
    if (isset($_POST['MYSQL_HOST'], $_POST['MYSQL_USER'], $_POST['MYSQL_PASS'], $_POST['MYSQL_DBNAME'])) {
        $_SESSION['INSTALL_STEP'] = 2;
        $submit = TRUE;
        $s['MYSQL_HOST'] = trim($_POST['MYSQL_HOST']);
        $s['MYSQL_USER'] = trim($_POST['MYSQL_USER']);
        $s['MYSQL_PASS'] = trim($_POST['MYSQL_PASS']);
        $s['MYSQL_DBNAME'] = trim($_POST['MYSQL_DBNAME']);
        if (empty($s['MYSQL_HOST']) || empty($s['MYSQL_USER']) || empty($s['MYSQL_DBNAME'])) {
            $error = TRUE;
            $errmsg = 'Please fill all the fields.';
        }
        if (!$error) {
            if ($s['MYSQL_MYEXT']=='mysqli' && function_exists('mysqli_connect')) {
                $conn = @mysqli_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
                if (!$conn && function_exists('mysql_connect')) {
                    $conn = @mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
                    if ($conn) {
                        $s['MYSQL_MYEXT'] == 'mysql';
                    }
                }
            }
            elseif ($s['MYSQL_MYEXT']=='mysql' && function_exists('mysql_connect')) {
                $conn = @mysql_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
                if (!$conn && function_exists('mysqli_connect')) {
                    $conn = @mysqli_connect($s['MYSQL_HOST'], $s['MYSQL_USER'], $s['MYSQL_PASS']);
                    if ($conn) {
                        $s['MYSQL_MYEXT'] == 'mysqli';
                    }
                }
            }
            if (!$conn) {
                $error = TRUE;
                $errmsg = 'Cannot connect - please check host, username and password.';
            }
        }
        if (!$error) {
            $dbs = my_mysql_select_db($s['MYSQL_DBNAME'], $conn);
            if (!$dbs) {
                $error = TRUE;
                $errmsg = 'Database does not exist.';
            }
        }
        if (!$error) {
            $tbl = my_mysql_query('SHOW TABLES FROM '.$s['MYSQL_DBNAME'], $conn);
            if ($tbl && my_mysql_num_rows($tbl)>0) {
                $error = TRUE;
                $errmsg = 'Database must be empty - this one contains one or more tables.';
            }
        }
        if (!$error) {
            $_SESSION['INSTALL_STEP'] = 3;
            header('Location: ?next&r='.rand(0,99999));
        }
    }
    
    $html .= '

    <div>
        <div>
            <div class="greygrad">
                <p  class="themsg-section">Fill in the information about the MySQL database.<br>For new '.SITE_TITLE.' installations you must create an <b>empty</b> MySQL database.</p>';

    if ($error) {
        $html .= errorbox('Error', $errmsg);
    }
    $html .= '
                    <form method="post" action="">
                    
                        <div class="form-block">
                            <label for="MYSQL_HOST">MySQL Host (usually "localhost")</label>
                            <input type="text" class="form-control" autocomplete="off" name="MYSQL_HOST" value="'.htmlspecialchars($s['MYSQL_HOST']).'" />
                        </div>

                        <div class="form-block">
                            <label for="MYSQL_USER">Username</label>
                            <input type="text" class="form-control" autocomplete="off" name="MYSQL_USER" value="'.htmlspecialchars($s['MYSQL_USER']).'" />
                        </div>

                        <div class="form-block">
                            <label for="MYSQL_PASS">Password</label>
                            <input type="password" class="form-control" autocomplete="off" name="MYSQL_PASS" value="'.htmlspecialchars($s['MYSQL_PASS']).'" />
                        </div>

                        <div class="form-block">
                            <label for="MYSQL_DBNAME">Database Name</label>
                            <input type="text" class="form-control" autocomplete="off" name="MYSQL_DBNAME" value="'.htmlspecialchars($s['MYSQL_DBNAME']).'" />
                        </div>
                        
                        <div>
                            <input type="submit" name="submit" value="Next" class="bnext"/>
                        </div>

                    </form>

                </div>
            </div>
        </div>';
    
?>