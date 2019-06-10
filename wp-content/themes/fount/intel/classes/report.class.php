<?php

/**
 * @author Arslan Javaid
 */
class Report
{
    private $filters = array();
    private $where;
    private $isFilter = false;
    private $ip;
    private $count = 0;
    private $statusDownload = true;

    function __construct()
    {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->db2 = new RscPDO(DSN2, DBUSER2, DBPASSWORD2, host);
        $this->pdo = new PDO('mysql:host=' . host . ';dbname=' . DSN2, DBUSER2, DBPASSWORD2);
        $this->table = 'report';
        $this->table_transaction = 'transaction_reports';
        $this->history_table = 'history';
        $this->idSeq = 'report_id_seq';
    }


    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row)
    {
        $this->report_id = (array_key_exists('report_id', $row)) ? $row['report_id'] : null;
    }

    public function UserSignUpValidation($Username, $UserEmail)
    {

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        global $wpdb;

        $owner = $wpdb->get_results("SELECT * From wp_users Where
            user_login ='" . $Username . "' OR user_email='" . $UserEmail . "' ");

        if ($owner) {
            $result = "old User";
        } else {
            $result = "New User";
        }
        return $result;
    }

    public function UserPdfViewsLimit($update_records, $ids)
    {

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        $transaction_reports_status = array();
        require_once($parse_uri[0] . 'wp-load.php');
        $transaction_reports_status['status'] = 'false';
        $user = wp_get_current_user();
        $id = $user->ID;
        $reportId = $_POST['reportId'];
        $date = date("Y-m-d");
        $query = $this->pdo->query('select  DISTINCT reportId from pdfDownloads where uid = (' . $id . ')');
        $reportIds = $query->fetchall();
        if (count($reportIds) > 0) {
            $userInfo['reportIDs'] = $reportIds;
        } else {
            $userInfo['reportIDs'] = array(0 => "0");
        }
        foreach ($reportIds as $rid) {
            if ($rid[0] == $reportId) {
                $this->statusDownload = false;
            }
        }
        if ($this->statusDownload == true) {
            $query = $this->pdo->query("INSERT INTO pdfDownloads (uid ,reportId,CurrDownloads,datee) VALUES ('$id','$reportId','','$date')");
            return $transaction_reports_status;
        } else {
            return $transaction_reports_status;
        }
    }

    public function getUserName($email)
    {
        $query = $this->pdo->query("Select ID from  wp_users  where user_email=('$email')");
        $name = $query->fetchall();
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $userName = get_user_meta($name[0][ID], 'first_name', TRUE);
        if( $userName==false && isset($name[0][ID])){
             $userName=$email;
        }
        return $userName;
    }

    public function resetpassword($pass, $email)
    {
        $reset = array();
        $query = $this->pdo->query("UPDATE wp_users SET user_pass =('$pass') where user_email=('$email')");

        if ($query->execute()) {
            $reset['status'] = 'true';
        } else {
            $reset['status'] = 'false';
        }
        return $reset;
    }

    function checkUserstatus($username, $password)
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $user = wp_get_current_user();
        $id = $user->ID;
        $userdata = get_user_by('login', $username);
        $result['status'] = wp_check_password($password, $userdata->user_pass, $userdata->ID);
        $query = $this->pdo->query("Select active from  wp_users  where user_login=('$username')");
        $active = $query->fetchall();
        $result['active']=$active[0]['active'];
        return $result;

    }

    function checkSubStatus($email)
    {
        $user_key['registered'] = "false";
        $isEmailexist=$this->IsEmailexist($email);
        if($isEmailexist==true){
            $user_key['registered'] = "true";
        }
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $list_id = '7a7174148c';
        $api_key = '92aea254d8bb04b62cd9eb7221f63f75-us5';

        //  check if user already subscribed then return the key
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                'Access-Control-Allow-Origin' => '*',
            ),
        );
        $email_formatted = md5(strtolower($email));
        $response = wp_remote_get('https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $email_formatted, $args);
        $body = json_decode(wp_remote_retrieve_body($response));
        $mailchimp_status = $body->status;
        if ($mailchimp_status == "subscribed") {
            $user_key['key'] = $body->unique_email_id;
            $user_key['fName'] = $body->merge_fields->FNAME;
            $user_key['lName'] = $body->merge_fields->LNAME;
//            $user_key['interests'] = $body->interests;
            $user_key['status'] = "subscribed";
        } else {
            $user_key['status'] = "notsubscribed";
        }

        return $user_key;
    }

    function activateReg($email)
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $list_id = '7a7174148c';
        $api_key = '92aea254d8bb04b62cd9eb7221f63f75-us5';

        //  check if user already subscribed then return the key
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                'Access-Control-Allow-Origin' => '*',
            ),
        );
        $email_formatted = md5(strtolower($email));
        $response = wp_remote_get('https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $email_formatted, $args);
        $body = json_decode(wp_remote_retrieve_body($response));
        $mailchimp_status = $body->status;
        if ($mailchimp_status == "subscribed") {
            $user_key['key'] = $body->unique_email_id;
            $user_key['status'] = "alreadySubscribed";
        }
        $query = $this->pdo->query("UPDATE wp_users SET active =TRUE where user_email=('$email')");
        if ($query->execute()) {
            $reset['status'] = 'true';
        } else {
            $reset['status'] = 'false';
        }
        return $user_key;
    }

    function unsubUser($email){
        $apiKey = "92aea254d8bb04b62cd9eb7221f63f75-us5";//your API key goes here
        $listId = "7a7174148c";// your trageted list ID

        $memberId = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
        $json = json_encode([
            'email_address' => $email,
            'status' => 'unsubscribed' // "subscribed","unsubscribed","cleaned","pending"
//            'interests' => [
//                'a920a88b86' => false,
//                '8500277a5b' => false,
//                '3cea326dc3' => false,
//            ]
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode;

    }
    function addUpdateSub($email, $fName, $lName)
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $list_id = '7a7174148c';
        $api_key = '92aea254d8bb04b62cd9eb7221f63f75-us5';

        //  check if user already subscribed then return the key
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                'Access-Control-Allow-Origin' => '*',
            ),
        );
        $email_formatted = md5(strtolower($email));
        $response = wp_remote_get('https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $email_formatted, $args);
        $body = json_decode(wp_remote_retrieve_body($response));
        $mailchimp_status = $body->title;
        if ($mailchimp_status !='Resource Not Found' ) {
            $user_key['key'] = $body->unique_email_id;
            $user_key['status'] = "alreadySubscribed";
            $user_key['sub_date'] = $body->timestamp_opt;
            $data = array(
                'apikey' => $api_key,
                'email_address' => $email,
                'status' => 'subscribed',
                'merge_fields' => array(
                    'FNAME' => $fName,
                    'LNAME' => $lName
                )
//                'interests' => array(
//                    'a920a88b86' => $interests[0] === 'true' ? true : false,
//                    '8500277a5b' => $interests[1] === 'true' ? true : false,
//                    '3cea326dc3' => $interests[2] === 'true' ? true : false,
//                )
            );
            $obj = new Report();
            $api_response_code = $obj->listSubscribe($data);
            return $user_key;
        } else {
            $auth = base64_encode('user:' . $api_key);
            $data = array(
                'apikey' => $api_key,
                'email_address' => $email,
                'status' => 'subscribed',
                'merge_fields' => array(
                    'FNAME' => $fName,
                    'LNAME' => $lName
                )
//                'interests' => array(
//                    'a920a88b86' => $interests[0] === 'true' ? true : false,
//                    '8500277a5b' => $interests[1] === 'true' ? true : false,
//                    '3cea326dc3' => $interests[2] === 'true' ? true : false,
//                )
            );
            $json_data = json_encode($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                'Authorization: Basic ' . $auth));
            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            $result = curl_exec($ch);

            //get the user manage preferences key
            $args = array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                    'Access-Control-Allow-Origin' => '*',
                ),
            );
            $email_formatted = md5(strtolower($email));
            $response = wp_remote_get('https://us5.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $email_formatted, $args);
            $body = json_decode(wp_remote_retrieve_body($response));
            $mailchimp_status = $body->status;
            $user_key['key'] = $body->unique_email_id;
            $user_key['status'] = "subscribed";
            $user_key['sub_date'] = $body->timestamp_opt;
            return $user_key;
        }
    }

    function listSubscribe(array $data)
    {
        $apiKey = "92aea254d8bb04b62cd9eb7221f63f75-us5";//your API key goes here
        $listId = "7a7174148c";// your trageted list ID

        $memberId = md5(strtolower($data['email_address']));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
        $json = json_encode([
            'email_address' => $data['email_address'],
            'status' => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
            'merge_fields' => [
                'FNAME' => $data['merge_fields']['FNAME'],
                'LNAME' => $data['merge_fields']['LNAME']
            ]
//            'interests' => [
//                'a920a88b86' => $data['interests']['a920a88b86'],
//                '8500277a5b' => $data['interests']['8500277a5b'],
//                '3cea326dc3' => $data['interests']['3cea326dc3'],
//            ]
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode;
    }

    function generatePass($password)
    {
        global $wp_hasher;
        require_once('../../../../../wp-includes/class-phpass.php');
        if (empty($wp_hasher)) {
            $wp_hasher = new PasswordHash(8, true);
        }

        return $wp_hasher->HashPassword(trim($password));
    }

//    public function getUserMembershipDetail()
//    {
//        //$wpdb->get_results("SELECT * FROM user_view_report WHERE user_id VALUES '$id'");
//        $wpdb->get_results("SELECT * FROM wp_users_levels_authority WHERE uid = '$id'");
//        //var_export($query);
//        //die();
//    }

    public function getUserplan(){
      $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
      require_once($parse_uri[0] . 'wp-load.php');
      $userInfo = array();
      if (is_user_logged_in()) {
          //get the user login image url to display to the intel page with dropdown to manage profile* Shahzaib
          $user = wp_get_current_user();
          // get user level id to detch sub plan from it
          $levels_str = get_user_meta($user->ID, 'ihc_user_levels', true);
          $level_id = explode(',', $levels_str);
          $level_data = ihc_get_level_by_id($levels_str);
          $userInfo['sub_plan'] = $level_data['label'];
        }
        else{
          $userInfo['sub_plan'] = 'null';
        }

        return $userInfo;
    }

    public function getUserData()
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $userInfo = array();
        if (is_user_logged_in()) {
            //get the user login image url to display to the intel page with dropdown to manage profile* Shahzaib
            $user = wp_get_current_user();
            // get user level id to detch sub plan from it
            $levels_str = get_user_meta($user->ID, 'ihc_user_levels', true);
            $level_id = explode(',', $levels_str);
            $level_data = ihc_get_level_by_id($levels_str);
            $userInfo['sub_plan'] = $level_data['label'];
            //get user image url and complete name
            $avatar = get_user_meta($user->ID, 'ihc_avatar', TRUE);
            $registered = $user->user_registered;
            $last_name = get_user_meta($user->ID, 'last_name', true);
            $userInfo['first_name'] = get_user_meta($user->ID, 'first_name', true);
            $userInfo['industry'] = get_user_meta($user->ID, 'ump_industry', true);
            $userInfo['job_title'] = get_user_meta($user->ID, 'ump_jobtitle', true);
            $userInfo['features'] = get_user_meta($user->ID, 'ump_features', true);
            $userInfo['phone'] = get_user_meta($user->ID, 'ump_phnNum', true);
            $userInfo['user_email'] = $user->data->user_email;

            $encoded_string = base64_encode($user->data->user_email . '&'. $user->ID . '&' . 'true');
            $userInfo['reset-pass-link'] = $encoded_string;

            $userInfo['comm'] = get_user_meta($user->ID, 'ump_commodities', true);
            $userInfo['user_registered'] = $user->data->user_registered;
            $userInfo['subscription'] = get_user_meta($user->ID, 'ump_sub', true);
            $userInfo['Company'] = get_user_meta($user->ID, 'ump_company', true);
            $avatar_data = wp_get_attachment_image_src($avatar, 'full');
            $uer = get_user_meta($user->ID);
            $d = strtotime("today");
            $start_week = strtotime("last sunday", $d);
            $end_week = strtotime("next saturday", $d);
            $start = date("Y-m-d", $start_week);
            $end = date("Y-m-d", $end_week);
            $today = date("Y-m-d");
            //insert user last and current visit date in DB
            $query = $this->pdo->query('select  last_visit,curr_visit  from user_visits where uid = (' . $user->ID . ')');
            $user_visits = $query->fetchall();
            if (count($user_visits) > 0) {
               // $userInfo['lastVisit'] = $user_visits[0]['curr_visit'];
                if($user_visits[0]['curr_visit']!=$today){
                    $lastVisit=$user_visits[0]['curr_visit'];
                    $query = $this->pdo->query("UPDATE user_visits SET last_visit =('$lastVisit'), curr_visit=('$today') where uid=('$user->ID')");
                    if($query->execute()){
                        $query = $this->pdo->query('select  last_visit,curr_visit  from user_visits where uid = (' . $user->ID . ')');
                        $user_visits = $query->fetchall();
                        $userInfo['lastVisit'] = $user_visits[0]['last_visit'];
                    }
                }
                else{
                    $query = $this->pdo->query('select  last_visit,curr_visit  from user_visits where uid = (' . $user->ID . ')');
                    $user_visits = $query->fetchall();
                    $userInfo['lastVisit'] = $user_visits[0]['last_visit'];
                }
            } else {
                $query = $this->pdo->query("INSERT INTO user_visits  (uid,last_visit,curr_visit) VALUES ('$user->ID','$today','$today')");
                $userInfo['lastVisit'] = $today;
            }
            //insert user last and current visit date in DB    *END
            $query = $this->pdo->query("select count(DISTINCT reportId) from pdfDownloads where uid = ('$user->ID ') and Date(datee) = '$today' group by Date(datee);");
            $data = $query->fetchall();
            if (count($data) > 0) {
                foreach ($data as $row) {
                    $userInfo['Dailydownloads'] = $row;
                }
            } else {
                $userInfo['Dailydownloads'] = array(0 => "0");
            }
            $query = $this->pdo->query('select COUNT(DISTINCT reportId) from pdfDownloads where uid = (' . $user->ID . ')');
            $data = $query->fetchall();
            if (count($data) > 0) {
                foreach ($data as $row) {
                    $userInfo['totalDownloads'] = $row;
                }
            } else {
                $userInfo['totalDownloads'] = array(0 => "0");
            }
            $query = $this->pdo->query("select COUNT(DISTINCT reportId) from pdfDownloads where uid = ('$user->ID') AND datee > '$start'");
            $data = $query->fetchall();
            if (count($data) > 0) {
                foreach ($data as $row) {
                    $userInfo['weeklyDownloads'] = $row;
                }
            } else {
                $userInfo['weeklyDownloads'] = array(0 => "0");
            }
            $query = $this->pdo->query('select  DISTINCT reportId from pdfDownloads where uid = (' . $user->ID . ')');
            $reportIds = $query->fetchall();
            if (count($reportIds) > 0) {
                $userInfo['reportIDs'] = $reportIds;
            } else {
                $userInfo['reportIDs'] = array(0 => "0");
            }
            if (!empty($avatar_data[0])) {
                $userInfo['avatar_url'] = $avatar_data[0];
            } else {
                $userInfo['avatar_url'] = 'https://www.w3schools.com/howto/img_avatar.png';
            }
            $userInfo['user_nicename'] = (isset($user->user_nicename) ? $user->user_nicename : "No Data");
            return $userInfo;
        } else {
            $userInfo['user_nicename'] = "UserLogout";
            return $userInfo;
        }
    }

    public function IsEmailexist($email){
        $query = $this->pdo->query("select * from wp_users  where user_email= '$email'");
        $data = $query->fetchall();
        $status=count($data);
        if($status!=0){
            return true;
        }
        else{
            return false;
        }
    }

    public function weekly_report($start_week, $end_week, $commodity)
    {
        $comm_array = array();
        $result = array();
        $reports_status = array();
        $reports_madien = array();
        $reports_drilling = array();
        $reports_label = array();
        $reports_dates = array();
        $date = date('Y-m-d', strtotime("-52 week"));
        $new_date = date("Y-m-d");
        foreach ($commodity as $item) {
            $comm_array = $item;
        }
        //convert array to string to perform query
        $commodities = join("','", $comm_array);
        if ($end_week == '') {
            $start_week = date("Y-m-d");
            $last_date = strtotime($start_week);
            $end_week = strtotime("2014-10-01");
            $last_date = date("Y-m-d", $last_date);
            $end_week = date("Y-m-d", $end_week);
            $x = 1;
            $m = 0;
            while ($end_week < $last_date) {
                $y = $m + 1;
                $previous_week = $end_week;

                $start_week = strtotime(date("Y-m-d", strtotime($previous_week)) . " $m week");
                $start_week = date("Y-m-d", $start_week);

                $end_week = strtotime(date("Y-m-d", strtotime($end_week)) . " $y week ");
                $end_week = date("Y-m-d", $end_week);

                $query['query'] = "SELECT count(status) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week'  AND commodities IN ('$commodities')
                                        ";
                $report_status = $this->db->getArrayFromSelect($query);
                array_push($reports_status, $report_status[0]['count']);

                $query['query'] = "SELECT count(status) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week' AND status = 'Maiden'  AND commodities IN ('$commodities')
                                        ";
                $report_madien = $this->db->getArrayFromSelect($query);
                array_push($reports_madien, $report_madien[0]['count']);

                $query['query'] = "SELECT count(type) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week' AND type = 'Exploration/Drilling Update'  AND commodities IN ('$commodities')
                                        ";
                $report_drilling = $this->db->getArrayFromSelect($query);
                array_push($reports_drilling, $report_drilling[0]['count']);
                $dateObj = $start_week;
                $week = date("W", strtotime($dateObj));
                array_push($reports_label, $week);
                $dateObj = date("d/m/y", strtotime($dateObj));
                array_push($reports_dates, $dateObj);
            }
        } else {
            $last_date = strtotime($start_week);
            $end_week = strtotime($end_week);
            $last_date = date("Y-m-d", $last_date);
            $end_week = date("Y-m-d", $end_week);
            $x = 1;
            $m = 0;
            while ($end_week < $last_date) {
                $y = $m + 1;
                $previous_week = $end_week;

                $start_week = strtotime(date("Y-m-d", strtotime($previous_week)) . " $m week");
                $start_week = date("Y-m-d", $start_week);

                $end_week = strtotime(date("Y-m-d", strtotime($end_week)) . " $y week ");
                $end_week = date("Y-m-d", $end_week);

                $query['query'] = "SELECT count(status) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week'  AND commodities IN ('$commodities')
                                        ";
                $report_status = $this->db->getArrayFromSelect($query);
                array_push($reports_status, $report_status[0]['count']);

                $query['query'] = "SELECT count(status) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week' AND status = 'Maiden'  AND commodities IN ('$commodities')
                                        ";
                $report_madien = $this->db->getArrayFromSelect($query);
                array_push($reports_madien, $report_madien[0]['count']);

                $query['query'] = "SELECT count(type) FROM report
                                        WHERE date >= '$start_week' AND date <= '$end_week' AND type = 'Exploration/Drilling Update'  AND commodities IN ('$commodities')
                                        ";
                $report_drilling = $this->db->getArrayFromSelect($query);
                array_push($reports_drilling, $report_drilling[0]['count']);
                $dateObj = $start_week;
                $week = date("W", strtotime($dateObj));
                array_push($reports_label, $week);
                $dateObj = date("d/m/y", strtotime($dateObj));
                array_push($reports_dates, $dateObj);
            }
        }
        $result['resources'] = $reports_status;
        $result['madien'] = $reports_madien;
        $result['drilling'] = $reports_drilling;
        $result['label'] = $reports_label;
        $result['dates'] = $reports_dates;
        return $result;
    }

    public function search_log_detail($actions)
    {

        //$dbname = "wpdev";
        $dates = join(',', $actions);
        $log_detail = array();
        $query = $this->pdo->query('SELECT * FROM log_activity WHERE date IN (' . $dates . ')');
        $data = $query->fetchall();
        foreach ($data as $row) {
            $log_detail[] = $row;
        }
        return $log_detail;
    }

    public function log_active($log, $actions,$mode,$report_id)
    {

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
            if($mode=='Technical Reports') {
                $reports = $this->getReportInfo($report_id, false);
                $detail = (isset($reports[0]['detail'])) ? $reports[0]['detail'] : NULL;
            }
            else {
                $reports = $this->getTransInfo($report_id);
                $detail = (isset($reports[0]['transaction_summary'])) ? $reports[0]['transaction_summary'] : NULL;
            }
            $company = (isset($reports[0]['company'])) ? $reports[0]['company'] : NULL;
            $commodities = (isset($reports[0]['commodities'])) ? $reports[0]['commodities'] : NULL;
            $cpqp = (isset($reports[0]['cpqp'])) ? $reports[0]['cpqp'] : NULL;
            $lat = (isset($reports[0]['latitude'])) ? $reports[0]['latitude'] : NULL;
            $lon = (isset($reports[0]['longitude'])) ? $reports[0]['longitude'] : NULL;
            $lat=trim(str_replace("'","\'",$lat));
            $lon=str_replace("'","\'",$lon);

        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $user_nicename = (isset($user->user_nicename) ? $user->user_nicename : "No Data");
        } else {
            $user_nicename = "Unknown";
        }
        require_once "login.class.php";
        $ip_obj = new Rsc();
        $this->ip = $ip_obj->getIpAddress();
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $this->ip);
        $country_name = $xml->geoplugin_countryName;
        $city_name = $xml->geoplugin_city;
        $location = $country_name;
        $date = date('Y-m-d H:i:s');

        $query = $this->pdo->query("INSERT INTO log_activity (date , user , ip , location,action,Action_Log,mode,report_id,Company,commodities,QC_CP,report_highlight,lat,lon) VALUES ('$date','$user_nicename','$this->ip','$location','$actions','$log','$mode','$report_id','$company','$commodities','$cpqp','$detail','$lat','$lon')");
        if ($query) {
                echo "New record created successfully";
        }
        else {
            echo "Error Performing Query";
        }
        return $query;
    }

    public function commodity_filter($data)
    {
        $commodities = $data;
        $commodities = implode(',', $commodities);
        $query['query'] = 'SELECT resource_qp,COUNT (resource_qp) as mycount
                  FROM
                  (SELECT resource_qp FROM resource_consultant where commodities IN (' . $commodities . ')) AS e
                  GROUP BY resource_qp ORDER BY mycount desc';
        return $this->db->getArrayFromSelect($query);

    }

    public function log_active_detail()
    {

        //$dbname = "wpdev";
        $log_detail = array();
        $query = $this->pdo->query('SELECT * FROM log_activity  ORDER BY id DESC limit 700');
        $data = $query->fetchall();
        foreach ($data as $row) {
            $log_detail[] = $row;
        }

        return $log_detail;
    }

    function deleteUser($email)
    {
        $query = $this->pdo->query("DELETE FROM wp_users where user_email=('$email')");
        $sql = $query->execute();
        if ($query->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error Performing Query";
        }
        return true;
    }

    function getreportXml(){
        $query['query'] = 'SELECT url_name,created_at from report ';
        return $this->db->getArrayFromSelect($query);
    }

    public function getAllTrans($data)
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $this->filters = $data;
        $this->where = "WHERE ";
        $this->where .= $this->getFilter('from-datee');
        $this->where .= $this->getFilter('to-datee');
        if ($this->filters['isProjectStage'] == 'true')
            $this->where .= $this->getFilter('project-stage');
        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se1');
        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se2');
        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se3');
        if ($this->filters['isTransectionType'] == 'true')
            $this->where .= $this->getFilter('transaction-type');
        if ($this->filters['isValueRange'] == 'true')
            $this->where .= $this->getFilter('value_range');
        if ($this->filters['islocationAccuracy'] == 'true')
            $this->where .= $this->getFilter('accuracy');
        if ($this->filters['isCommodity'] == 'true')
            $this->where .= $this->getFilter('commodity');

        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            // get user level id to detch sub plan from it
            $levels_str = get_user_meta($user->ID, 'ihc_user_levels', true);
            $level_id = explode(',', $levels_str);
            $level_data = ihc_get_level_by_id($levels_str);
            $plan=$level_data['label'];
            if($plan=='Plan1'){
                if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
                    $this->where === 'WHERE '
                )$this->where .= "commodities ILIKE '%GOLD%'";
                else if (($this->where != '') && ($this->where != 'WHERE ')) {
                    $this->where .= "AND commodities ILIKE '%GOLD%'";
                } else {
                    $this->where .= "commodities ILIKE '%GOLD%'";
                }

            }
            else {
                if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
                    $this->where === 'WHERE '
                )
                    $this->where = ""; //"WHERE  history = 'False'";
            }
        }

        $queryy['query'] = 'SELECT DISTINCT ON (latitude, longitude) id AS a, commodities  AS d, company AS j , region AS f, latitude AS g, longitude AS h,author_aff AS m,project AS l,type AS c,announcement_date AS n,project_stage AS b,accuracy AS e,value_range as range,ticker,se1 as stckexchange,se2 as stckExchange2,se3 as stckExchange3
                                FROM transaction_reports
                                ' . $this->where . '';

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        $transaction_reports_status = array();
        require_once($parse_uri[0] . 'wp-load.php');
        $transaction_reports_status['status'] = 'false';
        $user = wp_get_current_user();
        $id = $user->ID;
        $query = $this->pdo->query('select  DISTINCT reportId from pdfDownloads where uid = (' . $id . ')');
        $reportIds = $query->fetchall();
        if (count($reportIds) > 0) {
            $trans['reportIDs'] = $reportIds;
        } else {
            $trans['reportIDs'] = array(0 => "0");
        }
        $trans['trans'] = $this->db->getArrayFromSelect($queryy);
        return $trans;

    }

    private function getFilter($key)
    {

        $filter = '';
        if (!isset($this->filters[$key]) || empty($this->filters[$key]) || $this->filters[$key] == null) {
            return $filter;
        }


        switch ($key) {
            case "from-date":
                $filter = ($this->where === 'WHERE ') ? "date::date >='" . $this->filters[$key] . "'" : " AND date::date >= '" . $this->filters[$key] . "'";
                $this->isFilter = true;
                break;
            case "to-date":
                $filter = ($this->where === 'WHERE ') ? "date::date <= '" . $this->filters[$key] . "'" : " AND date::date <= '" . $this->filters[$key] . "'";
                $this->isFilter = true;
                break;
            case "from-datee":
                $filter = ($this->where === 'WHERE ') ? "announcement_date::date >='" . $this->filters[$key] . "'" : " AND announcement_date::date >= '" . $this->filters[$key] . "'";
                $this->isFilter = true;
                break;
            case "to-datee":
                $filter = ($this->where === 'WHERE ') ? "announcement_date::date <= '" . $this->filters[$key] . "'" : " AND announcement_date::date <= '" . $this->filters[$key] . "'";
                $this->isFilter = true;
                break;
            case "codes":
                $filter = $this->getFilterConditions($key, 'code');
                break;
            case "report-type":
                $filter = $this->getFilterConditions($key, 'type');
                break;
            case "se1":
                $filter = $this->getFilterConditions($key, 'se1');
                break;
            case "se2":
                $filter = $this->getFilterConditions($key, 'se2');
                break;
            case "se3":
                $filter = $this->getFilterConditions($key, 'se3');
                break;
            case "resources":
                $filter = $this->getFilterConditions($key, 'status');
                break;
            case "resources-reserves":
                $filter = $this->getFilterConditions($key, 'reserve_status');
                break;
            case "value_range":
                $filter = $this->getFilterConditions($key, 'value_range');
                break;
            case "accuracy":
                $filter = $this->getFilterConditions($key, 'accuracy');
                break;
            case "commodity":
                $filter = $this->getFilterConditions($key, 'commodities');
                break;
            case "rep_format":
                $filter = $this->getFilterConditions($key, 'format');
                break;
            case "proj_status":
                $filter = $this->getFilterConditions($key, 'prj_status');
                break;
            case "project-stage":
                $filter = $this->getFilterConditions($key, 'project_stage');
                break;
            case "transaction-type":
                $filter = $this->getFilterConditions($key, 'type');
                break;
            case "region":
                $filter = $this->getFilterConditions($key, 'region');
                break;
            case "case":
                echo "Your Case";
                break;
            default:
                $filter = '';
        }

        return $filter;
    }

    private function getFilterConditions($key, $col)
    {
        $conditions = '';
        $orFilter = $this->isFilter;
        $isQuery = ($this->where === 'WHERE ' || $orFilter) ? false : true;
        foreach ($this->filters[$key] as $k => $item) {
            if (!$isQuery)
            {
                $isQuery = true;
                $orFilter = false;
                if($item == 'Other')
                {
                            $conditions .= $col . " ILIKE '%Quartz%' OR " . $col . " ILIKE '%Potassium%' OR " . $col . " ILIKE '%Halloysite%' OR " . $col . " ILIKE '%Kaolinite%' OR "
                                . $col . " ILIKE '%Halite%' OR " . $col . " ILIKE '%Aggregate%' OR " . $col . " ILIKE '%Alumina%' OR " . $col . " ILIKE '%Barite%' OR "
                                . $col . " ILIKE '%n/a%' OR " . $col . " ILIKE '%Boron%' OR " . $col . " ILIKE '%Magnesite%' OR " . $col . " ILIKE '%Limestone%' OR "
                                . $col . " ILIKE '%Rutile%' OR " . $col . " ILIKE '%Ilmenite%' OR " . $col . " ILIKE '%Clay%' OR " . $col . " ILIKE '%Platnium%' OR "
                                . $col . " ILIKE '%Palladium%' OR " . $col . " ILIKE '%Ruthenium%' OR " . $col . " ILIKE '%Rhodium%' OR " . $col . " ILIKE '%Osmium%' OR "
                                . $col . " ILIKE '%Iridium%' OR " . $col . " ILIKE '%Corundum%' OR " . $col . " ILIKE '%Heavy Metals%' OR " . $col . " ILIKE '%Gypsum%' OR "
                                . $col . " ILIKE '%Gallium%' OR " . $col . " ILIKE '%Germanium%' OR " . $col . " ILIKE '%Chromite%' OR " . $col . " ILIKE '%Frac Sand%' OR "
                                . $col . " ILIKE '%Scandium%' OR " . $col . " ILIKE '%Chromium%' OR " . $col . " ILIKE '%Kieserite%' OR " . $col . " ILIKE '%Wollastonite%' OR "
                                . $col . " ILIKE '%Sapphire%' OR " . $col . " ILIKE '%Sand%' OR " . $col . " ILIKE '%Magnesium%' OR " . $col . " ILIKE '%Silica%' OR "
                                . $col . " ILIKE '%Caesium%' OR " . $col . " ILIKE '%Magnetite%' OR " . $col . " ILIKE '%Zeolite%' OR " . $col . " ILIKE '%Sylvite%' OR "
                                . $col . " ILIKE '%Flurospar%' OR " . $col . " ILIKE '%Polyhalite%' OR " . $col . " ILIKE '%Cesium%' OR " . $col . " ILIKE '%Rubidium%' OR "
                                . $col . " ILIKE '%Heavy Mineral%' OR " . $col . " ILIKE '%Kaolin%' OR " . $col . " ILIKE '%Rock Salt%' OR " . $col . " ILIKE '%Ruby%' OR "
                                . $col . " ILIKE '%Phosphorite%' OR " . $col . " ILIKE '%Pozzolan%' OR " . $col . " ILIKE '%Perlite%' OR " . $col . " ILIKE '%Feldspar%' OR "
                                . $col . " ILIKE '%Antimony%' OR " . $col . " ILIKE '%Emerald%' OR " . $col . " ILIKE '%Apatite%' OR " . $col . " ILIKE '%Vermiculite%' OR "
                                . $col . " ILIKE '%Manganese%' OR " . $col . " ILIKE '%Bauxite%' OR " . $col . " ILIKE '%Flourite%' OR " . $col . " ILIKE '%Fluorspar%' OR "
                                . $col . " ILIKE '%Potassium chloride%'";
                            //$conditions .= $col . " NOT ILIKE ALL (Array['%Gold%','%Aluminium%','%Diamonds%','%Silver%','%Cobalt%','%Graphite%','%PGM%','%Iron%','%Phosphate%','%Lithium%','%Potash%','%Molybdenum%','%Zircon%','%Niobium%','%Rare earth%','%Copper%','%Tantalum%','%Coal%','%Lead%','%Tin%','%Nickel%','%Titanium%','%Zinc%','%Tungsten%','%Uranium%','%Vanadium%'])";
                }
                else if($item == 'other')
                {
                              $conditions .= $col . " <> 'NI43-101' AND " . $col . " <> 'JORC' AND " . $col . " <> '(Enviro)'";
                }
                else if ($item == 'Feasibility Study' || $item == 'Pre-Feasibility Study')
                {
                    $conditions .= $col . " = '" . $item . "'";
                }
                else
                {
                             $conditions .= $col . " ILIKE '%" . $item . "%'";
                }
            } else
            {
                if($item == 'Other')
                {
                    //$conditions .= "OR " .$col . " NOT ILIKE ALL (Array['%Gold%','%Aluminium%','%Diamonds%','%Silver%','%Cobalt%','%Graphite%','%PGM%','%Iron%','%Phosphate%','%Lithium%','%Potash%','%Molybdenum%','%Zircon%','%Niobium%','%Rare earth%','%Copper%','%Tantalum%','%Coal%','%Lead%','%Tin%','%Nickel%','%Titanium%','%Zinc%','%Tungsten%','%Uranium%','%Vanadium%'])";
                    $conditions .= "OR " .$col . " ILIKE '%Quartz%' OR " . $col . " ILIKE '%Potassium%' OR " . $col . " ILIKE '%Halloysite%' OR " . $col . " ILIKE '%Kaolinite%' OR "
                        . $col . " ILIKE '%Halite%' OR " . $col . " ILIKE '%Aggregate%' OR " . $col . " ILIKE '%Alumina%' OR " . $col . " ILIKE '%Barite%' OR "
                        . $col . " ILIKE '%n/a%' OR " . $col . " ILIKE '%Boron%' OR " . $col . " ILIKE '%Magnesite%' OR " . $col . " ILIKE '%Limestone%' OR "
                        . $col . " ILIKE '%Rutile%' OR " . $col . " ILIKE '%Ilmenite%' OR " . $col . " ILIKE '%Clay%' OR " . $col . " ILIKE '%Platnium%' OR "
                        . $col . " ILIKE '%Palladium%' OR " . $col . " ILIKE '%Ruthenium%' OR " . $col . " ILIKE '%Rhodium%' OR " . $col . " ILIKE '%Osmium%' OR "
                        . $col . " ILIKE '%Iridium%' OR " . $col . " ILIKE '%Corundum%' OR " . $col . " ILIKE '%Heavy Metals%' OR " . $col . " ILIKE '%Gypsum%' OR "
                        . $col . " ILIKE '%Gallium%' OR " . $col . " ILIKE '%Germanium%' OR " . $col . " ILIKE '%Chromite%' OR " . $col . " ILIKE '%Frac Sand%' OR "
                        . $col . " ILIKE '%Scandium%' OR " . $col . " ILIKE '%Chromium%' OR " . $col . " ILIKE '%Kieserite%' OR " . $col . " ILIKE '%Wollastonite%' OR "
                        . $col . " ILIKE '%Sapphire%' OR " . $col . " ILIKE '%Sand%' OR " . $col . " ILIKE '%Magnesium%' OR " . $col . " ILIKE '%Silica%' OR "
                        . $col . " ILIKE '%Caesium%' OR " . $col . " ILIKE '%Magnetite%' OR " . $col . " ILIKE '%Zeolite%' OR " . $col . " ILIKE '%Sylvite%' OR "
                        . $col . " ILIKE '%Flurospar%' OR " . $col . " ILIKE '%Polyhalite%' OR " . $col . " ILIKE '%Cesium%' OR " . $col . " ILIKE '%Rubidium%' OR "
                        . $col . " ILIKE '%Heavy Mineral%' OR " . $col . " ILIKE '%Kaolin%' OR " . $col . " ILIKE '%Rock Salt%' OR " . $col . " ILIKE '%Ruby%' OR "
                        . $col . " ILIKE '%Phosphorite%' OR " . $col . " ILIKE '%Pozzolan%' OR " . $col . " ILIKE '%Perlite%' OR " . $col . " ILIKE '%Feldspar%' OR "
                        . $col . " ILIKE '%Antimony%' OR " . $col . " ILIKE '%Emerald%' OR " . $col . " ILIKE '%Apatite%' OR " . $col . " ILIKE '%Vermiculite%' OR "
                        . $col . " ILIKE '%Manganese%' OR " . $col . " ILIKE '%Bauxite%' OR " . $col . " ILIKE '%Flourite%' OR " . $col . " ILIKE '%Fluorspar%' OR "
                        . $col . " ILIKE '%Potassium chloride%'";
                }
                else if ($item == 'other')
                {
                    $conditions .= " OR " . $col . " <> 'NI43-101' AND " . $col . " <> 'JORC' AND " . $col . " <> '(Enviro)'";
                } elseif ($item == 'PEA')
                {
                    $conditions .= " OR " . $col . " ILIKE '%" . $item . "%' OR " . $col . " ILIKE '%Scoping Study%'";
                } elseif ($item == 'Not Defined')
                {
                    $conditions .= " OR " . $col . " ILIKE '%" . $item . "%' OR " . $col . " IS NULL ";
                }
                else if ($item == 'Feasibility Study' || $item == 'Pre-Feasibility Study')
                {
                    $conditions .= " OR " .  $col . " = '" . $item . "'";
                }
                else
                    $conditions .= " OR " . $col . " ILIKE '%" . $item . "%'";
            }
        }
        if ($key == 'se1' || $key == 'se2' || $key == 'se3') {
            if($key=='se1'){
                $conditions = ($this->isFilter) ? ' AND ( ' . $conditions . '' : '(' . $conditions . '';
            }
            else if($key=='se2'){
                $conditions = ($this->isFilter) ? ' OR  ' . $conditions . '' : ' ' . $conditions . '';
            }
            else if($key=='se3'){
                $conditions = ($this->isFilter) ? ' OR  ' . $conditions . ')' : ' ' . $conditions . ')';
            }
            $this->isFilter = true;
        } else if (count($this->filters[$key]) > 0) {
            $conditions = ($this->isFilter) ? ' AND ( ' . $conditions . ' )' : '( ' . $conditions . ' )';
            $this->isFilter = true;
        }

        return $conditions;
    }

    public function getWeeklyReports()
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        $query['query'] = 'select * from weekly_bulletin_reports ORDER BY date DESC;';
        return $this->db->getArrayFromSelect($query);
    }

    public function getAll($data)
    {

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');


        $this->filters = $data;
        $this->where = "WHERE ";
        $searchFilter = isset($data['searchFilter']) ? $_REQUEST['searchFilter'] : NULL;
        $search = $data['searchValue'];
        $search = str_replace('.', '', $search);
        $isCommodityFilterActivated = true;

        $this->where .= $this->getFilter('from-date');
        $this->where .= $this->getFilter('to-date');
        if ($this->filters['format'] == "true") {
            $this->where .= $this->getFilter('rep_format');
        }
        if ($this->filters['project_status'] == 'true') {
            $this->where .= $this->getFilter('proj_status');
        }

        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se1');
        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se2');
        if ($this->filters['isStockExchange'] == 'true')
            $this->where .= $this->getFilter('se3');
        if ($this->filters['isReportCode'] == 'true')
            $this->where .= $this->getFilter('codes');
        if ($this->filters['isReportType'] == 'true')
            $this->where .= $this->getFilter('report-type');
        if ($this->filters['isResourcesType'] == 'true')
            $this->where .= $this->getFilter('resources');
        if ($this->filters['isReservesType'] == 'true')
            $this->where .= $this->getFilter('resources-reserves');
        if (($this->filters['isCommodity'] == 'true') && (is_user_logged_in()) && ($searchFilter != 'Commodity: ' )) {
            $this->where .= $this->getFilter('commodity');

        }
        else if (($data['commodity'] != null) && (is_user_logged_in()) && ($searchFilter == 'Commodity: ' )) {
            if($search != '')
                array_push($this->filters['commodity'],$search);
            $this->where .= $this->getFilter('commodity');
                //$this->where .=" AND commodities ilike '%$search%'";
        }

        else {
            $isCommodityFilterActivated = false;
        }

        if (count($this->filters['region']) > 0)
            if ($this->filters['region'])
                $this->where .= $this->getFilter('region');
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            // get user level id to detch sub plan from it
            $levels_str = get_user_meta($user->ID, 'ihc_user_levels', true);
            $level_id = explode(',', $levels_str);
            $level_data = ihc_get_level_by_id($levels_str);
            $plan=$level_data['label'];
            if($plan=='Plan1'){
                if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
                    $this->where === 'WHERE '
                )$this->where .= "commodities ILIKE '%GOLD%'";
                else if (($this->where != '') && ($this->where != 'WHERE ')) {
                    $this->where .= "AND commodities ILIKE '%GOLD%'";
                } else {
                    $this->where .= "commodities ILIKE '%GOLD%'";
                }
            }
            else {
                if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
                    $this->where === 'WHERE '
                )
                    $this->where = ""; //"WHERE  history = 'False'";
            }
        } else {
            if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
                $this->where === 'WHERE '
            )$this->where .= "commodities ILIKE '%GOLD%'";
            else if (($this->where != '') && ($this->where != 'WHERE ')) {
                $this->where .= " AND commodities ILIKE '%GOLD%'";
            } else {
                $this->where .= "commodities ILIKE '%GOLD%'";
            }
        }
        if ($this->filters['pdf_url']){
           $pdf_url = $this->filters['pdf_url'];
            if (($this->where != '') && ($this->where != 'WHERE ')) {
                $this->where .= " OR url_name = '$pdf_url'";
            }
          }

          if($searchFilter != NULL) {

              switch ($searchFilter) {
                  case "Company: ":
                  if (($this->where != '') && ($this->where != 'WHERE ')) {
                      $this->where .=" AND company ilike '%$search%'";
                  } else {
                      $this->where = 'WHERE ';
                      $this->where .= "company ilike '%$search%'";
                  }
                      break;
                  case "Ticker: ":
                      if (($this->where != '') && ($this->where != 'WHERE ')) {
                          $this->where .=" AND ticker ilike '%$search%'";
                      } else {
                          $this->where = 'WHERE ';
                          $this->where .= "ticker ilike '%$search%'";
                      }
                      break;
                  case "Project: ":
                      if (($this->where != '') && ($this->where != 'WHERE ')) {
                          $this->where .=" AND project ilike '%$search%'";
                      } else {
                          $this->where = 'WHERE ';
                          $this->where .= "project ilike '%$search%'";
                      }
                      break;
                  case "Commodity: ":
                      if($isCommodityFilterActivated == false && $search != '') {
                          if (($this->where != '') && ($this->where != 'WHERE ')) {
                              $this->where .=" AND commodities ilike '%$search%'";
                          } else {
                              $this->where = 'WHERE ';
                              $this->where .= "commodities ilike '%$search%'";
                          }
                      }
                     break;
                  default:
                      //
              }
          }
        // else
        //     $this->where .= " AND  history = 'False'";

        $query['query'] = 'SELECT DISTINCT ON (g, h) a,b,g,h,z,history FROM (SELECT DISTINCT ON (latitude, longitude, history) id AS a, history, code AS b,latitude AS g,longitude AS h,prj_status AS z,ticker,se1 as stckexchange,se2 as stckExchange2,se3 as stckExchange3,ticker
               FROM report
               ' . $this->where . ') AS dataset';

        return $this->db->getArrayFromSelect($query);
    }

    /**
     * Search Report
     * @param string $term
     * @return Object
     */
    public function search($term,$data,$searchentire)
    {
        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');

        $this->filters = $data;
        $this->where = "WHERE ";
//        $this->where .= $this->getFilter('from-date');
//        $this->where .= $this->getFilter('to-date');
//        if ($this->filters['format'] == "true") {
//            $this->where .= $this->getFilter('rep_format');
//        }
//        if ($this->filters['project_status'] == 'true') {
//            $this->where .= $this->getFilter('proj_status');
//        }
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se1');
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se2');
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se3');
//        if ($this->filters['isReportCode'] == 'true')
//            $this->where .= $this->getFilter('codes');
//        if ($this->filters['isReportType'] == 'true')
//            $this->where .= $this->getFilter('report-type');
//        if ($this->filters['isResourcesType'] == 'true')
//            $this->where .= $this->getFilter('resources');
//        if ($this->filters['isReservesType'] == 'true')
//            $this->where .= $this->getFilter('resources-reserves');
//        if (($this->filters['isCommodity'] == 'true') && is_user_logged_in())
//            $this->where .= $this->getFilter('commodity');
//        if (count($this->filters['region']) > 0)
//            if ($this->filters['region'])
//                $this->where .= $this->getFilter('region');
        if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') ||
            $this->where === 'WHERE '
        )
            $this->where = "WHERE ";
        else
            $this->where .= " AND ";
        if($data['option_selected'] == 'ticker'){
          $term = ':'.$term;
        }
        $this->where .= $data['option_selected']." ilike('%" . $term . "%')";
//        if ($this->filters['isAdvancesearch'] == 'true') {
//            if ($this->filters['search-ticker'] == 'true')
//                $this->where .= " OR ticker ilike ('%" . $term . "%') ";
////            if ($this->filters['search-author'] == 'true')
////                $this->where .= "OR author_aff ilike ('%" . $term . "%') ";
//            if ($this->filters['search-other-commodity'] == 'true' && is_user_logged_in())
//                $this->where .= " OR commodities ilike ('%Silver%') ";
//        }
        if($searchentire=='true')
            $this->where= "WHERE (commodities ilike('%" . $term . "%') OR ticker ilike ('%" . $term . "%') OR company ilike('%" . $term . "%') OR deposit ilike('%" . $term . "%')
                                              OR project ilike('%" . $term . "%') OR cpqp ilike('%" . $term . "%'))";

//        if (!is_user_logged_in() && $this->filters['search-other-commodity'] == 'true')
//            $this->where.=" AND ((commodities ilike '%Gold%') OR (commodities ilike '%Silver%'))";
         if (!is_user_logged_in()){
            $this->where.=" AND ((commodities ilike '%Gold%'))";
        }

            $query['query'] = " SELECT id AS a, code AS b, type AS c, commodities AS d, status AS e, region AS f, latitude AS g,
                                longitude AS h, history AS i, company AS j, deposit AS k, project AS l, cpqp AS m, to_char(date, :date_format) AS n,reserve_status AS o,ticker as tic, prj_status as z
                                from report rpt inner join
                                (
                                  select k,l,m, max(n) max_date from
                                        (SELECT DISTINCT ON (latitude, longitude, history,date) id AS a, code AS b, type AS c, commodities AS d, status AS e, region AS f, latitude AS g,
                                        longitude AS h, history AS i, company AS j, deposit AS k, project AS l, cpqp AS m, date AS n,reserve_status AS o,ticker as tic
                                        FROM report $this->where ) as t
                                group by k,l,m) as grouped
                                on rpt.deposit = grouped.k and rpt.project = grouped.l and rpt.cpqp = grouped.m and rpt.date = grouped.max_date
                                order by rpt.date DESC";

        $query['values'] = array('date_format' => 'Mon DD, YYYY');
//       var_export($query);
//        die();

        return $this->db->getArrayFromSelect($query);
    }

    /**
     * Search Report
     * @param string $term
     * @return Object
     */
    public function transactionSearch($term,$data,$searchentire)
    {

        $this->filters = $data;
        $this->where = "WHERE ";
//        $this->where .= $this->getFilter('from-datee');
//        $this->where .= $this->getFilter('to-datee');
//        if ($this->filters['isProjectStage'] == 'true')
//            $this->where .= $this->getFilter('project-stage');
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se1');
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se2');
//        if ($this->filters['isStockExchange'] == 'true')
//            $this->where .= $this->getFilter('se3');
//        if ($this->filters['isTransectionType'] == 'true')
//            $this->where .= $this->getFilter('transaction-type');
//        if ($this->filters['isValueRange'] == 'true')
//            $this->where .= $this->getFilter('value_range');
//        if ($this->filters['islocationAccuracy'] == 'true')
//            $this->where .= $this->getFilter('accuracy');
//        if ($this->filters['isCommodity'] == 'true')
//            $this->where .= $this->getFilter('commodity');
        if (($data['show-all'] == 'Show/hide all markers' && $data['isMobileDevice'] == 'false') || $this->where === 'WHERE '){
            $this->where = "WHERE ";
        }
        else
            $this->where .= " AND ";

        $this->where .= $data['option_selected']." ilike('%" . $term . "%')";
        //$this->where .= " company ilike('%" . $term . "%') OR project ilike('%" . $term . "%')";
//        if ($this->filters['isAdvancesearch'] == 'true') {
//            if ($this->filters['search-ticker'] == 'true')
//                $this->where .= " OR ticker ilike ('%" . $term . "%') ";
//            if ($this->filters['search-author'] == 'true')
//                $this->where .= "OR author_aff ilike ('%" . $term . "%') ";
//            if ($this->filters['search-other-commodity'] == 'true')
//                $this->where .= " OR commodities ilike ('%Silver%') ";
//        }

        if($searchentire=='true')
            $this->where= " WHERE (commodities ilike('%" . $term . "%') OR company ilike ('%" . $term . "%') OR project ilike('%" . $term . "%') OR author_aff ilike('%" . $term . "%')
                                              OR se1 ilike('%" . $term . "%') OR se2 ilike('%" . $term . "%') OR se3  ilike('%" . $term . "%') OR ticker ilike('%" . $term . "%'))";
        $query['query'] = "SELECT id as A, commodities as d, latitude as g, longitude as h, company as j, project as l, author_aff as m, to_char(announcement_date, :date_format) as n,value_range as o,project_stage as p,type as t,se1 as se1,se2 as se2,se3 as se3,accuracy as acc,ticker as tic
                                FROM transaction_reports
                                 $this->where
                                ORDER BY d ASC";
        $query['values'] = array('date_format' => 'Mon DD, YYYY');
//        var_export($query);
//        die();
        return $this->db->getArrayFromSelect($query);
    }


    public function getTransactionReport()
    {

        $query['query'] = 'SELECT id, commodities, company , region, latitude, longitude,author_aff,project,type,announcement_date,project_stage,accuracy,ticker
                                FROM transaction_reports
                                WHERE history = :history';
        $query['values'] = array('history' => 'False');
        return $this->db->getArrayFromSelect($query);
    }

    public function getReportMetaDetail($name)
    {
        $query['query'] = "SELECT id, meta_tags,meta_desc,company,project,type,to_char(date, :date_format) as date FROM report
                                WHERE url_name ilike('" . $name . "')
                                UNION
                                SELECT id as id, meta_tags,meta_desc,company,project,type,to_char(announcement_date, :date_format) as date FROM transaction_reports
                                WHERE url_name ilike('" . $name . "')";
        $query['values'] = array('date_format' => 'Mon DD, YYYY');

        return $this->db->getArrayFromSelect($query);
    }

    public function getTransInfo($report_id)
    {
        $query['query'] = "SELECT id,value_range, commodities, company , accuracy,ticker, region, latitude, longitude,author_aff,project,type,transaction_summary,project_stage,affiliation,url_name,pdf_link,to_char(announcement_date, :date_format) as date,type,resources_reserves,class_level
                                FROM transaction_reports
                                WHERE id='" . $report_id . "'";
        $query['values'] = array('date_format' => 'Mon DD, YYYY');
        return $this->db->getArrayFromSelect($query);
    }

    public function getReportInfo($filter, $url)
    {
        session_start();
        $userId = (isset($_SESSION['userid']) && $_SESSION['userid'] != '') ? $_SESSION['userid'] : NULL;

        $report_filter = ($url) ? "report.url_name ilike('" . $filter . "')" : 'report.id = :filter';

        $query['query'] = 'select to_char(date, :date_format) as date, date as date1, id, assessment, cpqp, code,
                            commodities, company, deposit, detail, download, format, history, latitude, longitude,
                            location, project, region, resources, status, type, object_id, pdf_link, report_sum, url_name,ticker,
                             (
                             SELECT COUNT(*) FROM review
                             LEFT JOIN "user" ON "user".id = review.user_id
                             WHERE review.report_id = report.id AND review.status = 0 AND "user".level <> :exp_level
                             ) as total,
                             (
                            select DISTINCT ON(review.report_id) review.id from review
                                    LEFT JOIN "user"
                                    on "user"."id" = review.user_id
                                    where review.status in (0,1) and review.report_id = report.id and review.user_id = :userId
                            ) as review_submitted,
                            (SELECT
                            CASE WHEN count(report_id) > 0
                            THEN SUM(total_score) / count(report_id)
                            ELSE 0 END AS score
                            FROM review
                            LEFT JOIN "user" ON "user".id = review.user_id
                            WHERE report_id = report.id AND review.status = 0  AND "user".level <> :exp_level) AS total_score
                                from report
                                WHERE ' . $report_filter . '

                                ORDER BY report.id ASC';

        $query['values'] = array('date_format' => 'Mon DD, YYYY', 'exp_level' => 'Junior Reviewer', 'userId' => $userId);
        if (!$url) {
            $query['values']['filter'] = $filter;
        }

        return $this->db->getArrayFromSelect($query);
    }

//    public function getReportInfo($filter,$url) {
//        session_start();
//        $userId = (isset($_SESSION['userid']) && $_SESSION['userid'] != '') ? $_SESSION['userid'] : NULL;
//
//        $report_filter = ($url) ? "transaction_reports.url_name ilike('".$filter."')" : 'report.id = :filter';
//
//        $query['query'] = "(select to_char(date, :date_format) as date, date as date1, id, assessment, cpqp, code,
//                            commodities, company, deposit, detail, download, format, history, latitude, longitude,
//                            location, project, region, resources, status, type, object_id, pdf_link, report_sum, url_name
//                                from report
//                                WHERE report.url_name ilike('".$filter."')
//                                ORDER BY report.id ASC)
//                                UNION
//                                (select to_char(announcement_date, :date_format) as date, announcement_date as date1, id_pk as id, '' as assessment, cpqp,'' as code,
//                            commodities, company,'' as deposit,transaction_summary as detail, '' as download, '' as format, history, cast(latitude as character varying), cast(longitude as character varying),'' as location,
//                            project, region,'' as resources,status, type,'' as object_id, pdf_link,'' as report_sum, url_name
//                                from transaction_reports
//                                WHERE transaction_reports.url_name ilike('".$filter."')
//                                ORDER BY transaction_reports.id)";
//
//        $query['values'] = array('date_format' => 'Mon DD, YYYY');
//        if(!$url){
//            $query['values']['filter'] = $filter;
//        }
//
//        return $this->db->getArrayFromSelect($query);
////    }

    public function getTransReportLinkInfo($filter, $url)
    {
        $userId = (isset($_SESSION['userid']) && $_SESSION['userid'] != '') ? $_SESSION['userid'] : NULL;

        $report_filter = ($url) ? "transaction_reports.url_name ilike('" . $filter . "')" : 'report.id = :filter';

        $query['query'] = "select to_char(announcement_date, :date_format) as date, announcement_date as date1, id2 as id, '' as assessment, author_aff,'' as code,
                            commodities, company,'' as deposit,transaction_summary as detail, '' as download, '' as format, history, cast(latitude as character varying), cast(longitude as character varying),location,project, region,'' as resources,accuracy, type,'' as object_id, pdf_link,'' as report_sum, url_name, project_stage,accuracy,ticker,abstract
                                from transaction_reports
                                WHERE transaction_reports.url_name ilike('" . $filter . "')
                                ORDER BY transaction_reports.id";

        $query['values'] = array('date_format' => 'Mon DD, YYYY');
        if (!$url) {
            $query['values']['filter'] = $filter;
        }

        return $this->db->getArrayFromSelect($query);
    }

    /**
     * Load All Question
     * @return object
     */
    public function getAllQuestion()
    {
        $query['query'] = "SELECT question.id,question.name,question.review_info_id, section_id, section.name AS section_name
                            FROM question
                            INNER JOIN section ON section.id = question.section_id WHERE question.status = :status;";
        $query['values'] = array('status' => 0);

        return $this->db->getArrayFromSelect($query);
    }

    public function getHistory($latitude, $longitude, $current_report)
    {
        session_start();
        $userId = (isset($_SESSION['userid'])) ? $_SESSION['userid'] : null;

        $delimeters = array("'", '"');
        $lat = str_replace($delimeters, "", $latitude);
        $lon = str_replace($delimeters, "", $longitude);

        $query['query'] = 'select rpt.id AS report_id,
                (SELECT COUNT(*) FROM review
                 LEFT JOIN "user" ON "user".id = review.user_id
                 WHERE review.report_id = rpt.id AND review.status = 0 AND "user".level <> :exp_level
                 ) as total,
                (SELECT
                CASE WHEN count(report_id) > 0
                THEN SUM(total_score) / count(report_id)
                ELSE 0 END AS score
                FROM review
                LEFT JOIN "user" ON "user".id = review.user_id
                WHERE report_id = rpt.id AND review.status = 0  AND "user".level <> :exp_level) AS total_score,
                          rpt.*, to_char(date, :date_format) as date_format,
                          (SELECT review.id FROM review
                              WHERE review.user_id= :user_id and review.report_id=rpt.id and review.status  in (0,1)
                          ) as review_submitted
                           from report as rpt LEFT JOIN review as rv on rv.report_id = rpt.id';
        $query['query'] .= " where replace(replace(latitude, '" . '"' . "', ''), '''', '')='$lat' and replace(replace(longitude, '" . '"' . "', ''), '''', '')='$lon'";
        if (!$current_report)
            $query['query'] .= " and rpt.history = 'True'";
        $query['query'] .= " Group By rpt.id ORDER BY rpt.id";

        $query['values'] = array('exp_level' => 'Junior Reviewer', 'date_format' => 'Mon DD, YYYY', 'user_id' => $userId);
//        print_r($query);
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {

            return $result;
        }

        return false;

    }

    public function getTransHistory($latitude, $longitude)
    {
        $query['query'] = "select rpt.id AS report_id,
                          rpt.*, to_char(announcement_date, :date_format) as date_format,transaction_summary as detail,project as deposit
                           from transaction_reports as rpt
                           where latitude= '" . $latitude . "' and
                           longitude= '" . $longitude . "' and
                           rpt.history = 'True'
                           ORDER BY rpt.id2";

        $query['values'] = array('date_format' => 'Mon DD, YYYY');
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {

            return $result;
        }

        return false;

    }


    public function errors()
    {
        return $this->db->errors();
    }

    public function getReportDetails($reportId)
    {
        //$reportId=744;
        $query['query'] = 'select company,project,cpqp,type,code, to_char(date, :date_format) as date,download,
                            (SELECT COUNT(*) FROM review
                                 LEFT JOIN "user" ON "user".id = review.user_id
                                 WHERE review.report_id = report.id AND review.status = 0 AND "user".level <> :exp_level
                                 ) as total,
                            (SELECT
                                    CASE WHEN count(report_id) > 0
                                    THEN SUM(total_score) / count(report_id)
                                    ELSE 0 END AS score
                                    FROM review
                                    LEFT JOIN "user" ON "user".id = review.user_id
                                    WHERE report_id = report.id AND review.status = 0  AND "user".level <> :exp_level) AS total_score
                            from report where id=:reportId';
        $query['values'] = array('date_format' => 'Mon DD, YYYY', 'exp_level' => 'Junior Reviewer', 'reportId' => $reportId);
        $result = $this->db->getArrayFromSelect($query);
        if ($result) {
            return $result;
        }

        return false;
    }

    public function getUserDetailComplaint($userId)
    {
        //$userId=1;
        $query['query'] = 'select email,firstname,lastname,company from "user" where id=:userId';
        $query['values'] = array('userId' => $userId);
        $result = $this->db->getArrayFromSelect($query);
        if ($result) {
            return $result;
        }

        return false;
    }

    public function getReportUserDetails($reportId)
    {
        //$reportId=744;
        $query['query'] = 'SELECT "user".username,"user".anonymous,review.status,review.reviewer_identity, "user".profilepicture, "user"."level"
                            FROM review
                            INNER JOIN "user" ON "user".id = review.user_id
                            WHERE report_id = :reportId AND review.status = 0;';
        $query['values'] = array('reportId' => $reportId);
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function getReportUserReviewsDetail($reportId)
    {
        //$reportId=744;
        $query['query'] = 'SELECT u.email, r.status AS review_status, u.username,u.anonymous,r.reviewer_identity, u.profilepicture,r.id, r.total_score,
                                        u.company, u."position",u.reporting_code,u.commodity,u.country, u.stocks, u.experience,
                                        u.reporting_experience, u.level, u.biography, r.user_id, r.report_id, u.consultant, r.notes
                            FROM review AS r
                            INNER JOIN "user" AS u ON u.id = r.user_id
                            WHERE report_id = :reportId AND (r.status = 0 OR r.status = 3);';

        $query['values'] = array('reportId' => $reportId);
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function getAnonymousReportUserReviewsDetail($reportId)
    {
        $query['query'] = 'SELECT u.email, r.status AS review_status,
                            CASE WHEN u.anonymous =  :anonymous OR reviewer_identity = :anonymous THEN :anonymous_username
                            ELSE u.username END AS username,
                            CASE WHEN u.anonymous =  :anonymous OR reviewer_identity = :anonymous THEN :anonymous_picture
                            ELSE u.profilepicture END AS profilepicture,
                            CASE WHEN u.anonymous =  :anonymous OR reviewer_identity = :anonymous THEN :anonymous_biography
                            ELSE u.biography END AS biography,
                            CASE WHEN u.anonymous =  :anonymous OR reviewer_identity = :anonymous THEN
                             CASE WHEN u.experience >= 5 THEN u.experience / 5 * 5 ELSE u.experience END
                            ELSE u.experience END AS experience,
                            u.anonymous,r.reviewer_identity,r.id, r.total_score,
                                        u.company, u."position",u.reporting_code,u.commodity,u.country, u.stocks,
                                        u.reporting_experience, u.level, r.user_id, r.report_id, u.consultant, r.notes
                            FROM review AS r
                            INNER JOIN "user" AS u ON u.id = r.user_id
                            WHERE report_id = :reportId AND (r.status = 0 OR r.status = 3);';

        $query['values'] = array(
            'anonymous' => 'yes',
            'anonymous_username' => 'Anonymous',
            'anonymous_picture' => 'RP-temp.png',
            'anonymous_biography' => '',
            'reportId' => $reportId
        );
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function getAnonymousReportUserDetails($reportId)
    {
        $query['query'] = 'SELECT
                            CASE WHEN "user".anonymous =  :anonymous OR reviewer_identity = :anonymous THEN :anonymous_username
                            ELSE "user".username END AS username,
                            CASE WHEN "user".anonymous =  :anonymous OR reviewer_identity = :anonymous THEN :anonymous_picture
                            ELSE "user".profilepicture END AS profilepicture,
                            "user".anonymous,review.status,review.reviewer_identity, "user"."level"
                            FROM review
                            INNER JOIN "user" ON "user".id = review.user_id
                            WHERE report_id = :reportId AND review.status = 0;';
        $query['values'] = array(
            'anonymous' => 'yes',
            'anonymous_username' => 'Anonymous',
            'anonymous_picture' => 'RP-temp.png',
            'reportId' => $reportId
        );
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }


    public function getReportUserReviewsRating($reportId, $userId)
    {
        $query['query'] = 'SELECT section.name,section_rating.score
                            FROM section_rating
                            INNER JOIN review ON review.id = section_rating.review_id
                            INNER JOIN section ON section.id = section_rating.section_id
                            WHERE report_id = :reportId AND user_id = :userId AND (review.status = 0 OR review.status = 3);';

        $query['values'] = array('reportId' => $reportId, 'userId' => $userId);
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function getOverallRatting($userId, $report_id)
    {
        $query['query'] = 'SELECT id,total_score
                            FROM review
                            WHERE report_id = :reportId AND user_id = :userId AND review.status = 0;';

        $query['values'] = array('reportId' => $report_id, 'userId' => $userId);
        $result = $this->db->getArrayFromSelect($query);

        if ($result) {
            return $result;
        }

        return false;
    }

}
