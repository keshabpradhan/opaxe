<?php

interface DB {

    public function connect($query);

    public function query($query);
}

// class RscPDO
class RscPDO {

    private $conId;   // connection identifier
    private $dsn;
    private $dbuser;
    private $dbpassword;
    private $statement; // PDO query statement container
    private $result;
    private $status;  // false: There are errors	true: There are no errors
    private $errorMessages; // Associated array containing error messages, keys are (code,error,info)
    private $errorCodes; // Array containing error codes

    // constructor

    public function __construct($dsn, $dbUser, $dbPassword) {
        $this->dsn = $dsn;
        $this->dbuser = $dbUser;
        $this->dbpassword = $dbPassword;
        $this->statement = null;
        $this->result = null;
        $this->status = true;
        $this->errorMessages = array();
        $this->errorCodes = array(
            '1' => 'Database connection',
            '2' => 'Error performing query',
            '3' => 'Error fetching record',
            '4' => 'No records found'
        );
    }

    /**
     * connect to PostgreSQL server and select database
     * @return {boolean}
     */
    private function connectDB() {

        // connect to database and raise error if fail
        try{
            $this->conId = new PDO($this->dsn, $this->dbuser, $this->dbpassword);

            // set the error reporting attributes to display proper error messages using exceptions.
            $this->conId->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            $this->raiseError('1', 'check DSN settings');
        }


        // return the status
        return $this->status;
    }

    /**
     * Performs the query
     * @return boolean
     * @param object $query
     * @param object $values                    values to bind with query
     * @param boolean $connect[optional]	Default is true (this forces to create new connection)
     * @param boolean $close[optional]		Default is false (this forces to close the connection after query)
     */
    public function query($query, $connect=true, $close=false) {

        if ($connect) { // Do we need to connect OR use existing connection
            // connect to Postgresql
            if (!$this->connectDB())
                return $this->status; // we have some error in connection hence return status (which should be false)
        }
        // perform query
        $this->performQuery($query);
        // if result is set
        if ($this->status) {
            // we have results
            if ($close)
                $this->close();
            return $this->status;
        }

        // we have error in query
        if ($close)
            $this->close();
        return false;
    }

    /**
     * Performs query and return resultset or false
     * @return object::status OR resultset
     * @param string $query
     */
    private function performQuery($query) {
        if ($this->status) {
            try{
                //die(print_r($query));
                if(isset($query['query'])){
                    // prepare query statement
                    $this->statement = $this->conId->prepare($query['query']);
                    // check for values to bind
                    if(isset($query['values']) && $query['values'] != null){
                        // loop through values to bind them with query
                        //die(print_r($query));
                        foreach($query['values'] as $key => $value){
                            $this->statement->bindValue(":{$key}", $value);
                        }
                    }
                    // execute query
                    $this->statement->execute();
                }else{
                    $this->raiseError('2', "query is not set");
                }

            }catch(PDOException $e){
                $this->raiseError('2', $e->getMessage()); //$query['query'] . " --- " .                                
            }
        }
        return $this->status;
    }

    public function insertBulkRecord($query, $connect=true, $close=true) {

        if ($connect) { // Do we need to connect OR use existing connection
            // connect to Postgresql
            if (!$this->connectDB())
                return $this->status; // we have some error in connection hence return status (which should be false)
        }

        if ($this->status) {
            try{
                if(isset($query['query'])){
                    // prepare query statement
                    $this->statement = $this->conId->prepare($query['query']);
                    // check for values to bind
                    if(isset($query['values']) && $query['values'] != null){
                        // loop through values to execute query
                        foreach ($query['values'] as $data) {
                            $this->statement->execute($data);
                        }
                    }
                }else{
                    $this->raiseError('2', "query is not set");
                }

            }catch(PDOException $e){
                $this->raiseError('2', $e->getMessage()); //$query['query'] . " --- " .
            }
        }

        // we have error in query
        if ($close)
            $this->close();

        return $this->status;
    }

    /**
     * Checks if table contains a record with given id
     * @return {boolean}
     * @param object $table	Name of the table
     * @param object $idCol	Name of the column which contains the ID
     * @param object $idVal	Value of the Id
     */
    public function idExists($table, $idCol, $idVal) {
        // set initial status to false
        $status = false;
        // build query
        $query['query'] = "SELECT count($idCol) FROM $table WHERE $idCol = :idVal";
        $query['values'] = array('idVal' => $idVal);

        if ($this->query($query)) {
            // we have result
            $this->result = $this->statement->fetch(PDO::FETCH_COLUMN);
            $status = ($this->result == 1) ? true : false;
            // raise error if status id false
            if(!$status){
                $this->raiseError('4', $idCol . "($idVal) in " . $table);
            }
        }

        // we don't need the results anymore so clear the memory
        $this->freeResult();

        return $status;
    }

    /**
     * performs select query on the basis of given parameters
     *
     * @param string $table     name of the table to query from
     * @param string $filter    filters to use in where clause
     * @param object $values    values to bind with query
     * @param string $order     order by clause
     * @param string $limit     limit clause
     * @param string $offset    offset to use in query
     * @return bool             returns true on success and false on fail
     */
    public function filter($table='', $filter='', $values='', $order='', $limit='', $offset='') {
        if($table == ''){
            return false;
        }
        $query = "SELECT * FROM $table";

        // If there is some filter then encapsulate the whole merged records into a view (subquery) so all
        //filters can be applied
        // without knowing from which table they are being extracted
        $query = " SELECT * FROM ($query) AS recordset";

        $where = ($filter == '') ? '' : ' WHERE ' . $filter;
        $orderBy = $this->getOrderByClause($order);
        $limitBy = ($limit>0 && $limit!='') ? " LIMIT $limit":'';
        $offset = ($offset=='' || $offset==1) ? " OFFSET 0" : " OFFSET $offset";

        $query2['query'] = $query . $where . $orderBy . $limitBy . $offset;
        $query2['values'] = ($values == '') ? '' : $values;
        //die(print_r($query2));
        return $this->getArrayFromSelect($query2);
    }

    private function getOrderByClause($order) {
        if ($order == '') return $order;
        $orderType = substr($order, -1,1);
        $orderCol = substr($order, 0,strlen($order)-1);
        $orderBy = " ORDER BY " . $orderCol;
        $orderBy .= ($orderType == '1') ? " ASC " : " DESC ";
        return $orderBy;
    }

    /**
     * Checks if table contains a record with given 'where' clause
     * @return {boolean}
     * @param object $table	Name of the table
     * @param object $where     Where clause
     * @param object $values    values to use in Where clause
     */
    public function recordExists($table, $where, $values) {

        // set initial status to false
        $status = false;
        // build query
        $query['query'] = "SELECT count(*) FROM $table WHERE $where";
        $query['values'] = $values;
        //die(print_r($query));
        if ($this->query($query)) {
            // we have result
            $this->result = $this->statement->fetch(PDO::FETCH_COLUMN);
            //die("sdsds" . var_dump($this->result));
            $status = ($this->result == 1) ? true : false;

            // raise error if status id false
            if(!$status){
                $this->raiseError('4', $where . " in " . $table);
            }

        }

        // we don't need the results anymore so clear the memory
        $this->freeResult();

        return $status;
    }

    /**
     * performs the query and returns result as json object
     * @return JSON object or false
     * @param object $query
     */
    public function getJSONFromSelect($query) {

        // perform query
        if ($this->query($query)) {
            // fetch all records and store them in result
            $this->result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
            // close db connection
            $this->close();
            //return fetched result
            return json_encode($this->result);
        }

        return false;
    }

    public function getGeoJSONFromSelect($query) {

        // perform query
        if ($this->query($query)) {
            # Build GeoJSON feature collection array
            $geoJson = array(
                'type'      => 'FeatureCollection',
                'features'  => array()
            );
            # Loop through rows to build feature arrays
            while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)) {
                $properties = $row;
                # Remove geojson and geometry fields from properties
//                unset($properties['longitude']);
//                unset($properties['latitude']);

                $feature = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        "type" => "Point",
                        "coordinates" => [$properties['longitude'], $properties['latitude']]
                    ),
                    'properties' => $properties
                );
                # Add feature arrays to feature collection array
                array_push($geoJson['features'], $feature);
            }
            
            // store all records in result
            $this->result = $geoJson;
            // close db connection
            $this->close();
            //return fetched result
            return json_encode($this->result);
        }

        return false;
    }

    /**
     * performs the query and returns result as associated array
     * @return Array object or false
     * @param object $query
     */
    public function getArrayFromSelect($query) {
        // perform query
        //  die(var_dump("sss" . $query));
        //    die(print_r($query));
        if ($this->query($query)) {
            // fetch all records and store them in result
           // print_r($query);
            $this->result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
            //print_r($this->result);
            // close db connection
            $this->close();
            //return fetched result
            return $this->result;
        }
        return false;
    }

    /**
     * can be used to perform insert/update/delete query and returns id of inserted record if $idSeq is provided
     * @return boolean or Id of affected record
     * @param object $query
     * @param object $idSeq[optional]
     */
    public function cudRecord($query, $idSeq=false) {

        // connect to db and perform query
        if ($this->query($query)) {

            // free result
            $this->freeResult();

            // Do we need to find out the inserted records Id
            // if not then return with success
            if (!$idSeq) {
                $this->close();
                return true;
            }

            // otherwise get the inserted record's id using provided sequence
            $idQuery['query'] = "SELECT CURRVAL('$idSeq') as seq";
            // run the query with current connection and then close connection
            if ($this->query($idQuery, false, true)) {
                $this->result = $this->statement->fetch(PDO::FETCH_ASSOC);
                if (isset($this->result['seq'])) {
                    //free result
                    $this->freeResult();
                    // return the id
                    return $this->result['seq'];
                } else {
                    $this->raiseError('3', 'Sequence: ' . $idSeq);
                }
            }
        }

        return false;
    }

    /**
     * Performs the insert query
     * @return boolean
     * @param string $query
     */
    public function insert($query) {
        return $this->cudRecord($query);
    }

    /**
     * Performs the update query
     * @return boolean
     * @param string $query
     */
    public function update($query) {
        return $this->cudRecord($query);
    }

    /**
     * Performs the delete query
     * @return boolean
     * @param string $query
     */
    public function delete($query) {
        return $this->cudRecord($query);
    }

    // perform query which is the part of batch sql
    public function insertBatchRecord($query, $idSeq, $link) {
        // execute insert query
        return true;
    }

    public function freeResult() {
        if ($this->statement)
            $this->statement = null;
    }

    // close connection
    private function close() {
        // close connection
        $this->conId = null;
    }

    /**
     * @return {String} last error message
     */
    public function lastError() {
        $errors = count($this->errorMessages);
        if ($errors > 0)
            return $this->errorMessages[$errors - 1]['error'] . ': ' . $this->errorMessages[$errors - 1]['info'];
        else
            return false;
    }

    /**
     * Checks if there were any error while performing different functions
     * @return false or Object containing error details
     */
    public function getErrors() {
        // If there were any errors
        if ($this->status === false)
            // return the errorMessages array
            return array('status' => $this->status, 'details' => $this->errorMessages);
        else
            // otherwise return false
            return false;
    }

    /**
     * An alias for getErrors
     * @return object::getErrors()
     */
    public function errors() {
        return $this->getErrors();
    }

    /**
     * @return errorMessages
     */
    public function getAllErrors() {
        return $this->errorMessages;
    }

    private function setStatus($status, $msg='') {
        $this->status = $status;
        $this->errorMsg = $msg;
        return $this->status;
    }

    private function raiseError($code, $info) {
        $this->status = false;
        $info .= @pg_last_error();
        $msg = array('code' => $code,
            'error' => $this->errorCodes[$code],
            'info' => $info
        );
        array_push($this->errorMessages, $msg);
    }

    public function getResult() {
        return $this->result;
    }
}

?>