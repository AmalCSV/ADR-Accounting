// Function to call the insertPurchase.php script to insert purchase data to db
function addPurchase() {
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsDescription = $('#purchaseDetailsDescription').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var purchaseDetailsVendorName = $('#purchaseDetailsVendorName').val();
	const grandTotal= $(`#purchaseOrderTotal`).val();

	const purchaseItems = [];
	let item = {
		id: $('#purchaseDetailsItemNumber').val(),
		buyingPrice: $('#purchaseDetailsUnitPrice').val(),
		quntity: $('#purchaseDetailsQuantity').val(),
		total: $(`#purchaseDetailsTotal`).val(),
		name: $(`#purchaseDetailsItemName`).val(),
	};
	purchaseItems.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			id: $(`#purchaseDetailsItemNumber${index+1}`).val(),
			buyingPrice: $(`#purchaseDetailsUnitPrice${index+1}`).val(),
			quntity: $(`#purchaseDetailsQuantity${index+1}`).val(),
			total: $(`#purchaseDetailsTotal${index+1}`).val(),
			name: $(`#purchaseDetailsItemName${index+1}`).val(),
		};
		purchaseItems.push(item);
	}

	$.ajax({
		url: 'model/purchase/insertPurchase.php',
		method: 'POST',
		data: {
			purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
			purchaseDetailsGrandTotal: grandTotal,
			purchaseDetailsDescription: purchaseDetailsDescription,
			purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
			purchaseDetailsVendorName: purchaseDetailsVendorName,
			purchaseItems: purchaseItems,
		},
		success: function(data){
			$('#purchaseDetailsMessage').fadeIn();
			$('#purchaseDetailsMessage').html(data);
		},
		complete: function(){
			//getItemStockToPopulate('purchaseDetailsItemNumber', getItemStockFile, 'purchaseDetailsCurrentStock');
			//populateLastInsertedID(purchaseLastInsertedIDFile, 'purchaseDetailsPurchaseID');
			
			populateLastInsertedID('model/purchase/nextPurchaseID.php', 'purchaseDetailsPurchaseID');
			searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
			reportsPurchaseTableCreator('purchaseReportsTableDiv', purchaseReportsSearchTableCreatorFile, 'purchaseReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Listen to purchase add button
$('#addPurchaseBtn').on('click', function(){
    addPurchase();
});

// Function to call the updatePurchase.php script to update purchase data to db
function updatePurchase() {
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsDescription = $('#purchaseDetailsDescription').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var purchaseDetailsVendorName = $('#purchaseDetailsVendorName').val();
	const grandTotal= $(`#purchaseOrderTotal`).val();

	const purchaseItems = [];
	let item = {
		id: $('#purchaseDetailsItemNumber').val(),
		buyingPrice: $('#purchaseDetailsUnitPrice').val(),
		quntity: $('#purchaseDetailsQuantity').val(),
		total: $(`#purchaseDetailsTotal`).val(),
		name: $(`#purchaseDetailsItemName`).val(),
	};
	purchaseItems.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			id: $(`#purchaseDetailsItemNumber${index+1}`).val(),
			buyingPrice: $(`#purchaseDetailsUnitPrice${index+1}`).val(),
			quntity: $(`#purchaseDetailsQuantity${index+1}`).val(),
			total: $(`#purchaseDetailsTotal${index+1}`).val(),
			name: $(`#purchaseDetailsItemName${index+1}`).val(),
		};
		purchaseItems.push(item);
	}

	$.ajax({
		url: 'model/purchase/updatePurchase.php',
		method: 'POST',
		data: {
			purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
			purchaseDetailsGrandTotal: grandTotal,
			purchaseDetailsDescription: purchaseDetailsDescription,
			purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
			purchaseDetailsVendorName: purchaseDetailsVendorName,
			purchaseItems: purchaseItems,
		},
		success: function(data){
			$('#purchaseDetailsMessage').fadeIn();
			$('#purchaseDetailsMessage').html(data);
		},
		complete: function(){
			//getItemStockToPopulate('purchaseDetailsItemNumber', getItemStockFile, 'purchaseDetailsCurrentStock');
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

function addPurchaseItem(id, isGoodReceived) {
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
                        <input type="number" class="form-control" id="purchaseDetailsQuantity${id}" name="purchaseDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsUnitPrice${id}" name="purchaseDetailsUnitPrice${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsTotal${id}" name="purchaseDetailsTotal${id}" readonly>
                    </div>
					${isGoodReceived ? `<div class="form-group col-md-1"><input type="hidden" id="purchaseItemId${id}" name="purchaseItemId${id}">
						<input type="number" class="form-control" id="purchaseDetailsGoodReceivedQuantity${id}" name="purchaseDetailsGoodReceivedQuantity${id}" value="0">
					</div>`:`
					<div class="form-group col-md-1">
						<button type="button" id="deletePurchaseItem${id}" onclick="deletePurchaseItem(${id})" class="btn btn-danger">Delete</button>
					</div>
					`}
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
		//getItemStockToPopulate(`purchaseDetailsItemNumber${id}`, getItemStockFile, `purchaseDetailsCurrentStock${id}`);
	});
}

function setCalculationFunctions(id) {
	$(`#purchaseDetailsQuantity${id}, #purchaseDetailsUnitPrice${id}`).change(function(){
		calculateTotalInPurchase(id);
		calculateGrandTotal();
	});
}

// Calculate Total in purchase tab
$('#purchaseDetailsQuantity, #purchaseDetailsUnitPrice').change(function(){
	calculateTotalInPurchaseTab();
	calculateGrandTotal();
});

function calculateTotalInPurchase(id){
	var quantityPT = $(`#purchaseDetailsQuantity${id}`).val();
	var unitPricePT = $(`#purchaseDetailsUnitPrice${id}`).val();
	$(`#purchaseDetailsTotal${id}`).val(Number(quantityPT) * Number(unitPricePT));
}

function deletePurchaseItem(id) {
	$(`#addedRow${id}`).remove();
	rowCount--;
	calculateGrandTotal();
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

function initPurchaseOrder() {
	const currentDate =  new Date().toISOString().slice(0, 10);
	$('#purchaseDetailsPurchaseDate').val(currentDate);
	$.ajax({
		url: 'model/purchase/nextPurchaseID.php',
		method: 'POST',
		success: function(data){
			$('#purchaseDetailsPurchaseID').val(data);
		}
	});

	initPurchaseOrderList();
	initPurchaseOrderItems();
	document.getElementById("goodReceivedData").style.display = "none";
	document.getElementById("goodReceivedBtn").disabled = true
	document.getElementById("updatePurchaseBtn").disabled = true
	document.getElementById("addPurchaseBtn").disabled = false
	document.getElementById("addPurchaseItem").style.display = "block";
	document.getElementById("lableActionHeader").text = '#';
	document.getElementById("clearBtn").disabled = false;
}

function initPurchaseOrderList() {
	searchTableCreator('purchaseDetailsTableDiv1', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
}

function initPurchaseOrderItems() {
	$('#purchaseDetailsPurchaseDate').val('');
	$('#purchaseDetailsDescription').val('');
	$('#purchaseDetailsPurchaseID').val('');
	$('#purchaseDetailsVendorName').val('');
	$(`#purchaseOrderTotal`).val('');

	for (let index = 0; index < rowCount-1; index++) {
		deletePurchaseItem(index+1);
	}
}

function openEditView(purchaseOrderId, viewType) {
	const tab = document.getElementById('purchaseOrderTab');
	tab.click();
	$.ajax({
		url: 'model/purchase/getPurchaseOrder.php',
		data: {
			purchaseID: purchaseOrderId,
		},
		method: 'POST',
		success: function(data){
			loadDataToPurchaseOrder(data, viewType ==='GOOD_RECEIVED');
		}
	});	
}

function openGoodReceive(purchaseOrderId) {
	openEditView(purchaseOrderId, 'GOOD_RECEIVED');
}

function loadDataToPurchaseOrder(data, isGoodReceived){
	const {purchaseOrder, purchaseOrderItems} = JSON.parse(data);
	$('#purchaseDetailsPurchaseDate').val(purchaseOrder.orderDate);
	$('#purchaseDetailsDescription').val(purchaseOrder.description);
	$('#purchaseDetailsPurchaseID').val(purchaseOrder.orderNumber);
	$('#purchaseDetailsVendorName').val(purchaseOrder.fullName);
	$(`#purchaseOrderTotal`).val(purchaseOrder.amount);

	for (let index = 0; index < purchaseOrderItems.length; index++) {
		const numberText = index === 0 ? '' : index;
		
		$(`#purchaseDetailsItemNumber${numberText}`).val(purchaseOrderItems[index].itemNumber);
		$(`#purchaseDetailsUnitPrice${numberText}`).val(purchaseOrderItems[index].unitPrice);
		$(`#purchaseDetailsQuantity${numberText}`).val(purchaseOrderItems[index].quantity);
		$(`#purchaseDetailsTotal${numberText}`).val(purchaseOrderItems[index].totalPrice);
		$(`#purchaseDetailsItemName${numberText}`).val(purchaseOrderItems[index].itemName);
		$(`#purchaseItemId${numberText}`).val(purchaseOrderItems[index].purchaseItemID);
		
		if(isGoodReceived){
			//disableElements(['',])
		}
		if(index>0 && index+1 !== purchaseOrderItems.length){
			rowCount++;
    		addPurchaseItem(rowCount, isGoodReceived);
		}
	}

	if(isGoodReceived) {
		document.getElementById("goodReceivedData").style.display = "block";
		document.getElementById("goodReceivedBtn").disabled = false;
		document.getElementById("updatePurchaseBtn").disabled = true;
		document.getElementById("addPurchaseBtn").disabled = true;
		document.getElementById("addPurchaseItem").style.display = "none";
		document.getElementById("clearBtn").disabled = true;
		document.getElementById("lableActionHeader").text = "Received";
	}
}

function openEditPurchaseOrder(purchaseOrderId) {
	openEditView(purchaseOrderId, 'EDIT');
}

function openViewPurchaseOrder(purchaseOrderId) {
	openEditView(purchaseOrderId, 'VIEW');
}

function updateGoodReceived() {
	const items = [];
	let item = {
		itemNumber: $('#purchaseDetailsItemNumber').val(),
		id: $('#purchaseItemId').val(),
		goodReceived: $(`#purchaseDetailsGoodReceivedQuantity`).val(),
	};
	items.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			itemNumber: $(`#purchaseDetailsItemNumber${index+1}`).val(),
			id: $(`#purchaseItemId${index+1}`).val(),
			goodReceived: $(`#purchaseDetailsGoodReceivedQuantity${index+1}`).val(),
		};
		items.push(item);
	}

	$.ajax({
		url: 'model/goodReceive/insertGoodReceive.php',
		data: {
			items: items,
		},
		method: 'POST',
		success: function(data){
			$('#purchaseDetailsMessage').fadeIn();
			$('#purchaseDetailsMessage').html(data);
			initPurchaseOrder();
			populateLastInsertedID('model/purchase/nextPurchaseID.php', 'purchaseDetailsPurchaseID');
			searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
			reportsPurchaseTableCreator('purchaseReportsTableDiv', purchaseReportsSearchTableCreatorFile, 'purchaseReportsTable');
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});	
}
