<?php
$cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_setting where id_setting='1'"));
if ($cek['aktif']=='Tidak'){
    $query = mysqli_query($koneksi, "SELECT * FROM rb_psb_halaman where id_halaman='5'");
    $row = mysqli_fetch_array($query);
	echo "<div class='alert alert-success'>$row[judul]</div>
	      <p>".nl2br($row['isi_halaman'])."</p>";
}else{
    
echo "<div class='alert alert-success'>Masukkan Data anda yang sebenarnya,...</div>
<div class='col-xs-12 col-md-12'>";
if (isset($_GET['gagal'])){
    echo "<div class='alert alert-danger'>Maaf Terjadi Kesalahan, anda Gagal Mendaftar,..</div>";
}
echo "<form action='' method='POST' id='formku' class='form-horizontal' role='form'>
    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Nama Lengkap</label>
        <div class='col-xs-9 col-sm-9'>
        <div style='background:#fff;' class='input-group col-sm-11'>
            <input type='text' class='required form-control' name='a'placeholder='---------------------' autocomplete=off>
        </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Username / Email</label>
        <div class='col-xs-9 col-sm-9'>
        <div style='background:#fff;' class='input-group col-sm-11'>
            <input type='text' class='required form-control' name='b' onkeyup=\"nospaces(this)\" autocomplete=off>
        </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>No Telpon</label>
        <div class='col-xs-9 col-sm-9'>
        <div style='background:#fff;' class='input-group col-sm-11'>
            <input type='number' class='required form-control' name='cc' placeholder='08**********' onkeyup=\"nospaces(this)\" autocomplete=off>
        </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Password</label>
        <div class='col-xs-9 col-sm-9'>
        <div style='background:#fff;' class='input-group col-sm-11'>
            <input type='password' class='required form-control' placeholder='*************' name='d' onkeyup=\"nospaces(this)\" autocomplete=off>
        </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Security</label>
        <div class='col-xs-9 col-sm-9'>
        <div style='background:#e3e3e3;' class='input-group col-sm-11'>
            <input style='background:#e3e3e3;border:0px; padding:0px; display:inline-block; width:50px; text-align:right' type='number' class='required number' value='".rand(1,25)."' placeholder='*************' name='angka1' onkeyup=\"nospaces(this)\" autocomplete=off readonly=on> + 
            <input style='background:#e3e3e3;border:0px; padding:0px; display:inline-block; width:50px; text-align:right' type='number'  value='".rand(1,25)."' class='required number' placeholder='*************' name='angka2' onkeyup=\"nospaces(this)\" autocomplete=off  readonly=on> = 
            <input type='number' class='required form-control' name='c' placeholder='Jawaban' onkeyup=\"nospaces(this)\" autocomplete=off>
        </div>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'></label>
        <div class='col-xs-9 col-sm-9'>
        <div class='input-group col-sm-11'>
            <input style='width:150px' class='btn btn-primary' type='submit' name='submit' value='Mendaftar'>
        </div>
        </div>
    </div>
    <br>
</form>
</div>
<div style='clear:both'><br></div>";

if (isset($_POST['submit'])){
$angka=anti_injection($_POST['angka1']+$_POST['angka2']);
$hasil=anti_injection($_POST['c']);
    if ($angka==$hasil){
     $a=anti_injection($_POST['a']);
     $b=anti_injection($_POST['b']);
     $c=anti_injection($_POST['cc']);
     $d=md5(anti_injection($_POST['d']));
     $calon = mysqli_query($koneksi, "INSERT INTO rb_psb_akun VALUES('','4','$a','$b','$c','$d','$_SERVER[REMOTE_ADDR]','".date('Y-m-d H:i:s')."')");
     $id = mysqli_insert_id($koneksi);
        if ($calon){
            $r = mysqli_fetch_array($calon);
            $_SESSION['id']     = $id;
            $_SESSION['level']    = 'Calon';
            echo "<script>document.location='index.php?view=profile';</script>";
        }else{
            echo "<script>document.location='index.php?view=register&gagal';</script>";
        }
    }else{
        echo "<script>document.location='index.php?view=register&gagal';</script>";
    }
}

}
?>



