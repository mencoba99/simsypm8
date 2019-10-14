<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Pengembalian </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form action='<?php echo base_url().$this->uri->segment(1) ?>/transaksi_pengembalian_edit/<?php echo $this->uri->segment(3) ?>' method='POST'>
        <table class="table table-bordered table-striped table-condensed">
            <tr><td width='120px'>Nama Siswa</td> <td><select class='form-control combobox' name='a' required>
                      <option value='' selected>Cari Siswa</option>
                      <?php 
                        $siswa = $this->db->query("SELECT * FROM rb_siswa");
                        foreach ($siswa->result_array() as $row){
                          if ($d['id_siswa']==$row['id_siswa']){
                            echo "<option value='$row[id_siswa]' selected>$row[nama]</option>";
                          }else{
                            echo "<option value='$row[id_siswa]'>$row[nama]</option>";
                          }
                        }
                      ?>
                  </select></td></tr>
             <tr><td>Tanggal Pinjam</td> <td><input type="text" class='form-control datepicker' name='b' value='<?php echo tgl_view($d['tanggal_pinjam']); ?>' required></td></tr> 
             <tr><td>Keterangan</td> <td><textarea class='form-control' name='c'><?php echo $d['keterangan']; ?></textarea></td></tr>
             <tr><td></td> <td><button type="submit" name='simpan' class='btn btn-primary btn-sm'>Update Data</button></td>
            </tr> 
        </table><hr>



      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Cover</th>
            <th>Kode / Nama Buku</th>
            <th>Jumlah</th>
            <th>Tgl Kembalikan</th>
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
              <th><input class='form-control' type="number" name='bb' value='1' required></th>
              <th><input class='form-control datepicker' type="text" name='cc' value='<?php echo date('d-m-Y'); ?>' required></th>
              <th><button class='btn btn-primary' type='submit' name='simpan_buku'><span class='glyphicon glyphicon-plus'></span></button></th>
            </form>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r){
        if (file_exists('asset/foto_buku/'.$r['foto'])) { 
          if ($r['foto']==''){ $foto = 'buku.jpg'; }else{ $foto = $r['foto']; }
        }else{
          $foto = 'buku.jpg';
        }
        echo "<tr><td>$no</td>
                  <td><img width='70px' src='".base_url()."asset/foto_buku/$foto'></td>
                  <td style='padding-left:25px'>$r[kode_buku] - $r[judul]</td>
                  <td style='padding-left:20px'>$r[jumlah]</td>
                  <td style='padding-left:20px'>".tgl_view($r['tanggal_kembalikan'])."</td>
                  <td><center>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/transaksi_pengembalian_edit_hapus/$r[id_pinjam_detail]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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