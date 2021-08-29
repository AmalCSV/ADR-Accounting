<div id="itemDetailsTab" class="container-fluid tab-pane">
   <br>
   <!-- Div to show the ajax message from validations/db submission -->
   <div id="itemDetailsMessage"></div>
   <form>
      <div class="form-row">
         <div class="form-group col-md-3" style="display:inline-block">
            <label for="itemDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
            <input type="text" class="form-control" name="itemDetailsItemNumber" id="itemDetailsItemNumber" autocomplete="off">
         </div>
         <div class="form-group col-md-3">
            <label for="itemDetailsUnitMeasure" >Unit of Measure</label>
            <select id="itemDetailsUnitMeasure" name="itemDetailsUnitMeasure" class="form-control chosenSelect">
            <?php include ('inc/unitofmeasure.html'); ?>
            </select>
         </div>
         <div class="form-group col-md-2">
            <label for="itemDetailsStatus">Status</label>
            <select id="itemDetailsStatus" name="itemDetailsStatus" class="form-control chosenSelect">
            <?php include ('inc/statusList.html'); ?>
            </select>
         </div>
         <div class="form-group col-md-3">
            <label for="itemDetailsProductID" hidden>Product ID</label>
            <input class="form-control invTooltip" hidden type="number" readonly  id="itemDetailsProductID" name="itemDetailsProductID" title="This will be auto-generated when you add a new item">
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-6">
            <label for="itemDetailsItemName">Item Name<span class="requiredIcon">*</span></label>
            <input type="text" class="form-control" name="itemDetailsItemName" id="itemDetailsItemName" autocomplete="off">
         </div>
         <div class="form-group col-md-3">
            <label for="itemDetailsTotalStock">Total Stock</label>
            <input type="text" class="form-control" name="itemDetailsTotalStock" id="itemDetailsTotalStock" readonly>
         </div>
      </div>
      <div  class="form-row">
         <div class="form-group col-md-6">
            <div class="form-row">
               <div class="form-group col-md-12" style="display:inline-block">
                  <!-- <label for="itemDetailsDescription">Description</label> -->
                  <textarea rows="4" class="form-control" placeholder="Description" name="itemDetailsDescription" id="itemDetailsDescription"></textarea>
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-4">
                  <label for="itemDetailsBuyingPrice">Buying price</label><span class="requiredIcon">*</span></label>
                  <input type="text" class="form-control" value="0" name="itemDetailsBuyingPrice" id="itemDetailsBuyingPrice">
               </div>
               <div class="form-group col-md-4">
                  <label for="itemDetailsSellingPrice">Selling Price<span class="requiredIcon">*</span></label>
                  <input type="text" class="form-control" value="0" name="itemDetailsSellingPrice" id="itemDetailsSellingPrice">
               </div>
               <div class="form-group col-md-4" id="initialQtySec">
                  <label for="itemDetailsInitialQty">Initial Quantity</label>
                  <input type="number" class="form-control" value="0" name="itemDetailsInitialQty" id="itemDetailsInitialQty">
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-4">
                  <label for="itemDetailsWarningQty">Warning Quantity</label>
                  <input type="number" class="form-control" value="0" name="itemDetailsWarningQty" id="itemDetailsWarningQty">
               </div>
               <div class="form-group col-md-4">
                  <label for="itemRaitemDetailsRackNockNo">Rack No</label>
                  <input type="text" class="form-control" name="itemDetailsRackNo" id="itemDetailsRackNo">
               </div>
            </div>
         </div>
         <div class="form-group col-md-6">
            <div class="row">
               <div class="form-group col-md-6">
                  <div id="imageContainer"></div>
               </div>
            </div>
         </div>
      </div>
      <button type="button" id="addItem" class="btn btn-success">Add Item</button>
      <button type="button" id="updateItemDetailsButton" class="btn btn-primary">Update</button>
      <button type="button" id="deleteItem" class="btn btn-danger">Delete</button>
      <button type="reset" class="btn" id="itemClear">Clear</button>
   </form>
</div>
<div id="itemImageTab" class="container-fluid tab-pane fade">
   <br>
   <div id="itemImageMessage"></div>
   <p>You can upload an image for a particular item using this section.</p>
   <p>Please make sure the item is already added to database before uploading the image.</p>
   <br>							
   <form name="imageForm" id="imageForm" method="post">
      <div class="form-row">
         <input id="itemImageProductID"  name="itemImageProductID" class="form-control" type="text" hidden></input>
         <div class="form-group col-md-3" style="display:inline-block">
            <label for="itemImageItemNumber">Item Number<span class="requiredIcon">*</span></label>
            <input type="text" class="form-control" name="itemImageItemNumber" id="itemImageItemNumber" autocomplete="off" readonly>
            <div id="itemImageItemNumberSuggestionsDiv" class="customListDivWidth"></div>
         </div>
         <div class="form-group col-md-4">
            <label for="itemImageItemName">Item Name</label>
            <input type="text" class="form-control" name="itemImageItemName" id="itemImageItemName" autocomplete="off">
         </div>
      </div>
      <br>
      <div class="form-row">
         <div class="form-group col-md-7">
            <label for="itemImageFile">Select Image ( <span class="blueText">jpg</span>, <span class="blueText">jpeg</span>, <span class="blueText">gif</span>, <span class="blueText">png</span> only )</label>
            <input type="file" class="form-control-file btn btn-dark" id="itemImageFile" name="itemImageFile">
         </div>
      </div>
      <br>
      <button type="button" id="updateImageButton" class="btn btn-primary">Upload Image</button>
      <button type="button" id="deleteImageButton" class="btn btn-danger">Delete Image</button>
      <button type="reset" id="clearImageButton"  class="btn">Clear</button>
   </form>
</div>
<div  id="itemListTab" class="container-fluid tab-pane fade active show">
   <!-- Tab panes for reports sections -->
   <div class="tab-content">
      <div id="itemSearchTab" class="container-fluid tab-pane active">
         <br>
         <p>Use the grid below to search all details of items</p>
         <!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
         <div class="table-responsive" id="itemDetailsTableDiv"></div>
      </div>
   </div>
</div>

