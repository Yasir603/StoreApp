<?php
require '../config/conn.php';
     $query="SELECT * FROM products";
     $result = mysqli_query($conn,$query);
     $products = [];
   while ($row = mysqli_fetch_assoc($result)) {

       array_push($products, [


           'p_uid' => $row['p_uid'],
           'p_name' => $row['p_name'],
           'quantity' => $row['quantity'],
           'pieces' => $row['pieces'],
           'sales_price' => $row['sales_price'],
           'purchase_price' => $row['purchase_price'],
           'veodor_name' => $row['vendor_name'],
           'image' => $row['image']
       ]);

   }

      echo(json_encode([
          'status' => 'SUCCESS',
          'code' => '200',
          'data' => $products
      ]));
   die();
?>
