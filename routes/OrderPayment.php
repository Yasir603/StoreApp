<?php
require '../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  if (!isset($_POST['order_uid'])) {
    die('order_uid_missing');
  }

  $query = "SELECT * FROM orders where uid='". $_POST['order_uid'] . "'";

  $result = mysqli_query($conn , $query);

  if (!$result) {
    die('failed_to_run_order_query');
  }
  $orderMeta = [];
  $order =  mysqli_fetch_assoc($result);

  if ($order === null) {
    die('no_order_found_with_this_uid');
  }

    $query = "SELECT * FROM orderproducts where order_uid='". $order['uid'] ."'";

    $res = mysqli_query($conn , $query);

    if (!$res) {
      die('failed_to_run_user_fetch_orders_products_query');
    }

    $orderproductsMeta = [];
    $orderProduct = mysqli_fetch_assoc($res);

      $query = "SELECT * FROM products where p_uid='". $orderProduct['product_uid'] ."'";

      $product = mysqli_query($conn , $query);

      if (!$product) {
        die('failed_to_run_user_fetch_orders_products_query');
      }

      $product = mysqli_fetch_assoc($product);

      $quantity_bought =$orderProduct['quantity'];

      $order_price= $product['sales_price'];

      $bill= $quantity_bought * $order_price;

      $payment= $_REQUEST["amount_paid"];



      $due = $bill - $payment;




      if($order['state'] == 'pending'){
        if($payment == $bill){
          $query = "UPDATE orders
                    SET state = 'paid', Payment_due = '$due', Payment_paid = '$payment'
                    where uid = '". $_POST['order_uid'] . "'";
          $res = mysqli_query($conn, $query);
        }
        else{
        $query = "UPDATE orders
                  SET Payment_due = '$due', Payment_paid = '$payment'
                  where uid = '". $_POST['order_uid'] . "'";
        $res = mysqli_query($conn, $query);
        }
      }
      else{
        die('you_already_paied');
      }


      array_push($orderproductsMeta, [
        'p_uid' => $product['p_uid'],
        'p_name' => $product['p_name'],
        'sales_price' => $product['sales_price'],
        'quantity_bought' => $orderProduct['quantity'],
        'Total_bill' =>   $bill,
        'Payment_paid' => $payment,
        'Payment_due'=>  $due
      ]);

    array_push($orderMeta , [
      'order_uid' => $order['uid'],
      'status' => $order['state'],
      'Date & Time' =>$order['order_dt'],
      'products' => $orderproductsMeta
    ]);




  echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      'data' => $orderMeta
  ]));
  die();




}
?>
