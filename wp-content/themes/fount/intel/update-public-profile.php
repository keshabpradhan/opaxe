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
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
        
            // bind 'myForm' and provide a simple callback function 
            $('#addimageform').ajaxForm({ 
                 success:function(response){

                     var data = JSON.parse(response);
                     console.log(response);
                     var img =  document.createElement('img');
                     img.src = 'images/upload/'+data.pname;
                     img.className='PP-img';
                     $('#img').html(img);
                 }
            }); 
            $('#addimage').change(function() { 
            
            
                $('#addimageform').submit(); 
          });
        }); 
        
        function editprofile(){
            $('#profiledetails').hide();
            $('#profileedit').show();
        };
        
        function backtoprofile(){
            $('#profileedit').hide();
            $('#profiledetails').show();
            
        };
         
    </script> 
</head>
<body style="background-color:#ffffff;">




<div class="site-inner-wrapper">
    <?php include 'header.php';?>
    
    
    <section id="content-wrapper">
        <div class="backgroung-dashboardImg" >
                <div class ="image-text">
                    <h2 class="image-heaading">PUBLIC PROFILE</h2>
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
                        <a href="update-contact-details.php" id="RP-4">
                                Contact Details
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
        <div id="RP-2" class="public-profile">
            <div>
                <div class="RP-7">
                    PUBLIC PROFILE   &nbsp&nbsp<a href="#" id="PP-8" onclick="editprofile()">Edit</a>
                </div>

                <div id="profiledetails">
                    <table>

                            <tr class="updateprofile-row">
                                    <td class="PP-11">
                                            NAME:
                                    </td>
                                    <td class="PP-12">
                                            <?php  echo $_SESSION['firstname'];?>&nbsp<?php echo $_SESSION['lastname']; ?>
                                    </td>
                            </tr>

                            <tr class="updateprofile-row">
                                    <td class="PPi-11">
                                            BIOGRAPHY:
                                    </td>
                                    <td class="PPi-12">
                                            <?php  echo $_SESSION['biography'];?>
                                    </td>
                            </tr>
                     </table>
                </div>
                <div id="profileedit" style="display: none;">
                <form id="editprofile" action="javascript:oRsc.editprofile()" method="post">
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

                        <tr class="updateprofile-row">
                                <td class="PPi-11">
                                        BIOGRAPHY:
                                </td>
                                <td class="PPi-12">
                                        <textarea  rows="3" name="biography" value="" ><?php  echo $_SESSION['biography'];?></textarea>
                                </td>
                        </tr>
                         </table>
                    <div class="imgProgressProfile"><img src="images/loading_ani.gif"></div>
                         <input name="submit" type="submit" value="UPDATE" class="btn btn-success modal-login-btn" id="update-button">
                         <a href="#" class="btn btn-success modal-login-btn" id="update-cancel" onclick="backtoprofile();">CANCEL</a>

                    </form>
        </div>
            </div>
            <div>
                <form method="post" action="lib/all.php?action=addprofileimage" id="addimageform" enctype="multipart/form-data">
                    <div id="img"><?php echo '<img src="images/upload/'.$_SESSION['pname'].'" class="PP-img"></br>'; ?></div>
                    <input type="file" id="addimage" name="fileToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                    <?php
                        if($_SESSION['pname']){ ?>
                             <a href="#" id="PP-8" onclick="document.getElementById('addimage').click(); return false">Change Image</a>&nbsp;&nbsp;
                        <?php

                            }
                            else{?>
                                <a href="#" id="PP-8" onclick="document.getElementById('addimage').click(); return false">Add Image</a>
                            <?php }?>
                </form>
                <a href="#" id="PPD-8" onclick="javascript:oRsc.deleteImage();">Delete Image</a>

            </div>
        </div>
    </section>

</div>

<div class="footer-dashboard">
        <p>RSCMME Copyright 2015</p>
</div>
</body>
</html>