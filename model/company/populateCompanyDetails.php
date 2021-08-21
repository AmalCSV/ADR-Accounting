<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	// Execute the script if the POST request is submitted
		$companyDetailsSql = 'SELECT * FROM company';
		$companyDetailsSqlStatement = $conn->prepare($companyDetailsSql);
		$companyDetailsSqlStatement->execute();
		
		// If data is found for the given item number, return it as a json object
		if($companyDetailsSqlStatement->rowCount() > 0) {
			$row = $companyDetailsSqlStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$companyDetailsSqlStatement->closeCursor();
?>