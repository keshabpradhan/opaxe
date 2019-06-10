<div id="review-info-popup" class="review-info-popup"></div>

<form id="frm-review-form" action="javascript:oReview.submitReview();">
    <input type="hidden" id="review-report-id" name="review-report-id">
    <input type="hidden" id="history-review" name="history-review">
    <input type="hidden" id="modal-review-id" name="modal-review-id">
<div class="modal fade" id="review-modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close-review-show-btn" style="display: none;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <button type="button" id="close-review-btn" class="close" data-toggle="modal" data-target="#confirm-close-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">REPORT REVIEW FORM</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <p class="full-review-hidden">Thank you for taking the time to review this report!</p>

                    <div class="report-detail">
                        <h3 id="report-detail-h3">REPORT DETAILS</h3>
                        <table>
                            <tbody>
                            <tr>
                                <th>DATE :</th><td id="date-report"></td>
                            </tr>
                            <tr>
                                <th>Company :</th><td id="company-report"></td>
                            </tr>
                            <tr>
                                <th>PROJECT :</th><td id="project-report"></td>
                            </tr>
                            <tr>
                                <th>REPORT CODE :</th><td id="code-report"></td>
                            </tr>
                            <tr>
                                <th>REPORT TYPE :</th><td id="type-report"></td>
                            </tr>
                            <tr>
                                <th>CP/QP :</th><td id="cpqp-report"></td>
                            </tr>
                            </tbody>
                        </table>
                        <p id="review-confirm-box-p" class="full-review-hidden">Please confirm this is the report you wish to review <input type="checkbox" class="required not-left-nav" id="confirm-report" name="confirm-report" /></p>
                    </div>


                    <!--<p>For your review of this report:</p>-->
                    <div id="review-opt">
                        <div id="coi-div">
                            <!--<span class="conflict-of-interest-span"><img style="width:11px; height:11px" id="conflict_of_interest_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" /></span>-->
                            <p>
                                Do you have a conflict of interest?
                                <img style="width:11px; height:11px" id="conflict_of_interest_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" />
                            </p>
                            <select id="conflict-of-interest" class="required" name="conflict-of-interest">
                                <option value="">Please choose..</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                                <option value="maybe">Maybe</option>
                            </select>
                        </div>
                        <div style="clear: both"></div>
                        <div id="ausimm-code-span" class="full-review-hidden">
                            <!--<span class="review-right-span"><img style="width:11px; height:11px" id="ausimm_code_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" /></span>-->
                            <p>
                                Have you read and understood the AusIMM Code of Ethics and in particular the section on interaction with colleagues?
                                <img style="width:11px; height:11px" id="ausimm_code_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" />
                            </p>

                            <select id="ausimm-code" class="required" name="ausimm-code">
                                <option value="">Please choose..</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div style="clear: both"></div>
                        <div id="div-competent-person-commodity">
                            <p>
                                Do you consider yourself a Competent/Quali- fied Person for the style of mineralisation and activities covered by the report?
                            </p>

                            <select id="competent-person-commodity" name="competent-person-commodity" class="required">
                                <option value="">Please choose..</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div style="clear: both"></div>
                        <div id="anonymously-div" class="full-review-hidden">
                            <!--<span class="review-right-span"><img style="width:11px; height:11px" id="review_anonymously_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" /></span>-->
                            <p>
                                Review anonymously?
                                <img style="width:11px; height:11px" id="review_anonymously_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" />
                            </p>
                            <select id="review-report-identity" name="review-report-identity">
                                <option>Please choose..</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <p>
                            Type of review:
                            <select id="review-type" class="required" name="review-report-type">
                                <option value="">Please choose..</option>
                                <option value="1">Fatal Flaw (<=30 minutes)</option>
                                <option value="2">General Overview (<2 hrs)</option>
                                <option value="3">Thorough Review (>hrs-days)</option>
                            </select>
                        </p>
                    </div>
                </div>
                <div id="rating-content" class="rating-content">
                    <div class="spinner medium" id="loading"></div>
                </div>

                <div id="notes">
                    <label>Notes (not public): </label> <span><img style="width:11px; height:11px" id="notes_info"  class="tooltip-review" src="<?php bloginfo('template_url'); ?>/intel/images/info.png" /></span>
                    <textarea id="review-notes" name="review-notes" cols="55" rows="2" placeholder="Please Specify..."></textarea>
                </div>


            </div>
            <div class="modal-footer">
                <div class="overall-rating-div"></div>
                <p>Do you wish to submit a complaint about this report?<input type="checkbox" id="complaint-report" class="not-left-nav" name="complaint-report" /> </p>
                <div id="progress-bar">
                    <img src="images/loading_ani.gif">
                </div>
                <button id="review-submit-btn" type="submit" class="btn btn-primary">SUBMIT REVIEW</button>
                <p>Or <a id="review-save-btn"  onclick="javascript:oReview.saveReviewForLaterEdit();" href="#">save review to edit later.<a/> </p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>


<div class="modal fade bs-example-modal-sm" id="confirm-close-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                <h4 class="modal-title" id="myModalLabel">Confirm Close</h4>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to close this review without saving?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a class="btn btn-danger btn-ok" onclick="oReview.closeReview();">Yes</a>
            </div>
        </div>
    </div>
</div>


<!-- Review manually adjust overall rating -->
<div class="modal fade bs-example-modal-sm" id="manual-overall-rating-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>Please explain why you have chosen to manually adjust the overall score.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- conflict of interest -->
<div class="modal fade bs-example-modal-sm" id="conflict-of-interest-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>Please confirm that you have understood the importance of the issue of conflict of interest and that your selection is appropriate.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Yes I agree!</button>
            </div>
        </div>
    </div>
</div>

<?php

require_once('lib/lib.php');
$commodities=  getCommodityWithReviewer();
$codes=  getCodeWithReviewer();
?>
<!-- Invite All Reviewer-->
<form id="frm-invite-form" class="rsc-mi-modal" action="javascript:oInvitation.subscribe();">
    <div class="modal fade" id="invite-options-modal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close-subscribe-btn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Invite reviewer options</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div>
                            <input type="radio" name="invite_user" id="all_user" value="all" class="type_invite"/>
                            <label>All reviewers</label>
                        </div>
                        <div>
                            <input type="radio" name="invite_user" id="all_user_by" value="all" class="type_invite"/>
                            <label>All reviewers by</label>
                        </div>
                        <div class="invite_all_filter">
                            <input type="radio" name="invite_all_user" id="all_reporting_code" value="all" class="invite_filers"/>
                            <label>Experience with specific reporting code</label>
                        </div>
                        <div class="invite-all-reporting-code">
                            <select class="dropdown_style" name="invite-reporting-code" id="invite-reporting-code">
                                <?php
                                if (isset($codes)) {
                                    foreach ($codes as $data) {
                                        $id = $data['code'];
                                        ?>
                                        <option value="<?php echo $data['id']; ?>"><?php echo $data['code']; ?></option>
                                        <?php
                                    }
                                } // if
                                ?>
                            </select>
                        </div>
                        <div class="invite_all_filter">
                            <input type="radio" name="invite_all_user" id="all_stocks" value="all" class="invite_filers"/>
                            <label>Experience with specific stock markets</label>
                        </div>
                        <div class="invite-all-marketing">
                            <select class="dropdown_style" name="invite-marketing" id="invite-marketing">
                            </select>
                        </div>
                        <div class="invite_all_filter">
                            <input type="radio" name="invite_all_user" id="all_commodity_experience" value="all" class="invite_filers"/>
                            <label>Commodity experience</label>
                        </div>
                        <div class="invite-all-commodity-experience">
                            <select class="dropdown_style" name="invite-commodity-experience" id="invite-commodity-experience">
                                <?php
                                if (isset($commodities)) {
                                    foreach ($commodities as $data) {
                                        $id = $data['name'];
                                        ?>
                                        <option data-reviewers="<?php echo $data['reviewers']; ?>" value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                                        <?php
                                    }
                                } // if
                                ?>
                            </select>
                        </div>
                        <div>
                            <input type="radio" name="invite_user" id="specific_user" value="specific" class="type_invite"/>
                            <label>Specific reviewer by email</label>
                        </div>
                        <div id="hidden-feilds-invite">
                            <label id="email-hidden-invite-label" class="email-invite-hidden">Email </label>
                            <input type="text" id="email-invite-hidden-input" class="email-invite-hidden" name="email-invite-hidden">
                        </div>

                        <div>
                            <input type="radio" name="invite_user" id="specific_username" value="specific" class="type_invite"/>
                            <label>Specific reviewer by username</label>
                        </div>
                        <div class="invite_specifice_username">
                            <label>Username</label>
                            <select name="invite_username" id="invite_username" class="dropdown_style" >

                            </select>
                        </div>
                        <div id="reviewer-note-div">
                            <label>Personal message</label>
                            <textarea id="reviewers-note"></textarea>
                        </div>
                        <input name="reportId" id="reportId-invite-all" type="hidden">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="processing" style="display: inline-block; width: 16px; margin-right: 4px;">
                        <img src="images/loading_ani.gif" style="margin: 0px ! important; display: none;">
                    </div>
                    <input id="invite-submit-btn" type="button" onclick="javascript:oInvitation.checkInviteType();" class="btn btn-primary" value="SEND"/>
                    <input data-dismiss="modal" type="button" onclick="javascript:oInvitation.cancelinviteOnMap();" class="btn btn-default" value="CANCEL"/>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>

<!--complaint form-->
<form id="frm-complaint-form" enctype="multipart/form-data" action="javascript:oComplaint.submitComplaint();">
    <input type="hidden" id="complaint-report-id" name="complaint-report-id">
    <input type="hidden" id="complaint-review-id" name="complaint-review-id">
    <div class="modal fade complaint-modal" id="complaint-modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog complaint-popup" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close-complaint-show-btn" style="display: none;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <button type="button" id="close-complaint-btn" class="close" data-toggle="modal" data-target="#confirm-close-complaint-modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">REPORT COMPLAINT FORM</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>Thank you for taking the time to submit a complaint</p>

                        <h3>REPORT DETAILS</h3>
                        <table>
                            <tbody>
                            <tr>
                                <input type="hidden" id="txt-download-complaint" name="txt-download-complaint" />
                                <input type="hidden" id="txt-date-complaint" name="txt-date-complaint" />
                                <th>DATE :</th><td id="date-complaint"></td>
                            </tr>
                            <tr>
                                <input type="hidden" id="txt-company-complaint" name="txt-company-complaint" />
                                <th>Company :</th><td id="company-complaint"></td>
                            </tr>
                            <tr>
                                <input type="hidden" id="txt-project-complaint" name="txt-project-complaint" />
                                <th>PROJECT :</th><td id="project-complaint"></td>
                            </tr>
                            <tr>
                                <input type="hidden" id="txt-code-complaint" name="txt-code-complaint" />
                                <th>REPORT CODE :</th><td id="code-complaint"></td>
                            </tr>
                            <tr>
                                <input type="hidden" id="txt-type-complaint" name="txt-type-complaint" />
                                <th>REPORT TYPE :</th><td id="type-complaint"></td>
                            </tr>
                            <tr>
                                <input type="hidden" id="txt-cpqp-complaint" name="txt-cpqp-complaint" />
                                <th>CP/QP :</th><td id="cpqp-complaint"></td>
                            </tr>
                            </tbody>
                        </table>

                        <div id="complaint-confirm">
                            <p>Please confirm this is the report you wish to submit a complaint for </p>
                            <input type="checkbox" class="required not-left-nav" id="confirm-complaint-report" name="confirm-complaint-report" />
                        </div>

                        <p>Please indicate the type(s) of complaint:</p>
                        <div id="complaint-opt">

                            <div>
                                <input type="checkbox" checked class="required not-left-nav" id="non-complaint-public-report" name="non-complaint-public-report" />
                                <label>Non-compliant public report</label>
                                <p>
                                    <i>
                                        Your complaint will be submitted to relevant securities exchange(s) to which the company belongs.
                                    </i>
                                </p>
                            </div>
                            <div style="clear:both"></div>

                            <div>
                                <input type="checkbox" checked class="required not-left-nav" id="conduct-of-ethics" name="conduct-of-ethics" />
                                <label>Breach of conduct of ethics by CP/QP</label>
                                <p>
                                    <i>
                                        Your complaint will be submitted to the relevant professional organisation(s) to which the CP/QP belongs.
                                    </i>
                                </p>
                            </div>
                            <div style="clear:both"></div>

                            <div>
                                <input type="checkbox" checked class="required not-left-nav" id="claim-of-memebership" name="claim-of-memebership" />
                                <label>Incorrect claim of membership</label>
                                <p>
                                    <i>
                                        Your complaint will be submitted to relevant professional organistaion(s) to which the CP/QP has stated they belong, as well as the relevant securities exchange(s) to which the company responsible for the report belongs.
                                    </i>
                                </p>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div id="complaint-content" class="complaint-content">
                        <!--Personal Details-->
                        <div class="complaint-head">
                            <div class="expendable" id="expendable-person-detail">
                                <p>Personal Details</p>
                                <span class="expandSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-down.png"></span>
                                <span class="collapseSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-up.png"></span>
                            </div>
                            <div>
                                autofill from my profile
                                <input type="checkbox" checked class="required not-left-nav" id="auto-fill-personal" name="auto-fill-personal" />
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="slider complaint-slider" id="person-detail">
                            <p>Your personal detail are required when submitting complaints to professional organisations and securities exchanges. They will only be included in the submission of your complaint and will not be made public.</p>

                            <h3>Contact Detail</h3>
                            <div>
                                <label>Name: </label>
                                <input type="text" name="complaint-name" id="complaint-name" class="complaint-name" />
                            </div>

                            <div id="con-preferred-address">
                                <label>Preferred Address: </label>
                                <input type="text" name="preferred-address" id="preferred-address" /><br />
                                <input type="text" name="preferred-address-1" id="preferred-address-1" /><br />
                                <input type="text" name="preferred-address-2" id="preferred-address-2" />
                            </div>

                            <div>
                                <label>Preferred Email: </label>
                                <input type="text" name="complaint-email" id="complaint-email" />
                            </div>

                            <div>
                                <label>Telephone: </label>
                                <input type="text" name="complaint-telephone" id="complaint-telephone" />
                            </div>

                            <div>
                                <label>I would prefer to be contacted by: </label>
                                <select id="complaint-prefer-contacted" name="complaint-prefer-contacted">
                                    <option value="">Please choose..</option>
                                    <option value="phone">Phone</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>


                            <h3>Professional Membership</h3>

                            <!--Organisation-->
                            <div id="membership"></div>
                            <div style="clear: both; height: 2px;"></div>
                            <div id="personal-detail-opt">
                                <a href='#' onclick="javascript:oComplaint.addPersonalOrganisation();">+ add organisation</a>
                                <p> update my reviewer profile with this information </p>
                            </div>
                        </div>


                        <!--CP/QP Details-->
                        <div class="complaint-head">
                            <div class="expendable" id="expendable-cpqp-detail">
                                <p>CP/QP Details</p>
                                <span class="expandSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-down.png"></span>
                                <span class="collapseSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-up.png"></span>
                            </div>
                            <div>
                                <img src="<?php bloginfo('template_url'); ?>/intel/images/info.png" class="tooltip-complaint" id="cpqp-detail-autofill-info">
                                auto fill from database
                                <input type="checkbox" checked class="required not-left-nav" id="auto-fill-cpqp" name="auto-fill-cpqp" />
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="slider complaint-slider" id="cpqp-detail">
                            <p>
                                Please Indicate if your complaint is NOT directed at specific Competent or Qualified Persons:
                                <input type="checkbox" checked class="required not-left-nav" id="qualified-persons" name="qualified-persons" />
                            </p>
                            <br />
                            <p>Alternatively, please indicate which CPs/QPs responsible for this report, all or in part, you wish to submit a complaint about, and the type of complaint(s). </p>

                            <div id="cpqp-person"></div>
                            <div style="clear:both"></div>
                            <div id="cpqp-organisation">
                            </div>

                            <div style="clear:both;height: 5px;"></div>
                            <div>
                                submit this CP/QP's detail to help update the RSC database
                                <input type="checkbox" checked class="required not-left-nav" id="update-rsc-database" name="update-rsc-database" />
                                <img src="<?php bloginfo('template_url'); ?>/intel/images/info.png" class="tooltip-complaint" id="cpqp-submit-database-info">
                            </div>
                            <div id="cpqp-opt">
                                <div>
                                    <a href='#' onclick="javascript:oComplaint.addPersonCPQP();">+ add CP/QP</a>
                                    <img src="<?php bloginfo('template_url'); ?>/intel/images/info.png" class="tooltip-complaint" id="cpqp-add-person-info">
                                </div>

                            </div>

                        </div>

                        <!--Complaint Details-->
                        <div class="complaint-head">
                            <div class="expendable" id="expendable-complaint-detail">
                                <p>Complaint Details</p>
                                <span class="expandSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-down.png"></span>
                                <span class="collapseSlider"><img src="<?php bloginfo('template_url'); ?>/intel/images/arrow-up.png"></span>
                            </div>
                            <div></div>
                        </div>


                        <div style="clear:both"></div>
                        <div class="slider complaint-slider" id="complaint-detail">
                            <p>Please provide detailed information regarding specific allegation and/or instances of non-compliance:</p>
                            <textarea id="complaint-detail-info" name="complaint-detail-info" cols="57" rows="2" placeholder="Please describe..."></textarea>
                            <p>
                                Do you wish to submit a copy of the public report with your complaint?
                                <input type="checkbox" checked class="required not-left-nav" id="public-report-copy" name="public-report-copy" />
                            </p>
                            <p class="attachment-note">
                                * Please note that if the file is too big to send as an email attachment a hyperlink to download the file will be submitted in its place.
                            </p>

                            <br />
                            <p>
                                If you wish to submit additional evidence or supporting documentation, please briefly describe it and upload files using the link below.
                                <textarea id="complaint-additional-evidence" name="complaint-additional-evidence" cols="57" rows="2" placeholder="Please describe..."></textarea>
                            </p>

                            <input type="hidden" id="attchedFileName" name="attchedFileName" />
</form><!--End frm-complaint-form-->
<form method="post" action="lib/all.php?action=uploadAttachFile" id="uploadAttachForm" enctype="multipart/form-data">
    <input id="upload-attach-file" name="upload-attach-file" type="file" style="visibility: hidden; width: 1px; height: 1px" multiple />
    <a href="#" id="upload_link" onclick="document.getElementById('upload-attach-file').click(); return false;">+ attach file</a>
    <div id="customFileUpload" style="display: none;">Select a file</div>
</form>


</div>

</div>


</div>
<div class="modal-footer">
    <p>
        Do you consent to the relevant authorities contacting the reporting entity regarding this complaint ?
        <select id="complaint-relevant-authorities" name="complaint-relevant-authorities">
            <option>Please choose..</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </p>
    <p>You will be asked to review your complaint and consent to its submission.</p>
    <div class="progress-bar">
        <img src="images/loading_ani.gif">
    </div>
    <button id="complaint-submit-btn" type="submit" class="btn btn-primary">PROCEED WITH COMPLAINT</button>
    <!--<p>Or <a id="complaint-save-btn"  onclick="javascript:oComplaint.saveComplaintForLaterEdit();" href="#">save complaint to edit later.<a/> </p>-->
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--</form>-->


<div class="modal fade bs-example-modal-sm" id="confirm-close-complaint-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Close</h4>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to close this complaint without saving?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a class="btn btn-danger btn-ok" onclick="oComplaint.closeComplaint();">Yes</a>
            </div>
        </div>
    </div>
</div>

<!-- Complaint Thank You-->
<div class="modal fade bs-example-modal-sm" id="complaint-thankyou-modal" tabindex="-1" role="dialog" aria-labelledby="NotLoggedIn">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>Thank you for submitting the complain.</p>
            </div>
        </div>
    </div>
</div>


<script>
    // Validate Form
    $(document).ready(function(){
        $("#frm-review-form").validate({
            showErrors: function(errorMap, errorList) {
                // Clean up any tooltips for valid elements
                $.each(this.validElements(), function (index, element) {
                    var $element = $(element);
                    $element.data("title", "") // Clear the title - there is no error associated anymore
                        .removeClass("error")
                        .tooltip("destroy");
                });

                // Create new tooltips for invalid elements
                $.each(errorList, function (index, error) {
                    var $element = $(error.element);
                    $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                        .data("title", error.message)
                        .addClass("error")
                        .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
                });
            }
        });
    });
</script>