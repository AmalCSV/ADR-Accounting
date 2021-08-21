<div id="vendorDetailsTab" class="tab-pane fade" id="v-pills-vendor" role="tabpanel" aria-labelledby="v-pills-vendor-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header">Vendor Details</div>
        <div class="card-body">
            <!-- Div to show the ajax message from validations/db submission -->
            <div id="vendorDetailsMessage"></div>
            <form>
                <div class="form-row">
					<div class="form-group col-md-4">
                        <label for="vendorCompanyName">Company Name</label>
                        <input type="text" class="form-control" id="vendorCompanyName" name="vendorCompanyName" placeholder="" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vendorDetailsVendorFullName">Contact Person</label>
                        <input type="text" class="form-control" id="vendorDetailsVendorFullName" name="vendorDetailsVendorFullName" placeholder="" />
                    </div>
                    <div class="form-group col-md-2">
                        <label for="vendorDetailsStatus">Status</label>
                        <select id="vendorDetailsStatus" name="vendorDetailsStatus" class="form-control chosenSelect">
                            <?php include('inc/statusList.html'); ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="vendorDetailsVendorID">Vendor ID</label>
                        <input type="text" class="form-control invTooltip" id="vendorDetailsVendorID" name="vendorDetailsVendorID" title="This will be auto-generated when you add a new vendor" autocomplete="off" />
                        <div id="vendorDetailsVendorIDSuggestionsDiv" class="customListDivWidth"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="vendorDetailsVendorMobile">Phone (mobile)<span class="requiredIcon">*</span></label>
                        <input type="text" class="form-control invTooltip" id="vendorDetailsVendorMobile" name="vendorDetailsVendorMobile" title="Do not enter leading 0" />
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vendorDetailsVendorPhone2">Phone 2</label>
                        <input type="text" class="form-control invTooltip" id="vendorDetailsVendorPhone2" name="vendorDetailsVendorPhone2" title="Do not enter leading 0" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vendorDetailsVendorEmail">Email</label>
                        <input type="email" class="form-control" id="vendorDetailsVendorEmail" name="vendorDetailsVendorEmail" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="vendorDetailsVendorAddress">Address<span class="requiredIcon">*</span></label>
                    <input type="text" class="form-control" id="vendorDetailsVendorAddress" name="vendorDetailsVendorAddress" />
                </div>
                <div class="form-group">
                    <label for="vendorDetailsVendorAddress2">Address 2</label>
                    <input type="text" class="form-control" id="vendorDetailsVendorAddress2" name="vendorDetailsVendorAddress2" />
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="vendorDetailsVendorCity">City</label>
                        <input type="text" class="form-control" id="vendorDetailsVendorCity" name="vendorDetailsVendorCity" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vendorDetailsVendorDistrict">District</label>
                        <select id="vendorDetailsVendorDistrict" name="vendorDetailsVendorDistrict" class="form-control chosenSelect">
                            <?php include('inc/districtList.html'); ?>
                        </select>
                    </div>
                </div>
                <button type="button" id="addVendor" name="addVendor" class="btn btn-success">Add Vendor</button>
                <button type="button" id="updateVendorDetailsButton" class="btn btn-primary">Update</button>
                <button type="button" id="deleteVendorButton" class="btn btn-danger">Delete</button>
                <button type="reset" id="clearVendortButton" class="btn">Clear</button>
            </form>
        </div>
    </div>
</div>

<div  id="vendorListTab" class="container-fluid tab-pane fade active show">
   <!-- Tab panes for reports sections -->
   <div class="tab-content">
   		<div id="vendorSearchTab" class="container-fluid tab-pane fade active show">
			<br>
			<p>Use the grid below to search vendor details</p>
			<div class="table-responsive" id="vendorDetailsTableDiv"></div>
		</div>
   </div>
</div>

