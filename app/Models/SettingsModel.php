<?php

namespace App\Models;

use CodeIgniter\Model;


class SettingsModel extends Model
{

    protected $table = 'mc_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','setting','value'];

    private $settings;

    protected function initialize()
    {
        $this->settings = $this->findAll();
    }

    public function __get($key) {

        return $this->settings[array_search($key, array_column($this->settings, 'setting'))]['value'];

     }



    public function getSettingValue($setting = false){

        if(!$setting){return false;}

        $this->where('setting',$setting);
        if($value = $this->get()->getRowArray()) {return $value['value'];}
        else {return false;}

    }



    public function updateSettingByName($setting,$value){//jā

        if(!isset($setting) OR !isset($value)){return false;}

        $settingData = ['setting'=> $setting, 'value' => $value] ;

        $this->where('setting',$setting);
        if(!$existingValue =$this->get()->getRowArray()) {return $this->insert($settingData);}
        else {$settingData['id'] = $existingValue['id']; return $this->replace($settingData);}

    }






}



?>