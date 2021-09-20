<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

    $fromDate =  htmlentities($_POST['fromDate']);
    $toDate = htmlentities($_POST['toDate']);

	$companySearchSql = "SELECT sum(amount) as totalPurchases FROM purchaseorder where createdDate >= :fromDate and createdDate <= :toDate ";
	$selectCompanyStatement = $conn->prepare($companySearchSql);
	$selectCompanyStatement->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);

    // If data is found for the given item number, return it as a json object
    $row = $selectCompanyStatement->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
    $selectCompanyStatement->closeCursor();

?>