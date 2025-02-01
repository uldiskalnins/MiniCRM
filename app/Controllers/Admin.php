<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $helpers = ['crm_helper'];


    public function index()
    {

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.newUser');

        return view('default/head_part', $headData).view('default/admin/admin_home.php');
    }


    public function users()
    {
        $usersModel = new \App\Models\UsersModel();

        try {
            $data['users'] = $usersModel->findAll();
        }
        catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to(base_url('error/db_connection_error/'));
        }


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.newUser');

        return view('default/head_part', $headData).view('default/admin/list_users.php',$data);

    }



    public function newUser()
    {

        $usersModel = new \App\Models\UsersModel();


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.newUser');

        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[mc_users.email]',
                'errors' => [
                    'required' => 'Install.invalidEmail',
                    'valid_email' => 'Install.invalidEmail',
                    'is_unique' => 'Crm.registredEmail',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Install.invalidPass1',
                    'min_length' => 'Install.invalidPass1',
                ]
            ],
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Install.invalidName',
                    'max_length' => 'Install.invalidName',
                ]
            ],
            'phone' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Crm.invalidPhone',
                    'max_length' => 'Crm.invalidPhone',
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
            ],
            'rights' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Crm.invalidRights',
                    'numeric' => 'Crm.invalidRights',
                ]
            ],
        ];


       if ($this->request->is('post') && $this->validate($rules)){

            $userData = [
                'email' => $this->request->getPost('email'),
                'name' => $this->request->getPost('name'),
                'surname' => $this->request->getPost('surname'),
                'position' => $this->request->getPost('position'),
                'user_rights' => $this->request->getPost('rights'),
                'phone' => $this->request->getPost('phone'),
                'creation_date' => date("Y-m-d H:i:s"),
                'edit_date' => date("Y-m-d H:i:s"),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'active' => 1,
            ];

            $saveUser = $usersModel->save($userData);

            if($saveUser){

                $data['newUser'] = [
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'name' => $this->request->getPost('name'),
                    'surname' => $this->request->getPost('surname'),
                    'position' => $this->request->getPost('position'),
                    'rights' => lang('Crm.rightsLevelsWords')[array_search($this->request->getPost('rights'), (array) lang('Crm.rightsLevelsNumbers'))],
                ];

                return view('default/head_part', $headData).view('default/admin/user_created.php', $data);

            }
            else{session()->setFlashdata('error', 'Crm.error'); }

        }


        return view('default/head_part', $headData).view('default/admin/new_user.php');

    }

    public function editUser($getUserId)
    {
    

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.newUser');

        $usersModel = new \App\Models\UsersModel();

        $data['user'] = $usersModel->find($getUserId);


        if(!is_array($data['user'])){return redirect()->to(base_url('admin/users'));}


        $rules = [
            'email' => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'Install.invalidEmail',
                    'valid_email' => 'Install.invalidEmail',
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
            ],
            'rights' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Crm.invalidRights',
                    'numeric' => 'Crm.invalidRights',
                ]
            ],
            'active' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Crm.error',
                    'numeric' => 'Crm.error',
                ]
            ],
        ];



        if ($this->request->is('post') AND $this->validate($rules)){

            $userData = [
                'email' => $this->request->getPost('email'),
                'name' => $this->request->getPost('name'),
                'surname' => $this->request->getPost('surname'),
                'position' => $this->request->getPost('position'),
                'user_rights' => $this->request->getPost('rights'),
                'phone' => $this->request->getPost('phone'),
                'id' => $getUserId,
                'edit_date' => date("Y-m-d H:i:s"),
                'active' => $this->request->getPost('active'),
            ];


            if(!empty($this->request->getPost('password'))){ 
                $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

           if($usersModel->save($userData))
           {
                session()->setFlashdata('message', lang('Crm.actionOk'));
                return redirect()->to(base_url('admin/users'));
           }

        }



        return view('default/head_part', $headData).view('default/admin/edit_user.php', $data);


    }

    public function crmSettings()
    {


        $settingsModel = new \App\Models\SettingsModel();
        $crmModel = new \App\Models\CrmModel();

        $data['allowToSeeOtherUsersRecords'] = $settingsModel->allowToSeeOtherUsersRecords;

        $appSettings =  new \Config\App();

        $data['supportedLocales'] = $appSettings->supportedLocales;
        $data['crmLang'] = $settingsModel->language;



        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.crmSettings');

        return view('default/head_part', $headData).view('default/admin/crm_settings.php',$data);




    }


    public function emailsettings()
    {


        $settingsModel = new \App\Models\SettingsModel();


        $rules = [
            'smtpprotocol' => [
                'rules' => 'in_list[0,1]|permit_empty',
                'errors' => [
                    'in_list' => 'Crm.smtpProtocolError',
                ]
            ],
            'smtpserver' => [
                'rules' => 'valid_url|max_length[100]|permit_empty',
                'errors' => [
                    'valid_url' => 'Crm.smtpHostError',
                    'max_length' => 'Crm.smtpHostError',
                ]
            ],
            'smtpuser' => [
                'rules' => 'string|max_length[100]|permit_empty',
                'errors' => [
                    'string' => 'Crm.smtpUserError',
                    'max_length' => 'Crm.smtpUserError',
                ]
            ],
            'smtppass' => [
                'rules' => 'string|max_length[300]|permit_empty',
                'errors' => [
                    'string' => 'Crm.smtpPassError',
                    'max_length' => 'Crm.smtpPassError',
                ]
            ],
            'smtpport' => [
                'rules' => 'integer|max_length[5]|permit_empty',
                'errors' => [
                    'integer' => 'Crm.smtpPortError',
                    'max_length' => 'Crm.smtpPortError',
                ]
            ],
            'smtpcrypto' => [
                'rules' => 'alpha|max_length[3]|permit_empty',
                'errors' => [
                    'alpha' => 'Crm.smtpCryptoError',
                    'max_length' => 'Crm.smtpCryptoError',
                ]
            ],
        ];



        if ($this->request->is('post'))
        {

            if (!$this->validate($rules)) {
                session()->setFlashdata('error', \Config\Services::validation()->listErrors());
                return redirect()->to(base_url('admin/email-settings'));
            }

            $data = [
                ['setting' => "smtpServer",'value' => $this->request->getPost('smtpserver')],
                ['setting' => "smtpUser",'value' => $this->request->getPost('smtpuser')],
                ['setting' => "smtpPass",'value' => $this->request->getPost('smtppass')],
                ['setting' => "smtpPort",'value' => $this->request->getPost('smtpport')],
                ['setting' => "smtpEncryption",'value' => $this->request->getPost('smtpcrypto')],
                ['setting' => "useSmtp",'value' => $this->request->getPost('smtpprotocol')],
            ];



            if($settingsModel->updateBatch($data, 'setting'))
            {
                session()->setFlashdata('message', lang('Crm.actionOk'));
                return redirect()->to(base_url('admin/email-settings/'));

            }
            else
            {
                session()->setFlashdata('error', lang('Crm.error'));
                return redirect()->to(base_url('admin/email-settings'));
            }

        }


        $data['useSmtp']     = $settingsModel->useSmtp;
        $data['SMTPHost']    = $settingsModel->smtpServer;
        $data['SMTPUser']    = $settingsModel->smtpUser;
        $data['SMTPPass']    = $settingsModel->smtpPass;
        $data['SMTPPort']    = $settingsModel->smtpPort;
        $data['SMTPCrypto']  = $settingsModel->smtpEncryption;

        

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.controlPanel').' - '.lang('Crm.crmSettings');

        return view('default/head_part', $headData).view('default/admin/admin_email_settings.php',$data);


    }


    public function settings()
    {

        echo 'Settings';
 
        $migrate = \Config\Services::migrations();
        $migrate->latest();

    }









}
