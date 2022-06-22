<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sembako extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
    }

    public function index()
    {
        $query = 'SELECT *, (SELECT item_masuk - item_jual - item_keluar as stok FROM view_sembako_sumary WHERE sembako_id=id) as stok FROM tbl_sembako';
        $data = [
            'tabel' => $this->db->query($query)->result()
        ];
        $this->load->view('sembako/index', $data);
    }

    public function tambah()
    {
        $sembako = new StdClass();
        $sembako->id = null;
        $sembako->nama_sembako = null;
        $sembako->jenis_sembako = null;
        $sembako->tipe_sembako = null;
        $sembako->nama_agen = null;
        // $sembako->stok = null;
        $sembako->harga_jual = null;
        $sembako->harga_modal = null;

        $data = [
            'row' => $sembako,
            'page' => 'tambah'
        ];
        $this->load->view('sembako/form', $data);
    }

    public function edit($id)
    {
        $data = [
            'page' => 'edit',
            'row' => $this->db->where('id', $id)->get('tbl_sembako')->row()

        ];
        $this->load->view('sembako/form', $data);
    }


    public function process()
    {
        $post = $this->input->post(null, true);

        if ($post['nama_sembako']) {
            $data = [
                'nama_sembako' => $post['nama_sembako'],
                'jenis_sembako' => $post['jenis_sembako'],
                'tipe_sembako' => $post['tipe_sembako'],
                'nama_agen' => $post['nama_agen'],
                // 'qty' => $post['qty'],
                'harga_jual' => $post['harga_jual'],
                'harga_modal' => $post['harga_modal'],
            ];
            $add = [
                'add_date' => date('Y-m-d H:i:s')
            ];
            $upd = [
                'upd_date' => date('Y-m-d H:i:s'),
            ];
        }


        if ($post['opsi'] == 'tambah') {
            array_merge($data, $add);
            $this->db->insert('tbl_sembako', $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Berhasil di Tambah');
            }
        }
        if ($post['opsi'] == 'edit') {
            $id = [
                'id' => $post['id']
            ];
            array_merge($data, $upd, $id);
            $this->db->where('id', $post['id'])->update('tbl_sembako', $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Berhasil di Edit');
            }
        }

        if ($post['opsi'] == 'stok') {
            $dataJenis = [
                'sembako_id' => $post['id'],
                'qty' => $post['qty'],
                'jenis' => $post['jenis'],
                'note' => $post['note'],
                'add_date' => date('Y-m-d H:i:s')
            ];
            if ($post['jenis'] == 'masuk') {

                $this->db->insert('tbl_sembako_masuk_keluar', $dataJenis);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Berhasil di Edit');
                }
            } else if ($post['jenis'] == 'keluar') {
                if ($post['qty'] > $post['stok']) {
                    $this->session->set_flashdata('success', 'QTY tidak boleh melebihi STOK');
                } else {
                    $this->db->insert('tbl_sembako_masuk_keluar', $dataJenis);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('success', 'Berhasil di Edit');
                    }
                }
            }
        }

        redirect('sembako');
    }

    public function hapus($id)
    {
        $this->db->where('id', $id)->delete('tbl_sembako');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Berhasil di hapus');
        }
        redirect('sembako');
    }

    function tambah_stok($id)
    {
        $query = 'SELECT *, (SELECT item_masuk - item_jual - item_keluar as stok FROM view_sembako_sumary WHERE sembako_id=id) as stok FROM tbl_sembako WHERE id=' . $id;
        $data = [
            'row' => $this->db->query($query)->row(),
            'page' => 'stok'
        ];
        $this->load->view('sembako/tambah_sembako', $data);
    }

    function history()
    {
        $data = [
            'tabel' => $this->db->select('nama_sembako,jenis,qty,note,tbl_sembako_masuk_keluar.add_date')->from('tbl_sembako_masuk_keluar')->join('tbl_sembako', 'tbl_sembako.id=tbl_sembako_masuk_keluar.sembako_id', 'left')->get()->result()
        ];
        $this->load->view('history_sembako/index', $data);
    }
}