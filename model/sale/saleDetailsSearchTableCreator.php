<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$saleDetailsSearchSql = 'SELECT * FROM salesorder';
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
						'<td>' . '<button onclick=showSalesPayments("'. $row['saleID'] .'") type="button" class="btn btn-primary btn-sm">Payments</button>' . '</td>' .
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


