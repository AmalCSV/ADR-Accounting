var itemData =[];
var order = {};
var orderItems = {};

// Function to call the insertPurchase.php script to insert purchase data to db
function addPurchase() {
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsDescription = $('#purchaseDetailsDescription').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var purchaseDetailsVendorName = $('#purchaseDetailsVendorName').val();
	const grandTotal= $(`#purchaseOrderTotal`).val();

	const purchaseItems = [];
	let item = {
		id: $('#purchaseDetailsItem').val(),
		buyingPrice: $('#purchaseDetailsUnitPrice').val(),
		quntity: $('#purchaseDetailsQuantity').val(),
		total: $(`#purchaseDetailsTotal`).val(),
		name: $(`#purchaseDetailsItem option:selected`).text(),
	};
	purchaseItems.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			id: $(`#purchaseDetailsItem${index+1}`).val(),
			buyingPrice: $(`#purchaseDetailsUnitPrice${index+1}`).val(),
			quntity: $(`#purchaseDetailsQuantity${index+1}`).val(),
			total: $(`#purchaseDetailsTotal${index+1}`).val(),
			name: $(`#purchaseDetailsItem${index+1} option:selected`).text(),
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
		id: $('#purchaseDetailsItem').val(),
		buyingPrice: $('#purchaseDetailsUnitPrice').val(),
		quntity: $('#purchaseDetailsQuantity').val(),
		total: $(`#purchaseDetailsTotal`).val(),
		name: $(`#purchaseDetailsItem option:selected`).text(),
	};
	purchaseItems.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			id: $(`#purchaseDetailsItem${index+1}`).val(),
			buyingPrice: $(`#purchaseDetailsUnitPrice${index+1}`).val(),
			quntity: $(`#purchaseDetailsQuantity${index+1}`).val(),
			total: $(`#purchaseDetailsTotal${index+1}`).val(),
			name: $(`#purchaseDetailsItem${index+1} option:selected`).text(),
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

function addPurchaseItem(id, viewType) {
    $("#poItemList").append( `
			<div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-4">
						<select id='purchaseDetailsItem${id}' class="form-control">
                        </select>
				    </div>
                    <div class="form-group col-md-2">
                        <input type="number" class="form-control" id="purchaseDetailsQuantity${id}" name="purchaseDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsUnitPrice${id}" name="purchaseDetailsUnitPrice${id}" value="0" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsTotal${id}" name="purchaseDetailsTotal${id}" readonly>
						<input type="hidden" id="purchaseItemId${id}" name="purchaseItemId${id}">
					</div>
					${viewType === 'GOOD_RECEIVED' ? `<div class="form-group col-md-1">
						<input type="number" class="form-control" id="purchaseDetailsGoodReceivedQuantity${id}" name="purchaseDetailsGoodReceivedQuantity${id}" value="0">
					</div>`:`
					<div class="form-group col-md-1">
						<button type="button" id="deletePurchaseItem${id}" onclick="deletePurchaseItem(${id})" class="btn btn-danger">Delete</button>
					</div>
					`}
                </div>
            </div>
	` );
	setPOSuggestionFunctions(id);
	setPOCalculationFunctions(id);
}

function setPOSuggestionFunctions(id) {
	$(`#purchaseDetailsItem${id}`).select2({
		data: itemData
	});
	purchaseItemSelectChange(id);
	$(`#purchaseDetailsItem${id}`).change(function(){
		purchaseItemSelectChange(id);
	});
}

$('#purchaseDetailsItem').change(function(){
	purchaseItemSelectChange('');
});

function purchaseItemSelectChange(id) {
	const itemId = $(`#purchaseDetailsItem${id}`).val();
	const item = itemList.find(x => x.productID === itemId);
	$(`#purchaseDetailsUnitPrice${id}`).val(item ? item.buyingPrice : 0);
}


function setPOCalculationFunctions(id) {
	$(`#purchaseDetailsItem${id} #purchaseDetailsQuantity${id}, #purchaseDetailsUnitPrice${id}`).change(function(){
		calculateTotalInPurchase(id);
		calculatePOGrandTotal();
	});
}

// Calculate Total in purchase tab
$('#purchaseDetailsQuantity, #purchaseDetailsItem, #purchaseDetailsUnitPrice').change(function(){
	calculateTotalInPurchaseTab();
	calculatePOGrandTotal();
});

function calculateTotalInPurchase(id){
	var quantityPT = $(`#purchaseDetailsQuantity${id}`).val();
	var unitPricePT = $(`#purchaseDetailsUnitPrice${id}`).val();
	$(`#purchaseDetailsTotal${id}`).val(Number(quantityPT) * Number(unitPricePT));
}

function deletePurchaseItem(id) {
	$(`#addedRow${id}`).remove();
	rowCount--;
	$(`#deletePurchaseItem${rowCount}`).prop("disabled", false);
	calculatePOGrandTotal();
}

$('#deletePurchaseItem').on('click', function(){
    deletePurchaseItem();
});

var rowCount = 0;
$('#addPurchaseItem').on('click', function(){
	$(`#deletePurchaseItem${rowCount}`).prop("disabled", true);
	rowCount++;
    addPurchaseItem(rowCount);
});

function calculatePOGrandTotal() {
	let tot = $(`#purchaseDetailsTotal`).val();
	tot = tot || 0;
	for (let index = 0; index < rowCount; index++) {
		const itemTotal = $(`#purchaseDetailsTotal${index+1}`).val();
		tot = Number(tot) + Number(itemTotal || 0);
	}
	$(`#purchaseOrderTotal`).val(tot);
	validateAddPurchases(tot);
}

function validateAddPurchases(netAmount) {
	$('#addPurchaseBtn').prop("disabled", netAmount===0);
}


function initPurchaseOrder() {
	const currentDate =  new Date().toISOString().slice(0, 10);
	$.ajax({
		url: 'model/purchase/nextPurchaseID.php',
		method: 'POST',
		success: function(data){
			$('#purchaseDetailsPurchaseID').val(data);
		}
	});

	initPurchaseOrderList();
	initPurchaseOrderItems();
	$('#purchaseDetailsPurchaseDate').val(currentDate);
	document.getElementById("goodReceivedData").style.display = "none";
	document.getElementById("addPurchaseItem").style.display = "block";
	document.getElementById("lableActionHeader").text = '#';
	document.getElementById("statusPO").style.display = "none";

	displayHideElements(["cancelPOBtn","sendPOBtn","closePOBtn", "goodReceivedBtn", "printPdfBtn"]); //updatePurchaseBtn
	displayElements(["clearBtn","addPurchaseBtn"])
	rowCount = 0;
	itemData = getSelect2ItemData(itemList);
	$('#purchaseDetailsItem').select2({
		data: itemData
	});

	purchaseItemSelectChange('');
	$('#addPurchaseBtn').prop("disabled", true);
} 


function onSelectName(itemName, id) {
	if (itemName && itemName != "") {
	  const data = itemList.find(x => x.itemName == itemName);
	  if (data) {
		$(`#${id}`).val(data.itemNumber);
		selectItem(data);
	  }
	}
  }
  
  function onSelectNumber(itemNumber, id) {
	if (itemNumber && itemNumber != "") {
	  var data = itemList.find(x => x.itemNumber == itemNumber);
	  if (data) {
		$(`#${id}`).val(data.itemName);
		selectItem(data);
	  }
	}
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
	$(`#purchaseOrderId`).val('');

	for (let index = 0; index <= rowCount+1; index++) {
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
			loadDataToPurchaseOrder(data, viewType);
		}
	});	
}

function openGoodReceive(purchaseOrderId) {
	openEditView(purchaseOrderId, 'GOOD_RECEIVED');
}

function loadDataToPurchaseOrder(data, viewType){
	const {purchaseOrder, purchaseOrderItems} = JSON.parse(data);
	order = purchaseOrder;
	orderItems = purchaseOrderItems;
	$('#purchaseDetailsPurchaseDate').val(purchaseOrder.orderDate);
	$('#purchaseDetailsDescription').val(purchaseOrder.description);
	$('#purchaseDetailsPurchaseID').val(purchaseOrder.orderNumber);
	$('#purchaseDetailsVendorName').val(purchaseOrder.fullName);
	$(`#purchaseOrderTotal`).val(purchaseOrder.amount);
	$(`#purchaseOrderId`).val(purchaseOrder.purchaseID);

	document.getElementById("statusPO").style.display = "block";
	$(`#statusPOText`).text(purchaseOrder.statusText);

	for (let index = 0; index < purchaseOrderItems.length; index++) {
		const numberText = index === 0 ? '' : index;
		
		$(`#purchaseDetailsItem${numberText}`).val(purchaseOrderItems[index].itemNumber);
		$(`#purchaseDetailsUnitPrice${numberText}`).val(purchaseOrderItems[index].unitPrice);
		$(`#purchaseDetailsQuantity${numberText}`).val(purchaseOrderItems[index].quantity);
		$(`#purchaseDetailsTotal${numberText}`).val(purchaseOrderItems[index].totalPrice);
		$(`#purchaseItemId${numberText}`).val(purchaseOrderItems[index].purchaseItemID);

		if(viewType === 'GOOD_RECEIVED' || viewType === 'VIEW'){
			disableElements([`purchaseDetailsItem${numberText}`,`purchaseDetailsUnitPrice${numberText}`,`purchaseDetailsQuantity${numberText}`,
			`purchaseDetailsTotal${numberText}`]);
		}
		if(index>0 && index+1 !== purchaseOrderItems.length){
			rowCount++;
    		addPurchaseItem(rowCount, viewType);
		}
	}

	if(viewType === 'GOOD_RECEIVED' || viewType === 'VIEW'){
		disableElements([`purchaseDetailsItem`,`purchaseDetailsUnitPrice`,`purchaseDetailsQuantity`,
			`purchaseDetailsTotal`, 'purchaseDetailsDescription', 'purchaseDetailsPurchaseID'
		,'purchaseDetailsVendorName']);


		//document.getElementById("updatePurchaseBtn").disabled = true;
		document.getElementById("addPurchaseItem").style.display = "none";
		switch (viewType) {
			case 'GOOD_RECEIVED':
				displayElements(["goodReceivedBtn"]);
				displayHideElements(["cancelPOBtn", "sendPOBtn", "closePOBtn", "addPurchaseBtn", "clearBtn"]);
				document.getElementById("goodReceivedData").style.display = "block";
				document.getElementById("lableActionHeader").text = "Received";
				break;
		
			case 'VIEW':
				switch (purchaseOrder.status) {
					case '1':
						displayHideElements(["goodReceivedBtn", "closePOBtn", "addPurchaseBtn", "clearBtn" ]);
						displayElements(["sendPOBtn", "cancelPOBtn", "printPdfBtn"]);
						break;
					case '2':
						displayElements(["cancelPOBtn", "closePOBtn"]);
						displayHideElements(["goodReceivedBtn", "sendPOBtn", "printPdfBtn", "addPurchaseBtn", "clearBtn" ]);	
						break;
					case '3':
						displayHideElements(["goodReceivedBtn", "sendPOBtn", "closePOBtn", "printPdfBtn", "addPurchaseBtn", "clearBtn" ]);
						displayElements(["cancelPOBtn"]);
						break;
					default:
						displayHideElements(["goodReceivedBtn", "sendPOBtn", "closePOBtn", "cancelPOBtn", "printPdfBtn", "addPurchaseBtn", "clearBtn" ]);
						break;
				}
				break;
			default:
				break;
		}
	} else{
		displayHideElements(["clearBtn", "addPurchaseBtn"]);
		document.getElementById("cancelPOBtn").disabled = purchaseOrder.status === 3;
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
		itemNumber: $('#purchaseDetailsItem').val(),
		id: $('#purchaseItemId').val(),
		goodReceived: $(`#purchaseDetailsGoodReceivedQuantity`).val(),
	};
	items.push(item);

	for (let index = 0; index < rowCount; index++) {
		item = {
			itemNumber: $(`#purchaseDetailsItem${index+1}`).val(),
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

function updatePO(statusId, status) {
	const purchaseId = $(`#purchaseOrderId`).val();
		$.ajax({
			url: 'model/purchase/updateStatus.php',
			data: {
				purchaseID: purchaseId,
				statusId: statusId
			},
			method: 'POST',
			success: function(data){
				$('#purchaseDetailsMessage').fadeIn();
				$('#purchaseDetailsMessage').html(data);
				$(`#statusPOText`).text(status);
			}
		});	
	}

function sendPO() {
	updatePO(2, 'Pending');
}

function CancelPO() {
	updatePO(4, 'Cancel');
}

function closePO() {
	updatePO(3, 'Close');
}


 // Read selected option
 $('#but_read').click(function(){
	 var username = $('#selUser option:selected').text();
	 var userid = $('#selUser').val();

	 $('#result').html("id : " + userid + ", name : " + username);
 });

 function printPurchaseOrderPdf(){
	downloadOrderPdf("PO", order, orderItems);
 }