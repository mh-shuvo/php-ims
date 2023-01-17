<?php
if(!array_key_exists('id',$_GET)){
    echo "Invalid URL";
    exit;
}
require './controllers/FetchController.php';
$fetch = new FetchController();
$suppliers = $fetch->getAllSupplier();
$allProducts = $fetch->getAllProduct();

$id = $_GET['id'];
$purchase = $fetch->getPendingSinglePurchase($id);
if(empty($purchase)){
    echo "404 Not Found";
    exit;
}

$supplier_id_error = array_key_exists('supplier_id',$validation_errors) ? $validation_errors['supplier_id']:"";
$purchase_date_error = array_key_exists('purchase_date',$validation_errors) ? $validation_errors['purchase_date']:"";
$product_id_error = array_key_exists('product_id',$validation_errors) ? $validation_errors['product_id']:"";
$quantity_error = array_key_exists('quantity',$validation_errors) ? $validation_errors['quantity']:"";
$status_error = array_key_exists('status',$validation_errors) ? $validation_errors['status']:"";
?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Purchase</h4>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="<?php echo ACTION_ROOT;?>/purchase.php" method="post">
                    <input type="hidden" name="action" value="purchase_edit">
                    <input type="hidden" name="purchase_id" value="<?php echo $purchase['id'];?>">
                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">Select one</option>
                            <?php
                            foreach ($suppliers as $supplier){
                                ?>
                                <option
                                    <?php echo (array_key_exists('supplier_id',$oldValue) && $oldValue['supplier_id'] == $supplier['id']) ? "selected":($purchase['supplier_id']==$supplier['id']?"selected":null);?> value="<?php echo $supplier['id'];?>"><?php echo $supplier['name'];?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo $supplier_id_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="purchase_date">Purchase</label>
                        <input name="purchase_date" type="date" id="purchase_date" class="form-control" value="<?php echo array_key_exists('purchase_date',$oldValue) ? $oldValue["purchase_date"]:date('Y-m-d',strtotime($purchase['date']));?>"/>
                        <span class="text-danger"><?php echo $purchase_date_error;?></span>
                    </div>

                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control">
                            <option value="">Select one</option>
                            <?php
                            foreach ($allProducts as $product){
                                ?>
                                <option <?php echo (array_key_exists('product_id',$oldValue) && $oldValue['supplier_id'] == $product['id']) ?"selected":($purchase['product_id']==$product['id']?"selected":null);?> value="<?php echo $product['id'];?>"><?php echo $product['product_name'];?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo $product_id_error;?></span>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input name="quantity" type="text" id="quantity" placeholder="EX:5" class="form-control" value="<?php echo array_key_exists('quantity',$oldValue) ? $oldValue["quantity"]:$purchase['quantity'];?>"/>
                        <span class="text-danger"><?php echo $quantity_error;?></span>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select One</option>
                            <option <?php echo (array_key_exists('status',$oldValue) && $oldValue['status'] =='pending') ?"selected":($purchase['status']=='pending'?"selected":null);?> value="pending">Pending</option>
                            <option <?php echo (array_key_exists('status',$oldValue) && $oldValue['status'] =='completed') ?"selected":($purchase['status']=='completed'?"selected":null);?> value="completed">Completed</option>
                        </select>
                        <span class="text-danger"><?php echo $status_error;?></span>
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" placeholder="write something about purchase" id="note" cols="30" rows="10" class="form-control"><?php echo array_key_exists('note',$oldValue) ? $oldValue["note"]:$purchase['note'];?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6 offset-3">
                            <center>
                                <button type="button" class="btn btn-danger" id="ClearButton">Clear</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>