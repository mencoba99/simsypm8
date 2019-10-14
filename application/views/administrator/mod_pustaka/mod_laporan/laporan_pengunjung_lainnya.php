<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Kunjungan Perpustakaan (Non Siswa) </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/laporan_pengunjung_lainnya/print' style='margin-top:-4px' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
      ?>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Waktu Kunjung</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Asal / Keperluan</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        if($r['status']=='guru'){
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
                  <td>".hari($ex[0]).", ".tgl_view($ex[0])." ".$ex[1]."</td>
                  <td>$nama</td>
                  <td style='text-transform:capitalize'>$status</td>
                  <td>$keperluan</td>
              </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>