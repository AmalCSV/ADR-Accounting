var itemList = [];
var rowCount = 0;

$("#reportDetailsVendor").on("change", function () {
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