<style>
   .table th, .table td{
      padding: 0.50rem;
   }
</style>
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
         <div class="row">
            <div class="col-6">
               <div class="card">
                  <div class="card-header bg-warning pl-2 text-white">
                     <div class="row">
                        <div class="col-6">Profit</div>
                        <div class="col-6 text-right">20000.00</div>
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
                  <div class="card-header bg-info pl-2 text-white">
                     <div class="row">
                        <div class="col-6">Stock Value</div>
                        <div class="col-6 text-right">20000.00</div>
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
                        <thead class="thead-light">
                        </thead>
                        <tbody>
                           <tr>
                              <th colspan="2">Total</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total Paid</th>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total To Be Paid</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th scope="col">Order Status</th>
                              <th scope="col"  class="text-right">No of Orders</th>
                              <th scope="col"  class="text-right">Value</th>
                           </tr>
                           <tr>
                              <td >Submitted</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <td>Received</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <td>Closed</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                        </tbody>
                     </table>
                  </ul>
               </div>
            </div>
            <div class="col-6">
               <div class="card">
                  <div class="card-header bg-success pl-2 text-white">
                     Sales Orders
                  </div>
                  <ul class="list-group list-group-flush">
                     <table class="table table-striped">
                        <thead class="thead-light">
                        </thead>
                        <tbody>
                           <tr>
                              <th colspan="2">Total</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total Paid</th>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th colspan="2">Total To Be Paid</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <th scope="col">Order Status</th>
                              <th scope="col"  class="text-right">No of Orders</th>
                              <th scope="col"  class="text-right">Value</th>
                           </tr>
                           <tr>
                              <td >Submitted</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <td>Received</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
                           <tr>
                              <td>Closed</td>
                              <td class="text-right">10</td>
                              <td class="text-right">2000.00</td>
                           </tr>
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

