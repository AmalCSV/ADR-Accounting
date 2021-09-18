var itemData = [];
var itemList = [];
// File that creates the sale details search table
saleDetailsSearchTableCreatorFile = 'model/sale/saleDetailsSearchTableCreator.php';
// File that creates the sale reports search table
saleReportsSearchTableCreatorFile = 'model/sale/saleReportsSearchTableCreator.php';

function getItem(id) {
  const item = itemList.find(x => x.productID === id);
  return item;
}

// Function to call the insertSale.php script to insert sale data to db
function addSale() {
  let errorText = null;
  var saleDetailsSaleID = $("#saleDetailsSaleID").val();
  var saleDetailsDiscount = $("#saleDetailsDiscountp").val();
  var saleDetailsCustomerID = $("#saleDetailsCustomerName").val();
  var saleDetailsCustomerName = $("#saleDetailsCustomerName option:selected").text();
  var saleDetailsSaleDate = $("#saleDetailsSaleDate").val();
  var salesOrderTotal = $("#salesOrderTotal").val();
  var salesOrderNetTotal = $("#salesOrderNetTotal").val();
  var salesDescription = $("#salesDescription").val();
  var saleDetailsVendorId = $("#saleDetailsVendorName").val();

  const salesItem = [];

  let itemId = $('#saleDetailsItem').val();
  let itemData = itemId ? getItem(itemId) : {};

  let item = {
    id: itemId,
    sellingPrice: $("#saleDetailsUnitPrice").val(),
    quntity: $("#saleDetailsQuantity").val(),
    total: $(`#saleDetailsTotal`).val(),
    name: itemData.itemName,
    itemNumber: itemData.itemNumber,
  };
  salesItem.push(item);

  for (let index = 0; index < rowCount; index++) {
    itemId = $(`#saleDetailsItem${index+1}`).val();
    itemData = itemId ? getItem(itemId) : {};
    item = {
      id: itemId,
      sellingPrice: $(`#saleDetailsUnitPrice${index + 1}`).val(),
      quntity: $(`#saleDetailsQuantity${index + 1}`).val(),
      total: $(`#saleDetailsTotal${index + 1}`).val(),
      name: itemData.itemName,
      itemNumber: itemData.itemNumber,
    };

    const duplicateItem = salesItem.find(x => x.id ===item.id)
    if(duplicateItem){
      errorText = 'Duplicate Items in the list';
    }
    salesItem.push(item);
  }

  if(errorText == null && !!salesItem.find(x => !x.quntity || x.quntity == 0)){
    errorText = 'Quantity 0 item in the list';
  }

  if( errorText == null) {
    $.ajax({
      url: "model/sale/insertSale.php",
      method: "POST",
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
        vendorId: saleDetailsVendorId,
      },
      success: function (data) { console.log(data)
        const result = $.parseJSON(data);
        $('#saleDetailsMessage').html(result.alertMessage);
        $('#saleDetailsMessage').fadeOut(1000).fadeIn(500, function() {
        //  window.location.href += '#saleDetailsTab';
        //  window.location.reload();
        });
        if(result.status ==='success'){
          openEditView(result.salesOrderId, 'EDIT')
        }
      },
      complete: function () {
        //reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
      }
    });
  }
  else {
    $('#saleDetailsMessage').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+errorText+'</div>');
    $('#saleDetailsMessage').fadeOut(1000).fadeIn(500, function() {});
  }
}

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
      setSOItemList(itemList);
    }
  });

}

function addSalesItem(id, viewType) {
  $("#salesItemList").append(`
			      <div class="form-row" id="addedRow${id}"> 
                    <div class="form-group col-md-3">
						            <select id='saleDetailsItem${id}' class="form-control" style="width: 100%">
                        </select>
				            </div>
                    <div class="form-group col-md-1">
                        <input type="number" class="form-control text-right" id="saleDetailsAvalableQuantity${id}" name="saleDetailsAvalableQuantity${id}" value="0" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="number" class="form-control text-right" id="saleDetailsQuantity${id}" name="saleDetailsQuantity${id}" value="0">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control text-right" id="saleDetailsUnitPrice${id}" name="saleDetailsUnitPrice${id}" value="0" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control text-right" id="saleDetailsTotal${id}" name="saleDetailsTotal${id}" readonly>
						<input type="hidden" id="saleItemId${id}" name="saleItemId${id}">
					</div>
          ${viewType === "DELIVERED" || (viewType === 'VIEW' && status === 5)
          ? `<div class="form-group col-md-1">
                  <input type="number" class="form-control" id="saleDetailsDeliveredQuantity${id}" name="saleDetailsDeliveredQuantity${id}" value="0">
                </div>`
          : `
					<div class="form-group col-md-1">
						<button type="button" id="deleteSaleItem${id}" onclick="deleteSaleItem(${id})" class="btn btn-danger">Delete</button>
					</div>`}
                </div>
            </div>
	`);
  setSOSuggestionFunctions(id);
  setCalculationFunctions(id);
}

function setSOSuggestionFunctions(id) {
	$(`#saleDetailsItem${id}`).select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	salesItemSelectChange(id);
	$(`#saleDetailsItem${id}`).change(function(){
		salesItemSelectChange(id);
	});
}

$('#saleDetailsItem').change(function(){
	salesItemSelectChange('');
});

function setCalculationFunctions(id) {
  $(`#saleDetailsQuantity${id}, #saleDetailsUnitPrice${id},  #saleDetailsItem${id}`).change(function () {
    calculateTotalInSales(id);
    calculateGrandTotal();
    calculateNetTotal();
  });
}

var rowCount = 0;
$("#saleDetailsItemAdd").on("click", function () {
  $(`#deleteSalesItem${rowCount}`).prop("disabled", true);
  rowCount++;
  addSalesItem(rowCount);
});

function calculateGrandTotal() {
  let tot = $(`#saleDetailsTotal`).val();
  tot = tot || 0;
  for (let index = 0; index < rowCount; index++) {
    const itemTotal = $(`#saleDetailsTotal${index + 1}`).val();
    tot = Number(tot) + Number(itemTotal || 0);
  }
  $(`#salesOrderTotal`).val(tot);
}

function calculateTotalInSales(id) {
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

$("#deleteSalesItem").on("click", function () {
  deleteSalesItem();
});

function initSalesOrderList() {
  searchTableCreator("salesDetailsTableDiv1", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
}

function initSalesOrderItems() {
  $("#saleDetailsSaleDate").val();
  $("#saleDetailsDescription").val("");
  $("#saleDetailsCustomerName").val("");
  $(`#salesOrderTotal`).val("");
  $(`#saleDetailsItem`).val("");
  $(`#saleDetailsDiscountp`).val(0);

  for (let index = 0; index <= rowCount + 1; index++) {
    deleteSalesItem(index + 1);
  }
  rowCount = 0;
}

function initSalesOrder(isClear) {
  const currentDate = new Date().toISOString().slice(0, 10);
  $("#saleDetailsSaleDate").val(currentDate);
  $.ajax({
    url: "model/sale/nextSalesID.php",
    method: "POST",
    success: function (data) {
      $("#saleDetailsSaleID").val(data);
    }
  });

  initSalesOrderList();
  initSalesOrderItems();
  initCustomers();
  $("#soPaymentsTab").prop("disabled", true);

  itemData = itemList ? getSelect2ItemData(itemList) : [];
  $("#saleDetailsItem").select2({data: itemData});
  salesItemSelectChange("");
  $("#addSaleButton").prop("disabled", true);
  $("#saleDetailsMessage").prop("display", "none");

  document.getElementById("deliveredData").style.display = "none";
	document.getElementById("saleDetailsItemAdd").style.display = "block";
  $('#saleDetailsItemAdd').prop('disabled', true);
	document.getElementById("lableActionHeader").text = '#';
	document.getElementById("statusSO").style.display = "none";

	displayHideElements(["cancelSOBtn","sendSOBtn","closeSOBtn", "deliveredBtn", "printPdfBtn", "updateSaleButton"]); //
	displayElements(["clearBtn","addSaleButton"])
  const vendorId = $('#saleDetailsVendorName').val();
	rowCount = 0;
 
    setSOItemList(isClear? null: itemList);
  
 
  searchTableCreator("salesDetailsTableDiv1", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
	$('#addSaleButton').prop("disabled", true);
  enableElements([`saleDetailsItem`,`saleDetailsQuantity`,
   'salesDescription', 'saleDetailsSaleID'
 ,'saleDetailsVendorName', 'saleDetailsQuantity']);

}

$("#saleDetailsItem").change(function () {
  salesItemSelectChange("");
});

function salesItemSelectChange(id) {
  const itemId = $(`#saleDetailsItem${id}`).val();
  const item = itemList.find(x => x.productID === itemId);
  $(`#saleDetailsUnitPrice${id}`).val(
    item
    ? item.sellingPrice
    : 0);
}

// Calculate Total in sale tab
$("#saleDetailsQuantity, #saleDetailsUnitPrice, #saleDetailsItem").change(function () {
  calculateTotalInSales("");
  calculateGrandTotal();
  calculateNetTotal();
});

function calculateNetTotal() {
  const tot = $(`#salesOrderTotal`).val();
  const discountP = $("#saleDetailsDiscountp").val();
  const val = Math.round(Number(tot) * ((100 - Number(discountP|| 0)) / 100)*100)/100;
  $("#salesOrderNetTotal").val(val);
  validateAddSales(val);
}

$("#saleDetailsDiscountp").change(function () {
  calculateNetTotal();
});

function initCustomers() {
  $.ajax({
    url: "model/customer/getAllCustomers.php",
    method: "POST",
    dataType: "json",
    success: function (data) {
      const customerData = getSelect2CustomerData(data);
      $("#saleDetailsCustomerName").select2({data: customerData});
    }
  });
}

// Listen to sale add button
$("#addSaleButton").on("click", function () {
  addSale();
});

function validateAddSales(netAmount) {
  $("#addSaleButton").prop("disabled", netAmount === 0);
}

function showSalesPayments(orderId) {
  $("#soPaymentsTab").prop("disabled", false);
  const tab = document.getElementById("soPaymentsTab");
  tab.click();

  $.ajax({
    url: "model/sale/getSalesOrder.php",
    data: {
      salesID: orderId
    },
    method: "POST",
    success: function (data) {
      loadSalesPayments(data);
    }
  });
}

function loadSalesPayments(data) {
  const {salesOrder} = JSON.parse(data);
  let credit = parseFloat(salesOrder.amount) - parseFloat(salesOrder.paidAmount);

  $("#paymentSalesId").val(salesOrder.saleID);
  $("#soTotalAmount").html(salesOrder.amount);
  $("#soCreditAmount").html(credit);
  $("#soPaidAmount").html(salesOrder.paidAmount);
  $("#soNumber").html(salesOrder.salesNumber);
  $("#customer").html(salesOrder.fullName);
  let status = salesOrder.amount == salesOrder.paidAmount
    ? " Settled"
    : " Need to pay";
  $("#soPaymentStatus").html(status);

  initSalesOrderPaymentList(salesOrder.saleID);
}

function initSalesOrderPaymentList(orderId) {
	$.ajax({
	  url: "model/sale/salesPaymentTableCreatorFile.php",
	  method: "POST",
	  data: {
		orderId: orderId
	  },
	  success: function (data) {
		$("#salesPaymentsTableDiv").empty();
		$("#salesPaymentsTableDiv").html(data);
	  },
	  complete: function () {}
	});
  }
  

$("#soPaymentType").on("change", function () {
  var selectedValue = $(this).val();
  if (selectedValue === "Cheque") {
    showSOChequeDetails(true);
  } else {
    showSOChequeDetails(false);
  }
});

function showSOChequeDetails(show) {
  if (show) {
    $("#soChequeDateDiv").removeClass("d-none");
    $("#soChequeNoDiv").removeClass("d-none");
  } else {
    $("#soChequeDateDiv").addClass("d-none");
    $("#soChequeNoDiv").addClass("d-none");
  }
}

// Function to call the insertSale.php script to insert Sale data to db
function addSalesPayment() {
  var paymentType = $("#soPaymentType").val();
  var chequeNo = $("#soChequeNo").val();
  var chequeDate = $("#soChequeDate").val();

  if (paymentType == "Cash") {
    insertSalesPayment();
  } else if (paymentType == "Cheque") {
    if (chequeNo != "" && chequeDate != "") {
      insertSalesPayment();
    } else {
      $("#soPaymentDetailsMessage").fadeIn();
      showSalesPaymentMessages("Please add cheque details", "error");
    }
  }
}

function insertSalesPayment() {
  var orderId = $("#paymentSalesId").val();
  var paymentAmount = $("#soPaymentAmount").val();
  var paymentDate = $("#soPaymentDate").val();
  var paymentType = $("#soPaymentType").val();
  var chequeNo = $("#soChequeNo").val();
  var chequeDate = $("#soChequeDate").val();
  var totalBill = $("#soTotalAmount").text();
  var note = $("#soPaymentNote").val();
  var creditAmount = $("#soCreditAmount").text();
  var remainingAmount = parseFloat(paymentAmount) - parseFloat(totalBill);

  if (!isNaN(parseFloat(paymentAmount)) && !isNaN(remainingAmount) && parseFloat(paymentAmount) <= parseFloat(creditAmount)) {
    $.ajax({
      url: "model/sale/insertSalesPayment.php",
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
        $("#soPaymentDetailsMessage").fadeIn();
        $("#soClearPaymentFormBtn").trigger("click");
        showSalesPaymentMessages("Payment added successfully", "success");
      },
      complete: function () {
        showSalesPayments(orderId)
        initSalesOrderPaymentList(orderId);
        searchTableCreator("salesDetailsTableDiv1", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
        reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
      }
    });
  } else {
    showSalesPaymentMessages("Invalid amount. Please re-check the amount", "error");
  }
}

$("#soClearPaymentFormBtn").on("click", function () {
  showSOChequeDetails(false);
  $("#soPaymentDetailsMessage").html("");
});

function showSalesPaymentMessages(txt, type) {
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
  $("#soPaymentDetailsMessage").html(msg);
}

function deleteSalesPaymentPopup(paymentId) {
  bootbox.confirm("Are you sure you want to delete?", function (result) {
    if (result) {
      var orderId = $("#paymentSalesId").val();
      deleteSalesPayment(paymentId);
    }
  });
}

function deleteSalesPayment(paymentId) {
  var orderId = $("#paymentSalesId").val();

  $.ajax({
    url: "model/sale/deleteSalesPayment.php",
    method: "POST",
    data: {
      paymentId: paymentId
    },
    success: function (data) {
      $("#soPaymentDetailsMessage").empty();
      $("#soPaymentDetailsMessage").html(data);
      initSalesOrderPaymentList(orderId);
    },
    complete: function () {
      showSalesPayments(orderId);
      initSalesOrderPaymentList(orderId);
      searchTableCreator("salesDetailsTableDiv1", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
      reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
    }
  });
}

function updateSalesChequeStatusPopup(paymentId, amount) {
  var creditAmount = $("#soCreditAmount").text();

  if (parseFloat(creditAmount) <= 0) {
    showSalesPaymentMessages("This bill is already settled.", "error");
  } else if (parseFloat(amount) > parseFloat(creditAmount)) {
    showSalesPaymentMessages("This amount will be added extra payment to the vendor.", "error");
  } else if (parseFloat(creditAmount) > 0 && parseFloat(amount) <= parseFloat(creditAmount)) {
    bootbox.dialog({
      message: "<p>Deposit or Cancel Cheque ?</p>",
      size: "medium",
      buttons: {
        cancel: {
          label: "Cancel cheque",
          className: "btn-primary",
          callback: function () {
            updateSOChequeStatus(paymentId, "Canceled");
          }
        },
        noclose: {
          label: "Deposit cheque",
          className: "btn-info",
          callback: function () {
            updateSOChequeStatus(paymentId, "Deposited");
          }
        }
      }
    });
  } else {
    showSalesPaymentMessages("An error occurred. Please try again.", "error");
  }
}

function updateSOChequeStatus(paymentId, status) {
  var orderId = $("#paymentSalesId").val();
  let note = status + " on " + getToday();
  $.ajax({
    url: "model/sale/updateSalesChequeStatus.php",
    method: "POST",
    data: {
      paymentId: paymentId,
      status: status,
      note: note
    },
    success: function (data) {
      $("#soPaymentDetailsMessage").empty();
      $("#soPaymentDetailsMessage").html(data);
      initSalesOrderPaymentList(orderId);
    },
    complete: function () {
      showSalesPayments(orderId);
      initSalesOrderPaymentList(orderId);
      searchTableCreator("salesDetailsTableDiv1", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
      reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
    }
  });
}

$("#saleDetailsVendorName").on("change", function () {
  const selectedValue = $(this).val();
  initItems(selectedValue);
});

function salesItemSelectChange(id) {
	const itemId = $(`#saleDetailsItem${id}`).val();
	const item = itemList.find(x => x.productID === itemId);
	$(`#saleDetailsUnitPrice${id}`).val(item ? item.buyingPrice : 0);
	$(`#saleDetailsAvalableQuantity${id}`).val(item ? item.stock : 0);
	
}

function setSOItemList(items){
	itemData = items && items.length? getSelect2ItemData(items): [];
  $("#saleDetailsItem").empty().trigger("change");
  $("#saleDetailsItem").select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	salesItemSelectChange('');

  for (let index = 0; index < rowCount; index++) {
  $(`#saleDetailsItem${index+1}`).empty().trigger("change");
  $(`#saleDetailsItem${index+1}`).select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	salesItemSelectChange(index+1);
  }
}

function openEditView(salesOrderId, viewType) {
  const tab = document.getElementById("salesOrderTab");
  tab.click();
  $.ajax({
    url: "model/sale/getSalesOrder.php",
    data: {
      saleID: salesOrderId
    },
    method: "POST",
    success: function (soData) { console.log(soData)
      const {salesOrder, salesOrderItems} = JSON.parse(soData);
      $.ajax({
        url: "model/item/getAllItems.php",
        method: "POST",
        dataType: "json",
        data: {
          vendorId: salesOrder.vendorID
        },
        success: function (data) {
          itemList = data;
          itemData = getSelect2ItemData(itemList);
          $("#saleDetailsItem").select2({
            data: itemData
          });
          console.log(salesOrder, salesOrderItems, viewType)
          loadDataToSalesOrder(salesOrder, salesOrderItems, viewType);
        }
      });
    }
  });
}

function loadDataToSalesOrder(salesOrder, salesOrderItems, viewType) {
	$('#saleDetailsSaleDate').val(salesOrder.saleDate);
	$('#salesDescription').val(salesOrder.description);
	$('#saleDetailsSaleID').val(salesOrder.salesNumber);
  $('#saleDetailsVendorName').val(salesOrder.vendorID).trigger("chosen:updated");
	$(`#salesOrderTotal`).val(salesOrder.amount);
	$(`#saleOrderId`).val(salesOrder.saleID);
  $(`#saleDetailsDiscountp`).val(salesOrder.discountPercentage);
 
  rowCount =0;
	document.getElementById("statusSO").style.display = "inline-block";
	$(`#statusSOText`).text(salesOrder.statusText);

	for (let index = 0; index < salesOrderItems.length; index++) {
		const numberText = index === 0 ? '' : index;
		if(index>0){
			rowCount++;
    		addSalesItem(rowCount, viewType, salesOrder.status);
		}

    $(`#saleDetailsItem${numberText}`).val(salesOrderItems[index].productID.toString());
    $(`#saleDetailsItem${numberText}`).trigger('change');
		$(`#saleDetailsUnitPrice${numberText}`).val(salesOrderItems[index].unitPrice);
		$(`#saleDetailsQuantity${numberText}`).val(salesOrderItems[index].quantity);
		$(`#saleDetailsTotal${numberText}`).val(salesOrderItems[index].totalPrice);
		$(`#saleItemId${numberText}`).val(salesOrderItems[index].orderItemId);

		if(viewType === 'DELIVERED' || viewType === 'VIEW'){
			disableElements([`saleDetailsItem${numberText}`,`saleDetailsQuantity${numberText}`]);
      if(index>0){
        if(viewType !== 'DELIVERED'){
          displayHideElements([`deleteSaleItem${numberText}`]);
        } else {
          switch (salesOrder.status) {
            case '1': //created
              disableElements([`deleteSaleItem${numberText}`]);
            break;
          }
        }
        
      }
      if(viewType === 'DELIVERED'){
        $(`#saleDetailsGoodReceivedQuantity${numberText}`).val(salesOrderItems[index].quantity);
      }
		}
    else if (viewType === 'EDIT') {
      if(index>0){
        if(salesOrderItems.length !== index+1){
          disableElements([`deleteSaleItem${numberText}`]);
        }
      }
    }
	}
  calculateNetTotal();
	if(viewType === 'DELIVERED' || viewType === 'VIEW'){
		disableElements([`saleDetailsItem`,`saleDetailsUnitPrice`,`saleDetailsQuantity`,
			`saleDetailsTotal`, 'salesDescription', 'saleDetailsSaleID'
		,'saleDetailsVendorName', 'saleDetailsCustomerName', 'saleDetailsDiscountp']);

		//document.getElementById("updateSaleBtn").disabled = true;
		document.getElementById("saleDetailsItemAdd").style.display = "none";
		switch (viewType) {
			case 'DELIVERED': // goods received
      displayElements(["deliveredBtn", "cancelSOBtn"]);
      displayHideElements(["sendSOBtn",  "addSaleButton", "clearBtn"]);
      document.getElementById("deliveredData").style.display = "block";
      document.getElementById("lableActionHeader").innerText = "Delivered Quantity";
				break;
		
			case 'VIEW':
				switch (salesOrder.status) {
					case '1': //created
						displayHideElements(["deliveredBtn", "closeSOBtn", "addSaleButton", "clearBtn" ]);
						displayElements(["sendSOBtn", "cancelSOBtn", "printPdfBtn"]);
						break;
					case '2': //pending
						displayElements(["cancelSOBtn", "closeSOBtn", "printPdfBtn"]);
						displayHideElements(["deliveredBtn", "sendSOBtn", "addSaleButton", "clearBtn" ]);	
						break;
					case '3': // close
						displayHideElements(["deliveredBtn", "sendSOBtn", "closeSOBtn", "printPdfBtn", "addSaleButton", "clearBtn" ]);
						displayElements(["cancelSOBtn"]);
						break;
          case '5': //goods received
						displayElements(["cancelSOBtn", "closeSOBtn"]);
						displayHideElements(["deliveredBtn", "sendSOBtn", "addSaleButton", "printPdfBtn", "clearBtn" ]);	
						break;
					default: // cancel
						displayHideElements(["deliveredBtn", "sendSOBtn", "closeSOBtn", "cancelSOBtn", "printPdfBtn", "addSaleButton", "clearBtn" ]);
						break;
				}
				break;
			default:
				break;
		}
	} else if (viewType === 'EDIT') {
    disableElements([`saleDetailsVendorName`]);
    enableElements(['saleDetailsItemAdd']);
    displayElements(["updateSaleButton","sendSOBtn","printPdfBtn", "cancelSOBtn" ]);
    displayHideElements(["clearBtn", "addSaleButton"]);
  } else{
		displayHideElements(["clearBtn", "addSaleButton"]);
		document.getElementById("cancelSOBtn").disabled = saleOrder.status === 3;
	} 
}


function updateSO(statusId, status) {
  const saleId = $(`#salesOrderId`).val();
  return new Promise((resolve, reject) => {
      $.ajax({
        url: "model/sale/updateStatus.php",
        data: {
          saleID: saleId,
          statusId: statusId
        },
        method: "POST",
        success: function (data) {
          $("#saleDetailsMessage").fadeIn();
          $("#saleDetailsMessage").html(data);
          $(`#statusSOText`).text(status);
          resolve(saleId)
        },
        error: function () {
          reject(data);
        }

      });
    });
}

function sendSO() {
  updateSO(2, "Pending").then(function (saleId) {
    openDeliveredOrder(saleId)
  });
}

function cancelSO() {
  updateSO(4, "Cancel").then(function () {
    displayHideElements(["sendSOBtn",  "addSaleButton", "clearBtn", "deliveredBtn", "closeSOBtn","cancelSOBtn", "printPdfBtn"]);
  });
}

function closeSO() {
  updateSO(3, "Close").then(function () {
    displayHideElements(["sendSOBtn",  "addSaleButton", "clearBtn", "deliveredBtn", "closeSOBtn","cancelSOBtn", "printPdfBtn"]); 
  });
}

function printSalesOrderPdf() {
  downloadOrderPdf("SO", order, orderItems);
}

function openDeliveredOrder(salesOrderId) {
	openEditView(salesOrderId, 'DELIVERED');
}

function openEditSalesOrder(salesOrderId) {
  openEditView(salesOrderId, "EDIT");
}

function openViewSalesOrder(salesOrderId) {
  openEditView(salesOrderId, "VIEW");
}

initSalesOrder();
