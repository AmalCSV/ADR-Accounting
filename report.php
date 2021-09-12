<div id="reportsTab" class="container-fluid tab-pane fade active show pl-1 pr-1" style="padding:6px">
   <div id="reportsDetailsMessage"></div>
   <form>
      <div class="form-row">
         <div class="form-group col-md-4">
            <label for="itemDetailsUnitMeasure" >Report Type</label>
            <select id="itemDetailsUnitMeasure" name="itemDetailsUnitMeasure" class="form-control chosenSelect">
                <option value="vendorReports">Vendor vice</option>
                <option value="itemReports">Item vice</option>
                <option value="companyReports">All company</option>
            </select>
         </div>
         <div class="form-group col-md-4">
            <label for="reportDetailsVendor">Vendor Name<span class="requiredIcon">*</span></label>
            <div style="display:flex;">
                <select id="reportDetailsVendor" name="reportDetailsVendor" class="form-control chosenSelect">
                <option  value="null">--Select Vendor--</option> 
                    <?php 
                            require('model/vendor/getVendorNames.php');
                        ?>
                </select>                   
                <button type="button" class="btn btn-primary btn-md ml-2" onclick="window.location.href = 'vendors.php';"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            </div>
           
         </div>
         <div  class="form-group col-md-4">
            <label for="reportDetailsItem">Items<span class="requiredIcon">*</span></label>
            <select id="reportDetailsItem"  name="reportDetailsItem" class="form-control" style="width: 100%">
            </select>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-4">
            <label for="fromDate">From Date<span class="requiredIcon">*</span></label>
         </div>
      </div>
      <button type="button" id="addItem" class="btn btn-success">Add Item</button>
   </form>
</div>
<div  id="reportListTab" >
   <!-- Tab panes for reports sections -->
   <div class="tab-content">
      <div id="reportSearchTab" class="container-fluid tab-pane active pl-1 pr-1">
         <br>
         <div class="table-responsive" id="reportListTableDiv"></div>
      </div>
   </div>
</div>

