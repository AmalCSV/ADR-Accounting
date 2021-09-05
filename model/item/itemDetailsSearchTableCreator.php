<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT i.*, v.vendorID, v.companyName FROM item i left join vendor v on i.vendorID = v.vendorID where i.status ="Active"';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();
	
	$output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
					<th class="d-none">Product ID</th>
					<th>Item Number</th>
					<th>Item Name</th>
					<th>Measure</th>
					<th>Stock</th>
					<th>Warning Qty</th>
					<th>Supplier</th>
					<th>Selling Price</th>
					<th>Buying Price</th>
					<th>Status</th>
					<th>Rack No</th>
					<th>Actions</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		
		$output .= '<tr>' .
					'<td class="d-none">' . $row['productID'] . '</td>' .
					'<td>' . $row['itemNumber'] . '</td>' .
					'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
					'<td>' . $row['unitOfMeasure'] . '</td>' .
					'<td>' . $row['stock'] . '</td>' .
					'<td>' . $row['warningQty'] . '</td>' .
					'<td>' . $row['companyName'] . '</td>' .
					'<td>' . $row['sellingPrice'] . '</td>' .
					'<td>' . $row['buyingPrice'] . '</td>' .
					'<td>' . $row['status'] . '</td>' .
					'<td>' . $row['rackNo'] . '</td>' .
					'<td>' . '<button onclick=showEditItem("'. $row['productID'] .'") type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit  fa-sm"></i></button>'. '</td>' .
								'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th class="d-none">Product ID</th>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Measure</th>
						<th>Stock</th>
						<th>Warning Qty</th>
						<th>Supplier</th>
						<th>Selling Price</th>
						<th>Buying Price</th>
						<th>Status</th>
						<th>Rack No</th>
						<th>Actions</th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>