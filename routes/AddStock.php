<?php

require '../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $p_name= $_REQUEST["p_name"];
    $quantity= $_REQUEST["quantity"];
    $pieces= $_REQUEST["pieces"];
    $vendor_name= $_REQUEST["vendor_name"];
    $sales_price= $_REQUEST["sales_price"];


    if (!isset($_POST['p_uid'])) {
      die('misising');
    }
    $query = "SELECT * FROM products where p_uid ='" . $_POST['p_uid'] . "'";

    $result = mysqli_query($conn,$query);

    if (!result) {
      die('no product found');
    }

    $product = mysqli_fetch_assoc($result);
    $query = "UPDATE products
              SET p_name = '$_POST[p_name]', quantity= '$_POST[quantity]', pieces= '$_POST[pieces]', vendor_name= '$_POST[vendor_name]'
              WHERE  p_uid= '" .$product["p_uid"]. "'";
    $result = mysqli_query($conn, $query);
    if($result> 0){
          echo(json_encode([
              'status' => 'sucess',
              'code' => '200',
              exception => 'product_data_is_updated'
          ]));
    }
     else{
          echo(json_encode([
             'status' => 'failed',
             'code' => '200',
              exception => 'failed_to_update_product'
          ]));
     }
}
?>
