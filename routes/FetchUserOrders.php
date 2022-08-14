<?php
require '../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  $userUid = $_POST['user_uid'];

  if (!isset($_POST['user_uid'])) {
    die('user_uid_missing');
  }

  $query = "SELECT * FROM users where user_uid='". $_POST['user_uid'] . "'";

  $result = mysqli_query($conn , $query);

  if (!$result) {
    die('failed_to_run_user_query');
  }

  $user =  mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found_with_this_uid');
  }

  $query = "SELECT * FROM orders where user_uid='". $user['user_uid'] ."'";

  $result = mysqli_query($conn , $query);

  if (!$result) {
    die('failed_to_run_user_fetch_orders_query');
  }

  $orderMeta = [];

  while ($order = mysqli_fetch_assoc($result)) {

    $query = "SELECT * FROM orderproducts where order_uid='". $order['uid'] ."'";

    $res = mysqli_query($conn , $query);

    if (!$res) {
      die('failed_to_run_user_fetch_orders_products_query');
    }

    $orderproductsMeta = [];

    while ($orderProduct = mysqli_fetch_assoc($res)) {

      $query = "SELECT * FROM products where p_uid='". $orderProduct['product_uid'] ."'";

      $product = mysqli_query($conn , $query);

      if (!$product) {
        die('failed_to_run_user_fetch_orders_products_query');
      }

      $product = mysqli_fetch_assoc($product);

      $quantity_bought =$orderProduct['quantity'];
      $order_price= $product['sales_price'];
      $bill= $quantity_bought * $order_price;


      array_push($orderproductsMeta, [
        'p_uid' => $product['p_uid'],
        'p_name' => $product['p_name'],
        'quantity' => $product['quantity'],
        'pieces' => $product['pieces'],
        'sales_price' => $product['sales_price'],
        'purchase_price' => $product['purchase_price'],
        'veodor_name' => $product['vendor_name'],
        'image' => $product['image'],
        'quantity_bought' => $orderProduct['quantity'],
        'Total_bill' =>   $bill
      ]);

    }

    array_push($orderMeta , [
      'order_uid' => $order['uid'],
      'status' => $order['state'],
      'Date & Time' =>$order['order_dt'],
      'products' => $orderproductsMeta
    ]);

  }


  echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      'data' => $orderMeta
  ]));
  die();
}


?>
