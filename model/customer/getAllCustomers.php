<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
		
		$itemDetailsSql = 'SELECT * FROM customer';
		$itemDetailsStatement = $conn->prepare($itemDetailsSql);
		$itemDetailsStatement->execute();
		
		// If data is found for the given item number, return it as a json object
		if($itemDetailsStatement->rowCount() > 0) {
			$row = $itemDetailsStatement->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$itemDetailsStatement->closeCursor();
?>