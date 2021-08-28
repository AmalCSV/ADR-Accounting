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
			id: x.productID,
			text: x.itemName
		  }
	});
}

function getSelect2CustomerData(list) {
	return list.map( x=> {
		return {
			id: x.customerID,
			text: x.companyName
		  }
	});
}

function displayElements(ids) {
	ids.forEach(id => {
		document.getElementById(id).style.display = "";
	});
}

function displayHideElements(ids) {
	ids.forEach(id => {
		document.getElementById(id).style.display = "none";
	});
}
