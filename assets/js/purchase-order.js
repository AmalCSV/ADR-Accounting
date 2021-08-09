// Function to call the insertPurchase.php script to insert purchase data to db
function addPurchase() {
	var purchaseDetailsItemNumber = $('#purchaseDetailsItemNumber').val();
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsItemName = $('#purchaseDetailsItemName').val();
	var purchaseDetailsQuantity = $('#purchaseDetailsQuantity').val();
	var purchaseDetailsUnitPrice = $('#purchaseDetailsUnitPrice').val();
	var purchaseDetailsVendorName = $('#purchaseDetailsVendorName').val();
	
	$.ajax({
		url: 'model/purchase/insertPurchase.php',
		method: 'POST',
		data: {
			purchaseDetailsItemNumber:purchaseDetailsItemNumber,
			purchaseDetailsPurchaseDate:purchaseDetailsPurchaseDate,
			purchaseDetailsItemName:purchaseDetailsItemName,
			purchaseDetailsQuantity:purchaseDetailsQuantity,
			purchaseDetailsUnitPrice:purchaseDetailsUnitPrice,
			purchaseDetailsVendorName:purchaseDetailsVendorName,
		},
		success: function(data){
			$('#purchaseDetailsMessage').fadeIn();
			$('#purchaseDetailsMessage').html(data);
		},
		complete: function(){
			getItemStockToPopulate('purchaseDetailsItemNumber', getItemStockFile, 'purchaseDetailsCurrentStock');
			populateLastInsertedID(purchaseLastInsertedIDFile, 'purchaseDetailsPurchaseID');
			searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
			reportsPurchaseTableCreator('purchaseReportsTableDiv', purchaseReportsSearchTableCreatorFile, 'purchaseReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Listen to purchase add button
$('#addPurchase').on('click', function(){
    addPurchase();
});

// Function to call the updatePurchase.php script to update purchase data to db
function updatePurchase() {
	var purchaseDetailsItemNumber = $('#purchaseDetailsItemNumber').val();
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsItemName = $('#purchaseDetailsItemName').val();
	var purchaseDetailsQuantity = $('#purchaseDetailsQuantity').val();
	var purchaseDetailsUnitPrice = $('#purchaseDetailsUnitPrice').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var purchaseDetailsVendorName = $('#purchaseDetailsVendorName').val();
	
	$.ajax({
		url: 'model/purchase/updatePurchase.php',
		method: 'POST',
		data: {
			purchaseDetailsItemNumber:purchaseDetailsItemNumber,
			purchaseDetailsPurchaseDate:purchaseDetailsPurchaseDate,
			purchaseDetailsItemName:purchaseDetailsItemName,
			purchaseDetailsQuantity:purchaseDetailsQuantity,
			purchaseDetailsUnitPrice:purchaseDetailsUnitPrice,
			purchaseDetailsPurchaseID:purchaseDetailsPurchaseID,
			purchaseDetailsVendorName:purchaseDetailsVendorName,
		},
		success: function(data){
			$('#purchaseDetailsMessage').fadeIn();
			$('#purchaseDetailsMessage').html(data);
		},
		complete: function(){
			getItemStockToPopulate('purchaseDetailsItemNumber', getItemStockFile, 'purchaseDetailsCurrentStock');
			searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
			reportsPurchaseTableCreator('purchaseReportsTableDiv', purchaseReportsSearchTableCreatorFile, 'purchaseReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Listen to update button in purchase details tab
$('#updatePurchaseDetailsButton').on('click', function(){
    updatePurchase();
});

function addPurchaseItem(id) {
    $("#poItemList").append( `
			<div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsItemNumber${id}" name="purchaseDetailsItemNumber${id}" autocomplete="off">
                        <div id="purchaseDetailsItemNumberSuggestionsDiv${id}" class="customListDivWidth"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control invTooltip" id="purchaseDetailsItemName${id}" name="purchaseDetailsItemName${id}" readonly title="This will be auto-filled when you enter the item number above">
                    </div>
                    <div class="form-group col-md-1">
                        <input type="text" class="form-control" id="purchaseDetailsCurrentStock${id}" name="purchaseDetailsCurrentStock${id}" readonly>
                    </div>
                    <div class="form-group col-md-1">
                        <input type="number" class="form-control" id="purchaseDetailsQuantity${id}" name="purchaseDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsUnitPrice${id}" name="purchaseDetailsUnitPrice${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsTotal${id}" name="purchaseDetailsTotal${id}" readonly>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="button" id="deletePurchaseItem${id}" onclick="deletePurchaseItem(${id})" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
	` );
	setSuggestionFunctions(id);
	setCalculationFunctions(id);
}

function setSuggestionFunctions(id) {
	$(`#purchaseDetailsItemNumber${id}`).keyup(function(){
		showSuggestions(`purchaseDetailsItemNumber${id}`, showItemNumberForPurchaseTabFile, `purchaseDetailsItemNumberSuggestionsDiv${id}`);
	});

	$(document).on('click', `#purchaseDetailsItemNumberSuggestionsList li`, function(){
		$(`#purchaseDetailsItemNumber${id}`).val($(this).text());
		$(`#purchaseDetailsItemNumberSuggestionsList`).fadeOut();
		
		getItemName(`purchaseDetailsItemNumber${id}`, getItemNameFile, `purchaseDetailsItemName${id}`);
		getItemStockToPopulate(`purchaseDetailsItemNumber${id}`, getItemStockFile, `purchaseDetailsCurrentStock${id}`);
	});
}

function setCalculationFunctions(id) {
	$(`#purchaseDetailsQuantity${id}, #purchaseDetailsUnitPrice${id}`).change(function(){
		calculateTotalInPurchase(id);
	});
}

function calculateTotalInPurchase(id){
	var quantityPT = $(`#purchaseDetailsQuantity${id}`).val();
	var unitPricePT = $(`#purchaseDetailsUnitPrice${id}`).val();
	$(`#purchaseDetailsTotal${id}`).val(Number(quantityPT) * Number(unitPricePT));
	calculateGrandTotal();
}

function deletePurchaseItem(id) {
	$(`#addedRow${id}`).remove();
	rowCount--;
}

$('#deletePurchaseItem').on('click', function(){
    deletePurchaseItem();
});

var rowCount = 0;
$('#addPurchaseItem').on('click', function(){
	rowCount++;
    addPurchaseItem(rowCount);
});

function calculateGrandTotal() {
	let tot = $(`#purchaseDetailsTotal`).val();
	tot = tot || 0;
	for (let index = 0; index < rowCount; index++) {
		const itemTotal = $(`#purchaseDetailsTotal${index+1}`).val();
		tot = Number(tot) + Number(itemTotal || 0);
	}
	$(`#purchaseOrderTotal`).val(tot);
}
