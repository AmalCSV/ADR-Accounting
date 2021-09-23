<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    $fromDate =  htmlentities($_POST['fromDate']);
    $toDate = htmlentities($_POST['toDate']);

	$purchaseOrderReportSql = "SELECT po.status, (select status from purchaseorderstatus Where id=po.status) statusText, count(purchaseID) purchseOrders, ROUND(sum(amount),2) amount, 
    sum(paidAmount) paid, ROUND(sum(amount - paidAmount),2) tobePaid FROM purchaseorder po WHERE CAST(createdDate as DATE)  BETWEEN  :fromDate and :toDate group by status";
	$purchaseOrderReportStatement = $conn->prepare($purchaseOrderReportSql);
	$purchaseOrderReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $purchseOrders = array();
    while($row =  $purchaseOrderReportStatement->fetch(PDO::FETCH_ASSOC)){
        array_push($purchseOrders, $row);
    }
    $salesOrderReportSql = "SELECT so.status, (select status from salesorderstatus Where id=so.status) statusText, count(saleID) salesOrders, ROUND(sum(amount),2) amount, sum(paidAmount) paid, ROUND(sum(amount-paidAmount),2) tobePaid FROM salesorder so
    WHERE CAST(updatedDate as DATE) BETWEEN  :fromDate and :toDate group by status";
	$salesOrderReportStatement = $conn->prepare($salesOrderReportSql);
	$salesOrderReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $salesOrders = array();
    while($row =  $salesOrderReportStatement->fetch(PDO::FETCH_ASSOC)){
        array_push($salesOrders, $row);
    }

    $poPaymentReportSql = "SELECT 'paid', sum(amount) amount FROM purchaseorderpayment WHERE isDeleted =0 and CAST(date as DATE) BETWEEN :fromDate and :toDate";
	$poPaymentReportStatement = $conn->prepare($poPaymentReportSql);
	$poPaymentReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $poPayment =  $poPaymentReportStatement->fetch(PDO::FETCH_ASSOC);

    $soPaymentReportSql = "SELECT 'received', sum(amount) amount FROM salesorderpayment WHERE isDeleted =0 and CAST(date as DATE) BETWEEN :fromDate and :toDate";
	$soPaymentReportStatement = $conn->prepare($soPaymentReportSql);
	$soPaymentReportStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
    $soPayment =  $soPaymentReportStatement->fetch(PDO::FETCH_ASSOC);

    $stockValuationReportSql = "SELECT  'stockValue', ROUND(sum(stock*sellingPrice),2) amount FROM `item` WHERE stock>0";
	$stockValuationReportStatement = $conn->prepare($stockValuationReportSql);
	$stockValuationReportStatement->execute();
    $stockValuation =  $stockValuationReportStatement->fetch(PDO::FETCH_ASSOC);
   
    $object = (object) [
        'purchaseOrders' => (array) $purchseOrders,
        'purchaseOrdersPaid' => $poPayment,
        'salesOrders' => (array) $salesOrders,
        'salesOrdersPaid' => $soPayment,
        'stockValuation' => $stockValuation,
      ];

    echo json_encode($object);
    $purchaseOrderReportStatement->closeCursor();
    $salesOrderReportStatement->closeCursor();
    $soPaymentReportStatement->closeCursor();
    $poPaymentReportStatement->closeCursor();
    $stockValuationReportStatement->closeCursor();
?>