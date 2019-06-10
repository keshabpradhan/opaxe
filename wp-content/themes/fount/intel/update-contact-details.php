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
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.js"></script> 
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script> 
    <script src="js/jquery.cookie.min.js"></script>
     
    <script src="js/app.js"></script>
    <style type="text/css">
        .main-nav ul li a span, .main-nav ul li a:visited span {font-family: sans-serif;}
        .title-desc-wrapper.no-main-image {
            display: none;
        }
    </style>
    <script>
        
        $(document).ready(function() { 
        
            // bind 'myForm' and provide a simple callback function 
            $('#addresumeform').ajaxForm({
                success:function(response){
                    var data=JSON.parse(response);
                    console.log(data.rname);
                    $('#resume-label1').html(data.rname);
                }
            },'json');
            $('#addresume').change(function() {
                $('#addresumeform').submit();
            });
        });
        
        function editcontact(){
            $('#contactdetails').hide();
            $('#contactedit').show();
        };
        
        function backtoprofile(){
            $('#contactedit').hide();
            $('#contactdetails').show();
            
        };
    
    </script>
</head>
<body style="background-color:#ffffff;">




<div class="site-inner-wrapper">
    <?php include 'header.php';?>
    
    
    <section id="content-wrapper">
        <div class="backgroung-dashboardImg" >
                <div class ="image-text">
                    <h2 class="image-heaading">CONTACT DETAILS</h2>
                </div>
            </div>

		<div id="RP-1">
			<div class="RP-3">
				<a href="./" id="RP-4">
					Return to Map
				</a>
			</div>

			<div class="RP-3">
				<a href="manage-review.php" id="RP-4">
					Manage Reviews
				</a>
			</div>

			<div class="RP-3">
				<a href="update-public-profile.php" id="RP-4">
					Edit Profile
				</a>
			</div>

			<div class="RP-3" onclick="javascript:oRsc.logoutformdashboard()">
				<a href="#" id="RP-4">
					Logout
				</a>
			</div>
		</div>
        <div id="loggedin-div">
            Logged in as <a href="#" id="RP-8"><?php  echo $_SESSION['username']; ?></a>
        </div>

		<div id="RP-2">

			<div id="RP-9">
				<div id="RP-5">
					<div class="PP-7">
						<div>
							CONTACT DETAILS   &nbsp&nbsp
                                                        <a href="#" id="PP-8" onclick="editcontact()">
								Edit
							</a>

							<label id="CD-1">
								&nbsp&nbsp&nbsp&nbsp These are NOT made public
							</label> 
						</div>

						<div class="CD-10" id="contactdetails">
							<table>

								<tr class="updatecontact-row">
									<td class="PP-11">
										NAME: 
									</td>
									<td class="PP-12">
										<?php  echo $_SESSION['firstname'];?>&nbsp<?php echo $_SESSION['lastname']; ?>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										AFFILIATION:
									</td>
									<td class="PP-12">
										<?php  echo $_SESSION['affiliation']; ?>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										POSITION: 
									</td>
									<td class="PP-12">
										<?php  echo $_SESSION['position']; ?>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										EMAIL:
									</td>
									<td class="PP-12">
										<?php  echo $_SESSION['email']; ?>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										CONTACT PHONE:
									</td>
									<td class="PP-12">
										<?php  echo $_SESSION['phone']; ?>
									</td>
								</tr>


                                <?php if(isset($_SESSION['resumename']) ) { ?>
								<tr class="updatecontact-row">
									<td class="PP-11">
										CV:
									</td>
									<td class="PP-12">
                                        <a href="resume/<?php echo isset($_SESSION['resumename']) ? $_SESSION['resumename'] : ''; ?>">Resume</a>
									</td>
								</tr>
                                <?php } ?>
							 </table>
						</div>
                                            
                        <div class="CD-10" id="contactedit" style="display: none;">
                            <form id="editcontacts" action="javascript:oRsc.editcontact()" method="post">
							<table>

								<tr class="updateprofile-row">
                                                                    <td class="PP-11">
                                                                            First NAME: 
                                                                    </td>
                                                                    <td class="PP-12">
                                                                        <input class="profile-input" type="text" name="fname" value="<?php  echo $_SESSION['firstname'];?>"/>
                                                                    </td>
                                                            </tr>
                                <tr class="updateprofile-row">
                                                                    <td class="PP-11">
                                                                            LAST NAME: 
                                                                    </td>
                                                                    <td class="PP-12">
                                                                        <input class="profile-input" type="text" name="lname" value="<?php echo $_SESSION['lastname']; ?>"/>
                                                                    </td>
                                                            </tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										AFFILIATION:
									</td>
									<td class="PP-12">
										<input class="profile-input" type="text" name="affiliation" value="<?php  echo $_SESSION['affiliation'];?>"/>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										POSITION: 
									</td>
									<td class="PP-12">
										<input class="profile-input" type="text" name="position" value="<?php  echo $_SESSION['position'];?>"/>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										EMAIL:
									</td>
									<td class="PP-12">
										<input class="profile-input" type="text" name="email" value="<?php  echo $_SESSION['email'];?>"/>
									</td>
								</tr>

								<tr class="updatecontact-row">
									<td class="PP-11">
										CONTACT PHONE:
									</td>
									<td class="PP-12">
										<input class="profile-input" type="text" name="phone" value="<?php  echo $_SESSION['phone'];?>"/>
									</td>
								</tr>

								<tr>
									<td class="PP-11">
										&nbsp&nbsp
									</td>
									<td class="PP-12">
										&nbsp&nbsp
									</td>
								</tr>
                                </table>
                                    <div class="contact-buttons">
                                        <div class="imgProgressContact"><img src="images/loading_ani.gif"></div>
                                    <input name="submit" type="submit" value="UPDATE" class="btn btn-success modal-login-btn" id="updatec-button">
                                     <a href="#" class="btn btn-success modal-login-btn" id="updatec-cancel" onclick="backtoprofile();">CANCEL</a>

                                    </div>
                                </form>
                                    <form method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                            <table>
								<tr class="updatecontact-row">
									<td class="PPc-11">
										CV:
									</td>
									<td class="PPc-12">
										<input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                                                                <a href="#" class="PPi-8" onclick="document.getElementById('addresume').click(); return false">Update Resume</a><p  id="resume-label1" class="LI-A"></p>
									</td>
								</tr>
                                                            </table>
                                                    </form>
                                                    
                                                </div>
					</div>
				</div>
			</div>

		</div>

    </section>

</div>

<div class="footer-dashboard">
        <p>RSCMME Copyright 2015</p>
    </div
</body>
</html>