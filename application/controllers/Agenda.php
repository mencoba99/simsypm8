<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agenda extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function agenda(){
        cek_session_akses('agenda',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_lk_agenda',array('id_identitas_sekolah'=>$this->session->sekolah),'id_agenda','ASC');        
        $this->template->load('administrator/template','administrator/mod_lk_agenda/view',$data);
    }

    function agendaStatus(){
        cek_session_akses('agenda',$this->session->id_session);
        if (isset($_GET['status'])){            
            $data = array('status'=>$this->input->get('status'));
            $where = array('id_agenda' => $this->input->get('id'));
            $this->model_app->update('rb_lk_agenda', $data, $where);
            redirect($this->uri->segment(1).'/agenda');            
        }
    }
    
    function unduh_agenda(){
      $this->load->helper('download');
      $aa = $this->db->query("SELECT * FROM rb_lk_agenda WHERE id_agenda=".$this->uri->segment(3)." ")->result_array()[0];
   
      force_download("asset/dokumen_agenda/".$aa['dokumen']."",NULL);
      redirect($this->uri->segment(1).'/agenda');
    }

    function tambah_agenda(){
        cek_session_akses('agenda', $this->session->id_session);
         $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
        if (isset($_POST['submit'])){
            $config['upload_path'] = realpath('asset/dokumen_agenda/');
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = '100000';
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["dokumen"]['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('dokumen');
            $hasil=$this->upload->data();
            if($hasil['file_name']==''){
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'tgl'=>tgl_simpan($this->input->post('a')),
                                'nama_kegiatan'=>$this->input->post('b'),
                                'tempat'=>$this->input->post('c'),
                                'ketua_pelaksana'=>$this->input->post('d'),
                                'sasaran'=>$this->input->post('e'),
                                'detail_agenda'=>$this->input->post('f'),
                             );
            }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'tgl'=>tgl_simpan($this->input->post('a')),
                                'nama_kegiatan'=>$this->input->post('b'),
                                'tempat'=>$this->input->post('c'),
                                'ketua_pelaksana'=>$this->input->post('d'),
                                'sasaran'=>$this->input->post('e'),
                                'detail_agenda'=>$this->input->post('f'),
                                'dokumen'=>$hasil['file_name']
                            );
            }
            $guru = $this->db->query("SELECT * FROM rb_guru where id_guru =".$data['ketua_pelaksana']." ")->result_array()[0];
            $data['ketua_pelaksana'] = $guru['nama_guru'];
            $this->model_app->insert('rb_lk_agenda',$data);

            redirect($this->uri->segment(1).'/agenda');
        }else{
            $data = array('guru' => $guru);
            $this->template->load('administrator/template','administrator/mod_lk_agenda/tambah',$data);
        }
    }

    function edit_agenda(){
        cek_session_akses('agenda',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = realpath('asset/dokumen_agenda/');
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = '100000';
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["dokumen"]['name']; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('dokumen');
            $hasil=$this->upload->data();
            if ($_FILES["dokumen"]['name']=='') {                
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'tgl'=>tgl_simpan($this->input->post('a')),
                                'nama_kegiatan'=>$this->input->post('b'),
                                'tempat'=>$this->input->post('c'),
                                'ketua_pelaksana'=>$this->input->post('d'),
                                'sasaran'=>$this->input->post('e'),
                                'detail_agenda'=>$this->input->post('f'),
                            );
            }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'tgl'=>tgl_simpan($this->input->post('a')),
                                'nama_kegiatan'=>$this->input->post('b'),
                                'tempat'=>$this->input->post('c'),
                                'ketua_pelaksana'=>$this->input->post('d'),
                                'sasaran'=>$this->input->post('e'),
                                'detail_agenda'=>$this->input->post('f'),
                                'dokumen'=>$hasil['file_name']
                            );
            }
            $where = array('id_agenda' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_lk_agenda', $data, $where);
            redirect($this->uri->segment(1).'/agenda');
        }else{
            $edit = $this->model_app->view_where('rb_lk_agenda', array('id_agenda'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('edit' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_agenda/edit',$data);
        }
    }

    function delete_agenda(){
        cek_session_akses('agenda',$this->session->id_session);
        $id = array('id_agenda' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_lk_agenda',$id);
        redirect($this->uri->segment(1).'/agenda');
    }
}