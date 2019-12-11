<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_perpus");
    }


    public function index()
    {
        echo "Ini API";
    }

    public function getKategori($id = null)
    {
        $data = []; //Karena berupa Array
        if ($id != null) {
            $data = $this->M_perpus->get_where(["id_kategori" => $id], "kategori")->first_row();
        } else {
            $data = $this->M_perpus->get_data("kategori")->result_array();
        }

        echo printJson(true, "Berhasil mendapatkan kategori", $data);
    }

    public function getBuku($id = null)
    {
        $data = []; //Karena berupa Array
        if ($id != null) {
            $data = $this->M_perpus->get_where(["id_buku" => $id], "buku")->first_row();
        } else {
            $q = $this->input->get("q");
            if ($q != null) {
                $data = $this->db->query("SELECT * From `buku` WHERE `buku`.`judul_buku` LIKE '%$q%'")->result_array();
            } else {
                $data = $this->M_perpus->get_data("buku")->result_array();
            }
        }
        echo printJson(true, "Berhasil mendapatkan buku", $data);
    }

    public function loginAnggota()
    {
        return $this->doLogin("anggota");
    }

    public function loginAdmin()
    {
        return $this->doLogin("admin");
    }

    private function doLogin($mode)
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if (($username == null || trim($username) == "") && ($password == null || trim($password) == ""))
            return printJson(false, "Username dan password tidak boleh kosong");

        $password = md5($password);
        $login = $this->M_perpus->get_where(["username" => $username, "password" => $password], $mode);
        if ($login->num_rows() > 0) {
            return printJson(true, "Berhasil login", $login->first_row());
        } else {
            return printJson(false, "Username atau password tidak sesuai");
        }
    }
}
