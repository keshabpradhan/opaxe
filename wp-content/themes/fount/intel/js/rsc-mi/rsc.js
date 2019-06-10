/**
 * Created by Arslan on 7/27/2015.
 */

var oRscMi = {

    init : function(){

        // Logout popup
        $("button.dropdown-toggle").click(function(){
            var position = $(this).offset();
            var top =position.top - $(document).scrollTop() + 8;
            var left =position.left + 52;
            $("div#logout_popup").css({'top': top, 'left': left, 'display': 'inline'} );

            var popupContent;
            popupContent = '<p><a href="#" onclick="javascript:oRsc.goToManageAccount();">Manage Account</a></p>';
            popupContent += '<p><a href="#" onclick="javascript:oRsc.logout();">Logout</a></p>';

            $("div#logout_popup > p").html(popupContent);
        });


        // Logout popup
        $("div#login_name span a").click(function(){
            var position = $(this).offset();
            var top =position.top - $(document).scrollTop() - 2;
            var left =position.left + 52;
            $("div#logout_popup").css({'top': top, 'left': left, 'display': 'inline'} );

            var popupContent;
            popupContent = '<p><a href="#" onclick="javascript:oRsc.goToManageAccount();">Manage Account</a></p>';
            popupContent += '<p><a href="#" onclick="javascript:oRsc.logout();">Logout</a></p>';

            $("div#logout_popup > p").html(popupContent);
        });

        //Complaint form
        $('#complaint-less-rating-modal').on('change', '.less-rating-radio', function() {
            if(document.getElementById('contact-cpqp-yes').checked){
                $('.complaint-info-yes').show();
            }else{
                $('.complaint-info-yes').hide();
            }
        });

        // Reviewed Button
        $("#region-button-reviewed-reports").click(function() {
            //$('.main-scale-div').toggle();
            document.getElementById('reviewed-button-image').src= location.protocol+'/wp-content/themes/fount/intel/images/reviewed-button-clicked.png';
            if(oRsc.filterRating==false){
                var top=$('#region-button-reviewed-reports').offset().top;
                var left=$('#region-button-reviewed-reports').offset().left;
                var elementStyle = document.getElementById("scale-review-rating").style;
                elementStyle.position = "absolute";
                top=top+40;
                if(left>750){
                    left=left-226;
                }
                elementStyle.top = top+'px';
                elementStyle.left = left+'px';
                $('.main-scale-div').show();
                document.getElementById('down-arrow-review-img').src=location.protocol+'/wp-content/themes/fount/intel/images/down-arrow.png';
                oRsc.filterRating=true;
                /*Todo: RSC-MI taking parts down*/
                $('#region-button-reviewed-reports').removeClass().addClass('region-button-down region-button-on');
                /*Todo: END*/
            }else{
                $('.main-scale-div').hide();
                document.getElementById('down-arrow-review-img').src= location.protocol+'/wp-content/themes/fount/intel/images/up-arrow.png';
                oRsc.filterRating=false;
                /*Todo: RSC-MI taking parts down*/
                $('#region-button-reviewed-reports').removeClass().addClass('region-button-down region-button-off');
                /*Todo: END*/
            }
        });
    },

    reviewReport :function(elm){
        var $Report = $('#'+elm.id);
        var report = $Report.attr('report');
        $('#review-report-id').val(report);

        var model = '#login-modal';
        if($.cookie('login') == "loggedIn"){
            oReview.init();
        } else{
            $(model).modal('show');
        }
    },

    reviewHistoryReport :function(elm){
        var $Report = $('#'+elm.id);
        var report = $Report.attr('report');
        $('#review-report-id').val(report);
        $('#history-review').val('True');

        var model = '#login-modal';
        if($.cookie('login') == "loggedIn"){
            oReview.init();
        } else{
            $(model).modal('show');
        }
    },

    showLoginPopup : function(){
        var model = '#login-modal';
        $(model).modal('show');
    },

    showRatingDetail : function(reportId){
        var $table,tr,score,name,section, total_score,total_count;
        $table = $('.rating_summary');
        $table.html('');
        var that = this;
        var url = SCRIPT_PATH + "?action=getReviewRating";
        var fields = {report_id : reportId};
        $.post(url,fields, function(response){
            if(response.success){
                if(response.sections){
                    //Overall rating
                    section = response.sections[0];
                    total_count = parseInt(section.total);
                    $('.report-review-count').html(total_count+' expert reviews');

                    var level = $.cookie('level');

                    if(total_count >= 3 || level == 'Reviewer' || level == 'Senior Reviewer'  || level == 'Admin'){

                        $.each(response.sections, function( index, value ) {
                            name = value.name + ':';
                            score = parseFloat(value.score) / parseFloat(value.total);
                            tr = that.getRating(name,score);
                            $table.append(tr);
                        });

                        $('.overall-rating-report').prop('checked',false);
                        total_score = parseFloat(section.total_score)  / parseFloat(section.total);
                        //OVERALL
                        tr = $('<tr></tr>');
                        $table.append(tr);
                        tr = $('<tr></tr>');
                        $table.append(tr);
                        tr = that.getRating(oReview.overAllSection.name,total_score);

                        $table.append(tr);

                        $('#more-link').show();
                        document.getElementById('rating-container').innerHTML =tr[0].innerHTML;
                        // $('#star'+total_score).prop('checked',true);

                        $('.reviews-rating').rating({
                            disabled:true
                        });
                    }else{
                        //tr = that.getRating(oReview.overAllSection.name,0);
                        //$('#more-link').show();
                        //$('#rating-container').html('');
                        //document.getElementById('rating-container').innerHTML =tr[0].innerHTML;
                        //
                        //$('.reviews-rating').rating({
                        //    disabled:true
                        //});

                        $table.html('');
                        tr = $('<tr><td><p class="insufficient-rating">A minimum of 3 reviews is required for a rating to be displayed.</p></td></tr>');
                        $table.append(tr);
                    }

                }
                $('.spinner').hide();
            }else{
                //Todo: Display some error
                $table.html('');
                var txt = '<tr><td><p class="error">A minimum of 3 reviews is required for a rating to be displayed.</p></td></tr>';
                tr = $(txt);
                $table.append(tr);
                $('.spinner').hide();
            }
        }, 'json');
    },

    getRating : function(name,rating){
        var $tr, $td, review, $tdRating, checked='';
        if(name == 'OVERALL RATING'){
            $tr = $('<tr></tr>');
            $td = $('<td><b class="ol-rating">'+name+': </b></td>');
        }else{
            $tr = $('<tr></tr>');
            $td = $('<td><b>'+name+'</b></td>');
        }


        review = $('<input>').attr({
            class:'reviews-rating',
            value: rating,
            'data-stars': '5',
            'data-step': '5',
            'data-size': 'xs',
            'disable': 'disabled'
        });

        $tdRating = $('<td></td>');
        $tdRating.append(review);
        $tr.append($td).append($tdRating);
        $('.reviews-rating').rating({
            disabled:true
        });
        return $tr;


    },

    validate : function(){
        var username = $('#username').val();
        var password = $('#login-pass').val();
        //var $error = $('.login-error');

        if ((username == null || username == "") && (password == null || password == "")) {

            $('#login-message').text("Username & Password must be filled out.");
            //$error.html("Username & Password must be filled out.");
            return false;
        }else if (username == null || username == "") {
            $('#login-message').text("Please enter the Username.");
            //$error.html("Username must be filled out.").show();
            return false;
        }else if(password == null || password == ""){
            $('#login-message').text("Please enter the Password.");
            //$error.html("Password must be filled out.").show();
            return false;
        }

        return true;
    },

    login : function(){
        $("#login-message").text('');
        if (this.validate()){
            $(".imgProgress img").show();
            var fields = $('#login :input').serialize();
            var url = SCRIPT_PATH + '?action=login';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    $(".imgProgress img").hide();
                    //Set Cookie
                    that.setCookie(response);
                    //Logged in
                    that.checkLoggedIn();

                    $('#uname').text($.cookie('username'));
                    $('#login-modal').modal('hide');
                    location.reload();
                }else{
                    $('#login-message').text("Invalid Username or Password.");
                    $("#login-message").show();
                    $(".imgProgress img").hide();
                }
            },'json');
        }
        else
        {
            $("#login-message").show();
        }
    },

    logout : function(){
        this.destroyCookie();
        // Update Dom
        this.runFilter();
        var url = SCRIPT_PATH + '?action=logout';
        $.post(url, function(response){
            if(response.success){
                $('#submit-review-modal').modal('hide');
                $('#logedin').modal('hide');
                //$('#login-modal').modal('show');
                $(".imgProgress img").hide();
                $("#login-message").hide();

                location.reload();
            }
        },'json');
    },

    updateConditionStatus : function(){
        console.log('work');
        var url = SCRIPT_PATH + '?action=updateConditionStatus';
        $.post(url, function(response){
            if(response.success){
                $.cookie('rsc_advises', response.rsc_advises, { path: '/' });
            }
        },'json');
    },

    setCookie : function(user){
        $.cookie('login', user.login, { path: '/' });
        $.cookie('rsc_advises', user.rsc_advises, { path: '/' });
        $.cookie('username', user.username, { path: '/' });
        $.cookie('pname', user.pname, { path: '/' });
        $.cookie('level', user.level, { path: '/' });
        $.cookie('user_level', user.user_level, { path: '/' });
    },

    destroyCookie : function(){
        $.removeCookie('login', { path: '/' });
        $.removeCookie('rsc_advises', { path: '/' });
        $.removeCookie('username', { path: '/' });
        $.removeCookie('pname', { path: '/' });
        $.removeCookie('level', { path: '/' });
        $('#loggedin > div').css('display','none');
        $('#loggedin span a').html('');
    },

    validateEmail : function(){

        var email = $('#email').val();

        //var $error = $('.login-error');

        if (email == null || email == "") {
            $('#email-message').text("Please enter the Email Address");
            $('#email-message').show();
            //$error.html("Username must be filled out.").show();
            return false;
        }

        return true;
    },

    validateInviteEmail : function(){

        var email = $('#email123').val();

        //var $error = $('.login-error');

        if(email == null || email == "") {
            $('#email-message1').text("Please enter the Email Address");
            $('#email-message1').show();
            //$error.html("Username must be filled out.").show();
            return false;
        }

        return true;
    },

    emailSend : function(){
        if (this.validateEmail()){
            $(".imgProgressEmail img").show();
            var fields = $('#emailsend :input').serialize();
            var url = SCRIPT_PATH + '?action=emailsend';

            $.post(url, fields, function(response){
                if(response.success){
                    $('#login-email').modal('hide');
                    $('#emailSent-modal').modal('show');
                }
                else{
                    $('#email-message').text("This email is not registered.");
                    $('#email-message').show();
                    $(".imgProgressEmail img").hide();
                }
            },'json');
        }
    },

    emailpopup : function(){
        $(".imgProgressEmail img").hide();
        $('#email-message').hide();
        $('#login-modal').modal('hide');
        $('#logedin').modal('hide');
        $('#login-email').modal('show');

    },

    signuppopup : function(){
        $(".imgProgressSignup img").hide();
        $('#signup-message').hide();
        $('#login-modal').modal('hide');
        $('#signup-modal').modal('show');
        $('#signupdata').resetForm();
    },

    backtologin : function(){
        $("#login-message").hide();
        $('#signup-modal').modal('hide');
        $('#login-email').modal('hide');
        $('#login-modal').modal('show');
    },

    returnToMap : function(){
        $('#logedin').modal('hide');
        $('#submit-review-modal').modal('hide');
        $('#submit-review-complaint-modal').modal('hide');
        $('#thankyoumessage-modal').modal('hide');
        $('#saved-review-modal').modal('hide');
    },

    complaintForm : function(){
        $('#submit-review-complaint-modal').modal('hide');
        $('#complaint-modal').modal('show');
    },

    returnToLogin : function(){
        $('#emailSent-modal').modal('hide');
        //$('#submit-review-modal').modal('hide');
        //$('#submit-review-complaint-modal').modal('hide');
        $('#login-modal').modal('show');
    },

    editprofile : function(){
        $(".imgProgressProfile img").show();
        var fields = $('#editprofile :input').serialize();
        var url = SCRIPT_PATH + '?action=editprofile';
        $.post(url, fields, function(response){
            if(response.success){
                //Set Cookie
                location.reload();
            }else{
                // Todo: Display error msg
            }
            $(".imgProgressProfile img").hide();
        },'json');
    },

    logoutformdashboard : function(){
        this.destroyCookie();

        var url = SCRIPT_PATH + '?action=logout';
        $.post(url, function(response){
            if(response.success){
                //window.location.replace("http://www.rscmme.com");
                window.location.replace(BASE_URL);
            }
        },'json');
    },

    complaint : function(){
        var fields = $('#complaint :input').serialize();
        var url = SCRIPT_PATH + '?action=complaintsave';

        $.post(url, fields, function(response){
            if(response.success){

            }else{
                // Todo: Display error msg
            }
        },'json');
    },

    viewReportSummary : function(elm){
        $.cookie('reportId', elm.id, { expires: 1, path: '/' });
        var url = 'review-summary.php';
        window.open(url, '_blank');
    },

    goToManageAccount : function(){
        $('#submit-review-modal').modal('hide');
        // Checked logged in
        if(oRsc.checkUserLoggedIn()){
            var url = 'manage-account.php';
            window.open(url, '_self');
        }
    },

    checkLoggedIn : function(){
        var $lDiv = $('#loggedin > div#loign_details');
        $('#logged-in').css('display', 'block');
        var $LoggedinDiv = $('#hrefLogIn');
        var $LoggedOutDiv = $('#hrefLogOut');
        //Logged in
        if($.cookie('login') == 'loggedIn'){
            $LoggedinDiv.css('display','none');
            $LoggedOutDiv.css('display','inline-block');
            $lDiv.css('display','block');

            //Username
            $('#loggedin span a').html($.cookie('username'));

            var profileImg = $.cookie('pname');
            if(profileImg === null || profileImg == "null" || typeof profileImg === 'undefined'){
                $('#loggedin img').attr('src','images/upload/dummy.png');
            }else{
                $('#loggedin img').attr('src','images/upload/'+profileImg);
            }
        }else{
            $lDiv.css('display','none');
            $LoggedinDiv.css('display','inline-block');
            $LoggedOutDiv.css('display','none');
        }
    },

    checkUserLoggedIn : function (){
        this.validateSession();
        var loggedIn = $.cookie('login');
        if(loggedIn == 'loggedIn'){
            return true;
        }else{
            $('#not-loggedin-modal').modal('show');
            window.setTimeout('location.reload()', 3000);
        }
    },

    validateSession : function (){
        var url = SCRIPT_PATH + '?action=validateSession';
        var that = this;
        $.post(url, function(response){
            if(response.success){
                //Set Cookie
                that.setCookie(response);
                //Logged in
                that.checkLoggedIn();
            }else{
                // logout
                that.destroyCookie();
                that.checkLoggedIn();
            }
        },'json');
    },

    loadExpertPanel : function(){
        var url = SCRIPT_PATH + '?action=expertPanel';
        var that = this;
        $.post(url, function(response){
            if(response.success){
                var vDiv = document.getElementById('panel-biography');
                $.each(response.expertPanel, function(i, rev){

                    var cDiv = document.createElement('div');
                    cDiv.className='reviewers-container';

                    var imgDiv = document.createElement('div');
                    imgDiv.className='reviewer-img';

                    var img =  document.createElement('img');
                    img.className = "reviewer-image";

                    if(rev.anonymous == 'yes'){
                        img.src = 'images/upload/RP-temp.png';
                    }else{
                        if(rev.profilepicture){
                            img.src = 'images/upload/'+rev.profilepicture;
                        }
                        else{
                            img.src = 'images/upload/RP-temp.png';
                        }
                    }


                    var attribDiv = document.createElement('div');
                    attribDiv.className='reviewer-attrib';

                    var table = document.createElement('table');
                    table.className='';

                    var trFirst = document.createElement('tr');

                    var thCompany = document.createElement('th');
                    thCompany.innerHTML='Company:';


                    var company;
                    if(rev.company == null ){
                        company = '';
                    }else{
                        if(rev.anonymous == 'yes' && rev.consultant == 'yes'){
                            company ='Consultancy';
                        }else if(rev.anonymous == 'yes' && rev.consultant == 'no'){
                            company ='Mining/Exploration Company';
                        }else{
                            company = rev.company;
                        }
                    }
                    var tdCompany = document.createElement('td');
                    tdCompany.innerHTML= company ;

                    trFirst.appendChild(thCompany);
                    trFirst.appendChild(tdCompany);

                    var thCountry = document.createElement('th');
                    thCountry.innerHTML='Country:';
                    var country;
                    if(rev.country == null ){
                        country = '';
                    }else{
                        country = rev.country;
                    }
                    var tdCountry = document.createElement('td');
                    tdCountry.innerHTML= country;

                    trFirst.appendChild(thCountry);
                    trFirst.appendChild(tdCountry);

                    var thLevel = document.createElement('th');
                    thLevel.innerHTML='Level';
                    var tdLevel = document.createElement('td');
                    tdLevel.innerHTML= rev.level;

                    trFirst.appendChild(thLevel);
                    trFirst.appendChild(tdLevel);


                    var trSecond = document.createElement('tr');

                    var thPosition = document.createElement('th');
                    thPosition.innerHTML='Position:';

                    var position;
                    if(rev.position == null ){
                        position = '';
                    }else{
                        position = rev.position;
                    }
                    var tdPosition = document.createElement('td');
                    tdPosition.innerHTML= position ;

                    trSecond.appendChild(thPosition);
                    trSecond.appendChild(tdPosition);


                    var thCommodity = document.createElement('th');
                    thCommodity.innerHTML='Reporting Codes:';


                    var cExp,code;
                    if(rev.reporting_code == null ){
                        cExp = '';
                    }else{
                        code = rev.reporting_code;
                        cExp = code.replace(/[{}",]+/g, '');
                    }
                    var tdCommodity = document.createElement('td');
                    tdCommodity.colSpan = "3";
                    tdCommodity.innerHTML= cExp ;

                    trSecond.appendChild(thCommodity);
                    trSecond.appendChild(tdCommodity);


                    //var thStocks = document.createElement('th');
                    //thStocks.innerHTML='Stock Exchange:';
                    //var stocks;
                    //if(rev.stocks == null ){
                    //    stocks = '';
                    //}else{
                    //    stocks = rev.stocks;
                    //}
                    //var tdStocks = document.createElement('td');
                    //tdStocks.innerHTML= stocks;
                    //
                    //trSecond.appendChild(thStocks);
                    //trSecond.appendChild(tdStocks);


                    var trThird = document.createElement('tr');

                    var thExperience = document.createElement('th');
                    thExperience.innerHTML='Experience:';

                    var experience;
                    if(rev.experience == null ){
                        experience = '';
                    }else{
                        experience = rev.experience + ' Years';
                    }
                    var tdExperience = document.createElement('td');
                    tdExperience.innerHTML= experience ;

                    trThird.appendChild(thExperience);
                    trThird.appendChild(tdExperience);

                    //var thReporting = document.createElement('th');
                    //thReporting.innerHTML='Reporting Experience:';
                    //var rExp;
                    //if(rev.reporting_experience == null ){
                    //    rExp = '';
                    //}else{
                    //    rExp = rev.reporting_experience + ' Years';
                    //}
                    //var tdReporting = document.createElement('td');
                    //tdReporting.innerHTML= rExp;
                    //
                    //trThird.appendChild(thReporting);
                    //trThird.appendChild(tdReporting);

                    var thCommodities = document.createElement('th');
                    thCommodities.innerHTML='Commodities:';

                    var commodities;
                    if(rev.commodity == null ){
                        commodities = '';
                    }else{
                        commodities = rev.commodity;
                    }
                    var tdCommodities = document.createElement('td');
                    tdCommodities.colSpan = "3";
                    tdCommodities.innerHTML= commodities.replace(/[{}",]+/g, '');

                    trThird.appendChild(thCommodities);
                    trThird.appendChild(tdCommodities);




                    table.appendChild(trFirst);
                    table.appendChild(trSecond);
                    table.appendChild(trThird);


                    var bioDiv = document.createElement('div');
                    bioDiv.className='';

                    var infolabel = document.createElement('label');
                    if(rev.anonymous == 'yes'){
                        infolabel.innerHTML = 'Anonymous';
                    }else{
                        infolabel.innerHTML = rev.firstname +' '+rev.lastname;
                    }

                    var biography;
                    if(rev.biography == null ){
                        biography = '';
                    }else{
                        biography = rev.biography;
                    }
                    var infop = document.createElement('p');

                    infop.innerHTML = '<span class="biography-heading">Biography: </span> '+ "<span class='biography-text'>"+biography+"</span>";
                    bioDiv.appendChild(infop);

                    imgDiv.appendChild(img);
                    attribDiv.appendChild(infolabel);
                    attribDiv.appendChild(table);
                    imgDiv.appendChild(attribDiv);
                    cDiv.appendChild(imgDiv);
                    //cDiv.appendChild(infop);
                    attribDiv.appendChild(bioDiv);
                    vDiv.appendChild(cDiv);

                });
                $("#userBiographyImage img").hide();
            }else{
                // Todo: Display error msg
            }
        },'json');
    },

    populateCountries : function(){
        var url = SCRIPT_PATH + '?action=populateCountries';
        var countryOption;
        $.post(url, function(response){
            if(response.success){
                var countrySelect = document.getElementById('country');
                // Default value
                countryOption = oManageAccount.selectDefaultValue();
                countrySelect.appendChild(countryOption);
                $.each(response.countries, function(i, rev){
                    countryOption= document.createElement('option');
                    countryOption.innerHTML = rev.countires;
                    countryOption.value=rev.countires;
                    countrySelect.appendChild(countryOption);
                });
            }
            else{

            }

        },'json');
    },

    populateCountriesManageProfile : function(country){
        var url = SCRIPT_PATH + '?action=populateCountries';
        var countryOption;
        $.post(url, function(response){
            if(response.success){
                var countrySelect = document.getElementById('country');
                // Default value
                countryOption = oManageAccount.selectDefaultValue();
                countrySelect.appendChild(countryOption);
                $.each(response.countries, function(i, rev){
                    countryOption= document.createElement('option');
                    countryOption.innerHTML = rev.countires;
                    countryOption.value=rev.countires;
                    if(country==rev.countires){
                        countryOption.selected='selected';
                    }
                    countrySelect.appendChild(countryOption);
                });
            }
            else{

            }

        },'json');
    },

    populateCommodity : function(){
        var url = SCRIPT_PATH + '?action=populateCommodity';
        $.post(url, function(response){
            if(response.success){
                var commoditySelect = document.getElementById('commodity-name');
                var counter=1;
                var opt;
                $.each(response.commodity, function(i, rev){

                    if(counter==1 ||opt!=rev.type){
                        if(counter!=1){
                            commoditySelect.appendChild(commodityOptgroup);
                        }
                        commodityOptgroup= document.createElement('optgroup');
                        commodityOptgroup.label=rev.type;
                        opt=rev.type;
                        counter++;
                    }
                    var commdityOption= document.createElement('option');
                    commdityOption.innerHTML = rev.name;
                    commdityOption.value=rev.name;
                    commodityOptgroup.appendChild(commdityOption);

                });
                commoditySelect.appendChild(commodityOptgroup);
            }
            else{

            }

        },'json');
    },

    complaintSelection : function(){
        $('#complaint-modal').modal('hide');

        if (document.getElementById('complaint-form-one').checked)
            this.complaintFormOne();
        else if (document.getElementById('complaint-form-two').checked)
            this.complaintFormTwo();
        else if (document.getElementById('complaint-form-three').checked)
            this.complaintFormThree();

    },

    complaintFormOne : function(){
        var reportId = $('#review-report-id').val();
        var report = this.getReportDetailById(reportId);
        $('#company-complaint').html(report.company);
        $('#project-complaint').html(report.project);
        $('#code-complaint').html(report.code);
        $('#type-complaint').html(report.type);
        $('#cpqp-complaint').html(oReview.cleanString(report.cpqp));
        $('#date-complaint').html(report.date);

        $('#complaint-form-one-modal').modal('show');
        this.getComplaintDetail('One');
    },

    complaintFormTwo : function(){
        $('#complaint-form-two-modal').modal('show');
        this.getComplaintDetail('Two');
    },

    complaintFormThree : function(){
        var reportId = $('#review-report-id').val();
        var report = this.getReportDetailById(reportId);
        $('#company-complaint-three').html(report.company);
        $('#date-complaint-three').html(report.date);

        $('#complaint-form-three-modal').modal('show');

        this.getComplaintDetail('Three');
    },

    getComplaintDetail : function(form){
        var url = SCRIPT_PATH + '?action=complaintFormDetails';
        $.post(url, function(response){
            if(response.success){
                var rev = response.userData[0];
                $('#nameComplaint'+form).val(rev.firstname+' '+rev.lastname);
                $('#companyComplaint'+form).val(rev.company);
                $('#emailComplaint'+form).val(rev.email);
            }
        },'json');
    },

    submitComplaint : function(form){
        $(".imgProgressComplaint img").show();
        $('.complaint-form-one').prop('disabled', true);
        var fields = $('#'+form+' :input').serialize();
        var url = SCRIPT_PATH + '?action=submitComplaint';

        $.post(url, fields, function(response){
            if(response.success){
                $('#complaint-form-one-modal').modal('hide');
                $('#complaint-form-two-modal').modal('hide');
                $('#complaint-form-three-modal').modal('hide');
                $(".imgProgressComplaint img").hide();
                $('.complaint-form-one').prop('disabled', false);
                $('#complaint-thankyou-modal').modal('show');
                setTimeout(function(){
                    $('#complaint-thankyou-modal').modal('hide');
                },3000);
            }else{
                $(".imgProgressComplaint img").hide();
                $('.complaint-form-one').prop('disabled', false);
            }
        },'json');
    },

    getReportDetailById : function(report_id){
        var feature = $.grep(geoJson, function(e){ return e.id == report_id; });
        return feature[0].properties;
    },

    backToComplaintForm : function (){
        $('#complaint-form-one-modal').modal('hide');
        $('#complaint-form-two-modal').modal('hide');
        $('#complaint-form-three-modal').modal('hide');
        $('#complaint-modal').modal('show');
    },

    lessRating : function(){
        var fields = $('#lessRating :input').serialize();
        var url = SCRIPT_PATH + '?action=lessRating';
        $.post(url, fields, function(response){
            if(response.success){
            }else{
            }
        },'json');
    },

    emailAllReviewers : function(reportId){
        var feilds={'id':reportId};
        var url = SCRIPT_PATH + '?action=emailAllReviewers';
        $.post(url,feilds, function(response){
            if(response.success){
                $('#invite-options-modal').modal('hide');
                $(".imgProgressInviteAll img").hide();
                $('#invitationSent-modal').modal('show');
            }else{
                $(".imgProgressInviteAll img").hide();
            }
        },'json');
    },

    checkInviteType : function(){
        $(".imgProgressInviteAll img").show();
        var reportId=document.getElementById('reportId-invite-all').value;
        if (document.getElementById('specific_user').checked){
            var email=document.getElementById('email-invite-hidden-input').value;
            oManageReview.invitereviewer(email,reportId);
        }

        else if (document.getElementById('all_user').checked)
            oRsc.emailAllReviewers(reportId);
    },

    scaleImagesHover : function(){
        document.getElementById('reviewed-button-image').src= location.protocol+'/wp-content/themes/fount/intel/images/reviewed-button-clicked.png';
        $('#down-arrow-review-img').show();
        document.getElementById("down-arrow-review-img").style.display = "inblock";
    },

    scaleImagesHoverOut : function(){
        if ($("#region-button-reviewed-reports").hasClass('region-button-on')){
            document.getElementById('reviewed-button-image').src= location.protocol+'/wp-content/themes/fount/intel/images/reviewed-button-clicked.png';
            $('#down-arrow-review-img').show();
            document.getElementById("down-arrow-review-img").style.display = "inblock";
        }else {
            document.getElementById('reviewed-button-image').src = location.protocol+'/wp-content/themes/fount/intel/images/reviewed-button.png';
            document.getElementById("down-arrow-review-img").style.display = "none";
        }
    }
};

