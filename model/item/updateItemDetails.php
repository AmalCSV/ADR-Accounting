<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['itemDetailsProductID'])) {
		
		$productId = htmlentities($_POST['itemDetailsProductID']);
		$itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
		$itemName = htmlentities($_POST['itemDetailsItemName']);
		$status = htmlentities($_POST['itemDetailsStatus']);
		$description = htmlentities($_POST['itemDetailsDescription']);
		$status = htmlentities($_POST['itemDetailsStatus']);
		$unitOfMeasure = htmlentities($_POST['itemDetailsUnitMeasure']);
		$buyingPrice = htmlentities($_POST['itemDetailsBuyingPrice']);
		$sellingPrice = htmlentities($_POST['itemDetailsSellingPrice']);
		$warningQuantity = htmlentities($_POST['itemDetailsWarningQty']);
		$itemRackNo = htmlentities($_POST['itemDetailsRackNo']);

		$initialStock = 0;
		$newStock = 0;
		
		// Check if mandatory fields are not empty
		if(!empty($productId) && $productId > 0 && !empty($itemNumber) && !empty($itemName) && isset($sellingPrice) && isset($buyingPrice)){
			
			// Sanitize item number
			$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);
			
			// // Validate item quantity. It has to be a number
			// if(filter_var($itemDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($itemDetailsQuantity, FILTER_VALIDATE_INT)){
			// 	// Valid quantity
			// } else {
			// 	// Quantity is not a valid number
			// 	$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
			// 	$data = ['alertMessage' => $errorAlert];
			// 	echo json_encode($data);
			// 	exit();
			// }
			
			// Validate unit price. It has to be a number or floating point value
			if(filter_var($buyingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($buyingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid unit price
			} else {
				// Unit price is not a valid number
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for buying price</div>';
				$data = ['alertMessage' => $errorAlert];
				echo json_encode($data);
				exit();
			}

			// Validate unit price. It has to be a number or floating point value
			if(filter_var($sellingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($sellingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid unit price
			} else {
				// Unit price is not a valid number
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for selling price</div>';
				$data = ['alertMessage' => $errorAlert];
				echo json_encode($data);
				exit();
			}
			
			// Calculate the stock
			// $stockSelectSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
			// $stockSelectStatement = $conn->prepare($stockSelectSql);
			// $stockSelectStatement->execute(['itemNumber' => $itemNumber]);
			// if($stockSelectStatement->rowCount() > 0) {
			// 	$row = $stockSelectStatement->fetch(PDO::FETCH_ASSOC);
			// 	$initialStock = $row['stock'];
			// 	$newStock = $initialStock + $itemDetailsQuantity;
			// } else {
			// 	// Item is not in DB. Therefore, stop the update and quit
			// 	$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item Number does not exist in DB. Therefore, update not possible.</div>';
			// 	$data = ['alertMessage' => $errorAlert];
			// 	echo json_encode($data);
			// 	exit();
			// }

			// Construct the UPDATE query
			$updateItemDetailsSql = 'UPDATE item SET itemNumber = :itemNumber, itemName = :itemName, unitOfMeasure = :unitOfMeasure, buyingPrice = :buyingPrice,  sellingPrice = :sellingPrice, warningQty = :warningQty, rackNo = :rackNo, status = :status, description = :description WHERE productID = :productID';
			$updateItemDetailsStatement = $conn->prepare($updateItemDetailsSql);
			$updateItemDetailsStatement->execute(['itemName' => $itemName, 'unitOfMeasure' => $unitOfMeasure, 'buyingPrice' => $buyingPrice, 'sellingPrice' => $sellingPrice, 'warningQty' => $warningQuantity, 'rackNo' => $itemRackNo, 'status' => $status, 'description' => $description, 'itemNumber' => $itemNumber,  'productID' => $productId]);
			
			// UPDATE item name in sale table
			$updateItemInSaleTableSql = 'UPDATE sale SET itemName = :itemName WHERE itemNumber = :itemNumber';
			$updateItemInSaleTableSstatement = $conn->prepare($updateItemInSaleTableSql);
			$updateItemInSaleTableSstatement->execute(['itemName' => $itemName, 'itemNumber' => $itemNumber]);
			
			// UPDATE item name in purchase table
			$updateItemInPurchaseTableSql = 'UPDATE purchase SET itemName = :itemName WHERE itemNumber = :itemNumber';
			$updateItemInPurchaseTableSstatement = $conn->prepare($updateItemInPurchaseTableSql);
			$updateItemInPurchaseTableSstatement->execute(['itemName' => $itemName, 'itemNumber' => $itemNumber]);
			
			$successAlert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item details updated.</div>';
			$data = ['alertMessage' => $successAlert, 'newStock' => $newStock];
			echo json_encode($data);
			exit();
			
		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			$data = ['alertMessage' => $errorAlert];
			echo json_encode($data);
			exit();
		}
	}
	else{
		// One or more mandatory fields are empty. Therefore, display the error message
		$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Invalid Details</div>';
		$data = ['alertMessage' => $errorAlert];
		echo json_encode($data);
		exit();
	}
?>