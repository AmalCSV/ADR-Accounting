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
			return '<a class="dropdown-item" onclick="openGoodReceive(' . $purchaseID . ')">Good Receive</a> ';
		} else if ($status == poStatus::created){
			return '<a class="dropdown-item" onclick="openEditPurchaseOrder(' . $purchaseID . ')">Edit</a>';
		}
		return '';	
	}

	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	$purchaseDetailsSearchSql = ' SELECT po.*,v.companyName as fullName FROM purchaseOrder po inner join vendor v on po.vendorID=v.vendorID where isDeleted = false';

	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	$purchaseDetailsSearchStatement->execute();

	$output = '<table id="purchaseDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Purchase Order</th>
						<th>Purchase Date</th>
						<th>Vendor Name</th>
						<th>Vendor ID</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
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
						'<td>' . $row['vendorID'] . '</td>' .
						'<td>' . $row['amount'] . '</td>' .
						'<td>' . $row['paidAmount'] . '</td>' .
						' <td align="center">
							<div class="dropdown">
								<a class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
								</a>    
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" onclick="openViewPurchaseOrder(' . $row['purchaseID'] . ')">View</a>
								'. optionsMenu($row['status'], $row['purchaseID']) . '
								</div>
							</div> ' . '<button onclick=showPayments("'. $row['purchaseID'] .'") type="button" class="btn btn-primary btn-sm">Payments</button>' . '
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
						<th>Vendor ID</th>
						<th>Total Price</th>
						<th>Paid Amount</th>
						<th> Action </th>
						</tr>
					</tfoot>
				</table>';
	echo $output;

?>


