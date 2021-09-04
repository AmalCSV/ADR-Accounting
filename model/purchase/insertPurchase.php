<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
		$purchaseDetailsPurchaseDate = htmlentities($_POST['purchaseDetailsPurchaseDate']);
		$vendorID = htmlentities($_POST['vendorID']);
		$purchaseDetailsPurchaseID = htmlentities($_POST['purchaseDetailsPurchaseID']);
		
		$purchaseDetailsGrandTotal = htmlentities($_POST['purchaseDetailsGrandTotal']);
		$purchaseDetailsDescription = htmlentities($_POST['purchaseDetailsDescription']);
		$purchaseItems = $_POST['purchaseItems'];

		$initialStock = 0;
		$newStock = 0;
		
		// Check if mandatory fields are not empty
		if( isset($purchaseDetailsPurchaseID) && isset($purchaseDetailsPurchaseDate) && isset($vendorID) && isset($purchaseDetailsGrandTotal) ){	
			if($purchaseDetailsGrandTotal == 'null' || $purchaseDetailsGrandTotal == 0){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Invalid Amount.</div>';
				exit();
			}

			if($purchaseDetailsPurchaseDate == 'null' || $purchaseDetailsPurchaseDate == ''){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select the Order date</div>';
				exit();
			}
			if($vendorID == 'null'){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select a vendor</div>';
				exit();
			}		
			// Get the vendorId for the given vendorName
			$vendorIDsql = 'SELECT * FROM vendor WHERE vendorID = :vendorID';
			$vendorIDStatement = $conn->prepare($vendorIDsql);
			$vendorIDStatement->execute(['vendorID' => $vendorID]);
			$row = $vendorIDStatement->fetch(PDO::FETCH_ASSOC);
			$vendorName = $row['companyName'];
			
			// insert purchase order 

			$insertPurchaseOrderSql = 'INSERT INTO purchaseorder(orderNumber, orderDate, amount, vendorID, description) VALUES(:orderNumber, :orderDate, :amount, :vendorID, :note)';
			$insertPurchaseOrderStatement = $conn->prepare($insertPurchaseOrderSql);
			$insertPurchaseOrderStatement->execute(['orderNumber' => $purchaseDetailsPurchaseID, 'orderDate' => $purchaseDetailsPurchaseDate, 'amount' => $purchaseDetailsGrandTotal, 
				 'vendorID' => $vendorID, 'note' => $purchaseDetailsDescription]);

			$purchaseOrderID = $conn->lastInsertId();
				foreach ($purchaseItems as $item) {
					$insertPurchaseSql = 'INSERT INTO purchaseitem(itemNumber, purchaseDate, itemName, unitPrice, quantity, vendorName, vendorID, purchaseOrderID, totalPrice) VALUES(:itemNumber, :purchaseDate, :itemName, :unitPrice, :quantity, :vendorName, :vendorID, :purchaseOrderID, :totalPrice)';
					$insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
					$insertPurchaseStatement->execute(['itemNumber' => $item['id'], 'purchaseDate' => $purchaseDetailsPurchaseDate, 'itemName' => $item['name'], 'unitPrice' => $item['buyingPrice'], 'quantity' => $item['quntity'], 'vendorName' => $vendorName, 'vendorID' => $vendorID, 'purchaseOrderID' => $purchaseOrderID, 'totalPrice'=> $item['total']]);		
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