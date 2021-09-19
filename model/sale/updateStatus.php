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

	if(isset($_POST['statusId']) && isset($_POST['saleID'])) {
            $saleID = $_POST['saleID'];
            $updateStatusSql = 'UPDATE salesorder SET status = :statusId WHERE saleID = :saleID';
            $updatePurchaseStatement = $conn->prepare($updateStatusSql);
            $updatePurchaseStatement->execute(['statusId' => $_POST['statusId'], 'saleID' => $saleID]);

            if($_POST['statusId'] == 2){
                $selectSOitemsSql = 'SELECT quantity,productID FROM salesorderitem WHERE salesOrderId= :salesOrderId';
			    $selectSOitemsStatement = $conn->prepare($selectSOitemsSql);
			    $selectSOitemsStatement->execute(['salesOrderId' => $saleID]);

                while($SOitem = $selectSOitemsStatement->fetch(PDO::FETCH_ASSOC)){
                    //UPDATE the stock in item table
                    $stockUpdateSql = 'UPDATE item SET stock =(stock -:stock) WHERE productID = :id';
                    $stockUpdateStatement = $conn->prepare($stockUpdateSql);
                    $stockUpdateStatement->execute(['stock' => $SOitem['quantity'], 'id' => $SOitem['productID']]);
                }
            }   
            
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Status updated successfully.</div>';
        exit();
    }
?>
