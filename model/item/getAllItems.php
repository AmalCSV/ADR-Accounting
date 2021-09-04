<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	$vendorId = null;
	if(isset($_POST['vendorId'])){
		$vendorId = $_POST['vendorId'];
	}
	// Execute the script if the POST request is submitted
		
		$itemDetailsSql = 'SELECT i.*, v.vendorID, v.companyName FROM item i left join vendor v on i.vendorID = v.vendorID where i.status ="Active"';
		if(!is_null($vendorId)){
			$itemDetailsSql = $itemDetailsSql .' AND i.vendorID = '. $vendorId;
		}

		$itemDetailsStatement = $conn->prepare($itemDetailsSql);
		$itemDetailsStatement->execute();
		
		// If data is found for the given item number, return it as a json object
		if($itemDetailsStatement->rowCount() > 0) {
			$row = $itemDetailsStatement->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$itemDetailsStatement->closeCursor();
?>