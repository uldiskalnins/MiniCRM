<?php

namespace App\Controllers\Crm;

use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Crm extends BaseController
{

    protected $helpers = ['crm_helper'];


    public function index()
    {


        $crmModel = new \App\Models\CrmModel();






        $data = array( );

        $headData['title'] = lang('Crm.crmTitle');

        return view('default/head_part', $headData)
            . view('default/crm/crm_home.php', $data)
            . view('default/footer_part.php');
    }




    public function user($userId)
    {

        $usersModel = new \App\Models\UsersModel();
        $user = $usersModel->find($userId);

        if (!is_array($user)) {
            return redirect()->to(base_url('admin/users'));
        }

        $data['user'] = $user;


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . $user['name'] . ' ' . $user['surname'];

        return view('default/head_part', $headData)
            . view('default/crm/crm_user_profile.php', $data)
            . view('default/footer_part.php');
    }
    public function editUser()
    {

        $usersModel = new \App\Models\UsersModel();
        $user = $usersModel->find(session()->get('userId'));

        if (!is_array($user)) {
            return redirect()->to(base_url('admin/users'));
        }

        $data['user'] = $user;


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . $user['name'] . ' ' . $user['surname'];

        return view('default/head_part', $headData)
            . view('default/crm/crm_edit_user.php', $data)
            . view('default/footer_part.php');
    }

    public function saveUser()
    {
        $usersModel = new \App\Models\UsersModel();

        $rules = [
            'email' => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'Install.invalidEmail',
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[8]|max_length[100]',
                'errors' => [
                    'required' => 'Install.invalidPass1',
                    'min_length' => 'Install.invalidPass1',
                ]
            ],
            'password2' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'required' => 'Install.invalidPass2',
                    'matches' => 'Install.invalidPass2',
                ]
            ],
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Crm.invalidNameSurname',
                    'max_length' => 'Crm.invalidNameSurname',
                ]
            ],
            'surname' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Crm.invalidNameSurname',
                    'max_length' => 'Crm.invalidNameSurname',
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

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list'));
            return redirect()->to(base_url('crm/user/') . session()->get('userId'));
        }

        $userData = [
            'email' => $this->request->getPost('email'),
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'position' => $this->request->getPost('position'),
            'phone' => $this->request->getPost('phone'),
            'edit_date' => date("Y-m-d H:i:s"),
        ];

        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }


        if ($usersModel->update(session()->get('userId'), $userData)) {
            return redirect()->to(base_url('crm/user/') . session()->get('userId'));
        } else {
            session()->setFlashdata('error', lang('Crm.error'));
            return redirect()->to(base_url('crm/user/') . session()->get('userId'));
        }
    }

    public function deleteRecord($id, $type)
    {

        // Modeļu izvēle pēc $type
        $models = [
            1 => \App\Models\CompaniesModel::class,
            2 => \App\Models\PersonsModel::class,
            3 => \App\Models\LeadsModel::class,
            8 => \App\Models\OpportunitiesModel::class,
        ];


        //atgriešanās vieta
        $returnTo = [
            1 => 'crm/companies/',
            2 => 'crm/persons/',
            3 => 'crm/leads/',
            8 => 'crm/opportunities/',
        ];


        if (!isset($models[$type])) {return redirect()->to(base_url('crm/'));}
        if (!isset($returnTo[$type])) { return redirect()->to(base_url('crm/'));}


        $model = new $models[$type]();
        $entityData = $model->where('id', $id)->get()->getRow();

        // Pārbauda lietotāja tiesības rediģēt
        if (!allowedToEdit($entityData->user_id)) 
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable'));
            return redirect()->to(base_url('crm/'));
        }

        // Activ statusa maiņa
        $update['active'] = empty($entityData->active) ? 1 : 0;
        if ($entityData->active == 0 && !userAdmin()) 
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable'));
            return redirect()->to(base_url('crm/'));
        }

        // Datu atjaunināšana un pāradresācija
        if ($model->update($id, $update)) 
        {
            $actionHistoryLog = new ActionHistoryLibrary();
            $actionHistoryLog->deleteUndelete($type, $id, $update['active']);

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to($returnTo[$type]);
        }

        session()->setFlashdata('error', lang('Crm.error'));
        return redirect()->to(base_url('crm/'));

    }


    public function actionHistory($id, $type) 
    {
        $historyModel = new \App\Models\HistoryModel();
 
        switch ($type) {
            case 1:

                $companiesModel = new \App\Models\CompaniesModel();

                if(!$record = $companiesModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.companyNotFound')); return redirect()->to(base_url('crm/companies/'));
                }
                $data['linkTitle'] = $record['title'];
                $data['linkBaseUrl'] = base_url('crm/company/');


                break;
            case 2:

                $personsModel = new \App\Models\PersonsModel();

                if(!$record = $personsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.personNotFound')); return redirect()->to(base_url('crm/'));
                }
                $data['linkTitle'] = $record['name'] . ' ' . $record['surname'];
                $data['linkBaseUrl'] = base_url('crm/person/');

                break;
            case 3:

                $leadsModel = new \App\Models\LeadsModel();
    
                if(!$record = $leadsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.leadNotFound')); return redirect()->to(base_url('crm/'));
                }
                $data['linkTitle'] = $record['name'] . ' ' . $record['surname'];
                $data['linkBaseUrl'] = base_url('crm/lead/');

                break;

            case 4:

                $callsModel = new \App\Models\CallsModel();

                if(!$record = $callsModel->where('id', $id)->first())
                {
                   session()->setFlashdata('error', lang('Crm.recordNotFound')); return redirect()->to(base_url('crm/'));
                }
                $data['linkTitle'] = $record['title'] ;
                $data['linkBaseUrl'] = base_url('crm/activities/call/');

                break;
            case 5:

                    $meetingsModel = new \App\Models\MeetingsModel();

                    if(!$record = $meetingsModel->where('id', $id)->first())
                    {
                       session()->setFlashdata('error', lang('Crm.recordNotFound')); return redirect()->to(base_url('crm/'));
                    }
                    $data['linkTitle'] = $record['title'] ;
                    $data['linkBaseUrl'] = base_url('crm/activities/meeting/');

                    break;

            case 6:

                    $emailsModel = new \App\Models\EmailsModel();

                    if(!$record = $emailsModel->where('id', $id)->first())
                    {
                       session()->setFlashdata('error', lang('Crm.recordNotFound')); return redirect()->to(base_url('crm/'));
                    }
                    $data['linkTitle'] = $record['subject'] ;
                    $data['linkBaseUrl'] = base_url('crm/activities/meeting/');
                    break;
            case 7:

                $tasksModel = new \App\Models\TasksModel();

                if(!$record = $tasksModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.recordNotFound')); return redirect()->to(base_url('crm/'));
                }
                $data['linkTitle'] = $record['title'] ;
                $data['linkBaseUrl'] = base_url('crm/activities/task/');
                break;

            case 8:

                $opportunitiesModel  = new \App\Models\OpportunitiesModel;
    
                    if(!$record = $opportunitiesModel->where('id', $id)->first())
                    {
                        session()->setFlashdata('error', lang('Crm.recordNotFound')); return redirect()->to(base_url('crm/'));
                    }
                    $data['linkTitle'] = $record['title'] ;
                    $data['linkBaseUrl'] = base_url('crm/opportunity/');
                    break;
            default:

                session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }


        if(!allowedToView($record['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }

        $data['actionHistoryLog'] = new ActionHistoryLibrary();


        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 10;
        $limitFrom = ($page * $perPage) - $perPage ;

        if($type < 4)
        {
            $total   = $historyModel->countHistory($id, $type);
            $data['historyList'] = $historyModel->getHistoryList($id, $limitFrom, $perPage, $type);
        }
        elseif($type < 8)
        {
            $total   = $historyModel->countOnlyParentHistory($id, $type);
            $data['historyList'] = $historyModel->onlyParentHistoryList($id, $limitFrom, $perPage, $type);
        }
        elseif($type == 8)
        {
            $total   = $historyModel->countOnlyParentHistory($id, $type);
            $data['historyList'] = $historyModel->onlyParentHistoryList($id, $limitFrom, $perPage, $type);
        }

        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total, 'my_pagination');
        $data['recordId'] = $id; 



        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.actionHistory');

        return view('default/head_part', $headData)
            . view('default/crm/crm_action_history.php', $data)
            . view('default/footer_part.php');

    }

}
