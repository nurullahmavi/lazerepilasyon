<?php include 'header.php'; ?>

<style>
        ul li{list-style: none;}
        ul.sayfalama li{  display: inline-block;
}
        ul.sayfalama li a{ color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  border-radius: 5px;

}
  ul.sayfalama li a.active{
    background-color: #4CAF50;
  color: white;
  }
    </style>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Randevular</h4>
      <input type="text" class="search form-control" placeholder="Randevu Arama...">
    <span class="counter"></span>
    <br><br>
      <table id="tablo" class="table table-striped results">
        <thead>
          <tr>
            <th><b>Ad Soyad</b></th>
            <th><b>Telefon</b></th>
            <th><b>T.C.</b></th>
            <th><b>Kalan Para</b></th>
            <th><b>İşlemler</b></th>
          </tr>
        </thead>
        <tbody>
            <?php

$toplamVeri = $db->query("SELECT COUNT(*) FROM randevu")->fetchColumn(); // Tabloda kaç tane kayıt olduğunu buluyoruz
$goster = 10; // Her sayfada kaç veri görünsün
$toplamSayfa = ceil($toplamVeri / $goster);  // Toplam sayfa sayımızı buluyoruz sonucu yuvarlıyoruz
$sayfa = isset($_GET["s"]) ?$_GET["s"] : 1 ; // Sayfa numaramızı get metodu ile yolladığımız "s" değeri ile alıyoruz
if($sayfa < 1) $sayfa = 1; // Eğer kullanıcı sayfa numarasına 1'den küçük değer girerse 1.sayfayı gösteriyoruz
if($sayfa > $toplamSayfa) // Eğer kullanıcı sayfa numarasına toplam sayfadan daha fazla değer girerse en son sayfayı gösteriyoruz
{
    $sayfa = (int)$toplamSayfa;
}
$limit = ($sayfa - 1) * $goster;  // Veri tabanında listelemme yaparken limit ile kaçıncı veriden başladığını belirtiyoruz.

            $veriler = $db->prepare("SELECT * FROM randevu order by id desc LIMIT :basla, :bitir");
            $veriler->bindValue(":basla",$limit,PDO::PARAM_INT);
            $veriler->bindValue(":bitir",$goster,PDO::PARAM_INT);
            $veriler->execute();
            $dizi = $veriler->fetchAll(PDO::FETCH_OBJ);

            foreach($dizi as $randevu) {
            ?>
            <tr>
                <td><?php echo $randevu->AdSoyad?></td>
                <td><?php echo $randevu->TelefonNumarasi?></td>
                <td><?php echo $randevu->Tc?></td>
                <td><?php echo $randevu->KalanPara?></td>
                <td><div class="btn-group">
                    <button class="btn-success btn-sm btn detay" onclick="detayBtn(<?php echo $randevu->id?>)" type="button">Daha Fazla</button>
                    <button class="btn-primary btn-sm btn odeme" onclick="odemeAlBtn(<?php echo $randevu->id?>)" type="button">Ödeme Al</button>
                    <button class="btn-dark btn-sm btn odeme" onclick="odemelerBtn(<?php echo $randevu->id?>)" type="button">Ödemeler</button>
                    <button class="btn-warning btn-sm btn sil" onclick="seansBtn(<?php echo $randevu->id?>)" type="button">Seanslar</button>
                    <button class="btn-default btn-sm btn sil" onclick="duzenleBtn(<?php echo $randevu->id?>)" type="button">Düzenle</button>
                    <button class="btn-danger btn-sm btn sil" onclick="iptalBtn(<?php echo $randevu->id?>)" type="button">İptal Et</button>
                    </div>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
        <tr class="warning no-result" style="display:none;">
            <td colspan="5"><i class="fa fa-warning"></i> Bulunamadı</td>
        </tr>
        </tfoot>
      </table>
      <ul class="sayfalama">
<?php
for($i = 1; $i<=$toplamSayfa;$i++)
{
?>
<li><a <?php echo $i == @$_GET['s'] ? "class='active'" : null; ?> href="randevular.php?s=<?php echo $i;?>"><?php echo $i;?></a></li>
<?php } ?>
</ul>
<button id="aktar" class="btn btn-primary" style="float: right;">Excele aktar</button>

    </div>
    
  </div>
  
</div>

<div id="detayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Randevu Detay</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            
            <div>
                <b>Ad Soyad : </b> <span id="AdSoyadSpan"></span><br>
                <b>Tarih : </b> <span id="TarihSpan"></span><br>
                <b>Telefon Numarası : </b> <span id="TelefonNumarasiSpan"></span><br>
                <b>T.C. : </b> <span id="TcSpan"></span><br>
                <b>Doğum Tarihi : </b> <span id="DogumTarihiSpan"></span><br>
                <b>Yapılan İşlem : </b> <span id="YapilanIslemSpan"></span><br>
                <b>Paket : </b> <span id="PaketSpan"></span><br>
                <b>Estetisyen : </b> <span id="EstetisyenSpan"></span><br>
                <b>Atış Sayısı : </b> <span id="AtisSayisiSpan"></span><br>
                <b>Seans Sayisi : </b> <span id="SeansSayisiSpan"></span><br>
                <b>Referans : </b> <span id="ReferansSpan"></span><br>
                <b>Not : </b> <div style="word-wrap: normal;
word-wrap: break-word;">
                <span id="NotlarSpan"></span>
                </div><br>
                <b>Kalan Para : </b> <span id="KalanParaSpan"></span><br>
            </div>
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        
      </div>
    </div>

  </div>
</div>

<div id="odemeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Ödeme Al</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <form class="forms-sample" method="POST" id="formParaAl">
                  <div class="form-group">
                    <label for="AlinacakTutar">Alınacak Tutar</label>
                    <input type="text" class="form-control" name="AlinacakTutar" id="AlinacakTutar" placeholder="Alınacak Tutar">
                    <input type="hidden" class="form-control" name="idParaAl" id="idParaAl">
                  </div>
                  <div class="form-group">
                    <label for="perAdSoyad">Personel Ad Soyad</label>
                    <input type="text" class="form-control" name="perAdSoyad" id="perAdSoyad" placeholder="Personel Ad Soyad">
                  </div>

                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
        <button type="submit" id="btnOdemeAl" class="btn btn-primary mr-2">Ödeme Al</button>
              </form>
      </div>
    </div>

  </div>
</div>


<div id="odemelerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Ödemeler</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            
      <table class="table table-striped">
        <thead>
          
          <tr>
            <th><b>Ödemeyi Alan Personel</b></th>
            <th><b>Tarih</b></th>
            <th><b>Ödeme Miktarı</b></th>
          </tr>
        </thead>
        <tbody id="odemelerTablo">
            
        </tbody>
      </table>
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
       
      </div>
    </div>

  </div>
</div>

<table style="visibility: hidden;" id="veriler">
  <thead>
    <th><b>Ad Soyad</b></th>
    <th><b>Tarih</b></th>
    <th><b>Telefon Numarası</b></th>
    <th><b>T.C.</b></th>
    <th><b>Doğum Tarihi</b></th>
    <th><b>Yapılan İşlem</b></th>
    <th><b>Paket</b></th>
    <th><b>Estetisyen</b></th>
    <th><b>Atış Sayısı</b></th>
    <th><b>Seans Sayısı</b></th>
    <th><b>Referans</b></th>
    <th><b>Notlar</b></th>
    <th><b>Kalan Para</b></th>
  </thead>
  <tbody id="gec"></tbody>
</table>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script>
    $(document).ready(function(){
        
        $("#aktar").click(function(){

          axios.get(
                'database/randevuIslem.php?tip=excel'
            
                ).then(res => {
                  var gec = $('#gec');
                for ( let randevu of res.data.data ) {

                var tr = document.createElement('tr');
                tr.innerHTML = '<td>'+randevu.rAdSoyad+'</td>'+'<td>'+randevu.Tarih+'</td>'+
                '<td>'+randevu.TelefonNumarasi+'</td>'+'<td>'+randevu.Tc+'</td>'+'<td>'+randevu.DogumTarihi+'</td>'+
                '<td>'+randevu.YapilanIslem+'</td>'+'<td>'+randevu.Paket+'</td>'+'<td>'+randevu.eAdSoyad+'</td>'+
                '<td>'+randevu.AtisSayisi+'</td>'+'<td>'+randevu.SeansSayisi+'</td>'+'<td>'+randevu.Referans+'</td>'+
                '<td>'+randevu.Notlar+'</td>'+'<td>'+randevu.KalanPara+'</td>';
                gec.prepend(tr);
                
                } 
                $("#veriler").table2excel({
                filename: "rapor"
                });
                $("#veriler").remove();
                }
                
                );
            
        })
        
    })
</script>


<script>



    $(".search").keyup(function() {
    var searchTerm = $(".search").val();
    var bulunan = 0
    $('.results tbody tr').each(function(e) {
        var table = $(this)
        if (table.text().toLowerCase().includes(searchTerm.toLowerCase())) {
            bulunan += 1
            table.show()
            $(".counter").text(bulunan + " kayıt bulundu")
            $(".no-result").css('display', 'none')
        } else {
            table.hide()
            $(".counter").text(bulunan + " kayıt bulundu")
            if (bulunan == 0) {
                $(".no-result").css('display', '')
            }
        }
    })
});
</script>

<script>
    
    function iptalBtn(id){
            Swal.fire({
              title: 'İptal etmek istediğizden emin misiniz',
              text: "Bu veri ye bir daha ulaşamıyacakmışsınız!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Evet İptal Et',
              cancelButtonText: 'Hayır'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.get(
                'database/randevuIslem.php?tip=iptal&id='+id
                ).then(res =>{
                window.location.reload()
            }
                );
                
                
              }
            })
        
      }

      function seansBtn(id){
            
        window.location.href = 'seanslar.php?id='+id;
            
        
      }

      function duzenleBtn(id){
            
            window.location.href = 'randevuDuzenle.php?id='+id;
                
            
          }
    
    $('#btnOdemeAl').on("click",function(e){
    e.preventDefault();
            var AlinacakTutar = document.querySelector('#AlinacakTutar').value;
            var perAdSoyad = document.querySelector('#perAdSoyad').value;

            let id = document.querySelector('#idParaAl').value;
            if(AlinacakTutar.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Alınacak tutar girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }if(perAdSoyad.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Personel ad soyad girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else{
                
                axios.post(
                'database/randevuIslem.php?tip=odeme',"AlinacakTutar="+AlinacakTutar+"&id="+id+"&perAdSoyad="+perAdSoyad
            
                ).then(res => {
                window.location.reload();

                } 
                );
            }

            
        });
</script>

<script>
    function odemeAlBtn(id){
      var odemeModal = $('#odemeModal');
      document.getElementById('idParaAl').value = id;
      odemeModal.modal();
    }

    function odemelerBtn(id){
      var odemelerModal = $('#odemelerModal');
      var odemelerTablo = document.getElementById('odemelerTablo');
      var id = id;
      axios.get(
                'database/randevuIslem.php?tip=odemelerTablo&id='+id
            
                ).then(res => {

                for ( let odemeler of res.data.data ) {

                var tr = document.createElement('tr');
                tr.innerHTML = '<td>'+odemeler.perAdSoyad+'</td><td>'+odemeler.tarih+'</td><td>'+odemeler.alinanTutar+'</td>';
                odemelerTablo.prepend(tr);

                }
                } 
                );


      odemelerModal.modal();
    }


    function detayBtn(id){
      var detayModal = $('#detayModal');
        
            
                axios.get(
                'database/randevuIslem.php?tip=detay&id='+id
                ).then(res => {
                    for ( let randevu of res.data.data ){
                        var AdSoyadSpan = randevu.rAdSoyad;
                        var TarihSpan = randevu.Tarih;
                        var TelefonNumarasiSpan = randevu.TelefonNumarasi;
                        var TcSpan = randevu.Tc;
                        var DogumTarihiSpan = randevu.DogumTarihi;
                        var YapilanIslemSpan = randevu.YapilanIslem;
                        var PaketSpan = randevu.Paket;
                        var EstetisyenSpan = randevu.eAdSoyad;
                        var AtisSayisiSpan = randevu.AtisSayisi;
                        var ReferansSpan = randevu.Referans;
                        var NotlarSpan = randevu.Notlar;
                        var KalanParaSpan = randevu.KalanPara;
                        var SeansSayisiSpan = randevu.SeansSayisi;
                    }
                    document.getElementById("AdSoyadSpan").innerHTML=AdSoyadSpan;
                    document.getElementById("TarihSpan").innerHTML=TarihSpan;
                    document.getElementById("TelefonNumarasiSpan").innerHTML=TelefonNumarasiSpan;
                    document.getElementById("TcSpan").innerHTML=TcSpan;
                    document.getElementById("DogumTarihiSpan").innerHTML=DogumTarihiSpan;
                    document.getElementById("YapilanIslemSpan").innerHTML=YapilanIslemSpan;
                    document.getElementById("PaketSpan").innerHTML=PaketSpan;
                    document.getElementById("EstetisyenSpan").innerHTML=EstetisyenSpan;
                    document.getElementById("AtisSayisiSpan").innerHTML=AtisSayisiSpan;
                    document.getElementById("ReferansSpan").innerHTML=ReferansSpan;
                    document.getElementById("NotlarSpan").innerHTML=NotlarSpan;
                    document.getElementById("KalanParaSpan").innerHTML=KalanParaSpan;
                    document.getElementById("SeansSayisiSpan").innerHTML=SeansSayisiSpan;
                    detayModal.modal();
                }
                  
                  
                );
        
      }
</script>

<script src="js/xlsx.core.min.js"></script>
<script src="js/FileSaver.js"></script>
    
<?php include 'footer.php'; ?>