<style type="text/css">
.judul{
	border-left:5px solid #337ab7; border-radius:0px; padding:6px; font-weight:bold; margin-bottom: 5px;
}
</style>
<?php
echo "<div class='alert alert-success'>Jadwal Pendaftaran dan Seleksi</div>";
echo "<div class='col-md-12'>";
		$jadwal = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_jadwal"));
  	  	echo "<table width='100%'>
  	  			<tr><td width='130px'>Pelaksanaan Test</td> <td> : ".hari_ini($jadwal['pelaksanaan']).", ".tgl_indo($jadwal['pelaksanaan'])."</td></tr>
  	  			<tr><td>Pengumuman Test</td> <td> : ".hari_ini($jadwal['pengumuman']).", ".tgl_indo($jadwal['pengumuman'])."</td></tr>
  	  		  </table><br>";
  	  echo "</div>";

