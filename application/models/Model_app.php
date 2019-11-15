<?php 
class Model_app extends CI_model{
    public function view($table){
        return $this->db->get($table);
    }

    public function insert($table,$data){
        return $this->db->insert($table, $data);
    }

    public function edit($table, $data){
        return $this->db->get_where($table, $data);
    }
 
    public function update($table, $data, $where){
        return $this->db->update($table, $data, $where); 
    }

    public function delete($table, $where){
        return $this->db->delete($table, $where);
    }

    public function view_where($table,$data){
        $this->db->where($data);
        return $this->db->get($table);
    }

    public function view_ordering_limit($table,$order,$ordering,$baris,$dari){
        $this->db->select('*');
        $this->db->order_by($order,$ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }
    
    public function view_ordering($table,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function view_where_ordering($table,$data,$order,$ordering){
        $this->db->where($data);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_join_one($table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function view_join_where($select,$table1,$table2,$field,$where,$order,$ordering){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field,'left');
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }    

    public function view_join_tigo_where($select,$table1,$table2,$field,$table3,$field1,$where,$order,$ordering){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function kd_penilaian($id_mata_pelajaran,$tahun,$kelas){
        return $this->db->query("SELECT c.* FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_kompetensi_dasar c ON a.id_kompetensi_dasar=c.id_kompetensi_dasar
                where b.id_mata_pelajaran='$id_mata_pelajaran' AND b.id_tahun_akademik='$tahun' AND b.id_kelas='$kelas'  GROUP BY a.id_kompetensi_dasar")->result_array();
    }

    public function kd_penilaian_hitung($id_mata_pelajaran,$tahun,$kelas){
        return $this->db->query("SELECT c.* FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_kompetensi_dasar c ON a.id_kompetensi_dasar=c.id_kompetensi_dasar
                where b.id_mata_pelajaran='$id_mata_pelajaran' AND b.id_tahun_akademik='$tahun' AND b.id_kelas='$kelas'  GROUP BY a.id_kompetensi_dasar");
    }

    public function kd_penilaianketerampilan($id_mata_pelajaran,$tahun,$kelas){
        return $this->db->query("SELECT c.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_kompetensi_dasar c ON a.id_kompetensi_dasar=c.id_kompetensi_dasar
                where b.id_mata_pelajaran='$id_mata_pelajaran' AND b.id_tahun_akademik='$tahun' AND b.id_kelas='$kelas'  GROUP BY a.id_kompetensi_dasar")->result_array();
    }

    public function kd_penilaianketerampilan_hitung($id_mata_pelajaran,$tahun,$kelas){
        return $this->db->query("SELECT c.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_kompetensi_dasar c ON a.id_kompetensi_dasar=c.id_kompetensi_dasar
                where b.id_mata_pelajaran='$id_mata_pelajaran' AND b.id_tahun_akademik='$tahun' AND b.id_kelas='$kelas'  GROUP BY a.id_kompetensi_dasar");
    }

    public function view_join_where_single($select,$table1,$table2,$field,$where,$order,$ordering){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field,'left');
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }

    function siswa($angkatan,$kelas){
        $this->db->select('a.status_siswa, a.id_sesi, a.id_siswa, a.nipd, a.nisn, a.nama, a.angkatan, b.nama_kelas, c.nama_jurusan, d.jenis_kelamin');
        $this->db->from('rb_siswa a');
        $this->db->join('rb_kelas b','a.id_kelas=b.id_kelas', 'left');
        $this->db->join('rb_jurusan c','a.id_jurusan=c.id_jurusan', 'left');
        $this->db->join('rb_jenis_kelamin d','a.id_jenis_kelamin=d.id_jenis_kelamin', 'left');
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        if ($this->uri->segment(2)!='siswa'){
            $this->db->where('a.status_siswa','Aktif');
        }

        if (trim($angkatan) != '' AND trim($kelas) != ''){
            $this->db->where('a.angkatan',$angkatan);
            $this->db->where('a.id_kelas',$kelas);
        }elseif(trim($angkatan) != ''){
            $this->db->where('a.angkatan',$angkatan);
        }elseif(trim($kelas) != ''){
            $this->db->where('a.id_kelas',$kelas);
        }else{
            $this->db->where('a.id_kelas','xx');
        }
        $this->db->order_by('a.nama','ASC');
        return $this->db->get();
    }

    function siswa_nipd($angkatan,$kelas){
        $this->db->select('a.id_siswa, a.nipd, a.nisn, a.nama, a.angkatan, b.nama_kelas, c.nama_jurusan, d.jenis_kelamin');
        $this->db->from('rb_siswa a');
        $this->db->join('rb_kelas b','a.id_kelas=b.id_kelas', 'left');
        $this->db->join('rb_jurusan c','a.id_jurusan=c.id_jurusan', 'left');
        $this->db->join('rb_jenis_kelamin d','a.id_jenis_kelamin=d.id_jenis_kelamin', 'left');
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        if (trim($angkatan) != '' AND trim($kelas) != ''){
            $this->db->where('a.angkatan',$angkatan);
            $this->db->where('a.id_kelas',$kelas);
        }elseif(trim($angkatan) != ''){
            $this->db->where('a.angkatan',$angkatan);
        }elseif(trim($kelas) != ''){
            $this->db->where('a.id_kelas',$kelas);
        }else{
            $this->db->where('a.id_kelas','xx');
        }
        $this->db->order_by('a.nipd','ASC');
        return $this->db->get();
    }

    function guru(){
        $this->db->select('a.*, b.status_kepegawaian, c.jenis_ptk');
        $this->db->from('rb_guru a');
        $this->db->join('rb_status_kepegawaian b','a.id_status_kepegawaian=b.id_status_kepegawaian', 'left');
        $this->db->join('rb_jenis_ptk c','a.id_jenis_ptk=c.id_jenis_ptk', 'left');
        if ($this->uri->segment(3)!=''){
            $this->db->where('a.id_guru',$this->uri->segment(3));
        }
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('a.nama_guru','ASC');
        return $this->db->get();
    }

    function users(){
        $this->db->select('*');
        $this->db->from('rb_users');
        $this->db->where('level!=','kepala');
        $this->db->where('id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('id_user','ASC');
        return $this->db->get();
    }

    function mapel(){
        $this->db->select('a.*, b.nama_jurusan, c.nama_guru, d.kode_tingkat as tingkat, d.keterangan as keterangan_tingkat');
        $this->db->from('rb_mata_pelajaran a');
        $this->db->join('rb_jurusan b','a.id_jurusan=b.id_jurusan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tingkat d','a.id_tingkat=d.id_tingkat', 'left');
        if ($this->uri->segment(3)!=''){
            $this->db->where('a.id_tingkat',$this->uri->segment(3));
        }
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('a.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_all(){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.kode_pelajaran, e.namamatapelajaran, e.kkm, e.id_jurusan, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        if ($this->input->get('tahun')!=''){
            $this->db->where('a.id_tahun_akademik',$this->input->get('tahun'));
        }
        if ($this->input->get('kelas')!=''){
            $this->db->where('a.id_kelas',$this->input->get('kelas'));
        }
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('a.kodejdwl','ASC');
        return $this->db->get();
    }

    function magang_selected(){
        $this->db->select('*');
        $this->db->from('rb_siswa a');
        $this->db->join('rb_jurusan b','a.id_jurusan=b.id_jurusan', 'left');
        $this->db->join('rb_kelas c','a.id_kelas=c.id_kelas', 'left');
        $this->db->join('rb_tingkat d','c.id_tingkat=d.id_tingkat', 'left');
        
        if ($this->input->get('angkatan')!=''){
            $this->db->where('a.angkatan',$this->input->get('angkatan'));
        }
        
        if ($this->input->get('jurusan')!=''){
            $this->db->where('a.id_jurusan',$this->input->get('jurusan'));
        }

        $this->db->where('a.id_bkk', NULL);
        $this->db->where('a.status_siswa', 'Aktif');
        $this->db->where('c.id_tingkat', 12);
        $this->db->order_by('a.id_siswa','ASC');
        return $this->db->get();
    }

    function magang_all($params) {
        $this->db->select('*');
        $this->db->from('rb_siswa a');
        $this->db->join('rb_jurusan b','a.id_jurusan=b.id_jurusan', 'left');
        $this->db->join('rb_kelas c','a.id_kelas=c.id_kelas', 'left');
        $this->db->join('rb_tingkat d','c.id_tingkat=d.id_tingkat', 'left');
        $this->db->where('a.id_siswa', $params);
        $this->db->order_by('a.id_siswa','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran($kurikulum){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kkm, e.id_jurusan, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_tingkat g','f.id_tingkat=g.id_tingkat', 'left');
        if ($this->input->get('tahun')!=''){
            $this->db->where('a.id_tahun_akademik',$this->input->get('tahun'));
        }
        if ($this->input->get('kelas')!=''){
            $this->db->where('a.id_kelas',$this->input->get('kelas'));
        }
        $this->db->where('g.kode_kurikulum',$kurikulum);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('a.kodejdwl','ASC');
        return $this->db->get();
    }

    function jurnal_kbm_rekap($thn,$kelas){
        $this->db->select('a.*, c.namamatapelajaran, d.kompetensi_dasar, e.nama_guru, g.nama_kehadiran');
        $this->db->from('rb_journal_list a');
        $this->db->join('rb_jadwal_pelajaran b','a.kodejdwl=b.kodejdwl', 'left');
        $this->db->join('rb_mata_pelajaran c','b.id_mata_pelajaran=c.id_mata_pelajaran', 'left');
        $this->db->join('rb_kompetensi_dasar d','a.id_kompetensi_dasar=d.id_kompetensi_dasar', 'left');
        $this->db->join('rb_guru e','b.id_guru=e.id_guru', 'left');
        $this->db->join('rb_absensi_siswa f','a.id_journal=f.id_journal', 'left');
        $this->db->join('rb_kehadiran g','f.kode_kehadiran=g.kode_kehadiran', 'left');
        if ($this->session->level=='siswa'){
            $this->db->where('f.id_siswa',$this->session->id_session);
        }
        $this->db->where('b.id_tahun_akademik',$thn);
        $this->db->where('b.id_kelas',$kelas);
        $this->db->where('c.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('a.tanggal','DESC');
        return $this->db->get();
    }

    function mata_pelajaran_semester($kurikulum){
        $this->db->select('a.*, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_tingkat g','f.id_tingkat=g.id_tingkat', 'left');
        if ($this->input->get('tahun')!=''){
            $this->db->where('a.id_tahun_akademik',$this->input->get('tahun'));
        }
        if ($this->input->get('kelas')!=''){
            $this->db->where('a.id_kelas',$this->input->get('kelas'));
        }
        $this->db->where('g.kode_kurikulum',$kurikulum);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('e.urutan','ASC');
        $this->db->group_by('a.id_mata_pelajaran');
        return $this->db->get();
    }

    function mata_pelajaran_semester_siswa($id_tahun_akademik){
        $this->db->select('a.*, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->where('a.id_tahun_akademik',$id_tahun_akademik);
        $this->db->where('a.id_kelas',$this->session->id_kelas);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('e.urutan','ASC');
        $this->db->group_by('a.id_mata_pelajaran');
        return $this->db->get();
    }

    function jadwal_pelajaran_guru($tahun){
        $this->db->select('a.*, g.nama_jurusan, h.kode_tingkat, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kode_pelajaran, e.id_mata_pelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_jurusan g','e.id_jurusan=g.id_jurusan', 'left');
        $this->db->join('rb_tingkat h','e.id_tingkat=h.id_tingkat', 'left');
        $this->db->where('a.id_tahun_akademik',$tahun);
        $this->db->where('a.id_guru',$this->session->id_session);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_guru_kurikulum($tahun,$kurikulum){
        $this->db->select('a.*, g.nama_jurusan, h.kode_tingkat, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kode_pelajaran, e.id_mata_pelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_jurusan g','e.id_jurusan=g.id_jurusan', 'left');
        $this->db->join('rb_tingkat h','e.id_tingkat=h.id_tingkat', 'left');
        $this->db->where('h.kode_kurikulum',$kurikulum);
        $this->db->where('a.id_tahun_akademik',$tahun);
        $this->db->where('a.id_guru',$this->session->id_session);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_guru_sikap($tahun,$kurikulum){
        $this->db->select('a.*, g.nama_jurusan, h.kode_tingkat, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kode_pelajaran, e.id_mata_pelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_jurusan g','e.id_jurusan=g.id_jurusan', 'left');
        $this->db->join('rb_tingkat h','e.id_tingkat=h.id_tingkat', 'left');

        $where = "h.kode_kurikulum='$kurikulum' AND a.id_tahun_akademik='$tahun' AND a.id_guru='".$this->session->id_session."' AND e.id_identitas_sekolah='".$this->session->sekolah."' AND (a.penilaian='sosial' OR a.penilaian='spiritual')";
        $this->db->where($where);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_siswa($tahun){
        $this->db->select('a.*, g.nama_jurusan, h.kode_tingkat, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, e.namamatapelajaran, e.kode_pelajaran, e.id_mata_pelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->join('rb_jurusan g','e.id_jurusan=g.id_jurusan', 'left');
        $this->db->join('rb_tingkat h','e.id_tingkat=h.id_tingkat', 'left');
        $this->db->where('a.id_tahun_akademik',$tahun);
        $this->db->where('a.id_kelas',$this->session->id_kelas);
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_detail($id){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, d.nama_tahun, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        if($this->session->level=='guru'){
            $this->db->where('a.id_guru',$this->session->id_session);
        }
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->where('a.kodejdwl',$id);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }
    
    function jadwal_pelajaran_detail_borongan($id){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, d.nama_tahun, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->where('a.kodejdwl',$id);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function jadwal_pelajaran_sikap($penilaian,$kelas,$tahun){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, d.nama_tahun, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        if($this->session->level=='guru'){
            $this->db->where('a.id_guru',$this->session->id_session);
        }
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->where('a.id_kelas',$kelas);
        $this->db->where('a.id_tahun_akademik',$tahun);
        $this->db->where('a.penilaian',$penilaian);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function mata_pelajaran_detail($id){
        $this->db->select('a.*, b.nama_ruangan, c.nama_guru, d.kode_tahun_akademik, d.nama_tahun, e.namamatapelajaran, e.kkm, f.nama_kelas');
        $this->db->from('rb_jadwal_pelajaran a');
        $this->db->join('rb_ruangan b','a.id_ruangan=b.id_ruangan', 'left');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        $this->db->join('rb_tahun_akademik d','a.id_tahun_akademik=d.id_tahun_akademik', 'left');
        $this->db->join('rb_mata_pelajaran e','a.id_mata_pelajaran=e.id_mata_pelajaran', 'left');
        $this->db->join('rb_kelas f','a.id_kelas=f.id_kelas', 'left');
        if($this->session->level=='guru'){
            $this->db->where('a.id_guru',$this->session->id_session);
        }
        $this->db->where('e.id_identitas_sekolah',$this->session->sekolah);
        $this->db->where('a.id_mata_pelajaran',$id);
        $this->db->order_by('e.urutan','ASC');
        return $this->db->get();
    }

    function wali_kelas($id){
        $this->db->select('a.*, c.nama_guru');
        $this->db->from('rb_kelas a');
        $this->db->join('rb_guru c','a.id_guru=c.id_guru', 'left');
        if($this->session->level=='guru'){
            $this->db->where('a.id_guru',$this->session->id_session);
        }
        $this->db->where('a.id_kelas',$id);
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        return $this->db->get();
    }

    function jenis_biaya(){
        $this->db->distinct()->select('a.nama_jenis, a.total_beban, b.nama_coa, c.nama_sub_coa');
        $this->db->from('rb_keuangan_jenis a');
        $this->db->join('rb_keuangan_coa b','a.id_coa=b.id_coa', 'left');
        $this->db->join('rb_keuangan_sub_coa c','a.id_sub_coa=c.id_sub_coa', 'left');
        $this->db->order_by('a.id_keuangan_jenis','ASC');
        return $this->db->get();
    }

    function pembayaran_siswa(){
        $this->db->select('a.id_siswa, a.nipd, a.nisn, a.nama, a.angkatan, b.nama_kelas, c.nama_jurusan, d.jenis_kelamin');
        $this->db->from('rb_siswa a');
        $this->db->join('rb_kelas b','a.id_kelas=b.id_kelas', 'left');
        $this->db->join('rb_jurusan c','a.id_jurusan=c.id_jurusan', 'left');
        $this->db->join('rb_jenis_kelamin d','a.id_jenis_kelamin=d.id_jenis_kelamin', 'left');
        $this->db->where('a.id_identitas_sekolah',$this->session->sekolah);
        $this->db->where('a.id_kelas',$this->input->get('kelas'));
        $this->db->order_by('a.nama','ASC');
        return $this->db->get();
    }

    function detail_topic_forum(){
        $this->db->select('*');
        $this->db->from('rb_forum_topic a');
        $this->db->join('rb_jadwal_pelajaran b','a.kodejdwl=b.kodejdwl', 'left');
        $this->db->join('rb_guru c','b.id_guru=c.id_guru', 'left');
        $this->db->where('a.id_forum_topic',$this->input->get('id_topic'));
        $this->db->where('a.kodejdwl',$this->input->get('kodejdwl'));
        return $this->db->get();
    }

    function view_where_ruangan(){
        $this->db->select('a.*');
        $this->db->from('rb_ruangan a');
        $this->db->join('rb_gedung b','a.id_gedung=b.id_gedung', 'left');
        $this->db->where('b.id_identitas_sekolah',$this->session->sekolah);
        return $this->db->get()->result_array();
    }

    function lab(){
        $this->db->select('a.*');
        $this->db->from('rb_lab a');
        return $this->db->get()->result_array();   
    }

    function bengkel(){
        $this->db->select('a.*');
        $this->db->from('rb_bengkel a');
        return $this->db->get()->result_array();
    }

    function total_bayar(){
        return $this->db->query("SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_keuangan_jenis='$_GET[biaya]' AND id_kelas='$_GET[kelas]' AND id_siswa='$_GET[id_siswa]' AND id_tahun_akademik='$_GET[tahun]'");
    }
    
    function umenu_akses($link,$id){
        if($this->session->level=='admin' OR $this->session->level=='user'){
            return $this->db->query("SELECT * FROM modul,users_modul WHERE modul.id_modul=users_modul.id_modul AND users_modul.id_user='$id' AND modul.link='$link' AND level='".$this->session->level."'")->num_rows();
        }else{
            return $this->db->query("SELECT * FROM modul,users_modul WHERE modul.id_modul=users_modul.id_modul AND modul.link='$link' AND level='".$this->session->level."'")->num_rows();
        }
    }

    public function cek_login($username,$password,$table){
        return $this->db->query("SELECT * FROM $table where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
    }

    public function cek_login_guru($username,$password,$table){
        return $this->db->query("SELECT * FROM $table where nip='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
    }

    public function cek_login_siswa($username,$password,$table){
        return $this->db->query("SELECT * FROM $table where nipd='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."'");
    }

    public function cek_login_siswa_ortu($username,$password,$table){
        return $this->db->query("SELECT * FROM $table a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.email='".$this->db->escape_str($username)."' AND a.password='".$this->db->escape_str($password)."'");
    }

    function grafik_kunjungan(){
        return $this->db->query("SELECT * FROM rb_users_aktivitas GROUP BY tanggal ORDER BY tanggal DESC LIMIT 7");
    }

    public function import_excel_ruangan($directory,$filename)
    {
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);        
        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = $worksheet[$i]['B'];
          $data3 = $worksheet[$i]['C'];
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
          $data7 = $worksheet[$i]['G'];
         
          $id_gedung = $this->model_app->view_where('rb_gedung',array('kode_gedung'=>$data1))->row_array();  
          print_r($id_gedung); exit();

          $cek_kode_ruangan = $this->model_app->view_where('rb_ruangan','kode_ruangan')->row_array();         
          if ($cek->num_rows()<=0 AND trim($data3)!=''){
            $ins = array(
                    "id_gedung"         => $id_ruangan['id_gedung'],
                    "kode_gedung"       => $data1,
                    "kode_ruangan"      => $data2,
                    "nama_ruangan"      => $data3,
                    "kapasitas_belajar" => $data4,
                    "kapasitas_ujian"   => $data5,
                    "keterangan"        => $data6,
                    "aktif"             => $data7                    
                    );
            $this->db->insert('rb_gedung', $ins);
            echo "Sukses - <b><span style='color:green'>$data2 / $data3</span></b>, a/n <b> $data3</b> Sukses di import,.. <br>";
          }else{
            $ins_update = array("angkatan" => $data46,
                                "id_kelas" => $kelas['id_kelas']);
            $this->db->where('nipd',$data1);
            $this->db->update('rb_siswa',$ins_update);
            foreach ($cek->result_array() as $row) {
                echo "<b>Gagal - <span style='color:red'>$row[nipd] / $row[nisn]</span></b>, a/n <b> $row[nama]</b> sudah ada di database,.. <br>";
            }
          }
        }
    }
    public function import_excel_siswa($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
        echo "<a href='".base_url().$this->uri->segment(1)."/siswa?angkatan=".$this->input->post('angkatan')."&kelas=".$this->input->post('kelas')."'>Selesai / Kembali</a><hr>";
        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = md5(trim($worksheet[$i]['B']));
          $data3 = $worksheet[$i]['C'];
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
          $data7 = $worksheet[$i]['G'];
          $data8 = $worksheet[$i]['H'];
          $data9 = $worksheet[$i]['I'];
          $data10 = $worksheet[$i]['J'];
          $data11 = $worksheet[$i]['K'];
          $data12 = $worksheet[$i]['L'];
          $data13 = $worksheet[$i]['M'];
          $data14 = $worksheet[$i]['N'];
          $data15 = $worksheet[$i]['O'];
          $data16 = $worksheet[$i]['P'];
          $data17 = $worksheet[$i]['Q'];
          $data18 = $worksheet[$i]['R'];
          $data19 = $worksheet[$i]['S'];
          $data20 = $worksheet[$i]['T'];
          $data21 = $worksheet[$i]['U'];
          $data22 = $worksheet[$i]['V'];
          $data23 = $worksheet[$i]['W'];
          $data24 = $worksheet[$i]['X'];
          $data25 = $worksheet[$i]['Y'];
          $data26 = $worksheet[$i]['Z'];
          $data27 = $worksheet[$i]['AA'];
          $data28 = $worksheet[$i]['AB'];
          $data29 = $worksheet[$i]['AC'];
          $data30 = $worksheet[$i]['AD'];
          $data31 = $worksheet[$i]['AE'];
          $data32 = $worksheet[$i]['AF'];
          $data33 = $worksheet[$i]['AG'];
          $data34 = $worksheet[$i]['AH'];
          $data35 = $worksheet[$i]['AI'];
          $data36 = $worksheet[$i]['AJ'];
          $data37 = $worksheet[$i]['AK'];
          $data38 = $worksheet[$i]['AL'];
          $data39 = $worksheet[$i]['AM'];
          $data40 = $worksheet[$i]['AN'];
          $data41 = $worksheet[$i]['AO'];
          $data42 = $worksheet[$i]['AP'];
          $data43 = $worksheet[$i]['AQ'];
          $data44 = $worksheet[$i]['AR'];
          $data45 = $worksheet[$i]['AS'];
          $data46 = $worksheet[$i]['AT'];
          $data47 = $worksheet[$i]['AU'];
          $data48 = $worksheet[$i]['AV'];
          $data49 = $worksheet[$i]['AW'];
          // print_r($worksheet[$i]['AX']); exit();
          $data50 = str_replace(" "," ",$worksheet[$i]['AX']);
          $data51 = $worksheet[$i]['AY'];
          $data52 = $worksheet[$i]['AZ'];
          if (trim($data5)==''){ $data5x = rand(10000,99999999); }else{ $data5x = $data5; }
          if (trim($data5)==''){ $data5x = rand(10000,99999999); }else{ $data5x = $data5; }
          if (trim($data22)==''){ $data22x = 'siswa@schoolmedia.id'; }else{ $data22x = $data22; }
          $cek = $this->db->query("SELECT * FROM rb_siswa where (nipd='$data1' OR nisn='$data5x') AND id_identitas_sekolah='".$this->session->sekolah."'");
          $kelas = $this->db->query("SELECT id_kelas FROM rb_kelas where kode_kelas='$data50' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          $jurusan = $this->db->query("SELECT id_jurusan FROM rb_jurusan where kode_jurusan='$data51' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          if ($cek->num_rows()<=0 AND trim($data3)!=''){
            $ins = array(
                    "id_siswa"              => '',
                    "id_identitas_sekolah"  => $this->session->sekolah,
                    "nipd"                  => $data1,
                    "password"              => $data2,
                    "nama"                  => $data3,
                    "id_jenis_kelamin"      => $data4,
                    "nisn"                  => $data5x,
                    "tempat_lahir"          => $data6,
                    "tanggal_lahir"         => $data7,
                    "nik"                   => $data8,
                    "id_agama"              => $data9,
                    "kebutuhan_khusus"      => $data10,
                    "alamat"                => $data11,
                    "rt"                    => $data12,
                    "rw"                    => $data13,
                    "dusun"                 => $data14,
                    "kelurahan"             => $data15,
                    "kecamatan"             => $data16,
                    "kode_pos"              => $data17,
                    "jenis_tinggal"         => $data18,
                    "alat_transportasi"     => $data19,
                    "telepon"               => $data20,
                    "hp"                    => $data21,
                    "email"                 => $data22x,
                    "skhun"                 => $data23,
                    "penerima_kps"          => $data24,
                    "no_kps"                => $data25,
                    "foto"                  => $data26,
                    "nama_ayah"             => $data27,
                    "tahun_lahir_ayah"      => $data28,
                    "pendidikan_ayah"       => $data29,
                    "pekerjaan_ayah"        => $data30,
                    "penghasilan_ayah"      => $data31,
                    "kebutuhan_khusus_ayah" => $data32,
                    "no_telpon_ayah"        => $data33,
                    "nama_ibu"              => $data34,
                    "tahun_lahir_ibu"       => $data35,
                    "pendidikan_ibu"        => $data36,
                    "pekerjaan_ibu"         => $data37,
                    "penghasilan_ibu"       => $data38,
                    "kebutuhan_khusus_ibu"  => $data39,
                    "no_telpon_ibu"         => $data40,
                    "nama_wali"             => $data41,
                    "tahun_lahir_wali"      => $data42,
                    "pendidikan_wali"       => $data43,
                    "pekerjaan_wali"        => $data44,
                    "penghasilan_wali"      => $data45,
                    "angkatan"              => $data46,
                    "status_awal"           => $data47,
                    "status_siswa"          => $data48,
                    "tingkat"               => $data49,
                    "id_kelas"              => $kelas['id_kelas'],
                    "id_jurusan"            => $jurusan['id_jurusan'],
                    "id_sesi"               => $data52,
                    "email_sekolah"         => '',
                    "no_rek"                => '');
            $this->db->insert('rb_siswa', $ins);
            echo "Sukses - <b><span style='color:green'>$data1 / $data5x</span></b>, a/n <b> $data3</b> Sukses di import,.. <br>";
          }else{
            $ins_update = array("angkatan" => $data46,
                                "id_kelas" => $kelas['id_kelas']);
            $this->db->where('nipd',$data1);
            $this->db->update('rb_siswa',$ins_update);
            foreach ($cek->result_array() as $row) {
                echo "<b>Gagal - <span style='color:red'>$row[nipd] / $row[nisn]</span></b>, a/n <b> $row[nama]</b> sudah ada di database,.. <br>";
            }
          }
        }
    }


    public function import_excel_guru($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
        echo "<a href='".base_url().$this->uri->segment(1)."/guru'>Selesai / Kembali</a><hr>";

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = md5($worksheet[$i]['B']);
          $data3 = $worksheet[$i]['C'];
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
          $data7 = $worksheet[$i]['G'];
          $data8 = $worksheet[$i]['H'];
          $data9 = $worksheet[$i]['I'];
          $data10 = $worksheet[$i]['J'];
          $data11 = $worksheet[$i]['K'];
          $data12 = $worksheet[$i]['L'];
          $data13 = $worksheet[$i]['M'];
          $data14 = $worksheet[$i]['N'];
          $data15 = $worksheet[$i]['O'];
          $data16 = $worksheet[$i]['P'];
          $data17 = $worksheet[$i]['Q'];
          $data18 = $worksheet[$i]['R'];
          $data19 = $worksheet[$i]['S'];
          $data20 = $worksheet[$i]['T'];
          $data21 = $worksheet[$i]['U'];
          $data22 = $worksheet[$i]['V'];
          $data23 = $worksheet[$i]['W'];
          $data24 = $worksheet[$i]['X'];
          $data25 = $worksheet[$i]['Y'];
          $data26 = $worksheet[$i]['Z'];
          $data27 = $worksheet[$i]['AA'];
          $data28 = $worksheet[$i]['AB'];
          $data29 = $worksheet[$i]['AC'];
          $data30 = $worksheet[$i]['AD'];
          $data31 = $worksheet[$i]['AE'];
          $data32 = $worksheet[$i]['AF'];
          $data33 = $worksheet[$i]['AG'];
          $data34 = $worksheet[$i]['AH'];
          $data35 = $worksheet[$i]['AI'];
          $data36 = $worksheet[$i]['AJ'];
          $data37 = $worksheet[$i]['AK'];
          $data38 = $worksheet[$i]['AL'];
          $data39 = $worksheet[$i]['AM'];
          $data40 = $worksheet[$i]['AN'];
          $data41 = $worksheet[$i]['AO'];
          $data42 = $worksheet[$i]['AP'];
          $data43 = $worksheet[$i]['AQ'];
          $data44 = $worksheet[$i]['AR'];
          $data45 = $worksheet[$i]['AS'];
          $data46 = $worksheet[$i]['AT'];
          $data47 = $worksheet[$i]['AU'];
          $data48 = $worksheet[$i]['AV'];
          if (trim($data1)==''){ $data1x = rand(10000,99999999); }else{ $data1x = $data1; }
          if (trim($data23)==''){ $data23x = 'guru@schoolmedia.id'; }else{ $data23x = $data23; }

          $cek = $this->db->query("SELECT * FROM rb_guru where nip='$data1x' AND id_identitas_sekolah='".$this->session->sekolah."'");
          if ($cek->num_rows()<=0){
            $ins = array(
                    "id_identitas_sekolah"  =>$this->session->sekolah,
                    "nip"                   =>$data1x,
                    "password"              =>$data2,
                    "nama_guru"             =>$data3,
                    "id_jenis_kelamin"      =>$data4,
                    "tempat_lahir"          =>$data5,
                    "tanggal_lahir"         =>$data6,
                    "nik"                   =>$data7,
                    "niy_nigk"              =>$data8,
                    "nuptk"                 =>$data9,
                    "id_status_kepegawaian" =>$data10,
                    "id_jenis_ptk"          =>$data11,
                    "pengawas_bidang_studi" =>$data12,
                    "id_agama"              =>$data13,
                    "alamat_jalan"          =>$data14,
                    "rt"                    =>$data15,
                    "rw"                    =>$data16,
                    "nama_dusun"            =>$data17,
                    "desa_kelurahan"        =>$data18,
                    "kecamatan"             =>$data19,
                    "kode_pos"              =>$data20,
                    "telepon"               =>$data21,
                    "hp"                    =>$data22,
                    "email"                 =>$data23x,
                    "tugas_tambahan"        =>$data24,
                    "id_status_keaktifan"   =>$data25,
                    "sk_cpns"               =>$data26,
                    "tanggal_cpns"          =>$data27,
                    "sk_pengangkatan"       =>$data28,
                    "tmt_pengangkatan"      =>$data29,
                    "lembaga_pengangkatan"  =>$data30,
                    "id_golongan"           =>$data31,
                    "keahlian_laboratorium" =>$data32,
                    "sumber_gaji"           =>$data33,
                    "nama_ibu_kandung"      =>$data34,
                    "id_status_pernikahan"  =>$data35,
                    "nama_suami_istri"      =>$data36,
                    "nip_suami_istri"       =>$data37,
                    "pekerjaan_suami_istri" =>$data38,
                    "tmt_pns"               =>$data39,
                    "lisensi_kepsek"        =>$data40,
                    "jumlah_sekolah_binaan" =>$data41,
                    "diklat_kepengawasan"   =>$data42,
                    "mampu_handle_kk"       =>$data43,
                    "keahlian_breile"       =>$data44,
                    "keahlian_bahasa_isyarat" =>$data45,
                    "npwp"                  =>$data46,
                    "kewarganegaraan"       =>$data47,
                    "foto"                  =>$data48,
                    "guru_bk"               =>'Tidak',
                    "guru_piket"            =>'Tidak',
                    "kepala_sekolah"        =>'Tidak');
            $this->db->insert('rb_guru', $ins);
            echo "Sukses - <b><span style='color:green'>$data1x</span></b>, a/n <b> $data3</b> Sukses di import,.. <br>";
          }else{
            foreach ($cek->result_array() as $row) {
                echo "<b>Gagal - <span style='color:red'>$row[nip]</span></b>, a/n <b> $row[nama_guru]</b> sudah ada di database,.. <br>";
            }
          }
        }
    }

    public function import_excel_kd($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = $worksheet[$i]['B'];
          $data3 = $worksheet[$i]['C'];
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
            if (trim($data5)!=''){
                if (substr($data2, 0,1) =='1'){
                    $ranah = 'spiritual';
                }elseif (substr($data2, 0,1) =='2'){
                    $ranah = 'sosial';
                }elseif (substr($data2, 0,1) =='3'){
                    $ranah = 'pengetahuan';
                }elseif (substr($data2, 0,1) =='4'){
                    $ranah = 'keterampilan';
                }

                if (trim($data3)=='' OR $data3=='0'){
                    $kkm = 75;
                }else{
                    $kkm = $data3;
                }
                

                $ins = array("id_identitas_sekolah" =>$this->session->sekolah,
                             "id_mata_pelajaran"    =>$this->uri->segment(4),
                             "kd"                   =>$data2,
                             "ki"                   =>$data4,
                             "ranah"                =>$data1,
                             "kompetensi_dasar"     =>$data5,
                             "kkm"                  =>$kkm,
                             "deskripsi"            =>$data6,
                             "waktu_input"          =>date('Y-m-d H:i:s'));
                $this->db->insert('rb_kompetensi_dasar', $ins);
              }
        }

        $kkm_kd = $this->db->query("SELECT (sum(kkm)/count(*)) as nilai FROM rb_kompetensi_dasar where id_mata_pelajaran='".$this->uri->segment(4)."'")->row_array();
        $data_kkm = array('kkm'=>$kkm_kd['nilai']);
        $where_kkm = array('id_mata_pelajaran' => $this->uri->segment(4),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->update('rb_mata_pelajaran', $data_kkm, $where_kkm);
    }


    public function import_excel_uas($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data3 = $worksheet[$i]['C'];
            if (trim($data1)!=''){
                $kompetensi_dasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$this->uri->segment(6),'ranah'=>'pengetahuan'),'id_kompetensi_dasar','ASC');
                foreach ($kompetensi_dasar as $k){
                    $siw = $this->db->query("SELECT id_siswa FROM rb_siswa where nipd='$data1' OR nisn='$data1'")->row_array();
                    $cek = $this->model_app->view_where('rb_kompetensi_dasar',array('kodejdwl'=>$this->uri->segment(4), 'id_siswa'=>$siw['id_siswa'], 'id_kompetensi_dasar'=>$k['id_kompetensi_dasar'], 'kategori_nilai'=>3))->num_rows();
                    if ($cek>=1){
                        $data_uas = array('nilai'=>$data3);
                        $where_uas = array('kodejdwl'=>$this->uri->segment(4), 'id_siswa'=>$siw['id_siswa'], 'id_kompetensi_dasar'=>$k['id_kompetensi_dasar'], 'kategori_nilai'=>3);
                        $this->model_app->update('rb_kompetensi_dasar', $data_uas, $where_uas);
                    }else{
                        $data = array('kodejdwl'=>$this->uri->segment(4),
                                'id_siswa'=>$siw['id_siswa'],
                                'id_kompetensi_dasar'=>$k['id_kompetensi_dasar'],
                                'nilai'=>$data3,
                                'kategori_nilai'=>3,
                                'tanggal_penilaian'=>date('Y-m-d'),
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);  
                    }
                }
            }
        }
    }

    public function import_excel_mapel($directory,$filename,$tingkat){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = $worksheet[$i]['B'];          
          $data3 = $worksheet[$i]['C'];          
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
          $data7 = $worksheet[$i]['G'];
          $data8 = $worksheet[$i]['H'];
          $data9 = $worksheet[$i]['I'];
            if (trim($data1)!=''){
                $kel = $this->model_app->view_where('rb_kelompok_mata_pelajaran',array('jenis_kelompok_mata_pelajaran'=>$data2,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();                
                $jur = $this->model_app->view_where('rb_jurusan',array('kode_jurusan'=>$data3,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();                
                $guru = $this->model_app->view_where('rb_guru',array('nip'=>$data4,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                if ($guru['id_guru']==''){ $id = 1; }else{ $id = $guru['id_guru']; }
                $mapel = array("id_identitas_sekolah"           =>$this->session->sekolah,
                             "kode_pelajaran"                   =>$data1,
                             "id_kelompok_mata_pelajaran"       =>$kel['id_kelompok_mata_pelajaran'],
                             "id_kelompok_mata_pelajaran_sub"   =>'0',
                             "id_jurusan"                       =>$jur['id_jurusan'],
                             "id_guru"                          =>$id,
                             "namamatapelajaran"                =>$data5,
                             "namamatapelajaran_en"             =>$data6,
                             "id_tingkat"                       =>$tingkat,
                             "kompetensi_umum"                  =>'',
                             "kompetensi_khusus"                =>'',
                             "jumlah_jam"                       =>$data7,
                             "sesi"                             =>'0',
                             "urutan"                           =>$data8,
                             "kkm"                              =>$data9,
                             "aktif"                            =>'Ya');
                $this->db->insert('rb_mata_pelajaran', $mapel);
              }
        }
    }

     public function import_excel_jadwal($directory,$filename,$tingkat){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
            $data1 = $worksheet[$i]['A'];
            $data2 = $worksheet[$i]['B'];
            $data3 = $worksheet[$i]['C'];
            $data4 = $worksheet[$i]['D'];
            $data5 = $worksheet[$i]['E'];
            $data6 = $worksheet[$i]['F'];
            $data7 = $worksheet[$i]['G'];
            $data8 = $worksheet[$i]['H'];
            $data9 = $worksheet[$i]['I'];
            $data10 = $worksheet[$i]['J'];
            
            if (trim($data2)!=''){
                $tahun = $this->model_app->view_where('rb_tahun_akademik',array('nama_tahun'=>$data1,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                $kelas = $this->model_app->view_where('rb_kelas',array('kode_kelas'=>$data2,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                    $mapel = $this->model_app->view_where('rb_mata_pelajaran',array('kode_pelajaran'=>$data3,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                $ruang = $this->model_app->view_where('rb_ruangan',array('kode_ruangan'=>$data4))->row_array();
                $guru = $this->model_app->view_where('rb_guru',array('nip'=>$data5,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                
                if ($guru['id_guru']==''){ $id = 497; }else{ $id = $guru['id_guru']; }
                
                $jadwal = array("id_tahun_akademik"     => $tahun['id_tahun_akademik'],
                             "id_kelas"                 => $kelas['id_kelas'],
                             "id_mata_pelajaran"        => $mapel['id_mata_pelajaran'],
                             "id_ruangan"               => $ruang['id_ruangan'],
                             "id_guru"                  => $id,
                             "jam_ke"                   => $data6,
                             "jam_mulai"                => $data7,
                             "jam_selesai"              => $data8,
                             "hari"                     => $data9,
                             "jurnal_sikap"             => 'Aktif',
                             "remedial"                 => '1',
                             "penilaian"                => 'umum',
                             "aktif"                    => $data10);
                $this->db->insert('rb_jadwal_pelajaran', $jadwal);
            }
        }
    }

    public function import_excel_borongan($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $id_siswa = $worksheet[$i]['B'];
          $a        = $worksheet[$i]['F'];
          $b        = $worksheet[$i]['G'];
          $c        = $worksheet[$i]['H'];
          $d        = $worksheet[$i]['I'];

            if (trim($id_siswa)!=''){
                $cek = $this->model_app->view_where('rb_nilai_borongan',array('kodejdwl'=>$this->uri->segment(4), 'id_siswa'=>$id_siswa))->num_rows();
                if ($cek >= '1'){
                    $data = array('nilai_pengetahuan'=>$a,
                                  'deskripsi_pengetahuan'=>$b,
                                  'nilai_keterampilan'=>$c,
                                  'deskripsi_keterampilan'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'kodejdwl'=>$this->uri->segment(4));
                    $this->model_app->update('rb_nilai_borongan', $data, $where);
                }else{
                  $data = array('kodejdwl'=>$this->uri->segment(4),
                                'id_siswa'=>$id_siswa,
                                'nilai_pengetahuan'=>$a,
                                'deskripsi_pengetahuan'=>$b,
                                'nilai_keterampilan'=>$c,
                                'deskripsi_keterampilan'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_borongan',$data);
                }
            }
        }
    }

    public function import_excel_borongan_sikap($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $id_siswa = $worksheet[$i]['B'];
          $a        = $worksheet[$i]['F'];
          $b        = $worksheet[$i]['G'];
          $c        = $worksheet[$i]['H'];
          $d        = $worksheet[$i]['I'];

            if (trim($id_siswa)!=''){
                $cek = $this->model_app->view_where('rb_nilai_borongan_sikap',array('id_tahun_akademik'=>$this->input->get('tahun'), 'id_siswa'=>$id_siswa))->num_rows();
                if ($cek >= '1'){
                    $data = array('nilai_spiritual'=>$a,
                                  'deskripsi_spiritual'=>$b,
                                  'nilai_sosial'=>$c,
                                  'deskripsi_sosial'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->get('tahun'));
                    $this->model_app->update('rb_nilai_borongan_sikap', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                                'id_siswa'=>$id_siswa,
                                'nilai_spiritual'=>$a,
                                'deskripsi_spiritual'=>$b,
                                'nilai_sosial'=>$c,
                                'deskripsi_sosial'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_borongan_sikap',$data);
                }
            }
        }
    }
    
    public function import_excel_borongan_absensi($directory,$filename){
        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $id_siswa = $worksheet[$i]['B'];
          $a        = $worksheet[$i]['F'];
          $b        = $worksheet[$i]['G'];
          $c        = $worksheet[$i]['H'];
          $d        = $worksheet[$i]['I'];

            if (trim($id_siswa)!=''){
                $cek = $this->model_app->view_where('rb_absensi_borongan',array('id_tahun_akademik'=>$this->input->get('tahun'), 'id_siswa'=>$id_siswa))->num_rows();
                if ($cek >= '1'){
                    $data = array('sakit'=>$a,
                                  'izin'=>$b,
                                  'alpa'=>$c,
                                  'hadir'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->get('tahun'));
                    $this->model_app->update('rb_absensi_borongan', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                                'id_siswa'=>$id_siswa,
                                'sakit'=>$a,
                                'izin'=>$b,
                                'alpa'=>$c,
                                'hadir'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_absensi_borongan',$data);
                }
            }
        }
    }
}