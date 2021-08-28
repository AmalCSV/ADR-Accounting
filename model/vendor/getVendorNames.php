<?php
	$vendorNamesSql = 'SELECT * FROM vendor';
	$vendorNamesStatement = $conn->prepare($vendorNamesSql);
	$vendorNamesStatement->execute();
	
	if($vendorNamesStatement->rowCount() > 0) {
		while($row = $vendorNamesStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="' .$row['companyName'] . '">' . $row['companyName'] . '</option>';
		}
	}
	$vendorNamesStatement->closeCursor();
?>