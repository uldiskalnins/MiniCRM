<?php

namespace App\Controllers;

use App\Libraries\ActionHistoryLibrary;

class Ajax extends BaseController
{

    protected $helpers = ['crm_helper'];



    public function search_parent()
    {

        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = htmlspecialchars(urldecode((string) $this->request->getGet('find')), ENT_QUOTES);


        if (mb_strlen($text) < 3) {
            return false;
        }


        if ($this->request->getGet('type') == 1) {
            $companiesModel = new \App\Models\CompaniesModel();

            if (userAdmin()) {
                $data['parentsList'] = $companiesModel->where('active', 1)->like('title', $text)->limit(5)->get()->getResultArray();
            } else {
                $data['parentsList'] = $companiesModel->where('user_id', session()->get('userId'))->where('active', 1)->like('title', $text)->limit(5)->get()->getResultArray();
            }

            return view('default/ajax/ajax_parent_companies_list.php', $data);
        } elseif ($this->request->getGet('type') == 2) {
            $personsModel = new \App\Models\PersonsModel();

            if (userAdmin()) {
                $data['parentsList'] = $personsModel->select('mc_persons.*, mc_companies.title')->join('mc_companies', 'mc_companies.id = mc_persons.company_id', 'left')->where('mc_persons.active', 1)->groupStart()->like('mc_persons.name', $text)->orLike('mc_persons.surname', $text)->groupEnd()->limit(5)->get()->getResultArray();
            } else {
                $data['parentsList'] = $personsModel->select('mc_persons.*, mc_companies.title')->join('mc_companies', 'mc_companies.id = mc_persons.company_id', 'left')->groupStart()->like('mc_persons.name', $text)->orLike('mc_persons.surname', $text)->groupEnd()->where('mc_persons.active', 1)->where('mc_persons.user_id', session()->get('userId'))->limit(5)->get()->getResultArray();
            }


            return view('default/ajax/ajax_parent_persons_list.php', $data);
        } elseif ($this->request->getGet('type') == 3) {
            $leadsModel = new \App\Models\LeadsModel();

            if (userAdmin()) {
                $data['parentsList'] = $leadsModel->like('name', $text)->orLike('surname', $text)->limit(5)->get()->getResultArray();
            } else {
                $data['parentsList'] = $leadsModel->where('user_id', session()->get('userId'))->like('name', $text)->orLike('surname', $text)->limit(5)->get()->getResultArray();
            }


            return view('default/ajax/ajax_parent_leads_list.php', $data);
        } elseif ($this->request->getGet('type') == 8) {
            $opportunitiesModel = new \App\Models\OpportunitiesModel();

            if (userAdmin()) {
                $data['parentsList'] = $opportunitiesModel->like('title', $text)->limit(5)->get()->getResultArray();
            } else {
                $data['parentsList'] = $opportunitiesModel->where('user_id', session()->get('userId'))->like('title', $text)->limit(5)->get()->getResultArray();
            }


            return view('default/ajax/ajax_parent_opportunities_list.php', $data);
        }
    }

    public function search_person()
    {

        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode((string) $this->request->getGet('person'));

        if (mb_strlen($text) < 3) {
            return false;
        }

        $personsModel = new \App\Models\PersonsModel();

        if (allowedToViewAllUsersRecords()) {
            $data['personsList']  = $personsModel->like('name', $text)->orLike('surname', $text)->limit(5)->get()->getResultArray();
        } else {
            $data['personsList']  = $personsModel->where('user_id', session()->get('userId'))->groupStart()->like('name', $text)->orLike('surname', $text)->groupEnd()->limit(5)->get()->getResultArray();
        }

        return view('default/ajax/ajax_persons_list.php', $data);
    }

    public function search_lead() ///interesentu meklēšana interesentu sarakstā
    {

        $text = urldecode((string) $this->request->getGet('lead'));
        if (mb_strlen($text) < 3) {
            return false;
        }

        $leadsModel = new \App\Models\LeadsModel();

        if (allowedToViewAllUsersRecords()) {
            $data['leadsList']  = $leadsModel->like('name', $text)->orLike('surname', $text)->limit(5)->get()->getResultArray();
        } else {
            $data['leadsList']  = $leadsModel->where('user_id', session()->get('userId'))->where('active', 1)->groupStart()->like('name', $text)->orLike('surname', $text)->groupEnd()->limit(5)->get()->getResultArray();
        }

        return view('default/ajax/ajax_leads_list.php', $data);
    }

    public function search_opportunity() ///iespēju meklēšana iespēju sarakstā
    {
        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode((string) $this->request->getGet('opportunity'));
        if (mb_strlen($text) < 3) {
            return false;
        }

        $opportunitiesModel = new \App\Models\OpportunitiesModel();

        if (allowedToViewAllUsersRecords()) {
            $data['opportunitiesList'] = $opportunitiesModel->like('title', $text)->limit(5)->get()->getResultArray();
        } else {
            $data['opportunitiesList'] = $opportunitiesModel->where('user_id', session()->get('userId'))->where('active', 1)->like('title', $text)->limit(5)->get()->getResultArray();
        }

        return view('default/ajax/ajax_opportunities_list.php', $data);
    }


    public function search_connected_contact()
    {

        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode((string) $this->request->getGet('person'));

        if (mb_strlen($text) < 3) {
            return false;
        }

        $personsModel = new \App\Models\PersonsModel();
        $settingsModel = new \App\Models\SettingsModel();

        if (userAdmin() or $settingsModel->getSettingValue('allowToSeeOtherUsersRecords') == 1) {
            $data['personsList']  = $personsModel->like('name', $text)->orLike('surname', $text)->limit(5)->get()->getResultArray();
        } else {
            $data['personsList']  = $personsModel->like('name', $text)->orLike('surname', $text)->where('user_id', session()->get('userId'))->limit(5)->get()->getResultArray();
        }
        return view('default/ajax/ajax_connected_persons_list.php', $data);
    }

    public function search_assigned_user()
    {
        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode(esc($this->request->getGet('username')));

        if (mb_strlen($text) < 3) {
            return false;
        }

        $usersModel = new \App\Models\UsersModel();
        $data['usersData'] = $usersModel->GetUsernameLike($text);
        return view('default/ajax/ajax_assigned_users_list.php', $data);
    }

    public function search_account()
    {

        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode(esc($this->request->getGet('title')));

        if (mb_strlen($text) < 3) {
            return false;
        }

        $companiesModel = new \App\Models\CompaniesModel();


        if (allowedToViewAllUsersRecords()) {
            $data['accountsList'] = $companiesModel->like('title', $text)->where('active', 1)->limit(5)->get()->getResultArray();
        } else {
            $data['accountsList'] = $companiesModel->like('title', $text)->where('user_id', session()->get('userId'))->where('active', 1)->limit(5)->get()->getResultArray();
        }

        return view('default/ajax/ajax_companies_list.php', $data);
    }

    public function search_connected_account()
    {
        if (!$this->request->isAJAX()) {
            exit();
        }

        $text = urldecode((string) $this->request->getGet('title'));

        if (mb_strlen($text) < 3) {
            return false;
        }

        $companiesModel = new \App\Models\CompaniesModel();

        if (allowedToViewAllUsersRecords()) {
            $data['accountsList'] = $companiesModel->like('title', $text)->where('active', 1)->limit(5)->get()->getResultArray();
        } else {
            $data['accountsList'] = $companiesModel->like('title', $text)->where('user_id', session()->get('userId'))->where('active', 1)->limit(5)->get()->getResultArray();
        }

        // $data['accountsList'] = $companiesModel->like('title', $text)->limit(5)->get()->getResultArray();

        return view('default/ajax/ajax_connected_companies_list.php', $data);
    }



    public function get_company_contacts($companyId)
    {

        if (!$this->request->isAJAX()) {
            exit();
        }

        $personsModel = new \App\Models\PersonsModel();

        $data['contactPersonsList'] = $personsModel->where('company_id', $companyId)->orderBy('id', 'DESC')->findAll();

        return view('default/ajax/ajax_company_contacts_list.php', $data);
    }


    public function delete_file($fileId)
    {
        if (!$this->request->isAJAX()) {
            exit('0');
        }

        $filesModel = new \App\Models\FilesModel();

        if (!$fileData = $filesModel->find($fileId)) {
            exit('1');
        }
        if (!allowedToEdit($fileData['user_id'])) {
            exit('0');
        }

        if (file_exists(ROOTPATH . 'public/uploads/email/' . $fileData['file_name'])) {
            if (unlink(ROOTPATH . 'public/uploads/email/' . $fileData['file_name'])) {
                $filesModel->delete($fileId) ? exit('1') : exit('0');
            } else {
                exit('0');
            }
        } else {
            $filesModel->delete($fileId) ? exit('1') : exit('0');
        }
    }


    public function update_crm_settings($setting)
    {

        if (!$this->request->isAJAX()) {
            exit();
        }
        if (!userAdmin()) {
            exit('0');
        }

        $appSettings =  new \Config\App();
        $settingsModel = new \App\Models\SettingsModel();
        $crmModel = new \App\Models\CrmModel();

        $getValue = esc($this->request->getGet('value'));


        switch ($setting) {
            case 1:

                if ($getValue == 1) {
                    $settingValue = 1;
                } else {
                    $settingValue = 0;
                }

                $settingsModel->updateSettingByName('allowToSeeOtherUsersRecords', $settingValue) ? exit('1') : exit('0');


                break;
            case 2:

                $sl = $appSettings->supportedLocales;

                if (array_key_exists($getValue, $sl)) {

                    $settingsModel->updateSettingByName('language', $sl[$getValue]) ? exit('1') : exit('0');
                }


                break;
            case 3:

                $currencyId = esc($this->request->getGet('id'));

                if (is_numeric($currencyId)) {
                    $settingsModel->updateSettingByName('defaultCurrency', $currencyId) ? exit('1') : exit('0');
                }

                exit('0');

                break;

            case 4:

                $response = ['success' => false, 'message' => lang('Crm.error')];

                $rules = [
                    'currencyname'   => [
                        'rules' => 'required|string|max_length[250]',
                        'errors' => [
                            'required' => 'Crm.noDataOrInvalidData',
                            'max_length' => 'Crm.noDataOrInvalidData',
                            'string' => 'Crm.noDataOrInvalidData',
                        ]
                    ],
                    'currencycode'   => [
                        'rules' => 'required|string|max_length[3]',
                        'errors' => [
                            'required' => 'Crm.noDataOrInvalidData',
                            'max_length' => 'Crm.noDataOrInvalidData',
                            'string' => 'Crm.noDataOrInvalidData',
                        ]
                    ],
                    'currencysign'   => [
                        'rules' => 'permit_empty|max_length[1]',
                        'errors' => [
                            'required' => 'Crm.noDataOrInvalidData',
                            'max_length' => 'Crm.noDataOrInvalidData',
                        ]
                    ],
                ];

                if ($this->validate($rules)) {
                    $data = array('currency_name' => ucfirst($this->request->getPost('currencyname')), 'currency_code' => strtoupper($this->request->getPost('currencycode')), 'currency_sign' => $this->request->getPost('currencysign'));

                    if ($crmModel->addCurrency($data)) {
                        $response['success'] = true;
                        $response['message'] = lang('Crm.actionOk');
                    }
                } else {
                    $response['message'] =  \Config\Services::validation()->listErrors('my_list');
                }

                header('Content-Type: application/json');
                exit(json_encode($response));

                break;
            case 5:

                $currencyId = esc($this->request->getGet('id'));
                $crmModel->deleteCurrency($currencyId) ? exit('1') : exit('0');

                break;
            case 6:


                $currenciesList = $crmModel->getCurencies()->getResultArray();

                $currencies = array();
                if (is_array($currenciesList)) {
                    foreach ($currenciesList as $row) {
                        $currencies[] = $row;
                    }
                }


                $data = array(
                    'currencies' => $currencies,
                    'defaultCurrency' => $settingsModel->defaultCurrency
                );


                header('Content-Type: application/json');
                echo json_encode($data);

                break;
            default:
                ///
        }
    }

    public function add_history_note($id, $type)
    {

        //izlabot iespēju, kad jebkurš lietotājs var komentēt jebkuru ierakstu
        if (!$this->request->isAJAX()) {
            exit();
        }
        $response = ['success' => false, 'message' => $this->request->getPost('note')];


        $rules = [
            'note'   => [
                'rules' => 'required|string|max_length[500]',
                'errors' => [
                    'required' => 'Crm.noDataOrInvalidData',
                    'max_length' => 'Crm.noDataOrInvalidData',
                    'string' => 'Crm.noDataOrInvalidData',
                ]
            ],

        ];

        if ($this->validate($rules)) {
            $note = $this->request->getPost('note');
            $data = array('note' => $note, 'id' => $id, 'type' => $type);

            $actionHistoryLog = new ActionHistoryLibrary();

            if ($actionHistoryLog->saveNote($data)) {
                $response['success'] = true;
                $response['message'] = lang('Crm.actionOk');
            } else {
                $response['message'] =  lang('Crm.error');
            }
        } else {
            $response['message'] =  \Config\Services::validation()->listErrors('my_list');
        }



        return $this->response->setJSON($response);
    }

    public function checkLang($value)
    {
        if (!$this->request->isAJAX()) {
            exit();
        }
        if (empty($value)) {
            checkLanguage();
            exit();
        }
    }



    public function getHomeContentLists($type = 0)
    {
        if (!$this->request->isAJAX()) {
            exit();
        }

        $callsModel = new \App\Models\CallsModel();
        $meetingsModel = new \App\Models\MeetingsModel();
        $tasksModel = new \App\Models\TasksModel();
        $opportunitiesModel = new \App\Models\OpportunitiesModel();

        $offset = (int) ($this->request->getGet('offset') ?? 0);


        if ($type == 0) 
        {
            $list = $callsModel->select('*')->where('user_id',  session()->get('userId'))->where('status', 0)->where('start_date >= CURDATE()')->limit(5, $offset)->orderBy('start_date', 'ASC')->get()->getResult();
            $total = $callsModel->where('user_id', session()->get('userId'))->where('status', 0)->where('start_date >= CURDATE()')->countAllResults();
        }
        elseif ($type == 1) 
        {
            $list = $meetingsModel->select('*')->where('user_id',  session()->get('userId'))->where('status', 0)->where('start_date >= CURDATE()')->limit(5, $offset)->orderBy('start_date', 'ASC')->get()->getResult();
            $total = $meetingsModel->where('user_id', session()->get('userId'))->where('status', 0)->where('start_date >= CURDATE()')->countAllResults();
    
        }
        elseif ($type == 2) 
        {
            $list = $tasksModel->select('*')->where('user_id', session()->get('userId'))->where('status <', 2)->limit(5, $offset)->orderBy('id', 'DESC')->get()->getResult();
            $total = $tasksModel->where('user_id', session()->get('userId'))->where('status <', 2)->countAllResults();
        }
        elseif ($type == 3)
        {
            $list = $opportunitiesModel->select('*')->where('user_id', session()->get('userId'))->where('stage <', 4)->limit(5, $offset)->orderBy('id', 'DESC')->get()->getResult();
            $total = $opportunitiesModel->where('user_id', session()->get('userId'))->where('stage <', 4)->countAllResults();

        }


        return $this->response->setJSON([
            'list' => $list,
            'total' => $total
        ]);
    }
}
