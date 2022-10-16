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

function resetpass_Ok(response) {
   switch (response.status) {
        case 'ERROR':
            openandclose(paramsArray[0], response.message, 1700)
            setTimeout(function() { $(paramsArray[2]).removeAttr('disabled'); }, 2500);
            break;

        case 'OK':
            $(paramsArray[1]).html(response.html);
            $(paramsArray[3]).fadeOut('slow',function(){
                $(paramsArray[3]).hide(function(){
                    $(paramsArray[1]).fadeIn('slow');
                });
            });
            break;
   }
}

function resetpass_Error(response) {
    openandclose(paramsArray[0], msg_error_conection, 1700)
    setTimeout(function() {$(paramsArray[2]).removeAttr('disabled');}, 2500); 
}

function resetpass(divform, divok, diverror, bsubmit) {
    
	$(bsubmit).attr('disabled','true');

	email = validationInput('email', '#email', '#alert-email', error_email, bsubmit, true);
	if (!email) return;

    var data = {
        em: email,
    }
 
    paramsArray[0] = diverror;
    paramsArray[1] = divok;
    paramsArray[2] = bsubmit;
    paramsArray[3] = divform;
    
    var params = {
            type: 'POST',
            withFile: false,
            module: 'recoverypass',
            action: 'recovery',
            data: data
    }

    invoke(params, resetpass_Ok, resetpass_Error);

}