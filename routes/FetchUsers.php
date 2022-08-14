<?php
require '../config/conn.php';
    $query="SELECT * FROM users";
    $result = mysqli_query($conn,$query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {

         array_push($users, [

             'username' => $row['username'],
             'email' => $row['email'],
             'password' => $row['password'],
             'address' => $row['address'],
             'user_uid' => $row['user_uid'],
             'avatar' => $row['avatar'],
             'block' => $row['block'],
         ]);

    }

         echo(json_encode([
             'status' => 'SUCCESS',
             'code' => '200',
             'data' => $users
         ]));

    die();
?>
