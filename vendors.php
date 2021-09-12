<?php
	session_start();
	// Redirect the user to login page if he is not logged in.
	if(!isset($_SESSION['loggedIn'])){
		header('Location: login.php');
		exit();
	}
	
	require_once('inc/config/constants.php');
	require_once('inc/config/db.php');
	require_once('inc/header.html');
?>
<html>
    <body>
        <?php
	require 'inc/navigation.php';
?>

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-1 pl-1">
                    <h1 class="my-4"></h1>
                    <div class="nav flex-column nav-pills mt-minus-15" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" href="items.php" role="tab" aria-controls="v-pills-item" aria-selected="false">Item</a>
                        <a class="nav-link" href="purchase.php" id="v-pills-purchase-tab" role="tab" aria-selected="false">Purchase</a>
                        <a class="nav-link active" id="v-pills-vendor-tab" href="vendors.php" role="tab" aria-controls="v-pills-vendor" aria-selected="true">Vendor</a>
                        <!-- <a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false" onclick="initSalesOrder()">Sale</a> -->
                        <a class="nav-link" id="v-pills-customer-tab" href="customers.php" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                        <!-- <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a> -->
                        <a class="nav-link" id="v-pills-reports-tab" href="reports.php" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>
                    </div>
                </div>
                <div class="col-lg-11 pl-1 pr-1">
						<div class="tab-pane fade show active mt-minus-15" id="v-pills-vendor" role="tabpanel" aria-labelledby="v-pills-vendor-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Vendor Details</div>
                                <div class="card-body pl-1 pt-1 pr-1">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#vendorListTab">Vendors</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vendorDetailsTab">Add/Edit Vendor</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <?php include 'vendor.php';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
	require 'inc/footer.php';
?>
	<script src="assets/js/vendor.js"></script>

    </body>
</html>
