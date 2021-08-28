<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$saleDetailsSearchSql = 'SELECT * FROM salesOrder';
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
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>


