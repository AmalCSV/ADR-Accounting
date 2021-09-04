var itemList = [];

getAllItemsDetails();
enableUpdateDeleteButton(false);

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
  var itemDetailsVendorID = $("#itemDetailsVendor").val();
  var itemDetailsRackNo = $("#itemDetailsRackNo").val();
  itemDetailsWarningQty = (itemDetailsWarningQty == "") ? 0 : itemDetailsWarningQty ;

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
        itemDetailsRackNo: itemDetailsRackNo,
        itemDetailsVendorID : itemDetailsVendorID
      },
      success: function (data) {
        var result = $.parseJSON(data);
        $("#itemDetailsMessage").fadeIn();
        $("#itemDetailsMessage").html(result.alertMessage);
        if(result.status == "success"){
          getAllItemsDetails();
          enableUpdateDeleteButton(true);
        }
      },
      complete: function () {
        populateLastInsertedID(itemLastInsertedIDFile, "itemDetailsProductID");
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
        reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
      }
    });
}

// Function to call the upateItemDetails.php script to UPDATE item data in db
function updateItem() {
  var itemDetailsProductID = $("#itemDetailsProductID").val();
  var itemDetailsVendorID = $("#itemDetailsVendor").val();

  if (parseInt(itemDetailsProductID) > 0 && itemDetailsVendorID != null) {
    var itemDetailsItemNumber = $("#itemDetailsItemNumber").val();
    var itemDetailsItemName = $("#itemDetailsItemName").val();
    var itemDetailsUnitMeasure = $("#itemDetailsUnitMeasure").val();
    var itemDetailsBuyingPrice = $("#itemDetailsBuyingPrice").val();
    var itemDetailsSellingPrice = $("#itemDetailsSellingPrice").val();
    var itemDetailsStatus = $("#itemDetailsStatus").val();
    var itemDetailsDescription = $("#itemDetailsDescription").val();
    var itemDetailsWarningQty = $("#itemDetailsWarningQty").val();
    var itemDetailsRackNo = $("#itemDetailsRackNo").val();

    itemDetailsWarningQty = (itemDetailsWarningQty == "") ? 0 : itemDetailsWarningQty ;

    $.ajax({
      url: "model/item/updateItemDetails.php",
      method: "POST",
      data: {
        itemDetailsProductID: itemDetailsProductID,
        itemDetailsItemNumber: itemDetailsItemNumber,
        itemDetailsItemName: itemDetailsItemName,
        itemDetailsUnitMeasure: itemDetailsUnitMeasure,
        itemDetailsBuyingPrice: itemDetailsBuyingPrice,
        itemDetailsSellingPrice: itemDetailsSellingPrice,
        itemDetailsStatus: itemDetailsStatus,
        itemDetailsDescription: itemDetailsDescription,
        itemDetailsWarningQty: itemDetailsWarningQty,
        itemDetailsRackNo: itemDetailsRackNo,
        itemDetailsVendorID: itemDetailsVendorID
      },
      success: function (data) {
        var result = $.parseJSON(data);
        $("#itemDetailsMessage").fadeIn();
        $("#itemDetailsMessage").html(result.alertMessage);
        getAllItemsDetails();
      },
      complete: function () {
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
        searchTableCreator("purchaseDetailsTableDiv", purchaseDetailsSearchTableCreatorFile, "purchaseDetailsTable");
        searchTableCreator("saleDetailsTableDiv", saleDetailsSearchTableCreatorFile, "saleDetailsTable");
        reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
       // reportsPurchaseTableCreator("purchaseReportsTableDiv", purchaseReportsSearchTableCreatorFile, "purchaseReportsTable");
       // reportsSaleTableCreator("saleReportsTableDiv", saleReportsSearchTableCreatorFile, "saleReportsTable");
      }
    });
  } else {
    $("#itemDetailsMessage").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Invalid Details.</div>');
  }
}

function enableUpdateDeleteButton(enable) {
  if (enable) {
    $("#updateItemDetailsButton").prop("disabled", false);
    $("#deleteItem").prop("disabled", false);
    $("#addItem").prop("disabled", true);
  } else {
    $("#updateItemDetailsButton").prop("disabled", true);
    $("#deleteItem").prop("disabled", true);
    $("#addItem").prop("disabled", false);
  }
}

function getAllItemsDetails() {
  // relevant to the itemNumber which the user entered
  $.ajax({
    url: "model/item/getAllItems.php",
    method: "POST",
    dataType: "json",
    success: function (data) {
      itemList = data;
      searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
      autocomplete(document.getElementById("itemDetailsItemNumber"), itemList.map(x => x.itemNumber), onSelectItemNumber);
      autocomplete(document.getElementById("itemDetailsItemName"), itemList.map(x => x.itemName), onSelectItemName);
      autocomplete(document.getElementById("itemImageItemName"), itemList.map(x => x.itemName), onSelectImageItemName);
    }
  });
}

function onSelectImageItemName(itemName) {
  if (itemName && itemName != "") {
    var data = itemList.find(x => x.itemName == itemName);
    if (data) {
      $("#itemImageItemNumber").val(data.itemNumber);
      $("#itemImageProductID").val(data.productID);
    }
  }
}

function onSelectItemName(itemName) {
  if (itemName && itemName != "") {
    var data = itemList.find(x => x.itemName == itemName);
    if (data) {
      $("#itemDetailsItemNumber").val(data.itemNumber);
      selectItem(data);
    }
  }
}

function onSelectItemNumber(itemNumber) {
  if (itemNumber && itemNumber != "") {
    var data = itemList.find(x => x.itemNumber == itemNumber);
    if (data) {
      $("#itemDetailsItemName").val(data.itemName);
      selectItem(data);
    }
  }
}

function showEditItem(productId){
  $('.nav-tabs a[href="#itemDetailsTab"]').tab('show');
  let selectedItem =  itemList.find(x => x.productID == productId);
  $("#itemDetailsItemName").val(selectedItem.itemName);
  $("#itemDetailsItemNumber").val(selectedItem.itemNumber);
  selectItem(selectedItem);
}

function selectItem(data) {
  var defaultImgUrl = "data/item_images/imageNotAvailable.jpg";
  var defaultImageData = '<img class="img-fluid" src="data/item_images/imageNotAvailable.jpg">';

  if (data) {
    $("#itemDetailsProductID").val(data.productID);
    $("#itemDetailsTotalStock").val(data.stock);
    $("#itemDetailsBuyingPrice").val(data.buyingPrice);
    $("#itemDetailsSellingPrice").val(data.sellingPrice);
    $("#itemDetailsWarningQty").val(data.warningQty);
    $("#itemDetailsRackNo").val(data.rackNo);
    $("#itemDetailsDescription").val(data.description);
    $("#itemDetailsStatus").val(data.status).trigger("chosen:updated");
    $("#itemDetailsUnitMeasure").val(data.unitOfMeasure).trigger("chosen:updated");
    $("#initialQtySec").addClass("d-none");
		$('#itemDetailsVendor').val(data.vendorID).trigger("chosen:updated");

    newImgUrl = "data/item_images/" + data.productID + "/" + data.imageURL;

    // Set the item image
    if (data.imageURL == "imageNotAvailable.jpg" || data.imageURL == "") {
      $("#imageContainer").html(defaultImageData);
    } else {
      $("#imageContainer").html('<img class="img-fluid" src="' + newImgUrl + '">');
    }
    enableUpdateDeleteButton(true);
  }
}

// Function to delte item from db
function deleteItem() {
  // Get the item number entered by the user
  var itemDetailsItemNumber = $("#itemDetailsProductID").val();

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
        getAllItemsDetails();
      },
      complete: function () {
        searchTableCreator("itemDetailsTableDiv", itemDetailsSearchTableCreatorFile, "itemDetailsTable");
        reportsTableCreator("itemReportsTableDiv", itemReportsSearchTableCreatorFile, "itemReportsTable");
      }
    });
  }
}

// Function to fetch data to show in popovers
function fetchData() {
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

// Function to call the script that process imageURL in DB
function processImage(imageFormID, scriptPath, messageDivID) {
  var form = $("#" + imageFormID)[0];
  var formData = new FormData(form);
  $.ajax({
    url: scriptPath,
    method: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $("#clearImageButton").trigger("click");
      $("#itemClear").trigger("click");
      $("#" + messageDivID).html(data);
      getAllItemsDetails();
    }
  });
}

// Listen to item number text box in item image tab
$("#itemImageItemNumber").keyup(function () {
  showSuggestions("itemImageItemNumber", showItemNumberSuggestionsForImageTabFile, "itemImageItemNumberSuggestionsDiv");
});

// Clear the image from item tab when Clear button is clicked
$("#itemClear").on("click", function () {
  $("#initialQtySec").removeClass("d-none");
  $("#itemDetailsItemNumber").prop("readonly", false);
  $("#itemDetailsItemName").prop("readonly", false);
  $("#itemDetailsStatus").val("Active").trigger("chosen:updated");
  $("#itemDetailsUnitMeasure").val("Units").trigger("chosen:updated");
  $("#imageContainer").empty();
  $("#itemDetailsMessage").html("");
  enableUpdateDeleteButton(false);
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
  } else {
    $("#itemDetailsMessage").fadeIn();
    $("#itemDetailsMessage").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select an item</div>');
  }
});

$(document).ready(function () {
  // Listen to update button in item details tab
  $("#updateItemDetailsButton").on("click", function () {
    updateItem();
  });

  // Listen to item add button
  $("#addItem").on("click", function () {
    addItem();
  });

  // Listen to image update button
  $("#updateImageButton").on("click", function () {
    processImage("imageForm", updateImageFile, "itemImageMessage");
  });

  // Listen to image delete button
  $("#deleteImageButton").on("click", function () {
    processImage("imageForm", deleteImageFile, "itemImageMessage");
  });
});
