<?php
require_once "conf/conf.inc.php";
require_once "db/db.inc.php";

// create db object
$db = new RscPDO(DSN, DBUSER, DBPASSWORD);
$geom = "geometryfromtext('POINT(524949.5 180013)',27700)";
//$query['query'] = "select * from report limit 1;";
//$query['query'] = 'select * from "user" where username=fahim and password=123';
$query['query'] = 'select * from "user" where username=:username and password=:password' ;
$query['values'] = array('username' => 'fahim', 'password' => '123');


$result = $db->getArrayFromSelect($query);
print_r($result);
$error = $db->errors();
print_r($error);


?>