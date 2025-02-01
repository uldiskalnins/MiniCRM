<?php

namespace App\Controllers;

class Error extends BaseController
{
    public function index()
    {
        $data['locale'] = $this->request->getLocale();
        $data['error'] = lang('Install.error');
        return view('default/error/message.php',$data);
    }

    public function dbConnectionError()
    {
        $data['locale'] = $this->request->getLocale();
        $data['error'] = lang('Install.noDbConnectionError');
        return view('default/error/message.php',$data);
    }

    public function noDbSettings()
    {
        $data['locale'] = $this->request->getLocale();
        $data['error'] = lang('Install.noDbSettings');
        return view('default/error/message.php',$data);
    }

    public function noWritablePath()
    {
        $data['locale'] = $this->request->getLocale();
        $data['error'] = lang('Install.noWritablePath');
        return view('default/error/message.php',$data);
    }

}
