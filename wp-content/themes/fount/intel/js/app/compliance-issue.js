/**
 * Created by ARslan on 12/15/2017.
 */

oRsc.toggleComplianceIssue = function(elem){
    var $btn = $('#comp-submit-btn');
    if($(elem).is(':checked')){
        $btn.attr('disabled', false);
        $('#compliance-comments').prop('disabled', false);
    }else{
        $btn.attr('disabled', true);
        $('#compliance-comments').prop('disabled', true);
    }
};
oRsc.checkmessage = function(elem){
    var $btn = $('#comp-submit-btn');
    $btn.attr('disabled', false);
    $('#checked').prop('checked',true);
    $("#checked").on("click", false);
    if($('#checked').prop("checked")==true){
    }
    else{
        $('#compliance-comments').prop('disabled', true);
        $btn.attr('disabled', true);
    }
};
oRsc.complianceIssue = function(id,date,company,project,code,type,cpqp){
    var fields = this.getReportDetailById(id);
    fields.report_id  = id;
    fields.comments  = $('#compliance-comments').val();
    fields.date=date;
    fields.company=company;
    fields.project=project;
    fields.code=code;
    fields.type=type;
    fields.cpqp=cpqp;

    var url = SCRIPT_PATH + '?action=complianceIssue';
    var that = this;
    // Show Thanku popup
    var text = 'Thank you for your submission.',
    error = 'Briefly describe the compliance issue or data error (minimum 10 characters).';
    $('#compliane-issue-popup p').html('').css({'border': '',padding:''});
    $('#compliane-issue-popup span').html('');
    if($('#compliance-comments').val().length < 10)
    {
        $('#compliane-issue-popup p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#compliane-issue-popup').modal('show');
        return false;
    }
    else
    {
        var that = this, $layerToggle = $("#layer-toggle");
        var sone = [];
        sone['action'] = 'button:submit compliance';
        sone['action_log'] = $('#compliance-comments').val();
        sone['mode']=$('.region-button-on').text();
        oRsc.activity_log(sone);
        that.runFilter();
        $('#compliane-issue-popup span').html("<b>Thank you for your feedback.</b> Our RSC Intelligence team will try to attend to your feedback within one business day. If you left your email address then we will reply personally. Please don't hesitate to contact us at <a href='mailto:intel@rscmme.com?subject=Compliance Issue'>intel@rscmme.com</a>.");
        $('#compliane-issue-popup').modal('show');
    }
    $.post(url, fields, function(response){
        if(response.success){
            console.log('Thank you for your submission.');
        }
    },'json');

};


oRsc.SendFeedback = function(){
    
    var fields = $('#sidebarForm').serializeArray();
    fields.push({name: 'review', value: $('#review').val()});
    fields.push({name: 'from', value: $('#from').val()});
    fields.push({name: 'email', value: $('#email').val()});

    if($('#from').val().length < 2){
        error = 'Please tell us your name(min of 2 characters required).';
        $('#subscribe-thankyou-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#subscribe-thankyou-modal h').html('');
        $('#subscribe-thankyou-modal').modal('show');
        return false;
    }

    if($('#review').val().length < 10)
    {
        error = 'Please use a minimum of 10 characters for your comment. Thank you.';
        $('#subscribe-thankyou-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#subscribe-thankyou-modal h').html('');
        $('#subscribe-thankyou-modal').modal('show');
        return false;
    }
    var url = SCRIPT_PATH + '?action=SendFeedback';
    var that = this;  
    $('#feedback-modal').modal('hide');
    $('#compliane-issue-popup span').html('');
    $('#compliane-issue-popup p').html('');
    $('#compliane-issue-popup p').css('all','unset');
    $('#compliane-issue-popup span').html("<b>Thank you for your feedback.</b> Our RSC Intelligence team will try to attend to your feedback within one business day. If you left your email address then we will reply personally. Please don't hesitate to contact us at <a href='mailto:intel@rscmme.com?subject=Compliance Issue'>intel@rscmme.com</a>.");
    $('#compliane-issue-popup').modal('show');
    $('#subscribe-thankyou-modal h').html('Thank you for your feedback.');
    $('#subscribe-thankyou-modal p').html('');
    $('#subscribe-thankyou-modal p').css('all','unset');
    // $('#subscribe-thankyou-modal').modal('show'); 
    $.post(url, fields, function(response){
        if(response.success){
            console.log('Thank you for your submission.');
        }
    },'json');
    $('#from').val('');
    $('#email').val('');
    $('#review').val(''); 
};

oRsc.requestforPDFdownloads = function(){
    var fields = $('#sidebarForm').serializeArray();
    var isValid = $("#phone").intlTelInput("isValidNumber");
    var phone=$('#phone').val();
    if($('#request-user').val()=='' || $('#request-user').val().length<3){
        error = 'User Name should not be empty and contain more than 3 characters.';
        $('#pdf-modal h').html('');
        $('#pdf-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#pdf-modal').modal('show');
        return false;
    }
    else if(!phone.match(/^\d+$/) && !$.isNumeric(phone)){
        error = 'Phone number should not be empty and should contain only numbers.';
        $('#pdf-modal h').html('');
        $('#pdf-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#pdf-modal').modal('show');
        return false;
    }
    else if(isValid==false){
            error = 'Please enter a valid phone number.';
            $('#pdf-modal h').html('');
            $('#pdf-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
            $('#pdf-modal').modal('show');
            return false;

    }
    else if($('#pdfrequestMessage').val().length<10){
        error = 'Message box should contain atleast 10 characters..';
        $('#pdf-modal h').html('');
        $('#pdf-modal p').html(error).css({'border': '1px solid #f00',padding:'5px'});
        $('#pdf-modal').modal('show');
        return false;
    }

    fields.push({name: 'user', value: $('#request-user').val()});
    var phone=$("#phone").intlTelInput("getNumber");
    fields.push({name: 'phnNum', value: phone});
    fields.push({name: 'Message', value: $('#pdfrequestMessage').val()});
    var url = SCRIPT_PATH + '?action=requestforPDFdownloads';
    var that = this;
    $('#pdf-modal h').attr('id','thnkew-popup');
    $('#pdf-limit-notifier').hide();
    $('#pdf-modal h').html('Thank you for an upgrade request. We will contact you as soon as we can.');
    $('#pdf-modal p').html('');
    $('#pdf-modal p').css('all','unset');
    $('#pdf-modal').modal('show');
    $.post(url, fields, function(response){
        if(response.success){
            console.log('Thank you for your submission.');
        }
    },'json');
};

