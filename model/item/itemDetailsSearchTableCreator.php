<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT i.*, v.vendorID, v.companyName FROM item i left join vendor v on i.vendorID = v.vendorID where i.status ="Active"';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();
	
	function showStock($stock, $warningQty) {
		if($stock <= $warningQty){
			return '<td class="text-right pr-1 warning-clr">' . $stock . '</td>';
		}
		else{
			return '<td class="text-right pr-1">' . $stock . '</td>';
		}
	}

	$output = '<table id="itemDetailsTable" class="table table-sm table-striped table-bordered table-hover " style="width:100%;">
				<thead>
					<tr>
					<th class="d-none">Product ID</th>
					<th style="min-width:50px !important;">Item No</th>
					<th style="min-width:150px !important;">Item Name</th>
					<th style="width:100px !important;">Supplier</th>
					<th>Stock</th>
					<th>W Qty</th>
					<th>Selling Price</th>
					<th>Buying Price</th>
					<th>Rack</th>
					<th>Status</th>
					<th></th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		
		$output .= '<tr>' .
					'<td class="d-none">' . $row['productID'] . '</td>' .
					'<td>' . $row['itemNumber'] . '</td>' .
					'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
					'<td>' . $row['companyName'] . '</td>' .
					showStock( $row['stock'], $row['warningQty']) .
					'<td class="text-right pr-1">' . $row['warningQty'] . '</td>' .
					'<td class="text-right pr-1">' . $row['sellingPrice'] . '</td>' .
					'<td class="text-right pr-1">' . $row['buyingPrice'] . '</td>' .
					'<td>' . $row['rackNo'] . '</td>' .
					'<td>' . $row['status'] . '</td>' .
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
						<th>Supplier</th>
						<th>Stock</th>
						<th>W Qty</th>
						<th>Selling Price</th>
						<th>Buying Price</th>
						<th>Rack</th>
						<th>Status</th>
						<th></th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>