<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['purchaseID'])){
        $purchaseDetailSql = 'SELECT po.*,v.fullName FROM purchaseOrder po inner join vendor v on po.vendorID=v.vendorID 
        where isDeleted = false and po.purchaseID ='. $_POST['purchaseID'];
        $stmt = $conn->prepare($purchaseDetailSql);
        $stmt->execute();
        $purchaseDetail = $stmt->fetch(PDO::FETCH_ASSOC);

        $purchaseItemsSql = 'SELECT pi.* from purchaseItem pi WHERE purchaseOrderID='. $_POST['purchaseID'];
        $stmtItem = $conn->prepare($purchaseItemsSql);
        $stmtItem->execute();
        $purchaseItems = $stmtItem->fetch(PDO::FETCH_ASSOC);
        $stmtItem->closeCursor();

        $object = (object) [
            'purchaseOrder' => $purchaseDetail,
            'purchaseOrderItems' => (array) [$purchaseItems],
          ];
        echo (json_encode($object));
    }
	
?>