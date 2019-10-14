<style type="text/css">
@media (min-width: 992px){
	.col-md-4 {
	    width: 32.33333333%;
	}
}
.judul{
	border-left:5px solid #337ab7; border-radius:0px; padding:6px; font-weight:bold;
}
</style>
<?php
	echo "<div class='alert alert-info'>Data Riwayat Pekerjaan</div><br>";
	echo "<div>";
		echo "<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
		<div class='col-md-12'>
			<table class='table table-condensed'>
				<tbody>
					<tr>
						<th width='140px' scope='row'>Nama Perusahaan</th> 
						<td><input type='text' class='form-control' name='a' autocomplete='off'></td>
					</tr>
					<tr>
						<th scope='row'>Pimpinan Perusahaan</th> 
						<td><input type='text' class='form-control' name='b' autocomplete='off'> </td>
					</tr>
					<tr>
						<th scope='row'>Alamat Perusahaan</th> 
						<td><textarea class='form-control' name='c'></textarea></td>
					</tr>
					<tr>
						<th scope='row'>Jabatan</th> 
						<td><input type='text' class='form-control' name='d' autocomplete='off'> </td>
					</tr>
					<tr>
						<th scope='row'>Tahun Mulai Bekerja</th> 
						<td><input type='number' min='1900' max='2099' class='form-control' name='e' autocomplete='off'> </td>
					</tr>
					<tr>
						<th scope='row'>Tahun Berhenti Bekerja</th> 
						<td><input type='number' max='2099' class='form-control' name='f' autocomplete='off'><small>*. Bila masih bekerja isikan dengan angka (0).</small></td>
					</tr>
					<tr>
						<th scope='row'>Gaji Bulanan</th> 
						<td><input type='number' class='form-control' name='g' autocomplete='off''> </td>
					</tr>
					<tr>
						<th scope='row'>Keterangan</th> 
						<td><textarea class='form-control' name='h'></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class='box-footer'>
			<button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
			<a href='index.php?view=profile'><button type='button' class='btn btn-default pull-right'>Kembali</button></a>
		</div>
	</form>
	<br/>";
	echo "</div>";

	if (isset($_POST['submit'])) {
		$a=anti_injection($_POST['a']);
		$b=anti_injection($_POST['b']);
		$c=anti_injection($_POST['c']);
		$d=anti_injection($_POST['d']);
		$e=anti_injection($_POST['e']);
		$f=anti_injection($_POST['f']);
		$g=anti_injection($_POST['g']);
		$h=anti_injection($_POST['h']);

		$riwayat = mysqli_query($koneksi, "INSERT INTO rb_lk_riwayat_tracer VALUES ('','$_SESSION[id]', '$a', '$b', '$c', '$d', '$e', '$f', '$g', 'Aktif', '$h')");
		
		$id = mysqli_insert_id($koneksi);
		
		if ($riwayat){
			echo "<script>document.location='index.php?view=profile';</script>";
		} else {
			echo "<script>document.location='index.php?view=register&gagal';</script>";
		}
	}

	
