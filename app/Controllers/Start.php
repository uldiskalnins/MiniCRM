<?php

namespace App\Controllers;

class Start extends BaseController
{


    public function index()
    {

        if (session()->has('userLogin')){
            if (session()->get('userLogin')){return redirect()->to(base_url('crm'));}
        }

        if (!file_exists(ROOTPATH.'installed')){return redirect()->to(base_url('install'));}


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.login');

        return view('default/head_part', $headData)
            .view('default/login.php');

    }


    public function login()
    {

        $usersModel = new \App\Models\UsersModel();

        $rules = [
                    'email' => [
                        'label' => 'email',
                        'rules' => 'required|valid_email',
                        'errors' => [
                            'required' => 'Install.invalidEmail',
                            'valid_email' => 'Install.invalidEmail',
                        ]
                    ],
                    'password' => [
                        'label' => '',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Install.invalidPass1',
                        ]
                    ],
                ];


        if ($this->request->is('post') AND $this->validate($rules))
        {

            $password = trim($this->request->getPost('password'));
            $email = trim($this->request->getPost('email'));


            try {
                $userData = $usersModel->getUserByEmail($email);
            }
            catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('error/db_connection_error/'));
            }


            if(!is_null($userData)):

                if (password_verify($password, $userData['password'])){

                    $settingsModel = new \App\Models\SettingsModel();

                    session()->set('userId', $userData['id']);
                    session()->set('userRights', $userData['user_rights']);
                    session()->set('userName', $userData['name']);
                    session()->set('userSurname', $userData['surname']);
                    session()->set('userEmail', $userData['email']);
                    session()->set('userLogin', true);
                    session()->set('langCode', $settingsModel->language);

                    return redirect()->to(base_url('crm/'));

                }
                else{session()->setFlashdata('error', lang('Crm.invalidPass'));}

            else:
                session()->setFlashdata('error', lang('Crm.invalidPass'));
            endif;
        }


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.login');

        return view('default/head_part', $headData)
            .view('default/login.php');

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

}
