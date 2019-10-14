<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Katalog Laporan  </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/katalog_laporan_buku/print' style='margin-top:-4px' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
      ?>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Nama Penulis</th>
            <th>Judul Laporan</th>
            <th>Tahun</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        echo "<tr><td>$no</td>
                  <td>$r[pengarang]</td>
                  <td>$r[judul]</td>
                  <td>$r[tahun_terbit]</td>
                  <td>$r[deskripsi]</td>
              </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>