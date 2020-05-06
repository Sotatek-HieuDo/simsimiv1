<?php
$config['host'] = "localhost";

$config['username'] = "zkzfcjfthosting_chatsims";
$config['password'] = "GV8goLKEQ8WP";
$config['dbname'] = "zkzfcjfthosting_simsimi";
$connection = mysql_connect($config['host'],$config['username'],$config['password']);
if (!$connection){
die('ERORR DATA ');
}
mysql_select_db($config['dbname']) or die(mysql_error());
mysql_query("SET NAMES utf8");
