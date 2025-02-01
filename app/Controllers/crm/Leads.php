<?php

namespace App\Controllers\Crm;
use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Leads extends BaseController
{


    public function __construct()
    {
        helper('crm_helper');
    }






    
    public function leadsList()
    {
        $leadsModel = new \App\Models\LeadsModel();

        // Kārtošanai
        $sort = $this->request->getGet('sort');
        switch ($sort) {
            case 1:
                $order_by = 'mc_leads.status';
                $order_type = 'ASC';
                $data['leadStatusSort'] = 'sort=2';
                break;
            case 2:
                $order_by = 'mc_leads.status';
                $order_type = 'DESC';
                $data['leadStatusSort'] = 'sort=1';
                break;
            default:
                // Ja nav sort parametra vai nepareiza vērtība
                $order_by = 'mc_leads.id';
                $order_type = 'DESC';
                $data['leadStatusSort'] = 'sort=1';
        }
    
        // Sākuma query
        $leadsQuery = $leadsModel->select('mc_leads.*, mc_users.name AS user_name, mc_users.surname AS user_surname, mc_users.id AS user_id')
        ->join('mc_users', 'mc_users.id = mc_leads.user_id', 'left');
    
        // Lietotāja redzamības ierobežojumi
        if (!allowedToViewAllUsersRecords()) {
            $leadsQuery->where('mc_leads.active', 1)->where('mc_leads.user_id', session()->get('userId'));
        }
    
        // Pievieno kārtošanu un lapošanas iestatījumus
        $data['leads'] = $leadsQuery->orderBy($order_by, $order_type)->paginate(10, 'group1');
        $data['pager'] = $leadsModel->pager;
        $data['currentPage'] = $leadsModel->pager->getCurrentPage('group1');
        $data['totalPages'] = $leadsModel->pager->getPageCount('group1');
    
        // Galvenes dati

        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.leads');
    
        // Skata atgriešana
        return view('default/head_part', $headData)
            .view('default/crm/crm_leads_list.php', $data)
            .view('default/footer_part.php');


    }

    public function new()
    {

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.leads').' - '.lang('Crm.createNew');

        return view('default/head_part', $headData)
        .view('default/crm/crm_new_lead.php')
        .view('default/footer_part.php');

    }


    public function save()
    {

        $leadsModel = new \App\Models\LeadsModel();


        //echo $this->request->getPost('account');exit();

        $rules = [
            'account' => [
                'rules' => 'string|max_length[250]',
                'errors' => [
                    'string' => 'Crm.error',
                    'max_length' => 'Crm.error',

                ]
            ],
            'name' => [
                'rules' => 'required|string|max_length[100]',
                'errors' => [
                    'required' => 'Crm.invalidNameSurname',
                    'string' => 'Crm.invalidNameSurname',
                    'max_length' => 'Crm.invalidNameSurname',
                ]
            ],
            'surname' => [
                'rules' => 'string|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string' => 'Crm.invalidNameSurname',
                ]
            ],
            'position' => [
                'rules' => 'permit_empty|string|max_length[100]',
                'errors' => [
                    'string' => 'Crm.error',
                    'max_length' => 'Crm.error',

                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email',
                'errors' => [
                    'valid_email' => 'Crm.error',
                ]
            ],
            'social' => [
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => 'Crm.error',
                ]
            ],
            'phone' => [
                'rules' => 'permit_empty|alpha_numeric_punct|max_length[100]',
                'errors' => [
                    'max_length' => 'Crm.invalidPhoneOrFax',
                    'alpha_numeric_punct'=> 'Crm.invalidPhoneOrFax',
                ]
            ],
            'source' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer'=> 'Crm.error',
                ]
            ],
            'status' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer'=> 'Crm.error',
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
            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
        ];


        if (!$this->validate($rules))
        {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list') );
            return redirect()->to(base_url('crm/leads/'));
        }


        $leadData = [
            'email' => $this->request->getPost('email'),
            'position' => $this->request->getPost('position',FILTER_SANITIZE_SPECIAL_CHARS),
            'name' => $this->request->getPost('name',FILTER_SANITIZE_SPECIAL_CHARS),
            'surname' => $this->request->getPost('surname',FILTER_SANITIZE_SPECIAL_CHARS),
            'account' => $this->request->getPost('account'),
            'phone' => $this->request->getPost('phone'),
            'source' => $this->request->getPost('source'),
            'status' => $this->request->getPost('status'),
            'social_network' => $this->request->getPost('social'),
            'city' => $this->request->getPost('city'),
            'country' => $this->request->getPost('country'),
            'address1' => $this->request->getPost('address1'),
            'address2' => $this->request->getPost('address2'),
            'postal_code' => $this->request->getPost('postcode'),
            'description' => $this->request->getPost('description'),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'edit_date' => date("Y-m-d H:i:s"),
        ];

        if($this->request->getPost('website'))
        { 
            $leadData['website'] = prep_url(strval($this->request->getPost('website')),true);
        }

        if($this->request->getPost('active'))
        { 
            $leadData['active'] = $this->request->getPost('active');
        }
        else{  $leadData['active'] = 1; }

        if($this->request->getPost('id'))
        { 
            $leadData['id'] = $this->request->getPost('id');
            $oldData = $leadsModel->select('mc_leads.*, mc_users.name AS user_name, mc_users.surname AS user_surname, mc_users.id AS user_id')->
            join('mc_users', 'mc_users.id = mc_leads.user_id', 'left')->where('mc_leads.id', $leadData['id'])->first();
        }
        else{ $leadData['creation_date'] = date("Y-m-d H:i:s"); }

        if($this->request->getPost('userid'))
        {
            $leadData['user_id'] = $this->request->getPost('userid');
        }
        else{ $leadData['user_id'] = 0; }

        $actionHistoryLog = new ActionHistoryLibrary();


        if ($leadsModel->save($leadData))
        {

            if(!$this->request->getPost('id'))
            {
                $leadData['id'] = $leadsModel->getInsertID();
                $actionHistoryLog->createContact(3, $leadData);
            }
            else{ $actionHistoryLog->updateContact(3, $leadData, $oldData);}

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/lead/').$leadData['id']);
        }
        else
        {
            session()->setFlashdata('error', lang('Crm.error'));
            return redirect()->to(base_url('crm/leads/'));
        }


    }


    public function lead($leadId)
    {
        $leadsModel = new \App\Models\LeadsModel();


        $data['leadData'] = $leadsModel->select('mc_leads.*, mc_users.name AS user_name, mc_users.surname AS user_surname, mc_users.id AS user_id')->
        join('mc_users', 'mc_users.id = mc_leads.user_id', 'left')->where('mc_leads.id',$leadId)->first();

        if (empty($data['leadData'])){session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/leads/'));}


        if(!userAdmin() AND $data['leadData']['active'] == 0)
        {
            session()->setFlashdata('error', lang('Crm.recordNotAvailable'));
            return redirect()->to(base_url('crm/leads/'));
        }

        if (!allowedToView($data['leadData']['user_id'])) 
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/leads/'));
        }


        $data['addresses'] = addressFormats([
            $data['leadData']['address1'],
            $data['leadData']['address2'],
            $data['leadData']['city'],
            $data['leadData']['country'],
            $data['leadData']['postal_code']
        ]);

        $data['lead_title'] = $data['leadData']['name']? $data['leadData']['name'].' '.$data['leadData']['surname'] : ($data['leadData']['surname']? $data['leadData']['surname'] : $data['leadData']['account']);

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.leads').' - '. $data['lead_title'];

        return view('default/head_part', $headData)
        .view('default/crm/crm_see_lead.php', $data)
        .view('default/footer_part.php');


    }

    public function edit($leadId)
    {
        $leadsModel = new \App\Models\LeadsModel();


        $data['leadData'] = $leadsModel->select('mc_leads.*, CONCAT(mc_users.name, " ", mc_users.surname) AS user_full_name')->
        join('mc_users', 'mc_users.id = mc_leads.user_id', 'left')->where('mc_leads.id',$leadId)->first();


        if (empty($data['leadData'])){session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/leads/'));}

        if (!allowedToEdit($data['leadData']['user_id'])) {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/leads/'));
        }


        $data['lead_title'] = $data['leadData']['name']? $data['leadData']['name'].' '.$data['leadData']['surname'] : ($data['leadData']['surname']? $data['leadData']['surname'] : $data['leadData']['account']);

        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.leads').' - '.lang('Crm.createNew');

        return view('default/head_part', $headData)
        .view('default/crm/crm_edit_lead.php', $data)
        .view('default/footer_part.php');


    }





}
