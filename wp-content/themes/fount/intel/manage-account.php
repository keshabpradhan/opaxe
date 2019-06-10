<?php if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['userid'])) header('Location: www.rscmme.com');

require_once 'lib/login.header.php';
require_once('lib/lib.php');
$profile=  getProfileDetail();
$profile_detail = $profile['profile'];
$org = $profile['organization'];
$reporting = $profile['reporting_exp'];
$commodity = $profile['commodity_exp'];
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>RSC RESOURCE REPORTING INTELLIGENCE — RSC</title>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.js"></script>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <?php include 'header-inc.php';?>
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="css/custom.css?122">

    <style type="text/css">
        a {cursor: pointer;}
        .profile-input {
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
            color: #555;
            display: block;
            font-size: 15px;
            height: 29px;
            line-height: 1.42857;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
            border-radius: 10px;
        }

        #review-modal #confirm-report {top: 4px !important;}
        .expendable > p {padding-top: 2px !important;}
        #complaint-report {margin-left: 7px !important;position: relative;top: 3px;}

        body {background-color: #ffffff !important;}

        .personalTableLeft {font-size: 15px !important;}
        #personal-details td {
            font-size: 14px;
        }
        button, input, select, textarea {font-size: 14px !important;}
        .label-heading {font-size: 15px !important;}
        .checkbox_container span {font-size: 14px !important;}
        #personal-detail-container {float: left;width: 70%;}
        .RightDivEdit {width: 100%;}
        #content-div #savedreviews td {font-size: 14px !important;}
        #content-div #savedreviews td, #content-div #submittedReviews td {font-size: 14px !important;}
        .review-table > #submittedReviews {margin-bottom: 4em;}
        #personal-details-edit input[type="text"] {width: 157px;}
        .checkbox_container {width: 410px;}
        .checkbox_container select {float: right;position: relative;top: 5px;}
        #content-div { border-top: 1px solid #161616;margin-top: 30px;}
        .modal-body .container-fluid th, #complaint-opt label,.rating-head p,#notes > label,.modal-body label {font-family: sans-serif;}
        #complaint-modal .expandSlider > img {margin-top: 13px;}
        #complaint-modal .collapseSlider > img {margin-top: -6px;}


        #review-modal, #frm-review-form{font-family: sans-serif;font-size: 0.9em;}
        #review-modal .modal-dialog, .complaint-modal .modal-dialog {font-size: 12px;line-height: 1.6;}
        #review-modal button,#review-modal input,#review-modal select,#review-modal textarea {font-family: sans-serif;font-size: 12px !important;}
        #review-modal .modal-body {padding-top: 8px;}
        .expandSlider > img {margin-top: 9px;}
        #review-modal #close-review-btn{font-size: 21px !important;}
        #review-modal #close-review-show-btn {font-size: 21px !important;}
    </style>


    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
</head>
<body style="background-color:#ffffff;">
<!--<div id="review-info-popup" class="review-info-popup"></div>-->
    <div class="site-inner-wrapper">
        <?php include 'header.php';?>

        <div class="left-navigation" >
            <div class="expert-panel-left-link" >
                <a href="./" id="RP-4">
                    Return to Map
                </a>
            </div>

            <div class="expert-panel-left-link">
                <a href="#" id="RP-4" onclick="javascript:oRsc.logoutformdashboard()">Logout</a>
            </div>
        </div>
    </div>

    <section id="content-wrapper">
    <div id="review-panel-main">

    <div id="expert-panel-paragraph">


    <div id="profile-details">



        <div class="contact-details-tabel">
            <div class="RightDivEdit">

                <div>
                    <div id="personal-detail-container">
                        <div>
                            <h3 style="margin-top: 0px;">PERSONAL DETAILS &nbsp&nbsp
                                <a href="#" class="edit-link" id="edit-personal-detail-link" onclick="javascript:oManageAccount.editPersonalDetails();">Edit</a>
                            </h3>
                        </div>

                        <div id="personal-details">
                            <table>
                                <tr>
                                    <td class="personalTableLeft">Name:</td>
                                    <td id="ma-name"><?php  echo $profile_detail['firstname'];?>&nbsp<?php echo $profile_detail['lastname']; ?></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Company:</td>
                                    <td id="ma-company"><?php echo $profile_detail['company']; ?></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Position:</td>
                                    <td id="ma-position"><?php echo $profile_detail['position']; ?></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">City:</td>
                                    <td id="ma-city"><?php echo $profile_detail['city']; ?></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Country:</td>
                                    <td id="ma-country"><?php echo $profile_detail['country']; ?></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Email:</td>
                                    <td id="ma-email"><?php echo $profile_detail['email']; ?></td>
                                </tr>
                            </table><br>

                            <label class="labelSubHeadingRight">Biography (public):</label><br>
                            <p id="ma-biography"><?php echo $profile_detail['biography']; ?></p><br>
                        </div>

                        <div id="personal-details-edit" style="display: none">
                            <table>
                                <tr>
                                    <td class="personalTableLeft">First Name:</td>
                                    <td><input type="text" id="ma-fname" name="fname" value="<?php  echo $profile_detail['firstname'];?>"></td>
                                </tr>

                                <tr>
                                    <td class="personalTableLeft">Last Name:</td>
                                    <td><input type="text" id="ma-lname" name="lname" value="<?php echo $profile_detail['lastname']; ?>"></td>
                                </tr>

                                <tr>
                                    <td class="personalTableLeft">Company:</td>
                                    <td><input type="text" id="ma-edit-company" name="company" value="<?php echo $profile_detail['company']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Position:</td>
                                    <td><input type="text" id="ma-edit-position" name="position" value="<?php echo $profile_detail['position']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">City:</td>
                                    <td><input type="text" id="ma-edit-city" name="city" value="<?php echo $profile_detail['city']; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Country:</td>
                                    <td>
                                        <select name="country" id="country" style="width:  11.2em;"></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="personalTableLeft">Email:</td>
                                    <td><input type="text" id="ma-edit-email" name="email" value="<?php echo $profile_detail['email']; ?>"></td>
                                </tr>
                            </table><br>

                            <label class="labelSubHeadingRight">Biography (public):</label><br>
                            <textarea rows="3" cols="100" id="ma-edit-biography" name="biography"><?php echo $profile_detail['biography']; ?></textarea><br>

                            <div class="editButton">
                                <div class="processing" style="display: inline-block; width: 16px;">
                                    <img src="images/loading_ani.gif" style="display: none; margin: 0px ! important;">
                                </div>
                                <input type="button" onclick="javascript:oManageAccount.updatePersonalDetails()" value="SAVE">
                                <input type="button" onclick="javascript:oManageAccount.showPersonalDetails()" value="CANCEL">
                            </div>
                            <br>
                        </div>
                    </div>
                    <!--Profile Images-->
                    <div style="float: left; " id="image-container">
                        <h3 style="margin:0 0 14px;display: none;">EDIT PROFILE  </h3>
                        <div class="imgDivEdit">
                            <form method="post" action="lib/all.php?action=addprofileimage" id="addimageform" enctype="multipart/form-data">
                                <div id="img"><?php
                                    if($_SESSION['pname']){
                                        echo '<img src="images/upload/'.$_SESSION['pname'].'" class="PP-img"></br>';
                                    }else{
                                        echo '<img src="images/upload/dummy.png" class="PP-img"></br>';
                                    }
                                    ?></div>
                                <input type="file" id="addimage" name="fileToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <div id="image-links" style="display: block; text-align: right; margin-top: 5px;">
                                    <div id="profile-img-links" style="display: block">
                                        <a href="#" onclick="document.getElementById('addimage').click(); return false">
                                            <img src="images/edit.png" title="Change Image" alt="Change Image"/></a>&nbsp;&nbsp;
                                        <a href="#" onclick="javascript:oManageAccount.deleteImage();">
                                            <img src="images/delete.png" title="Delete Image" alt="Delete Image"/></a>
                                    </div>
                                    <div id="add-profile-img-link" style="display: block">
                                        <a href="#" onclick="document.getElementById('addimage').click(); return false">
                                            <img src="images/add.png" height="20px" width="20px" title="Add Image" alt="Add Image"/></a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="resume-container">
                            <label class="label-heading">Resume : </label><br>

                            <?php if($profile_detail['resume'] != '') { ?>
                                <label >&#34;<?php echo $profile_detail['resume']; ?>&#34;</label><br>
                                <form style="position: absolute" method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                    <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                    <a class="edit-link" id="upload-resume-manageAccount" onclick="document.getElementById('addresume').click(); return false">Change</a>&nbsp;&nbsp;&nbsp;
                                    <a class="edit-link" id="delete-resume"onclick="javascript:oManageAccount.deleteResume()">Delete</a>
                                </form>
                            <?php }else{ ?>
                                <label id="no-reusme">&#34;no resume found.&#34;</label>
                                <form method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                    <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                    <a class="edit-link" id="upload-resume-manageAccount"onclick="document.getElementById('addresume').click(); return false">Upload Resume</a>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div style="clear:both"></div>



                <div id="perfessional-membership-view" style="display: block">
                <label class="labelSubHeadingRight">Professional Memberships: <a href="#" class="edit-link" id="edit-personal-detail-link" onclick="javascript:oManageAccount.editPerfessionalMembership();">Edit</a></label>
                <div id="professionalMembershipView">
                    <?php
                    if (isset($org) && $org != false) {
                    foreach($org as $key => $value){
                        $str = ''; // Reset
                        ?>
                        <label><?php echo $value['org_name'];?></label>
                        <label>, Membership No. &nbsp;<?php echo $value['membership_no'];?>,</label>
                        <?php if(isset($value['membership']) && $value['membership']){ $str = 'Membership, ';}
                         if(isset($value['member']) && $value['member']){ $str.='Member,';}
                         if(isset($value['fellow']) && $value['fellow']){ $str.='Fellow,';}
                         if(isset($value['cp']) && $value['cp']){ $str.='Cp,';}
                         if(isset($value['rpgeo']) && $value['rpgeo']){ $str.='RPGeo';}
                         $str = str_replace(",", ", ", $str);
                        $str = rtrim($str, ', '); ?>
                        <?php if($str != ''){ ?>
                        <label>(<?php echo $str; ?>)</label>
                        <?php } ?>
                        <br>
                    <?php } // Foreache
                    } // if
                    ?>
                </div>
            </div><br>
                <div id="perfessional-membership-edit" style="display: none">
                <label class="labelSubHeadingRight">Professional Memberships:</label>
                <div id="professionalMembership"></div>
                <a class="linkEditAccount" onclick="javascript:oManageAccount.loadProfessionalMembership();">+add organisation/association</a><br><br>

                    <div class="editButton">
                        <div class="processing" style="display: inline-block; width: 16px;">
                            <img src="images/loading_ani.gif" style="display: none; margin: 0px ! important;">
                        </div>
                        <input type="button" onclick="javascript:oManageAccount.addPerfessionalMemberships()" value="SAVE">
                        <input type="button" onclick="javascript:oManageAccount.showPerfessionalMembership()" value="CANCEL">
                </div>
            </div>

                <div id="commodity-experience-view" style="display: block">
                    <label class="labelSubHeadingRight">Commodity Experience: <a href="#" class="edit-link" id="edit-personal-detail-link" onclick="javascript:oManageAccount.editCommodityExp();">Edit</a></label>
                    <div id="commodityExperienceDivView">
                        <?php
                        // Group Commodity by type
                        if (isset($commodity) && $commodity != false) {
                            $commodityGroup = array();
                            foreach ($commodity as $data) {
                                $id = $data['type_id'];
                                if (isset($commodityGroup[$id])) {
                                    $commodityGroup[$id][] = $data;
                                } else {
                                    $commodityGroup[$id] = array($data);
                                }
                            }
                        foreach($commodityGroup as $key => $value){ ?>
                            <label><?php if($value[0]['type']){ echo @$value[0]['type']; } ?> </label><br>

                            <?php
                            // sub commodity
                            foreach($value as $k => $val) {
                                ?>
                                <label style="padding-left: 2em"><?php if ($val['name']) {
                                        echo @$val['name'];
                                    }
                                    if ($val['style']) {
                                        echo '(' . $val['style'] . ')';
                                        if ($val['experience']) {
                                            echo ', ' . getExperience(@$val['experience']);
                                        }
                                    } ?>
                                </label><br>
                            <?php
                            } // sub foreach
                            } // foreache
                        } // if
                        ?>
                    </div>
                </div><br>

                <div id="commodity-experience-edit" style="display: none">
                <label class="labelSubHeadingRight">Commodity Experience:</label>
                <div id="commodityExperienceDiv"></div>
                <a class="linkEditAccount" onclick="javascript:oManageAccount.loadCommodity();">+add commodity</a><br><br>
                    <div class="editButton">
                        <div class="processing" style="display: inline-block; width: 16px;">
                            <img src="images/loading_ani.gif" style="display: none; margin: 0px ! important;">
                        </div>
                        <input type="button" onclick="javascript:oManageAccount.saveCommodity();" value="SAVE">
                        <input type="button" onclick="javascript:oManageAccount.showCommodityExp();" value="CANCEL">
                    </div>
            </div>

                <div id="reporting-exprience-view" style="display: block">
                    <label class="labelSubHeadingRight">Reporting Experience: <a href="#" class="edit-link" id="edit-personal-detail-link" onclick="javascript:oManageAccount.editReportingExp();">Edit</a></label>
                    <div id="reportingExperienceDivView">
                        <?php
                        if (isset($reporting) && $reporting != false) {
                        foreach($reporting as $key => $value){ ?>
                            <label><?php if($value['code']){ echo @$value['code']; }
                                 if($value['experience']){ echo ', '.getExperience(@$value['experience']); }
                                 if($value['exchanges']){ echo ', reporting to the '.@$value['exchanges'].' exchanges'; } ?>
                                </label><br>
                        <?php } // Foreache
                        } // if
                        ?>

                    </div><br>
                </div>

                <div id="reporting-exprience-edit" style="display: none">
                <label class="labelSubHeadingRight">Reporting Experience:</label>
                <div id="reportingExperienceDiv"></div>
                <a class="linkEditAccount" onclick="javascript:oManageAccount.loadReporting();">+add code/guideline</a><br><br>
                    <div class="editButton">
                        <div class="processing" style="display: inline-block; width: 16px;">
                            <img src="images/loading_ani.gif" style="display: none; margin: 0px ! important;">
                        </div>
                        <input type="button" onclick="javascript:oManageAccount.saveReportingExperience()" value="SAVE">
                        <input type="button" onclick="javascript:oManageAccount.showReportingExp();" value="CANCEL">
                    </div>
            </div>

                <div id="div-rsc-advises">
                    <p>
                        <?php
                        if($profile_detail['rsc_advises']){
                            $rsc_checked = 'checked';
                        }else{
                            $rsc_checked = '';
                        }
                        ?>
                        RSC advises to exercise caution when carrying out reviews. Reviewers are to make sure they do not have a conflict of interest, whether perceived or real and RSC notes that providing anonymous reviews should under no circumstance be misused as a mechanism to bring into disrepute people, groups or companies. RSC advises each reviewer to obtain legal advice, particularly in regard to any personal or professional liability that may arise from using this site and the need for indemnity insurance.
                        <br />
                        <input type="checkbox" name="rsc-advises" id="rsc-advises" <?php echo($rsc_checked); ?> /> I understand
                    </p>
                </div>

                <div id="notification-view" style="display: block">
                <label class="labelSubHeadingRight">Notification:</label> <a href="#" class="edit-link" id="edit-personal-detail-link" onclick="javascript:oManageAccount.editNotification();">Edit</a><br>
                <div class="checkbox_container">

                    <?php if($profile_detail['register_as'] == 'cpqp'){ ?>
                        <div>
                            <?php
                                if($profile_detail['my_report_review']){
                                    $checked = 'checked';
                                     }else{
                                    $checked = '';
                                }
                            ?>
                            <label><input  type="checkbox" name="my_report_review" id="my_report_review" <?php echo($checked); ?> disabled></label>
                            <span>whenever my report gets reviewed.</span>
                        </div>
                    <?php } ?>


                        <div>
                            <?php if($profile_detail['invitation'] == 'yes'){ ?>
                                <label><input type="checkbox" name="invites_updates" id="invites_updates" checked disabled></label>
                                <span id="view_invites_updates">invites from other registered reviewers to review reports (<?php echo $profile_detail['invitation_frequency']; ?>).</span>
                            <?php }else{ ?>
                                <label><input type="checkbox" name="invites_updates" id="invites_updates" disabled></label>
                                <span>invites from other registered reviewers to review reports.</span>
                            <?php } ?>

                        </div>


                        <div>
                            <?php if($profile_detail['new_review_updates']){ ?>
                                <label><input  type="checkbox" name="new_review_updates" id="new_review_updates" checked disabled></label>
                                <span id="view_new_review_updates">whenever a new review is submitted (<?php echo $profile_detail['new_review_frequency']; ?>).</span>
                            <?php }else{ ?>
                                <label><input type="checkbox" name="new_review_updates" id="new_review_updates" disabled></label>
                                <span>whenever a new review is submitted.</span>
                            <?php } ?>

                        </div>

                        <div>
                            <?php if($profile_detail['summery_report']){ ?>
                                <label><input type="checkbox" name="summery_report_check" id="summery_report_check" checked disabled></label>
                                <span  id="view_summery_report_check">summary of new reports (<?php echo $profile_detail['summery_report_frequency']; ?>).</span>
                            <?php }else{ ?>
                                <label><input type="checkbox" name="summery_report_check" id="summery_report_check" disabled></label>
                                <span>summary of new reports.</span>
                            <?php } ?>

                        </div>

                        <div>
                        <?php if($profile_detail['below_average']){ ?>
                            <label><input  type="checkbox" name="below_average" id="below_average" checked disabled></label>
                            <span>only reviews which are below 2.5 average.</span>
                        <?php }else{ ?>
                            <label><input  type="checkbox" name="below_average" id="below_average" disabled></label>
                            <span>only reviews which are below 2.5 average.</span>
                        <?php } ?>

                        </div>


                </div>
            </div>
                <div id="notification-edit" style="display: none">
                    <label class="labelSubHeadingRight">Notification:</label><br>
                    <div class="checkbox_container">
                        <?php if($profile_detail['register_as'] == 'cpqp'){ ?>
                            <div>
                                <?php
                                if($profile_detail['my_report_review']){
                                    $checked = 'checked';
                                }else{
                                    $checked = '';
                                }
                                ?>
                                <label><input  type="checkbox" name="my_report_review" id="my_report_review" <?php echo($checked); ?> ></label>
                                <span>whenever my report gets reviewed.</span>
                            </div>
                        <?php } ?>

                        <div>
                            <?php if($profile_detail['invitation'] == 'yes'){ ?>
                                <label><input type="checkbox" name="invites_updates_check" id="invites_updates" checked></label>
                            <?php }else{ ?>
                                <label><input type="checkbox" name="invites_updates_check" id="invites_updates" ></label>
                            <?php } ?>
                            <span>invites from other registered reviewers to review reports.</span>
                            <select id="invites_freq" name="invites_freq">
                                <?php $invites = $profile_detail['invitation_frequency']; ?>
                                <?php if($invites == 'daily'){ ?>
                                    <option value="daily" selected >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } elseif($invites == 'weekly'){ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly" selected>weekly</option>
                                <?php }else{ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } ?>
                            </select>
                        </div>


                        <div>
                            <?php if($profile_detail['new_review_updates']){ ?>
                                <label><input onclick="javascript:oManageAccount.identifyNewReviewCheck()" type="checkbox" name="new_review_check" id="new_review_updates" class="new_review_updates" checked ></label>
                            <?php }else{ ?>
                                <label><input onclick="javascript:oManageAccount.identifyNewReviewCheck()" type="checkbox" name="new_review_check" id="new_review_updates" class="new_review_updates" ></label>
                            <?php } ?>
                            <span>whenever a new review is submitted.</span>
                            <select id="new_review_freq" name="new_review_freq">
                                <?php $new_review = $profile_detail['new_review_frequency']; ?>
                                <?php if($new_review == 'daily'){ ?>
                                    <option value="daily" selected >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } elseif($new_review == 'weekly'){ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly" selected>weekly</option>
                                <?php }else{ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } ?>
                            </select>
                        </div>

                        <div>
                            <?php if($profile_detail['summery_report']){ ?>
                                <label><input type="checkbox" name="summery_report_check" id="summery_report_check" checked ></label>
                            <?php }else{ ?>
                                <label><input type="checkbox" name="summery_report_check" id="summery_report_check" ></label>
                            <?php } ?>
                            <span>summary of new reports.</span>
                            <select id="summery_report_freq" name="summery_report_freq">
                                <?php $sumery_rep = $profile_detail['summery_report_frequency']; ?>
                                <?php if($sumery_rep == 'daily'){ ?>
                                    <option value="daily" selected >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } elseif($sumery_rep == 'weekly'){ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly" selected>weekly</option>
                                <?php }else{ ?>
                                    <option value="daily" >daily</option>
                                    <option value="weekly">weekly</option>
                                <?php } ?>
                            </select>
                        </div>

                        <div>
                            <?php if($profile_detail['below_average']){ ?>
                                <label><input onclick="javascript:oManageAccount.identifyBlowAvegCheck()" type="checkbox" name="below_average_check" id="below_average" class="below_average" checked ></label>
                            <?php }else{ ?>
                                <label><input onclick="javascript:oManageAccount.identifyBlowAvegCheck()" type="checkbox" name="below_average_check" id="below_average" class="below_average" ></label>
                            <?php } ?>
                            <span>only reviews which are below 2.5 average.</span>
                        </div>



                    </div>
                    <div class="editButton">
                        <div class="processing" style="display: inline-block; width: 16px;">
                            <img src="images/loading_ani.gif" style="display: none; margin: 0px ! important;">
                        </div>
                        <input type="button" onclick="javascript:oManageAccount.updateNotification()" value="SAVE">
                        <input type="button" onclick="javascript:oManageAccount.showNotification()" value="CANCEL">
                    </div>
            </div>
            </div>
        </div>

    </div>

    <div id="content-div">
    <div class="review-tablei">
        <h3>SUBMITTED REVIEWS:</h3>

        <table id="savedreviews">
            <div class="spinner medium" id="loading"></div>
            <label id="no-review" style="display:none;">No Submitted Reviews.</label>
        </table>
    </div>

    <div class="review-table">
        <h3>SAVED REVIEWS:</h3>

        <table id="submittedReviews">
            <div class="spinner medium" id="submittedReviews_loading"></div>
            <label id="submittedReviews_no-review"  style="display:none;">No Saved Reviews.</label>
        </table>
    </div>

</div>

</div>

    <?php include 'review.php';?>
</div>
</section>
    </div>
</body>
</html>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="Del-1">
            <div class="modal-body login-modal">
                <p id="L-2">Do You Want to Delete This Review?</p>
                <a class="btn btn-success modal-login-btn" id="L-89" onclick="javascript:oManageReview.deletereview()">YES</a>
                <a class="btn btn-success modal-login-btn" id="L-90" onclick="javascript:oManageReview.nothing()">NO</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="invite-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="inviterevierpopup">
            <div class="modal-body login-modal">
                <p id="email-heading">Invite A Reviewer</p>
                <div id='social-icons-conatainer'>
                    <div class='modal-body-left' id="L-3">
                        <div class="error-email"> <label id="email-message" ></label></div>
                        <form id="invite" action="javascript:oManageReview.invitereviewer()" method="post">
                            <div class="email-label-input">
                                <div class="form-group" id="L-6">
                                    <label> Email:</label>

                                    <input name="email" type="text" id="email" value="" class="form-control login-field L-5" >
                                    <input name="reportId" id="reportId" type="hidden">
                                </div>
                            </div>
                            <div id="button-issue">
                                <div class="imgProgressInvite"><img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"></div>
                                <input name="submit" type="submit" value=" SEND" class="btn btn-success modal-login-btn" id="L-65">
                                <input type="button" class="btn btn-success modal-login-btn" id="L-66" onclick="javascript:oManageReview.cancelinvite();" value="CANCEL">
                            </div>
                        </form>
                        <div class="error-email"> <label id="email-message" ></label></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade submit-review" id="invitationSent-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="thankyouInvitation">
            <div class="modal-body login-modal">
                <p>Thank you for inviting a fellow reviewer(s)!</p>

                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oManageReview.hideInvitationConfirmation();" class="btn loggedin-btn" id="back-btn-invitation">BACK</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        oManageAccount.init();
        oInvitation.populateUsername();
        oRsc.populateCountriesManageProfile("<?php echo $profile_detail['country'];?>");

        // Review & Complaint
        oReview.initReview();
        oComplaint.initComplaint();

        _UserProfessionalMemberships = <?php echo json_encode($org); ?>;
        _UserCommodityExperience = <?php echo json_encode($commodity); ?>;
        _UserReportingExperience = <?php echo json_encode($reporting); ?>;
    });
</script>