<script type="text/javascript" src="plugins/jQuery/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#container').highcharts({
            data: {
                table: 'datatable'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: ''
                }
            },
            tooltip: {
                enabled: false,
                crosshairs: true,
                
            },

            plotOptions: {
              series: {
                dataLabels: {
                  enabled: true,
                  formatter: function () {
                    return '<b>' + this.series.name + '</b> ' +
                        '(' + this.point.y + ')';
                }
                }
              }
            }
        });
    });
</script>

<div class="box box-success">
    <div class="box-header">
    <i class="fa fa-th-list" style='color:#014282'></i>
    <h3 class="box-title" style='color:#014282'>Jumlah Siswa, Guru dan Kelas </h3>
    <div class="box-tools pull-right">
       <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
    </div>
    </div>

<div class="box-body chat" id="chat-box">
<div id="container" style="min-width: 310px; height: 340px; margin: 0 auto; margin-left:10px"></div><br>
<table id="datatable" style='display:none'>
    <thead>
        <tr>
            <th></th>
            <?php 
        	$tingkat = $this->db->query("SELECT * FROM rb_tingkat ORDER BY id_tingkat ASC");
        	foreach ($tingkat->result_array() as $row) {
        		echo "<th>Siswa $row[kode_tingkat]</th>";
        	}
            ?>
            <th>Guru</th>
            <th>Kelas</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $grafik = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang ORDER BY b.id_jenjang");
        foreach ($grafik->result_array() as $r) {
            $siswa = $this->db->query("SELECT * FROM rb_siswa where id_identitas_sekolah='$r[id_identitas_sekolah]' AND status_siswa='Aktif'")->num_rows();
            $guru = $this->db->query("SELECT * FROM rb_guru where id_identitas_sekolah='$r[id_identitas_sekolah]'")->num_rows();
            $kelas = $this->db->query("SELECT * FROM rb_kelas where id_identitas_sekolah='$r[id_identitas_sekolah]'")->num_rows();
            echo "<tr>
                    <th><a href=''>$r[nama_jenjang]</a></th>";
                    $tingkat = $this->db->query("SELECT * FROM rb_tingkat ORDER BY id_tingkat ASC");
		        	foreach ($tingkat->result_array() as $row) {
		        		$siswa = $this->db->query("SELECT * FROM rb_siswa a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where a.id_identitas_sekolah='$r[id_identitas_sekolah]' AND b.id_tingkat='$row[id_tingkat]' AND a.status_siswa='Aktif'")->num_rows();
		        		echo "<th>$siswa</th>";
		        	}
                    echo "<td>$guru</td>
                    <td>$kelas</td>
                  </tr>";
        }
    ?>
    </tbody>
</table>
</div><!-- /.chat -->
</div><!-- /.box (chat box) -->

