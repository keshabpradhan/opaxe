var oManageAccount = {
    _organisation : [],
    _professionalMembershipsNumber : 1,
    _commodityNumber : 1,
    _reportingNumber : 1,
    _commodityType : [],
    _commodity : [],
    _commodityStyle : [],
    _reportingCode : [],
    _signup : false,

    _profile : [
        {id : 'profile-details-info',information : '<p>This information is collected in order for reviewers to be able to be identified and contacted by administrators of RSC-MI. If you opt to "review anonymously" none of this information will be made public, otherwise your name, company and position will be included in your public profile. Your contact details will always remain confidential.</p>'},
        {id : 'biography-info',information : '<p>Reviewer biographies are made publicly available for external users of the website to access relevant background information on our reviewers career history and experience. Please DO NOT include any information you do not wish to be made public.<br />If you have chosen to act as an anonymous reviewer then please provide a generic profile along the lines of " Reviewer has broad industry experience as resource consultant for gold, base metals and iron ore. Reviewer has been involved in large scale mining operations.."</p>'},
        {id : 'perfessional-membership-info',information : '<p>Please provide details of your current professional memberships. This information will not be made public.</p>'},
        {id : 'commodity-experience-info',information : '<p>Please provide details of your experience working on one or more commodities, particularly the ones for which you would qualify as a competent or qualified person. This information will not be made public. <br />Please break this down per mineralisation style: Au (orogenic) – 5 years, Ay (alluvial) – 4 years, Pb/Zn (MVT style) – 3 years, etc. Note that the length of your experience is cumulative.</p>'},
        {id : 'reporting-experience-info',information : '<p>Please provide details of your Code-compliant reporting experience by selecting one or more Codes or industry guidelines and indicating the numbers of years you have been taking responsibility for those reports, and to which stock exchanges they have been submitted.</p>'},
        {id : 'additional-information-info',information : '<p>If you wish to submit additional information along with your reviewer application you can attach additional files below. Resumes will be kept confidential but profile pictures will be incorporated into your online public reviewer profile (In addition to the biography you provided at the start of this form). <br />Your resume will facilitate our screening process, as we want to make sure that all registered reviewers have the relevant experience.</p>'},
        {id : 'anonymously-info',information : '<p>Let us know whether you want your public profile to be visible to the public. This means that people can read about your experience. Most company people chose to remain anonymous, and most consultants are choosing to be seen. You can change at any time.</p>'},
        {id : 'register-as-info',information : '<p>Reviewers may also be competent/qualified persons. All the information in this form is required for Reviewers. Competent/Qualified persons are encouraged to fill out as much information as possible, but as a minimum should register with an email address and should designate if they want to be contacted when their reports get reviewed.</p>'}
    ],

    _experience : [
        {id : '1', name : '<1 yr'},
        {id : '2', name : '1-5 yrs'},
        {id : '3', name : '5-10 yrs'},
        {id : '4', name : '10-15 yrs'},
        {id : '5', name : '15-30 yrs'},
        {id : '6', name : '>30 yrs'}
    ],

    _exchange : [
        {id : 'AIM', name: 'AIM'},
        {id : 'AltX', name: 'AltX'},
        {id : 'AMEX', name: 'AMEX'},
        {id : 'ASX', name: 'ASX'},
        {id : 'BVL', name: 'BVL'},
        {id : 'CSE (Can.)', name: 'CSE (Can.)'},
        {id : 'CSE (Col.)', name: 'CSE (Col.)'},
        {id : 'CVE', name: 'CVE'},
        {id : 'ESM', name: 'ESM'},
        {id : 'FRA', name: 'FRA'},
        {id : 'Frankfurt', name: 'Frankfurt'},
        {id : 'FSE', name: 'FSE'},
        {id : 'FWB', name: 'FWB'},
        {id : 'GME', name: 'GME'},
        {id : 'HKE', name: 'HKE'},
        {id : 'ISE', name: 'ISE'},
        {id : 'JSE', name: 'JSE'},
        {id : 'MOEX', name: 'MOEX'},
        {id : 'MSM', name: 'MSM'},
        {id : 'NASDAQ', name: 'NASDAQ'},
        {id : 'NASDAQ OMX', name: 'NASDAQ OMX'},
        {id : 'NSX', name: 'NSX'},
        {id : 'NYSE', name: 'NYSE'},
        {id : 'NYSE MKT', name: 'NYSE MKT'},
        {id : 'NZX', name: 'NZX'},
        {id : 'OSE', name: 'OSE'},
        {id : 'OTC', name: 'OTC'},
        {id : 'OTC Pink', name: 'OTC Pink'},
        {id : 'OTCBB', name: 'OTCBB'},
        {id : 'OTCQB', name: 'OTCQB'},
        {id : 'OTCQX', name: 'OTCQX'},
        {id : 'POMSoX', name: 'POMSoX'},
        {id : 'TSX', name: 'TSX'},
        {id : 'TSX-V', name: 'TSX-V'}
    ],

    init : function(){
        $accountDiv = $('#profile-details');
        var that = this;

        // signup page flag
        that._signup = false;

        //Check Profile Image
        this.profileImgLinks();
        //Add Profile Img without page load
        this.addProfileImg();
        // Add Resume without page load
        this.addResume();

        //Get Organisation
        this.getOrganisation();
        //Get Commodity
        this.getCommodity();
        //Get Reporting Code
        this.getReportingCode();

        //Load Reviews
        oManageReview.init();
        // Delete Record
        $accountDiv.on('click', '.deleteRecord', function(e) {
            $(this).parent().remove();
        });


        // Update Commodity
        $accountDiv.on('change', '.commodity-type-name', function(e) {
            var commodityNumber =$(this).attr('commodity-number');
            that.updateCommodityOpt(commodityNumber);
            that.updateCommodityStyleOpt(commodityNumber);
        });
        $accountDiv.on('change', '.commodity-name', function(e) {
            var commodityNumber =$(this).attr('commodity-number');
            that.updateCommodityStyleOpt(commodityNumber);
        });
    },

    signupInit: function(){

        $accountDiv = $('#content-div');
        var that = this, $anonymousDiv = $('#anonymousDiv'), $myReportReviewDiv = $('#my_report_review_div'), $myReportReview = $('#my_report_review'), $inviteFromOtherDiv = $('#invite-from-other-div'), $rscAdvisesDiv = $('#div-rsc-advises');

        // signup page flag
        that._signup = true;
        //Add Profile Img without page load
        this.addProfileImg();
        // Add Resume without page load
        this.addResume();

        //Get Organisation
        this.getOrganisation();

        //Get Commodity
        this.getCommodity();
        //Get Reporting Code
        this.getReportingCode();

        //show info text
        this.signupInfo();
        // Delete Record
        $accountDiv.on('click', '.deleteRecord', function(e) {
            $(this).parent().remove();
        });


        // Register As
        $('.register_as').on('click', function(e) {

            if(this.id  == 'register_as_cpqp'){
                $anonymousDiv.hide();
                $myReportReviewDiv.show();
                $myReportReview.prop('checked',true);

                //Hide Invite From Other Reviewer Div
                $inviteFromOtherDiv.hide();
                // uncheck option
                // First 3 option select by default
                $('#invites_updates').prop('checked',false);
                $('#new_review_updates').prop('checked',false);
                $('#summery_report_check').prop('checked',false);
                // Hide Rsc advises section
                $rscAdvisesDiv.hide();
            }else{
                $anonymousDiv.show();
                $myReportReviewDiv.hide();
                $myReportReview.prop('checked',false);
                // First 3 option select if register as reviewer
                $('#invites_updates').prop('checked',true);
                $('#new_review_updates').prop('checked',true);
                $('#summery_report_check').prop('checked',true);


                //Show Invite From Other Reviewer Div
                $inviteFromOtherDiv.show();
                // Hide Rsc advises section
                $rscAdvisesDiv.show();
            }

        });

        // Update Commodity
        $accountDiv.on('change', '.commodity-type-name', function(e) {
            var commodityNumber =$(this).attr('commodity-number');
            that.updateCommodityOpt(commodityNumber);
            that.updateCommodityStyleOpt(commodityNumber);
        });
        $accountDiv.on('change', '.commodity-name', function(e) {
            var commodityNumber =$(this).attr('commodity-number');
            that.updateCommodityStyleOpt(commodityNumber);
        });


    },

    identifyNewReviewCheck :function(){
        if($('input.below_average').attr('checked', true)){
            $('input.below_average').attr('checked', false);
        }
    },

    identifyBlowAvegCheck: function(){
        if($('input.new_review_updates').attr('checked', true)) {
            $("input.new_review_updates").attr('checked', false);
        }
    },

    signupInfo : function(){
        // Info Link
        var that = this, id;
        var $div = $("div.signup-info-popup");
        var $modal = $('#singup_container');
        $modal.on('mouseover', '.tooltip-complaint', function() {
            id = this.id;

            var position = $(this).offset();
            var top =position.top - $(document).scrollTop() - 8;
            var left =position.left + 25;
            $div.css({'top': top, 'left': left, 'display': 'inline', 'z-index':999999, 'width':'30%'} );

            var complaintInfo = oReview.getObjById(that._profile,id);
            complaintInfo = complaintInfo[0];
            var popupContent = '<img class="callout" src="images/arrow.png" />';
            popupContent += '<div>';
            popupContent += complaintInfo.information;
            popupContent += '</div>';
            $div.html(popupContent);
        });

        $modal.on('mouseout', '.tooltip-complaint', function(){
            that.closeInfoPopup();
        });

    },

    closeInfoPopup : function() {
        $("div.signup-info-popup").hide();
    },

    signup : function(){
        $(".signupProgressBar img").show();
        if (this.validatesignup()){
            $(".signupProgressBar img").show();
            $('#signup-message').hide();
            var $popupContent = $('#registered_as_content');

            var fields = $('#singup_container :input').serialize();
            var url = SCRIPT_PATH + '?action=addPersonalDetails';
            $.post(url, fields, function(response){
                if(response.success){
                    // Show Thanku popup
                    if($("input[name=register_as]:checked").val() == 'cpqp')
                        $popupContent.html('Thank you. You are now registered as a Competent/Qualified Person on RSC-MI.');
                    else
                        $popupContent.html('Thank you for applying to become a reviewer on RSC-MI. After your application has been reviewed by our team you will be issued a username and password. Usually this happens within one business day.');

                    $('#registration-thankyou-modal').modal('show');
                    setTimeout(function(){
                        $('#registration-thankyou-modal').modal('hide');
                        window.location.replace(BASE_URL);
                    },10000);
                }else{
                    $('html, body').animate({scrollTop: 50}, 500);
                    $('#signup-message').show();
                    $('#email').css('border', '1px solid #b30011');
                    $('#signup-message').text("This email id is already registered.");
                    $(".signupProgressBar img").hide();
                }
            },'json');
        }else{
            $(".signupProgressBar img").hide();
            $('#signup-message').show();
            $('html, body').animate({scrollTop: 50}, 500);
        }
    },

    validatesignup : function(){

        $('.signup-input').css('border', '');

        var register_as_cpqp,register_as_reviewer,fname,lname,company,position,city,email,biography,country,register_as_div,rsc_advises;
        var membership_div,organistation_name,membership_no;
        var commodity_div,commodity_name,commodity_experience;
        var reporting_div,reporting_name,reporting_experience;

        register_as_cpqp = document.getElementById('register_as_cpqp').checked;
        register_as_reviewer = document.getElementById('register_as_reviewer').checked;
        fname = $('#fname');
        lname = $('#lname');
        company = $('#company');
        position = $('#position');
        city = $('#city');
        email = $('#email');
        biography = $('#biography');
        country = $('#country');
        register_as_div = $('#register-as-div');
        rsc_advises = $('#div-rsc-advises');
        membership_div = $('#perfessional-membership-edit');
        organistation_name = $('#organistation-name-1');
        membership_no = $('#membership-no-1');

        commodity_div = $('#commodity-experience-edit');
        commodity_name = $('#commodity-type-name-1');
        commodity_experience = $('#commodity-experience-1');

        reporting_div = $('#reporting-exprience-edit');
        reporting_name = $('#reporting-code-1');
        reporting_experience = $('#reporting-experience-1');

        // Reset Fillter
        fname.css('border', '');
        lname.css('border', '');
        company.css('border', '');
        position.css('border', '');
        city.css('border', '');
        email.css('border', '');
        biography.css('border', '');
        country.css('border', '');
        register_as_div.css('border', '');
        rsc_advises.css('border', '');
        membership_div.css('border', '');
        organistation_name.css('border', '');
        membership_no.css('border', '');
        commodity_div.css('border', '');
        commodity_name.css('border', '');
        commodity_experience.css('border', '');
        reporting_div.css('border', '');
        reporting_name.css('border', '');
        reporting_experience.css('border', '');

        if (fname.val() == null || fname.val() == "") {
            fname.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your First Name.");
            return false;
        }else if(lname.val() == null || lname.val() == ""){
            lname.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Last Name.");
            return false;
        }else if(company.val() == null || company.val() == ""){
            company.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Company.");
            return false;
        }else if((position.val() == null || position.val() == "") && (register_as_cpqp == false)){
            position.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Position.");
            return false;
        }else if((city.val() == null || city.val() == "") && (register_as_cpqp == false)){
            city.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your City.");
            return false;
        }else if (country.val() == null || country.val() == "") {
            country.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Country.");
            return false;
        }else if (email.val() == null || email.val() == "") {
            email.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Email Address.");
            return false;
        }else if ((biography.val() == null || biography.val() == "") && (register_as_cpqp == false)) {
            biography.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter your Biography.");
            return false;
        }else if ($("input[name=register_as]:checked").length <= 0) {
            register_as_div.css('border', '1px solid #b30011');
            $('#signup-message').text("Please choose Register as.");
            return false;
        }else if((organistation_name.val() == null || organistation_name.val() == "") && (register_as_reviewer == true)){
            membership_div.css('border', '1px solid #b30011');
            organistation_name.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select Organisation.");
            return false;
        }else if((membership_no.val() == null || membership_no.val() == "") && (register_as_reviewer == true)){
            membership_div.css('border', '1px solid #b30011');
            membership_no.css('border', '1px solid #b30011');
            $('#signup-message').text("Please enter Membership No.");
            return false;
        }else if((commodity_name.val() == null || commodity_name.val() == "") && (register_as_reviewer == true)){
            commodity_div.css('border', '1px solid #b30011');
            commodity_name.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select Commodity");
            return false;
        }else if((commodity_experience.val() == null || commodity_experience.val() == "") && (register_as_reviewer == true)){
            commodity_div.css('border', '1px solid #b30011');
            commodity_experience.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select Commodity Experience.");
            return false;
        }else if((reporting_name.val() == null || reporting_name.val() == "") && (register_as_reviewer == true)){
            reporting_div.css('border', '1px solid #b30011');
            reporting_name.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select Reporting Code.");
            return false;
        }else if((reporting_experience.val() == null || reporting_experience.val() == "") && (register_as_reviewer == true)){
            reporting_div.css('border', '1px solid #b30011');
            reporting_experience.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select Reporting Experience.");
            return false;
        }else if ($("input[name=rsc-advises]:checked").length <= 0 && (register_as_reviewer == true)) {
            rsc_advises.css('border', '1px solid #b30011');
            $('#signup-message').text("Please select term and condition.");
            return false;
        }
        return true;
    },

    uploadResume : function(){
        $('#addresumeform').ajaxForm({
            success:function(response){
                var data= JSON.parse(response);
                $('#resume-label').html(data.rname);
            }
        },'json');
        $('#addresume').change(function() {
            $('#addresumeform').submit();
        });
    },

    updateCommodityOpt : function(commodity){
        // Populate Select options
        var input = $('#commodity-name-'+commodity);
        input.html('');
        var type = $('#commodity-type-name-'+commodity).val();
        $.each(this._commodity, function(i, val){
            if(val.type_id == type)
                input.append('<option value="'+val.id+'">'+val.name+'</option>');
        });
    },

    updateCommodityStyleOpt : function(commodity){
        // Populate Select options
        var input = $('select#commodity-style-'+commodity);
        var textInput = $('input#commodity-style-'+commodity);
        input.html('');
        var type = $('#commodity-name-'+commodity).val();
        var text = $('#commodity-name-'+commodity+' option:selected').text();
        if(text == 'Other…'){
            input.append('<option value=""></option>');
            input.css({'visibility': 'hidden', 'position': 'absolute'});
            textInput.css('display','inline-block');
        }else{
            input.css({'visibility': 'visible', 'position': 'relative'});
            textInput.css('display','none');
            $.each(this._commodityStyle, function(i, val){
                if(val.commodity_id == type)
                    input.append('<option value="'+val.name+'">'+val.name+'</option>');
            });
        }

    },

    showSelectOpt : function(data, container){
        // Populate Select options
        var input = $(container);
        input.val('');
        //input.append('<option>Please choose..</option>');
        $.each(data, function(i, val){
            input.append('<option value="'+val.id+'">'+val.name+'</option>');
        });
    },

    getOrganisation : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getOrganisation";
        $.post(url, function(response){
            if(response.success && response.organisation){
                that._organisation = response.organisation;

                //Membership
                (that._signup === true) ? that.loadProfessionalMembership() : that.loadUserProfessionalMembership();

            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    getUserOrganisation : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getUserOrganisation";
        $.post(url, function(response){
            if(response.success && response.organisation){
                _UserProfessionalMemberships = response.organisation;
                //Membership
                (that._signup === true) ? that.loadProfessionalMembership() : that.loadUserProfessionalMembership();
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    getCommodity : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getCommodity";
        $.post(url, function(response){
            if(response.success && response.commodity){
                that._commodityType = response.commodity_type;
                that._commodity = response.commodity;
                that._commodityStyle = response.commodity_style;

                //Commodity
                (that._signup === true) ? that.loadCommodity() : that.loadUserCommodity();

            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    getUserCommodity : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getUserCommodity";
        $.post(url, function(response){
            if(response.success && response.commodity){
                _UserCommodityExperience = response.commodity;
                //Commodity
                (that._signup === true) ? that.loadCommodity() : that.loadUserCommodity();
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    getReportingCode : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getReportingCode";
        $.post(url, function(response){
            if(response.success && response.code){
                that._reportingCode = response.code;
                //Reporting
                (that._signup === true) ? that.loadReporting() : that.loadUserReporting();
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    getUserReportingCode : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getUserReportingCode";
        $.post(url, function(response){
            if(response.success && response.code){
                _UserReportingExperience = response.code;
                //Reporting
                (that._signup === true) ? that.loadReporting() : that.loadUserReporting();
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    addProfileImg : function(){
        $('#addimageform').ajaxForm({
            success:function(response){
                var data = JSON.parse(response);
                var img =  document.createElement('img');
                if(data.pname){
                    $('#profile-img-links').show();
                    $('#add-profile-img-link').hide();
                    img.src = 'images/upload/'+data.pname;
                    $('#profile_').text(' ( '+data.pname+' )').show();
                    $('#no_profile').hide();
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
    },

    addResume : function(){
        var that = this;
        $('#addresumeform').ajaxForm({
            success:function(response){
                var response = JSON.parse(response);
                if(response.rname && that._signup === true){
                    $('#reusme').text(' ( '+response.rname+' )').show();
                    $('#no-reusme').hide();
                }else{
                    location.reload();
                }

            }
        },'json');

        $('#addresume').change(function() {
            $('#addresumeform').submit();
        });
    },

    profileImgLinks : function(){
        var img = $.cookie('pname');
        if(img == 'RP-temp.png'){
            $('#profile-img-links').hide();
            $('#add-profile-img-link').show();
        }else{
            $('#profile-img-links').show();
            $('#add-profile-img-link').hide();
        }
    },

    showPersonalDetails : function(){
        $('#personal-details').show();
        $('#personal-details-edit').hide();
        $('#edit-personal-detail-link').show();
    },

    editPersonalDetails : function(){
        $('#personal-details').hide();
        $('#personal-details-edit').show();
        $('#edit-personal-detail-link').hide();

        // Hide Other section
        this.showPerfessionalMembership();
        this.showCommodityExp();
        this.showReportingExp();
        this.showNotification();
    },

    showNotification : function(){
        $('#notification-edit').hide();
        $('#notification-view').show();
    },

    editNotification : function(){
        var $editDiv = $("#notification-edit");
        $editDiv.show();
        $('#notification-view').hide();

        // Hide Other section
        this.showPerfessionalMembership();
        this.showCommodityExp();
        this.showReportingExp();
        // Scroll to editable div
        $('html, body').animate({scrollTop: $editDiv.offset().top - 120}, 1000);
    },

    showPerfessionalMembership : function(){
        $('#perfessional-membership-view').show();
        $('#perfessional-membership-edit').hide();
    },

    editPerfessionalMembership : function(){
        var $editDiv = $("#perfessional-membership-edit");
        $editDiv.show();
        $('#perfessional-membership-view').hide();

        // Hide Other section
        this.showCommodityExp();
        this.showReportingExp();
        this.showNotification();
        // Scroll to editable div
        $('html, body').animate({scrollTop: $editDiv.offset().top - 120}, 1000);
    },

    showCommodityExp : function(){
        $('#commodity-experience-view').show();
        $('#commodity-experience-edit').hide();
    },

    editCommodityExp : function(){
        var $editDiv = $("#commodity-experience-edit");
        $editDiv.show();
        $('#commodity-experience-view').hide();

        // Hide Other section
        this.showPerfessionalMembership();
        this.showReportingExp();
        this.showNotification();
        // Scroll to editable div
        $('html, body').animate({scrollTop: $editDiv.offset().top - 120}, 1000);
    },

    showReportingExp : function(){
        $('#reporting-exprience-view').show();
        $('#reporting-exprience-edit').hide();
    },

    editReportingExp : function(){
        var $editDiv = $("#reporting-exprience-edit");
        $editDiv.show();
        $('#reporting-exprience-view').hide();

        // Hide Other section
        this.showPerfessionalMembership();
        this.showCommodityExp();
        this.showNotification();
        // Scroll to editable div
        $('html, body').animate({scrollTop: $editDiv.offset().top - 120}, 1000);
    },

    addPerfessionalMemberships : function(){
        var that = this;
        var fields = $('#professionalMembership :input').serialize();
        $(".processing img").show();
        var url = SCRIPT_PATH + '?action=addPerfessionalMemberships';
        $.post(url, fields, function(response){
            if(response.success || response.update){
                that.showPerfessionalMembership();
                that.getUserOrganisation();
            }else{
                // Todo: Display error msg
            }
            $(".processing img").hide();
        },'json');
    },


    deleteResume : function(){
        var url = SCRIPT_PATH + '?action=deleteResume';
        $.post(url, function(response){
            if(response.success){
                location.reload();
            }
        },'json');
    },

    deleteImage : function(){
        var img =  document.createElement('img');
        img.src = 'images/upload/RP-temp.png';
        img.className='PP-img';
        $('#img').html(img);
        $('#profile-img-links').hide();
        $('#add-profile-img-link').show();
        var url = SCRIPT_PATH + '?action=deleteimage';
        $.post(url, function(response){
        },'json');
    },

    updatePersonalDetails : function(){
        $(".processing img").show();
        var fields = $('#personal-details-edit :input').serialize();
        var url = SCRIPT_PATH + '?action=editPersonalDetails';
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                that.getUpdatePersonalDetails();
                that.showPersonalDetails();
            }else{
                // Todo: Display error msg
            }
            $(".processing img").hide();
        },'json');
    },

    getUpdatePersonalDetails : function(){
        var that = this, detail, name,freInvite,freNewReview,freSummaryReport;
        var url = SCRIPT_PATH + "?action=getUpdatePersonalDetails";
        $.post(url, function(response){
            if(response.success && response.personal_detail){
                detail = response.personal_detail;
                // Set View Details
                name = detail.firstname + ' ' + detail.lastname;
                $('#ma-name').html(name);
                $('#ma-company').html(detail.company);
                $('#ma-position').html(detail.position);
                $('#ma-city').html(detail.city);
                $('#ma-country').html(detail.country);
                $('#ma-email').html(detail.email);
                $('#ma-biography').html(detail.biography);
                // Set Edit Value
                $('#ma-fname').val(detail.firstname);
                $('#ma-lname').val(detail.lastname);
                $('#ma-edit-company').val(detail.company);
                $('#ma-edit-position').val(detail.position);
                $('#ma-edit-city').val(detail.city);
                $('#country').prop('checked',detail.country);
                $('#ma-edit-email').val(detail.email);
                $('#ma-edit-biography').val(detail.biography);
                $('#rsc-advises').prop('checked',detail.rsc_advises);

                // Set Notification
                if(detail.invitation == 'yes'){
                    $('#invites_updates').prop('checked',true);
                    freInvite = '(' +detail.invitation_frequency+ ')';
                }else{
                    $('#invites_updates').prop('checked',false);
                    freInvite= '';
                }
                $('#invites_freq').val(detail.invitation_frequency);
                $('#view_invites_updates').html('invites from other registered reviewers to review reports'+freInvite+'.');
                // new review
                $('#new_review_updates').prop('checked',detail.new_review_updates);
                $('#new_review_freq').val(detail.new_review_frequency);
                freNewReview = (detail.new_review_updates) ? '(' +detail.new_review_frequency+ ')' : '';
                $('#view_new_review_updates').html('whenever a new review is submitted'+freNewReview+'.');
                // summary of report
                $('#summery_report_check').prop('checked',detail.summery_report);
                $('#summery_report_freq').val(detail.summery_report_frequency);
                freSummaryReport = (detail.summery_report) ? '(' +detail.summery_report_frequency+ ')' : '';
                $('#view_summery_report_check').html('summary of new reports'+freSummaryReport+'.');
                // Below Average
                $('#below_average').prop('checked',detail.below_average);
                // My Report Review
                $('#my_report_review').prop('checked',detail.my_report_review);








            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    updateNotification : function(){
        $(".processing img").show();
        var fields = $('#notification-edit :input').serialize();
        var url = SCRIPT_PATH + '?action=editNotification';
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                that.getUpdatePersonalDetails();
                that.showNotification();
            }else{
                // Todo: Display error msg
            }
            $(".processing img").hide();
        },'json');
    },

    loadUserProfessionalMembership : function(){
        var that =this, membership,$viewDiv = $('#professionalMembershipView'), viewHTML ='', membershipHTML = '';
        // Refresh DOM
        $('#professionalMembership').html('');
        $viewDiv.html('');
        $.each(_UserProfessionalMemberships, function(i, val){
            membership = that._professionalMembershipsNumber;
            that.loadProfessionalMembership();
            // Organistaion
            $("#organistation-name-"+membership+" option").filter(function() {
                return $(this).val() == val.organisation_id;
            }).prop('selected', true);
            // Membership No.
            $("#membership-no-"+membership).val(val.membership_no);
            // Member
            $("#member-"+membership).prop('checked', val.member);
            // Fellow
            $("#org-fellow-"+membership).prop('checked', val.fellow);
            // CP
            $("#org-cp-"+membership).prop('checked', val.cp);
            // RPGeo
            $("#org-rp-"+membership).prop('checked', val.rpgeo);
            // Other membership
            $("#membership-other-"+membership).prop('checked', val.membership);
            $("#org-other-"+membership).val(val.other);

            // Membership
            membershipHTML = '';
            if(val.member)
                membershipHTML +=  ' Member,';
            if(val.fellow)
                membershipHTML +=  ' Fellow,';
            if(val.cp)
                membershipHTML +=  ' Cp,';
            if(val.rpgeo)
                membershipHTML +=  ' RPGeo,';
            if(val.membership)
                membershipHTML +=  'Other: ';
            if(val.other)
                membershipHTML +=  val.other;

            membershipHTML = membershipHTML.replace(/^,|,$/g,'');
            membershipHTML = $.trim(membershipHTML);
            // View
            viewHTML +=  '<label>';
            viewHTML += val.org_name +',';
            viewHTML +=  'Membership No. ' +val.membership_no+',';
            if(membershipHTML != '')
                viewHTML +=  '(' + membershipHTML + ')';

            viewHTML +=  '</label><br>';

            $viewDiv.html(viewHTML);
        });
    },

    loadProfessionalMembership : function(){
        var option;
        var mainDiv = document.getElementById('professionalMembership');
        var div = document.createElement('div');
        var labelOrganistaion=document.createElement('label');
        labelOrganistaion.innerHTML='Organisation: &nbsp;';

        var selectOrganistation=document.createElement('select');
        selectOrganistation.className = 'organistation-name';
        selectOrganistation.id = 'organistation-name-'+this._professionalMembershipsNumber;
        selectOrganistation.name = 'organistation-name[]';
        // Default value
        option = this.selectDefaultValue();
        selectOrganistation.appendChild(option);
        //Create and append the options
        $.each(this._organisation, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectOrganistation.appendChild(option);
        });
        //selectOrganistation.className='dropdown_style';

        div.appendChild(labelOrganistaion);
        div.appendChild(selectOrganistation);

        var labelMembershipNo=document.createElement('label');
        labelMembershipNo.innerHTML='&nbsp;&nbsp;Membership No.: &nbsp;';

        var inputMembership=document.createElement('input');
        inputMembership.id = 'membership-no-'+this._professionalMembershipsNumber;
        inputMembership.className='professionalMembershipInput';
        inputMembership.name = 'membership-no[]';

        div.appendChild(labelMembershipNo);
        div.appendChild(inputMembership);

        var labelMembership=document.createElement('label');
        labelMembership.className = 'pm-membership';
        labelMembership.innerHTML='Membership:';
        div.appendChild(labelMembership);

        var count = $('#professionalMembership div').length;
        // Member
        var inputMember =document.createElement('input');
        inputMember.type ='checkbox';
        inputMember.id = 'member-'+this._professionalMembershipsNumber;
        inputMember.name = 'member['+count+']';
        var labelMember=document.createElement('label');
        labelMember.innerHTML='&nbsp;Member &nbsp;';
        labelMember.className='checkboxLabel';
        div.appendChild(inputMember);
        div.appendChild(labelMember);
        // Fellow
        var inputFellow =document.createElement('input');
        inputFellow.type ='checkbox';
        inputFellow.id = 'org-fellow-'+this._professionalMembershipsNumber;
        inputFellow.name = 'org_fellow['+count+']';
        var labelFellow=document.createElement('label');
        labelFellow.innerHTML='&nbsp;Fellow &nbsp;';
        labelFellow.className='checkboxLabel';
        div.appendChild(inputFellow);
        div.appendChild(labelFellow);
        // CP
        var inputCp =document.createElement('input');
        inputCp.type ='checkbox';
        inputCp.id = 'org-cp-'+this._professionalMembershipsNumber;
        inputCp.name = 'org_cp['+count+']';
        var labelCp=document.createElement('label');
        labelCp.innerHTML='&nbsp;CP &nbsp;';
        labelCp.className='checkboxLabel';
        div.appendChild(inputCp);
        div.appendChild(labelCp);
        // RPGeo
        var inputRp =document.createElement('input');
        inputRp.type ='checkbox';
        inputRp.id = 'org-rp-'+this._professionalMembershipsNumber;
        inputRp.name = 'org_rp['+count+']';
        var labelRp=document.createElement('label');
        labelRp.innerHTML='&nbsp;RPGeo &nbsp;';
        labelRp.className='checkboxLabel';
        div.appendChild(inputRp);
        div.appendChild(labelRp);
        // Other
        var inputOther =document.createElement('input');
        inputOther.type ='checkbox';
        inputOther.id = 'membership-other-'+this._professionalMembershipsNumber;
        inputOther.name = 'membership-other['+count+']';
        var labelOther=document.createElement('label');
        labelOther.innerHTML='&nbsp;Other &nbsp;';
        labelOther.className='checkboxLabel';
        var inputOtherText=document.createElement('input');
        inputOtherText.className='professionalMembershipInput';
        inputOtherText.id = 'org-other-'+this._professionalMembershipsNumber;
        inputOtherText.name = 'org_other[]';
        div.appendChild(inputOther);
        div.appendChild(labelOther);
        div.appendChild(inputOtherText);

        var aDeleteRow=document.createElement('a');
        aDeleteRow.innerHTML='&nbsp;<img src="images/delete.png" title="Delete" alt="Delete"/>';
        aDeleteRow.className='linkEditAccount deleteRecord';

        if(this._professionalMembershipsNumber > 1)
            div.appendChild(aDeleteRow);

        mainDiv.appendChild(div);

        this._professionalMembershipsNumber += 1;
    },

    loadUserCommodity : function(){
        var that =this, commodity, $viewDiv = $('#commodityExperienceDivView'), viewHTML = '', exp;
        // Refresh DOM
        $('#commodityExperienceDiv').html('');
        $viewDiv.html('');
        $.each(_UserCommodityExperience, function(i, val){
            commodity = that._commodityNumber;
            that.loadCommodity();
            // commodity-type
            $("#commodity-type-name-"+commodity+" option").filter(function() {
                return $(this).val() == val.type_id;
            }).prop('selected', true);
            // commodity
            that.updateCommodityOpt(commodity);
            $("#commodity-name-"+commodity+" option").filter(function() {
                return $(this).text() == val.name;
            }).prop('selected', true);
            // commodity-style
            that.updateCommodityStyleOpt(commodity);
            var text = $('#commodity-name-'+commodity+' option:selected').text();
            if(text == 'Other…'){
                $('input#commodity-style-'+commodity).val(val.style);
            }else{
                $("#commodity-style-"+commodity+" option").filter(function() {
                    return $(this).text() == val.style;
                }).prop('selected', true);
            }
            // experience
            $("#commodity-experience-"+commodity+" option").filter(function() {
                return $(this).val() == val.experience;
            }).prop('selected', true);
        });

        // View Commodity
        var commodityView = this.groupBy(_UserCommodityExperience, function(item){return [item.type_id];});
        $.each(commodityView, function(i, commodityType){
            viewHTML +=  '<label>';
            if(commodityType[0].type)
                viewHTML += commodityType[0].type;
            viewHTML +=  '</label><br>';

            $.each(commodityType, function(i, val){
                viewHTML +=  '<label style="padding-left: 2em">';
                if(val.name)
                    viewHTML += val.name;
                if(val.style)
                    viewHTML += '('+val.style+')';
                if(val.experience){
                    exp = oReview.getObjById(that._experience,val.experience);
                    viewHTML += ','+ exp[0].name;
                }
                viewHTML +=  '</label><br>';
            });

            $viewDiv.html(viewHTML);
        });
    },

    groupBy : function( array , f ){
        var groups = {};
        array.forEach( function( o ){
            var group = JSON.stringify( f(o) );
            groups[group] = groups[group] || [];
            groups[group].push( o );
        });
        return Object.keys(groups).map( function( group ){
            return groups[group];
        });
    },

    loadCommodity : function(){
        var mainDiv = document.getElementById('commodityExperienceDiv');
        var div = document.createElement('div');
        var option;
        var labelType=document.createElement('label');
        labelType.innerHTML='Type: &nbsp;';
        var selectType=document.createElement('select');
        selectType.id = 'commodity-type-name-'+this._commodityNumber;
        selectType.className = 'commodity-type-name';
        selectType.name = 'commodity-type-name[]';
        selectType.setAttribute('commodity-number', ''+this._commodityNumber+'');
        // Default value
        option = this.selectDefaultValue();
        selectType.appendChild(option);
        //Create and append the options
        $.each(this._commodityType, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectType.appendChild(option);
        });
        //selectType.className='dropdown_style';

        div.appendChild(labelType);
        div.appendChild(selectType);

        var labelCommodity=document.createElement('label');
        labelCommodity.innerHTML='&nbsp;&nbsp;&nbsp;&nbsp;Commodity: &nbsp;';
        var selectCommodity=document.createElement('select');
        selectCommodity.id = 'commodity-name-'+this._commodityNumber;
        selectCommodity.className = 'commodity-name';
        selectCommodity.name = 'commodity-name[]';
        selectCommodity.setAttribute('commodity-number', ''+this._commodityNumber+'');
        //Create and append the options
        $.each(this._commodity, function(i, val){
            if(val.type_id == selectType.value){
                option = document.createElement("option");
                option.value = val.id;
                option.text = val.name;
                selectCommodity.appendChild(option);
            }
        });
        //selectCommodity.className='dropdown_style';

        div.appendChild(labelCommodity);
        div.appendChild(selectCommodity);

        var labelStyle=document.createElement('label');
        labelStyle.innerHTML='&nbsp;&nbsp;&nbsp;&nbsp;Style: &nbsp;';
        var selectStyle=document.createElement('select');
        selectStyle.id = 'commodity-style-'+this._commodityNumber;
        selectStyle.className = 'commodity-style';
        selectStyle.name = 'commodity-style[]';
        //Create and append the options
        $.each(this._commodityStyle, function(i, val){
            if(val.commodity_id == selectCommodity.value){
                option = document.createElement("option");
                option.value = val.name;
                option.text = val.name;
                selectStyle.appendChild(option);
            }
        });
        //selectStyle.className='dropdown_style';

        var textStyle=document.createElement('input');
        textStyle.id = 'commodity-style-'+this._commodityNumber;
        textStyle.className = 'commodity-style';
        textStyle.name = 'commodity-text[]';
        textStyle.type = 'text';
        textStyle.placeholder = "Please specify…";
        textStyle.style.display = 'none';
        textStyle.style.width = '144px';

        div.appendChild(labelStyle);
        div.appendChild(selectStyle);
        div.appendChild(textStyle);

        var labelExperience=document.createElement('label');
        labelExperience.innerHTML='&nbsp;&nbsp;&nbsp;&nbsp;Experience: &nbsp;';
        var selectExperience=document.createElement('select');
        selectExperience.id = 'commodity-experience-'+this._commodityNumber;
        selectExperience.name = 'commodity-experience[]';
        //Create and append the options
        $.each(this._experience, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectExperience.appendChild(option);
        });
        //selectExperience.className='dropdown_style';

        div.appendChild(labelExperience);
        div.appendChild(selectExperience);
        var aDeleteRow=document.createElement('a');
        aDeleteRow.innerHTML='&nbsp;<img src="images/delete.png" title="Delete" alt="Delete"/>';
        aDeleteRow.className='linkEditAccount deleteRecord';

        if(this._commodityNumber > 1)
            div.appendChild(aDeleteRow);

        mainDiv.appendChild(div);

        this._commodityNumber += 1;
    },

    loadUserReporting : function(){
        var that =this, reporting, $viewDiv = $('#reportingExperienceDivView'), viewHTML = '', exp;
        // Refresh DOM
        $('#reportingExperienceDiv').html('');
        $viewDiv.html('');
        $.each(_UserReportingExperience, function(i, val){
            reporting = that._reportingNumber;
            that.loadReporting();
            // reporting-code
            $("#reporting-code-"+reporting+" option").filter(function() {
                return $(this).text() == val.code;
            }).prop('selected', true);
            // experience
            $("#reporting-experience-"+reporting+" option").filter(function() {
                return $(this).val() == val.experience;
            }).prop('selected', true);
            // reporting-exchange
            $("#reporting-exchange-"+reporting+" option").filter(function() {
                return $(this).text() == val.exchanges;
            }).prop('selected', true);


            // View
            viewHTML +=  '<label>';
            if(val.code)
                viewHTML += val.code +',';
            if(val.experience){
                exp = oReview.getObjById(that._experience,val.experience);
                viewHTML += exp[0].name +',';
            }
            if(val.exchanges)
                viewHTML += 'reporting to the ' + val.exchanges +' exchanges';
            viewHTML +=  '</label><br>';

            viewHTML = viewHTML.replace(/^,|,$/g,'');
            viewHTML = $.trim(viewHTML);

            $viewDiv.html(viewHTML);
        });
    },

    loadReporting : function(){
        var mainDiv = document.getElementById('reportingExperienceDiv');
        var div = document.createElement('div');
        var option;
        var labelCode=document.createElement('label');
        labelCode.innerHTML='Code: &nbsp;';
        var selectCode=document.createElement('select');
        selectCode.id = 'reporting-code-'+this._reportingNumber;
        selectCode.className = 'reporting-code';
        selectCode.name = 'reporting-code[]';
        // Default value
        option = this.selectDefaultValue();
        selectCode.appendChild(option);
        //Create and append the options
        $.each(this._reportingCode, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectCode.appendChild(option);
        });
        //selectCode.className='dropdown_style';

        div.appendChild(labelCode);
        div.appendChild(selectCode);

        var labelExperience=document.createElement('label');
        labelExperience.innerHTML='&nbsp;&nbsp;&nbsp;&nbsp;Experience: &nbsp;';
        var selectExperience=document.createElement('select');
        selectExperience.id = 'reporting-experience-'+this._reportingNumber;
        selectExperience.name = 'reporting-experience[]';
        // Default value
        option = this.selectDefaultValue();
        selectExperience.appendChild(option);
        //Create and append the options
        $.each(this._experience, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectExperience.appendChild(option);
        });
        //selectExperience.className='dropdown_style';

        div.appendChild(labelExperience);
        div.appendChild(selectExperience);

        var labelExchanges=document.createElement('label');
        labelExchanges.innerHTML='&nbsp;&nbsp;&nbsp;&nbsp;Exchanges: &nbsp;';
        var selectExchanges=document.createElement('select');
        selectExchanges.id = 'reporting-exchange-'+this._reportingNumber;
        selectExchanges.name = 'reporting-exchange[]';
        // Default value
        option = this.selectDefaultValue();
        selectExchanges.appendChild(option);
        //Create and append the options
        $.each(this._exchange, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectExchanges.appendChild(option);
        });
        //selectExchanges.className='dropdown_style';

        div.appendChild(labelExchanges);
        div.appendChild(selectExchanges);

        var aDeleteRow=document.createElement('a');
        aDeleteRow.innerHTML='&nbsp;<img src="images/delete.png" title="Delete" alt="Delete"/>';
        aDeleteRow.className='linkEditAccount deleteRecord';

        if(this._reportingNumber > 1)
            div.appendChild(aDeleteRow);

        mainDiv.appendChild(div);

        this._reportingNumber += 1;
    },

    saveCommodity : function() {
        if(oRsc.checkUserLoggedIn()){
            $(".processing img").show();
            var fields = $('#commodityExperienceDiv :input').serialize();
            var url = SCRIPT_PATH + '?action=saveCommodity';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    that.getUserCommodity();
                    that.showCommodityExp();
                }else{
                    // Todo: Display error msg
                    that.enable();
                }
                $(".processing img").hide();
            },'json');
        }
    },

    saveReportingExperience : function(){
        $(".processing img").show();
        if(oRsc.checkUserLoggedIn()){
            var fields = $('#reportingExperienceDiv :input').serialize();
            var url = SCRIPT_PATH + '?action=saveReportingExperience';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    that.getUserReportingCode();
                    that.showReportingExp();
                }else{
                    // Todo: Display error msg
                    that.enable();
                }
                $(".processing img").hide();
            },'json');
        }
    },

    selectDefaultValue : function(){
        var option = document.createElement("option");
        option.value = '';
        option.text = 'Please choose..';

        return option;
    }
};