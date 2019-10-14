<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Laporan Rekap Kondisi Buku  </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/rekap_kondisi_buku/print' style='margin-top:-4px' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
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
            <th>Baik</th>
            <th>Rusak</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $kondisi = $this->db->query("SELECT sum(jumlah) as total FROM rb_pustaka_buku_kondisi where id_buku='$r[id_buku]'")->row_array();
        $rusak = $kondisi['total'];
        $baik = $r['jumlah']-$kondisi['total'];
        echo "<tr><td>$no</td>
                  <td>$r[kode_buku]</td>
                  <td>$r[pengarang]</td>
                  <td>$r[judul]</td>
                  <td>$r[penerbit]</td>
                  <td>$r[tahun_terbit]</td>
                  <td>".rupiah($baik)."</td>
                  <td>".rupiah($rusak)."</td>
              </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>