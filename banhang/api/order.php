<?php
session_start();
require "../config/db.php";
$pdo=getPDO();

if(empty($_SESSION['cart'])) exit;

$stmt=$pdo->prepare(
"INSERT INTO orders(name,phone,address,total) VALUES (?,?,?,?)");

$total=array_sum($_SESSION['cart']);
$stmt->execute([$_POST['name'],$_POST['phone'],$_POST['address'],$total]);

$_SESSION['cart']=[];
