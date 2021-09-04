<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	abstract class poStatus {
		const created = 1;
		const pending = 2;
		const close = 3;
		const cancel = 4;
	}

	function optionsMenu($status, $purchaseID) {
		if( $status == poStatus::pending) { 
			return '<i class="far fa-clipboard"  onclick="openGoodReceive(' . $purchaseID . ')"></i>';
		} else if ($status == poStatus::created){
			return '<i class="fas fa-edit" onclick="openEditPurchaseOrder(' . $purchaseID . ')"></i>';
		}
		return '';	
	}

	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$purchaseDetailsSearchSql = " SELECT po.*,
			CASE
            WHEN po.status = 1 THEN 'Created'
            WHEN po.status = 2 THEN 'Pending'
            WHEN po.status = 3 THEN 'Close'
            WHEN po.status = 4 THEN 'Cancel'
            ELSE ''
        END AS statusText,
	v.companyName as fullName FROM purchaseorder po inner join vendor v on po.vendorID=v.vendorID where isDeleted = false";

	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	$purchaseDetailsSearchStatement->execute();

	$output = '<table id="purchaseDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Purchase Order</th>
						<th>Purchase Date</th>
						<th>Vendor Name</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
						<th>Status</th>
						<th> Action </th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){	
		$output .= '<tr>' .
						'<td>' . $row['orderNumber'] . '</td>' .
						'<td>' . $row['orderDate'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td>' . $row['amount'] . '</td>' .
						'<td>' . $row['paidAmount'] . '</td>' .
						'<td>' . $row['statusText'] . '</td>' .
						' <td align="right">'. optionsMenu($row['status'], $row['purchaseID']) . '
							<i class="far fa-file" onclick="openViewPurchaseOrder(' . $row['purchaseID'] . ')"></i>
							<i class="fas fa-cash-register" onclick=showPayments("'. $row['purchaseID'] .'")></i> 
                    	</td>'.
					'</tr>';
	}
	
	$purchaseDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th>Purchase Order</th>
						<th>Purchase Date</th>
						<th>Vendor Name</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
						<th>Status</th>
						<th> Action </th>
						</tr>
					</tfoot>
				</table>';
	echo $output;

?>


