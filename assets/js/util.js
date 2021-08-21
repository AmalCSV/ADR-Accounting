function disableElements(ids) {
	ids.forEach(id => {
		document.getElementById(id).disabled = true;
	});
}

function enableElements(ids) {
	ids.forEach(id => {
		document.getElementById(id).disabled = false;
	});
}