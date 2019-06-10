<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>RSC RESOURCE REPORTING INTELLIGENCE — RSC</title>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet" href="css/custom.css?102">
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
     <script src="js/app.js"></script>
   
    <style type="text/css">
        .main-nav ul li a span, .main-nav ul li a:visited span {font-family: sans-serif;}
        .title-desc-wrapper.no-main-image {
            display: none;
        }
    </style>
</head>
<body style="background-color:#ffffff;">




<div class="site-inner-wrapper">
    <?php include 'header.php';?>
    
    
    <section id="content-wrapper">
        <div class="dashboard-mainDiv">
            <div class="background-dashboardImg" >
                <div class ="image-text">
                    <h2 class="image-heaading">REVIEWER PORTAL</h2>
                </div>
            </div>
            <div id="dashboard-leftlinks" class="dashboard-leftlinks">
			<div>
				<a href="./">
					Return to Map
				</a>
			</div>

			<div>
				<a href="#" onclick="javascript:oRsc.logoutformdashboard()">
					Logout
				</a>
			</div>
		</div>
            <div id="dashboard-mainContent">

			<div id="RP-9">
				<div id="RP-5">

					<div class="RP-7">
						WELCOME TO THE RSC REPORT REVIEWER PORTAL
					</div>

                    <?php

                    require_once('lib/lib.php');

                    $saved_reviews=  getCompletedReview();
                    $submitted_reviews =  getSubmittedReview();
                    ?>
					You have completed <label id="RP-8"><?php echo $saved_reviews;
                                        if($saved_reviews<=1){
                                            echo ' review';
                                        }
                                        else {
                                            echo ' reviews';
                                        }
                                        ?></label> and have <label id="RP-8"><?php echo $submitted_reviews; ?> saved</label>
                                        <?php
                                        if($submitted_reviews<=1){
                                            echo 'review';
                                        }
                                        else{
                                            echo ' reviews';
                                        }
                                        ?>
                                </div>

				<div id="RP-6">
					Logged in as <label id="RP-8"><?php  echo $_SESSION['username']; ?></label>

				</div>
			</div>

			<div>

				<div id="RP-10">

					<div id="RP-11">
						<div>
							<a href="update-contact-details.php" id="RP-8"><img src="images/MetroUI-Other-Mail-icon.png"> </a>
						</div>
						<div>
							<a href="update-contact-details.php" id="RP-8">UPDATE CONTACT DETAILS</a>
						</div>
					</div>
 
				</div>

				<div id="RP-10">

					<div id="RP-11">
						<div>
                                                    <a href="update-public-profile.php" id="RP-8"><img src="images/profile.jpg"> </a>
						</div>
						<div>
							<a href="update-public-profile.php" id="RP-8">EDIT PUBLIC PROFILE</a>
						</div>
					</div>

				</div>

				<div id="RP-10">

					<div id="RP-11">
						<div>
							<a href="manage-review.php" id="RP-8"><img src="images/icon.form.png"> </a>
						</div>
						<div>
							<a href="manage-review.php" id="RP-8">MANAGE REVIEWS</a>
						</div>
					</div>

				</div>

			</div>

		</div>
        </div>
    </section>

</div>

<div class="footer-dashboard">
        <p>RSCMME Copyright 2015</p>
    </div>

</body>
</html>