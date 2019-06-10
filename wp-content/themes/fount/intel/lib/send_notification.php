<?php
//die();
require_once('../conf/conf.inc.php');
require_once('../db/db.inc.php');
require ('PHPMailer/PHPMailerAutoload.php');

function sendEmailNotification(){
    require_once('../classes/activity.class.php');
    require_once('../classes/signup.class.php');

    $oActivity = new Activity();
    $users = new Signup();
    $reports = $oActivity->getRequireEmailNotification();
    $subscribers = $users->getSubscribedUsers();
    $unRegisterSubscribers = $users->getUnRegisteredSubscribedUsers();
    if($reports){
        sendEmails($subscribers, $reports);
        sendEmailToSubscribers($unRegisterSubscribers, $reports);
    }
}

function sendEmails($subscribers, $reportData){
    require_once('../classes/activity.class.php');
    $oActivity = new Activity();

    // List of New Review on Report
    for($j=0; $j<count($reportData); $j++){
        $subject='New review submitted';
        $subscriberUpdateOpt = 'New report reviews';
        $level = $reportData[$j]['level'];
        $report_id = $reportData[$j]['report_id'];
        // Send Email to each Subscriber
        for($i=0; $i<count($subscribers); $i++){
            $emails = $subscribers[$i]['email'];
            $user_id = $subscribers[$i]['user_id'];
            $full_name = $subscribers[$i]['firstname'] .' '.$subscribers[$i]['lastname'];
            // New Review Updates
            if($subscribers[$i]['new_review_updates']){
                $subscriberUpdateOpt = 'New report reviews';
                $subject = 'New review submitted';
            }
            // Average below 2.5
            if($subscribers[$i]['below_average'] && $reportData[$j]['total_score'] <= 2.5){
                $subscriberUpdateOpt = 'New &lt; 2.5 rated report reviews';
                $subject = 'Less than 2.5 rated report review';
            }

            $history = ($reportData[$j]['history'] != 'True') ? ' (see History tab):' : ':' ;
            $message='Dear registered reviewer,<br><br>';

            // MY Report Review
            $myReport = $oActivity->isMyReport($report_id,$user_id);
            if($subscribers[$i]['my_report_review'] && $myReport){
                $subscriberUpdateOpt = 'New report reviews';
                $subject = 'New review submitted';

                $message .= 'The user '.$full_name.' has submitted a review against your report with details as follow:';
            }else{
                $message .= 'A new <TYPE> review has been submitted by a <b style="text-transform: lowercase;">'.strtolower($level).'</b> for the following <b>'.strtolower($reportData[$j]['type']).'<b>'.$history.'</b>'.'</b>';
            }

            $messageRsc='<html><body>' .$message. '<br><br>';
            $messageRsc .= '<br><b>Date :</b> '.$reportData[$j]['date'];
            $messageRsc .= '<br><b>Company :</b> '.$reportData[$j]['company'];
            $messageRsc .= '<br><b>Project :</b> '.$reportData[$j]['project'];
            $messageRsc .= '<br><b>CPQP :</b> '.$reportData[$j]['cpqp'];
            $messageRsc .= '<br><b>Report Type :</b> '.$reportData[$j]['type'];
            $messageRsc .= '<br><b>Report Code :</b> '.$reportData[$j]['code'].'<br>';

            $messageRsc .='<br><br>If you are interested to submit a review for this report as well, or would like to review another report, please log on to our website: <a href="http://intel.rscmme.com/" target="_blank">http://intel.rscmme.com/</a>';
            $messageRsc .='<br><br>Kind regards,';
            $messageRsc .='<br><br>The RSC Mineral Intelligence team';
            $messageRsc .='<br><br><p style="color: #4a4a4a;font-size: 0.78em;">This email was sent to <a href="#">'.$emails.'</a> because you have subscribed to receive <b>'.$subscriberUpdateOpt.'.</b> If you no longer wish to receive these emails, please update your subscription by logging on to our <a href="http://intel.rscmme.com/" target="_blank">website</a> and update your profile.</p>';
            $messageRsc .='</body></html>';

            phpmail($emails, $subject, $messageRsc);
        }

        $activity_log_id = $reportData[$j]['activity_log_id'];
        $oActivity->updateEmailReleaseStatus($activity_log_id);
    }

    return true;
}

function sendEmailToSubscribers($subscribers, $reportData){
    require_once('../classes/activity.class.php');
    $oActivity = new Activity();
    $req = '/lib/all.php?action=unsubscribe';
    $base_url = "http://$_SERVER[HTTP_HOST]$req";
    // List of New Review on Report
    for($j=0; $j<count($reportData); $j++){
        $subject='New review submitted';
        $subscriberUpdateOpt = 'New report reviews';
        $level = $reportData[$j]['level'];
        // Send Email to each Subscriber
        for($i=0; $i<count($subscribers); $i++){
            $emails = $subscribers[$i]['email'];
            $name   = $subscribers[$i]['name'];
            $token   = $subscribers[$i]['token'];
            if($subscribers[$i]['new_review']){
                $history = ($reportData[$j]['history'] != 'True') ? ' (see History tab):' : ':' ;
                $message='Dear '.$name.',<br><br>';
                $message .= 'A new <TYPE> review has been submitted by a <b style="text-transform: lowercase;">'.strtolower($level).'</b> for the following <b>'.strtolower($reportData[$j]['type']).'<b>'.$history.'</b>'.'</b>';

                $messageRsc='<html><body>' .$message. '<br><br>';
                $messageRsc .= '<br><b>Date :</b> '.$reportData[$j]['date'];
                $messageRsc .= '<br><b>Company :</b> '.$reportData[$j]['company'];
                $messageRsc .= '<br><b>Project :</b> '.$reportData[$j]['project'];
                $messageRsc .= '<br><b>CPQP :</b> '.$reportData[$j]['cpqp'];
                $messageRsc .= '<br><b>Report Type :</b> '.$reportData[$j]['type'];
                $messageRsc .= '<br><b>Report Code :</b> '.$reportData[$j]['code'].'<br>';

                $messageRsc .='<br><br>If you are interested to submit a review for this report as well, or would like to review another report, please log on to our website: <a href="http://intel.rscmme.com/" target="_blank">http://intel.rscmme.com/</a>';
                $messageRsc .='<br><br>Kind regards,';
                $messageRsc .='<br><br>The RSC Mineral Intelligence team';
                $messageRsc .='<br><br><p style="color: #4a4a4a;font-size: 0.78em;">This email was sent to <a href="#">'.$emails.'</a> because you have subscribed to receive <b>'.$subscriberUpdateOpt.'.</b> If you no longer wish to receive these emails, <a href="'.$base_url.'&un=true&key='.$token.'" target="_blank">you can unsubscribe here</a>.</p>';
//                $messageRsc .='<p style="color: #4a4a4a;font-size: 0.78em;">You are receiving this email because you subscribe at intel.rscmme.com If you do not wish to receive emails in the future <a href="'.$base_url.'&un=true&key='.$token.'" target="_blank">Unsubscribe here</a> </p>';
                $messageRsc .='</body></html>';

                phpmail($emails, $subject, $messageRsc);
            }
        }
    }

    return true;
}

/**
 *  Send Email to invite users
 */
function sendNotificationToInvitedUser(){
    require_once('../classes/invitation.class.php');
    require_once('../classes/signup.class.php');
    require_once ('../classes/reviews.class.php');

    $oInvitation = new invitation();
    $users = new Signup();
    $reports = $oInvitation->getInvitationDetail();
    $subscribers = $users->getInvitationSubscribedUsers();
    if($reports){
        // List of Invitations
        for($j=0; $j<count($reports); $j++){
            $subject = 'Invite from other reviewers';
            //OverAll rating
            $overAllRating = getOverAllRating($reports[$j]['report_id']);
            $email = $reports[$j]['invite_email'];
            $messageRsc = inviteReviewerEmail($reports[$j],$overAllRating,$email);
            // Send Email to each Subscriber
            phpmail($email, $subject, $messageRsc);

            $invite_reviewer_id = $reports[$j]['invite_reviewer_id'];
            $oInvitation->updateEmailReleaseStatus($invite_reviewer_id);
        }
    }

}

function getOverAllRating($reportId){
    require_once ('../classes/reviews.class.php');

    $oReview = new Reviews();
    $oReview->setReportId($reportId);
    $rating= $oReview->getReviewRating();
    if($rating)
        $overAllRating =  $rating[0]['total_score'] / (int) $rating[0]['total'];
    else
        $overAllRating = 0;

    return $overAllRating;
}

function inviteReviewerEmail($reportDetails,$overallRating,$email){
    $message='Dear registered reviewer,<br><br>';
    $message .= 'A new review has been submitted by a <b style="text-transform: lowercase;">'.strtolower($reportDetails['level']).'</b> for the following <b>'.strtolower($reportDetails['type']).'</b> report:<br><br>';
    $message.='<b>Date : </b>'.$reportDetails['date'].'<br>';
    $message.='<b>Company : </b>'.$reportDetails['company'].'<br>';
    $message.='<b>Project : </b>'.$reportDetails['project'].'<br>';
    $message.='<b>CP/QP : </b>'.$reportDetails['cpqp'].'<br>';
    $message.='<b>Report Type : </b>'.$reportDetails['type'].'<br>';
    $message.='<b>Report Code : </b>'.$reportDetails['code'].'<br>';
    $message.='<b>Overall Rating : </b>'.$overallRating.'<br><br>';

    $reviewerNote = isset($reportDetails['reviewer_note']) ? $reportDetails['reviewer_note'] : false;
    if($reviewerNote){
        $message.='The reviewer&#39;s note is as follow:<br><i>'.$reviewerNote.'</i>';
    }

    $message.='<br><br>If you are interested to submit a review for this report as well, or would like to review another report, please log on to our website: <a href="http://intel.rscmme.com/" target="_blank">http://intel.rscmme.com/</a>';
    $message.='<br><br>Kind regards,';
    $message.='<br><br>The RSC Mineral Intelligence team';
    $message.='<br><br><p style="color: #4a4a4a;font-size: 0.78em;">This email was sent to <a href="#">'.$email.'</a> because you have subscribed to receive <b>Invites from other reviewers</b>. If you no longer wish to receive these emails, please update your subscription by logging on to our <a href="http://intel.rscmme.com/" target="_blank">website</a> and update your profile.</p>';
    $message.='</body></html>';
    return $message;
}

function subscribeUserMailResend(){
    require_once('../classes/invitation.class.php');

    $oInvitation = new invitation();
    $users = $oInvitation->subscribeUsersFailedMail();
    $req = '/lib/all.php?action=unsubscribe';
    $base_url = "http://$_SERVER[HTTP_HOST]$req";
    if($users){
        for($i=0; $i<count($users); $i++){
            $user = $users[$i];

            $token   = $user['token'];
            $to      = $user['email'];
            $subject = 'Subscription confirmation to RSC-MI';
            $message = '<html><body>Dear '.$user['name'].' <br/><br/>';
            $message .= 'Thank you for subscribing to RSC-MI.';
            $message .='<br><br>Kind regards,';
            $message .='<br><br>The RSC Mineral Intelligence team';
            $message .='<br><br><p style="color: #4a4a4a;font-size: 0.78em;">You are receiving this email because you subscribed at intel.rscmme.com. If you do not wish to receive any further emails from us you can unsubscribe <a href="'.$base_url.'&un=true&key='.$token.'" target="_blank">here</a>. </p>';
            $message .= '</body></html>';
            $email = phpmail($to,$subject,$message);
            if($email){
                $oInvitation->emailRelease($token);
                // Admin Email
                subscribeEmailToAdmin($user);
            }
        }
    }
}

function subscribeEmailToAdmin($user){
    $name = $user['name'];
    $email = $user['email'];
    $subject = 'New user subscribed';
    $message = '<html><body>'.$name.' ('.$email.') would like to subscribe to the following options:<br><br>';
    if($user['new_report'])
        $message .= '<p>I would like to receive a weekly summary of new published technical reports.</p>';
    if($user['new_review'])
        $message .= '<p>I would like to be notified whenever a new report review has been submitted.</p>';
    if($user['cp_review'])
        $message .= '<p>I would like to register as a competent person (CP) and would like to be notified whenever a published technical report (co-) written by me has been reviewed.</p>';
    $message .='<br><br>Kind regards,';
    $message .='<br><br>The RSC Mineral Intelligence team';
    $message .= '</body></html>';

    // Send Email
    $emails =(explode(",",SUBSCRIBE_EMAIL));
    foreach ($emails as $email) {
        phpmail($email, $subject, $message);
    }
}

function phpmail($to,$subject,$message){

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth   = true;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.oneclout.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username   = PHP_MAILER_EMAIL;
    $mail->Password   = PHP_MAILER_PASSWORD;
    $mail->AddReplyTo(REPLY_EMAIL, 'RSC Mineral Intelligence');
    $mail->SetFrom(FROM_EMAIL, 'RSC Mineral Intelligence');
    $mail->Subject    = $subject;
    $address = $to;
    $mail->AddAddress($address);
    $mail->MsgHTML($message);
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return true;
    }
}


sendEmailNotification();
sendNotificationToInvitedUser();
//Subscribe User which mail notification sending failed.
subscribeUserMailResend();

