<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
		$purchaseDetailsPurchaseDate = htmlentities($_POST['purchaseDetailsPurchaseDate']);
		$purchaseDetailsVendorName = htmlentities($_POST['purchaseDetailsVendorName']);
		$purchaseDetailsNumber = htmlentities($_POST['purchaseDetailsVendorName']);
		$purchaseDetailsPurchaseID = htmlentities($_POST['purchaseDetailsPurchaseID']);
		
		$purchaseDetailsGrandTotal = htmlentities($_POST['purchaseDetailsGrandTotal']);
		$purchaseDetailsDescription = htmlentities($_POST['purchaseDetailsDescription']);
		$purchaseItems = $_POST['purchaseItems'];

		$initialStock = 0;
		$newStock = 0;
		
		// Check if mandatory fields are not empty
		if( isset($purchaseDetailsPurchaseID) && isset($purchaseDetailsPurchaseDate) && isset($purchaseDetailsVendorName) && isset($purchaseDetailsGrandTotal) && $purchaseDetailsVendorName != ''){		
			
			// Sanitize item number
			//$purchaseDetailsItemNumber = filter_var($purchaseDetailsItemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be an integer
			//if(filter_var($purchaseDetailsQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($purchaseDetailsQuantity, FILTER_VALIDATE_INT)){
				// Valid quantity
			//} else {
				// Quantity is not a valid number
			// 	echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity.</div>';
			// 	exit();
			// }
			
			// Validate unit price. It has to be an integer or floating point value
			// if(filter_var($purchaseDetailsUnitPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($purchaseDetailsUnitPrice, FILTER_VALIDATE_FLOAT)){
				// Valid unit price
			// } else {
				// Unit price is not a valid number
			//	echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price.</div>';
			//	exit();
			// }
			
			// Get the vendorId for the given vendorName
			$vendorIDsql = 'SELECT * FROM vendor WHERE companyName = :fullName';
			$vendorIDStatement = $conn->prepare($vendorIDsql);
			$vendorIDStatement->execute(['fullName' => $purchaseDetailsVendorName]);
			$row = $vendorIDStatement->fetch(PDO::FETCH_ASSOC);
			$vendorID = $row['vendorID'];
			
			// insert purchase order 

			$insertPurchaseOrderSql = 'INSERT INTO purchaseOrder(orderNumber, orderDate, amount, vendorID, description) VALUES(:orderNumber, :orderDate, :amount, :vendorID, :note)';
			$insertPurchaseOrderStatement = $conn->prepare($insertPurchaseOrderSql);
			$insertPurchaseOrderStatement->execute(['orderNumber' => $purchaseDetailsPurchaseID, 'orderDate' => $purchaseDetailsPurchaseDate, 'amount' => $purchaseDetailsGrandTotal, 
				 'vendorID' => $vendorID, 'note' => $purchaseDetailsDescription]);

			$purchaseOrderID = $conn->lastInsertId();
				foreach ($purchaseItems as $item) {
					$insertPurchaseSql = 'INSERT INTO purchaseItem(itemNumber, purchaseDate, itemName, unitPrice, quantity, vendorName, vendorID, purchaseOrderID, totalPrice) VALUES(:itemNumber, :purchaseDate, :itemName, :unitPrice, :quantity, :vendorName, :vendorID, :purchaseOrderID, :totalPrice)';
					$insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
					$insertPurchaseStatement->execute(['itemNumber' => $item['id'], 'purchaseDate' => $purchaseDetailsPurchaseDate, 'itemName' => $item['name'], 'unitPrice' => $item['buyingPrice'], 'quantity' => $item['quntity'], 'vendorName' => $purchaseDetailsVendorName, 'vendorID' => $vendorID, 'purchaseOrderID' => $purchaseOrderID, 'totalPrice'=> $item['total']]);		
				}

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Purchase details added successfully.</div>';
				exit();

				// Item does not exist in item table, therefore, you can't make a purchase from it 
				// to add it to DB as a new purchase
				// echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB. Therefore, first enter this item to DB using the <strong>Item</strong> tab.</div>';
				// exit();


		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}

?>