function deleteProduct(id){
    let isConfirm = confirm("Are you sure?");
    if(isConfirm){
        document.getElementById("product_list_product_id").value = id;
        document.getElementById("product_list_delete_form").submit();
    }
}
function deleteSupplier(id){
    let isConfirm = confirm("Are you sure?");
    if(isConfirm){
        document.getElementById("supplier_list_supplier_id").value = id;
        document.getElementById("supplier_list_delete_form").submit();
    }
}
function deleteCustomer(id){
    let isConfirm = confirm("Are you sure?");
    if(isConfirm){
        document.getElementById("customer_list_customer_id").value = id;
        document.getElementById("customer_list_delete_form").submit();
    }
}
function deletePurchase(id){
    let isConfirm = confirm("Are you sure?");
    if(isConfirm){
        document.getElementById("purchase_list_purchase_id").value = id;
        document.getElementById("purchase_list_delete_form").submit();
    }
}
function statusChangePurchase(id){
    let isConfirm = confirm("Are you sure?");
    if(isConfirm){
        document.getElementById("purchase_status_form_purchase_list_purchase_id").value = id;
        document.getElementById("purchase_list_status_form").submit();
    }
}
if(document.getElementById("ClearButton")){
    document.getElementById("ClearButton").addEventListener("click",function(){
        document.getElementById("ProductForm").reset();
        let defaultImage = document.getElementById("preview").getAttribute("default_image");
        document.getElementById("preview").src = defaultImage;
    });
}
function validateProductCreate(){
    return true;
}
