<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Kartu Pustaka </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form style='margin-right:5px; margin-top:0px; min-width:50%' action='' method='POST'>
        <select class='form-control combobox' style='padding:5px;' name='a' required>
            <option value='' selected>Cari Siswa atau Guru + Enter...</option>
            <?php 
              $pengunjung = $this->db->query("SELECT id_siswa as id, nama, 'siswa' as status FROM rb_siswa UNION SELECT id_guru as id, nama_guru as nama, 'guru' as status FROM rb_guru");
              foreach ($pengunjung->result_array() as $row){
                  echo "<option value='$row[id];$row[status]'>$row[nama] ($row[status])</option>";
              }
            ?>
        </select>
        <input type="submit" name='tambahkan' class='btn btn-info btn-sm hidden' value='Proses'>
      </form><br>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>No Kartu</th>
            <th>NIP / NIPD</th>
            <th>Nama Pemilik</th>
            <th>Alamat</th>
            <th style='width:70px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        if ($r['status']=='siswa'){
          $s = $this->db->query("SELECT a.*, b.nama_kelas, c.jenis_kelamin FROM rb_siswa a JOIN rb_kelas b ON a.id_kelas=b.id_kelas LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin where a.id_siswa='$r[id_siswa]'")->row_array();
          $id = $s['nipd'];
          $nokartu = $r['no_kartu'];
          $nama = $s['nama'];
          $status = "<span style='color:green'>$s[alamat], $s[kelurahan], $s[kecamatan]</span>";
        }elseif($r['status']=='guru'){
          $s = $this->db->query("SELECT a.*, b.jenis_kelamin FROM rb_guru a LEFT JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_guru='$r[id_siswa]'")->row_array();
          $id = $s['nip'];
          $nokartu = $r['no_kartu'];
          $nama = $s['nama_guru'];
          $status = "<span style='color:blue'>$r[alamat_jalan], $s[desa_kelurahan], $s[kecamatan]</span>";
        }
        echo "<tr><td>$no</td>
                  <td>$nokartu</td>
                  <td>$id</td>
                  <td>$nama</td>
                  <td style='text-transform:capitalize'>$status</td>
                  <td><center>
                    <a target='_BLANK' class='btn btn-success btn-xs' title='Print Kartu' href='".base_url().$this->uri->segment(1)."/kartu_pustaka_print?id=$r[id_kartu]'><span class='glyphicon glyphicon-print'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/kartu_pustaka_hapus/$r[id_kartu]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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