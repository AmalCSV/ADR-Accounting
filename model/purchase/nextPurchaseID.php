<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$sql = "SELECT CONCAT_WS('-', 'PO', max(purchaseID) + 1001) as nextPO from purchaseOrder";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	echo $row['nextPO'];
	$stmt->closeCursor();
?>

