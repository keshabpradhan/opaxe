<?php if (!isset($_SESSION)) session_start();
      if (!isset($_SESSION['userid'])) header('Location: www.rscmme.com');

      require_once 'lib/login.header.php';
      require_once('lib/lib.php');
      $profile_detail=  getProfileDetail();
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

    <style type="text/css">

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
        .expendable > p {padding-top: 7px !important;}
        #complaint-report {margin-left: 7px !important;position: relative;top: 3px;}

        body {background-color: #ffffff !important;}

    </style>
    
    
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script> 
    <script src="js/jquery.cookie.min.js"></script>
    
   <script> 
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
        
            // bind 'myForm' and provide a simple callback function 
            $('#addimageform').ajaxForm({ 
                 success:function(response){

                     var data = JSON.parse(response);
                     console.log(response);
                     var img =  document.createElement('img');
                     if(data.pname){
                        img.src = 'images/upload/'+data.pname;
                     }else{
                         img.src ='images/upload/dummy.png';
                     }

                     img.className='PP-img';
                     $('#img').html(img);
                 }
            }); 
            $('#addimage').change(function() { 
            
            
                $('#addimageform').submit(); 
          });
        }); 
        
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
            $('#image-links').show();
            $('.resume_links').show();
        };
        
        function backtoprofile(){
            $('#contactedit').hide();
            $('#contactdetails').show();
            $('#image-links').hide();
            $('.resume_links').hide();
            
        };


        function showMoreOptions(){
            $('#parent_checkbox_container').hide();
            $('#more_option_container').show();
        }

        function hideMoreOptions(){
            $('#parent_checkbox_container').show();
            $('#more_option_container').hide();
        }

        /*************for future use related to 1st and 2nd checkbox****************/
       function checkboxCondition(){

           $('#daily_updates').click(function() {
               if($(this).is(':checked'))
                   $('#below_average').prop('checked', false);
               else
                   $('#below_average').prop('checked', true);
           });

           $('#below_average').click(function() {
               if($(this).is(':checked'))
                   $('#daily_updates').prop('checked', false);
               else
                   $('#daily_updates').prop('checked', true);
           });

       }

         
    </script>
</head>
<body style="background-color:#ffffff;">

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

<section id="content-wrapper">
<div id="review-panel-main">

<div id="expert-panel-paragraph">


            <div id="profile-details">

                <div style="float: left; " id="image-container">
                    <div class="manage-account-image">
                    <form method="post" action="lib/all.php?action=addprofileimage" id="addimageform" enctype="multipart/form-data">
                        <div id="img"><?php
                                            if($_SESSION['pname']){
                                                echo '<img src="images/upload/'.$_SESSION['pname'].'" class="PP-img"></br>';
                                            }else{
                                                echo '<img src="images/upload/dummy.png" class="PP-img"></br>';
                                            }
                                       ?></div>
                        <input type="file" id="addimage" name="fileToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                        <div id="image-links" style="display: none; text-align: right; margin-top: 5px; margin-bottom: 110px;">
                            <?php
                            if($_SESSION['pname']&&$_SESSION['pname']!='RP-temp.png'){ ?>
                                <a href="#" onclick="document.getElementById('addimage').click(); return false">
                                    <img src="images/edit.png" title="Change Image" alt="Change Image"/></a>&nbsp;&nbsp;
                                <a href="#" onclick="javascript:oRsc.deleteImage();">
                                    <img src="images/delete.png" title="Delete Image" alt="Delete Image"/></a>
                            <?php } else { ?>
                                <a href="#" onclick="document.getElementById('addimage').click(); return false">
                                    <img src="images/add.png" height="20px" width="20px" title="Add Image" alt="Add Image"/></a>
                            <?php }?>
                        </div>
                    </form>
                </div>
                    <div class="resume_links" style=" display: none;">
                        <?php if(isset($profile_detail['resume']) ) { ?>
                            <form style="position: absolute" method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <p  id="resume-label1" ></p><a href="#" id="update-resume-manageAccount"onclick="document.getElementById('addresume').click(); return false">Change Resume</a>
                            </form>
                        <?php }else{ ?>
                            <form method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                                <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                                <p  id="resume-label1" ></p><a href="#" id="upload-resume-manageAccount"onclick="document.getElementById('addresume').click(); return false">Upload Resume</a>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="contact-details-tabel">
                                <div class="detail_heading">PROFILE DETAILS   &nbsp&nbsp<a href="#" id="PP-8" onclick="editcontact()">Edit</a></div>

                                <div id="contactdetails">
                                    <table>

                                        <tr>
                                            <td>NAME:</td>
                                            <td><?php  echo $profile_detail['firstname'];?>&nbsp<?php echo $profile_detail['lastname']; ?></td>
                                            <td>&nbsp</td>
                                              <td>STOCK EXCHANGE:</td>
                                            <td><?php  echo $profile_detail['stocks']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>EMAIL:</td>
                                            <td><?php echo $profile_detail['email']; ?></td>
                                            <td>&nbsp</td>
                                            <td>REPORTING CODES:</td>
                                            <td><?php echo $profile_detail['reporting_code']; ?></td>
                                        </tr>

                                        <?php
                                            $diff = abs(strtotime(date('Y-m-d')) - strtotime($profile_detail['created_at']));
                                            $years = floor($diff / (365*60*60*24));
                                            $experience =  $years + $profile_detail['experience'];
                                        ?>

                                        <tr>
                                            <td>COUNTRY:</td>
                                            <td><?php  echo @$profile_detail['country']; ?></td>
                                            <td>&nbsp</td>
                                            <td>EXPERIENCE:</td>
                                            <td><?php  echo $experience.' Year(s)'; ?></td>
                                        </tr>

                                        <tr>
                                            <td>CITY:</td>
                                            <td><?php  echo @$profile_detail['city']; ?></td>
                                            <td>&nbsp</td>
                                            <td>REPORTING EXPERIENCE:</td>
                                            <td><?php  echo $profile_detail['reporting_experience']; ?></td>
                                        </tr>


                                        <tr>
                                            <td>COMPANY:</td>
                                            <td><?php echo $profile_detail['company']; ?></td>
                                            <td>&nbsp</td>
                                            <td>CONSULTANT:</td>
                                            <td><?php  echo $profile_detail['consultant']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>POSITION:</td>
                                            <td><?php echo $profile_detail['position']; ?></td>
                                            <td>&nbsp</td>
                                            <td>ANONYMOUS:</td>
                                            <td><?php  echo $profile_detail['anonymous']; ?></td>

                                        </tr>


                                        <tr>
                                            <?php if(@$profile_detail['level']){ ?>
                                                <td>LEVEL:</td>
                                                <td><?php  echo @$profile_detail['level']; ?></td>
                                            <?php }else{?>
                                                <td></td>
                                                <td></td>
                                            <?php } ?>
                                            <td>&nbsp</td>
                                            <td rowspan="1">COMMODITY:</td>
                                            <td rowspan="1" style="display: block;max-height: 80px;overflow: auto;"><?php echo $profile_detail['commodity_view']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top; padding-top: 16px;">BIOGRAPHY:</td>
                                            <td colspan="4" style="padding-top: 14px;"><p><?php  echo $profile_detail['biography'];?></p></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id="contactedit" style="display: none;">
                                    <form id="editcontacts" action="javascript:oRsc.editcontact1()" method="post">
                                        <div class="edit_main_container">
                                            <div class="left_colum" style="float:left; width: 43%; ">
                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name">First Name:</label>
                                                    <div><input class="profile-input" type="text" name="fname" value="<?php  echo $profile_detail['firstname']; ?>"/></div>
                                                </div>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name" >last name:</label>
                                                    <div><input class="profile-input" type="text" name="lname" value="<?php echo $profile_detail['lastname']; ?>"/></div>

                                                </div>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name" >email:</label>
                                                    <div ><input class="profile-input" type="text" name="email" value="<?php echo $profile_detail['email'];?>"/></div>

                                                </div>

                                                <div class="left_edit_entity_container" >
                                                    <label class="entity_name">country:</label>
                                                    <div ><select name="country" id="country" class="edit_profile_dropdown" >
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name">city:</label>
                                                    <div><input class="profile-input" type="text" name="city" value="<?php echo $profile_detail['city']; ?>"/></div>
                                                </div>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name">company:</label>
                                                    <div><input class="profile-input" type="text" name="company" value="<?php echo $profile_detail['company']; ?>"/></div>
                                                </div>

                                                <?php
                                                $diff = abs(strtotime(date('Y-m-d')) - strtotime($profile_detail['created_at']));
                                                $years = floor($diff / (365*60*60*24));
                                                $experience =  $years + $profile_detail['experience'];
                                                ?>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name">experience:</label>
                                                    <div>
                                                        <select name="experience" class="edit_profile_dropdown">
                                                            <?php for($i=0;  $i<50; $i++){
                                                                if($experience == $i){ ?>
                                                                    <option value="<?php echo $i; ?>" selected><?php echo $experience; ?></option>
                                                                <?php }else{ ?>
                                                                    <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                                                <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="left_edit_entity_container">
                                                    <label class="entity_name">position:</label>
                                                    <div><input class="profile-input" type="text" name="position" value="<?php echo $profile_detail['position']; ?>"/></div>
                                                </div>



                                            </div>

                                            <div class="right_colum" style="float: left;  width: 57%;">
                                                <div class="edit_entity_container">
                                                    <label>COMMODITY:</label>
                                                    <div>
                                                        <select style="width: 35% !important; background-position: 87% 42%;" name="commodity-name" placeholder="Commodity"  id="commodity-name" class="edit_profile_dropdown" ></select>
                                                        <select  style="width: 49% !important; background-position: 92% 42%;" name="commodity-experience" id="commodity-experience" class="edit_profile_dropdown"  style="margin-top: 0px">
                                                            <option value="5-10 years">5-10 years</option>
                                                            <option value="10-15 years">10-15 years</option>
                                                            <option value="15-20 years">15-20 years</option>
                                                            <option value="20-30 years">20-30 years</option>
                                                            <option value=">30 year">>30 years</option></optgroup></select>
                                                        <a  style="float:right; margin: 3px 1px;" href="#" onclick="javascript:AddCommodity()" >Add</a>
                                                    </div>
                                                </div>


                                                <div class="edit_entity_container">
                                                    <label></label>
                                                    <div style="height: 66px !important;"><textarea id="commodity" name="commodity" value="<?php echo $profile_detail['commodity']; ?>"><?php echo $profile_detail['commodity']; ?></textarea></div>
                                                </div>

                                                <div class="edit_entity_container">
                                                    <label>reporting code:</label>
                                                    <div><select   multiple="multiple" placeholder="<?php echo isset($profile_detail['reporting_code']) ? $profile_detail['reporting_code'] : '';?>"  class="multiSelect" name="reporting-code[]" id="reporting-code">
                                                            <option value="JORC">JORC</option>
                                                            <option value="NI 43-101">NI 43-101</option>
                                                            <option value="SAMREC">SAMREC</option>
                                                            <option value="NAEN">NAEN</option>
                                                            <option value="PERC">PERC</option>
                                                            <option value="IIMCH">IIMCH</option>
                                                            <option value="MRC">MRC</option>
                                                            <option value="SEC IG7">SEC IG7</option>
                                                        </select>
                                                        <input class="profile-input" type="text" name="reportingCode" value="<?php  echo $profile_detail['reporting_code'];?>" style="visibility: hidden; width: 1px; height: 1px"/>
                                                    </div>
                                                </div>

                                                <div class="edit_entity_container">
                                                    <label>stock exchange:</label>
                                                    <div><select   multiple="multiple" placeholder="<?php echo $profile_detail['stocks']; ?>" value="<?php echo $profile_detail['stocks']; ?>" class="multiSelect" name="stocks[]" id="stocks">
                                                            <option value="AIM">AIM</option>
                                                            <option value="ASX">ASX</option>
                                                            <option value="HKT">HKT</option>
                                                            <option value="JSE">JSE</option>
                                                            <option value="TSX">TSX</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                        <input class="profile-input" type="text" name="stockExchange" value="<?php echo $profile_detail['stocks'];?>" style="visibility: hidden; width: 1px; height: 1px"/></div>
                                                </div>

                                                <div class="edit_entity_container">
                                                    <label>anonymous:</label>
                                                    <div>
                                                        <p id="anonymous_data">
                                                            <?php if($profile_detail['anonymous'] == 'yes'){ ?>
                                                                <span>Yes:</span><input name="anonymous" type="radio" id="consultantyes" value="yes" checked class="btn-radio-signup" >
                                                                <span>No:</span><input name="anonymous" type="radio" id="consultantno" value="no" class="btn-radio-signup" >
                                                            <?php }else{ ?>
                                                                <span>Yes:</span><input name="anonymous" type="radio" id="consultantyes" value="yes" class="btn-radio-signup" >
                                                                <span>No:</span><input name="anonymous" type="radio" id="consultantno" value="no" checked class="btn-radio-signup" >
                                                            <?php } ?>
                                                        </p>
                                                    </div>
                                                </div>



                                                <?php $exp = @$profile_detail['reporting_experience'];?>
                                                <div class="edit_entity_container">
                                                    <label>reporting excperience:</label>
                                                    <div><select name="reporting-experience" id="reporting-experience" class="edit_profile_dropdown" >
                                                            <option <?php if($exp == '5-10 years '){echo("selected ");}?> value="5-10 years">5-10 years</option>
                                                            <option <?php if($exp == '10-15 years '){echo("selected ");}?>value="10-15 years">10-15 years</option>
                                                            <option <?php if($exp == '15-20 years '){echo("selected ");}?>value="15-20 years">15-20 years</option>
                                                            <option <?php if($exp == '20-30 years'){echo("selected ");}?>value="20-30 years">20-30 years</option>
                                                            <option <?php if($exp == '>30 year '){echo("selected ");}?>value=">30 year">>30 years</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="edit_entity_container">
                                                    <label>consultant:</label>
                                                    <div><?php if($profile_detail['consultant'] == 'yes'){ ?>
                                                            <p id="consultant_data">
                                                            <span>Yes:</span><input name="consultant" type="radio" id="consultantyes" value="yes" checked class="btn-radio-signup">
                                                            <span>No:</span><input name="consultant" type="radio" id="consultantyes" value="no" class="btn-radio-signup" >
                                                        <?php }else{ ?>
                                                            <span>Yes:</span><input name="consultant" type="radio" id="consultantyes" value="yes" class="btn-radio-signup" >
                                                            <span>No:</span><input name="consultant" type="radio" id="consultantyes" value="no" checked class="btn-radio-signup" >
                                                        <?php } ?></div>
                                                    </p>
                                                </div>

                                            </div>

                                            <div style="float: left; width: 100%;">
                                                <div class="edit_entity_container_bio">
                                                    <label>biography:</label>
                                                    <div><textarea  rows="6" cols="80" name="biography" value="" ><?php echo $profile_detail['biography']; ?></textarea></div>
                                                </div>

                                                <div class="checkbox_container">
                                                    <div id="parent_checkbox_container" style="display: block;">
                                                        <?php
                                                        if($profile_detail['invitation'] == 'yes' || $profile_detail['new_review_updates'] || $profile_detail['below_average']){
                                                            $checked = 'checked';
                                                        }else{
                                                            $checked = '';
                                                        }
                                                        ?>
                                                        <label><input type="checkbox" name="" id="" <?php echo $checked; ?> ></label>
                                                        <span>I would like to receive daily updates and allow registered reviewers to invite me to review a report.</span>
                                                        <span style="margin-left: 29px;"><a href="#" id="more_options" onclick="javascript:showMoreOptions();">more options</a></span>
                                                    </div>

                                                <div id="more_option_container" style="display: none;">
                                                    <div style="display: none;">
                                                        <label><input type="checkbox"  name="daily_updates" id="daily_updates" onclick=""></label>
                                                        <span>daily updates of any new reviews,</span>

                                                    </div>

                                                    <div style="display: none;">
                                                        <label><input type="checkbox" name="weekly_updates" id="weekly_updates" ></label>
                                                        <span>weekly updates of any new reviews,</span>
                                                    </div>

                                                    <div>
                                                        <?php if($profile_detail['invitation'] == 'yes'){ ?>
                                                        <label><input type="checkbox" name="invites_updates" id="invites_updates" checked></label>
                                                        <?php }else{ ?>
                                                        <label><input type="checkbox" name="invites_updates" id="invites_updates" ></label>
                                                        <?php } ?>
                                                        <span>invites from other registered reviewers to review reports.</span>
                                                        <span style="margin-left: 238px;"><a href="#" onclick="javascript:hideMoreOptions();">hide options</a></span>
                                                    </div>


                                                    <div>
                                                        <?php if($profile_detail['new_review_updates']){ ?>
                                                            <label><input type="checkbox" name="new_review_updates" id="new_review_updates" checked ></label>
                                                        <?php }else{ ?>
                                                            <label><input type="checkbox" name="new_review_updates" id="new_review_updates" ></label>
                                                        <?php } ?>
                                                        <span>whenever a new review is submitted.</span>
                                                    </div>

                                                    <div>
                                                        <?php if($profile_detail['below_average']){ ?>
                                                        <label><input type="checkbox" name="below_average" id="below_average" checked ></label>
                                                        <?php }else{ ?>
                                                        <label><input type="checkbox" name="below_average" id="below_average" ></label>
                                                        <?php } ?>
                                                        <span>only reviews which are below 2.5 average.</span>
                                                    </div>
                                                </div>

                                                </div>

                                                <div class="contact-buttons1">

                                                    <input type="button" class="btn btn-success modal-login-btn" id="updatec-button1" onclick="backtoprofile();" value="CANCEL">
                                                    <input name="submit" type="submit" value="SAVE" class="btn btn-success modal-login-btn" onclick="javascript:oRsc.editcontact1()" id="updatec-button">
                                                    <div class="imgProgressP" id="processing"><img src="images/loading_ani.gif"></div>
                                                </div>
                                            </div>
                                        </div>


                                    </form>

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
<script type="text/javascript">                  
$(document).ready(function() {
    oManageReview.init();
    //Initialize Review
    oReview.initReview();
    oRsc.populateCountriesManageProfile("<?php  echo $profile_detail['country'];?>");
    oRsc.populateCommodity();
    oInvitation.populateUsername();
});
$(document).ready(function () {

            window.multiselect = $('.multiSelect').SumoSelect()//{okCancelInMulti:true });

        });
        
 function AddCommodity(){
    var commodityName = document.getElementById('commodity-name').value;
    
    var commodityExperience = document.getElementById('commodity-experience').value;
    var concatinatedValue=commodityName+':\t'+commodityExperience;
    var commodity = document.getElementById('commodity').value;
    if(!(commodity.indexOf(commodityName) >= 0)){
        
        if(commodity){
        var finalValue=commodity+'\n'+concatinatedValue;
        }
        else{
            var finalValue=concatinatedValue;
        }
        $('#commodity').val(finalValue);
    }

};
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
                            <div class="imgProgressInvite"><img src="images/loading_ani.gif"></div>
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