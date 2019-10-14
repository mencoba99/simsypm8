<?php            
echo "<div class='col-xs-12'>  
    <div class='box'>
        <div class='box-header'>
          <h3 class='box-title'>Data Pengeluaran</h3>
          <a class='pull-right btn btn-sm btn-primary' href='".base_url().$this->uri->segment(1)."/tambah_pengeluaran'>Tambahkan Data</a>
        </div>
        
        <div class='box-body'>
            <table id='example1' class='table table-bordered'>
                <thead>
                    <tr>
                        <th width='40px'>No</th>
                        <th>Kode Pengeluaran</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>CoA</th>
                        <th>Sub-CoA</th>
                        <th>Metode</th>
                        <th>Total Keluar</th>
                        <th>Bukti Pengeluaran</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>";

                $tampil = $this->db->query("SELECT * FROM rb_lk_keuangan_keluar ORDER BY id_pengeluaran ASC");
                $no = 1;
                
                foreach ($tampil->result_array() as $r) {
                    $coa = $this->db->query("SELECT * FROM rb_lk_keuangan_keluar a JOIN rb_keuangan_coa b ON a.id_coa = b.id_coa WHERE a.id_coa = $r[id_coa]")->row_array();
                    $sub_coa = $this->db->query("SELECT * FROM rb_lk_keuangan_keluar a JOIN rb_keuangan_sub_coa b ON a.id_sub_coa = b.id_sub_coa WHERE a.id_sub_coa = $r[id_sub_coa]")->row_array();
                    echo "<tr'>
                            <td>$no</td>
                            <td>$r[kode]</td>
                            <td>$r[waktu_bayar]</td>
                            <td>$r[nama]</td>
                            <td>$r[deskripsi]</td>
                            <td>$coa[nama_coa]</td>
                            <td>$sub_coa[nama_sub_coa]</td>
                            <td>$r[metode]</td>
                            <td style='text-align: right'>Rp ".number_format($r['total_bayar'])."</td>
                            <td style='text-align: center'><img src='".base_url()."asset/Bukti_Pengeluaran/$r[bukti]' style='height: 100px;'></td>
                            <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_pengeluaran/$r[id_pengeluaran]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_pengeluaran/$r[id_pengeluaran]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center>
                            </td>
                        </tr>";
                    $no++;
                }
              ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>