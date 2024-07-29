<?php
$username = 'root';
$password = '123123';
$database = 'gon';
$host = 'localhost';

$connect = mysqli_connect($host,$username,$password,$database);

$username = '{"key":"'.time().'"}';
$hash = base64_encode(sha1(md5($username)));
$query = "insert into seriel(seriel) values('".$hash."')";
mysqli_query($connect,$query);


?>