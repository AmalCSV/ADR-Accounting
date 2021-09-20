<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	if(isset($_POST['saleID'])){
        $salesDetailSql = "SELECT so.*,v.companyName as fullName,
        CASE
            WHEN so.status = 1 THEN 'Created'
            WHEN so.status = 2 THEN 'Pending'
            WHEN so.status = 3 THEN 'Close'
            WHEN so.status = 4 THEN 'Cancel'
            WHEN so.status = 5 THEN 'Delivered'
            ELSE ''
        END AS statusText
        FROM salesorder so inner join customer v on so.customerID =v.customerID 
        where so.saleID =". $_POST['saleID'];
        $stmt = $conn->prepare($salesDetailSql);
        $stmt->execute();
        $salesDetail = $stmt->fetch(PDO::FETCH_ASSOC);

        $salesItemsSql = 'SELECT si.* from salesorderitem si WHERE salesOrderId='. $_POST['saleID'];
        $stmtItem = $conn->prepare($salesItemsSql);
        $stmtItem->execute();

        $salesItems = array();
        while($row =  $stmtItem->fetch(PDO::FETCH_ASSOC)){
            array_push($salesItems, $row);
        }
        
        $object = (object) [
            'salesOrder' => $salesDetail,
            'salesOrderItems' => (array) $salesItems,
          ];
        echo (json_encode($object));
        exit;
    }
	
?>