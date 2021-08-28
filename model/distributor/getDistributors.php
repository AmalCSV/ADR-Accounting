<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
		$distributorsSql = 'SELECT * FROM distributor';
		$distributorsSqlStatement = $conn->prepare($distributorsSql);
		$distributorsSqlStatement->execute();
		
		// If data is found for the given item number, return it as a json object
		if($distributorsSqlStatement->rowCount() > 0) {
			$row = $distributorsSqlStatement->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$distributorsSqlStatement->closeCursor();
?>