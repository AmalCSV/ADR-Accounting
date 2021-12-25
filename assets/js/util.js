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
			text: `${x.itemNumber} - ${x.itemName}`
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
		$(tableID).DataTable({
			"order": [[ 0, "desc" ]]
		});
		$("[data-toggle=tooltip]").tooltip();
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

function reportsTableCreator(tableContainerDiv, tableCreatorFileUrl, table){
	var tableContainerDivID = '#' + tableContainerDiv;
	var tableID = '#' + table;
	$(tableContainerDivID).load(tableCreatorFileUrl, function(){
		// Initiate the Datatable plugin once the table is added to the DOM
		$(tableID).DataTable({
			dom: 'lBfrtip',
			//dom: 'lfBrtip',
			//dom: 'Bfrtip',
			buttons: [
				'copy',
				'csv', 'excel',
				{extend: 'pdf', orientation: 'landscape', pageSize: 'LEGAL'},
				'print'
			],
			"ordering": false
		});
	});
}

var poSearchFilter = {};
var soSearchFilter = {};
var localSExpiryDate = 1;
var poMaxLimit = 30;
var soMaxLimit = 15;
const purchseOrder = "PO";
const salesOrder = "SO";
var today = new Date();


function setOrderFilter(type, fromDate, toDate){
	let expiryDate = new Date(); 
	expiryDate.setDate(expiryDate.getDate() + 1);
	if(type == purchseOrder){
		poSearchFilter.fromDate = fromDate;
		poSearchFilter.toDate = toDate;
		poSearchFilter.expiry =  expiryDate;
		localStorage.setItem("poSearchFilter", JSON.stringify(poSearchFilter));

	}
	else{
		soSearchFilter.fromDate = fromDate;
		soSearchFilter.toDate = toDate;
		soSearchFilter.expiry = expiryDate;
		localStorage.setItem("soSearchFilter", JSON.stringify(soSearchFilter));
	}
}

function getOrderFilter(type){
	let expiryDate = new Date(); 
	expiryDate.setDate(expiryDate.getDate() + 1);
	if(type == purchseOrder){

		poSearchFilter = JSON.parse(localStorage.getItem("poSearchFilter"));

		if(!poSearchFilter || ( poSearchFilter && isLocalSExpired(poSearchFilter.expiry))){
			let fromDate = new Date();
			fromDate.setDate(fromDate.getDate() - poMaxLimit);
			poSearchFilter = {};
			poSearchFilter.fromDate = fromDate.toISOString().slice(0, 10);
			poSearchFilter.toDate = today.toISOString().slice(0, 10);
			poSearchFilter.expiry = expiryDate.toISOString().slice(0, 10);

		}
		return poSearchFilter;
	}
	else{
		soSearchFilter = JSON.parse(localStorage.getItem("soSearchFilter"));

		if(!soSearchFilter || ( soSearchFilter && isLocalSExpired(soSearchFilter.expiry)) ){
		
			let fromDate = new Date();
			fromDate.setDate(fromDate.getDate() - soMaxLimit);
			soSearchFilter = {};
			soSearchFilter.fromDate = fromDate.toISOString().slice(0, 10);
			soSearchFilter.toDate = today.toISOString().slice(0, 10);
			soSearchFilter.expiry = expiryDate.toISOString().slice(0, 10);

		}
		return soSearchFilter;
	}
}

function isLocalSExpired(expiryDate){

	var date = new Date();
	date.setDate(date.getDate() - localSExpiryDate);

	if(expiryDate && date >= expiryDate){
		return true;
	}
	else{
		return false;
	}

}