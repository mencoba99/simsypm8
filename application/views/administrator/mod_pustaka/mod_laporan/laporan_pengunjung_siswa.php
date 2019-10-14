<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Pengunjung Siswa </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/laporan_pengunjung_siswa/print' style='margin-top:-4px' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
      ?>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Waktu Kunjung</th>
            <th>Nama</th>
            <th>NIPD</th>
            <th>Kelas</th>
            <th>Asal/Keperluan</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $id = $r['nipd'];
        $nama = $r['nama'];
        $status = "<span style='color:green'>$r[nama_kelas]</span>";
        $jk = $r['jenis_kelamin'];
        $keperluan = $r['keterangan'];

        $ex = explode(' ',$r['waktu_kunjung']);
        echo "<tr><td>$no</td>
                  <td>".hari($ex[0]).", ".tgl_view($ex[0])." ".$ex[1]."</td>
                  <td>$nama</td>
                  <td>$id</td>
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