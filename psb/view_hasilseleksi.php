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
if (is_numeric($_GET['sekolah'])){
$jen = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_jenjang where id_jenjang='$_GET[sekolah]'"));
	echo "<div class='alert alert-success'>Hasil seleksi Unit <b>$jen[nama_jenjang]</b></div>
			<table id='example1' class='table table-bordered table-striped'>
		                    <thead>
		                      <tr bgcolor='#e3e3e3'>
		                        <th>No</th>
		                        <th>No Induk</th>
		                        <th>Nama Siswa</th>
		                        <th>Jenis Kelamin</th>
		                        <th></th>
		                       </tr>
		                    </thead>
		                    <tbody>";
		                    if (isset($_GET['sekolah'])){
		                      $tampil = mysqli_query($koneksi, "SELECT * FROM rb_psb_pendaftaran a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin 
		                                                JOIN rb_psb_aktivasi c ON a.id_aktivasi=c.id_aktivasi 
		                                                	JOIN rb_identitas_sekolah d ON c.id_identitas_sekolah=d.id_identitas_sekolah
		                                                		JOIN rb_jenjang e ON d.id_jenjang=e.id_jenjang 
		                                                			where e.id_jenjang='$_GET[sekolah]' AND a.status_seleksi='Terima' 
		                                                   ORDER BY a.id_pendaftaran DESC");
		                    }else{
		                      $tampil = mysqli_query($koneksi, "SELECT * FROM rb_psb_pendaftaran a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin 
		                                                JOIN rb_psb_aktivasi c ON a.id_aktivasi=c.id_aktivasi where a.status_seleksi='Terima' 
		                                                   ORDER BY a.id_pendaftaran DESC");
		                    }
		                    $no = 1;
		                    while($r=mysqli_fetch_array($tampil)){
		                    echo "<tr>
		                              <td>$no</td>
		                              <td>$r[no_induk]</td>
		                              <td>$r[nama]</td>
		                              <td>$r[jenis_kelamin]</td>
		                              <td><i style='color:green'>Lulus</i></td>
		                            </tr>";
		                      $no++;
		                      }

		                    echo "</tbody>
		                  </table>";
}
	
