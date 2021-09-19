<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['items']) && isset($_POST['saleId'])) {
        $deliveredItems = $_POST['items'];
        $saleId = $_POST['saleId'];
        foreach ($deliveredItems as $item) {
            $insertPurchaseSql = 'UPDATE salesorderitem SET deliveredQuantity = :deliveredQuantity WHERE orderItemId = :orderItemId';
            $insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
            $insertPurchaseStatement->execute(['deliveredQuantity' => $item['delivered'], 'orderItemId' => $item['id']]);
        }
        $soUpdateSql = 'UPDATE salesorder SET status = 5 WHERE saleID = :saleId';
        $soUpdateStatement = $conn->prepare($soUpdateSql);
        $soUpdateStatement->execute(['saleId' => $saleId]);
        
        $message = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Goods delivered successfully.</div>';
		$data = ['alertMessage' => $message, 'status' => "success"];
		echo json_encode($data);
        exit();
    } else {
    // One or more mandatory fields are empty. Therefore, display a the error message
    $message = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter valid amount</div>';
	$data = ['alertMessage' => $message, 'status' => "error"];
	echo json_encode($data);
    exit();
    }
?>
