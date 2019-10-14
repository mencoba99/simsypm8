<?php 
	if ($_GET['view']=='home' OR $_GET['view']==''){
		include "view_home.php";
	}elseif($_GET['view']=='halaman'){
		include "view_halaman.php";
	}elseif($_GET['view']=='pendaftaran'){
		if ($_SESSION['level']!=''){
			include "pendaftaran.php";
		}
	}elseif($_GET['view']=='pendaftaran_ulang'){
		if ($_SESSION['level']!=''){
			include "pendaftaran_ulang.php";
		}
	}elseif($_GET['view']=='sukses'){
		include "view_sukses.php";
	}elseif($_GET['view']=='pengumuman'){
		include "view_pengumuman.php";
	}elseif($_GET['view']=='riwayat'){
		include "view_riwayat.php";
	}elseif($_GET['view']=='contact'){
		include "view_contact.php";
	}elseif($_GET['view']=='login'){
		include "view_login.php";
	}elseif($_GET['view']=='register'){
		include "view_register.php";
	}elseif($_GET['view']=='profile'){
		include "view_profile.php";
	}elseif($_GET['view']=='profile'){
		include "view_profile.php";
	}
?>