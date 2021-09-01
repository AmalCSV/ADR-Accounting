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
                <div class="col-lg-2">
                    <h1 class="my-4"></h1>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" href="items.php" role="tab" aria-controls="v-pills-item" aria-selected="false">Item</a>
                        <a class="nav-link" href="purchase.php" id="v-pills-purchase-tab" role="tab" aria-selected="false">Purchase</a>
                        <a class="nav-link active" id="v-pills-vendor-tab" href="vendors.php" role="tab" aria-controls="v-pills-vendor" aria-selected="true">Vendor</a>
                        <!-- <a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false" onclick="initSalesOrder()">Sale</a> -->
                        <a class="nav-link" id="v-pills-customer-tab" href="customers.php" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                        <!-- <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a> -->
                        <!-- <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a> -->
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Item Details</div>
                                <div class="card-body">
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
						<div class="tab-pane fade show active" id="v-pills-vendor" role="tabpanel" aria-labelledby="v-pills-vendor-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Vendor Details</div>
                                <div class="card-body">
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
                        <?php include('inc/html/sales-order.html'); ?>

                        <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Customer Details</div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#customerListTab">Customers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#customerDetailsTab">Add/Edit Customer</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <?php include 'customer.php';?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Search Inventory<button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <!-- <li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#customerSearchTab">Customer</a>
						</li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#saleSearchTab">Sale</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#purchaseSearchTab">Purchase</a>
                                        </li>
                                       
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div id="saleSearchTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <p>Use the grid below to search sale details</p>
                                            <div class="table-responsive" id="saleDetailsTableDiv"></div>
                                        </div>
                                        <div id="purchaseSearchTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <p>Use the grid below to search purchase details</p>
                                            <div class="table-responsive" id="purchaseDetailsTableDiv"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
                            <div class="card card-outline-secondary my-4">
                                <div class="card-header">Reports<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#customerReportsTab">Customer</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#saleReportsTab">Sale</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#purchaseReportsTab">Purchase</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#vendorReportsTab">Vendor</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes for reports sections -->
                                    <div class="tab-content">
                                        <div id="itemReportsTab" class="container-fluid tab-pane active">
                                            <br />
                                            <p>Use the grid below to get reports for items</p>
                                            <div class="table-responsive" id="itemReportsTableDiv"></div>
                                        </div>
                                        <div id="customerReportsTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <p>Use the grid below to get reports for customers</p>
                                            <div class="table-responsive" id="customerReportsTableDiv"></div>
                                        </div>
                                        <div id="saleReportsTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <!-- <p>Use the grid below to get reports for sales</p> -->
                                            <form>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="saleReportStartDate">Start Date</label>
                                                        <input type="text" class="form-control datepicker" id="saleReportStartDate" value="2018-05-24" name="saleReportStartDate" readonly />
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="saleReportEndDate">End Date</label>
                                                        <input type="text" class="form-control datepicker" id="saleReportEndDate" value="2018-05-24" name="saleReportEndDate" readonly />
                                                    </div>
                                                </div>
                                                <button type="button" id="showSaleReport" class="btn btn-dark">Show Report</button>
                                                <button type="reset" id="saleFilterClear" class="btn">Clear</button>
                                            </form>
                                            <br />
                                            <br />
                                            <div class="table-responsive" id="saleReportsTableDiv"></div>
                                        </div>
                                        <div id="purchaseReportsTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <!-- <p>Use the grid below to get reports for purchases</p> -->
                                            <form>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="purchaseReportStartDate">Start Date</label>
                                                        <input type="text" class="form-control datepicker" id="purchaseReportStartDate" value="2018-05-24" name="purchaseReportStartDate" readonly />
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="purchaseReportEndDate">End Date</label>
                                                        <input type="text" class="form-control datepicker" id="purchaseReportEndDate" value="2018-05-24" name="purchaseReportEndDate" readonly />
                                                    </div>
                                                </div>
                                                <button type="button" id="showPurchaseReport" class="btn btn-dark">Show Report</button>
                                                <button type="reset" id="purchaseFilterClear" class="btn">Clear</button>
                                            </form>
                                            <br />
                                            <br />
                                            <div class="table-responsive" id="purchaseReportsTableDiv"></div>
                                        </div>
                                        <div id="vendorReportsTab" class="container-fluid tab-pane fade">
                                            <br />
                                            <p>Use the grid below to get reports for vendors</p>
                                            <div class="table-responsive" id="vendorReportsTableDiv"></div>
                                        </div>
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
    </body>
</html>
