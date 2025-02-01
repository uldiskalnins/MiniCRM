<?php

namespace App\Controllers\Crm;
use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Contacts extends BaseController
{
    protected $helpers = ['crm_helper'];


    public function companiesList()
    {
        // Izveido jaunu modeļa instanci
        $companiesModel = new \App\Models\CompaniesModel();

        // Pārbauda vai lietotājs ir administrators vai ir atļauts skatīt citu lietotāju ierakstus
        if (allowedToViewAllUsersRecords()){
            // Ja ir administrators vai ir atļauts skatīt citu lietotāju ierakstus
            $data = [
                'companies' => $companiesModel->select("mc_companies.*,CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name'")
                ->join('mc_users', 'mc_companies.user_id = mc_users.id', 'left')
                ->orderBy('id', 'DESC')->paginate(5, 'group1'),
                'pager' => $companiesModel->pager,
                'currentPage' => $companiesModel->pager->getCurrentPage('group1'),
                'totalPages'  => $companiesModel->pager->getPageCount('group1'),
            ];
        } else {
            // Ja lietotājs nav administrators un nav atļauts skatīt citu lietotāju ierakstus
            $data = [
                'companies' => $companiesModel->select("mc_companies.*,CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name'")->join('mc_users', 'mc_companies.user_id = mc_users.id', 'left')->where('mc_companies.user_id', session()->get('userId'))->where('mc_companies.active', 1)->orderBy('id', 'DESC')->paginate(5, 'group1'),
                'pager' => $companiesModel->pager,
                'currentPage' => $companiesModel->pager->getCurrentPage('group1'),
                'totalPages'  => $companiesModel->pager->getPageCount('group1'),
            ];
        }


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.companies').' - '.lang('Crm.showList');

        // Atgriež skatus ar sagatavotiem datiem
        return view('default/head_part', $headData)
            .view('default/crm/crm_companies_list.php', $data)
            .view('default/footer_part.php');
    }



    public function newCompany()
    {

        $leadId = $this->request->getGet('leadid');

        if ($leadId AND is_numeric($leadId))
        {
            $leadsModel = new \App\Models\LeadsModel();

            if (! $data['leadData'] = $leadsModel->where('id', $this->request->getGet('leadid'))->first()){$leadId = False;}

        }



        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.companies').' - '.lang('Crm.createNew');

        return view('default/head_part', $headData)
        .($leadId ? view('default/crm/crm_new_company_from_lead.php', $data) : view('default/crm/crm_new_company.php') )
        .view('default/footer_part.php');

    }


    public function company($companyId)
    {
        // Izveido jaunas instances no modeļiem
        $companiesModel = new \App\Models\CompaniesModel();


        // Iegūst uzņēmuma datus pēc ID
        if (!$data['companyData'] = $companiesModel->getCompanyWithUserById($companyId)) 
        {
            // Ja uzņēmums nav atrasts, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.companyNotFound'));
            return redirect()->to(base_url('crm/companies/'));
        }

        if(!userAdmin() AND $data['companyData']['active'] == 0)
        {
            // Ja lietotājs nav admins un ieraksts neaktivs, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.recordNotAvailable'));
            return redirect()->to(base_url('crm/companies/'));
        }

        // Pārbauda lietotāja tiesības skatīties uzņēmuma datus
        if (!allowedToView($data['companyData']['user_id'])) 
        {
            // Ja lietotājam nav atļauts skatīties šī uzņēmuma datus, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable'));
            return redirect()->to(base_url('crm/companies/'));
        }

        // Sagatavo uzņēmuma adreses datus
        $addresses = addressFormats([$data['companyData']['address1'], $data['companyData']['address2'], $data['companyData']['city'], $data['companyData']['country'], $data['companyData']['postal_code']]);
        $data['address'] = $addresses['addressLine'];
        $data['addressGoogleMapsUrl'] = $addresses['addressGoogleMapsUrl'];

        $data['getIdentifier'] = [
            1 => 'companyid',
            2 => 'personid',
            3 => 'leadid',
            8 => 'opportunityid'
        ];

        // Sagatavo datus galvenes daļai
        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.companies').' - '. $data['companyData']['title'];


        // Atgriež skatu ar sagatavotiem datiem
        return view('default/head_part', $headData)
            .view('default/crm/crm_see_company.php', $data)
            .view('default/footer_part.php');
    }


    public function editCompany($companyId)
    {
        // Izveido jaunu instance no CompaniesModel
        $companiesModel = new \App\Models\CompaniesModel();

        // Iegūst uzņēmuma datus pēc ID
        if (!$data['companyData'] = $companiesModel->getCompanyWithUserById($companyId)) {
            // Ja uzņēmums nav atrasts, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.companyNotFound'));
            return redirect()->to(base_url('crm/companies/'));
        }
    
        // Pārbauda lietotāja tiesības rediģēt uzņēmuma datus
        if (!allowedToEdit($data['companyData']['user_id'])) {
            // Ja lietotājam nav atļauts rediģēt šī uzņēmuma datus, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.companyNotFound'));
            return redirect()->to(base_url('crm/companies/'));
        }

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.companies').' - '.lang('Crm.edit').' - '.$data['companyData']['title'];
    
        // Atgriež skatu ar sagatavotiem datiem
        return view('default/head_part', $headData)
            .view('default/crm/crm_edit_company.php', $data)
            .view('default/footer_part.php');
    }





    public function saveCompany()
    {

        // Izveido jaunu instanci no CompaniesModel
        $companiesModel = new \App\Models\CompaniesModel();

        // Noteikumi validācijai
        $rules = [
            'title' => [
                'rules' => 'required|string',
                'errors' => [
                    'required' => 'Crm.invalidTitle',
                    'string' => 'Crm.invalidTitle',
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'phone2' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email',
                'errors' => [
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'fax' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'website' => [
                'rules' => 'permit_empty|valid_url',
                'errors' => [
                    'valid_url'=> 'Crm.invalidUrl',
                ]
            ],
            'rnumber' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[11]',
                'errors' => [
                    'max_length' => 'Crm.invalidRegOrVatNumber',
                    'alpha_numeric_punct'=> 'Crm.invalidRegOrVatNumber',
                ]
            ],
            'vnumber' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[13]',
                'errors' => [
                    'max_length' => 'Crm.invalidRegOrVatNumber',
                    'alpha_numeric_punct'=> 'Crm.invalidRegOrVatNumber',
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|string|max_length[5000]',
                'errors' => [
                    'max_length' => 'Crm.tooLongText',
                    'string' => 'Crm.error',
                ]
            ],
            'address1' => [
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => 'Crm.invalidAdressField',
                ]
            ],
            'address2' => [
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => 'Crm.invalidAdressField',
                ]
            ],
            'city' => [
                'rules' => 'permit_empty|string|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidAdressField',
                    'string'=> 'Crm.invalidAdressField',
                ]
            ],
            'country' => [
                'rules' => 'permit_empty|string|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidAdressField',
                    'string'=> 'Crm.invalidAdressField',
                ]
            ],
            'postcode' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[10]',
                'errors' => [
                    'max_length' => 'Crm.invalidAdressField',
                    'alpha_numeric_punct'=> 'Crm.invalidPostalField',
                ]
            ],
            'userfullname' => [
                'rules' => 'permit_empty|string|max_length[500]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string'=> 'Crm.invalidNameSurname',
                ]
            ],
            'id' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'leadid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],

        ];



        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list'));
            return redirect()->back()->withInput();
        }


        $companyData = [
            'email' => $this->request->getPost('email'),
            'title' => str_replace(array("\r", "\n"), '', $this->request->getPost('title',FILTER_SANITIZE_SPECIAL_CHARS)),
            'reg_nr' => $this->request->getPost('rnumber'),
            'vat_nr' => $this->request->getPost('vnumber'),
            'phone' => $this->request->getPost('phone'),
            'second_phone' => $this->request->getPost('phone2'),
            'fax' => $this->request->getPost('fax'),
            'bank_title' => $this->request->getPost('btitle'),
            'bank_code' => $this->request->getPost('bcode'),
            'bank_acc_nr' => $this->request->getPost('bankacc'),
            'city' => $this->request->getPost('city',FILTER_SANITIZE_SPECIAL_CHARS),
            'country' => $this->request->getPost('country',FILTER_SANITIZE_SPECIAL_CHARS),
            'address1' => $this->request->getPost('address1',FILTER_SANITIZE_SPECIAL_CHARS),
            'address2' => $this->request->getPost('address2',FILTER_SANITIZE_SPECIAL_CHARS),
            'postal_code' => $this->request->getPost('postcode'),
            'description' => $this->request->getPost('description',FILTER_SANITIZE_SPECIAL_CHARS),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'edit_date' => date("Y-m-d H:i:s"),
            'website' => prep_url(strval($this->request->getPost('website')),true),
        ];

        if($this->request->getPost('id')){ 
            $companyData['id'] = $this->request->getPost('id');
            $oldData = $companiesModel->getCompanyWithUserById($companyData['id']);
        }
        else{
            $companyData['creation_date'] = date("Y-m-d H:i:s");
            $companyData['active'] = 1;
        }

        $actionHistoryLog = new ActionHistoryLibrary();

        if($this->request->getPost('userid')){ 
            $companyData['user_id'] = $this->request->getPost('userid');
        }
        else{$companyData['user_id'] = 0;}

        if($this->request->getPost('leadid')){ 
            $companyData['lead_id'] = $this->request->getPost('leadid');
        }
        else{$companyData['lead_id'] = 0; }



        if ($companiesModel->save($companyData))
        {
            if(!$this->request->getPost('id'))
            {
                $companyData['id'] = $companiesModel->getInsertID();
                $actionHistoryLog->createContact(1, $companyData);
            }
            else{ $actionHistoryLog->updateContact(1, $companyData, $oldData);}

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/companies/'));
        }
        else{session()->setFlashdata('error', 'Crm.error'); return redirect()->to(base_url('crm/companies/'));}


    }

    public function personsList()
    {

        $personsModel = new \App\Models\PersonsModel();

        if (allowedToViewAllUsersRecords())
        {
            $data = [
                'persons' => $personsModel->select("mc_persons.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', mc_companies.title")->
                join('mc_companies', 'mc_companies.id = mc_persons.company_id', 'left')->
                join('mc_users', 'mc_persons.user_id = mc_users.id', 'left')->
                orderBy('mc_persons.id', 'DESC')->paginate(10, 'group1'),
                'pager' => $personsModel->pager,
                'currentPage' => $personsModel->pager->getCurrentPage('group1'),
                'totalPages'  => $personsModel->pager->getPageCount('group1'),
            ];

        }
        else{ // 

            $data = [
                'persons' => $personsModel->select("mc_persons.*, CONCAT(mc_users.name, ' ', mc_users.surname) AS 'user_full_name', mc_companies.title")->
                join('mc_companies', 'mc_companies.id = mc_persons.company_id', 'left')->
                join('mc_users', 'mc_persons.user_id = mc_users.id', 'left')->
                where('mc_persons.user_id', session()->get('userId'))->where('mc_persons.active', 1)->
                orderBy('mc_persons.id', 'DESC')->paginate(10, 'group1'),
                'pager' => $personsModel->pager,
                'currentPage' => $personsModel->pager->getCurrentPage('group1'),
                'totalPages'  => $personsModel->pager->getPageCount('group1'),
            ];
        }

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.persons').' - '.lang('Crm.showList');

        return view('default/head_part', $headData)
        .view('default/crm/crm_persons_list.php', $data)
        .view('default/footer_part.php');

    }

    public function newPerson()
    {


        $data = array();
 
        $companyId = $this->request->getGet('companyid');
        $leadId = $this->request->getGet('leadid');

        if ($companyId AND is_numeric($companyId))
        {
            $companiesModel = new \App\Models\CompaniesModel();
            $data['companyData'] = $companiesModel->select('id, title')->where('id', $companyId)->get()->getRowArray();
        }
        elseif ($leadId AND is_numeric($leadId))
        {
            $leadsModel = new \App\Models\LeadsModel();

            if (! $data['leadData'] = $leadsModel->where('id', $this->request->getGet('leadid'))->first()){$leadId = False;}

        }


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.persons').' - '.lang('Crm.createNew');

        return view('default/head_part', $headData)
        .($leadId ? view('default/crm/crm_new_person_from_lead.php', $data) : view('default/crm/crm_new_person.php') )
        .view('default/footer_part.php');

    }


    public function savePerson()
    {

        $personsModel = new \App\Models\PersonsModel();

        $rules = [
            'name' => [
                'rules' => 'required|string|max_length[100]',
                'errors' => [
                    'required' => 'Crm.invalidNameSurname',
                    'string' => 'Crm.invalidNameSurname',
                    'max_length' => 'Crm.invalidNameSurname',
                ]
            ],
            'surname' => [
                'rules' => 'permit_empty|string|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string' => 'Crm.invalidNameSurname',
                ]
            ],
            'position' => [
                'rules' => 'permit_empty|string|max_length[100]',
                'errors' => [
                    'string' => 'Crm.error',
                    'required' => 'Crm.error',
                ]
            ],
            'birthday' => [
                'rules' => 'permit_empty|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Crm.error',
                    'valid_date' => 'Crm.invalidDate',
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email',
                'errors' => [
                    'required' => 'Crm.error',
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'phone2' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'id' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'active' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'companyid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'socialnetwork' => [
                'rules' => 'permit_empty|valid_url',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'userfullname' => [
                'rules' => 'permit_empty|string|max_length[500]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string'=> 'Crm.invalidNameSurname',
                ]
            ],
            'leadid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
        ];


        if (!$this->validate($rules))
        {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list') );
            return redirect()->to(base_url('crm/persons/'));
        }

        $personData = [
            'email' => $this->request->getPost('email'),
            'position' => $this->request->getPost('position',FILTER_SANITIZE_SPECIAL_CHARS),
            'name' => $this->request->getPost('name',FILTER_SANITIZE_SPECIAL_CHARS),
            'surname' => $this->request->getPost('surname',FILTER_SANITIZE_SPECIAL_CHARS),
            'birthday' => $this->request->getPost('birthday'),
            'nin' => $this->request->getPost('nin'),
            'phone' => $this->request->getPost('phone'),
            'second_phone' => $this->request->getPost('phone2'),
            'social_network' => $this->request->getPost('socialnetwork'),
            'bank_title' => $this->request->getPost('btitle'),
            'bank_code' => $this->request->getPost('bcode'),
            'bank_acc_nr' => $this->request->getPost('bankacc'),
            'city' => $this->request->getPost('city'),
            'country' => $this->request->getPost('country'),
            'address1' => $this->request->getPost('address1'),
            'address2' => $this->request->getPost('address2'),
            'postal_code' => $this->request->getPost('postcode'),
            'description' => $this->request->getPost('description'),
            'edit_date' => date("Y-m-d H:i:s"),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'website' => prep_url(strval($this->request->getPost('website')),true),
        ];

        if($this->request->getPost('website')){ 
            $personData['website'] = prep_url(strval($this->request->getPost('website')),true);
        }

        if($this->request->getPost('active')){ 
            $personData['active'] = $this->request->getPost('active');
        }
        else{ $personData['active'] = 1;}

        if($this->request->getPost('id')){ 
            $personData['id'] = $this->request->getPost('id');
            $oldData = $personsModel->getPersonWithUserAndCompanyById($personData['id']);

        }
        else{
            $personData['creation_date'] = date("Y-m-d H:i:s");
        }

        if($this->request->getPost('userid')){
            $personData['user_id'] = $this->request->getPost('userid');
        }
        else{$personData['user_id'] = 0;}

        if($this->request->getPost('companyid')){ 
            $personData['company_id'] = $this->request->getPost('companyid');
        }
        else{$personData['company_id'] = 0;}

        if($this->request->getPost('leadid')){ 
            $personData['lead_id'] = $this->request->getPost('leadid');
        }
        else{$personData['lead_id'] = 0; }


        if ($personsModel->save($personData))
        {

            $actionHistoryLog = new ActionHistoryLibrary();

            if(!$this->request->getPost('id'))
            {
                $personData['id'] = $personsModel->getInsertID();
                $actionHistoryLog->createContact(2, $personData);
            }
            else{ $actionHistoryLog->updateContact(2, $personData, $oldData);}

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/persons/'));
        }
        else{
            session()->setFlashdata('error', lang('Crm.error'));
            return redirect()->to(base_url('crm/persons/'));
        }


    }


    public function person($personId)
    {

        $personsModel = new \App\Models\PersonsModel();

        if(!$data['personData'] = $personsModel->getPersonWithUserAndCompanyById($personId))
        {
            session()->setFlashdata('error', lang('Crm.personNotFound')); 
            return redirect()->to(base_url('crm/persons/'));
        }

        if(!userAdmin() AND $data['personData']['active'] == 0)
        {
            // Ja lietotājs nav admins un ieraksts neaktivs, uzstāda kļūdas ziņojumu un pāradresē uz uzņēmumu sarakstu
            session()->setFlashdata('error', lang('Crm.recordNotAvailable'));
            return redirect()->to(base_url('crm/persons/'));
        }

        if (!allowedToView($data['personData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable'));
            return redirect()->to(base_url('crm/persons/'));
        }


        $data['addresses'] = addressFormats([
            $data['personData']['address1'],
            $data['personData']['address2'],
            $data['personData']['city'],
            $data['personData']['country'],
            $data['personData']['postal_code']
        ]);

        $data['getIdentifier'] = [
            1 => 'companyid',
            2 => 'personid',
            3 => 'leadid',
            8 => 'opportunityid'
        ];

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.person').' - '.$data['personData']['name'].' '.$data['personData']['surname'];

        return view('default/head_part', $headData)
        .view('default/crm/crm_see_person.php', $data)
        .view('default/footer_part.php');

    }

    public function editPerson($personId)
    {


        $personsModel = new \App\Models\PersonsModel();


        if(!$data['personData'] = $personsModel->getPersonWithUserAndCompanyById($personId)){
            session()->setFlashdata('error', lang('Crm.companyNotFound')); 
            return redirect()->to(base_url('crm/persons/'));
        }


        if($data['personData']['company_id'] == 0){$data['personData']['company_id'] = ''; $data['personData']['title'] = '';}

        if (!allowedToEdit($data['personData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.companyNotFound'));
            return redirect()->to(base_url('crm/companies/'));
        }

        if($data['personData']['user_id'] == 0){ $data['personData']['user_name'] = ''; $data['personData']['user_surname'] = ''; }
        else{$data['personData']['user_name'] = $data['personData']['user_name'].' ';}


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.person').' - '.$data['personData']['name'].' '.$data['personData']['surname'];

        return view('default/head_part', $headData)
        .view('default/crm/crm_edit_person.php', $data)
        .view('default/footer_part.php');
    }



}
