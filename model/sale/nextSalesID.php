<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$sql = "SELECT CONCAT_WS('-', 'SO', IFNULL(max(saleID),0) + 1001) as nextSO from salesorder";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $row['nextSO'];
	$stmt->closeCursor();
?>