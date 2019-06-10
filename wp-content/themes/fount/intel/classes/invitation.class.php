<?php


class invitation {
    private $db;
    private $table;
    private $name;
    private $email;
    private $new_report;
    private $new_review;
    private $status;
    private $token;
    private $cp_review;
    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table='user';
    }

    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row) {
        $this->name        = (array_key_exists ( 'name', $row )) ? $row ['name'] : '';
        $this->email       = (array_key_exists ( 'email', $row )) ? $row ['email'] : '';
        $this->new_report  = (array_key_exists ( 'new_report', $row )) ? $row ['new_report'] : 0;
        $this->new_review  = (array_key_exists ( 'new_review', $row )) ? $row ['new_review'] : 0;
        $this->status      = (array_key_exists ( 'status', $row )) ? $row ['status'] : 0;
        $this->token       = (array_key_exists ( 'token', $row )) ? $row ['token'] : '';
        $this->cp_review       = (array_key_exists ( 'cp_review', $row )) ? $row ['cp_review'] : 0;
    }
    
    public function getUsername(){
        $query['query'] = 'SELECT firstname,lastname,username
                           FROM "user"
                           Where invitation=:status and anonymous=:anonymous';
        $query['values'] = array( 'status' => 'yes','anonymous' => 'no');
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function getUserEmail($user){
        $query['query'] = 'SELECT DISTINCT(email)
                           FROM "user"
                           Where username=:username';
        $query['values'] = array( 'username' => $user);
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function allUserEmail(){
        $query['query'] = 'SELECT DISTINCT(email)
                           FROM "user"
                           Where invitation=:status';
        $query['values'] = array( 'status' => 'yes');
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function allUserCode($code){
        $query['query'] = 'SELECT DISTINCT(email)
                           FROM "user"
                           INNER JOIN user_reporting ON "user".id = user_reporting.user_id
                           Where invitation=:status and reporting_id = :code';
        $query['values'] = array( 'status' => 'yes','code' => $code);
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function allUserMarketing($stocks){
        $strStock = '%'.$stocks.'%';
        $query['query'] = 'SELECT DISTINCT(email)
                           FROM "user"
                            INNER JOIN user_reporting ON "user".id = user_reporting.user_id
                            Where invitation=:status and exchanges ilike :stocks;';
        $query['values'] = array( 'status' => 'yes','stocks' => $strStock);
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function allUserCommodity($commodity){
        $query['query'] = 'SELECT DISTINCT(email)
                            FROM "user"
                            INNER JOIN user_commodity ON user_commodity.user_id = "user".id
                          Where commodity_id = :commodity';
        $query['values'] = array('commodity' => $commodity);
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }
    
    public function saveInvite($userId,$reportId,$email,$reviewId,$reviewerNote){
        $query['query'] = 'INSERT INTO invite_reviewer(
                           user_id, report_id, invite_email,review_id,reviewer_note)
                            VALUES (:userId,:reportId,:email,:reviewId,:reviewerNote)';
        $query['values'] = array( 'userId' => $userId,'reportId' => $reportId,'email' => $email,'reviewId' => $reviewId,'reviewerNote' =>$reviewerNote);
        $save = $this->db->insert($query);
        return $save;
    }


    public function getInvitationDetail(){
        $query['query'] = 'SELECT ir.id as invite_reviewer_id,ir.user_id,u.level,report_id,invite_email,reviewer_note,to_char(r.date, :date_format) as date, r.company, r.project, r.cpqp, r.type, r.code
                            FROM invite_reviewer ir
                            INNER JOIN report r ON ir.report_id = r.id
                            INNER JOIN "user" u ON ir.user_id = u.id
                            WHERE email_release is FALSE;';
        $query['values'] = array('date_format' => 'Mon DD, YYYY');
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }

    public function updateEmailReleaseStatus($invite_reviewer_id){
        $query['query'] = 'UPDATE invite_reviewer SET email_release = TRUE where id=:invite_reviewer_id';
        $query['values'] = array('invite_reviewer_id' => $invite_reviewer_id);
        $update = $this->db->update($query);
        if($update){
            return true ;
        }
        return false;
    }

    public function addSubscriber($data){
        $this->map($data);
        $query['query'] = 'SELECT * FROM subscribe WHERE email = \'' . $data['email'] . '\' and status=0';
       // $query['query'] = 'SELECT * FROM subscribe WHERE email =ali@gmail.com';
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return false;
        }
        $query['query'] = 'SELECT * FROM subscribe WHERE email = \'' . $data['email'] . '\'';
        // $query['query'] = 'SELECT * FROM subscribe WHERE email =ali@gmail.com';
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            $query['query'] = 'update subscribe set status=0 where email=\''.$data['email']. '\'';
            $update = $this->db->update($query);
            if($update){
                return true ;
            }
            return false;
        }
        
        $query['query'] = 'INSERT INTO subscribe ( name, email, new_report, new_review, status, token, cp_review)
                                  VALUES(:name, :email, :new_report, :new_review, :status, :token, :cp_review);';
        $query['values'] = array(
            'name' => $this->name,
            'email' => $this->email,
            'new_report' => $this->new_report,
            'new_review' => $this->new_review,
            'status' => $this->status,
            'token' => $this->token,
            'cp_review' => $this->cp_review
        );
        $update = $this->db->insert($query);
        if($update){
            return true ;
        }
        return false;
    }

    public function emailRelease($token){
        $query['query'] = 'UPDATE subscribe SET email_release = TRUE WHERE token=:token';
        $query['values'] = array('token' => $token);
        $update = $this->db->update($query);
        if($update){
            return true ;
        }
        return false;
    }
   

    public function subscribeUsersFailedMail(){
        $query['query'] = 'SELECT * FROM subscribe WHERE email_release = :email_release;';
        $query['values'] = array('email_release' => 'FALSE');
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }
    public function getToken($email){

        $query['query'] = 'select token from subscribe where email=\'' . $email . '\'';
        //$query['values'] = array('token' => $token);
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }
    public function unSubscribefromintel($email){
        $query['query'] = 'update subscribe set status=2 where email=\'' . $email . '\'';
        //$query['values'] = array('token' => $token);
        $update = $this->db->update($query);
        if($update){
            return true ;
        }
        return false;
    }
    public function unSubscribe($token){

        $query['query'] = 'update subscribe set status=2 where token=:token';
        $query['values'] = array('token' => $token);
        $update = $this->db->update($query);
        if($update){
            return true ;
        }
        return false;
    }

    public function getCommodityWithReviewer(){
        $query['query'] = "select commodity.id,name,type_id , COUNT(DISTINCT user_commodity.user_id) reviewers
                            FROM commodity
                            LEFT JOIN user_commodity ON commodity.id = user_commodity.commodity_id
                            WHERE commodity.status = :status
                            group by commodity.id;";
        $query['values'] = array('status' => 0);
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }

    public function getCodeWithReviewer(){
        $query['query'] = "SELECT id,code FROM reporting WHERE status = :status";
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
}
