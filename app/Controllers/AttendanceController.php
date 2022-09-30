<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttendanceModel;
use App\Models\CategoryModel;
use App\Models\QRModel;
use CodeIgniter\Config\Services;

class AttendanceController extends BaseController
{
    protected $attendanceModel, $categoryModel, $qrModel, $session;
    public function __construct()
    {
        helper(['form']);
        $this->attendanceModel = new AttendanceModel();
        $this->categoryModel = new CategoryModel();
        $this->qrModel = new QRModel();
        $this->session = session();
    }

    public function index()
    {
        $attedance = $this->attendanceModel
            ->join('users', 'users.userId = attendances.user_id', 'left')
            ->findAll();

        $data = [
            'page' => 'attendance',
            'attendance' => $attedance,
        ];

        echo view('layouts/pages/attendance/index', $data);
    }

    // public function myPdfPage()
    // {
    //     $url = base_url('assets/your.pdf');
    //     $html = '<iframe src="' . $url . '" style="border:none; width: 100%; height: 100%"></iframe>';
    //     echo $html;
    // }

    public function getQrCode() {
        $today = date('Y-m-d');
        $qrToday =  $this->qrModel->where('DATE(created_at)', $today)->first();
        $data = [
            'qrToday' => $qrToday ? $qrToday['file'] : null
        ];

        echo view('layouts/pages/User/qrcode/index', $data);
    }

    public function permission()
    {
        $data = [
            'validation' => Services::validation(),
            'category' => $this->categoryModel->findAll()
        ];

        echo view('layouts/pages/User/permission/index', $data);
    }

    public function permissionSave()
    {
        helper(['form']);
        $rules = [
            'category' => 'required',
            'description' => 'required',
            // 'user_proof_file' => 'required',
        ];

        if ($this->validate($rules)) {

            $dataUserProofFile = $this->request->getFile('user_proof_file');
            $fileName = $dataUserProofFile->getRandomName();
            $dataUserProofFile->move('assets/media/berkas', $fileName);

            $data = [
                'user_id' => session()->get('id'),
                'category' => $this->request->getVar('category'),
                'description' => $this->request->getVar('description'),
                'user_proof_file' => $fileName,
                'is_logged_in' => TRUE,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->attendanceModel->save($data);

            // TBD
            session()->setFlashdata('success_absent', 'Permission submit successfully!');
            return redirect()->to('/user/absent');
        } else {
            $validation = Services::validation();
            return redirect()->to('/user/permission')->withInput()->with('validation', $validation);
        }
    }

    // public function permissionSave()
    // {
    //     helper(['form']);
    //     $rules = [
    //         'category' => 'required',
    //         'description' => 'required',
    //         'user_proof_file' => 'required',
    //     ];

    //     if ($this->validate($rules)) {
    //         $data = [
    //             'user_id' => session()->get('id'),
    //             'category' => $this->request->getVar('category'),
    //             'description' => $this->request->getVar('description'),
    //             'file' => $this->request->getVar('file'),
    //             'is_logged_in' => TRUE,
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];

    //         $this->attendanceModel->save($data);

    //         // TBD
    //         session()->setFlashdata('success_absent', 'Permission submit successfully!');
    //         return redirect()->to('/user/absent');
    //     } else {
    //         $validation = Services::validation();
    //         return redirect()->to('/user/permission')->withInput()->with('validation', $validation);
    //     }
    // }

    public function scanner()
    {
        $today = date('Y-m-d');
        $qrToday =  $this->qrModel->where('DATE(created_at)', $today)->first();

        $data = [
            'qrToday' => $qrToday['content'] ?? null,
        ];

        echo view('layouts/pages/User/scan/index', $data);
    }

    public function scannerSave()
    {
        helper(['form']);
        $data = [
            'user_id' => session()->get('id'),
            'is_logged_in' => TRUE,
            'category' => 'hadir',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->attendanceModel->save($data);

        return redirect()->to('/user');
    }
}
