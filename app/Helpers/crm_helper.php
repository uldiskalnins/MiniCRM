<?php


    function addressFormats($addressFieldsArray){

        $returnArray = array();

        $aFields = 0; $address = ''; $addressMaps = '';

        foreach ($addressFieldsArray as $value) {

            if(!empty($value)){

                $address .= $value.', ';
                $addressMaps .= $value.'+';
                $aFields++;

            }

        }

        if ( $aFields > 2){$returnArray['showAddress'] = True;}
        else{$returnArray['showAddress'] = False;}

        $returnArray['addressFieldsCount'] = $aFields;
        $returnArray['addressLine'] = rtrim($address, ", ");

        if (mb_strlen($returnArray['addressLine'],"UTF-8") > 35){
            $returnArray['addressLineShort'] = mb_substr($returnArray['addressLine'],0,35,'UTF-8').'...'; 
        }
        else{$returnArray['addressLineShort'] = $returnArray['addressLine'];}
        
        $returnArray['addressGoogleMapsUrl'] = 'https://www.google.com/maps/search/'. rtrim($addressMaps, "+");


        return $returnArray;
    }



    function userAdmin()
    {
        if (session()->get('userRights') < 1){return True;}
        else{ return False;}
    }


    function allowedToEdit($recordUserId)
    {
        if (session()->get('userId') == $recordUserId OR session()->get('userRights') < 1){return True;}
        else{ return False;}
    }


    function allowedToView($recordUserId)
    {
        $settingsModel = new \App\Models\SettingsModel();
        if (session()->get('userRights') < 1 OR  $settingsModel->allowToSeeOtherUsersRecords > 0 OR session()->get('userId') == $recordUserId){return True;}
        else{return False;}

    }

    function getParentDataByGet()
    {

        $request = \Config\Services::request();


        if ($request->getGet('companyid')) 
        {
            $companiesModel = new \App\Models\CompaniesModel();

            if (!is_numeric($request->getGet('companyid'))) {return false;}
            if (!$data['companyData'] = $companiesModel->getCompanyWithUserById($request->getGet('companyid'))) {return false;}
            if(!allowedToView($data['companyData']['user_id'])){return false;}

            $data['secondaryParentAccId'] = 0;
            $data['secondaryParentAccText'] = '';
            $data['parentType'] = 1;
            $data['parentId'] = $data['companyData']['id'];
            $data['parentText'] = $data['companyData']['title'];
            $data['toEmail'] = $data['companyData']['email'];

            if (!empty($data['companyData']['user_id'])) {
                $data['associatedUser']['id'] = $data['companyData']['user_id'];
                $data['associatedUser']['fullName'] = $data['companyData']['user_full_name']; ;
            }

        } 
        elseif ($request->getGet('personid')) 
        {
            $personsModel = new \App\Models\PersonsModel();

            if (!is_numeric($request->getGet('personid'))) {return false;}
            if (!$data['personData'] = $personsModel->getPersonWithUserAndCompanyById($request->getGet('personid'))) {return false;}
            if(!allowedToView($data['personData']['user_id'])){return false;}

            $data['parentType'] = 2;
            $data['parentId'] = $data['personData']['id'];
            $data['parentText'] = $data['personData']['name']. ' '.$data['personData']['surname'];
            $data['secondaryParentAccId'] = $data['personData']['company_id'];
            $data['secondaryParentAccText'] = $data['personData']['title'];
            $data['toEmail'] = $data['personData']['email'];

            if (!empty($data['personData']['user_id'])) {
                $data['associatedUser']['id'] = $data['personData']['user_id'];
                $data['associatedUser']['fullName'] = $data['personData']['user_name'] . ' ' . $data['personData']['user_surname'];
            }

        }
        elseif ($request->getGet('leadid')) 
        {
            $leadsModel = new \App\Models\LeadsModel();

            if (!is_numeric($request->getGet('leadid'))) {return false;}
            if (!$data['leadData'] = $leadsModel->getLeadWithUser($request->getGet('leadid'))) {return false;}
            if(!allowedToView($data['leadData']['user_id'])){return false;}

            $data['secondaryParentAccId'] = 0;
            $data['secondaryParentAccText'] = '';
            $data['parentType'] = 3;
            $data['parentId'] = $data['leadData']['id'];
            $data['parentText'] = $data['leadData']['name']. ' '.$data['leadData']['surname'];
            $data['toEmail'] = $data['leadData']['email'];

            if (!empty($data['leadData']['user_id'])) {
                $data['associatedUser']['id'] = $data['leadData']['user_id'];
                $data['associatedUser']['fullName'] = $data['leadData']['user_full_name'];
            }

        }
        elseif ($request->getGet('opportunityid')) 
        {
            $opportunitiesModel = new \App\Models\OpportunitiesModel();

            if (!is_numeric($request->getGet('opportunityid'))) {return false;}
            if (!$data['opportunityData'] = $opportunitiesModel->getOpportunity($request->getGet('opportunityid'))) {return false;}
            if(!allowedToView($data['opportunityData']['user_id'])){return false;}

            $data['secondaryParentAccId'] = 0;
            $data['secondaryParentAccText'] = '';
            $data['parentType'] = 8;
            $data['parentId'] = $data['opportunityData']['id'];
            $data['parentText'] = $data['opportunityData']['title'];
            $data['toEmail'] = '';

            if (!empty($data['opportunityData']['user_id'])) {
                $data['associatedUser']['id'] = $data['opportunityData']['user_id'];
                $data['associatedUser']['fullName'] = $data['opportunityData']['user_full_name'] ;
            }

        }
        else
        {
            $data['secondaryParentAccId'] = 0;
            $data['secondaryParentAccText'] = '';
            $data['parentType'] = 1;
            $data['parentId'] = '';
            $data['parentText'] = '';
            $data['toEmail'] = '';
        }

        return $data;

    }

    function allowedToViewAllUsersRecords() // allow to view all
    {
        $settingsModel = new \App\Models\SettingsModel();
        if ((session()->get('userRights') < 1) OR ($settingsModel->allowToSeeOtherUsersRecords > 0)){return True;}
        else{ return False;}
    }

    function showDateAndTime($date,$t = 0)
    {// $t = 0 - default date and time no sec, 1 - date only, 2 - date, time & seconds
        switch ($t) :
            case 1:
                return date("d.m.Y.", strtotime($date));
                break;
            case 2:
                return date("d.m.Y. H:i:s", strtotime($date));
                break;
            case 3:
                return date("Y-m-d", strtotime($date));
                break;
            case 4:
                $birthDate = $date;
                $birthDay = new DateTime($birthDate);
                $now = new DateTime();
                $age = $now->diff($birthDay)->y;
                return date("d.m.Y.", strtotime($date)).' ('.$age.')';
                break;

            default:
                return date("d.m.Y. H:i", strtotime($date));
        endswitch;


    }

    function showMoney($amount, $currencyCode = 0)
    {

        if (empty($currencyCode)){$currencyCode = '???';}

        $returnAmount = number_format($amount, 2, '.', ' ');

        return $returnAmount .' '.$currencyCode;
    }

    function shortEmailFileName($longFileName)
    {
        $splitedFN = explode("!!-!!", $longFileName);
        if (array_key_exists(1, $splitedFN)){
            return $splitedFN[1];
        }
        else{
            return $longFileName;
        }
    }


    function checkLanguage() // check language changes and update session
    {
        $settingsModel = new \App\Models\SettingsModel();
        session()->set('langCode', $settingsModel->language);
        return true;

    }



    function addFilesListToDb($attachedFiles, $type = 0, $id = 0, $userId = 0)
    {

        if (empty($id) OR empty($type)){return false;}
        if (empty($userId)){ $userId = session()->get('userId');}


        $filesModel = new \App\Models\FilesModel();

        $dbFilesData = array();

        if (count($attachedFiles) > 0) {
            foreach ($attachedFiles as $file) {
                $dbFilesData[] = ['file_name' => $file, 'parent_type' => $type, 'parent_id' => $id, 'user_id' => $userId, 'creation_date' => date("Y-m-d H:i:s")];
            }

            return $filesModel->insertBatch($dbFilesData);
        } else {
            return true;
        }
    }

    function uploadFilesAndAddToDb( $type = 0, $id = 0, $userId = 0, $inputName = 0, $uploadDir = 0)
    {

        if (empty($id) OR empty($type)){return false;}
        if (empty($userId)){ $userId = session()->get('userId');}

        if(empty($inputName)){$uploadDir = 'file';}

        if(empty($uploadDir)){$uploadDir = 'files';} 
        else{$uploadDir = stripslashes($uploadDir);}


        $request = \Config\Services::request();
        $filesModel = new \App\Models\FilesModel();

        $attachedFiles = array();

        if ($uploadFiles = $request->getFileMultiple($inputName)) 
        {
            foreach ($uploadFiles as $file) 
            {
                if ($file->isValid() AND !$file->hasMoved())
                {
                    $attachedFiles[] = $newName  = $userId . '-' . $type . '-' . $id . '-' . date("YmdHis"). '-'. random_string('alpha', 6) . '!!-!!' . $file->getName();
                    $file->move(ROOTPATH . 'public/uploads/' . $uploadDir . '/', $newName);
                }
            }
        }

        $dbFilesData = array();

        if (count($attachedFiles) > 0) 
        {
            foreach ($attachedFiles as $file) 
            {
                $dbFilesData[] = ['file_name' => $file, 'parent_type' => $type, 'parent_id' => $id, 'user_id' => $userId, 'creation_date' => date("Y-m-d H:i:s")];
            }

            if($filesModel->insertBatch($dbFilesData)){return true; }
            else
            {
                foreach ($attachedFiles as $file) {
                    unlink(ROOTPATH . 'public/uploads/' .  $uploadDir . '/', $file);
                }
                return false;
            }
        } 
        else { return 0; }

    }
    function deleteListedFiles($fileNameList, $filesDir = 0)
    {
        if(empty($filesDir)){$filesDir = 'files';}
        else{$filesDir = stripslashes($filesDir);}

        $filesPath = ROOTPATH . 'public/uploads/' .  $filesDir . '/';
        $countDeletedFiles = 0;

        if (count($fileNameList) > 0) 
        {
            foreach ($fileNameList as $file) {
                if(unlink($filesPath, $file)){$countDeletedFiles++;}
            }
            return $countDeletedFiles;
        }
        else { return 0; }


    }
