<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	function index(){
    		if (isset($_POST['submit'])){
          $angka=cetak($this->input->post('angka1'))+cetak($this->input->post('angka2'));
          $hasil=cetak($this->input->post('c'));
          if ($angka==$hasil){
      			$username = $this->input->post('a');
      			$password = hash("sha512", md5($this->input->post('b')));
            $passwords = md5($this->input->post('b'));
      			$admin = $this->model_app->cek_login($username,$password,'rb_users');
            $guru = $this->model_app->cek_login_guru($username,$passwords,'rb_guru');
            $siswa = $this->model_app->cek_login_siswa($username,$passwords,'rb_siswa');
            $ortu = $this->model_app->cek_login_siswa_ortu($username,$passwords,'rb_siswa_ortu');
      		  
            $row1 = $admin->row_array();
      		  $total1 = $admin->num_rows();
            
            $row2 = $guru->row_array();
            $total2 = $guru->num_rows();

            $row3 = $siswa->row_array();
            $total3 = $siswa->num_rows();

            $row4 = $ortu->row_array();
            $total4 = $ortu->num_rows();

      			      if ($total1 == 1){
              				$this->session->set_userdata('upload_image_file_manager',true);
              				$this->session->set_userdata(array('username'=>$row1['username'],
      								                   'level'=>$row1['level'],
                                         'id_session'=>$row1['id_user']));
                      $sekolah = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$row1['id_identitas_sekolah']));
                      $sek = $sekolah->row_array();
                      if ($sekolah->num_rows()>=1){
                        $this->session->set_userdata(array('sekolah'=>$sek['id_identitas_sekolah']));
                        redirect($sek['keyword'].'/home');
                      }else{
                        redirect('login/jenjang');
                      }
      			      }elseif($total2 > 0){
                      $this->session->set_userdata('upload_image_file_manager',true);
                      $this->session->set_userdata(array('username'=>$row2['email'],
                                         'password'=>$row2['password'],
                                         'level'=>'guru',
                                         'id_session'=>$row2['id_guru']));
                      $sekolah = $this->db->query("SELECT a.*, b.keyword FROM rb_guru a JOIN rb_identitas_sekolah b ON a.id_identitas_sekolah=b.id_identitas_sekolah where a.nip='$row2[nip]'");
                      $sek = $sekolah->row_array();
                      if ($sekolah->num_rows()==1){
                        $this->session->set_userdata(array('sekolah'=>$sek['id_identitas_sekolah']));
                        $data = array('id_identitas_sekolah'=>$sek['id_identitas_sekolah'],
                                      'identitas'=>$row2['id_guru'],
                                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                                      'browser'=>$this->agent->browser().' '.$this->agent->version(),
                                      'os'=>$this->agent->platform(),
                                      'status'=>'guru',
                                      'jam'=>date('H:i:s'),
                                      'tanggal'=>date('Y-m-d'));
                        $this->model_app->insert('rb_users_aktivitas',$data);
                        redirect($sek['keyword'].'/home');
                      }else{
                        redirect('login/jenjang');
                      }
                  }elseif($total3 == 1){
                      $this->session->set_userdata(array('username'=>$row3['email'],
                                         'level'=>'siswa',
                                         'id_session'=>$row3['id_siswa'],
                                         'id_kelas'=>$row3['id_kelas']));

                      $sekolah = $this->db->query("SELECT a.*, b.keyword FROM rb_siswa a JOIN rb_identitas_sekolah b ON a.id_identitas_sekolah=b.id_identitas_sekolah where a.id_siswa='$row3[id_siswa]'");
                      $sek = $sekolah->row_array();
                      if ($sekolah->num_rows()==1){
                        $this->session->set_userdata(array('sekolah'=>$sek['id_identitas_sekolah']));
                        $data = array('id_identitas_sekolah'=>$sek['id_identitas_sekolah'],
                                      'identitas'=>$row3['id_siswa'],
                                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                                      'browser'=>$this->agent->browser().' '.$this->agent->version(),
                                      'os'=>$this->agent->platform(),
                                      'status'=>'siswa',
                                      'jam'=>date('H:i:s'),
                                      'tanggal'=>date('Y-m-d'));
                        $this->model_app->insert('rb_users_aktivitas',$data);
                        redirect($sek['keyword'].'/home');
                      }else{
                        redirect('login/jenjang');
                      }
                  }elseif($total4 > 0){
                      $row5 = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$row4['id_siswa']))->row_array();
                      $this->session->set_userdata(array('username'=>$row5['email'],
                                         'level'=>'siswa',
                                         'level2'=>'siswa_ortu',
                                         'id_session'=>$row5['id_siswa'],
                                         'id_kelas'=>$row5['id_kelas']));
                      $sekolah = $this->db->query("SELECT a.*, b.keyword FROM rb_siswa a JOIN rb_identitas_sekolah b ON a.id_identitas_sekolah=b.id_identitas_sekolah where a.id_siswa='$row5[id_siswa]'");
                      $sek = $sekolah->row_array();
                      if ($sekolah->num_rows()==1){
                        $this->session->set_userdata(array('sekolah'=>$sek['id_identitas_sekolah']));
                        $data = array('id_identitas_sekolah'=>$sek['id_identitas_sekolah'],
                                      'identitas'=>$row5['id_siswa'],
                                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                                      'browser'=>$this->agent->browser().' '.$this->agent->version(),
                                      'os'=>$this->agent->platform(),
                                      'status'=>'Orang_Tua',
                                      'jam'=>date('H:i:s'),
                                      'tanggal'=>date('Y-m-d'));
                        $this->model_app->insert('rb_users_aktivitas',$data);
                        redirect($sek['keyword'].'/home');
                      }else{
                        redirect('login/jenjang');
                      }
                  }else{
              echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password salah!</center></div>');
              redirect('login');
      			}
          }else{
            echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Security Code yang anda masukkan salah!</center></div>');
            redirect('login');
          }
    		}else{
    			$data['title'] = 'SIMASTA | Log in';
    			$this->load->view('administrator/view_login',$data);
          if($this->session->level!=''){
              redirect('login/jenjang');
          }
    		}
	}

  function jenjang(){
    $cek = $this->model_app->view_where('rb_users',array('id_user'=>$this->session->id_session))->row_array();
    if ($cek['id_identitas_sekolah']=='0' OR $this->session->sekolah==''){
      if ($this->session->level!=''){
        $data['sekolah'] = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang ORDER BY a.id_jenjang");
        $this->load->view('administrator/view_pilih_sekolah',$data);
      }
    }else{
      $sekolah = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah));
      $sek = $sekolah->row_array();
      if ($sekolah->num_rows()>=1){
        $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                      'identitas'=>$this->session->id_session,
                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                      'browser'=>$this->agent->browser().' '.$this->agent->version(),
                      'os'=>$this->agent->platform(),
                      'status'=>$this->session->level,
                      'jam'=>date('H:i:s'),
                      'tanggal'=>date('Y-m-d'));
        $this->model_app->insert('rb_users_aktivitas',$data);
        redirect($sek['keyword'].'/home');
      }
    }
  }

  function system(){
    if ($this->session->level!=''){
      $this->session->set_userdata(array('sekolah'=>$this->uri->segment(3)));
      $sekolah = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->uri->segment(3)))->row_array();
      
      $data = array('id_identitas_sekolah'=>$this->uri->segment(3),
                      'identitas'=>$this->session->id_session,
                      'ip_address'=>$_SERVER['REMOTE_ADDR'],
                      'browser'=>$this->agent->browser().' '.$this->agent->version(),
                      'os'=>$this->agent->platform(),
                      'status'=>$this->session->level,
                      'jam'=>date('H:i:s'),
                      'tanggal'=>date('Y-m-d'));
      $this->model_app->insert('rb_users_aktivitas',$data);

      redirect($sekolah['keyword'].'/home');
    }
  }

	function logout(){
		$this->session->sess_destroy();
		redirect($this->uri->segment(1));
	}
}
