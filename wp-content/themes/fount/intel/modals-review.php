<!--Login-->
<div class="modal fade" id="login-modal" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close-login-btn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">REVIEWER LOG IN</h4>
            </div>
            <div class="modal-body">
                <div id='social-icons-conatainer'>
                    <div class='modal-body' id="L-3">
                        <img width="90" height="90" alt="avatar" class="img-circle" src="<?php bloginfo('template_url'); ?>/intel/images/upload/dummy.png">
                        <div class="error-login"> <label id="login-message" ></label></div>

                        <form id="login" action="javascript:oRsc.login()" method="post">
                            <div>
                                <div class="form-group">
                                    <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                        <input class="form-control" placeholder="Username" id="username"  name="username" type="text" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
                                        <input class="form-control" placeholder="Password" id="login-pass" name="password" type="password" value="">
                                    </div>
                                    <a href="#" class="login-link text-center" id="forgot-login" onclick="javascript:oRsc.emailpopup()">Forgot Log In?</a>
                                </div>

                            </div>
                            <div style="clear:both"></div>

                            <div id="opt-login">
                                <div class="imgProgress"><img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"></div>
                                <input name="submit" type="submit" value=" LOG IN" class="btn btn btn-primary" id="login-submit-btn">
                            </div>


                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div id="become-reviewer">
                    <label>Not on the review panel?</label>
                    <a href="signup.php">Apply</a>
                    <span>to Become a Reviewer</span>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="logedin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="L-1">
            <div class="modal-body login-modal">
                <p id="LI-2">Logged in as <label  id="uname" class="LI-A"></label></p>
                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oReview.init();" class="btn btn-success modal-login-btn" id="LI-8">CONTINUE TO NEW REPORT REVIEW</a>
                    <a href="#" onclick="javascript:oRsc.returnToMap();" class="btn btn-success modal-login-btn" id="LI-8">RETURN TO MAP</a>
                    <a href="#" onclick="javascript:oRsc.goToManageAccount();" class="btn btn-success modal-login-btn" id="LI-8">MANAGE ACCOUNT</a>
                    <a href="#" class="btn btn-success modal-login-btn" id="LI-8">SEE TRENDING REPORTS</a>
                </div>

                <div class="form-group modal-register-btn" id="LI-10">
                    <a href="#" onclick="javascript:oRsc.logout()">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="login-email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="email-forget-back">
            <div class="modal-body login-modal">
                <p id="email-heading">Log In Recovery</p>
                <div id='social-icons-conatainer'>
                    <div class='modal-body-left' id="L-3">
                        <div class="error-email"> <label id="email-message" ></label></div>
                        <form id="emailsend" action="javascript:oRsc.emailSend()" method="post">
                            <div class="email-label-input">
                                <div class="form-group" id="L-6">
                                    <label>Enter your Email:</label>
                                    <input name="email" type="text" id="email" value="" class="form-control login-field email-input-forget-password" >
                                </div>
                            </div>
                            <div>
                                <div class="imgProgressEmail"><img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"></div>
                                <input name="submit" type="submit" value=" SEND" class="btn btn-success modal-login-btn" id="email-forget-submit">
                                <a href="#" class="btn btn-success modal-login-btn" id="email-forget-cancel-button" onclick="javascript:oRsc.backtologin();">CANCEL</a>
                            </div>
                        </form>
                        <div class="error-email"> <label id="email-message" ></label></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--submit review-->
<div class="modal fade submit-review" id="submit-review-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="removed-trending-report">
            <div class="modal-body login-modal">
                <p>Thank you for submitting a review!</p>

                <p>Would you like to invite someone else to review this report?</p>
                <a class="btn loggedin-btn" href="#" onclick="javascript:oManageReview.invitationPopup();">INVITE</a>
                <p>Or would you prefer to:</p>


                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oRsc.returnToMap();" class="btn loggedin-btn">RETURN TO MAP</a>
                    <a href="#" onclick="javascript:oRsc.goToManageAccount();" class="btn loggedin-btn">MANAGE ACCOUNT</a>

                    <a href="#" onclick="javascript:oRsc.logout()" class="btn loggedin-btn">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--submit review-->
<div class="modal fade submit-review" id="submit-review-complaint-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="L-1">
            <div class="modal-body login-modal">
                <p>Thank you for submitting a review!</p>

                <p>You have indicated you would like to submit a complaint about this report to the relevant marker or regulatory body.</p>

                <p class="is-correct">Is this correct?</p>


                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oComplaint.init();" class="btn loggedin-btn">YES, TAKE ME TO COMPLAINT FORM</a>
                    <a href="#" onclick="javascript:oRsc.returnToMap();" class="btn loggedin-btn">NO (RETURN TO MAP)</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--saved review-->
<div class="modal fade submit-review" id="saved-review-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="review-saved-after-modal">
            <div class="modal-body login-modal">
                <p>Your review has been saved in your account.</p>

                <p>You can edit the saved review from your account.</p>
                <a href="#" onclick="javascript:oRsc.goToManageAccount();" class="btn loggedin-btn">MANAGE ACCOUNT</a>
                <p>Or would you prefer to:</p>


                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oInvitation.init();" class="btn loggedin-btn">INVITE</a>
                    <a href="#" onclick="javascript:oRsc.returnToMap();" class="btn loggedin-btn">RETURN TO MAP</a>


                    <a href="#" onclick="javascript:oRsc.logout()" class="btn loggedin-btn">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sign up Thank you-->
<div class="modal fade submit-review" id="thankyoumessage-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="L-1">
            <div class="modal-body login-modal">
                <p>Thank you for applying as a reviewer!</p>
                <p>We will contact you within 1 business day.</p>

                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oRsc.returnToMap();" class="btn loggedin-btn">OK (RETURN TO MAP)</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Invite Reviewer-->
<div class="modal fade" id="invite-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="inviteRevierPopupFromMap">
            <div class="modal-body login-modal">
                <p id="email-heading">Invite A Reviewer</p>
                <div id='social-icons-conatainer'>

                    <div class='modal-body-left' id="L-3">
                        <div class="error-email-invite"> <label id="email-message1" ></label></div>
                        <form id="inviteMap" action="javascript:oManageReview.invitereviewerMap()" method="post">
                            <div class="email-label-input">
                                <div class="form-group" id="L-6">
                                    <label> Email:</label>

                                    <input name="email" type="text" id="email123" value="" class="form-control login-field L-5" >
                                    <input name="reportId" id="reportId123" type="hidden">
                                </div>
                            </div>
                            <div id="button-issue">
                                <div class="imgProgressInvite"><img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"></div>
                                <input name="submit" type="submit" value=" SEND" class="btn btn-success modal-login-btn" id="inviteEmailMapButton">
                                <input type="button" class="btn btn-success modal-login-btn" id="L-66" onclick="javascript:oManageReview.backToInviteOnMap();" value="BACK">
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- invitation thankyou message-->
<div class="modal fade submit-review" id="invitationSent-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="thankyouInvitationFromMap">
            <div class="modal-body login-modal">
                <p>Thank you for inviting a fellow reviewer(s)!</p>

                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oManageReview.hideInvitationConfirmation();" class="btn loggedin-btn" id="back-btn-invitation">BACK</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- password email sent-->
<div class="modal fade submit-review" id="emailSent-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="forget_email_send">
            <div class="modal-body login-modal">
                <p>The password has been sent to you!</p>

                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oRsc.returnToLogin();" class="btn loggedin-btn">OK (RETURN TO LOGIN)</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Not Logged In-->
<div class="modal fade bs-example-modal-sm" id="not-loggedin-modal" tabindex="-1" role="dialog" aria-labelledby="NotLoggedIn">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Session Expired</h4>
            </div>
            <div class="modal-body">
                <p>Your session has expired, this window will reload automatically in 3 secs.</p>
            </div>
        </div>
    </div>
</div>

<!--Complaint Form if rating <2.5-->
<form id="lessRating" method="post">
    <input type="hidden" id="complaint-review-id-three" class="complaint-review-id" name="complaint-review-id">
    <input type="hidden" id="complaint-report-id-three" name="complaint-report-id">
    <div class="modal fade bs-example-modal-sm" id="complaint-less-rating-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm complaint-popup">
            <div class="modal-content">


                <div class="modal-body" id="complaint-form-body">
                    <p><b>Thank you for submitting a review!</b></p>

                    <p>You have submitted a review that gives a below average (<2.5 star) rating for this report.</p>
                    <p>The purpose of this review system is to encourage high standards of public reporting of exploration results, minerals resources and ore reserves. RSC attempts to contact the Competent or Qualified Persons responsible for reports that receive <2.5 star ratings to advise them of the negative review and give them an opportunity to respond prior to the review being made public. Consequently it may take a few days for your review to become available online.</p>

                    <p>Do you wish to be advised if the CP/QP responds?</p>
                    <label class="less-rating-label"> Yes</label><input class="less-rating-radio" type="radio" name="respond-cpqp" value="yes"/>
                    <label class="less-rating-label">No</label><input class="less-rating-radio" type="radio" name="respond-cpqp" value="no"/>
                    <p>Can you help us by providing contact details for the CP/QP responsible for this report?</p>
                    <label class="less-rating-label"> Yes</label><input class="less-rating-radio" type="radio" name="contact-cpqp" value="yes" id="contact-cpqp-yes"/>
                    <label class="less-rating-label">No</label><input class="less-rating-radio" type="radio" name="contact-cpqp" value="no"/><br>
                    <div><label id="name-hidden-label" class="less-hidden-label complaint-info-yes">Name: </label><input type="text" id="name-hidden" class="complaint-info-yes"  name="name-hidden"></div>
                    <div><label id="email-hidden-label" class="less-hidden-label complaint-info-yes">Email: </label><input type="text" id="email-hidden" class="complaint-info-yes" name="email-hidden"></div><br>

                    <input style="display: none;" type="button" class="btn modal-login-btn complaint-form-button" data-dismiss="modal" value="OK" id="complaint-form-close-btn" onclick="javascript:oRsc.lessRating();">
                    <input type="button" class="btn modal-login-btn complaint-form-button" value="OK" id="complaint-form-btn" onclick="javascript:oComplaint.init();">
                </div>


            </div>
        </div>
    </div>
</form>

<!--send message popup-->
<div class="modal fade submit-review" id="send-message-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="send-message-report">
            <div class="modal-body message-modal">
                <form action="" method="post" name="send_message" id="send_message" >
                    <input type="hidden" name="reviewer-email" id="reviewer-email">
                    <input type="hidden" name="report_id" id="report_id">
                    <input placeholder="Enter subject" type="text" name="subject" id="subject" value="" />
                    <textarea name="message" id="message"></textarea>

                    <div style="width: 282px;">
                        <a href="#" onclick="javascript:oMessage.sendMessage();" class="message-btn">Submit</a>
                        <a href="#" onclick="javascript:oMessage.hideMessagePopup();" class="message-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
