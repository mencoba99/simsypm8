<?php 
if ($_SESSION['id']!=''){ 
if ($_GET['halaman']==''){
?>
<script type="text/javascript">
	function show1(){
	  document.getElementById('jalur-show').style.display ='block';
	}
	function show2(){
	  document.getElementById('jalur-show').style.display = 'none';
	}
</script>

<?php
	if (isset($_POST['aa'])){
		$id = anti_injection($_POST['id']);
		$a = anti_injection($_POST['a']);
		$b = anti_injection($_POST['b']);
		$c = anti_injection($_POST['c']);
		$d = anti_injection($_POST['d']);
		$e = anti_injection($_POST['e']);
		$f = anti_injection($_POST['f']);
		$g = anti_injection($_POST['g']);
		$h = anti_injection($_POST['h']);
		$i = anti_injection($_POST['i']);
		$j = anti_injection($_POST['j']);
		$k = anti_injection($_POST['k']);
		$l = anti_injection($_POST['l']);
		$m = anti_injection($_POST['m']);
		$n = anti_injection($_POST['n']);
		$o = anti_injection($_POST['o']);
		$p = '';
		$q = '';
		$r = anti_injection($_POST['r']);
		$s = anti_injection($_POST['s']);

		$a1 = anti_injection($_POST['a1']);
		$a2 = anti_injection($_POST['a2']);
		$b1 = anti_injection($_POST['b1']);
		$b2 = anti_injection($_POST['b2']);
		$c1 = anti_injection(tgl_simpan($_POST['c1']));
		$c2 = anti_injection(tgl_simpan($_POST['c2']));
		$d1 = anti_injection($_POST['d1']);
		$d2 = anti_injection($_POST['d2']);
		$e1 = anti_injection($_POST['e1']);
		$e2 = anti_injection($_POST['e2']);
		$f1 = anti_injection($_POST['f1']);
		$f2 = anti_injection($_POST['f2']);
		$g1 = anti_injection($_POST['g1']);
		$g2 = anti_injection($_POST['g2']);
		$h1 = anti_injection($_POST['h1']);
		$h2 = anti_injection($_POST['h2']);
		$i1 = anti_injection($_POST['i1']);
		$i2 = anti_injection($_POST['i2']);
		$j1 = anti_injection($_POST['j1']);
		$j2 = anti_injection($_POST['j2']);

		$aa = anti_injection($_POST['aa']);
		$bb = anti_injection($_POST['bb']);
		$cc = anti_injection($_POST['cc']);

		$longitude = anti_injection($_POST['longitude']);
		$latitude = anti_injection($_POST['latitude']);

		$dusun = anti_injection($_POST['dusun']);
		$kelurahan = anti_injection($_POST['kelurahan']);
		$kecamatan = anti_injection($_POST['kecamatan']);
		$kode_pos = anti_injection($_POST['kode_pos']);
		$email = anti_injection($_POST['email']);
		$prestasi1 = anti_injection($_POST['prestasi1']);
		$prestasi2 = anti_injection($_POST['prestasi2']);
		$optional = anti_injection($_POST['optional1']).'=='.anti_injection($_POST['optional2']).'=='.anti_injection($_POST['optional3']);

		$kode = anti_injection($_POST['id']);
		$tgllahir = anti_injection(tgl_simpan($_POST['tgllahir']));
		$beban = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_keuangan where id_identitas_sekolah='4'"));

		$dir_gambar = '../asset/foto_siswa/';
        $filename = $_FILES['foto']['name'];
        $tipe_file  = $_FILES['foto']['type'];
        $uploadfile = $dir_gambar . $filename;
        $total_db = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM rb_psb_pendaftaran"))+1;
        $no_daftar = date('y').sprintf("%04d", $total_db);
        $pass = sprintf("%04d", rand(10,999));
        if ($tipe_file == "image/jpeg" OR $tipe_file == "image/pjpeg"){
	        if ($filename != ''){
		        	if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadfile)) { 
		        	mysqli_query($koneksi, "INSERT INTO rb_psb_pendaftaran VALUES('','$_SESSION[id]','$pass','$no_daftar','$a','$b','$c','$d','$e','$tgllahir','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p',
																	   '$q','$r','$s','$a1','$b1','$c1','$d1','$e1','$f1','$g1','$h1','$i1','$j1',
																	   '$a2','$b2','$c2','$d2','$e2','$f2','$g2','$h2','$i2','$j2','$aa','$bb','$cc','".date('Y-m-d H:i:s')."','Pending','$beban[id_keuangan_jenis]','$filename','$dusun','$kelurahan','$kecamatan','$kode_pos','$email','$prestasi1','$prestasi2','$optional','$_SERVER[REMOTE_ADDR]','$longitude','$latitude')");
		        	}
	        }else{
				mysqli_query($koneksi, "INSERT INTO rb_psb_pendaftaran VALUES('','$_SESSION[id]','$pass','$no_daftar','$a','$b','$c','$d','$e','$tgllahir','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p',
																   '$q','$r','$s','$a1','$b1','$c1','$d1','$e1','$f1','$g1','$h1','$i1','$j1',
																   '$a2','$b2','$c2','$d2','$e2','$f2','$g2','$h2','$i2','$j2','$aa','$bb','$cc','".date('Y-m-d H:i:s')."','Pending','$beban[id_keuangan_jenis]','','$dusun','$kelurahan','$kecamatan','$kode_pos','$email','$prestasi1','$prestasi2','$optional','$_SERVER[REMOTE_ADDR]','$longitude','$latitude')");
			}
		}else{
			mysqli_query($koneksi, "INSERT INTO rb_psb_pendaftaran VALUES('','$_SESSION[id]','$pass','$no_daftar','$a','$b','$c','$d','$e','$tgllahir','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p',
																   '$q','$r','$s','$a1','$b1','$c1','$d1','$e1','$f1','$g1','$h1','$i1','$j1',
																   '$a2','$b2','$c2','$d2','$e2','$f2','$g2','$h2','$i2','$j2','$aa','$bb','$cc','".date('Y-m-d H:i:s')."','Pending','$beban[id_keuangan_jenis]','','$dusun','$kelurahan','$kecamatan','$kode_pos','$email','$prestasi1','$prestasi2','$optional','$_SERVER[REMOTE_ADDR]','$longitude','$latitude')");
		}
		$idd = mysqli_insert_id($koneksi);
	    for ($i=0; $i<=4; $i++){
	     if (isset($_POST['sa'.$i])){
	     	$mapel = anti_injection($_POST['mapel'.$i]);
	       	$semester1 = anti_injection($_POST['sa'.$i]);
	       	$semester2 = anti_injection($_POST['sb'.$i]);
	       	$semester3 = anti_injection($_POST['sc'.$i]);
	       	$semester4 = anti_injection($_POST['sd'.$i]);
	       	$semester5 = anti_injection($_POST['se'.$i]);
	        if (trim($mapel) != ''){
	       		mysqli_query($koneksi, "INSERT INTO rb_psb_pendaftaran_rapor VALUES('','$idd','$mapel','$semester1','$semester2','$semester3','$semester4','$semester5')");
	       	}
	     }
	    }

	    $aaj = anti_injection($_POST['aaj']);
	    $bbj = anti_injection($_POST['bbj']);
	    $ccj = anti_injection($_POST['ccj']);
	    mysqli_query($koneksi, "INSERT INTO rb_psb_pendaftaran_jalur VALUES('','$idd','$aaj','$bbj','$ccj')");

		echo "<script>document.location='pendaftaran-sukses.mu';</script>";
	}

$d = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_akun where id_psb_akun='$_SESSION[id]'"));
$cek_pendaftaran = mysqli_query($koneksi,"SELECT * FROM rb_psb_pendaftaran where id_psb_akun='$_SESSION[id]'");
if (mysqli_num_rows($cek_pendaftaran)>=1){
	$rr = mysqli_fetch_array($cek_pendaftaran);
	if ($rr['status_seleksi']=='Pending'){
		$d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_info where status='psb_success'"));
		echo "<div class='alert alert-success'>$d[informasi]</p></div>";

		$rekening = mysqli_query($koneksi,"SELECT * FROM rb_psb_rekening where id_identitas_sekolah='4'");
		echo "<a class='btn btn-warning btn-sm' href='index.php?view=pendaftaran&halaman=edit'><span class='glyphicon glyphicon-edit'></span> Edit Data Formulir Pendaftaran</a>

		<table class='table table-condensed table-hovered table-bordered' style='margin-top:10px'>";
		while($row = mysqli_fetch_array($rekening)){
			echo "<tr style='background:#e3e3e3'><td>Nama Bank</td> <td><b style='color:red'>$row[nama_bank]</td></tr>
				  <tr><td width='150px'>Nama Pemilik</td> <td><b>$row[nama_pemilik]</b></td></tr>
				  <tr><td>No Rekening</td> <td><b>$row[no_rekening]</b></td></tr>
				  <tr><td colspan='2'><br></td></tr>";
		}
		echo "</table>";
	}elseif ($rr['status_seleksi']=='Terima'){
		$d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_info where status='psb_valid'"));
		echo "<div class='alert alert-success'>$d[informasi]</p></div>
			  <a target='_BLANK' class='btn btn-success btn-sm' href='print-bukti-ujian.php'><span class='glyphicon glyphicon-print'></span> Print / Cetak Kartu Ujian</a>
			  <a class='btn btn-warning btn-sm' href='index.php?view=pendaftaran&halaman=edit'><span class='glyphicon glyphicon-edit'></span> Edit Data Pendaftaran</a>
			  <div style='clear:both'><br></div>";

		$detail = mysqli_query($koneksi, "SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.id_identitas_sekolah
                            FROM rb_psb_pendaftaran a
                            JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                            JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                              JOIN rb_agama c ON a.id_agama=c.id_agama 
                                JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                                  JOIN rb_agama e ON a.agama_ibu=e.id_agama
                                    where a.id_psb_akun='$_SESSION[id]'");
		$s = mysqli_fetch_array($detail);
	    $ex = explode(' ',$s['waktu_daftar']);
	    $tanggal = $ex[0];
	    $jam = $ex[1];
		echo "<div class='col-md-7'>
              <table class='table table-condensed'>
              <tbody>
              	<tr><th width='160px' scope='row'>No Pendaftaran</th> <td><b style='color:green'>$s[id_aktivasi]</b></td></tr>
              	<tr><th width='160px' scope='row'>Password Ujian</th> <td><b style='color:red'>$s[pass]</b></td></tr>
                <tr><th width='160px' scope='row'>Nama Lengkap</th> <td>$s[nama]</td></tr>
                <tr><th scope='row'>Jenis Kelamin</th> <td>$s[jenis_kelamin]</td></tr>
                <tr><th scope='row'>Tempat / Tgl Lahir</th> <td>$s[tempat_lahir] / ".tgl_indo($s['tanggal_lahir'])."</td></tr>
                <tr><th scope='row'>Agama</th> <td>$s[nama_agama]</td></tr>
                <tr><th scope='row'>Alamat Siswa</th> <td>$s[alamat_siswa]</td></tr>
                <tr><th scope='row'>No Telpon</th> <td>$s[no_telpon]</td></tr>
                <tr><th scope='row'>Email</th> <td>$s[email]</td></tr>
                <tr><th scope='row'>Status/Anak Ke/dari</th> <td>$s[status_dalam_keluarga], / $s[anak_ke] dari $s[jumlah_saudara]</td></tr>
                <tr><th scope='row'></th> <td></td></tr>
              </tbody>
              </table>
            </div>
            <div class='col-md-5'>
              <table class='table table-condensed'>
              <tbody>";
              $ex = explode('==', $s['lainnya']);
                echo "<tr><th width='120px' scope='row'>Prest. Akademik</th> <td>".nl2br($s['prestasi_akademik'])."</td></tr>
                <tr><th width='160px' scope='row'>Prest. Non Akademik</th> <td>".nl2br($s['prestasi_non_akademik'])."</td></tr>
                <tr><th scope='row'>Sekolah Asal</th> <td>$s[sekolah_asal]</td></tr>
                <tr><th scope='row'>No Induk (NISN)</th> <td>$s[no_induk]</td></tr>
                <tr><th scope='row'>Tahun Lulus</th> <td>".$ex[0]."</td></tr>
                <tr><th scope='row'>Akreditasi Sekolah</th> <td>".$ex[1]."</td></tr>
                <tr><th scope='row'>Tahu SMK LIMAKODE </th> <td>".$ex[2]."</td></tr>
                <tr><th scope='row'>Tanggal Daftar</th> <td>".tgl_indo($tanggal).", $jam Wib</td></tr>
              </tbody>
              </table>
            </div>   ";
	}
}else{
?>
<div class="alert alert-info">
    <strong>PSB - Pendaftaran Siswa Baru
</div>

<div class="btn-group btn-breadcrumb" style="text-align:center;margin-bottom:30px;">
	<a class="btn btn-default"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
    <a class="step btn btn-default">Jalur dan Pilihan</a>
    <a class="step btn btn-default">Formulir Pendaftaran</a>
</div>

<br>
<form action="" id="formku" class="form-horizontal" method="post" enctype='multipart/form-data'>
	<div class="tab">
		<div class='col-md-12'>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Jalur Pendaftaran</label>
				<div style="background:#fff;" class="input-group col-lg-6">
					<input style='width:auto !important' type="radio" value='Seleksi Rapor' id='jalur' onclick="show1();" name="aaj" checked> Seleksi Rapor &nbsp; &nbsp; &nbsp; 
					<input style='width:auto !important' type="radio" value='Jalur Tes' id='jalur' onclick="show2();" name="aaj"> Jalur Tes
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Pilihan 1</label>
				<div style="background:#fff;" class="input-group col-lg-8">
					<select class="required form-control" name="bbj">
						<option value=''>- Pilih -</option>
						<?php 
						$data = array('Kimia Industri','Teknik Otomasi Industri');
						for ($i=0; $i < count($data) ; $i++) { 
							echo "<option value='$i'>".$data[$i]."</option>";
						}
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Pilihan 2</label>
				<div style="background:#fff;" class="input-group col-lg-8">
					<select class="form-control" name="ccj">
						<option value=''>- Pilih -</option>
						<?php 
						$data = array('Kimia Industri','Teknik Otomasi Industri');
						for ($i=0; $i < count($data) ; $i++) { 
							echo "<option value='$i'>".$data[$i]."</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="tab">
	<div class='col-md-6'>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Nama Lengkap</label>
			<div style="background:#fff;" class="input-group col-lg-6">
				<input type="text" class="required form-control" value='<?php echo $d[nama_lengkap]; ?>' name="a">
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Jenis Kelamin</label>
			<div style="background:#fff;" class="input-group col-lg-5">
				<select class="required form-control" name="d">
					<option value="" selected="">- Pilih -</option>
					<?php 
						$jk = mysqli_query($koneksi, "SELECT * FROM rb_jenis_kelamin");
						while ($j = mysqli_fetch_array($jk)){
							echo "<option value='$j[id_jenis_kelamin]'>$j[jenis_kelamin]</option>";
						}
					?>
				 </select>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Tempat Lahir</label>
			<div style="background:#fff;" class="input-group col-lg-6">
				<input type="text" class="required form-control" name="e">
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Tanggal Lahir</label>
			<div style="background:#fff;" class="input-group col-lg-4">
				<input type="text" id="datepicker1" class="required form-control" autocomplete='off' name="tgllahir">
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Agama</label>
			<div style="background:#fff;" class="input-group col-lg-5">
				<select class="required form-control" name="f">
					<option value="" selected="">- Pilih -</option>
					<?php 
						$agama = mysqli_query($koneksi, "SELECT * FROM rb_agama");
						while ($a = mysqli_fetch_array($agama)){
							echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
						}
					?>
				 </select>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Alamat Lengkap</label>
			<div style="background:#fff;" class="input-group col-lg-8">
				<textarea class="required form-control" name="j" style="height:60px" minlength="10"></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">No Telpon</label>
			<div style="background:#fff;" class="input-group col-lg-7">
				<input type="number" class="required number form-control" name="k" value='<?php echo $d[no_telpon]; ?>' minlength="11">
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Email</label>
			<div style="background:#fff;" class="input-group col-lg-7">
				<input type="email" class="required email form-control" value='<?php echo $d[email]; ?>' name="email">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Anak Ke</label>
			<div style="background:#fff;" class="input-group col-lg-3">
				<input type="number" class="required form-control" name="g">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Jumlah Saudara</label>
			<div style="background:#fff;" class="input-group col-lg-3">
				<input type="number" class="required form-control" name="h">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Status di Keluarga</label>
			<div style="background:#fff;" class="input-group col-lg-6">
				<select class="required form-control" name="i">
					<option value="" selected="">- Pilih -</option>
					<?php 
						$jk = mysqli_query($koneksi, "SELECT * FROM ms_status_dikeluarga");
						while ($j = mysqli_fetch_array($jk)){
							echo "<option value='$j[status_dikeluarga]'>$j[status_dikeluarga]</option>";
						}
					?>
				 </select>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Longitude</label>
			<div style="background:#fff;" class="input-group col-lg-7">
				<input type="text" class="form-control" name="longitude" placeholder='Dapatkan di google maps..'>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Latitude</label>
			<div style="background:#fff;" class="input-group col-lg-7">
				<input type="text" class="form-control" name="latitude" placeholder='Dapatkan di google maps..'>
			</div>
		</div>

		<input type="hidden" class="required form-control" name="b" value='-'> <!-- Nama Panggilan -->
		<input type="hidden" class="required form-control" name="dusun" value='-'>
		<input type="hidden" class="required form-control" name="kelurahan" value='-'>
		<input type="hidden" class="required form-control" name="kecamatan" value='-'>
		<input type="hidden" class="required form-control" name="kode_pos" value='0'>
	</div>

	<div class='col-md-6'>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Prestasi Akademik</label>
			<div style="background:#fff;" class="input-group col-lg-8">
				<textarea class="form-control" name="prestasi1" style="height:120px" placeholder='1.___________________________'></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-4 control-label">Prestasi Non Akademik</label>
			<div style="background:#fff;" class="input-group col-lg-8">
				<textarea class="form-control" name="prestasi2" style="height:120px" placeholder='1.___________________________'></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Nama Sekolah Asal</label>
			<div style="background:#fff;" class="input-group col-lg-8">
				<input type="text" class="required form-control" name="r">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">No Induk (NISN)</label>
			<div style="background:#fff;" class="input-group col-lg-4">
				<input type="number" class="required number form-control" name="c">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Tahun Lulus</label>
			<div style="background:#fff;" class="input-group col-lg-4">
				<input type="number" class="required number form-control" name="optional1">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Akreditasi Sekolah</label>
			<div style="background:#fff;" class="input-group col-lg-4">
				<input type="text" class="required form-control" name="optional2">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Tahu SMK LIMAKODE Dari</label>
			<div style="background:#fff;" class="input-group col-lg-4">
				<input type="text" class="required form-control" name="optional3">
			</div>
		</div>

		<input type="hidden" class="required form-control" name="l" placeholder='Kilogram (KG)' value='0'>
		<input type="hidden" class="required form-control" name="m" placeholder='Centimeter (Cm)' value='0'>
		<input type="hidden" class="required form-control" name="n" value='-'> <!-- Golongan Darah -->
		<input type="hidden" class="required form-control" name="o" value='-'> <!-- Sakit Pernah Diderita -->
		<input type="hidden" class="required form-control" name="s" value='-'><!-- Alamat Sekolah Asal -->

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Foto (.jpg)</label>
			<div style="background:#fff;" class="input-group col-lg-8">
				<input type="file" class="form-control" name="foto">
				<small><i style='font-weight:400'>Format Foto Hanya Boleh : <b style='color:red'>.jpg</b> Saja!</i></small>
			</div>
		</div>
		</div>

		<div style="clear:both"><br></div>
		<table class="table daftar">
			<tr bgcolor='#e3e3e3' class="alert alert-<?php echo $alert; ?>">
				<th></th>
				<th><center>Data Ayah</center></th>
				<th><center>Data Ibu</center></th>
			</tr>
			<tr>
				<td width='170px' style="padding:0px !important"><label style='padding-right:9px' class="pull-right control-label">Nama Lengkap</label></td>
				<td><input type="text" class="required form-control" style="border-radius:0px;" name="a1"></td>
				<td><input type="text" class="required form-control" style="border-radius:0px;" name="a2"></td>
			</tr>

			<input type="hidden" class="required form-control" style="border-radius:0px;" name="b1" value='-'><!-- Tempat Lahir Ayah -->
			<input type="hidden" class="required form-control" style="border-radius:0px;" name="b2" value='-'><!-- Tempat Lahir Ibu -->
			<input type="hidden" class="required form-control" style="border-radius:0px;" name="c1" value='0000-00-00'><!-- Tanggal Lahir Ayah -->
			<input type="hidden" class="required form-control" style="border-radius:0px;" name="c2" value='0000-00-00'><!-- Tanggal Lahir Ibu -->
			<input type="hidden" class="required form-control" name="d1" value='1'><!-- Agama Ayah -->
			<input type="hidden" class="required form-control" name="d2" value='1'><!-- Agama Ibu -->
			<input type="hidden" class="required form-control" style="border-radius:0px;" name="e1" value='-'><!-- Pendidikan Terakhir Ayah -->
			<input type="hidden" class="required form-control" style="border-radius:0px;" name="e2" value='-'><!-- Pendidikan Terakhir Ibu -->

			<tr>
				<td><label style='padding-right:9px' class="pull-right control-label">Pekerjaan</label></td>
				<td><input type="text" class="required form-control" style="border-radius:0px;" name="f1"></td>
				<td><input type="text" class="required form-control" style="border-radius:0px;" name="f2"></td>
			</tr>

				<input type="hidden" class="required form-control" style="border-radius:0px;" name="g1" value='-'><!-- Alamat Rumah Ayah -->
				<input type="hidden" class="required form-control" style="border-radius:0px;" name="g2" value='-'><!-- Alamat Rumah Ibu -->

			<tr>
				<td><label style='padding-right:9px' class="pull-right control-label">No Telpon / Hp</label></td>
				<td><input type="number" class="required form-control" style="border-radius:0px;" value='0' name="h1"></td>
				<td><input type="number" class="required form-control" style="border-radius:0px;" value='0' name="h2"></td>
			</tr>

				<input type="hidden" class="required form-control" style="border-radius:0px;" name="i1" value='-'><!-- Alamat Kantor Ayah -->
				<input type="hidden" class="required form-control" style="border-radius:0px;" name="i2" value='-'><!-- Alamat Kantor Ibu -->


				<input type="hidden" class="required form-control" style="border-radius:0px;" value='0' name="j1"><!-- No Telpon Kantor Ayah -->
				<input type="hidden" class="required form-control" style="border-radius:0px;" value='0' name="j2"><!-- No Telpon Kantor Ibu -->

		</table>

		<input type="hidden" class="required form-control" name="aa" value='-'><!-- Nama Wali -->
		<input type="hidden" class="required form-control" name="bb" value='-'><!-- Alamat Wali -->
		<input type="hidden" class="required number form-control" value='0' name="cc" minlength="11"><!-- No Telpon Wali -->

		<div style="clear:both"><br></div>
		<table id="jalur-show" class="table daftar">
			<tr bgcolor='#e3e3e3' class="alert alert-<?php echo $alert; ?>">
				<th width='30px'>No</th>
				<th><center>Mata Pelajaran</center></th>
				<th><center>Semester 1</center></th>
				<th><center>Semester 2</center></th>
				<th><center>Semester 3</center></th>
				<th><center>Semester 4</center></th>
				<th><center>Semester 5</center></th>
			</tr>
			<?php 
			$mapel = array('','IPA','Matematika','Bahasa Inggris','Bahasa Indonesia');
			for ($i=1; $i <= 4; $i++){
			echo "<tr>
					<td>$i</td>
					<td><input type='text' class='form-control' style='border-radius:0px;' value='".$mapel[$i]."' name='mapel".$i."' readonly='on'></td>
					<td><input type='number' class='form-control' style='border-radius:0px;' name='sa".$i."'></td>
					<td><input type='number' class='form-control' style='border-radius:0px;' name='sb".$i."'></td>
					<td><input type='number' class='form-control' style='border-radius:0px;' name='sc".$i."'></td>
					<td><input type='number' class='form-control' style='border-radius:0px;' name='sd".$i."'></td>
					<td><input type='number' class='form-control' style='border-radius:0px;' name='se".$i."'></td>
				  </tr>";
			} ?>
		</table>
	</div>
	<div style="clear:both"></div>
	<div style="overflow:auto;">
	    <div style="float:right;">
	      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
	      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
	    </div>
	</div><br>

</form>


<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the crurrent tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("formku").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByClassName("required");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
<?php } 





}elseif($_GET['halaman']=='edit'){
$ss = mysqli_fetch_array(mysqli_query($koneksi,"SELECT id_pendaftaran FROM rb_psb_pendaftaran where id_psb_akun='$_SESSION[id]'"));
	  if (isset($_POST['update'])){
      if (trim($_POST['d'])==''){
          $query = mysqli_query($koneksi, "UPDATE rb_psb_akun SET 
                                       nama_lengkap = '$_POST[a]',
                                       email = '$_POST[b]',
                                       no_telpon = '$_POST[c]' where id_psb_akun='$_SESSION[id]'");  
      }else{
          $query = mysqli_query($koneksi, "UPDATE rb_psb_akun SET 
                                       nama_lengkap = '$_POST[a]',
                                       email = '$_POST[b]',
                                       no_telpon = '$_POST[c]',
                                       password = '".md5($_POST[d])."' where id_psb_akun='$_SESSION[id]'");
      }
                                       
        echo "<script>document.location='index.php?view=pendaftaran&halaman=edit';</script>";

  }

  if (isset($_POST['update_siswa'])){
  	$longitude = anti_injection($_POST['longitude']);
	$latitude = anti_injection($_POST['latitude']);
    $optional = anti_injection($_POST['ss']).'=='.anti_injection($_POST['tt']).'=='.anti_injection($_POST['uu']);
    $query = mysqli_query($koneksi, "UPDATE rb_psb_pendaftaran SET nama = '$_POST[aa]',
                                 id_jenis_kelamin = '$_POST[bb]',
                                 tempat_lahir = '$_POST[cc]',
                                 tanggal_lahir = '$_POST[dd]',
                                 id_agama = '$_POST[ee]',
                                 alamat_siswa = '$_POST[ff]',
                                 no_telpon = '$_POST[gg]',
                                 email = '$_POST[hh]',
                                 anak_ke = '$_POST[ii]',
                                 jumlah_saudara = '$_POST[jj]',
                                 status_dalam_keluarga = '$_POST[kk]',

                                 prestasi_akademik = '$_POST[oo]',
                                 prestasi_non_akademik = '$_POST[pp]',
                                 sekolah_asal = '$_POST[qq]',
                                 no_induk = '$_POST[rr]',
                                 lainnya = '$optional',
                                 longitude = '$longitude',
                                 latitude = '$latitude' where id_pendaftaran='$ss[id_pendaftaran]'");

    mysqli_query($koneksi, "UPDATE rb_psb_pendaftaran_jalur SET jalur = '$_POST[ll]',
                         pilihan1 = '$_POST[mm]',
                         pilihan2 = '$_POST[nn]' where id_pendaftaran='$ss[id_pendaftaran]'");
    echo "<script>document.location='index.php?view=pendaftaran&halaman=edit';</script>";
  }

  if (isset($_POST['update_ortu'])){
    mysqli_query($koneksi, "UPDATE rb_psb_pendaftaran SET nama_ayah = '$_POST[aaa]',
                         pekerjaan_ayah = '$_POST[bbb]',
                         telpon_rumah_ayah = '$_POST[ccc]',
                         nama_ibu = '$_POST[ddd]',
                         pekerjaan_ibu = '$_POST[eee]',
                         telpon_rumah_ibu = '$_POST[fff]' where id_pendaftaran='$ss[id_pendaftaran]'");
    echo "<script>document.location='index.php?view=pendaftaran&halaman=edit';</script>";

  }

  if (isset($_POST['update_rapor'])){
        for ($i=1; $i<=4; $i++){
         if (isset($_POST['sa'.$i])){
          $mapel = anti_injection($_POST['mapel'.$i]);
            $semester1 = $_POST['sa'.$i];
            $semester2 = $_POST['sb'.$i];
            $semester3 = $_POST['sc'.$i];
            $semester4 = $_POST['sd'.$i];
            $semester5 = $_POST['se'.$i];
              mysqli_query($koneksi, "UPDATE rb_psb_pendaftaran_rapor SET semester1='$semester1',
                                                                          semester2='$semester2',
                                                                          semester3='$semester3',
                                                                          semester4='$semester4',
                                                                          semester5='$semester5' where nama_mapel='$mapel' AND id_pendaftaran='$ss[id_pendaftaran]'");
         }
        }
        echo "<script>document.location='index.php?view=pendaftaran&halaman=edit';</script>";
  }

    $detail = mysqli_query($koneksi, "SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.*
                            FROM rb_psb_pendaftaran a
                            JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                            JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                              JOIN rb_agama c ON a.id_agama=c.id_agama 
                                JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                                  JOIN rb_agama e ON a.agama_ibu=e.id_agama
                                    where a.id_pendaftaran='$ss[id_pendaftaran]'");
    $s = mysqli_fetch_array($detail);
    $ex = explode(' ',$s['waktu_daftar']);
    $tanggal = $ex[0];
    $jam = $ex[1];
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Siswa PSB </h3>
                </div>
                <div class='box-body'>

                  <div class='panel-body'>
                    <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                      <li role='presentation' class='active'><a href='#akun' id='akun-tab' role='tab' data-toggle='tab' aria-controls='akun' aria-expanded='true'>Akun </a></li>
                      <li role='presentation' class=''><a href='#siswa' role='tab' id='siswa-tab' data-toggle='tab' aria-controls='siswa' aria-expanded='false'>Data Siswa</a></li>
                      <li role='presentation' class=''><a href='#ortu' role='tab' id='ortu-tab' data-toggle='tab' aria-controls='ortu' aria-expanded='false'>Data Orang Tua</a></li>
                      <li role='presentation' class=''><a href='#rapor' role='tab' id='rapor-tab' data-toggle='tab' aria-controls='rapor' aria-expanded='false'>Nilai Rapor</a></li>
                    </ul><br>

                    <div id='myTabContent' class='tab-content'>
                    <div role='tabpanel' class='tab-pane fade active in' id='akun' aria-labelledby='akun-tab'>
                      <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <div class='col-md-12'>
                          <table class='table table-condensed'>
                          <tbody>
                            <tr><th width='140px' scope='row'>Nama Lengkap</th> <td><input type='text' class='form-control' name='a' value='$s[nama_lengkap]'> </td></tr>
                            <tr><th scope='row'>Username / Email</th> <td><input type='text' class='form-control' name='b' value='$s[email]' onkeyup=\"nospaces(this)\"> </td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='number' class='form-control' name='c' value='$s[no_telpon]'> </td></tr>
                            <tr><th scope='row'>Password</th>          <td><input type='password' class='form-control' name='d'><small><i>Biarkan Kosong jika tidak diubah!</i></small></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update' class='btn btn-info'>Update</button>
                            <a href='index.php?view=pendaftaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                      </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='siswa' aria-labelledby='siswa-tab'>
                        <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-6'>
                          <table class='table table-condensed'>
                          <tbody>
                            <tr><th width='160px' scope='row'>Nama Lengkap</th> <td><input type='text' class='form-control' name='aa' value='$s[nama]'></td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th> <td><select name='bb' class='form-control'>";
                                                                       $jk = mysqli_query($koneksi,"SELECT * FROM rb_jenis_kelamin");
                                                                       while($row = mysqli_fetch_array($jk)){
                                                                        if ($s['id_jenis_kelamin']==$row['id_jenis_kelamin']){
                                                                          echo "<option value='$row[id_jenis_kelamin]' selected>$row[jenis_kelamin]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_jenis_kelamin]'>$row[jenis_kelamin]</option>";
                                                                        }
                                                                       }
                                                                       echo "</select></td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' name='cc' value='$s[tempat_lahir]'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control' name='dd' value='$s[tanggal_lahir]'></td></tr>
                            <tr><th scope='row'>Agama</th> <td><select name='ee' class='form-control'>";
                                                                       $ag = mysqli_query($koneksi,"SELECT * FROM rb_agama");
                                                                       while($row = mysqli_fetch_array($ag)){
                                                                        if ($s['id_agama']==$row['id_agama']){
                                                                          echo "<option value='$row[id_agama]' selected>$row[nama_agama]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_agama]'>$row[nama_agama]</option>";
                                                                        }
                                                                       }
                                                                       echo "</select></td></tr>
                            <tr><th scope='row'>Alamat Siswa</th> <td><textarea class='form-control' name='ff'>$s[alamat_siswa]</textarea></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='number' class='form-control' name='gg' value='$s[no_telpon]'></td></tr>
                            <tr><th scope='row'>Email</th> <td><input type='email' class='form-control' name='hh' value='$s[email]'></td></tr>
                            <tr><th scope='row'>Anak Ke / dari</th> <td><input style='display:inline-block; width:70px' type='text' class='form-control' name='ii' value='$s[anak_ke]'> 
                                                                        / <input style='display:inline-block; width:70px' type='text' class='form-control' name='jj' value='$s[jumlah_saudara]'></td></tr>
                            <tr><th scope='row'>Status</th> <td><select class='form-control' name='kk'>";
                                                                  $jk = mysqli_query($koneksi, "SELECT * FROM ms_status_dikeluarga");
                                                                  while ($j = mysqli_fetch_array($jk)){
                                                                    if ($s['status_dikeluarga']==$s['status_dikeluarga']){
                                                                      echo "<option value='$j[status_dikeluarga]' selected>$j[status_dikeluarga]</option>";
                                                                    }else{
                                                                      echo "<option value='$j[status_dikeluarga]'>$j[status_dikeluarga]</option>";
                                                                    }
                                                                  }
                                                               echo "</select>
                            </td></tr>
                            <tr><th scope='row'>Longitude</th> <td><input type='text' class='form-control' name='longitude' value='$s[longitude]'></td></tr>
                            <tr><th scope='row'>Latitude</th> <td><input type='text' class='form-control' name='latitude' value='$s[latitude]'></td></tr>

                          </tbody>
                          </table>
                        </div>
                        <div class='col-md-6'>
                          <table class='table table-condensed'>
                          <tbody>";
                          $ex = explode('==', $s['lainnya']);
                          $jal = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_pendaftaran_jalur where id_pendaftaran='$ss[id_pendaftaran]'"));
                          if ($jal['pilihan1']=='0'){ $pilihan1 = 'Kimia Industri'; }elseif($jal['pilihan1']=='1'){ $pilihan1 = 'Teknik Otomasi Industri'; }else{ $pilihan1 = '-'; }
                          if ($jal['pilihan2']=='0'){ $pilihan2 = 'Kimia Industri'; }elseif($jal['pilihan2']=='1'){ $pilihan2 = 'Teknik Otomasi Industri'; }else{ $pilihan2 = '-'; }
                            echo "
                            <tr><th width='120px' scope='row'>Jalur Daftar</th> <td><select name='ll' class='form-control'>";
                                                                                  $jalur = array('Seleksi Rapor','Jalur Tes');
                                                                                  for ($i=0; $i < count($jalur); $i++) { 
                                                                                    if ($jal['jalur']==$jalur[$i]){
                                                                                      echo "<option value='".$jalur[$i]."' selected>".$jalur[$i]."</option>";
                                                                                    }else{
                                                                                      echo "<option value='".$jalur[$i]."'>".$jalur[$i]."</option>";
                                                                                    }
                                                                                  }
                                                                                    echo "</select></td></tr>
                            <tr><th width='120px' scope='row'>Pilihan 1</th> <td><select class='form-control' name='mm'>";
                                                                                    $data = array('Kimia Industri','Teknik Otomasi Industri');
                                                                                    for ($i=0; $i < count($data) ; $i++) { 
                                                                                      if ($jal['pilihan1']==$i){
                                                                                        echo "<option value='$i' selected>".$data[$i]."</option>";
                                                                                      }else{
                                                                                        echo "<option value='$i'>".$data[$i]."</option>";
                                                                                      }
                                                                                    }
                                                                                echo "</select></td></tr>
                            <tr><th width='120px' scope='row'>Pilihan 2</th> <td><select class='form-control' name='nn'>";
                                                                                    $data = array('Kimia Industri','Teknik Otomasi Industri');
                                                                                    for ($i=0; $i < count($data) ; $i++) { 
                                                                                      if ($jal['pilihan2']==$i){
                                                                                        echo "<option value='$i' selected>".$data[$i]."</option>";
                                                                                      }else{
                                                                                        echo "<option value='$i'>".$data[$i]."</option>";
                                                                                      }
                                                                                    }
                                                                                echo "</select></td></tr>
                            
                            <tr><th width='120px' scope='row'>Prest. Akademik</th> <td><textarea class='form-control' name='oo'>$s[prestasi_akademik]</textarea></td></tr>
                            <tr><th width='160px' scope='row'>Prest. Non Akademik</th> <td><textarea class='form-control' name='pp'>$s[prestasi_non_akademik]</textarea></td></tr>
                            <tr><th scope='row'>Sekolah Asal</th> <td><input type='text' class='form-control' name='qq' value='$s[sekolah_asal]'></td></tr>
                            <tr><th scope='row'>No Induk (NISN)</th> <td><input type='text' class='form-control' name='rr' value='$s[no_induk]'></td></tr>
                            <tr><th scope='row'>Tahun Lulus</th> <td><input type='text' class='form-control' name='ss' value='".$ex[0]."'></td></tr>
                            <tr><th scope='row'>Akreditasi Sekolah</th> <td><input type='text' class='form-control' name='tt' value='".$ex[1]."'></td></tr>
                            <tr><th scope='row'>Tahu SMK LIMAKODE</th> <td><input type='text' class='form-control' name='uu' value='".$ex[2]."'></td></tr>
                          </tbody>
                          </table>
                        </div>   
                        <div class='box-footer'>
                            <button type='submit' name='update_siswa' class='btn btn-info'>Update</button>
                            <a href='index.php?view=pendaftaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='ortu' aria-labelledby='ortu-tab'>
                        <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-12'>
                          <table class='table table-condensed'>
                          <tbody>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ayah</th> <td><input type='text' class='form-control' name='aaa' value='$s[nama_ayah]'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' name='bbb' value='$s[pekerjaan_ayah]'></td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td><input type='text' class='form-control' name='ccc' value='$s[telpon_rumah_ayah]'></td></tr>

                            <tr><th scope='row' coslpan='2'><br></th></tr>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ibu</th> <td><input type='text' class='form-control' name='ddd' value='$s[nama_ibu]'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' name='eee' value='$s[pekerjaan_ibu]'></td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td><input type='text' class='form-control' name='fff' value='$s[telpon_rumah_ibu]'></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update_ortu' class='btn btn-info'>Update</button>
                            <a href='index.php?view=pendaftaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='rapor' aria-labelledby='rapor-tab'>
                        <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-12'>
                          <table class='table table-striped table-condensed'>
                            <thead>
                              <tr bgcolor=#e3e3e3>
                                <th width='30px'>No</th>
                                <th>Nama Mapel</th>
                                <th>Semester 1</th>
                                <th>Semester 2</th>
                                <th>Semester 3</th>
                                <th>Semester 4</th>
                                <th>Semester 5</th>
                              </tr>
                            </thead>
                            <tbody>";
                            $tampil = mysqli_query($koneksi, "SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$ss[id_pendaftaran]'");
                            $i = 1;
                            while($r=mysqli_fetch_array($tampil)){
                            echo "<tr>
                                    <td>$i</td>
                                    <td><input type='text' class='form-control' style='border-radius:0px;' value='$r[nama_mapel]' name='mapel".$i."' readonly='on'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sa".$i."' value='$r[semester1]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sb".$i."' value='$r[semester2]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sc".$i."' value='$r[semester3]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sd".$i."' value='$r[semester4]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='se".$i."' value='$r[semester5]'></td>
                                  </tr>";
                              $i++;
                              }
                            echo "</tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update_rapor' class='btn btn-info'>Update</button>
                            <a href='index.php?view=pendaftaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>";
}

} ?>
