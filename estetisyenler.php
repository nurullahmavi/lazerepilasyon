<?php include 'header.php';?>
<div class="row">
    <div class="col-md-4">
            <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Yeni Estetisyen Ekle</h4>
              <form class="forms-sample" method="POST" id="formEstetisyen">
                  <div class="form-group">
                    <label for="AdSoyad">Ad Soyad</label>
                    <input type="text" class="form-control" name="AdSoyad" id="AdSoyad" placeholder="Ad Soyad">
                  </div>

                <button type="submit" id="btnEkle" class="btn btn-primary mr-2">Ekle</button>
              </form>
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-8">
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Estetisyenler</h4>
                    </p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Ad Soyad</th>
                          <th>İşlem</th>
                        </tr>
                      </thead>
                      <tbody id="estetisyenler">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
    </div>
</div>


<!-- Modal -->
<div id="estModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Düzenle</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <form class="forms-sample" method="POST" id="formEstetisyen">
                  <div class="form-group">
                    <label for="AdSoyadDuzenle">Ad Soyad</label>
                    <input type="text" class="form-control" name="AdSoyadDuzenle" id="AdSoyadDuzenle" placeholder="Ad Soyad">
                    <input type="hidden" class="form-control" name="idDuzenle" id="idDuzenle">
                  </div>

                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
        <button type="submit" id="btnKaydet" class="btn btn-primary mr-2">Kaydet</button>
              </form>
      </div>
    </div>

  </div>
</div>

<script>
$(function(){
    let estetisyenler = document.querySelector('#estetisyenler');
  axios.get('database/estetisyenIslemler.php?tip=all').then((res) => {
    for ( let estetisyen of res.data.data ) {
        var tr = document.createElement('tr');
        tr.setAttribute('id','row_'+estetisyen.id);
        tr.innerHTML = '<td>'+estetisyen.AdSoyad+'</td><td><div class="btn-group"><button class="btn-danger btn-sm btn sil" onclick="silBtn('+estetisyen.id+')" type="button">Sil</button><button class="btn-primary btn-sm btn sil" onclick="DuzenleBtn('+estetisyen.id+')" type="button">Düzenle</button></div></td>'
        estetisyenler.prepend(tr);
    }
  });

});

function silBtn(id){
            Swal.fire({
              title: 'Silmek istediğizden emin misiniz',
              text: "Bu veri kalıcı olarak silinecektir!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Evet Sil',
              cancelButtonText: 'İptal'
            }).then((result) => {
              if (result.isConfirmed) {
                axios.get(
                'database/estetisyenIslemler.php?tip=sil&id='+id
                ).then(res => 
                  Swal.fire(
                    res.data.title,
                    res.data.message,
                    res.data.type
                  ),
                  $('#row_'+id).remove()
                );
                
                
              }
            })
        
      }

function DuzenleBtn(id){
      var estModal = $('#estModal');
      axios.get('database/estetisyenIslemler.php?tip=kim&id='+id).then( res =>{
        //console.log(res);
        for ( let estetisyen of res.data.data ){
            var estAdSoyad = estetisyen.AdSoyad;
            var estID = estetisyen.id;
        }
        document.querySelector('#AdSoyadDuzenle').value = estAdSoyad;
        document.querySelector('#idDuzenle').value = estID;
        estModal.modal();
      }


      );
      
  
}


$('#btnEkle').on("click",function(e){
    e.preventDefault();
            let AdSoyad = document.querySelector('#AdSoyad').value;
            let estetisyenler = document.querySelector('#estetisyenler');
            if(AdSoyad.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Ad Soyad girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else{
                
                axios.post(
                'database/estetisyenIslemler.php?tip=ekle',"AdSoyad="+AdSoyad
            
                ).then(res => {
                Swal.fire({
                      icon: res.data.type,
                      title: res.data.title,
                      text: res.data.message,
                });
                var tr = document.createElement('tr');
                tr.setAttribute('id','row_'+res.data.data.id);
                tr.innerHTML = '<td>'+res.data.data.AdSoyad+'</td><td><div class="btn-group"><button class="btn-danger btn-sm btn sil" onclick="silBtn('+res.data.data.id+')" type="button">Sil</button><button class="btn-primary btn-sm btn sil" onclick="DuzenleBtn('+res.data.data.id+')" type="button">Düzenle</button></div></td>'
                estetisyenler.prepend(tr);
                document.getElementById('AdSoyad').value = "";
                } 
                );
            }

            
        });


        $('#btnKaydet').on("click",function(e){
    e.preventDefault();
            let AdSoyadDuzenle = document.querySelector('#AdSoyadDuzenle').value;
            let id = document.querySelector('#idDuzenle').value;
            let estetisyenler = document.querySelector('#estetisyenler');
            if(AdSoyadDuzenle.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Ad Soyad girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else{
                
                axios.post(
                'database/estetisyenIslemler.php?tip=duzenle',"AdSoyad="+AdSoyadDuzenle+"&id="+id
            
                ).then(res => {
                
                window.location.reload();

                } 
                );
            }

            
        });
</script>

<?php include 'footer.php';?>