<?php include 'header.php';?>
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Yeni Randevu Ekle</h4><br>
      <form class="forms-sample">
        <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="AdSoyad"><b>Ad Soyad</b></label>
            <input type="text" class="form-control" name="AdSoyad" id="AdSoyad" placeholder="Ad Soyad">
          </div>
          <div class="form-group">
            <label for="Tarih"><b>Tarih</b></label>
            <input type="date" class="form-control" name="Tarih" id="Tarih" placeholder="">
          </div>
          <div class="form-group">
            <label for="Telefon"><b>Telefon Numarası</b></label>
            <input type="number" class="form-control" name="Telefon" id="Telefon" placeholder="Telefon Numarası">
          </div>
          <div class="form-group">
            <label for="Tc"><b>T.C.</b></label>
            <input type="number" class="form-control" name="Tc" id="Tc" placeholder="T.C.">
          </div>
          <div class="form-group">
            <label for="DogumTarihi"><b>Doğum Tarihi</b></label>
            <input type="date" class="form-control" name="DogumTarihi" id="DogumTarihi" placeholder="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="YapilanIslem"><b>Yapılan İşlem</b></label>
            <input type="text" class="form-control" name="YapilanIslem" id="YapilanIslem" placeholder="Yapılan İşlem">
          </div>
          <div class="form-group">
            <label for="Paket"><b>Paket TL</b></label>
            <input type="number" class="form-control" name="Paket" id="Paket" placeholder="Paket TL">
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
                <option class="secilen" value="<?php echo $est['id']?>"><?php echo $est['AdSoyad']?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="SeansSayisi"><b>Seans Sayısı</b></label>
            <input type="number" class="form-control" name="SeansSayisi" id="SeansSayisi" placeholder="Seans Sayısı">
          </div>
          <div class="form-group">
            <label for="AtisSayisi"><b>Atış Sayısı</b></label>
            <input type="number" class="form-control" name="AtisSayisi" id="AtisSayisi" placeholder="Atış Sayısı">
          </div>
        </div>

          
        </div>
          <div class="form-group">
            <label for="Referans"><b>Referans</b></label>
            <input type="text" class="form-control" name="Referans" id="Referans" placeholder="Referans">
          </div>
          <div class="form-group">
            <label for="Notlar"><b>Not</b></label>
            <textarea class="form-control" name="Notlar" id="Notlar" rows="7"></textarea>
          </div>





        <button type="submit" id="btnOlustur" class="btn btn-primary mr-2">Randevu Oluştur</button>
        <button type="button" id="btnIptal" class="btn btn-light">İptal</button>
      </form>
    </div>
  </div>
</div>


<script>
	          		var estetisyenId = 0;

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
            let Paket = document.querySelector('#Paket').value;
            let SeansSayisi = document.querySelector('#SeansSayisi').value;
            let AtisSayisi = document.querySelector('#AtisSayisi').value;
            let Referans = document.querySelector('#Referans').value;
            let Notlar = document.querySelector('#Notlar').value;
            
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
            }else if(Paket.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Paket tutarını girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(SeansSayisi.trim() == ''){
              Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Seans sayısını girmelisin',
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
                'database/randevuIslem.php?tip=ekle',"AdSoyad="+AdSoyad+"&Tarih="+Tarih+"&TelefonNumarasi="+Telefon+"&Tc="+Tc+"&DogumTarihi="+DogumTarihi+"&YapilanIslem="+YapilanIslem
                +"&Paket="+Paket+"&SeansSayisi="+SeansSayisi+"&AtisSayisi="+AtisSayisi+"&Referans="+Referans+"&Notlar="+Notlar+"&estetisyenId="+estetisyenId
            
                ).then(res => {
                Swal.fire({
                      icon: res.data.type,
                      title: res.data.title,
                      text: res.data.message,
                });
                document.getElementById('AdSoyad').value = "";
                document.getElementById('Tarih').value = "";
                document.getElementById('Telefon').value = "";
                document.getElementById('Tc').value = "";
                document.getElementById('DogumTarihi').value = "";
                document.getElementById('YapilanIslem').value = "";
                document.getElementById('Paket').value = "";
                document.getElementById('SeansSayisi').value = "";
                document.getElementById('AtisSayisi').value = "";
                document.getElementById('Referans').value = "";
                document.getElementById('Notlar').value = "";
                document.getElementById('estetisyenId').value = 0;
                } 
                );
            }

            
        });

  $('#btnIptal').click(()=>{
    window.location.reload();
  });
</script>
<?php include 'footer.php';?>