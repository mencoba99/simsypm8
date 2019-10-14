<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-aqua">
    <div class="inner">
    <?php $jmla = $this->model_app->view_where('rb_siswa',array('id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'))->num_rows(); ?>
      <h3><?php echo $jmla; ?></h3>
      <p>Siswa</p>
    </div>
    <div class="icon">
      <i class="fa fa-users"></i>
    </div>
    <a href="<?php echo base_url().$this->uri->segment(1); ?>/siswa" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-green">
    <div class="inner">
      <?php $jmlb = $this->model_app->view_where('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah))->num_rows(); ?>
      <h3><?php echo $jmlb; ?></h3>
      <p>Guru</p>
    </div>
    <div class="icon">
      <i class="fa fa-user"></i>
    </div>
    <a href="<?php echo base_url().$this->uri->segment(1); ?>/guru" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-yellow">
    <div class="inner">
    <?php $jmlc = $this->model_app->view_where('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah))->num_rows(); ?>
      <h3><?php echo $jmlc; ?></h3>
      <p>Kelas</p>
    </div>
    <div class="icon">
      <i class="fa fa-university"></i>
    </div>
    <a href="<?php echo base_url().$this->uri->segment(1); ?>/kelas" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<!-- ./col -->
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-red">
    <div class="inner">
      <?php $jmld = $this->model_app->view_where('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah))->num_rows(); ?>
      <h3><?php echo $jmld; ?></h3>
      <p>Jurusan</p>
    </div>
    <div class="icon">
      <i class="fa fa-star"></i>
    </div>
    <a href="<?php echo base_url().$this->uri->segment(1); ?>/jurusan" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<div style="clear:both"></div>
<div class="col-lg-12 col-xs-12">
  <div class="callout callout-danger">
    <b>Penting!</b> Hubungi Developer via WA/SMS/TELP : <b>082211445534</b> (Limakode Inc.), Jika ditemukan kendala atau jika ada yang diragukan!!.
  </div>
</div>
<section class="col-lg-5 connectedSortable">
      <?php include "home_grafik.php"; ?>
</section><!-- /.Left col -->

<section class="col-lg-7 connectedSortable">
    <?php include "home_app.php"; ?>
</section><!-- right col -->
