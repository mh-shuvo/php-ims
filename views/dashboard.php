<?php
    require("./controllers/FetchController.php");
    $fetch = new FetchController();
    $data = $fetch->dashboardData();
?>
<h3 class="text-muted">Welcome back to login: <span class="text-success"><?php echo $currentUser['name'];?></span></h3>
<hr>
<div class="row">
    <div class="col-3">
        <div class="card bg-info mb-3">
            <div class="card-body text-center text-white">
                <h4>Today Sales</h4>
                <h4>৳<?php echo $data['today_sales'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-info mb-3">
            <div class="card-body text-center text-white">
                <h4>Today Purchase</h4>
                <h4>৳<?php echo $data['today_purchase'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Customer</h4>
                <h4><?php echo $data['total_customer'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Supplier</h4>
                <h4><?php echo $data['total_supplier'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-info mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Product</h4>
                <h4><?php echo $data['total_product'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-primary mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Purchase</h4>
                <h4>৳<?php echo $data['total_purchase'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-danger mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Pending Purchase</h4>
                <h4>৳<?php echo $data['total_pending_purchase'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Completed Purchase</h4>
                <h4>৳<?php echo $data['total_completed_purchase'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Sales</h4>
                <h4>৳<?php echo $data['total_sales'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-danger mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Pending Sales</h4>
                <h4>৳<?php echo $data['total_pending_sales'];?></h4>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card bg-success mb-3">
            <div class="card-body text-center text-white">
                <h4>Total Completed Sales</h4>
                <h4>৳<?php echo $data['total_completed_sales'];?></h4>
            </div>
        </div>
    </div>
</div>

                