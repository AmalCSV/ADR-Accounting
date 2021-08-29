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
		$itemDetailsVendorID = htmlentities($_POST['itemDetailsVendorID']);
	
		// Check if mandatory fields are not empty
		if(!empty($itemNumber) && !empty($itemName) && isset($sellingPrice) && isset($buyingPrice) && $itemDetailsVendorID != "null"){
			
			// Sanitize item number
			$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be a number
			if(filter_var($initialQty, FILTER_VALIDATE_INT) === 0 || filter_var($initialQty, FILTER_VALIDATE_INT)){
				// Valid quantity
			} else {
				// Quantity is not a valid number
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for initial quantity</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}
			
			// Validate item quantity. It has to be a number
			if(filter_var($warningQuantity, FILTER_VALIDATE_INT) === 0 || filter_var($warningQuantity, FILTER_VALIDATE_INT)){
				// Valid quantity
			} else {
				// Quantity is not a valid number
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for warning quantity</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}
			
			// Validate unit price. It has to be a number or floating point value
			if(filter_var($buyingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($buyingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid float (buying price)
			} else {
				// Unit price is not a valid number
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for buying price</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}

			// Validate unit price. It has to be a number or floating point value
			if(filter_var($sellingPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($sellingPrice, FILTER_VALIDATE_FLOAT)){
				// Valid float (selling price)
			} else {
				// Unit price is not a valid number
				$errorAlert =  '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for selling price</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
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
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			} else {
				// Item does not exist, therefore, you can add it to DB as a new item
				// Start the insert process
				$insertItemSql = 'INSERT INTO item(itemNumber, itemName, unitOfMeasure, stock,  buyingPrice, sellingPrice, warningQty , rackNo, status, description, vendorID) VALUES(:itemNumber, :itemName, :unitOfMeasure, :stock,  :buyingPrice, :sellingPrice, :warningQty,:rackNo,  :status, :description, :vendorID)';
				$insertItemStatement = $conn->prepare($insertItemSql);
				$insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'unitOfMeasure' => $unitOfMeasure, 'stock' => $initialQty,'buyingPrice' => $buyingPrice, 'sellingPrice' => $sellingPrice, 'warningQty' => $warningQuantity, 'rackNo' => $itemitemRackNo,  'status' => $status, 'description' => $description, 'vendorID' => $itemDetailsVendorID]);
				
				$successAlert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
				$data = ['alertMessage' => $successAlert, 'status' => "success"];
				echo json_encode($data);
				exit();
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			$data = ['alertMessage' => $errorAlert, 'status' => "error"];
			echo json_encode($data);
			exit();
		}
	}
	else{
		
	}
?>