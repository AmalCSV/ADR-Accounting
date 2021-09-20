<div id="reportsTab" class="container-fluid tab-pane fade active show pl-1 pr-1" style="padding:6px">
   <div id="reportsDetailsMessage"></div>
   <form>
      <div class="form-row">
         <div class="form-group col-md-4">
            <label for="reportType" >Report Type</label>
            <select id="reportType" name="reportType" class="form-control chosenSelect">
                <option value="companyReports">All company</option>
                <option value="vendorReports">Vendor vice</option>
                <option value="itemReports">Item vice</option>
            </select>
         </div>
         <div class="form-group col-md-4" id="venderDiv"  style="display:none;">
            <label for="reportDetailsVendor">Vendor Name<span class="requiredIcon">*</span></label>
            <div  style="display:flex;" >
                <select id="reportDetailsVendor" name="reportDetailsVendor" class="form-control chosenSelect">
                <option  value="null">--Select Vendor--</option> 
                    <?php 
                            require('model/vendor/getVendorNames.php');
                        ?>
                </select>                   
                <button type="button" class="btn btn-primary btn-md ml-2" onclick="window.location.href = 'vendors.php';"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            </div>
           
         </div>
         <div  class="form-group col-md-4 " style="display:none;" id="itemsDiv">
            <label for="reportDetailsItem">Items<span class="requiredIcon">*</span></label>
            <select id="reportDetailsItem" name="reportDetailsItem" class="form-control" style="width: 100%">
            </select>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-4">
            <label for="reportsFromDate">From Date<span class="requiredIcon">*</span></label>
            <input style="height:32px;width: 95%;" type="text" class="form-control datepicker" id="reportsFromDate" name="reportsFromDate" >
         </div>
         <div class="form-group col-md-4">
            <label for="reportsToDate">To Date<span class="requiredIcon">*</span></label>
            <input style="height:32px;width: 92%;" type="text" class="form-control datepicker" id="reportsToDate" name="reportsToDate">
         </div>
         <div class="form-group col-md-4 mt-4">
            <button type="button" id="addItem" class="btn btn-success mt-1" style="width: 30%;" onclick="searchData()">Search</button>
         </div>
      </div>
      <div class="mt-4 ml-2" id="companyDetails">
         <div class="form-row ">
            <div class="form-group col-md-2">
               <label for="totalPurchases">Total Purchases </label>
            </div>
            <div class="form-group col-md-1  text-right">
               <label id="totalPurchases">0.00</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-2">
               <label for="totalSales">Total Sales </label>
            </div>
            <div class="form-group col-md-1  text-right">
               <label id="totalSales">0.00</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-2">
               <label for="totalProfit">Total Profit </label>
            </div>
            <div class="form-group col-md-1 text-right">
               <label id="totalProfit">0.00</label>
            </div>
         </div>
         <div class="form-row">
            <div class="form-group col-md-2">
               <label for="stockValue">Stock Value </label>
            </div>
            <div class="form-group col-md-1  text-right">
               <label id="stockValue">0.00</label>
            </div>
         </div>
      </div>
   </form>
</div>
<div  id="reportListTab" style="display:none;" >
   <!-- Tab panes for reports sections -->
   <div class="tab-content">
      <div id="reportSearchTab" class="container-fluid tab-pane active pl-1 pr-1">
         <br>
         <div class="table-responsive" id="reportListTableDiv"></div>
      </div>
   </div>
</div>

