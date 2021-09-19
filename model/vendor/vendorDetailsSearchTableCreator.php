<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$vendorDetailsSearchSql = 'SELECT * FROM vendor';
	$vendorDetailsSearchStatement = $conn->prepare($vendorDetailsSearchSql);
	$vendorDetailsSearchStatement->execute();

	$output = '<table id="vendorDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th class="d-none">Vendor ID</th>
						<th>Company Name</th>
						<th>Contact Person</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Phone 2</th>
						<th>Address</th>
						<th>Address 2</th>
						<th>City</th>
						<th>District</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $vendorDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td class="d-none">' . $row['vendorID'] . '</td>' .
						'<td>' . $row['companyName'] . '</td>' .
						'<td>' . $row['contactPerson'] . '</td>' .
						'<td>' . $row['email'] . '</td>' .
						'<td>' . $row['mobile'] . '</td>' .
						'<td>' . $row['phone2'] . '</td>' .
						'<td>' . $row['address'] . '</td>' .
						'<td>' . $row['address2'] . '</td>' .
						'<td>' . $row['city'] . '</td>' .
						'<td>' . $row['district'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td>' . '<button onclick=showEditVendor("'. $row['vendorID'] .'") type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit  fa-sm"></i></button>'. '</td>' .
					'</tr>';
	}
	
	$vendorDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
							<th class="d-none">Vendor ID</th>
							<th>Company Name</th>
							<th>Contact Person</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Phone 2</th>
							<th>Address</th>
							<th>Address 2</th>
							<th>City</th>
							<th>District</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>