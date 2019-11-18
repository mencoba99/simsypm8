<div class="col-xs-12">  
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Absensi Siprenta</h3>
            <?php 
                echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url()."".$this->uri->segment(1)."/rekap_kehadiran_siprenta/' method='GET' enctype='multipart/form-data'>
                    <input type='text' name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;' name='c' class='datepicker'>
                    <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat</button>
                </form>";
             ?>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:40px'>No</th>
                        <th>NIPD/NIP</th>
                        <th>Nama</th>
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
                                <td>$r[jam_datang]</td>
                                <td>$r[jam_pulang]</td>
                                // <td><center>
                                //     <a class='btn btn-success btn-xs' title='Tampil List Absensi' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa/$r[kodejdwl]'><span class='glyphicon glyphicon-th'></span> Tampilkan</a>
                                //     <a class='btn btn-warning btn-xs' title='Rekap Absensi Siswa' href='".base_url().$this->uri->segment(1)."/rekap_absensi_siswa/$r[kodejdwl]'><span class='glyphicon glyphicon-book'></span> Rekap</a>
                                // </center></td>
                            </tr>";
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
