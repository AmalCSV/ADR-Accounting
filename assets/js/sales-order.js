var itemData =[];
// Function to call the insertSale.php script to insert sale data to db
function addSale() {
	var saleDetailsSaleID = $('#saleDetailsSaleID').val();
	var saleDetailsDiscount = $('#saleDetailsDiscountp').val();
	var saleDetailsCustomerID = $('#saleDetailsCustomerName').val();
	var saleDetailsCustomerName = $('#saleDetailsCustomerName option:selected').text();
	var saleDetailsSaleDate = $('#saleDetailsSaleDate').val();
	var salesOrderTotal = $('#salesOrderTotal').val();
	var salesOrderNetTotal = $('#salesOrderNetTotal').val();
	var salesDescription = $('#salesDescription').val();

	const salesItem = [];

	let item = {
		id: $('#saleDetailsItem').val(),
		sellingPrice: $('#saleDetailsUnitPrice').val(),
		quntity: $('#saleDetailsQuantity').val(),
		total: $(`#saleDetailsTotal`).val(),
		name: $(`#saleDetailsItem option:selected`).text(),
	};
	salesItem.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			id: $(`#saleDetailsItem${index+1}`).val(),
			sellingPrice: $(`#saleDetailsUnitPrice${index+1}`).val(),
			quntity: $(`#saleDetailsQuantity${index+1}`).val(),
			total: $(`#saleDetailsTotal${index+1}`).val(),
			name: $(`#saleDetailsItem${index+1} option:selected`).text(),
		};
		salesItem.push(item);
	}

	$.ajax({
		url: 'model/sale/insertSale.php',
		method: 'POST',
		data: {
			saleDetailsSaleID: saleDetailsSaleID,
			saleDetailsDiscount: saleDetailsDiscount,
			salesOrderTotal: salesOrderTotal,
			saleDetailsCustomerName: saleDetailsCustomerName,
			saleDetailsSaleDate: saleDetailsSaleDate,
			salesOrderNetTotal: salesOrderNetTotal,
			salesDescription: salesDescription,
			saleDetailsCustomerID: saleDetailsCustomerID,
			salesItem: salesItem,
		},
		success: function(data){
			$('#saleDetailsMessage').fadeIn();
			$('#saleDetailsMessage').html(data);
		},
		complete: function(){
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

function addSalesItem(id, viewType) {
    $("#salesItemList").append( `
			<div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-4">
						<select id='saleDetailsItem${id}' class="form-control">
                        </select>
				    </div>
                    <div class="form-group col-md-2">
                        <input type="number" class="form-control" id="saleDetailsQuantity${id}" name="saleDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="saleDetailsUnitPrice${id}" name="saleDetailsUnitPrice${id}" value="0" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="saleDetailsTotal${id}" name="saleDetailsTotal${id}" readonly>
						<input type="hidden" id="saleItemId${id}" name="saleItemId${id}">
					</div>
					<div class="form-group col-md-1">
						<button type="button" id="deleteSalesItem${id}" onclick="deleteSalesItem(${id})" class="btn btn-danger">Delete</button>
					</div>
                </div>
            </div>
	` );
	setSuggestionFunctions(id);
	setCalculationFunctions(id);
}

function setSuggestionFunctions(id) {
	$(`#saleDetailsItem${id}`).select2({
		data: itemData
	});
	itemSelectChange(id);
	$(`#saleDetailsItem${id}`).change(function(){
		itemSelectChange(id);
	});
}

function setCalculationFunctions(id) {
	$(`#saleDetailsQuantity${id}, #saleDetailsUnitPrice${id}`).change(function(){
		calculateTotalInSales(id);
		calculateGrandTotal();
        calculateNetTotal();
	});
}

var rowCount = 0;
$('#saleDetailsItemAdd').on('click', function(){
	$(`#deleteSalesItem${rowCount}`).prop("disabled", true);
	rowCount++;
    addSalesItem(rowCount);
});

function calculateGrandTotal() {
	let tot = $(`#saleDetailsTotal`).val();
	tot = tot || 0;
	for (let index = 0; index < rowCount; index++) {
		const itemTotal = $(`#saleDetailsTotal${index+1}`).val();
		tot = Number(tot) + Number(itemTotal || 0);
	}
	$(`#salesOrderTotal`).val(tot);
}

function calculateTotalInSales(id){
	const quantityPT = $(`#saleDetailsQuantity${id}`).val();
	const unitPricePT = $(`#saleDetailsUnitPrice${id}`).val();
	$(`#saleDetailsTotal${id}`).val(Number(quantityPT) * Number(unitPricePT));
}

function deleteSalesItem(id) {
	$(`#addedRow${id}`).remove();
	rowCount--;
	$(`#deleteSalesItem${rowCount}`).prop("disabled", false);
	calculateGrandTotal();
    calculateNetTotal();
}

$('#deleteSalesItem').on('click', function(){
    deleteSalesItem();
});

function initSalesOrderList() {
	searchTableCreator('salesDetailsTableDiv1', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
}

function initSalesOrderItems() {
	$('#saleDetailsSaleDate').val();
	$('#saleDetailsDescription').val('');
	$('#saleDetailsCustomerName').val('');
	$(`#salesOrderTotal`).val('');
	$(`#saleDetailsItem`).val('');
    $(`#saleDetailsDiscountp`).val(0);
    
	for (let index = 0; index <= rowCount+1; index++) {
		deleteSalesItem(index+1);
	}
	rowCount = 0;
}

function initSalesOrder() {
	const currentDate =  new Date().toISOString().slice(0, 10);
	$('#saleDetailsSaleDate').val(currentDate);
	$.ajax({
		url: 'model/sale/nextSalesID.php',
		method: 'POST',
		success: function(data){
			$('#saleDetailsSaleID').val(data);
		}
	});

	initSalesOrderList();
	initSalesOrderItems();
	initCustomers();

	itemData = getSelect2ItemData(itemList);
	$('#saleDetailsItem').select2({
		data: itemData
	});
	itemSelectChange('');
	$('#addSaleButton').prop("disabled", true);
	$('#saleDetailsMessage').prop("display", "none");
	
} 

$('#saleDetailsItem').change(function(){
	itemSelectChange('');
});

function itemSelectChange(id) {
	const itemId = $(`#saleDetailsItem${id}`).val();
	const item = itemList.find(x => x.productID === itemId);
	$(`#saleDetailsUnitPrice${id}`).val(item ? item.sellingPrice : 0);
}

// Calculate Total in sale tab
$('#saleDetailsQuantity, #saleDetailsUnitPrice').change(function(){
    calculateTotalInSales('');
    calculateGrandTotal();
    calculateNetTotal();
});

function calculateNetTotal(){
    const tot = $(`#salesOrderTotal`).val();
    const discountP = $('#saleDetailsDiscountp').val()
    const val= Math.round(Number(tot) * ((100 - Number(discountP)) / 100), 2);
    $('#salesOrderNetTotal').val(val);
	validateAddSales(val);
}

$('#saleDetailsDiscountp').change(function(){
    calculateNetTotal();
});

function initCustomers() {
	$.ajax({
		url: 'model/customer/getAllCustomers.php',
		method: 'POST',
		dataType: "json",
		success: function(data) {
			const customerData = getSelect2CustomerData(data);
			$('#saleDetailsCustomerName').select2({
				data: customerData
			});
		}
	});
}

// Listen to sale add button
$('#addSaleButton').on('click', function(){
	addSale();
});

function validateAddSales(netAmount) {
	$('#addSaleButton').prop("disabled", netAmount===0);
}
