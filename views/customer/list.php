<?php
    require './controllers/FetchController.php';
    $customerObject = new FetchController();
    $customers = $customerObject->getAllCustomer();
    $search = null;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $search = $_POST['search'];
        $customers = $customerObject->getAllCustomer($_POST['search']);
    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <h5 class="card-title">Customer List</h5>
                            </div>
                            <div class="col-sm-2">
                                <a href="<?php echo BASE_URL.'?q=customer/create';?>" class="btn btn-primary btn-sm float-right">Add new customer</a>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <form action="<?php echo BASE_URL.'/?q=customer/list'?>" method="post">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control float-right" placeholder="write something and hit enter" value="<?php echo $search;?>">
                                    <?php
                                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                                        ?>
                                        <a href="<?php echo BASE_URL.'/?q=customer/list'?>" type="button" class="btn btn-danger">Clear Search</a>
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
                            <th width="40%">Address</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php
                            if($customers != false){
                            foreach ($customers as $index => $customer){
                        ?>
                            <tr>
                                <td><?php echo $index+1;?></td>
                                <td><?php echo $customer['name'];?></td>
                                <td><?php echo $customer['phone'];?></td>
                                <td><?php echo $customer['address'];?></td>
                                <td><?php echo date('d-m-Y',strtotime($customer['created_at']));?></td>
                                <td>
                                <a href="<?php echo BASE_URL.'?q=customer/edit&id='.$customer['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <button onclick="deleteCustomer(<?php echo $customer['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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

<form action="<?php echo ACTION_ROOT.'/customer.php'?>" method="post" id="customer_list_delete_form">
    <input type="hidden" name="action" value="customer_delete">
    <input type="hidden" name="customer_id" id="customer_list_customer_id" value="">
</form>
