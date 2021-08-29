<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['id'])){
		
		$productID = htmlentities($_POST['id']);
		
			
		$defaultImgFolder = 'data/item_images/';
		
		// Get all item details
		$sql = 'SELECT * FROM item WHERE productID = :productID';
		$stmt = $conn->prepare($sql);
		$stmt->execute(['productID' => $productID]);
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$output = '<p><img src="';
		
			if($row['imageURL'] === '' || $row['imageURL'] === 'imageNotAvailable.jpg'){
				$output .= 'data/item_images/imageNotAvailable.jpg" class="img-fluid"></p>';
			} else {
				$output .= 'data/item_images/' . $row['productID'] . '/' . $row['imageURL'] . '" class="img-fluid"></p>';
			}
						
			$output .= '<span><strong>Name:</strong> ' . $row['itemName'] . '</span><br>';
			$output .= '<span><strong>Selling Price:</strong> ' . $row['sellingPrice'] . '</span><br>';
			$output .= '<span><strong>Buying Price:</strong> ' . $row['buyingPrice'] . '</span><br>';
			$output .= '<span><strong>Stock:</strong> ' . $row['stock'] . '</span><br>';
			$output .= '<span><strong>Warning Stock:</strong> ' . $row['warningQty'] . '</span><br>';
		}
		
		echo $output;
	}
?>