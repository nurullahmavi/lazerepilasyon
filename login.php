<?php
session_start();
ob_start();
if(isset($_SESSION['girisBasarili'])){
if($_SESSION['girisBasarili'] == true){
  header('Location:index.php');
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Giriş Yap</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" <!-- End layout styles -->
    <link rel="shortcut icon" href="images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <h2>Giriş Yap</h2>
                </div>
                <?php
                if(isset($_SESSION['girisBasarisiz'])){
                  ?>
                  <div class="alert alert-danger">Kullanıcı adı veya şifre hatalı</div>
                  <?php
                  session_destroy();
                }
                ?>
                <form class="pt-3" id="loginForm" action="database/loginCheck.php" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="UserName" id="UserName" placeholder="Kullanıcı Adı">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="Sifre" name="Sifre" placeholder="Şifre">
                  </div>
                  
                  <div class="mb-2">
                    <button type="button" id="btnLogin" class="btn btn-block btn-facebook auth-form-btn">Giriş Yap </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
      $('#btnLogin').click(()=>{
            let UserName = document.querySelector('#UserName').value;
            let Sifre = document.querySelector('#Sifre').value;
            if(UserName.trim()== ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Kullanıcı adını girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else if(Sifre.trim() == ''){
                Swal.fire({
                  icon: 'info',
                  title: 'Olmadı',
                  text: 'Şifreni girmelisin',
                  confirmButtonText: 'Tamam'
                });
            }else{
                $('#loginForm').submit();
            }

            
        });
    </script>
  </body>
</html>