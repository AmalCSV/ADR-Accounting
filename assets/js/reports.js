var itemList = [];
var rowCount = 0;

const currentDate =  new Date().toISOString().slice(0, 10);

$( document ).ready(function() {
	$('#reportsToDate').val(currentDate);
    // loadData();

    var date = new Date();
    date.setDate(date.getDate() - 30);
    var dateString = date.toISOString().split('T')[0]; 
    $('#reportsFromDate').val(dateString);
    
    // Create item details popover boxes
		$('.itemDetailsHover').popover({
			container: 'body',
			title: 'Item Details',
			trigger: 'hover',
			html: true,
			placement: 'right',
			content: fetchItems
		});

    loadCompanyReport();

});

// Function to fetch data to show in popovers
function fetchItems() {
  var fetch_data = "";
  var element = $(this);
  var id = element.attr("id");

  $.ajax({
    url: "model/item/getItemDetailsForPopover.php",
    method: "POST",
    async: false,
    data: {
      id: id
    },
    success: function (data) {
      fetch_data = data;
    }
  });
  return fetch_data;
}


$("#reportType").on("change", function () {
  const selectedValue = $(this).val();

  if(selectedValue == "companyReports"){
    document.getElementById("companyDetails").style.display = "";
    document.getElementById("venderDiv").style.display = "none";
    document.getElementById("reportListTab").style.display = "none";
    document.getElementById("itemsDiv").style.display = "none";
    document.getElementById("statusDiv").style.display = "none";
  }
  else if(selectedValue == "vendorReports" || selectedValue == "itemReports"){
    document.getElementById("venderDiv").style.display = "";
    document.getElementById("companyDetails").style.display = "none";
    document.getElementById("reportListTab").style.display = "";
    document.getElementById("statusDiv").style.display = "";

    if(selectedValue == "itemReports"){
      document.getElementById("itemsDiv").style.display = "";
    }
    else{
      document.getElementById("itemsDiv").style.display = "none";
    }
  }
  
  initItems(selectedValue);
});

$("#reportDetailsVendor").on("change", function () {
    const selectedValue = $(this).val();
    if(selectedValue == "null"){
      $("#reportDetailsItem").empty().trigger("change");
    }
    else{
      initItems(selectedValue);
    }
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
          setReportsItemList(itemList);
        }
 });

}
  
function setReportsItemList(items){
	itemData = items && items.length? getSelect2ItemData(items): [];
  $("#reportDetailsItem").empty().trigger("change");
  $("#reportDetailsItem").select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	purchaseItemSelectChange('');

  for (let index = 0; index < rowCount; index++) {
  $(`#reportDetailsItem${index+1}`).empty().trigger("change");
  $(`#reportDetailsItem${index+1}`).select2({
		placeholder: {text: "Select Item"},
		data: itemData
	});

	purchaseItemSelectChange(index+1);
  }
}


function purchaseItemSelectChange(id) {
	// const itemId = $(`#purchaseDetailsItem${id}`).val();
	// const item = itemList.find(x => x.productID === itemId);
	// $(`#purchaseDetailsUnitPrice${id}`).val(item ? item.buyingPrice : 0);
	// $(`#purchaseDetailsAvalableQuantity${id}`).val(item ? item.stock : 0);
}

function loadData(){
    
  $.ajax({
    url: "model/report/itemReportTableCreator.php",
    method: "POST",
    data: {
    },
    success: function (data) {
      $("#reportListTableDiv").empty();
      $("#reportListTableDiv").html(data);
    },
    complete: function () {}
  });

}


function searchData(){

  const reportType = $("#reportType").val();
  const vendor = $("#reportDetailsVendor").val();
  const item = $("#reportDetailsItem").val();
  const toDate = $("#reportsToDate").val();
  const fromDate = $("#reportsFromDate").val();
  const status = $("#reportStatus").val();

  if(reportType == "companyReports"){
    loadCompanyReport();
  }
  else if(reportType == "vendorReports"){
    loadVendorReport(fromDate, toDate, vendor, status);
  }
  else if(reportType == "itemReports"){
    loadItemsReport(fromDate, toDate, vendor, item, status);
  }

}

function loadCompanyReport(){
  var fromDate = $("#reportsFromDate").val();
  var toDate = $("#reportsToDate").val();

  $.ajax({
    url: "model/report/companyReportCreator.php",
    method: "POST",
    data: {
      fromDate: fromDate,
      toDate: toDate
    },
    success: function (data) {
      var response = $.parseJSON(data);

      var poArray = response.purchaseOrders;
      var soArray = response.salesOrders;
      let poTable = '';
      let soTable = '';
      var totalPurchases = 0.0;
      var totalSales = 0.0;
      var poToBePaid = 0.0;
      var soToBePaid = 0.0;
      var poPaid = 0.0;
      var soPaid = 0.0;

      poArray.forEach(element => {
        poTable += '<tr><td >'+ element.statusText +'</td> <td class="text-right">' + element.purchseOrders +'</td><td class="text-right">'+ element.amount +'</td>""</tr>';
        totalPurchases += parseFloat(element.amount) ;
        poToBePaid += parseFloat(element.tobePaid);
        poPaid += parseFloat(element.paid);
      });

      soArray.forEach(element => {
        soTable += '<tr><td >'+ element.statusText +'</td> <td class="text-right">' + element.salesOrders +'</td><td class="text-right">'+ element.amount +'</td>""</tr>';
        totalSales += parseFloat(element.amount) ;
        soToBePaid += parseFloat(element.tobePaid);
        soPaid += parseFloat(element.paid);
      });

      $("#poTable").html(poTable);
      $("#soTable").html(soTable);

      $("#totalPurchases").html(isNaN(totalPurchases) ? "0.00" : totalPurchases.toFixed(2));
      $("#poToBePaid").html(isNaN(poToBePaid) ? "0.00" : poToBePaid.toFixed(2));
      $("#poPaid").html(isNaN(poPaid) ? "0.00" : poPaid.toFixed(2));

      $("#totalSales").html(isNaN(totalSales) ? "0.00" : totalSales.toFixed(2));
      $("#soToBePaid").html(isNaN(soToBePaid) ? "0.00" : soToBePaid.toFixed(2));
      $("#soPaid").html(isNaN(soPaid) ? "0.00" : soPaid.toFixed(2));
      
      var profit = totalSales - totalPurchases;
      $("#totalProfit").html( profit? "0.00" : (profit).toFixed(2));

      if(response.stockValuation.amount == null){
        $("#stockValue").html("0.00");
      }
      else{
        $("#stockValue").html(response.stockValuation.amount);
      }

    },
    complete: function () {}
  });

}

function loadVendorReport(fromDate, toDate, vendor, status){
  reportsTableCreator('reportListTableDiv', `model/report/itemReportTableCreator.php?fromDate=${fromDate}&toDate=${toDate}&vendorId=${vendor}&status=${status}`, 'vendorReportTable');  
}

function loadItemsReport(fromDate, toDate, vendor, item){

}
