<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
      $extArray = ['doc', 'docx', 'xlsx', 'jpeg', 'jpg', 'png', 'pdf'];

      $fileInfo = pathinfo($_FILES['image']['name']);

      $tmp = explode(".", $_FILES['image']['name']);

      $size = ($_FILES["image"]["size"]/10).'MB';

      $newName = time() . rand(0, 99999) . "." . end($tmp);
      if ($_FILES["image"]["size"] > 10485760) {
          echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));

      }
      else {
          if (! move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../data/' . $newName)) {
          echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
          die();
          }

      }


      if ($_SERVER["REQUEST_METHOD"] === 'POST') {

          $p_name= $_REQUEST["p_name"];
          $quantity= $_REQUEST["quantity"];
          $pieces= $_REQUEST["pieces"];
          $sales_price= $_REQUEST["sales_price"];
          $purchase_price= $_REQUEST["purchase_price"];
          $vendor_name= $_REQUEST["vendor_name"];
          $p_uid = Uuid::uuid4()->toString();

          $queryproduct = "INSERT into products (p_uid,p_name,quantity,pieces,sales_price,purchase_price,vendor_name,image) VALUE ('".$p_uid."','".$p_name."','".$quantity."','".$pieces."','".$sales_price."','".$purchase_price."','".$vendor_name."','".$newName."')";
          $result = mysqli_query($conn, $queryproduct);
          if($result> 0){
                echo(json_encode([
                    'status' => 'sucess',
                    'code' => '200',
                    exception => 'product_data__is_submitted'
                ]));
          }
           else{
                echo(json_encode([
                   'status' => 'failed',
                   'code' => '200',
                    exception => 'failed_to_insert_product'
                ]));
           }
      }
?>
