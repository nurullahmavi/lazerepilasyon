<?php include 'header.php';

if(isset($_GET['id'])){
  $randevuBilgi = $db->prepare('select * from randevu where id = ?');
  $randevuBilgi->execute([$_GET['id']]);
  $randevuBilgiDizi = $randevuBilgi->fetchALL(PDO::FETCH_ASSOC);
  foreach($randevuBilgiDizi as $randevu){
    $AdSoyad = $randevu['AdSoyad'];
    $Tarih = $randevu['Tarih'];
    $TelefonNumarasi = $randevu['TelefonNumarasi'];
    $Tc = $randevu['Tc'];
    $DogumTarihi = $randevu['DogumTarihi'];
    $YapilanIslem = $randevu['YapilanIslem'];
    $estetisyenId = $randevu['estetisyenId'];
    $AtisSayisi = $randevu['AtisSayisi'];
    $Referans = $randevu['Referans'];
    $Notlar = $randevu['Notlar'];
  }
}else{
  header('Location:randevular.php');
}

?>
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Randevu Düzenleme</h4><br>
      <form class="forms-sample">
        <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="AdSoyad"><b>Ad Soyad</b></label>
            <input type="text" class="form-control" name="AdSoyad" value="<?php echo $AdSoyad;?>" id="AdSoyad" placeholder="Ad Soyad">
            <input type="hidden" class="form-control" name="id" value="<?php echo $_GET['id'];?>" id="id">
          </div>
          <div class="form-group">
            <label for="Tarih"><b>Tarih</b></label>
            <input type="date" class="form-control" value="<?php echo $Tarih;?>" name="Tarih" id="Tarih" placeholder="">
          </div>
          <div class="form-group">
            <label for="Telefon"><b>Telefon Numarası</b></label>
            <input type="number" class="form-control" name="Telefon" value="<?php echo $TelefonNumarasi;?>" id="Telefon" placeholder="Telefon Numarası">
          </div>
          <div class="form-group">
            <label for="Tc"><b>T.C.</b></label>
            <input type="number" class="form-control" name="Tc" value="<?php echo $Tc;?>" id="Tc" placeholder="T.C.">
          </div>
          
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="YapilanIslem"><b>Yapılan İşlem</b></label>
            <input type="text" class="form-control" name="YapilanIslem" value="<?php echo $YapilanIslem;?>" id="YapilanIslem" placeholder="Yapılan İşlem">
          </div>
          <div class="form-group">
            <label for="DogumTarihi"><b>Doğum Tarihi</b></label>
            <input type="date" class="form-control" name="DogumTarihi" value="<?php echo $DogumTarihi;?>" id="DogumTarihi" placeholder="">
          </div>
          <div class="form-group">
            <label class=""><b>Estetisyen</b></label>
            <div class="">
              <select id="Estetisyen" required   class="form-control">
                <option disabled selected hidden >Seçiniz</option>
                <?php
                  $est = $db->prepare('select * from estetisyenler');
                  $est->execute([]);
                  $estler = $est->fetchALL(PDO::FETCH_ASSOC);
                  foreach($estler as $est){
                ?>
                <option class="secilen" <?php echo $estetisyenId == $est['id'] ? 'selected' : null ;?> value="<?php echo $est['id']?>"><?php echo $est['AdSoyad']?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="AtisSayisi"><b>Atış Sayısı</b></label>
            <input type="number" class="form-control" name="AtisSayisi" value="<?php echo $AtisSayisi;?>" id="AtisSayisi" placeholder="Atış Sayısı">
          </div>
        </div>

          
        </div>
          <div class="form-group">
            <label for="Referans"><b>Referans</b></label>
            <input type="text" class="form-control" name="Referans" value="<?php echo $Referans;?>" id="Referans" placeholder="Referans">
          </div>
          <div class="form-group">
            <label for="Notlar"><b>Not</b></label>
            <textarea class="form-control" name="Notlar" id="Notlar" rows="7"><?php echo $Notlar;?></textarea>
          </div>





        <button type="submit" id="btnOlustur" class="btn btn-primary mr-2">Kaydet</button>
        <button type="button" id="btnIptal" class="btn btn-light">İptal</button>
      </form>
    </div>
  </div>
</div>


<script>
	          		var estetisyenId = $("#Estetisyen").val();

  $('#Estetisyen').on('change', function() {
	          		estetisyenId = $("#Estetisyen").val();
	          });
$('#btnOlustur').on("click",function(e){
    e.preventDefault();
            let AdSoyad = document.querySelector('#AdSoyad').value;
            let Tarih = document.querySelector('#Tarih').value;
            let Telefon = document.querySelector('#Telefon').value;
            let Tc = document.querySelector('#Tc').value;
            let DogumTarihi = document.querySelector('#DogumTarihi').value;
            let YapilanIslem = document.querySelector('#YapilanIslem').value;
            let AtisSayisi = document.querySelector('#AtisSayisi').value;
            let Referans = document.querySelector('#Referans').value;
            let Notlar = document.querySelector('#Notlar').value;
            let id = document.querySelector('#id').value;
            
            if(AdSoyad.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Ad Soyad girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Tarih.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Tarih girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Telefon.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Telefon numaranı girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Tc.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'T.C. girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(DogumTarihi.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Doğum tarihi girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(YapilanIslem.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Yapılan işlemi girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(AtisSayisi.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Atış sayısını girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Referans.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Referans girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Notlar.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Not girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(estetisyenId == 0){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Estetisyen seçin',
                  confirmButtonText: 'Tamam'
                });
            }else{



                axios.post(
                'database/randevuIslem.php?tip=guncelle',"AdSoyad="+AdSoyad+"&Tarih="+Tarih+"&TelefonNumarasi="+Telefon+"&Tc="+Tc+"&DogumTarihi="+DogumTarihi+"&YapilanIslem="+YapilanIslem
                +"&AtisSayisi="+AtisSayisi+"&Referans="+Referans+"&Notlar="+Notlar+"&estetisyenId="+estetisyenId+"&id="+id
            
                ).then(res => {
                Swal.fire({
                      icon: res.data.type,
                      title: res.data.title,
                      text: res.data.message,
                });
                } 
                );
            }

            
        });

  $('#btnIptal').click(()=>{
    window.location.reload();
  });
</script>
<?php include 'footer.php';?>