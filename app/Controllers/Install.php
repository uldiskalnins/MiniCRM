<?php

namespace App\Controllers;

class Install extends BaseController
{

    public function index()
    {

        //pieslēdz datu bāzes modeli
        $usersModel = new \App\Models\UsersModel();

        //pārbauda vai ir norādīti datu bāzes parametri un ja nav pāradresē uz kļūdas paziņojumu
        if (!$this->checkDbSettings()){return redirect()->to(base_url('error/no_db_settings'));}

        //pārbauda vai ceļš ir rakstāms
        if (!is_writable(ROOTPATH.'')) {return redirect()->to(base_url('error/no_writable_path'));}

        //pārbauda vai lietotāju tabulā jau nav ieraksta
        if ( $this->checkUsersTable()){return redirect()->to(base_url('install/ok'));}
        else{ return redirect()->to(base_url());}

    }


    public function ok()
    {//veic instalāciju (admina lietotāja izveidošanu)

        //pārbauda vai lietotāju tabulā jau nav ierakstu
        if (!$this->checkUsersTable()){ return redirect()->to(base_url());}

        $usersModel = new \App\Models\UsersModel();


        $rules = [
                    'email' => [
                        'rules' => 'required|valid_email|is_unique[mc_users.email]',
                        'errors' => [
                            'required' => 'Install.invalidEmail',
                            'valid_email' => 'Install.invalidEmail',
                        ]
                    ],
                    'password' => [
                        'rules' => 'required|min_length[8]',
                        'errors' => [
                            'required' => 'Install.invalidPass1',
                            'min_length' => 'Install.invalidPass1',
                        ]
                    ],
                    'password2' => [
                        'rules' => 'required|matches[password]',
                        'errors' => [
                            'required' => 'Install.invalidPass2',
                            'matches' => 'Install.invalidPass2',
                        ]
                    ],
                    'name' => [
                        'rules' => 'required|max_length[100]',
                        'errors' => [
                            'required' => 'Install.invalidName',
                            'max_length' => 'Install.invalidName',
                        ]
                    ],
                    'surname' => [
                        'rules' => 'required|max_length[100]',
                        'errors' => [
                            'required' => 'Install.invalidSurname',
                            'max_length' => 'Install.invalidSurname',
                        ]
                    ],
                    'position' => [
                        'rules' => 'required|max_length[100]',
                        'errors' => [
                            'required' => 'Crm.invalidPosition',
                            'max_length' => 'Crm.invalidPosition',
                        ]
                    ]
                ];



        if ($this->request->is('post') && $this->validate($rules)){

            $userData = [
                'email' => $this->request->getPost('email'),
                'name' => $this->request->getPost('name'),
                'surname' => $this->request->getPost('surname'),
                'position' => $this->request->getPost('position'),
                'user_rights' => 0,
                'phone' => $this->request->getPost('phone'),
                'creation_date' => date("Y-m-d H:i:s"),
                'edit_date' => date("Y-m-d H:i:s"),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'active' => 1,
            ];

            $insertReturn = $usersModel->insert($userData, false);

            if($insertReturn){

                $this->createInstalFile();

                $data['locale'] = $this->request->getLocale();
                $data['adminEmail'] = $this->request->getPost('email');
                $data['adminPass'] = $this->request->getPost('password');

                return view('default/install/installed.php', $data);

            }

        }

        //veic datu bāzes tabulu izveidošanu
        try {
            $migrate = \Config\Services::migrations();
            $migrate->latest();
        }
        catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            //exit($e);
            return redirect()->to(base_url('error/db_connection_error/'));
        }

        $data['locale'] = $this->request->getLocale();
        return view('default/install/install.php', $data);
    }


    //veic pārbaudes, lai pārliecinātos, ka nav ierakstu lietotaju tabulā
    private function checkUsersTable()
    {
        $usersModel = new \App\Models\UsersModel();

        try
        {
            if($usersModel->usersTableExist()){
                $countUsers = $usersModel->countAllResults();
                if ($countUsers < 1){return True;}
                else{$this->createInstalFile(); return False;}
            }
            else {return True;}
        }
        catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to(base_url('error/db_connection_error/'));
        }

    }

    //pārbauda vai ir datu bāzes uzstādījumi
    private function checkDbSettings()
    {

        //$dbConfig = new \Config\Database();

        if ((empty(env('database.default.hostname'))) OR (empty(env('database.default.username'))) OR (empty(env('database.default.database'))))
        {
            return false;
        }
        else{return true;}
    }

    //izveido failu kas norāda, ka instalācija jau ir veikta
    private function createInstalFile()
    {
        helper('filesystem');
        return write_file(ROOTPATH.'installed', '1');
    }


}
