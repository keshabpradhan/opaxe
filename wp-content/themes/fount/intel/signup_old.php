
<button style="display:none;" id='signup-launcher' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#signup-modal">
    sign up 
</button>

<div class="modal fade" id="signup-modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    	<div class="modal-content" id="signup-form">
            <div class="modal-body login-modal">
                <p id="L-2">REVIEWER SIGN UP</p>
                <div class='modal-body-left' id="L-3">
                    <form id="signupdata" action="javascript:oRsc.signup()" method="post" >
                        <div id="left-column">
                            <div>
                                <label> First Name:</label><input name="fname" type="text" id="fname" value="" class="form-control login-field L-5 " >
                                
                            </div>
                            <div>
                                <label> Last Name:</label>
                                <input name="lname" type="text" id="lname" value="" class="form-control login-field L-5" >
                            </div>
                            <div>
                                <label> Email:</label>
                                <input name="email" type="text" id="emailSignup" value="" class="form-control login-field L-5" >
                            </div>
                            <div>
                                <label> Title:</label>
                                <input name="title" type="text" id="title" value="" class="form-control login-field L-5" >
                            </div>
                            <div>
                                <label> City:</label>
                                <input name="city" type="text" id="city" value="" class="form-control login-field L-5" >
                            </div>
                            <div id="country-div">
                                <label> Country:</label>
                                <!--form-control login-field L-5<input name="country" type="text" id="country" value="" class="form-control login-field L-5" >-->
                                <select name="country" id="country" class="dropdown_style" >
                                    
                                </select>
                            </div>
                            <div>
                                <label> Company:</label>
                                <input name="company" type="text" id="company" value="" class="form-control login-field L-5" >
                            </div>
                            <div id="experience-div">
                                <label title="Professional Experience">Experience (yr):</label>
                                <input name="experience" type="number" id="experience" value="" class="dropdown_style" min="0" max="80">
                            </div>
                            <div id="consultant-form">
                                <label> Consultant: </label>
                                &nbsp;&nbsp;&nbsp;Yes:<input name="consultant" type="radio" id="consultantyes" value="yes" class="btn-radio-signup" style="position: absolute; top: -4px;" >
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No:<input name="consultant" type="radio" id="consultantno" value="no" class="btn-radio-signup" style="position: absolute; top: -4px;">
                            </div>
                            <div id="anonymous-form">
                                <label title="If ananymous is selected then your credentials will remain hidden frm other users."> Anonymous:</label>
                                &nbsp;&nbsp;&nbsp;Yes:<input name="anonymous" type="radio" id="consultantyes" value="yes" class="btn-radio-signup" style="position: absolute; top: -4px;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No:<input name="anonymous" type="radio" id="consultantno" value="no" class="btn-radio-signup" style="position: absolute; top: -4px;">
                            </div>
                                
                        </div>
                        
                        <div id="right-column">
            

                            <div id="reporting-experience-div">
                                <label > Reporting Experience:</label>
                                <!--<input name="reporting-experience" type="number" id="reporting-experience" value="" class="form-control login-field L-5" min="0">-->
                                 <select name="reporting-experience" id="reporting-experience" class="dropdown_style" >
                                    <option value="5-10 years">5-10 years</option>
                                    <option value="10-15 years">10-15 years</option>
                                    <option value="15-20 years">15-20 years</option>
                                    <option value="20-30 years">20-30 years</option>
                                    <option value=">30 year">>30 years</option>
                                </select>
                            </div>
                            <div id="reporting-code-div">
                                <label id="reporting-code-label"> Reporting Codes:</label>
                                <!--<input name="reporting-code" type="text" id="reporting-code" value="" class="form-control login-field L-5" >-->
                            <select   multiple="multiple" placeholder="Reporting Code"  class="multiSelect" name="reporting-code[]" id="reporting-code">
                                <option value="JORC">JORC</option>
                                <option value="NI 43-101">NI 43-101</option>
                                <option value="SAMREC">SAMREC</option>
                                <option value="NAEN">NAEN</option>
                                <option value="PERC">PERC</option>
                                <option value="IIMCH">IIMCH</option>
                                <option value="MRC">MRC</option>
                                <option value="SEC IG7">SEC IG7</option>
                            </select>
</div>

                            <div id="stocks-div">
                                <label id="stocks-label"> Stock Exchanges:</label>
                                <!--<input name="stocks" type="text" id="stocks" value="" class="form-control login-field L-5" >-->
                                <select   multiple="multiple" placeholder="Stock Exchanges"  class="multiSelect" name="stocks[]" id="stocks">
                                    <option value="AIM">AIM</option>
                                    <option value="ASX">ASX</option>
                                    <option value="HKT">HKT</option>
                                    <option value="JSE">JSE</option>
                                    <option value="TSX">TSX</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input name="stocks[]" type="text" id="other"  class="form-control login-field L-5 others-stocks" style="display: none;" >
                            </div>

                            <div id="commodity-div">
                                <label> Commodity:</label> 

                               <select name="commodity-name" placeholder="Commodity"  id="commodity-name" class="dropdown_style" >
                                </select>
                            </div>
                            <div id="commodity-div">
                                <label> Experience:</label>
                                <select name="commodity-experience" id="commodity-experience" class="dropdown_style" style="width: 112px !important; background-position: 89px 7px !important;">
                                    <option value="5-10 years">5-10 years</option>
                                    <option value="10-15 years">10-15 years</option>
                                    <option value="15-20 years">15-20 years</option>
                                    <option value="20-30 years">20-30 years</option>
                                    <option value=">30 year">>30 years</option></optgroup>

                                </select>
                            </div>
                            <div class="commodity-text-area">
                                <textarea rows="4" cols="32" id="commodity" name="commodity" style="width: 302px;height: 70px;"></textarea>
                            </div>
                            <div class="biograpghy-div">
								<label> Biography:</label>
								<textarea rows="4" cols="32" id="biography" name="biography" style="width: 302px;height: 70px;"></textarea>
                            </div>
                        </div>
                        <a href="#" onclick="javascript:AddCommodity()" id="add-link-signup">Add</a>
                        <div class="imgProgressSignup"><img src="images/loading_ani.gif"></div>
                    <input name="submit" type="submit" value=" SIGN UP" class="btn btn-success modal-login-btn" id="signuprsc-button">
                    <a href="#" class="btn btn-success modal-login-btn" id="signup-cancel-button" onclick="javascript:oRsc.backtologin();">CANCEL</a>
                    </form>
                    
                          <div class="error-signup">
                 <label id="signup-message" ></label>
                 </div>
                </div>
                <div id="PPi-9">
                    <form method="post" action="lib/all.php?action=addresumefile" id="addresumeform" enctype="multipart/form-data">
                        <input type="file" id="addresume" name="resumeToUpload" style="visibility: hidden; width: 1px; height: 1px" multiple />
                        <a href="#" id="PPi-8" onclick="document.getElementById('addresume').click(); return false">Upload Resume</a><p  id="resume-label" class="LI-A"></p>
                    </form>
                </div>
                <div class="error-signup">
                 <label id="signup-message" ></label>
                 </div>
            </div>
  	</div>
    </div>
</div>

<style type="text/css">
    #reporting-code-div span {
        padding-left: 7px !important;
        padding-top: 0 !important;
    }
    .SumoSelect > .CaptionCont > span {
        padding-left: 7px !important;
        padding-top: 0 !important;
    }
</style>