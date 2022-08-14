<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST'){

    $order_uid = Uuid::uuid4()->toString();
    $data= $_REQUEST["request_data"];

    $data = json_decode($data , true);
    foreach ($data['products'] as $product) {
        $uid = Uuid::uuid4()->toString();
      if (!isset($_POST['p_uid'])) {
        die('product_uid_misising');
      }
      $query = "SELECT * FROM products where p_uid ='" . $product['product_uid'] . "'";
      $result = mysqli_query($conn,$query);

      if ($result) {
          $row = mysqli_fetch_assoc($result);

          if ($row == null) {
            die( 'product not found');
          }
      }


      if($row['quantity'] <= $product['quantity']){
       die( 'product quantity is less');
      }
      else{
        $query = "INSERT into orderproducts (uid,order_uid,product_uid,quantity) VALUE ('".$uid."','".$order_uid."','".$product['product_uid']."','".$product['quantity']."')";
        $result = mysqli_query($conn, $query);
        if(!$result){
          echo(json_encode([
              'status' => 'failed',
              'code' => '200',
               exception => 'failed_to_insert_orderproducts'
          ]));
          die();
         }



      }

    }



    $user = $data['user_uid'];
    $now = Carbon::now();
    $query = "INSERT into orders (uid,user_uid,state,order_dt) VALUE ('".$order_uid."','".$user."','pending','".$now."')";
    $result = mysqli_query($conn, $query);
    if($result> 0){
          echo(json_encode([
               'status' => 'sucess',
               'code' => '200',
                exception => 'order_data__is_submitted'
          ]));
     }
     else{
          echo(json_encode([
              'status' => 'failed',
              'code' => '200',
               exception => 'failed_to_insert_order'
          ]));
     }


   }

 ?>
