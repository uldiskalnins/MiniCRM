<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Start::index', ["filter" => "language"]);
$routes->get('install', 'Install::index', ["filter" => "language"]);
$routes->match(['get', 'post'], 'install/ok/', 'Install::ok', ["filter" => "language"]);
$routes->match(['get', 'post'],'login', 'Start::login', ["filter" => "language"]);
$routes->get('logout', 'Start::logout', ["filter" => "language"]);


$routes->group('crm', ["filter" => ["myauth","language"]], static function ($routes) {
    $routes->get('/', 'crm\Crm::index');
    $routes->get('action-history/(:num)/(:num)', 'crm\Crm::actionHistory/$1/$2');
    $routes->get('companies/', 'crm\Contacts::companiesList');
    $routes->get('companies/new', 'crm\Contacts::newCompany');
    $routes->post('companies/save', 'crm\Contacts::saveCompany');
    $routes->get('company/(:num)', 'crm\Contacts::company/$1');
    $routes->get('company/edit/(:num)', 'crm\Contacts::editCompany/$1');
    $routes->get('activities/history/(:num)/(:num)', 'crm\Activities::activitiesHistory/$1/$2');
    $routes->get('user/(:num)', 'crm\Crm::user/$1');
    $routes->get('edit-user/', 'crm\Crm::editUser/');
    $routes->post('save-user/', 'crm\Crm::saveUser/');
    $routes->get('persons/', 'crm\Contacts::personsList');
    $routes->get('persons/new', 'crm\Contacts::newPerson');
    $routes->post('persons/save', 'crm\Contacts::savePerson');
    $routes->get('person/(:num)', 'crm\Contacts::person/$1');
    $routes->get('person/edit/(:num)', 'crm\Contacts::editPerson/$1');
    $routes->get('activities/calls/new/', 'crm\Activities::newCall');
    $routes->post('activities/calls/save/', 'crm\Activities::saveCall');
    $routes->get('activities/call/(:num)', 'crm\Activities::call/$1');
    $routes->get('activities/calls/', 'crm\Activities::allCalls');
    $routes->get('activities/meetings/', 'crm\Activities::allMeetings');
    $routes->get('activities/emails/', 'crm\Activities::allEmails');
    $routes->get('activities/tasks/', 'crm\Activities::allTasks');
    $routes->get('activities/call/edit/(:num)', 'crm\Activities::editCall/$1');
    $routes->get('activities/meetings/new/', 'crm\Activities::newMeeting');
    $routes->post('activities/meetings/save/', 'crm\Activities::saveMeeting');
    $routes->get('activities/meeting/(:num)', 'crm\Activities::meeting/$1');
    $routes->get('activities/meeting/edit/(:num)', 'crm\Activities::editMeeting/$1');
    $routes->get('activities/tasks/new/', 'crm\Activities::newTask');
    $routes->post('activities/tasks/save/', 'crm\Activities::saveTask');
    $routes->get('activities/task/(:num)', 'crm\Activities::task/$1');
    $routes->get('activities/task/edit/(:num)', 'crm\Activities::editTask/$1');
    $routes->get('activities/emails/new/', 'crm\Activities::newEmail');
    $routes->post('activities/emails/save/', 'crm\Activities::saveEmail');
    $routes->get('activities/email/(:num)', 'crm\Activities::email/$1');
    $routes->get('activities/emails/edit/(:num)', 'crm\Activities::editEmail/$1');
    $routes->get('unit/tasks/(:num)/(:num)', 'crm\Activities::unitTasks/$1/$2');
    $routes->get('leads/', 'crm\Leads::leadsList');
    $routes->get('leads/new', 'crm\Leads::new');
    $routes->post('leads/save', 'crm\Leads::save');
    $routes->get('lead/(:num)', 'crm\Leads::lead/$1');
    $routes->get('lead/edit/(:num)', 'crm\Leads::edit/$1');
    $routes->get('opportunities/', 'crm\Opportunities::opportunitiesList');
    $routes->get('opportunities/new', 'crm\Opportunities::new');
    $routes->post('opportunities/save', 'crm\Opportunities::save');
    $routes->get('opportunity/(:num)', 'crm\Opportunities::opportunity/$1');
    $routes->get('opportunity/edit/(:num)', 'crm\Opportunities::edit/$1');
    $routes->get('delete-record/(:num)/(:num)', 'crm\Crm::deleteRecord/$1/$2');
});


$routes->group('ajax', ["filter" => ["myauth","language"]], static function ($routes) {
    $routes->get('search-assigned-user', 'Ajax::search_assigned_user');
    $routes->get('search-account', 'Ajax::search_account');
    $routes->get('search-person', 'Ajax::search_person');
    $routes->get('search-lead', 'Ajax::search_lead');
    $routes->get('search-opportunity', 'Ajax::search_opportunity');
    $routes->get('search-connected-company', 'Ajax::search_connected_account');
    $routes->get('search-connected-person', 'Ajax::search_connected_contact');
    $routes->get('get-company-contacts/(:num)', 'Ajax::get_company_contacts/$1');
    $routes->match(['get', 'post'],'update-crm-settings/(:num)', 'Ajax::update_crm_settings/$1');
    $routes->get('delete-file/(:num)', 'Ajax::delete_file/$1');
    $routes->get('search-parent', 'Ajax::search_parent');
    $routes->post('add-history-note/(:num)/(:num)', 'Ajax::add_history_note/$1/$2');
    $routes->get('check-lang/(:num)', 'Ajax::checkLang/$1');
    $routes->get('get-home-content-lists/(:num)', 'Ajax::getHomeContentLists/$1');
});



$routes->group('admin', ["filter" => ["adminsOnly","language"]], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('users', 'Admin::users');
    $routes->match(['get', 'post'],'edit-user/(:num)', 'Admin::editUser/$1');
    $routes->match(['get', 'post'],'new-user/', 'Admin::newUser');
    $routes->get('settings', 'Admin::settings');
    $routes->match(['get', 'post'],'email-settings', 'Admin::emailSettings');
    $routes->match(['get', 'post'],'crm-settings/', 'Admin::crmSettings');

});


$routes->get('error/no_db_settings', 'Error::noDbSettings', ["filter" => "language"]);
$routes->get('error/db_connection_error', 'Error::dbConnectionError', ["filter" => "language"]);
$routes->get('error/no_writable_path', 'Error::noWritablePath', ["filter" => "language"]);

