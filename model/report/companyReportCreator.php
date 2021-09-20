<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    $fromDate =  htmlentities($_POST['fromDate']);
    $toDate = htmlentities($_POST['toDate']);

	$purchaseOrderReportSql = "SELECT po.status, (select status from purchaseorderstatus Where id=po.status) statusText, count(purchaseID) purchseOrders, sum(amount) amount, 
    sum(paidAmount) paid, sum(amount - paidAmount) tobePaid FROM purchaseorder po WHERE createdDate BETWEEN  :fromDate and :toDate group by status";
	$purchaseOrderReportStatement = $conn->prepare($purchaseOrderReportSql);
	$purchaseOrderReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $purchseOrders = array();
    while($row =  $purchaseOrderReportStatement->fetch(PDO::FETCH_ASSOC)){
        array_push($purchseOrders, $row);
    }
    $salesOrderReportSql = "SELECT so.status, (select status from salesorderstatus Where id=so.status) statusText, count(saleID) salesOrders, sum(amount) amount, sum(paidAmount) paid, sum(amount-paidAmount) tobePaid FROM salesorder so
    WHERE updatedDate BETWEEN  :fromDate and :toDate group by status";
	$salesOrderReportStatement = $conn->prepare($salesOrderReportSql);
	$salesOrderReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $salesOrders = array();
    while($row =  $salesOrderReportStatement->fetch(PDO::FETCH_ASSOC)){
        array_push($salesOrders, $row);
    }

    $object = (object) [
        'purchseOrders' => (array) $purchseOrders,
        'salesOrders' => (array) $salesOrders,
      ];

    echo json_encode($object);
    $purchaseOrderReportStatement->closeCursor();
    $salesOrderReportStatement->closeCursor();

?>