<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$fromDate =  htmlentities($_GET['fromDate']);
	$toDate =  htmlentities($_GET['toDate']);

	abstract class soStatus {
		const created = 1;
		const pending = 2;
		const close = 3;
		const cancel = 4;
		const delivered = 5;
	}

	function optionsMenu($status, $saleID) {
		if( $status == soStatus::pending && $status != soStatus::delivered ) { 
			return '<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Deliver" onclick="openDeliveredOrder(' . $saleID . ')"><i class="fas fa-boxes"></i></button>';
		} else if ($status == soStatus::created){
			return '<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" onclick="openEditSalesOrder(' . $saleID . ')"> <i class="fas fa-edit"></i></button>';
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
END AS statusText FROM salesorder so where isDeleted = false and saleDate >= :fromDate and saleDate <= :toDate ORDER BY so.saleID DESC";
	$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
	$saleDetailsSearchStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate ]);

	$headerRow = '<tr>
					<th>SO No</th>
					<th>Customer Name</th>
					<th>Sale Date</th>
					<th>Discount %</th>
					<th>Discount</th>
					<th>Net Total</th>
					<th>Received Amount</th>
					<th>Status</th>
					<th style="width: 90px;"> Action </th>
				</tr>';

	$output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>'
					.$headerRow.
				'</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
			
		$output .= '<tr>' .
						'<td>' . $row['salesNumber'] . '</td>' .
						'<td>' . $row['customerName'] . '</td>' .
						'<td>' . $row['saleDate'] . '</td>' .
						'<td class="text-right">' . $row['discountPercentage'] . '</td>' .
						'<td class="text-right">' . $row['discount'] . '</td>' .
						'<td class="text-right">' . $row['amount'] . '</td>' .
						'<td class="text-right">' . $row['paidAmount'] . '</td>' .
						'<td>' . $row['statusText'] . '</td>' .
						'<td align="right">' . optionsMenu($row['status'], $row['saleID']).
						'<button type="button" class="btn btn-success btn-sm" style="margin-left:3px" data-toggle="tooltip" data-placement="top" title="View" onclick="openViewSalesOrder(' . $row['saleID'] . ')"> <i class="fa fa-eye pointer"></i></button>
						<button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Payments" onclick=showSalesPayments("'. $row['saleID'] .'")> <i class="fa fa-dollar-sign pointer"></i></button>
						</td>'.
					'</tr>';
	}
	
	$saleDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>'
					.$headerRow.
					'</tfoot>
				</table>';
	echo $output;
?>


