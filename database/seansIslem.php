<?php
include 'connection.php';

$duzenle = $db->prepare('update seanslar set yapilanIslem = ? , islemTarihi=? where id = ?');
$result = $duzenle->execute([
    $_POST['yapilanIslem'],
    $_POST['islemTarihi'],
    $_POST['id']
]);

$geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
header("Refresh: 0; url=$geldigi_sayfa");