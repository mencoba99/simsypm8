<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Pengembalian </h3>
      <a class='pull-right btn btn-warning btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/transaksi_pengembalian'>Kembali</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php 
        echo "<table class='table table-bordered table-striped table-condensed'>
          <tr><td width='120px'><b>Nama Siswa</b></td> <td>$d[nama]</td></tr>
           <tr><td><b>Tanggal Pinjam</b></td>          <td>".tgl_view($d['tanggal_pinjam'])."</td></tr> 
           <tr><td><b>Keterangan</b></td>              <td>$d[keterangan]</td></tr>   
      </table><hr>

      <form action='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_detail/".$this->uri->segment(3)."' method='POST'>
      <table class='table table-bordered table-striped'>
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Cover</th>
            <th>Kode / Nama Buku</th>
            <th>Jml</th>
            <th>Deadline</th>
            <th>Tgl Kembalikan</th>
            <th>Jumlah</th>
            <th>Catatan</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $k = $this->db->query("SELECT jumlah, denda, keterangan, tanggal_kembali FROM rb_pustaka_kembali where id_pinjam='".$this->uri->segment(3)."' AND id_buku='$r[id_buku]'")->row_array();
        if ($k['tanggal_kembali']==''){ $tgl = date('d-m-Y'); }else{ $tgl = tgl_view($k['tanggal_kembali']); }
        if (file_exists('asset/foto_buku/'.$r['foto'])) { 
          if ($r['foto']==''){ $foto = 'buku.jpg'; }else{ $foto = $r['foto']; }
        }else{
          $foto = 'buku.jpg';
        }

        if (trim($k['jumlah'])==''){ $jumlah = $r['jumlah']; }else{ $jumlah = $k['jumlah']; }
        echo "<tr><td>$no</td>
                  <td><img width='70px' src='".base_url()."asset/foto_buku/$foto'></td>
                  <td>$r[kode_buku] - $r[judul]</td>
                  <td>$r[jumlah]</td>
                  <td>".tgl_view($r['tanggal_kembalikan'])."</td>
                  <input type='hidden' name='a$no' value='$r[id_buku]'>
                  <input type='hidden' value='$r[tanggal_kembalikan]' name='deadline$no'>
                  <td><input type='text' class='form-control datepicker$no' style='text-align:center; max-width:90px' value='$tgl' name='b$no'></td>
                  <td><input type='number' class='form-control' style='text-align:center; max-width:70px' value='$jumlah' name='c$no'></td>
                  <td><textarea class='form-control' style='height:80px' name='e$no'>$k[keterangan]</textarea></td>
              </tr>";
          $no++;
          }
          $cek_ada = $this->db->query("SELECT * FROM rb_pustaka_kembali where id_pinjam='".$this->uri->segment(3)."'")->num_rows();
          $hitung_denda = $this->db->query("SELECT sum(denda) as denda FROM rb_pustaka_kembali where id_pinjam='".$this->uri->segment(3)."'")->row_array();
          if ($cek_ada>=1){
          echo "<tr class='danger'>
                  <td colspan='7'><b>Total Denda Keterlambatan</b></td>
                  <td><b>Rp ".rupiah($hitung_denda['denda'])."</b></td>
                </tr>";
          }

        $biaya_denda = $this->db->query("SELECT * FROM rb_pustaka_denda ORDER BY id_denda DESC LIMIT 1")->row_array();
        echo "<tr class='info'>
                  <td colspan='8'><i>Ctt : Denda keterlambatan 1 buku Rp $biaya_denda[nominal]/hari</td>
                </tr>";
      ?>
        </tbody>
      </table><br>

      <input class='btn btn-sm btn-primary' type="submit" name='simpan' value='Proses data Pengembalian'>
      </form>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>