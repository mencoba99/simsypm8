<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Penerimaan </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>No Terima</th>
            <th>No Surat Jalan</th>
            <th>Pengirim</th>
            <th>Nama Supplier</th>
            <th>Tanggal Terima</th>
            <th>Diterima Oleh</th>
            <th style='width:50px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        echo "<tr><td>$no</td>
                  <td>$r[no_terima]</td>
                  <td>$r[no_surat_jalan]</td>
                  <td>$r[pengirim]</td>
                  <td>$r[nama_supplier]</td>
                  <td>".tgl_indo($r['tanggal_terima'])."</td>
                  <td>$r[nama_guru]</td>
                  <td><center>
                    <a class='btn btn-info btn-xs' title='Data Penerimaan' href='".base_url().$this->uri->segment(1)."/laporan_penerimaan_detail/$r[id_pembelian]'><span class='fa fa-search'></span></a>
                    <a target='_BLANK' href='".base_url().$this->uri->segment(1)."/laporan_penerimaan_detail_print/$r[id_pembelian]' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-print'></span></a>
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
