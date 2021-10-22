<?php

class DataAbsensi extends CI_Controller
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
    $data['title'] = "Data Absensi Pegawai";

    if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
      $bulan = $_GET['bulan'];
      $tahun = $_GET['tahun'];
      $bulanTahun = $bulan . $tahun;
    } else {
      $bulan = date('m');
      $tahun = date('Y');
      $bulanTahun = $bulan . $tahun;
    }

    $data['absensi'] = $this->db->query("SELECT data_kehadiran.*, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_pegawai.jabatan FROM data_kehadiran INNER JOIN data_pegawai ON data_kehadiran.nip = data_pegawai.nip INNER JOIN data_jabatan ON data_pegawai.jabatan = data_jabatan.nama_jabatan WHERE data_kehadiran.bulan = '$bulanTahun' ORDER BY data_pegawai.nama_pegawai ASC")->result();

    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/RekapAbsen/dataAbsensi', $data);
    $this->load->view('templates_admin/footer');
  }

  public function inputAbsensi()
  {
    if ($this->input->post('submit', TRUE) == 'submit') {
      $post = $this->input->post();

      foreach ($post['bulan'] as $key => $value) {
        if ($post['bulan'][$key] != '' || $post['nik'][$key] != '') {
          $simpan[] = array(
            'bulan'         => $post['bulan'][$key],
            'nip'           => $post['nip'][$key],
            'nama_pegawai'  => $post['nama_pegawai'][$key],
            'jenis_kelamin' => $post['jenis_kelamin'][$key],
            'nama_jabatan'  => $post['nama_jabatan'][$key],
            'hadir'         => $post['hadir'][$key],
            'sakit'         => $post['sakit'][$key],
            'izin'         => $post['izin'][$key],
            'alpha'         => $post['alpha'][$key],
          );
        }
      }
      $this->penggajianModel->insert_batch('data_kehadiran', $simpan);
      $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil ditambahkan</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/dataAbsensi');
    }

    $data['title'] = "Form Input Absensi";

    if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
      $bulan = $_GET['bulan'];
      $tahun = $_GET['tahun'];
      $bulanTahun = $bulan . $tahun;
    } else {
      $bulan = date('m');
      $tahun = date('Y');
      $bulanTahun = $bulan . $tahun;
    }

    $data['inputAbsensi'] = $this->db->query("SELECT data_pegawai.*, data_jabatan.nama_jabatan FROM data_pegawai INNER JOIN data_jabatan ON data_pegawai.jabatan = data_jabatan.nama_jabatan WHERE NOT EXISTS(SELECT * FROM data_kehadiran WHERE bulan = '$bulanTahun' AND data_pegawai.nip = data_kehadiran.nip) ORDER BY data_pegawai.nama_pegawai ASC")->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/RekapAbsen/formInputAbsensi', $data);
    $this->load->view('templates_admin/footer');
  }
  public function updateData($id)
  {
    // $where = array('id_jabatan' => $id);
    $data['title'] = "Update Data Absensi";
    $data['absensi'] = $this->db->query("SELECT * FROM data_kehadiran WHERE id_kehadiran = '$id'")->result();
    // $data['absensi'] = $this->penggajianModel->get_data('data_kehadiran')->result();
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/RekapAbsen/updateDataAbsensi', $data);
    $this->load->view('templates_admin/footer');
  }

  public function updateDataAksi()
  {
    $this->_rules();

    if ($this->form_validation->run() == FALSE) {
      $id = $this->insert_batch->post('id_kehadiran');
      $this->updateData($id);
    } else {
      $id           = $this->input->post('id_pegawai');
      $nama_pegawai = $this->input->post('nama_pegawai');
      $jenis_kelamin   = $this->input->post('jenis_kelamin');
      $nama_jabatan = $this->input->post('nama_jabatan');
      $hadir   = $this->input->post('hadir');
      $sakit   = $this->input->post('sakit');
      $alpha   = $this->input->post('alpha');
      $izin   = $this->input->post('izin');


      $data = array(
        'nama_pegawai' => $nama_pegawai,
        'jenis_kelamin'   => $jenis_kelamin,
        'nama_jabatan' => $nama_jabatan,
        'hadir' => $hadir,
        'sakit'   => $sakit,
        'alpha' => $alpha,
        'izin'  => $izin,
      );

      $where = array(
        'id_kehadiran' => $id
      );

      $this->penggajianModel->update_data('data_kehadiran', $data, $where);
      $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil diupdate</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/dataAbsensi');
    }
  }
  public function deleteData($id)
  {
    $where = array('id_kehadiran' => $id);
    $this->penggajianModel->delete_data($where, 'data_kehadiran');
    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil dihapus</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('admin/dataAbsensi');
  }
  public function _rules()
  {
    $this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
    $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('hadir', 'Hadir', 'required');
    $this->form_validation->set_rules('sakit', 'Sakit', 'required');
    $this->form_validation->set_rules('alpha', 'Alpha', 'required');
  }
}
