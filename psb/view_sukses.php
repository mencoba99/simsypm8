<?php
$d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_info where status='psb_success'"));
	echo "<div class='alert alert-success'>$d[informasi]</p></div>
			<a class='btn btn-warning btn-sm' href='index.php?view=pendaftaran&halaman=edit'><span class='glyphicon glyphicon-edit'></span> Edit Data Formulir Pendaftaran</a>";

	$rekening = mysqli_query($koneksi,"SELECT * FROM rb_psb_rekening where id_identitas_sekolah='4'");
	echo "<table class='table table-condensed table-hovered table-bordered' style='margin-top:10px'>";
	while($row = mysqli_fetch_array($rekening)){
		echo "<tr style='background:#e3e3e3'><td>Nama Bank</td> <td><b style='color:red'>$row[nama_bank]</b></td></tr>
			  <tr><td>Nama Pemilik</td> <td>$row[nama_pemilik]</td></tr>
			  <tr><td>No Rekening</td> <td>$row[no_rekening]</td></tr>
			  <tr><td colspan='2'><br></td></tr>";
	}
	echo "</table>";
