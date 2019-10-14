<style type="text/css">
.navbar-nav>li>a {
    padding-top: 20px;
    padding-bottom: 20px;
}
</style>
        <!-- Logo -->
        <a href="<?php echo base_url().$sekolah[keyword]; ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
              <b style="font-size:22px"><span style="color:red">S</span>IA</b>
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
              <b style="font-size:22px"><span style="color:red">SIM</span>ASTA</b>
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <?php 
              /*if ($sekolah['keyword']!=$this->uri->segment(1) AND $this->uri->segment(1)!='ktsp_'.$sekolah['keyword']){
                redirect($sekolah['keyword']);
              }*/
              if ($this->session->level=='guru'){ $aksi = 'edit_guru'; }elseif ($this->session->level=='guru'){ $aksi = 'edit_siswa'; }else{ $aksi = 'edit_manajemenuser'; }
            ?>
            <span style='font-family:Calibri; text-transform:uppercase'> &nbsp; <?php echo $sekolah['nama_sekolah']; ?></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <?php 
                if ($this->session->level=='admin'){
                  $cek = $this->model_app->view_where('rb_users',array('id_user'=>$this->session->id_session))->row_array();
                  if ($cek['id_identitas_sekolah']=='0'){
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bank"></i> &nbsp; Unit <span class="caret"></span></a>
                  <ul class="dropdown-menu" style="border:1px solid #cecece;">
                    <?php 
                     $semua_sekolah = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang ORDER BY a.id_jenjang");
                      foreach ($semua_sekolah->result_array() as $row) {
                        echo "<li style='border:1px dotted #cecece;''><a href='".base_url()."login/system/$row[id_identitas_sekolah]'>$row[nama_sekolah]</a></li>";
                      }
                    ?>
                  </ul>
                </li>
                <?php 
                }
              }

              if ($this->session->level=='guru'){
                  $cek_guru = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session))->row_array();
                  $guru = $this->model_app->view_where('rb_guru',array('nip'=>$cek_guru['nip']));
                  if ($guru->num_rows()>1){
                  $row = $guru->row_array();
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bank"></i> &nbsp; Unit <span class="caret"></span></a>
                  <ul class="dropdown-menu" style="border:1px solid #cecece;">
                    <?php 
                     $semua_sekolah = $this->db->query("SELECT * FROM rb_guru a JOIN rb_identitas_sekolah b ON a.id_identitas_sekolah=b.id_identitas_sekolah JOIN rb_jenjang c ON c.id_jenjang=c.id_jenjang where a.nip='$row[nip]' GROUP BY a.id_identitas_sekolah ORDER BY b.id_jenjang");
                      foreach ($semua_sekolah->result_array() as $row) {
                        echo "<li style='border:1px dotted #cecece;''><a href='".base_url()."login/system/$row[id_identitas_sekolah]'>$row[nama_sekolah]</a></li>";
                      }
                    ?>
                  </ul>
                </li>
                <?php 
                }
              }
              ?>
              <li><a style='padding-top:20px; padding-bottom:20px;' href="<?php echo base_url()."$sekolah[keyword]/".$aksi."/".$this->session->id_session; ?>"><i class="fa fa-user"></i> </a></li>
              <li><a style='padding-top:20px; padding-bottom:20px;' href="<?php echo base_url()."$sekolah[keyword]/logout"; ?>"><i class="fa fa-power-off"></i></a></li>
            </ul>
          </div>
        </nav>