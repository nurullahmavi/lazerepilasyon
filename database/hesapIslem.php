<?php
include 'connection.php';
session_start();
ob_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'username'){
    
    $duzenle = $db->prepare('update admin set UserName = ? where id = ?');
    $result = $duzenle->execute([
        $_POST['UserName'],
        1
    ]);
    
    if($result){
        $_SESSION['usernameDegisti'] = true;
        $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
        header("Refresh: 0; url=$geldigi_sayfa");
    }else{
        $_SESSION['usernameDegisti'] = false;
        $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
        header("Refresh: 0; url=$geldigi_sayfa");
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'sifre'){
    
    $eskiSifre = $db->prepare('select * from  admin where Sifre = ? and id = ?');
    $eskiSifre->execute([
        md5($_POST['EskiSifre']),
        1
    ]);
    $varmi = $eskiSifre->rowCount();

    
    if($varmi > 0){

        if($_POST['YeniSifre'] == $_POST['YeniSifreTekrar']){
            $kisa = strlen($_POST['YeniSifre']);
            if($kisa > 5 ){
                $duzenle = $db->prepare('update admin set Sifre = ? where id = ?');
                $result = $duzenle->execute([
                    md5($_POST['YeniSifre']),
                    1
                ]);
                $_SESSION['sifre'] = 'basarili';
                $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
                header("Refresh: 0; url=$geldigi_sayfa");
            }else{
                $_SESSION['sifre'] = 'kisaSifre';
                $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
                header("Refresh: 0; url=$geldigi_sayfa");
            }
        }else{
            $_SESSION['sifre'] = 'sifreAyniDegil';
            $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
            header("Refresh: 0; url=$geldigi_sayfa");
        }
        
    }else{
        $_SESSION['sifre'] = 'eskiSifreYanlis';
        $geldigi_sayfa = $_SERVER['HTTP_REFERER']; 
        header("Refresh: 0; url=$geldigi_sayfa");
    }
}