<?php

$host="localhost";
$user="root";
$password="";
$dbname="storeapp";
error_reporting(0);
$conn = mysqli_connect($host,$user,$password,$dbname);

if(!$conn) {
	echo(json_encode([
        'status' => 'FAILURE',
        'code' => '200',
        'exception' => [
            'failed_to_connect_to_database' => true
        ]
    ]));

    die();

}

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Karachi');
require "../vendor/autoload.php";
?>
