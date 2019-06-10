/**
 * Created by shahzaib on 11/01/2019.
 */

var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';

var register={

};

$(document).ready(function () {
    if ($('.page-id-5088').is(':visible')) {

        // *** click on register btn event***/
        var registerbtn = $('.page-id-5088 #ihc_submit_bttn');
        registerbtn.click(function (e) {
            var tc = $('input[name="tos"]').prop('checked');
             if(tc!=true){
                 $('.ihc-tos-wrap').prepend('<div class="error-on-terms" style="display: block!important;"> Please agree to our Terms &amp; Conditions</div>');
                 e.preventDefault();
                 return
             }
             $('.error-on-terms').hide();
            if($('#job-field').is(":visible")){
                var job_field=$('#job-field').val();
                if(job_field.length>0){
                    $('.select-custom-job-filed').val(job_field);
                }
            }
            if($('#other-field').is(":visible")){
                var industry_field=$('#other-field').val();
                if(industry_field.length>0){
                    $('.select-custom-industry-sector').val(industry_field);
                }
            }


            $('.iump-submit-form').css('pointer-events','none');
            setTimeout(function(){
                $('.iump-submit-form').css('pointer-events','');
            },2000);
            $('#loading-spin-markers').show();
            var email = $('input[name="user_email"]').val();
            url = SCRIPT_PATH + "?action=IsEmailexist";
            var data = {name: 'email', 'value': email};
            $.post(url, data, function (response) {
                console.log(response);
                if (response.success) {
                    $('#loading-spin-markers').hide();
                    $('#pdf-modal span').attr('id', 'thnkew-popup');
                    $('#pdf-modal span').html('Email is invalid or already taken.');
                    $('#pdf-modal p').html('<a class="lost-pass-link" href="/resetpassword">Lost your password?</a>');
                    $('#pdf-modal p').css('all', 'unset');
                    $('#pdf-modal').modal('show');
                }
                else{
                    var companyLength = $('input[name="ump_company"]').val().length;
                    if(companyLength < 3)
                    {
                        $('#loading-spin-markers').hide();
                        $('#pdf-modal span').html('Company name should contain atleast 3 letters.');
                        $('#pdf-modal').modal('show');
                        return;
                    }
                    var scrollup=setInterval(function(){
                        var errors=$('.ihc-register-notice');
                        if(errors.length>0) {
                            $('.ihc-register-notice').css('display', 'inline');
                            $('#loading-spin-markers').hide();
                            if( (tc==true) && ($('.ihc-tos-wrap .ihc-register-notice').is(':visible'))){
                                    $('.ihc-tos-wrap .ihc-register-notice').hide();
                            }
                            if(!$('.ihc-tos-wrap .ihc-register-notice').is(':visible')) {
                                $("html, body").animate({scrollTop: 100}, "slow");
                            }
                            clearInterval(scrollup);
                        }
                    }, 1000);
                    //subscribe user to the mailchimp
                    var pass1 = $('input[name="pass1"]').val();
                    var pass2 = $('input[name="pass2"]').val();
                    var tc = $('input[name="tos"]').prop('checked');
                    var first_name=$('input[name="first_name"]').val();
                    var last_name=$('input[name="last_name"]').val();
                    var industry=$('.ind-sec :selected').val();
                    var job_title=$('.job-tit :selected').val();
                    if (pass1.length > 5 && pass2.length > 5 && tc == true && first_name!='' && last_name!='' &&  industry!='' && job_title!=''  ) {
                        clearInterval(scrollup);
                        $('.ihc-register-notice').remove();
                        $('.page-id-5088 #ihc_submit_bttn').attr('disabled',true);
                        addupdateSub();
                    }
                }
            }, 'json');
        });

        function addupdateSub() {
            var data = {
                // interests: [],
                i: 0,
                email: $('input[name="user_email"]').val(),
                first_name: $('input[name="first_name"]').val(),
                last_name: $('input[name="last_name"]').val(),
                company: $('input[name="ump_company"]').val(),
                job_title: $('.job-tit :selected').val(),
                ind_sector: $('.ind-sec :selected').val(),
                plan:$('input[name=lid]').val()

            };
            // $('input[name="ump_sub[]"]').each(function () {
            //     if ($(this).prop('checked') == true) {
            //         data.interests[data.i] = true;
            //         data.i++;
            //     }
            //     else {
            //         data.interests[data.i] = false;
            //         data.i++;
            //     }
            // });

            if (data.email != '' && data.first_name != '' && data.last_name != '') {
                sessionStorage.setItem("newRegUser",JSON.stringify(data) );
                var data=JSON.parse(sessionStorage.getItem("newRegUser"));
                console.log(data);
            }
            else {
                console.log('error');
            }
        }


        // *** click on register btn event   END***/

        // *** on focus out of email input field check subscription status ***//

        $('body').on('focusout', 'input[name="user_email"]', function () {

            var email = $('input[name="user_email"]').val();
            var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var status = emailReg.test(email);
            if (status == true) {
                $('#loading-spin-markers').show();
                url = SCRIPT_PATH + "?action=checkSubStatus";
                var data = {name: 'email', 'value': email};
                $.post(url, data, function (response) {
                    $('#loading-spin-markers').hide();
                    var res = JSON.parse(response);
                    console.log(res);
                    if (res.success=="true") {
                        if(res.registered=="true"){
                            $('#pdf-modal span').attr('id', 'thnkew-popup');
                            $('#pdf-modal span').html('Email is invalid or already taken.');
                            $('#pdf-modal p').html('<a class="lost-pass-link" href="/resetpassword">Lost your password?</a>');
                            $('#pdf-modal p').css('all', 'unset');
                            $('#pdf-modal').modal('show');
                        }
                        else if (res.status == 'notsubscribed') {
                            $('input[name="first_name"]').val('');
                            $('input[name="last_name"]').val('');
                            $('.subs').attr('disabled', false);
                            $('#update-sub').remove();
                            $('input[name="ump_sub[]"]').each(function () {
                                $(this).prop('checked', true);
                            });
                            $('.ihc-register-notice').css('display','unset');
                        }
                        else {
                            var urlforPref = 'https://rscmme.us5.list-manage.com/profile/?u=2ccf06e2022ac43c8d1935fa5&id=7a7174148c&e=' + res.key + '';
                            $('#update-sub').remove();
                            $('.iump-form-checkbox').last().after('<p class="update-sub-link"><a target="_blank" id="update-sub" href="#">Update your subscriptions</a></p>');
                            $('#update-sub').attr("href", urlforPref);
                            $('.subs').attr('disabled', true);
                            $('#pdf-modal span').removeAttr('id');
                            $('#pdf-modal span').html("Great. You are already receiving our newsletters. We have now linked your email address so you don't receive our newsletters twice. Feel free to update your subscription in the section below.");
                            $('#pdf-modal span').css('padding','0');
                            $('#pdf-modal p').html('');
                            $('#pdf-modal p').css('all', 'unset');
                            $('#pdf-modall').modal('hide');
                            $('#pdf-modal').modal('show');
                            if (res.fName != '')
                                $('input[name="first_name"]').val(res.fName);
                            if (res.lName != '')
                                $('input[name="last_name"]').val(res.lName);
                            var i = 0;
                            var flag = 0;
                            $('input[name="ump_sub[]"]').each(function () {
                                $(this).prop('checked', false);
                            });
                            $('input[name="ump_sub[]"]').each(function () {
                                if (i == 0 && res.interests['a920a88b86'] == true) {
                                    $(this).prop('checked', true);
                                    i++;
                                    flag++;
                                }
                                else if (i == 1 && res.interests['8500277a5b'] == true) {
                                    $(this).prop('checked', true);
                                    i++;
                                    flag++;
                                }
                                else if (i == 2 && res.interests['3cea326dc3'] == true) {
                                    $(this).prop('checked', true);
                                    i++;
                                    flag++;
                                }
                                else {
                                    i++;
                                }
                            });
                            if (flag == 0) {
                                $('input[name="ump_sub[]"]').each(function () {
                                    $(this).prop('checked', false);
                                });
                            }
                            else {
                                //do nothing
                            }
                        }
                    }

                });
            }
            else {
                $('#loading-spin-markers').hide();
            }
        });

        // *** on focus out of email input field check subscription status END ***//

        //initialize everything
        for (i=0;i<=6;i++){
            jQuery('.page-id-5088 form>:nth-child(2) .iump-form-line-register:nth-child(5) .iump-form-checkbox-wrapper:nth-child(3)').append('<div class="iump-form-checkbox" style="visibility:hidden;margin-right: 10px;"><span style="color: red">✕</span><input type="checkbox" name="ump_sub[]" id="" class="subs" value="RSC News (occasionally)">RSC News (occasionally)</div>');
        }
    }
});