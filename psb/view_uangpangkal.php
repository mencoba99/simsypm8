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
	echo "<ul class='nav nav-tabs' role='tablist'>";
	$jenjang = mysqli_query($koneksi,"SELECT * FROM rb_jenjang ORDER BY id_jenjang");
	$no = 1;
	while($jen = mysqli_fetch_array($jenjang)){
		if ($no==1){ $aktif ='active'; }else{ $aktif =''; }
		echo "<li role='presentation' class='$aktif'><a href='#$jen[id_jenjang]' aria-controls='$jen[id_jenjang]' role='tab' data-toggle='tab'>$jen[nama_jenjang]</a></li>";
	$no++;
	}
	echo "</ul>";


	echo "<br><div class='tab-content'>";
	$jenjang1 = mysqli_query($koneksi,"SELECT * FROM rb_jenjang ORDER BY id_jenjang");
	$no = 1;
	while($jen = mysqli_fetch_array($jenjang1)){
	if ($no==1){ $aktif ='active'; }else{ $aktif =''; }
	echo "<div role='tabpanel' class='tab-pane $aktif' id='$jen[id_jenjang]'>
			<div class='alert alert-success'>Uang Pangkal berdasarkan hasil seleksi Unit $jen[nama_jenjang]</div><br>";
	$gel = array('1','2','3');
		for ($i=0; $i < 3 ; $i++) { 
			echo "<div class='col-md-4' style='margin:3px; margin-top:-10px'>
					<p style='border-bottom:1px dotted #000;'><b>Gelombang ".$gel[$i]."</b></p>";
					$ga = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_uangpangkal where id_gelombang='".$gel[$i]."' AND grade='A' AND id_jenjang='$jen[id_jenjang]'"));
					$gb = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_uangpangkal where id_gelombang='".$gel[$i]."' AND grade='B' AND id_jenjang='$jen[id_jenjang]'"));
					$gc = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_uangpangkal where id_gelombang='".$gel[$i]."' AND grade='C' AND id_jenjang='$jen[id_jenjang]'"));
		      	  	echo "<table width='100%'>
		      	  			<tr><td width='60px'>Grade A</td> <td> : ".rupiah($ga['nominal'])."</td></tr>
		      	  			<tr><td>Grade B</td> <td> : ".rupiah($gb['nominal'])."</td></tr>
		      	  			<tr><td>Grade C</td> <td> : ".rupiah($gc['nominal'])."</td></tr>
		      	  		  </table>";
		      	  echo "</div>";
		}
		echo "</div>";
		$no++;
	}
	echo "</div>";
