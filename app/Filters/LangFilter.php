<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LangFilter implements FilterInterface
{
    /** https://onlinewebtutorblog.com/work-with-filters-in-codeigniter-4-tutorial/
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        $lang = service('language');

        if (session()->has('userLogin'))
        {
            if (!session()->has('langCode'))
            {
                $lang = service('language');
                $settingsModel = new \App\Models\SettingsModel();
                session()->set('langCode', $settingsModel->language);
            }

            $lang->setLocale(session()->get('langCode'));

        }
        else
        {

            $db = db_connect();

            if ($db->tableExists('mc_settings')) 
            {
                $settingsModel = new \App\Models\SettingsModel();

                $lang = service('language');
                $lang->setLocale($settingsModel->language);
            }


        }


    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}