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
            $updateStatusSql = 'UPDATE purchaseorder SET status = :statusId WHERE purchaseID = :purchaseID';
            $updatePurchaseStatement = $conn->prepare($updateStatusSql);
            $updatePurchaseStatement->execute(['statusId' => $_POST['statusId'], 'purchaseID' => $_POST['purchaseID']]);
            
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Status updated successfully.</div>';
        exit();
    }
?>