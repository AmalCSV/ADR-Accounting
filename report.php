<style>
   .table th, .table td{
      padding: 0.50rem;
   }
</style>
<div id="reportsTab" class="container-fluid tab-pane fade active show pl-1 pr-1" style="padding:6px">
   <div id="reportsDetailsMessage"></div>
   <form>
      <div class="form-row">
         <div class="form-group col-md-3">
            <label for="reportType" >Report Type</label>
            <select id="reportType" name="reportType" class="form-control chosenSelect">
                <option value="companyReports">All company</option>
                <option value="vendorReports">Vendor wise</option>
                <option value="itemReports">Item wise</option>
            </select>
         </div>
         <div class="form-group col-md-3" id="venderDiv"  style="display:none;">
            <label for="reportDetailsVendor">Vendor Name<span class="requiredIcon">*</span></label>
            <div  style="display:flex;" >
                <select id="reportDetailsVendor" name="reportDetailsVendor" class="form-control chosenSelect">
                <option  value="-1">All</option> 
                    <?php 
                            require('model/vendor/getVendorNames.php');
                        ?>
                </select>                   
            </div>
         </div>
         <div  class="form-group col-md-3" style="display:none;" id="itemsDiv">
            <label for="reportDetailsItem">Items<span class="requiredIcon">*</span></label>
            <select id="reportDetailsItem" name="reportDetailsItem" class="form-control" style="width: 100%">
            </select>
         </div>
         <div class="form-group col-md-3" id="statusDiv"  style="display:none;">
            <label for="reportStatus">Order Status</label>
            <div  style="display:flex;" >
                <select id="reportStatus" name="reportStatus" class="form-control ">
                <option  value="ALL">All</option> 
                <option  value="CLOSE">Close</option> 
                </select>                   
            </div>
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
         <div class="row">
            <div class="col-6">
               <div class="card">
                  <div class="card-header bg-warning pl-2 text-white" style="background-image: linear-gradient(#ff6707, #DD5600 60%, #c94e00);">
                     <div class="row">
                        <div class="col-6">Profit</div>
                        <div class="col-6 text-right" id="totalProfit">0.00</div>
                     </div>
                  </div>
                  <!-- <ul class="list-group list-group-flush">
                  <table class="table table-striped">
                        <thead class="thead-light">
                           <tr>
                              <th scope="col">Total Profit</th>
                              <th class="text-right">20000.00</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </ul> -->
               </div>
            </div>
            <div class="col-6">
               <div class="card" >
                  <div class="card-header bg-dark pl-2 text-white">
                     <div class="row">
                        <div class="col-6">Stock Value</div>
                        <div id="stockValue" class="col-6 text-right">0.00</div>
                     </div>
                  </div>
                  <!-- <ul class="list-group list-group-flush">
                  <table class="table table-striped">
                        <thead class="thead-light">
                           <tr>
                              <th scope="col">Total Stock</th>
                              <th class="text-right">20000.00</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </ul> -->
               </div>
            </div>
         </div>
         <br>
         <div class="row">
            <div class="col-6">
               <div class="card">
                  <div class="card-header bg-primary pl-2 text-white">
                     Purchase Orders
                  </div>
                  <ul class="list-group list-group-flush">
                     <table class="table table-striped">
                        <tbody >
                           <tr>
                              <th colspan="2">Total Purchases</td>
                              <td class="text-right" id="totalPurchases">0.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total Paid</th>
                              <td class="text-right" id="poPaid">0.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total To Be Paid</td>
                              <td class="text-right" id="poToBePaid">0.00</td>
                           </tr>
                        </tbody>
                     </table>
                     <table class="table table-striped">
                        <thead>
                        <tr>
                              <th scope="col">Order Status</th>
                              <th scope="col"  class="text-right">No of Orders</th>
                              <th scope="col"  class="text-right">Amount</th>
                           </tr>
                        </thead>
                        <tbody id="poTable"> 
                        </tbody>
                     </table>
                  </ul>
               </div>
            </div>
            <div class="col-6">
               <div class="card">
                  <div class="card-header pl-2 text-white" style="background-image: linear-gradient(#88c149, #73A839 60%, #699934);">
                     Sales Orders
                  </div>
                  <ul class="list-group list-group-flush">
                     <table class="table table-striped">
                        <thead class="thead-light">
                        </thead>
                        <tbody>
                           <tr>
                              <th colspan="2">Total Sales</td>
                              <td class="text-right"  id="totalSales">0.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Payments Received</th>
                              <td class="text-right"  id="soPaid">0.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Payments To Be Received</td>
                              <td class="text-right"  id="soToBePaid">0.00</td>
                           </tr>                       
                        </tbody>
                     </table>
                     <table class="table table-striped">
                        <thead>
                        <tr>
                              <th scope="col">Order Status</th>
                              <th scope="col"  class="text-right">No of Orders</th>
                              <th scope="col"  class="text-right">Amount</th>
                           </tr>
                        </thead>
                        <tbody id="soTable"> 
                        </tbody>
                     </table>
                  </ul>
               </div>
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

