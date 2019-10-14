<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Pengembalian </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal Pinjam</th>
            <th>Jumlah</th>
            <th>Kembali</th>
            <th>Status</th>
            <th style='width:120px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $j = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_pinjam='$r[id_pinjam]'")->row_array();
        $k = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_kembali where id_pinjam='$r[id_pinjam]'")->row_array();
        if ($j['jumlah']==$k['jumlah']){ $status = '<i style="color:green">Sudah Dikembalikan</i>'; }else{ $status = '<i style="color:red">Belum Dikembalikan</i>'; }
        echo "<tr><td>$no</td>
                  <td>$r[nama]</td>
                  <td>".tgl_view($r['tanggal_pinjam'])."</td>
                  <td>$j[jumlah] Buku</td>
                  <td>".rupiah($k['jumlah'])." Buku</td>
                  <td>$status</td>
                  <td><center>
                    <a class='btn btn-primary btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_detail/$r[id_pinjam]'><span class='glyphicon glyphicon-ok'></span> Proses</a>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_edit/$r[id_pinjam]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_hapus/$r[id_pinjam]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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