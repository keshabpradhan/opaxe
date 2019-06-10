<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>RSC RESOURCE REPORTING INTELLIGENCE — RSC</title>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <?php include 'header-inc.php';?>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/site.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/custom.css?102">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/dashboard.css" />
<!--    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-1.10.2.min.js"></script>-->
<!--    <script src="<?php bloginfo('template_url'); ?>/intel/js/bootstrap.min.js"></script>-->
<!--    <script src="<?php bloginfo('template_url'); ?>/intel/js/app.js"></script>-->
<!--    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.cookie.min.js"></script>-->
   
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/bootstrap.min.css"/>

    <script src="<?php bloginfo('template_url'); ?>/intel/js/star-rating.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
   
    <style type="text/css">
        .title-desc-wrapper.no-main-image {display: none;}
        .rating-head > div {padding-bottom: 5px;padding-top: 5px;}
        #review-modal .modal-dialog {font-size: 0.9em;}
        .expendable > p {padding-top: 7px;}
        .modal-footer {padding-bottom: 7px !important;}
    </style>
</head>
<body style="background-color:#ffffff;">




<div class="site-inner-wrapper">
    <?php include 'header.php';?>
    
    
    <section id="content-wrapper">
        <div>
            <div class="backgroung-dashboardImg" >
                <div class ="image-text">
                    <h2 class="image-heaading">MANAGE REVIEWS</h2>
                </div>
            </div>

            
		<div id="RP-1">
			<div class="RP-3">
				<a href="./" id="RP-4">
					Return to Map
				</a>
			</div>

			<div class="RP-3">
				<a href="update-contact-details.php" id="RP-4">
					Update Details
				</a>
			</div>

			<div class="RP-3">
				<a href="update-public-profile.php" id="RP-4">
					Edit Profile
				</a>
			</div>

			<div class="RP-3">
				<a href="#" id="RP-4" onclick="javascript:oRsc.logoutformdashboard()">
					Logout
				</a>
			</div>
		</div>
        <div id="loggedin-div">
                Logged in as <a href="#" id="RP-8"><?php  echo $_SESSION['username']; ?></a>
        </div>

        <div id="content-div">
            <div class="review-table">

            <div id="MR-1">
            <div id="RP-5">
                <div class="RP-7">
                    SUBMITTED REVIEWS
                </div>
            </div>
        </div>

                <table id="savedreviews">
                    <div class="spinner medium" id="loading"></div>
                </table>
            </div>

            <div class="review-table">

        <div id="MR-1">
            <div id="RP-5">

                <div class="RP-7">
                    SAVED   REVIEWS
                </div>
            </div>
        </div>

                <table id="submittedReviews">
                    <div class="spinner medium" id="submittedReviews_loading"></div>
                </table>
            </div>
        </div>
    
    
</div>


    </section>
    <?php include 'review.php';?>
</div>
 <div class="footer-dashboard">
        <p>RSCMME Copyright 2015</p>
 </div> 
<script type="text/javascript">                  
$(document).ready(function() {
    oManageReview.init();
    //Initialize Review
    oReview.initReview();
});
</script>
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
                <p>Thank you for inviting a fellow reviewer!</p>

                <div id='social-icons-conatainer'>
                    <a href="#" onclick="javascript:oManageReview.hideInvitationConfirmation();" class="btn loggedin-btn" id="back-btn-invitation">BACK</a>
                </div>
            </div>
        </div>
    </div>
</div>