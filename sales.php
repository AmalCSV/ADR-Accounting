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
                        <a class="nav-link" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="false">Item</a>
                        <a class="nav-link" href="purchase.php">Purchase</a>
                        <a class="nav-link" id="v-pills-vendor-tab" href="vendors.php" role="tab" aria-controls="v-pills-vendor" aria-selected="false">Vendor</a>
                        <a class="nav-link active" id="v-pills-sale-tab" href="sales.php" role="tab" aria-controls="v-pills-sale"  aria-selected="true">Sale</a>
                        <a class="nav-link" id="v-pills-customer-tab" href="customers.php" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                        <!-- <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a> -->
                        <!-- <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a> -->
                    </div>
                </div>
                <div class="col-lg-11 pl-1 pr-1">
                    <div class="tab-content mt-minus-15" id="v-pills-tabContent">
                        <?php include('inc/html/sales-order.php'); ?>
                    </div>
                </div>
            </div>
        </div>
         <!-- Footer -->
    <footer class="footer bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Inventory System <?php echo date('Y'); ?></p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<!-- Datatables script -->
	<script type="text/javascript" charset="utf8" src="vendor/DataTables/datatables.js"></script>
	<script type="text/javascript" charset="utf8" src="vendor/DataTables/sumsum.js"></script>
	
	<!-- Chosen files for select boxes -->
	<script src="vendor/chosen/chosen.jquery.min.js"></script>
	<link rel="stylesheet" href="vendor/chosen/chosen.css" />
	
	<!-- Datepicker JS -->
	<script src="vendor/datepicker164/js/bootstrap-datepicker.min.js"></script>
	
	<!-- Bootbox JS -->
	<script src="vendor/bootbox/bootbox.min.js"></script>
	<!-- select js -->
	<script src='assets/lib/select2/dist/js/select2.min.js'></script>
	<script src='assets/lib/fontawesome-5/js/all.js'></script>

	<!-- New scripts -->
	<script src="assets/js/util.js"></script>

	<script src="assets/js/sales-order.js"></script>
	<script src="vendor/pdfmake/pdfmake.js"></script>
	<script src="vendor/pdfmake/vfs_fonts.js"></script>

	<script src="assets/js/pdfGenerator.js"></script>
    </body>
</html>
