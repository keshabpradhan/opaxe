/**
 * Created by shahzaib on 11/01/2019.
 */

var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';
var url = SCRIPT_PATH + "?action=userMembershipLevels";

$(document).ready(function () {

    $("#edituser").on("input", function() {
        // do whatever you need to do when something's changed.
        // perhaps set up an onExit function on the window
        // console.log('change');
        $('#ihc_submit_bttn').show();
    });


    $("#edituser input[type=text], #edituser input[type=email], #edituser input[type=password], #edituser select").on('input',function(){
        $(this).parent().find("div.ihc-register-notice").hide()
    });

    $("#createuser input[type=text], #createuser input[type=email], #createuser input[type=password], #createuser select").on('input',function(){
        $(this).parent().find("div.ihc-register-notice").hide()
    });

    if ($('.page-id-5109').is(':visible')) {

        // .........................update password rules and implementation
        $('input[name="pass1"], input[name="pass2"]').focusout(function () {
            var newpass = $("input[name=pass1]").val();
            var cnfrmpass = $("input[name=pass2]").val();
            if (newpass.length > 5 && cnfrmpass.length > 5)
                $('#update-pass').show();
            else
                $('#update-pass').hide();
        });

        //......................................... Hide password error messages when user start typing
        $('input[name="pass1"], input[name="pass2"], input[name="verify-pass"]').keypress(function () {
            $('.iump-form-password .ihc-register-notice').hide();
        });

        $('body').on('click', '#update-pass', function () {

            var newpass = $("input[name=pass1]").val();
            var cnfrmpass = $("input[name=pass2]").val();
            var email = $("input[name=user_email]").val();
            var data = [{name: 'reset', 'value': email}, {name: 'pass', 'value': newpass}];

            //define password rules and email rules
            var upper_text = new RegExp('[A-Z]');
            var lower_text = new RegExp('[a-z]');
            var number_check = new RegExp('[0-9]');
            var isEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            url = SCRIPT_PATH + "?action=resetpassword";

            //check validation
            var flag = 0;
            if (!isEmail.test(email)) {
                error = 'Please enter valid email address.';
                flag++
            } else if (newpass == '') {
                error = 'Please choose a password.';
                flag++;
            } else if (!newpass.match(upper_text)) {
                error = 'Use at least one upper case letter.';
                flag++;
            } else if (!newpass.match(lower_text)) {
                error = 'Use atleast one lower case letter.';
                flag++;
            } else if (!newpass.match(number_check)) {
                error = 'Use atleast one digit.';
                flag++;
            } else if (newpass.length < 6) {
                error = 'Password must contains 6 letters.';
                flag++;
            } else if (newpass != cnfrmpass) {
                error = 'Password do not match.';
                flag++;
            }

            if (flag > 0) {
                $('#pdf-modal .modal-body span').empty();
                $('#pdf-modal .modal-body p').html(error).css({'border': '1px solid #f00', padding: '5px'});
                $('#pdf-modal').modal('show');
            } else {
                $.post(url, data, function (response) {
                    if (response) {
                        $('#pdf-modal span').attr('id', 'thnkew-popup');
                        $('#pdf-modal span').html('Your password is successfully updated.');
                        $('#pdf-modal p').html('');
                        $('#pdf-modal p').css('all', 'unset');
                        $('#pdf-modal').modal('show');
                    }

                });
            }
        });


        //..... update job title and industry sectory if user choose other field
        var submitbtn = $('.page-id-5109 #ihc_submit_bttn');

        submitbtn.click(function () {

            if ($('#job-field').is(":visible")) {
                var job_field = $('#job-field').val();
                if (job_field.length > 0) {
                    $('.select-custom-job-filed').val(job_field);
                }
            }

            if ($('#other-field').is(":visible")) {
                var industry_field = $('#other-field').val();
                if (industry_field.length > 0) {
                    $('.select-custom-industry-sector').val(industry_field);
                }
            }

            var data = {
                i: 0,
                email: $('input[name="user_email"]').val(),
                first_name: $('input[name="first_name"]').val(),
                last_name: $('input[name="last_name"]').val(),
                company: $('input[name="ump_company"]').val(),
                job_title: $('.job-tit :selected').val(),
                ind_sector: $('.ind-sec :selected').val(),
            };

            if (data.email != '' && data.first_name != '' && data.last_name != '' && data.job_title != '' && data.ind_sector != '' && data.company != '') {
                addUpdateMailchimpUser(data);
            }
            else {
                console.log('error');
            }

        });

        function addUpdateMailchimpUser(data) {

            url = SCRIPT_PATH + "?action=addUpdateMailchimpUser";

            if (data) {
                $.post(url, data, function (response) {
                    if (response) {
                        console.log(response);
                    }
                });
            }

        }

        function getuserSubscriptions() {

            var email = $('input[name=user_email]').val();
            var i = 0;
            var url = SCRIPT_PATH + "?action=checkSubStatus";
            var data = {name: 'email', 'value': email};

            $.post(url, data, function (response) {
                if (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    globalVariables.userSubscriptions = res;
                    if (res.status == 'subscribed') {
                        globalVariables.userSubscribed = true;
                        $('.page-id-5109 form>:nth-child(2) .iump-form-line-register:nth-child(5)>label').append('<a style="margin-left: 20px" class="change-plan" onclick="changeplan()" href="#">Change plan</a>');
                        var urlforPref = 'https://rscmme.us5.list-manage.com/profile/?u=2ccf06e2022ac43c8d1935fa5&id=7a7174148c&e=' + res.key + '';
                        $('.iump-form-checkbox-wrapper').last().after('<p class="update-sub-link"><a target="_blank" id="update-sub" href="#">Update your subscriptions</a></p>');
                        $('#update-sub').attr("href", urlforPref);
                        // $.each(res.interests, function (j, res) {
                        //     i = i + 1;
                        //     if (res == true) {
                        //         $('.page-id-5109 form>:nth-child(2) .iump-form-line-register:nth-child(5) .iump-form-checkbox:nth-child(' + i + ')').prepend('<span>✓</span>').css('margin-right', '10px');
                        //     } else {
                        //         $('.page-id-5109 form>:nth-child(2) .iump-form-line-register:nth-child(5) .iump-form-checkbox:nth-child(' + i + ')').prepend('<span style="color: red">✕</span>').css('margin-right', '10px');
                        //     }
                        //
                        // });
                    } else {
                        $('.page-id-5109 form>:nth-child(2) .iump-form-line-register:nth-child(5) .iump-form-checkbox').prepend('<span style="color: red">✕</span>').css('margin-right', '10px');
                        $('.page-id-5109 .iump-form-checkbox-wrapper').last().after('<p class="subscribe-to-newsletter"><a target="_blank" href="https://rscmme.us5.list-manage.com/subscribe?u=2ccf06e2022ac43c8d1935fa5&id=7a7174148c">Subscribe to our Newsletter</a></p>');
                    }

                }
            });

        }

        //.................initialize evrything
        for (i = 0; i <= 5; i++) {
            jQuery('.page-id-5109 form>:nth-child(2) .iump-form-line-register:nth-child(5) .iump-form-checkbox-wrapper:nth-child(3)').append('<div class="iump-form-checkbox" style="visibility:hidden;margin-right: 10px;"><span style="color: red">✕</span><input type="checkbox" name="ump_sub[]" id="" class="subs" value="RSC News (occasionally)">RSC News (occasionally)</div>');
        }

        $('.page-id-5109 .job-tit').append('<option class="select-custom-job-filed" value="" >other</option>');
        $('.page-id-5109 .ind-sec').append('<option class="select-custom-industry-sector" value="" >other</option>');

        getuserSubscriptions();
    }

});