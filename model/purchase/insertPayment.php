<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
		$orderId =  htmlentities($_POST['orderId']);
		$paymentAmount = htmlentities($_POST['paymentAmount']);
		$paymentDate = htmlentities($_POST['paymentDate']);
		$paymentType = htmlentities($_POST['paymentType']);
		$chequeNo = htmlentities($_POST['chequeNo']);
		$chequeDate = $paymentType == "Cash" ?  null : htmlentities($_POST['chequeDate']) ;
		$remainingAmount = htmlentities($_POST['remainingAmount']);
		$paymentNote = htmlentities($_POST['note']);

		
		// Check if mandatory fields are not empty
		if( isset($orderId) && isset($paymentAmount) && isset($paymentDate)){		
			
			// insert purchase order payment
			$insertPOPaymentSql = 'INSERT INTO purchaseorderpayment (purchaseOrderID, amount, date, type, chequeNo, realisationDate, note, chequeStatus) VALUES(:orderId, :amount, :date, :type, :chequeNo, :realisationDate, :note, "Received" )';
			$insertPOStatement = $conn->prepare($insertPOPaymentSql);
			$insertPOStatement->execute(['orderId' => $orderId, 'amount' => $paymentAmount, 'date' => $paymentDate,  'type' => $paymentType,  'chequeNo' => $chequeNo, 'realisationDate' => $chequeDate, 'note' => $paymentNote]);

			// update purchase order paid amount if payment type is cash.
			if($paymentType === 'Cash'){
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

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}

?>