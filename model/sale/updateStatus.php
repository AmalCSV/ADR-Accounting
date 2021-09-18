<?php
/*
1- created
2- pending
3- close
4- cancel
5- delivered
*/
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['statusId']) && isset($_POST['purchaseID'])) {
            $updateStatusSql = 'UPDATE salesorder SET status = :statusId WHERE saleID = :saleID';
            $updatePurchaseStatement = $conn->prepare($updateStatusSql);
            $updatePurchaseStatement->execute(['statusId' => $_POST['statusId'], 'saleID' => $_POST['saleID']]);
            
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Status updated successfully.</div>';
        exit();
    }
?>