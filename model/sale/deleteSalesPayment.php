<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$paymentId = htmlentities($_POST['paymentId']);
	
	if(isset($_POST['paymentId'])){

        // Check if the item is in the database
        $paymentSql = 'SELECT * FROM salesorderpayment WHERE id=:id';
        $paymentStatement = $conn->prepare($paymentSql);
        $paymentStatement->execute(['id' => $paymentId]);
        $paymentRow = $paymentStatement->fetch(PDO::FETCH_ASSOC);
        $paymentType = $paymentRow['type'];
        $chequeStatus = $paymentRow['chequeStatus'];
        $paymentAmount = $paymentRow['amount'];
        $orderId = $paymentRow['salesOrderID'];

        if($paymentStatement->rowCount() > 0){
            
            // payment exists in DB. Hence start the DELETE process
            $deletePaymentSql = 'UPDATE salesorderpayment SET isDeleted = :isDeleted where id= :id';
            $deletePaymentStatement = $conn->prepare($deletePaymentSql);
            $deletePaymentStatement->execute(['isDeleted' => true, 'id' => $paymentId]);

            if($paymentType  === 'Cash' || $chequeStatus === "Deposited"){
				$selectSalesSql = 'SELECT paidAmount FROM salesorder WHERE saleID = :orderId';
				$selectSalesStatement = $conn->prepare($selectSalesSql);
				$selectSalesStatement->execute(['orderId' => $orderId]);
				$row = $selectSalesStatement->fetch(PDO::FETCH_ASSOC);
	
				$paidAmount = 0;
				if($selectSalesStatement->rowCount() > 0){
					$paidAmount = $row['paidAmount'];
				}

				$updateSalesSql = 'UPDATE salesorder SET paidAmount = :paidAmount where saleID = :orderId';
				$updateSalesStatement = $conn->prepare($updateSalesSql);
				$updateSalesStatement->execute(['orderId' => $orderId, 'paidAmount' => ( $paidAmount - $paymentAmount )]);
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