<?php
class Activity{

    private $db;
    private $activity_log_id;
    private $user_id;
    private $review_id;
    private $report_id;
    private $session_id;
    private $activity_type_code;
    private $status;
    private $email;

    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table = 'activity_log';
        $this->idSeq = 'activity_log_id_seq';
    }

    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row) {
        $this->review_id   = (array_key_exists ( 'review_id', $row )) ? $row ['review_id'] : null;
        $this->report_id   = (array_key_exists ( 'report_id', $row )) ? $row ['report_id'] : null;
        $this->user_id     = (array_key_exists ( 'user_id', $row )) ? $row ['user_id'] : null;
        $this->session_id  = (array_key_exists ( 'session_id', $row )) ? $row ['session_id'] : null;
        $this->email       = (array_key_exists ( 'email', $row )) ? $row ['email'] : null;
        $this->activity_type_code  = (array_key_exists ( 'activity_type_code', $row )) ? $row ['activity_type_code'] : null;
        $this->status      = (array_key_exists ( 'status', $row )) ? $row ['status'] : 0;
    }

    public function logActivity($data){
        $this->map($data);

        return $this->log();
    }

    private function log() {
        $insertQuery ['query'] = "INSERT INTO $this->table (user_id, report_id, review_id, session_id, activity_type_code, status)
                                  VALUES(:user_id, :report_id, :review_id, :session_id, :activity_type_code, :status)";
        $insertQuery ['values'] = array (
                            'user_id' => $this->user_id,
                            'report_id' => $this->report_id,
                            'review_id' => $this->review_id,
                            'session_id' => $this->session_id,
                            'activity_type_code' => $this->activity_type_code,
                            'status' => $this->status
                        );

        $this->activity_log_id = $this->db->cudRecord ( $insertQuery, $this->idSeq );
        return ! ($this->activity_log_id === false);
    }

    public function getRequireEmailNotification(){
        /*get rating from reviw tbl and put some condtion on review status and user !nuniour review*/
        $query['query'] = 'SELECT "user".level, r.id As report_id , al.id AS activity_log_id, al.report_id, al.user_id,review.total_score, to_char(r.date, :date_format) as date, r.company, r.project, r.cpqp, r.type, r.code, r.history
                    FROM '.$this->table.' as al
                    inner join report as r
                    on al.report_id = r.id
                    INNER JOIN review on review.id = al.review_id
                    INNER JOIN "user" on "user".id = review.user_id
                    where activity_type_code =:activity_type_code AND email_release is FALSE AND review.status = :active_status';
        $query['values'] = array('activity_type_code' => 'RC', 'date_format' => 'Mon DD, YYYY', 'active_status' => 0);

        $result = $this->db->getArrayFromSelect($query);

        if($result)
        {
            return $result;
        }
        return false;
    }

    public function updateEmailReleaseStatus($activity_log_id){
        $query['query'] = 'UPDATE activity_log SET email_release = TRUE where id=:activity_log_id';
        $query['values'] = array('activity_log_id' => $activity_log_id);
        $update = $this->db->update($query);
        if($update){
            return true ;
        }
        return false;
    }

    public function isUserInvited($data){
        $this->map($data);
        $query['query'] = 'SELECT * FROM invite_reviewer WHERE user_id = :user_id AND report_id = :report_id AND invite_email=:email;';
        $query['values'] = array(
                                'user_id' => $this->user_id,
                                'report_id' => $this->report_id,
                                'email' => $this->email
                            );
        $result = $this->db->getArrayFromSelect($query);
        if($result)
        {
            return $result;
        }
        return false;
    }

    public function isMyReport($report_id,$user_id){
        $query['query'] = 'SELECT "count"(*) FROM report WHERE id = :report_id AND user_id = :user_id;';
        $query['values'] = array(
            'report_id' => $report_id,
            'user_id' => $user_id
        );
        $result = $this->db->getArrayFromSelect($query);
        if($result[0]['count'] >= 1)
        {
            return true;
        }
        return false;
    }

    public function errors() {
        return $this->db->errors();
    }

}