<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Penerimaan Barang </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:20px'>No</th>
            <th>Kode</th>
            <th>Supplier</th>
            <th>Belanja</th>
            <th>Tgl Pembelian</th>
            <th>Tgl Terima</th>
            <th>Bayar</th>
            <th>Status</th>
            <th style='width:150px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $tampil = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a LEFT JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier ORDER BY a.id_pembelian DESC");
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $b = $this->db->query("SELECT sum(jumlah_pesan*harga_pesan) as jumlah_belanja FROM rb_koperasi_pembelian_detail where id_pembelian='$r[id_pembelian]'")->row_array();
        $tanggal = $this->db->query("SELECT count(*) as jml, GROUP_CONCAT(DATE_FORMAT(tanggal_terima, '%d-%m-%Y') SEPARATOR ', ') as tgl_terima FROM `rb_koperasi_pembelian_terima` where id_pembelian='$r[id_pembelian]'")->row_array();
        $bayar = $this->db->query("SELECT sum(jumlah_bayar) as total FROM rb_koperasi_pembelian_bayar where id_pembelian='$r[id_pembelian]'")->row_array();
        if ($b['jumlah_belanja']<=$bayar['total']){ $status = '<i style="color:green">Lunas</i>'; }else{ $status = '?'; }
        if ($tanggal['tgl_terima']==''){ $terima = '-'; }else{ $terima = $tanggal['tgl_terima']; }
        echo "<tr><td>$no</td>
                  <td>$r[kode_pembelian]</td>
                  <td>$r[nama_supplier]</td>
                  <td>Rp ".rupiah($b['jumlah_belanja'])."</td>
                  <td>".tgl_view($r['tanggal_pembelian'])."</td>
                  <td>$terima</td>
                  <td>Rp ".rupiah($bayar['total'])."</td>
                  <td>$status</td>
                  <td><center>
                    <a class='btn btn-primary btn-xs' title='Detail Data' href='".base_url().$this->uri->segment(1)."/transaksi_penerimaan_detail/$r[id_pembelian]'><span class='glyphicon glyphicon-search'></span></a>
                    <a class='btn btn-success btn-xs' title='Detail Data' href='".base_url().$this->uri->segment(1)."/transaksi_penerimaan_bayar/$r[id_pembelian]'><span class='fa fa-money'></span> Bayar</a>
                    <a class='btn btn-warning btn-xs' title='Data Penerimaan' href='".base_url().$this->uri->segment(1)."/transaksi_penerimaan_terima/$r[id_pembelian]'><span class='fa fa-truck'></span> Terima</a>
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
