<?php

namespace App\Controllers\Crm;
use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Opportunities extends BaseController
{

    private $allowedParentsTypesId;

    public function __construct()
    {
        helper('crm_helper');
        $this->allowedParentsTypesId =  [1,2];
    }






    
    public function opportunitiesList()
    {
        $opportunitiesModel = new \App\Models\OpportunitiesModel();
        $crmModel = new \App\Models\CrmModel();

        $pager = service('pager');
        $page  = (int) ($this->request->getGet('page') ?? 1);


        if (allowedToViewAllUsersRecords())
        {
            $perPage = 20;
            $total   = $opportunitiesModel->countAll();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['leads'] = $opportunitiesModel->getAllOpportunitiesWithUsers(0, $limitFrom, $perPage);

        }
        else
        {
            $perPage = 20;
            $total   = $opportunitiesModel->where('user_id', session()->get('userId'))->countAllResults();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['leads'] = $opportunitiesModel->getAllOpportunitiesWithUsers(session()->get('userId'), $limitFrom, $perPage);
        }

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        // Galvenes dati
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.opportunitie');
    
        // Skata atgriešana
        return view('default/head_part', $headData)
            .view('default/crm/crm_opportunities_list.php', $data)
            .view('default/footer_part.php');


    }

    public function new()
    {

        $data = getParentDataByGet();
        if(!$data){ session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));}

        $crmModel = new \App\Models\CrmModel();
        $settingsModel = new \App\Models\SettingsModel();

        $data['defaultCurrency'] = $settingsModel->defaultCurrency;
        $data['currencies'] = $crmModel->getCurencies()->getResultArray();

        $data['allowedParents'] = $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.leads').' - '.lang('Crm.createNew');

        return view('default/head_part', $headData)
        .view('default/crm/crm_new_opportunity.php', $data)
        .view('default/footer_part.php');

    }


    public function save()
    {

        $opportunitiesModel = new \App\Models\OpportunitiesModel();


        $rules = [
            'title' => [
                'rules' => 'string|max_length[250]|required',
                'errors' => [
                    'string' => 'Crm.invalidTitle',
                    'max_length' => 'Crm.invalidTitle',
                    'required' => 'Crm.invalidTitle',

                ]
            ],
            'source' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger',
                ]
            ],
            'closedate' => [
                'rules' => 'string|required|valid_date[Y-m-d]',
                'errors' => [
                    'valid_date' => 'Crm.invalidDate',
                    'string' => 'Crm.invalidDate',
                    'required' => 'Crm.invalidDate',
                ]
            ],
            'stage' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.invalidInteger',
                ]
            ],
            'amount' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Crm.invalidAmount',
                    'numeric' => 'Crm.invalidAmount',

                ]
            ],
            'currency' => [
                'rules' => 'required|string|max_length[3]',
                'errors' => [
                    'required' => 'Crm.error',
                    'string' => 'Crm.error',
                    'max_length' => 'Crm.error',
                ]
            ],
            'probability' => [
                'rules' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => 'Crm.invalidProbability',
                    'numeric' => 'Crm.invalidProbability',
                    'greater_than_equal_to' => 'Crm.invalidProbability',
                    'less_than_equal_to' => 'Crm.invalidProbability',
                ]
            ],
            'description' => [
                'rules' => 'string|max_length[2500]|permit_empty',
                'errors' => [
                    'string' => 'Crm.error',
                    'max_length' => 'Crm.tooLongText',
                ]
            ],
            'parentid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'parenttype' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'id' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'active' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],

            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
        ];


        if (!$this->validate($rules))
        {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list') );
            return redirect()->back()->withInput();
        }


        $opportunityData = [
            'title' => $this->request->getPost('title',FILTER_SANITIZE_SPECIAL_CHARS),
            'lead_source' => $this->request->getPost('source'),
            'close_date' => $this->request->getPost('closedate'),
            'stage' => $this->request->getPost('stage'),
            'amount' => $this->request->getPost('amount'),
            'currency' => $this->request->getPost('currency'),
            'probability' => $this->request->getPost('probability'),
            'description' => $this->request->getPost('description',FILTER_SANITIZE_SPECIAL_CHARS),
            'parent_id' => $this->request->getPost('parentid'),
            'parent_type' => $this->request->getPost('parenttype'),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'edit_date' => date("Y-m-d H:i:s"),
            'creation_date' => date("Y-m-d H:i:s"),
        ];



        if($this->request->getPost('active'))
        { 
            $opportunityData['active'] = $this->request->getPost('active');
        }
        else{  $opportunityData['active'] = 1; }

        if($this->request->getPost('id'))//ja ieraksts tiek labots
        { 
            $opportunityData['id'] = $this->request->getPost('id');
            $oldData = $opportunitiesModel->select('mc_opportunities.*, mc_users.name AS user_name, mc_users.surname AS user_surname, mc_users.id AS user_id')->
            join('mc_users', 'mc_users.id = mc_opportunities.user_id', 'left')->where('mc_opportunities.id', $opportunityData['id'])->first();

            //iespējams vajag veikt pārbaudi vai lietotājs var labot ierakstu
        }
        else{ $opportunityData['creation_date'] = date("Y-m-d H:i:s"); }

        if($this->request->getPost('userid'))
        {
            $opportunityData['user_id'] = $this->request->getPost('userid');
        }
        else{ $opportunityData['user_id'] = 0; }

        $actionHistoryLog = new ActionHistoryLibrary();


        if ($opportunitiesModel->save($opportunityData))
        {

            if(!$this->request->getPost('id'))
            {
                $opportunityData['id'] = $opportunitiesModel->getInsertID();
                $actionHistoryLog->createOpportunity($opportunityData);
            }
            else{ $actionHistoryLog->updateOpportunity($opportunityData, $oldData);}

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/opportunity/').$opportunityData['id']);
            
        }
        else
        {
            session()->setFlashdata('error', lang('Crm.error'));
            return redirect()->to(base_url('crm/opportunities/'));
        }


    }


    public function opportunity($opportunityId)
    {

        $opportunitiesModel = new \App\Models\OpportunitiesModel();
        $crmModel = new \App\Models\CrmModel();


        $data['opportunityData'] = $opportunitiesModel->getOpportunity($opportunityId);
        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        if(!userAdmin() AND $data['opportunityData']['active'] == 0)
        {
            session()->setFlashdata('error', lang('Crm.recordNotAvailable'));
            return redirect()->to(base_url('crm/opportunities/'));
        }


        if (!allowedToView($data['opportunityData']['user_id'])) 
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable'));
            return redirect()->to(base_url('crm/opportunities/'));
        }



        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.opportunity').' - '. $data['opportunityData']['title'];

        return view('default/head_part', $headData)
        .view('default/crm/crm_see_opportunity.php', $data)
        .view('default/footer_part.php');

    }

    public function edit($opportunityId)
    {

        $opportunitiesModel = new \App\Models\OpportunitiesModel();
        $crmModel = new \App\Models\CrmModel();

        $data['currencies'] = $crmModel->getCurencies()->getResultArray();

        $data['opportunityData'] = $opportunitiesModel->getOpportunity($opportunityId);
        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        $data['checkCurrency'] = $crmModel->checkCurency($data['opportunityData']['currency']); 

        //var_dump($data['checkCurrency']); exit();
        $headData['title'] = lang('Crm.crmTitle').' - '.lang('Crm.opportunity').' - '.lang('Crm.edit').' - '.$data['opportunityData']['title'];

        return view('default/head_part', $headData)
        .view('default/crm/crm_edit_opportunity.php', $data)
        .view('default/footer_part.php');

    }





}
