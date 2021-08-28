<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['salesID'])){
        $purchaseDetailSql = "SELECT po.*,v.companyName as fullName,
        CASE
            WHEN po.status = 1 THEN 'Created'
            WHEN po.status = 2 THEN 'Pending'
            WHEN po.status = 3 THEN 'Close'
            WHEN po.status = 4 THEN 'Cancel'
            ELSE ''
        END AS statusText
        FROM salesorder po inner join customer v on po.customerID =v.customerID 
        where po.saleID =". $_POST['salesID'];
        $stmt = $conn->prepare($purchaseDetailSql);
        $stmt->execute();
        $purchaseDetail = $stmt->fetch(PDO::FETCH_ASSOC);

        // $purchaseItemsSql = 'SELECT pi.* from salesorderitem pi WHERE saleID='. $_POST['salesID'];
        // $stmtItem = $conn->prepare($purchaseItemsSql);
        // $stmtItem->execute();
        // $purchaseItems = $stmtItem->fetch(PDO::FETCH_ASSOC);
        // $stmtItem->closeCursor();

        $object = (object) [
            'salesOrder' => $purchaseDetail,
            // 'salesOrderItems' => (array) [$purchaseItems],
          ];
        echo (json_encode($object));
    }
	
?>