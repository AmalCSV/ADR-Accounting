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
		$isDiscountAmount = htmlentities($_POST['isDiscountAmount']);
        $discount =  htmlentities($_POST['discount']);
		
		// Check if mandatory fields are not empty
		if(!empty($saleDetailsSaleID) && isset($salesOrderTotal) && isset($customerName) && isset($saleDate) && isset($salesItem)){

			if($isDiscountAmount === 'true'){
				$discountAmount = $discount;
				$isDiscountAmount = 1;
			} else {
				$discountAmount = $salesOrderTotal - $salesOrderNetTotal;
				$isDiscountAmount = 0;
			}
			// insert sales order 
			
			$insertSalesOrderSql = 'INSERT INTO salesorder(salesNumber, saleDate, amount, customerID, description, discount, discountPercentage, customerName, vendorID, isDiscountAmount) 
			VALUES(:salesNumber, :saleDate, :amount, :customerID, :note, :discount, :discountPercentage, :customerName, :vendorId, :isDiscountAmount)';
			$insertSalesOrderStatement = $conn->prepare($insertSalesOrderSql);
			$insertSalesOrderStatement->execute(['salesNumber' => $saleDetailsSaleID, 'saleDate' => $saleDate, 'amount' => $salesOrderNetTotal, 
				 'customerID' => $saleDetailsCustomerID, 'note' => $salesDetailsDescription, 'discount' => $discountAmount, 'discountPercentage' => $discountp, 'customerName' => $customerName, 'vendorId' => $vendorId, 'isDiscountAmount' => $isDiscountAmount]);

			$salesOrderID = $conn->lastInsertId();
				foreach ($salesItem as $item) {
					$insertSalesSql = 'INSERT INTO salesorderitem(productID, itemNumber, itemName, unitPrice, quantity, salesOrderId, totalPrice) VALUES(:productID,:itemNumber, :itemName, :unitPrice, :quantity, :salesOrderId, :totalPrice)';
					$insertSalesStatement = $conn->prepare($insertSalesSql);
					$insertSalesStatement->execute(['productID' => $item['id'], 'itemNumber' => $item['itemNumber'], 'itemName' => $item['name'], 'unitPrice' => $item['sellingPrice'], 'quantity' => $item['quntity'], 'salesOrderId' => $salesOrderID, 'totalPrice'=> $item['total']]);		
				
					// UPDATE the stock in item table
					// $stockUpdateSql = 'UPDATE item SET stock =(stock -:stock) WHERE productID = :id';
					// $stockUpdateStatement = $conn->prepare($stockUpdateSql);
					// $stockUpdateStatement->execute(['stock' => $item['quntity'], 'id' => $item['id']]);
				
				}

				$message = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Sales details added successfully.</div>';
				$data = ['alertMessage' => $message, 'status' => "success", 'salesOrderId' => $salesOrderID];
				echo json_encode($data);
				exit();

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			$message = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			$data = ['alertMessage' => $message, 'status' => "error"];
			echo json_encode($data);
			exit();
		}
	}
?>