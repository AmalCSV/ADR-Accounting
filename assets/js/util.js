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

function getSelect2ItemData(list= []) {
	return list.map( x=> {
		return {
			id: x.productID,
			text: x.itemName
		  }
	});
}

function getToday() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + "/" + dd + "/" + yyyy;
  return today;
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

// Function to create searchable datatables for customer, item, purchase, sale
function searchTableCreator(tableContainerDiv, tableCreatorFileUrl, table){
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function(){
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable();
	});
}

// Function to populate last inserted ID
function populateLastInsertedID(scriptPath, textBoxID){
	$.ajax({
		url: scriptPath,
		method: 'POST',
		dataType: 'json',
		success: function(data){
			$('#' + textBoxID).val(data);
		}
	});
}

// Initiate datepickers
$('.datepicker').datepicker({
	format: 'yyyy-mm-dd',
	todayHighlight: true,
	todayBtn: 'linked',
	orientation: 'bottom left'	
});

var companyDetails = {};

function fetchCompanyDetails(){
	$.ajax({
		url: 'model/company/populateCompanyDetails.php',
		method: 'POST',
		dataType: 'json',
		success: function(data){
			companyDetails = data;
		},
		error: function(data){
			console.log(data);
		}
	});
}

fetchCompanyDetails();

function getCompanyDetails(){
	return companyDetails;
}