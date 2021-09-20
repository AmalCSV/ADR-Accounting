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
                        <a class="nav-link active" href="items.php" role="tab" aria-controls="v-pills-item" aria-selected="true">Item</a>
                        <a class="nav-link" href="purchase.php" id="v-pills-purchase-tab" role="tab" aria-selected="false">Purchase</a>
                        <a class="nav-link" id="v-pills-vendor-tab" href="vendors.php" role="tab" aria-controls="v-pills-vendor" aria-selected="false">Vendor</a>
                        <a class="nav-link" id="v-pills-sale-tab" href="sales.php" role="tab" aria-controls="v-pills-sale" aria-selected="false">Sale</a>
                        <a class="nav-link" id="v-pills-customer-tab" href="customers.php" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                        <!-- <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a> -->
                        <a class="nav-link" id="v-pills-reports-tab" href="reports.php" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>
                    </div>
                </div>
                <div class="col-lg-11 pl-1 pr-1">
                    <div class="tab-content mt-minus-15" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Item Details</div>
                                <div class="card-body pl-1 pt-1 pr-1">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#itemListTab">Item List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#itemDetailsTab">Add/Edit Item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#itemImageTab">Upload Image</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes for item details and image sections -->
                                    <div class="tab-content">
                                        <?php include 'item.php';?>
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
<script src="assets/js/item.js"></script>
    </body>
</html>
