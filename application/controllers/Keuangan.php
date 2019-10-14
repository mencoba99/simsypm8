<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Keuangan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function coa(){
        cek_session_akses('coa',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
        $this->template->load('administrator/template','administrator/mod_coa/view',$data);
    }

    function tambah_coa(){
        cek_session_akses('coa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_coa'=>$this->input->post('a'),
                            'nama_coa'=>$this->input->post('b'));
            $this->model_app->insert('rb_keuangan_coa',$data);
            redirect($this->uri->segment(1).'/coa');
        }else{
            $this->template->load('administrator/template','administrator/mod_coa/tambah');
        }
    }

    function edit_coa(){
        cek_session_akses('coa',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_coa'=>$this->input->post('a'),
                            'nama_coa'=>$this->input->post('b'));
            $where = array('id_coa' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_keuangan_coa', $data, $where);
            redirect($this->uri->segment(1).'/coa');
        }else{
            $edit = $this->model_app->view_where('rb_keuangan_coa', array('id_coa'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_coa/edit',$data);
        }
    }

    function delete_coa(){
        cek_session_akses('coa',$this->session->id_session);
        $id = array('id_coa' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_keuangan_coa',$id);
        redirect($this->uri->segment(1).'/coa');
    }

    function sub_coa(){
        cek_session_akses('sub_coa',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_keuangan_sub_coa.* ,nama_coa','rb_keuangan_sub_coa','rb_keuangan_coa','id_coa',array('rb_keuangan_coa.id_identitas_sekolah'=>$this->session->sekolah),'id_sub_coa','ASC');
        $this->template->load('administrator/template','administrator/mod_sub_coa/view',$data);
    }

    function tambah_sub_coa(){
        cek_session_akses('sub_coa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_coa'=>$this->input->post('a'),
                            'kode_sub_coa'=>$this->input->post('b'),
                            'nama_sub_coa'=>$this->input->post('c'));
            $this->model_app->insert('rb_keuangan_sub_coa',$data);
            redirect($this->uri->segment(1).'/sub_coa');
        }else{
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $data = array('coa' => $coa);
            $this->template->load('administrator/template','administrator/mod_sub_coa/tambah',$data);
        }
    }

    function edit_sub_coa(){
        cek_session_akses('sub_coa',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_coa'=>$this->input->post('a'),
                            'kode_sub_coa'=>$this->input->post('b'),
                            'nama_sub_coa'=>$this->input->post('c'));
            $where = array('id_sub_coa' => $this->input->post('id'));
            $this->model_app->update('rb_keuangan_sub_coa', $data, $where);
            redirect($this->uri->segment(1).'/sub_coa');
        }else{
            $edit = $this->model_app->view_where('rb_keuangan_sub_coa', array('id_sub_coa'=>$id))->row_array();
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $data = array('s' => $edit,'coa' => $coa);
            $this->template->load('administrator/template','administrator/mod_sub_coa/edit',$data);
        }
    }

    function delete_sub_coa(){
        cek_session_akses('sub_coa',$this->session->id_session);
        $id = array('id_sub_coa' => $this->uri->segment(3));
        $this->model_app->delete('rb_keuangan_sub_coa',$id);
        redirect($this->uri->segment(1).'/sub_coa');
    }

    function jenis_biaya(){
        cek_session_akses('jenis_biaya',$this->session->id_session);
        $record = $this->model_app->jenis_biaya();
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
        $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
        $this->template->load('administrator/template','administrator/mod_jenis_biaya/view',$data);
    }

    function tambah_jenis_biaya(){
        cek_session_akses('jenis_biaya',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('tahun'),
                            'id_kelas'=>$this->input->post('kelas'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'),
                            'nama_jenis'=>$this->input->post('a'),
                            'total_beban'=>$this->input->post('b'));
            $this->model_app->insert('rb_keuangan_jenis',$data);
            redirect($this->uri->segment(1).'/jenis_biaya?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas'));
        }else{
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $sub_coa = $this->model_app->view_join_where('*','rb_keuangan_sub_coa','rb_keuangan_coa','id_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_sub_coa','ASC');
            $data = array('coa' => $coa,'sub_coa' => $sub_coa);
            $this->template->load('administrator/template','administrator/mod_jenis_biaya/tambah',$data);
        }
    }

    function edit_jenis_biaya(){
        cek_session_akses('jenis_biaya',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('tahun'),
                            'id_kelas'=>$this->input->post('kelas'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'),
                            'nama_jenis'=>$this->input->post('a'),
                            'total_beban'=>$this->input->post('b'));
            $where = array('id_keuangan_jenis' => $this->input->post('id'));
            $this->model_app->update('rb_keuangan_jenis', $data, $where);
            redirect($this->uri->segment(1).'/jenis_biaya?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas'));
        }else{
            $edit = $this->model_app->view_where('rb_keuangan_jenis', array('id_keuangan_jenis'=>$id))->row_array();
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $sub_coa = $this->model_app->view_join_where('*','rb_keuangan_sub_coa','rb_keuangan_coa','id_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_sub_coa','ASC');
            $data = array('s' => $edit,'coa' => $coa,'sub_coa' => $sub_coa);
            $this->template->load('administrator/template','administrator/mod_jenis_biaya/edit',$data);
        }
    }

    function delete_jenis_biaya(){
        cek_session_akses('jenis_biaya',$this->session->id_session);
        $id = array('id_keuangan_jenis' => $this->uri->segment(3));
        $this->model_app->delete('rb_keuangan_jenis',$id);
        redirect($this->uri->segment(1).'/jenis_biaya?tahun='.$this->uri->segment(4).'&kelas='.$this->uri->segment(5));
    }

    function pembayaran_siswa(){
        cek_session_akses('pembayaran_siswa',$this->session->id_session);
        $record = $this->model_app->pembayaran_siswa();
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
        $jenis_biaya = $this->model_app->view_where_ordering('rb_keuangan_jenis',array('id_tahun_akademik'=>$this->input->get('tahun'),'id_kelas'=>$this->input->get('kelas')),'id_keuangan_jenis','ASC');
        $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas,'jenis_biaya'=>$jenis_biaya);
        $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/view',$data);
    }

    function detail_pembayaran_siswa(){
        cek_session_akses('pembayaran_siswa',$this->session->id_session);
        if (isset($_POST['proses'])){
            $data = array('id_keuangan_jenis'=>$this->input->get('biaya'),
                            'id_kelas'=>$this->input->get('kelas'),
                            'id_siswa'=>$this->input->get('id_siswa'),
                            'id_tahun_akademik'=>$this->input->get('tahun'),
                            'kode'=>$this->input->post('kode'),
                            'metode'=>$this->input->post('metode'),
                            'total_bayar'=>$this->input->post('bayar'),
                            'id_user'=>$this->session->id_session,
                            'waktu_bayar'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_keuangan_bayar',$data);
            redirect($this->uri->segment(1).'/detail_pembayaran_siswa?tahun='.$_GET["tahun"].'&kelas='.$_GET["kelas"].'&biaya='.$_GET["biaya"].'&id_siswa='.$_GET["id_siswa"]);
        }else{
            $jenis_keuangan = $this->model_app->view_where('rb_keuangan_jenis',array('id_keuangan_jenis'=>$this->input->get('biaya')))->row_array();
            $total_bayar = $this->model_app->total_bayar()->row_array();
            $siswa = $this->model_app->view_join_where_single('*','rb_siswa','rb_kelas','id_kelas',array('id_siswa'=>$this->input->get('id_siswa')),'id_siswa','ASC')->row_array();
            
            $pembayaran = $this->model_app->view_where_ordering('rb_keuangan_bayar',array('id_keuangan_jenis'=>$this->input->get('biaya'),'id_kelas'=>$this->input->get('kelas'),'id_siswa'=>$this->input->get('id_siswa'),'id_tahun_akademik'=>$this->input->get('tahun')),'id_keuangan_bayar','DESC');
            $data = array('j' => $jenis_keuangan,'t' => $total_bayar,'d' => $siswa,'pembayaran' => $pembayaran);
            $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/detail',$data);
        }
    }

    function print_pembayaran_siswa(){
        cek_session_akses('pembayaran_siswa',$this->session->id_session);
        $jenis_keuangan = $this->model_app->view_where('rb_keuangan_jenis',array('id_keuangan_jenis'=>$this->input->get('biaya')))->row_array();
        $total_bayar = $this->model_app->total_bayar()->row_array();
        $siswa = $this->model_app->view_join_where_single('*','rb_siswa','rb_kelas','id_kelas',array('id_siswa'=>$this->input->get('id_siswa')),'id_siswa','ASC')->row_array();
        $pembayaran = $this->model_app->view_where_ordering('rb_keuangan_bayar',array('id_keuangan_jenis'=>$this->input->get('biaya'),'id_kelas'=>$this->input->get('kelas'),'id_siswa'=>$this->input->get('id_siswa'),'id_tahun_akademik'=>$this->input->get('tahun')),'id_keuangan_bayar','ASC');
        
        $iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $kepsek = $this->model_app->view_where('rb_users',array('level'=>'kepala','id_identitas_sekolah'=>$this->session->sekolah))->row_array();

        $data = array('j' => $jenis_keuangan,'t' => $total_bayar,'d' => $siswa,'pembayaran' => $pembayaran,'iden' => $iden,'kepsek' => $kepsek);
        $this->load->view('administrator/mod_pembayaran_siswa/print',$data);
    }

    function data_keuangan_coa(){
        cek_session_akses('pembayaran_siswa',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/jurnal_coa');
    }

    function transaksi_koperasi(){
        cek_session_akses('transaksi_koperasi',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT a.*, b.nama_supplier, x.nama_coa, y.nama_sub_coa FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier 
                                                  LEFT JOIN rb_keuangan_coa x ON a.id_coa=x.id_coa 
                                                        LEFT JOIN rb_keuangan_sub_coa y ON a.id_sub_coa=y.id_sub_coa
                                                          ORDER BY a.id_pembelian DESC");
        $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/koperasi',$data);
    }

    function transaksi_koperasi_detail(){
        cek_session_akses('coa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'));
            $where = array('id_pembelian' => $this->uri->segment(3));
            $this->model_app->update('rb_koperasi_pembelian', $data, $where);
            redirect($this->uri->segment(1).'/transaksi_koperasi_detail/'.$this->uri->segment(3));
        }else{
            $data['d'] = $this->db->query("SELECT a.*, b.nama_supplier FROM rb_koperasi_pembelian a JOIN rb_koperasi_supplier b On a.id_supplier=b.id_supplier where id_pembelian='".$this->uri->segment(3)."'")->row_array();
            $data['tot'] = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->row_array();

            $data['record'] = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->uri->segment(3)."' ORDER BY id_pembelian_detail ASC");
            $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/koperasi_detail',$data);
        }
    }

    function coa_koperasi(){
        cek_session_akses('coa_koperasi',$this->session->id_session);
        if (isset($_POST['update'])){
            $data = array('nama_jenis'=>$this->input->post('a'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'));
            $where = array('id_setting_coa' => $this->input->post('id'));
            $this->model_app->update('rb_setting_coa', $data, $where);
            redirect($this->uri->segment(1).'/coa_koperasi');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_setting_coa where id_setting_coa='1'")->row_array();
            $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/koperasi_coa',$data);
        }
    }

    function laporan_keuangan_kasir(){
        cek_session_akses('laporan_keuangan_kasir',$this->session->id_session);
            $data['record'] = $this->db->query("SELECT * FROM rb_keuangan_bayar a LEFT JOIN rb_guru b ON a.id_user=b.id_guru GROUP BY a.id_user DESC");
            $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/keuangan_kasir',$data);
    }

    function print_keuangan_detail(){
        cek_session_akses('laporan_keuangan_kasir',$this->session->id_session);
        $this->load->view('administrator/mod_pembayaran_siswa/keuangan_kasir_detail_print',$data);
    }

    function print_keuangan_rekap(){
        cek_session_akses('laporan_keuangan_kasir',$this->session->id_session);
        $this->load->view('administrator/mod_pembayaran_siswa/keuangan_kasir_print',$data);
    }

    function kartu_ujian(){
        cek_session_akses('kartu_ujian',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/kartu_ujian',$data);
    }

    function print_kartu_ujian(){
        cek_session_akses('kartu_ujian',$this->session->id_session);
        $this->load->view('administrator/mod_pembayaran_siswa/kartu_ujian_print',$data);
    }

    function jurnal_keuangan(){
        cek_session_akses('jurnal_keuangan',$this->session->id_session);
        $tampil = $this->db->query("SELECT * FROM rb_keuangan_coa ORDER BY id_coa ASC");
        $date = $this->input->get('bulan');
        $bulan = substr($date, 5, 6);
        $tahun = substr($date, 0, 4);
        $data = array('tampil' => $tampil, 'date' => $date, 'bulan' => $bulan, 'tahun' => $tahun);
        $this->template->load('administrator/template','administrator/mod_pembayaran_siswa/jurnal_keuangan_coa',$data);
    }

    function pengeluaran(){
        cek_session_akses('pengeluaran',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_lk_keuangan_keluar.* ,nama_coa','rb_lk_keuangan_keluar','rb_keuangan_coa','id_coa',array('rb_keuangan_coa.id_identitas_sekolah'=>$this->session->sekolah),'id_pengeluaran','ASC');
        $this->template->load('administrator/template','administrator/mod_pengeluaran/view',$data);
    }

    function tambah_pengeluaran(){
        cek_session_akses('pengeluaran',$this->session->id_session);
        // return var_dump($this->session->userdata());
        if (isset($_POST['submit'])){
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for ( $i = 0 ; $i < $cpt ; $i++ ) {
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileupload = str_replace(' ','_',$fileName);
            if ($fileName=='') {
                $data = $data = array('id_pengeluaran'=>$this->input->post('id'),
                            'kode'=>$this->input->post('a'),
                            'nama'=>$this->input->post('b'),
                            'deskripsi'=>$this->input->post('e'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'),
                            'metode'=>$this->input->post('f'),
                            'qty'=>NULL,
                            'total_bayar'=>$this->input->post('h'),
                            'id_user'=>$this->session->userdata('username'),
                            'waktu_bayar'=>date('Y-m-d H:i:s'));
            } else {
                $data = array('id_pengeluaran'=>$this->input->post('id'),
                            'kode'=>$this->input->post('a'),
                            'nama'=>$this->input->post('b'),
                            'deskripsi'=>$this->input->post('e'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'),
                            'metode'=>$this->input->post('f'),
                            'qty'=>NULL,
                            'total_bayar'=>$this->input->post('h'),
                            'bukti'=>$fileName,
                            'id_user'=>$this->session->userdata('username'),
                            'waktu_bayar'=>date('Y-m-d H:i:s'));
            }

            $this->model_app->insert('rb_lk_keuangan_keluar',$data);
            redirect($this->uri->segment(1).'/pengeluaran');
        } else {
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $sub_coa = $this->model_app->view_join_where('*','rb_keuangan_sub_coa','rb_keuangan_coa','id_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_sub_coa','ASC');
            $data = array('coa' => $coa, 'sub_coa' => $sub_coa);
            $this->template->load('administrator/template','administrator/mod_pengeluaran/tambah',$data);
        }
    }

    function edit_pengeluaran(){
        cek_session_akses('pengeluaran',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama'=>$this->input->post('a'),
                            'deskripsi'=>$this->input->post('b'),
                            'id_coa'=>$this->input->post('c'),
                            'id_sub_coa'=>$this->input->post('d'),
                            'metode'=>$this->input->post('e'),
                            'total_bayar'=>$this->input->post('f'));
            $where = array('id_pengeluaran' => $this->input->post('id'));
            $this->model_app->update('rb_lk_keuangan_keluar', $data, $where);
            redirect($this->uri->segment(1).'/pengeluaran');
        } else {
            $coa = $this->model_app->view_where_ordering('rb_keuangan_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_coa','ASC');
            $sub_coa = $this->model_app->view_join_where('*','rb_keuangan_sub_coa','rb_keuangan_coa','id_coa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_sub_coa','ASC');
            $edit = $this->model_app->view_where('rb_lk_keuangan_keluar', array('id_pengeluaran'=>$id))->row_array();
            $data = array('coa' => $coa, 'sub_coa' => $sub_coa, 's' => $edit);
            $this->template->load('administrator/template','administrator/mod_pengeluaran/edit',$data);
        }
    }

    function delete_pengeluaran(){
        cek_session_akses('pengeluaran',$this->session->id_session);
        $id = array('id_pengeluaran' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_keuangan_keluar',$id);
        redirect($this->uri->segment(1).'/pengeluaran');
    }

    private function set_upload_options(){
        $config = array();
        $config['upload_path'] = 'asset/Bukti_Pengeluaran/';
        $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt|jpeg';
        $config['max_size'] = '30000'; // kb
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
      return $config;
    }
}
