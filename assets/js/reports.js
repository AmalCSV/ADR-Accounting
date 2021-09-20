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
  }
  else if(selectedValue == "vendorReports" || selectedValue == "itemReports"){
    document.getElementById("venderDiv").style.display = "";
    document.getElementById("companyDetails").style.display = "none";
    document.getElementById("reportListTab").style.display = "";

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

  var reportType = $("#reportType").val();
  var vendor = $("#reportDetailsVendor").val();
  var fromDate = $("#reportDetailsItem").val();
  var toDate = $("#reportsFromDate").val();
  var item = $("#reportsToDate").val();

  if(reportType == "companyReports"){
    loadCompanyReport();
  }
  else if(reportType == "vendorReports"){


  }
  else if(reportType == "itemReports"){

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

      console.log(response);

      $("#totalPurchases").html(response.totalPurchases);
      $("#totalSales").html(data.totalSales);
      $("#totalProfit").html(data.totalProfit);
      $("#stockValue").html(data.stockValue);

    },
    complete: function () {}
  });


}
