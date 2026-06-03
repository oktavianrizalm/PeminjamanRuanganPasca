<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Peminjaman');
    }

    public function index() {
        $data['jadwal'] = $this->M_Peminjaman->get_jadwal_mendatang();
        $this->load->view('dashboard', $data);
    }

    public function pinjam() {
        if ($this->input->method() === 'post') {
            $data = [
                'nama_ruangan' => $this->input->post('nama_ruangan'),
                'nama_peminjam' => $this->input->post('nama_peminjam'),
                'no_telp' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'kegiatan' => $this->input->post('kegiatan'),
                'tanggal' => $this->input->post('tanggal'),
                'waktu_mulai' => $this->input->post('waktu_mulai'),
                'waktu_selesai' => $this->input->post('waktu_selesai'),
                'status' => 'Disetujui'
            ];

            if ($this->M_Peminjaman->check_overlap($data['nama_ruangan'], $data['tanggal'], $data['waktu_mulai'], $data['waktu_selesai'])) {
                $this->session->set_flashdata('error', 'Ruangan ' . $data['nama_ruangan'] . ' sudah ada yang pakai pada jam tersebut. Cek jadwal!');
                redirect('pinjam');
            }

            if ($this->M_Peminjaman->insert_jadwal($data)) {
                $this->session->set_flashdata('success', 'Jadwal berhasil ditambahkan!');
                redirect(''); // kembali ke dashboard
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data.');
                redirect('pinjam');
            }
        } else {
            $data['jadwal'] = $this->M_Peminjaman->get_jadwal_mendatang();
            $this->load->view('pinjam', $data);
        }
    }

    public function history() {
        $data['history'] = $this->M_Peminjaman->get_all_jadwal();
        $this->load->view('history', $data);
    }

    public function delete() {
        if ($this->input->method() === 'post') {
            $authCode = $this->input->post('auth_code');
            if ($authCode !== '@Lebak123') {
                echo json_encode(['success' => false, 'error' => 'Akses ditolak: Kode akses tidak valid']);
                return;
            }

            $id = $this->input->post('id');
            if ($this->M_Peminjaman->delete_jadwal($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Gagal menghapus jadwal']);
            }
        }
    }

    public function edit() {
        if ($this->input->method() === 'post') {
            $authCode = $this->input->post('auth_code');
            if ($authCode !== '@Lebak123') {
                echo json_encode(['success' => false, 'error' => 'Akses ditolak: Kode akses tidak valid']);
                return;
            }

            $id = $this->input->post('id');
            $data = [
                'nama_ruangan' => $this->input->post('nama_ruangan'),
                'nama_peminjam' => $this->input->post('nama_peminjam'),
                'no_telp' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'kegiatan' => $this->input->post('kegiatan'),
                'tanggal' => $this->input->post('tanggal'),
                'waktu_mulai' => $this->input->post('waktu_mulai'),
                'waktu_selesai' => $this->input->post('waktu_selesai')
            ];

            if ($this->M_Peminjaman->check_overlap($data['nama_ruangan'], $data['tanggal'], $data['waktu_mulai'], $data['waktu_selesai'], $id)) {
                echo json_encode(['success' => false, 'error' => 'Ruangan sudah dipakai pada jam tersebut.']);
                return;
            }

            if ($this->M_Peminjaman->update_jadwal($id, $data)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Gagal mengupdate jadwal']);
            }
        }
    }
}
