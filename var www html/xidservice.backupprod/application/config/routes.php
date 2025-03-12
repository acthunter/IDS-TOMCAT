<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'site';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['stomp'] = 'stomp/xbanc';
$route['stomp1'] = 'stomp/xbanc/v_query1';
$route['gchart1'] = 'stomp/xbanc/v_gchart1';

$route['mposition'] = 'mposition/approval';

$route['homelist/(:any)'] = 'mposition/approval/home_list/$1';
$route['approval/get/(:any)'] = 'mposition/review/xtest1/$1';
$route['temppos/get/(:any)'] = 'mposition/temppos/tpos/$1'; 
$route['apprbytype/(:any)'] = 'mposition/approval/apprbytype/$1';
$route['apprbyid/(:any)'] = 'mposition/approval/apprbyid/$1';

#$route['rscsrc_list'] = 'stomp/xbanc/rscsrc_list';
#$route['rscsrc_mark'] = 'stomp/xbanc/rscsrc_mark';
#$route['rscsrc_detail/(:any)'] = 'stomp/xbanc/rscsrc_detail/$1';
$route['rscsrc_list'] = 'sysadm/xbatch/rscsrc_list';
$route['rscsrc_mark'] = 'sysadm/xbatch/rscsrc_mark';
$route['rscsrc_detail/(:any)'] = 'sysadm/xbatc/rscsrc_detail/$1';

$route['sysadmin'] = 'sysadm/xbatch';

//$route['dynmodal'] = 'stomp/xids';
$route['home'] = 'stomp/xids';
$route['form'] = 'stomp/xids/loadform';
$route['getjobbyid/(:any)'] = 'stomp/xids/getJobbyid/$1';
$route['jobbyid'] = 'stomp/xids/jobbyid';
$route['rpositem'] = 'stomp/xids/rpositem';



$route['getjobdetail/(:any)/(:any)'] = 'stomp/xids/getjobdetail/$1/$2';
$route['myjob'] = 'stomp/xids/getMyJob'; 
$route['userreq'] = 'stomp/xids/userreq';
$route['wf/action/(:num)/(:any)/(:num)'] = 'stomp/xids/action/$1/$2/$3';
$route['wf/wfaction'] = 'stomp/xids/wfaction';
//$route['wf/createnew'] = 'stomp/xids/createnew';
$route['wf/inititate/(:any)'] = 'stomp/xids/initiate/$1';
$route['wf/new/(:any)'] = 'stomp/xids/createnew/$1';

//$route['myjob'] = 'stomp/xids/reviewpos';
$route['userreq/wfaction'] = 'stomp/xchgpos/wfaction';

$route['login'] = 'stomp/xctest/login';
$route['logout'] = 'stomp/xctest/logout';
$route['log_out'] = 'site/logout';

$route['test/param/(:any)'] = 'stomp/xctest/testparam/$1';
$route['test/wfparam/(:any)/(:any)'] = 'stomp/xctest/testparam1/$1/$2';
$route['test/movestage/(:any)/(:any)'] = 'stomp/xctest/movetostage/$1/$2';
$route['test/wf_mark'] = 'stomp/xctest/wf_mark';
$route['test/rp_mark'] = 'sysadm/xbatch/rp_mark';

$route['param_batchctl'] = 'sysadm/xbatch/param_batchctl';
$route['batchctl'] = 'sysadm/xbatch/batchctl';
$route['sysrequest'] = 'sysadm/xbatch/sysrequest';
$route['employee'] = 'sysadm/Xbatch_edit';
$route['employee2'] = 'sysadm/Xbatch/employee';
$route['query_em'] = 'sysadm/xbatch/query_em';
$route['query_em2'] = 'sysadm/xbatch/query_em2';
$route['update_employee'] = 'sysadm/xbatch/update_employee';
$route['update_employeesya'] = 'sysadm/xbatch/update_employee2';
$route['update_prev'] = 'sysadm/xbatch/update_prev';
$route['query_prev'] = 'sysadm/xbatch/query_prev';
$route['previledge'] = 'sysadm/xbatch/previledge';
$route['chg_req'] = 'sysadm/xbatch/chg_req';
$route['chg_req_list'] = 'sysadm/xbatch/chg_req_list';
$route['chg_req_list2'] = 'sysadm/xbatch/chg_req_list2';
$route['login_sum'] = 'sysadm/xbatch/login_sum';
$route['login_sum_list2'] = 'sysadm/xbatch/login_sum_list2';
$route['login_sum_list3'] = 'sysadm/xbatch/login_sum_list3';
$route['login_sum_list4'] = 'sysadm/xbatch/login_sum_list4';

$route['itservice'] = 'itservice/xmain';
$route['enduser'] = 'enduser/xmain';
$route['endsession'] = 'endsession/xmain';
$route['idadmin'] = 'idadmin/xmain';
$route['validation'] = 'validation/xvalid';
$route['dpass'] = 'dpass/xdpass';
$route['gpass'] = 'pass/xgpass';

$route['redirect'] = 'welcome/redirect';
$route['testmail'] = 'welcome/testmail';
$route['mailmanual'] = 'welcome/mailmanual';
$route['invalid'] = 'welcome/invalid';
$route['mail'] = 'sendmail/htmlmail';
$route['guser'] = 'guser/getpass';
$route['back'] = 'welcome/back';
$route['monitoring'] = 'sysadm/xbatch/monitoring';
$route['reviewupdate'] = 'sysadm/xbatch/reviewupdate';
$route['call_procedure'] = 'sysadm/xbatch/call_reviewupdate';
$route['suspect'] = 'sysadm/xbatch/suspect';
$route['wait_approval'] = 'sysadm/xbatch/wappr';
$route['reqsuccess'] = 'sysadm/xbatch/reqsuccess';
$route['wait_request'] = 'sysadm/xbatch/wreq';
$route['audit'] = 'sysadm/xbatch/audit';
$route['history_login'] = 'sysadm/xbatch/history_login';
$route['resource-not-create'] = 'sysadm/xbatch/res_not_create';
$route['revupdate_data'] = 'sysadm/xbatch/review_update';
$route['revupdate_data_submit'] = 'sysadm/xbatch/review_update_submit';
//$route['sys_login'] = 'sysadm/xbatch/sys_login';
$route['sys_monitoring'] = 'welcome/sys_mon';
//$route['sys_login_list'] = 'sysadm/xbatch/sys_login_list';
$route['sys_login_list'] = 'welcome/sys_login_list';
$route['syar_resource'] = 'welcome/syar_resource';
$route['tellerdispatch'] = 'welcome/tellerdispatch';


$route['audit_detail'] = 'sysadm/xbatch/audit_detail';
$route['wreq_detail'] = 'sysadm/xbatch/wreq_detail';
$route['wappr_detail'] = 'sysadm/xbatch/wappr_detail';
$route['suspect_detail'] = 'sysadm/xbatch/wappr_detail';
$route['reqsuccess_detail'] = 'sysadm/xbatch/reqsuccess_detail';
$route['test_xml'] = 'sysadm/xbatch/test';
$route['faq'] = 'welcome/faq';
$route['info'] = 'welcome/nfeature';
$route['informasi'] = 'stomp/xids/load_infouser';
$route['adm'] = 'stomp/xids/load_adm';
$route['killuser'] = 'stomp/killuser';
$route['pending_request'] = 'welcome/sumreq';
$route['otp'] = 'pass/xgpass/otp';
$route['list-request'] = 'idadmin/xmain/load_req';

$route['list-userresign'] = 'idadmin/xmain/load_reqresign';
$route['list-resign'] = 'idadmin/xmain/getreqresign';
$route['process_del'] = 'idadmin/xmain/process_delete';
$route['process_lock'] = 'idadmin/xmain/process_lock';
$route['cancelreq'] = 'idadmin/xmain/cancelreq';

$route['request_approve'] = 'idadmin/xmain/load_reqappr';
$route['log-updatesso'] = 'idadmin/xmain/load_logupdt';
$route['req_management'] = 'stomp/reqmanage'; 
$route['tracking_request_management'] = 'stomp/historypass';
$route['locked'] = 'endsession/xmain/locked';
$route['killusersso'] = 'endsession/xmain/killusersso';
$route['update-sso'] = 'endsession/xmain/updatedata';
$route['auth'] = 'itservice/xmain/load_admappr';
//$route['review/list/create'] = 'stomp/review/create';
//$route['review/list/create'] = 'stomp/review/create';

$route['add-binareuse'] = 'itservice/xmain/addbinareuse';
$route['add-appsso'] = 'itservice/xmain/addappsso';
$route['npp_search'] = 'itservice/xmain/npp_search';
$route['search_app'] = 'itservice/xmain/search_app';
$route['proses_add'] = 'itservice/xmain/proses';
$route['search_unit'] = 'itservice/xmain/search_unit';
$route['search_unitbina'] = 'itservice/xmain/search_unitbina';

$route['getuserlock'] = 'stomp/xids/usr_unlock';
$route['unlock'] = 'stomp/xids/unlock_cas';


