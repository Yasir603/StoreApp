<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;

    $extArray = ['doc', 'docx', 'xlsx', 'jpeg', 'jpg', 'png', 'pdf'];

    $fileInfo = pathinfo($_FILES['avatar']['name']);

    $tmp = explode(".", $_FILES['avatar']['name']);

    $size = ($_FILES["avatar"]["size"]/10).'MB';

    $newName = time() . rand(0, 99999) . "." . end($tmp);
    if ($_FILES["avatar"]["size"] > 10485760) {

        echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));
    }
    else {
          if (! move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../data/' . $newName)) {
          echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
          die();
          }
    }


    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
          $username= $_REQUEST["username"];
          $email= $_REQUEST["email"];
          $password= $_REQUEST["password"];
          $address= $_REQUEST["address"];
          $avatar= $_REQUEST["avatar"];
          $block= $_REQUEST["block"];
          $uid = Uuid::uuid4()->toString();

          $reg_users = "INSERT into users (username,email,password,address,user_uid,avatar,block) VALUE ('".$username."','".$email."','".$password."','".$address."','".$uid."','".$newName."','".$block."')";
          $result = mysqli_query($conn, $reg_users);
          if($result> 0){
          echo(json_encode([
            'status' => 'sucess',
            'code' => '200',
            exception => 'User_data__is_submitted'
            ]));
          }
      else{
        echo(json_encode([
            'status' => 'failed',
            'code' => '200',
            exception => 'failed_to_insert_User'
        ]));
      }
    }
?>
