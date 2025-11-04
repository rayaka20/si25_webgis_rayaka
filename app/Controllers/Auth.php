<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAuth;

class Auth extends BaseController
{
    protected $ModelAuth;
    public function __construct()
    {
        $this->ModelAuth = new ModelAuth;
    }

    public function Login() 
    {
        $data = [
            'judul' => 'Login',
        ];
        return view('v_login', $data);
    }

    public function CekLogin()
    {
        if ($this->validate([
                'email' => [
                'label' => 'E-Mail',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
                ],
                'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
                ],
            ])) {
                //jika login
                $email = $this->request->getPost('email');
                $password = sha1($this->request->getPost('password'));
                $CekLogin = $this->ModelAuth->Login($email, $password);
                if ($CekLogin) {
                    #jika berhasil login
                    session()->set('nama_user', $CekLogin['nama_user']);
                    session()->set('foto', $CekLogin['foto']);
                    session()->set('login', 1);
                    return redirect()->to('Admin');
                } else {
                    #jika gagal login
                    session()->setFlashData('pesan', 'Email Atau Password Salah');
                    return redirect()->to('Auth/Login'); 
                }
            } else {
                //jika validasi gagal
                session()->setFlashData('errors', \Config\Services::validation()->getErrors());
                return redirect()->to('Auth/Login')->withInput();
            }
    }

    public function LogOut()
    {
        session()->remove('nama_user');
        session()->remove('foto');
        session()->remove('login');
        session()->setFlashData('logout', 'Anda Berhasil LogOut');
        return redirect()->to('Auth/Login');
    }
}