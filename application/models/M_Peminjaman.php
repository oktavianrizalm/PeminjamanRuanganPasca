<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Peminjaman extends CI_Model {

    public function get_all_jadwal() {
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('waktu_mulai', 'DESC');
        return $this->db->get('peminjaman_ruangan')->result_array();
    }

    public function get_jadwal_mendatang() {
        // Ambil jadwal mulai hari ini ke depan
        $today = date('Y-m-d');
        $this->db->where('tanggal >=', $today);
        $this->db->order_by('tanggal', 'ASC');
        $this->db->order_by('waktu_mulai', 'ASC');
        return $this->db->get('peminjaman_ruangan')->result_array();
    }

    public function insert_jadwal($data) {
        return $this->db->insert('peminjaman_ruangan', $data);
    }

    public function update_jadwal($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('peminjaman_ruangan', $data);
    }

    public function delete_jadwal($id) {
        $this->db->where('id', $id);
        return $this->db->delete('peminjaman_ruangan');
    }

    public function check_overlap($nama_ruangan, $tanggal, $waktu_mulai, $waktu_selesai, $exclude_id = NULL) {
        // Normalisasi nama ruangan
        $searchNames = [$nama_ruangan];
        if ($nama_ruangan === "R. LB 001") $searchNames = ["R. LB 001", "LB001"];
        else if ($nama_ruangan === "R. LB 002") $searchNames = ["R. LB 002", "LB002"];
        else if ($nama_ruangan === "R. LB 003") $searchNames = ["R. LB 003", "LB003", "Ruang Rapat"];

        $this->db->select('waktu_mulai, waktu_selesai');
        $this->db->where_in('nama_ruangan', $searchNames);
        $this->db->where('tanggal', $tanggal);
        if ($exclude_id !== NULL) {
            $this->db->where('id !=', $exclude_id);
        }
        $existing = $this->db->get('peminjaman_ruangan')->result_array();

        // Cek overlap di PHP
        foreach ($existing as $jadwal) {
            if ($waktu_mulai < $jadwal['waktu_selesai'] && $waktu_selesai > $jadwal['waktu_mulai']) {
                return true; // Overlap
            }
        }
        return false; // Aman
    }
}
