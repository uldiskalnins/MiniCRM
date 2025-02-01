<?php

namespace App\Controllers\Crm;

use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Activities extends BaseController
{


    protected $helpers = ['crm_helper','text'];
    private $appSettings;
    private $allowedParentsTypesId;

    public function __construct()
    {

        $this->appSettings =  new \Config\App();
        $this->allowedParentsTypesId =  [1,2,3,8];

    }

    public function newEmail()
    {
        $data = getParentDataByGet();
        if(!$data){ session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));}

        $data['allowedUploadFileTypes'] =  $this->appSettings->allowedUploadFileTypes;

        $usersModel = new \App\Models\UsersModel();
        $crmModel = new \App\Models\CrmModel();


        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();
        $data['user'] = $usersModel->find(session()->get('userId'));


        $headData['title'] = lang('Crm.crmTitle') . ' - '. lang('Crm.newEmail');

        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_new_email.php', $data)
            . view('default/footer_part.php');
    }


    public function saveEmail()
    {

        $appConfig = new \Config\App();


        $rules = [
            'toemail'   => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'Install.invalidEmail',
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'fromemail' => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'Install.invalidEmail',
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'cc'        => [
                'rules' => 'permit_empty|valid_email|',
                'errors' => [
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'bcc'       => [
                'rules' => 'permit_empty|valid_email|',
                'errors' => [
                    'valid_email' => 'Install.invalidEmail',
                ]
            ],
            'subject'   => [
                'rules' => 'required|string|max_length[1000]',
                'errors' => [
                    'required' => 'Crm.error',
                    'max_length' => 'Crm.error',
                    'string' => 'Crm.error',
                ]
            ],
            'body'       => [
                'rules' => 'required|string|max_length[10000]',
                'errors' => [
                    'required' => 'Crm.error',
                    'max_length' => 'Crm.error',
                    'string' => 'Crm.error',
                    ]
            ],
            'action'       => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'parenttype'   => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'parentid'   => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'userfullname' => [
                'rules' => 'permit_empty|string|max_length[500]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string'=> 'Crm.invalidNameSurname',
                ]
            ],
            'file'   => [
                'rules' => 'permit_empty|ext_in[file,'.$appConfig->allowedUploadFileTypes.']',
                'errors' => [
                    'ext_in' => 'Crm.invalidFileType',
                ]
            ],

        ];



        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors('my_list'));
            return redirect()->to(base_url('crm/'));
        }

        $settingsModel = new \App\Models\SettingsModel();
        $emailsModel = new \App\Models\EmailsModel();



        $emailData = [
            'from_email' => $this->request->getPost('fromemail'),
            'to_email' => $this->request->getPost('toemail'),
            'cc' => $this->request->getPost('cc'),
            'bcc' => $this->request->getPost('bcc'),
            'subject' => esc($this->request->getPost('subject')),
            'body' => $this->request->getPost('body'),
            'from_name' => session()->get('userName') . ' ' . session()->get('userSurname'),
            'edit_date' => date("Y-m-d H:i:s"),
            'action_type' => $this->request->getPost('action'),
            'parent_type' => $this->request->getPost('parenttype'),
            'parent_id' => $this->request->getPost('parentid'),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'active' => 1,
        ];


        if ($this->request->getPost('userid')) {
            $emailData['user_id'] = $this->request->getPost('userid');
        }
        else{
            
            if (userAdmin()){$emailData['user_id'] = 0;}
            else{$emailData['user_id'] = session()->get('userId');}

        }

        if ($this->request->getPost('id')) {
            $emailData['id'] = $this->request->getPost('id');

            $getEmail = $emailsModel->getEmail($emailData['id']);

            if(!allowedToEdit($getEmail['user_id'])){
                session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
            }
        }
        else{$emailData['creation_date'] =  date("Y-m-d H:i:s");}


        boolval($settingsModel->useSmtp) ? $eConfig['protocol'] = 'smtp' : $eConfig['protocol'] = 'mail';


        $eConfig['SMTPHost']    = $settingsModel->smtpServer;
        $eConfig['SMTPUser']    = $settingsModel->smtpUser;
        $eConfig['SMTPPass']    = $settingsModel->smtpPass;
        $eConfig['SMTPPort']    = $settingsModel->smtpPort;
        $eConfig['SMTPCrypto']  = $settingsModel->smtpEncryption;
        $eConfig['wordWrap']    = TRUE;
        $eConfig['mailType']    = 'html';
        $eConfig['charset'] = 'utf-8';

        $email = \Config\Services::email();
        $email->initialize($eConfig);



        $attachedFiles = array();

        if ($emailFiles = $this->request->getFileMultiple('file')) 
        {
            foreach ($emailFiles as $file) 
            {
                if ($file->isValid() AND !$file->hasMoved())
                {
                    $attachedFiles[] = $newName  = session()->get('userId') . '-' . $emailData['parent_type'] . '-' . $emailData['parent_id'] . '-' . date("YmdHis"). '-'. random_string('alnum', 5) . '!!-!!' . $file->getName();

                    $email->attach($file->getTempName(), 'attachment', $file->getName());

                    $file->move(ROOTPATH . 'public/uploads/email/', $newName);

                }
            }
        }


        $actionHistoryLog = new ActionHistoryLibrary();

        if ($emailData['action_type'] == 0 AND !isset($emailData['id'])) :

            $email->setTo($emailData['to_email']);
            $email->setFrom($emailData['from_email'], $emailData['from_name']);
            $email->setCC($emailData['cc']);
            $email->setBCC($emailData['bcc']);
            $email->setSubject($emailData['subject']);
            $email->setMessage($emailData['body']);


            if ($email->send()) 
            {

                $emailsModel->insert($emailData);

                $emailData['id'] = $emailsModel->insertID();


                addFilesListToDb($attachedFiles, 6, $emailData['id']);


                $actionHistoryLog->saveEmail($emailData, 1);

                session()->setFlashdata('message', lang('Crm.actionOk'));
                return redirect()->to(base_url('crm/activities/email/' . $emailData['id']));

            }
            else
            {
                deleteListedFiles($attachedFiles, 'email');
            
                session()->setFlashdata('error', $email->printDebugger(['headers']));
                return redirect()->to(base_url('crm/'));
            }


        else:

            if ($emailsModel->save($emailData))
            {
                if(isset($emailData['id'])){$new = 0; }
                else{$emailData['id'] = $emailsModel->insertID(); $new = 1;}

                addFilesListToDb($attachedFiles, 6, $emailData['id']);

                $actionHistoryLog->saveEmail($emailData, $new);

                session()->setFlashdata('message', lang('Crm.actionOk'));
                return redirect()->to(base_url('crm/activities/email/' . $emailData['id']));
            }
            else 
            {
                deleteListedFiles($attachedFiles, 'email');

                session()->setFlashdata('error', lang('Crm.error'));
                return redirect()->to(base_url('crm/'));
            }
        endif;
    }


    public function email($emailId)
    {

        $emailsModel = new \App\Models\EmailsModel();
        $filesModel = new \App\Models\FilesModel();
        $crmModel = new \App\Models\CrmModel();


        if(!$data['emailData'] = $emailsModel->getEmail($emailId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToView($data['emailData']['user_id'])){
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }

        //E-pastu parent_type ir 6. Vecāku tipi ir noteikti mc_posts_parents tabulā
        $data['emailFiles'] = $filesModel->select()->where('parent_type', 6)->where('parent_id', $emailId )->orderBy('id', 'DESC')->findAll();


        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.emails') . ' - ' . $data['emailData']['subject'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_see_email.php', $data)
            . view('default/footer_part.php');
    }

    public function editEmail($emailId)
    {

        $data['allowedUploadFileTypes'] =  $this->appSettings->allowedUploadFileTypes;

        $emailsModel = new \App\Models\EmailsModel();
        $filesModel = new \App\Models\FilesModel();
        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        if(!$data['emailData'] = $emailsModel->getEmail($emailId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToEdit($data['emailData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }


        $data['emailFiles'] = $filesModel->select()->where('parent_type',3)->where('parent_id', $emailId )->orderBy('id', 'DESC')->findAll();


        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.emails') . ' - ' . $data['emailData']['subject'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_edit_email.php', $data)
            . view('default/footer_part.php');
    }


    public function allEmails()
    {

        $emailsModel = new \App\Models\EmailsModel();
        $crmModel = new \App\Models\CrmModel();

        $pager = service('pager');
        $page  = (int) ($this->request->getGet('page') ?? 1);

        if (allowedToViewAllUsersRecords())
        {

            $perPage = 20;
            $total   = $emailsModel->countAll();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');

            $data['emails'] = $emailsModel->getAllEmailsWithUser(0, $limitFrom, $perPage);

        }
        else
        {

            $perPage = 20;
            $total   = $emailsModel->where('user_id', session()->get('userId'))->countAllResults();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');

            $data['emails'] = $emailsModel->getAllEmailsWithUser(session()->get('userId'), $limitFrom, $perPage);
        }

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.emails') ;

        return view('default/head_part', $headData)
            . view('default/crm/crm_emails_list.php', $data)
            . view('default/footer_part.php');


    }
    public function newCall()
    {
        $data = getParentDataByGet();
        if(!$data){ session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));}

        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.activities') . ' - ' .lang('Crm.calls'). ' - '.lang('Crm.createNew');


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_new_call.php', $data)
            . view('default/footer_part.php');
    }



    public function call($callId)
    {


        $callsModel = new \App\Models\CallsModel();
        $callsParticipantsModel = new \App\Models\CallsParticipantsModel();
        $crmModel = new \App\Models\CrmModel();

        if(!$data['callData'] = $callsModel->getCall($callId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToView($data['callData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }


        $data['secondaryParent'] = $callsParticipantsModel->getSecondaryParticipant($callId , $data['callData']['parent_type'], $data['callData']['parent_id']);

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.calls') . ' - ' . $data['callData']['title'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_see_call.php', $data)
            . view('default/footer_part.php');
    }


    public function saveCall()
    {

        $rules = [
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Crm.invalidTitle',
                ]
            ],
            'type' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'status' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'startdate' => [
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'Crm.invalidDate',
                    'valid_date' => 'Crm.invalidStartDate'
                ]
            ],
            'enddate' => [
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'Crm.invalidDate',
                    'valid_date' => 'Crm.invalidEndDate'
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|max_length[20000]',
                'errors' => [
                    'max_length' => 'Crm.error'
                ]
            ],
            'parentid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'parenttype' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'secondaryparentaccountid' => [
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
            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
        ];


        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors());
            return redirect()->to(base_url('crm/'));
        }

        $callsModel = new \App\Models\CallsModel();
        $callsParticipantsModel = new \App\Models\CallsParticipantsModel();


        $callData = [
            'title' => $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
            'start_date' => $this->request->getPost('startdate'),
            'end_date' => $this->request->getPost('enddate'),
            'type' => $this->request->getPost('type'),
            'status' => $this->request->getPost('status'),
            'user_id' => $this->request->getPost('userid'),
            'parent_id' => $this->request->getPost('parentid'),
            'parent_type' => $this->request->getPost('parenttype'),
            'activity_type' => 4,
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'edit_date' => date("Y-m-d H:i:s"),
        ];
        //Primārā parent dati tiek dublēti, lai vienkāršotu un paātrinātu pieprasījumus un
        // izvairītos no papildus kolonas dalībnieku tabulā



        if(!allowedToEdit($callData['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }

        if ($this->request->getPost('id')) 
        {
            $callData['id'] = $this->request->getPost('id');
            $callsParticipantsModel->where('call_id', $callData['id'])->delete();

        }
        else{
            $callData['creation_date'] = date("Y-m-d H:i:s");
        }

        if ($callsModel->save($callData)) 
        {
            $actionHistoryLog = new ActionHistoryLibrary();

            if (!isset($callData['id'])){$callData['id'] = $callsModel->insertID(); $new = 1;} else {$new = 0;}

            $actionHistoryLog->saveActivity($callData, $new);

            if (($this->request->getPost('parenttype')) AND ($this->request->getPost('parentid'))) 
            {

                $callParticipants = array(
                    array('call_id' => $callData['id'], 'parent_type' => $this->request->getPost('parenttype'), 'parent_id' => $this->request->getPost('parentid'))
                );

                if ($this->request->getPost('secondaryparentaccountid'))
                {
                    $callParticipants[] = array('call_id' => $callData['id'], 'parent_type' => 1, 'parent_id' => $this->request->getPost('secondaryparentaccountid'));
                }

                $callsParticipantsModel->insertBatch($callParticipants);
            }

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/activities/call/' . $callData['id']));
        }
        else 
        {
            session()->setFlashdata('error', 'Crm.error');
            return redirect()->to(base_url('crm/'));
        }
    }

    public function editCall($callId)
    {

        $callsModel = new \App\Models\CallsModel();

        if(!$data['callData'] = $callsModel->getCall($callId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToEdit($data['callData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }


        $callsParticipantsModel = new \App\Models\CallsParticipantsModel();
        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        $data['secondaryParent'] = $callsParticipantsModel->getSecondaryParticipant($callId , $data['callData']['parent_type'], $data['callData']['parent_id']);
 
        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.calls') . ' - ' . $data['callData']['title'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_edit_call.php', $data)
            . view('default/footer_part.php');
    }


    public function allCalls()
    {

        $callsModel = new \App\Models\CallsModel();
        $crmModel = new \App\Models\CrmModel();

        $pager = service('pager');
        $page  = (int) ($this->request->getGet('page') ?? 1);


        if (allowedToViewAllUsersRecords())
        {
            $perPage = 20;
            $total   = $callsModel->countAll();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['calls'] = $callsModel->getAllCallsWithUsers(0, $limitFrom, $perPage);

        }
        else

        { //
            $perPage = 20;
            //$total   = $callsModel->where('user_id', session()->get('userId'))->countAllResults();
            $total   = $callsModel->countCallsWithActiveParent(session()->get('userId'));
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['calls'] = $callsModel->getAllCallsWithUsers(session()->get('userId'), $limitFrom, $perPage);

        }


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.calls') ;

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        return view('default/head_part', $headData)
            . view('default/crm/crm_calls_list.php', $data)
            . view('default/footer_part.php');
    }

    public function allMeetings()
    {

        $meetingsModel = new \App\Models\MeetingsModel();
        $crmModel = new \App\Models\CrmModel();

        $pager = service('pager');
        $page  = (int) ($this->request->getGet('page') ?? 1);


        if (allowedToViewAllUsersRecords())
        {


            $perPage = 20;
            $total   = $meetingsModel->countAll();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['meetings'] = $meetingsModel->getAllMeetingsWithUsers(0, $limitFrom, $perPage);

        }
        else
        {

            $perPage = 20;
            $total   = $meetingsModel->where('user_id', session()->get('userId'))->countAllResults();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
    
            $data['meetings'] = $meetingsModel->getAllMeetingsWithUsers(session()->get('userId'), $limitFrom, $perPage);
        }


        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.meetings') ;

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        return view('default/head_part', $headData)
            . view('default/crm/crm_meetings_list.php', $data)
            . view('default/footer_part.php');

        }




    public function newMeeting()
    {

        $data = getParentDataByGet();
        if(!$data){ session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));}


        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();

        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.activities') . ' - ' . lang('Crm.createNew');


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_new_meeting.php', $data)
            . view('default/footer_part.php');
    }

    public function saveMeeting()
    {


        $rules = [
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Crm.invalidTitle',
                ]
            ],
            'status' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.error',
                ]
            ],
            'startdate' => [
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'Crm.invalidStartDate',
                    'valid_date' => 'Crm.invalidStartDate'
                ]
            ],
            'enddate' => [
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'Crm.invalidEndDate',
                    'valid_date' => 'Crm.invalidEndDate'
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|max_length[20000]',
                'errors' => [
                    'max_length' => 'Crm.error'
                ]
            ],
            'parentid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'parenttype' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
            'secondaryparentaccountid' => [
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
            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.error'
                ]
            ],
        ];


        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors());
            return redirect()->to(base_url('crm/'));
        }



        $meetingsModel = new \App\Models\MeetingsModel();
        $meetingsParticipantsModel = new \App\Models\MeetingsParticipantsModel();


        $meetingData = [
            'title' => $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
            'start_date' => $this->request->getPost('startdate'),
            'end_date' => $this->request->getPost('enddate'),
            'status' => $this->request->getPost('status'),
            'parent_id' => $this->request->getPost('parentid'),
            'parent_type' => $this->request->getPost('parenttype'),
            'user_id' => $this->request->getPost('userid'),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'activity_type' => 5,
            'edit_date' => date("Y-m-d H:i:s"),
        ];

        //Primārā parent dati tiek dublēti, lai vienkāršotu un paātrinātu pieprasījumus un
        // izvairītos no papildus kolonas dalībnieku tabulā.


        if(!allowedToEdit($meetingData['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }

        if ($this->request->getPost('id')) 
        {
            $meetingData['id'] = $meetingId = $this->request->getPost('id');
            $meetingsParticipantsModel->where('meeting_id', $meetingData['id'])->delete();
        }
        else{
            $meetingData['creation_date'] = date("Y-m-d H:i:s");
        }


        if ($meetingsModel->save($meetingData)) 
        {

            $actionHistoryLog = new ActionHistoryLibrary();

            if (!isset($meetingData['id'])){$meetingData['id'] = $meetingsModel->insertID(); $new = 1;}else {$new = 0;}
            $actionHistoryLog->saveActivity($meetingData, $new);

            if (($this->request->getPost('parenttype')) AND ($this->request->getPost('parentid'))) 
            {

                $meetingParticipants = array(
                    array('meeting_id' => $meetingData['id'], 'parent_type' => $this->request->getPost('parenttype'), 'parent_id' => $this->request->getPost('parentid'))
                );

                if ($this->request->getPost('secondaryparentaccountid'))
                {
                    $meetingParticipants[] = array('meeting_id' => $meetingData['id'], 'parent_type' => 1, 'parent_id' => $this->request->getPost('secondaryparentaccountid'));
                }
                $meetingsParticipantsModel->insertBatch($meetingParticipants);

            }

            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/activities/meeting/').$meetingData['id']);
        }
        else 
        {
            session()->setFlashdata('error', 'Crm.error');
            return redirect()->to(base_url('crm/'));
        }
    }

    public function meeting($meetingId)
    {

        $meetingsModel = new \App\Models\MeetingsModel();
        $meetingsParticipantsModel = new \App\Models\MeetingsParticipantsModel();
        $crmModel = new \App\Models\CrmModel();

        if(!$data['meetingData'] = $meetingsModel->getMeeting($meetingId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToView($data['meetingData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }


        $data['secondaryParent'] = $meetingsParticipantsModel->getSecondaryParticipant($meetingId , $data['meetingData']['parent_type'], $data['meetingData']['parent_id']);

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.meetings') . ' - ' . $data['meetingData']['title'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_see_meeting.php', $data)
            . view('default/footer_part.php');
    }



    public function editMeeting($meetingId)
    {

        $meetingsModel = new \App\Models\MeetingsModel();
        $meetingsParticipantsModel = new \App\Models\MeetingsParticipantsModel();


        if(!$data['meetingData'] = $meetingsModel->getMeeting($meetingId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToEdit($data['meetingData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }

        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();

        $data['secondaryParent'] = $meetingsParticipantsModel->getSecondaryParticipant($meetingId , $data['meetingData']['parent_type'], $data['meetingData']['parent_id']);




        if(!allowedToEdit($data['meetingData']['user_id'])){
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }



        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.meetings') . ' - ' . $data['meetingData']['title'];


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_edit_meeting.php', $data)
            . view('default/footer_part.php');
    }


    public function newTask()
    {

        $data = getParentDataByGet();
        if(!$data){ session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));}


        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.newTask');


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_new_task.php', $data)
            . view('default/footer_part.php');

    }


    public function saveTask()
    {

        $tasksModel = new \App\Models\TasksModel();


        $rules = [
            'title' => [
                'rules' => 'required|string',
                'errors' => [
                    'required' => 'Crm.invalidTitle',
                    'string' => 'Crm.invalidTitle',
                ]
            ],
            'priority' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.invalidInteger',
                ]
            ],
            'status' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Crm.error',
                    'integer' => 'Crm.invalidInteger',
                ]
            ],
            'startdate' => [
                'rules' => 'permit_empty|valid_date[Y-m-d H:i]',
                'errors' => [
                    'valid_date' => 'Crm.invalidStartDate'
                ]
            ],
            'enddate' => [
                'rules' => 'permit_empty|valid_date[Y-m-d H:i]',
                'errors' => [
                    'valid_date' => 'Crm.invalidEndDate'
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|max_length[20000]',
                'errors' => [
                    'max_length' => 'Crm.error'
                ]
            ],
            'parenttype' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'parentid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
            'userfullname' => [
                'rules' => 'permit_empty|string|max_length[500]',
                'errors' => [
                    'max_length' => 'Crm.invalidNameSurname',
                    'string'=> 'Crm.invalidNameSurname',
                ]
            ],
            'userid' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Crm.invalidInteger'
                ]
            ],
        ];


        if (!$this->validate($rules)) {
            session()->setFlashdata('error', \Config\Services::validation()->listErrors());
            return redirect()->to(base_url('crm/'));
        }

        $taskData = [
            'title' => $this->request->getPost('title', FILTER_SANITIZE_SPECIAL_CHARS),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
            'start_date' => (empty($this->request->getPost('startdate')) ? null : $this->request->getPost('startdate')),
            'end_date' => (empty($this->request->getPost('enddate')) ? null : $this->request->getPost('enddate')),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status'),
            'parent_type' => $this->request->getPost('parenttype'),
            'parent_id' => $this->request->getPost('parentid'),
            'user_id' => $this->request->getPost('userid'),
            'user_full_name' => $this->request->getPost('userfullname',FILTER_SANITIZE_SPECIAL_CHARS),
            'activity_type' => 7,
            'edit_date' => date("Y-m-d H:i:s"),
        ];

        if ($this->request->getPost('id')) {
            $taskData['id'] = $this->request->getPost('id');

            if(!allowedToEdit($taskData['user_id'])){
                session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
            }
        }
        else{
            $taskData['creation_date'] = date("Y-m-d H:i:s");
        }

        if ($tasksModel->save($taskData)) 
        {
            $actionHistoryLog = new ActionHistoryLibrary();

            if(!isset($taskData['id'])){$taskData['id'] = $tasksModel->insertID(); $new = 1;} else{$new = 0; } 
            $actionHistoryLog->saveActivity($taskData, $new);


            session()->setFlashdata('message', lang('Crm.actionOk'));
            return redirect()->to(base_url('crm/activities/task/').$taskData['id']);
        }
        else
        {
            session()->setFlashdata('error', lang('Crm.error'));
            return redirect()->to(base_url('crm/'));
        }
    }


    public function task($taskId)
    {
        $tasksModel = new \App\Models\TasksModel();
        $crmModel = new \App\Models\CrmModel();

        if(!$data['taskData'] = $tasksModel->getTask($taskId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToView($data['taskData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }

        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.meetings') . ' - ' . $data['taskData']['title'];


        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_see_task.php', $data)
            . view('default/footer_part.php');
    }


    public function editTask($taskId)
    {


        $tasksModel = new \App\Models\TasksModel();

        if(!$data['taskData'] = $tasksModel->getTask($taskId))
        {
            session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToEdit($data['taskData']['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.youCannotEdit')); return redirect()->to(base_url('crm/'));
        }

        $crmModel = new \App\Models\CrmModel();

        // pieprasa pēc tipiem no mc_posts_parents tabulas
        $data['allowedParents'] =  $crmModel->getAllowedParents($this->allowedParentsTypesId)->getResult();


        
        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.newMeeting');


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_edit_task.php', $data)
            . view('default/footer_part.php');
    }



    public function allTasks()
    {
        $tasksModel = new \App\Models\TasksModel();
        $crmModel = new \App\Models\CrmModel();


        $pager = service('pager');
        $page  = (int) ($this->request->getGet('page') ?? 1);

        if (allowedToViewAllUsersRecords())
        {

            $perPage = 20;
            $total   = $tasksModel->countAll();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');

            $data['tasks'] = $tasksModel->getAllTasksWithUser(0, $limitFrom, $perPage);

        }
        else
        {

            $perPage = 20;
            $total   = $tasksModel->where('user_id', session()->get('userId'))->countAllResults();
            $limitFrom = ($page * $perPage) - $perPage ;

            $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');

            $data['tasks'] = $tasksModel->getAllTasksWithUser(session()->get('userId'), $limitFrom, $perPage);
        }

        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.emails') ;

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        return view('default/head_part', $headData)
            . view('default/crm/crm_tasks_list.php', $data)
            . view('default/footer_part.php');

    }

    public function activitiesHistory($type, $id)
    {

        switch ($type) {

            case 1:
                $companiesModel = new \App\Models\CompaniesModel();

                if(!$unitData = $companiesModel->getCompanyWithUserById($id))
                {
                    session()->setFlashdata('error', lang('Crm.companyNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['title'];

                break;
            case 2:
                $personsModel = new \App\Models\PersonsModel();

                if(!$unitData = $personsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.personNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['name'] . ' ' . $unitData['surname'];

                break;
            case 3:
                $leadsModel = new \App\Models\LeadsModel();

                if(!$unitData = $leadsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.leadNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['name'] . ' ' . $unitData['surname'];

                break;
                case 8:
                $opportunitiesModel = new \App\Models\OpportunitiesModel();
    
                if(!$unitData =  $opportunitiesModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.leadNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['title'];

                break;
            default:

                session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }

        if(!allowedToView($unitData['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }


        $data['id'] = $id; $data['type'] = $type;

        $data['getIdentifier'] = [
            1 => 'companyid',
            2 => 'personid',
            3 => 'leadid',
            8 => 'opportunityid'
        ];

        $crmModel = new \App\Models\CrmModel();
        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');


        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = $crmModel->countUnitActivitiesHistory($id,$type)->count_history;
        $limitFrom = ($page * $perPage) - $perPage ;


        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');

        $data['activitiesList'] = $crmModel->getUnitActivitiesHistoryITDUList($id, $limitFrom, $perPage, $type);

        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.activitiesHistory');


        return view('default/head_part', $headData)
            . view('default/crm/crm_activities_history.php', $data)
            . view('default/footer_part.php');

    }


    public function unitTasks($type, $id)
    {

        switch ($type) {

            case 1:
                $companiesModel = new \App\Models\CompaniesModel();

                if(!$unitData = $companiesModel->getCompanyWithUserById($id))
                {
                    session()->setFlashdata('error', lang('Crm.companyNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['title'];

                break;
            case 2:
                $personsModel = new \App\Models\PersonsModel();

                if(!$unitData = $personsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.personNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['name'] . ' ' . $unitData['surname'];

                break;
            case 3:
                $leadsModel = new \App\Models\LeadsModel();

                if(!$unitData = $leadsModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.leadNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['name'] . ' ' . $unitData['surname'];

                break;
                case 8:
                $opportunitiesModel = new \App\Models\OpportunitiesModel();
    
                if(!$unitData =  $opportunitiesModel->where('id', $id)->first())
                {
                    session()->setFlashdata('error', lang('Crm.leadNotFound')); return redirect()->to(base_url('crm/'));
                }

                $data['title'] = $unitData['title'];

                break;
            default:

                session()->setFlashdata('error', lang('Crm.error')); return redirect()->to(base_url('crm/'));
        }


        if(!allowedToView($unitData['user_id']))
        {
            session()->setFlashdata('error', lang('Crm.ActionNotAvailable')); return redirect()->to(base_url('crm/'));
        }


        $data['id'] = $id; $data['type'] = $type;

        $data['getIdentifier'] = [
            1 => 'companyid',
            2 => 'personid',
            3 => 'leadid',
            8 => 'opportunityid'
        ];


        $tasksModel = new \App\Models\TasksModel();
        $crmModel = new \App\Models\CrmModel();

        $data['allowedParents'] = array_column($crmModel->getAllowedParents($this->allowedParentsTypesId)->getResultArray(), null, 'id');

        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = $tasksModel->countUnitTasks($id, $type);
        $limitFrom = ($page * $perPage) - $perPage ;

        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total,'my_pagination');
        $data['tasks'] = $tasksModel->getUnitTasksList($id, $limitFrom, $perPage, $type);


        $headData['title'] = lang('Crm.crmTitle') . ' - ' . lang('Crm.tasks');

        return view('default/head_part', $headData)
            . view('default/crm/crm_unit_tasks_list.php', $data)
            . view('default/footer_part.php');

    }



}
