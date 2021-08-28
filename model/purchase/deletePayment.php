<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$paymentId = htmlentities($_POST['paymentId']);
	
	if(isset($_POST['paymentId'])){

        // Check if the item is in the database
        $paymentSql = 'SELECT * FROM purchaseorderpayment WHERE id=:id';
        $paymentStatement = $conn->prepare($paymentSql);
        $paymentStatement->execute(['id' => $paymentId]);
        
        if($paymentStatement->rowCount() > 0){
            
            // payment exists in DB. Hence start the DELETE process
            $deletePaymentSql = 'UPDATE purchaseorderpayment SET isDeleted = :isDeleted where id= :id';
            $deletePaymentStatement = $conn->prepare($deletePaymentSql);
            $deletePaymentStatement->execute(['isDeleted' => true, 'id' => $paymentId]);

            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Payment deleted.</div>';
            exit();
            
        } else {
            // payment does not exist, therefore, tell the user that he can't delete that payment 
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>payment does not exist in DB. Therefore, can\'t delete.</div>';
            exit();
        }
			
	}
?>