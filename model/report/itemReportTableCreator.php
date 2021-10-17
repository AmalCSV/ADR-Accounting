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
					<th style="min-width:100px !important;">Item No</th>
					<th style="min-width:145px !important;">Item Name</th>
					<th class="price-al">Purchases</th>
					<th class="price-al">Purchases Cost</th>
					<th class="price-al">Sales</th>
					<th class="price-al">Sales Income</th> 
					<th class="price-al">Profit</th> 
					<th class="price-al">In stock</th>
					<th class="price-al">Stock value</th>
					<th class="price-al">Yet to receive</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		
		$output .= '<tr>' .
					'<td class="d-none">' . $row['productID'] . '</td>' .
					'<td>' . $row['itemNumber'] . '</td>' .
					'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
					'<td class="price-al">' . $row['warningQty'] . '</td>' .
					showStock( $row['stock'], $row['warningQty']) .
					'<td class="text-right pr-1">' . $row['warningQty'] . '</td>' .
					'<td class="text-right pr-1">' . $row['sellingPrice'] . '</td>' .
					'<td class="text-right pr-1">' . $row['buyingPrice'] . '</td>' .
					'<td class="price-al">' . $row['warningQty'] . '</td>' .
					'<td class="price-al">' . $row['sellingPrice'] . '</td>' .
					'<td class="price-al">' . $row['warningQty'] . '</td>' .
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
					<tr>
					<th class="d-none">Product ID</th>
					<th style="min-width:100px !important;">Item No</th>
					<th style="min-width:145px !important;">Item Name</th>
					<th class="price-al">Purchases</th>
					<th class="price-al">Cost</th>
					<th class="price-al">Sales</th>
					<th class="price-al">Sales Income</th> 
					<th class="price-al">Profit</th> 
					<th class="price-al">In stock</th>
					<th class="price-al">Stock value</th>
					<th class="price-al">Yet to receive</th>
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>