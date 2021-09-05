var itemList = [];
var order = {};
var orderItems = {};

// File that creates the purchase details search table
purchaseDetailsSearchTableCreatorFile = 'model/purchase/purchaseDetailsSearchTableCreator.php';
purchasePaymentTableCreatorFile = 'model/purchase/purchasePaymentTableCreator.php';
// File that creates the purchase reports search table
purchaseReportsSearchTableCreatorFile = 'model/purchase/purchaseReportsSearchTableCreator.php';

// Calculate Total Purchase value in purchase details tab
function calculateTotalInPurchaseTab(){
	var quantityPT = $('#purchaseDetailsQuantity').val();
	var unitPricePT = $('#purchaseDetailsUnitPrice').val();
	$('#purchaseDetailsTotal').val(Number(quantityPT) * Number(unitPricePT));
}

// Function to call the insertPurchase.php script to insert purchase data to db
function addPurchase() {
  let errorText = null;
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsDescription = $('#purchaseDetailsDescription').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var vendorID = $('#purchaseDetailsVendorName').val();
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
    const duplicateItem = purchaseItems.find(x => x.id ===item.id)
    if(duplicateItem){
      errorText = 'Duplicate Items in the list';
      return;
    }
		purchaseItems.push(item);
	}

  if(errorText == null && !!purchaseItems.find(x => !x.quntity || x.quntity == 0)){
    errorText = 'Quantity 0 item in the list';
  }

  if( errorText == null) {
    $.ajax({
      url: 'model/purchase/insertPurchase.php',
      method: 'POST',
      data: {
        purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
        purchaseDetailsGrandTotal: grandTotal,
        purchaseDetailsDescription: purchaseDetailsDescription,
        purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
        vendorID: vendorID,
        purchaseItems: purchaseItems,
      },
      success: function(data){
        $('#purchaseDetailsMessage').html(data);
        $('#purchaseDetailsMessage').fadeOut(1000).fadeIn(500, function() {
        //  window.location.href += '#purchaseDetailsTab';
        //  window.location.reload();
        });
        
      },
      complete: function(){
        populateLastInsertedID('model/purchase/nextPurchaseID.php', 'purchaseDetailsPurchaseID');
        searchTableCreator('purchaseDetailsTableDiv1', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
      //	searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
      //	reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
  
        $('#addPurchaseBtn').prop('disabled', true);
      }
    });
  }
  else {
    $('#purchaseDetailsMessage').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+errorText+'</div>');
    $('#purchaseDetailsMessage').fadeOut(1000).fadeIn(500, function() {});
  }
}

// Listen to purchase add button
$("#addPurchaseBtn").on("click", function () {
  addPurchase();
});

// Function to call the updatePurchase.php script to update purchase data to db
function updatePurchase() {
  let errorText = null;
	var purchaseDetailsPurchaseDate = $('#purchaseDetailsPurchaseDate').val();
	var purchaseDetailsDescription = $('#purchaseDetailsDescription').val();
	var purchaseDetailsPurchaseID = $('#purchaseDetailsPurchaseID').val();
	var vendorID = $('#purchaseDetailsVendorName').val();
  const purchaseOrderId = $('#purchaseOrderId').val();
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
    const duplicateItem = purchaseItems.find(x => x.id ===item.id)
    if(duplicateItem){
      errorText = 'Duplicate Items in the list';
      return;
    }
		purchaseItems.push(item);
	}

  if(errorText == null && !!purchaseItems.find(x => !x.quntity || x.quntity == 0)){
    errorText = 'Quantity 0 item in the list';
  }

  if( errorText == null) {
    $.ajax({
      url: "model/purchase/updatePurchase.php",
      method: "POST",
      data: {
        purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
        purchaseDetailsGrandTotal: grandTotal,
        purchaseDetailsDescription: purchaseDetailsDescription,
        purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
        vendorID: vendorID,
        purchaseItems: purchaseItems,
        purchaseOrderId: purchaseOrderId,
      },
      success: function (data) {
        $("#purchaseDetailsMessage").fadeOut(1000).fadeIn(500, function() {});
        $("#purchaseDetailsMessage").html(data);
      },
      complete: function () {
        searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      }
    });
  } else {
    $('#purchaseDetailsMessage').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+errorText+'</div>');
    $('#purchaseDetailsMessage').fadeOut(1000).fadeIn(500, function() {});
  }
}

// Listen to update button in purchase details tab
$("#updatePurchaseDetailsButton").on("click", function () {
  updatePurchase();
});

function addPurchaseItem(id, viewType) {
  $("#poItemList").append(
    `
			<div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-3">
						<select id='purchaseDetailsItem${id}' name='purchaseDetailsItem${id}' class="form-control" style="width: 100%">
                        </select>
				    </div>
					<div class="form-group col-md-1">
                        <input type="number" class="form-control" id="purchaseDetailsAvalableQuantity${id}" name="purchaseDetailsAvalableQuantity${id}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="number" class="form-control" id="purchaseDetailsQuantity${id}" name="purchaseDetailsQuantity${id}" value="0" min="1">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsUnitPrice${id}" name="purchaseDetailsUnitPrice${id}" value="0" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsTotal${id}" name="purchaseDetailsTotal${id}" readonly>
						<input type="hidden" id="purchaseItemId${id}" name="purchaseItemId${id}">
					</div>
					${viewType === "GOOD_RECEIVED"
    ? `<div class="form-group col-md-1">
						<input type="number" class="form-control" id="purchaseDetailsGoodReceivedQuantity${id}" name="purchaseDetailsGoodReceivedQuantity${id}" value="0">
					</div>`
    : `
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
		placeholder: {text: "Select Item"},
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
	$(`#purchaseDetailsAvalableQuantity${id}`).val(item ? item.stock : 0);
	
}

function setPOCalculationFunctions(id) {
	$(`#purchaseDetailsItem${id}, #purchaseDetailsQuantity${id}, #purchaseDetailsUnitPrice${id}`).keyup(function(){
		calculateTotalInPurchase(id);
		calculatePOGrandTotal();
	});
}

// Calculate Total in purchase tab
$('#purchaseDetailsQuantity, #purchaseDetailsItem, #purchaseDetailsUnitPrice').keyup(function(){
	calculateTotalInPurchaseTab();
	calculatePOGrandTotal();
});

function calculateTotalInPurchase(id) {
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

$("#deletePurchaseItem").on("click", function () {
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


function initPurchaseOrder(isClear) {
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
  $("#poPaymentsTab").prop("disabled", true);
	$('#purchaseDetailsPurchaseDate').val(currentDate);
  $('#purchaseOrderTotal').val('');
  
	document.getElementById("goodReceivedData").style.display = "none";
	document.getElementById("addPurchaseItem").style.display = "block";
  $('#addPurchaseItem').prop('disabled', true);
	document.getElementById("lableActionHeader").text = '#';
	document.getElementById("statusPO").style.display = "none";

	displayHideElements(["cancelPOBtn","sendPOBtn","closePOBtn", "goodReceivedBtn", "printPdfBtn", "updatePurchaseBtn"]); //updatePurchaseBtn
	displayElements(["clearBtn","addPurchaseBtn"])
  const vendorId = $('#purchaseDetailsVendorName').val();
	rowCount = 0;
 
    setPOItemList(isClear? null: itemList);
  
 
  searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
	$('#addPurchaseBtn').prop("disabled", true);
  enableElements([`purchaseDetailsItem`,`purchaseDetailsQuantity`,
   'purchaseDetailsDescription', 'purchaseDetailsPurchaseID'
 ,'purchaseDetailsVendorName', 'purchaseDetailsQuantity']);

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
  searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
}

function initPurchaseOrderItems() {
	$('#purchaseDetailsPurchaseDate').val('');
	$('#purchaseDetailsDescription').val('');
	$('#purchaseDetailsPurchaseID').val('');
	$('#purchaseDetailsVendorName').val('');
	$(`#purchaseDetailsTotal`).val('');
	$(`#purchaseOrderId`).val('');
  
  $("#purchaseDetailsItem").select2({data: [{id: '', text: ''}]});

  $(`#purchaseDetailsQuantity`).val('');
  

	for (let index = 0; index <= rowCount+1; index++) {
		deletePurchaseItem(index+1);
	}
}

function openEditView(purchaseOrderId, viewType) {
  const tab = document.getElementById("purchaseOrderTab");
  tab.click();
  $.ajax({
    url: "model/purchase/getPurchaseOrder.php",
    data: {
      purchaseID: purchaseOrderId
    },
    method: "POST",
    success: function (poData) {
      let {purchaseOrder} = JSON.parse(poData);
      $.ajax({
        url: "model/item/getAllItems.php",
        method: "POST",
        dataType: "json",
        data: {
          vendorId: purchaseOrder.vendorID
        },
        success: function (data) {
          itemList = data;
          itemData = getSelect2ItemData(itemList);
          $("#purchaseDetailsItem").select2({
            data: itemData
          });
          loadDataToPurchaseOrder(poData, viewType);
        }
      });
    }
  });
}

function openGoodReceive(purchaseOrderId) {
	openEditView(purchaseOrderId, 'GOOD_RECEIVED');
}

function loadDataToPurchaseOrder(data, viewType){
	let {purchaseOrder, purchaseOrderItems} = JSON.parse(data);
	order = purchaseOrder;
	orderItems = purchaseOrderItems;
	$('#purchaseDetailsPurchaseDate').val(purchaseOrder.orderDate);
	$('#purchaseDetailsDescription').val(purchaseOrder.description);
	$('#purchaseDetailsPurchaseID').val(purchaseOrder.orderNumber);
  $('#purchaseDetailsVendorName').val(purchaseOrder.vendorID).trigger("chosen:updated");
	$(`#purchaseOrderTotal`).val(purchaseOrder.amount);
	$(`#purchaseOrderId`).val(purchaseOrder.purchaseID);
  rowCount =0;
	document.getElementById("statusPO").style.display = "flex";
	$(`#statusPOText`).text(purchaseOrder.statusText);

	for (let index = 0; index < purchaseOrderItems.length; index++) {
		const numberText = index === 0 ? '' : index;
		if(index>0){
			rowCount++;
    		addPurchaseItem(rowCount, viewType);
		}

    const itemNumberValue = purchaseOrderItems[index].itemNumber;
    $(`#purchaseDetailsItem${numberText}`).val(purchaseOrderItems[index].itemNumber.toString());
    $(`#purchaseDetailsItem${numberText}`).trigger('change');
		$(`#purchaseDetailsUnitPrice${numberText}`).val(purchaseOrderItems[index].unitPrice);
		$(`#purchaseDetailsQuantity${numberText}`).val(purchaseOrderItems[index].quantity);
		$(`#purchaseDetailsTotal${numberText}`).val(purchaseOrderItems[index].totalPrice);
		$(`#purchaseItemId${numberText}`).val(purchaseOrderItems[index].purchaseItemID);

		if(viewType === 'GOOD_RECEIVED' || viewType === 'VIEW'){
			disableElements([`purchaseDetailsItem${numberText}`,`purchaseDetailsQuantity${numberText}`]);
      if(index>0){
        $(`#deletePurchaseItem${numberText}`).prop('disabled', true);
      }
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
	} else if (viewType === 'EDIT') {
    displayElements(["updatePurchaseBtn" ]);
    displayHideElements(["clearBtn", "addPurchaseBtn"]);
  } else{
		displayHideElements(["clearBtn", "addPurchaseBtn"]);
		document.getElementById("cancelPOBtn").disabled = purchaseOrder.status === 3;
	} 
}

function openEditPurchaseOrder(purchaseOrderId) {
  openEditView(purchaseOrderId, "EDIT");
}

function openViewPurchaseOrder(purchaseOrderId) {
  openEditView(purchaseOrderId, "VIEW");
}

function updatePurchaseOrder() {
  updatePurchase();
}

function updateGoodReceived() {
  const items = [];
  let item = {
    itemNumber: $("#purchaseDetailsItem").val(),
    id: $("#purchaseItemId").val(),
    goodReceived: $(`#purchaseDetailsGoodReceivedQuantity`).val()
  };
  items.push(item);

  for (let index = 0; index < rowCount; index++) {
    item = {
      itemNumber: $(`#purchaseDetailsItem${index + 1}`).val(),
      id: $(`#purchaseItemId${index + 1}`).val(),
      goodReceived: $(`#purchaseDetailsGoodReceivedQuantity${index + 1}`).val()
    };
    items.push(item);
  }

  $.ajax({
    url: "model/goodReceive/insertGoodReceive.php",
    data: {
      items: items
    },
    method: "POST",
    success: function (data) {
      $("#purchaseDetailsMessage").fadeIn();
      $("#purchaseDetailsMessage").html(data);
      initPurchaseOrder();
      populateLastInsertedID("model/purchase/nextPurchaseID.php", "purchaseDetailsPurchaseID");
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
    }
  });
}

function updatePO(statusId, status) {
  const purchaseId = $(`#purchaseOrderId`).val();
  $.ajax({
    url: "model/purchase/updateStatus.php",
    data: {
      purchaseID: purchaseId,
      statusId: statusId
    },
    method: "POST",
    success: function (data) {
      $("#purchaseDetailsMessage").fadeIn();
      $("#purchaseDetailsMessage").html(data);
      $(`#statusPOText`).text(status);
    }
  });
}

function sendPO() {
  updatePO(2, "Pending");
}

function cancelPO() {
  updatePO(4, "Cancel");
}

function closePO() {
  updatePO(3, "Close");
}

// Read selected option
$("#but_read").click(function () {
  var username = $("#selUser option:selected").text();
  var userid = $("#selUser").val();

  $("#result").html("id : " + userid + ", name : " + username);
});

function printPurchaseOrderPdf() {
  downloadOrderPdf("PO", order, orderItems);
}

function showPayments(purchaseOrderId) {
  $("#poPaymentsTab").prop("disabled", false);
  const tab = document.getElementById("poPaymentsTab");
  tab.click();

  $.ajax({
    url: "model/purchase/getPurchaseOrder.php",
    data: {
      purchaseID: purchaseOrderId
    },
    method: "POST",
    success: function (data) {
      loadPayments(data);
    }
  });
}

function loadPayments(data) {
  const {purchaseOrder} = JSON.parse(data);
  let credit = parseFloat(purchaseOrder.amount) - parseFloat(purchaseOrder.paidAmount);

  $("#paymentOrderId").val(purchaseOrder.purchaseID);
  $("#totalAmount").html(purchaseOrder.amount);
  $("#creditAmount").html(credit);
  $("#paidAmount").html(purchaseOrder.paidAmount);
  $("#poNumber").html(purchaseOrder.orderNumber);
  $("#vendor").html(purchaseOrder.fullName);
  let status = purchaseOrder.amount == purchaseOrder.paidAmount ? " Settled" : " Need to pay"
  $("#paymentStatus").html(status);
  
  initPurchaseOrderPaymentList(purchaseOrder.purchaseID);
}

function initPurchaseOrderPaymentList(orderId) {
  $.ajax({
    url: purchasePaymentTableCreatorFile,
    method: "POST",
    data: {
      orderId: orderId
    },
    success: function (data) {
      $("#purchasePaymentsTableDiv").empty();
      $("#purchasePaymentsTableDiv").html(data);
    },
    complete: function () {}
  });
}

$("#paymentType").on("change", function () {
  var selectedValue = $(this).val();
  if (selectedValue === "Cheque") {
    showPOChequeDetails(true);
  } else {
    showPOChequeDetails(false);
  }
});

function showPOChequeDetails(show) {
  if (show) {
    $("#chequeDateDiv").removeClass("d-none");
    $("#chequeNoDiv").removeClass("d-none");
  } else {
    $("#chequeDateDiv").addClass("d-none");
    $("#chequeNoDiv").addClass("d-none");
  }
}

// Function to call the insertPurchase.php script to insert purchase data to db
function addPayment() {
  var paymentType = $("#paymentType").val();
  var chequeNo = $("#chequeNo").val();
  var chequeDate = $("#chequeDate").val();

  if(paymentType == "Cash"){
    insertPayment();
  }
  else if (paymentType == "Cheque") {
    if (chequeNo != "" && chequeDate != "") {
      insertPayment();
    } else {
      $("#PaymentDetailsMessage").fadeIn();
      showPaymentMessages("Please add cheque details", "error");

    }
  } 
}

function insertPayment() {
  var orderId = $("#paymentOrderId").val();
  var paymentAmount = $("#paymentAmount").val();
  var paymentDate = $("#paymentDate").val();
  var paymentType = $("#paymentType").val();
  var chequeNo = $("#chequeNo").val();
  var chequeDate = $("#chequeDate").val();
  var totalBill = $("#totalAmount").text();
  var note = $("#paymentNote").val();
  var creditAmount = $("#creditAmount").text();
  var remainingAmount = parseFloat(paymentAmount) - parseFloat(totalBill);

  if (!isNaN(parseFloat(paymentAmount)) && !isNaN(remainingAmount) && parseFloat(paymentAmount) <= parseFloat(creditAmount)) {
    $.ajax({
      url: "model/purchase/insertPayment.php",
      method: "POST",
      data: {
        orderId: orderId,
        paymentAmount: paymentAmount,
        paymentDate: paymentDate,
        paymentType: paymentType,
        chequeNo: chequeNo,
        chequeDate: chequeDate,
        remainingAmount: remainingAmount,
        note: note
      },
      success: function (data) {
        $("#PaymentDetailsMessage").fadeIn();
        $("#clearPaymentFormBtn").trigger("click");
        showPaymentMessages("Payment added successfully", "success");
      },
      complete: function () {
        showPayments(orderId);
        initPurchaseOrderPaymentList(orderId);
        searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
        reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      }
    });
  } else {
    showPaymentMessages("Invalid amount. Please re-check the amount", "error");
  }
}

$("#clearPaymentFormBtn").on("click", function () {
  showPOChequeDetails(false);
  $("#PaymentDetailsMessage").html("");
});

function showPaymentMessages(txt, type) {
  let msgType = "";
  switch (type) {
    case "success":
      msgType = "alert-success";
      break;
    case "error":
      msgType = "alert-danger";
      break;
    default:
      msgType = "alert-info";
  }

  let msg = '<div class="alert ' + msgType + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + txt + "</div>";
  $("#PaymentDetailsMessage").html(msg);
}

function deletePaymentPopup(paymentId) {
  bootbox.confirm("Are you sure you want to delete?", function (result) {
    if (result) {
      var orderId = $("#paymentOrderId").val();
      deletePayment(paymentId);
    }
  });
}

function deletePayment(paymentId){
  var orderId = $("#paymentOrderId").val();

  $.ajax({
    url: "model/purchase/deletePayment.php",
    method: "POST",
    data: {
      paymentId: paymentId
    },
    success: function (data) {
      $("#PaymentDetailsMessage").empty();
      $("#PaymentDetailsMessage").html(data);
      initPurchaseOrderPaymentList(orderId);
    },
    complete: function () {
      showPayments(orderId);
      initPurchaseOrderPaymentList(orderId);
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
    }
  });

}

function updateChequeStatusPopup(paymentId, amount) {

  var creditAmount = $("#creditAmount").text();

  if(parseFloat(creditAmount) <= 0 ){
    showPaymentMessages("This bill is already settled.", "error");
  }
  else if(parseFloat(amount) > parseFloat(creditAmount)){
    showPaymentMessages("This amount will be added extra payment to the vendor.", "error");
  }
  else if ( parseFloat(creditAmount)>0 && parseFloat(amount) <= parseFloat(creditAmount)) {
    bootbox.dialog({
      message: "<p>Deposit or Cancel Cheque ?</p>",
      size: 'medium',
      buttons: {
          cancel: {
              label: "Cancel cheque",
              className: 'btn-primary',
              callback: function(){
                  updateChequeStatus(paymentId, "Canceled");
              }
          },
          noclose: {
              label: "Deposit cheque",
              className: 'btn-info',
              callback: function(){
                  updateChequeStatus(paymentId, "Deposited");
              }
          }
      }
    });
  }
  else{
    showPaymentMessages("An error occurred. Please try again.", "error");
  }
}

function updateChequeStatus(paymentId, status){
  var orderId = $("#paymentOrderId").val();
  let note = status + " on " + getToday();
  $.ajax({
    url: "model/purchase/updateChequeStatus.php",
    method: "POST",
    data: {
      paymentId: paymentId,
      status : status, 
      note: note
    },
    success: function (data) {
      $("#PaymentDetailsMessage").empty();
      $("#PaymentDetailsMessage").html(data);
      initPurchaseOrderPaymentList(orderId);
    },
    complete: function () {
      showPayments(orderId);
      initPurchaseOrderPaymentList(orderId);
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
    }
  });
}

$("#purchaseDetailsVendorName").on("change", function () {
  const selectedValue = $(this).val();
  initItems(selectedValue);
});

function initItems(vendorId) {
    $.ajax({
      url: "model/item/getAllItems.php",
      method: "POST",
      dataType: "json",
      data: {
        vendorId: vendorId
      },
      success: function (data) {
        itemList = data;
        setPOItemList(itemList);
      }
    });

    $('#addPurchaseItem').prop('disabled', !(vendorId>0));
    $('#addPurchaseBtn').prop("disabled", !(vendorId>0));
}

function setPOItemList(items){
	itemData = items && items.length? getSelect2ItemData(items): [];
  $("#purchaseDetailsItem").empty().trigger("change");
  $("#purchaseDetailsItem").select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	purchaseItemSelectChange('');

  for (let index = 0; index < rowCount; index++) {
  $(`#purchaseDetailsItem${index+1}`).empty().trigger("change");
  $(`#purchaseDetailsItem${index+1}`).select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	purchaseItemSelectChange(index+1);
  }
}

initPurchaseOrder();
