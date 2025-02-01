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
    $routes->get('/', 'Crm\Crm::index');
    $routes->get('action-history/(:num)/(:num)', 'Crm\Crm::actionHistory/$1/$2');
    $routes->get('companies/', 'Crm\Contacts::companiesList');
    $routes->get('companies/new', 'Crm\Contacts::newCompany');
    $routes->post('companies/save', 'Crm\Contacts::saveCompany');
    $routes->get('company/(:num)', 'Crm\Contacts::company/$1');
    $routes->get('company/edit/(:num)', 'Crm\Contacts::editCompany/$1');
    $routes->get('activities/history/(:num)/(:num)', 'Crm\Activities::activitiesHistory/$1/$2');
    $routes->get('user/(:num)', 'Crm\Crm::user/$1');
    $routes->get('edit-user/', 'Crm\Crm::editUser/');
    $routes->post('save-user/', 'Crm\Crm::saveUser/');
    $routes->get('persons/', 'Crm\Contacts::personsList');
    $routes->get('persons/new', 'Crm\Contacts::newPerson');
    $routes->post('persons/save', 'Crm\Contacts::savePerson');
    $routes->get('person/(:num)', 'Crm\Contacts::person/$1');
    $routes->get('person/edit/(:num)', 'Crm\Contacts::editPerson/$1');
    $routes->get('activities/calls/new/', 'Crm\Activities::newCall');
    $routes->post('activities/calls/save/', 'Crm\Activities::saveCall');
    $routes->get('activities/call/(:num)', 'Crm\Activities::call/$1');
    $routes->get('activities/calls/', 'Crm\Activities::allCalls');
    $routes->get('activities/meetings/', 'Crm\Activities::allMeetings');
    $routes->get('activities/emails/', 'Crm\Activities::allEmails');
    $routes->get('activities/tasks/', 'Crm\Activities::allTasks');
    $routes->get('activities/call/edit/(:num)', 'Crm\Activities::editCall/$1');
    $routes->get('activities/meetings/new/', 'Crm\Activities::newMeeting');
    $routes->post('activities/meetings/save/', 'Crm\Activities::saveMeeting');
    $routes->get('activities/meeting/(:num)', 'Crm\Activities::meeting/$1');
    $routes->get('activities/meeting/edit/(:num)', 'Crm\Activities::editMeeting/$1');
    $routes->get('activities/tasks/new/', 'Crm\Activities::newTask');
    $routes->post('activities/tasks/save/', 'Crm\Activities::saveTask');
    $routes->get('activities/task/(:num)', 'Crm\Activities::task/$1');
    $routes->get('activities/task/edit/(:num)', 'Crm\Activities::editTask/$1');
    $routes->get('activities/emails/new/', 'Crm\Activities::newEmail');
    $routes->post('activities/emails/save/', 'Crm\Activities::saveEmail');
    $routes->get('activities/email/(:num)', 'Crm\Activities::email/$1');
    $routes->get('activities/emails/edit/(:num)', 'Crm\Activities::editEmail/$1');
    $routes->get('unit/tasks/(:num)/(:num)', 'Crm\Activities::unitTasks/$1/$2');
    $routes->get('leads/', 'Crm\Leads::leadsList');
    $routes->get('leads/new', 'Crm\Leads::new');
    $routes->post('leads/save', 'Crm\Leads::save');
    $routes->get('lead/(:num)', 'Crm\Leads::lead/$1');
    $routes->get('lead/edit/(:num)', 'Crm\Leads::edit/$1');
    $routes->get('opportunities/', 'Crm\Opportunities::opportunitiesList');
    $routes->get('opportunities/new', 'Crm\Opportunities::new');
    $routes->post('opportunities/save', 'Crm\Opportunities::save');
    $routes->get('opportunity/(:num)', 'Crm\Opportunities::opportunity/$1');
    $routes->get('opportunity/edit/(:num)', 'Crm\Opportunities::edit/$1');
    $routes->get('delete-record/(:num)/(:num)', 'Crm\Crm::deleteRecord/$1/$2');
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

