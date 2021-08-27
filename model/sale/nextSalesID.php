<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$sql = "SELECT CONCAT_WS('-', 'SO', max(saleID) + 1001) as nextSO from salesOrder";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $row['nextSO'];
	$stmt->closeCursor();
?>