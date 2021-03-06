<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['vendorDetailsStatus'])){
		
		$fullName = htmlentities($_POST['vendorDetailsVendorFullName']);
		$companyName = htmlentities($_POST['vendorCompanyName']);
		$email = htmlentities($_POST['vendorDetailsVendorEmail']);
		$mobile = htmlentities($_POST['vendorDetailsVendorMobile']);
		$phone2 = htmlentities($_POST['vendorDetailsVendorPhone2']);
		$address = htmlentities($_POST['vendorDetailsVendorAddress']);
		$address2 = htmlentities($_POST['vendorDetailsVendorAddress2']);
		$city = htmlentities($_POST['vendorDetailsVendorCity']);
		$district = htmlentities($_POST['vendorDetailsVendorDistrict']);
		$status = htmlentities($_POST['vendorDetailsStatus']);

		if(isset($fullName) && isset($mobile) && isset($address)) {
			// Validate mobile number
			if( preg_match('/^\d{10}$/', $mobile) && strlen($mobile) == 10) {
				// Valid mobile number
			} else {
				// Mobile is wrong
				$errorAlert =  '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number.</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}
			
			// Check if mobile phone is empty
			if($mobile == ''){
				// Mobile phone 1 is empty
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter mobile phone number.</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}
			
			// Validate second phone number only if it's provided by user
			if(!empty($phone2)){
				if(!(preg_match('/^\d{10}$/', $phone2) && strlen($phone2) == 10)) {
					// Phone number 2 is not valid
					$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number 2.</div>';
					$data = ['alertMessage' => $errorAlert, 'status' => "error"];
					echo json_encode($data);
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($email)) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email.</div>';
					$data = ['alertMessage' => $errorAlert, 'status' => "error"];
					echo json_encode($data);
					exit();
				}
			}
			
			// Validate address, address2 and city
			// Validate address
			if($address == ''){
				// Address 1 is empty
				$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Address.</div>';
				$data = ['alertMessage' => $errorAlert, 'status' => "error"];
				echo json_encode($data);
				exit();
			}
			
			// Start the insert process
			$sql = 'INSERT INTO vendor(companyName, contactPerson, email, mobile, phone2, address, address2, city, district, status) VALUES(:companyName, :contactPerson, :email, :mobile, :phone2, :address, :address2, :city, :district, :status)';
			$stmt = $conn->prepare($sql);
			$stmt->execute(['companyName' => $companyName, 'contactPerson' => $fullName, 'email' => $email, 'mobile' => $mobile, 'phone2' => $phone2, 'address' => $address, 'address2' => $address2, 'city' => $city, 'district' => $district, 'status' => $status]);
			$successAlert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Vendor added to database</div>';
			$data = ['alertMessage' => $successAlert, 'status' => "success"];
			echo json_encode($data);
			exit();
		
		} else {
			// One or more fields are empty
			$errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			$data = ['alertMessage' => $errorAlert, 'status' => "error"];
			echo json_encode($data);
			exit();
		}
	
	}
?>