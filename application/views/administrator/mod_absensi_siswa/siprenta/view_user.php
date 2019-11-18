<div class="col-xs-12">  
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Absensi Siprenta - <?= $user['nama'] ?> / <?= $user['nisn'] ?></h3>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:40px'>No</th>
                        <th>NIPD/NIP</th>
                        <th>Nama</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $no = 1;
                        foreach ($record->result_array() as $r){
                            echo "<tr>
                                <td>$no</td>
                                <td>$r[nisn]</td>
                                <td>$r[nama]</td>
                                <td>$r[hari]</td>
                                <td>$r[tanggal]</td>
                                <td>$r[jam_datang]</td>
                                <td>$r[jam_pulang]</td>
                            </tr>";
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
