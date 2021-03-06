<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT * FROM item';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();

	$output = '<table id="itemReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
					<th>Product ID</th>
					<th>Item Number</th>
					<th>Item Name</th>
					<th>Measure</th>
					<th>Stock</th>
					<th>Warning Qty</th>
					<th>Selling Price</th>
					<th>Buying Price</th>
					<th>Status</th>
					<th>Rack No</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
		'<td>' . $row['productID'] . '</td>' .
		'<td>' . $row['itemNumber'] . '</td>' .
		'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
		'<td>' . $row['unitOfMeasure'] . '</td>' .
		'<td>' . $row['stock'] . '</td>' .
		'<td>' . $row['warningQty'] . '</td>' .
		'<td>' . $row['sellingPrice'] . '</td>' .
		'<td>' . $row['buyingPrice'] . '</td>' .
		'<td>' . $row['status'] . '</td>' .
		'<td>' . $row['rackNo'] . '</td>' .
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
					<tr>
					<th>Product ID</th>
					<th>Item Number</th>
					<th>Item Name</th>
					<th>Measure</th>
					<th>Stock</th>
					<th>Warning Qty</th>
					<th>Selling Price</th>
					<th>Buying Price</th>
					<th>Status</th>
					<th>Rack No</th>
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>