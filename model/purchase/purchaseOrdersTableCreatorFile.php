<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$pageNo = 0;
	$perPage = 10;

	if (isset($_GET['pageNo'])) {
		$pageNo = $_GET['pageNo'];
	}

	if (isset($_GET['perPage'])) {
		$perPage = $_GET['perPage'];
	}

	abstract class poStatus {
		const created = 1;
		const pending = 2;
		const close = 3;
		const cancel = 4;
		const goodsReceived = 5;
	}

	function optionsMenu($status, $purchaseID) {
		if( $status == poStatus::pending && $status != poStatus::goodsReceived ) { 
			return '<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Good Receive"><i class="fas fa-boxes" onclick="openGoodReceive(' . $purchaseID . ')"></i></button>';
		} else if ($status == poStatus::created){
			return '<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit" onclick="openEditPurchaseOrder(' . $purchaseID . ')"></i></button>';
		}
		return '';	
	}

	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$offset = ($pageNo-1) * $perPage; 
	$result_db = $conn->prepare("SELECT COUNT(*) FROM purchaseorder");
	$result_db->execute();
	$total = $result_db->fetch(PDO::FETCH_ASSOC); 
	$total_records = array_values($total)[0];
	$total_pages = ceil($total_records / $perPage); 


	$purchaseDetailsSearchSql = " SELECT po.*,
			CASE
            WHEN po.status = 1 THEN 'Created'
            WHEN po.status = 2 THEN 'Pending'
            WHEN po.status = 3 THEN 'Close'
            WHEN po.status = 4 THEN 'Cancel'
			WHEN po.status = 5 THEN 'Goods Received'
            ELSE ''
        END AS statusText,
	v.companyName as fullName FROM purchaseorder po inner join vendor v on po.vendorID=v.vendorID where isDeleted = false ORDER BY po.purchaseID DESC LIMIT :offset";

	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	// $purchaseDetailsSearchStatement->execute(['offset' => 1,'perPage' => 10 ]);
	$purchaseDetailsSearchStatement->execute(['offset' => 1 ]);
	// $purchaseDetailsSearchStatement->execute();
	$output = '<table id="purchaseDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>PO No</th>
						<th>Order Date</th>
						<th>Vendor Name</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
						<th>Status</th>
						<th style="width: 90px;"> Action </th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){	
		$output .= '<tr>' .
						'<td>' . $row['orderNumber'] . '</td>' .
						'<td>' . $row['orderDate'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td class="price-al">' . $row['amount'] . '</td>' .
						'<td class="price-al">' . $row['paidAmount'] . '</td>' .
						'<td>' . $row['statusText'] . '</td>' .
						' <td align="right">'. optionsMenu($row['status'], $row['purchaseID']) . '
							<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View"  onclick="openViewPurchaseOrder(' . $row['purchaseID'] . ')"> <i class="fa fa-eye pointer"></i></button>
							<button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Payments" onclick=showPayments("'. $row['purchaseID'] .'")> <i class="fa fa-dollar-sign pointer"></i></button>
            </td>'.
					'</tr>';
	}
	
	$purchaseDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th>PO No</th>
						<th>Order Date</th>
						<th>Vendor Name</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
						<th>Status</th>
						<th>Action </th>
						</tr>
					</tfoot>
				</table>';
	echo $output;

?>


