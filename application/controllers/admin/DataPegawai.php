<?php

class DataPegawai extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('hak_akses') != '1') {
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Anda belum login!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('welcome');
    }
  }

  public function index()
  {
    $data['title'] = "Data Pegawai";
    //penggajianMode suatu model yang berisi  get_data data pegawai(database)
    //->resuly(); untuk mengatur query
    $data['pegawai'] = $this->penggajianModel->get_data('data_pegawai')->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/Pegawai/dataPegawai', $data);
    $this->load->view('templates_admin/footer');
  }

  public function tambahData()
  {
    $data['title'] = "Tambah Data Pegawai";
    $data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/Pegawai/formTambahPegawai', $data);
    $this->load->view('templates_admin/footer');
  }

  public function tambahDataAksi()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $this->tambahData();
    } else {
      $nip           = $this->input->post('nip');
      $nama_pegawai  = $this->input->post('nama_pegawai');
      $jenis_kelamin = $this->input->post('jenis_kelamin');
      $tanggal_masuk = $this->input->post('tanggal_masuk');
      $jabatan       = $this->input->post('jabatan');
      $status        = $this->input->post('status');
      $hak_akses     = $this->input->post('hak_akses');
      $username      = $this->input->post('username');
      $password      = md5($this->input->post('password'));
      $no_hp         = $this->input->post('no_hp');
      $email         = $this->input->post('email');
      $pendidikan    = $this->input->post('pendidikan');
      $alamat        = $this->input->post('alamat');
      $peta          = $this->input->post('peta');
      $photo         = $_FILES['photo']['name'];
      if ($photo = '') {
      } else {
        $config['upload_path'] = './assets/photo';
        $config['allowed_types'] = 'jpg|jpeg|png|tiff|jfif';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('photo')) {
          echo "Photo gagal diupload!";
        } else {
          $photo = $this->upload->data('file_name');
        }
      }

      $data = array(
        'nip' => $nip,
        'nama_pegawai'  => $nama_pegawai,
        'jenis_kelamin' => $jenis_kelamin,
        'jabatan'       => $jabatan,
        'tanggal_masuk' => $tanggal_masuk,
        'status'        => $status,
        'hak_akses'     => $hak_akses,
        'username'      => $username,
        'password'      => $password,
        'photo'         => $photo,
        'no_hp'         => $no_hp,
        'email'         => $email,
        'pendidikan'    => $pendidikan,
        'alamat'        => $alamat,
        'peta'          => $peta,
      );

      $this->penggajianModel->insert_data($data, 'data_pegawai');
      $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil ditambahkan</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/dataPegawai');
    }
  }

  public function updateData($id)
  {
    // $where = array('id_pegawai' => $id);
    $data['title'] = "Update Data Pegawai";
    $data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
    $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai = '$id'")->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/Pegawai/formUpdatePegawai', $data);
    $this->load->view('templates_admin/footer');
  }
  public function updateDataAksi()
  {
    // echo "disini";
    // die;
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $id = $this->input->post('id_pegawai');
      $this->updateData($id);
    } else {
      $id            = $this->input->post('id_pegawai');
      $nip           = $this->input->post('nip');
      $nama_pegawai  = $this->input->post('nama_pegawai');
      $jenis_kelamin = $this->input->post('jenis_kelamin');
      $tanggal_masuk = $this->input->post('tanggal_masuk');
      $jabatan       = $this->input->post('jabatan');
      $status        = $this->input->post('status');
      $hak_akses     = $this->input->post('hak_akses');
      $username      = $this->input->post('username');
      $password      = md5($this->input->post('password'));
      $no_hp         = $this->input->post('no_hp');
      $email         = $this->input->post('email');
      $pendidikan    = $this->input->post('pendidikan');
      $alamat        = $this->input->post('alamat');
      $peta          = $this->input->post('peta');
      $photo         = $_FILES['photo']['name'];
      if ($photo) {
        $config['upload_path'] = './assets/photo';
        $config['allowed_types'] = 'jpg|jpeg|png|tiff';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('photo')) {
          $photo = $this->upload->data('file_name');
          $this->db->set('photo', $photo);
        } else {
          echo $this->upload->display_errors();
        }
      }
      $data = array(
        'nip'           => $nip,
        'nama_pegawai'  => $nama_pegawai,
        'username'      => $username,
        'password'      => $password,
        'jenis_kelamin' => $jenis_kelamin,
        'jabatan'       => $jabatan,
        'tanggal_masuk' => $tanggal_masuk,
        'status'        => $status,
        // 'photo'         => $photo,
        'no_hp'         => $no_hp,
        'email'         => $email,
        'pendidikan'    => $pendidikan,
        'alamat'        => $alamat,
        'peta'          => $peta,
        'hak_akses'     => $hak_akses,
      );
      $where = array('id_pegawai' => $id);
      $this->penggajianModel->update_data('data_pegawai', $data, $where);
      $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil diupdate</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/dataPegawai');
    }
  }

  public function deleteData($id)
  {
    $where = array('id_pegawai' => $id);
    $this->penggajianModel->delete_data($where, 'data_pegawai');
    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil dihapus</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('admin/dataPegawai');
  }

  public function _rules()
  {
    $this->form_validation->set_rules('nip', 'NIP', 'required');
    $this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
    $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('peta', 'Peta', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
  }
  public function detaildata($id)
  {
    $data['title'] = "Detail";
    $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai = '$id'")->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/Pegawai/detaildata', $data);
    $this->load->view('templates_admin/footer');
  }
  public function search()
  {
    $data['title'] = "Data Pegawai";
    $keyword = $this->input->post('keyword');
    $data['pegawai'] = $this->penggajianModel->get_keyword($keyword);
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/Pegawai/datapegawai', $data);
    $this->load->view('templates_admin/footer');
  }
}
