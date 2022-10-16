function loadcategorymarket_Ok(response) {
   switch (response.status) {
        case 'ERROR':
            break;

        case 'OK':
            $(paramsArray[0]).html(response.categories);
            $(paramsArray[0]).removeAttr('disabled');
            break;            
   }
}

function loadcategorymarket_Error(response) {
}

function loadcategorymarket(idcat, msgcategory, msgsubcategory, divcategories, divsubcategories) {
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
            action: 'market',
            data: data
    }

    invoke(params, loadcategorymarket_Ok, loadcategorymarket_Error);

}

/*__________________________________________________________________*/
/*__________________________________________________________________*/

function loadsubcategorymarket_Ok(response) {
   switch (response.status) {
        case 'ERROR':
            break;

        case 'OK':
            $(paramsArray[1]).html(response.subcategories);
            $(paramsArray[1]).removeAttr('disabled');
            break;            
   }
}

function loadsubcategorymarket_Error(response) {
}

function loadsubcategorymarket(idcat, idsubcat, msgcsubcategory, divsubcategories) {	
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
            action: 'market',
            data: data
    }

    invoke(params, loadsubcategorymarket_Ok, loadsubcategorymarket_Error);

}

/*__________________________________________________________________*/
/*__________________________________________________________________*/