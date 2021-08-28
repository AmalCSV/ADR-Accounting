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
  return list.map(x => {
    return {id: x.itemNumber, text: x.itemName};
  });
}

function getToday() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + "/" + dd + "/" + yyyy;
  return today;
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
