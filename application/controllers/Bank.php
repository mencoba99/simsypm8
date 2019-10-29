<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function kode_transaksi(){
        cek_session_akses('kode_transaksi',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_lk_bankmini_kd_transaksi','id_kd_transaksi','ASC');
        $this->template->load('administrator/template','administrator/mod_lk_bank/mod_kd_transaksi/view',$data);
    }

    function tambah_kode_transaksi(){
        cek_session_akses('kode_transaksi',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array(  'kd_akun'=>$this->input->post('kd_akun'),
                            'nama_akun'=>$this->input->post('nama_akun'),
                            'debit_kredit'=>$this->input->post('debit_kredit'));
            $this->model_app->insert('rb_lk_bankmini_kd_transaksi',$data);
            redirect($this->uri->segment(1).'/kode_transaksi');
        }else{
            $this->template->load('administrator/template','administrator/mod_lk_bank/mod_kd_transaksi/tambah');
        }
    }

    function edit_kode_transaksi(){
        cek_session_akses('notulensi_rapat',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array(  'kd_akun'=>$this->input->post('kd_akun'),
                            'nama_akun'=>$this->input->post('nama_akun'),
                            'debit_kredit'=>$this->input->post('debit_kredit'));
                            
            $where = array('id_kd_transaksi' => $this->input->post('id'));
            $this->model_app->update('rb_lk_bankmini_kd_transaksi', $data, $where);
            redirect($this->uri->segment(1).'/kode_transaksi');
        }else{
            $edit = $this->model_app->view_where('rb_lk_bankmini_kd_transaksi', array('id_kd_transaksi'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_bank/mod_kd_transaksi/edit',$data);
        }
    }

    function delete_kode_transaksi(){
        cek_session_akses('kode_transaksi',$this->session->id_session);
        $id = array('id_kd_transaksi' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_bankmini_kd_transaksi',$id);
        redirect($this->uri->segment(1).'/kode_transaksi');
    }

    function view_nasabah(){
  	  cek_session_akses('nasabah',$this->session->id_session);      
      $data['record'] = $this->model_app->view_ordering('rb_lk_bankmini_nasabah','id_nasabah','ASC');
      $this->template->load('administrator/template','administrator/mod_lk_bank/mod_nasabah/view',$data);
    }


  function tambah_nasabah(){
        cek_session_akses('nasabah',$this->session->id_session);
        if (isset($_POST['submit'])){
            $tgl = date('Y-m-d');
            $norek = 'Bm'.date('Y').$this->input->post('id_siswa');
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_siswa'=>$this->input->post('id_siswa'),
                            'nasabah_saldo'=>$this->input->post('nasabah_saldo'),
                            'saldo_sekarang'=>$this->input->post('nasabah_saldo'),
                            'saldo_akhir' => '0',
                            'nasabah_keterangan'=>$this->input->post('nasabah_keterangan'),
                            'tanggal_buat'=>$tgl,
                            'no_rek'=>$norek,
                          );
            $this->model_app->insert('rb_lk_bankmini_nasabah',$data);
            redirect($this->uri->segment(1).'/view_nasabah');
        }else{
            
            $siswa = $this->model_app->view_where_ordering('rb_siswa',array('id_identitas_sekolah'=>$this->session->sekolah),'id_siswa','ASC');

            $data = array('siswa' => $siswa);
            $this->template->load('administrator/template','administrator/mod_lk_bank/mod_nasabah/tambah',$data);
        }
    }

    function edit_nasabah(){
        cek_session_akses('nasabah',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
              $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_siswa'=>$this->input->post('id_siswa'),
                            'nasabah_saldo'=>$this->input->post('nasabah_saldo'),
                            'nasabah_keterangan'=>$this->input->post('nasabah_keterangan'),
                          );
            $where = array('id_nasabah' => $this->input->post('id'));
            $this->model_app->update('rb_lk_bankmini_nasabah', $data, $where);
            redirect($this->uri->segment(1).'/view_nasabah');
        }else{
            $edit = $this->model_app->view_where('rb_lk_bankmini_nasabah', array('id_nasabah'=>$id))->row_array();
            $data = array('edit' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_bank/mod_nasabah/edit',$data);
        }
    }

    function delete_nasabah(){
        cek_session_akses('nasabah',$this->session->id_session);
        $id = array('id_nasabah' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_bankmini_nasabah',$id);
        redirect($this->uri->segment(1).'/view_nasabah');
    }
    function detail_nasabah(){
        cek_session_akses('nasabah',$this->session->id_session);
        $id = $this->uri->segment(3);
        $detail = $this->model_app->view_where('rb_lk_bankmini_nasabah', array('id_nasabah'=>$id))->row_array();
        $id = $detail['id_nasabah'];
        
        //data transaksi
        $transaksi = $this->db->query(" SELECT * FROM rb_lk_bankmini_nasabah a 
                                        JOIN rb_lk_bankmini_transaksi b ON a.id_nasabah = b.id_nasabah 
                                        JOIN rb_lk_bankmini_kd_transaksi c ON b.id_kd_transaksi = c.id_kd_transaksi 
                                        WHERE a.id_nasabah = ".$id)->result_array();

        $kdtransaksi = $this->db->query("SELECT id_kd_transaksi FROM rb_lk_bankmini_transaksi where id_nasabah=".$id." ")->row_array();
        $jenis = $this->db->query("SELECT nama_akun FROM rb_lk_bankmini_kd_transaksi where id_kd_transaksi=".$kdtransaksi['id_kd_transaksi']." ")->result_array()[0];
        $nasabah = $this->model_app->view_where('rb_lk_bankmini_nasabah',$id, 'ASC');
        $siswa = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$detail['id_siswa']), 'ASC')->row_array();
        $data = array(
                    'record'=>$detail, 
                    'transaksi'=>$transaksi, 
                    'jenis'=>$jenis,
                    'siswa'=>$siswa
                    );
        
        $this->template->load('administrator/template','administrator/mod_lk_bank/mod_nasabah/detail_tabungan',$data);
    }

     function transaksi(){
        cek_session_akses('transaksi',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_one('rb_lk_bankmini_transaksi', 'rb_lk_bankmini_kd_transaksi', 'id_kd_transaksi', 'id_transaksi', 'ASC');
        $this->template->load('administrator/template','administrator/mod_lk_bank/mod_transaksi/view',$data);
    }

    public function ajax_transaksi() {
    $id=$_GET['id_nasabah'];
    $siswa = $this->db->query("SELECT * FROM rb_lk_bankmini_nasabah where id_nasabah=".$id." ")->result_array()[0];

    $data = array(
              'nasabah_nama' => $siswa['nasabah_nama'],
              'nasabah_kelas' => $siswa['nasabah_kelas'],
              'nasabah_jurusan' => $siswa['nasabah_jurusan'],
              'nasabah_tahun_angkatan' => $siswa['nasabah_tahun_angkatan'],
              'nasabah_jk' => $siswa['nasabah_jk'],
              'nasabah_alamat' => $siswa['nasabah_alamat'],
              'nasabah_no_telp' => $siswa['nasabah_no_telp'],
              'saldo_sekarang' => $siswa['saldo_sekarang'],
            );
    echo json_encode($data);
  }

    function detail_transaksi(){
        cek_session_akses('transaksi',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id_transaksi' => $id);

        $transaksi = $this->model_app->view_where('rb_lk_bankmini_transaksi', $where)->row_array();
        $detail = $this->model_app->view_where('rb_lk_bankmini_nasabah',array('id_nasabah'=>$transaksi['id_nasabah']), 'ASC')->row_array();
        $jenis = $this->model_app->view_where('rb_lk_bankmini_kd_transaksi',array('id_kd_transaksi'=>$transaksi['id_kd_transaksi']), 'ASC')->row_array();
        $siswa = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$detail['id_siswa']), 'ASC')->row_array();
        
        $data = array('record'=>$transaksi, 'detail'=>$detail, 'jenis'=>$jenis, 'siswa'=>$siswa);
        $this->template->load('administrator/template','administrator/mod_lk_bank/mod_transaksi/detail',$data);
    }

    function print_transaksi(){
     cek_session_akses('transaksi',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id_transaksi' => $id);

        $transaksi = $this->model_app->view_where('rb_lk_bankmini_transaksi', $where)->row_array();
        $detail = $this->model_app->view_where('rb_lk_bankmini_nasabah',array('nasabah_nipd'=>$transaksi['id_nasabah']), 'ASC')->row_array();
        $jenis = $this->model_app->view_where('rb_lk_bankmini_kd_transaksi',array('id_kd_transaksi'=>$transaksi['id_kd_transaksi']), 'ASC')->row_array();

        $data = array('record'=>$transaksi, 'detail'=>$detail, 'jenis'=>$jenis);
        $this->template->load('administrator/template','administrator/mod_lk_bank/mod_transaksi/print',$data);
        // redirect(base_url().$this->uri->segment(1).'/detail_transaksi/'.$id);

    }
 
     function tambah_transaksi(){
        cek_session_akses('transaksi',$this->session->id_session);
        if (isset($_POST['submit'])){        
            
            $data = array(  'id_identitas_sekolah'=>$this->session->sekolah,
                            'id_nasabah'=>$this->input->post('id_nasabah'),
                            'id_kd_transaksi'=>$this->input->post('id_kd_transaksi'),
                            'nominal'=>$this->input->post('nominal'),
                            'tgl_transaksi'=>date('Y-m-d')
                        );
            $debitKredit = $this->db->query("SELECT * FROM rb_lk_bankmini_kd_transaksi where id_kd_transaksi='".$data['id_kd_transaksi']."' ")->row_array();

            $saldo = $this->db->query("SELECT * FROM rb_lk_bankmini_nasabah WHERE id_nasabah='".$data['id_nasabah']."' ")->row_array();

            //perhitungan
            $total = 0;
            if ($debitKredit['debit_kredit'] == 'Kredit') {
                $total = (int) $saldo['saldo_sekarang'] + (int) $data['nominal'];
            } 
            if ($debitKredit['debit_kredit'] == 'Debet') {
                if($data['nominal'] > $saldo['saldo_sekarang']) {
                    $flash = "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Transaksi Gagal..!</strong> - Saldo Tidak Mencukupi,..
                          </div>";
                    $this->session->set_flashdata('data',$flash); 
                        redirect(base_url().$this->uri->segment(1).'/tambah_transaksi/');
                }else{                    
                 $total = (int) $saldo['saldo_sekarang'] - (int) $data['nominal'];
                }
            }

            $data['total_saldo'] = $total; //hasil perhitungan
            //update saldo_sekarang nasabah tabel nasabah
            $sal = $this->db->query("SELECT * FROM rb_lk_bankmini_nasabah where id_nasabah='".$data['id_nasabah']."' ")->row_array();
            $sal['saldo_sekarang'] = $data['total_saldo'];
            $where = array('id_nasabah' => $data['id_nasabah']);

            $this->db->update('rb_lk_bankmini_nasabah', $sal, $where);
            $this->model_app->insert('rb_lk_bankmini_transaksi',$data);
            
            redirect($this->uri->segment(1).'/transaksi');
        } else {
            $kd_transaksi = $this->model_app->view('rb_lk_bankmini_kd_transaksi','id_kd_transaksi','ASC');
            $nasabah = $this->model_app->view_join_one('rb_lk_bankmini_nasabah','rb_siswa','id_siswa','id_nasabah', 'ASC');
            $data = array('kd_transaksi' => $kd_transaksi, 'nasabah'=>$nasabah);
            $this->template->load('administrator/template','administrator/mod_lk_bank/mod_transaksi/tambah',$data);
        }
    }

     function edit_transaksi(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kode_bkk'=>$this->input->post('a'),
                            'nama_instansi'=>$this->input->post('b'),
                            'pimpinan_instansi'=>$this->input->post('c'),
                            'no_telp'=>$this->input->post('d'),
                            'alamat_instansi'=>$this->input->post('e'),
                            'email'=>$this->input->post('f'),
                            'status'=>$this->input->post('g'),
                            'keterangan'=>$this->input->post('h'));
            $where = array('id_bkk' => $this->input->post('id'));
            $this->model_app->update('rb_lk_bkk', $data, $where);
            redirect($this->uri->segment(1).'/alumni_bkk');
        } else {
            $edit = $this->model_app->view('rb_lk_bkk')->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_bkk/edit',$data);
        }
    }

    function delete_transaksi(){
        cek_session_akses('transaksi',$this->session->id_session);
        $id = array('id_transaksi' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_bankmini_transaksi',$id);
        redirect($this->uri->segment(1).'/transaksi');
    }

    function daftar_transaksi(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $bkk = $this->uri->segment(3);
        $data['id'] = $bkk;
        if (isset($_POST['submit'])){
            $data = array('id_daftar_bkk'=>$this->input->post(id),
                            'nama'=>$this->input->post('a'),
                            'nisn'=>$this->input->post('b'),
                            'tempat_lahir'=>$this->input->post('c'),
                            'tanggal_lahir'=>$this->input->post('d'),
                            'email'=>$this->input->post('e'),
                            'no_telp'=>$this->input->post('f'),
                            'alamat'=>$this->input->post('g'),
                            'tahun_masuk'=>$this->input->post('h'),
                            'tahun_lulus'=>$this->input->post('i'),
                            'no_ijazah'=>$this->input->post('j'),
                            'nilai_ujian'=>$this->input->post('k'),
                            'status'=>$this->input->post('l'),
                            'keterangan'=>$this->input->post('m'),
                            'id_bkk'=>$this->uri->segment(3),
                            'tanggal_daftar'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_lk_daftar_bkk',$data);
            redirect($this->uri->segment(1).'/detail_alumni_bkk/'.$this->uri->segment(3));
        } else {
            $this->template->load('administrator/template','administrator/mod_lk_bkk/daftar',$data);
        }
    }

    function delete_daftar_transaksi(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = array('id_daftar_bkk' => $this->uri->segment(4));
        $this->model_app->delete('rb_lk_daftar_bkk',$id);
        redirect($this->uri->segment(1).'/detail_daftar_bkk/'.$this->uri->segment(3));
    }
}
 -->