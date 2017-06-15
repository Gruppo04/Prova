function doValidation(id, actionUrl, formName) {
        // la isValid() valida l'intera form, quindi bisogna andare a leggere l'errore solo dell'elemento voluto
        // questa è la funzione di callback: estrae l'errore che serve, cancella dalla form l'eventuale errore precedente
        // e inietta il nuovo messaggio di errore
        function showErrors(resp) {
		$("#" + id).parent().parent().find('.errors').html(' ');    // l'errore viene messo a vuoto
		$("#" + id).parent().parent().find('.errors').html(getErrorHtml(resp[id])); // inietta il nuovo errore
	}

	$.ajax({
		type : 'POST',
		url : actionUrl,
                // data è definita in modo da simulare la submit della form
                // serialize crea la stringa per il server a partire dai dati della form
		data : $("#" + formName).serialize(),
		dataType : 'json',
		success : showErrors
	});
}

function getErrorHtml(formErrors) { // la funzione prende il messaggio inviato dal server (elenco errori)
	if (( typeof (formErrors) === 'undefined') || (formErrors.length < 1))
		return;

	var out = '<ul>';
	for (errorKey in formErrors) {
		out += '<li>' + formErrors[errorKey] + '</li>';
	}
	out += '</ul>';
	return out; // restituisce un codice HTML che viene inittato nella view con la form
}

