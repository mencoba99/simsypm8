<ul class="nav navbar-nav">
<?php
  $menu = mysqli_query($koneksi, "SELECT * FROM rb_lk_tracer_menu where id_parent='0' AND aktif='Ya' ORDER BY urutan ASC");
  while($dataMenu = mysqli_fetch_assoc($menu)){
    $menu_id = $dataMenu['id'];
    $submenu = mysqli_query($koneksi, "SELECT * FROM rb_lk_tracer_menu WHERE id_parent='$menu_id' AND aktif='Ya' ORDER BY urutan ASC");
    if(mysqli_num_rows($submenu) == 0){
      echo '<li><a href="'.$dataMenu['link'].'"><i class="glyphicon glyphicon-'.$dataMenu['icon'].'"></i> '.$dataMenu['nama_menu'].'</a></li>';
    }else{
      echo '
      <li class="dropdown">
        <a href="'.$dataMenu['link'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-'.$dataMenu['icon'].'"></i> '.$dataMenu['nama_menu'].' <span class="caret"></span></a>
        <ul class="dropdown-menu">';
        while($dataSubmenu = mysqli_fetch_assoc($submenu)){
          echo '<li><a href="'.$dataSubmenu['link'].'">'.$dataSubmenu['nama_menu'].'</a></li>';
        }
      echo '
        </ul>
      </li>
      ';
    }
  }

  if ($_SESSION['level']!='Calon'){
    echo "<li><a href='login.ta'> Login</a></li>
          <li><a href='register.ta'> Register</a></li>";
  }else{
    echo "<li><a href='index.php?view=profile'> Profile</a></li>";
    echo "<li><a href='index.php?view=riwayat'> Riwayat Pekerjaan</a></li>";
  }
echo "</ul>";

if ($_SESSION['level']=='Calon'){
  $ce = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_humas_traceralumni where id_traceralumni = '$_SESSION[id]'"));
  echo "<ul class='nav navbar-nav navbar-right'>
  <li class='dropdown'>
    <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Halo! $ce[nama] <span class='caret'></span></a>
    <ul class='dropdown-menu'>
      <li><a href='index.php?view=profile'>Profile Anda</a></li>
      <li><a href='logout.php'>Logout</a></li>
    </ul>
  </li>
  </ul>";
} 
?>
