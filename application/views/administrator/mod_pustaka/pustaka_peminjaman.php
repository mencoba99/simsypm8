<?php 
  if ($this->session->pinjam!=''){
    $button = 'Update Data';
    $e = $this->db->query("SELECT * FROM rb_pustaka_pinjam where id_pinjam='$_SESSION[pinjam]'")->row_array();
    $tgl_pinjam = tgl_view($e['tanggal_pinjam']);
    $keterangan = $e['keterangan'];
  }else{
    $button = 'Selanjutnya';
    $tgl_pinjam = date('d-m-Y');
    $keterangan = '';
  }
?>
<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Peminjaman </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form action='<?php echo base_url().$this->uri->segment(1)."/transaksi_peminjaman"; ?>' method='POST'>
        <table class="table table-bordered table-striped table-condensed">
            <tr><td width='120px'>Nama Siswa</td> <td><select class='form-control combobox' name='a' required>
                                          <option value='' selected>Cari Siswa</option>
                                          <?php 
                                            $siswa = $this->db->query("SELECT * FROM rb_siswa");
                                            foreach ($siswa->result_array() as $row){
                                              if ($e['id_siswa']==$row['id_siswa']){
                                                echo "<option value='$row[id_siswa]' selected>$row[nama]</option>";
                                              }else{
                                                echo "<option value='$row[id_siswa]'>$row[nama]</option>";
                                              }
                                            }
                                          ?>
                                      </select></td></tr>
             <input type="hidden" class='form-control datepicker' name='b' value='<?php echo $tgl_pinjam; ?>' required>
             <tr><td>Keterangan</td> <td><textarea class='form-control' name='c'><?php echo $keterangan; ?></textarea></td></tr>   
             <tr><td></td> <td><input class='btn btn-sm btn-success' type="submit" name='simpan' value='<?php echo $button; ?>'>
                              <?php if ($this->session->pinjam!=''){ ?>
                                <a class='btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1)."/transaksi_peminjaman?selesai"; ?>'>Selesai / Simpan Data</a>  
                              <?php } ?> 
                           </td></tr> 
        </table><hr>


    <?php if ($this->session->pinjam!=''){ ?>
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Cover</th>
            <th>Kode / Nama Buku</th>
            <th>Jumlah</th>
            <th>Lama Kembali (Hari)</th>
            <th style='width:40px'>Action</th>
          </tr>

          <tr>
            <th style='width:40px'></th>
            <th></th>
            <th><select class='form-control combobox' name='aa'>
                    <option value='' selected>Cari Buku</option>
                    <?php 
                      $buku = $this->db->query("SELECT * FROM rb_pustaka_buku");
                      foreach ($buku->result_array() as $row){
                          echo "<option value='$row[id_buku]'>$row[kode_buku] - $row[judul]</option>";
                      }
                    ?>
                </select>
            </th>
            <?php $set = $this->db->query("SELECT * FROM rb_pustaka_setting where id_pustaka_setting='1'")->row_array(); ?>
            <th><input class='form-control' type="number" name='bb' value='1'></th>
            <th><input class='form-control' type="text" name='cc' value='<?php echo $set['durasi']; ?>'></th>
            <th><button class='btn btn-primary' type='submit' name='simpan_buku'><span class='glyphicon glyphicon-plus'></span></button></th>
          </tr>
        </thead>
        <tbody>
        </form>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r){
        if (file_exists('asset/foto_buku/'.$r['foto'])) { 
          if ($r['foto']==''){ $foto = 'buku.jpg'; }else{ $foto = $r['foto']; }
        }else{
          $foto = 'buku.jpg';
        }

        $datetime1 = new DateTime(date('Y-m-d'));
        $datetime2 = new DateTime($r['tanggal_kembalikan']);
        $difference = $datetime1->diff($datetime2);

        echo "<tr><td>$no</td>
                  <td><img width='70px' src='".base_url()."asset/foto_buku/$foto'></td>
                  <td style='padding-left:25px'>$r[kode_buku] - $r[judul]</td>
                  <td style='padding-left:20px'>$r[jumlah]</td>
                  <td style='padding-left:20px'>".$difference->days." Hari (".tgl_indo($r['tanggal_kembalikan']).")</td>
                  <td><center>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/transaksi_peminjaman_hapus/$r[id_pinjam_detail]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>
              </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table><br>
    <?php } ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>