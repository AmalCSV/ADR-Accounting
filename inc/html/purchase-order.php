<div class="tab-pane fade show active" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
    <div class="card card-outline-secondary my-4">
      <div class="card-header">Purchase Details</div>
      <div class="card-body">
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
          <div class="tab-content">
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
                      <input type="text" class="form-control datepicker" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" readonly>
                  </div>
                  <div class="form-group col-md-4">
                      <label for="purchaseDetailsVendorName">Vendor Name<span class="requiredIcon">*</span></label>
                      <select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
                        <option  value="null">--Select Vendor--</option> 
                        <?php 
                              require('model/vendor/getVendorNames.php');
                          ?>
                      </select>
                    </div>
                  <div class="form-group col-md-3" id="statusPO">
                    <label>Status</label>
                    <h4><span id="statusPOText" class="badge badge-info">Status</span></h4>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="purchaseDetailsDescription">Note</label>
                    <textarea rows="4" class="form-control" id="purchaseDetailsDescription" name="purchaseDetailsDescription"  autocomplete="off"></textarea>
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
                              <input type="number" class="form-control" id="purchaseDetailsAvalableQuantity" name="purchaseDetailsAvalableQuantity" value="0" readonly>
                          </div>
                            <div class="form-group col-md-2">
                                <input type="number" class="form-control" id="purchaseDetailsQuantity" name="purchaseDetailsQuantity" value="0" min="1">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="purchaseDetailsUnitPrice" name="purchaseDetailsUnitPrice" value="0" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="hidden" id="purchaseItemId" name="purchaseItemId">
                                <input type="text" class="form-control" id="purchaseDetailsTotal" name="purchaseDetailsTotal" readonly>
                            </div>
                            <div class="form-group col-md-1" id="goodReceivedData">
                              <input type="number" class="form-control" id="purchaseDetailsGoodReceivedQuantity" name="purchaseDetailsGoodReceivedQuantity" value="0">
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
                        <input type="text" class="form-control" id="purchaseOrderTotal" name="purchaseOrderTotal" readonly>
                      </div>
                  </div>
                </div>
                <hr>
                
                <button type="button" id="addPurchaseBtn" class="btn btn-success">Add Purchase</button>
                <button type="button" id="updatePurchaseBtn" class="btn btn-primary" onclick="updatePurchaseOrder()">Update</button>
                <button type="button" id="clearBtn" class="btn" onclick="initPurchaseOrder(true)">Clear</button>
                
                <button type="button" id="sendPOBtn" class="btn btn-info" onclick="sendPO()">Submit</button>
                <button type="button" id="closePOBtn" class="btn btn-success" onclick="closePO()">Close</button>
                <button type="button" id="goodReceivedBtn" class="btn btn-info" onclick="updateGoodReceived()">Good Receive</button>
                <button type="button" id="cancelPOBtn" class="btn btn-danger" onclick="cancelPO()">Cancel</button>
                <button type="button" id="printPdfBtn" class="btn btn-secondary" onclick="printPurchaseOrderPdf()">Print</button>
              </form>
            </div>
            <div id="purchaseListTab" class="container-fluid tab-pane fade active show">
              <br>
              <p>Use the grid below to search purchase details</p>
              <div class="table-responsive" id="purchaseDetailsTableDiv"></div>
            </div>
            <div id="purchasePaymentsTab" class="container-fluid tab-pane">
              <br>
              <input type="hidden" id="paymentOrderId" name="paymentOrderId">
              <div id="PaymentDetailsMessage"></div>
              <div class="form-row">
                <div class="form-group col-md-3" style="display:inline-block">
                  <label for="totalAmount" style="display : inline-flex"> Order No  : <span id="poNumber"></span> </label>
                </div>
                <div class="form-group col-md-3" style="display:inline-block">
                  <label for="totalAmount"  style="display : inline-flex"> Vendor : <span id="vendor"></span>  </label>
                </div>
                <div class="form-group col-md-3" style="display:inline-block">
                  <label for="totalAmount"  style="display : inline-flex"> Payment Status : <span style="font-weight: 700;" id="paymentStatus"></span>  </label>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3" style="display:inline-block">
                  <label for="totalAmount"> Total Amount</label>
                  <h3 ><span id="totalAmount" class="badge bg-primary text-white"></span></h3>  
                </div>
                <div class="form-group col-md-3">
                  <label for="paidAmount"> Paid Amount </label>
                  <h3><span id="paidAmount" class="badge bg-success text-white"></span></h3>
                </div>
                <div class="form-group col-md-2">
                  <label for="creditAmount"> Credit</label>
                  <h3><span id="creditAmount" class="badge bg-warning text-white"></span></h3>
                </div>
             </div>
              <br>
             <h5>Settle this  bill</h5>
              <form id="poPaymentForm"> 
                <div class="form-row">
                  <div class="form-group col-md-2">
                     <label for="paymentAmount">Amount<span class="requiredIcon">*</span></label>
                     <input type="text" class="form-control" name="paymentAmount" id="paymentAmount" pattern="[0-9]{1,10}" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                     <label for="paymentAmount">Date<span class="requiredIcon">*</span></label>
                    <input type="text" class="form-control datepicker" name="paymentDate" id="paymentDate" value="2018-05-24" readonly="">
                  </div>
                <div class="form-group col-md-2">
                  <label for="paymentAmount">Payment Type<span class="requiredIcon">*</span></label>
                  <select  class="form-control"  name="paymentType" id="paymentType">
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                  </select>
                </div>
                <div class="form-group col-md-2 d-none" id="chequeNoDiv">
                  <label for="chequeNo">Cheque No<span class="requiredIcon">*</label>
                  <input type="text" class="form-control" name="chequeNo" id="chequeNo" autocomplete="off">
                </div>
                <div class="form-group col-md-2 d-none" id="chequeDateDiv">
                    <label for="chequeDate">Realisation Date</label>
                    <input type="text" class="form-control datepicker" name="chequeDate" id="chequeDate" value="2018-05-24" readonly="">
                </div>
             </div>
             <div  class="form-row">
              <div class="form-group col-md-6">
                <label for="paymentNote" >Note</label>
                <input type="text" id=paymentNote class="form-control"></input>
              </div>
              <div class="form-group col-md-2" style="text-align: right; margin-top: 30px;">
                <button type="reset" id="clearPaymentFormBtn" class="btn">Clear</button>
                <button type="button" id="addItem" class="btn btn-success" onclick="addPayment()">Add Payment</button>
              </div>
             </div>
              </form>
              <br>
              <br>
              <p>Payment History</p>
              <div class="table-responsive" id="purchasePaymentsTableDiv"></div>

            </div>
          </div>
      </div> 
    </div>
</div>