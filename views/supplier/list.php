<?php
    require './controllers/SupplierFetchController.php';
    $supplierObject = new SupplierFetchController();
    $suppliers = $supplierObject->getAllSupplier();
    $search = null;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $search = $_POST['search'];
        $suppliers = $supplierObject->getAllSupplier($_POST['search']);
    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <h5 class="card-title">Supplier List</h5>
                            </div>
                            <div class="col-sm-2">
                                <a href="<?php echo BASE_URL.'?q=supplier/create';?>" class="btn btn-primary btn-sm float-right">Add new Supplier</a>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <form action="<?php echo BASE_URL.'/?q=supplier/list'?>" method="post">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control float-right" placeholder="write something and hit enter" value="<?php echo $search;?>">
                                    <?php
                                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                                    ?>
                                    <a href="<?php echo BASE_URL.'/?q=supplier/list'?>" type="button" class="btn btn-danger">Clear Search</a>
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
                            if($suppliers != false){
                            foreach ($suppliers as $index => $supplier){
                        ?>
                            <tr>
                                <td><?php echo $index+1;?></td>
                                <td><?php echo $supplier['name'];?></td>
                                <td><?php echo $supplier['phone'];?></td>
                                <td><?php echo $supplier['address'];?></td>
                                <td><?php echo date('d-m-Y',strtotime($supplier['created_at']));?></td>
                                <td>
                                <a href="<?php echo BASE_URL.'?q=supplier/edit&id='.$supplier['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <button onclick="deleteSupplier(<?php echo $supplier['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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

<form action="<?php echo ACTION_ROOT.'/supplier.php'?>" method="post" id="supplier_list_delete_form">
    <input type="hidden" name="action" value="supplier_delete">
    <input type="hidden" name="supplier_id" id="supplier_list_supplier_id" value="">
</form>
