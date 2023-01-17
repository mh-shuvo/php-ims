<?php
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
                            <h5 class="card-title">Add New Supplier</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo ACTION_ROOT.'/supplier.php'?>" method="post">
                        <input type="hidden" name="action" value="supplier_create">
                        <div class="form-group">
                            <label for="name">Supplier Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ex: Akash" value="<?php echo array_key_exists('name',$oldValue) ? $oldValue["name"]:null;?>">
                            <span class="text-danger"><?php echo $name_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Supplier Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="ex: +8801XXXXXXXXXXX" min="11" max="14" value="<?php echo array_key_exists('phone',$oldValue) ? $oldValue["phone"]:null;?>">
                            <span class="text-danger"><?php echo $phone_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Supplier Address</label>
                            <textarea type="text" name="address" id="address" class="form-control" placeholder="Dhaka, Bangladesh"><?php echo array_key_exists('address',$oldValue) ? $oldValue["address"]:null;?></textarea>
                            <span class="text-danger"><?php echo $address_error;?></span>
                        </div>
                        <center>
                            <button class="btn btn-danger btn-sm" type="reset">Clear/Reset</button>
                            <button class="btn btn-success btn-sm" type="submit">Save</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>