<div class="tab-pane fade show active" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
    <div class="card card-outline-secondary my-4">
      <div class="card-header">Purchase Details</div>
      <div class="card-body pl-1 pt-1 pr-1">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#purchaseListTab" onclick="location.reload()">Purchase Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " id="purchaseOrderTab" onclick="initPurchaseOrder()" data-toggle="tab" href="#purchaseDetailsTab">Add/Edit</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="poPaymentsTab" data-toggle="tab" href="#purchasePaymentsTab" disabled>Payments</a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content  mt-minus-15">
            <div id="purchaseDetailsTab" class="container-fluid tab-pane">
              <br>
              <div id="purchaseDetailsMessage"></div>
              <form>
                <div class="form-row">
                  <div class="form-group col-md-2">
                      <input type="hidden" id="purchaseOrderId" name="purchaseOrderId">
                      <label for="purchaseDetailsPurchaseID">Purchase ID</label>
                      <input type="text" class="form-control invTooltip" id="purchaseDetailsPurchaseID" name="purchaseDetailsPurchaseID" title="This will be auto-generated when you add a new record" autocomplete="off">
                      <div id="purchaseDetailsPurchaseIDSuggestionsDiv" class="customListDivWidth"></div>
                  </div>
                  <div class="form-group col-md-3">
                      <label>Purchase Date<span class="requiredIcon">*</span></label>
                      <input style="height:32px;" type="text" class="form-control datepicker" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" readonly>
                  </div>
                  <div class="form-group col-md-5">
                      <label for="purchaseDetailsVendorName">Vendor Name<span class="requiredIcon">*</span></label>
                      <div style="display:flex;">
                        <select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
                          <option  value="null">--Select Vendor--</option> 
                          <?php 
                                require('model/vendor/getVendorNames.php');
                            ?>
                        </select>
                        <button type="button" class="btn btn-primary btn-md ml-2" onclick="window.location.href = 'vendors.php';"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                  <div class="form-group col-md-2" id="statusPO">
                    <label>Status</label>
                    <h4><span id="statusPOText" class="badge badge-info">Status</span></h4>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="purchaseDetailsDescription">Note</label>
                    <textarea rows="1" class="form-control" id="purchaseDetailsDescription" name="purchaseDetailsDescription"  autocomplete="off"></textarea>
                </div>
                </div>
                <hr>
                <div style="background-color: #f8f8f7; padding:5px">
                  <div class="form-row"> 
                      <div class="form-group col-md-3">
                        <label for="purchaseDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
                      </div>
                      <div class="form-group col-md-1">
                        <label>Stock</label>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="purchaseDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="purchaseDetailsUnitPrice">Buying Price<span class="requiredIcon">*</span></label>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="purchaseDetailsTotal">Sub Total</label>
                      </div>
                      <div class="form-group col-md-1">
                        <label id="lableActionHeader">#</label>
                      </div>
                  </div>
                  <div id="poItemList">
                    <div class="form-row"> 
                            <div class="form-group col-md-3">
                              <select id="purchaseDetailsItem"  name="purchaseDetailsItem" class="form-control" style="width: 100%">
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <input type="number" class="form-control price-al" id="purchaseDetailsAvalableQuantity" name="purchaseDetailsAvalableQuantity" value="0" readonly>
                          </div>
                            <div class="form-group col-md-2">
                                <input type="number" class="form-control price-al" id="purchaseDetailsQuantity" name="purchaseDetailsQuantity" value="0" min="1">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control price-al" id="purchaseDetailsUnitPrice" name="purchaseDetailsUnitPrice" value="0" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="hidden" id="purchaseItemId" name="purchaseItemId">
                                <input type="text" class="form-control price-al" id="purchaseDetailsTotal" name="purchaseDetailsTotal" readonly>
                            </div>
                            <div class="form-group col-md-1" id="goodReceivedData">
                              <input type="number" class="form-control price-al" id="purchaseDetailsGoodReceivedQuantity" name="purchaseDetailsGoodReceivedQuantity" value="0">
                            </div>
                            <div class="form-group col-md-1"> 
                            </div>
                        </div>
                    </div>
                  <div class="form-row" >
                    <div class="form-group col-md-4">
                      <button type="button" id="addPurchaseItem"  class="btn btn-info">Add Item Row</button>
                    </div>
                    <div class="form-group col-md-4">
                        <label style="float:right">Total </label>
                      </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control price-al" id="purchaseOrderTotal" name="purchaseOrderTotal" readonly>
                      </div>
                  </div>
                </div>
                <hr>
                
                <button type="button" id="addPurchaseBtn" class="btn btn-success">Add Purchase</button>
                <button type="button" id="updatePurchaseBtn" class="btn btn-primary" onclick="updatePurchaseOrder()">Update</button>
                <button type="button" id="clearBtn" class="btn" onclick="initPurchaseOrder(true)">Clear</button>
                <button type="button" id="printPdfBtn" class="btn btn-secondary" onclick="printPurchaseOrderPdf()">Print</button>
                <button type="button" id="sendPOBtn" class="btn btn-info" onclick="sendPO()">Submit</button>
                <button type="button" id="goodReceivedBtn" class="btn btn-info" onclick="updateGoodReceived()">Goods Receive</button>
                <button type="button" id="closePOBtn" class="btn btn-success" onclick="closePO()">Close</button>
                
                <button type="button" id="cancelPOBtn" class="btn btn-danger" onclick="cancelPO()">Cancel</button>
              </form>
            </div>
            <div id="purchaseListTab" class="container-fluid tab-pane fade active show">
              <br>
              <div class="table-responsive" id="purchaseDetailsTableDiv"></div>
            </div>
            <div id="purchasePaymentsTab" class="container-fluid tab-pane">
              <br>
              <input type="hidden" id="paymentOrderId" name="paymentOrderId">
              <div id="PaymentDetailsMessage"></div>
              <div class="form-row">
                <div class="form-group col-md-4" style="display:inline-block">
                  <label for="totalAmount" class ="payment-info"> Order No  : <span id="poNumber"></span> </label>
                </div>
                <div class="form-group col-md-4" style="display:inline-block">
                  <label for="totalAmount"  class ="payment-info"> Vendor : <span id="vendor"></span>  </label>
                </div>
                <div class="form-group col-md-4" style="display:inline-block">
                  <label for="totalAmount" class ="payment-info"> Payment Status : <span style="font-weight: 700;" id="paymentStatus"></span>  </label>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4" style="display:inline-block">
                  <label for="totalAmount"> Total Amount</label>
                  <h3 ><span id="totalAmount" class="badge bg-primary text-white"></span></h3>  
                </div>
                <div class="form-group col-md-4">
                  <label for="paidAmount"> Paid Amount </label>
                  <h3><span id="paidAmount" class="badge bg-success text-white"></span></h3>
                </div>
                <div class="form-group col-md-4">
                  <label for="creditAmount"> Credit</label>
                  <h3><span id="creditAmount" class="badge bg-warning text-white"></span></h3>
                </div>
             </div>
              <br>
             <h5>Settle this  bill</h5>
              <form id="poPaymentForm"> 
                <div class="form-row">
                  <div class="form-group col-md-3">
                     <label for="paymentAmount">Amount<span class="requiredIcon">*</span></label>
                     <input type="text" class="form-control" name="paymentAmount" id="paymentAmount" pattern="[0-9]{1,10}" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                     <label for="paymentAmount">Date<span class="requiredIcon">*</span></label>
                    <input style="height:32px;" type="text" class="form-control datepicker" name="paymentDate" id="paymentDate"  readonly="">
                  </div>
                <div class="form-group col-md-2">
                  <label for="paymentAmount">Payment Type<span class="requiredIcon">*</span></label>
                  <select  class="form-control"  name="paymentType" id="paymentType">
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                  </select>
                </div>
                <div class="form-group col-md-3 d-none" id="chequeNoDiv">
                  <label for="chequeNo">Cheque No<span class="requiredIcon">*</label>
                  <input type="text" class="form-control" name="chequeNo" id="chequeNo" autocomplete="off">
                </div>
                <div class="form-group col-md-2 d-none" id="chequeDateDiv">
                    <label for="chequeDate">Realization Date</label>
                    <input style="height:38px;" type="text" class="form-control datepicker" name="chequeDate" id="chequeDate" value="2018-05-24" readonly="">
                </div>
             </div>
             <div  class="form-row">
              <div class="form-group col-md-7">
                <label for="paymentNote" >Note</label>
                <textarea rows="1" id=paymentNote class="form-control"></textarea>
              </div>
              <div class="form-group col-md-4" style="text-align: left; margin-top: 30px;">
                <button type="reset" id="clearPaymentFormBtn" class="btn">Clear</button>
                <button type="button" id="addItem" class="btn btn-success" onclick="addPayment()">Add Payment</button>
              </div>
             </div>
              </form>
              <br>
              <br>
              <p style="font-weight: 700;">Payment History</p>
              <div class="table-responsive" id="purchasePaymentsTableDiv"></div>

            </div>
          </div>
      </div> 
    </div>
</div>
