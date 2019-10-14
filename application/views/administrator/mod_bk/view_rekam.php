<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Rekaman Pelanggaran</b></h3>
      <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_rekam_kasus'>Tambahkan Data</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php
      echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/rekam_kasus' method='GET'>
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
            <th>Jenis Pelanggaran</th>
            <th>Bobot</th>
            <th>Penemu Kasus</th>
            <th style='width:80px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        echo "<tr><td>$no</td>
                  <td>$r[nipd]</td>
                  <td>$r[nama]</td>
                  <td><b style='color:green'>$r[judul]</b> - $r[pelanggaran]</td>
                  <td>$r[bobot]</td>
                  <td>$r[nama_guru]</td>
                  <td><center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_rekam_kasus/$r[id_rekam]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_rekam_kasus/$r[id_rekam]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>
                  </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>

