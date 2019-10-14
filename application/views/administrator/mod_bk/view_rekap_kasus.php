<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Rekaman Pelanggaran</b></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php
      echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/rekap_kasus' method='GET'>
        <table class='table table-condensed table-hover'>
            <tbody>
              <tr><th width='130px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
              <option value=''>- Pilih -</option>";
                $tahun = $this->model_app->view_where("rb_tahun_akademik",array('id_identitas_sekolah'=>$this->session->sekolah));
                foreach ($tahun->result_array() as $k){
                  if ($_GET['tahun']==$k['id_tahun_akademik']){
                    echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                  }else{
                    echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                  }
                }

        echo "</select>
              <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
            </tbody>
        </table>
        </form>";
    ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>NIPD</th>
            <th>Nama Siswa</th>
            <th>Total Kasus</th>
            <th>Total Bobot</th>
            <th style='width:80px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        if ($_GET['tahun']!=''){
          $cek = $this->db->query("SELECT count(*) as kasus, sum(b.bobot) as bobot FROM rb_bk_rekam a JOIN rb_bk_jenis_detail b ON a.id_jenis_detail=b.id_jenis_detail where a.id_siswa='$r[id_siswa]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
        }else{
          $cek = $this->db->query("SELECT count(*) as kasus, sum(b.bobot) as bobot FROM rb_bk_rekam a JOIN rb_bk_jenis_detail b ON a.id_jenis_detail=b.id_jenis_detail where a.id_siswa='$r[id_siswa]'")->row_array();
        }
        echo "<tr><td>$no</td>
                  <td>$r[nipd]</td>
                  <td>$r[nama]</td>
                  <td><b style='color:green'>$cek[kasus] Kasus</td>
                  <td>$cek[bobot]</td>
                  <td><center>";
                  if ($_GET['tahun']!=''){
                    echo "<a class='btn btn-success btn-xs' title='Lihat Data' href='".base_url().$this->uri->segment(1)."/detail_rekap_kasus/$r[id_siswa]/$_GET[tahun]'><span class='glyphicon glyphicon-th-list'></span> Lihat kasus</a>";
                  }else{
                    echo "<a class='btn btn-default btn-xs' title='Lihat Data' href='#' onClick=\"return alert('Pilih Tahun Akademik Terlebih Dahulu!!!')\"><span class='glyphicon glyphicon-th-list'></span> Lihat kasus</a>";
                  }
                  echo "</center></td>
                  </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>

