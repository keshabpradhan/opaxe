var self = this, isNavTopFilter;
var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';
var url = SCRIPT_PATH + "?action=userMembershipLevels";
var globalVariables={
    userEmail:'',
    userSubscriptions:'',
    userSubscribed : false
};
$(document).ready(function () {


    //open Register page on Sign up free click
    register_from = function () {
        $('.modal').modal('hide');
        $('#plansModel').modal('show');
        var sone = [];
        sone['action'] = 'button:signup';
        sone['action_log'] = 'view plans';
        from_activity_log(sone);
    };

    from_activity_log = function (sone) {
        var path = "?action=activity_log",
            url = SCRIPT_PATH + path;
        var data = {'log': sone['action_log'], 'action': sone['action'], 'mode': sone['mode'],'report-id':sone['report-id']};
        $.ajax(url, {
            type: 'POST',
            global: false,
            data: data,
            success: function (response) {
                console.log(response);
            },
        });
    };


    $("#mail-to").click(function () {
        $('#feedback-modal').modal('show');
    });

    //......................................terms of services link in Disclamier message
    $('#showTermUse').click(function () {
        // $('[data-remodal-id=terms-services-popup]').remodal().open();

        document.querySelector("#terms-services-popup .close-custom-modal-remodal").style.display="block";

        if (document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.contains("not-hide"))
        {
            document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.remove("not-hide");
        }

        $('#terms-services-popup').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });

    $('#terms-services').click(function () {
        $('#terms-services-popup').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });

        document.querySelector("#terms-services-popup .close-custom-modal-remodal").style.display="none";

        document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.add("not-hide");

    });

    $('#terms-co').click(function () {
        if (document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.contains("not-hide"))
        {
            document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.remove("not-hide");
        }

        $('#terms-services-popup').modal('show');

        $('#show-accon-btn').hide();
    });

    $('#tou_privacy-pol').click(function () {
        if (document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.contains("not-hide"))
        {
            $('#privacyPopup').modal('show');
            $('#privacyPopup').show();
        }
        else {
            $('#terms-services-popup').modal('hide');
            $('#privacyPopup').modal('show');
        }
    });

    $('.close-custom-modal-remodal').click(function(e) {
        if($(this).hasClass('not-hide')) {


            $('.modal').not('#terms-services-popup').hide();

            // $('.modal').modal('hide');
            // $('.modal-backdrop').remove();
            //
            //
            // setTimeout(function() {
            //     $('#terms-services-popup').modal('show');
            // }, 700);


        }
        else {
            $('.modal').modal('hide');
            $('.modal-backdrop').remove();
        }

    });

    $(".remodal-confirm").click(function () {
        $('.modal:not(#login-modal.modal)').modal('hide');
    });

    $('nav#nav-main ul li a').click(function(e)
    {
        var popup = $(this).find("span").text();

        if(popup== "Latest Weekly Bulletin"){

            var shared_url = false;
            oPdf.weeklyBulletin(shared_url);

        } else if (popup== "Our Company" || popup== "How we work" || popup== "Our data" || popup== "Our team"){
            // $('[data-remodal-id=aboutusPopup]').remodal().open();
            $('#aboutusPopup').modal('show');
            //scroll to popup relevent section
            scrollToSection(popup);

        } else if (popup== "Contact"){

            // $('[data-remodal-id=contactusPopup]').remodal().open();
            $('#contactusPopup').modal('show');

        }
    });

    function scrollToSection(scrollToSection) {
        if(scrollToSection == "Our team") {
            setTimeout(function(){

                document.getElementById('our-team').scrollIntoView({
                    behavior: 'smooth'
                });

            }, 1000);
            return false;

        } else if(scrollToSection == "How we work") {

            setTimeout(function(){

                document.getElementById('how-we-work').scrollIntoView({
                    behavior: 'smooth'
                });

            }, 1000);
            return false;

        } else if(scrollToSection == "Our data") {

            setTimeout(function(){

                document.getElementById('our-data').scrollIntoView({
                    behavior: 'smooth'
                });

            }, 1000);
            return false;

        } else {
            return false;
        }
    }


    var region = $('.region-button-on').text();
    if (region != "") {
        return;
    }
    $.post(url, function (response) {
        if (response) {

            if (response.userStatus == "UserLogout") {

            }
            else {
                globalVariables.userEmail=response.Email;
                //add delete my account option in manage profile
                $('.ihc_userpage_template_1').parent().before('<a id="delete-account"><i class="icon-trash" style="color: #7B868C;" ></i>Delete my Account</a>');
                setTimeout(function () {
                    if (response.phone) {
                        $('#phone').val(response.phone);
                    }
                    $('.ind-sec').prepend('<option value="' + response.industry + '" selected> ' + response.industry + ' </option>');
                    $('.job-tit').prepend('<option value="' + response.jobTitle + '" selected> ' + response.jobTitle + ' </option>');

                    if (response.firstName == 'Sebastian')
                        weeklyLimit = 70;
                    else
                        weeklyLimit = 10;

                    var TotalpdfDownloads = response.totalDownloads[0];
                    $('.iump-form-checkbox .commodity-form-checkbox').css('width', '275px');

                    // var userProfile = ' <span id="user-name-header">' + 'Welcome  ' + response.firstName + '</span>';
                    // userProfile += '<div class="dropdown" aria-hidden="true" id="userProfile"><div id="img-dist">';
                    // userProfile += '</div>';
                    // userProfile += '<div class="dropdown-content" id="myDropdown">';
                    // userProfile += '<div id="first-row-user-profile">';
                    // userProfile += '<span id="user-name">Subscription Plan:</span> <span class="plan-name">' + response.subPlan + '</span><a class="upgrade-plan" href="/user-profile?ihc_ap_menu=subscription">   (upgrade)</a>';
                    // userProfile += '<div><span style="all: unset;text-transform: initial">Registered Since ' + response.userRegistered + '</span></div>';
                    // userProfile += '</div>';
                    // userProfile += '<a class="User-dropdown-Last2" href="/user-profile?ihc_ap_menu=profile">MANAGE PROFILE</a>';
                    // userProfile += '<a class="User-dropdown-Last2 last2-links"  href='+ weeklyreport+'>Weekly Intel report (PDF)</a>';
                    // //userProfile += '<a class="User-dropdown-Last2 last2-links" onclick="underDeveolpment()" href="#">List of published reports (PDF)</a>';
                    // userProfile += '<a class="User-dropdown-Last2 saved-pref" href="/user-profile?ihc_ap_menu=savedPreferences">SAVED PREFERENCES</a>';
                    // userProfile += '<a class="User-dropdown-Last2"  href="/iump-logout-2?ihcdologout=true">LOGOUT</a></div></div>';
                    $('.page-id-5109 .reset-pass-manage-profile a').attr('href','/reset-password-request/'+response.ResetPassLink);
                    $('#menu_section.unpad_right .sf-menu>li:last-child').empty();
                   // $("#menu_section.unpad_right .sf-menu>li:last-child").append(userProfile);
                    $("#img-dist").css("background", "url(" + response.imageUrl + ")50% 50% no-repeat");
                    $('input[name="ump_sub[]"]').each(function () {
                        $(this).prop('checked', false);
                    });
                    if(response.subPlan=='Plan1'){
                        $('.saved-pref').css('display','none');
                    }
                    for (i = 0; i < response.Subscription.length; i++) {
                        $('input[name="ump_sub[]"]').each(function () {
                            if ($(this).val() == response.Subscription[i]) {
                                $(this).prop('checked', true);
                            }
                        });
                    }

                }, 4000);
            }
        }
    }, 'json');
});
function underDeveolpment() {
    $('#under-deveolpment').modal('show');
}
//change plan link in register page
function changeplan(){
    $('#changePlanmodel').modal('show');
}

function listfeatures(plan) {
    if (plan == 1) {
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').children().remove();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').empty();
        $('.ihc-register-6 .iump-submit-form input').css('margin-top', '18px');
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').text('Available features for SILVER');
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').append('<a style="margin-left: 20px"  class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="RSC News" checked="" ><span>RSC News</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Resource Reports Bulletin" checked="" ><span>Resource Reports Bulletin</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="List of reports published by week" checked="" ><span>List of reports published by week</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report Highlights" checked="" ><span>Technical Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report PDF Downloads" checked="" ><span>Technical Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>Transaction Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>Transaction Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>Saved preferences</span></div>');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>User Generated Custom Reports</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>Alerts</span></div>');
    }
    if (plan == 2) {
      $('.page-id-5088 .wpb_wrapper p em').text('Registration for GOLD is currently free. Please complete all fields. We will not spam you unless you ask us to.');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').children().remove();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').empty();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').text('Available features for GOLD');
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').append('<a style="margin-left: 20px" class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
        $('.ihc-register-6 .iump-submit-form input').css('margin-top', '18px');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="RSC News" checked="" ><span>RSC News</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Resource Reports Bulletin" checked="" ><span>Resource Reports Bulletin</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="List of reports published by week" checked="" ><span>List of reports published by week</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report Highlights" checked="" ><span>Technical Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report PDF Downloads" checked="" ><span>Technical Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Transaction Report Highlights" checked="" ><span>Transaction Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Transaction Report PDF Downloads" checked="" ><span>Transaction Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Saved preferences" checked="" ><span>Saved preferences</span></div>');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>User Generated Custom Reports</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span style="color:red">&#10005;</span><span>Alerts</span></div>');
    }
    if (plan == 3) {
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').children().remove();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').text('Available features for PLATINUM');
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').append('<a style="margin-left: 20px"  class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
        $('.ihc-register-6 .iump-submit-form input').css('margin-top', '18px');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="RSC News" checked="" ><span>RSC News</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Resource Reports Bulletin" checked="" ><span>Resource Reports Bulletin</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="List of reports published by week" checked="" ><span>List of reports published by week</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report Highlights" checked="" ><span>Technical Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Technical Report PDF Downloads" checked="" ><span>Technical Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Transaction Report Highlights" checked="" ><span>Transaction Report Highlights</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Transaction Report PDF Downloads" checked="" ><span>Transaction Report PDF Downloads</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Saved preferences" checked="" ><span>Saved preferences</span></div>');
        // jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="User Generated Custom Reports" checked="" ><span>User Generated Custom Reports</span></div>');
        jQuery('form>:nth-child(1) .iump-form-checkbox-wrapper .iump-form-checkbox:nth-child(1)').first().append('<div class="iump-form-checkbox commodity-form-checkbox"><span>&#10003;</span><input type="checkbox" name="ump_features[]" id="" class="commodities plan-features" value="Alerts" checked="" ><span>Alerts</span></div>');
    }
    if (plan == 'true') {
        $('.login-register-form').modal('show');
    }
    if (!plan) {
        $('.ihc-register-6 .iump-submit-form input').css('margin-top', '221px');
    }
}


$(document).ready(function () {
     setfeatures();
    //open login model in intel page if login param set to true
    var isLogin = getUrlParameter('login');
    listfeatures(isLogin);
    //Initialize everything

    //add a disable option value in job title and industry dropdown that shows as default option
    $('.page-id-5088 .job-tit').prepend('<option value="" disabled selected>Please select</option>');
    $('.page-id-5088 .ind-sec').prepend('<option value="" disabled selected>Please select</option>');

    //add a other value in job title and industry dropdown that allow users to enter custom field
    $('.page-id-5088 .job-tit').append('<option class="select-custom-job-filed" value="" >other</option>');
    $('.page-id-5088 .ind-sec').append('<option class="select-custom-industry-sector" value="" >other</option>');
    //hide login from menu for other than intel pages
    var body = $('body').attr('class');
    body = body.includes("page-id-2237");
    if (!body)
        $('#menu_section.unpad_right .sf-menu>li:last-child>a').css("display", "none");
    $('.ihc-level-item-wrap').eq(1).css('padding-top', '0');
    //remove top sections in plans model to free up space (subscription tab)
    $('.ihc-level-item-price').remove();
    $('.ihc-level-item-top').remove();
    //set background dark blue to active plan and list features according to the plan
    var planName = $('.ihc-top-level-box ').text();
    if(planName=='' && $('.ich_level_wrap.ihc_level_template_5').is(':visible')){
        $('.ich_level_wrap.ihc_level_template_5').hide();
        $('.iump-account-content-title').after('Please wait Something went wrong....');
        ihc_buy_new_level_from_ap('Plan1', '', 1, '/user-profile?ihcnewlevel=true&lid=1&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
        $('.plan1-list').append('<a type="button"  class="btn btn-primary upgrade-plan1">Upgrade plan</a>');
        $('.plan2-list').append('<a type="button"  class="btn btn-primary upgrade-plan2">Upgrade plan</a>');
        // $('.plan3-list').append('<a type="button"  class="btn btn-primary upgrade-plan3">Coming soon</a>');
    }
    if (planName == 'Plan1') {
        //hide saved preferences for plan1
        $('.fa-savedPreferences-account-ihc').parent().css('display', 'none');
        $('.saved-pref').css('display', 'none');
        var plan = 1;
        //set the ammount free for plan1
        $('.ihc-account-subscr-list tbody td:last-child').text('Free');
        //add upgrade buttons in other two plans
        $('.plan2-list').append('<a type="button"  class="btn btn-primary upgrade-plan2">Upgrade plan</a>');
        // $('.plan3-list').append('<a type="button"  class="btn btn-primary upgrade-plan3">Coming soon</a>');
        //set the background of active plan in subscription tab
        $('.ihc-level-item-wrap').css('background', '#DE7070');
        $('.ihc-level-item-wrap:first-child').first().css('background', '#c63c3c');


        // change plan names of user profile
        //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].innerHTML = "SILVER";

        // change span text free to ACTIVE LAN
        $('#plan1-pricetext').text('ACTIVE PLAN');

        //hide Plan name from header bar profilepage
        document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].style.display = 'none';

        if ($('#ihc_account_page_wrapp span').hasClass('ihc-level-name')) {
            //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].innerHTML = "Plan1";
            var span = document.createElement('span')
            span.innerHTML = 'SILVER';
            span.className += "ihc-level-label";
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].style.display = 'none';
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].after(span);
        }
    }
    else if (planName == 'Plan2') {
        var plan = 2;
        //set the ammount free for plan2
        $('.ihc-account-subscr-list tbody td:last-child').text('Free');
        //add cancel button in active plan and upgrade button in other
        $('.plan2-list').append('<a type="button"  class="btn btn-danger cancel-plan2">Cancel plan</a>');
        // $('.plan3-list').append('<a type="button"  class="btn btn-primary upgrade-plan3">Coming soon</a>');
        //set the background of active plan in subscription tab
        $('.ihc-level-item-wrap').css('background', '#DE7070');
        $('.ihc-level-item-wrap').eq(1).css('background', '#c63c3c');
        $('.plan2-list>p').css('margin-bottom','0');

        // change plan names of user profile
        //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].innerHTML = "GOLD";

        // change span text free to ACTIVE LAN
        $('#plan2-pricetext').text('ACTIVE PLAN');

        //hide Plan name from header bar profilepage
        document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].style.display = 'none';

        if($('#ihc_account_page_wrapp span').hasClass('ihc-level-name')) {
            var span = document.createElement('span')
            span.innerHTML = 'GOLD';
            span.className += "ihc-level-label";
            //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].innerHTML = "Plan2";
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].style.display = 'none';
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].after(span);
        }
    }
    else if (planName == 'Plan3') {
        var plan = 3;
        //add cancel button in active plan and upgrade button in other
        $('.plan3-list').append('<a type="button"  class="btn btn-danger cancel-plan3">Cancel plan</a>');
        $('.plan2-list').append('<a type="button"  class="btn btn-primary upgrade-plan2">Upgrade plan</a>');
        //set the background of active plan in subscription tab
        $('.ihc-level-item-wrap').css('background', '#DE7070');
        $('.ihc-level-item-wrap:first-child').last().css('background', '#c63c3c');

        // change plan names of user profile
        //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].innerHTML = "PLATINUM";

        // change span text free to ACTIVE LAN
        $('#plan3-pricetext').text('ACTIVE PLAN');

        //hide Plan name from header bar profilepage
        document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].style.display = 'none';

        if($('#ihc_account_page_wrapp span').hasClass('ihc-level-name')){
            //document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].innerHTML = "Plan3";
            var span = document.createElement('span');
            span.innerHTML = 'PLATINUM';
            span.className += "ihc-level-label";
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].style.display = 'none';
            document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-account-subscr-list")[0].getElementsByClassName("ihc-level-name")[0].after(span);
        }

    }

    //hide Plan name from header bar profilepage
    // document.getElementById("ihc_account_page_wrapp").getElementsByClassName("ihc-middle-side")[0].getElementsByClassName("ihc-top-level-box")[0].style.display = 'none';

    listfeatures(plan);
    //remove bottom sigup buttons from sub plans
    $('.ihc-level-item-bottom').remove();
    //
    // $("#phone").intlTelInput({
    //     nationalMode: false
    // });
    // $("#phone1").intlTelInput({
    //     nationalMode: false
    //
    // });


    //Add cancel button in register form
    $('.page-id-5088 .ihc-tos-wrap').prepend('<a class="btn btn-primary redirect-to-intel" id="cancel_Btn"  href="/">Cancel</a>');

    //Conditions
    var sp = $('.ihc-member-photo').attr('src');
    if (sp) {
        var s = sp.replace(/\\/g, '/');
        s = s.substring(s.lastIndexOf('/') + 1);
        var dot = '.';
        if (s.indexOf(dot) != -1) {
            var url=$('.ihc-user-page-avatar img').attr('src');
            $('.page-id-5109 .ihc-wrapp-file-upload').before('<a id="image-name" href="'+ url + '">' + s + '</a>');
        }
        else {

        }
    }

    //Events
    //cancel and upgrade plan events
     function showCancelUpgradeMessage(message){
         $('#message-model p').text(message);
         $('#message-model').modal('show');
    }
    $('.cancel-plan2').click(function () {
        $('#cancel-plan2').modal('show');
    });
    $('#cancel-curr-plan2').click(function () {
        showCancelUpgradeMessage('You	have successfully downgraded to	SILVER.');
        ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 2, 0);
        ihc_buy_new_level_from_ap('Plan1', '', 1, '/user-profile?ihcnewlevel=true&lid=1&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    });

    $('.cancel-plan3').click(function () {
        $('#cancel-plan3').modal('show');
    });
    $('#cancel-curr-plan3').click(function () {
        showCancelUpgradeMessage('You	have successfully downgraded to	SILVER.');
        ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 3, 0);
        ihc_buy_new_level_from_ap('Plan1', '', 1, '/user-profile?ihcnewlevel=true&lid=1&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    });

    // $('.upgrade-plan3').click(function(){
    //     $('#upgrade-plan3').modal('show');
    // });
    // $('#upgrade-your-plan3').click(function(){
    //     var planName=$('.ihc-top-level-box ').text();
    //     if(planName=='Plan1'){
    //         ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 1, 0);
    //         ihc_buy_new_level_from_ap('Plan3', '10', 3, '/user-profile?ihcnewlevel=true&lid=3&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    //     }
    //     else if(planName=='Plan2'){
    //         ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 2, 0);
    //         ihc_buy_new_level_from_ap('Plan3', '10', 3, '/user-profile?ihcnewlevel=true&lid=3&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    //     }
    // else{
    //     ihc_buy_new_level_from_ap('Plan3', '10', 3, '/user-profile?ihcnewlevel=true&lid=3&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    // }
    // });

    $('.upgrade-plan2').click(function () {
        $('#upgrade-plan2').modal('show');
    });
    $('#upgrade-your-plan2').click(function () {
        showCancelUpgradeMessage('You have successfully upgraded to GOLD.');
        var planName = $('.ihc-top-level-box ').text();
        if (planName == 'Plan1') {
            ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 1, 0);
            ihc_buy_new_level_from_ap('Plan2', '10', 2, '/user-profile?ihcnewlevel=true&lid=2&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
        }
        else if (planName == 'Plan3') {
            ihc_set_form_i('#ihc_delete_level', '#ihc_form_ap_subscription_page', 3, 0);
            ihc_buy_new_level_from_ap('Plan2', '10', 2, '/user-profile?ihcnewlevel=true&lid=2&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
        }
        else{
            ihc_buy_new_level_from_ap('Plan2', '10', 2, '/user-profile?ihcnewlevel=true&lid=2&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
        }
    });

    $('.upgrade-plan1').click(function () {
        showCancelUpgradeMessage('You have successfully upgraded to SILVER.');
        ihc_buy_new_level_from_ap('Plan1', '', 1, '/user-profile?ihcnewlevel=true&lid=1&urlr=user-profile%3Fihc_ap_menu%3Dsubscription');
    });
    //cancel and upgrade plan events End

    $(document).on('keydown', function (e) {
        if (e.keyCode == 8 && $('.phn-num').is(":focus") && $('.phn-num').val().length < 3) {
            e.preventDefault();
        }
    });

    // links that redirect back to intel page
    $('.redirect-to-intel').click(function(){
            sessionStorage.setItem("redirect-to-intel","true");
    })

    //click events on plan selection of plans model Button
    $('.changePlan2').click(function(){
        $('input[name="lid"]').val(2);
        listfeatures(2);
        $('.change-plan').remove();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').append('<a style="margin-left: 20px"  class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
        $('.change-plans-model-closeBtn').click();
        $('#pdf-modal span').attr('id', 'thnkew-popup');
        $('#pdf-modal span').html('Your plan is changed to GOLD.');
        $('#pdf-modal p').html('');
        $('#pdf-modal p').css('all', 'unset');
        $('#pdf-modal').modal('show');
    });
    $('.changePlan1').click(function(){
        $('input[name="lid"]').val(1);
        listfeatures(1);
        $('.change-plan').remove();
        $('.ihc-register-col:nth-child(1) .iump-form-line-register:nth-child(10)>label').append('<a style="margin-left: 20px"  class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
        $('.change-plans-model-closeBtn').click();
        $('#pdf-modal span').attr('id', 'thnkew-popup');
        $('#pdf-modal span').html('Your plan is changed to SILVER.');
        $('#pdf-modal p').html('');
        $('#pdf-modal p').css('all', 'unset');
        $('#pdf-modal').modal('show');
    });

    $('body').on('click', '.ihc-wrapp-file-upload .ihc-delete-attachment-bttn', function () {
        $('#image-name').remove();
    });
    $('body').on('click', '#prk_menu_left_trigger', function () {
        $('.menu_at_top #prk_responsive_menu #menu_section .sf-menu>li:last-child').css('border-bottom', 'unset');
        $('#user-name-header').css('display', 'none');
    });
    $('body').on('mouseover', '.dropdown', function () {
        $('.dropdown-content').toggleClass('display-dropdown');
    });
    $('body').on('mouseout', '.dropdown', function () {
        $('.dropdown-content').toggleClass('display-dropdown');
    });


    $('body').on('click', '#request-for-upgrade', function () {
        $('#request-forupgrade').modal('show');
    });
    $('body').on('click', '#delete-account', function () {
        var email = globalVariables.userEmail;
        if (email == 'arslan.javaid@oneclout.com') {
            $('#pdf-modal span').attr('id', 'thnkew-popup');
            $('#pdf-modal span').html('You cannot delete admin account.');
            $('#pdf-modal p').html('');
            $('#pdf-modal p').css('all', 'unset');
            $('#pdf-modall').modal('hide');
            $('#pdf-modal').modal('show');
        }
        else {
            $('#pdf-modall').modal('show');
        }
    });
    $('body').on('click', '#unsub-me', function () {
         var email = globalVariables.userEmail;
         url = SCRIPT_PATH + "?action=unsubUser";
         var data = [{name: 'email', 'value': email}];
         $.post(url, data, function (response) {
             if(response){
                 var del_url = SCRIPT_PATH + "?action=deleteUser";
                 deleteUser(del_url,data);
             }
         });
    });
    $('body').on('click', '#remain-sub', function () {
        var email = globalVariables.userEmail;
        var data = [{name: 'email', 'value': email}];
        var del_url = SCRIPT_PATH + "?action=deleteUser";
        deleteUser(del_url,data);
    });

    $('body').on('click', '#delete-account-cnfrm', function () {
        // var interests=globalVariables.userSubscriptions.interests;
        // var flag=false;
        var email = globalVariables.userEmail;
        url = SCRIPT_PATH + "?action=deleteUser";
        var data = [{name: 'email', 'value': email}];
        // $.each(interests, function (j, res) {
        //     if(res==true){
        //         flag=true;
        //     }
        // });
        if(globalVariables.userSubscribed==true){
            $('#pdf-modall').modal('hide');
            $('#unsub-modal').modal('show');
        }
        else {
            deleteUser(url,data);
        }
    });

    function deleteUser(url,data){

        $.post(url, data, function (response) {
            if (response) {

                $('#pdf-modal span').attr('id', 'thnkew-popup');
                $('#pdf-modal span').html('Your account has been successfully deleted.');
                $('#pdf-modal p').html('');
                $('#pdf-modal p').css('all', 'unset');
                $('#pdf-modall').modal('hide');
                $('#unsub-modal').modal('hide');
                $('#pdf-modal').modal('show');
                window.location.href = "/";

            }
        });

    }


    $('body').on('click', '#requestForUpgrade', function () {
        var fields = $('#sidebarForm').serializeArray();
        var isValid = $("#phone").intlTelInput("isValidNumber");
        var phone = $('#phone').val();
        if ($('#request-user').val() == '' || $('#request-user').val().length < 3) {
            error = 'User Name should not be empty and contain more than 3 characters.';
            $('#pdf-modal span').html('');
            $('#pdf-modal p').html(error).css({'border': '1px solid #f00', padding: '5px'});
            $('#pdf-modal').modal('show');
            return false;
        }
        else if (!phone.match(/^\d+$/) && !$.isNumeric(phone)) {
            error = 'Phone number should not be empty and should contain only numbers.';
            $('#pdf-modal span').html('');
            $('#pdf-modal p').html(error).css({'border': '1px solid #f00', padding: '5px'});
            $('#pdf-modal').modal('show');
            return false;
        }
        else if (isValid == false) {
            error = 'Please enter a valid phone number.';
            $('#pdf-modal span').html('');
            $('#pdf-modal p').html(error).css({'border': '1px solid #f00', padding: '5px'});
            $('#pdf-modal').modal('show');
            return false;

        }
        else if ($('#pdfrequestMessage').val().length < 10) {
            error = 'Message box should contain at least 10 characters.';
            $('#pdf-modal span').html('');
            $('#pdf-modal p').html(error).css({'border': '1px solid #f00', padding: '5px'});
            $('#pdf-modal').modal('show');
            return false;
        }

        fields.push({name: 'user', value: $('#request-user').val()});
        var phone = $("#phone").intlTelInput("getNumber");
        fields.push({name: 'phnNum', value: phone});
        fields.push({name: 'Message', value: $('#pdfrequestMessage').val()});
        var url = SCRIPT_PATH + '?action=requestforPDFdownloads';
        var that = this;
        $('#pdf-modal span').attr('id', 'thnkew-popup');
        $('#request-forupgrade').modal('hide');
        $('#pdf-modal span').html('Thank you for an upgrade request. We will contact you as soon as we can.');
        $('#pdf-modal p').html('');
        $('#pdf-modal p').css('all', 'unset');
        $('#pdf-modal').modal('show');
        $.post(url, fields, function (response) {
            if (response.success) {
              // submitted
            }
        }, 'json');
    });

    $(document).on('change', 'select.ind-sec', function (e) {
        var value = $('.ind-sec option:selected').text();
        if (value == 'other') {
            $('#other-field').css('display', 'block');
            if (!$('#other-field').length) {
                //$('.iump-form-line-register:nth-child(3)').last().append('<input type="text" placeholder="Please specify" name="ump_industry" id="other-field" class="iump-form-select ">');
                $('<input type="text" placeholder="Please specify" name="ump_industry" id="other-field" class="iump-form-select ">' ).insertAfter(".ind-sec");
            }
        }
        else {
            $('#other-field, .ind-sec-error ').css('display', 'none');
        }
    });

    $(document).on('change', 'select.job-tit', function (e) {
        var value = $('.job-tit option:selected').text();
        if (value == 'other') {
            $('#job-field').css('display', 'block');
            if (!$('#job-field').length) {
                //$('.iump-form-line-register:nth-child(3)').last().append('<input type="text" placeholder="Please specify" name="ump_jobtitle" id="job-field" class="iump-form-select "><p class="other-fields-error">* This is a mandatory information.</p>');
                $('<input type="text" placeholder="Please specify" name="ump_jobtitle" id="job-field" class="iump-form-select ">' ).insertAfter(".job-tit");
            }
        }
        else {
            $('#job-field, .job-title-error').css('display', 'none');
        }
    });

    //functions

    function setfeatures() {
        var plan = getUrlParameter('lid');
        listfeatures(plan);
    }

    function getUrlParameter(sParam){
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('?'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

});

//others
$(window).resize(function (event) {
    // get the width of the screen after the resize event
    var width = document.documentElement.clientWidth;
    if (width > 1300) {
        $('#user-name-header').css('display', 'block');
    }
});
