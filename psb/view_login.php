<div class='alert alert-info'>Masukkan username dan password pada form berikut untuk login,...</div>
<br>
<div class="logincontainer">
    <form method="post" action="" role="form" id='formku'>
        <div class="form-group">
            <label for="inputEmail">Username / Email</label>
            <input type="text" name="a" class="required form-control" placeholder="Masukkan No Telpon / Username / Email" autofocus="" onkeyup="nospaces(this)">
        </div>

        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" name="b" class="form-control required" placeholder="Masukkan Password" autocomplete="off">
        </div>

        <div align="center">
            <input style='width:100px' name='login' type="submit" class="btn btn-primary" value="Login"> 
            <a href="#" class="btn btn-default" data-toggle='modal' data-target='#lupass'>Lupa Password Anda?</a> 
        </div>
    </form>
</div>

<?php 
if (isset($_POST['login'])){
 $pass=md5(anti_injection($_POST['b']));
 $calon = mysqli_query($koneksi, "SELECT * FROM rb_psb_akun WHERE (email='".anti_injection($_POST['a'])."' OR no_telpon='".anti_injection($_POST['a'])."') AND password='$pass'");
 $hitungcalon = mysqli_num_rows($calon);
 if ($hitungcalon >= 1){
    $r = mysqli_fetch_array($calon);
    $_SESSION['id']     = $r['id_psb_akun'];
    $_SESSION['level']    = 'Calon';
    echo "<script>document.location='index.php?view=profile';</script>";
 }else{
    echo "<script>window.alert('Maaf, Anda Tidak Memiliki akses');
                                  window.location=('index.php?view=login')</script>";
 }
}
?>