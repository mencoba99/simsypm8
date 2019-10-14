<link rel="stylesheet" href="../bootstrap/css/printer.css">
<body onload="window.print()">

<?php
                    // <hr>
$nama = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
$date = date("Ymd", strtotime($record['tgl_transaksi']));
    echo "<div class='col-md-12'>
            <div class='box box-success'>
                <div class='box-header'>
                    <h3 class='box-title'>Detail Transaksi</h3>
                </div>

                <div class='box-header'>
                    <center>
                        <h3 class='box-title'><b style='margin-top: 0px;'>$nama[nama_sekolah]</b> </h3><br>
                        <h5>$nama[alamat_sekolah]</h5>
                        <h5>Bukti Transaksi Tabungan Siswa</h5>
                    </center>
                </div>

                <div class='box-body'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>Nama Siswa </th> 
                                <td width='30px'>:</td>
                                <td>$detail[nasabah_nama]</td>                            
                            </tr>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>No.Rek / NIPD</th>
                                <td width='30px'>:</td>
                                <td>$record[id_nasabah]</td>
                            </tr>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>Kode Transaksi </th> 
                                <td width='30px'>:</td>
                                <td>$date$record[id_transaksi]</td>                            
                            </tr>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>Jenis Transaksi </th> 
                                <td width='30px'>:</td>
                                <td>$jenis[nama_akun]</td>                            
                            </tr>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>Nominal</th>
                                <td width='30px'>:</td>
                                <td>Rp. ".rupiah($record[nominal])."</td>
                            </tr>
                            <tr>
                                <td width='350px'></td>
                                <th width='120px'>Saldo</th> 
                                <td width='30px'>:</td>
                                <td>Rp. ".rupiah($record[total_saldo])."</td>                            
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    
                </div>
        </div>";