<?php

$action = (isset($_GET['action'])) ? $_GET['action'] : die('Nothing to do');

require_once('../conf/conf.inc.php');
require_once('../db/db.inc.php');
require('PHPMailer/PHPMailerAutoload.php');

// Available actions
$actions = array();
array_push($actions, array('name' => 'validateSession', 'action' => 'validateSession'));
array_push($actions, array('name' => 'getAll', 'action' => 'getAllReport'));
array_push($actions, array('name' => 'resetpassword', 'action' => 'resetpassword'));
array_push($actions, array('name' => 'resetpasswordRequest', 'action' => 'resetpasswordRequest'));
array_push($actions, array('name' => 'search_log_detail', 'action' => 'search_log_detail'));
array_push($actions, array('name' => 'activity_log_detail', 'action' => 'activity_log_detail'));
array_push($actions, array('name' => 'activity_log', 'action' => 'activity_log'));
array_push($actions, array('name' => 'search', 'action' => 'search'));
array_push($actions, array('name' => 'weeklyReport', 'action' => 'weeklyReport'));
array_push($actions, array('name' => 'commodity_filter', 'action' => 'commodity_filter'));
array_push($actions, array('name' => 'userMembershipLevels', 'action' => 'userMembershipLevels'));
// array_push($actions, array('name' => 'getAllTransaction', 'action' => 'getAllTransactionReports'));
array_push($actions, array('name' => 'getAllTrans', 'action' => 'getAllTransactions'));
array_push($actions, array('name' => 'getReportById', 'action' => 'getReportById'));
array_push($actions, array('name' => 'getTransReportById', 'action' => 'getTransReportById'));
array_push($actions, array('name' => 'getReportByURLName', 'action' => 'getReportByURLName'));
array_push($actions, array('name' => 'searchReport', 'action' => 'searchReport'));
array_push($actions, array('name' => 'getReviewInfo', 'action' => 'getReviewInfo'));
array_push($actions, array('name' => 'getAllSection', 'action' => 'getAllSection'));
array_push($actions, array('name' => 'getAllQuestion', 'action' => 'getAllQuestion'));
array_push($actions, array('name' => 'checkUserstatus', 'action' => 'checkUserstatus'));
// array_push($actions, array('name' => 'saveReview', 'action' => 'saveReview'));
// array_push($actions, array('name' => 'saveReviewForLaterEdit', 'action' => 'saveReviewForLaterEdit'));
// array_push($actions, array('name' => 'editReview', 'action' => 'editReview'));
// array_push($actions, array('name' => 'getReviewRating', 'action' => 'getReviewRating'));
// array_push($actions, array('name'=>'login','action'=>'login'));
// array_push($actions, array('name'=>'logout','action'=>'logout'));
array_push($actions, array('name' => 'updateConditionStatus', 'action' => 'updateConditionStatus'));
array_push($actions, array('name' => 'emailsend', 'action' => 'emailsend'));
// array_push($actions, array('name'=>'fetchreviews','action'=>'fetchreviews'));
// array_push($actions, array('name'=>'deletereview','action'=>'deletereview'));
// array_push($actions, array('name'=>'signup','action'=>'signup'));
// array_push($actions, array('name'=>'addprofileimage','action'=>'addprofileimage'));
// array_push($actions, array('name'=>'addresumefile','action'=>'addresumefile'));
// array_push($actions, array('name'=>'editprofile','action'=>'editprofile'));
// array_push($actions, array('name'=>'editprofilecontact','action'=>'editprofilecontact'));
array_push($actions, array('name' => 'complaintsave', 'action' => 'complaintsave'));
array_push($actions, array('name' => 'getHistory', 'action' => 'getHistory'));
array_push($actions, array('name' => 'getTransHistory', 'action' => 'getTransHistory'));
array_push($actions, array('name' => 'invitereviewer', 'action' => 'invitereviewer'));
array_push($actions, array('name' => 'deleteimage', 'action' => 'deleteimage'));
array_push($actions, array('name' => 'getReviewDetail', 'action' => 'getReviewDetailById'));
array_push($actions, array('name' => 'reportDetails', 'action' => 'reportDetails'));
array_push($actions, array('name' => 'reportUserDetails', 'action' => 'reportUserDetails'));
array_push($actions, array('name' => 'reportUserReviewRating', 'action' => 'reportUserReviewRating'));
array_push($actions, array('name' => 'getReportUserReviewsRating', 'action' => 'getReportUserReviewsRating'));
// array_push($actions, array('name'=>'manageEditprofilecontact','action'=>'manageEditprofilecontact'));
// array_push($actions, array('name'=>'editPersonalDetails','action'=>'editPersonalDetails'));
// array_push($actions, array('name'=>'saveResume','action'=>'saveResume'));
array_push($actions, array('name' => 'expertPanel', 'action' => 'expertPanel'));
// array_push($actions, array('name'=>'logReviewStart','action'=>'logReviewStart'));
// array_push($actions, array('name'=>'logReviewClose','action'=>'logReviewClose'));
array_push($actions, array('name' => 'populateCountries', 'action' => 'populateCountries'));
array_push($actions, array('name' => 'populateCommodity', 'action' => 'populateCommodity'));
array_push($actions, array('name' => 'complaintFormDetails', 'action' => 'complaintFormDetails'));
array_push($actions, array('name' => 'submitComplaint', 'action' => 'submitComplaint'));
array_push($actions, array('name' => 'lessRating', 'action' => 'lessRating'));
array_push($actions, array('name' => 'emailAllReviewers', 'action' => 'emailAllReviewers'));
array_push($actions, array('name' => 'populateUsername', 'action' => 'populateUsername'));
array_push($actions, array('name' => 'inviteReviewerUsername', 'action' => 'inviteReviewerUsername'));
array_push($actions, array('name' => 'inviteAllCode', 'action' => 'inviteAllCode'));
array_push($actions, array('name' => 'inviteAllMarketing', 'action' => 'inviteAllMarketing'));
array_push($actions, array('name' => 'inviteAllCommodity', 'action' => 'inviteAllCommodity'));
array_push($actions, array('name' => 'sendMessageEmail', 'action' => 'sendMessageEmail'));
// array_push($actions, array('name'=>'getReviewerDetail','action'=>'getReviewerDetail'));
// array_push($actions, array('name'=>'deleteResume','action'=>'deleteResume'));
array_push($actions, array('name' => 'editNotification', 'action' => 'editNotification'));
/*Manage Account*/
array_push($actions, array('name' => 'getOrganisation', 'action' => 'getOrganisation'));
array_push($actions, array('name' => 'getCommodity', 'action' => 'getCommodity'));
array_push($actions, array('name' => 'getReportingCode', 'action' => 'getReportingCode'));
array_push($actions, array('name' => 'addPerfessionalMemberships', 'action' => 'addPerfessionalMemberships'));
array_push($actions, array('name' => 'saveCommodity', 'action' => 'saveCommodity'));
array_push($actions, array('name' => 'saveReportingExperience', 'action' => 'saveReportingExperience'));
array_push($actions, array('name' => 'addPersonalDetails', 'action' => 'addPersonalDetails'));
array_push($actions, array('name' => 'getUserOrganisation', 'action' => 'getUserOrganisation'));
array_push($actions, array('name' => 'getUserCommodity', 'action' => 'getUserCommodity'));
array_push($actions, array('name' => 'getUserReportingCode', 'action' => 'getUserReportingCode'));
array_push($actions, array('name' => 'getUpdatePersonalDetails', 'action' => 'getUpdatePersonalDetails'));

/*subscribe*/
array_push($actions, array('name' => 'subscribe', 'action' => 'subscribe'));
array_push($actions, array('name' => 'subscribe_mail', 'action' => 'subscribe_mail'));
array_push($actions, array('name' => 'unsubscribe', 'action' => 'unsubscribe'));
/*Save Complaint*/
array_push($actions, array('name' => 'uploadAttachFile', 'action' => 'uploadAttachFile'));
array_push($actions, array('name' => 'saveComplaint', 'action' => 'saveComplaint'));

array_push($actions, array('name' => 'complianceIssue', 'action' => 'complianceIssue'));
array_push($actions, array('name' => 'SendFeedback', 'action' => 'SendFeedback'));
array_push($actions, array('name' => 'requestforPDFdownloads', 'action' => 'requestforPDFdownloads'));
array_push($actions, array('name' => 'countMap', 'action' => 'countMap'));
array_push($actions, array('name' => 'validate_Users_email', 'action' => 'validate_Users_email'));
array_push($actions, array('name' => 'activateReg', 'action' => 'activateReg'));
array_push($actions, array('name' => 'deleteUser', 'action' => 'deleteUser'));
array_push($actions, array('name' => 'checkSubStatus', 'action' => 'checkSubStatus'));
array_push($actions, array('name' => 'subUser', 'action' => 'subUser'));
array_push($actions, array('name' => 'addUpdateMailchimpUser', 'action' => 'addUpdateMailchimpUser'));
array_push($actions, array('name' => 'saveCurrentMode', 'action' => 'saveCurrentMode'));
array_push($actions, array('name' => 'getDeafultMode', 'action' => 'getDeafultMode'));
array_push($actions, array('name' => 'getSavedpreferences', 'action' => 'getSavedpreferences'));
array_push($actions, array('name' => 'updateDefaultmode', 'action' => 'updateDefaultmode'));
array_push($actions, array('name' => 'deleteModes', 'action' => 'deleteModes'));
array_push($actions, array('name' => 'IsEmailexist', 'action' => 'IsEmailexist'));
array_push($actions, array('name' => 'getreportDetailbyName', 'action' => 'getreportDetailbyName'));
array_push($actions, array('name' => 'unsubUser', 'action' => 'unsubUser'));
array_push($actions, array('name' => 'getreportXml', 'action' => 'getreportXml'));
array_push($actions, array('name' => 'getWeeklyReports', 'action' => 'getWeeklyReports'));
// Go through the actions list and run the associated functions
foreach ($actions as $act) {
    if ($act['name'] == $action) {
        $functionName = $act['action'] . '();';

        eval($functionName);
    }
}
function validate_Users_email()
{

    require_once('../classes/report.class.php');

    $response = array('success' => false);
    $userName = (isset($_REQUEST['user_login'])) ? $_REQUEST['user_login'] : NULL;
    $userEmail = (isset($_REQUEST['user_email'])) ? $_REQUEST['user_email'] : NULL;
    // load Reports
    $oReport = new Report();
    $reports = $oReport->UserSignUpValidation($userName, $userEmail);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);


}

function checkSubStatus()
{
    require_once('../classes/report.class.php');
    $email = $_POST['value'];
    $oReport = new Report();
    $result = $oReport->checkSubStatus($email);
    if($result) {
        $key['key'] = $result['key'];
        $response['success'] = 'true';
        $response['key'] = $result['key'];
        $response['fName'] = $result['fName'];
        $response['lName'] = $result['lName'];
//        $response['interests'] = $result['interests'];
        $response['status'] = $result['status'];
        $response['registered'] = $result['registered'];
    }
    else{
        $response['success'] = 'false';
    }
    echo encode($response);
}

function addUpdateMailchimpUser() {

    $response['success'] = 'true';
    require_once('../classes/report.class.php');
    $email = $_POST['email'];
    $fName = $_POST['first_name'];
    $lName = $_POST['last_name'];


    $oReport = new Report();
    $result = $oReport->addUpdateSub($email, $fName, $lName);
    $response['key'] = $result;

    echo encode($response);

}

function subUser()
{
    require_once('../classes/report.class.php');
    $email = $_POST['email'];
    $fName = $_POST['first_name'];
    $lName = $_POST['last_name'];
//    $interests = $_POST['interests'];
    $company = $_POST['company'];
    $job_title = $_POST['job_title'];
    $ind_sector = $_POST['ind_sector'];
    $plan = $_POST['plan'];
    if($plan=='2')
        $plan='GOLD';
//        $plan='PLan 2';
    else if($plan=='3')
        $plan='PLATINUM';
//        $plan='Plan 3';
    else
        $plan='SILVER';
//        $plan='Plan 1';

    $oReport = new Report();
    $result = $oReport->addUpdateSub($email, $fName, $lName);
    $log_activity = $oReport->log_active('New Registration', 'button:register', '', '');
    $key['key'] = $result['key'];
    $response['success'] = 'true';
    $sub_date=date("d-m-Y", strtotime($result['sub_date']));
    $user_ip=get_client_ip();
    $user_ip_details= ip_details($user_ip);
    $country=$user_ip_details->country->name;
    if(!$country){
        $country='not defined';
    }
//create a email to send to the admins
    $message = '<html><body>' . $fName. ' ' .$lName.'  registered for an opaxe account.<br><br>';
    $message .= '<label>Email : </label>' . $email . '<br>';
    $message .= '<label>Company : </label>' . $company . '<br>';
    $message .= '<label>Industry Sector : </label>' . $ind_sector . '<br>';
    $message .= '<label>Job Title : </label>' . $job_title . '<br>';
    $message .= '<label>Plan : </label>' . $plan . '<br>';
    $message .= '<label>Country : </label>' . $country . '<br>';
    $message .= '<label>date subscribed : </label>'.$sub_date.'<br>';
    $message .= '<label>Subscribed to : </label>';
    $message .= 'Resource Reports Bulletin';
//    if($interests[0]=='true')
//        $message .= 'Intel Weekly Bulletin (50 per year),';
//     if($interests[1]=='true')
//        $message .= 'Special reports (occasionally),';
//     if($interests[2]=='true')
//        $message .= 'RSC News (occasionally)';
    if($result['status']=='alreadySubscribed'){
        $subject = 'Subscribed user registered';
    }
    else{
        $subject = 'New user registered';
    }
    $message .= '</body></html>';

    // Send Email
    $emails = (explode(",", RSC_EMAILS));
    foreach ($emails as $email) {
        phpmail($email, $subject, $message);
    }

    echo encode($response);
}


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function ip_details($IPaddress)
{
    $json       = file_get_contents("https://ipsidekick.com/{$IPaddress}");
    $details    = json_decode($json);
    return $details;
}

function unsubUser(){
    require_once('../classes/report.class.php');
    $email = $_POST['email'];
    $oReport = new Report();
    $result = $oReport->unsubUser($email);
    $response['success'] = 'true';
    echo encode($response);
}

function activateReg()
{
    require_once('../classes/report.class.php');
    $email = $_POST['email'];
    $oReport = new Report();
    $result = $oReport->activateReg($email);
    $key['key'] = $result['key'];
    $subjectRsc = 'Registration Confirmed';

    $message = '<html>';
    $message .= '<head><style type="text/css">label{width: 210px;}</style></head>';
    $message .= '<body>';
    $message .= '<p>Dear new subscriber,</p>';
    $message .= '<p>Welcome to <span style="color:#FC2020">opaxe</span><span style="font-size: 8px"><sup>TM</sup></span></p>';
    $message .= '<p>Now you have easy access to reports published by listed resource companies from across the world including exploration drilling updates,
                    resource and reserve updates, scoping studies and PEAs, and feasibility studies.</p>';
    $message .= '<p>Subscribers to our Gold and Platinum levels may receive weekly updates on activities within the resources sector and are also able to access
                    listed company transaction reports providing information on transactions of mineral and mining projects globally. You can change your 
                    subscription plan in the "Manage Profile" section on opaxe.com.</p>';
    $message .= '<p><span style="color:#FC2020">Opaxe</span> also undertakes bespoke research and can provide customised data for our clients, please contact us to discuss your requirements 
                    - <a href="mailto:info@opaxe.com?subject=Message against">info@opaxe.com</a></p>';
    $message .= '<p>We hope that you enjoy using opaxe.com</p>';
    $message .= '<span>Nick Saunders<br> 
                 Managing Director<br>
                 opaxe.com<br>
                 </span><br><br>';
    $message .= '<img src="https://www.opaxe.com/wp-content/uploads/2019/04/opaxe-logo.png" width="200"/>';
    $message .= '</body></html>';

    phpmail($email, $subjectRsc, $message);
    $response['success'] = 'true';
    $response['key'] = $result['key'];
    $response['status'] = $result['status'];
    echo encode($response);
}

function weeklyReport()
{
    require_once('../classes/report.class.php');
    $start_week = (isset($_REQUEST['to'])) ? $_REQUEST['to'] : NULL;
    $end_week = (isset($_REQUEST['from'])) ? $_REQUEST['from'] : NULL;
    $commodity[] = (isset($_REQUEST['commodity'])) ? $_REQUEST['commodity'] : NULL;
    $response = array('success' => false);
    $oReport = new Report();
    $result = $oReport->weekly_report($start_week, $end_week, $commodity);
    if ($result) {
        $response['result'] = $result;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function deleteUser()
{
    require_once('../classes/report.class.php');
    $userEmail = $_POST['email'];
    $oReport = new Report();
    $reports = $oReport->deleteUser($userEmail);
    if ($reports) {
        $url = "http://$_SERVER[HTTP_HOST]/register?lid=1";
        $response['success'] = true;
        $subjectRsc = 'Your account with opaxe has been deleted';
        $messageRsc = '<html>';
        $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
        $messageRsc .= '<body>';
        $messageRsc .= '<p>Your account with opaxe has been deleted.</p>';
        $messageRsc .= '<p>We\'re sorry to see you go..</p>';
        $messageRsc .= '<p>Was this a mistake? You can re-register here:</p>';
        $messageRsc .= '<span style="   background-color: dodgerblue;color: white;padding: 9px 8px;border: none;cursor: pointer;width: 25%;opacity: 0.9;border-radius:10px">';
        $messageRsc .= '<a style="text-decoration:none;color:black;" href=" ' . $url . '">Register</a></span><br>';
        $messageRsc .= '<p>For questions or comments, please contact us: <a href="mailto:info@opaxe.com?subject=Message against">www.opaxe.com</a></p>';
        $messageRsc .= '</body></html>';
        phpmail($userEmail, $subjectRsc, $messageRsc);
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function commodity_filter()
{
    require_once('../classes/report.class.php');
    $commodities = (isset($_REQUEST['comm_filters'])) ? $_REQUEST['comm_filters'] : NULL;
    $response = array('success' => false);

    // load Reports
    $oReport = new Report();
    $reports = $oReport->commodity_filter($commodities);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function countMap()
{

    require_once('../classes/report.class.php');
    $ids = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL;
    $response = array('success' => false);


    // load Reports
    $oReport = new Report();
    $reports = $oReport->UserPdfViewsLimit(1, $ids);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);

}

function search_log_detail()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $actions = (isset($_REQUEST['checkboxes'])) ? $_REQUEST['checkboxes'] : NULL;
    $oReport = new Report();
    $reports = $oReport->search_log_detail($actions);
    if ($reports) {

        $response['success'] = true;
        $response['detail'] = $reports;


    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);

}

function activity_log()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $actions = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : NULL;
    $log = (isset($_REQUEST['log'])) ? $_REQUEST['log'] : NULL;
    $mode = (isset($_REQUEST['mode'])) ? $_REQUEST['mode'] : NULL;
    $report_id = (isset($_REQUEST['report-id'])) ? $_REQUEST['report-id'] : NULL;
    $oReport = new Report();
    $reports = $oReport->log_active($log, $actions, $mode,$report_id);
    if ($reports) {
        $response['success'] = true;

    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);

}

function activity_log_detail()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $oReport = new Report();
    $reports = $oReport->log_active_detail();
    if ($reports) {
        $response['success'] = true;
        $response['detail'] = $reports;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);

}

function emailsend()
{
    require_once('../classes/login.class.php');
    $oRSc = new Rsc();
    $email = $_POST['email'];
    $response = array('success' => false);

    $result = $oRSc->email($email);
    if ($result) {
        $to = $email;
        $subject = 'Forgot Password';
        $message = '<html><body>Dear ' . $result[0]['firstname'] . ' ' . $result[0]['lastname'] . ' <br/><br/> You have requested for the password of your reviewer account.<br><br>Uersname : ' . $result[0]['username'] . '<br> Password : ' . $result[0]['password'] . '<br><br> Regards<br>' . PERSON_NAME . '</body></html>';
        phpmail($to, $subject, $message);
        $response['success'] = true;
        $response['email'] = $_SESSION['email'];
    } else {
        $response['errors'] = 'This user does not exist';
    }
    echo encode($response);
}


function userMembershipLevels()
{
    require_once('../classes/report.class.php');
    $oReport = new Report();
    $ids = null;
    $userStatus = $oReport->getUserData();
    //$userPdfViewsLimit = $oReport->UserPdfViewsLimit(0, $ids);

    if ($userStatus['user_nicename'] != 'UserLogout') {
        $response['userStatus'] = $userStatus['user_nicename'];
        $response['firstName'] = $userStatus['first_name'];
        $response['imageUrl'] = $userStatus['avatar_url'];
        $response['industry'] = $userStatus['industry'];
        $response['jobTitle'] = $userStatus['job_title'];
        $response['subPlan'] = $userStatus['sub_plan'];
        $response['Email'] = $userStatus['user_email'];
        $response['userRegistered'] = date_create($userStatus['user_registered']);
        $response['userRegistered'] = date_format($response['userRegistered'], "d F  Y");
        $response['Subscription'] = $userStatus['subscription'];
        $response['Company'] = $userStatus['Company'];
        $response['phone'] = $userStatus['phone'];
        $response['Dailydownloads'] = $userStatus['Dailydownloads'];
        $response['weeklyDownloads'] = $userStatus['weeklyDownloads'];
        $response['totalDownloads'] = $userStatus['totalDownloads'];
        $response['reportIDs'] = $userStatus['reportIDs'];
        $response['features'] = $userStatus['features'];
        $response['lastVisit'] = $userStatus['lastVisit'];
        $response['ResetPassLink'] = $userStatus['reset-pass-link'];
        $response['success'] = true;

    } else {
        $response['userStatus'] = $userStatus['user_nicename'];
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function saveCurrentMode()
{
    require_once('../classes/preferences.class.php');
    $data['filters'] = $_POST['filters'];
    $data['zoom_level'] = $_POST['zoom_level'];
    $data['map_position'] = $_POST['map_position'];
    $data['is_trans'] = $_POST['is_trans'];
    $preferences = new preferences();
    $result = $preferences->savePreferences($data);
    if ($result) {
        $response['success'] = true;
    } else {
        $response['error'] = true;
    }
    echo encode($response);
}

function deleteModes()
{

    require_once('../classes/preferences.class.php');
    $data['preferences-list'] = $_POST['preferences-list'];
    $preferences = new preferences();
    $result = $preferences->deleteModes($data);
    if ($result) {
        $response['success'] = true;
    } else {
        $response['error'] = true;
    }
    echo encode($response);

}

function getDeafultMode()
{
    require_once('../classes/preferences.class.php');
    $preferences = new preferences();
    $result = $preferences->getActivemode();
    if ($result) {
        $response['success'] = true;
        $response['active_filters'] = $result;
    } else {
        $response['success'] = false;
    }
    echo encode($response);
}

function IsEmailexist()
{

    require_once('../classes/report.class.php');
    $email = $_POST['value'];
    $oReport = new Report();
    $result = $oReport->IsEmailexist($email);
    if ($result) {
        $response['success'] = true;
    } else {
        $response['error'] = true;
    }
    echo encode($response);

}

function getSavedpreferences()
{
    require_once('../classes/preferences.class.php');
    $preferences = new preferences();
    $result = $preferences->getSavedpreferences();
    if ($result) {
        $response['success'] = true;
        $response['saved_preferences'] = $result;
    } else {
        $response['error'] = true;
    }
    echo encode($response);
}

function getreportXml(){
    require_once('../classes/report.class.php');
    $oReport = new Report();
    $result = $oReport->getreportXml();
    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = true;
    }
    echo encode($response);
}

function updateDefaultmode()
{

    require_once('../classes/preferences.class.php');
    $id = $_POST['id'];
    $is_trans=$_POST['is_trans'];
    $preferences = new preferences();
    $result = $preferences->updateDefaultmode($id,$is_trans);
    if ($result) {
        $response['success'] = true;
    } else {
        $response['error'] = true;
    }
    echo encode($response);

}

function getAllTransactions()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $project_stage = (isset($_REQUEST['project-stage'])) ? $_REQUEST['project-stage'] : NULL;
    $transaction_type = (isset($_REQUEST['transaction-type'])) ? $_REQUEST['transaction-type'] : NULL;
    $valueRange = (isset($_REQUEST['value_range'])) ? $_REQUEST['value_range'] : NULL;
    $locationAccuracy = (isset($_REQUEST['accuracy'])) ? $_REQUEST['accuracy'] : NULL;
    $commodity = (isset($_REQUEST['commodity'])) ? $_REQUEST['commodity'] : NULL;
    $stockExchange = (isset($_REQUEST['stock-exchange'])) ? $_REQUEST['stock-exchange'] : NULL;
    if ($stockExchange) {
        if (in_array("OTCQB", $stockExchange)) {
            $val = count($stockExchange);
            $stockExchange[$val + 1] = 'OTC';
            $stockExchange[$val + 2] = 'OTC Pink';

        }
    }
    $data = array(
        'isMobileDevice' => (isset($_REQUEST['isMobileDevice'])) ? $_REQUEST['isMobileDevice'] : 'false',
        'show-all' => (isset($_REQUEST['show-all'])) ? $_REQUEST['show-all'] : FALSE,
        'commodity' => $commodity,
        'isStockExchange' => (isset($_REQUEST['isStockExchange'])) ? $_REQUEST['isStockExchange'] : NULL,
        'se1' => $stockExchange,
        'se2' => $stockExchange,
        'se3' => $stockExchange,
        'isValueRange' => (isset($_REQUEST['valueRange'])) ? $_REQUEST['valueRange'] : NULL,
        'value_range' => $valueRange,
        'islocationAccuracy' => (isset($_REQUEST['locationAccuracy'])) ? $_REQUEST['locationAccuracy'] : NULL,
        'accuracy' => $locationAccuracy,
        'project-stage' => $project_stage,
        'transaction-type' => $transaction_type,
        'isTransectionType' => (isset($_REQUEST['isTransectionType'])) ? $_REQUEST['isTransectionType'] : NULL,
        'isProjectStage' => (isset($_REQUEST['isProjectStage'])) ? $_REQUEST['isProjectStage'] : NULL,
        'isCommodity' => (isset($_REQUEST['isCommodity'])) ? $_REQUEST['isCommodity'] : NULL,
        'to' => (isset($_REQUEST['to'])) ? $_REQUEST['to'] : NULL,
        'from' => (isset($_REQUEST['from'])) ? $_REQUEST['from'] : NULL,
        'from-datee' => (isset($_REQUEST['from-date'])) ? $_REQUEST['from-date'] : NULL,
        'to-datee' => (isset($_REQUEST['to-date'])) ? $_REQUEST['to-date'] : NULL,
    );

    $lookup = array(
        'id' => 'a',
        'project_stage' => 'b',
        'type' => 'c',
        'commodities' => 'd',
        'status' => 'e',
        'region' => 'f',
        'latitude' => 'g',
        'longitude' => 'h',
        'company' => 'j',
        'project' => 'l',
        'cpqp' => 'm',
        'announcement_date' => 'n',
        'value_range' => 'range',
        'se1' => 'stckexchange',
        'se2' => 'stckExchange2',
        'se3' => 'stckExchange3'
    );
    // load Reports
    //if ((count($project_stage) > 0) && (count($commodity) > 0) && (count($stockExchange) > 0) && (count($transaction_type) > 0) && (count($valueRange) > 0) && (count($locationAccuracy) > 0)) {
    $oReport = new Report();
    $reports = $oReport->getAllTrans($data);

    if ($reports) {
        $response['lookup'] = $lookup;
        $response['reports'] = $reports['trans'];
        $response['reportIDs'] = $reports['reportIDs'];
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    // }

    echo encode($response);
}

function getWeeklyReports()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $oReport = new Report();
    $reports = $oReport->getWeeklyReports();
    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function getAllReport()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $date1 = new DateTime();
    $startTime = date("Y-m-d-h-m-s", $date1->getTimestamp());

    $codes = (isset($_REQUEST['codes'])) ? $_REQUEST['codes'] : NULL;
    $commodity = (isset($_REQUEST['commodity'])) ? $_REQUEST['commodity'] : NULL;
    $format = (isset($_REQUEST['report-format'])) ? $_REQUEST['report-format'] : NULL;
    $proj_status = (isset($_REQUEST['proj_status'])) ? $_REQUEST['proj_status'] : NULL;
    $report_type = (isset($_REQUEST['report-type'])) ? $_REQUEST['report-type'] : NULL;
    $resources = (isset($_REQUEST['resources'])) ? $_REQUEST['resources'] : NULL;
    $resources_reserves = (isset($_REQUEST['resources-reserves'])) ? $_REQUEST['resources-reserves'] : NULL;
    $stockExchange = (isset($_REQUEST['stock-exchange'])) ? $_REQUEST['stock-exchange'] : NULL;
    if ($stockExchange) {
        if (in_array("OTCQB", $stockExchange)) {
            $val = count($stockExchange);
            $stockExchange[$val + 1] = 'OTC';
            $stockExchange[$val + 2] = 'OTC Pink';

        }
    }
    $data = array(
        'isMobileDevice' => (isset($_REQUEST['isMobileDevice'])) ? $_REQUEST['isMobileDevice'] : 'false',
        'show-all' => (isset($_REQUEST['show-all'])) ? $_REQUEST['show-all'] : FALSE,
        'nav-filter' => (isset($_REQUEST['nav-filter'])) ? $_REQUEST['nav-filter'] : FALSE,
        'from-date' => (isset($_REQUEST['from-date'])) ? $_REQUEST['from-date'] : NULL,
        'to-date' => (isset($_REQUEST['to-date'])) ? $_REQUEST['to-date'] : NULL,
        'pdf_url' => (isset($_REQUEST['pdf_url'])) ? $_REQUEST['pdf_url'] : NULL,
        'codes' => $codes,
        'report-type' => $report_type,
        'resources' => $resources,
        'resources-reserves' => $resources_reserves,
        'commodity' => $commodity,
        'proj_status' => $proj_status,
        'rep_format' => $format,
        'isReportCode' => (isset($_REQUEST['isReportCode'])) ? $_REQUEST['isReportCode'] : NULL,
        'isReportType' => (isset($_REQUEST['isReportType'])) ? $_REQUEST['isReportType'] : NULL,
        'isResourcesType' => (isset($_REQUEST['isResourcesType'])) ? $_REQUEST['isResourcesType'] : NULL,
        'isReservesType' => (isset($_REQUEST['isReservesType'])) ? $_REQUEST['isReservesType'] : NULL,
        'isCommodity' => (isset($_REQUEST['isCommodity'])) ? $_REQUEST['isCommodity'] : NULL,
        'to' => (isset($_REQUEST['to'])) ? $_REQUEST['to'] : NULL,
        'from' => (isset($_REQUEST['from'])) ? $_REQUEST['from'] : NULL,
        'chckbox' => (isset($_REQUEST['checkbox'])) ? $_REQUEST['checkbox'] : NULL,
        'region' => (isset($_REQUEST['isNavTopFilter']) && $_REQUEST['isNavTopFilter'] == 'true') ? array('seabed' => 'Seabed Resources') : NULL,
        'format' => (isset($_REQUEST['isReportformat'])) ? $_REQUEST['isReportformat'] : NULL,
        'project_status' => (isset($_REQUEST['ProjectStatus'])) ? $_REQUEST['ProjectStatus'] : NULL,
        'searchValue' => (isset($_REQUEST['searchValue'])) ? $_REQUEST['searchValue'] : NULL,
        'searchFilter' => (isset($_REQUEST['searchFilter'])) ? $_REQUEST['searchFilter'] : NULL,
        'isStockExchange' => (isset($_REQUEST['isStockExchange'])) ? $_REQUEST['isStockExchange'] : NULL,
        'se1' => $stockExchange,
        'se2' => $stockExchange,
        'se3' => $stockExchange,
    );

    $lookup = array(
        'id' => 'a',
        'code' => 'b',
        'latitude' => 'g',
        'longitude' => 'h',
        'prj_status' => 'z',
        'se1' => 'stckexchange',
        'se2' => 'stckExchange2',
        'se3' => 'stckExchange3'
    );
    // load Reports

    //if (count($commodity) > 0 && count($proj_status)>0 && count($codes) > 0 && count($report_type) > 0 && count($format)>0 && count($resources) > 0 && count($resources_reserves) > 0) {
    $oReport = new Report();
    $reports = $oReport->getAll($data);

    if ($reports) {
        $response['lookup'] = $lookup;
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    // }

    $date2 = new DateTime();
    $endTime = date("Y-m-d-h-m-s", $date2->getTimestamp());

    $timeDiff = "S: $startTime E: $endTime";

    $response['timeDiff'] = $timeDiff;

    echo encode($response);
}


function search()
{
    require_once('../classes/report.class.php');
    $searchentire = (isset($_REQUEST['searchentireDB'])) ? $_REQUEST['searchentireDB'] : false;
    $term = (isset($_REQUEST['term'])) ? $_REQUEST['term'] : NULL;
    $transaction = (isset($_REQUEST['transaction'])) ? $_REQUEST['transaction'] : false;

    $stockExchange = (isset($_REQUEST['stock-exchange'])) ? $_REQUEST['stock-exchange'] : NULL;
    if ($stockExchange) {
        if (in_array("OTCQB", $stockExchange)) {
            $val = count($stockExchange);
            $stockExchange[$val + 1] = 'OTC';
            $stockExchange[$val + 2] = 'OTC Pink';

        }
    }
    $commodity = (isset($_REQUEST['commodity'])) ? $_REQUEST['commodity'] : NULL;

    if($transaction=='true'){
        $project_stage = (isset($_REQUEST['project-stage'])) ? $_REQUEST['project-stage'] : NULL;
        $transaction_type = (isset($_REQUEST['transaction-type'])) ? $_REQUEST['transaction-type'] : NULL;
        $valueRange = (isset($_REQUEST['value_range'])) ? $_REQUEST['value_range'] : NULL;
        $locationAccuracy = (isset($_REQUEST['accuracy'])) ? $_REQUEST['accuracy'] : NULL;
        $data = array(
            'isMobileDevice' => (isset($_REQUEST['isMobileDevice'])) ? $_REQUEST['isMobileDevice'] : 'false',
            'show-all' => (isset($_REQUEST['show-all'])) ? $_REQUEST['show-all'] : FALSE,
            'commodity' => $commodity,
            'isStockExchange' => (isset($_REQUEST['isStockExchange'])) ? $_REQUEST['isStockExchange'] : NULL,
            'se1' => $stockExchange,
            'se2' => $stockExchange,
            'se3' => $stockExchange,
            'isValueRange' => (isset($_REQUEST['valueRange'])) ? $_REQUEST['valueRange'] : NULL,
            'value_range' => $valueRange,
            'islocationAccuracy' => (isset($_REQUEST['locationAccuracy'])) ? $_REQUEST['locationAccuracy'] : NULL,
            'accuracy' => $locationAccuracy,
            'project-stage' => $project_stage,
            'transaction-type' => $transaction_type,
            'isTransectionType' => (isset($_REQUEST['isTransectionType'])) ? $_REQUEST['isTransectionType'] : NULL,
            'isProjectStage' => (isset($_REQUEST['isProjectStage'])) ? $_REQUEST['isProjectStage'] : NULL,
            'isCommodity' => (isset($_REQUEST['isCommodity'])) ? $_REQUEST['isCommodity'] : NULL,
            'to' => (isset($_REQUEST['to'])) ? $_REQUEST['to'] : NULL,
            'from' => (isset($_REQUEST['from'])) ? $_REQUEST['from'] : NULL,
            'from-datee' => (isset($_REQUEST['from-date'])) ? $_REQUEST['from-date'] : NULL,
            'to-datee' => (isset($_REQUEST['to-date'])) ? $_REQUEST['to-date'] : NULL,
            'option_selected'=>(isset($_REQUEST['option_selected'])) ? $_REQUEST['option_selected'] : NULL,
        );
    }
else {

    $codes = (isset($_REQUEST['codes'])) ? $_REQUEST['codes'] : NULL;
    $format = (isset($_REQUEST['report-format'])) ? $_REQUEST['report-format'] : NULL;
    $proj_status = (isset($_REQUEST['proj_status'])) ? $_REQUEST['proj_status'] : NULL;
    $report_type = (isset($_REQUEST['report-type'])) ? $_REQUEST['report-type'] : NULL;
    $resources = (isset($_REQUEST['resources'])) ? $_REQUEST['resources'] : NULL;
    $resources_reserves = (isset($_REQUEST['resources-reserves'])) ? $_REQUEST['resources-reserves'] : NULL;
    $data = array(
        'isMobileDevice' => (isset($_REQUEST['isMobileDevice'])) ? $_REQUEST['isMobileDevice'] : 'false',
        'show-all' => (isset($_REQUEST['show-all'])) ? $_REQUEST['show-all'] : FALSE,
        'nav-filter' => (isset($_REQUEST['nav-filter'])) ? $_REQUEST['nav-filter'] : FALSE,
        'from-date' => (isset($_REQUEST['from-date'])) ? $_REQUEST['from-date'] : NULL,
        'to-date' => (isset($_REQUEST['to-date'])) ? $_REQUEST['to-date'] : NULL,
        'codes' => $codes,
        'report-type' => $report_type,
        'resources' => $resources,
        'resources-reserves' => $resources_reserves,
        'commodity' => $commodity,
        'proj_status' => $proj_status,
        'rep_format' => $format,
        'isReportCode' => (isset($_REQUEST['isReportCode'])) ? $_REQUEST['isReportCode'] : NULL,
        'isReportType' => (isset($_REQUEST['isReportType'])) ? $_REQUEST['isReportType'] : NULL,
        'isResourcesType' => (isset($_REQUEST['isResourcesType'])) ? $_REQUEST['isResourcesType'] : NULL,
        'isReservesType' => (isset($_REQUEST['isReservesType'])) ? $_REQUEST['isReservesType'] : NULL,
        'isCommodity' => (isset($_REQUEST['isCommodity'])) ? $_REQUEST['isCommodity'] : NULL,
        'to' => (isset($_REQUEST['to'])) ? $_REQUEST['to'] : NULL,
        'from' => (isset($_REQUEST['from'])) ? $_REQUEST['from'] : NULL,
        'chckbox' => (isset($_REQUEST['checkbox'])) ? $_REQUEST['checkbox'] : NULL,
        'region' => (isset($_REQUEST['isNavTopFilter']) && $_REQUEST['isNavTopFilter'] == 'true') ? array('seabed' => 'Seabed Resources') : NULL,
        'format' => (isset($_REQUEST['isReportformat'])) ? $_REQUEST['isReportformat'] : NULL,
        'project_status' => (isset($_REQUEST['ProjectStatus'])) ? $_REQUEST['ProjectStatus'] : NULL,
        'isStockExchange' => (isset($_REQUEST['isStockExchange'])) ? $_REQUEST['isStockExchange'] : NULL,
        'se1' => $stockExchange,
        'se2' => $stockExchange,
        'se3' => $stockExchange,
        'option_selected'=>(isset($_REQUEST['option_selected'])) ? $_REQUEST['option_selected'] : NULL,
    );
}
    $response = array('success' => false);
    // load Reports
    $oReport = new Report();

    if ($transaction == 'true') {
        $lookup = array(
            'id' => 'a',
            'code' => 'b',
            'type' => 'c',
            'commodities' => 'd',
            'status' => 'e',
            'region' => 'f',
            'latitude' => 'g',
            'longitude' => 'h',
            'history' => 'i',
            'company' => 'j',
            'deposit' => 'k',
            'project' => 'l',
            'cpqp' => 'm',
            'date' => 'n',
            'value_range' => 'o',
            'project_stage' => 'p',
            'type' => 't',
            'se1' => 'se1',
            'se2' => 'se2',
            'se3' => 'se3',
            'accuracy' => 'acc',
            'ticker' => 'tic',

        );
        $reports = $oReport->transactionSearch($term,$data,$searchentire);
    } else {
        $lookup = array(
            'id' => 'a',
            'code' => 'b',
            'type' => 'c',
            'commodities' => 'd',
            'status' => 'e',
            'region' => 'f',
            'latitude' => 'g',
            'longitude' => 'h',
            'history' => 'i',
            'company' => 'j',
            'deposit' => 'k',
            'project' => 'l',
            'cpqp' => 'm',
            'date1' => 'n',
            'reserve_status' => 'o',
            'ticker' => 'tic',
            'prj_status' => 'z'
        );
        $reports = $oReport->search($term,$data,$searchentire);
    }

    if ($reports) {
        $response['lookup'] = $lookup;
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}


function getReportById()
{
    require_once('../classes/report.class.php');

    $report_id = (isset($_REQUEST['rid'])) ? $_REQUEST['rid'] : NULL;
    $response = array('success' => false);

    // load Reports
    $oReport = new Report();
    //$reports = $oReport->getTransInfo($report_id );
    $reports = $oReport->getReportInfo($report_id, false);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function checkUserstatus()
{
    require_once('../classes/report.class.php');

    $userName = (isset($_REQUEST['userName'])) ? $_REQUEST['userName'] : NULL;
    $password = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : NULL;
    $response = array('success' => false);

    $oReport = new Report();
    $hashPass = $oReport->checkUserstatus($userName, $password);


    if ($hashPass['status'] == 'true') {
        $response['success'] = true;
        $response['active'] = $hashPass['active'];
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function getTransReportById()
{
    require_once('../classes/report.class.php');

    $report_id = (isset($_REQUEST['rid'])) ? $_REQUEST['rid'] : NULL;
    $response = array('success' => false);

    // load Reports
    $oReport = new Report();
    $reports = $oReport->getTransInfo($report_id);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function getReportByURLName()
{
    require_once('../classes/report.class.php');

    $url_name = (isset($_REQUEST['url_name'])) ? $_REQUEST['url_name'] : NULL;
    $response = array('success' => false);

    // load Reports
    $oReport = new Report();
    $reports = $oReport->getReportInfo($url_name, true);

    //get user plan
    $user = $oReport->getUserplan();

//    echo $report_check; exit;
    if (count($reports) == 0) {
        $reports = $oReport->getTransReportLinkInfo($url_name, true);
        if ($reports) {
            $response['reports'] = $reports;
            $response['success'] = true;
            $response['user_plan'] = $user_plan;
            $response['TransReport'] = true;
        } else {
            $response['error'] = $oReport->errors();
        }
    } else {
        if ($reports) {
            $response['reports'] = $reports;
            $response['success'] = true;
            $response['user'] = $user;
            $response['TransReport'] = false;
        } else {
            $response['error'] = $oReport->errors();
        }
    }
    echo encode($response);
}


function searchReport()
{
    require_once('../classes/report.class.php');
    $q = $_POST['q'];
    $response = array('success' => false);

    // load Reports
    $oReport = new Report();
    $reports = $oReport->searchReport($q);

    if ($reports) {
        $response['reports'] = $reports;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function resetpasswordRequest()
{

    //email=$email_address&event_id=$event_id";
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $oReport = new Report();
    $email = $_POST['value'];
    $date = date('Y-m-d h:i:sa');
    $encoded_string = base64_encode($email . '&'. $date .'&'.'false');
    $url = "http://$_SERVER[HTTP_HOST]/reset-password-request/".$encoded_string;
    $name = $oReport->getUserName($email);
    if($name) {
        $subjectRsc = ' Password reset confirmation required';
        $messageRsc = '<html>';
        $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
        $messageRsc .= '<body>';
        $messageRsc .= '<p>Hi  ' . $name . '</p>';
        $messageRsc .= '<p>It looks like you requested a new password.</p> <p style="margin-bottom: 25px">
        	             If that sounds right, you can enter a new password by clicking on the button below.</p>';
        $messageRsc .= '<span style="   background-color: dodgerblue;color: white;padding: 9px 8px;border: none;cursor: pointer;width: 25%;opacity: 0.9;border-radius:10px">';
        $messageRsc .= '<a style="text-decoration:none;color:black;" href=" ' . $url . '">Reset password</a></span><br>';
        $messageRsc .= '<p style="margin-top: 25px">This link will be valid for the next 12 hours.</p><br><br>';
        $messageRsc .= '<p>Kind regards,</p>';
        $messageRsc .= '<p>The opaxe Team</p>';
        $messageRsc .= '<p style="font-size: 11px">This email was sent to you because you have an account on <a href="https://www.opaxe.com/">www.opaxe.com</a></p>';
        $messageRsc .= '</body></html>';
        phpmail($email, $subjectRsc, $messageRsc);
        $response['success'] = 'true';
    }

    echo encode($response);

}

function resetpassword()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);
    $oReport = new Report();
    $email = $_POST['reset'];
    $rand = $_POST['pass'];
    //$rand = generateRandomString();
    $pass = $oReport->generatePass($rand);
    // load Question
    $oReport = new Report();
    $questions = $oReport->resetpassword($pass, $email);
    if ($questions['status'] == 'true') {
        //$emails = (explode(",", SIGNUP_EMAIL));
//        $subjectRsc = 'Reset Password';
//        $messageRsc = '<html>';
//        $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
//        $messageRsc .= '<body>';
//        $messageRsc .= '<h1>Hi</h1>';
//        $messageRsc .= '<p>You have requested for a new password for Account at RSC Resource Reporting intelligence.We have process your email and generate a new password for your account
//        	             use below password for you Account and set a new one later</p>';
//        $messageRsc .= '<label>Your new password : </label>' . $rand . '<br>';
//        $messageRsc .= '<h1>Thanks</h1>';
//        $messageRsc .= '<h1>RSC Resource Reporting Intelligence</h1>';
//        $messageRsc .= '</body></html>';
//
//
//        phpmail($email, $subjectRsc, $messageRsc);
        $response['success'] = 'true';


    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function getAllQuestion()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    // load Question
    $oReport = new Report();
    $questions = $oReport->getAllQuestion();
    if ($questions) {
        $response['questions'] = $questions;
        $response['success'] = true;
    } else {
        $response['error'] = $oReport->errors();
    }
    echo encode($response);
}

function getAllSection()
{
    require_once('../classes/reviews.class.php');
    $response = array('success' => false);
    // load Section
    $oReview = new Reviews();
    $sections = $oReview->getAllSection();
    if ($sections) {
        $response['sections'] = $sections;
        $response['success'] = true;
    } else {
        $response['error'] = $oReview->errors();
    }
    echo encode($response);
}

function getReviewInfo()
{
    require_once('../classes/reviews.class.php');
    $response = array('success' => false);
    // load Review Info
    $oReview = new Reviews();
    $sections = $oReview->getReviewInfo();
    if ($sections) {
        $response['reviews'] = $sections;
        $response['success'] = true;
    } else {
        $response['error'] = $oReview->errors();
    }
    echo encode($response);
}


function getRandomstring($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getReviewRating()
{
    require_once('../classes/reviews.class.php');
    $response = array('success' => false);

    $oReview = new Reviews();
    //Set Report Id
    $oReview->setReportId($_REQUEST['report_id']);
    $sections = $oReview->getReviewRating();
    if ($sections) {
        $response['sections'] = $sections;
        $response['success'] = true;
    } else {
        $response['error'] = $oReview->errors();
    }
    echo encode($response);
}

// function getReviewDetailById(){
//     require_once('../classes/reviews.class.php');
//     $response = array('success'=>false);

//     $oReviews = new Reviews();
//     //Set Review Id
//     $oReviews->setReviewId($_REQUEST['review_id']);
//     // Get Data
//     $reviews = $oReviews->getReviewDetailById();
//     $rating = $oReviews->getRatingByReviewId();
//     $section_rating = $oReviews->getSectionByReviewId();

//     if ($reviews){
//         $response['reviews'] = $reviews;
//         $response['rating']  = $rating;
//         $response['section_rating'] = $section_rating;
//         $response['success'] = true;
//     }else {
//         $response['error'] = $oReviews->errors();
//     }
//     echo encode($response);
// }

// function saveReview(){
// //    0 : save review
//     $response = array('success'=>false,'error' => 'OverAll Rating must be greater than 1.');
//     $total_score = isset($_REQUEST['overall-rating-section']) ? $_REQUEST['overall-rating-section'] : 0;

//     if($total_score >= 1){
//         $status = (isset($_REQUEST['conflict-of-interest']) && $_REQUEST['conflict-of-interest'] == 'no') ? 0 : 3;
//         addReview($status,'Save');
//     }else{
//         echo encode($response);
//     }

//     // Allow Junior Reviewer to submit reviews As Requirement has changed.
// //    if (!isset($_SESSION)) session_start();
// //    if($_SESSION['user_level'] == 'Junior Reviewer'){
// //        echo encode($response);
// //    }else{
// //        addReview(0);
// //    }

// }

// function saveReviewForLaterEdit(){
//     //    1 : save review for edit later
//     require_once('../classes/reviews.class.php');

//     if(isset($_POST['modal-review-id'])){
//         $reviewId = $_POST['modal-review-id'];
//         $oReview = new reviews();
//         $oReview->deleteReviews($reviewId);
//     }

//     addReview(1,'SaveForLaterEdit');
// }

// function editReview(){
//     require_once('../classes/reviews.class.php');

//     $reviewId = $_POST['modal-review-id'];
//     $oReview = new reviews();
//     $oReview->deleteReviews($reviewId);

//     addReview(0,'Edit');
//     // Log Activity
//     $report_id = $_REQUEST['review-report-id'];
//     $data = array('activity_type_code' => REVIEW_EDITING_COMPLETED, 'review_id' => $reviewId, 'report_id' => $report_id);
//     $log = logActivity($data);
// }

// function addReview($status,$type){
//     require_once('../classes/report.class.php');
//     require_once('../classes/reviews.class.php');
//     $response = array('success'=>false);

//     $oReviews = new Reviews();
//     $oReport = new Report();

//     if (!isset($_SESSION)) session_start();
//     $report_id = $_REQUEST['review-report-id'];
//     $data = array(
//         'user_id'          => $_SESSION['userid'],
//         'report_id'        => $report_id,
//         'type'             => $_REQUEST['review-report-type'],
//         'total_score'      => isset($_REQUEST['overall-rating-section']) ? $_REQUEST['overall-rating-section'] : 0,
//         'reviewer_identity'=> isset($_REQUEST['review-report-identity']) ? $_REQUEST['review-report-identity'] : '',
//         'reviewer_interest'=> isset($_REQUEST['conflict-of-interest']) ? $_REQUEST['conflict-of-interest'] : '',
//         'ausimm_code'=> isset($_REQUEST['ausimm-code']) ? $_REQUEST['ausimm-code'] : '',
//         'competent_person_commodity'=> isset($_REQUEST['competent-person-commodity']) ? $_REQUEST['competent-person-commodity'] : '',
//         'notes'     => isset($_REQUEST['review-notes']) ? $_REQUEST['review-notes'] : '',
//         'auto_calc'     => (isset($_REQUEST['chk-overall-rating-section']) && $_REQUEST['chk-overall-rating-section'] == 'on') ? true : 0,
//         'status' => $status
//     );
//     $review_id = $oReviews->addReview($data);
//     $questions = $oReport->getAllQuestion();
//     $rating = $oReviews->addAllRating($questions);
//     $section_rating = $oReviews->addSectionRating();
//     $result=$oReport->getReportDetails($report_id);

//     if ($review_id){
//         // Log Activity
//         if($status == 0){
//             sendAdminReviewEmail( $_SESSION['firstname'],$_SESSION['lastname'],$result );
//             $data = array('activity_type_code' => REVIEW_COMPLETED, 'review_id' => $review_id, 'report_id' => $report_id);
//         }else{
//             $data = array('activity_type_code' => REVIEW_SAVE_FOR_LATER_EDIT, 'review_id' => $review_id, 'report_id' => $report_id);
//         }

//         if($type == 'Save')
//             $log = logActivity($data);

//         $response['review'] = $review_id;
//         $response['report_id'] = $report_id;
//         $response['rating'] = $rating;
//         $response['section_rating'] = $section_rating;
//         $response['log'] = isset($log) ? $log : false;
//         $response['success'] = true;
//     }else {
//         $response['error'] = $oReviews->errors();
//     }

//     echo encode($response);
// }

// function fetchreviews(){
//     require_once('../classes/reviews.class.php');
//     if (!isset($_SESSION)) session_start();
//     $userid=$_SESSION['userid'];

//     $oReview = new reviews();
//     $response = array('success'=>false);
//     $savedreviews = $oReview->getsavedreviews($userid);
//     $submittedreviews=$oReview->getsubmittedreviews($userid);

//      if($savedreviews||$submittedreviews){
//             $response['success'] = true;
//             $response['savedReviews'] = $savedreviews;
//             $response['submittedReviews'] = $submittedreviews;

//     }else{

//             $response['errors'] = 'credentials are not correct!';
//     }

//    echo encode($response);

// }

// function deletereview(){
//      require_once('../classes/reviews.class.php');
//      $reviewid=$_POST['id'];

//       $oReview = new reviews();
//       $response = array('success'=>true);
//       $deleterev = $oReview->deleteReviews($reviewid);
//       echo encode($response);

// }

// function signup(){
//     require_once('../classes/signup.class.php');

//     $usersignup = new Signup();

//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $email = $_POST['email'];

//     $string = implode(',',$_POST['reporting-code']);
//     $string_stock = implode(',',$_POST['stocks']);

//     $data = array (
//         'first_name' => $fname,
//         'last_name' => $lname,
//         'email' => $email,
//         'title' => $_POST['title'],
//         'city' => $_POST['city'],
//         'country' => $_POST['country'],
//         'commodity' => $_POST['commodity'],
//         'consultant' => $_POST['consultant'],
//         'experience' => $_POST['experience'],
//         'reporting_experience' => $_POST['reporting-experience'],
//         'reporting_code' => $string,
//         'company' => $_POST['company'],
//         'stocks' => $string_stock,
//         'anonymous' => $_POST['anonymous'],
//         'biography' => $_POST['biography'],
//     );

//     $response = array('success'=>false);
//     $validate_email=$usersignup->checkuser($email);
//     if($validate_email){
//         $signup=$usersignup->signupuser($data);
//         if($signup) {
//             $subject = 'Thank you for applying as a reviewer';
//             $message = '<html><body>Dear ' . $fname . ' ' . $lname . '<br><br>Thank you for applying to become a reviewer on our site <a href="intel.rscmme.com">intel.rscmme.com</a>.  After your application has been reviewed by our team you will be issued a username and password.  Usually this happens within one business day.  Should you have any questions please do not hesitate to contact us by replying to this email.<br><br>Regards <br><br>' . PERSON_NAME . '</body></html>';
//             phpmail($email, $subject, $message);
//             sendAdminMail($data);
//             $response['success'] = true;
//         }
//     }
//     else{
//         $response['errors'] = 'User already exist!';
//    }
//    echo encode($response);
// }

// function addprofileimage(){
//     require_once('../classes/signup.class.php');

//     $status = false;
//     $response = array('success'=>false);
//     $allowed =  array('gif','png' ,'jpg');
//     $target_dir = '../images/upload/';
//     $tmp_name = $_FILES['fileToUpload']['tmp_name'];
//     if (!isset($_SESSION)) session_start();
//     $name = @$_SESSION['username'].$_FILES['fileToUpload']['name'];
//     $ext = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

//     $finalname = $target_dir.$name;
//     if(in_array($ext,$allowed) ) {
//         $status = move_uploaded_file($tmp_name, $finalname);
//     }

//     if($status){
//          $usersignup = new Signup();
//          if(@$_SESSION['username']){
//              $signup=$usersignup->savepicture($name);
//          }
//          $response['success'] = true;
//          $response['pname'] = $name;
//          $_SESSION['pname'] = $name;
//     }
//     else{
//         $response['errors'] = 'image not upload';
//     }
//     echo encode($response);
//  }

// function addresumefile(){
//     $randstring=  generateRandomString();
//     $status = false;
//      $target_dir = '../resume/';
//      $allowed =  array('doc','docx' ,'pdf','txt');
//      $tmp_name = $_FILES['resumeToUpload']['tmp_name'];
//      $name = $randstring.$_FILES['resumeToUpload']['name'];
//      $finalname = $target_dir.$name;
//      $ext = pathinfo($_FILES['resumeToUpload']['name'], PATHINFO_EXTENSION);
//      if(in_array($ext,$allowed) ) {
//         $status = move_uploaded_file($tmp_name, $finalname);
//     }
//      if($status){
//          if (!isset($_SESSION)) session_start();
//          $_SESSION['rname']=$name;
//          if(@$_SESSION['username']){
//              saveResume();
//          }
//          $response['success'] = true;
//          $response['rname']=$name;
//      }
//       else{
//         $response['errors'] = 'file not upload';
//     }
//     echo encode($response);

//  }


//  function saveResume(){
//     require_once('../classes/signup.class.php');

//      if (!isset($_SESSION)) session_start();

//     $resumeName=$_SESSION['rname'];
//     $usersignup = new Signup();
//     $signup=$usersignup->updateresume($resumeName);
//     $response = array('success'=>false);
//     if($signup){
//         $response['success'] = true;
//     }
//     else{
//         $response['errors'] = 'Cannont Update!';
//     }
// //   echo encode($response);
//      return true;
//  }

// function editprofile(){
//      require_once('../classes/signup.class.php');

//     $usersignup = new Signup();
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $biography = $_POST['biography'];

//     $response = array('success'=>false);
//     $signup=$usersignup->updateprofile($fname,$lname,$biography);
//     if($signup){

//         $response['success'] = true;
//         //$response['username'] = $_SESSION['username'];
//     }
//     else{
//         $response['errors'] = 'Cannont Update!';
//     }
//    echo encode($response);
//  }

//  function manageEditprofilecontact(){
//      if (!isset($_SESSION)) session_start();

//     require_once('../classes/signup.class.php');
//     $usersignup = new Signup();

//     $response = array('success'=>false);
//      $daily_updates = (isset($_POST['daily_updates'])) ? 1 : 0;
//      $weekly_updates = (isset($_POST['weekly_updates'])) ? 1 : 0;
//      $invites_updates = (isset($_POST['invites_updates'])) ? 'yes' : 'no';
//      $below_average = (isset($_POST['below_average'])) ? 1 : 0;
//      $new_review_updates = (isset($_POST['new_review_updates'])) ? 1 : 0;

//      $fname = $_POST['fname'];
//      $lname = $_POST['lname'];
//      $email = $_POST['email'];

//     if(!empty($_POST['reporting-code']))
//     {

//         $string = implode(',',$_POST['reporting-code']);
//     }
//     else{
//         $string=$_POST['reportingCode'];
//     }

//     if(!empty($_POST['stocks']))
//     {
//        $string_stock = implode(',',$_POST['stocks']);
//     }
//     else{
//        $string_stock=$_POST['stockExchange'];

//     }

//     //$string_stock = implode(',',$_POST['stocks']);
//      $data = array (
//          'first_name' => $fname,
//          'last_name' => $lname,
//          'email' => $email,
//          'city' => $_POST['city'],
//          'country' => $_POST['country'],
//          'commodity' => $_POST['commodity'],
//          'consultant' => $_POST['consultant'],
//          'experience' => $_POST['experience'],
//          'reporting_experience' => $_POST['reporting-experience'],
//          'reporting_code' =>  $string,
//          'company' => $_POST['company'],
//          'stocks' => $string_stock,
//          'anonymous' => $_POST['anonymous'],
//          'position' => $_POST['position'],
//          'biography' => $_POST['biography'],
//          'daily_updates' => $daily_updates,
//          'weekly_updates' => $weekly_updates,
//          'invites_updates' => $invites_updates,
//          'below_average' => $below_average,
//          'new_review_updates' => $new_review_updates

//      );

//     $signup=$usersignup->updateManageContact($data);
//     if($signup){
//         $response['success'] = true;
//     }
//     else{
//         $response['errors'] = 'Can not update';
//     }
//    echo encode($response);

//  }

// function addPersonalDetails(){
//     require_once('../classes/signup.class.php');
//     $usersignup = new Signup();

//     $response = array('success'=>false);
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $email = $_POST['email'];
//     $new_review_freq = (isset($_POST['new_review_freq'])) ? $_POST['new_review_freq'] : '';
//     $invites_freq = (isset($_POST['invites_freq'])) ? $_POST['invites_freq'] : '';
//     $below_average_freq = (isset($_POST['below_average_freq'])) ? $_POST['below_average_freq'] : '';
//     $summery_report_freq = (isset($_POST['summery_report_freq'])) ? $_POST['summery_report_freq'] : '';

//     $my_report_review = (isset($_POST['my_report_review'])) ? 1 : 0;
//     $new_review_check = (isset($_POST['new_review_check'])) ? 1 : 0;
//     $invites_updates_check = (isset($_POST['invites_updates_check'])) ? 'yes' : 'no';
//     $below_average_check = (isset($_POST['below_average_check'])) ? 1 : 0;
//     $summery_report_check = (isset($_POST['summery_report_check'])) ? 1 : 0;
//     $rsc_advises = (isset($_POST['rsc-advises']) && $_POST['rsc-advises'] == 'on') ? 1 : 0;

//     $data = array (
//         'first_name' => $fname,
//         'last_name' => $lname,
//         'company' => @$_POST['company'],
//         'position' => @$_POST['position'],
//         'country' => @$_POST['country'],
//         'city' => @$_POST['city'],
//         'email' => $email,
//         'consultant' => @$_POST['consultant'],
//         'anonymous' => @$_POST['anonymous'],
//         'register_as' => @$_POST['register_as'],
//         'rsc_advises' => $rsc_advises,
//         'biography' => @$_POST['biography'],
//         'new_review_frequency' => $new_review_freq,
//         'invitation_frequency' => $invites_freq,
//         'below_average_frequency' => $below_average_freq,
//         'summery_report_frequency' => $summery_report_freq,
//         'new_review_updates' => $new_review_check,
//         'invites_updates' => $invites_updates_check,
//         'below_average' => $below_average_check,
//         'summery_report' => $summery_report_check,
//         'my_report_review' => $my_report_review
//     );

//     $email_validation =$usersignup->checkuser($email);

//     if($email_validation){
//         $user_id=$usersignup->signupuser($data);
//         if (!isset($_SESSION)) session_start();
//         $_SESSION['userid'] = $user_id;
//         $membership_res =addPerfessionalMemberships();
//         $commodity_res = saveCommodity();
//         $reporting_res = saveReportingExperience();

//         if($user_id){
//             if($_POST['register_as'] == 'cpqp'){
//                 $subject = 'Thank you for applying as a Competent Qualified Person';
//                 $message = '<html><body>Dear ' . $fname . ' ' . $lname . '<br><br>Thank you for registering as a Competent/Qualified Person on our site <a href="intel.rscmme.com">intel.rscmme.com</a>.  Should you have any questions please do not hesitate to contact us by replying to this email. <br><br> Kind regards, <br>The RSC Mineral Intelligence team</body></html>';
//             }else{
//                 $subject = 'Thank you for applying as a reviewer';
//                 $message = '<html><body>Dear ' . $fname . ' ' . $lname . '<br><br>Thank you for applying to become a reviewer on our site <a href="intel.rscmme.com">intel.rscmme.com</a>.  After your application has been reviewed by our team you will be issued a username and password.  Usually this happens within one business day.  Should you have any questions please do not hesitate to contact us by replying to this email.<br><br> Kind regards, <br>The RSC Mineral Intelligence team</body></html>';
//             }

//             phpmail($email,$subject,$message);
//             sendAdminMail($data);
//             $response['success'] = true;
//             $_SESSION['userid'] = '';
//         }
//     }
//     else{
//         $response['errors'] = 'User already exist!';

//     }

//     echo encode($response);
// }


// function editPersonalDetails(){
//     if (!isset($_SESSION)) session_start();
//     require_once('../classes/signup.class.php');
//     $usersignup = new Signup();

//     $response = array('success'=>false);
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $email = $_POST['email'];

//     $data = array (
//         'first_name' => $fname,
//         'last_name' => $lname,
//         'company' => $_POST['company'],
//         'position' => $_POST['position'],
//         'city' => $_POST['city'],
//         'country' => $_POST['country'],
//         'email' => $email,
//         'biography' => $_POST['biography'],
//     );

//     $signup = $usersignup->updatePersonalDetails($data);

//     if($signup){
//         $response['success'] = true;
//     }
//     else{
//         $response['errors'] = 'Can not update';
//     }
//     echo encode($response);

// }

function editNotification()
{
    if (!isset($_SESSION)) session_start();
    require_once('../classes/signup.class.php');
    $usersignup = new Signup();

    $response = array('success' => false);
    $new_review_freq = (isset($_POST['new_review_freq'])) ? $_POST['new_review_freq'] : '';
    $invites_freq = (isset($_POST['invites_freq'])) ? $_POST['invites_freq'] : '';
    $below_average_freq = (isset($_POST['below_average_freq'])) ? $_POST['below_average_freq'] : '';
    $summery_report_freq = (isset($_POST['summery_report_freq'])) ? $_POST['summery_report_freq'] : '';

    $my_report_review = (isset($_POST['my_report_review'])) ? 1 : 0;
    $new_review_check = (isset($_POST['new_review_check'])) ? 1 : 0;
    $invites_updates_check = (isset($_POST['invites_updates_check'])) ? 'yes' : 'no';
    $below_average_check = (isset($_POST['below_average_check'])) ? 1 : 0;
    $summery_report_check = (isset($_POST['summery_report_check'])) ? 1 : 0;

    $data = array(
        'my_report_review' => $my_report_review,
        'new_review_frequency' => $new_review_freq,
        'invitation_frequency' => $invites_freq,
        'below_average_frequency' => $below_average_freq,
        'summery_report_frequency' => $summery_report_freq,
        'new_review_updates' => $new_review_check,
        'invites_updates' => $invites_updates_check,
        'below_average' => $below_average_check,
        'summery_report' => $summery_report_check
    );

    $result = $usersignup->updateNotification($data);

    if ($result) {
        $response['success'] = true;
    } else {
        $response['errors'] = 'Can not update';
    }
    echo encode($response);
}

function editprofilecontact()
{
    session_start();

    require_once('../classes/signup.class.php');
    $usersignup = new Signup();
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $affiliation = $_POST['affiliation'];
    $position = $_POST['position'];
    $resume = $_SESSION['rname'];

    $response = array('success' => false);
    $signup = $usersignup->updatecontact($fname, $lname, $email, $affiliation, $position, $resume);
    if ($signup) {

        $response['success'] = true;
        //$response['username'] = $_SESSION['username'];
    } else {
        $response['errors'] = 'Can not update';
    }
    echo encode($response);

}

function complaintsave()
{
    require_once('../classes/reviews.class.php');
    session_start();

    $userid = $_SESSION['userid'];
    $complaint = $_POST['complaint'];
    $reviewid = '';//getrevew id from where this popup is attached
    $oReviews = new Reviews();

    $savecomplain = $oReviews->savecomplain($userid, $complaint, $reviewid);
    $response = array('success' => false);
    if ($savecomplain) {
        $to = '';//get id from config
        $subject = 'Complaint';
        $message = $complaint;
        $headers = 'From: RSC' . "\r\n" .
            'Reply-To: support@rscmme.com';

        mail($to, $subject, $message, $headers);
        $response['success'] = true;
    } else {
        $response['errors'] = 'Can not update';
    }
    echo encode($response);
}

function deleteimage()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    session_start();
    $name = 'RP-temp.png';
    echo $name;
    $usersignup = new Signup();
    $signup = $usersignup->savepicture($name);
    $response['success'] = true;
    $response['pname'] = $name;
    $_SESSION['pname'] = $name;
    echo encode($response);
}

function deleteResume()
{
    require_once('../classes/signup.class.php');
    $response = array('success' => false);
    session_start();
    $resume = '';
    $usersignup = new Signup();
    $signup = $usersignup->updateresume($resume);
    if ($signup) {
        $response['success'] = true;
    }

    echo encode($response);
}

function encode($var)
{
    return json_encode($var);
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getHistory()
{

    require_once('../classes/report.class.php');
    require_once('../classes/reviews.class.php');
    $response = array('success' => false);

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $current_report = isset($_POST['current_report']) ? $_POST['current_report'] : false;
    $oReport = new Report();
    $oReview = new reviews();
    $history = $oReport->getHistory($latitude, $longitude, $current_report);

    if ($history) {
        $response['history'] = $history;
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    echo encode($response);
}

function getTransHistory()
{

    require_once('../classes/report.class.php');
    require_once('../classes/reviews.class.php');
    $response = array('success' => false);

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $oReport = new Report();
    $oReview = new reviews();
    $history = $oReport->getTransHistory($latitude, $longitude);

    if ($history) {
        $response['history'] = $history;
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    echo encode($response);
}

function getreportDetailbyName(){
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $reportId = $_GET['name'];
    $oReport = new Report();

    $data = $oReport->getReportMetaDetail($reportId);

    if ($data) {
        $response['success'] = true;
        $response['reportdata'] = $data;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}
function reportDetails()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $reportId = $_POST['reportId'];
    $oReport = new Report();

    $data = $oReport->getReportDetails($reportId);

    if ($data) {
        $response['success'] = true;
        $response['reportdata'] = $data;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}

function complaintFormDetails()
{
    require_once('../classes/report.class.php');
    session_start();
    $response = array('success' => false);

    $userId = $_SESSION['userid'];
    $oReport = new Report();
    $userInfo = $oReport->getUserDetailComplaint($userId);
    if ($userInfo) {
        $response['success'] = true;
        $response['userData'] = $userInfo;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}

function reportUserDetails()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $reportId = $_POST['reportId'];
    $oReport = new Report();
    session_start();
    $userLevel = (isset($_SESSION['level'])) ? $_SESSION['level'] : NULL;

    if ($userLevel == 'Admin') {
        $data = $oReport->getReportUserDetails($reportId);
    } else {
        $data = $oReport->getAnonymousReportUserDetails($reportId);
    }

    if ($data) {
        $response['success'] = true;
        $response['userdata'] = $data;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}

function reportUserReviewRating()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $reportId = $_POST['reportId'];
    $oReport = new Report();

    session_start();
    $userLevel = (isset($_SESSION['level'])) ? $_SESSION['level'] : NULL;

    if ($userLevel == 'Admin') {
        $data = $oReport->getReportUserReviewsDetail($reportId);
    } else {
        $data = $oReport->getAnonymousReportUserReviewsDetail($reportId);
    }

    if ($data) {
        $response['success'] = true;
        $response['userReviewData'] = $data;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}

function getReportUserReviewsRating()
{
    require_once('../classes/report.class.php');
    $response = array('success' => false);

    $reportId = $_POST['report_id'];
    $userId = $_POST['user_id'];
    $oReport = new Report();
    $data = $oReport->getReportUserReviewsRating($reportId, $userId);
    if ($data) {
        $response['success'] = true;
        $response['userReviewData'] = $data;
    } else {
        $response['errors'] = 'data not found!';
    }
    echo encode($response);
}

function phpmail($to, $subject, $message)
{


    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.office365.com';
    $mail->Port = 587; // or 587
    $mail->SMTPSecure = 'STARTLS'; // secure transfer enabled REQUIRED for Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'info@opaxe.com';
    $mail->Password = 'Ventnor@23';
    $mail->AddReplyTo('s.kerkvliet@rscmme.com', 'opaxe');
    $mail->SetFrom('info@opaxe.com', 'opaxe');
    $mail->From = "info@opaxe.com";
    $mail->Subject = $subject;
    $address = $to;
    $mail->AddAddress($address);
    $mail->MsgHTML($message);
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return true;
    }

//    $mail = new PHPMailer;
//    $mail->isSMTP();
//    $mail->SMTPDebug = 0;
//    $mail->SMTPAuth = true;
//    $mail->Debugoutput = 'html';
//    $mail->Host = 'smtp.gmail.com';
//    $mail->Port = 465; // or 587
//    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
//    $mail->SMTPAuth = true;
//    $mail->Username = PHP_MAILER_EMAIL;
//    $mail->Password = PHP_MAILER_PASSWORD;
//    $mail->AddReplyTo(REPLY_EMAIL, 'RSC Mineral Intelligence');
//    $mail->SetFrom(FROM_EMAIL, 'RSC Mineral Intelligence');
//    $mail->Subject = $subject;
//    $address = $to;
//    $mail->AddAddress($address);
//    $mail->MsgHTML($message);
//    //send the message, check for errors
//    if (!$mail->send()) {
//        echo "Mailer Error: " . $mail->ErrorInfo;
//    } else {
//        return true;
//    }

}

function sendAdminMail($data)
{
    //$emailRsc=SIGNUP_EMAIL;
    $first_name = isset($data['first_name']) ? $data['first_name'] : '';
    $last_name = isset($data['last_name']) ? $data['last_name'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $title = isset($data['title']) ? $data['title'] : '';
    $city = isset($data['city']) ? $data['city'] : '';
    $country = isset($data['country']) ? $data['country'] : '';
    $commodity = isset($data['commodity']) ? $data['commodity'] : '';
    $consultant = isset($data['consultant']) ? $data['consultant'] : '';
    $experience = isset($data['experience']) ? $data['experience'] : '';
    $reporting_experience = isset($data['reporting_experience']) ? $data['reporting_experience'] : '';
    $reporting_code = isset($data['reporting_code']) ? $data['reporting_code'] : '';
    $company = isset($data['company']) ? $data['company'] : '';
    $stocks = isset($data['stocks']) ? $data['stocks'] : '';
    $anonymous = isset($data['anonymous']) ? $data['anonymous'] : '';
    $biography = isset($data['biography']) ? $data['biography'] : '';
    $register_as = isset($data['register_as']) ? $data['register_as'] : '';

    $emails = (explode(",", SIGNUP_EMAIL));
    $subjectRsc = 'New reviewer';
    $messageRsc = '<html>';
    $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
    $messageRsc .= '<body>';

    if ($register_as == 'cpqp')
        $messageRsc .= $first_name . ' ' . $last_name . ' has registered as a Competent/Qualified Person.<br><br>';
    else
        $messageRsc .= $first_name . ' ' . $last_name . ' would like to become a reviewer.<br><br>';


    $messageRsc .= '<label>First Name : </label>' . $first_name . '<br>';
    $messageRsc .= '<label>Last Name : </label>' . $last_name . '<br>';
    $messageRsc .= '<label>E-mail : </label>' . $email . '<br>';
    $messageRsc .= '<label>Title : </label>' . $title . '<br>';
    $messageRsc .= '<label>City : </label>' . $city . '<br>';
    $messageRsc .= '<label>Country : </label>' . $country . '<br>';
    $messageRsc .= '<label>Commodity : </label>' . $commodity . '<br>';
    $messageRsc .= '<label>Consultant : </label>' . $consultant . '<br>';
    $messageRsc .= '<label>Experience : </label>' . $experience . '<br>';
    $messageRsc .= '<label>Reporting Experience : </label>' . $reporting_experience . '<br>';
    $messageRsc .= '<label>Reporting Code : </label>' . $reporting_code . '<br>';
    $messageRsc .= '<label>Company : </label>' . $company . '<br>';
    $messageRsc .= '<label>Stocks : </label>' . $stocks . '<br>';
    $messageRsc .= '<label>Anonymous : </label>' . $anonymous . '<br>';
    $messageRsc .= '<label>Biography : </label>' . $biography . '<br>';

    // Resume
    $resume = isset($_SESSION['rname']) ? $_SESSION['rname'] : '';
    $resumeName = '/resume/' . $resume;
    $resume_url = "http://$_SERVER[HTTP_HOST]$resumeName";
    $messageRsc .= '<label>Resume : </label><a href="' . $resume_url . '" target="_blank">' . $resume . '</a><br>';
    // Profile Picture
    $img = isset($_SESSION['pname']) ? $_SESSION['pname'] : '';
    $imageName = '/images/upload/' . $img;
    $img_url = "http://$_SERVER[HTTP_HOST]$imageName";
    $messageRsc .= '<label>Profile Picture : </label><a href="' . $img_url . '" target="_blank">' . $img . '</a> <br>';

    $messageRsc .= '</body></html>';

    foreach ($emails as $emailRsc) {
        phpmail($emailRsc, $subjectRsc, $messageRsc);
    }


    //$emailSecondRsc='r.sterk@rscmme.com';
    //phpmail($emailSecondRsc,$subjectRsc,$messageRsc);
}

function expertPanel()
{
    require_once('../classes/login.class.php');
    $oRSc = new Rsc();
    $response = array('success' => false);

    $getUser = $oRSc->getUser();
    if ($getUser) {
        $response['success'] = true;
        $response['expertPanel'] = $getUser;
    } else {

        $response['errors'] = 'data not found!';
    }

    echo encode($response);
}


/**
 * Log Activity
 */
function logActivity($data)
{
    require_once('../classes/activity.class.php');

    if (!isset($_SESSION)) session_start();

    $data['user_id'] = $_SESSION['userid'];
    $data['session_id'] = $_SESSION['session_id'];

    $oActivity = new Activity();
    $response = array('success' => true);
    $log = $oActivity->logActivity($data);

    if ($log) {
        $response['log'] = $log;
        $response['success'] = true;
    } else {
        $response['error'] = $oActivity->errors();
    }

    return $response;
}

function logReviewStart()
{
    $response = array('success' => true);

    // Log Activity
    $report_id = isset($_REQUEST['report_id']) ? $_REQUEST['report_id'] : null;
    if (isset($_REQUEST['review_id'])) {
        $reviewId = $_REQUEST['review_id'];
        $data = array('activity_type_code' => REVIEW_EDITING_STARTED, 'review_id' => $reviewId);
    } else {
        $data = array('activity_type_code' => REVIEW_STARTED, 'report_id' => $report_id);
    }

    $log = logActivity($data);

    if ($log) {
        $response['log'] = $log;
        $response['success'] = true;
    } else {
        $response['error'] = '';
    }

    echo encode($response);
}

function logReviewClose()
{
    $response = array('success' => true);

    // Log Activity
    $report_id = isset($_REQUEST['report_id']) ? $_REQUEST['report_id'] : null;
    $data = array('activity_type_code' => REVIEW_CLOSE, 'report_id' => $report_id);
    $log = logActivity($data);

    if ($log) {
        $response['log'] = $log;
        $response['success'] = true;
    } else {
        $response['error'] = '';
    }

    echo encode($response);
}

function populateCountries()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    $usersignup = new Signup();
    $countries = $usersignup->getCountries();
    if ($countries) {
        $response['success'] = true;
        $response['countries'] = $countries;
    } else {
        $response['error'] = 'countries not found!';
    }
    echo encode($response);
}

function populateCommodity()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    $usersignup = new Signup();
    $commodity = $usersignup->getCommodity();
    if ($commodity) {
        $response['success'] = true;
        $response['commodity'] = $commodity;
    } else {
        $response['error'] = 'commodities not found!';
    }
    echo encode($response);
}

function sendAdminReviewEmail($fName, $lName, $result)
{
    $cpQp = str_replace("[Overall Report]:", "", $result[0]['cpqp']);
    $cpQp = str_replace("[Resources]:", "", $cpQp);
    $subjectRsc = 'Review has been submitted';
    $messageRsc = '<html><body>The user ' . $fName . ' ' . $lName . ' has submitted a review against the report with details as follow:<br><br><b>Date: </b> ' . $result[0]['date'] . '<br><b>Company: </b> ' . $result[0]['company'] . '<br><b>Project: </b> ' . $result[0]['project'] . '<br><b>Report Code: </b> ' . $result[0]['code'] . '<br><b>Report Type: </b> ' . $result[0]['type'] . '<br><b>CP/QP: </b> ' . $cpQp . '</body></html>';
    $emails = (explode(",", REVIEW_EMAIL));

    foreach ($emails as $emailRsc) {
        phpmail($emailRsc, $subjectRsc, $messageRsc);
    }
}

function submitComplaint()
{
    require_once('../classes/complaint.class.php');

    $oComplaint = new Complaint();
    $response = array('success' => false);

    $data = array(
        'name' => isset($_POST['nameComplaint']) ? $_POST['nameComplaint'] : null,
        'date' => isset($_POST['dateComplaint']) ? $_POST['dateComplaint'] : null,
        'company' => isset($_POST['companyComplaint']) ? $_POST['companyComplaint'] : null,
        'email' => isset($_POST['emailComplaint']) ? $_POST['emailComplaint'] : null,
        'address' => isset($_POST['addressComplaint']) ? $_POST['addressComplaint'] : null,
        'phone' => isset($_POST['contactComplaint']) ? $_POST['contactComplaint'] : null,
        'cpqp' => isset($_POST['cpqpComplaint']) ? $_POST['cpqpComplaint'] : null,
        'complaint' => isset($_POST['Complaint']) ? $_POST['Complaint'] : null,
        'securities' => isset($_POST['securities-exchangesComplaint']) ? $_POST['securities-exchangesComplaint'] : null,
        'organistation' => isset($_POST['professional-organisationComplaint']) ? $_POST['professional-organisationComplaint'] : null,
        'lawTick' => isset($_POST['law-tick']) ? $_POST['law-tick'] : null,
        'ethicsTick' => isset($_POST['ethics-tick']) ? $_POST['ethics-tick'] : null,
        'jorcTick' => isset($_POST['jorc-tick']) ? $_POST['jorc-tick'] : null,
        'valminTick' => isset($_POST['valmin-tick']) ? $_POST['valmin-tick'] : null,
        'law' => isset($_POST['law']) ? $_POST['law'] : null,
        'ethics' => isset($_POST['ethics']) ? $_POST['ethics'] : null,
        'jorc' => isset($_POST['jorc']) ? $_POST['jorc'] : null,
        'valmin' => isset($_POST['valmin']) ? $_POST['valmin'] : null,
        'otherDetail' => isset($_POST['otherDetail']) ? $_POST['otherDetail'] : null,
        'reviewId' => isset($_POST['complaint-review-id']) ? $_POST['complaint-review-id'] : null
    );

    $complainSave = $oComplaint->saveComplaint($data);
    if ($complainSave) {
        $response['success'] = true;
    } else {
        $response['error'] = $oComplaint->errors();;
    }

    echo encode($response);

}

function lessRating()
{

    require_once('../classes/complaint.class.php');

    $oComplaint = new Complaint();
    $response = array('success' => false);

    $data = array(
        'name' => isset($_POST['name-hidden']) ? $_POST['name-hidden'] : null,
        'email' => isset($_POST['email-hidden']) ? $_POST['email-hidden'] : null,
        'cpqp' => isset($_POST['respond-cpqp']) ? $_POST['respond-cpqp'] : null,
        'contact_cpqp' => isset($_POST['contact-cpqp']) ? $_POST['contact-cpqp'] : null,
        'reviewId' => isset($_POST['complaint-review-id']) ? $_POST['complaint-review-id'] : null
    );

    $complainSave = $oComplaint->lessRating($data);
    if ($complainSave) {
        $response['success'] = true;
    } else {
        $response['error'] = $oComplaint->errors();
    }

    echo encode($response);
}

function emailAllReviewers()
{
    require_once('../classes/report.class.php');
    require_once('../classes/invitation.class.php');
    session_start();

    $report_id = $_POST['id'];
    $oReviews = new Report();
    $reportDetails = $oReviews->getReportDetails($report_id);
    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $reviewerNote = $_POST['reviewerNote'];
    $userName = new Invitation();
    $userEmail = $userName->allUserEmail();
    $subject = 'Report Review Invitation';
    foreach ($userEmail as $email) {
        $to = $email['email'];
        $message = inviteReviewerEmail($reviewerNote, $reportDetails, $report_id, $to);
        $save = $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    }

    $response = array('success' => true);
    echo encode($response);
}

function populateUsername()
{
    require_once('../classes/invitation.class.php');
    $response = array('success' => false);
    $userName = new Invitation();
    $result = $userName->getUsername();
    if ($result) {
        $response['success'] = true;
        $response['username'] = $result;
    }
    echo encode($response);
}

function inviteReviewerUsername()
{
    require_once('../classes/invitation.class.php');
    require_once('../classes/report.class.php');
    session_start();
    $response = array('success' => false);
    $report_id = $_POST['reportId'];
    $oReviews = new Report();
    $reportDetails = $oReviews->getReportDetails($report_id);
    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $user = $_POST['username'];
    $reviewerNote = $_POST['reviewerNote'];
    $userName = new Invitation();
    $result = $userName->getUserEmail($user);
    if ($result) {
        $response['success'] = true;
        $to = $result[0]['email'];
        $subject = 'Report Review Invitation';
        $message = inviteReviewerEmail($reviewerNote, $reportDetails, $report_id, $to);
        $save = $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    }
    echo encode($response);
}

function invitereviewer()
{
    require_once('../classes/report.class.php');
    require_once('../classes/invitation.class.php');
    session_start();
    $userName = new Invitation();
    $reviewerNote = $_POST['reviewerNote'];
    $email = $_POST['email'];
    $report_id = $_POST['reportId'];
    $oReviews = new Report();
    $reportDetails = $oReviews->getReportDetails($report_id);
    $to = $email;
    $subject = 'Report Review Invitation';
    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $message = inviteReviewerEmail($reviewerNote, $reportDetails, $report_id, $email);
    $save = $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    $response = array('success' => true);
    echo encode($response);
}

function inviteAllCode()
{
    require_once('../classes/report.class.php');
    require_once('../classes/invitation.class.php');
    session_start();

    $report_id = $_POST['reportId'];
    $oReviews = new Report();
    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $reviewerNote = $_POST['reviewerNote'];
    $code = $_POST['reportingCode'];
    $userName = new Invitation();
    $userEmail = $userName->allUserCode($code);
    foreach ($userEmail as $email) {
        $to = $email['email'];
        $save = $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    }

    $response = array('success' => true);
    echo encode($response);
}

function inviteAllMarketing()
{
    require_once('../classes/report.class.php');
    require_once('../classes/invitation.class.php');
    session_start();

    $report_id = $_POST['reportId'];
    $oReviews = new Report();
    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $reviewerNote = $_POST['reviewerNote'];
    $stocks = $_POST['stocks'];
    $userName = new Invitation();
    $userEmail = $userName->allUserMarketing($stocks);
    foreach ($userEmail as $email) {
        $to = $email['email'];
        $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    }

    $response = array('success' => true);
    echo encode($response);
}

function inviteAllCommodity()
{
    require_once('../classes/report.class.php');
    require_once('../classes/invitation.class.php');
    session_start();

    $report_id = $_POST['reportId'];
    $oReviews = new Report();
    $save = false;

    $overallRating = $oReviews->getOverallRatting($_SESSION['userid'], $report_id);
    $reviewerNote = $_POST['reviewerNote'];
    $commodity = $_POST['commodity'];
    $userName = new Invitation();
    $userEmail = $userName->allUserCommodity($commodity);

    foreach ($userEmail as $email) {
        $to = $email['email'];
        $save = $userName->saveInvite($_SESSION['userid'], $report_id, $to, $overallRating[0]['id'], $reviewerNote);
    }

    $response = array(
        'success' => true,
        'save' => $save,
    );
    echo encode($response);
}

function sendMessageEmail()
{
    require_once('../classes/report.class.php');
    require_once('../classes/login.class.php');
    require_once('../classes/reviews.class.php');

    $oReview = new Reviews();
    $oReport = new Report();
    $oUser = new Rsc();

    $reportData = $oReport->getReportDetails($_POST['reportId']);

    $subject = $_POST['subject'];
    $user_message = $_POST['message'];
    $to_email = $_POST['email'];
    $receiver = $oUser->getDetailByEmail($to_email);
    $first_name = isset($receiver[0]['firstname']) ? $receiver[0]['firstname'] : '';
    $last_name = isset($receiver[0]['lastname']) ? $receiver[0]['lastname'] : '';
    $receiverName = $first_name . ' ' . $last_name;
    $emails = [REVIEW_EMAIL, $to_email];
    $subscriberUpdateOpt = 'Private messages';

    //OverAll rating
    $oReview->setReportId($_REQUEST['reportId']);
    $sections = $oReview->getReviewRating();
    $overall_rating = (int)$sections[0]['total_score'] / (int)$sections[0]['total'];

    if (!isset($_SESSION)) session_start();
    if (isset($_SESSION['anonymous']) && $_SESSION['anonymous'] == 'yes')
        $senderName = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
    else
        $senderName = 'An anonymous user';

    $message = 'Dear ' . $receiverName . ',<br><br>';
    $message .= $senderName . ' has left the following private message for you:';
    $message .= '<p><i>' . $user_message . '</i></p>';
    $message .= 'This message was sent in regards to the following ' . $reportData[0]['type'] . ' <a href="' . $reportData[0]['download'] . '" target="_blank">report</a>';

    $messageRsc = '<html><body>' . $message . '<br>';
    $messageRsc .= '<br><b>Date :</b> ' . $reportData[0]['date'];
    $messageRsc .= '<br><b>Company :</b> ' . $reportData[0]['company'];
    $messageRsc .= '<br><b>Project :</b> ' . $reportData[0]['project'];
    $messageRsc .= '<br><b>CPQP :</b> ' . $reportData[0]['cpqp'];
    $messageRsc .= '<br><b>Report Type :</b> ' . $reportData[0]['type'];
    $messageRsc .= '<br><b>Report Code :</b> ' . $reportData[0]['code'];
    $messageRsc .= '<br><b>Overall Rating :</b> ' . number_format($overall_rating, 2) . '<br>';

    $messageRsc .= '<br><br>If you would like to respond click <a href="mailto:s.kerkvliet@rscmme.com?subject=Message against review" target="_blank">here</a>. Or if you would like to edit your review, or review another report, please log on to our website: <a href="http://intel.rscmme.com/" target="_blank">http://intel.rscmme.com/</a>';
    $messageRsc .= '<br><br>Kind regards,';
    $messageRsc .= '<br><br>The RSC Mineral Intelligence team';
    $messageRsc .= '<br><br><p style="color: #4a4a4a;font-size: 0.78em;">This email was sent to <a href="#">' . $to_email . '</a> because you have subscribed to receive <b>' . $subscriberUpdateOpt . '.</b> if you no longer wish to receive these emails, please update your subscription by logging on to our <a href="http://intel.rscmme.com/" target="_blank">website</a> and update your profile.</p>';
    $messageRsc .= '</body></html>';

    foreach ($emails as $emailRsc) {
        $res = phpmail($emailRsc, $subject, $messageRsc);
    }

    if ($res == 1) {
        $response['success'] = true;
    } else {
        $response['error'] = 'Message not sent!';
    }

    echo encode($response);

}

function inviteReviewerEmail($reviewerNote, $reportDetails, $report_id, $email)
{
    $overallRating = getOverAllRating($report_id);
    $message = 'Dear registered reviewer,<br><br>';
    $message .= 'A new review has been submitted by a <b>' . $_SESSION['level'] . '</b> for the following <b>' . $reportDetails[0]['type'] . '</b> report:<br><br>';
    $message .= '<b>Date :</b>' . $reportDetails[0]['date'] . '<br>';
    $message .= '<b>Company :</b>' . $reportDetails[0]['company'] . '<br>';
    $message .= '<b>Project :</b>' . $reportDetails[0]['project'] . '<br>';
    $message .= '<b>CP/QP :</b>' . $reportDetails[0]['cpqp'] . '<br>';
    $message .= '<b>Report Type :</b>' . $reportDetails[0]['type'] . '<br>';
    $message .= '<b>Report Code :</b>' . $reportDetails[0]['code'] . '<br>';
    $message .= '<b>Overall Rating :</b>' . $overallRating . '<br><br>';

    if ($reviewerNote) {
        $message .= 'The reviewer&#39;s note is as follow:<br>' . $reviewerNote;
    }

    $message .= '<br><br>If you are interested to submit a review for this report as well, or would like to review another report, please log on to our website: <a href="http://intel.rscmme.com/">http://intel.rscmme.com/</a>';
    $message .= '<br><br>Kind regards,';
    $message .= '<br><br>The RSC Mineral Intelligence team';
    $message .= '<br><br><p style="color: #4a4a4a;font-size: 0.78em;">This email was sent to <a href="#">' . $email . '</a> because you have subscribed to receive <b>Invites from other reviewers</b>. If you no longer wish to receive these emails, please update your subscription by logging on to our <a href="http://intel.rscmme.com/">website</a> and update your profile.</p>';
    $message .= '</body></html>';
    return $message;
}

function getOverAllRating($reportId)
{
    require_once('../classes/reviews.class.php');

    $oReview = new Reviews();
    $oReview->setReportId($reportId);
    $sections = $oReview->getReviewRating();
    return $sections[0]['total_score'] / (int)$sections[0]['total'];
}

function getReviewerDetail()
{
    require_once('../classes/login.class.php');

    $oRSc = new Rsc();
    $response = array('success' => false);
    $reviewer = $oRSc->getReviewerDetail();
    if ($reviewer) {
        $response['success'] = true;
        $response['reviewer'] = $reviewer[0];
    } else {
        $response['errors'] = $oRSc->errors();
    }

    echo encode($response);
}

function getOrganisation()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    $oAccount = new Signup();
    $organisation = $oAccount->getOrganisation();
    if ($organisation) {
        $response['success'] = true;
        $response['organisation'] = $organisation;
    } else {
        $response['error'] = $oAccount->errors();
    }
    echo encode($response);
}

function getUserOrganisation()
{
    require_once('../classes/login.class.php');
    $response = array('success' => false);
    $oRsc = new Rsc();
    $organisation = $oRsc->getUserOrganizations();
    if ($organisation) {
        $response['success'] = true;
        $response['organisation'] = $organisation;
    } else {
        $response['error'] = $oRsc->errors();
    }
    echo encode($response);
}

function getUserCommodity()
{
    require_once('../classes/login.class.php');
    $response = array('success' => false);
    $oRsc = new Rsc();
    $commodity = $oRsc->getUserCommodityExperience();
    if ($commodity) {
        $response['success'] = true;
        $response['commodity'] = $commodity;
    } else {
        $response['error'] = $oRsc->errors();
    }
    echo encode($response);
}

function getUserReportingCode()
{
    require_once('../classes/login.class.php');
    $response = array('success' => false);
    $oRsc = new Rsc();
    $code = $oRsc->getUserReportingExperience();
    if ($code) {
        $response['success'] = true;
        $response['code'] = $code;
    } else {
        $response['error'] = $oRsc->errors();
    }
    echo encode($response);
}

function getUpdatePersonalDetails()
{
    require_once('../classes/login.class.php');
    $response = array('success' => false);
    $oRsc = new Rsc();
    $detail = $oRsc->getProfileDetail();
    if ($detail) {
        $response['success'] = true;
        $response['personal_detail'] = $detail[0];
    } else {
        $response['error'] = $oRsc->errors();
    }
    echo encode($response);
}


function getCommodity()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    $oAccount = new Signup();
    $commodity = $oAccount->getCommodity();
    $commodityType = $oAccount->getCommodityType();
    $commodityStyle = $oAccount->getCommodityStyle();
    if ($commodity && $commodityType) {
        $response['success'] = true;
        $response['commodity_type'] = $commodityType;
        $response['commodity'] = $commodity;
        $response['commodity_style'] = $commodityStyle;
    } else {
        $response['error'] = $oAccount->errors();
    }
    echo encode($response);
}

function getReportingCode()
{
    require_once('../classes/signup.class.php');

    $response = array('success' => false);
    $oAccount = new Signup();
    $reportingCode = $oAccount->getReportingCode();
    if ($reportingCode) {
        $response['success'] = true;
        $response['code'] = $reportingCode;
    } else {
        $response['error'] = $oAccount->errors();
    }
    echo encode($response);
}

function addPerfessionalMemberships()
{

    if (!isset($_SESSION)) session_start();
    require_once('../classes/signup.class.php');
    $usersignup = new Signup();
    $response = array('success' => false);
    $result = false;
    $update = '';
    if (@$_SESSION['username']) {
        $update = $usersignup->updateUserOrganization();
    }


    if (isset($_POST['organistation-name'])) {
        $len = count($_POST['organistation-name']);
        for ($i = 0; $i < $len; $i++) {
            $organization_id = (isset($_POST['organistation-name'][$i])) ? $_POST['organistation-name'][$i] : null;
            $membership_no = (isset($_POST['membership-no'][$i])) ? $_POST['membership-no'][$i] : '';
            $org_membership = (isset($_POST['membership-other'][$i])) ? $_POST['membership-other'][$i] : 0;
            $org_member = (isset($_POST['member'][$i])) ? $_POST['member'][$i] : 0;
            $org_fellow = (isset($_POST['org_fellow'][$i])) ? $_POST['org_fellow'][$i] : 0;
            $org_cp = (isset($_POST['org_cp'][$i])) ? $_POST['org_cp'][$i] : 0;
            $org_rp = (isset($_POST['org_rp'][$i])) ? $_POST['org_rp'][$i] : 0;
            $org_other = (isset($_POST['org_other'][$i])) ? $_POST['org_other'][$i] : null;

            $data = array(
                'organisation_id' => $organization_id,
                'membership_no' => $membership_no,
                'org_membership' => $org_membership,
                'org_member' => $org_member,
                'org_fellow' => $org_fellow,
                'org_cp' => $org_cp,
                'org_rpgeo' => $org_rp,
                'org_other' => $org_other
            );

            $result = $usersignup->addUserOrganization($data);


        }
    }

    if ($result || $update) {
        $response['membership'] = $result;
        $response['success'] = true;
        $response['update'] = $update;
    } else {
        $response['errors'] = 'Can not update';
    }

    if (@$_SESSION['username']) {
        echo encode($response);
    } else {
        return true;
    }


}

function saveCommodity()
{
    require_once('../classes/signup.class.php');
    $response = array('success' => false);
    $commodity = false;
    $oAccount = new Signup();

    if (!isset($_SESSION)) session_start();
    $user_id = $_SESSION['userid'];
    $update = '';
    if (@$_SESSION['username']) {
        $update = $oAccount->updateUserCommodity($user_id);
    }


    if (isset($_REQUEST['commodity-name'])) {
        for ($i = 0; $i < count($_REQUEST['commodity-name']); $i++) {
            $other = isset($_REQUEST['commodity-text'][$i]) ? $_REQUEST['commodity-text'][$i] : '';
            $data = array(
                'user_id' => $user_id,
                'commodity_id' => isset($_REQUEST['commodity-name'][$i]) ? $_REQUEST['commodity-name'][$i] : null,
                'commodity_style' => (isset($_REQUEST['commodity-style'][$i]) && $_REQUEST['commodity-style'][$i] != "") ? $_REQUEST['commodity-style'][$i] : $other,
                'commodity_experience' => isset($_REQUEST['commodity-experience'][$i]) ? $_REQUEST['commodity-experience'][$i] : '',
                'status' => 0
            );
            $commodity = $oAccount->addUserCommodity($data);
        }
    }


    if ($commodity || $update) {
        $response['commodity'] = $commodity;
        $response['success'] = true;
        $response['update'] = $update;
    } else {
        $response['error'] = $oAccount->errors();
    }

    if (@$_SESSION['username']) {
        echo encode($response);
    } else {
        return true;
    }
}

function saveReportingExperience()
{
    require_once('../classes/signup.class.php');
    $response = array('success' => false);
    $reporting = false;
    $oAccount = new Signup();

    if (!isset($_SESSION)) session_start();
    $user_id = $_SESSION['userid'];
    $update = '';
    if (@$_SESSION['username']) {
        $update = $oAccount->updateUserReporting($user_id);
    }

    if (isset($_REQUEST['reporting-code'])) {
        for ($i = 0; $i < count($_REQUEST['reporting-code']); $i++) {
            $data = array(
                'user_id' => $user_id,
                'reporting_id' => isset($_REQUEST['reporting-code'][$i]) ? $_REQUEST['reporting-code'][$i] : null,
                'reporting_experience' => isset($_REQUEST['reporting-experience'][$i]) ? $_REQUEST['reporting-experience'][$i] : '',
                'rep_exchanges' => isset($_REQUEST['reporting-exchange'][$i]) ? $_REQUEST['reporting-exchange'][$i] : '',
                'status' => 0
            );
            $reporting = $oAccount->addUserReporting($data);
        }
    }

    if ($reporting || $update) {
        $response['commodity'] = $reporting;
        $response['success'] = true;
        $response['update'] = $update;
    } else {
        $response['error'] = $oAccount->errors();
    }

    if (@$_SESSION['username']) {
        echo encode($response);
    } else {
        return true;
    }
}


function uploadAttachFile()
{
    $rand = generateRandomString();
    $target_dir = '../resume/';
    $tmp_name = $_FILES['upload-attach-file']['tmp_name'];
    $name = $rand . '-' . $_FILES['upload-attach-file']['name'];
    $finalPath = $target_dir . $name;
    // todo: exclude .exe file
    $status = move_uploaded_file($tmp_name, $finalPath);
    if ($status) {
        $response['success'] = true;
        $response['file_name'] = $name;
    } else {
        $response['errors'] = 'file not upload';
    }
    echo encode($response);

}

function saveComplaint()
{
    sendComplaintEmail();
}

function sendComplaintEmail()
{
    require_once('../classes/complaint.class.php');
    $response = array('success' => false);
    $oComplaint = new Complaint();

    $subject = 'REVIEW COMPLAINT';
    $attach = isset($_REQUEST['attchedFileName']) ? $_REQUEST['attchedFileName'] : null;
    $download = isset($_REQUEST['txt-download-complaint']) ? $_REQUEST['txt-download-complaint'] : '';
    $complaint_name = isset($_REQUEST['complaint-name']) ? $_REQUEST['complaint-name'] : '';
    $preferred_address_1 = isset($_REQUEST['preferred-address-1']) ? $_REQUEST['preferred-address-1'] : '';
    $preferred_address_2 = isset($_REQUEST['preferred-address-2']) ? $_REQUEST['preferred-address-2'] : '';

    $qualified_persons = (isset($_REQUEST['qualified-persons']) && $_REQUEST['qualified-persons'] == 'on') ? true : false;
    $cpqp_breach_ethics = (isset($_REQUEST['cpqp-breach-ethics']) && $_REQUEST['cpqp-breach-ethics'][0] == 'on') ? true : false;
    $cpqp_membership_issue = (isset($_REQUEST['cpqp-membership-issue']) && $_REQUEST['cpqp-membership-issue'][0] == 'on') ? true : false;

    $complaint_prefer_contacted = 'Email';
    if (isset($_REQUEST['complaint-prefer-contacted'])) {
        $complaint_prefer_contacted = ($_REQUEST['complaint-prefer-contacted'] == 'phone') ? 'Phone' : 'Email';
    }

    $attachPath = '../resume/' . $attach;
    $message = '<html>';
    $message .= '<body>Dear Sir/Madam,<br><br>';
    $message .= '<p>I, ' . $complaint_name . ' wish to make a complaint in relation to the Public Report released by a mineral exploration and mining company. I wish to notify you of a suspected instance of:</p>';
    if ($qualified_persons)
        $message .= '<p>public report non-compliance</p>';
    if ($cpqp_breach_ethics)
        $message .= '<p>a breach of conduct or ethics by a Competent/Qualified</p>';
    if ($cpqp_membership_issue)
        $message .= '<p>a false claim of membership to a professional organisation.</p>';
    $message .= '<p>I have submitted this complaint using the confidential complaint submission form provided by the Public Report Review portal operated by <a href="http://www.rscmme.com/" target="_blank">www.rscmme.com</a> . This notification should contain all the information you require, but if further clarification or information is needed please contact me by ' . $complaint_prefer_contacted . '.</p>';
    $message .= '<h3>My Details:</h3>';
    if (isset($_REQUEST['complaint-name']))
        $message .= 'Name: ' . $_REQUEST['complaint-name'] . '<br>';
    if (isset($_REQUEST['preferred-address']))
        $message .= 'Address: ' . $_REQUEST['preferred-address'] . ' ' . $preferred_address_1 . ' ' . $preferred_address_2 . '<br>';
    if (isset($_REQUEST['complaint-email']))
        $message .= 'Email: ' . $_REQUEST['complaint-email'] . '<br>';
    if (isset($_REQUEST['complaint-telephone']))
        $message .= 'Phone: ' . $_REQUEST['complaint-telephone'] . '<br>';
    $message .= '<p>I am a member of the following professional organisations:</p>';
    if (isset($_REQUEST['complaint-organization'])) {
        for ($i = 0; $i < count($_REQUEST['complaint-organization']); $i++) {
            $organization = isset($_REQUEST['complaint-organization'][$i]) ? $_REQUEST['complaint-organization'][$i] : '';
            $membership_no = isset($_REQUEST['complaint-membership-number'][$i]) ? ' ( ' . $_REQUEST['complaint-membership-number'][$i] . ' ) ' : '';
            $message .= '<p>' . $organization . $membership_no . '</p>';
        }
    }
    $message .= '<br><br>';
    $message .= '<h3>Complaint Summary:</h3>';
    $message .= '<p>My complaint is in relation to the following public report:</p>';
    if (isset($_REQUEST['txt-date-complaint']))
        $message .= 'Dated: ' . $_REQUEST['txt-date-complaint'] . '<br>';
    if (isset($_REQUEST['txt-company-complaint']))
        $message .= 'Company: ' . $_REQUEST['txt-company-complaint'] . '<br>';
    if (isset($_REQUEST['txt-type-complaint']))
        $message .= 'Report Type: ' . $_REQUEST['txt-type-complaint'] . '<br>';
    if (isset($_REQUEST['txt-cpqp-complaint']))
        $message .= 'Relevant Code/Guideline: ' . $_REQUEST['txt-cpqp-complaint'] . '<br>';
    $message .= '<br>';
    if (isset($_REQUEST['complaint-cpqp-name'])) {
        for ($i = 0; $i < count($_REQUEST['complaint-cpqp-name']); $i++) {
            $complaint_cpqp_name = isset($_REQUEST['complaint-cpqp-name'][$i]) ? $_REQUEST['complaint-cpqp-name'][$i] : '';
            $complaint_company = isset($_REQUEST['complaint-company'][$i]) ? $_REQUEST['complaint-company'][$i] : '';
            $message .= '<p>It is my opinion that ' . $complaint_cpqp_name . ' has made a false claim of membership/affiliation with ' . $complaint_company . '.</p>';
        }
    }
    $message .= '<br>';
    if (isset($_REQUEST['cpqp-membership-organisation'])) {
        for ($i = 0; $i < count($_REQUEST['cpqp-membership-organisation']); $i++) {
            $complaint_cpqp_name = isset($_REQUEST['complaint-cpqp-name'][0]) ? $_REQUEST['complaint-cpqp-name'][0] : ''; //Todo : Fixed for multiple CPQP
            $member_issue_contacted = isset($_REQUEST['member-issue-contacted'][$i]) ? $_REQUEST['member-issue-contacted'][$i] : '';
            $cpqp_breach_ethics = (isset($_REQUEST['cpqp-breach-ethics']) && $_REQUEST['cpqp-breach-ethics'][$i] == 'on') ? true : false;;
            $breach_conduct_contacted = isset($_REQUEST['breach-conduct-contacted'][$i]) ? $_REQUEST['breach-conduct-contacted'][$i] : '';
            $cpqp_code_guideline = (isset($_REQUEST['cpqp-code-guideline'][$i]) && $_REQUEST['cpqp-code-guideline'][$i] == 'NI 43-101') ? 'Qualified Person' : 'Competent Person';
            if ($member_issue_contacted == 2)
                $message .= '<p>It is my opinion that ' . $complaint_cpqp_name . ' does not have the required level of membership to be considered a ' . $cpqp_code_guideline . ' in accordance with the ' . $_REQUEST['txt-cpqp-complaint'] . '.</p>';

            if ($cpqp_breach_ethics)
                $message .= '<p>It is my opinion that ' . $complaint_cpqp_name . ' has breached ' . $breach_conduct_contacted . '.</p>';

            $message .= '<p>(In addition) it is my opinion that the Public Report stated above is not compliant with ' . $cpqp_code_guideline . '.</p>';
        }
    }
    $message .= '<br>';
    if (isset($_REQUEST['complaint-detail-info']))
        $message .= $_REQUEST['complaint-detail-info'] . '<br>';

    $message .= '<p>Please find a copy of the Public Report in question attached to this email.[or] As the Public Report in question is too large to send via email, please find a link to copy of it here: <a href="' . $download . '" target="_blank">Report</a></p>';
    $message .= ''; //Todo:
    $message .= '<p>If you have an question in relation to this complaint please contact me directly. If you have any comments or suggestions about how the submission of this and other complaints to your organisation can be improved, please contact RSC at <a href="mailto:info@rscmme.com">info@rscmme.com</a>.</p>';
    $message .= '<br><p>Kind Regards,</p><br>';
    $message .= $complaint_name . '<br>';
    $message .= '</body>';
    $message .= '</html>';

    // Send Email
    $emails = (explode(",", COMPLAINT_EMAIL));
    foreach ($emails as $email) {
        $complaint = phpmailWithAttachment($email, $subject, $message, $attachPath);
    }


    if ($complaint) {
        $response['complaint'] = $complaint;
        $response['success'] = true;
    } else {
        $response['error'] = $oComplaint->errors();
    }

    echo encode($response);
}

function phpmailWithAttachment($to, $subject, $message, $attach)
{

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.oneclout.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = PHP_MAILER_EMAIL;
    $mail->Password = PHP_MAILER_PASSWORD;
    $mail->AddReplyTo(REPLY_EMAIL, 'RSC Mineral Intelligence');
    $mail->SetFrom(FROM_EMAIL, 'RSC Mineral Intelligence');
    $mail->AddAttachment($attach);
    $mail->Subject = $subject;
    $address = $to;
    $mail->AddAddress($address);
    $mail->MsgHTML($message);
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return true;
    }
}

function subscribe()
{
    require_once('../classes/invitation.class.php');
    $response = array('success' => false);

    $oInvitation = new invitation();
    $name = isset($_REQUEST['subscriber-name']) ? $_REQUEST['subscriber-name'] : '';
    $email = isset($_REQUEST['EMAIL']) ? $_REQUEST['EMAIL'] : '';
    $token = $name . $email . date("Y-m-d") . rand(10, 1000);
    $token = md5($token);

    $data = array(
        'name' => $name,
        'email' => $email,
        'new_report' => (isset($_REQUEST['weekly-summary-report']) && $_REQUEST['weekly-summary-report'] == 'on') ? true : 0,
        'new_review' => (isset($_REQUEST['new-review-subscription']) && $_REQUEST['new-review-subscription'] == 'on') ? true : 0,
        'cp_review' => (isset($_REQUEST['competent-person-review']) && $_REQUEST['competent-person-review'] == 'on') ? true : 0,
        'token' => $token,
        'status' => 0
    );
    $subscribe = $oInvitation->addSubscriber($data);

    if ($subscribe) {
        $response['subscribe'] = $subscribe;
        $response['email'] = $email;
        $response['token'] = $token;
        $response['success'] = true;
    } else {
        $response['error'] = $oInvitation->errors();
    }

    echo encode($response);
}

function subscribe_mail()
{

    require_once('../classes/invitation.class.php');
    $response = array('success' => false);

    $oInvitation = new invitation();
    $name = isset($_REQUEST['subscriber-name']) ? $_REQUEST['subscriber-name'] : '';
    $email = isset($_REQUEST['EMAIL']) ? $_REQUEST['EMAIL'] : '';
    $token = isset($_REQUEST['subscriber-token']) ? $_REQUEST['subscriber-token'] : '';
    $req = '/intel?action=unsubscribe';
    $base_url = "http://$_SERVER[HTTP_HOST]$req";
    $to = $email;
    //$subject = 'Subscription confirmation to RSC-MI';
    $subject = 'Subscription confirmation to RSC Resource Reporting Intelligence.';
    $message = '<html><body>Dear ' . $name . ', <br/><br/>';
    //$message .= 'Thank you for subscribing to RSC-MI.';
    $message .= 'Thank you for subscribing to RSC Resource Reporting Intelligence.<br/>';
    $message .= 'You will now receive a weekly summary of new published reports.<br/>';
    $message .= '<br><br>Kind regards,';
    $message .= '<br><br>The RSC Mineral Intelligence team';
    $message .= '<br><br><p style="color: #4a4a4a;font-size: 0.78em;">You are receiving this email because you subscribed at intel.rscmme.com. If you do not wish to receive any further emails from us you can unsubscribe <a href="' . $base_url . '&un=true&key=' . $token . '" target="_blank">here</a>. </p>';
    $message .= '</body></html>';
    $email = phpmail($to, $subject, $message);
    if ($email) {
        $oInvitation->emailRelease($token);
        // Admin Email
        subscribeEmailToAdmin();
    }

    $response['email'] = $email;
    $response['success'] = true;

    echo encode($response);
}

function subscribeEmailToAdmin()
{
    $name = isset($_REQUEST['subscriber-name']) ? $_REQUEST['subscriber-name'] : '';
    $email = isset($_REQUEST['EMAIL']) ? $_REQUEST['EMAIL'] : '';
    $subject = 'New user subscribed';
//    $message = '<html><body>'.$name.' would like to subscribe following options against '.$email.'.<br><br>';
    $message = '<html><body>' . $name . ' (' . $email . ') would like to subscribe to the following options:<br><br>';
    if (isset($_REQUEST['weekly-summary-report']) && $_REQUEST['weekly-summary-report'] == 'on')
        $message .= '<p>I would like to receive a weekly summary of new published technical reports.</p>';
    if (isset($_REQUEST['new-review-subscription']) && $_REQUEST['new-review-subscription'] == 'on')
        $message .= '<p>I would like to be notified whenever a new report review has been submitted.</p>';
    if (isset($_REQUEST['competent-person-review']) && $_REQUEST['competent-person-review'] == 'on')
        $message .= '<p>I would like to register as a competent person (CP) and would like to be notified whenever a published technical report (co-) written by me has been reviewed.</p>';
    $message .= '<br><br>Kind regards,';
    $message .= '<br><br>The RSC Mineral Intelligence team';
    $message .= '</body></html>';

    // Send Email
    $emails = (explode(",", SUBSCRIBE_EMAIL));
    foreach ($emails as $email) {
        phpmail($email, $subject, $message);
    }
}

function unsubscribe()

{
    require_once('../classes/invitation.class.php');
    $email = isset($_REQUEST['EMAIL']) ? $_REQUEST['EMAIL'] : '';
    if ($email) {
        $oInvitation = new invitation();
        $token = $oInvitation->getToken($email);
        //if (isset($_GET['key'])) {
        // $token = $_GET['key'];
        $oInvitation = new invitation();
        $oInvitation->unSubscribefromintel($email);
        $req = '?action=unsubscribe';
        $base_url = "http://$_SERVER[HTTP_HOST]$req";
        header('Location: ' . $base_url);
    } else {
        if (isset($_GET['key'])) {
            $token = $_GET['key'];
            $oInvitation = new invitation();
            $oInvitation->unSubscribe($token);
            $req = '?action=unsubscribe';
            $base_url = "http://$_SERVER[HTTP_HOST]$req";
            header('Location: ' . $base_url);
        }
    }


}

function updateConditionStatus()
{
    require_once('../classes/login.class.php');
    $oRSc = new Rsc();
    $response = array('success' => false);

    $condition = $oRSc->updateConditionStatus();
    if ($condition) {
        $response['success'] = true;
        $response['rsc_advises'] = $condition;
    } else {
        $response['errors'] = 'data not found!';
    }

    echo encode($response);
}


function complianceIssue()
{
    $response = array('success' => false);


    $report_id = isset($_REQUEST['report_id']) ? $_REQUEST['report_id'] : '';
    $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
    $company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';
    $project = isset($_REQUEST['project']) ? $_REQUEST['project'] : '';
    $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
    $cpqp = isset($_REQUEST['cpqp']) ? $_REQUEST['cpqp'] : '';
    $comments = isset($_REQUEST['comments']) ? $_REQUEST['comments'] : '';

    $emails = (explode(",", COMPLAINT_EMAIL));
    $subjectRsc = 'Compliance Issue';
    $messageRsc = '<html>';
    $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
    $messageRsc .= '<body>';

    $messageRsc .= '<label>Report ID : </label>' . $report_id . '<br>';
    $messageRsc .= '<label>Date : </label>' . $date . '<br>';
    $messageRsc .= '<label>Company : </label>' . $company . '<br>';
    $messageRsc .= '<label>Project : </label>' . $project . '<br>';
    $messageRsc .= '<label>Code : </label>' . $code . '<br>';
    $messageRsc .= '<label>Type : </label>' . $type . '<br>';
    $messageRsc .= '<label>CPQP : </label>' . $cpqp . '<br>';
    $messageRsc .= '<label>Comments : </label>' . $comments . '<br>';

    $messageRsc .= '</body></html>';

    $delivered = 0;
    $failed = 0;
    foreach ($emails as $emailRsc) {
        $email = phpmail($emailRsc, $subjectRsc, $messageRsc);
        if ($email) {
            $delivered++;
        } else {
            $failed++;
        }
    }
    $response['report_id'] = $report_id;
    $response['delivered'] = $delivered;
    $response['failed'] = $failed;
    $response['success'] = true;

    echo encode($response);

}

function SendFeedback()
{
    $response = array('success' => false);


    $message = isset($_REQUEST['review']) ? $_REQUEST['review'] : '';
    $From = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';

    $emails = (explode(",", COMPLAINT_EMAIL));
    $subjectRsc = 'Feedback Message';
    $messageRsc = '<html>';
    $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
    $messageRsc .= '<body>';
    $messageRsc .= '<label>From : </label>' . $From . '<br>';
    $messageRsc .= '<label>Email : </label>' . $email . '<br>';
    $messageRsc .= '<label>Message : </label>' . $message . '<br>';
    $messageRsc .= '</body></html>';

    $delivered = 0;
    $failed = 0;
    foreach ($emails as $emailRsc) {
        $email = phpmail($emailRsc, $subjectRsc, $messageRsc);
        if ($email) {
            $delivered++;
        } else {
            $failed++;
        }
    }
    $response['message'] = $message;
    $response['delivered'] = $delivered;
    $response['failed'] = $failed;
    $response['success'] = true;

    echo encode($response);

}


function requestforPDFdownloads()
{
    $response = array('success' => false);
    $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
    require_once($parse_uri[0] . 'wp-load.php');
    $user = wp_get_current_user();
    $user_email = $user->data->user_email;
    $phnnum = isset($_REQUEST['phnNum']) ? $_REQUEST['phnNum'] : '';
    $Name = isset($_REQUEST['user']) ? $_REQUEST['user'] : '';
    $Message = isset($_REQUEST['Message']) ? $_REQUEST['Message'] : '';

    $emails = (explode(",", COMPLAINT_EMAIL));
    $subjectRsc = 'Request for increased in PDF Download Limit';
    $messageRsc = '<html>';
    $messageRsc .= '<head><style type="text/css">label{width: 210px;}</style></head>';
    $messageRsc .= '<body>';
    $messageRsc .= '<label>Name : </label>' . $Name . '<br>';
    $messageRsc .= '<label>User Email : </label>' . $user_email . '<br>';
    $messageRsc .= '<label>Phone Num : </label>' . $phnnum . '<br>';
    $messageRsc .= '<label>Message : </label>' . $Message . '<br>';
    $messageRsc .= '</body></html>';

    $delivered = 0;
    $failed = 0;
    foreach ($emails as $emailRsc) {
        $email = phpmail($emailRsc, $subjectRsc, $messageRsc);
        if ($email) {
            $delivered++;
        } else {
            $failed++;
        }
    }
    $response['delivered'] = $delivered;
    $response['failed'] = $failed;
    $response['success'] = true;

    echo encode($response);

}
