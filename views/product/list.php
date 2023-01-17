<?php
require("./controllers/ProductFetchController.php");
$product = new ProductFetchController();
$allProducts = $product->getAllProduct();
?>
<div class="container-fluid">
    <h1>Product List</h1>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-borderd table-striped">
                <thead>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Current Stock</th>
                    <th>Status</th>
                    <th>Added By</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($allProducts as $index => $item){
                    ?>
                    <tr>
                        <td><?php echo $index+1;?></td>
                        <td>
                            <img src="<?php echo $item["product_image"]!=null ? UPLOAD_DIR.''.$item['product_image']:"assets/".DEFAULT_IMAGE;?>" alt="<?php echo $item['product_name'];?>" style="max-height: 60px;">
                        </td>
                        <td><?php echo $item['product_name'];?></td>
                        <td><?php echo $item['product_code'];?></td>
                        <td><?php echo $item['buying_price'];?></td>
                        <td><?php echo $item['selling_price'];?></td>
                        <td><?php echo $item['current_stock'];?></td>
                        <td>
                            <?php
                                if($item['status'] == 'active'){
                                    echo "<span class='badge badge-success badge-pill'>Active</span>";
                                }else{
                                    echo "<span class='badge badge-danger badge-pill'>InActive</span>";
                                }
                            ?>
                        </td>
                        <td><?php echo $item['added_by'];?></td>
                        <td>
                            <a href="<?php echo BASE_URL.'?q=product/edit&id='.$item['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <button onclick="deleteProduct(<?php echo $item['id'];?>)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form action="<?php echo ACTION_ROOT.'/product.php'?>" method="post" id="product_list_delete_form">
    <input type="hidden" name="action" value="product_delete">
    <input type="hidden" name="product_id" id="product_list_product_id" value="">
</form>
