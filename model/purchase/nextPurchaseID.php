<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$sql = "SELECT CONCAT_WS('-', 'PO', IFNULL(max(purchaseID),0) + 1001) as nextPO from purchaseorder";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $row['nextPO'];
	$stmt->closeCursor();
?>

