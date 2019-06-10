<?php

class Signup{

    private $sequence_id;
    private $db;
    private $user_id;
    private $first_name;
    private $last_name;
    private $email;
    private $affiliation;
    private $position;
    private $biography;
    private $resume_name;
    private $company;
    private $city;
    private $country;
    private $experience;
    private $reporting_experience;
    private $reporting_code;
    private $stocks;
    private $anonymous;
    private $commodity;
    private $consultant;
    private $daily_updates;
    private $weekly_updates;
    private $invitation;
    private $below_average;
    private $new_review_updates;
    private $summery_report;
    private $new_review_frequency;
    private $invitation_frequency;
    private $summery_report_frequency;
    private $below_average_frequency;
    private $organisation_id;
    private $membership_no;
    private $org_member;
    private $org_fellow;
    private $org_cp;
    private $org_rpgeo;
    private $org_other;
    private $commodity_id;
    private $commodity_style;
    private $commodity_experience;
    private $reporting_id;
    private $rep_exchanges;
    private $org_membership;
    private $register_as;
    private $rsc_advises;
    private $my_report_review;

    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table = 'user';
        $this->sequence_id = 'user_id_seq';

    }

    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row)
    {
        $this->user_id     = (array_key_exists('user_id', $row)) ? $row ['user_id'] : null;
        $this->first_name  = (array_key_exists('first_name', $row)) ? $row ['first_name'] : null;
        $this->last_name   = (array_key_exists('last_name', $row)) ? $row ['last_name'] : null;
        $this->email       = (array_key_exists('email', $row)) ? $row ['email'] : null;
        $this->affiliation = (array_key_exists('affiliation', $row)) ? $row ['affiliation'] : null;
        $this->position    = (array_key_exists('position', $row)) ? $row ['position'] : null;
        $this->biography   = (array_key_exists('biography', $row)) ? $row ['biography'] : null;
        $this->company     = (array_key_exists('company', $row)) ? $row ['company'] : null;
        $this->city        = (array_key_exists('city', $row)) ? $row ['city'] : null;
        $this->country     = (array_key_exists('country', $row)) ? $row ['country'] : null;
        $this->experience  = (array_key_exists('experience', $row)) ? $row ['experience'] : null;
        $this->stocks      = (array_key_exists('stocks', $row)) ? $row ['stocks'] : null;
        $this->anonymous   = (array_key_exists('anonymous', $row)) ? $row ['anonymous'] : null;
        $this->commodity   = (array_key_exists('commodity', $row)) ? $row ['commodity'] : null;
        $this->consultant  = (array_key_exists('consultant', $row)) ? $row ['consultant'] : null;
        $this->reporting_experience = (array_key_exists('reporting_experience', $row)) ? $row ['reporting_experience'] : null;
        $this->reporting_code = (array_key_exists('reporting_code', $row)) ? $row ['reporting_code'] : null;
        $this->daily_updates = (array_key_exists('daily_updates', $row)) ? $row ['daily_updates'] : null;
        $this->weekly_updates = (array_key_exists('weekly_updates', $row)) ? $row ['weekly_updates'] : null;
        $this->invitation = (array_key_exists('invites_updates', $row)) ? $row ['invites_updates'] : null;
        $this->below_average = (array_key_exists('below_average', $row)) ? $row ['below_average'] : null;
        $this->new_review_updates = (array_key_exists('new_review_updates', $row)) ? $row ['new_review_updates'] : null;
        $this->summery_report = (array_key_exists('summery_report', $row)) ? $row ['summery_report'] : null;
        $this->new_review_frequency = (array_key_exists('new_review_frequency', $row)) ? $row ['new_review_frequency'] : null;
        $this->invitation_frequency = (array_key_exists('invitation_frequency', $row)) ? $row ['invitation_frequency'] : null;
        $this->summery_report_frequency = (array_key_exists('summery_report_frequency', $row)) ? $row ['summery_report_frequency'] : null;
        $this->below_average_frequency = (array_key_exists('below_average_frequency', $row)) ? $row ['below_average_frequency'] : null;
        $this->organisation_id = (array_key_exists('organisation_id', $row)) ? $row ['organisation_id'] : null;
        $this->membership_no = (array_key_exists('membership_no', $row)) ? $row ['membership_no'] : null;
        $this->org_membership = (array_key_exists('org_membership', $row)) ? $row ['org_membership'] : null;
        $this->org_member = (array_key_exists('org_member', $row)) ? $row ['org_member'] : null;
        $this->org_fellow = (array_key_exists('org_fellow', $row)) ? $row ['org_fellow'] : null;
        $this->org_cp = (array_key_exists('org_cp', $row)) ? $row ['org_cp'] : null;
        $this->org_rpgeo = (array_key_exists('org_rpgeo', $row)) ? $row ['org_rpgeo'] : null;
        $this->org_other = (array_key_exists('org_other', $row)) ? $row ['org_other'] : null;
        $this->commodity_id = (array_key_exists('commodity_id', $row)) ? $row ['commodity_id'] : null;
        $this->commodity_style = (array_key_exists('commodity_style', $row)) ? $row ['commodity_style'] : null;
        $this->commodity_experience = (array_key_exists('commodity_experience', $row)) ? $row ['commodity_experience'] : null;
        $this->reporting_id = (array_key_exists('reporting_id', $row)) ? $row ['reporting_id'] : null;
        $this->rep_exchanges = (array_key_exists('rep_exchanges', $row)) ? $row ['rep_exchanges'] : null;
        $this->register_as = (array_key_exists('register_as', $row)) ? $row ['register_as'] : null;
        $this->rsc_advises = (array_key_exists('rsc_advises', $row)) ? $row ['rsc_advises'] : false;
        $this->my_report_review = (array_key_exists('my_report_review', $row)) ? $row ['my_report_review'] : null;

        //$this->resume_name = (array_key_exists('resume_name', $row)) ? $row ['resume_name'] : null;
    }

    public function signupuser($data){
        session_start();
        $this->map($data);

        $resume = isset($_SESSION['rname']) ? $_SESSION['rname'] : null;
        $pname = isset($_SESSION['pname']) ? $_SESSION['pname'] : null;

        $query['query'] = 'INSERT INTO "user"(email, firstname, lastname,position, resume,company,city,country,anonymous,
                          consultant,biography, invitation, below_average,new_review_updates, summery_report,
                          invitation_frequency, below_average_frequency,new_review_frequency, summery_report_frequency,profilepicture,
                          my_report_review, register_as, rsc_advises)
                            VALUES (:email, :fname, :lname, :position, :resume,:company,:city,:country,
                                    :anonymous,:consultant,:biography,:invitation,:below_average,:new_review_updates,
                                    :summery_report,:invitation_frequency,:below_average_frequency,:new_review_frequency,
                                    :summery_report_frequency, :profilepicture, :my_report_review, :register_as, :rsc_advises)';
        $query['values'] = array(
            'email' => $this->email,
            'fname' => $this->first_name,
            'lname' => $this->last_name,
            'position' =>$this->position,
            'resume'=> $resume,
            'company' => $this->company,
            'city' => $this->city,
            'country' => $this->country,
            'anonymous' => $this->anonymous,
            'consultant' => $this->consultant,
            'biography'=> $this->biography,
            'profilepicture' => $pname,
            'invitation' => $this->invitation,
            'below_average' => $this->below_average,
            'new_review_updates' => $this->new_review_updates,
            'summery_report' => $this->summery_report,
            'invitation_frequency' => $this->invitation_frequency,
            'below_average_frequency' => $this->below_average_frequency,
            'new_review_frequency' => $this->new_review_frequency,
            'summery_report_frequency' => $this->summery_report_frequency,
            'my_report_review' => $this->my_report_review,
            'register_as' => $this->register_as,
            'rsc_advises' => $this->rsc_advises
        );
        $save = $this->db->cudRecord($query, $this->sequence_id);
        return $save;
    }
    
   public function checkuser($email){
       $query['query'] = 'select count(*) from "'.$this->table.'" where email=:email';
        $query['values'] = array('email' => $email);
        $result = $this->db->getArrayFromSelect($query);
        if($result[0]['count'] > 0){
            return false;
        }
        else{
            return true;
        }
   }


    public function addUserOrganization($data){
        $this->map($data);

        $user = isset($_SESSION['rname']) ? $_SESSION['rname'] : null;

        $query['query'] = 'INSERT INTO user_organisation(user_id,organisation_id, membership_no,membership,
                                member, fellow, cp, rpgeo, other, status)
                                VALUES (:user_id, :organisation_id, :membership_no, :membership,
                                :member, :fellow, :cp, :rpgeo, :other, :status)';
        $query['values'] = array(
            'user_id' =>  $_SESSION['userid'],
            'organisation_id' => $this->organisation_id,
            'membership_no' => $this->membership_no,
            'membership' => $this->org_membership,
            'member'=> $this->org_member,
            'fellow' => $this->org_fellow,
            'cp' => $this->org_cp,
            'rpgeo' => $this->org_rpgeo,
            'other' => $this->org_other,
            'status' => 0
        );

        return $this->db->insert($query);
    }

    public function updateUserOrganization(){

        $query['query'] = 'update user_organisation
                          SET status=:status
                          where user_id=:user_id';
        $query['values'] = array(
            'user_id' => $_SESSION['userid'],
            'status' => 2
        );

        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return true;
        }
        return false;
    }

    public function addUserCommodity($data){
        $this->map($data);
        $query['query'] = 'INSERT INTO user_commodity(user_id,commodity_id,style,experience,status)
                                VALUES (:user_id,:commodity_id,:commodity_style,:commodity_experience,:status)';
        $query['values'] = array(
            'user_id' =>  $this->user_id,
            'commodity_id' => $this->commodity_id,
            'commodity_style' => $this->commodity_style,
            'commodity_experience'=> $this->commodity_experience,
            'status' => 0
        );

        return $this->db->insert($query);
    }

    public function updateUserCommodity($user_id){

        $query['query'] = 'update user_commodity
                          SET status=:status
                          where user_id=:user_id';
        $query['values'] = array(
            'user_id' => $user_id,
            'status' => 2
        );

        return $this->db->update($query);
    }

    public function addUserReporting($data){
        $this->map($data);

        $query['query'] = 'INSERT INTO user_reporting(user_id,reporting_id,experience,exchanges,status)
                                VALUES (:user_id,:reporting_id,:experience,:exchanges,:status)';
        $query['values'] = array(
            'user_id' =>  $_SESSION['userid'],
            'reporting_id' => $this->reporting_id,
            'experience' => $this->reporting_experience,
            'exchanges'=> $this->rep_exchanges,
            'status' => 0
        );

        return $this->db->insert($query);
    }

    public function updateUserReporting($user_id){

        $query['query'] = 'update user_reporting
                          SET status=:status
                          where user_id=:user_id';
        $query['values'] = array(
            'user_id' => $user_id,
            'status' => 2
        );

        return $this->db->update($query);
    }

   public function savepicture($name){
       if(!isset($_SESSION)) session_start();
       $query['query'] = 'UPDATE "user"
                          SET profilepicture=:name, updated_at=now()
                          where username=:username';
       $query['values'] = array('username' => $_SESSION['username'], 'name' => $name);
       $result = $this->db->getArrayFromSelect($query);
       return true;
   }

    public function updateNotification($data){
        $this->map($data);

        $query['query'] = 'UPDATE "user"
                          SET invitation=:invitation, below_average=:below_average,
                          new_review_updates=:new_review_updates, summery_report=:summery_report,
                          invitation_frequency=:invitation_frequency, below_average_frequency=:below_average_frequency,
                          new_review_frequency=:new_review_frequency, summery_report_frequency=:summery_report_frequency, my_report_review = :my_report_review, updated_at=now()
                          where username=:username';
        $query['values'] = array('username' => $_SESSION['username'],
                    'invitation' => $this->invitation,
                    'below_average' => $this->below_average,
                    'new_review_updates' => $this->new_review_updates,
                    'summery_report' => $this->summery_report,
                    'invitation_frequency' => $this->invitation_frequency,
                    'below_average_frequency' => $this->below_average_frequency,
                    'new_review_frequency' => $this->new_review_frequency,
                    'summery_report_frequency' => $this->summery_report_frequency,
                    'my_report_review' => $this->my_report_review
        );
        $result = $this->db->getArrayFromSelect($query);
        return true;
    }
	
   public function updateprofile($fname,$lname,$biography){
       session_start();
       $query['query'] = 'UPDATE "user"
                          SET firstname=:fname, lastname=:lname, biography=:biography, updated_at=now()
                          where username=:username';
       $query['values'] = array('username' => $_SESSION['username'], 'fname' => $fname,'lname' => $lname,'biography' => $biography);
       $result = $this->db->getArrayFromSelect($query);
       $_SESSION['firstname']=$fname;
       $_SESSION['lastname']=$lname;
       $_SESSION['biography']=$biography;
       return true;
       
   }
   
   public function updatecontact($fname,$lname,$email,$affiliation,$position,$resume){
       session_start();
       $query['query'] = 'UPDATE "user"
                          SET firstname=:fname, lastname=:lname, email=:email,
                          "position"=:position, company=:affiliation, resume=:resume, updated_at=now()
                          where username=:username';
       $query['values'] = array('username' => $_SESSION['username'], 'fname' => $fname,'lname' => $lname,'email' => $email, 'position' => $position,'affiliation' => $affiliation, 'resume'=> $resume);
       $result = $this->db->getArrayFromSelect($query);
       $_SESSION['firstname']=$fname;
       $_SESSION['lastname']=$lname;
       $_SESSION['email']=$email;
       $_SESSION['affiliation']=$affiliation;
       $_SESSION['position']=$position;
       $_SESSION['resumename']=$resume;
       
       
       return true;
   }

    public function errors() {
        return $this->db->errors();
    }

    public function updateManageContact($data){
        if (!isset($_SESSION)) session_start();
        $this->map($data);

        $query['query'] = 'UPDATE "user"
                          SET firstname=:fname, lastname=:lname, email=:email,biography=:biography,"position"=:position,
                          company=:company, city=:city, country=:country, experience=:experience
                          ,reporting_experience=:reporting_experience, reporting_code=:reporting_code, stocks=:stocks,
                          anonymous=:anonymous, commodity=:commodity,consultant=:consultant,daily_updates=:daily_updates,
                          weekly_updates=:weekly_updates,invitation=:invites_updates,below_average=:below_average,new_review_updates=:new_review_updates, updated_at=now()
                          where username=:username';
        $query['values'] = array(
            'username'   => $_SESSION['username'],
            'fname'      => $this->first_name,
            'lname'      => $this->last_name,
            'email'      => $this->email,
            'position'   => $this->position,
            'biography'  => $this->biography,
            'company'    => $this->company,
            'city'       => $this->city,
            'country'    => $this->country,
            'experience' => $this->experience,
            'reporting_experience' => $this->reporting_experience,
            'reporting_code' => $this->reporting_code,
            'stocks'    => $this->stocks,
            'anonymous' => $this->anonymous,
            'commodity' => $this->commodity,
            'consultant'=> $this->consultant,
            'daily_updates' => $this->daily_updates,
            'weekly_updates' => $this->weekly_updates,
            'invites_updates' => $this->invitation,
            'below_average' => $this->below_average,
            'new_review_updates' => $this->new_review_updates
        );

        return $this->db->update($query);
    }
    
    public function updatePersonalDetails($data){
        if (!isset($_SESSION)) session_start();
        $this->map($data);

       $query['query'] = 'UPDATE "user"
                          SET firstname=:fname, lastname=:lname, company=:company, "position"=:position,
                          city=:city, country=:country, email=:email, biography=:biography, updated_at=now()
                          where username=:username';
       $query['values'] = array(
                        'username'   => $_SESSION['username'],
                        'fname'      => $this->first_name,
                        'lname'      => $this->last_name,
                        'company'    => $this->company,
                        'position'   => $this->position,
                        'city'       => $this->city,
                        'country'    => $this->country,
                        'email'      => $this->email,
                        'biography'  => $this->biography
                            );
        return $this->db->update($query);
   }
   
   public function updateresume($name){
       if (!isset($_SESSION)) session_start();

       $username = isset($_SESSION['username']) ? $_SESSION['username'] : '' ;
       $query['query'] = 'UPDATE "user"
                          SET  resume=:resume
                          where username=:username';
       $query['values'] = array('username' => $username, 'resume'=> $name);
       $result = $this->db->update($query);
      

       return true;
       
   }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * @param mixed $affiliation
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;
    }


    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * @return mixed
     */
    public function getResumeName()
    {
        return $this->resume_name;
    }

    /**
     * @param mixed $resume_name
     */
    public function setResumeName($resume_name)
    {
        $this->resume_name = $resume_name;
    }

    public function getCountries(){
        $query['query'] = 'SELECT countires FROM countries';
        $result = $this->db->getArrayFromSelect($query); 
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getCommodityType(){
        $query['query'] = 'SELECT id, name FROM commodity_type WHERE status = :status';
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getCommodityStyle(){
        $query['query'] = 'SELECT id, name,commodity_id FROM commodity_style WHERE status = :status';
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getCommodity(){
        $query['query'] = 'SELECT id, name, type_id FROM commodity WHERE status = :status';
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query); 
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getOrganisation(){
        $query['query'] = 'SELECT id,name FROM organisation WHERE status = :status';
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getReportingCode(){
        $query['query'] = 'SELECT id,code, code as name FROM reporting WHERE status = :status';
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getSubscribedUsers(){
        $query['query'] = 'SELECT "user".id AS user_id, firstname, lastname, email, level,invitation,below_average,new_review_updates,my_report_review from "user" where below_average = :below_average or new_review_updates = :new_review_updates or my_report_review = :my_report_review';
        $query['values'] = array('below_average' => true,'new_review_updates' => true,'my_report_review' => true);

        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getUnRegisteredSubscribedUsers(){
        $query['query'] = 'SELECT name, email, new_report, new_review, token FROM subscribe
                                WHERE (new_report = :new_report OR new_review = :new_review_updates) AND status = :status;';
        $query['values'] = array('new_report' => true,'new_review_updates' => true, 'status' => 0);

        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getInvitationSubscribedUsers(){
        $query['query'] = 'SELECT email, level,invitation,below_average,new_review_updates from "user" where invitation =:invitation';
        $query['values'] = array('invitation' => 'yes');

        $result = $this->db->getArrayFromSelect($query);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

}//end of class
