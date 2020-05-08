<?php
$config['host'] = "localhost";

$config['username'] = "root";
$config['password'] = "";
$config['dbname'] = "simsimi";

$conn = mysqli_connect($config['host'],$config['username'],$config['password'], $config['dbname']);
if (!$conn){
die('ERORR DATA ');
}
