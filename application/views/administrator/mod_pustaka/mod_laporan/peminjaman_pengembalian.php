<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Katalog Laporan  </h3>
      <form style='margin-right:5px; margin-top:0px' action='<?php echo base_url().$this->uri->segment(1); ?>/peminjaman_pengembalian' method='GET'>
      <input type="hidden" name='view' value='pustaka_laporan'>
      <input type='text' autocomplete='off' class='form-control' id='rangepicker' style='display:inline-block; width:300px' value='<?php echo $_GET['tanggal']; ?>' name='tanggal' placeholder='MM/DD/YYYY - MM/DD/YYYY'>
      <input type="submit" style='margin-top:-4px' value='Tampilkan' class='btn btn-primary btn-sm'>
        <?php
        if(isset($_GET['tanggal'])){
          echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/peminjaman_pengembalian/print?tanggal=$_GET[tanggal]' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-print'></span></a>";
        }
        ?>
      </form>
    </div><!-- /.box-header -->
    <div class="box-body">
      

      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Tanggal</th>
            <th>Nama Peminjam</th>
            <th>Kelas</th>
            <th>No Buku</th>
            <th>Judul Buku</th>
            <th>Jumlah</th>
            <th>Pengembalian</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $j = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_pinjam='$r[id_pinjam]'")->row_array();
        $k = $this->db->query("SELECT sum(jumlah) as jumlah, GROUP_CONCAT(DATE_FORMAT(tanggal_kembali, '%d %b %Y') SEPARATOR ', ') as kembali FROM rb_pustaka_kembali where id_pinjam='$r[id_pinjam]'")->row_array();
        $b = $this->db->query("SELECT GROUP_CONCAT(b.kode_buku SEPARATOR '<br> ') as kode_buku, GROUP_CONCAT(b.judul SEPARATOR '<br> ') as judul FROM rb_pustaka_pinjam_detail a JOIN rb_pustaka_buku b ON a.id_buku=b.id_buku where a.id_pinjam='$r[id_pinjam]'")->row_array();
        if ($j['jumlah']>1){
           $kembali = "<i style='color:green'>Sudah $j[jumlah] Buku</i>";
        }else{
           $kembali = "<i style='color:red'>Belum Kembali</i>";
        }
        echo "<tr><td>$no</td>
                  <td><a target='_BLANK' href='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_detail/$r[id_pinjam]'>".tgl_indo($r['tanggal_pinjam'])."</a></td>
                  <td>$r[nama]</td>
                  <td>$r[nama_kelas]</td>
                  <td>$b[kode_buku]</td>
                  <td>$b[judul]</td>
                  <td>".rupiah($j['jumlah'])."</td>
                  <td>$kembali</td>
                  <td>$r[keterangan]</td>
              </tr>";

          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>