<?php
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
                            <h5 class="card-title">Add New User</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo ACTION_ROOT.'/user.php'?>" method="post">
                        <input type="hidden" name="action" value="user_create">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="ex: Akash" value="<?php echo array_key_exists('name',$oldValue) ? $oldValue["name"]:null;?>">
                            <span class="text-danger"><?php echo $name_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="ex: +8801XXXXXXXXXXX" min="11" max="14" value="<?php echo array_key_exists('phone',$oldValue) ? $oldValue["phone"]:null;?>">
                            <span class="text-danger"><?php echo $phone_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="ex: shuvo@shop.com" value="<?php echo array_key_exists('email',$oldValue) ? $oldValue["email"]:null;?>">
                            <span class="text-danger"><?php echo $email_error;?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter you password" value="<?php echo array_key_exists('password',$oldValue) ? $oldValue["password"]:null;?>">
                            <span class="text-danger"><?php echo $password_error;?></span>
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