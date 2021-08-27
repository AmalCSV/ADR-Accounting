<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['saleDetailsSaleID'])){
		$saleDetailsSaleID = htmlentities($_POST['saleDetailsSaleID']);
		$discount = htmlentities($_POST['saleDetailsDiscount']);
		$salesOrderNetTotal = htmlentities($_POST['salesOrderNetTotal']);
		$salesItem = htmlentities($_POST['salesItem']);
		$salesOrderTotal = htmlentities($_POST['salesOrderTotal']);
		$customerName = htmlentities($_POST['saleDetailsCustomerName']);
		$saleDate = htmlentities($_POST['saleDetailsSaleDate']);
		
		// Check if mandatory fields are not empty
		if(!empty($saleDetailsSaleID) && isset($salesOrderTotal) && isset($customerName) && isset($saleDate) && isset($salesItem)){
			
			// insert sales order 

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


			// Calculate the stock values
			$stockSql = 'SELECT stock FROM item WHERE itemNumber = :itemNumber';
			$stockStatement = $conn->prepare($stockSql);
			$stockStatement->execute(['itemNumber' => $itemNumber]);
			if($stockStatement->rowCount() > 0){
				// Item exits in DB, therefore, can proceed to a sale
				$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
				$currentQuantityInItemsTable = $row['stock'];
				
				if($currentQuantityInItemsTable <= 0) {
					// If currentQuantityInItemsTable is <= 0, stock is empty! that means we can't make a sell. Hence abort.
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Stock is empty. Therefore, can\'t make a sale. Please select a different item.</div>';
					exit();
				} elseif ($currentQuantityInItemsTable < $quantity) {
					// Requested sale quantity is higher than available item quantity. Hence abort 
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Not enough stock available for this sale. Therefore, can\'t make a sale. Please select a different item.</div>';
					exit();
				}
				else {
					// Has at least 1 or more in stock, hence proceed to next steps
					$newQuantity = $currentQuantityInItemsTable - $quantity;
					
					// Check if the customer is in DB
					$customerSql = 'SELECT * FROM customer WHERE customerID = :customerID';
					$customerStatement = $conn->prepare($customerSql);
					$customerStatement->execute(['customerID' => $customerID]);
					
					if($customerStatement->rowCount() > 0){
						// Customer exits. That means both customer, item, and stocks are available. Hence start INSERT and UPDATE
						$customerRow = $customerStatement->fetch(PDO::FETCH_ASSOC);
						$customerName = $customerRow['fullName'];
						
						// INSERT data to sale table
						$insertSaleSql = 'INSERT INTO sale(itemNumber, itemName, discount, quantity, unitPrice, customerID, customerName, saleDate) VALUES(:itemNumber, :itemName, :discount, :quantity, :unitPrice, :customerID, :customerName, :saleDate)';
						$insertSaleStatement = $conn->prepare($insertSaleSql);
						$insertSaleStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'discount' => $discount, 'quantity' => $quantity, 'unitPrice' => $unitPrice, 'customerID' => $customerID, 'customerName' => $customerName, 'saleDate' => $saleDate]);
						
						// UPDATE the stock in item table
						$stockUpdateSql = 'UPDATE item SET stock = :stock WHERE itemNumber = :itemNumber';
						$stockUpdateStatement = $conn->prepare($stockUpdateSql);
						$stockUpdateStatement->execute(['stock' => $newQuantity, 'itemNumber' => $itemNumber]);
						
						echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Sale details added to DB and stocks updated.</div>';
						exit();
						
					} else {
						echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer does not exist.</div>';
						exit();
					}
				}
				
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
				exit();
			} else {
				// Item does not exist, therefore, you can't make a sale from it
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB.</div>';
				exit();
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>