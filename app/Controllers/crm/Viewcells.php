<?php

namespace App\Controllers\Crm;
use App\Controllers\BaseController;
use App\Libraries\ActionHistoryLibrary;

class Viewcells extends BaseController
{

    public function companyTasksList($companyId)
    {
        $tasksModel = new \App\Models\TasksModel();
        $data['tasks'] = $tasksModel->getUnitTasksList($companyId, 0, 5, 1);
        $data['countTasks']= $tasksModel->countUnitTasks($companyId, 1);
        return view('default/crm/crm_vc_company_tasks_list.php', $data);
    }

    public function companyActivitiesList($companyId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['plannedActivities'] = $crmModel->getUnitPlannedActivitiesITDUList($companyId, 1);
        return view('default/crm/crm_vc_company_planned_activities.php', $data);
    }

    public function companyContactsList($companyId)
    {
        $personsModel = new \App\Models\PersonsModel();
        $data['contactPersonsList'] = $personsModel->where('company_id', $companyId)->orderBy('id', 'DESC')->findAll();
        return view('default/crm/crm_vc_company_contacts_list.php', $data);
    }

    public function companyHistoryList($companyId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['activitiesHistory'] = $crmModel->getUnitActivitiesHistoryITDUList($companyId,0,5,1);
        $data['countHistory'] = $crmModel->countUnitActivitiesHistory($companyId,1)->count_history;
        $data['type'] = 1;
        return view('default/crm/crm_vc_company_activities_history.php', $data);
    }


    public function personTasksList($personId)
    {
        $tasksModel = new \App\Models\TasksModel();
        $data['tasks'] = $tasksModel->getUnitTasksList($personId, 0, 5, 2);
        $data['countTasks']= $tasksModel->countUnitTasks($personId, 2);
        $data['type'] = 2;
        return view('default/crm/crm_vc_person_tasks_list.php', $data);
    }

    public function personActivitiesList($personId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['plannedActivities'] = $crmModel->getUnitPlannedActivitiesITDUList($personId, 2);
        return view('default/crm/crm_vc_person_planned_activities.php', $data);
    }


    public function personHistoryList($personId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['activitiesHistory'] = $crmModel->getUnitActivitiesHistoryITDUList($personId,0,5,2);
        $data['countHistory'] = $crmModel->countUnitActivitiesHistory($personId,2)->count_history;
        $data['type'] = 2;
        return view('default/crm/crm_vc_person_activities_history.php', $data);
    }


    public function leadHistoryList($leadId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['activitiesHistory'] = $crmModel->getUnitActivitiesHistoryITDUList($leadId,0,5,3);
        $data['countHistory'] = $crmModel->countUnitActivitiesHistory($leadId, 3)->count_history;
        $data['type'] = 3;
        return view('default/crm/crm_vc_lead_activities_history.php', $data);
    }


    public function leadActivitiesList($leadId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['plannedActivities'] = $crmModel->getUnitPlannedActivitiesITDUList($leadId, 3);
        return view('default/crm/crm_vc_lead_planned_activities.php', $data);

    }


    public function leadTasksList($leadId)
    {
        $tasksModel = new \App\Models\TasksModel();
        $data['tasks'] = $tasksModel->getUnitTasksList($leadId, 0, 5, 3);
        $data['countTasks']= $tasksModel->countUnitTasks($leadId, 3);
        $data['type'] = 3;
        return view('default/crm/crm_vc_lead_tasks_list.php', $data);
    }


    public function opportunityActivitiesList($opportunityId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['plannedActivities'] = $crmModel->getUnitPlannedActivitiesITDUList($opportunityId, 8);
        $data['type'] = 8;
        return view('default/crm/crm_vc_opportunity_planned_activities.php', $data);
    }

    public function opportunityHistoryList($opportunityId)
    {
        $crmModel = new \App\Models\CrmModel();
        $data['activitiesHistory'] = $crmModel->getUnitActivitiesHistoryITDUList($opportunityId,0,5,8);
        $data['countHistory'] = $crmModel->countUnitActivitiesHistory($opportunityId, 8)->count_history;
        return view('default/crm/crm_vc_opportunity_activities_history.php', $data);
    }
    public function opportunityTasksList($opportunityId)
    {
        $tasksModel = new \App\Models\TasksModel();
        $data['tasks'] = $tasksModel->getUnitTasksList($opportunityId, 0, 5, 8);
        $data['countTasks']= $tasksModel->countUnitTasks($opportunityId, 8);
        $data['type'] = 8;
        return view('default/crm/crm_vc_opportunity_tasks_list.php', $data);
    }


    public function getActionHistory($id, $type)
    {
        $historyModel = new \App\Models\HistoryModel();

        if($type < 4)
        {
            $data['historyList'] = $historyModel->getHistoryList($id, 0, 5, $type);
            $data['countHistory'] = $historyModel->countHistory($id, $type);
        }
        else
        {
            $data['historyList'] = $historyModel->onlyParentHistoryList($id, 0, 5, $type);
            $data['countHistory'] = $historyModel->countOnlyParentHistory($id, $type);
        }

        $data['actionHistoryLog'] = new ActionHistoryLibrary();
        $data['historyId'] = $id;
        $data['historyType'] = $type;
        return view('default/crm/crm_vc_action_history_list.php', $data);
    }


    public function unitOpportunityList($parentType, $parentId)
    {
        $opportunitiesModel = new \App\Models\OpportunitiesModel(); 
    
        $data['parentType'] = $parentType;
        $data['parentId'] = $parentId;
        $data['countOpportunities'] = $opportunitiesModel->where('parent_type', $parentType)->where('parent_id', $parentId)->countAllResults();
        $data['opportunitiesList'] = $opportunitiesModel->select('id, title, stage, close_date, currency, amount')->where('parent_type', $parentType)->where('parent_id', $parentId)->limit(0, 5)->orderBy('id', 'DESC')->findAll();
        return view('default/crm/crm_vc_unit_opportunity_list.php', $data);

    }


    public function homeNearestPersonsBirthdaysList($userId = 0 )
    {
        $personsModel = new \App\Models\PersonsModel();

        $data['persons'] = $personsModel->getPersonsWithNearbyBirthdays($userId);

        return view('default/crm/crm_vc_home_nearest_persons_birthdays.php', $data);

    }

}