<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$paymentId = htmlentities($_POST['paymentId']);
	$status = htmlentities($_POST['status']);
	$note = htmlentities($_POST['note']);
	
	if(isset($_POST['paymentId'])){

        // Check if the item is in the database
        $paymentSql = 'SELECT * FROM purchaseorderpayment WHERE id=:id';
        $paymentStatement = $conn->prepare($paymentSql);
        $paymentStatement->execute(['id' => $paymentId]);
        $paymentRow = $paymentStatement->fetch(PDO::FETCH_ASSOC);
        $paymentAmount = $paymentRow['amount'];
        $orderId = $paymentRow['purchaseOrderID'];
                
        if($paymentStatement->rowCount() > 0){
            
            // payment exists in DB. Hence start the DELETE process
            $updatePaymentSql = 'UPDATE purchaseorderpayment SET chequeStatus = :chequeStatus, note = :note where id= :id';
            $updatePaymentStatement = $conn->prepare($updatePaymentSql);
            $updatePaymentStatement->execute(['chequeStatus' => $status,'note' => $note, 'id' => $paymentId]);
    
            if($status == "Deposited"){

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
				$updatePurchaseStatement->execute(['orderId' => $orderId, 'paidAmount' => ($paymentAmount + $paidAmount)]);

            }

            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Cheque is updated.</div>';
            exit();
            
        } else {
            // payment does not exist, therefore, tell the user that he can't delete that payment 
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Payment does not exist in DB. Therefore, can\'t update.</div>';
            exit();
        }
			
	}
?>