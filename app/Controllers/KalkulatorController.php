<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KalkulatorModel;
use CodeIgniter\HTTP\ResponseInterface;

class KalkulatorController extends BaseController
{
    protected $kalkulatorModel;

    public function __construct() //inisiasi model
    {
        $this->kalkulatorModel = new KalkulatorModel();
    }

    public function index() //menampilkan data history kalkulasi dan tambah data ke database
    {
        $data = [];

        if ($this->request->getMethod() === 'post') {
            // Jika form dikirimkan, lakukan perhitungan dan simpan ke database
            $num1 = $this->request->getPost('num1');
            $num2 = $this->request->getPost('num2');
            $operator = $this->request->getPost('operator');

            $hasil = $this->proses($num1, $num2, $operator); //memproses input dengan memanggil func proses

            // Simpan hasil perhitungan ke dalam database
            $this->kalkulatorModel->save([
                'num1' => $num1,
                'num2' => $num2,
                'operator' => $operator,
                'hasil' => $hasil,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $data['hasil'] = $hasil;
        }

        // Ambil semua data dari tabel kalkulators
        $data['calculations'] = $this->kalkulatorModel->findAll();

        return view('kalkulator_view', $data);
    }

    private function proses($num1, $num2, $operator) // menggunakan fungsi proses untuk melakukan perhitungan
    {
        switch ($operator) {
            case '+':
                return $num1 + $num2;
            case '-':
                return $num1 - $num2;
            case '*':
                return $num1 * $num2;
            case '/':
                return ($num2 != 0) ? $num1 / $num2 : 'undefined';
            case '%':
                return ($num2 != 0) ? $num1 % $num2 : 'undefined';
            default:
                return 'operator tidak valid';
        }
    }

    //melakukan reset hasil agar reload ke halaman sebelum dilakukan perhitungan
    public function resetHasil()
    {
        return redirect()->to(site_url('/'));
    }

    // Fungsi untuk mengupdate data
    public function update()
    {
        // Ambil data yang dikirimkan melalui form
        $id = $this->request->getPost('id');
        $num1 = $this->request->getPost('editNum1');
        $num2 = $this->request->getPost('editNum2');
        $operator = $this->request->getPost('editOperator');

        // Lakukan perhitungan berdasarkan nilai-nilai yang baru
        $hasil = $this->proses($num1, $num2, $operator); // menggunakan fungsi proses untuk melakukan perhitungan

        // Update data ke database
        $this->kalkulatorModel->update($id, [
            'num1' => $num1,
            'num2' => $num2,
            'operator' => $operator,
            'hasil' => $hasil
        ]);

        // Redirect atau tampilkan pesan sukses, dll.
        return redirect()->to(base_url('/'));
    }


    // Fungsi untuk menghapus data
    public function delete($id)
    {
        // Hapus data dari database berdasarkan ID
        $this->kalkulatorModel->delete($id);

        // Redirect atau tampilkan pesan sukses, dll.
        return redirect()->to(base_url('/'));
    }
}
