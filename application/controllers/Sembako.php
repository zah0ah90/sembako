<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sembako extends CI_Controller
{

    public function index()
    {
        $data = [
            // 'table' => $this->db->query()
        ];
        $this->load->view('sembako/index');
    }
}