<?php

	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['saleDetailsSaleID'])){
		$saleDetailsSaleID = htmlentities($_POST['saleDetailsSaleID']);
		$discountp = htmlentities($_POST['saleDetailsDiscount']);
		$salesOrderNetTotal = htmlentities($_POST['salesOrderNetTotal']);
		$salesItem = $_POST['salesItem'];
		$salesOrderTotal = htmlentities($_POST['salesOrderTotal']);
		$customerName = htmlentities($_POST['saleDetailsCustomerName']); 
		$saleDetailsCustomerID = htmlentities($_POST['saleDetailsCustomerID']); 
		$saleDate = htmlentities($_POST['saleDetailsSaleDate']);
		$salesDetailsDescription = htmlentities($_POST['salesDescription']);
		$vendorId = htmlentities($_POST['vendorId']);
		$salesOrderId = htmlentities($_POST['salesOrderId']);
		$isDiscountAmount = htmlentities($_POST['isDiscountAmount']);
        $discount =  htmlentities($_POST['discount']);
		
		if(!empty($saleDetailsSaleID) && isset($salesOrderTotal) && isset($customerName) && isset($saleDate) && isset($salesItem)){	
			if($salesOrderNetTotal == 'null' || $salesOrderNetTotal == 0){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Invalid Amount.</div>';
				exit();
			}

			if($saleDate == 'null' || $saleDate == ''){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select the Order date</div>';
				exit();
			}
			if($vendorId == 'null'){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select a vendor</div>';
				exit();
			}
				
			if($isDiscountAmount === 'true'){
				$discountAmount = $discount;
				$isDiscountAmount = 1;
			} else {
				$discountAmount = $salesOrderTotal - $salesOrderNetTotal;
				$isDiscountAmount = 0;
			}

			// update sales order 
			$updateOrderSql = 'UPDATE salesorder set salesNumber= :salesNumber, saleDate = :saleDate, amount=:amount, customerID= :customerID, description= :note, discount=:discount, 
			discountPercentage =:discountPercentage, customerName=:customerName, vendorID=:vendorId, isDiscountAmount=:isDiscountAmount WHERE saleID=:saleID ';
			$updateOrderSqlStatement = $conn->prepare($updateOrderSql);
			$updateOrderSqlStatement->execute(['salesNumber' => $saleDetailsSaleID, 'saleDate' => $saleDate, 'amount' => $salesOrderNetTotal, 
			'customerID' => $saleDetailsCustomerID, 'note' => $salesDetailsDescription, 'discount' => $discountAmount, 'discountPercentage' => $discountp, 'customerName' => $customerName, 'vendorId' => $vendorId, 'isDiscountAmount' => $isDiscountAmount, 'saleID' => $salesOrderId]);

		    // delete SO Items
			$selectSOitemsSql = 'SELECT orderItemId FROM salesorderitem WHERE salesOrderId= :salesOrderId';
			$selectSOitemsStatement = $conn->prepare($selectSOitemsSql);
			$selectSOitemsStatement->execute(['salesOrderId' => $salesOrderId]);

			while($SOitem = $selectSOitemsStatement->fetch(PDO::FETCH_ASSOC)){
				$deleteSOitemsSql = 'DELETE FROM salesorderitem WHERE orderItemId=:orderItemId';
				$deleteSOitemsStatement = $conn->prepare($deleteSOitemsSql);
				$deleteSOitemsStatement->execute(['orderItemId' => $SOitem['orderItemId']]);
			}

			foreach ($salesItem as $item) {
				$insertSalesSql = 'INSERT INTO salesorderitem(productID, itemNumber, itemName, unitPrice, quantity, salesOrderId, totalPrice) VALUES(:productID,:itemNumber, :itemName, :unitPrice, :quantity, :salesOrderId, :totalPrice)';
				$insertSalesStatement = $conn->prepare($insertSalesSql);
				$insertSalesStatement->execute(['productID' => $item['id'], 'itemNumber' => $item['itemNumber'], 'itemName' => $item['name'], 'unitPrice' => $item['sellingPrice'], 'quantity' => $item['quntity'], 'salesOrderId' => $salesOrderId, 'totalPrice'=> $item['total']]);					
			}

			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Sales details updated successfully.</div>';
			exit();

		
		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>