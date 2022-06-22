<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_not_login();
	}

	public function index()
	{
		$query = "SELECT nama_sembako, stok, id FROM tbl_sembako join view_stok on tbl_sembako.id=view_stok.sembako_id WHERE stok > 0";
		$data = [
			'sembako' => $this->db->query($query)
		];
		$this->load->view('transaksi/index', $data);
	}


	function showCarts()
	{
		echo $this->show_cart();
	}

	function show_cart()
	{ //Fungsi untuk menampilkan Cart
		$output = '';
		$no     = 0;
		foreach ($this->cart->contents() as $items) {
			$no++;
			// echo '<pre>';
			// print_r($items);
			// die();
			$output .= '
				<tr>
				<td>' . $items['name'] . ' </td>
				<td class="text-center">
				<a href="#" data-id="' . $items['id'] . '"           
				class="tambahCart  text-white btn btn-primary btn-sm rounded-circle"><i class="fas fa-plus"></i></a>
				&nbsp; ' . $items['qty'] . ' &nbsp;  <a href="#" data-id="' . $items['rowid'] . '" 
				class="kurangCart  text-white rounded-circle btn btn-primary btn-sm"><i class="fas fa-minus"></i></a>
				</td>
				<td>' . $items['price'] . '</td> 
				<td>
				';
			// $CekStokDB = $this->db->select('product_id, stok')->where('product_id', $items['id'])->get('tbl_product_list')->row()->stok;
			$CekStokDB = $this->db->query("SELECT item_masuk - item_jual - item_keluar as stok,sembako_id FROM view_sembako_sumary WHERE sembako_id=" . $items['id'] . "")->row()->stok;

			$output .= '' . $CekStokDB . ' </td><td>' . $items['subtotal'] . ' </td>   
		<td><a href="#" data-id="' . $items['rowid'] . '"           
		class="hapusCart  text-white btn btn-danger btn-sm rounded-circle"><i class="far fa-trash-alt"></i></a></td>
		</tr>
			   ';
		}
		return $output;
	}

	function search($array, $key, $value)
	{
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$results[] = $array;
			}

			foreach ($array as $subarray) {
				$results = array_merge($results, $this->search($subarray, $key, $value));
			}
		}

		return $results;
	}


	function tambahCart()
	{
		$post = $this->input->post(null, true);
		$id = $post['id'];
		// $item = $this->db->select('harga_setelah_diskon, nama, product_id, stok')->where('product_id', $id)->get('tbl_product_list')->row();
		// echo '<pre>';
		$item = $this->db->query("SELECT nama_sembako, harga_jual,id FROM tbl_sembako WHERE id=" . $id . "")->row();
		$stok = $this->db->query("SELECT item_masuk - item_jual - item_keluar as stok FROM view_sembako_sumary where sembako_id=" . $post['id'] . "")->row();
		$try = $this->cart->contents();
		// print_r($try);
		// die();
		$cekArray = $this->search($try, 'id', $id);
		// print_r();
		if ($stok == '0') {
			echo $this->show_cart() . '<script>alert("Mohon untuk mengecek stok karena stok tersebut 0")</script>';
		} else {
			if ($cekArray) {
				if ($stok->stok >  $cekArray[0]['qty']) {
					$data = array(
						'id'          => $id,
						'price'       => $item->harga_jual,
						'name'        => $item->nama_sembako,
						'qty'         => 1,
					);
					$this->cart->insert($data);
					echo $this->show_cart();
				} else {
					echo $this->show_cart() . '<script>alert("Mohon untuk mengecek stok")</script>';
				}
			} else {
				$data = array(
					'id'          => $item->id,
					'price'       => $item->harga_jual,
					'name'        => $item->nama_sembako,
					'qty'         => 1,
				);
				$this->cart->insert($data);
				echo $this->show_cart();
			}
		}
	}

	function clear()
	{
		$this->cart->destroy();
		echo $this->show_cart();
	}

	function kurangCart()
	{
		$idarray = $this->input->post('id');
		$try = $this->cart->get_item($idarray);

		$qty     = $try['qty'] - 1;
		$data   = array(
			'rowid' => $idarray,
			'qty'   => $qty,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}

	function hapusCart()
	{
		$idarray = $this->input->post('id');
		$try = $this->cart->get_item($idarray);

		$qty     = $try['qty'] * 0;
		$data   = array(
			'rowid' => $idarray,
			'qty'   => $qty,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}

	function showHarga()
	{
		echo $this->cart->total();
	}

	function bayar()
	{
		$post = $this->input->post(null, true);
		$dataInsert = [
			'total_harga_jual' => $this->cart->total(),
			'status_id' => '1',
			'add_date' => date('Y-m-d H:i:s'),
		];
		// $this->crud_m->insert_model($table = 'tbl_trx_list', $data);
		$this->db->insert('tbl_penjualan', $dataInsert);
		$id = $this->db->insert_id();
		if ($this->db->affected_rows() > 0) {
			$try = $this->cart->contents();
			foreach ($try as $key => $items) {
				$itemQTY = $items['qty'];
				$itemID = $items['id'];
				$ngambilSembakoID = $this->db->query("SELECT harga_jual, harga_modal FROM tbl_sembako WHERE id=" . $itemID . "")->row();

				$dataDetailProduct[] = [
					'penjualan_id' => $id,
					'sembako_id' =>  $itemID,
					// 'product_name' =>  $items['name'],
					'harga_jual_satuan' => $items['price'],
					'harga_modal_satuan' => $ngambilSembakoID->harga_modal,
					'harga_modal_total' => $ngambilSembakoID->harga_modal * $itemQTY,
					// 'total' => $items['subtotal'],
					'qty' => $itemQTY,
					// 'status' => '1',
					// 'addid'           => $this->session->userdata('nama'),
					'add_date' => date('Y-m-d H:i:s'),
				];

				$dataSembakoKeluar = [
					'sembako_id' => $itemID,
					'jenis' => 'jual',
					'qty' => $itemQTY,
					'add_date' => date('Y-m-d H:i:s'),
					'note' => 'Sembako terjual'
				];

				$this->db->insert('tbl_sembako_masuk_keluar', $dataSembakoKeluar);

				//INSERT STOK
				// $mencariStok = $this->db->select('product_id, stok')->where('product_id', $itemID)->get('tbl_product_list')->row();
				// print_r($itemQTY);
				// $menempelkanStokProduct = [
				// 'stok' => $mencariStok->stok - $itemQTY
				// ];
				// die();
				// $this->crud_m->update_model($table = 'tbl_product_list', $category = 'product_id', $idnya = $itemID, $menempelkanStokProduct);
				// $this->db->where('product_id', $itemID)->update('tbl_product_list', $menempelkanStokProduct);
			}


			foreach ($dataDetailProduct as $item) {
				$insert_query = $this->db->insert_string('tbl_penjualan_detail', $item);
				$insert_query = str_replace('INSERT INTO', 'INSERT INTO', $insert_query);
				$this->db->query($insert_query);
			}

			if ($this->db->affected_rows() > 0) {

				$updateHargaModal = $this->db->query("SELECT SUM(harga_modal_total) as harga FROM tbl_penjualan_detail WHERE penjualan_id=" . $id . "")->row();
				$updateHargaUpdate = [
					'total_harga_modal' => $updateHargaModal->harga
				];
				$this->db->where('id', $id)->update('tbl_penjualan', $updateHargaUpdate);

				$this->cart->destroy();
				$massage['status'] = true;
				echo json_encode($massage);
			} else {
				echo '<script>alert("error insert");</script>';
				$massage['status'] = false;
				echo json_encode($massage);
			}
		}
	}

	function listProduct()
	{
		$post = $this->input->post(null, true);

		$stok = $this->db->query("SELECT item_masuk - item_jual - item_keluar as stok FROM view_sembako_sumary where sembako_id=" . $post['id'] . "")->row();
		$harga = $this->db->query("SELECT id,harga_jual FROM tbl_sembako WHERE id=" . $post['id'] . "")->row();

		$output = false;
		$output .= '<div class="form-group">';
		$output .= '<label for="">STOK</label>';
		$output .= '<input type="number" class="form-control stok" value="' . $stok->stok . '" readonly>';
		$output .= '</div"><br>';
		$output .= '<div class="form-group">';
		$output .= '<label for="">HARGA</label>';
		$output .= '<input type="number" class="form-control " value="' . $harga->harga_jual . '" readonly>';
		$output .= '</div">';
		echo $output;
	}

	function history()
	{
		$post = $this->input->post(null, true);
		$query = false;
		$query = "SELECT * FROM tbl_penjualan";

		$query1 = false;

		$query1 = "SELECT SUM(total_harga_jual) as total_harga_jual, SUM(total_harga_modal) as total_harga_modal, SUM(total_harga_jual) - SUM(total_harga_modal) as keuntungan   from tbl_penjualan GROUP BY status_id";


		if (isset($post['asambit'])) {
			$query = "SELECT * FROM tbl_penjualan WHERE DATE(add_date) BETWEEN '" . $post['tanggalAwal'] . "' AND '" . $post['tanggalAkhir'] . "'";
			$query1 = "SELECT SUM(total_harga_jual) as total_harga_jual, SUM(total_harga_modal) as total_harga_modal, SUM(total_harga_jual) - SUM(total_harga_modal) as keuntungan FROM tbl_penjualan WHERE DATE(add_date) BETWEEN '" . $post['tanggalAwal'] . "' AND '" . $post['tanggalAkhir'] . "' ";
		}

		$data = [
			'tabel' => $this->db->query($query)->result(),
			'tabel_total' => $this->db->query($query1)->result()

		];
		$this->load->view('transaksi/laporan', $data);
	}

	function margin()
	{
		$post = $this->input->post(null, true);

		$query1 = false;

		$query1 = "SELECT SUM(total_harga_jual) as total_harga_jual, SUM(total_harga_modal) as total_harga_modal, SUM(total_harga_jual) - SUM(total_harga_modal) as keuntungan   from tbl_penjualan GROUP BY status_id";

		if (isset($post['asambit'])) {

			$query1 = "SELECT SUM(total_harga_jual) as total_harga_jual, SUM(total_harga_modal) as total_harga_modal, SUM(total_harga_jual) - SUM(total_harga_modal) as keuntungan FROM tbl_penjualan WHERE DATE(add_date) BETWEEN '" . $post['tanggalAwal'] . "' AND '" . $post['tanggalAkhir'] . "' ";
		}

		$data = [

			'tabel_total' => $this->db->query($query1)->result()
		];
		$this->load->view('transaksi/margin', $data);
	}

	function detailData()
	{
		$post = $this->input->post(null, true);
		$this->load->view('transaksi/detail', ['tabel' => $this->db->where('penjualan_id', $post['id'])->join('tbl_sembako', 'tbl_sembako.id=tbl_penjualan_detail.sembako_id')->get('tbl_penjualan_detail')->result()]);
	}

	function printDetail($id)
	{
		$query2 = $this->db->where('id', $id)->get('tbl_penjualan')->row();
		$query1 = $this->db->where('penjualan_id', $id)->join('tbl_sembako', 'tbl_sembako.id=tbl_penjualan_detail.sembako_id')->get('tbl_penjualan_detail')->result();
		$this->load->view('transaksi/print', ['detail' => $query1, 'bukanDetail' => $query2]);
	}
}