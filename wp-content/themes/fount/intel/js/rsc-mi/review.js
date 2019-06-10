var oReview = {
    reviewId : null,
    Review : null,
    totalReviewRating : 0,
    arrReviewInfo : [],
    disableInput : false,
    overAllSection : {
        id : 'overall-rating',
        name : 'OVERALL RATING',
        review_info_id : 77
    },
    // Initialize once
    initReview : function(){
        var that = this;
        //cache
        this.$ratingDiv = $('div.rating-content');
        //Initialize expendable div
        this.toggleSlides();
        // Initialization
        this.initCalc();
        // Initialize Reviewer invitation
        this.initInviteReviewer();

        // Auto calc
        $('#review-type').on('click', function() {
            var reviewType = $(this).val();
            // if auto calc is checked
            if(reviewType == '1'){
                that.isFatalFlaw();
            } else{
                $('.chk-auto-calc').prop('checked',true).prop('disabled',false);
                $('.rdo-overall').prop('disabled',true);
            }
        });


        // Conflict Of Interest
        $('#conflict-of-interest').on('change', function() {
            $('#conflict-of-interest-modal').modal('show');
        });

        // info link
        this.getReviewInfo();
        this.reviewInfo();

        //auto height notes
        $("textarea#review-notes").keyup(function (e) {
            that.autoHeight(this);
        });
    },

    initInviteReviewer : function(){
        // Stock select
        var selectExchanges = document.getElementById('invite-marketing'),option;
        //Create and append the options
        $.each(oManageAccount._exchange, function(i, val){
            option = document.createElement("option");
            option.value = val.id;
            option.text = val.name;
            selectExchanges.appendChild(option);
        });
        var $inviteModel =$('#invite-options-modal'), $byEmail =$('.email-invite-hidden'), $byUsername =$('.invite_specifice_username');
        var $reportingCode =$('.invite-all-reporting-code'), $stock =$('.invite-all-marketing'), $commodity =$('.invite-all-commodity-experience');

        $inviteModel.on('change', '.type_invite', function() {
            $byEmail.hide();
            $byUsername.hide();
            $stock.hide();
            $commodity.hide();
            $reportingCode.hide();

            // All user by options
            if(this.id != 'all_user_by')
                $('.invite_filers').prop('checked', false);

            if(this.id == 'specific_user'){
                $byEmail.show();
            }else if(this.id == 'specific_username'){
                $byUsername.show();
            }
        });

        $inviteModel.on('change', '.invite_filers', function() {
            $('#all_user_by').prop('checked', true);
            // Hide All
            $byEmail.hide();
            $byUsername.hide();
            $reportingCode.hide();
            $stock.hide();
            $commodity.hide();


            if(this.id == 'all_reporting_code')
                $reportingCode.show();
            else if(this.id == 'all_stocks')
                $stock.show();
            else if(this.id == 'all_commodity_experience')
                $commodity.show();

        });
    },

    autoHeight : function(a) {
        if (!$(a).prop('scrollTop')) {
            do {
                var b = $(a).prop('scrollHeight');
                var h = $(a).height();
                $(a).height(h - 5);
            }
            while (b && (b != $(a).prop('scrollHeight')));
        };
        $(a).height($(a).prop('scrollHeight') + 20);
    },

    getReviewInfo : function(edit){
        var that = this;
        var url = SCRIPT_PATH + "?action=getReviewInfo";
        $.post(url, function(response){
            if(response.success){
                if(response.reviews){
                    that.arrReviewInfo = response.reviews;
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    reviewInfo : function(){
        // Info Link
        var that = this;
        var $div = $("div.review-info-popup");
        var $modal = $('#review-modal');
        $modal.on('mouseover', '.tooltip-review', function() {
            var strId = this.id;
            strId = strId.split("-");

            var id = strId[0];
            var rSection = strId[1];
            var position = $(this).offset();
            var top =position.top - $(document).scrollTop() - 22;
            var left =position.left + 25;
            if(rSection == 'reviewinfosection')
                $div.css({'top': top, 'left': left, 'display': 'inline', 'z-index':999999, 'width':'36%'} );
            else
                $div.css({'top': top, 'left': left, 'display': 'inline', 'z-index':999999, 'width':'30%'} );


            var review = that.getObjById(that.arrReviewInfo,id);
            review = review[0];
            var popupContent = '<img class="callout" src="images/arrow.png" />';
            /*popupContent += '<button onclick="javascript:oReview.closeInfoPopup();" type="button" class="close" aria-hidden="true">&times;</button>';*/
            popupContent += '<div>';
            /*popupContent += '<h3>'+review.name+'</h3>';*/
            if(this.id == 'notes_info'){
                popupContent += '<p>Shown to registered reviewers only</p>';
            }else if(this.id == 'conflict_of_interest_info'){
                popupContent += '<p>IMPORTANT: Reviewers should indicate whether they have a conflict of interest, whether perceived or real. For each Report review, the Reviewers must tick this box, stating that there is no conflict of interest. If the box is left unticked, the review does not get included into the overall weighting and the review does not get made public.This has important legal implications, as a conflict of interest may open the doors to risk of defamation in case of negative reviews. We therefore advise caution for Reviewers who are consultants and who are reviewing reports made by other consultancies or previous employers. We also advise caution for Reviewers who are employed with mining or exploration companies and who are reviewing reports made by potential competitor companies.</p>';
            }else if(this.id == 'ausimm_code_info'){
                popupContent += '<p>Members of The AusIMM should respect the abilities of their colleagues and not attempt to supplant another member whose services have been engaged by a client or employer. Members of The AusIMM should not intentionally or recklessly say or do anything that could injure the reputation of another member. Please make sure that your review is done with the intention of improving public reporting and not to injure the reputation of another member.</p>';
            }else if(this.id == 'review_anonymously_info'){
                popupContent += '<p>This means that people will be able to see your name when they select a particular report that you have reviewed. Mostly, consultants opt for this options as it allows for companies to get in touch with reviewers based on their reviews.</p>';
            }
            else{
                popupContent += '<p>'+review.information+'</p>';
            }
            popupContent += '</div>';

            $div.html(popupContent);
            //$('#review-info-modal').modal('show');
        });

        $modal.on('mouseout', '.tooltip-review', function(){
            that.closeInfoPopup();
        });
    },

    getObjById : function (arr, id){
        return $.grep(arr, function(e){ return e.id == id; });
    },

    closeInfoPopup : function() {
        $("div.review-info-popup").hide();
    },

    init : function(){
        $('#logedin').modal('hide');
        $('#login-modal').modal('hide');
        $('#review-modal').modal('show');
        // Checked logged in
        oRsc.checkUserLoggedIn();
        // Reset Form
        document.getElementById("frm-review-form").reset();
        $('.modal-body').scrollTop(0);

        // Log Activity
        this.logReviewStart();
        // Validate Form
        $("#frm-review-form").validate();
        // Report Detail
        this.reportDetail();
        // get All section
        this.getSection(false);
        //Overall rating
        this.loadSection(this.overAllSection,true,true);

        this.resizeReviewPopup();

        //check user level - Allow Junior Reviewer to submit reviews As Requirement has changed.
        //if($.cookie('user_level') == 'Junior Reviewer')
        //    $("#review-submit-btn").prop("disabled",true);
    },

    resizeReviewPopup : function(){
        var height = document.body.clientHeight;
        height -= 360;
        $('#review-modal .modal-body').css('height',height+'px');
    },

    logReviewStart : function (){
        var that = this;
        var url = SCRIPT_PATH + "?action=logReviewStart";
        var report_id = $('#review-report-id').val();
        var fields = {report_id : report_id};
        $.post(url,fields, function(response){

        }, 'json');
    },

    fullReviewHidden : function(){
        $('.full-review-hidden').hide();
    },

    toggleSlides : function(){
        this.$ratingDiv.on('click', '.expendable', function(e) {
            // tooltip review info
            var target = $(e.target);
            if(target.hasClass('tooltip-review'))
                return;
            // Fatal flaw
            if($('#review-type').val() == '1')
                return;

            var id=$(this).attr('id');
            var widgetId=id.substring(id.indexOf('-')+1,id.length);
            $('#'+widgetId).slideToggle();
            $(this).toggleClass('sliderExpanded');
            $('.closeSlider').click(function(){
                $(this).parent().hide('slow');
                var relatedToggler='toggler-'+$(this).parent().attr('id');
                $('#'+relatedToggler).removeClass('sliderExpanded');
            });
        });
    },

    initCalc : function(){
        var that = this;
        this.$ratingDiv.on('click', '.chk-auto-calc', function() {
            var id = $(this).attr('id');
            var section_id = $(this).attr('section');
            var name = id.slice(4);
            if(this.checked){
                that.calculateRating(section_id);
                that.calculateOverAllRating();
                $('input[name='+name+']').prop('disabled',true);
            }
            else
                $('input[name='+name+']').prop('disabled',false);
        });

        this.$ratingDiv.on('click', '.review-section', function() {
            var section_id = $(this).attr('section');
            // if auto calc is checked
            if($('#chk-'+section_id+'-section').is(':checked')){
                that.calculateRating(section_id);
                that.calculateOverAllRating();
            }
        });

        this.$ratingDiv.on('change', '.rdo-overall', function() {
            that.calculateOverAllRating();
        });


        $('.modal-footer').on('click', '#chk-overall-rating-section', function() {
            // if auto calc is checked
            if($('#chk-overall-rating-section').is(':checked')){
                that.calculateOverAllRating();
                $('.rdo-overall-total').prop('disabled',true);
                $('#manual-overall-rating-modal').modal('hide');
                $('#review-notes').removeClass('required');
            }else{
                $('.rdo-overall-total').prop('disabled',false);
                $('#manual-overall-rating-modal').modal('show');
                $('#review-notes').addClass('required');
            }
        });
    },

    calculateRating : function(section_id){
        var section = 'rdo-'+section_id+'-section';
        var rating, arrCheckedValues,arrNaValues, total_selected_rev;
        var total_reviews = $('.'+section_id+'-review-section').length;
        arrCheckedValues = this.getSelectedRating(section);
        arrNaValues = this.getNaRating(section);

        total_selected_rev = arrCheckedValues.length + arrNaValues.length;

        //Check if all option are selected
        if(total_reviews == total_selected_rev){
            $('.'+section_id+'-section').prop('checked',false); //reset

            rating = this.calculate(arrCheckedValues,arrCheckedValues.length);
            // auto select rating
            var id = rating+'-'+section_id;
            $('#'+id+'-review').prop('checked',true);
        }else{
            $('#'+id+'-review').prop('checked',false);
        }
    },

    calculateOverAllRating :function(){
        var rating, arrCheckedValues, arrNaValues,total_selected_rev;
        arrCheckedValues = this.getSelectedRating('rdo-overall');
        arrNaValues = this.getNaRating('rdo-overall');
        var total_reviews = arrCheckedValues.length;
        //var total_reviews = $('.rdo-overall').length;
        total_selected_rev = 5 - arrNaValues.length;
        $('.rdo-overall-total').prop('checked',false); //reset
        //Check if all option are selected
        if(total_reviews == total_selected_rev){ //Todo: fetch total count from db
            rating = this.calculate(arrCheckedValues,total_reviews);
            //total rating
            this.totalReviewRating = parseInt(rating);
            if(this.totalReviewRating >= 1)
                $("#review-submit-btn").prop("disabled",false);
            else
                $("#review-submit-btn").prop("disabled",true);

            // auto select rating
            var id = rating+'-'+this.overAllSection.id;
            $('#'+id+'-review').prop('checked',true);
            $('#'+id+'-overall-rating-review').prop('checked',true);
        }else{
            $('#'+id+'-review').prop('checked',false);

            $('#'+id+'-overall-rating-review').prop('checked',false);
        }
    },

    getSelectedRating : function(section){
        return $('.'+section+':checked').map(function() {
            var val = parseInt(this.value) || 0;
            if(val != 0) //Skip n/a
                return val;
        }).get();
    },

    getNaRating : function(section){
        return $('.'+section+':checked').map(function() {
            var val = parseInt(this.value) || 0;
            if(val == 0) //Skip n/a
                return val;
        }).get();
    },

    calculate :function(arrCheckedValues,totalReviews){
        var sum = 0,total_rating = 0;
        // sum review rating
        $.each(arrCheckedValues,function() { sum+= parseInt(this) || 0; });

        // Calculate rating
        total_rating = sum / parseInt(totalReviews);
        total_rating = Math.round(total_rating);

        return total_rating;
    },

    reportDetail :function(){
        var report_id = $('#review-report-id').val();
        var history_report = $('#history-review').val();
        var feature;
        if(history_report == 'True'){
            oReview.getReportById(report_id);
        }else{
            feature = $.grep(geoJson, function(e){ return e.id == report_id; });
            feature =feature[0].properties;
            this.setReportDetail(feature);
        }
    },

    setReportDetail : function(feature){
        $('#project-report').html(feature.project);
        $('#company-report').html(feature.company);
        $('#code-report').html(feature.code);
        $('#type-report').html(feature.type);
        $('#cpqp-report').html(this.cleanString(feature.cpqp));
        $('#date-report').html(feature.date);
    },

    getReportById : function(report_id){
        var url = SCRIPT_PATH + "?action=reportDetails";
        var fields = {reportId : report_id};
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                if(response.reportdata){
                    var feature = response.reportdata[0];
                    that._reportType = feature.type;
                    that.setReportDetail(feature);
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    cleanString : function(str){
        str = str.replace('[Resources]:', '');
        str = str.replace('[Overall Report]:', '');
        return str;
    },

    getSection : function(edit){
        var that = this;
        var url = SCRIPT_PATH + "?action=getAllSection";
        $.post(url, function(response){
            if(response.success){
                if(response.sections){
                    that.$ratingDiv.html('');
                    var len = response.sections.length - 1;
                    $.each(response.sections, function( index, value ) {
                        if(index == 0)
                            that.loadSection(value,true,false);
                        else if(value.name == 'Competence' || value.name == 'Compliance')
                            that.loadSectionCC(value);
                        else
                            that.loadSection(value,false,false);
                    });
                    // Load All Questions
                    that.getQuestion();
                    //Overall rating
                    if(edit == 'Show' || edit == 'Edit'){
                        if(edit == 'Show')
                            that.loadSection(that.overAllSection,true,false);


                        that.getReviewDetail();
                    }

                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    loadSection : function(section,bRating,overall){
        var rating,sectionDiv,id, className;

        if(section.id == 'overall-rating')
            className = 'rating-head overall-rating-heads';
        else
            className = 'rating-head';


        if(bRating){
            rating = '<div class="'+className+'">';
            rating += '<div></div>';
            if(overall || section.id == 'overall-rating'){
                rating += '<div><span>very poor</span><span>poor</span><span></span><span>good</span><span>very good</span><span></span><span>auto calc.</span></div>';
            }else{
                rating += '<div><span>very poor</span><span>poor</span><span></span><span>good</span><span>very good</span><span>n/a</span><span>auto calc.</span></div>';
            }

            rating += '</div>';

            if(!overall)
                this.$ratingDiv.append($(rating));
        }

        id = section.id + '-section';
        sectionDiv = '<div class="'+className+'">';
        sectionDiv += '<div id="expendable-'+id+'" class="expendable">';
        sectionDiv += '<p>'+section.name+'<img id="'+section.review_info_id+'-reviewinfosection" class="tooltip-review" src="images/info.png" /></p>';
        if(!overall && section.id != 'overall-rating'){
            sectionDiv += '<span class="expandSlider"><img src="images/arrow-down.png"></span><span class="collapseSlider"><img src="images/arrow-up.png"></span>';
        }
        sectionDiv += '</div>';
        if(!overall) {
            sectionDiv += '<div class="overall-review-section">';
        }else{
            sectionDiv += '<div>';
        }

        if(overall){
            sectionDiv += '<span><input id="1-'+section.id+'-review" class="rdo-overall-total required" name="'+section.id+'-section" value="1" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="2-'+section.id+'-review" class="rdo-overall-total" name="'+section.id+'-section" value="2" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="3-'+section.id+'-review" class="rdo-overall-total" name="'+section.id+'-section" value="3" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="4-'+section.id+'-review" class="rdo-overall-total" name="'+section.id+'-section" value="4" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="5-'+section.id+'-review" class="rdo-overall-total" name="'+section.id+'-section" value="5" type="radio" disabled /></span>';
            sectionDiv += '<span></span>';
        }else{
            sectionDiv += '<span><input id="1-'+section.id+'-review" class="rdo-overall '+section.id+'-section required" name="'+section.id+'-section" value="1" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="2-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="2" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="3-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="3" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="4-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="4" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="5-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="5" type="radio" disabled /></span>';
            sectionDiv += '<span><input id="0-' + section.id + '-review" class="rdo-overall '+section.id+'-section" name="' + section.id + '-section" value="0" type="radio" disabled /></span>';
        }
        sectionDiv += '<span><input id="chk-'+section.id+'-section" name="chk-'+section.id+'-section" class="chk-auto-calc" section="'+section.id+'" type="checkbox" checked /></span></div>';
        sectionDiv += '</div>';

        sectionDiv += '<div style="clear:both"></div>';
        sectionDiv += '<div class="slider" id="'+id+'">';
        sectionDiv += '</div>';
        sectionDiv += '<div style="clear:both"></div>';

        if(overall){
            $('.overall-rating-div').html('').append($(rating)).append($(sectionDiv));
        }
        else
            this.$ratingDiv.append($(sectionDiv));
    },

    loadSectionCC : function(section){
        var rating,sectionDiv,id;

        rating = '<div class="rating-head">';
        rating += '<div></div>';
        if(section.name == 'Competence'){
            rating += '<div class="competence-section"><span>not competent</span><span></span><span>competent</span><span></span><span>very competent</span><span>n/a</span><span>auto calc.</span></div>';
        }else if(section.name == 'Compliance'){
            rating += '<div class="compliance-section"><span>not compliant</span><span></span><span>compliant</span><span></span><span>fully compliant</span><span>n/a</span><span>auto calc.</span></div>';
        }

        rating += '</div>';

        this.$ratingDiv.append($(rating));

        id = section.id + '-section';
        sectionDiv = '<div class="rating-head">';
        sectionDiv += '<div id="expendable-'+id+'" class="expendable">';
        sectionDiv += '<p>'+section.name+'<img id="'+section.review_info_id+'-reviewinfosection" class="tooltip-review" src="images/info.png" /></p>';
        sectionDiv += '<span class="expandSlider"><img src="images/arrow-down.png"></span><span class="collapseSlider"><img src="images/arrow-up.png"></span>';
        sectionDiv += '</div>';

        sectionDiv += '<div>';
        sectionDiv += '<span><input id="1-'+section.id+'-review" class="rdo-overall '+section.id+'-section required" name="'+section.id+'-section" value="1" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="2-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="2" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="3-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="3" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="4-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="4" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="5-'+section.id+'-review" class="rdo-overall '+section.id+'-section" name="'+section.id+'-section" value="5" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="0-' + section.id + '-review" class="rdo-overall '+section.id+'-section" name="' + section.id + '-section" value="0" type="radio" disabled /></span>';
        sectionDiv += '<span><input id="chk-'+section.id+'-section" class="chk-auto-calc" section="'+section.id+'" type="checkbox" checked /></span></div>';
        sectionDiv += '</div>';

        sectionDiv += '<div style="clear:both"></div>';
        sectionDiv += '<div class="slider" id="'+id+'">';
        sectionDiv += '</div>';
        sectionDiv += '<div style="clear:both"></div>';

        this.$ratingDiv.append($(sectionDiv));
    },

    getQuestion : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getAllQuestion";
        $.post(url, function(response){
            if(response.success){
                if(response.questions){
                    $.each(response.questions, function( index, value ) {
                        //if(value.section_name == 'Competence' || value.section_name == 'Compliance')
                        //    that.loadQuestionCC(value);
                        //else
                        that.loadQuestion(value);
                    });
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    loadQuestion : function(question){
        var divId,sectionDiv,subSection;

        if (typeof question.sub_section != 'undefined' && question.sub_section != '' && question.sub_section != null ){
            var sid = question.sub_section.replace(/\s+/g, '');
            divId = 'sub'+ sid;
            if($('#'+divId).length == 0){
                subSection = $('<p id="'+divId+'">'+question.sub_section+'</p>');
                $('#'+question.section_id + '-section').append(subSection);
            }
        }

        sectionDiv = '<div class="rating-head">';
        sectionDiv += '<div>'+question.name+'</div>';
        sectionDiv += '<div class="review-section '+question.section_id+'-review-section" section="'+question.section_id+'">';
        sectionDiv += '<span><input id="1-'+question.id+'" class="rdo-'+question.section_id+'-section required" name="'+question.id+'" value="1" type="radio" /></span>';
        sectionDiv += '<span><input id="2-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="2" type="radio" /></span>';
        sectionDiv += '<span><input id="3-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="3" type="radio" /></span>';
        sectionDiv += '<span><input id="4-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="4" type="radio" /></span>';
        sectionDiv += '<span><input id="5-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="5" type="radio" /></span>';
        sectionDiv += '<span><input id="0-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="0" type="radio" /></span>';
        sectionDiv += '<span><img id="'+question.review_info_id+'-reviewinfo"  class="tooltip-review" src="images/info.png" /></span>';
        sectionDiv += '</div>';

        $('#'+question.section_id + '-section').append(sectionDiv);
    },

    loadQuestionCC : function(question){
        var divId,sectionDiv,subSection;

        if (typeof question.sub_section != 'undefined' && question.sub_section != '' && question.sub_section != null ){
            var sid = question.sub_section.replace(/\s+/g, '');
            divId = 'sub'+ sid;
            if($('#'+divId).length == 0){
                subSection = $('<p id="'+divId+'">'+question.sub_section+'</p>');
                $('#'+question.section_id + '-section').append(subSection);
            }
        }

        sectionDiv = '<div class="rating-head">';
        sectionDiv += '<div>'+question.name+'</div>';
        sectionDiv += '<div class="review-section '+question.section_id+'-review-section" section="'+question.section_id+'">';
        sectionDiv += '<span class="cc-section"><input id="1-'+question.id+'" class="rdo-'+question.section_id+'-section required" name="'+question.id+'" value="1" type="radio" /></span>';
        sectionDiv += '<span class="cc-section"><input id="2-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="2" type="radio" /></span>';
        sectionDiv += '<span class="cc-section"><input id="3-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="3" type="radio" /></span>';
        sectionDiv += '<span><input id="0-'+question.id+'" class="rdo-'+question.section_id+'-section" name="'+question.id+'" value="0" type="radio" /></span>';
        sectionDiv += '<span><img id="'+question.review_info_id+'-reviewinfo"  class="tooltip-review" src="images/info.png" /></span>';
        sectionDiv += '</div>';

        $('#'+question.section_id + '-section').append(sectionDiv);
    },

    initReviewTable : function(tbl){
        tbl.html('');
        var tr = $('<tr></tr>');
        var th = $('<th></th>');
        var td = $('<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>n/a</td>');

        tr.append(th).append(td);
        tbl.append(tr);
    },

    reviewForm : function(question, tbl){
        var tr = $('<tr></tr>');
        var th = $('<th>'+question.name+'</th>');
        //var th = $('<th></th>');
        var td1 = $('<td><input id="1-'+question.id+'" name="'+question.id+'" value="1" type="radio"></td>');
        var td2 = $('<td><input id="2-'+question.id+'" name="'+question.id+'" value="2" type="radio"></td>');
        var td3 = $('<td><input id="3-'+question.id+'" name="'+question.id+'" value="3" type="radio"></td>');
        var td4 = $('<td><input id="4-'+question.id+'" name="'+question.id+'" value="4" type="radio"></td>');
        var td5 = $('<td><input id="5-'+question.id+'" name="'+question.id+'" value="5" type="radio"></td>');
        var td = $('<td><input id="0-'+question.id+'" name="'+question.id+'" value="0" type="radio"></td>');

        //var td = $('<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>n/a</td>');

        tr.append(th).append(td1).append(td2).append(td3).append(td4).append(td5).append(td);
        //tr.append(th).append(td);
        tbl.append(tr);
    },

    submitReview : function(){
        // Checked logged in
        if(oRsc.checkUserLoggedIn() && this.totalReviewRating >= 1){
            this.disable();
            this.enableFields();
            var fields = $('#frm-review-form :input').serialize();
            var url = SCRIPT_PATH + '?action=saveReview';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    that.enable();
                    //Refresh dom
                    var complaint = $('#complaint-report').is(":checked");
                    var strParam = "?saved_review=true&complaint="+complaint+"&review_id="+response.review+"&report_id="+response.report_id+"&total_score="+that.totalReviewRating;
                    window.location.replace(BASE_URL+strParam);
                }else{
                    // Todo: Display error msg
                    that.enable();
                }
            },'json');
        }
    },

    saveReviewForLaterEdit : function(){
        this.disable();
        this.enableFields();
        // Checked logged in
        if(oRsc.checkUserLoggedIn()){
            var fields = $('#frm-review-form :input').serialize();
            var url = SCRIPT_PATH + '?action=saveReviewForLaterEdit';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    that.enable();
                    that.handleResponse();
                    //Edit Review
                    oManageReview.init();
                }else{
                    // Todo: Display error msg
                    that.enable();
                }
            },'json');
        }
    },

    handleResponse : function(){
        $('#review-modal').modal('hide');
        //if(document.getElementById('complaint-report').checked)
        if($('#complaint-report').is(":checked"))
            $('#submit-review-complaint-modal').modal('show');
        else
            $('#saved-review-modal').modal('show');

    },

    handleSavedResponse : function(complaint,review_id,total_score){
        $('.complaint-review-id').val(review_id);
        $('#review-modal').modal('hide');

        if(complaint == "true")
            $('#submit-review-complaint-modal').modal('show');
        else
            $('#submit-review-modal').modal('show');
    },

    disable : function (){
        $('#progress-bar img').show();
        $("#review-submit-btn").prop("disabled",true);
        $("#review-save-btn").prop("disabled",true);
    },

    enable : function (){
        $('.modal-body').scrollTop(0);
        $('#progress-bar img').hide();
        $("#review-submit-btn").prop("disabled",false);
        $("#review-save-btn").prop("disabled",false);
    },

    showReview : function (id){
        this.reviewId = id;
        this.disableInput = true;
        $('#review-modal').modal('show');
        // get All section
        this.getSection('Show');
        // Close btn
        this.closeReviewShowBtn();

        //Hide Footer
        $('#review-modal .modal-footer').css('display' , 'none');
        $('#review-modal .modal-body').css('height' , '450px').css('margin-bottom','5px');
    },

    editReview : function (id){
        this.reviewId = id;
        $('#modal-review-id').val(id);
        this.disableInput = false;
        $('#review-modal').modal('show');

        // Log Activity
        this.logEditReviewStart(id);
        //Show Footer
        $('#review-modal .modal-footer').css('display' , 'block');
        $('#review-modal .modal-body').css('height' , '310px').css('margin-bottom','0');

        // Close btn
        this.closeReviewBtn();
        // Set form action
        $("#frm-review-form").attr('action', 'javascript:oReview.updateReview();');
        // get All section
        this.getSection('Edit');
        //Overall rating
        this.loadSection(this.overAllSection,true,true);
    },

    logEditReviewStart : function (id){
        var that = this;
        var url = SCRIPT_PATH + "?action=logReviewStart";
        var fields = {
            review_id : id
        };
        $.post(url,fields, function(response){
        }, 'json');
    },

    updateReview : function(){
        this.disable();
        this.enableFields();
        var fields = $('#frm-review-form :input').serialize();
        var url = SCRIPT_PATH + '?action=editReview';
        var that = this;
        $.post(url, fields, function(response){
            if(response.success){
                that.enable();
                $('#review-modal').modal('hide');
                oManageReview.init();
                location.reload();
            }else{
                // Todo: Display error msg
                that.enable();
            }
        },'json');
    },

    getReviewDetail : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getReviewDetail";
        var fields = {review_id : this.reviewId};
        $.post(url,fields, function(response){
            if(response.success){
                if(response.reviews){
                    that.Review = response;
                    that.showReviewDetail();
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    showReviewDetail : function(){
        var review = this.Review.reviews[0];
        $('#review-report-id').val(review.report_id);
        $('#project-report').html(review.project);
        $('#company-report').html(review.company);
        $('#code-report').html(review.code);
        $('#type-report').html(review.type);
        $('#cpqp-report').html(this.cleanString(review.cpqp));
        $('#date-report').html(review.date);
        $('#confirm-report').prop('checked',true).prop('disabled',true);

        $('#conflict-of-interest').val(review.reviewer_interest);
        $('#ausimm-code').val(review.ausimm_code);
        $('#competent-person-commodity').val(review.competent_person_commodity);
        $('#review-report-identity').val(review.reviewer_identity);
        $('#review-type').val(review.review_type);
        $('#review-notes').val(review.notes);
        this.autoHeight($("#review-notes"));

        // Section Rating
        var sections = this.Review.section_rating;
        $.each(sections, function( index, value ) {
            $('#'+value.score+'-'+value.section_id+'-review').prop('checked',true);
        });

        var ratings = this.Review.rating;
        $.each(ratings, function( index, value ) {
            $('#'+value.score+'-'+value.question_id).prop('checked',true);
        });
        // OverAll Rating
        $('#'+review.total_score+'-overall-rating-review').prop('checked',true);


        // Disabled
        if(this.disableInput){
            this.disableFields();
        }else{
            this.enableFields();
            if(review.review_type == '1'){
                this.isFatalFlaw();
            }else{
                $('.rdo-overall').prop('disabled',true);
            }
        }
    },

    isFatalFlaw : function(){
        $('.rdo-overall').prop('disabled',false).prop('disabled',false);
        $('.chk-auto-calc').prop('checked',false).prop('disabled',true);
        $('#chk-overall-rating-section').prop('checked',true).prop('disabled',false);
        $('.rdo-overall-total').prop('disabled',true);
    },

    disableFields : function (){
        $('#conflict-of-interest').prop('disabled',true);
        $('#ausimm-code').prop('disabled',true);
        $('#competent-person-commodity').prop('disabled',true);
        $('#review-report-identity').prop('disabled',true);
        $('#review-type').prop('disabled',true);
        $('.chk-auto-calc').prop('disabled',true);
        $('.review-section input').prop('disabled',true);
        $('#review-notes').prop('disabled',true);
    },

    enableFields : function (){
        $('#conflict-of-interest').prop('disabled',false);
        $('#ausimm-code').prop('disabled',false);
        $('#competent-person-commodity').prop('disabled',false);
        $('#review-report-identity').prop('disabled',false);
        $('#review-type').prop('disabled',false);
        $('.chk-auto-calc').prop('disabled',false);
        $('.rdo-overall').prop('disabled',false);
        $('.rdo-overall-total').prop('disabled',false);
        $('.review-section input').prop('disabled',false);
        $('#review-notes').prop('disabled',false);
    },

    closeReview : function (){
        $('#confirm-close-modal').modal('hide');
        $('#review-modal').modal('hide');
        // Log Activity
        this.logReviewClose();
    },

    logReviewClose : function (){
        var that = this;
        var url = SCRIPT_PATH + "?action=logReviewClose";
        var report_id = $('#review-report-id').val();
        var fields = {
            report_id : report_id
        };
        $.post(url,fields, function(response){
        }, 'json');
    },

    closeReviewShowBtn : function(){
        $('#close-review-btn').hide();
        $('#close-review-show-btn').show();
    },

    closeReviewBtn : function(){
        $('#close-review-show-btn').hide();
        $('#close-review-btn').show();
    }
};