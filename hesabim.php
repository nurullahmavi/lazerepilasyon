<?php include 'header.php';?>
  
<div class="row">
    <div class="col-md-6">
        <?php
        if(isset($_SESSION['usernameDegisti'])){
            if($_SESSION['usernameDegisti'] == true ){
                ?>
                <div class="alert alert-success">
                    Kullanıcı adı değiştirildi
                </div>
                <?php
            }else{
            ?>
            <div class="alert alert-danger">
            Kullanıcı adı değiştirilirken bir hata oluştu. Lütfen tekrar deneyin
            </div>
            <?php
            
            }
            unset($_SESSION['usernameDegisti']);
        }
        ?>
    <form action="database/hesapIslem.php?tip=username" method="POST" class="forms-sample">
          
            
          <div class="form-group">
        <label for="UserName">Kullanıcı Adı</label>
          <input type="text" class="form-control" required value="<?php echo $UserName?>" name="UserName" id="UserName">
        </div>
      <button type="submit" id="btnOlustur" class="btn btn-primary mr-2">Kaydet</button>

        
      
  </form>
    </div>
    <div class="col-md-6">
    <?php
        if(isset($_SESSION['sifre'])){
            if($_SESSION['sifre'] == 'eskiSifreYanlis' ){
                ?>
                <div class="alert alert-danger">
                    Eski şifrenizi yanlış girdiniz
                </div>
                <?php
            }elseif($_SESSION['sifre'] == 'sifreAyniDegil' ){
                ?>
                <div class="alert alert-danger">
                    Yeni Şifreleriniz uyuşmuyor
                </div>
                <?php
            }elseif($_SESSION['sifre'] == 'kisaSifre' ){
                ?>
                <div class="alert alert-danger">
                    Şifreniz en az 6 karekterli olmalıdır
                </div>
                <?php
            }else{
            ?>
            <div class="alert alert-success">
            Şifreniz başarı ile güncelendi
            </div>
            <?php
            
            }
            unset($_SESSION['sifre']);
        }
        ?>
    <form action="database/hesapIslem.php?tip=sifre" method="POST" class="forms-sample">
          
            
          <div class="form-group">
        <label for="EskiSifre">Eski Şifre</label>
          <input type="text" class="form-control" required value="" name="EskiSifre" id="EskiSifre" placeholder="Eski Şifre">
        </div>
        <div class="form-group">
        <label for="YeniSifre">Yeni Şifre</label>
          <input type="text" class="form-control" required value="" name="YeniSifre" id="YeniSifre" placeholder="Yeni Şifre">
        </div>
        <div class="form-group">
        <label for="YeniSifreTekrar">Yeni Şifre Tekrar</label>
          <input type="text" class="form-control" required value="" name="YeniSifreTekrar" id="YeniSifreTekrar" placeholder="Yeni Şifre Tekrar">
        </div>
      <button type="submit" id="btnOlustur" class="btn btn-primary mr-2">Kaydet</button>

        
      
  </form>
    </div>
</div>






        
<?php include 'footer.php';?>