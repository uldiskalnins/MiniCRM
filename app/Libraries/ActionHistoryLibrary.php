<?php 

namespace App\Libraries;


class ActionHistoryLibrary
{
    protected $historyModel;
    protected $usersModel;

    public function __construct()
    {
        $this->historyModel = new \App\Models\HistoryModel();
        $this->usersModel = new \App\Models\UsersModel();
    }


    public function createContact($type, $data)
    {
        if ($data['user_id'] != session()->get('userId'))
        {
            $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id']);
            $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        }

        $historyData['user_id'] = session()->get('userId');
        $historyData['parent_type'] = $type;
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;
        $historyData['action_type'] = 'Create';

        return $this->historyModel->insert($historyData);

    }

    public function updateContact($type, $data, $oldData)
    {
        if ($data['user_id'] != $oldData['user_id'])
        {
            if (!empty($oldData['user_id']))
            {
                $oldAssignedUserName = $this->usersModel->select('CONCAT(name, " ", surname) AS user_full_name')->where('id', $oldData['user_id'])->first()['user_full_name'];
            }
            else{$oldAssignedUserName = '';}
            $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id'], 'oldAssignedUserName' => $oldAssignedUserName, 'oldAssignedUserId' => $oldData['user_id']);
            $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        }

        $historyData['user_id'] = session()->get('userId');
        $historyData['parent_type'] = $type;
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;
        $historyData['action_type'] = 'Update';

        return $this->historyModel->insert($historyData);
    }

    public function createOpportunity($data)
    {

        $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id'], 'title' => $data['title']);
        $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);


        $historyData['user_id'] = session()->get('userId');
        $historyData['parent_type'] = 8;
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;
        $historyData['action_type'] = 'Create';
        $historyData['super_parent_type'] = $data['parent_type'];
        $historyData['super_parent_id'] = $data['parent_id'];

        return $this->historyModel->insert($historyData);

    }
    public function updateOpportunity($data, $oldData)
    {
        if ($data['user_id'] != $oldData['user_id'])
        {
            if (!empty($oldData['user_id']))
            {
                $oldAssignedUserName = $this->usersModel->select('CONCAT(name, " ", surname) AS user_full_name')->where('id', $oldData['user_id'])->first()['user_full_name'];
            }
            else{$oldAssignedUserName = '';}
            $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id'], 'oldAssignedUserName' => $oldAssignedUserName, 'oldAssignedUserId' => $oldData['user_id']);
    
        }
        else
        {
            $jsonData = array('title' => $data['title']);
        }

        $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);

        $historyData['user_id'] = session()->get('userId');
        $historyData['parent_type'] = 8;
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;
        $historyData['action_type'] = 'Update';
        $historyData['super_parent_type'] = $data['parent_type'];
        $historyData['super_parent_id'] = $data['parent_id'];

        return $this->historyModel->insert($historyData);
    }
    public function deleteUndelete($type, $id, $action)
    {
        $historyData['user_id'] = session()->get('userId');
        $historyData['parent_type'] = $type;
        $historyData['parent_id'] = $id;
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;
        $historyData['action_type'] = empty($action) ? 'Delete' : 'Undelete';
        return $this->historyModel->insert($historyData);
    }

    public function saveEmail($data, $new)
    {
        $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id'], 'emailSubject' => $data['subject']);
        $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);

        $historyData['user_id'] = session()->get('userId');
        $historyData['super_parent_type'] = $data['parent_type'];//jāuztaisa, ka ja parent id = 0 arī parent type ir jābūt 0
        $historyData['super_parent_id'] = $data['parent_id'];
        $historyData['parent_type'] = 6;
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;

        $historyData['action_type'] = empty($new) ? 'Update' : 'Create';
        return $this->historyModel->insert($historyData);

    }
    public function saveActivity($data, $new)
    {
        $jsonData = array('assignedUserName' => $data['user_full_name'], 'assignedUserId' =>  $data['user_id'], 'title' => $data['title']);
        $historyData['data'] = json_encode($jsonData, JSON_UNESCAPED_UNICODE);

        $historyData['user_id'] = session()->get('userId');
        $historyData['super_parent_type'] = $data['parent_type'];//jāuztaisa, ka ja parent id = 0 arī parent type ir jābūt 0
        $historyData['super_parent_id'] = $data['parent_id'];
        $historyData['parent_type'] = $data['activity_type'];
        $historyData['parent_id'] = $data['id'];
        $historyData['creation_date'] = date("Y-m-d H:i:s");
        $historyData['active'] = 1;

        $historyData['action_type'] = empty($new) ? 'Update' : 'Create';
        return $this->historyModel->insert($historyData);

    }
    public function saveNote($data)
    {
        return $this->historyModel->insert([
            'user_id' => session()->get('userId'),
            'parent_type' => $data['type'],
            'parent_id' => $data['id'],
            'creation_date' => date("Y-m-d H:i:s"),
            'active' => 1,
            'action_type' => 'Note',
            'data' => json_encode(['note' => $data['note']], JSON_UNESCAPED_UNICODE),
        ]);
    }


    public function decodeData($data)
    {

        switch ($data->parent_type) {
            case 1:
                return $this->decodeContactData($data);
            break;
            case 2:
                return $this->decodeContactData($data);
            break;
            case 3:
                return $this->decodeContactData($data);
            break;
            case 4:
               return $this->decodeCallData($data);
            break;
            case 5:
                return $this->decodeMeetingData($data);
            break;
            case 6:
                return $this->decodeEmailData($data);
            break;
            case 7:
                return $this->decodeTaskData($data);
            break;
            case 8:
                return $this->decodeOpportunityData($data); 
            break;
            default:
                return '';
          }

    }


    protected function decodeOpportunityData($data)
    {


        if (is_null($decodedData = json_decode($data->data))){return $data->action_type;}


        switch ($data->action_type) {
            case 'Create':

                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.createRelatedOpportunity').'. ';
                }
                else{$returnActionText = lang('Crm.createOpportunity').'. ';}

                if (isset($decodedData->title)){$returnActionText .= ' <a href ="'.base_url('crm/opportunity/'.$data->parent_id).'">'. $decodedData->title.'</a>. ';}

                if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                elseif($decodedData->assignedUserId != $data->user_id)
                { 
                    $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a> ';
                }
                else{$returnUserText =  lang('Crm.assignedToSelf') ;}

                return $returnActionText .' '. $returnUserText;

            break;
            case 'Update': 
                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.updateRelatedOpportunity').'. ';
                }
                else{$returnActionText =  lang('Crm.updateOpportunity').'. ';}

                if (isset($decodedData->title)){$returnActionText .= ' <a href ="'.base_url('crm/opportunity/'.$data->parent_id).'">'. $decodedData->title.'</a>.';}


                if(empty($decodedData->assignedUserId))
                { 
                    $returnUserText = lang('Crm.assignedUserRemoved').'. ';
                }
                else 
                {
                    $returnUserText = lang('Crm.assignedUserChanged').'. ';
                    if (empty($decodedData->oldAssignedUserName)){$returnUserText .=  lang('Crm.noOldAssignedUser').'. ';}
                    else{$returnUserText .=  lang('Crm.oldAssignedUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->oldAssignedUserId).'">' .  $decodedData->oldAssignedUserName. '</a>. ';}
                    $returnUserText .=  lang('Crm.newAssignedUser').' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a>';
                }


                return $returnActionText . $returnUserText;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            case 'Delete':
                return lang('Crm.deleteRecord');
            break;
            case 'Undelete':
                return lang('Crm.undeleteRecord');
            break;
            default:
                return '';
        }

    }

    protected function decodeContactData($data)
    {

        switch ($data->action_type) {
            case 'Create':

                $returnCreateText = array(1 => lang('Crm.createAccount'), 2 => lang('Crm.createContact'), 3 => lang('Crm.createLead'));

                $returnActionText = $returnCreateText[$data->parent_type].'. ';

                if (is_null($decodedData = json_decode($data->data))){$returnUserText = lang('Crm.assignedToSelf');}
                else
                {
                    if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                    else 
                    {
                        $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a>';
                    }
                }

                return $returnActionText . $returnUserText;

            break;
            case 'Update':

                $returnUpdateText = array(1 => lang('Crm.updateAccount'), 2 => lang('Crm.updateContact'), 3 => lang('Crm.updateLead'));

                $returnActionText = $returnUpdateText[$data->parent_type].'. ';

                if (is_null($decodedData = json_decode($data->data))){return $returnActionText;}

                if(empty($decodedData->assignedUserId))
                { 
                    $returnUserText = lang('Crm.assignedUserRemoved').'. ';
                }
                else 
                {
                    $returnUserText = lang('Crm.assignedUserChanged').'. ';
                    if (empty($decodedData->oldAssignedUserName)){$returnUserText .=  lang('Crm.noOldAssignedUser').'. ';}
                    else{$returnUserText .=  lang('Crm.oldAssignedUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->oldAssignedUserId).'">' .  $decodedData->oldAssignedUserName. '</a>. ';}
                    $returnUserText .=  lang('Crm.newAssignedUser').' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a>';
                }

                return $returnActionText . $returnUserText;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            case 'Delete':
                return lang('Crm.deleteRecord');
            break;
            case 'Undelete':
                return lang('Crm.undeleteRecord');
            break;
            default:
                return '';
        }

    }


    protected function decodeCallData($data)
    {
        if (is_null($decodedData = json_decode($data->data))){return '';}


        switch ($data->action_type) {
            case 'Create':

                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.createRelatedCall');
                }
                else{$returnActionText = lang('Crm.createTheCall');}

                $returnLinkToCall = ' <a href ="'.base_url('crm/activities/call/'.$data->parent_id).'">'. $decodedData->title.'</a>. ';

                if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                elseif($decodedData->assignedUserId != $data->user_id)
                { 
                    $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a> ';
                }
                else{$returnUserText =  lang('Crm.assignedToSelf') ;}

                return $returnActionText . $returnLinkToCall .' '. $returnUserText;

            break;
            case 'Update': 
                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.updateRelatedCall');
                }
                else{$returnActionText = lang('Crm.updateCall');}

                $returnLinkToCall = ' <a href ="'.base_url('crm/activities/call/'.$data->parent_id).'">'. $decodedData->title.'</a>.';

                return $returnActionText . $returnLinkToCall;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            default:
                return '';

        }
    }

    protected function decodeMeetingData($data)
    {
        if (is_null($decodedData = json_decode($data->data))){return '';}

        switch ($data->action_type) {
            case 'Create':

                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.createRelatedMeeting');
                }
                else{$returnActionText = lang('Crm.createTheMeeting');}

                $returnLinkToMeeting = ' <a href ="'.base_url('crm/activities/meeting/'.$data->parent_id).'">'. $decodedData->title.'</a>. ';

                if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                elseif($decodedData->assignedUserId != $data->user_id)
                { 
                    $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a> ';
                }
                else{$returnUserText =  lang('Crm.assignedToSelf') ;}

                return $returnActionText . $returnLinkToMeeting . $returnUserText;

            break;
            case 'Update': 
                if (isset($data->super_parent_id)) //pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.updateRelatedMeeting');
                }
                else {$returnActionText = lang('Crm.updateMeeting');}

                $returnLinkToMeeting = ' <a href ="'.base_url('crm/activities/meeting/'.$data->parent_id).'">'. $decodedData->title.'</a>.';

                return $returnActionText . $returnLinkToMeeting;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            default:
                return '';

        }
    }

    protected function decodeEmailData($data)
    {
        if (is_null($decodedData = json_decode($data->data))){return '';}

        switch ($data->action_type) {
            case 'Create':

                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.createRelatedEmail');
                }
                else{$returnActionText = lang('Crm.createTheEmail');}

                $returnLinkToEmail = ' <a href ="'.base_url('crm/activities/email/'.$data->parent_id).'">'. $decodedData->emailSubject.'</a>. ';

                if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                elseif($decodedData->assignedUserId != $data->user_id)
                { 
                    $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a> ';
                }
                else{$returnUserText =  lang('Crm.assignedToSelf') ;}

                return $returnActionText . $returnLinkToEmail . $returnUserText;

            break;
            case 'Update': 
                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.updateRelatedEmail');
                }
                else{$returnActionText = lang('Crm.updateEmail'); }

                $returnLinkToEmail = ' <a href ="'.base_url('crm/activities/email/'.$data->parent_id).'">'. $decodedData->emailSubject.'</a>.';

                return $returnActionText . $returnLinkToEmail;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            default:
                return '';

        }
    }

    protected function decodeTaskData($data)
    {
        if (is_null($decodedData = json_decode($data->data))){return '';}

        switch ($data->action_type) {
            case 'Create':

                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.createRelatedTask');
                }
                else{$returnActionText = lang('Crm.createTheTask');}

                $returnLinkToTask = ' <a href ="'.base_url('crm/activities/task/'.$data->parent_id).'">'. $decodedData->title.'</a>. ';

                if(empty($decodedData->assignedUserId)){ $returnUserText = lang('Crm.userWasNotAssigned');}
                elseif($decodedData->assignedUserId != $data->user_id)
                { 
                    $returnUserText =  lang('Crm.assignedToTheUser') . ' <a href ="'.base_url('crm/user/'.$decodedData->assignedUserId).'">' .  $decodedData->assignedUserName. '</a> ';
                }
                else{$returnUserText =  lang('Crm.assignedToSelf') ;}

                return $returnActionText . $returnLinkToTask . $returnUserText;

            break;
            case 'Update': 
                if (isset($data->super_parent_id)) // pieprasījums no kontakta
                {
                    $returnActionText = lang('Crm.updateRelatedTask');
                }
                else{$returnActionText = lang('Crm.updateTask');}

                $returnLinkToTask = ' <a href ="'.base_url('crm/activities/task/'.$data->parent_id).'">'. $decodedData->title.'</a>.';

                return $returnActionText . $returnLinkToTask;

            break;
            case 'Note':
                return $this->processNote($data->data);
            break;
            default:
                return '';

        }

    }
    protected function processNote($data)
    {
        if (is_null($decodedData = json_decode($data))){return '';}
        return  '<i class="fas fa-pen text-secondary"></i> '. $decodedData->note;
    }
} 