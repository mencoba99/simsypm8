<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Buku Tamu </h3>
      <a class='pull-right btn btn-primary btn-sm' href='#' data-toggle="modal" data-target="#myModal">Pengunjung Umum</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form style='margin-right:5px; margin-top:0px; min-width:50%' action='<?php echo base_url().$this->uri->segment(1) ?>/buku_tamu' method='POST'>
        <select class='form-control combobox' style='padding:5px;' name='a' required>
            <option value='' selected>Cari Siswa atau Guru + Enter...</option>
            <?php 
              $pengunjung = $this->db->query("SELECT id_siswa as id, nama, 'siswa' as status FROM rb_siswa UNION SELECT id_guru as id, nama_guru as nama, 'guru' as status FROM rb_guru");
              foreach ($pengunjung->result_array() as $row) {
                  echo "<option value='$row[id];$row[status]'>$row[nama] ($row[status])</option>";
              }
            ?>
        </select>
        <input type="submit" name='tambahkan' class='btn btn-info btn-sm hidden' value='Proses'>
      </form>
      <table id="example2" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>ID / NIP / NIPD</th>
            <th>Nama Pengunjung</th>
            <th>Kelas / Status</th>
            <th>Jenis Kelamin</th>
            <th>Keperluan</th>
            <th>Waktu Kunjung</th>
            <th style='width:40px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        if ($r['status']=='siswa'){
          $s = $this->db->query("SELECT a.*, b.nama_kelas, c.jenis_kelamin FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin where a.id_siswa='$r[id_siswa]'")->row_array();
          $id = $s['nipd'];
          $nama = $s['nama'];
          $status = "<span style='color:green'>$s[nama_kelas]</span>";
          $jk = $s['jenis_kelamin'];
          $keperluan = $r['keterangan'];
        }elseif($r['status']=='guru'){
          $s = $this->db->query("SELECT a.*, b.jenis_kelamin FROM rb_guru a LEFT JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_guru='$r[id_siswa]'")->row_array();
          $id = $s['nip'];
          $nama = $s['nama_guru'];
          $status = "<span style='color:blue'>$r[status]</span>";
          $jk = $s['jenis_kelamin'];
          $keperluan = $r['keterangan'];
        }else{
          $s = explode(';', $r['keterangan']);
          $id = $s[0];
          $nama = $s[1];
          $status = "<span style='color:#000'>$r[status]</span>";
          $jk = $s[2];
          $keperluan = $s[3];
        }
        $ex = explode(' ',$r['waktu_kunjung']);
        echo "<tr><td>$no</td>
                  <td>$id</td>
                  <td>$nama</td>
                  <td style='text-transform:capitalize'>$status</td>
                  <td>$jk</td>
                  <td>$keperluan</td>
                  <td>".tgl_view($ex[0])." ".$ex[1]."</td>
                  <td><center>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_buku_tamu/$r[id_bukutamu]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Pengunjung Umum</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo base_url().$this->uri->segment(1) ?>/buku_tamu" class='form-horizontal' method='POST'>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">ID</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="text" style='color:red' class="form-control" name="a" value='<?php echo date("YmdHis"); ?>' readonly=on>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="text" class="form-control" name="b" required>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="radio" name="c" value='Laki-laki' checked> Laki-laki
                <input type="radio" name="c" value='Perempuan'> Perempuan
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Keperluan</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="text" class="form-control" name="d" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" name='umum' class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>