<?php

// Updated script - 2018-05-09

	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['purchaseDetailsPurchaseID'])){

		$purchaseDetailsPurchaseDate = htmlentities($_POST['purchaseDetailsPurchaseDate']);
		$vendorID = htmlentities($_POST['vendorID']);
		$purchaseDetailsPurchaseID = htmlentities($_POST['purchaseDetailsPurchaseID']);
		
		$purchaseDetailsGrandTotal = htmlentities($_POST['purchaseDetailsGrandTotal']);
		$purchaseDetailsDescription = htmlentities($_POST['purchaseDetailsDescription']);
		$purchaseItems = $_POST['purchaseItems'];
		$purchaseOrderId = htmlentities($_POST['purchaseOrderId']);
		
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

			$insertPurchaseOrderSql = 'UPDATE purchaseorder SET orderNumber= :orderNumber , orderDate=:orderDate , amount=:amount, vendorID=:vendorID, description=:note WHERE purchaseID=:purchaseID';
			$insertPurchaseOrderStatement = $conn->prepare($insertPurchaseOrderSql);
			$insertPurchaseOrderStatement->execute(['orderNumber' => $purchaseDetailsPurchaseID, 'orderDate' => $purchaseDetailsPurchaseDate, 'amount' => $purchaseDetailsGrandTotal, 
				 'vendorID' => $vendorID, 'note' => $purchaseDetailsDescription, 'purchaseID' => $purchaseOrderId]);

		    // delete PO Items
			$selectPOitemsSql = 'SELECT purchaseItemID FROM purchaseitem WHERE purchaseOrderID= :purchaseOrderID';
			$selectPOitemsStatement = $conn->prepare($selectPOitemsSql);
			$selectPOitemsStatement->execute(['purchaseOrderID' => $purchaseOrderId]);

			while($POitem = $selectPOitemsStatement->fetch(PDO::FETCH_ASSOC)){
				$deletePOitemsSql = 'DELETE FROM purchaseitem WHERE purchaseItemID=:purchaseItemID';
				$deletePOitemsStatement = $conn->prepare($deletePOitemsSql);
				$deletePOitemsStatement->execute(['purchaseItemID' => $POitem['purchaseItemID']]);
			}

			foreach ($purchaseItems as $item) {
				$insertPurchaseSql = 'INSERT INTO purchaseitem(itemNumber, purchaseDate, itemName, unitPrice, quantity, vendorName, vendorID, purchaseOrderID, totalPrice,productID) VALUES(:itemNumber, :purchaseDate, :itemName, :unitPrice, :quantity, :vendorName, :vendorID, :purchaseOrderID, :totalPrice, :productID)';
				$insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
				$insertPurchaseStatement->execute(['itemNumber' => $item['itemNumber'], 'purchaseDate' => $purchaseDetailsPurchaseDate, 'itemName' => $item['name'], 'unitPrice' => $item['buyingPrice'], 'quantity' => $item['quntity'], 'vendorName' => $vendorName, 'vendorID' => $vendorID, 'purchaseOrderID' => $purchaseOrderId, 'totalPrice'=> $item['total'],'productID' => $item['id']]);		
			}

			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Purchase details added successfully.</div>';
			exit();

		
		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>