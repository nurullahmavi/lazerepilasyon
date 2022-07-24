<?php include 'header.php';?>
  
<?php
    $seanslar = $db->prepare('select * from seanslar where randevuId = ?');
    $seanslar->execute([$_GET['id']]);
    $seanslarDizi = $seanslar->fetchALL(PDO::FETCH_ASSOC);
    foreach($seanslarDizi as $seans) {
?>
<form action="database/seansIslem.php" method="POST" class="forms-sample">
          <div class="row">
            <input type="hidden" name="id" value="<?php echo $seans['id'];?>">
            <div class="col-md-3">
                <div class="form-group">
                <label for="YapilanIslem"><?php echo $seans['seansAdi'];?></label>
                </div>
            </div>
            <div class="col-md-3">
                  <div class="form-group">
                  <input type="text" class="form-control" required value="<?php echo $seans['yapilanIslem'];?>" name="yapilanIslem" id="yapilanIslem" placeholder="Yapılan İşlem">
                </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
                  <input type="date" class="form-control" required   value="<?php echo $seans['islemTarihi'];?>" name="islemTarihi" id="islemTarihi" placeholder="İşlem Tarihi">
                </div>
            </div>
            <div class="col-md-3">
          <button type="submit" id="btnOlustur" class="btn btn-primary mr-2">Kaydet</button>

            </div>
          </div>
          
      </form>
<?php
    }
?>




        
<?php include 'footer.php';?>