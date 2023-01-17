<?php
if(!array_key_exists('id',$_GET)){
    echo "Invalid URL";
    exit;
}
$id = $_GET['id'];
require './controllers/FetchController.php';
$fetch = new FetchController();
$user = $fetch->getSingleUserById($id);

if($user == null){
    echo "Invalid Request";
    exit();
}

$name_error = array_key_exists('name',$validation_errors) ? $validation_errors['name']:"";
$phone_error = array_key_exists('phone',$validation_errors) ? $validation_errors['phone']:"";
$email_error = array_key_exists('email',$validation_errors) ? $validation_errors['email']:"";
$password_error = array_key_exists('password',$validation_errors) ? $validation_errors['password']:"";
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">Update User Information</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo ACTION_ROOT.'/user.php'?>" method="post">
                        <input type="hidden" name="action" value="user_edit">
                        <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ex: Akash" value="<?php echo array_key_exists('name',$oldValue) ? $oldValue["name"]:$user['name'];?>">
                            <span class="text-danger"><?php echo $name_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="ex: +8801XXXXXXXXXXX" min="11" max="14" value="<?php echo array_key_exists('phone',$oldValue) ? $oldValue["phone"]:$user['phone'];?>">
                            <span class="text-danger"><?php echo $phone_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="ex: shuvo@shop.com" value="<?php echo array_key_exists('email',$oldValue) ? $oldValue["email"]:$user['email'];?>">
                            <span class="text-danger"><?php echo $email_error;?></span>
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