<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;
use App\Models\ModelSetting;

class User extends BaseController
{
     protected $ModelUser;
    protected $ModelSetting;
    public function __construct() {
        $this->ModelUser = new ModelUser();
        $this->ModelSetting = new ModelSetting();
    }   
    public function index()
    {
        $data = [
            'judul' => 'User',
            'menu' => 'user',
            'page' => 'user/v_index',
            'user'=> $this->ModelUser->AllData(),
            
        ];
        return view('v_template_back_end', $data);
    }
    public function Input()
    {
        $data = [
            'judul' => 'Input User' ,
            'menu' => 'user' ,
            'page' => 'user/v_input',
            'user'=> $this->ModelUser->AllData(),
            'web' => $this-> ModelSetting->web(),
        ];
        return view('v_template_back_end', $data);
    }
     public function InsertData()
    {
        if ($this->validate([
            'nama_user' => [
                'label' => 'Nama user',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!!'
                ]
            ],
            'email' => [
                'label' => 'email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi!!'
                ]
            ],
            'password' => [
            'label' => 'password',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!!'
             ]
            ],
            'foto' => [
            'label' => 'Foto user',
            'rules' => 'uploaded[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
            'uploaded' => '{field} wajib diisi!!',
            'max_size' => 'Ukuran {field} maksimal 2MB!',
            'mime_in' => 'Jenis {field} harus jpg, jpeg, atau png!'
                ]
            ],
           

        ])) {
            $foto= $this->request->getFile('foto');
            $nama_file_foto = $foto->getRandomName();
            // Data valid, lakukan penyimpanan ke database
            $data = [
                'nama_user' => $this->request->getPost('nama_user'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'foto' => $nama_file_foto
                
            ];

            $foto->move('foto', $nama_file_foto);
            $this->ModelUser->InsertData($data); // Pastikan method ini ada di ModelSekolah
            session()->setFlashdata('insert', 'Data wilayah berhasil di tambahkan.');
            return redirect()->to('User');
        } else {
            // Validasi gagal
            // Jika validasi gagal
        session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
        return redirect()->to('User/Input')->withInput()->with('errors', \Config\Services::validation()->getErrors());

        }
    }

     public function Edit($id_user)
    {
        $data = [
            'judul' => 'Edit User' ,
            'menu' => 'user' ,
            'page' => 'user/v_edit',
            'user'=> $this->ModelUser->DetailData(id_user: $id_user),
        
        ];
        return view('v_template_back_end', $data);
    }

   public function UpdateData($id_user)
{
    if ($this->validate([
        'nama_user' => [
            'label' => 'Nama user',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!!'
            ]
        ],
        'email' => [
            'label' => 'email',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!!'
            ]
        ],
        'password' => [
            'label' => 'password',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} wajib diisi!!'
            ]
        ],
        // Foto tidak wajib, hanya dicek kalau ada
        'foto' => [
            'label' => 'Foto user',
            'rules' => 'if_exist|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Ukuran {field} maksimal 2MB!',
                'mime_in'  => 'Jenis {field} harus jpg, jpeg, atau png!'
            ]
        ],
    ])) {
        $user = $this->ModelUser->DetailData($id_user);
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama (jika ada)
            if ($user['foto'] && file_exists('foto/' . $user['foto'])) {
                unlink('foto/' . $user['foto']);
            }
            $nama_file_foto = $foto->getRandomName();
            $foto->move('foto', $nama_file_foto);
        } else {
            // Tidak ada foto baru → pakai yang lama
            $nama_file_foto = $user['foto'];
        }

        $data = [
            'id_user'   => $id_user,
            'nama_user' => $this->request->getPost('nama_user'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'foto'      => $nama_file_foto
        ];

        $this->ModelUser->UpdateData($data);
        session()->setFlashdata('update', 'Data user berhasil di update.');
        return redirect()->to('User');
    } else {
        session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
        return redirect()->to('User/Edit/'.$id_user)->withInput();
    }
}


  public function Delete($id_user)
{
    $user = $this->ModelUser->DetailData($id_user);
    if ($user['foto'] <> '') {
        unlink('foto/' . $user['foto']);
    }
    $data = [
        'id_user' => $id_user ,
    ];

    $this->ModelUser->DeleteData($data);
    session()->setFlashdata('delete', 'Data user berhasil di HAPUS!!!!.');
    return redirect()->to('User');
}


    
    
    
}