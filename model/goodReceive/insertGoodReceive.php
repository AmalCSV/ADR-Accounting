<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['items']) && isset($_POST['purchaseId'])) {
        $goodReceivedItems = $_POST['items'];
        $purchaseId = $_POST['purchaseId'];
        foreach ($goodReceivedItems as $item) {
            $insertPurchaseSql = 'UPDATE purchaseitem SET goodReceivedQuantity = :goodReceived WHERE purchaseItemID = :purchaseItemID';
            $insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
            $insertPurchaseStatement->execute(['goodReceived' => $item['goodReceived'], 'purchaseItemID' => $item['id']]);
            
            $newItemCurrentStockSql = 'SELECT stock FROM item WHERE productID = :itemNumber';
            $newItemCurrentStockStatement = $conn->prepare($newItemCurrentStockSql);
            $newItemCurrentStockStatement->execute(['itemNumber' => $item['itemNumber']]);
            
            // Calculate the new stock value for new item using the existing stock in item table
            while($newItemRow = $newItemCurrentStockStatement->fetch(PDO::FETCH_ASSOC)){
            $originalQuantityForNewItem = $newItemRow['stock'];
            $newItemNewStock = $originalQuantityForNewItem + $item['goodReceived'];

            // UPDATE the stock for new item in item table
            $newItemStockUpdateSql = 'UPDATE item SET stock = :stock WHERE productID = :itemNumber';
            $newItemStockUpdateStatement = $conn->prepare($newItemStockUpdateSql);
            $newItemStockUpdateStatement->execute(['stock' => $newItemNewStock, 'itemNumber' => $item['itemNumber']]);
            }
        }
        $poUpdateSql = 'UPDATE purchaseorder SET status = 5 WHERE purchaseID = :purchaseId';
        $poUpdateStatement = $conn->prepare($poUpdateSql);
        $poUpdateStatement->execute(['purchaseId' => $purchaseId]);
        
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Good receive added successfully.</div>';
        exit();
    } else {
    // One or more mandatory fields are empty. Therefore, display a the error message
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter valid amount</div>';
    exit();
    }
?>
