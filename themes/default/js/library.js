function loadcategorylibrary_Ok(response) {
   switch (response.status) {
        case 'ERROR':
            break;

        case 'OK':
            $(paramsArray[0]).html(response.categories);
            $(paramsArray[0]).removeAttr('disabled');
            break;            
   }
}

function loadcategorylibrary_Error(response) {
}

function loadcategorylibrary(idcat, msgcategory, msgsubcategory, divcategories, divsubcategories) {
	$(divcategories).html('<option value="-1">' + msgcategory + '</option>');
	$(divcategories).attr('disabled','true');
	$(divsubcategories).html('<option value="0">' + msgsubcategory + '</option>');
    
	paramsArray[0] = divcategories;
    
    var data = {
        idc: idcat,
    }
    
    var params = {
            type: 'POST',
            withFile: false,
            module: 'getcategories',
            action: 'library',
            data: data
    }

    invoke(params, loadcategorylibrary_Ok, loadcategorylibrary_Error);

}

/*__________________________________________________________________*/
/*__________________________________________________________________*/

function loadsubcategorylibrary_Ok(response) {
   switch (response.status) {
        case 'ERROR':
            break;

        case 'OK':
            $(paramsArray[1]).html(response.subcategories);
            $(paramsArray[1]).removeAttr('disabled');
            break;            
   }
}

function loadsubcategorylibrary_Error(response) {
}

function loadsubcategorylibrary(idcat, idsubcat, msgcsubcategory, divsubcategories) {	
	$(divsubcategories).html('<option value="-1">' + msgcsubcategory + '</option>');
	$(divsubcategories).attr('disabled','true');
    
	paramsArray[1] = divsubcategories;
    
    var data = {
        idc: idcat,
        idsc: idsubcat,
    }
    
    var params = {
            type: 'POST',
            withFile: false,
            module: 'getsubcategories',
            action: 'library',
            data: data
    }

    invoke(params, loadsubcategorylibrary_Ok, loadsubcategorylibrary_Error);

}

/*__________________________________________________________________*/
/*__________________________________________________________________*/

