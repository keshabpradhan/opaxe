<?php

class Complaint{
    
    private $db;
    private $table;
    private $name;
    private $date;
    private $company;
    private $email;
    private $phone;
    private $address;
    private $cpqp;
    private $complaint;
    private $organistaion;
    private $security;
    private $lawTick;
    private $ethicsTick;
    private $jorcTick;
    private $valminTick;
    private $law;
    private $ethics;
    private $jorc;
    private $valmin;
    private $otherDetail;
    private $reviewId;
    private $contact_cpqp;

    function __construct () {
        $this->db = new RscPDO(DSN, DBUSER, DBPASSWORD);
        $this->table = 'complaint';
    }

    /**
     * map values to private variables
     * @param object $row
     */
    public function map($row)
    {
        $this->name  = (array_key_exists('name', $row)) ? $row ['name'] : null;
        $this->date   = (array_key_exists('date', $row)) ? $row ['date'] : null;
        $this->email       = (array_key_exists('email', $row)) ? $row ['email'] : null;
        $this->address = (array_key_exists('address', $row)) ? $row ['address'] : null;
        $this->phone       = (array_key_exists('phone', $row)) ? $row ['phone'] : null;
        $this->cpqp    = (array_key_exists('cpqp', $row)) ? $row ['cpqp'] : null;
        $this->complaint   = (array_key_exists('complaint', $row)) ? $row ['complaint'] : null;
        $this->company     = (array_key_exists('company', $row)) ? $row ['company'] : null;
        $this->organistaion        = (array_key_exists('organistaion', $row)) ? $row ['organistaion'] : null;
        $this->security     = (array_key_exists('security', $row)) ? $row ['security'] : null;
        $this->lawTick  = (array_key_exists('lawTick', $row)) ? $row ['lawTick'] : null;
        $this->ethicsTick       = (array_key_exists('ethicsTick', $row)) ? $row ['ethicsTick'] : null;
        $this->jorcTick      = (array_key_exists('jorcTick', $row)) ? $row ['jorcTick'] : null;
        $this->valminTick   = (array_key_exists('valminTick', $row)) ? $row ['valminTick'] : null;
        $this->law   = (array_key_exists('law', $row)) ? $row ['law'] : null;
        $this->ethics  = (array_key_exists('ethics', $row)) ? $row ['ethics'] : null;
        $this->jorc = (array_key_exists('jorc', $row)) ? $row ['jorc'] : null;
        $this->valmin = (array_key_exists('valmin', $row)) ? $row ['valmin'] : null;
        $this->otherDetail = (array_key_exists('otherDetail', $row)) ? $row ['otherDetail'] : null;
        $this->reviewId = (array_key_exists('reviewId', $row)) ? $row ['reviewId'] : null;
        $this->contact_cpqp = (array_key_exists('contact_cpqp', $row)) ? $row ['contact_cpqp'] : null;
    }

    public function saveComplaint($data){
        $this->map($data);
        
        $this->date = date("Y-m-d", strtotime($this->date));
      
        $query['query'] = 'INSERT INTO complaint(
                            review_id, complaint, date, name, company, email, address, phone, 
                            cpqp, professional_organisation, securities_exchange, aus_imm_law, 
                            aus_imm_ethics, jorc_code, valmin_code, specific_law, code_of_ethics, 
                            specific_jorc_code, specific_valmin_code, other_details)
                            VALUES (:reviewId,:complaint,:date,:name,:company,:email,:address,:phone,
                            :cpqp,:professional_organisation,:securities_exchange,:aus_imm_law,:aus_imm_ethics,
                            :jorc_code,:valmin_code,:specific_law,:code_of_ethics,:specific_jorc_code,
                            :specific_valmin_code, :other_details)';
        $query['values'] = array(
            'reviewId' => $this->reviewId,
            'complaint' => $this->complaint,
            'date' => $this->date,
            'name' => $this->name,
            'company'=> $this->company,
            'email' => $this->email,
            'address' => $this->address,
            'phone' => $this->phone,
            'cpqp'=> $this->cpqp,
            'professional_organisation' => $this->organistaion,
            'securities_exchange' => $this->security,
            'aus_imm_law' => $this->lawTick,
            'aus_imm_ethics' => $this->ethicsTick,
            'jorc_code' => $this->jorcTick,
            'valmin_code' => $this->valminTick,
            'specific_law' => $this->law,
            'code_of_ethics'=> $this->ethics,
            'specific_jorc_code' => $this->jorc,
            'specific_valmin_code'=> $this->valmin,
            'other_details' => $this->otherDetail

        );
        $save = $this->db->insert($query);         
        return $save;
    }
    
    public function lessRating($data){
        $this->map($data);
        $query['query'] = 'INSERT INTO review_complaint(
                            review_id, name, email, cpqp_respond, cpqp_contact)
                            VALUES (:reviewId,:name,:email,
                            :cpqp,:contact_cpqp)';
        $query['values'] = array(
            'reviewId' => $this->reviewId,
            'name' => $this->name,
            'email' => $this->email,
            'cpqp'=> $this->cpqp,
            'contact_cpqp' => $this->contact_cpqp

        );
        $save = $this->db->insert($query);         
        return $save;
    }
    
    public function errors() {
        return $this->db->errors();
    }

}//end of class

