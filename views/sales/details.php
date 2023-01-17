<?php
if(!array_key_exists('id',$_GET)){
    echo "Invalid URL";
    exit;
}
$id = $_GET['id'];
require './controllers/FetchController.php';
$fetch = new FetchController();
$sales = $fetch->getSingleSalesById($id);

if(!$sales){
    echo "No sales data found.";
    exit;
}

?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Sales Details - <?php echo $sales['sales_unique_number'];?></h4>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['customer_name'];?>">
                            </div>

                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['product_name'];?>">
                            </div>

                            <div class="form-group">
                                <label for="sales_price">Unit Price</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['unit_price'];?>">
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['discount'];?>">
                            </div>

                            <div class="form-group">
                                <label for="payment_type">Payment Type</label>
                                <input type="text" readonly class="form-control" value="<?php echo strtoupper($sales['payment_type']);?>">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="sales_date">Sales Date</label>
                                <input type="text" readonly class="form-control" value="<?php echo date('d-m-Y',strtotime($sales['sales_date']));?>">
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['quantity'];?>">
                            </div>

                            <div class="form-group">
                                <label for="subtotal">Sub Total</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['subtotal'];?>">
                            </div>

                            <div class="form-group">
                                <label for="total_payable_amount">Total Payable</label>
                                <input type="text" readonly class="form-control" value="<?php echo $sales['total_payble_amount'];?>">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" readonly class="form-control" value="<?php echo ucfirst($sales['status']);?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="transaction_id_div">
                        <label for="transaction_id">Transaction No</label>
                        <input type="text" readonly class="form-control" value="<?php echo $sales['transaction_id'];?>">
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label> <br>
                        <?php echo $sales['note'];?>
                    </div>
            </div>
        </div>
    </div>
</div>