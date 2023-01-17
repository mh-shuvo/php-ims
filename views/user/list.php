<?php
require './controllers/FetchController.php';
$fetch = new FetchController();
$users = $fetch->getAllUser();
$search = null;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $search = $_POST['search'];
    $users = $fetch->getAllUser($search);
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h5 class="card-title">User List</h5>
                        </div>
                        <div class="col-sm-2">
                            <a href="<?php echo BASE_URL.'?q=user/create';?>" class="btn btn-primary btn-sm float-right">Add New User</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <form action="<?php echo BASE_URL.'/?q=user/list'?>" method="post">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control float-right" placeholder="write something and hit enter" value="<?php echo $search;?>">
                                    <?php
                                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                                        ?>
                                        <a href="<?php echo BASE_URL.'/?q=user/list'?>" type="button" class="btn btn-danger">Clear Search</a>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-borderd">
                        <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php
                        if($users != false){
                            foreach ($users as $index => $user){
                                ?>
                                <tr>
                                    <td><?php echo $index+1;?></td>
                                    <td><?php echo $user['name'];?></td>
                                    <td><?php echo $user['phone'];?></td>
                                    <td><?php echo $user['email'];?></td>
                                    <td><?php echo date('d-m-Y',strtotime($user['created_at']));?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL.'?q=user/edit&id='.$user['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button onclick="deleteUser(<?php echo $user['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo ACTION_ROOT.'/user.php'?>" method="post" id="user_list_delete_form">
    <input type="hidden" name="action" value="user_delete">
    <input type="hidden" name="user_id" id="user_list_supplier_id" value="">
</form>

<script>
    function deleteUser(id){
        let isConfirm = confirm("Are you sure?");
        if(isConfirm){
            document.getElementById("user_list_supplier_id").value = id;
            document.getElementById("user_list_delete_form").submit();
        }
    }
</script>
