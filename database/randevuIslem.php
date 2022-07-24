<?php
include 'connection.php';
session_start();
ob_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'ekle'){

    $ekle = $db->prepare('insert into randevu set AdSoyad = ?,Tarih = ?,TelefonNumarasi=?,Tc=?,DogumTarihi=?,YapilanIslem=?,Paket=?,estetisyenId=?,AtisSayisi=?,SeansSayisi=?,Referans=?,Notlar=?,KalanPara=?');
    $result = $ekle->execute([
        $_POST['AdSoyad'],
        $_POST['Tarih'],
        $_POST['TelefonNumarasi'],
        $_POST['Tc'],
        $_POST['DogumTarihi'],
        $_POST['YapilanIslem'],
        $_POST['Paket'],
        $_POST['estetisyenId'],
        $_POST['AtisSayisi'],
        $_POST['SeansSayisi'],
        $_POST['Referans'],
        $_POST['Notlar'],
        $_POST['Paket']
    ]);
    $id = $db->lastInsertId();
    if($result){
        for($i = 1; $i<= $_POST['SeansSayisi'] ; $i++){
            $seansEkle = $db->prepare('insert into seanslar set seansAdi = ? ,randevuId = ? ');
            $seansEkle->execute([
                'Seans-'.$i,
                $id
            ]);            
        }
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Randevu başarıyla eklendi','type'=>'success','is' => $result]);
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Randevu eklenemedi','type'=>'error']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip']== 'detay'){
    $liste = $db->prepare('select randevu.AdSoyad as rAdSoyad ,randevu.Tarih,randevu.TelefonNumarasi,randevu.Tc,randevu.DogumTarihi,randevu.YapilanIslem,randevu.Paket,randevu.AtisSayisi,randevu.SeansSayisi,randevu.Referans,randevu.Notlar,randevu.KalanPara,estetisyenler.AdSoyad as eAdSoyad from randevu left join estetisyenler on estetisyenler.id = randevu.estetisyenId where randevu.id = ? ');
    $liste->execute([$_GET['id']]);
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    
    if($data){
        echo json_encode(compact('data'));
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'İşlem başarısız','type'=>'error']);
        
    }
} 


if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'odeme'){
    $liste = $db->prepare('select * from randevu where id = ? ');
    $liste->execute([$_POST['id']]);
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    foreach($data as $d){
        $KalanPara = $d['KalanPara'];
    }
    if($_POST['AlinacakTutar'] <= $KalanPara){
        $kalan = $KalanPara - $_POST['AlinacakTutar'];
        $duzenle = $db->prepare('update randevu set KalanPara = ? where id = ?');
        $result = $duzenle->execute([
            $kalan,
            $_POST['id']
        ]);
    }else{
        $result = false;
    }
    
    
    if($result){
        $now = date_create()->format('Y-m-d');
        $odemeEkle = $db->prepare('insert into odeme set randevuId = ? , perAdSoyad = ?, tarih = ?,alinanTutar = ?');
        $odemeEkle->execute([
            $_POST['id'],
            $_POST['perAdSoyad'],
            $now,
            $_POST['AlinacakTutar']
        ]);
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Ödeme alındı','type'=>'success']);
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Ödeme alınamadı galiba fazla para alıyorsunuz kontrol edip tekrar deneyin','type'=>'error']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip'] == 'iptal'){
    $sil = $db->prepare('delete from randevu where id = ?');
    $result = $sil->execute([$_GET['id']]);
    
    if($result){
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Estetisyen kalıcı olarak silindi','type'=>'success']);
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Estetisyen silinirken bir hata oluştu','type'=>'error']);
        
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip']== 'odemelerTablo'){
    $liste = $db->prepare('select * from odeme where randevuId = ? ');
    $liste->execute([$_GET['id']]);
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    
    if($data){
        echo json_encode(compact('data'));
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'İşlem başarısız','type'=>'error']);
        
    }
} 


if($_SERVER['REQUEST_METHOD'] == 'POST' and $_GET['tip'] == 'guncelle'){

    $ekle = $db->prepare('update randevu set AdSoyad = ?,Tarih = ?,TelefonNumarasi=?,Tc=?,DogumTarihi=?,YapilanIslem=?,estetisyenId=?,AtisSayisi=?,Referans=?,Notlar=? where id = ?');
    $result = $ekle->execute([
        $_POST['AdSoyad'],
        $_POST['Tarih'],
        $_POST['TelefonNumarasi'],
        $_POST['Tc'],
        $_POST['DogumTarihi'],
        $_POST['YapilanIslem'],
        $_POST['estetisyenId'],
        $_POST['AtisSayisi'],
        $_POST['Referans'],
        $_POST['Notlar'],
        $_POST['id'],
    ]);
    if($result){
        
        echo json_encode(['title'=>'İşlem başarılı','message'=>'Randevu başarıyla güncellendi','type'=>'success','is' => $result]);
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'Randevu güncelenemedi. Lütfen tekrar deneyin','type'=>'error']);
    }
}


if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['tip']== 'excel'){
    $liste = $db->prepare('select randevu.AdSoyad as rAdSoyad ,randevu.Tarih,randevu.TelefonNumarasi,randevu.Tc,randevu.DogumTarihi,randevu.YapilanIslem,randevu.Paket,randevu.AtisSayisi,randevu.SeansSayisi,randevu.Referans,randevu.Notlar,randevu.KalanPara,estetisyenler.AdSoyad as eAdSoyad from randevu left join estetisyenler on estetisyenler.id = randevu.estetisyenId ');
    $liste->execute([]);
    $data = $liste->fetchALL(PDO::FETCH_ASSOC);
    
    if($data){
        echo json_encode(compact('data'));
        
    }else{
        echo json_encode(['title'=>'İşlem başarısız','message'=>'İşlem başarısız','type'=>'error']);
        
    }
} 