<?php
require './controllers/FetchController.php';
$fetch = new FetchController();
$allSales = $fetch->getAllSales();

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h5 class="card-title">Sales List</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <thead>
                        <th>#</th>
                        <th>Sales Number</th>
                        <th>Sales Date</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>quantity</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php
                        if($allSales != false){
                            foreach ($allSales as $index => $sale){
                                ?>
                                <tr>
                                    <td><?php echo $index+1;?></td>
                                    <td><?php echo $sale['sales_unique_number'];?></td>
                                    <td><?php echo date('d-m-Y',strtotime($sale['sales_date']));?></td>
                                    <td><?php echo $sale['customer_name'];?></td>
                                    <td><?php echo $sale['product_name'];?></td>
                                    <td><?php echo $sale['quantity'];?></td>
                                    <td><?php echo $sale['total_payble_amount'];?></td>
                                    <td><?php
                                        if($sale['status'] == 'pending'){
                                            echo '<span class="badge bg-danger text-white p-1">Pending</span>';
                                        }else{
                                            echo '<span class="badge bg-success text-white p-1">Completed</span>';
                                        }
                                        ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL.'?q=sales/details&id='.$sale['id'];?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                        <?php
                                        if($sale['status'] == 'pending'){
                                            ?>
                                            <button onclick="statusChangeSales(<?php echo $sale['id'];?>)" type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                            <a href="<?php echo BASE_URL.'?q=sales/edit&id='.$sale['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <button onclick="deleteSales(<?php echo $sale['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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

<form action="<?php echo ACTION_ROOT.'/sales.php'?>" method="post" id="sales_delete_form">
    <input type="hidden" name="action" value="sales_delete">
    <input type="hidden" name="sales_id" id="sales_id" value="">
</form>

<form action="<?php echo ACTION_ROOT.'/sales.php'?>" method="post" id="sales_status_change">
    <input type="hidden" name="action" value="sales_status_change">
    <input type="hidden" name="sales_id" id="sales_status_change_sales_id" value="">
</form>

<script>
    function statusChangeSales(id) {

        let isConfirm = confirm("Do really want to change status?");
        if(isConfirm){
            document.getElementById("sales_status_change_sales_id").value = id;
            document.getElementById("sales_status_change").submit();
        }
    }
    function deleteSales(id) {
        let isConfirm = confirm("Are you sure?");
        if(isConfirm){
            document.getElementById("sales_id").value = id;
            document.getElementById("sales_delete_form").submit();
        }
    }
</script>