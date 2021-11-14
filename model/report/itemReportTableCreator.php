<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	$fromDate =  htmlentities($_GET['fromDate']);
    $toDate = htmlentities($_GET['toDate']);
	$vendorId = htmlentities($_GET['vendorId']);
	$status = htmlentities($_GET['status']);
	$itemId = htmlentities($_GET['itemId']);

	function getItemSqlText($item, $prefix) {
		if($item == -1) {
			return ' ';
		} else {
			return  'AND '.$prefix.'.productID='.$item;
		}
	}

	function getStatusSqlText($status) {
		if($status == 'ALL') {
			return 'status != 4 ';
		} else  {
			return 'status = 3 ';
		}
	}

	function getArrayData($items, $id, $keyField, $returnField) {
		$key = array_search($id, array_column($items, $keyField));
		if($key == '') {
			return 0;
		} else {
			return $items[$key][$returnField];
		}
	}

	$itemDetailsSearchSql = 'SELECT i.*, v.vendorID, v.companyName ,i.sellingPrice-i.buyingPrice as itemProfit FROM item i left join vendor v on i.vendorID = v.vendorID  where i.status ="Active" ' . getItemSqlText($itemId, 'i') ;
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();


	$purchaseItemSearchSql = 'SELECT pi.productID, sum(pi.quantity) as quantity, sum(pi.totalPrice) totalPrice FROM purchaseitem pi WHERE pi.purchaseOrderID IN 
	(SELECT i.purchaseID FROM purchaseorder i WHERE  CAST(createdDate as DATE) BETWEEN  :fromDate and :toDate  AND ' . getStatusSqlText($status) . ') '. getItemSqlText($itemId, 'pi').' group by productID';

	$purchaseItemSearchStatement = $conn->prepare($purchaseItemSearchSql);
	$purchaseItemSearchStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);

	$purchaseItems = array();
	while($row =  $purchaseItemSearchStatement->fetch(PDO::FETCH_ASSOC)){
		array_push($purchaseItems, $row);
	}
	$purchaseItemSearchStatement->closeCursor();

	$salesItemSearchSql = 'SELECT si.productID, sum(si.quantity) as quantity, sum(si.totalPrice) totalPrice FROM salesorderitem si WHERE si.salesOrderId IN 
	(SELECT i.saleID FROM salesorder i WHERE  CAST(updatedDate as DATE) BETWEEN  :fromDate and :toDate AND ' . getStatusSqlText($status) . ') '. getItemSqlText($itemId, 'si').' group by productID';

	$salesItemSearchStatement = $conn->prepare($salesItemSearchSql);
	$salesItemSearchStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);

	$salesItems = array();
	while($row =  $salesItemSearchStatement->fetch(PDO::FETCH_ASSOC)){
		array_push($salesItems, $row);
	}
	$salesItemSearchStatement->closeCursor();

	$purchaseItemPendingSql = 'SELECT pi.productID, sum(pi.quantity) as quantity, sum(pi.totalPrice) totalPrice FROM purchaseitem pi WHERE pi.purchaseOrderID IN 
	(SELECT i.purchaseID FROM purchaseorder i WHERE  CAST(createdDate as DATE) BETWEEN  :fromDate and :toDate  AND i.status =2) '. getItemSqlText($itemId, 'pi').' group by productID';

	$purchaseItemPendingStatement = $conn->prepare($purchaseItemPendingSql);
	$purchaseItemPendingStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);

	$purchasePendingItems = array();
	while($row =  $purchaseItemPendingStatement->fetch(PDO::FETCH_ASSOC)){
		array_push($purchasePendingItems, $row);
	}
	$purchaseItemPendingStatement->closeCursor();

	//echo $purchaseItemSearchSql;
	function getStyle($isBold)
	{
		if($isBold){
			return 'style="font-weight:bold"';
		}
		else {
			return '';
		}
	}
	function getReportRow($row ,$isBold = false) {
		return '<tr '. getStyle($isBold) .'>' .
		'<td class="d-none">' . $row['productID'] . '</td>' .
		'<td>' . $row['itemNumber'] . '</td>' .
		'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
		'<td class="price-al">' . $row['purchaseQuantity'] . '</td>' .
		'<td class="text-right pr-1">' . $row['purchaseCost'] . '</td>'.
		'<td class="text-right pr-1">' . $row['salesQuantity'] . '</td>'.
		'<td class="text-right pr-1">' . $row['salesCost'] . '</td>' .
		'<td class="text-right pr-1">' . $row['calculatedProfit']. '</td>' .
		'<td class="price-al">' . $row['stock'] . '</td>' .
		'<td class="price-al">' . $row['stockValue'] . '</td>' .
		'<td class="price-al">' . $row['purchasePendingQuantity'] . '</td>' .
		'</tr>';
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
	$totalRow = array();
	$i = 0;
	$totalRow[$i]['productID'] = '#';
	$totalRow[$i]['itemNumber'] = 'Total';
	$totalRow[$i]['itemName'] = '';
	$totalRow[$i]['purchaseQuantity'] = 0;
	$totalRow[$i]['purchaseCost']  =0;
	$totalRow[$i]['salesQuantity']  =0;
	$totalRow[$i]['salesCost'] =0;
	$totalRow[$i]['purchasePendingQuantity'] =0;
	$totalRow[$i]['calculatedProfit'] =0;
	$totalRow[$i]['stockValue']  =0;
	$totalRow[$i]['stock'] =0;
	while ($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
		$row['purchaseQuantity'] = getArrayData($purchaseItems, $row['productID'], 'productID', 'quantity');
		$row['purchaseCost'] = getArrayData($purchaseItems, $row['productID'], 'productID', 'totalPrice');
		$row['salesQuantity'] = getArrayData($salesItems, $row['productID'], 'productID', 'quantity');
		$row['salesCost'] = getArrayData($salesItems, $row['productID'], 'productID', 'totalPrice');
		$row['purchasePendingQuantity'] = getArrayData($purchasePendingItems, $row['productID'], 'productID', 'quantity');
		$row['calculatedProfit'] = $row['itemProfit'] * $row['salesQuantity'];
		$row['stockValue'] = $row['stock'] * $row['buyingPrice'];
		$output .= getReportRow($row);

		$totalRow[$i]['purchaseQuantity'] += $row['purchaseQuantity'];
		$totalRow[$i]['purchaseCost'] += $row['purchaseCost'];
		$totalRow[$i]['salesQuantity'] += $row['salesQuantity'];
		$totalRow[$i]['salesCost'] += $row['salesCost'];
		$totalRow[$i]['purchasePendingQuantity'] += $row['purchasePendingQuantity'];
		$totalRow[$i]['calculatedProfit'] += $row['calculatedProfit'];
		$totalRow[$i]['stockValue'] += $row['stockValue'];
	}

	$output .= getReportRow($totalRow[$i], true);

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