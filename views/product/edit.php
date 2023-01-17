<?php

if(!array_key_exists('id',$_GET)){
    echo "Invalid URL";
    exit;
}
require("./controllers/ProductFetchController.php");
$productObj = new ProductFetchController();

$id = $_GET['id'];
$product = $productObj->getSingleProductById($id) ? ($productObj->getSingleProductById($id))->fetch_assoc() : false;

//if($productObj->getSingleProductById($id)){
//    $data = $productObj->getSingleProductById($id);
//    $product = $data->fetch_assoc();
//}else{
//    $product = false;
//}

if(!$product){
    echo "Invalid Request";
    exit;
}


$product_name_error = array_key_exists('product_name',$validation_errors) ? $validation_errors['product_name']:"";
$product_code_error = array_key_exists('product_code',$validation_errors) ? $validation_errors['product_code']:"";
$buying_price_error = array_key_exists('buying_price',$validation_errors) ? $validation_errors['buying_price']:"";
$selling_price_error = array_key_exists('selling_price',$validation_errors) ? $validation_errors['selling_price']:"";
$status_error = array_key_exists('status',$validation_errors) ? $validation_errors['status']:"";
?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Product Edit</h4>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="<?php echo ACTION_ROOT;?>/product.php" method="post" onSubmit="validateProductCreate()" id="ProductForm">
                    <input type="hidden" name="action" value="product_edit">
                    <input type="hidden" name="product_id" value="<?php echo $product["id"];?>">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product['product_name'];?>">
                        <span style="color:red;"><?php echo $product_name_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code" value="<?php echo $product['product_code'];?>">
                        <span style="color:red;"><?php echo $product_code_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="buying_price">Buying Price</label>
                        <input type="text" class="form-control" name="buying_price" id="buying_price" placeholder="Buying Price"value="<?php echo $product['buying_price'];?>">
                        <span style="color:red;"><?php echo $buying_price_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="selling_price">Selling Price</label>
                        <input type="text" class="form-control" name="selling_price" id="selling_price" placeholder="Selling Price" value="<?php echo $product['selling_price'];?>">
                        <span style="color:red;"><?php echo $selling_price_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="active" <?php echo $product['status'] == 'active' ? 'selected':null; ?>>Active</option>
                            <option value="inactive" <?php echo $product['status'] == 'inactive' ? 'selected':null; ?>>InActive</option>
                        </select>
                        <span style="color:red;"><?php echo $status_error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="product_image">Product Image</label>
                        <input name="product_image" type="file" accept="image/*" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"> <br>
                        <img src="<?php echo $product["product_image"]!=null ? UPLOAD_DIR.''.$product['product_image']:"assets/".DEFAULT_IMAGE;?>" alt="<?php echo $product['product_name'];?>" default_image = "./assets/<?php echo DEFAULT_IMAGE;?>" id="preview" alt="Product Image" style="height:60px; width=60px">
                    </div>
                    <div class="row">
                        <div class="col-6 offset-3">
                            <center>
                                <button type="button" class="btn btn-danger" id="ClearButton">Clear</button>
                                <button type="submit" class="btn btn-success">Upload</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>