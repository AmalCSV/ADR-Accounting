var itemData = [];
var order = {};
var orderItems = {};

// Function to call the insertPurchase.php script to insert purchase data to db
function addPurchase() {
  var purchaseDetailsPurchaseDate = $("#purchaseDetailsPurchaseDate").val();
  var purchaseDetailsDescription = $("#purchaseDetailsDescription").val();
  var purchaseDetailsPurchaseID = $("#purchaseDetailsPurchaseID").val();
  var purchaseDetailsVendorName = $("#purchaseDetailsVendorName").val();
  const grandTotal = $(`#purchaseOrderTotal`).val();

  const purchaseItems = [];
  let item = {
    id: $("#purchaseDetailsItem").val(),
    buyingPrice: $("#purchaseDetailsUnitPrice").val(),
    quntity: $("#purchaseDetailsQuantity").val(),
    total: $(`#purchaseDetailsTotal`).val(),
    name: $(`#purchaseDetailsItem option:selected`).text()
  };
  purchaseItems.push(item);

  for (let index = 0; index < rowCount; index++) {
    item = {
      id: $(`#purchaseDetailsItem${index + 1}`).val(),
      buyingPrice: $(`#purchaseDetailsUnitPrice${index + 1}`).val(),
      quntity: $(`#purchaseDetailsQuantity${index + 1}`).val(),
      total: $(`#purchaseDetailsTotal${index + 1}`).val(),
      name: $(`#purchaseDetailsItem${index + 1} option:selected`).text()
    };
    purchaseItems.push(item);
  }

  $.ajax({
    url: "model/purchase/insertPurchase.php",
    method: "POST",
    data: {
      purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
      purchaseDetailsGrandTotal: grandTotal,
      purchaseDetailsDescription: purchaseDetailsDescription,
      purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
      purchaseDetailsVendorName: purchaseDetailsVendorName,
      purchaseItems: purchaseItems
    },
    success: function (data) {
      $("#purchaseDetailsMessage").fadeIn();
      $("#purchaseDetailsMessage").html(data);
    },
    complete: function () {
      populateLastInsertedID("model/purchase/nextPurchaseID.php", "purchaseDetailsPurchaseID");
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
    }
  });
}

// Listen to purchase add button
$("#addPurchaseBtn").on("click", function () {
  addPurchase();
});

// Function to call the updatePurchase.php script to update purchase data to db
function updatePurchase() {
  var purchaseDetailsPurchaseDate = $("#purchaseDetailsPurchaseDate").val();
  var purchaseDetailsDescription = $("#purchaseDetailsDescription").val();
  var purchaseDetailsPurchaseID = $("#purchaseDetailsPurchaseID").val();
  var purchaseDetailsVendorName = $("#purchaseDetailsVendorName").val();
  const grandTotal = $(`#purchaseOrderTotal`).val();

  const purchaseItems = [];
  let item = {
    id: $("#purchaseDetailsItem").val(),
    buyingPrice: $("#purchaseDetailsUnitPrice").val(),
    quntity: $("#purchaseDetailsQuantity").val(),
    total: $(`#purchaseDetailsTotal`).val(),
    name: $(`#purchaseDetailsItem option:selected`).text()
  };
  purchaseItems.push(item);

  for (let index = 0; index < rowCount; index++) {
    item = {
      id: $(`#purchaseDetailsItem${index + 1}`).val(),
      buyingPrice: $(`#purchaseDetailsUnitPrice${index + 1}`).val(),
      quntity: $(`#purchaseDetailsQuantity${index + 1}`).val(),
      total: $(`#purchaseDetailsTotal${index + 1}`).val(),
      name: $(`#purchaseDetailsItem${index + 1} option:selected`).text()
    };
    purchaseItems.push(item);
  }

  $.ajax({
    url: "model/purchase/updatePurchase.php",
    method: "POST",
    data: {
      purchaseDetailsPurchaseDate: purchaseDetailsPurchaseDate,
      purchaseDetailsGrandTotal: grandTotal,
      purchaseDetailsDescription: purchaseDetailsDescription,
      purchaseDetailsPurchaseID: purchaseDetailsPurchaseID,
      purchaseDetailsVendorName: purchaseDetailsVendorName,
      purchaseItems: purchaseItems
    },
    success: function (data) {
      $("#purchaseDetailsMessage").fadeIn();
      $("#purchaseDetailsMessage").html(data);
    },
    complete: function () {
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
    }
  });
}

// Listen to update button in purchase details tab
$("#updatePurchaseDetailsButton").on("click", function () {
  updatePurchase();
});

function addPurchaseItem(id, viewType) {
  $("#poItemList").append(
    `
			<div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-4">
						<select id='purchaseDetailsItem${id}' class="form-control">
                        </select>
				    </div>
                    <div class="form-group col-md-2">
                        <input type="number" class="form-control" id="purchaseDetailsQuantity${id}" name="purchaseDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" id="purchaseDetailsUnitPrice${id}" name="purchaseDetailsUnitPrice${id}" value="0">
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
	`);
  setSuggestionFunctions(id);
  setCalculationFunctions(id);
}

function setSuggestionFunctions(id) {
  console.log(id);
  $(`#purchaseDetailsItem${id}`).select2({data: itemData});
}

function setCalculationFunctions(id) {
  $(`#purchaseDetailsQuantity${id}, #purchaseDetailsUnitPrice${id}`).change(function () {
    calculateTotalInPurchase(id);
    calculateGrandTotal();
  });
}

// Calculate Total in purchase tab
$("#purchaseDetailsQuantity, #purchaseDetailsUnitPrice").change(function () {
  calculateTotalInPurchaseTab();
  calculateGrandTotal();
});

function calculateTotalInPurchase(id) {
  var quantityPT = $(`#purchaseDetailsQuantity${id}`).val();
  var unitPricePT = $(`#purchaseDetailsUnitPrice${id}`).val();
  $(`#purchaseDetailsTotal${id}`).val(Number(quantityPT) * Number(unitPricePT));
}

function deletePurchaseItem(id) {
  $(`#addedRow${id}`).remove();
  rowCount--;
  calculateGrandTotal();
}

$("#deletePurchaseItem").on("click", function () {
  deletePurchaseItem();
});

var rowCount = 0;
$("#addPurchaseItem").on("click", function () {
  rowCount++;
  addPurchaseItem(rowCount);
});

function calculateGrandTotal() {
  let tot = $(`#purchaseDetailsTotal`).val();
  tot = tot || 0;
  for (let index = 0; index < rowCount; index++) {
    const itemTotal = $(`#purchaseDetailsTotal${index + 1}`).val();
    tot = Number(tot) + Number(itemTotal || 0);
  }
  $(`#purchaseOrderTotal`).val(tot);
}

function initPurchaseOrder() {
  const currentDate = new Date().toISOString().slice(0, 10);
  $("#purchaseDetailsPurchaseDate").val(currentDate);
  $.ajax({
    url: "model/purchase/nextPurchaseID.php",
    method: "POST",
    success: function (data) {
      $("#purchaseDetailsPurchaseID").val(data);
    }
  });

  initPurchaseOrderList();
  initPurchaseOrderItems();
  $("#poPaymentsTab").prop("disabled", true);

  document.getElementById("goodReceivedData").style.display = "none";

  document.getElementById("updatePurchaseBtn").disabled = true;
  document.getElementById("addPurchaseBtn").disabled = false;
  document.getElementById("addPurchaseItem").style.display = "block";
  document.getElementById("lableActionHeader").text = "#";
  document.getElementById("clearBtn").disabled = false;
  document.getElementById("statusPO").style.display = "none";

  document.getElementById("goodReceivedBtn").disabled = true;
  document.getElementById("closePOBtn").disabled = true;
  document.getElementById("sendPOBtn").disabled = true;
  document.getElementById("cancelPOBtn").disabled = true;

  itemData = getSelect2ItemData(itemList);
  $("#purchaseDetailsItem").select2({data: itemData});
}

function onSelectName(itemName, id) {
  console.log(itemName, id);
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
  searchTableCreator("purchaseDetailsTableDiv1", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
}

function initPurchaseOrderItems() {
  $("#purchaseDetailsPurchaseDate").val("");
  $("#purchaseDetailsDescription").val("");
  $("#purchaseDetailsPurchaseID").val("");
  $("#purchaseDetailsVendorName").val("");
  $(`#purchaseOrderTotal`).val("");
  $(`#purchaseOrderId`).val("");

  for (let index = 0; index < rowCount - 1; index++) {
    deletePurchaseItem(index + 1);
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
    success: function (data) {
      loadDataToPurchaseOrder(data, viewType);
    }
  });
}

function openGoodReceive(purchaseOrderId) {
  openEditView(purchaseOrderId, "GOOD_RECEIVED");
}

function loadDataToPurchaseOrder(data, viewType) {
  const {purchaseOrder, purchaseOrderItems} = JSON.parse(data);
  order = purchaseOrder;
  orderItems = purchaseOrderItems;
  $("#purchaseDetailsPurchaseDate").val(purchaseOrder.orderDate);
  $("#purchaseDetailsDescription").val(purchaseOrder.description);
  $("#purchaseDetailsPurchaseID").val(purchaseOrder.orderNumber);
  $("#purchaseDetailsVendorName").val(purchaseOrder.fullName);
  $(`#purchaseOrderTotal`).val(purchaseOrder.amount);
  $(`#purchaseOrderId`).val(purchaseOrder.purchaseID);

  document.getElementById("statusPO").style.display = "block";
  $(`#statusPOText`).text(purchaseOrder.statusText);

  for (let index = 0; index < purchaseOrderItems.length; index++) {
    const numberText = index === 0
      ? ""
      : index;

    $(`#purchaseDetailsItem${numberText}`).val(purchaseOrderItems[index].itemNumber);
    $(`#purchaseDetailsUnitPrice${numberText}`).val(purchaseOrderItems[index].unitPrice);
    $(`#purchaseDetailsQuantity${numberText}`).val(purchaseOrderItems[index].quantity);
    $(`#purchaseDetailsTotal${numberText}`).val(purchaseOrderItems[index].totalPrice);
    $(`#purchaseItemId${numberText}`).val(purchaseOrderItems[index].purchaseItemID);

    if (viewType === "GOOD_RECEIVED" || viewType === "VIEW") {
      disableElements([`purchaseDetailsItem${numberText}`, `purchaseDetailsUnitPrice${numberText}`, `purchaseDetailsQuantity${numberText}`, `purchaseDetailsTotal${numberText}`]);
    }
    if (index > 0 && index + 1 !== purchaseOrderItems.length) {
      rowCount++;
      addPurchaseItem(rowCount, viewType);
    }
  }

  if (viewType === "GOOD_RECEIVED" || viewType === "VIEW") {
    disableElements([
      `purchaseDetailsItem`,
      `purchaseDetailsUnitPrice`,
      `purchaseDetailsQuantity`,
      `purchaseDetailsTotal`,
      "purchaseDetailsDescription",
      "purchaseDetailsPurchaseID",
      "purchaseDetailsVendorName"
    ]);

    document.getElementById("updatePurchaseBtn").disabled = true;
    document.getElementById("addPurchaseBtn").disabled = true;
    document.getElementById("addPurchaseItem").style.display = "none";
    document.getElementById("clearBtn").disabled = true;

    switch (viewType) {
      case "GOOD_RECEIVED":
        document.getElementById("goodReceivedBtn").disabled = false;
        document.getElementById("closePOBtn").disabled = true;
        document.getElementById("sendPOBtn").disabled = true;
        document.getElementById("cancelPOBtn").disabled = true;
        document.getElementById("goodReceivedData").style.display = "block";
        document.getElementById("lableActionHeader").text = "Received";
        break;

      case "VIEW":
        document.getElementById("goodReceivedBtn").disabled = true;
        document.getElementById("closePOBtn").disabled = purchaseOrder.status !== 2;
        document.getElementById("sendPOBtn").disabled = purchaseOrder.status !== 1;
        document.getElementById("cancelPOBtn").disabled = purchaseOrder.status === 3;
        break;
      default:
        break;
    }
  } else {
    document.getElementById("updatePurchaseBtn").disabled = purchaseOrder.status !== 1;
    document.getElementById("cancelPOBtn").disabled = purchaseOrder.status === 3;
  }
}

function openEditPurchaseOrder(purchaseOrderId) {
  openEditView(purchaseOrderId, "EDIT");
}

function openViewPurchaseOrder(purchaseOrderId) {
  openEditView(purchaseOrderId, "VIEW");
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
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
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

function CancelPO() {
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

  if (paymentType == "Cheque" && !(chequeNo == "" || chequeDate == "")) {
    if (chequeNo != "" && chequeDate != "") {
      addPayment();
    } else {
      $("#PaymentDetailsMessage").fadeIn();
      $("#PaymentDetailsMessage").html("Please add cheque details");
    }
  } else {
    addPayment();
  }
}

function addPayment() {
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
        initPurchaseOrderPaymentList(orderId);
        searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
        reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      }
    });
  } else {
    showPaymentMessages("Invalid amount", "error");
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

    }
  });

}

function updateChequeStatusPopup(paymentId) {
  bootbox.dialog({
    message: "<p>Deposit or Cancel Cheque ?</p>",
    size: 'medium',
    buttons: {
        cancel: {
            label: "Cancel cheque",
            className: 'btn-primary',
            callback: function(){
                console.log('Custom cancel clicked');
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

    }
  });


}
