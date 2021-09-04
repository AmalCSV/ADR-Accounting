<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['purchaseID'])){
        $purchaseDetailSql = "SELECT po.*,v.companyName as fullName,
        CASE
            WHEN po.status = 1 THEN 'Created'
            WHEN po.status = 2 THEN 'Pending'
            WHEN po.status = 3 THEN 'Close'
            WHEN po.status = 4 THEN 'Cancel'
            ELSE ''
        END AS statusText
        FROM purchaseorder po inner join vendor v on po.vendorID=v.vendorID 
        where isDeleted = false and po.purchaseID =". $_POST['purchaseID'];
        $stmt = $conn->prepare($purchaseDetailSql);
        $stmt->execute();
        $purchaseDetail = $stmt->fetch(PDO::FETCH_ASSOC);

        $purchaseItemsSql = 'SELECT pi.* from purchaseitem pi WHERE purchaseOrderID='. $_POST['purchaseID'];
        $stmtItem = $conn->prepare($purchaseItemsSql);
        $stmtItem->execute();

        $purchaseItems = array();
        while($row =  $stmtItem->fetch(PDO::FETCH_ASSOC)){
            array_push($purchaseItems, $row);
        }
        
        $object = (object) [
            'purchaseOrder' => $purchaseDetail,
            'purchaseOrderItems' => (array) $purchaseItems,
          ];
        echo (json_encode($object));
    }
	
?>