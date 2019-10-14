            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Buku </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_buku'>Tambahkan Data</a>

                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Cover</th>
                        <th></th>
                        <th></th>
                        <th>Deskripsi</th>
                        <th style='width:120px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    foreach ($record->result_array() as $r){
                    if (file_exists('asset/foto_buku/'.$r['foto'])) { 
                      if ($r['foto']==''){ $foto = 'buku.jpg'; }else{ $foto = $r['foto']; }
                    }else{
                      $foto = 'buku.jpg';
                    }
                    $pinjam = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_buku='$r[id_buku]'")->row_array();
                    $kembali = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_kembali where id_buku='$r[id_buku]'")->row_array();
                    $deskripsi =strip_tags($r['deskripsi']);
                    $isi = substr($deskripsi,0,300); 
                    $isi = substr($deskripsi,0,strrpos($isi," ")); 
                    echo "<tr><td>$no</td>
                              <td width='70px'><img width='70px' src='".base_url()."asset/foto_buku/$foto'></td>
                              <td width='250px'><b>Kode :</b> <span style='color:red'>$r[kode_buku]</span><br>
                                  <b>Judul :</b> $r[judul]<br>
                                  <b>Pengarang :</b> $r[pengarang]<br>
                                  <b>Penerbit :</b> $r[penerbit]<br>
                                  <b>Tahun :</b> $r[tahun_terbit]
                              </td>
                              
                              <td width='180px'><b>Stok :</b> <span style='color:blue'>".(($r['jumlah']-$pinjam['jumlah'])+$kembali['jumlah'])."</span> <br>
                                  <b>Harga :</b> Rp ".rupiah($r['harga_buku'])."<br>
                                  <b>Sumber Dana :</b> $r[sumber_dana]<br>
                                  <b>Tahun Pengadaan :</b> $r[tahun_pengadaan]</td>
                              <td>$isi...</td>
                              <td>
                              <center>
                                <a class='btn btn-primary btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/kondisi_buku/$r[id_buku]'><span class='fa fa-check-square-o'></span> Kondisi</a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_buku/$r[id_buku]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_buku/$r[id_buku]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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