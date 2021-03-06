<?php

namespace App\Controllers;

class Tugas extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

	public function Index()
	{
        $tugasModel = new \App\Models\TugasModel();
        $idsiswa = $this->session->get('id');

		return view('Tugas/Index', [
            'pagedata' => [
                'name' => 'tugas',
                'title' => 'Daftar Tugas'
            ],
            'tugass' => [
                'running' => $tugasModel->listing($idsiswa),
                'completed' => $tugasModel->listCompleted($idsiswa)
            ]
        ]);
	}

    public function View()
    {
        $id = $this->request->uri->getSegment(3);
        $tugasModel = new \App\Models\TugasModel();
        $tugas = $tugasModel->find($id);
        $tugasid = $tugas->id;
        if($this->request->uri->getSegment(4) == 'Admin')
        {
            return view('Tugas/Edit', [
                'pagedata' => [
                    'name' => 'tugas',
                    'title' => "Tugas #$tugasid Admin"
                ],
                'tugas' => $tugas
            ]);
        }
        
        if($this->session->get('privilege') == 1)
        {
            $userid = $this->request->uri->getSegment(5);
        } else {
            $userid = $this->session->get('id');
        }

        return view('Tugas/View', [
            'pagedata' => [
                'name' => 'tugas',
                'title' => "Tugas #$tugasid"
            ],
            'tugas' => [
                'quest' => $tugas,
                'answer' => $tugasModel->tugasAnswer($id, $userid)
            ]
        ]);
    }

    public function Tambah()
    {
        if($this->request->getPost())
        {
            $data = $this->request->getPost();
            $this->validation->run($data, 'tambahTugas');
            $errors = $this->validation->getErrors();
            if(!$errors)
            {
                $tugas = new \App\Entities\Tugas();
                $tugasModel = new \App\Models\TugasModel();
                $timelimit_date = $data['timelimit_date'];
                $timelimit_time = $data['timelimit_time'];
                $data['time_limit'] = date('Y:m:d H:i:s', strtotime("$timelimit_date $timelimit_time"));
                $tugas->fill($data);
                $tugasModel->save($tugas);
                return redirect()->to(site_url('Tugas'));
            }
            $this->session->setFlashdata('errors', $errors);
        }
        $kelasModel = new \App\Models\KelasModel();
        return view('Tugas/Tambah', [
            'pagedata' => [
                'name' => 'tugas',
                'title' => 'Tambah Tugas'
            ],
            'data' => [
                'kelass' => $kelasModel->index($this->session->get('id'))
            ]
        ]);
    }

    public function SubmitTugas()
    {
        if($this->request->getPost())
        {
            $siswaTugasModel = new \App\Models\SiswaTugasModel();
            $siswatugas = new \App\Entities\SiswaTugas();
            $data = $this->request->getPost();
            $siswatugas->fill($data);
            $siswatugas->user_id = $this->session->get('id');
            $siswatugas->tugas_id = $this->request->uri->getSegment(3);
            if($this->request->getFile('attachment')->getName())
            {
                $siswatugas->filename = $this->request->getFile('attachment')->getName();
                $siswatugas->setAttachment($this->request->getFile('attachment'));
            } else {
                $siswatugas->filename = 'Tidak ada lampiran';
                $siswatugas->attachment = '';
            }
            $siswaTugasModel->save($siswatugas);
            $id = $siswaTugasModel->insertID();
            $segments = ['Tugas', 'View', $this->request->uri->getSegment(3)];
            return redirect()->to(site_url($segments));
        }
        echo 'Something went wrong';
    }

    public function Update()
    {
        if($this->request->getPost())
        {
            $data = $this->request->getPost();
            $id = $data['id'];
            $this->validation->run($data, 'tambahTugas');
            $errors = $this->validation->getErrors();
            if(!$errors)
            {
                $tugasEdit = new \App\Entities\Tugas();
                $tugasModel = new \App\Models\TugasModel();
                $timelimit_date = $data['timelimit_date'];
                $timelimit_time = $data['timelimit_time'];
                $data['time_limit'] = date('Y:m:d H:i:s', strtotime("$timelimit_date $timelimit_time"));
                $tugasEdit->fill($data);
                $tugasEdit->id = $id;
                $tugasModel->save($tugasEdit);
                $segments = ['Tugas', 'View', $id];
                return redirect()->to(site_url($segments));
            }
        }
        return redirect()->to(site_url('Tugas'));
    }

    public function Delete()
    {
        $id = $this->request->uri->getSegments(3);
        $tugasModel = new \App\Models\TugasModel();
        $delete = $tugasModel->delete($id);
        return redirect()->to(site_url('Tugas/Index'));
    }
}