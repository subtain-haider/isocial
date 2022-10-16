<?php
 
    $PAGE_TITLE = 'Code Purchase';
    
    $s = &$_SESSION['INSTALL_DATA'];

    if (isset($s['PURCHASE_OK']) && $s['PURCHASE_OK'] == 1) {
        $_SESSION['INSTALL_STEP'] = 2;
        header('Location: ?next&r='.rand(0,99999));
    }
    
    if (!isset($s['CODE_PURCHASE'])) $s['CODE_PURCHASE'] = '';
    
    $submit = FALSE;
    $error = FALSE;
    $errmsg = '';
    if (isset($_POST['CODE_PURCHASE'])) {
        $_SESSION['INSTALL_STEP'] = 2;
        $submit = TRUE;
        $s['CODE_PURCHASE'] = trim($_POST['CODE_PURCHASE']);
        if (empty($s['CODE_PURCHASE'])) {
            $error = TRUE;
            $errmsg = 'Please fill all the fields.';
            $_SESSION['INSTALL_STEP'] = 1;
        } else {
            $MCODE_API = "http://api.mcodedeveloper.com/index.php";
            $s['CODEP'] = 'xEsd45Frt67';
            $validateURL = $MCODE_API . "?pcode=" . $s['CODE_PURCHASE'] . "&cp=" . $s['CODEP'] . "&url=" . site_url(TRUE);
            $result = apiCallMCode($validateURL);
            if ($result) {
                $inforesult = json_decode($result , true);    
                if ($inforesult['status'] == 'error') {
                    $error = TRUE;
                    $errmsg = $inforesult['msgerror'];
                    $_SESSION['INSTALL_STEP'] = 1;
                } else {
                    file_put_contents($s['CODEP'], $inforesult['clipping']);
                    file_put_contents($s['CODEP'].'e', $inforesult['clipper']);
                    $s['PURCHASE_OK'] = 1;
                    
                }
            } else {
                $error = TRUE;
                $errmsg = 'An error has occurred.';
                $_SESSION['INSTALL_STEP'] = 1;
            }
        }
        
        if (!$error) {
            $_SESSION['INSTALL_STEP'] = 2;
            header('Location: ?next&r='.rand(0,99999));
        }
    }
    
    $html .= '

    <div style="margin-top: 5px;">
        <div class="greygrad">
            <div>
                <p  class="themsg-section">Enter the code purchase of your product.</p>';

    if ($error) {
        $html .= errorbox('Error', $errmsg);
    }
    $html .= '
                    <form method="post" action="">
                    
                        <div class="form-block"><input type="text" autocomplete="off" class="form-control" placeholder="Code Purchase" name="CODE_PURCHASE" value="'.htmlspecialchars($s['CODE_PURCHASE']).'" /></div>
                        
                        <div>
                            <input type="submit" name="submit" value="Next" class="bnext"/>
                        </div>

                    </form>

                </div>
            </div>
        </div>';    
?>