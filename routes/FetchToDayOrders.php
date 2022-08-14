<?php
require '../config/conn.php';
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

      // $now = Carbon::now();
      //
      // $date_arr = explode(" ", $now);
      // $date = $date_arr[0];
      // $time = $date_arr[1];

      $query  = "SELECT * FROM orders";
      $result  =  mysqli_query($conn,$query);

      if (!$result) {
        die('failed_to_run_fetch_today_orders_query');
      }
     $orderMeta = [];
     while($order  =  mysqli_fetch_assoc($result)){

           // $date_arr= explode(" ", $order["order_dt"]);
           // $date1 = $date_arr[0];
           // $time1 = $date_arr[1];

           $orderDate = new Carbon($order["order_dt"]);

          if ($orderDate->isCurrentDay()) {

          array_push($orderMeta , [
            'order_uid' => $order['uid'],
            'status' => $order['state'],
            'Date & Time' =>$order['order_dt'],
          ]);

          }
    }
    echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      'data' => $orderMeta
    ]));
    die();
}


?>
