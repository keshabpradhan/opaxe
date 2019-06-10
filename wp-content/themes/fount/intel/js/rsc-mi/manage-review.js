var oManageReview = {
    init : function(){
        $('#modal-launcher').hide();
        $('#delete-modal').modal('hide');
        this.getReview();
        $('#invite-options-modal').modal('hide');
        $(".rating").rating('create');
        // Initialize Reviewer invitation
        oReview.initInviteReviewer();
    },

    getReview : function(){
        var url = SCRIPT_PATH + '?action=fetchreviews';

        var that = this;
        $.post(url, function(response){
            if(response.success){

                if(response.savedReviews){
                    that.loadData(response.savedReviews, 'savedreviews');
                    $('#loading').hide();
                }else{
                    $('#loading').hide();
                    $('#no-review').show();
                }

                if(response.submittedReviews){
                    that.loadData(response.submittedReviews, 'submittedReviews');
                    $('#submittedReviews_loading').hide();
                }else{
                    $('#submittedReviews_loading').hide();
                    $('#submittedReviews_no-review').show();
                }

                $('.rating').rating({ disabled:true });
            }
            else{
                $('#loading').hide();
                $('#submittedReviews_loading').hide();

                $('#no-review').show();
                $('#submittedReviews_no-review').show();
            }

        },'json');
    },


    loadData : function(reviews,table){
        var vTable = document.getElementById(table);
        var tBody = document.createElement('tbody');

        if(reviews.length > 0){
            thead = this.getTableHead();
            $(vTable).html(thead);
        }


        $.each(reviews, function(i, rev){
            var tr = document.createElement('tr');

            var tdDate = document.createElement('td');
            tdDate.innerHTML = rev.created_at;

            var tdProject = document.createElement('td');
            tdProject.innerHTML = rev.project;

            var tdCompany = document.createElement('td');
            tdCompany.innerHTML = rev.company;

            var tdReportType = document.createElement('td');
            tdReportType.innerHTML = rev.type;

            var tdMyRating = document.createElement('td');

            var starInput=document.createElement("input");
            starInput.setAttribute('class', 'rating');
            starInput.setAttribute('value', rev.total_score);
            starInput.setAttribute('data-stars', '5');
            starInput.setAttribute('data-step', '0.1');
            starInput.setAttribute('disable', 'disabled');
            starInput.setAttribute('data-size', 'xs');


            var tdOptions= document.createElement('td');
            tdOptions.className = 'review-options';

            var aView= document.createElement('a');
            aView.innerHTML = '<img src="images/view.png" height="16px" width="16px" title="View" alt="View"/>';
            aView.href="#";

            var aEdit= document.createElement('a');
            aEdit.innerHTML = '<img src="images/edit.png" title="Edit" alt="Edit"/>';
            aEdit.href="#";

            var aDelete= document.createElement('a');
            aDelete.innerHTML = '<img src="images/delete.png" title="Delete" alt="Delete"/>';
            aDelete.id=rev.id;
            aDelete.href="#";
            aDelete.onclick=function () {
                var id = $(this).attr('id');
                $('#L-89').attr('review-id', id);
                $('#delete-modal').modal('show');
            };

            var aInvite= document.createElement('a');
            aInvite.innerHTML = '<img height="16px" width="16px" src="images/email.png" title="Invite" alt="Invite"/>';
            aInvite.className='PP-8';
            aInvite.href="#";
            aInvite.id=rev.report_id;
            aInvite.onclick=function () {
                var id = $(this).attr('id');
                $('#reportId-invite-all').val(id);
                $('#email-message').hide();
                $('#invite-options-modal').modal('show');
            };


            // Complaint
            var eComplaint = document.createElement('a');
            eComplaint.innerHTML = '<img height="16px" width="16px" src="images/complaint.png" title="Complaint" alt="Complaint"/>';
            eComplaint.className='PP-8';
            eComplaint.href="#";
            eComplaint.id=rev.report_id;
            eComplaint.onclick=function () {
                var id = $(this).attr('id');
                //set Report Id
                $('#review-report-id').val(id);
                oComplaint.init();
            };

            tr.appendChild(tdDate);
            tr.appendChild(tdProject);
            tr.appendChild(tdCompany);
            tr.appendChild(tdReportType);
            tr.appendChild(tdMyRating);
            tr.appendChild(tdOptions);
            tdOptions.appendChild(aView);
            tdOptions.appendChild(aEdit);
            tdOptions.appendChild(aDelete);
            tdOptions.appendChild(aInvite);
            tdOptions.appendChild(eComplaint);
            tdMyRating.appendChild(starInput);


            tBody.appendChild(tr);

            $(aView).bind("click",function(e) {
                oReview.showReview(rev.id);
            });

            $(aEdit).bind("click",function(e) {
                oReview.editReview(rev.id);
            });
        });

        vTable.appendChild(tBody);




    },

    getTableHead : function(){
        var thead = document.createElement('thead');
        var tr = document.createElement('tr');

        var thDate = document.createElement('th');
        thDate.innerHTML = 'Date';
        thDate.style.width='11%';

        var thProject = document.createElement('th');
        thProject.innerHTML = 'Project';
        thProject.style.width='20%';

        var thCompany = document.createElement('th');
        thCompany.innerHTML = 'Company';
        thCompany.style.width='20%';

        var thReportType = document.createElement('th');
        thReportType.innerHTML = 'Report Type';
        thReportType.style.width='20%';

        var thMyRating = document.createElement('th');
        thMyRating.innerHTML = 'My Rating';
        thMyRating.style.width='15%';

        var thOptions = document.createElement('th');
        thOptions.innerHTML = 'Options';
        thOptions.style.width='14%';

        tr.appendChild(thDate);
        tr.appendChild(thProject);
        tr.appendChild(thCompany);
        tr.appendChild(thReportType);
        tr.appendChild(thMyRating);
        tr.appendChild(thOptions);

        thead.appendChild(tr);


        return thead;
    },

    deletereview : function(){
        var id = $('#L-89').attr('review-id');
        var fields={'id':id};
        var url = SCRIPT_PATH + '?action=deletereview';
        var that = this;
        $.post(url,fields, function(response){

            if(response.success){
                $('#delete-modal').modal('hide');
                //$('#loading').show();
                //$('#submittedReviews_loading').show();
                //that.init();
                location.reload();
            }else{
                alert(response.errors);
            }
        },'json');

    },

    nothing : function(){
        $('#delete-modal').modal('hide');
        //location.reload();
    },

    cancelinvite : function(){
        $('#invite-modal').modal('hide');
        //location.reload();
    },

    cancelinviteOnMap : function(){
        $('#invite-modal').modal('hide');
        $('#submit-review-modal').modal('hide');

    },

    invitereviewer : function(email,reportId){

        var fields = {'reportId':reportId,'email':email};

        var url = SCRIPT_PATH + '?action=invitereviewer';
        $.post(url, fields, function(response){
            if(response.success){
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
                $('#invitationSent-modal').modal('show');
            }
            else{
                $(".imgProgressInviteAll img").hide();
                $('#invite-options-modal').modal('hide');
            }

        },'json');
    },

    backToInviteOnMap : function(){
        $('#invite-modal').modal('hide');
        $('#submit-review-modal').modal('hide');
        $('#invite-options-modal').modal('show');

    },
    invitereviewerMap : function(){

        if (oRsc.validateInviteEmail()){

            $(".imgProgressInvite img").show();

            var fields = $('#inviteMap :input').serialize();

            var url = SCRIPT_PATH + '?action=invitereviewer';
            $.post(url, fields, function(response){
                if(response.success){
                    $(".imgProgressInvite img").hide();
                    $('#invite-modal').modal('hide');
                    $('#invitationSent-modal').modal('show');
                }

            },'json');
        }
    },

    hideInvitationConfirmation : function(){
        $('#invitationSent-modal').modal('hide');
    },

    backtomap : function(){
        $('#thankyoumessage').hide();
    },

    invitationPopup : function(){
        $('#email-message').hide();
        $('#submit-review-modal').modal('hide');
        $('#reportId123').val($('#review-report-id').val());
        $('#reportId-invite-all').val($('#review-report-id').val());
        $('#invite-options-modal').modal('show');
    },

    saveResume : function(){
        var url = SCRIPT_PATH + '?action=saveResume';
        $.post(url,  function(response){
            if(response.success){
                location.reload();
            }
            else{
                //to do
            }

        },'json');
    },

    hidePopoupManageAccount : function(){
        $('#submit-review-modal').modal('hide');
    }

};