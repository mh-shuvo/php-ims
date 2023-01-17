<?php
require './controllers/FetchController.php';
$fetch = new FetchController();
$customers = $fetch->getAllCustomer();
$allProducts = $fetch->getAllProduct();

$customer_id_error = array_key_exists('customer_id',$validation_errors) ? $validation_errors['customer_id']:"";
$sales_date_error = array_key_exists('sales_date',$validation_errors) ? $validation_errors['sales_date']:"";
$product_id_error = array_key_exists('product_id',$validation_errors) ? $validation_errors['product_id']:"";
$quantity_error = array_key_exists('quantity',$validation_errors) ? $validation_errors['quantity']:"";
$status_error = array_key_exists('status',$validation_errors) ? $validation_errors['status']:"";
$payment_type_error = array_key_exists('payment_type',$validation_errors) ? $validation_errors['payment_type']:"";
$transaction_id_error = array_key_exists('transaction_id',$validation_errors) ? $validation_errors['transaction_id']:"";

?>

<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">New Sales</h4>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="<?php echo ACTION_ROOT;?>/sales.php" method="post">
                    <input type="hidden" name="action" value="sales_create">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">Select one</option>
                                    <?php
                                    foreach ($customers as $customer){
                                        ?>
                                        <option <?php echo (array_key_exists('customer_id',$oldValue) && $oldValue['customer_id'] == $customer['id']) ?"selected":null;?> value="<?php echo $customer['id'];?>"><?php echo $customer['name'];?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?php echo $customer_id_error;?></span>
                            </div>

                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select name="product_id" id="product_id" onchange="productChangeEvent()" class="form-control">
                                    <option value="">Select one</option>
                                    <?php
                                    foreach ($allProducts as $product){
                                        ?>
                                        <option
                                            <?php echo (array_key_exists('product_id',$oldValue) && $oldValue['product_id'] == $product['id']) ?"selected":null;?> value="<?php echo $product['id'];?>"
                                            sales_price="<?php echo $product['selling_price'];?>"
                                            current_stock="<?php echo $product['current_stock'];?>"
                                            ><?php echo $product['product_name'].'('.$product['current_stock'].')';?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?php echo $product_id_error;?></span>
                            </div>

                            <div class="form-group">
                                <label for="sales_price">Unit Price</label>
                                <input type="text" class="form-control" id="unit_price" name="unit_price" readonly value="<?php echo array_key_exists('unit_price',$oldValue) ? $oldValue["unit_price"]:null; ?>">
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountOnKeyUp()" value="<?php echo array_key_exists('discount',$oldValue) ? $oldValue["discount"]:null; ?>">
                            </div>

                            <div class="form-group">
                                <label for="payment_type">Payment Type</label>
                                <select name="payment_type" id="payment_type" class="form-control" onchange="paymentTypeChangeEvent()">
                                    <option value="">Select One</option>
                                    <option value="cod" <?php echo array_key_exists('status',$oldValue) && $oldValue['status'] =='cod' ? "selected":null; ?>>COD</option>
                                    <option value="online" <?php echo array_key_exists('payment_type',$oldValue) && $oldValue['status'] =='online' ? "selected":null; ?>>Online</option>
                                </select>
                                <span class="text-danger"><?php echo $payment_type_error;?></span>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="sales_date">Sales Date</label>
                                <input name="sales_date" type="date" id="sales_date" class="form-control" value="<?php echo array_key_exists('sales_date',$oldValue) ? $oldValue["sales_date"]:null;?>"/>
                                <span class="text-danger"><?php echo $sales_date_error;?></span>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input name="quantity" onkeyup="quantityChangeEvent(this)" type="number" id="quantity" placeholder="EX:5" class="form-control" value="<?php echo array_key_exists('quantity',$oldValue) ? $oldValue["quantity"]:null;?>"/>
                                <span class="text-danger"><?php echo $quantity_error;?></span>
                            </div>

                            <div class="form-group">
                                <label for="subtotal">Sub Total</label>
                                <input type="text" class="form-control" name="subtotal" id="subtotal" readonly value="<?php echo array_key_exists('subtotal',$oldValue) ? $oldValue["subtotal"]:null; ?>">
                            </div>

                            <div class="form-group">
                                <label for="total_payable_amount">Total Payable</label>
                                <input type="text" class="form-control" name="total_payable_amount" id="total_payable_amount" readonly value="<?php echo array_key_exists('total_payable_amount',$oldValue) ? $oldValue["total_payable_amount"]:null; ?>">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="pending" <?php echo array_key_exists('status',$oldValue) && $oldValue['status'] =='pending' ? "selected":null; ?>>Pending</option>
                                    <option value="completed" <?php echo array_key_exists('status',$oldValue) && $oldValue['status'] =='completed' ? "selected":null; ?>>Completed</option>
                                </select>
                                <span class="text-danger"><?php echo $status_error;?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group <?php echo array_key_exists('payment_type',$oldValue) && $oldValue['payment_type'] =='online'? "":"d-none"; ?>" id="transaction_id_div">
                        <label for="transaction_id">Transaction No</label>
                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" value="<?php echo array_key_exists('transaction_id',$oldValue) ? $oldValue["transaction_id"]:null; ?>">
                        <span class="text-danger"><?php echo $transaction_id_error;?></span>
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" placeholder="write something about sales" id="note" cols="30" rows="10" class="form-control"><?php echo array_key_exists('note',$oldValue) ? $oldValue["note"]:null;?></textarea>
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

<script>
    function productChangeEvent() {
        calculate()
    }
    
    function quantityChangeEvent(el) {
        let currentStock = document.querySelector("#product_id").selectedOptions[0].getAttribute('current_stock') || null //raw JS;
        if(currentStock == null){
            $(el).val("");
            alert("Please select product");
            return false
        }
        let qty = $(el).val()

        if(parseInt(qty) > parseInt(currentStock)){
            $(el).val("");
            alert("Stock Exceded");
            return false
        }

        calculate()
    }
    function discountOnKeyUp() {
        calculate()
    }

    function calculate() {
        let salePrice = $("#product_id").find(':selected').attr('sales_price'); // Jquery
        let discount = parseFloat($("#discount").val()) || 0
        let qty = parseInt($("#quantity").val()) || 0

        $("#unit_price").val(salePrice);

        let subtotal = salePrice * qty

        $("#subtotal").val(subtotal)

        let total_payable = subtotal - discount;
        $("#total_payable_amount").val(total_payable)
    }

    function paymentTypeChangeEvent(){
        let type = $("#payment_type").val() || null
        if(type == "online"){
            $("#transaction_id_div").removeClass("d-none")
        }else{
            $("#transaction_id_div").addClass("d-none")
        }
    }
</script>