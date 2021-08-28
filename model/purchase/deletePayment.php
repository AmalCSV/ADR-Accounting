<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$paymentId = htmlentities($_POST['paymentId']);
	
	if(isset($_POST['paymentId'])){

        // Check if the item is in the database
        $paymentSql = 'SELECT * FROM purchaseorderpayment WHERE id=:id';
        $paymentStatement = $conn->prepare($paymentSql);
        $paymentStatement->execute(['id' => $paymentId]);
        $paymentRow = $paymentStatement->fetch(PDO::FETCH_ASSOC);
        $paymentType = $paymentRow['type'];
        $chequeStatus = $paymentRow['chequeStatus'];
        $paymentAmount = $paymentRow['amount'];
        $orderId = $paymentRow['purchaseOrderID'];

        if($paymentStatement->rowCount() > 0){
            
            // payment exists in DB. Hence start the DELETE process
            $deletePaymentSql = 'UPDATE purchaseorderpayment SET isDeleted = :isDeleted where id= :id';
            $deletePaymentStatement = $conn->prepare($deletePaymentSql);
            $deletePaymentStatement->execute(['isDeleted' => true, 'id' => $paymentId]);

            if($paymentType  === 'Cash' || $chequeStatus === "Deposited"){
				$selectPurchaseSql = 'SELECT paidAmount FROM purchaseorder WHERE purchaseID = :orderId';
				$selectPurchaseStatement = $conn->prepare($selectPurchaseSql);
				$selectPurchaseStatement->execute(['orderId' => $orderId]);
				$row = $selectPurchaseStatement->fetch(PDO::FETCH_ASSOC);
	
				$paidAmount = 0;
				if($selectPurchaseStatement->rowCount() > 0){
					$paidAmount = $row['paidAmount'];
				}

				$updatePurchaseSql = 'UPDATE purchaseorder SET paidAmount = :paidAmount where purchaseID = :orderId';
				$updatePurchaseStatement = $conn->prepare($updatePurchaseSql);
				$updatePurchaseStatement->execute(['orderId' => $orderId, 'paidAmount' => ( $paidAmount - $paymentAmount )]);
			}

            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Payment deleted.</div>';
            exit();
            
        } else {
            // payment does not exist, therefore, tell the user that he can't delete that payment 
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>payment does not exist in DB. Therefore, can\'t delete.</div>';
            exit();
        }
			
	}
?>