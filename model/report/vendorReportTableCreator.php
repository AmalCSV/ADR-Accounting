<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$fromDate =  htmlentities($_GET['fromDate']);
    $toDate = htmlentities($_GET['toDate']);
	$vendorId = htmlentities($_GET['vendorId']);
	$status = htmlentities($_GET['status']);

	if($vendorId == 'null' || $vendorId == 0) {
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select a vendor.</div>';
		exit();
	}

	function getStatusSqlText($status) {
		if($status == 'ALL') {
			return 'status != 4 ';
		} else  {
			return 'status = 3 ';
		}
	}
	
	$itemDetailsSearchSql = '';

	if($vendorId == -1) {
		$itemDetailsSearchSql = 'SELECT po.vendorID, (select companyName from vendor Where vendorID=po.vendorID) name,"Purchases" as orderType, count(purchaseID) orders, 
		ROUND(sum(amount),2) amount, sum(paidAmount) paid,
		ROUND(sum(amount - paidAmount),2) tobePaid FROM purchaseorder po WHERE  CAST(createdDate as DATE) BETWEEN  :fromDate and :toDate AND ' . getStatusSqlText($status) . 'group by vendorID
		 UNION ALL SELECT po.vendorID, (select companyName from vendor Where vendorID=po.vendorID) name,"Paid" as orderType, count(pp.id) orders,
		ROUND(sum(pp.amount),2) amount, 0,0 FROM purchaseorderpayment pp LEFT JOIN purchaseorder po ON po.purchaseID = pp.purchaseOrderID WHERE pp.isDeleted =0 and CAST(pp.date as DATE) BETWEEN :fromDate
		AND :toDate group by vendorID
		 UNION All SELECT so.vendorID, (select companyName from vendor Where vendorID=so.vendorID) name,"Sales" as orderType, count(saleID) orders, 
		ROUND(sum(amount),2) amount, sum(paidAmount) paid,
		ROUND(sum(amount - paidAmount),2) tobePaid FROM salesorder so WHERE CAST(updatedDate as DATE) BETWEEN  :fromDate and :toDate AND ' . getStatusSqlText($status) . 'group by vendorID
		 UNION ALL SELECT so.vendorID, (select companyName from vendor Where vendorID=so.vendorID) name,"Payment-Received" as orderType, count(sp.id) orders, 
		ROUND(sum(sp.amount),2) amount, 0,0 FROM salesorderpayment sp LEFT JOIN salesorder so ON sp.salesOrderID = so.saleID WHERE sp.isDeleted =0 and CAST(sp.date as DATE) BETWEEN :fromDate and :toDate group by vendorID';

		$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
		$itemDetailsSearchStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
	} else {
		$itemDetailsSearchSql = 'SELECT po.vendorID, (select companyName from vendor Where vendorID=po.vendorID) name, "Purchases" as orderType, count(purchaseID) orders, 
		ROUND(sum(amount),2) amount, sum(paidAmount) paid,
		ROUND(sum(amount - paidAmount),2) tobePaid FROM purchaseorder po WHERE po.vendorID =:vendorId AND CAST(createdDate as DATE) BETWEEN  :fromDate and :toDate AND '. getStatusSqlText($status) .
		' UNION ALL SELECT po.vendorID, (select companyName from vendor Where vendorID=po.vendorID) name,"Paid" as orderType, count(pp.id) orders,
		ROUND(sum(pp.amount),2) amount, 0,0 FROM purchaseorderpayment pp LEFT JOIN purchaseorder po ON po.purchaseID = pp.purchaseOrderID WHERE po.vendorID =:vendorId AND pp.isDeleted =0 and CAST(pp.date as DATE) BETWEEN :fromDate and :toDate
		  UNION All SELECT so.vendorID, (select companyName from vendor Where vendorID=so.vendorID) name,"Sales" as orderType, count(saleID) orders, 
		ROUND(sum(amount),2) amount, sum(paidAmount) paid,
		ROUND(sum(amount - paidAmount),2) tobePaid FROM salesorder so WHERE so.vendorID =:vendorId AND CAST(updatedDate as DATE) BETWEEN  :fromDate and :toDate AND ' . getStatusSqlText($status).
		' UNION ALL SELECT so.vendorID, (select companyName from vendor Where vendorID=so.vendorID) name,"Payment-Received" as orderType, count(sp.id) orders, 
		ROUND(sum(sp.amount),2) amount, 0,0 FROM salesorderpayment sp LEFT JOIN salesorder so ON sp.salesOrderID = so.saleID WHERE so.vendorID =:vendorId AND sp.isDeleted =0 and CAST(sp.date as DATE) BETWEEN :fromDate and :toDate';
		$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
		$itemDetailsSearchStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate, 'vendorId' => $vendorId]);
	}

	//echo $itemDetailsSearchSql;
	function getDataTable($itemDetailsSearchStatement) {
		$headerRow = '<tr>
						<th class="text-right">Vendor </th>
						<th class="text-right">Type </th>
						<th style="min-width:100px !important;">Count</th>
						<th style="min-width:145px !important;">Amount</th>
						<th class="price-al">Paid</th>
						<th class="price-al">To be Paid</th>
					</tr>';

		$output = '<table id="vendorReportTable" class="table table-sm table-striped table-bordered table-hover " style="width:100%;">
				<thead>
					'.$headerRow.'	
				</thead>
				<tbody>';

		// Create table rows from the selected data
		while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
			if($row['vendorID']) {
				$output .= '<tr>' .
				'<td class="text-right">' . $row['name'] . '</td>' .
				'<td>' . $row['orderType'] . '</td>' .
				'<td>' . $row['orders'] . '</td>' .
				'<td class="price-al">' . $row['amount'] . '</td>'.
				'<td class="text-right pr-1">' . $row['paid'] . '</td>' .
				'<td class="text-right pr-1">' . $row['tobePaid'] . '</td>' .
				'</tr>';
			}
		}
		$itemDetailsSearchStatement->closeCursor();
		$output .= '</tbody>
						<tfoot>
							'.$headerRow.'
						</tfoot>
					</table>';
		return $output;
	}
	$responseData = getDataTable($itemDetailsSearchStatement);
	echo $responseData;
?>