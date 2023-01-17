<?php
require './controllers/FetchController.php';
$id = $_GET['id'];
$customerObject = new FetchController();
$customer = $customerObject->getSingleCustomerById($id) ? $customerObject->getSingleCustomerById($id)->fetch_assoc() : null;

if($customer == null){
    echo "Invalid Request";
    exit();
}

$name_error = array_key_exists('name',$validation_errors) ? $validation_errors['name']:"";
$phone_error = array_key_exists('phone',$validation_errors) ? $validation_errors['phone']:"";
$address_error = array_key_exists('address',$validation_errors) ? $validation_errors['address']:"";

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">Edit Customer Information</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo ACTION_ROOT.'/customer.php'?>" method="post">
                        <input type="hidden" name="action" value="customer_edit">
                        <input type="hidden" name="id" value="<?php echo $customer['id'];?>">
                        <div class="form-group">
                            <label for="name">Customer Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ex: Akash" value="<?php echo array_key_exists('name',$oldValue) ? $oldValue["name"]:$customer['name'];?>">
                            <span class="text-danger"><?php echo $name_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Customer Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="ex: +8801XXXXXXXXXXX" min="11" max="14" value="<?php echo array_key_exists('phone',$oldValue) ? $oldValue["phone"]:$customer['phone'];?>">
                            <span class="text-danger"><?php echo $phone_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Customer Address</label>
                            <textarea type="text" name="address" id="address" class="form-control" placeholder="Dhaka, Bangladesh"><?php echo array_key_exists('address',$oldValue) ? $oldValue["address"]:$customer['address'];?></textarea>
                            <span class="text-danger"><?php echo $address_error;?></span>
                        </div>
                        <center>
                            <a href="<?php echo BASE_URL.'?q=customer/list';?>" class="btn btn-danger btn-sm">Cancel</a>
                            <button class="btn btn-success btn-sm" type="submit">Save</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
