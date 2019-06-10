<?php
require_once('lib/lib.php');

/*Todo: RSC-MI taking parts down*/
header("Location: http://intel.rscmme.com");
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
    <link rel="stylesheet" href="css/custom.css?105">


    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
    <style type="text/css">
        .font-14 label, .font-14 select, .checkbox_container select{
            font-size: 14px !important;
        }
        .personal-details input[type=radio]{
            position: relative;
            top:2px;
        }
    </style>

</head>
<body style="background-color:#ffffff;">

    <!-- Registration Thank you Popup -->
    <div class="modal fade bs-example-modal-sm" id="registration-thankyou-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="registered_as_content">Thank you. You are now registered as Competent/Qualified Person on RSC-MI.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="site-inner-wrapper">
        <?php include 'header.php';?>

        <div class="left-navigation" >
            <div class="expert-panel-left-link" >
                <!--<a href="./" id="RP-4">
                    Return to Map
                </a>-->
                <a href="#" onclick = "javascript:self.close();" id="RP-4">
                    Return to map
                </a>
            </div>
        </div>
    </div>

    <section id="content-wrapper">

        <div id="review-panel-main">
            <div id="expert-panel-paragraph">
                <div id="content-div">


                    <div class="singup_container" id="singup_container" >
                        <div id="signup-info-popup" class="signup-info-popup" ></div>

                        <h3>Personal Details: &nbsp;<img id="profile-details-info" class="tooltip-complaint" src="images/info.png"></h3>

                        <div class="full-width margin-bottom" id="error-msg" style="display: ; text-align: center">
                            <div class="imgProgressSignup" style="height: 1em; margin: 0 30em;"><img style="margin: 0px !important; display: none" src="images/loading_ani.gif"></div>
                            <label class="full-width" id="signup-message" style="display: none"></label>
                        </div>

                        <div class="half margin-bottom " style="width:54%" >
                            <div class="personal-details">
                                <label class="entity_name">First Name:</label>
                                <div><input class="signup-input" type="text" id="fname" name="fname" value=""/></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">Last Name:</label>
                                <div><input class="signup-input" type="text" id="lname" name="lname" value=""/></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">Company:</label>
                                <div><input class="signup-input" type="text" id="company" name="company" value=""/></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">Position:</label>
                                <div><input class="signup-input" type="text" id="position" name="position" value=""/></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">Country:</label>
                                <div><select name="country" id="country" style=" height: 2em;width: 21.4em; font-size: 14px;"></select></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">City:</label>
                                <div><input class="signup-input" type="text" id="city" name="city" value=""/></div>
                            </div>
                            <div class="personal-details">
                                <label class="entity_name">Email:</label>
                                <div><input class="signup-input" type="text" id="email" name="email" value=""/></div>
                            </div>
                            <div id="register-as-div" class="personal-details font-14">
                                <label style="float: left; width: 32%">Apply to register as: &nbsp;<img id="register-as-info" class="tooltip-complaint" src="images/info.png"></label>
                                <div style="width: 26em; float: left">
                                    <div>
                                        <input type="radio" class="register_as" name="register_as" id="register_as_reviewer" value="reviewer">
                                        Reviewer&nbsp;
                                    </div>

                                    <div>
                                        <input type="radio" value="cpqp" id="register_as_cpqp" class="register_as" name="register_as">
                                        Competent/Qualified Person for a report listed on this website
                                    </div>
                                </div><br><br>
                            </div>
                            <div class="personal-details font-14">
                                <label style="float: left; width: 32%">Are you a consultant? &nbsp;&nbsp;&nbsp;</label>
                                <div style="width: 20em; float: left">Yes&nbsp;<input type="radio" name="consultant" value="yes">
                                No&nbsp;<input type="radio" name="consultant" value="no"></div>
                            </div>
                            <div style="clear: both"></div>
                            <div id="anonymousDiv" class="personal-details font-14">
                                <label style="float: left; width: 32%">Profile Anonymous? &nbsp;<img id="anonymously-info" class="tooltip-complaint" src="images/info.png"></label>
                                <div style="width: 20em; float: left">Yes&nbsp;<input type="radio" name="anonymous" value="yes">
                                No&nbsp;<input type="radio" name="anonymous" value="no"></div>
                            </div>
                        </div>

                        <div class="half margin-bottom " style="width:46%" >
                            <label class="entity_name">Biography: &nbsp;<img id="biography-info" class="tooltip-complaint" src="images/info.png"></label>
                            <div>
                                <textarea name="biography" id="biography" rows="8" cols="49"></textarea>
                            </div>
                        </div>

                        <div id="perfessional-membership-edit" class="full-width margin-bottom ">
                            <label class="entity_name full-width">Professional Memberships: &nbsp;<img id="perfessional-membership-info" class="tooltip-complaint" src="images/info.png"></label>
                            <div id="professionalMembership" class="full-width font-14"></div>
                            <a class="linkEditAccount full-width" onclick="javascript:oManageAccount.loadProfessionalMembership();">+ add organisation/association</a><br><br>
                        </div>

                        <div id="commodity-experience-edit" class="full-width margin-bottom " >
                            <label class="entity_name full-width">Commodity Experience: &nbsp;<img id="commodity-experience-info" class="tooltip-complaint" src="images/info.png"></label>
                            <div id="commodityExperienceDiv" class="full-width font-14"></div>
                            <a class="linkEditAccount full-width" onclick="javascript:oManageAccount.loadCommodity();">+ add commodity</a><br><br>
                        </div>

                        <div id="reporting-exprience-edit" class="full-width margin-bottom " >
                            <label class="entity_name full-width">Reporting Experience: &nbsp;<img id="reporting-experience-info" class="tooltip-complaint" src="images/info.png"></label>
                            <div id="reportingExperienceDiv" class="full-width font-14"></div>
                            <a class="linkEditAccount full-width" onclick="javascript:oManageAccount.loadReporting();">+ add code/guideline</a><br><br>
                        </div>

                        <div id="notification-edit" class="full-width margin-bottom ">
                            <label class="entity_name full-width">Additional Information: &nbsp;<img id="additional-information-info" class="tooltip-complaint" src="images/info.png"></label>
                            <form method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <div class="full-width">
                                <a class="edit-link" id="upload-resume-manageAccount"onclick="document.getElementById('addresume').click(); return false">Upload Resume</a>
                                    <label id="no-reusme" style="font-size: 14px">( no file uploaded )</label>
                                    <label id="reusme" style="display: none;font-size: 14px"></label>

                                </div>
                            </form>


                            <form method="post" action="lib/all.php?action=addprofileimage" id="addimageform" enctype="multipart/form-data">
                                <input type="file" id="addimage" name="fileToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <div id="add-profile-img-link-signup" class="full-width">
                                <a class="edit-link " href="#" onclick="document.getElementById('addimage').click(); return false">Upload Profile Picture</a>
                                    <label id="no_profile" style="font-size: 14px">( no file uploaded )</label>
                                    <label id="profile_" style="display: none;font-size: 14px"></label>
                                </div>
                            </form>
                        </div><br>

                        <div class="full-width margin-bottom " >
                            <div id="div-rsc-advises">
                                <p>
                                    RSC advises to exercise caution when carrying out reviews. Reviewers are to make sure they do not have a conflict of interest, whether perceived or real and RSC notes that providing anonymous reviews should under no circumstance be misused as a mechanism to bring into disrepute people, groups or companies. RSC advises each reviewer to obtain legal advice, particularly in regard to any personal or professional liability that may arise from using this site and the need for indemnity insurance.
                                    <br />
                                    <input type="checkbox" name="rsc-advises" id="rsc-advises" /> I understand
                                </p>
                            </div>
                            <label class="entity_name full-width">Notifications:</label>
                            <div class="checkbox_container full-width">
                                <div id="my_report_review_div" style="display: none;">
                                    <label><input type="checkbox" name="my_report_review" id="my_report_review" ></label>
                                    <span>whenever my report gets reviewed.</span>
                                </div>
                                <div id="invite-from-other-div">
                                    <label><input type="checkbox" name="invites_updates_check" id="invites_updates" ></label>
                                    <span>invites from other registered reviewers to review reports.</span>
                                    <select name="invites_freq" class="checkbox-dropdown">
                                            <option value="daily" >daily</option>
                                            <option value="weekly">weekly</option>
                                    </select>
                                </div>
                                <div>
                                    <label><input onclick="javascript:oManageAccount.identifyNewReviewCheck()" type="checkbox" name="new_review_check" id="new_review_updates" class="new_review_updates" ></label>
                                    <span>whenever a new review is submitted.</span>
                                    <select name="new_review_freq" class="checkbox-dropdown">
                                        <option value="daily" >daily</option>
                                        <option value="weekly">weekly</option>
                                    </select>
                                </div>
                                <div>
                                    <label><input type="checkbox" name="summery_report_check" id="summery_report_check" ></label>
                                    <span>weekly summary of new reports.</span>
                                    <!--<select name="summery_report_freq" class="checkbox-dropdown">
                                        <option value="daily" >daily</option>
                                        <option value="weekly">weekly</option>
                                    </select>-->
                                </div>
                                <div>
                                    <label><input onclick="javascript:oManageAccount.identifyBlowAvegCheck()" type="checkbox" name="below_average_check" id="below_average" class="below_average" ></label>
                                    <span>only reviews which are below 2.5 average.</span>
                                </div>
                            </div>
                        </div>

                        <div class="editButton full-width">
                            <div class="signupProgressBar" style="display: inline-block; width: 16px;"><img style="margin: 0px !important; display: none" src="images/loading_ani.gif"></div>
                            <input type="button" onclick="javascript:oManageAccount.signup()" value="SIGNUP">
                            <input type="button" onclick="javascript:oManageAccount.()" value="CANCEL">
                            <div id="processing"><img src="images/loading_ani.gif"></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </section>


</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        oManageAccount.signupInit();
        oRsc.populateCountriesManageProfile();
    });
</script>