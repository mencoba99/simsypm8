<div class="col-xs-12">  
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Absensi Siprenta</h3>
            <?php 
                echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url()."".$this->uri->segment(1)."/rekap_kehadiran_siprenta' method='GET' enctype='multipart/form-data'>
                    <input type='date' name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;'>
                    <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat</button>
                </form>";
             ?>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:20px'>No</th>
                        <th>NIPD/NIP</th>
                        <th>Nama</th>
                        <th>Kelas/Jabatan</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $no = 1;
                        foreach ($record as $r){
                            $siswa = $this->db->query("SELECT * FROM rb_siswa a JOIN rb_kelas b ON a.id_kelas = b.id_kelas WHERE a.nisn = ".$r->no_induk)->row_array();
                            if ($siswa === NULL ) {
                                $kel = "Guru";
                            } else {
                                $kel = $siswa['nama_kelas'];
                            } 

                            echo "<tr>
                                <td>$no</td>
                                <td>".$r->no_induk."</td>
                                <td>".$r->nama."</td>
                                <td>".$kel."</td>
                                <td>".$r->jam_masuk."</td>
                                <td>".$r->jam_pulang."</td>
                                <td>".$r->kode_kehadiran."</td>
                            </tr>";
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
