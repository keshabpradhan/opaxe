<?php

class reviews{
    
    private $db;
    private $review_id;
    private $user_id;
    private $report_id;
    private $type;
    private $question_id;
    private $score;
    private $reviewer_identity;
    private $reviewer_interest;
    private $total_score;
    private $status;
    private $notes;
    private $auto_calc;
    private $ausimm_code;
    private $competent_person_commodity;

    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table = 'review';
        $this->idSeq = 'review_id_seq';
    }

    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row) {
        $this->review_id   = (array_key_exists ( 'review_id', $row )) ? $row ['review_id'] : null;
        $this->report_id   = (array_key_exists ( 'report_id', $row )) ? $row ['report_id'] : null;
        $this->user_id     = (array_key_exists ( 'user_id', $row )) ? $row ['user_id'] : null;
        $this->type        = (array_key_exists ( 'type', $row )) ? $row ['type'] : null;
        $this->question_id = (array_key_exists ( 'question_id', $row )) ? $row ['question_id'] : null;
        $this->score       = (array_key_exists ( 'score', $row )) ? $row ['score'] : null;
        $this->total_score = (array_key_exists ( 'total_score', $row )) ? $row ['total_score'] : null;
        $this->notes       = (array_key_exists ( 'notes', $row )) ? $row ['notes'] : null;
        $this->reviewer_identity = (array_key_exists ( 'reviewer_identity', $row )) ? $row ['reviewer_identity'] : null;
        $this->reviewer_interest = (array_key_exists ( 'reviewer_interest', $row )) ? $row ['reviewer_interest'] : null;
        $this->auto_calc         = (array_key_exists ( 'auto_calc', $row )) ? $row ['auto_calc'] : 0;
        $this->ausimm_code       = (array_key_exists ( 'ausimm_code', $row )) ? $row ['ausimm_code'] : 'no';
        $this->competent_person_commodity       = (array_key_exists ( 'competent_person_commodity', $row )) ? $row ['competent_person_commodity'] : 'no';
        $this->status      = (array_key_exists ( 'status', $row )) ? $row ['status'] : 0;
    }

    public function getsavedreviews($userid){
        $query['query'] = "SELECT review.id,review.report_id,to_char(review.created_at, 'Mon DD, YYYY') as created_at, review.total_score, report.type, report.company, report.project FROM review,report
                            WHERE review.report_id = report.id and (review.status=0 OR review.status=3) and review.user_id=:userid";
        $query['values'] = array('userid' => $userid);
        $saved_reviews = $this->db->getArrayFromSelect($query);

        if($saved_reviews){
 
            return $saved_reviews ;    
        }
        return false;
    }
    
    public function getsubmittedreviews($userid){
        
        $query['query'] = "SELECT review.id,review.report_id,to_char(review.created_at, 'Mon DD, YYYY') as created_at, review.total_score, report.type, report.company, report.project FROM review,report
                            WHERE review.report_id = report.id and review.status=1 and review.user_id=:userid";
        $query['values'] = array('userid' => $userid);
        $submitted_reviews = $this->db->getArrayFromSelect($query);
        
        if($submitted_reviews){
 
            return $submitted_reviews ;    
        }
        return false;
    }
    
    
    public function deleteReviews($reviewid){
        
        $query['query'] = 'update review set status=2 where id=:reviewid';
        $query['values'] = array('reviewid' => $reviewid);
        $deleted_reviews = $this->db->update($query);
        
        if($deleted_reviews){
 
            return true ;    
        }
        return false;
    }

    public function addReview($data) {
        // perform checks on data and then process it
        $this->map ( $data );
        return $this->add ();
    }

    private function add() {
        $insertQuery ['query'] = "INSERT INTO $this->table (
                                          user_id, report_id, type, reviewer_identity, reviewer_interest,
                                          total_score, status, notes, auto_calc, ausimm_code, competent_person_commodity
                                          )
                                          VALUES(
                                          :user_id, :report_id, :type, :reviewer_identity, :reviewer_interest,
                                          :total_score, :status, :notes, :auto_calc, :ausimm_code, :competent_person_commodity
                                          )";
        $insertQuery ['values'] = array (
                            'user_id' => $this->user_id,
                            'report_id' => $this->report_id,
                            'type' => $this->type,
                            'reviewer_identity' => $this->reviewer_identity,
                            'reviewer_interest' => $this->reviewer_interest,
                            'total_score' => $this->total_score,
                            'status' => $this->status,
                            'notes' => $this->notes,
                            'auto_calc' => $this->auto_calc,
                            'ausimm_code' => $this->ausimm_code,
                            'competent_person_commodity' => $this->competent_person_commodity
                        );

        $this->review_id = $this->db->cudRecord ( $insertQuery, $this->idSeq );
        return $this->review_id;
    }


    public function addRating($data) {
        $this->map ( $data );
        $table = "rating";
        $sequence = "rating_id_seq";

        $query['query'] = "INSERT INTO $table ( review_id, question_id,score, status) VALUES(:review_id, :question_id, :score, :status);";
        $query['values'] = array('review_id' => $this->review_id,'question_id' => $this->question_id,'score' => $this->score, 'status' => $this->status );
        return $this->db->cudRecord($query, $sequence);
    }


    public function addAllRating($questions) {
        $table = "rating";
        $sequence = "rating_id_seq";

        $query['query'] = "INSERT INTO $table ( review_id, question_id,score, status) VALUES(?, ?, ?, ?);";
        $data = array();
        foreach ($questions as $q) {
            $questionId = $q['id'];
            $score = isset($_REQUEST[$questionId]) ? $_REQUEST[$questionId] : 0;

            $temp = array($this->review_id, $questionId,$score, $this->status );
            array_push($data,$temp);
        }
        $query['values'] = $data;
        return $this->db->insertBulkRecord($query, $sequence);
    }

    public function addSectionRating(){
        $table = "section_rating";
        $sequence = "section_rating_id_seq";

        $sections = $this->getAllSection();
        $query['query'] = "INSERT INTO $table ( review_id, section_id,score, status) VALUES(?, ?, ?, ?);";
        $data = array();
        foreach ($sections as $s) {
            $sectionId = $s['id'].'-section';
            $score = isset($_REQUEST[$sectionId]) ? $_REQUEST[$sectionId] : 0;

            $temp = array($this->review_id, $s['id'],$score, $this->status );
            array_push($data,$temp);
        }
        $query['values'] = $data;
        return $this->db->insertBulkRecord($query, $sequence);
    }

    public function savecomplain($userid,$complaint,$reviewid){
        $query['query'] = 'INSERT INTO "complaint"(
                           user_id, complaint, review_id
                           )
                            VALUES ( :userid, :complaint, :reviewid)';
        $query['values'] = array( 'userid' => $userid,'complaint' => $complaint, 'reviewid' => $reviewid);
        $save = $this->db->getArrayFromSelect($query);
        return true;
    }

    /**
     * Load All Section
     * @return object
     */
    public function getAllSection() {
        $query['query'] = 'SELECT id,name,review_info_id FROM "section" WHERE status = :status ORDER BY id ASC;' ;
        $query['values'] = array('status' => 0);

        return $this->db->getArrayFromSelect($query);

        return $this->db->filter('section');
    }

    public function getReviewDetailById() {
        $query['query'] = 'select review.id, review.user_id, report_id, reviewer_identity, reviewer_interest, total_score, review.type AS review_type,
                             report.cpqp,report.code,report.company,to_char(report.date, :date_format) as date,report.project,report.type,
                             anonymous,consultant,level,notes,ausimm_code,competent_person_commodity
                              from '.$this->table .'
                                INNER JOIN report ON report.id = review.report_id
                                INNER JOIN "user" ON "user".id = review.user_id
                                WHERE review.id = :review_id;' ;
        $query['values'] = array('date_format' => 'Mon DD, YYYY', 'review_id' => $this->review_id);

        return $this->db->getArrayFromSelect($query);
    }


    public function getReviewRating() {
        $query['query'] = 'SELECT report_id,section.id,name, SUM(score) AS score, count(review.id)  AS total, SUM(review.total_score) AS total_score
                            FROM review
                            LEFT JOIN section_rating ON review.id = section_rating.review_id
                            LEFT JOIN section ON section.id = section_rating.section_id
                            LEFT JOIN "user" ON "user".id = review.user_id
                            WHERE report_id = :report_id AND review.status = 0 AND "user".level <> :exp_level
                            GROUP BY report_id,section.id,section.name
                            ORDER BY section.id ASC;' ;
        $query['values'] = array('report_id' => $this->report_id, 'exp_level' => 'Junior Reviewer'); //Junior Reviewer not include in rating calculation

        return $this->db->getArrayFromSelect($query);
    }

    public function getRatingByReviewId() {
        $query['query'] = "SELECT review_id,question_id,score FROM rating
                                WHERE review_id = :review_id;" ;
        $query['values'] = array('review_id' => $this->review_id);

        return $this->db->getArrayFromSelect($query);
    }

    public function getSectionByReviewId() {
        $query['query'] = "SELECT review_id,section_id,score FROM section_rating
                                WHERE review_id = :review_id;" ;
        $query['values'] = array('review_id' => $this->review_id);

        return $this->db->getArrayFromSelect($query);
    }

    public function getReviewInfo() {
        $query['query'] = "SELECT id,name,information,status FROM review_info WHERE status = :status;";
        $query['values'] = array('status' => 0);

        return $this->db->getArrayFromSelect($query);
    }

    public function reportLink($report_id){
        $query['query'] = "SELECT * FROM report
                            WHERE id=:reportid";
        $query['values'] = array('reportid' => $report_id);
        $reportlink = $this->db->getArrayFromSelect($query);

        if($reportlink){
            if (!isset($_SESSION)) session_start();
            $_SESSION['reportlink']=$reportlink[0]['download'];
            return true ;
        }
        return false;

    }

    public function saveinvitereview($report_id,$email,$userId){
        $query['query'] = 'INSERT INTO invite_reviewer(
                           user_id, report_id, invite_email
                           )
                            VALUES ( :userId, :report_id, :email)';
        $query['values'] = array( 'userId' => $userId,'report_id' => $report_id, 'email' => $email);
        $save = $this->db->getArrayFromSelect($query);
    }

    public function allUserEmail(){
        $query['query'] = 'SELECT email
                           FROM "user"
                           Where invitation=:status';
        $query['values'] = array( 'status' => 'yes');
        $result = $this->db->getArrayFromSelect($query);
        return $result;
    }

    public function errors() {
        return $this->db->errors();
    }

    /**
     * @return mixed
     */
    public function getReviewId()
    {
        return $this->review_id;
    }

    /**
     * @param mixed $review_id
     */
    public function setReviewId($review_id)
    {
        $this->review_id = $review_id;
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
    public function getReportId()
    {
        return $this->report_id;
    }

    /**
     * @param mixed $report_id
     */
    public function setReportId($report_id)
    {
        $this->report_id = $report_id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getReviewerIdentity()
    {
        return $this->reviewer_identity;
    }

    /**
     * @param mixed $reviewer_identity
     */
    public function setReviewerIdentity($reviewer_identity)
    {
        $this->reviewer_identity = $reviewer_identity;
    }

    /**
     * @return mixed
     */
    public function getReviewerInterest()
    {
        return $this->reviewer_interest;
    }

    /**
     * @param mixed $reviewer_interest
     */
    public function setReviewerInterest($reviewer_interest)
    {
        $this->reviewer_interest = $reviewer_interest;
    }

    /**
     * @return mixed
     */
    public function getTotalScore()
    {
        return $this->total_score;
    }

    /**
     * @param mixed $total_score
     */
    public function setTotalScore($total_score)
    {
        $this->total_score = $total_score;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
  
}//end of class
