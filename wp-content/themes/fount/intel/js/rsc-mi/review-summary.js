var oReviewSummary = {
    init: function () {
        this.showReportDetail();
        this.showUserSummary();
        this.showUserReviews();
        $(".rating").rating('create');
    },

    showReportDetail : function(){
        var reportId = $.cookie('reportId');

        var fields = {'reportId':reportId};
        var url = SCRIPT_PATH + '?action=reportDetails';
        $.post(url, fields, function(response){
            if(response.success){
                $.each(response.reportdata, function(i, rev){
                    $('#company1').html(rev.company);
                    $('#project1').html(rev.project);
                    $('#code1').html(rev.code);
                    $('#type1').html(rev.type);
                    $('#cpqp1').html(oReview.cleanString(rev.cpqp));
                    $('#date1').html(rev.date);

                    // Report overall rating
                    var starInput=document.createElement("input");
                    starInput.setAttribute('class', 'sumary-ol-rating');
                    starInput.setAttribute('value', parseFloat(rev.total_score));
                    starInput.setAttribute('data-stars', '5');
                    starInput.setAttribute('data-step', '0.1');
                    starInput.setAttribute('disable', 'disabled');
                    starInput.setAttribute('data-size', 'xs');
                    $('#summary-overall-report-rating').html(starInput);
                    $('.sumary-ol-rating').rating({disabled:true});
                });
            }else{
                $('#project1').html('');
                $('#company1').html('');
                $('#code1').html('');
                $('#type1').html('');
                $('#cpqp1').html('');
                $('#date1').html('');
                $('#summary-overall-report-rating').html('');
            }
        },'json');
    },

    showUserSummary : function(){
        var reportId = $.cookie('reportId');
        var fields = {'reportId':reportId};
        var url = SCRIPT_PATH + '?action=reportUserDetails';
        var level = $.cookie('level');
        $.post(url, fields, function(response){
            if(response.success){
                var vDiv = document.getElementById('reviewed-by');
                $.each(response.userdata, function(i, rev){
                    var cDiv = document.createElement('div');
                    var aUserLink= document.createElement('a');
                    if((rev.reviewer_identity=="no"&& rev.anonymous=="no") || level == 'Admin'){
                        aUserLink.innerHTML = rev.username;
                    }
                    else{
                        aUserLink.innerHTML ='Anonymous';
                    }

                    var img =  document.createElement('img');
                    if((rev.profilepicture && rev.reviewer_identity=="no" && rev.anonymous=="no")  || (rev.profilepicture &&  level == 'Admin')){
                        img.src = 'images/upload/'+rev.profilepicture;
                    }
                    else{
                        img.src = 'images/upload/RP-temp.png';
                    }
                    img.className='review-summary-image';
                    //$('#img').html(img);

                    cDiv.appendChild(aUserLink);
                    cDiv.appendChild(img);

                    vDiv.appendChild(cDiv);
                });
                $("#userdataimage img").hide();
            }else{
                //to do
            }
        },'json');

    },

    displayUserDetail : function(rev, report_id){
        var level = $.cookie('level');
        var cMainDiv = document.createElement('div');
        cMainDiv.className='summary-report-detail';

        var rP=document.createElement('p');

        var rSpan=document.createElement('span');
        rSpan.innerHTML = 'Review by ';

        var aUserLink= document.createElement('a');
        //aUserLink.innerHTML = rev.username;
        if((rev.reviewer_identity=="no" && rev.anonymous=="no") ||  level == 'Admin'){
            aUserLink.innerHTML = rev.username;
        }
        else{
            aUserLink.innerHTML ='Anonymous';
        }

        rP.appendChild(rSpan);
        rP.appendChild(aUserLink);
        cMainDiv.appendChild(rP);

        var cDiv1 = document.createElement('div');

        var img =  document.createElement('img');
        img.style.maxHeight = '160px';
        img.style.width = '124px';
        if((rev.profilepicture && rev.reviewer_identity=="no" && rev.anonymous=="no") || (rev.profilepicture && level == 'Admin')){
            img.src = 'images/upload/'+rev.profilepicture;
        }
        else{
            img.src = 'images/upload/RP-temp.png';
        }

        var company;
        if(rev.company == null ){
            company = '';
        }else{
            if(rev.reviewer_identity=="no" && rev.anonymous=="no" || level == 'Admin'){
                company = rev.company;
            }else{
                if(rev.consultant == 'yes'){
                    company ='Consultancy';
                }else if(rev.consultant == 'no'){
                    company ='Mining/Exploration Company';
                }
            }
        }

        var rP1=document.createElement('p');

        var rSpan1=document.createElement('span');
        rSpan1.innerHTML = 'See user\'s ';

        var aLink= document.createElement('a');
        aLink.innerHTML = 'full review';
        aLink.href="#";
        $(aLink).bind("click",function(e) {
            oReview.showReview(rev.id);
        });

        var sendMessageContainer = document.createElement('p');
        sendMessageContainer.style.margin = '1px 0 20px';
        sendMessageContainer.style.cursor = 'pointer';
        var sendMessageLink= document.createElement('a');
        sendMessageLink.innerHTML = 'Send Message to reviewer';

        $(sendMessageLink).bind("click",function(e) {
            oMessage.builtMessagePopup(rev.id, rev.email, report_id);
        });

        rP1.appendChild(rSpan1);
        rP1.appendChild(aLink);
        cDiv1.appendChild(img);
        cDiv1.appendChild(rP1);
        sendMessageContainer.appendChild(sendMessageLink);
        cDiv1.appendChild(sendMessageContainer);
        cMainDiv.appendChild(cDiv1);

        var vTable1=document.createElement('table');
        vTable1.id = 'reviewer_rating_data';

        var trOVERALL=document.createElement('tr');
        trOVERALL.className='summary-report-overall';

        var tdOVERALL=document.createElement('td');
        tdOVERALL.innerHTML='OVERALL RATING: &nbsp';

        var tdOVERALLScore=document.createElement('td');
        var starInput=document.createElement("input");
        starInput.setAttribute('class', 'rating');
        starInput.setAttribute('value', rev.total_score);
        starInput.setAttribute('data-stars', '5');
        starInput.setAttribute('data-step', '0.1');
        starInput.setAttribute('disable', 'disabled');
        starInput.setAttribute('data-size', 'xs');

        tdOVERALLScore.appendChild(starInput);
        trOVERALL.appendChild(tdOVERALL);
        trOVERALL.appendChild(tdOVERALLScore);

        vTable1.appendChild(trOVERALL);

        tableReviewerData = document.createElement('table');
        tableReviewerData.id = 'reviewer_data';
        trFirst = document.createElement('tr');
        thCompany = document.createElement('th');
        thCompany.innerHTML = 'Company:';
        tdCompany = document.createElement('td');
        tdCompany.innerHTML = company;
        thReportingCode = document.createElement('th');
        thReportingCode.innerHTML = 'Reporting Code:';
        tdReportingCode = document.createElement('td');
        tdReportingCode.innerHTML = rev.reporting_code;
        thComodities = document.createElement('th');
        thComodities.innerHTML = 'Commodities:';
        tdComodities = document.createElement('td');
        if(rev.reviewer_identity=="no" && rev.anonymous=="no" || level == 'Admin'){
            tdComodities.innerHTML = rev.commodity;
        }
        else{
            tdComodities.innerHTML = oReviewSummary.cleanCommodity(rev.commodity);
        }

        var thAnonymous = document.createElement('th');
        thAnonymous.innerHTML = 'Anonymous:';
        var tdAnonymous = document.createElement('td');
        tdAnonymous.innerHTML = rev.anonymous;

        trSecond = document.createElement('tr');
        thPosition = document.createElement('th');
        thPosition.innerHTML = 'Position:';
        tdPosition = document.createElement('td');
        tdPosition.innerHTML = rev.position;
        thCountry = document.createElement('th');
        thCountry.innerHTML = 'Country:';
        tdCountry = document.createElement('td');
        tdCountry.innerHTML = rev.country;
        thStockExchange = document.createElement('th');
        thStockExchange.innerHTML = 'Stock Exchange:';
        tdStockExchange = document.createElement('td');
        tdStockExchange.innerHTML = rev.stocks;

        trThird = document.createElement('tr');
        thExperience = document.createElement('th');
        thExperience.innerHTML = 'Experience:';
        tdExperience = document.createElement('td');
        if(rev.reviewer_identity=="no" && rev.anonymous=="no" || level == 'Admin'){
            tdExperience.innerHTML = rev.experience + ' years';
        }else{
            if(parseInt(rev.experience) >= 5)
                tdExperience.innerHTML = rev.experience + '+ years';
            else
                tdExperience.innerHTML = 'less than 5 years';
        }
        thReportingExp = document.createElement('th');
        thReportingExp.innerHTML = 'Reporting Experience:';
        tdReportingExp = document.createElement('td');
        if(rev.reviewer_identity=="no" && rev.anonymous=="no" || level == 'Admin'){
            tdReportingExp.innerHTML = rev.reporting_experience;
        }
        else{
            if(rev.reporting_experience=='5-10 years')
                tdReportingExp.innerHTML = '5+ years';
            else if(rev.reporting_experience=='10-15 years')
                tdReportingExp.innerHTML = '10+ years';
            else if(rev.reporting_experience=='15-20 years')
                tdReportingExp.innerHTML = '15+ years';
            else if(rev.reporting_experience=='20-30 years')
                tdReportingExp.innerHTML = '20+ years';
            else if(rev.reporting_experience=='>30 year')
                tdReportingExp.innerHTML = '30+ years';

        }
        thLevel = document.createElement('th');
        thLevel.innerHTML = 'Level:';
        tdLevel = document.createElement('td');
        tdLevel.innerHTML = rev.level;

        trForth = document.createElement('tr');
        trFifth = document.createElement('tr');

        trFirst.appendChild(thCompany);
        trFirst.appendChild(tdCompany);
        trFirst.appendChild(thCountry);
        trFirst.appendChild(tdCountry);

        trSecond.appendChild(thPosition);
        trSecond.appendChild(tdPosition);
        trSecond.appendChild(thExperience);
        trSecond.appendChild(tdExperience);

        trThird.appendChild(thReportingCode);
        trThird.appendChild(tdReportingCode);
        trThird.appendChild(thLevel);
        trThird.appendChild(tdLevel);


        trForth.appendChild(thStockExchange);
        trForth.appendChild(tdStockExchange);
        trForth.appendChild(thComodities);
        trForth.appendChild(tdComodities);

        trFifth.appendChild(thReportingExp);
        trFifth.appendChild(tdReportingExp);
        if(level == 'Admin'){
            trFifth.appendChild(thAnonymous);
            trFifth.appendChild(tdAnonymous);
        }

        tableReviewerData.appendChild(trFirst);
        tableReviewerData.appendChild(trSecond);
        tableReviewerData.appendChild(trThird);
        tableReviewerData.appendChild(trForth);
        tableReviewerData.appendChild(trFifth);

        cMainDiv.appendChild(vTable1);
        cMainDiv.appendChild(tableReviewerData);

        var loggedIn = $.cookie('login');
        if(rev.notes != '' && rev.notes != null && loggedIn == 'loggedIn'){
            var reviewNotes = document.createElement('div');
            reviewNotes.id = 'review_notes';
            reviewNotes.innerHTML = '<p><span class="notes-heading">Reviewer Notes: </span><span class="notes-text">'+rev.notes+'</span></p>';
            cMainDiv.appendChild(reviewNotes);
        }

        if(rev.reviewer_identity=="no" && rev.anonymous=="no" || level == 'Admin'){
            biographyContainer = document.createElement('div');
            biographyContainer.id = 'biography_data';
            biographyContainer.innerHTML = '<p><span class="biography-heading">Biography: </span><span class="biography-text">'+rev.biography+'</span></p>';
            cMainDiv.appendChild(biographyContainer);
        }

        this.getReportUserReviewsRating(rev.report_id, rev.user_id,vTable1);

        if(rev.level == 'Junior Reviewer' || rev.review_status == 3){
            var juniorNote=document.createElement('div');
            juniorNote.className='junior-note';
            var conflict = (rev.review_status == 3) ? '(Due to conflict of interest)' : '';
            juniorNote.innerHTML='<p><b>Note :</b> Score not weighed into the report&#39;s Overall Rating. '+conflict+'</p>';
            cMainDiv.appendChild(juniorNote);
        }


        return cMainDiv;

    },
    cleanCommodity: function (str) {
        if(str){
            var find ='5-10 years';
            var re=new RegExp(find, 'g');
            str = str.replace(re, '');
            var find =':';
            var re=new RegExp(find, 'g');
            str = str.replace(re, ',');
            var find ='10-15 years';
            var re=new RegExp(find, 'g');
            str = str.replace(re, '');
            var find ='15-20 years';
            var re=new RegExp(find, 'g');
            str = str.replace(re, '');
            var find ='20-30 years';
            var re=new RegExp(find, 'g');
            str = str.replace(re, '');
            var find ='>30 years';
            var re=new RegExp(find, 'g');
            str = str.replace(re, '');
        }
        return str;
    },

    getReportUserReviewsRating : function(report_id, user_id, vTable1){
        var fields = {'report_id':report_id , 'user_id':user_id};
        var url = SCRIPT_PATH + '?action=getReportUserReviewsRating';
        var level = $.cookie('level');
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                var vDiv = document.getElementById('reviews');
                $.each(response.userReviewData, function(i, rev){
                    // Display User
                    var tr = that.displayUserRating(rev);
                    vTable1.appendChild(tr);
                });
                $('.rating').rating({
                    disabled:true
                });
                $("#userreviewdataimage img").hide();

            }else{
                //todo
            }
        },'json');
    },

    displayUserRating : function(rev){
        var tr=document.createElement('tr');

        var td=document.createElement('td');
        td.innerHTML=rev.name+' &nbsp';
        var tdScore=document.createElement('td');
        var starInput=document.createElement("input");
        starInput.setAttribute('class', 'rating');
        starInput.setAttribute('value', rev.score);
        starInput.setAttribute('data-stars', '5');
        starInput.setAttribute('data-step', '0.1');
        starInput.setAttribute('disable', 'disabled');
        starInput.setAttribute('data-size', 'xs');
        tdScore.appendChild(starInput);
        tr.appendChild(td);
        tr.appendChild(tdScore);

        return tr;
    },

    showUserReviews : function(){
        var reportId = $.cookie('reportId');
        var fields = {'reportId':reportId};
        var url = SCRIPT_PATH + '?action=reportUserReviewRating';
        var level = $.cookie('level');
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                var vDiv = document.getElementById('reviews');
                $.each(response.userReviewData, function(i, rev){
                    // Display User
                    var cMainDiv = that.displayUserDetail(rev, reportId);
                    vDiv.appendChild(cMainDiv);
                });
                $('.rating').rating({
                    disabled:true
                });
                $("#userreviewdataimage img").hide();

            }else{
                //todo
            }
        },'json');
    },

    getReviewRating : function(questionId,reviewId,username){
        var reviewRating = Parse.Object.extend("Rating");
        var query = new Parse.Query(reviewRating);
        query.equalTo("QuestionId", questionId);
        query.equalTo("ReviewId", reviewId);
        query.find({
            success: function (Review) {
                var object = Review[0];
                var score = object.get('Score');

                var question = object.get('Score') + '-' +username+questionId;
                $('#'+question).prop('checked', true);
            },
            error: function (object, error) {
            }
        });
    },

    showUserDetail : function(userId,reviewId){
        var that = this;
        var user = Parse.Object.extend("User");
        var query = new Parse.Query(user);
        query.get(userId, {
            success: function (User) {
                var file = User.get('picture');
                var username = User.get('username');

                that.displayReviewedBy(username,file);
                that.displayFullReview(username,file,reviewId);

            },
            error: function (object, error) {
            }
        });
    },

    displayReviewedBy : function(username,file){
        var $cDiv = $('#reviewed-by');
        var $div = $('<div><a href="#"> '+username+' </a></div>');
        var $img = $('<img class="review-summary-image" alt="'+username+'" src="'+file.url()+'">');
        $div.append($img);
        $cDiv.append($div);
    },

    displayFullReview : function(username,file,reviewId){
        var $cDiv = $('#reviews');

        var $div = $('<div class="summary-report-detail"></div>');
        var $p = $('<p><span>Review by </span> <a href="#"> '+username+'.</a></p>');
        var $profileDiv = $('<div><img alt="'+username+'" src="'+file.url()+'"><p><span>See '+username+'&#39;s </span> <a href="#" id="'+reviewId+'" onclick="javascript:oReviewSummary.showFullReview(this);"> full review.</a></p></div>');

        var $table,$tbody,$tr;
        $table = $('<table></table>');
        $tbody = $('<tbody></tbody>');
        $tr = this.getReviewTr('Transparency',username,'TlJK2YyABN',true);
        $tbody.append($tr);
        $tr = this.getReviewTr('Materiality',username,'7ScpK4m6iS');
        $tbody.append($tr);
        $tr = this.getReviewTr('Methodology',username,'xURqtuYDYq');
        $tbody.append($tr);
        $tr = this.getReviewTr('Competence',username,'qrf78dZbWe');
        $tbody.append($tr);
        $tr = this.getReviewTr('Code-Compliance',username,'Fhl3Eov52P');
        $tbody.append($tr);
        $tr = this.getReviewTr('OVERALL RATING',username,'MBirAt2qlw');
        $tbody.append($tr);
        $table.append($tbody);

        $div.append($p);
        $div.append($profileDiv);
        $div.append($table);

        $cDiv.append($div);


        var transparency = this.getReviewRating('TlJK2YyABN',reviewId,username);
        var materiality = this.getReviewRating('7ScpK4m6iS',reviewId,username);
        var methodology = this.getReviewRating('xURqtuYDYq',reviewId,username);
        var competence = this.getReviewRating('qrf78dZbWe',reviewId,username);
        var codeCompliance = this.getReviewRating('Fhl3Eov52P',reviewId,username);
        var overAllRating = this.getReviewRating('MBirAt2qlw',reviewId,username);
    },

    getReviewTr : function(name,username,QuestionId,first){
        var $tr, $td, $tdRating,$rdo,checked = '';
        $tr = $('<tr></tr>');
        $td = $('<td>'+name+':</td>');
        $tdRating = $('<td></td>');
        var len = 6;
        for (var index = 1; index < len; index++) {
            var id = index+'-'+username+QuestionId;
            if(first)
                $rdo = $('<span>'+index+'</span><input '+checked+' type="radio" disabled value="'+index+'" name="'+username+name+'" id="'+id+'">');
            else
                $rdo = $('<input '+checked+' type="radio" disabled value="'+index+'" name="'+username+name+'" id="'+id+'">');

            $tdRating.append($rdo);
        }
        $tr.append($td).append($tdRating);

        return $tr;
    },

    showFullReview : function(elm){
        $.cookie('ReviewId', elm.id, { expires: 1, path: '/' });
        window.location.href = "http://rscmme.com/full-review";
    },

    cleanString: function (str) {
        str = str.replace('[Resources]:', '');
        str = str.replace('[Overall Report]:', '');
        return str;
    },

    backToMap : function(){
        window.location.href = BASE_URL;
    },

    closeTab : function(){
        window.close();
    }

};
