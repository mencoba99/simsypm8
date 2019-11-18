<div class="col-xs-12">  
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Absensi Siprenta</h3>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:40px'>No</th>
                        <th>NIPD/NIP</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $no = 1;
                        foreach ($record as $r){
                            echo "<tr>
                                <td>$no</td>
                                <td>".$r->no_induk."</td>
                                <td>".$r->nama."</td>
                                <td>".tgl_indo($r->tanggal)."</td>
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
