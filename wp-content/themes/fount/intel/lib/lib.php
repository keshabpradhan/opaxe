<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/conf/conf.inc.php'); 
require_once(__ROOT__.'/db/db.inc.php');


function getCompletedReview(){
    require_once('classes/login.class.php');

    $oRsc = new Rsc();
    $saved_reviews = $oRsc->getCompletedReview();
    return  count($saved_reviews);
}

function getSubmittedReview(){
    require_once('classes/login.class.php');

    $oRsc = new Rsc();
    $submitted_reviews = $oRsc->getSubmittedReview();
    return  count($submitted_reviews);
}

function getProfileDetail(){
    require_once('classes/login.class.php');

    $oRsc = new Rsc();
    $res = $oRsc->getProfileDetail();
    $profile['profile'] = $res[0];
    $profile['organization'] = $oRsc->getUserOrganizations();
    $profile['reporting_exp'] = $oRsc->getUserReportingExperience();
    $profile['commodity_exp'] = $oRsc->getUserCommodityExperience();
    return $profile;
}

function getAllCommodity(){
    require_once('classes/login.class.php');

    $oRsc = new Rsc();
    $commodity = $oRsc->getAllCommodity();
    return $commodity;
}

function getCommodityWithReviewer(){
    require_once('classes/invitation.class.php');
    $oInvitation = new invitation();
    $commodity = $oInvitation->getCommodityWithReviewer();
    return $commodity;
}

function getCodeWithReviewer(){
    require_once('classes/invitation.class.php');
    $oInvitation = new invitation();
    $codes = $oInvitation->getCodeWithReviewer();
    return $codes;
}

function getExperience($id){
    switch($id){
        case 1:
            return '<1 yr';
            break;
        case 2:
           return '1-5 yrs';
            break;
        case 3:
            return '5-10 yrs';
            break;
        case 4:
            return '10-15 yrs';
            break;
        case 5:
            return '15-30 yrs';
            break;
        case 6:
            return '>30 yrs';
            break;
    }
}

function getMetaDetail($name){
    require_once (__ROOT__.'/classes/report.class.php');
    // load Reports
    $oReport = new Report();
    $report = $oReport->getReportMetaDetail($name);
    if(count($report) >= 1)
        return $report[0];
    else
        return false;
}
