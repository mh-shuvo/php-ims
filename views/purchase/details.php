<?php
if(!array_key_exists('id',$_GET)){
    echo "Invalid URL";
    exit;
}
require './controllers/FetchController.php';
$fetch = new FetchController();
$id = $_GET['id'];
$purchase = $fetch->getSinglePurchase($id);

if($purchase == null){
    echo "Invalid Request";
    exit();
}
?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Purchase Details</h4>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="javascript:void(0)" method="post">
                    <div class="form-group">
                        <label for="purchase_unique_number">Purchase Number</label>
                        <input type="text" readonly class="form-control" value="<?php echo $purchase['purchase_unique_number'];?>">
                    </div>
                    <div class="form-group">
                        <label for="supplier_id">Supplier</label>
                        <input type="text" readonly class="form-control" value="<?php echo $purchase['supplier_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="text" readonly class="form-control" value="<?php echo date('d-m-Y',strtotime($purchase['date']));?>">
                    </div>

                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <input type="text" readonly name="" class="form-control" value="<?php echo $purchase['product_name'];?>">
                    </div>

                    <div class="form-group">
                        <label for="buying_price">Product</label>
                        <input type="text" readonly name="" class="form-control" value="<?php echo $purchase['buying_price'];?>">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" readonly name="" class="form-control" value="<?php echo $purchase['quantity'];?>">
                    </div>

                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="text" readonly name="" class="form-control" value="<?php echo $purchase['total_purchase'];?>">
                    </div>

                    <div class="form-group">
                        <label for="created_at">Purchase Create Date</label>
                        <input type="text" readonly name="" class="form-control" value="<?php echo date('d-m-Y',strtotime($purchase['created_at']));?>">
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <p><?php echo $purchase['note'];?></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>