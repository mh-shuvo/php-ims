<?php
$emailError = array_key_exists('email',$validation_errors) ? $validation_errors['email']:"";
$phoneError = array_key_exists('phone',$validation_errors) ? $validation_errors['phone']:"";
$nameError = array_key_exists('name',$validation_errors) ? $validation_errors['name']:"";
?>
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <div class="card">
            <div class="card-header">
                <p class="text-custom card-title">Profile Update</p>
            </div>
            <div class="card-body">
                    <form action="<?php echo ACTION_ROOT;?>/auth.php" method="post">
                        <input type="hidden" name="action" value="profile_update">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $currentUser['name']; ?>">
                            <span class="text-danger"><?php echo $nameError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $currentUser['phone'];   ?>">
                            <span class="text-danger"><?php echo $phoneError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $currentUser['email'];  ?>">
                            <span class="text-danger"><?php echo $emailError;?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>