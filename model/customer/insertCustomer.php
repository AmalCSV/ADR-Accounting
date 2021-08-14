<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['customerDetailsCustomerFullName'])){
		
		$fullName = htmlentities($_POST['customerDetailsCustomerFullName']);
		$companyName = htmlentities($_POST['customerDetailsCustomerCompanyName']);
		$email = htmlentities($_POST['customerDetailsCustomerEmail']);
		$mobile = htmlentities($_POST['customerDetailsCustomerMobile']);
		$phone2 = htmlentities($_POST['customerDetailsCustomerPhone2']);
		$address = htmlentities($_POST['customerDetailsCustomerAddress']);
		$address2 = htmlentities($_POST['customerDetailsCustomerAddress2']);
		$city = htmlentities($_POST['customerDetailsCustomerCity']);
		$district = htmlentities($_POST['customerDetailsCustomerDistrict']);
		$status = htmlentities($_POST['customerDetailsStatus']);
		
		if(isset($fullName) && isset($mobile) && isset($address)) {
			// Validate mobile number
			if( preg_match('/^\d{10}$/', $mobile) && strlen($mobile) == 10) {
				// Valid mobile number
			} else {
				// Mobile is wrong
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
				exit();
			}
			
			// Validate second phone number only if it's provided by user
			if(!empty($phone2)){
				if(!(preg_match('/^\d{10}$/', $phone2) && strlen($phone2) == 10)) {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number 2</div>';
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($email)) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}
			
			// Validate address
			if($address == ''){
				// Address 1 is empty
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Address 1</div>';
				exit();
			}
			
			// Check if Company name is empty or not
			if($companyName == ''){
				// Full Name is empty
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Company Name.</div>';
				exit();
			}
			
			// Start the insert process
			$sql = 'INSERT INTO customer(companyName, contactPerson, email, mobile, phone2, address, address2, city, district, status) VALUES(:companyName, :contactPerson, :email, :mobile, :phone2, :address, :address2, :city, :district, :status)';
			$stmt = $conn->prepare($sql);
			$stmt->execute(['companyName' => $companyName, 'contactPerson' => $fullName, 'email' => $email, 'mobile' => $mobile, 'phone2' => $phone2, 'address' => $address, 'address2' => $address2, 'city' => $city, 'district' => $district, 'status' => $status]);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer added to database</div>';
		} else {
			// One or more fields are empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>