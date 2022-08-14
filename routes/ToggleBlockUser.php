<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
  if ($_SERVER["REQUEST_METHOD"] === 'POST'){

    if (!isset($_POST['user_uid'])) {
      die('misising');
    }

    $query = "SELECT * FROM users where user_uid ='" . $_POST['user_uid'] . "'";

    $result = mysqli_query($conn,$query);

    if (!result) {
      die('no user');
    }

    $user = mysqli_fetch_assoc($result);

    $block = $user['block'];

    if($block == 1){
      $block = 0;
    }
    else{
      $block = 1;
    }

    $query = "UPDATE registerusers SET block=". $block ." where user_uid='" . $user['user_uid'] . "'";

    $result = mysqli_query($conn,$query);

    if (!$result) {
      die('failed_to_update');
    }

    die('updated');
   // update user with new block state

  }
?>
