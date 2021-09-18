<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	abstract class soStatus {
		const created = 1;
		const pending = 2;
		const close = 3;
		const cancel = 4;
		const delivered = 5;
	}

	function optionsMenu($status, $saleID) {
		if( $status == soStatus::pending && $status != soStatus::delivered ) { 
			return '<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delivered"><i class="fas fa-boxes" onclick="openDelivered(' . $saleID . ')"></i></button>';
		} else if ($status == soStatus::created){
			return '<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fas fa-edit" onclick="openEditSalesOrder(' . $saleID . ')"></i></button>';
		}
		return '';	
	}

	$saleDetailsSearchSql = "SELECT so.*,
	CASE
	WHEN so.status = 1 THEN 'Created'
	WHEN so.status = 2 THEN 'Pending'
	WHEN so.status = 3 THEN 'Close'
	WHEN so.status = 4 THEN 'Cancel'
	WHEN so.status = 5 THEN 'Delivered'
	ELSE ''
END AS statusText FROM salesorder so where isDeleted = false ORDER BY so.saleID DESC";
	$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
	$saleDetailsSearchStatement->execute();

	$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Sale ID</th>
						<th>Order Number</th>
						<th>Customer Name</th>
						<th>Sale Date</th>
						<th>Discount %</th>
						<th>Discount</th>
						<th>Net Total</th>
						<th>Received Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
			
		$output .= '<tr>' .
						'<td>' . $row['saleID'] . '</td>' .
						'<td>' . $row['salesNumber'] . '</td>' .
						'<td>' . $row['customerName'] . '</td>' .
						'<td>' . $row['saleDate'] . '</td>' .
						'<td>' . $row['discountPercentage'] . '</td>' .
						'<td>' . $row['discount'] . '</td>' .
						'<td>' . $row['amount'] . '</td>' .
						'<td>' . $row['paidAmount'] . '</td>' .
						'<td align="right">' . optionsMenu($row['status'], $row['saleID']).
						'<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View"> <i class="fa fa-eye pointer" onclick="openViewSalesOrder(' . $row['saleID'] . ')"></i></button>
						<button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Payments"> <i class="fa fa-dollar-sign pointer" onclick=showSalesPayments("'. $row['saleID'] .'")></i></button>
						</td>'.
					'</tr>';
	}
	
	$saleDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
					<tr>
						<th>Sale ID</th>
						<th>Order Number</th>
						<th>Customer Name</th>
						<th>Sale Date</th>
						<th>Discount %</th>
						<th>Discount</th>
						<th>Net Total</th>
						<th>Received Amount</th>
						<th>Action</th>
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>


