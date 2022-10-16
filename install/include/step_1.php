<?php
    
    $PAGE_TITLE = 'Terms of use';
        
    $installed = FALSE;
    
    if (isset($OLDK->INSTALLED) && $OLDK->INSTALLED) {
    	$installed = TRUE;
    }
    
    if ($installed) {
        $_SESSION['INSTALL_STEP'] = 0;
        
        $PAGE_TITLE = 'Oops!';
        $html .= '
                '.errorbox('Oops', SITE_TITLE.' is already installed on your system. Please remove the "install/" folder.', FALSE, 'margin-top:25px;');
    } else {
        $_SESSION['INSTALL_STEP'] = 0;
        
        $error = FALSE;
        if (isset($_POST['submit'])) {
            $a = isset($_POST['accept1']) && $_POST['accept1']=="1";
    
            if (!$a) {
                $error = TRUE;
            }
            if (!$error) {
                $_SESSION['INSTALL_STEP'] = 1;
                header('Location: ?next');
                exit;
            }
        }
        
        $html .= '
        <div style="margin-top: 5px;">
            <div>
                <div class="greygrad">
                    <div class="themsg-section">
                        <p>
                            <p><b class="bold">LICENSE AGREEMENT</b>:<br> Install on one (01) domain (site).</p>

                            <p>
                            <b class="bold">You CAN:</b><br> 1) Install on one (01) domain. You require an additional license for each additional domain.<br> 2) Modify or edit as you wish.<br> 3) Delete the sections you want.<br> 4) Translate into the language of your choice.<br>
                            <br><b class="bold">You CANNOT:</b> <br>1) Resell, distribute, give away, or trade by any means to a third party or individual without permission.<br> 2) Use in more than one (01) domain.
                            <br><br>You can buy unlimited licenses of our product. This is available.
                            </p>
                        </p>
                    </div>';

        if ($error) {
            $html .= errorbox('Sorry', 'You must accept the '.SITE_TITLE.' License terms and limitations to proceed with installation.');
        }
        $html .= '
                    <form method="post" action="">
                        <div style="margin-top: 10px; margin-left:2px;">
                            <label id="agree-license">
                                <input type="checkbox" id="accept1" name="accept1" value="1" style="margin:0px; padding:0px; border:0px solid; line-height:1; margin-right:8px; cursor:pointer;" /> I agree to the terms of use and privacy policy.
                            </label>
                            ';
    $html .= '      </div>
                        <div style="margin-top: 10px;">
                            <input type="submit" id="bsubmit1" name="submit" value="Next" disabled class="bnext"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
<script>
    $(function() {
        $("#accept1").change(function() {
            if($(this).is(":checked")) {
                $("#bsubmit1").attr("disabled", false);
            } else {
            	$("#bsubmit1").attr("disabled", true);
            }       
        });
    });
</script>
        ';
    }
?>