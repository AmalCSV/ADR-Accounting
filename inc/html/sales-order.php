<div class="tab-pane fade show active" id="v-pills-sale" role="tabpanel" aria-labelledby="v-pills-sale-tab">
  <div class="card card-outline-secondary my-4">
    <div class="card-header">Sale Details</div>
    <div class="card-body">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#salesListTab">Sales Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="salesOrderTab" data-toggle="tab" href="#salesOrderDetailTab">Add/Edit</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="soPaymentsTab" data-toggle="tab" href="#salesPaymentsTab" disabled="disabled">Payments</a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div id="salesOrderDetailTab" class="container-fluid tab-pane">
          <br>
          <div id="saleDetailsMessage"></div>
          <form>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label for="saleDetailsSaleID">Sale ID</label>
                <input type="text" class="form-control invTooltip" id="saleDetailsSaleID" name="saleDetailsSaleID"/>
              </div>
              <div class="form-group col-md-2">
                <label for="saleDetailsSaleDate">Sale Date<span class="requiredIcon">*</span></label>
                <input type="text" class="form-control datepicker" id="saleDetailsSaleDate" name="saleDetailsSaleDate" readonly="readonly"/>
              </div>
              <div class="form-group col-md-3">
                      <label for="saleDetailsVendorName">Vendor Name<span class="requiredIcon">*</span></label>
                      <div style="display:flex;">
                        <select id="saleDetailsVendorName" name="saleDetailsVendorName" class="form-control chosenSelect">
                          <option  value="null">--Select Vendor--</option> 
                          <?php 
                                require('model/vendor/getVendorNames.php');
                            ?>
                        </select>
                        <button type="button" class="btn btn-primary btn-md ml-2" onclick="window.location.href = 'vendors.php';"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                      </div>
              </div>
              <div class="form-group col-md-3">
                <label for="saleDetailsCustomerName" class="col-md-12">Customer</label>
                <select id="saleDetailsCustomerName" class="ol-md-12 form-control" style="width: 100%"></select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="salesDescription">Note</label>
                <textarea rows="1" class="form-control" id="salesDescription" name="salesDescription" autocomplete="off"></textarea>
              </div>
              <div class="form-group col-md-2" id="statusSO">
                    <label>Status</label>
                    <h4><span id="statusSOText" class="badge badge-info">Status</span></h4>
                  </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Item Name<span class="requiredIcon">*</span></label>
              </div>
              <div class="form-group col-md-2">
                <label>Quantity<span class="requiredIcon">*</span></label>
              </div>
              <div class="form-group col-md-2">
                <label>Selling Price<span class="requiredIcon">*</span></label>
              </div>
              <div class="form-group col-md-2">
                <label>Sub Total</label>
              </div>
              <div class="form-group col-md-1">
                <label id="lableActionHeader">#</label>
              </div>
            </div>
            <div id="salesItemList">
              <div class="form-row">
                <div class="form-group col-md-3">
                  <select id="saleDetailsItem" class="form-control" style="width: 100%"></select>
                </div>
                <div class="form-group col-md-1">
                  <input type="number" class="form-control text-right" id="saleDetailsAvalableQuantity" name="saleDetailsAvalableQuantity" value="0" readonly>
                </div>
                <div class="form-group col-md-2">
                  <input type="number" class="form-control text-right" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0"/>
                </div>
                <div class="form-group col-md-2">
                  <input type="text" class="form-control text-right" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0" readonly="readonly"/>
                </div>
                <div class="form-group col-md-2">
                  <input type="text" class="form-control text-right" id="saleDetailsTotal" name="saleDetailsTotal" readonly="readonly"/>
                </div>
                <div class="form-group col-md-1" id="deliveredData">
                  <input type="number" class="form-control" id="saleDetailsDeliveredQuantity" name="saleDetailsDeliveredQuantity" value="0">
                </div>
                <div class="form-group col-md-1">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                  <button type="button" id="saleDetailsItemAdd"  class="btn btn-info">Add Item Row</button>
              </div>
              <div class="form-group col-md-4">
                <label style="float:right">Total Before Discount</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control text-right" id="salesOrderTotal" name="salesOrderTotal" readonly="readonly">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                <label style="float:right" for="saleDetailsDiscountp">Discount %</label>
              </div>
              <div class="form-group col-md-1">
                <input class="form-control text-right" id="saleDetailsDiscountp" name="saleDetailsDiscountp" value="0" type="number" min="1" max="50"/>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                <label style="float:right">Total</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control text-right" id="salesOrderNetTotal" name="salesOrderNetTotal" readonly="readonly">
              </div>
            </div>
            <button type="button" id="addSaleButton" class="btn btn-success">Add Sale</button>
            <button type="button" id="updateSaleButton" class="btn btn-primary" onclick="updateSalesOrder()">Update</button>
            <button type="reset" id="clearBtn" onclick="initSalesOrder()" class="btn">Clear</button>
            <button type="button" id="printPdfBtn" class="btn btn-secondary" onclick="printSalesOrderPdf()">Print</button>
            <button type="button" id="sendSOBtn" class="btn btn-info" onclick="sendSO()">Submit</button>
            <button type="button" id="deliveredBtn" class="btn btn-info" onclick="updateDelivered()">Delivery</button>
            <button type="button" id="closeSOBtn" class="btn btn-success" onclick="closeSO()">Close</button>
            <button type="button" id="cancelSOBtn" class="btn btn-danger" onclick="cancelSO()">Cancel</button>
          </form>
        </div>
        <div id="salesListTab" class="container-fluid tab-pane fade show active">
          <br/>
          <p>Use the grid below to search sale details</p>
          <div class="table-responsive" id="salesDetailsTableDiv1"></div>
        </div>
        <div id="salesPaymentsTab" class="container-fluid tab-pane fade">
          <br>
          <input type="hidden" id="paymentSalesId" name="paymentOrderId">
          <div id="soPaymentDetailsMessage"></div>
          <div class="form-row">
            <div class="form-group col-md-3" style="display:inline-block">
              <label for="soNumber" style="display : inline-flex">
                Order No :
                <span id="soNumber"></span>
              </label>
            </div>
            <div class="form-group col-md-3" style="display:inline-block">
              <label for="customer" style="display : inline-flex">
                Customer :
                <span id="customer"></span>
              </label>
            </div>
            <div class="form-group col-md-3" style="display:inline-block">
              <label for="soPaymentStatus" style="display : inline-flex">
                Payment Status :
                <span style="font-weight: 700;" id="soPaymentStatus"></span>
              </label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3" style="display:inline-block">
              <label for="totalAmount">
                Total Amount</label>
              <h3>
                <span id="soTotalAmount" class="badge bg-primary text-white"></span></h3>
            </div>
            <div class="form-group col-md-3">
              <label for="soPaidAmount">
                Paid Amount
              </label>
              <h3>
                <span id="soPaidAmount" class="badge bg-success text-white"></span></h3>
            </div>
            <div class="form-group col-md-2">
              <label for="soCreditAmount">
                Credit</label>
              <h3>
                <span id="soCreditAmount" class="badge bg-warning text-white"></span></h3>
            </div>
          </div>
          <br>
          <h5>Settle this bill</h5>
          <form id="poPaymentForm">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label for="soPaymentAmount">Amount<span class="requiredIcon">*</span></label>
                <input type="text" class="form-control" name="soPaymentAmount" id="soPaymentAmount" pattern="[0-9]{1,10}" autocomplete="off">
              </div>
              <div class="form-group col-md-2">
                <label for="soPaymentDate">Date<span class="requiredIcon">*</span></label>
                <input type="text" class="form-control datepicker" name="soPaymentDate" id="soPaymentDate" value="2018-05-24" readonly="">
              </div>
              <div class="form-group col-md-2">
                <label for="soPaymentType">Payment Type<span class="requiredIcon">*</span></label>
                <select class="form-control" name="soPaymentType" id="soPaymentType">
                  <option value="Cash">Cash</option>
                  <option value="Cheque">Cheque</option>
                </select>
              </div>
              <div class="form-group col-md-2 d-none" id="soChequeNoDiv">
                <label for="soChequeNo">Cheque No<span class="requiredIcon">*</label>
                  <input type="text" class="form-control" name="soChequeNo" id="soChequeNo" autocomplete="off">
                </div>
                <div class="form-group col-md-2 d-none" id="soChequeDateDiv">
                  <label for="soChequeDate">Realisation Date</label>
                  <input type="text" class="form-control datepicker" name="soChequeDate" id="soChequeDate" value="2018-05-24" readonly="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="soPaymentNote">Note</label>
                  <input type="text" id="soPaymentNote" class="form-control"></input>
                </div>
                <div class="form-group col-md-2" style="text-align: right; margin-top: 30px;">
                  <button type="reset" id="soClearPaymentFormBtn" class="btn">Clear</button>
                  <button type="button" id="soAddItem" class="btn btn-success" onclick="addSalesPayment()">Add Payment</button>
                </div>
              </div>
            </form>
            <br>
            <br>
            <p>Payment History</p>
            <div class="table-responsive" id="salesPaymentsTableDiv"></div>

          </div>
        </div>

      </div>
    </div>
  </div>
