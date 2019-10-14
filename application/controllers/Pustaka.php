<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pustaka extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function buku_tamu(){
        cek_session_akses('buku_tamu',$this->session->id_session);
        if (isset($_POST['tambahkan'])){
            $ex = explode(';', $_POST['a']);
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_siswa'=>$ex[0],
                            'id_guru'=>$this->session->id_session,
                            'keterangan'=>'Kunjungan',
                            'status'=>$ex[1],
                            'waktu_kunjung'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_pustaka_bukutamu',$data);
            redirect($this->uri->segment(1).'/buku_tamu');

        }elseif (isset($_POST['umum'])){
            $data = $_POST['a'].';'.$_POST['b'].';'.$_POST['c'].';'.$_POST['d'];
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_siswa'=>0,
                            'id_guru'=>$this->session->id_session,
                            'keterangan'=>$data,
                            'status'=>'umum',
                            'waktu_kunjung'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_pustaka_bukutamu',$data);
            redirect($this->uri->segment(1).'/buku_tamu');
        }else{
            $data['tampil'] = $this->db->query("SELECT * FROM `rb_pustaka_bukutamu` ORDER BY id_bukutamu DESC");
            $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_buku_tamu',$data);
        }
    }

    function delete_buku_tamu(){
        cek_session_akses('buku_tamu',$this->session->id_session);
        $id = array('id_bukutamu' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_bukutamu',$id);
        redirect($this->uri->segment(1).'/buku_tamu');
    }


    function kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_pustaka_kategori','id_kategori','DESC');
        $this->template->load('administrator/template','administrator/mod_pustaka/mod_kategori/view',$data);
    }

    function tambah_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_kategori'=>$this->input->post('a'),
                            'id_guru'=>$this->session->id_session);
            $this->model_app->insert('rb_pustaka_kategori',$data);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_kategori/tambah',$data);
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
            $this->model_app->update('rb_pustaka_kategori', $data, $where);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $edit = $this->model_app->view_where('rb_pustaka_kategori', array('id_kategori'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_kategori/edit',$data);
        }
    }

    function delete_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $id = array('id_kategori' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_kategori',$id);
        redirect($this->uri->segment(1).'/kategori');
    }


    function buku(){
        cek_session_akses('buku',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT a.*, b.nama_kategori FROM rb_pustaka_buku a JOIN rb_pustaka_kategori b ON a.id_kategori=b.id_kategori ORDER BY id_buku DESC");
        $this->template->load('administrator/template','administrator/mod_pustaka/mod_buku/view',$data);
    }

    function tambah_buku(){
        cek_session_akses('buku',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_buku/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '10000'; // kb
            $config['file_name'] = date('YmdHis').'_'.$_FILES["f"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($_FILES["foto"]['name']==''){
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_kategori'=>$this->input->post('a'),
                                'kode_buku'=>$this->input->post('b'),
                                'judul'=>$this->input->post('c'),
                                'pengarang'=>$this->input->post('d'),
                                'penerbit'=>$this->input->post('e'),
                                'deskripsi'=>$this->input->post('g'),
                                'jumlah'=>$this->input->post('h'),
                                'tahun_terbit'=>$this->input->post('tahun_terbit'),
                                'tahun_pengadaan'=>$this->input->post('tahun_pengadaan'),
                                'harga_buku'=>$this->input->post('harga_buku'),
                                'sumber_dana'=>$this->input->post('sumber_dana'),
                                'id_guru'=>$this->session->id_session);
            }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_kategori'=>$this->input->post('a'),
                                'kode_buku'=>$this->input->post('b'),
                                'judul'=>$this->input->post('c'),
                                'pengarang'=>$this->input->post('d'),
                                'penerbit'=>$this->input->post('e'),
                                'foto'=>$hasil['file_name'],
                                'deskripsi'=>$this->input->post('g'),
                                'jumlah'=>$this->input->post('h'),
                                'tahun_terbit'=>$this->input->post('tahun_terbit'),
                                'tahun_pengadaan'=>$this->input->post('tahun_pengadaan'),
                                'harga_buku'=>$this->input->post('harga_buku'),
                                'sumber_dana'=>$this->input->post('sumber_dana'),
                                'id_guru'=>$this->session->id_session);
            }
            $this->model_app->insert('rb_pustaka_buku',$data);
            redirect($this->uri->segment(1).'/buku');
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_buku/tambah',$data);
        }
    }

    function edit_buku(){
        cek_session_akses('buku',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_buku/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '10000'; // kb
            $config['file_name'] = date('YmdHis').'_'.$_FILES["f"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($_FILES["foto"]['name']==''){
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_kategori'=>$this->input->post('a'),
                                'kode_buku'=>$this->input->post('b'),
                                'judul'=>$this->input->post('c'),
                                'pengarang'=>$this->input->post('d'),
                                'penerbit'=>$this->input->post('e'),
                                'deskripsi'=>$this->input->post('g'),
                                'jumlah'=>$this->input->post('h'),
                                'tahun_terbit'=>$this->input->post('tahun_terbit'),
                                'tahun_pengadaan'=>$this->input->post('tahun_pengadaan'),
                                'harga_buku'=>$this->input->post('harga_buku'),
                                'sumber_dana'=>$this->input->post('sumber_dana'),
                                'id_guru'=>$this->session->id_session);
            }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_kategori'=>$this->input->post('a'),
                                'kode_buku'=>$this->input->post('b'),
                                'judul'=>$this->input->post('c'),
                                'pengarang'=>$this->input->post('d'),
                                'penerbit'=>$this->input->post('e'),
                                'foto'=>$hasil['file_name'],
                                'deskripsi'=>$this->input->post('g'),
                                'jumlah'=>$this->input->post('h'),
                                'tahun_terbit'=>$this->input->post('tahun_terbit'),
                                'tahun_pengadaan'=>$this->input->post('tahun_pengadaan'),
                                'harga_buku'=>$this->input->post('harga_buku'),
                                'sumber_dana'=>$this->input->post('sumber_dana'),
                                'id_guru'=>$this->session->id_session);
            }
            $where = array('id_buku' => $this->input->post('id'));
            $this->model_app->update('rb_pustaka_buku', $data, $where);
            redirect($this->uri->segment(1).'/buku');
        }else{
            $edit = $this->model_app->view_where('rb_pustaka_buku', array('id_buku'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_buku/edit',$data);
        }
    }

    function kondisi_buku(){
        cek_session_akses('buku',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_buku'=>$this->uri->segment(3),
                                'kondisi'=>$this->input->post('a'),
                                'jumlah'=>$this->input->post('b'),
                                'waktu'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_pustaka_buku_kondisi',$data);
            redirect($this->uri->segment(1).'/kondisi_buku/'.$this->uri->segment(3));
        }else{
            $edit = $this->model_app->view_where('rb_pustaka_buku', array('id_buku'=>$id))->row_array();
            $tampil = $this->db->query("SELECT * FROM rb_pustaka_buku_kondisi where id_buku='$id' ORDER BY id_buku_kondisi DESC");
            $data = array('s' => $edit,'tampil' => $tampil);
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_buku/kondisi',$data);
        }
    }

    function delete_kondisi_buku(){
        cek_session_akses('buku',$this->session->id_session);
        $id = array('id_buku_kondisi' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_buku_kondisi',$id);
        redirect($this->uri->segment(1).'/kondisi_buku/'.$this->uri->segment(4));
    }

    function delete_buku(){
        cek_session_akses('buku',$this->session->id_session);
        $id = array('id_buku' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_buku',$id);
        redirect($this->uri->segment(1).'/buku');
    }


    function kartu_pustaka(){
        cek_session_akses('kartu_pustaka',$this->session->id_session);
        if (isset($_POST['tambahkan'])){
            $ex = explode(';', $this->input->post('a'));
            $cek = $this->db->query("SELECT * FROM rb_pustaka_kartu where id_siswa='".$ex[0]."' AND status='".$ex[1]."'");
            if ($cek->num_rows()>=1){
              echo "<script>window.alert('Gagal!!!, Maaf Data Sudah ada Di Database!');
                                          window.location=('".base_url().$this->uri->segment(1)."/kartu_pustaka')</script>";
            }else{
                $data = array('id_siswa'=>$ex[0],
                                'id_guru'=>$this->session->id_session,
                                'no_kartu'=>"PSTA-".date('YmdHis'),
                                'status'=>$ex[1],
                                'tanggal_create'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_pustaka_kartu',$data);
            }
            redirect($this->uri->segment(1).'/kartu_pustaka');
        }else{
            $data['record'] = $this->db->query("SELECT * FROM `rb_pustaka_kartu` ORDER BY id_kartu DESC");
            $this->template->load('administrator/template','administrator/mod_pustaka/kartu_pustaka',$data);
        }
    }

    function kartu_pustaka_print(){
        cek_session_akses('kartu_pustaka',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT * FROM `rb_pustaka_kartu` ORDER BY id_kartu DESC");
        $this->load->view('administrator/mod_pustaka/kartu_pustaka_print',$data);
    }

    function kartu_pustaka_hapus(){
        cek_session_akses('kartu_pustaka',$this->session->id_session);
        $id = array('id_kartu' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_kartu',$id);
        redirect($this->uri->segment(1).'/kartu_pustaka');
    }


    function setting(){
        cek_session_akses('setting_denda',$this->session->id_session);
        if (isset($_POST['update'])){
            $data = array('nominal'=>$this->input->post('a'),
                          'keterangan'=>$this->input->post('b'));
            $where = array('id_denda' => $this->input->post('id'));
            $this->model_app->update('rb_pustaka_denda', $data, $where);

            $data1 = array('durasi'=>$this->input->post('c'));
            $where1 = array('id_pustaka_setting' => 1);
            $this->model_app->update('rb_pustaka_setting', $data1, $where1);
            redirect($this->uri->segment(1).'/setting');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_pustaka_denda order by id_denda DESC LIMIT 1")->row_array();
            $data['e'] = $this->db->query("SELECT * FROM rb_pustaka_setting where id_pustaka_setting='1'")->row_array();
            $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_denda',$data);
        }
    }

    function transaksi_peminjaman(){
        cek_session_akses('transaksi_peminjaman',$this->session->id_session);
        if (isset($_GET['selesai'])){
            $this->session->unset_userdata(array('pinjam'));
            redirect($this->uri->segment(1).'/transaksi_peminjaman');
        }

        if (isset($_POST['simpan'])){
              if ($this->session->pinjam!=''){
                $data = array('id_siswa'=>$this->input->post('a'),
                            'tanggal_pinjam'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'));
                $where = array('id_pinjam' => $this->session->pinjam);
                $this->model_app->update('rb_pustaka_pinjam', $data, $where);
              }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_siswa'=>$this->input->post('a'),
                                'tanggal_pinjam'=>tgl_simpan($this->input->post('b')),
                                'keterangan'=>$this->input->post('c'),
                                'id_guru'=>$this->session->id_session);
                $this->model_app->insert('rb_pustaka_pinjam',$data);
                $this->session->set_userdata(array('pinjam'=>$this->db->insert_id()));
              }
            redirect($this->uri->segment(1).'/transaksi_peminjaman');

        }elseif (isset($_POST['simpan_buku'])){
            $buku = $this->db->query("SELECT jumlah FROm rb_pustaka_buku where id_buku='$_POST[aa]'")->row_array();
            $pinjam = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_buku='".$this->input->post('aa')."'")->row_array();
            $kembali = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_kembali where id_buku='".$this->input->post('aa')."'")->row_array();

            $stok = ($buku['jumlah']-$pinjam['jumlah'])+$kembali['jumlah'];
            if($stok>=$this->input->post('bb')){
              if($this->input->post('bb')>=1){
                $date = date_create(date('Y-m-d'));
                date_add($date, date_interval_create_from_date_string($this->input->post('cc').' days'));
                $hasil = date_format($date, 'Y-m-d');
                $set = $this->db->query("SELECT * FROM rb_pustaka_setting where id_pustaka_setting='1'")->row_array();
                if ($this->input->post('cc')<=$set['durasi'] AND $this->input->post('cc')>0){
                    $data = array('id_pinjam'=>$this->session->pinjam,
                                'id_buku'=>$this->input->post('aa'),
                                'jumlah'=>$this->input->post('bb'),
                                'tanggal_kembalikan'=>$hasil);
                    $this->model_app->insert('rb_pustaka_pinjam_detail',$data);
                }
              }
                redirect($this->uri->segment(1).'/transaksi_peminjaman');
            }else{
                echo "<script>window.alert('Maaf, Stok Buku Saat ini $stok');
                                          window.location=('".base_url().$this->uri->segment(1)."/transaksi_peminjaman')</script>";
            }  
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_pustaka_denda order by id_denda DESC LIMIT 1")->row_array();
            $data['e'] = $this->db->query("SELECT * FROM rb_pustaka_setting where id_pustaka_setting='1'")->row_array();
            $data['tampil'] = $this->db->query("SELECT a.*, b.foto, b.kode_buku, b.judul FROM rb_pustaka_pinjam_detail a JOIN rb_pustaka_buku b ON a.id_buku=b.id_buku where a.id_pinjam='".$this->session->pinjam."' ORDER BY id_pinjam_detail ASC");
            $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_peminjaman',$data);
        }
    }

    function transaksi_peminjaman_hapus(){
        cek_session_akses('transaksi_peminjaman',$this->session->id_session);
        $id = array('id_pinjam_detail' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_pinjam_detail',$id);
        redirect($this->uri->segment(1).'/kartu_pustaka');
    }

    function transaksi_pengembalian(){
        cek_session_akses('transaksi_pengembalian',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama FROM `rb_pustaka_pinjam` a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa LEFT JOIN rb_pustaka_pinjam_detail d ON a.id_pinjam=d.id_pinjam GROUP BY a.id_pinjam ORDER BY a.id_pinjam DESC");
        $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_pengembalian',$data);
    }

    function transaksi_pengembalian_hapus(){
        cek_session_akses('transaksi_pengembalian',$this->session->id_session);
        $id = array('id_pinjam' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_pinjam',$id);
        $this->model_app->delete('rb_pustaka_pinjam_detail',$id);
        redirect($this->uri->segment(1).'/transaksi_pengembalian');
    }

    function transaksi_pengembalian_detail(){
        cek_session_akses('transaksi_pengembalian',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $hitung  = $this->db->query("SELECT * FROM rb_pustaka_pinjam_detail where id_pinjam='".$this->uri->segment(3)."'")->num_rows();
            $biaya_denda = $this->db->query("SELECT * FROM rb_pustaka_denda ORDER BY id_denda DESC LIMIT 1")->row_array();
            for ($ia=1; $ia<=$hitung; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = tgl_simpan($_POST['b'.$ia]);
              $deadline  = $_POST['deadline'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $e  = $_POST['e'.$ia];

              $start_date = new DateTime($deadline);
              $end_date = new DateTime($b);
              $interval = $start_date->diff($end_date);

              $tgl1 = str_replace("-","",$deadline);
              $tgl2 = str_replace("-","",$b);
              if ($tgl2>$tgl1){
                if ($interval->days>0){ 
                  $hari = $interval->days; 
                }else{ 
                  $hari = 0;
                }
              }else{
                $hari = 0;
              }
              $denda = $hari*$biaya_denda['nominal']*$c;

                $cek = $this->db->query("SELECT * FROM rb_pustaka_kembali where id_pinjam='".$this->uri->segment(3)."' AND id_buku='$a'")->num_rows();
                if ($cek >= '1'){
                    $data = array('tanggal_kembali'=>$b,
                            'jumlah'=>$c,
                            'denda'=>$denda,
                            'keterangan'=>$e);
                    $where = array('id_buku' => $a,'id_pinjam'=>$this->uri->segment(3));
                    $this->model_app->update('rb_pustaka_kembali', $data, $where);
                }else{
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'id_pinjam'=>$this->uri->segment(3),
                                    'id_buku'=>$a,
                                    'tanggal_kembali'=>$b,
                                    'jumlah'=>$c,
                                    'denda'=>$denda,
                                    'keterangan'=>$e,
                                    'id_guru'=>$this->session->id_session);
                    $this->model_app->insert('rb_pustaka_kembali',$data);
                }
            }
            redirect($this->uri->segment(1).'/transaksi_pengembalian_detail/'.$this->uri->segment(3));
        }else{
            $data['d'] = $this->db->query("SELECT a.*, b.nama FROM rb_pustaka_pinjam a JOIN rb_siswa b On a.id_siswa=b.id_siswa where a.id_pinjam='".$this->uri->segment(3)."'")->row_array();
            $data['tampil'] = $this->db->query("SELECT a.*, b.foto, b.kode_buku, b.judul FROM rb_pustaka_pinjam_detail a JOIN rb_pustaka_buku b ON a.id_buku=b.id_buku where a.id_pinjam='".$this->uri->segment(3)."' ORDER BY id_pinjam_detail ASC");
            $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_pengembalian_detail',$data);
        }
    }

    function transaksi_pengembalian_edit(){
        cek_session_akses('transaksi_pengembalian',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $data = array('id_siswa'=>$this->input->post('a'),
                            'tanggal_pinjam'=>tgl_simpan($this->input->post('b')),
                            'keterangan'=>$this->input->post('c'));
            $where = array('id_pinjam' => $this->uri->segment(3));
            $this->model_app->update('rb_pustaka_pinjam', $data, $where);
            redirect($this->uri->segment(1).'/transaksi_pengembalian_edit/'.$this->uri->segment(3));

        }elseif (isset($_POST['simpan_buku'])){
            $buku = $this->db->query("SELECT jumlah FROm rb_pustaka_buku where id_buku='$_POST[aa]'")->row_array();
            $pinjam = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_buku='".$this->input->post('aa')."'")->row_array();
            $kembali = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_kembali where id_buku='".$this->input->post('aa')."'")->row_array();

            $stok = ($buku['jumlah']-$pinjam['jumlah'])+$kembali['jumlah'];
            if($stok>=$this->input->post('bb')){
                $data = array('id_pinjam'=>$this->uri->segment(3),
                                'id_buku'=>$this->input->post('aa'),
                                'jumlah'=>$this->input->post('bb'),
                                'tanggal_kembalikan'=>tgl_simpan($_POST['cc']));
                $this->model_app->insert('rb_pustaka_pinjam_detail',$data);

              redirect($this->uri->segment(1).'/transaksi_pengembalian_edit/'.$this->uri->segment(3));
            }else{
                echo "<script>window.alert('Maaf, Stok Buku Saat ini $stok');
                                          window.location=('".base_url().$this->uri->segment(1)."/transaksi_pengembalian_edit/".$this->uri->segment(3)."')</script>";
            }  
        }else{
            $data['d'] = $this->db->query("SELECT * FROM rb_pustaka_pinjam where id_pinjam='".$this->uri->segment(3)."'")->row_array();

            $data['tampil'] = $this->db->query("SELECT a.*, b.foto, b.kode_buku, b.judul FROM rb_pustaka_pinjam_detail a JOIN rb_pustaka_buku b ON a.id_buku=b.id_buku where a.id_pinjam='".$this->uri->segment(3)."' ORDER BY id_pinjam_detail ASC");
            $this->template->load('administrator/template','administrator/mod_pustaka/pustaka_pengembalian_edit',$data);
        }
    }

    function transaksi_pengembalian_edit_hapus(){
        cek_session_akses('transaksi_pengembalian',$this->session->id_session);
        $id = array('id_pinjam_detail' => $this->uri->segment(3));
        $this->model_app->delete('rb_pustaka_pinjam_detail',$id);
        redirect($this->uri->segment(1).'/transaksi_pengembalian_edit/'.$this->uri->segment(4));
    }

    function laporan_pengunjung_siswa(){
        cek_session_akses('laporan_pengunjung_siswa',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT * FROM `rb_pustaka_bukutamu` z LEFT JOIN
                                                rb_siswa a ON z.id_siswa=a.id_siswa LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                                  LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin where z.status='siswa'
                                                    ORDER BY id_bukutamu DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/laporan_pengunjung_siswa_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/laporan_pengunjung_siswa',$data);
        }
    }

    function laporan_pengunjung_lainnya(){
        cek_session_akses('laporan_pengunjung_lainnya',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT * FROM `rb_pustaka_bukutamu` where status!='siswa' ORDER BY id_bukutamu DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/laporan_pengunjung_lainnya_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/laporan_pengunjung_lainnya',$data);
        }
    }

    function katalog_laporan_buku(){
        cek_session_akses('katalog_laporan_buku',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama_kategori FROM rb_pustaka_buku a JOIN rb_pustaka_kategori b ON a.id_kategori=b.id_kategori ORDER BY id_buku DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/katalog_laporan_buku_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/katalog_laporan_buku',$data);
        }
    }

    function peminjaman_pengembalian(){
        cek_session_akses('peminjaman_pengembalian',$this->session->id_session);
        if(isset($_GET['tanggal'])){
          $ex = explode(' - ',$_GET['tanggal']);
          $exx = explode('-',$ex[0]);
          $exy = explode('-',$ex[1]);
          $mulai = $exx[2].'-'.$exx[1].'-'.$exx[0];
          $selesai = $exy[2].'-'.$exy[1].'-'.$exy[0];

          $data['tampil'] = $this->db->query("SELECT a.*, b.nama, c.nama_guru, d.nama_kelas FROM `rb_pustaka_pinjam` a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa LEFT JOIN rb_guru c ON a.id_guru=c.id_guru LEFT JOIN rb_kelas d ON b.id_kelas=d.id_kelas where a.tanggal_pinjam between '$mulai' AND '$selesai' ORDER BY a.id_pinjam DESC");
        }else{
          $data['tampil'] = $this->db->query("SELECT a.*, b.nama, c.nama_guru, e.nama_kelas FROM `rb_pustaka_pinjam` a LEFT JOIN rb_siswa b On a.id_siswa=b.id_siswa LEFT JOIN rb_guru c ON a.id_guru=c.id_guru LEFT JOIN rb_kelas e ON b.id_kelas=e.id_kelas ORDER BY a.id_pinjam DESC");
        }

        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/peminjaman_pengembalian_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/peminjaman_pengembalian',$data);
        }
    }

    function buku_besar(){
        cek_session_akses('buku_besar',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama_kategori FROM rb_pustaka_buku a JOIN rb_pustaka_kategori b ON a.id_kategori=b.id_kategori ORDER BY id_buku DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/buku_besar_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/buku_besar',$data);
        }
    }

    function laporan_kondisi_buku(){
        cek_session_akses('laporan_kondisi_buku',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama_kategori FROM rb_pustaka_buku a JOIN rb_pustaka_kategori b ON a.id_kategori=b.id_kategori ORDER BY id_buku DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/laporan_kondisi_buku_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/laporan_kondisi_buku',$data);
        }
    }

    function rekap_kondisi_buku(){
        cek_session_akses('rekap_kondisi_buku',$this->session->id_session);
        $data['tampil'] = $this->db->query("SELECT a.*, b.nama_kategori FROM rb_pustaka_buku a JOIN rb_pustaka_kategori b ON a.id_kategori=b.id_kategori ORDER BY id_buku DESC");
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/laporan_kondisi_buku_rekap_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/laporan_kondisi_buku_rekap',$data);
        }
    }

    function rekap_pengunjung_tahun(){
        cek_session_akses('rekap_pengunjung_tahun',$this->session->id_session);
        if ($this->uri->segment(3)=='print'){
            $data['iden'] = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
            $data['kepsek'] = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $this->load->view('administrator/mod_pustaka/mod_laporan/rekap_pengunjung_tahun_print',$data);
        }else{
            $this->template->load('administrator/template','administrator/mod_pustaka/mod_laporan/rekap_pengunjung_tahun',$data);
        }
    }
}
