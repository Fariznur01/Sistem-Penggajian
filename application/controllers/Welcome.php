<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Form Login";
			$this->load->view('templates_admin/header', $data);
			$this->load->view('formLogin');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$cek = $this->penggajianModel->cek_login($username, $password);
			if ($cek == FALSE) {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Username atau password salah!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>');
				redirect('admin/dashboard');
			} else {
				$this->session->set_userdata('hak_akses', $cek->hak_akses);
				$this->session->set_userdata('nama_pegawai', $cek->nama_pegawai);
				$this->session->set_userdata('photo', $cek->photo);
				$this->session->set_userdata('nip', $cek->nip);
				$this->session->set_userdata('id_pegawai', $cek->id_pegawai);
				switch ($cek->hak_akses) {
					case 1:
						redirect('admin/dashboard');
						break;
					case 2:
						redirect('pegawai/dashboard');
						break;
					default:
						break;
				}
			}
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('welcome');
	}
	public function forgotPassword()
	{
		//aturan 
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		//jika email input gagal
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Forgot Password';
			$this->load->view('templates_admin/header', $data);
			$this->load->view('formreset');;
		} else
		//jika berhasil
		{
			//mengambil email yang telah diinput 
			$email = $this->input->post('email');
			//validasi email,kalo aktif =1
			$data_pegawai = $this->db->get_where('data_pegawai', ['email' => $email])->row_array();
			//jika ada email dan sudah diaktifkan  maka diberi token
			if ($data_pegawai) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				//query tambah user token website
				$this->db->insert('user_token', $user_token);
				//token dikirim ke email
				$this->_sendEmail($token, 'forgot');
				//pesan 
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
				redirect('welcome/forgotpassword');
			}
			//email terdaftar tapi belum aktifkan
		}
	}
	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			//email institusi 
			'smtp_user' => 'fariznurfadillah95@gmail.com',
			'smtp_pass' => 'Aquarius_00123',
			'smtp_port' => 465,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => "\r\n"
		];
		//memanggil library email dari CI 3
		//$this->email->initialize($config);
		$this->load->library('email', $config);
		//memberi info gmail pengirim  dan nama pengirim
		$this->email->from('fariznurfadillah95@gmail.com', 'Fariz  ver BETA');
		//mengirim email ke pengirim
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message(' Ganti Password :
    <a href="' . base_url() . 'welcome/gantiPasswordAksi?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
		}
		//jika berhasil dikirm
		if ($this->email->send()) {
			return true;
		} else
		//jika gagal kirim memai print_debugger
		{
			echo $this->email->print_debugger();
			die;
		}
	}
	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		//status email dan token
		$data_pegawai = $this->db->get_where('data_pegawai', ['email' => $email])->row_array();
		if ($data_pegawai) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				//masuk ke halaman ganti password
				$this->gantiPasswordAksi();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
				redirect('welcome');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
			redirect('welcome');
		}
	}
	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('welcome');
		}
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Change Password';
			$this->load->view('templates_admin/header', $data);
			$this->load->view('formGantiPassword');
			$this->load->view('templates_admin/footer');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');
			//query update password
			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('data_pegawai');
			//query menghapus link
			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
			redirect('welcome');
		}
	}
	public function gantiPasswordAksi()
	{
		$passBaru = $this->input->post('passBaru');
		$ulangPass = $this->input->post('ulangPass');
		$this->form_validation->set_rules('passBaru', 'Password baru', 'required|matches[ulangPass]');
		$this->form_validation->set_rules('ulangPass', 'Ulangi password', 'required');
		if ($this->form_validation->run() != FALSE) {
			$data = array('password' => md5($passBaru));
			$id = array('id_pegawai' => $this->session->userdata('id_pegawai'));
			$this->penggajianModel->update_data('data_pegawai', $data, $id);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Password berhasil diganti</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">       <span aria-hidden="true">&times;</span>
        </button>   </div>');
			redirect('welcome');
		} else {
			$data['title'] = "Ganti Password";
			$this->load->view('templates_admin/header', $data);
			$this->load->view('formGantiPassword', $data);
		}
	}
	public function _rules()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
	}
}
