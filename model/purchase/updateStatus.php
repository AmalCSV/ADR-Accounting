<?php
/*
1- created
2- pending
3- close
4- cancel
*/
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['statusId']) && isset($_POST['purchaseID'])) {
            $insertPurchaseSql = 'UPDATE purchaseOrder SET status = :statusId WHERE purchaseID = :purchaseID';
            $insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
            $insertPurchaseStatement->execute(['statusId' => $item['statusId'], 'purchaseID' => $item['purchaseID']]);
            
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Status updated successfully.</div>';
        exit();
    }
?>