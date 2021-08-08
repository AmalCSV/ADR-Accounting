// Function to call the insertItem.php script to insert item data to db
function addItem() {
  var itemDetailsItemNumber = $("#itemDetailsItemNumber").val();
  var itemDetailsItemName = $("#itemDetailsItemName").val();
  var itemDetailsUnitMeasure = $("#itemDetailsUnitMeasure").val();
  var itemDetailsInitialQty = $("#itemDetailsInitialQty").val();
  var itemDetailsBuyingPrice = $("#itemDetailsBuyingPrice").val();
  var itemDetailsSellingPrice = $("#itemDetailsSellingPrice").val();
  var itemDetailsStatus = $("#itemDetailsStatus").val();
  var itemDetailsDescription = $("#itemDetailsDescription").val();
  var itemDetailsWarningQty = $("#itemDetailsWarningQty").val();
  var itemDetailsRackNo = $("#itemDetailsRackNo").val();
  $.ajax({
    url: "model/item/insertItem.php",
    method: "POST",
    data: {
      itemDetailsItemNumber: itemDetailsItemNumber,
      itemDetailsItemName: itemDetailsItemName,
      itemDetailsUnitMeasure: itemDetailsUnitMeasure,
      itemDetailsInitialQty: itemDetailsInitialQty,
      itemDetailsBuyingPrice: itemDetailsBuyingPrice,
      itemDetailsSellingPrice: itemDetailsSellingPrice,
      itemDetailsStatus: itemDetailsStatus,
      itemDetailsDescription: itemDetailsDescription,
      itemDetailsWarningQty: itemDetailsWarningQty,
      itemDetailsRackNo: itemDetailsRackNo
    },
    success: function (data) {
      $("#itemDetailsMessage").fadeIn();
      $("#itemDetailsMessage").html(data);
    },
    complete: function () {
      populateLastInsertedID(itemLastInsertedIDFile, "itemDetailsProductID");
      getItemStockToPopulate("itemDetailsItemNumber", getItemStockFile, itemDetailsTotalStock);
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
    }
  });
}

// Function to call the upateItemDetails.php script to UPDATE item data in db
function updateItem() {
  var itemDetailsItemNumber = $("#itemDetailsItemNumber").val();
  var itemDetailsItemName = $("#itemDetailsItemName").val();
  var itemDetailsUnitMeasure = $("#itemDetailsUnitMeasure").val();
  var itemDetailsBuyingPrice = $("#itemDetailsBuyingPrice").val();
  var itemDetailsSellingPrice = $("#itemDetailsSellingPrice").val();
  var itemDetailsStatus = $("#itemDetailsStatus").val();
  var itemDetailsDescription = $("#itemDetailsDescription").val();
  var itemDetailsWarningQty = $("#itemDetailsWarningQty").val();
  var itemDetailsRackNo = $("#itemDetailsRackNo").val();

  $.ajax({
    url: "model/item/updateItemDetails.php",
    method: "POST",
    data: {
      itemDetailsItemNumber: itemDetailsItemNumber,
      itemDetailsItemName: itemDetailsItemName,
      itemDetailsUnitMeasure: itemDetailsUnitMeasure,
      itemDetailsBuyingPrice: itemDetailsBuyingPrice,
      itemDetailsSellingPrice: itemDetailsSellingPrice,
      itemDetailsStatus: itemDetailsStatus,
      itemDetailsDescription: itemDetailsDescription,
      itemDetailsWarningQty: itemDetailsWarningQty,
      itemDetailsRackNo: itemDetailsRackNo
    },
    success: function (data) {
      var result = $.parseJSON(data);
      $("#itemDetailsMessage").fadeIn();
	  console.log(result.alertMessage);
      $("#itemDetailsMessage").html(result.alertMessage);
    },
    complete: function () {
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
      searchTableCreator("saleDetailsTableDiv", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
      reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
      reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
      reportsSaleTableCreator("saleReportsTableDiv", saleReportsSearchTableCreatorFile, "saleReportsTable");
    }
  });
}

// Function to send itemNumber so that item details can be pulled from db
// to be displayed on item details tab
function getItemDetailsToPopulate() {
  // Get the itemNumber entered in the text box
  var itemNumber = $("#itemDetailsItemNumber").val();
  var defaultImgUrl = "data/item_images/imageNotAvailable.jpg";
  var defaultImageData = '<img class="img-fluid" src="data/item_images/imageNotAvailable.jpg">';
  // Call the populateItemDetails.php script to get item details
  // relevant to the itemNumber which the user entered
  $.ajax({
    url: "model/item/populateItemDetails.php",
    method: "POST",
    data: {
      itemNumber: itemNumber
    },
    dataType: "json",
    success: function (data) {
      //$('#itemDetailsItemNumber').val(data.itemNumber);
      $("#itemDetailsItemNumber").prop("readonly", true);
      $("#itemDetailsProductID").val(data.productID);
      $("#itemDetailsItemName").val(data.itemName);
      $("#itemDetailsTotalStock").val(data.stock);
      $("#itemDetailsBuyingPrice").val(data.buyingPrice);
      $("#itemDetailsSellingPrice").val(data.sellingPrice);
      $("#itemDetailsWarningQty").val(data.warningQty);
      $("#itemDetailsRackNo").val(data.rackNo);
      $("#itemDetailsDescription").val(data.description);
      $("#itemDetailsStatus").val(data.status).trigger("chosen:updated");
      $("#itemDetailsUnitMeasure").val(data.unitOfMeasure).trigger("chosen:updated");
      $("#initialQtySec").addClass("d-none");

      newImgUrl = "data/item_images/" + data.itemNumber + "/" + data.imageURL;

      // Set the item image
      if (data.imageURL == "imageNotAvailable.jpg" || data.imageURL == "") {
        $("#imageContainer").html(defaultImageData);
      } else {
        $("#imageContainer").html('<img class="img-fluid" src="' + newImgUrl + '">');
      }
    }
  });
}

// Function to delte item from db
function deleteItem() {
  // Get the item number entered by the user
  var itemDetailsItemNumber = $("#itemDetailsItemNumber").val();

  // Call the deleteItem.php script only if there is a value in the
  // item number textbox
  if (itemDetailsItemNumber != "") {
    $.ajax({
      url: "model/item/deleteItem.php",
      method: "POST",
      data: {
        itemDetailsItemNumber: itemDetailsItemNumber
      },
      success: function (data) {
        $("#itemDetailsMessage").fadeIn();
        $("#itemClear").trigger("click");
        $("#itemDetailsMessage").html(data);
      },
      complete: function () {
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
        reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
      }
    });
  }
}



// Function to fetch data to show in popovers
function fetchData(){
	var fetch_data = '';
	var element = $(this);
	var id = element.attr('id');
	
	$.ajax({
		url: 'model/item/getItemDetailsForPopover.php',
		method: 'POST',
		async: false,
		data: {id:id},
		success: function(data){
			fetch_data = data;
		}
	});
	return fetch_data;
}


// Function to call the script that process imageURL in DB
function processImage(imageFormID, scriptPath, messageDivID){
	var form = $('#' + imageFormID)[0];
	var formData = new FormData(form);
	$.ajax({
		url: scriptPath,
		method: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		success: function(data){
			$('#' + messageDivID).html(data);
		}
	});
}

// Listen to item number text box in item image tab
$("#itemImageItemNumber").keyup(function () {
  showSuggestions("itemImageItemNumber", showItemNumberSuggestionsForImageTabFile, "itemImageItemNumberSuggestionsDiv");
});

// Remove the item numbers suggestions dropdown in the item image tab
// when user selects an item from it
$(document).on("click", "#itemImageItemNumberSuggestionsList li", function () {
  $("#itemImageItemNumber").val($(this).text());
  $("#itemImageItemNumberSuggestionsList").fadeOut();
  getItemName("itemImageItemNumber", getItemNameFile, "itemImageItemName");
});

// Clear the image from item tab when Clear button is clicked
$("#itemClear").on("click", function () {
  $("#initialQtySec").removeClass("d-none");
  $("#itemDetailsItemNumber").prop("readonly", false);
  $("#itemDetailsStatus").val("Active").trigger("chosen:updated");
  $("#itemDetailsUnitMeasure").val("Units").trigger("chosen:updated");
  $("#imageContainer").empty();
  $("#itemDetailsMessage").html('');
});

// Listen to delete button in item details tab
$("#deleteItem").on("click", function () {
  if ($("#itemDetailsItemNumber").val() != "") {
    // Confirm before deleting
    bootbox.confirm("Are you sure you want to delete?", function (result) {
      if (result) {
        deleteItem();
      }
    });
  }
  else{
	$("#itemDetailsMessage").fadeIn();
	$("#itemDetailsMessage").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select an item</div>');
  }
});

// Listen to update button in item details tab
$("#updateItemDetailsButton").on("click", function () {
  updateItem();
});

// Listen to item add button
$("#addItem").on("click", function () {
  addItem();
});