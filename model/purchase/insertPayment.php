<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
		$orderId =  htmlentities($_POST['orderId']);
		$paymentAmount = htmlentities($_POST['paymentAmount']);
		$paymentDate = htmlentities($_POST['paymentDate']);
		$paymentType = htmlentities($_POST['paymentType']);
		$chequeNo = htmlentities($_POST['chequeNo']);
		$chequeDate = htmlentities($_POST['chequeDate']);
		$remainingAmount = htmlentities($_POST['remainingAmount']);
		$paymentNote = htmlentities($_POST['note']);

		
		// Check if mandatory fields are not empty
		if( isset($orderId) && isset($paymentAmount) && isset($paymentDate)){		
			
			// insert purchase order payment

			$insertPOPaymentSql = 'INSERT INTO purchaseorderpayment (purchaseOrderID, amount, date, type, chequeNo, realisationDate, note) VALUES(:orderId, :amount, :date, :type, :chequeNo, :realisationDate, :note)';
			$insertPOStatement = $conn->prepare($insertPOPaymentSql);
			$insertPOStatement->execute(['orderId' => $orderId, 'amount' => $paymentAmount, 'date' => $paymentDate,  'type' => $paymentType,  'chequeNo' => $chequeNo,   'realisationDate' => $chequeDate, 'note' => $paymentNote]);

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}

?>