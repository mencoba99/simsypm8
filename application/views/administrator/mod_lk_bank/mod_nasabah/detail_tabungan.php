<html>
<head>
<title>Tabungan Siswa</title>
</head>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">

<body onload="window.print()">

<div class="col-xs-12">  
  <div class="box">
    <div class="box-body">

        <?php
        $iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $tgl = date('D, d-m-Y');
        echo "
        <center>
        <h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
        <h2 style='margin:0px'>$iden[nama_sekolah]</h2>
        <p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
        </center>

        <table>
            <tbody>
              <tr><td>Tabunganku</td></tr>
              <tr><td style='font-weight:bold' width='150px' scope='row'>Nama Nasabah</td> <td> : $siswa[nama]</td></tr>
              <tr><td style='font-weight:bold' scope='row'>No Rekening</td>          <td> : $record[no_rek]</td></tr>
              <tr><td style='font-weight:bold' scope='row'>Tanggal</td>          <td> : $tgl</td></tr>
            </tbody>
            </table>

        <table id='tablemodul1' width=100% border=1>
        <thead>
          <tr>
            <th style='width : 50px; text-align: center' class='center'>No</th>
            <th style='text-align: center'>Tanggal Transaksi</th>
            <th style='text-align: center'>Jenis Transaksi</th>
            <th style='text-align: center'>Nominal</th>
            <th style='text-align: center'>Saldo Terkini</th>
          </tr>
        </thead>
        <tbody>";

        $no = 1;
        foreach ($transaksi as $r){
        $date = date("d/m/Y", strtotime($r['tgl_transaksi']));          
        echo "<tr>
                  <td style='text-align : center;'>$no</td>
                  <td>".tgl_indo($r['tgl_transaksi'])."</td>
                  <td>$r[nama_akun]</td>
                  <td style='text-align: right;'>Rp. ".rupiah($r[nominal])."</td>
                  <td style='text-align: right;'>Rp. ".rupiah($r[total_saldo])."</td>
              </tr>";
          $no++;
          }

        echo "</tbody>
        </table>
          
        ";
        ?>
    </div>
  </div>
</div>
</body>
</html>
  
