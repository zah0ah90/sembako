<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
	}

	public function index()
	{
		$jumlahBarang = $this->db->query("SELECT count(id) as id from tbl_sembako")->row();
		$jumlahUser = $this->db->query("SELECT count(id) as id from tbl_user")->row();
		$jumlahPenjualan = $this->db->query("SELECT count(id) as id from tbl_penjualan")->row();

		$data = [
			'Barang' => $jumlahBarang->id,
			'User' => $jumlahUser->id,
			'Penjualan' => $jumlahPenjualan->id,
		];
		$this->load->view('dashboard/index', $data);
	}
}