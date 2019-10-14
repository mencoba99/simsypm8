<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Laporan Kondisi Buku  </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/laporan_kondisi_buku/print' style='margin-top:-4px' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
      ?>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Nomor</th>
            <th>Pengarang</th>
            <th>Judul Buku</th>
            <th>Penerbit</th>
            <th>Tahun Penerbit</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        echo "<tr><td>$no</td>
                  <td>$r[kode_buku]</td>
                  <td>$r[pengarang]</td>
                  <td>$r[judul]</td>
                  <td>$r[penerbit]</td>
                  <td>$r[tahun_terbit]</td>
                  <td>$r[jumlah]</td>
                  <td>";
                  $kondisi = $this->db->query("SELECT * FROM rb_pustaka_buku_kondisi where id_buku='$r[id_buku]'");
                  if ($kondisi->num_rows()>=1){
                    foreach ($kondisi->result_array() as $c) {
                      echo "<i style='color:red'>$c[jumlah] $c[kondisi], </i>";
                    }
                  }else{
                    echo "<i style='color:green'>Semua Buku Baik</i>";
                  }
                  echo "</td>
              </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>