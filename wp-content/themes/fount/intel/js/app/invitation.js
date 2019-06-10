var oInvitation = {
    init: function () {
        var id = $('#review-report-id').val();
        $('#reportId123').val(id);
        $('#reportId-invite-all').val(id);
        $('#email-message').hide();
        $('#saved-review-modal').modal('hide');
        $('#invite-options-modal').modal('show');
    },

    populateUsername: function () {
        var url = SCRIPT_PATH + '?action=populateUsername';
        $.post(url, function (response) {
            if (response.success) {
                var usernameSelect = document.getElementById('invite_username');
                $.each(response.username, function (i, rev) {
                    var usernameOption = document.createElement('option');
                    usernameOption.innerHTML = rev.firstname + ' ' + rev.lastname;
                    usernameOption.value = rev.username;
                    usernameSelect.appendChild(usernameOption);
                });
            }
            else {
            }
        }, 'json');
    },

    checkInviteType: function () {
        $(".imgProgressInviteAll img").show();
        var reportId = document.getElementById('reportId-invite-all').value;
        if (document.getElementById('reviewers-note').value) {
            var reviewerNote = document.getElementById('reviewers-note').value;
        } else {
            var reviewerNote = null;
        }

        if (document.getElementById('specific_user').checked) {
            var email = document.getElementById('email-invite-hidden-input').value;
            oInvitation.invitereviewer(email, reportId, reviewerNote);
        }

        else if (document.getElementById('all_user').checked)
            oInvitation.emailAllReviewers(reportId, reviewerNote);

        else if (document.getElementById('specific_username').checked) {
            var username = document.getElementById('invite_username').value;
            oInvitation.inviteByUsername(username, reportId, reviewerNote);
        } else if (document.getElementById('all_user_by').checked) {
            if (document.getElementById('all_reporting_code').checked) {
                var reportingCode = document.getElementById('invite-reporting-code').value;
                oInvitation.inviteAllReportingCode(reportId, reviewerNote, reportingCode);

            } else if (document.getElementById('all_stocks').checked) {
                var stocks = document.getElementById('invite-marketing').value;
                oInvitation.inviteAllMarketing(reportId, reviewerNote, stocks);

            } else if (document.getElementById('all_commodity_experience').checked) {
                var commodity = document.getElementById('invite-commodity-experience').value;
                oInvitation.inviteAllCommodity(reportId, reviewerNote, commodity);

            }
        }
    },

    inviteByUsername: function (username, reportId, reviewerNote) {
        var fields = {'username': username, 'reportId': reportId, 'reviewerNote': reviewerNote};

        var url = SCRIPT_PATH + '?action=inviteReviewerUsername';
        $.post(url, fields, function (response) {
            if (response.success) {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        }, 'json');
    },

    invitereviewer: function (email, reportId, reviewerNote) {

        var fields = {'reportId': reportId, 'email': email, 'reviewerNote': reviewerNote};

        var url = SCRIPT_PATH + '?action=invitereviewer';
        $.post(url, fields, function (response) {
            if (response.success) {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        }, 'json');
    },

    emailAllReviewers: function (reportId, reviewerNote) {
        var feilds = {'id': reportId, 'reviewerNote': reviewerNote};
        var url = SCRIPT_PATH + '?action=emailAllReviewers';
        $.post(url, feilds, function (response) {
            if (response.success) {
                $('#invite-options-modal').modal('hide');
                $(".imgProgressInviteAll img").hide();
                $('#invitationSent-modal').modal('show');
            } else {
                $(".imgProgressInviteAll img").hide();
            }
        }, 'json');
    },

    inviteAllReportingCode: function (reportId, reviewerNote, reportingCode) {
        var fields = {'reportId': reportId, 'reportingCode': reportingCode, 'reviewerNote': reviewerNote};

        var url = SCRIPT_PATH + '?action=inviteAllCode';
        $.post(url, fields, function (response) {
            if (response.success) {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        }, 'json');
    },

    inviteAllMarketing: function (reportId, reviewerNote, stocks) {
        var fields = {'reportId': reportId, 'stocks': stocks, 'reviewerNote': reviewerNote};

        var url = SCRIPT_PATH + '?action=inviteAllMarketing';
        $.post(url, fields, function (response) {
            if (response.success) {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        }, 'json');
    },

    inviteAllCommodity: function (reportId, reviewerNote, commodity) {
        var fields = {'reportId': reportId, 'commodity': commodity, 'reviewerNote': reviewerNote};

        var url = SCRIPT_PATH + '?action=inviteAllCommodity';
        $.post(url, fields, function (response) {
            if (response.success) {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else {
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        }, 'json');
    },

    cancelinviteOnMap: function () {
        $('#invite-options-modal').modal('hide');
        $('#submit-review-modal').modal('hide');
    },

    unsubscribe:function(){
        var fields = $('#mce-EMAIL').val();
        var fields = $('#frm-subscribe-form').serialize();
        var url = SCRIPT_PATH + '?action=unsubscribe';
        var that = this;
        // Disable submit button

        $.post(url, fields, function(response) {
            if (response.success) {

            }
            $('#subscribe-modal').modal('hide');
            $('#un-subscribe-modal').modal('show');
        });

    },

    subscribe : function(){
         var fields = $('#frm-subscribe-form').serialize();
        var url = SCRIPT_PATH + '?action=subscribe';
        var that = this;
        // Disable submit button
       
        $.post(url, fields, function(response){
           if(response.success){

               // send email
               $('#subscriber-token').val(response.token);
                var fields = $('#frm-subscribe-form').serialize();
        var url = SCRIPT_PATH + '?action=subscribe_mail';
        $.post(url, fields, function(response){
            if(response.success){
                console.log('Email send');
                oRsc.unsublink=response.linkUnsubscribe;
            }else{
                // Todo: Display error msg
                $('#subscribe-modal').modal('hide');
                $(".processing img").hide();
                var text = 'Sorry !';
                var text2 = 'You have already subscribed ';
                $('#subscribe-thankyou-modal h').html(text);
                $('#subscribe-thankyou-modal p').html(text2);
                $('#subscribe-thankyou-modal').modal('show');
            }
        },'json');
    
                // Show Thanku popup
                var fields = $('#mce-EMAIL').val();
                var name=$('#subscriber-name').val();
                console.log(fields);
                var url = 'https://rscmme.us5.list-manage.com/subscribe/post?u=2ccf06e2022ac43c8d1935fa5&amp;id=7a7174148c';
                var that = this;
                var one=0;
                var two=0;
                var three=0;
                var four=0;
                var five=0;
                first=$('#one').is(":checked");
                if(first==true)
                    one=1;
                second=$('#two').is(":checked");
                    if (second==true)
                        two=1;
                third=$('#three').is(":checked");
                         if(third=1)
                             three=1;
                fourth=$('#four').is(":checked");
                             if(fourth==1)
                                 four=1;

                fifth=$('#five').is(":checked");
                if(fifth==1)
                    five=1
        data={MERGE1:name,EMAIL: fields,'group[19541][1]':one,'group[19541][2]':two,'group[19541][8]':four,'group[19541][16]':five};
                $(".processing img").show();
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: url,
                    data: data,
                    success: function () {
                        $('#subscribe-modal').modal('hide');
                        $(".processing img").hide();
                        //send email
                         $('#subscriber-token').val(response.token);

                        // Show Thanku popup
                        var text = 'Thank you for subscribing to our weekly report !';
                        var text2 = ' There is just one more step. We sent you a confirmation email with a link to activate your subscription.Please check your email and click the link.This helps to ensure that your (and our) inbox remains free of spam.We will never share your email with anyone, and you may unsubscribe at any time.<br>Kind regards,<br>The RSC Mineral Intelligence Team';
                        $('#subscribe-thankyou-modal h').html(text);
                        $('#subscribe-thankyou-modal p').html(text2);
                        $('#subscribe-thankyou-modal').modal('show');
                    }, error: function (jqXHR, Exception, error) {
                        $('#subscribe-modal').modal('hide');
                        $(".processing img").hide();
                         //send email
                        // $('#subscriber-token').val(response.token);
                           var text = 'Thank you for subscribing to our weekly report !';
                           var text2 = ' There is just one more step. We sent you a confirmation email with a link to activate your subscription.Please check your email and click the link.This helps to ensure that your (and our) inbox remains free of spam.We will never share your email with anyone, and you may unsubscribe at any time.<br>Kind regards,<br>The RSC Mineral Intelligence Team';
                           $('#subscribe-thankyou-modal h').html(text);
                           $('#subscribe-thankyou-modal p').html(text2);
                           $('#subscribe-thankyou-modal').modal('show');
                    }
                });
            
           }else{
              //  Todo: Display error msg
                $('#subscribe-modal').modal('hide');
                $(".processing img").hide();
                var text = 'Sorry !';
                var text2 = 'You have already subscribed ';
                $('#subscribe-thankyou-modal h').html(text);
                $('#subscribe-thankyou-modal p').html(text2);
                $('#subscribe-thankyou-modal').modal('show');
           }
            
            
            // Reset Form
            document.getElementById("frm-subscribe-form").reset();
       },'json');
       
    },

    // subscribe_mail : function(){
    //     //var fields = $('#mce-EMAIL').val();
    //     var fields = $('#frm-subscribe-form').serialize();
    //     var url = SCRIPT_PATH + '?action=subscribe_mail';
    //     $.post(url, fields, function(response){
    //         if(response.success){
    //             console.log('Email send')
    //         }else{
    //             // Todo: Display error msg
    //         }
    //     },'json');
    // }
    
 };
