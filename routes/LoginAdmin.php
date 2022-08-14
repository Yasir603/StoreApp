<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
  if ($_SERVER["REQUEST_METHOD"] === 'POST'){
    $extArray = ['doc', 'docx', 'xlsx', 'jpeg', 'jpg', 'png', 'pdf'];

    $fileInfo = pathinfo($_FILES['avatar']['name']);

    $tmp = explode(".", $_FILES['avatar']['name']);

    $size = ($_FILES["avatar"]["size"]/10).'MB';

    $newName = time() . rand(0, 99999) . "." . end($tmp);
    if ($_FILES["avatar"]["size"] > 10485760) {

        echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));
    }
    else {
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../data/' . $newName)) {
              echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
              die();
            }
    }

    if(!isset($_POST["email"])){
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'email_feild_is_required'
            ]));
            die();
    }

    if(!isset($_POST["password"])){
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'password_feild_is_required'
            ]));
            die();
    }

          $email= $_REQUEST["email"];
          $password= $_REQUEST["password"];

          $uid = Uuid::uuid4()->toString();


          $queryAdmin = "SELECT count(*) as cntAdmin FROM admin";
          $res = mysqli_query($conn, $queryAdmin);
          $row = mysqli_fetch_array($res);

          $count = $row['cntAdmin'];

    if($count == 0){
          $loginAdmin = "INSERT into admin (email,password,admin_uid,avatar) VALUE ('".$email."','".$password."','".$uid."','".$newName."')";
          $result = mysqli_query($conn, $loginAdmin);
           if (!$result) {
                echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'failed_to_insert_Admin'
                ]));

           }
               echo(json_encode([
               'status' => 'sucess',
               'code' => '200',
                exception => 'Admin_data__is_submitted'
                ]));
    }


    else{
        $queryLogin = "SELECT * FROM admin WHERE email = '".$email."'";
        $res1 = mysqli_query($conn, $queryLogin);
        if(($row = mysqli_fetch_assoc($res1))){
            $row["email"] = $email;
        }
        else{
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'invalid_email'
            ]));
            die();
        }

        $queryLogin = "SELECT * FROM admin WHERE password = '".$password."'";
        $res2 = mysqli_query($conn, $queryLogin);
        if(($row = mysqli_fetch_assoc($res2))){
            $row["password"] = $password;
        }
        else{
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'invalid_password'
            ]));
            die();
        }

        $queryLogin = "SELECT * FROM admin WHERE email = '".$email."' AND password = '".$password."' ";
        $res3 = mysqli_query($conn, $queryLogin);
        if(mysqli_num_rows($res) > 0) {
            $Admin = [];
            while ($row = mysqli_fetch_assoc($res3)) {

                $path = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/app/data/' . $row['avatar'];

                var_dump($path);

                array_push($Admin, [

                    'email' => $row['email'],
                    'password' => $row['password'],
                    'avatar' => $path,
                    'admin_uid' => $row['admin_uid'],

                ]);

            }
            var_dump(__DIR__);

            echo(json_encode([
                'status' => 'SUCCESS',
                'code' => '200',
                'data' => $Admin
            ]));

            die();
        }
    }



  }
?>
