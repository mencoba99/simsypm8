<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Siswa - Pendaftaran Kembali </h3>
      <?php 
            echo "<a style='margin-right:5px' class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/daftar_siswa_tambah'>Tambahkan Data</a>";
    echo "</div>
    
    <div class='box-body'>
      <table id='example1' class='table table-bordered table-striped table-condensed'>
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Nama siswa</th>
            <th>Jenis Kelamin</th>
            <th>Jurusan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>";

        $no = 1;
        $tampil = $this->db->query("SELECT * FROM rb_siswa_temp a LEFT JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin LEFT JOIN rb_jurusan c ON a.id_jurusan=c.id_jurusan ORDER BY a.id_siswa DESC");
        foreach ($tampil->result_array() as $r){
        echo "<tr><td>$no</td>
                  <td>$r[nisn]</td>
                  <td>$r[nik]</td>
                  <td>$r[nama_siswa]</td>
                  <td>$r[jenis_kelamin]</td>
                  <td>$r[nama_jurusan]</td>
                  <td><center>
                    <a target='_BLANK' class='btn btn-success btn-xs' title='Print Data' href='".base_url().$this->uri->segment(1)."/daftar_siswa_print/$r[id_siswa]'><span class='glyphicon glyphicon-print'></span></a>
                    <a class='btn btn-info btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/daftar_siswa_edit/$r[id_siswa]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a style='margin-left:3px' class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/daftar_siswa_delete/$r[id_siswa]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></center></td>
                  </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>