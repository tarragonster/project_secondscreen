<?php

class Index extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("admin_model");		
		$this->load->model("dashboard_model");
	}

	public function index() {
		$this->dashboard();
	}

	public function dashboard($fromDate = '', $toDate = '', $secondFromDate = '', $secondToDate = '') {
		$admin = $this->session->userdata('admin');
		if ($admin == null) {
			redirect(base_url('login'));
		}
		if (!empty($fromDate)) {
			$startDate = strtotime($fromDate);
		} else {
			$startDate = strtotime(date('Y-m-d', time()));
		}
		if (!empty($toDate)) {
			$endDate = strtotime($toDate) + 86400;
		} else {
			$endDate = strtotime(date('Y-m-d', time())) + 86400;
		}
		$dashboard = $this->dashboard_model->getDashBoard($startDate, $endDate, $secondFromDate, $secondToDate);
		if ($this->input->is_ajax_request()) {
			header('Content-Type: application/json');
			$dashboard['success'] = true;
			echo json_encode($dashboard);
		} else {
			$this->mainParams['bottom_html'] = $this->load->view('admin/dashboard/scripts', $dashboard, true);
			$this->customCss[] = 'assets/plugins/morris/morris.css';
			$this->customCss[] = 'assets/plugins/bootstrap-daterangepicker/daterangepicker.css';
			$this->customCss[] = 'assets/css/dashboard.css';
			$this->customJs[] = 'assets/vendor/peity/jquery.peity.min.js';
			$this->customJs[] = 'assets/vendor/jquery-sparkline/jquery.sparkline.min.js';
			$this->customJs[] = 'assets/plugins/moment/moment.js';
			$this->customJs[] = 'assets/plugins/bootstrap-daterangepicker/daterangepicker.js';
			$this->customJs[] = 'assets/vendor/jquery-number/jquery.number.min.js';
			$this->customJs[] = 'assets/plugins/raphael/raphael-min.js';
			$this->customJs[] = 'assets/plugins/morris/morris.min.js';
			$this->customJs[] = 'assets/js/dashboard.js';

			$dashboard['top_users'] = $this->dashboard_model->countUsers();
//			$dashboard['customJs'] = $this->customJs;
//			$dashboard['customCss'] = $this->customCss;
			$this->render('admin/dashboard/layout', $dashboard, 1, 10);
//			$this->load->view('admin/dashboard/layout', $dashboard, 1, 10);
		}
	}
	
	public function login() {
		$admin = $this->session->userdata('admin');
		if ($admin != null) {
			redirect(base_url('dashboard'));
		}

		$cmd = $this->input->post("cmd");
		if ($cmd != '') {
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			if ($email == '' || $password == '') {
				$this->load->view('admin/login', array('error'=>'Thiếu trường'));
			} else {
				$account = $this->admin_model->getAdminAccount($email, $password);
				if ($account != null) {
					$this->session->set_userdata('admin', array('email'=>$account['email'], 'group'=>$account['group']));
					$this->redirect('dashboard');
				} else {
					$this->load->view('admin/login', array('error'=>'Sai thông tin đăng nhập'));
				}
			}
		} else {
			$this->load->view('admin/login');
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('admin');
		$this->session->unset_userdata('lockdata');
		redirect(base_url('login'));
	}
	
	public function lockscreen() {
		$admin = $this->session->userdata('admin');
		if ($admin == null) {
			redirect(base_url('login'));
		}
		
		$account = $this->admin_model->getAdminAccountByEmail($admin['email']);
		$cmd = $this->input->post('cmd');
		if ($cmd == '') {
			$lockdata = $this->session->userdata('lockdata');
			if ($lockdata == null) {
				$this->session->set_userdata('lockdata', array('lock'=>1));
			}
			
			$this->load->view('admin/lockscreen', array('account'=>$account, 'other_account'=>base_url('logout')));
		} else {
			$password = $this->input->post('password');
			if ($password == '') {
				$error = 'Password is missing!';
			} else {
				$account_check = $this->admin_model->getAdminAccount($admin['email'], $password);
				if ($account_check != null) {
					$this->session->unset_userdata('lockdata');
					redirect(base_url(''));
				} else {
					$error = 'Password is invalid!';
				}
			}
			$this->load->view('admin/lockscreen', array('account'=>$account, 'error' => $error, 'other_account'=>base_url('logout')));
		}
	}
}