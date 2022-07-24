<?php
include 'connection.php';
session_start();
ob_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'ekle'){

    $ekle = $db->prepare('insert into estetisyenler set AdSoyad = ?');
    $result = $ekle->execute([
        $_POST['AdSoyad']
    ]);
    
    if($result){
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Kişi başarıyla eklendi','type'=>'success','data'=>[
            'id'=> $db->lastInsertId(),
            'AdSoyad'=> $_POST['AdSoyad']
            ]]);
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Kişi eklenemedi','type'=>'error']);
    }
}


if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip']== 'all'){
    $liste = $db->query('select * from estetisyenler');
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    
    if($data){
        echo json_encode(compact('data'));
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'İşlem başarısız','type'=>'error']);
        
    }
} 

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip'] == 'sil'){
    $sil = $db->prepare('delete from estetisyenler where id = ?');
    $result = $sil->execute([$_GET['id']]);
    
    if($result){
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Estetisyen kalıcı olarak silindi','type'=>'success']);
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Estetisyen silinirken bir hata oluştu','type'=>'error']);
        
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip']== 'kim'){
    $liste = $db->prepare('select * from estetisyenler where id = ? ');
    $liste->execute([$_GET['id']]);
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    
    if($data){
        echo json_encode(compact('data'));
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'İşlem başarısız','type'=>'error']);
        
    }
} 

if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'duzenle'){
    $duzenle = $db->prepare('update estetisyenler set AdSoyad = ? where id = ?');
    $result = $duzenle->execute([
        $_POST['AdSoyad'],
        $_POST['id']
    ]);
    
    if($result){
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Kişi başarıyla eklendi','type'=>'success']);
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Kişi eklenemedi','type'=>'error']);
    }
}