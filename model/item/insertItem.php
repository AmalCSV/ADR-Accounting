<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$initialStock = 0;
	$baseImageFolder = '../../data/item_images/';
	$itemImageFolder = '';
	
	if(isset($_POST['itemDetailsItemNumber'])){
		
		$itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
		$itemName = htmlentities($_POST['itemDetailsItemName']);
		$status = htmlentities($_POST['itemDetailsStatus']);
		$unitOfMeasure = htmlentities($_POST['itemDetailsUnitMeasure']);
		$initialQty = htmlentities($_POST['itemDetailsInitialQty']);
		$buyingPrice = htmlentities($_POST['itemDetailsBuyingPrice']);
		$sellingPrice = htmlentities($_POST['itemDetailsSellingPrice']);
		$description = htmlentities($_POST['itemDetailsDescription']);
		$warningQuantity = htmlentities($_POST['itemDetailsWarningQty']);
		$itemitemRackNo = htmlentities($_POST['itemDetailsRackNo']);

	
		// Check if mandatory fields are not empty
		if(!empty($itemNumber) && !empty($itemName) && isset($sellingPrice) && isset($buyingPrice)){
			
			// Sanitize item number
			$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be a number
			if(filter_var($initialQty, FILTER_VALIDATE_INT) === 0 || filter_var($initialQty, FILTER_VALIDATE_INT)){
				// Valid quantity
			} else {
				// Quantity is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for initial quantity</div>';
				exit();
			}
			
			// Validate item quantity. It has to be a number
			if(filter_var($warningQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($warningQuantity, FILTER_VALIDATE_INT)){
				// Valid quantity
			} else {
				// Quantity is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for warning quantity</div>';
				exit();
			}
			
			// Validate unit price. It has to be a number or floating point value
			if(filter_var($buyingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($buyingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid float (buying price)
			} else {
				// Unit price is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for buying price</div>';
				exit();
			}

			// Validate unit price. It has to be a number or floating point value
			if(filter_var($sellingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($sellingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid float (selling price)
			} else {
				// Unit price is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for selling price</div>';
				exit();
			}
			
			// Create image folder for uploading images
			$itemImageFolder = $baseImageFolder . $itemNumber;
			if(is_dir($itemImageFolder)){
				// Folder already exist. Hence, do nothing
			} else {
				// Folder does not exist, Hence, create it
				mkdir($itemImageFolder);
			}
			
			// Calculate the stock values
			$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
			$stockStatement = $conn->prepare($stockSql);
			$stockStatement->execute(['itemNumber' => $itemNumber]);
			if($stockStatement->rowCount() > 0){
				//$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
				//$quantity = $quantity + $row['stock'];
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
				exit();
			} else {
				// Item does not exist, therefore, you can add it to DB as a new item
				// Start the insert process
				// $insertItemSql = 'INSERT INTO item(itemNumber, itemName, unitOfMeasure, stock, buyingPrice, sellingPrice, warningQty, rackNo, status, description) VALUES(:itemNumber, :itemName, :unitOfMeasure, :stock, :buyingPrice, :sellingPrice, :warningQty, :rackNo, :status, :description)';
				// $insertItemStatement = $conn->prepare($insertItemSql);
				//  $insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'unitOfMeasure' => $unitOfMeasure, 'stock' => $initialQty, 'buyingPrice' => $buyingPrice, 'sellingPrice' => $sellingPrice, 'warningQuantity' => $warningQuantity,  'rackNo' => $itemitemRackNo, 'status' => $status, 'description' => $description]);
				

				 $insertItemSql = 'INSERT INTO item(itemNumber, itemName, unitOfMeasure, stock,  buyingPrice, sellingPrice, warningQty , rackNo, status, description) VALUES(:itemNumber, :itemName, :unitOfMeasure, :stock,  :buyingPrice, :sellingPrice, :warningQty,:rackNo,  :status, :description)';
				$insertItemStatement = $conn->prepare($insertItemSql);
				 $insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'unitOfMeasure' => $unitOfMeasure, 'stock' => $initialQty,'buyingPrice' => $buyingPrice, 'sellingPrice' => $sellingPrice, 'warningQty' => $warningQuantity, 'rackNo' => $itemitemRackNo,  'status' => $status, 'description' => $description]);

				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
				exit();

			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
	else{
		
	}
?>