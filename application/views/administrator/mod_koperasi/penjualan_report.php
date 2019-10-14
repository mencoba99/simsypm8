<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Laporan Data Penjualan </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form action='<?php echo base_url().$this->uri->segment(1)."/laporan_penjualan"; ?>' method='GET'>
        <input type='text' class='form-control' id='rangepicker' style='display:inline-block; width:200px' value='<?php echo $_GET['tanggal']; ?>' name='tanggal' autocomplete='off'>
        <input type="submit" style='margin-top:-4px' class='btn btn-primary btn-sm'>
          <?php
          if(isset($_GET['tanggal'])){
            echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/laporan_penjualan_print?mulai=$mulai&selesai=$selesai' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-print'></span></a>";
          }
          ?>
      </form>

      <table id="example2" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Kode Penjualan</th>
            <th>Nama Pembeli</th>
            <th>Jml Belanja</th>
            <th>Jml Bayar</th>
            <th>Kembali</th>
            <th>Waktu Transaksi</th>
            <th style='width:70px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php
        
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $b = $this->db->query("SELECT sum((jumlah_jual*harga)-diskon) as jumlah_belanja FROM rb_koperasi_penjualan_detail where id_penjualan='$r[id_penjualan]'")->row_array();
        echo "<tr><td>$no</td>
                  <td>$r[kode_penjualan]</td>
                  <td>$r[nama]</td>
                  <td>".rupiah($b['jumlah_belanja'])."</td>
                  <td>".rupiah($r['jumlah_bayar'])."</td>
                  <td>".rupiah($r['jumlah_bayar']-$b['jumlah_belanja'])."</td>
                  <td>$r[waktu_penjualan]</td>
                  <td><center>
                    <a class='btn btn-info btn-xs' title='Detail Data' href='".base_url().$this->uri->segment(1)."/laporan_penjualan_detail/$r[id_penjualan]'><span class='glyphicon glyphicon-search'></span></a>
                    <a target='_BLANK' href='".base_url().$this->uri->segment(1)."/transaksi_penjualan_print?id=$r[id_penjualan]'  class='btn btn-success btn-xs'><span class='glyphicon glyphicon-print'></span></a>
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