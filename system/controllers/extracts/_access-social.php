<?php
if ($K->LOGIN_WITH_FACEBOOK && $K->FB_APPID && $K->FB_SECRET) {
    
    $D->OAuthRedirectURI = $K->SITE_URL.'social:facebook/?go=1';

    if ($this->param('social') && $this->param('social') == 'facebook') {
    
        $theFBCode = $_GET['code'];
        $theFBState = $_GET['state'];
        
        $theConnectionFB = getTokenSocialFB($K->FB_APPID, $K->FB_SECRET, $D->OAuthRedirectURI, $theFBCode);

        $theuserFB = getInfoUserFB($theConnectionFB['access_token']);
        
        $theStateMine = $_SESSION['USER_DATA']['STATE_FB'];

		if($theConnectionFB == null || $theStateMine == null || $theStateMine != $theFBState || empty($theuserFB->email)) {
            header("Location: ".$K->SITE_URL);
            exit();
		}


        $fb_email = $this->db1->e($theuserFB->email);
    
        $usersimple = $this->db1->fetch_field("SELECT iduser FROM users WHERE user_email='".$theuserFB->email."' AND auth=''");
        if ($usersimple) {
            $D->msg_alert = 'The email that this facebook account is using is already registered';
            session_destroy();
        } else {
            $save_avatar = FALSE;
            $r = $this->db1->query("SELECT user_username FROM users WHERE user_email='".$fb_email."' AND auth='facebook'");
            if (!($obj = $this->db1->fetch_object($r))) {
                
                $ip	= $this->db1->escape( ip2long($_SERVER['REMOTE_ADDR']) );
                $code = codeUniqueInTable(11, 1, 'users', 'code');
                $soc_id = $theuserFB->id;
                $soc_pass = getCode(10,1);
                $soc_photourl = $theuserFB->picture->data->url;
                $soc_first_name = $this->db1->e($theuserFB->first_name);
                $soc_last_name = $this->db1->e($theuserFB->last_name);
                $soc_email = $fb_email;

                $soc_gender = 'male';
                if (isset($theuserFB->gender)) $soc_gender = $theuserFB->gender;
                
                $soc_username = $theuserFB->name;
                $soc_username = str_replace(' ','',$soc_username);
                $soc_username = str_replace('.','',$soc_username);
    
                //if the username does not work, use your email
                if (!validateUsername($soc_username)) {
                    $newUser = explode('@', $fb_email);
                    $soc_username = str_replace('.','',$newUser[0]);
                    $soc_username = str_replace('-','',$soc_username);
                    $lenun = strlen($soc_username);
                    if (strlen($soc_username)<6) $soc_username = $soc_username . getCode(6-$lenun,1);
                }
        
                $numu1 = $this->db1->fetch_field("SELECT count(iduser) FROM users WHERE user_username='".$soc_username."'");
                $numu2 = $this->db1->fetch_field("SELECT count(idgroup) FROM groups WHERE guname='".$soc_username."'");
                $numu3 = $this->db1->fetch_field("SELECT count(idpage) FROM pages WHERE puname='".$soc_username."'");
                $numu = $numu1 + $numu2 + $numu3;
                if ($numu != 0) $soc_username = $soc_username.''.($numu + 1);
                
                $soc_username = $this->db1->e($soc_username);
    
                $gender = 0;
                if ($soc_gender == 'male') $gender = 1;
                if ($soc_gender == 'female') $gender = 2;
                
                $finalphoto = '';
                $code_media = '';
    
                if (!empty($soc_photourl)) {
                    $ext = '.jpg';
                    $codephoto = getCode(5, 1);
                    $codephoto .= '-'.getCode(6, 1);
                    $codephoto .= '-'.getCode(7, 1);
                    $finalphoto = $codephoto.'.'.$ext;
                    
                    $the_pholder_avatar_0 = $K->STORAGE_DIR_AVATARS.'originals/'.$code;
                    $the_pholder_avatar_1 = $K->STORAGE_DIR_AVATARS.'min1/'.$code;
                    $the_pholder_avatar_2 = $K->STORAGE_DIR_AVATARS.'min2/'.$code;
                    $the_pholder_avatar_3 = $K->STORAGE_DIR_AVATARS.'min3/'.$code;
                    $the_pholder_avatar_4 = $K->STORAGE_DIR_AVATARS.'min4/'.$code;
                    
                    if (!file_exists($the_pholder_avatar_0)) {
                        mkdir($the_pholder_avatar_0, 0777, true);
                        $findex = fopen($the_pholder_avatar_0.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_1)) {
                        mkdir($the_pholder_avatar_1, 0777, true);
                        $findex = fopen($the_pholder_avatar_1.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_2)) {
                        mkdir($the_pholder_avatar_2, 0777, true);
                        $findex = fopen($the_pholder_avatar_2.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_3)) {
                        mkdir($the_pholder_avatar_3, 0777, true);
                        $findex = fopen($the_pholder_avatar_3.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_4)) {
                        mkdir($the_pholder_avatar_4, 0777, true);
                        $findex = fopen($the_pholder_avatar_4.'/index.html', "a");
                    }
                    
                    
                    
                    $res_avatar = copyImageFromUrl('https://graph.facebook.com/me/picture?width=500&height=500&access_token='.$theConnectionFB['access_token'], $the_pholder_avatar_0.'/', $finalphoto);
                    if (!$res_avatar) $finalphoto = '';
                    else {
    
                        if (file_exists($the_pholder_avatar_0.'/'.$finalphoto)) {
                        
                            require_once('classes/class_imagen.php');
                            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar1, $K->heightAvatar1, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_1.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar2, $K->heightAvatar2, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_2.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar3, $K->heightAvatar3, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_3.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar4, $K->heightAvatar4, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_4.'/'.$finalphoto);
                            
                            $save_avatar = TRUE;
                            
                        }
    
                    }
                }
    
                
                $r = $this->db1->query("INSERT INTO users SET code='".$code."', user_password='" . md5($soc_pass) . "', auth='facebook', user_username='".$soc_username."', auth_id='".$soc_id."', firstname='".$soc_first_name."', lastname='".$soc_last_name."', user_email='".$soc_email."', avatar='".$finalphoto."', avatar_media='".$code_media."', registerdate='" . time() . "', ipregister='" . $ip . "', birthday='1973-11-16', verified=1, validated=1, datevalidated='" . time() . "', gender=".$gender.", facebook=''");
                
                $theusername = $soc_username;
    
            } else {
                $theusername = $obj->user_username;
            }
            $this->user->loginSocial($theusername, 'facebook');
            
            if ($save_avatar) {
                require_once('classes/class_newpost.php');
                $np = new newpost();				
                $np->moreInfo($code, 0, 0, $code, 0, '', '', '');
                $code_media = $np->attachImagesFromServer($the_pholder_avatar_0.'/'.$finalphoto, $ext);
                $np->setMessage('');
                $np->setTypePost(6);
                $np->save();
                $this->db1->query("UPDATE users SET avatar_media='".$code_media."' WHERE code='".$code."' LIMIT 1");
            }
            
            $this->redirect($K->SITE_URL);
        }






/*

        $theusersimple = $this->db2->fetch_field("SELECT iduser FROM users WHERE user_email='".$theuserFB->email."' AND auth='' LIMIT 1");
        if ($theusersimple) {
            $D->msg_alert = $this->lang('home_fb_email_already');
            session_destroy();
        } else {
            $save_avatar = FALSE;
            
            $un_in_db = $this->db2->fetch_field("SELECT user_username FROM users WHERE user_email='".$theuserFB->email."' AND auth='facebook' LIMIT 1");
            if (!$un_in_db) {

                $ip	= $this->db2->escape( ip2long($_SERVER['REMOTE_ADDR']) );
                $ncodeuser = codeUniqueInTable(11, 1, 'users', 'code');
                $soc_id = $theuserFB->id;
                $soc_firstname = $theuserFB->first_name;
                $soc_lastname = $theuserFB->last_name;
                $soc_username = $theuserFB->name;
                $soc_username = str_replace(' ','',$soc_username);
                $soc_username = str_replace('.','',$soc_username);
                $soc_password = getCode(10,1);
                $soc_email = $theuserFB->email;
                $soc_gender = $theuserFB->gender;
                $soc_picture = $theuserFB->picture->data->url;
                
                // if the username does not work, use your email
                if (!validateUsername($soc_username)) {
                    $newsoc_User = explode('@', $soc_email);
                    $soc_username = str_replace('.','',$newsoc_User[0]);
                    $soc_username = str_replace('-','',$soc_username);
                    $soc_lenun = strlen($soc_username);
                    if (strlen($soc_username)<6) $soc_username = $soc_username . getCode(6-$soc_lenun,1);
                }
        
                $soc_numu = $this->db2->fetch_field("SELECT count(iduser) FROM users WHERE user_username='".$soc_username."'");
                if ($soc_numu != 0) $soc_username = $soc_username.''.($soc_numu + 1);
                
                $soc_username = $this->db2->e($soc_username);
        
                $soc_newgender = 0;
                if ($soc_gender == 'male') $soc_newgender = 1;
                if ($soc_gender == 'female') $soc_newgender = 2;
                
                $finalphoto = '';
                $code_media = '';

                if (!empty($soc_picture)) {
                    $ext = 'jpg';
                    $codephoto = getCode(5, 1);
                    $codephoto .= '-'.getCode(6, 1);
                    $codephoto .= '-'.getCode(7, 1);
                    $finalphoto = $codephoto.'.'.$ext;
                    
                    $the_pholder_avatar_0 = $K->STORAGE_DIR_AVATARS.'originals/'.$ncodeuser;
                    $the_pholder_avatar_1 = $K->STORAGE_DIR_AVATARS.'min1/'.$ncodeuser;
                    $the_pholder_avatar_2 = $K->STORAGE_DIR_AVATARS.'min2/'.$ncodeuser;
                    $the_pholder_avatar_3 = $K->STORAGE_DIR_AVATARS.'min3/'.$ncodeuser;
                    $the_pholder_avatar_4 = $K->STORAGE_DIR_AVATARS.'min4/'.$ncodeuser;
                    $the_pholder_avatar_5 = $K->STORAGE_DIR_AVATARS.'min5/'.$ncodeuser;
                    
                    if (!file_exists($the_pholder_avatar_0)) {
                        mkdir($the_pholder_avatar_0, 0777, true);
                        $findex = fopen($the_pholder_avatar_0.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_1)) {
                        mkdir($the_pholder_avatar_1, 0777, true);
                        $findex = fopen($the_pholder_avatar_1.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_2)) {
                        mkdir($the_pholder_avatar_2, 0777, true);
                        $findex = fopen($the_pholder_avatar_2.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_3)) {
                        mkdir($the_pholder_avatar_3, 0777, true);
                        $findex = fopen($the_pholder_avatar_3.'/index.html', "a");
                    }
    
                    if (!file_exists($the_pholder_avatar_4)) {
                        mkdir($the_pholder_avatar_4, 0777, true);
                        $findex = fopen($the_pholder_avatar_4.'/index.html', "a");
                    }
                    
                    if (!file_exists($the_pholder_avatar_5)) {
                        mkdir($the_pholder_avatar_5, 0777, true);
                        $findex = fopen($the_pholder_avatar_5.'/index.html', "a");
                    }                
                    
                    $res_avatar = copyImageFromUrl('https://graph.facebook.com/me/picture?width=500&height=500&access_token='.$theConnectionFB['access_token'], $the_pholder_avatar_0.'/', $finalphoto);
                    
                    if (!$res_avatar) $finalphoto = '';
                    else {
    
                        if (file_exists($the_pholder_avatar_0.'/'.$finalphoto)) {
                            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar1, $K->heightAvatar1, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_1.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar2, $K->heightAvatar2, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_2.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar3, $K->heightAvatar3, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_3.'/'.$finalphoto);
            
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar4, $K->heightAvatar4, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_4.'/'.$finalphoto);
    
                            $thumbnail = new imagen($the_pholder_avatar_0.'/'.$finalphoto);
                            $thumbnail->resizeImage($K->widthAvatar5, $K->heightAvatar5, 'crop');
                            $thumbnail->saveImage($the_pholder_avatar_5.'/'.$finalphoto);
                            
                            $save_avatar = TRUE;
                            
                        }
    
                    }
                }
    
                
                $r = $this->db2->query("INSERT INTO users SET code='".$ncodeuser."', user_password='" . hash('sha256', $soc_password, false) . "', auth='facebook', user_username='".$soc_username."', auth_id='".$soc_id."', firstname='".$soc_firstname."', lastname='".$soc_lastname."', user_email='".$soc_email."', avatar='".$finalphoto."', avatar_media='".$code_media."', registerdate='" . time() . "', ipregister='" . $ip . "', birthday='1973-11-16', verified=1, validated=1, datevalidated='" . time() . "', gender=".$soc_newgender.", facebook=''");
                
                $theusername = $soc_username;

            } else {
                
                $theusername = $un_in_db;
                
            }
            
            $this->user->loginSocial($theusername, 'facebook');
            
            if ($save_avatar) {

                $np = new newpost();				
                $np->moreInfo($ncodeuser, 0, 0, $ncodeuser, 0);
                $code_media = $np->attachImagesFromServer($the_pholder_avatar_0.'/'.$finalphoto, $ext);
                $np->setMessage('');
                $np->setTypePost(6);
                $np->save();
                $this->db2->query("UPDATE users SET avatar_media='".$code_media."' WHERE code='".$ncodeuser."' LIMIT 1");
            
            }
            
            $this->redirect($K->SITE_URL);

        }

*/

    } else {

        $_SESSION['USER_DATA']['STATE_FB'] = md5(uniqid(rand(), TRUE)); 
        
        $D->FB_loginURL = 'https://www.facebook.com/dialog/oauth?client_id='.$K->FB_APPID.'&redirect_uri='.urlencode($D->OAuthRedirectURI).'&scope=public_profile,email&state='.$_SESSION['USER_DATA']['STATE_FB'];       
        
    }    
    
}