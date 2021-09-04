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
			$insertSOPaymentSql = 'INSERT INTO salesorderpayment (salesOrderID, amount, date, type, chequeNo, realisationDate, note, chequeStatus) VALUES(:orderId, :amount, :date, :type, :chequeNo, :realisationDate, :note, "Received" )';
			$insertSOStatement = $conn->prepare($insertSOPaymentSql);
			$insertSOStatement->execute(['orderId' => $orderId, 'amount' => $paymentAmount, 'date' => $paymentDate,  'type' => $paymentType,  'chequeNo' => $chequeNo, 'realisationDate' => $chequeDate, 'note' => $paymentNote]);

			// update purchase order paid amount if payment type is cash.
			if($paymentType === 'Cash'){
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
				$updateSalesStatement->execute(['orderId' => $orderId, 'paidAmount' => ($paymentAmount + $paidAmount)]);
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}

?>