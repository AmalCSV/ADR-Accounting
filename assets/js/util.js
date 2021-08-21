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

function getSelect2ItemData(list) {
	return list.map( x=> {
		return {
			id: x.itemNumber,
			text: x.itemName
		  }
	});
}
