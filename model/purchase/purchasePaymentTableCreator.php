<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	$orderId =  htmlentities($_POST['orderId']);
	
	$purchaseDetailsSearchSql = 'SELECT pp.*, po.orderNumber, v.companyName FROM purchaseorderpayment pp inner join purchaseorder po on pp.purchaseOrderID = po.purchaseID inner join vendor v on po.vendorID=v.vendorID where po.purchaseID = :orderId and pp.isDeleted = false'  ;
	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	$purchaseDetailsSearchStatement->execute(['orderId' => $orderId]);
	$numberOfRows = $purchaseDetailsSearchStatement->rowCount(); 
	
	$output = '<table id="purchasePaymentsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
					<th>Id</th>
						<th>Order No</th>
						<th>Amount</th>
						<th>Payment Date</th>
						<th>Payment Type</th>
						<th>Cheque No</th>
						<th>Cheque Date </th>
						<th>Status</th>
						<th>Note </th>
						<th></th>
					</tr>
				</thead>
				<tbody>';
	
	if($numberOfRows > 0){
		// Create table rows from the selected data
		while($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){	
			$output .= '<tr>' .
							'<td>' . $row['id'] . '</td>' .
							'<td>' . $row['orderNumber'] . '</td>' .
							'<td class="text-right">' . $row['amount'] . '</td>' .
							'<td class="text-right">' . $row['date'] . '</td>' .
							'<td>' . $row['type'] . '</td>' .
							'<td>' . $row['chequeNo'] . '</td>' .
							'<td class="text-right">' . $row['realisationDate'] . '</td>' .
							'<td class="text-right">' . $row['chequeStatus'] . '</td>' .
							'<td>' . $row['note'] . '</td>' .
							'<td>' . (($row['chequeNo'] != "" && $row['chequeStatus'] == "Received") ?'<button onclick=updateChequeStatusPopup("'. $row['id'] .'","'.  $row['amount'] .'") type="button" class="btn btn-primary btn-sm">Deposit</button>' : '') . '  ' . 
							'<button onclick=deletePaymentPopup("'. $row['id'] .'") type="button" class="btn btn-danger btn-sm">Delete</button>' . '</td>' .
						'</tr>';
		}
	}
	else{
		$output .= '<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty text-center">No data available in table</td></tr>';
	}
	
	$purchaseDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th>Id</th>
						<th>Order No</th>
						<th>Amount</th>
						<th>Payment Date</th>
						<th>Payment Type</th>
						<th>Cheque No</th>
						<th>Cheque Date </th>
						<th>Status</th>
						<th>Note </th>
						<th></th>
						</tr>
					</tfoot>
				</table>';
	echo $output;

?>


