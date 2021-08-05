
// Function to call the insertItem.php script to insert item data to db
function addItem() {
	var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();
	var itemDetailsItemName = $('#itemDetailsItemName').val();
	var itemDetailsUnitMeasure = $('#itemDetailsUnitMeasure').val();
	var itemDetailsInitialQty = $('#itemDetailsInitialQty').val();
	var itemDetailsBuyingPrice = $('#itemDetailsBuyingPrice').val();
	var itemDetailsSellingPrice = $('#itemDetailsSellingPrice').val();
	var itemDetailsStatus = $('#itemDetailsStatus').val();
	var itemDetailsDescription = $('#itemDetailsDescription').val();
	var itemDetailsWarningQty = $('#itemDetailsWarningQty').val();
	var itemDetailsRackNo = $('#itemDetailsRackNo').val();
	$.ajax({
		url: 'model/item/insertItem.php',
		method: 'POST',
		data: {
			itemDetailsItemNumber:itemDetailsItemNumber,
			itemDetailsItemName:itemDetailsItemName,
			itemDetailsUnitMeasure:itemDetailsUnitMeasure,
			itemDetailsInitialQty:itemDetailsInitialQty,
			itemDetailsBuyingPrice:itemDetailsBuyingPrice,
			itemDetailsSellingPrice:itemDetailsSellingPrice,
			itemDetailsStatus:itemDetailsStatus,
			itemDetailsDescription:itemDetailsDescription,
			itemDetailsWarningQty:itemDetailsWarningQty,
			itemDetailsRackNo:itemDetailsRackNo
		},
		success: function(data){
			
			$('#itemDetailsMessage').fadeIn();
			$('#itemDetailsMessage').html(data);
		},
		complete: function(){
			
			populateLastInsertedID(itemLastInsertedIDFile, 'itemDetailsProductID');
			getItemStockToPopulate('itemDetailsItemNumber', getItemStockFile, itemDetailsTotalStock);
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}



// Function to call the upateItemDetails.php script to UPDATE item data in db
function updateItem() {
	var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();
	var itemDetailsItemName = $('#itemDetailsItemName').val();
	var itemDetailsUnitMeasure = $('#itemDetailsUnitMeasure').val();
	var itemDetailsBuyingPrice = $('#itemDetailsBuyingPrice').val();
	var itemDetailsSellingPrice = $('#itemDetailsSellingPrice').val();
	var itemDetailsStatus = $('#itemDetailsStatus').val();
	var itemDetailsDescription = $('#itemDetailsDescription').val();
	var itemDetailsWarningQty = $('#itemDetailsWarningQty').val();
	var itemDetailsRackNo = $('#itemDetailsRackNo').val();
	
	$.ajax({
		url: 'model/item/updateItemDetails.php',
		method: 'POST',
		data: {
			itemDetailsItemNumber:itemDetailsItemNumber,
			itemDetailsItemName:itemDetailsItemName,
			itemDetailsUnitMeasure:itemDetailsUnitMeasure,
			itemDetailsBuyingPrice:itemDetailsBuyingPrice,
			itemDetailsSellingPrice:itemDetailsSellingPrice,
			itemDetailsStatus:itemDetailsStatus,
			itemDetailsDescription:itemDetailsDescription,
			itemDetailsWarningQty:itemDetailsWarningQty,
			itemDetailsRackNo:itemDetailsRackNo
		},
		success: function(data){
			var result = $.parseJSON(data);
			$('#itemDetailsMessage').fadeIn();
			$('#itemDetailsMessage').html(result.alertMessage);
			if(result.newStock != null){
				$('#itemDetailsTotalStock').val(result.newStock);
			}
		},
		complete: function(){
			searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');			
			searchTableCreator('purchaseDetailsTableDiv', purchaseDetailsSearchTableCreatorFile, 'purchaseDetailsTable');
			searchTableCreator('saleDetailsTableDiv', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
			reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
			reportsPurchaseTableCreator('purchaseReportsTableDiv', purchaseReportsSearchTableCreatorFile, 'purchaseReportsTable');
			reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
		}
	});
}

