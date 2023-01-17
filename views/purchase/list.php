<?php
require './controllers/FetchController.php';
$fetch = new FetchController();
$allPurchases = $fetch->getAllPurchase();

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h5 class="card-title">Purchase List</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <thead>
                        <th>#</th>
                        <th>Purchase Number</th>
                        <th>Purchase Date</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>quantity</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php
                        if($allPurchases != false){
                            foreach ($allPurchases as $index => $purchase){
                                ?>
                                <tr>
                                    <td><?php echo $index+1;?></td>
                                    <td><?php echo $purchase['purchase_unique_number'];?></td>
                                    <td><?php echo date('d-m-Y',strtotime($purchase['date']));?></td>
                                    <td><?php echo $purchase['supplier_name'];?></td>
                                    <td><?php echo $purchase['product_name'];?></td>
                                    <td><?php echo $purchase['quantity'];?></td>
                                    <td><?php echo $purchase['total_purchase'];?></td>
                                    <td><?php
                                            if($purchase['status'] == 'pending'){
                                                echo '<span class="badge bg-danger text-white p-1">Pending</span>';
                                            }else{
                                                echo '<span class="badge bg-success text-white p-1">Completed</span>';
                                            }
                                        ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL.'?q=purchase/details&id='.$purchase['id'];?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                        <?php
                                            if($purchase['status'] == 'pending'){
                                        ?>
                                        <button onclick="statusChangePurchase(<?php echo $purchase['id'];?>)" type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                        <a href="<?php echo BASE_URL.'?q=purchase/edit&id='.$purchase['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button onclick="deletePurchase(<?php echo $purchase['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                         <?php
                                            }
                                            ?>
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

<form action="<?php echo ACTION_ROOT.'/purchase.php'?>" method="post" id="purchase_list_delete_form">
    <input type="hidden" name="action" value="purchase_delete">
    <input type="hidden" name="purchase_id" id="purchase_list_purchase_id" value="">
</form>

<form action="<?php echo ACTION_ROOT.'/purchase.php'?>" method="post" id="purchase_list_status_form">
    <input type="hidden" name="action" value="purchase_status_change">
    <input type="hidden" name="purchase_id" id="purchase_status_form_purchase_list_purchase_id" value="">
</form>
