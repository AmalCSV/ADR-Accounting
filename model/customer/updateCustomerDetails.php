<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	// Check if the POST query is received
	if(isset($_POST['customerDetailsCustomerID'])) {
		
		$customerDetailsCustomerID = htmlentities($_POST['customerDetailsCustomerID']);
		$customerDetailsCustomerFullName = htmlentities($_POST['customerDetailsCustomerFullName']);
		$customerDetailsCustomerCompanyName = htmlentities($_POST['customerDetailsCustomerCompanyName']);
		$customerDetailsCustomerMobile = htmlentities($_POST['customerDetailsCustomerMobile']);
		$customerDetailsCustomerPhone2 = htmlentities($_POST['customerDetailsCustomerPhone2']);
		$customerDetailsCustomerEmail = htmlentities($_POST['customerDetailsCustomerEmail']);
		$customerDetailsCustomerAddress = htmlentities($_POST['customerDetailsCustomerAddress']);
		$customerDetailsCustomerAddress2 = htmlentities($_POST['customerDetailsCustomerAddress2']);
		$customerDetailsCustomerCity = htmlentities($_POST['customerDetailsCustomerCity']);
		$customerDetailsCustomerDistrict = htmlentities($_POST['customerDetailsCustomerDistrict']);
		$customerDetailsStatus = htmlentities($_POST['customerDetailsStatus']);
		
		// Check if mandatory fields are not empty
		if(isset($customerDetailsCustomerCompanyName) && isset($customerDetailsCustomerMobile) && isset($customerDetailsCustomerAddress)) {
			
			// Validate mobile number
			if( preg_match('/^\d{10}$/', $customerDetailsCustomerMobile) && strlen($customerDetailsCustomerMobile) == 10) {
				// Valid mobile number
			} else {
				// Mobile is wrong
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
				exit();
			}
			
			// Validate second phone number only if it's provided by user
			if(!empty($customerDetailsCustomerPhone2)){
				if(!(preg_match('/^\d{10}$/', $customerDetailsCustomerPhone2) && strlen($customerDetailsCustomerPhone2) == 10)) {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number 2</div>';
					exit();
				}
			}
			
			// Check if CustomerID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
			if(empty($customerDetailsCustomerID)){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the CustomerID to update that customer.</div>';
				exit();
			}
			
			// Validate email only if it's provided by user
			if(!empty($customerDetailsCustomerEmail)) {
				if (filter_var($customerDetailsCustomerEmail, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}

			// Check if the given CustomerID is in the DB
			$customerIDSelectSql = 'SELECT customerID FROM customer WHERE customerID = :customerDetailsCustomerID';
			$customerIDSelectStatement = $conn->prepare($customerIDSelectSql);
			$customerIDSelectStatement->execute(['customerDetailsCustomerID' => $customerDetailsCustomerID]);
			
			if($customerIDSelectStatement->rowCount() > 0) {
				
				// CustomerID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updateCustomerDetailsSql = 'UPDATE customer SET companyName = :companyName, contactPerson = :contactPerson, email = :email, mobile = :mobile, phone2 = :phone2, address = :address, address2 = :address2, city = :city, district = :district, status = :status WHERE customerID = :customerID';
				$updateCustomerDetailsStatement = $conn->prepare($updateCustomerDetailsSql);
				$updateCustomerDetailsStatement->execute(['companyName' => $customerDetailsCustomerCompanyName,'contactPerson' => $customerDetailsCustomerFullName, 'email' => $customerDetailsCustomerEmail, 'mobile' => $customerDetailsCustomerMobile, 'phone2' => $customerDetailsCustomerPhone2, 'address' => $customerDetailsCustomerAddress, 'address2' => $customerDetailsCustomerAddress2, 'city' => $customerDetailsCustomerCity, 'district' => $customerDetailsCustomerDistrict, 'status' => $customerDetailsStatus, 'customerID' => $customerDetailsCustomerID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer details updated.</div>';
				exit();
			} else {
				// CustomerID is not in DB. Therefore, stop the update and quit
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>CustomerID does not exist in DB. Therefore, update not possible.</div>';
				exit();
			}
			
		} else {
			// One or more mandatory fields are empty. Therefore, display the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>