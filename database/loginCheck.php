<?php
include 'connection.php';
session_start();
ob_start();


$login = $db->prepare('select * from admin where UserName = ? and Sifre = ? and id = ?');
$login->execute([
    $_POST['UserName'],
    md5($_POST['Sifre']),
    1
]);
$data = $login->rowCount();
if($data == 1){
    $_SESSION['girisBasarili'] = true;
    header('Location:../index.php');
}else{
    $_SESSION['girisBasarisiz'] = 'Hata';
    $_SESSION['girisBasarili'] = false;
    header('Location:../login.php');
}