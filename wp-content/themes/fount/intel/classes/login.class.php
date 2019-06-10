<?php

class Rsc{
    
    private $db;
    private $user_id;
    private $session_id;
    private $ip;

    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table = 'user';
    }

    public function loginUser($username, $password){
        $query['query'] = 'select * from "'.$this->table.'" where username ilike(:username) and password=:password limit 1';
        $query['values'] = array('username' => $username, 'password' => $password);
        $result = $this->db->getArrayFromSelect($query); 
        if($result){

            // Set user_id
            $this->user_id = $result[0]['id'];

            if (!isset($_SESSION)) session_start();
            $_SESSION['login']="loggedIn";
            $_SESSION['userid']=$result[0]['id'];
            $_SESSION['username']=$result[0]['username'];
            $_SESSION['firstname']=$result[0]['firstname'];
            $_SESSION['lastname']=$result[0]['lastname'];
            $_SESSION['email']=$result[0]['email'];
            $_SESSION['position']=$result[0]['position'];
            $_SESSION['biography']=$result[0]['biography'];
            $_SESSION['pname']=$result[0]['profilepicture'];
            $_SESSION['resumename']=$result[0]['resume'];
            $_SESSION['level']=$result[0]['user_type'];
            $_SESSION['user_level']=$result[0]['level'];
            $_SESSION['anonymous']=$result[0]['anonymous'];
            $_SESSION['rsc_advises']=$result[0]['rsc_advises'];


            $saved_reviews = $this->getCompletedReview();
            $_SESSION['countsavedreview']=  count($saved_reviews);


            $submitted_reviews = $this->getSubmittedReview();
            $_SESSION['submittedReviews']=  count($submitted_reviews);
            $total=count($saved_reviews)+count($submitted_reviews);
            $_SESSION['countreview']=  $total;

            return true;    
        }
        return false;
    }

    public function addSession() {
        $table = "session";
        $sequence = "session_id_seq";
        $this->ip = $this->getIpAddress();

        $query['query'] = "INSERT INTO $table ( ip, user_id, logged_in, status) VALUES(:ip, :user_id, :logged_in, :status);";
        $query['values'] = array('ip' => $this->ip,'user_id' => $this->user_id,'logged_in' => 'now()', 'status' => 0);
        $this->session_id =  $this->db->cudRecord($query, $sequence);

        if (!isset($_SESSION)) session_start();
        $_SESSION['session_id']= $this->session_id;

        return ! ($this->session_id === false);
    }

    public function getIpAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function logOut(){
        $table = "session";
        $query['query'] = "update $table set logged_out=now() where id=:session_id";
        $query['values'] = array('session_id' => $this->session_id);
        $logout = $this->db->update($query);
        if($logout){
            return true ;
        }
        return false;
    }

    public function updateConditionStatus(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = 'update "'.$this->table.'" set rsc_advises=true where id=:user_id';
        $query['values'] = array('user_id' => $_SESSION['userid']);
        if($this->db->update($query)){
            return true ;
        }
        return false;
    }

    public function getCompletedReview(){
        $query['query'] = "SELECT review.id,to_char(review.created_at, 'Mon DD, YYYY') as created_at, review.total_score, report.type, report.company, report.project FROM review,report
                            WHERE review.report_id = report.id and review.status=0 and review.user_id=:userid";
        $query['values'] = array('userid' => $_SESSION['userid']);
        return $this->db->getArrayFromSelect($query);
    }

    public function getSubmittedReview(){
        $query['query'] = "SELECT review.id,to_char(review.created_at, 'Mon DD, YYYY') as created_at, review.total_score, report.type, report.company, report.project FROM review,report
                            WHERE review.report_id = report.id and review.status=1 and review.user_id=:userid";
        $query['values'] = array('userid' => $_SESSION['userid']);
        return $this->db->getArrayFromSelect($query);
    }

    public function email($email){
       
       $query['query'] = 'select * from"'. $this->table.'" where email=:email';
         $query['values'] = array('email' => $email);
       $result = $this->db->getArrayFromSelect($query); 
        if($result){
            /*if (!isset($_SESSION)) session_start();
            $_SESSION['email']=$result[0]['email'];
            $_SESSION['password']=$result[0]['password'];
            $_SESSION['firstname']=$result[0]['firstname'];
            $_SESSION['lastname']=$result[0]['lastname'];
            $_SESSION['username']=$result[0]['username'];*/
            return $result;
        }
        return false;
    }

    public function getDetailByEmail($email){
        $query['query'] = 'select firstname,lastname from"'. $this->table.'" where email=:email';
        $query['values'] = array('email' => $email);
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        return false;
    }


    public function getProfileDetail(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = "SELECT regexp_replace(u.biography, E'[\\n\\r]+', '<br/>', 'g' ) as biography , u.id, u.username, u.email, u.firstname, u.lastname, u.position, u.profilepicture, u.resume, u.city, u.country, u.company,
                u.experience, u.reporting_experience, u.consultant, u.anonymous, regexp_replace(u.commodity, E'[\\n\\r]+', '<br/>', 'g' ) as commodity_view ,u.commodity,  u.reporting_code, u.stocks, u.level, u.daily_updates,
                u.weekly_updates, u.invitation, u.below_average, u.new_review_updates, u.new_review_frequency, u.invitation_frequency, u.summery_report_frequency, u.summery_report, u.below_average_frequency, u.my_report_review, u.register_as,
                to_char(u.created_at, 'YYYY-MM-DD') as created_at, rsc_advises
                FROM ".'"'.$this->table.'" as u
                WHERE u.id = :user_id';
        $query['values'] = array('user_id' => $_SESSION['userid']);

       // print_r($query);
       // die;
        $result = $this->db->getArrayFromSelect($query);
        
        if($result)
        {
            return $result;
        }

        return false;
    }

    public function getUserOrganizations(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = "SELECT uo.organisation_id, uo.membership_no, uo.membership,
                uo.member, uo.fellow, uo.cp, uo.rpgeo, uo.other, uo.status, o.name as org_name
                FROM  user_organisation as uo
                INNER JOIN organisation as o
                on uo.organisation_id = o.id
                WHERE uo.user_id = :user_id and uo.status = :status";
        $query['values'] = array('user_id' => $_SESSION['userid'], 'status' => 0);
        $result = $this->db->getArrayFromSelect($query);

        if($result)
        {
            return $result;
        }
        return false;
    }

    public function getUserReportingExperience(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = "SELECT ur.experience, ur.exchanges, r.code  from user_reporting as ur
                    INNER JOIN reporting as r
                    on r.id = ur.reporting_id
                    WHERE ur.user_id = :user_id and ur.status = :status";
        $query['values'] = array('user_id' => $_SESSION['userid'], 'status' => 0);
        $result = $this->db->getArrayFromSelect($query);

        if($result)
        {
            return $result;
        }
        return false;
    }

    public function getUserCommodityExperience(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = "SELECT uc.commodity_id, uc.style, uc.experience, c.name, c.type_id, ct.name as type from user_commodity as uc
                    INNER JOIN commodity as c
                    on c.id = uc.commodity_id
                    INNER JOIN commodity_type as ct
                    on ct.id = c.type_id
                    WHERE uc.user_id = :user_id and uc.status = :status
                    ORDER BY c.type_id ASC";
        $query['values'] = array('user_id' => $_SESSION['userid'], 'status' => 0);
        $result = $this->db->getArrayFromSelect($query);

        if($result)
        {
            return $result;
        }
        return false;
    }

    public function getReviewerDetail(){
        if (!isset($_SESSION)) session_start();
        $query['query'] = "SELECT username, email, firstname, lastname, company FROM ".'"'.$this->table.'"  WHERE id = :user_id';
        $query['values'] = array('user_id' => $_SESSION['userid']);
        $result = $this->db->getArrayFromSelect($query);

        if($result)
        {
            return $result;
        }

        return false;
    }

    public function getAllCommodity(){
        $query['query'] = "select id,name,type_id FROM commodity WHERE status = :status;";
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }

    public function errors() {
        return $this->db->errors();
    }
    
    public function getUser(){
        $commodity_select = "commodity.name || '(' || user_commodity.style || ') ' || get_experience(CAST (experience AS INTEGER)) || '<br>'";
        $reporting_code_select = "reporting.code || ' ' || get_experience(CAST (experience AS INTEGER))  || ' reporting to the ' || user_reporting.exchanges || ' exchanges' || '<br>'";
        $query['query'] = 'select firstname,lastname,biography,profilepicture,anonymous, level,
                            reporting_experience, experience,
                            (select array(select '.$commodity_select.' from commodity INNER JOIN user_commodity ON commodity.id = user_commodity.commodity_id WHERE "user".id = user_commodity.user_id))as commodity,
                            stocks,
                            (select array(select '.$reporting_code_select.' from reporting INNER JOIN user_reporting ON reporting.id = user_reporting.reporting_id  WHERE "user".id = user_reporting.user_id))as reporting_code,
                            company, position, consultant, country  from "'.$this->table.'" where status = :status';
        $query['values'] = array(
            'status' => 0
    );
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }


	
}//end of class
