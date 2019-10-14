<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Koperasi extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_koperasi_supplier',array('aktif'=>'Y'),'id_supplier','DESC');
        $this->template->load('administrator/template','administrator/mod_koperasi/mod_suppliers/view',$data);
    }

    function tambah_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('nama_supplier'=>$this->input->post('a'),
                            'no_telpon'=>$this->input->post('b'),
                            'email'=>$this->input->post('c'),
                            'alamat'=>$this->input->post('d'));
            $this->model_app->insert('rb_koperasi_supplier',$data);
            redirect($this->uri->segment(1).'/suppliers');
        }else{
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_suppliers/tambah');
        }
    }

    function edit_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_supplier'=>$this->input->post('a'),
                            'no_telpon'=>$this->input->post('b'),
                            'email'=>$this->input->post('c'),
                            'alamat'=>$this->input->post('d'));
            $where = array('id_supplier' => $this->input->post('id'));
            $this->model_app->update('rb_koperasi_supplier', $data, $where);
            redirect($this->uri->segment(1).'/suppliers');
        }else{
            $edit = $this->model_app->view_where('rb_koperasi_supplier', array('id_supplier'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_suppliers/edit',$data);
        }
    }

    function delete_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $id = array('id_supplier' => $this->uri->segment(3));
        $this->model_app->delete('rb_koperasi_supplier',$id);
        redirect($this->uri->segment(1).'/suppliers');
    }


    function kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_koperasi_kategori',array('aktif'=>'Y'),'id_kategori','DESC');
        $this->template->load('administrator/template','administrator/mod_koperasi/mod_kategori/view',$data);
    }

    function tambah_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_kategori'=>$this->input->post('a'),
                            'id_guru'=>$this->session->id_session,
                            'aktif'=>'Y');
            $this->model_app->insert('rb_koperasi_kategori',$data);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_kategori/tambah',$data);
        }
    }

    function edit_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_kategori'=>$this->input->post('a'),
                            'id_guru'=>$this->session->id_session);
            $where = array('id_kategori' => $this->input->post('id'));
            $this->model_app->update('rb_koperasi_kategori', $data, $where);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $edit = $this->model_app->view_where('rb_koperasi_kategori', array('id_kategori'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_kategori/edit',$data);
        }
    }

    function delete_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $id = array('id_kategori' => $this->uri->segment(3));
        $this->model_app->delete('rb_koperasi_kategori',$id);
        redirect($this->uri->segment(1).'/kategori');
    }


    function produk(){
        cek_session_akses('produk',$this->session->id_session);
        $status = $this->uri->segment(3);
        if (isset($_GET['kategori'])){
            $data['record'] = $this->db->query("SELECT * FROM rb_koperasi_barang a LEFT JOIN rb_koperasi_kategori b ON a.id_kategori=b.id_kategori where a.jual='$status' AND a.id_kategori='$_GET[kategori]' AND a.aktif='Y' ORDER BY a.id_barang DESC");
        }else{
            $data['record'] = $this->db->query("SELECT * FROM rb_koperasi_barang a LEFT JOIN rb_koperasi_kategori b ON a.id_kategori=b.id_kategori where a.jual='$status' AND a.aktif='Y' ORDER BY a.id_barang DESC");
        }
        $this->template->load('administrator/template','administrator/mod_koperasi/mod_produk/view',$data);
    }

    function tambah_produk(){
        cek_session_akses('produk',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_kategori'=>$this->input->post('a'),
                            'kode_barang'=>$this->input->post('b'),
                            'nama_barang'=>$this->input->post('c'),
                            'harga'=>$this->input->post('d'),
                            'satuan'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'stok_margin'=>$this->input->post('ee'),
                            'jual'=>$this->input->post('ff'),
                            'id_guru'=>$this->session->id_session,
                            'aktif'=>'Y');
            $this->model_app->insert('rb_koperasi_barang',$data);
            redirect($this->uri->segment(1).'/produk/'.$this->input->post('ff'));
        }else{
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_produk/tambah',$data);
        }
    }

    function edit_produk(){
        cek_session_akses('produk',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_kategori'=>$this->input->post('a'),
                            'kode_barang'=>$this->input->post('b'),
                            'nama_barang'=>$this->input->post('c'),
                            'harga'=>$this->input->post('d'),
                            'satuan'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'stok_margin'=>$this->input->post('ee'),
                            'jual'=>$this->input->post('ff'),
                            'id_guru'=>$this->session->id_session,
                            'aktif'=>'Y');
            $where = array('id_barang' => $this->input->post('id'));
            $this->model_app->update('rb_koperasi_barang', $data, $where);
            redirect($this->uri->segment(1).'/produk/'.$this->input->post('ff'));
        }else{
            $edit = $this->model_app->view_where('rb_koperasi_barang', array('id_barang'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_koperasi/mod_produk/edit',$data);
        }
    }

    function delete_produk(){
        cek_session_akses('produk',$this->session->id_session);
        $id = array('id_barang' => $this->uri->segment(3));
        $this->model_app->delete('rb_koperasi_barang',$id);
        redirect($this->uri->segment(1).'/produk/'.$this->uri->segment(4));
    }

    function transaksi_pembelian(){
        cek_session_akses('transaksi_pembelian',$this->session->id_session);
        if (isset($_GET['selesai'])){
             $this->session->unset_userdata(array('beli'));
             redirect($this->uri->segment(1).'/transaksi_pembelian');
        }

        if (isset($_POST['simpan'])){
            if ($this->session->beli!=''){
                $data = array('id_supplier'=>$this->input->post('a'),
                            'kode_pembelian'=>$this->input->post('b'),
                            'tanggal_pembelian'=>tgl_simpan($this->input->post('c')),
                            'deskripsi'=>$this->input->post('d'));
                $where = array('id_pembelian' => $this->session->beli);
                $this->model_app->update('rb_koperasi_pembelian', $data, $where);
            }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_supplier'=>$this->input->post('a'),
                            'kode_pembelian'=>$this->input->post('b'),
                            'tanggal_pembelian'=>tgl_simpan($this->input->post('c')),
                            'deskripsi'=>$this->input->post('d'),
                            'id_coa'=>0,
                            'id_sub_coa'=>0,
                            'id_guru'=>$this->session->id_session);
                $this->model_app->insert('rb_koperasi_pembelian',$data);
                $this->session->set_userdata(array('beli'=>$this->db->insert_id()));
            }
            redirect($this->uri->segment(1).'/transaksi_pembelian');
        }elseif (isset($_POST['simpan_barang'])){
            $data = array('id_pembelian'=>$this->session->beli,
                            'id_barang'=>$this->input->post('aa'),
                            'jumlah_pesan'=>$this->input->post('bb'),
                            'harga_pesan'=>$this->input->post('cc'),
                            'satuan_pesan'=>$this->input->post('dd'));
            $this->model_app->insert('rb_koperasi_pembelian_detail',$data);
            redirect($this->uri->segment(1).'/transaksi_pembelian');
        }else{
            $this->template->load('administrator/template','administrator/mod_koperasi/pembelian',$data);
        }
    }

    function transaksi_penerimaan(){
        cek_session_akses('transaksi_penerimaan',$this->session->id_session);
        $this->session->unset_userdata(array('terima'));
        $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan',$data);
    }

    function transaksi_penerimaan_detail(){
        cek_session_akses('transaksi_penerimaan',$this->session->id_session);
        $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
        $data['tampil'] = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
        $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan_detail',$data);
    }

    function transaksi_penerimaan_bayar(){
        cek_session_akses('transaksi_penerimaan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $tot = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->row_array();
            $bayar = $this->db->query("SELECT sum(jumlah_bayar) as total FROM rb_koperasi_pembelian_bayar where id_pembelian='".$this->uri->segment(3)."'")->row_array();

            $sisa = $tot['total']-$bayar['total'];
            if ($this->input->post('bayar')>$sisa){ $bayar_masuk = $sisa; }else{ $bayar_masuk = $this->input->post('bayar'); } 
                $data = array('id_pembelian'=>$this->uri->segment(3),
                            'jumlah_bayar'=>$bayar_masuk,
                            'tanggal_bayar'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_koperasi_pembelian_bayar',$data);
                redirect($this->uri->segment(1).'/transaksi_penerimaan_bayar/'.$this->uri->segment(3));
        }else{
            $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
            $data['tampil'] = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
            $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan_bayar',$data);
        }
    }

    function transaksi_penerimaan_terima(){
        cek_session_akses('transaksi_penerimaan',$this->session->id_session);
        if (isset($_POST['submit'])){
          $trm_hitung = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima where id_pembelian='".$this->uri->segment(3)."'")->num_rows();
          $trm = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima where id_pembelian='".$this->uri->segment(3)."'")->row_array();
          if ($trm_hitung>=1){
            $data = array('no_terima'=>$this->input->post('a'),
                            'no_surat_jalan'=>$this->input->post('b'),
                            'pengirim'=>$this->input->post('c'),
                            'tanggal_terima'=>tgl_simpan($this->input->post('d')),
                            'id_guru'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'));
            $where = array('id_koperasi_pembelian_terima' => $trm['id_koperasi_pembelian_terima']);
            $this->model_app->update('rb_koperasi_pembelian_terima', $data, $where);
          }else{
            $data = array('id_pembelian'=>$this->uri->segment(3),
                            'no_terima'=>$this->input->post('a'),
                            'no_surat_jalan'=>$this->input->post('b'),
                            'pengirim'=>$this->input->post('c'),
                            'tanggal_terima'=>tgl_simpan($this->input->post('d')),
                            'id_guru'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'waktu_proses'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_koperasi_pembelian_terima',$data);
            $this->session->set_userdata(array('terima'=>$this->db->insert_id()));
          }
          
          if (trim($this->session->terima)==''){
            $ikpt = $this->input->post('ikpt');
          }else{
            $ikpt = $this->session->terima;
          }

          $cekbeli = $this->db->query("SELECT * FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->num_rows();
          for ($ia=1; $ia<=$cekbeli; $ia++){
            $a  = $_POST['barang'.$ia];
            $b  = $_POST['jumlah'.$ia];
              $cek = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima_detail where id_barang='$a' AND id_koperasi_pembelian_terima='$ikpt'")->num_rows();
              if ($cek >= '1'){
                $data1 = array('jumlah_terima'=>$b);
                $where1 = array('id_koperasi_pembelian_terima' => $ikpt,'id_barang'=>$a);
                $this->model_app->update('rb_koperasi_pembelian_terima_detail', $data1, $where1);
              }else{
                $data1 = array('id_koperasi_pembelian_terima'=>$ikpt,
                            'id_barang'=>$a,
                            'jumlah_terima'=>$b);
                $this->model_app->insert('rb_koperasi_pembelian_terima_detail',$data1);
              }
          }
          redirect($this->uri->segment(1).'/transaksi_penerimaan_terima/'.$this->uri->segment(3));
      }else{
        $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
        $data['trm'] = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima where id_pembelian='".$this->uri->segment(3)."'")->row_array();
        $data['trm_hitung'] = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima where id_pembelian='".$this->uri->segment(3)."'")->num_rows();
        $data['tampil'] = $this->db->query("SELECT a.*, b.id_barang, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
        $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan_terima',$data);
      }
    }

    function transaksi_penjualan(){
        cek_session_akses('transaksi_penjualan',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $coa = $this->db->query("SELECT * FROM rb_setting_coa where status='koperasi_jual'")->row_array();
              if ($this->session->jual!=''){
                $data1 = array('id_siswa'=>$this->input->post('a'),
                               'kode_penjualan'=>$this->input->post('b'),
                               'deskripsi'=>$this->input->post('d'));
                $where1 = array('id_penjualan' => $this->session->jual);
                $this->model_app->update('rb_koperasi_penjualan', $data1, $where1);
              }else{
                $data1 = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_coa'=>$coa['id_coa'],
                            'id_sub_coa'=>$coa['id_sub_coa'],
                            'kode_penjualan'=>$this->input->post('b'),
                            'id_siswa'=>$this->input->post('a'),
                            'metode'=>'-',
                            'jumlah_bayar'=>0,
                            'deskripsi'=>$this->input->post('d'),
                            'id_guru'=>$this->session->id_session,
                            'waktu_penjualan'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_koperasi_penjualan',$data1);
                $this->session->set_userdata(array('jual'=>$this->db->insert_id()));
              }
              redirect($this->uri->segment(1).'/transaksi_penjualan');

        }elseif (isset($_POST['simpanx'])){
              $data1 = array('jumlah_bayar'=>$this->input->post('bayar'),
                               'metode'=>$this->input->post('metode'),
                               'deskripsi'=>$this->input->post('d'));
                $where1 = array('id_penjualan' => $this->session->jual);
                $this->model_app->update('rb_koperasi_penjualan', $data1, $where1);
              $this->session->unset_userdata(array('jual'));
              // Refresh form
              // echo "<script>";
              // echo "window.open('".base_url().$this->uri->segment(1)."/transaksi_penjualan_print?id=".$this->input->post('idn')."', width=330,height=330,left=100, top=25)";
              // echo "</script>";
              redirect($this->uri->segment(1).'/transaksi_penjualan');
        }elseif (isset($_POST['simpan_barang'])){
                $data1 = array('id_penjualan'=>$this->session->jual,
                            'id_barang'=>$this->input->post('aa'),
                            'jumlah_jual'=>$this->input->post('bb'),
                            'harga'=>$this->input->post('cc'),
                            'satuan'=>$this->input->post('dd'),
                            'diskon'=>$this->input->post('ee'));
                $this->model_app->insert('rb_koperasi_penjualan_detail',$data1);
              redirect($this->uri->segment(1).'/transaksi_penjualan');
          }else{
            $data['tampil'] = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_penjualan_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_penjualan='".$this->session->jual."' ORDER BY id_penjualan_detail ASC");
            $this->template->load('administrator/template','administrator/mod_koperasi/penjualan',$data);
        }
    }

    function transaksi_penjualan_print(){
        cek_session_akses('transaksi_penjualan',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama_barang FROM `rb_koperasi_penjualan_detail` a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_penjualan='$_GET[id]'");
        $this->load->view('administrator/mod_koperasi/penjualan_report_print',$data);
    }

    function laporan_penjualan(){
        cek_session_akses('laporan_penjualan',$this->session->id_session);
        if(isset($_GET['tanggal'])){
            $ex = explode(' - ',$_GET['tanggal']);
            $exx = explode('-',$ex[0]);
            $exy = explode('-',$ex[1]);
            $mulai = $exx[2].'-'.$exx[1].'-'.$exx[0].' 00:01:00';
            $selesai = $exy[2].'-'.$exy[1].'-'.$exy[0].' 23:59:00';
            $data['mulai'] = $exx[2].'-'.$exx[1].'-'.$exx[0];
            $data['selesai'] = $exy[2].'-'.$exy[1].'-'.$exy[0];

          $data['tampil'] = $this->db->query("SELECT a.*, b.nama FROM rb_koperasi_penjualan a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa where a.waktu_penjualan between '$mulai' AND '$selesai' ORDER BY a.id_penjualan DESC");
        }else{
          $data['tampil'] = $this->db->query("SELECT a.*, b.nama FROM rb_koperasi_penjualan a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa ORDER BY a.id_penjualan DESC");
        }
        $this->template->load('administrator/template','administrator/mod_koperasi/penjualan_report',$data);
    }

    function laporan_penjualan_detail(){
        cek_session_akses('laporan_penjualan',$this->session->id_session);
          $data['tot'] = $this->db->query("SELECT sum((harga*jumlah_jual)-diskon) as total FROM rb_koperasi_penjualan_detail where id_penjualan='".$this->uri->segment(3)."'")->row_array();
          $data['d'] = $this->db->query("SELECT a.*, b.nama FROM rb_koperasi_penjualan a JOIN rb_siswa b On a.id_siswa=b.id_siswa where id_penjualan='".$this->uri->segment(3)."'")->row_array();
          $data['tampil'] = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_penjualan_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_penjualan='".$this->uri->segment(3)."' ORDER BY id_penjualan_detail ASC");
          $this->template->load('administrator/template','administrator/mod_koperasi/penjualan_report_detail',$data);
    }

    function laporan_penjualan_print(){
        cek_session_akses('laporan_penjualan',$this->session->id_session);
          $mulai = $_GET['mulai'].' 00:01:00';
          $selesai = $_GET['selesai'].' 23:59:00';
            $data['tampil'] = $this->db->query("SELECT a.*, b.nama FROM rb_koperasi_penjualan a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa where a.waktu_penjualan between '$mulai' AND '$selesai' ORDER BY a.id_penjualan DESC");

          $this->load->view('administrator/mod_koperasi/penjualan_report_print_all',$data);
    }

    function laporan_penerimaan(){
        cek_session_akses('laporan_penerimaan',$this->session->id_session);
          $this->session->unset_userdata(array('terima'));
          $data['tampil'] = $this->db->query("SELECT a.*, c.nama_supplier, d.nama_guru FROM `rb_koperasi_pembelian_terima` a JOIN rb_koperasi_pembelian b ON a.id_pembelian=b.id_pembelian JOIN rb_koperasi_supplier c ON b.id_supplier=c.id_supplier LEFT JOIN rb_guru d ON a.id_guru=d.id_guru ORDER BY a.id_koperasi_pembelian_terima DESC");
          $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan_report',$data);
    }

    function laporan_penerimaan_detail(){
        cek_session_akses('laporan_penerimaan',$this->session->id_session);
          $this->session->unset_userdata(array('terima'));
            $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
            $data['trm'] = $this->db->query("SELECT a.*, b.nama_guru FROM rb_koperasi_pembelian_terima a JOIN rb_guru b ON a.id_guru=b.id_guru where a.id_pembelian='".$this->uri->segment(3)."'")->row_array();

          $data['tampil'] = $this->db->query("SELECT a.*, b.id_barang, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
          $this->template->load('administrator/template','administrator/mod_koperasi/penerimaan_report_detail',$data);
    }

    function laporan_penerimaan_detail_print(){
        cek_session_akses('laporan_penerimaan',$this->session->id_session);
          $this->session->unset_userdata(array('terima'));
            $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
            $data['trm'] = $this->db->query("SELECT a.*, b.nama_guru FROM rb_koperasi_pembelian_terima a JOIN rb_guru b ON a.id_guru=b.id_guru where a.id_pembelian='".$this->uri->segment(3)."'")->row_array();

          $data['tampil'] = $this->db->query("SELECT a.*, b.id_barang, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
          $this->load->view('administrator/mod_koperasi/penerimaan_report_detail_print',$data);
    }
}
