var organisationInfoHTML = '<thead><tr><th>Acronym</th><th>Organisation</th><th>Recognised By</th></tr></thead>';
organisationInfoHTML += '<tbody>';
organisationInfoHTML += '<tr><td>AIG</td><td>Australian Institute of Geoscientists</td> <td>JORC</td></tr>';
organisationInfoHTML += '<tr><td>AIPG</td><td>American Institute of Professional Geologists</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APEGA</td><td>Association of Professional Engineers, Geologists and Geophysicists</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APEGBC</td><td>Association of Professional Engineers and Geoscientists of British Columbia</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APEGM</td><td>Association of Professional Engineers and Geoscientists of Manitoba</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APEGNB</td><td>Association of Professional Engineers and Geoscientists of New Brunswick</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APEGS</td><td>Association of Professional Engineers and Geoscientists of Saskatchewan</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>APGO</td><td>Association of Professional Geoscientists of Ontario</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>AusIMM</td><td>Australian Institute of Mining and Metallurgy</td><td>JORC</td></tr>';
organisationInfoHTML += '<tr><td>CCPG</td><td>The Canadian Council of Professional Geoscientists</td><td>JORC</td></tr>';
organisationInfoHTML += '<tr><td>Comisi&#243;n Minera</td><td>Comisi&#243;n Calificadora de Competencias en Rescursos y Reservas Mineras(Chilean Mining Commission or Comisi&#243;n Minera)</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>ECSA</td><td>Engineering Council of South Africa</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>EFG</td><td>European Federation of Geologists</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>&#8220;GNS&#8221;</td><td>Association of Professional Geoscientists of Nova Scotia</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>GSL</td><td>Geological Society of London</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>GSSA</td><td>Geological Society of South Africa</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>IGI</td><td>Institute of Geologists of Ireland</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>IMMM</td><td>Institue of Materials, Minerals and Mining</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>MMSA</td><td>Mining and Metallurgical Society of Ameria</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>NAPEG</td><td>Association of Professional Engineers, Geologists and Geophysicits of the Northwest Territories</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>OERN</td><td>Russian Society of subsoil Use Experts</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>OGQ</td><td>Ordre des Geologues du Qu&#233;bec</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>OIQ</td><td>Ordre des Ing&#233;nieurs du Qu&#233;bec</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>PEGNL</td><td>Association of Professional Engineers and Geoscientists of Newfoundland and Labrador</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>PEO</td><td>Professional Engineers Ontario</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>PLATO</td><td>South African Council for Professional and Technical Surveyors</td><td>NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>SACNASP</td><td>South African Council for Natural Scientific Professions</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>SAIMM</td><td>The Southern African Institute of Mining and Metallurgy</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '<tr><td>SME</td><td>Society for Mining, Metallurgy & Exploration</td><td>JORC, NI 43-101</td></tr>';
organisationInfoHTML += '</tbody>';

var oComplaint = {
    _personalOrganisation : 1,
    _cpqpPerson : 1,
    _cpqpOrganisation : 1,
    _reportType : '',
    _reviewerDetail : null,
    _membership : [
        {id : 'AIG',name : 'AIG'},
        {id : 'AIPG',name : 'AIPG'},
        {id : 'APEGBC',name : 'APEGBC'},
        {id : 'APEGM',name : 'APEGM'},
        {id : 'APGO',name : 'APGO'},
        {id : 'AusIMM',name : 'AusIMM'},
        {id : 'CCPG',name : 'CCPG'},
        {id : 'Comision Minera',name : 'Comision Minera'},
        {id : 'ECSA',name : 'ECSA'},
        {id : 'EFG',name : 'EFG'},
        {id : 'GSL',name : 'GSL'},
        {id : 'GSSA',name : 'GSSA'},
        {id : 'IGI',name : 'IGI'},
        {id : 'IMMM',name : 'IMMM'},
        {id : 'MMSA',name : 'MMSA'},
        {id : 'PLATO',name : 'PLATO'},
        {id : 'PEO',name : 'PEO'},
        {id : 'SACNASP',name : 'SACNASP'},
        {id : 'SAIMM',name : 'SAIMM'},
        {id : 'SME',name : 'SME'},
        {id : 'PEGNL',name : 'PEGNL'},
        {id : 'NAPEG',name : 'NAPEG'},
        {id : 'Geosci. Nova Scotia',name : 'Geosci. Nova Scotia'},
        {id : 'APEGNB',name : 'APEGNB'},
        {id : 'APEGA',name : 'APEGA'},
        {id : 'APEGS',name : 'APEGS'},
        {id : 'OGQ',name : 'OGQ'},
        {id : 'OIQ',name : 'OIQ'},
        {id : 'OERN',name : 'OERN'}
    ],

    _memberIssue : [
        {id : '1',name : 'Not a member of this Organisation'},
        {id : '2',name : 'Is a member,but not at the required level'}
    ],
    _breachConduct : [
        {id : '1',name : 'By-Law'},
        {id : '1',name : 'Code of Ethics'},
        {id : '1',name : 'Reporting Code Guideline'}
    ],

    _responsibility : [
        {id : 'overall_report',name : 'Overall Report', resource_estimation : '', exploration_update : ''},
        {id : 'mining_methods',name : 'Mining Methods', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'property_description',name : 'Property Description', resource_estimation : '', exploration_update : ''},
        {id : 'recovery_methods',name : 'Recovery Methods', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'project_history',name : 'Project History', resource_estimation : '', exploration_update : ''},
        {id : 'project_infrastructure',name : 'Project Infrastructure', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'geology_mineralisation',name : 'Geology/Mineralisation', resource_estimation : '', exploration_update : ''},
        {id : 'market_studies',name : 'Market Studies', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'deposit_types',name : 'Deposit Types', resource_estimation : '', exploration_update : ''},
        {id : 'environmental_social_studies',name : 'Environmental/Social Studies', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'exploration_results',name : 'Exploration Results', resource_estimation : '', exploration_update : ''},
        {id : 'capital_operational_costs',name : 'Capital & Operational Costs', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'mineral_processing',name : 'Mineral Processing', resource_estimation : '', exploration_update : ''},
        {id : 'economic_analysis',name : 'Economic Analysis', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'mineral_resources',name : 'Mineral Resources', resource_estimation : '', exploration_update : 'disabled'},
        {id : 'conclusions',name : 'Conclusions', resource_estimation : '', exploration_update : ''},
        {id : 'ore_reserves',name : 'Ore Reserves', resource_estimation : 'disabled', exploration_update : 'disabled'},
        {id : 'recommendations',name : 'Recommendations', resource_estimation : '', exploration_update : ''}
    ],

    _info : [
        {id : 'cpqp-detail-autofill-info',information : '<p>We are compiling a database of CP/QP details to help automate this section, and to enable CPs/QPs to be notified in the event one of their report receives a bad review. While the database does not yet contain all the relevant for information for all of the CPs/QPs associated with the reports we have on file, you can tick this box to autofill the details we have already collected.</p>'},
        {id : 'cpqp-responsibility-info',information : '<p>Please indicate the sections of the report for which this CP/QP takes responsibility. (Note: automatic &#8220;n/a&#8221; entries can still be selected if they are applicable)</p>'},
        {id : 'cpqp-organisation-info', table : organisationInfoHTML , information : '<p>Competent/Qualified Persons are required to be members of one or more of the following Recognised Professional Organisations and Associations:</p>'},
        {id : 'cpqp-detail-complaint-info',information : '<p>Please indicate the type of complaint you wish to make against this particular CP/QP. You can select both.</p>'},
        {id : 'cpqp-member-issue-info',information : "<p>Different Codes require different CPs/QPs to be members of one or more professional organisation or associations. In addition, a person's membership status may need to be of a certain level or above in order to meet the criteria for being a CP or QP.</p>"},
        {id : 'cpqp-breached-regulation-info',information : '<p>Please indicate the type of regulation that has been breached that is associated with the professional organisation chosen perviously.</p>'},
        {id : 'cpqp-code-guideline-info',information : '<p>Please provide the name or title of the By-Law, COde of Ethics or Reporting Code/Guideline that has been breached.</p>'},
        {id : 'cpqp-specific-clause-info',information : '<p>Please specify the exact clause or clauses that have been breached.</p>'},
        {id : 'cpqp-add-organisation-info',information : '<p>Click if you wish to send a complaint to multiple professional organisations/or associations and fill in the relevent  complaint details.</p>'},
        {id : 'cpqp-submit-database-info',information : '<p>We are compiling a database of CP/QP detail to help automate this section, and to enable CPs/QPs to be notified in the event one of their reports receives a bad review. The database does not yet contain all the relevant information required to do this but you can help out by ticking this box if you have manually entered information about CPs/QPs associated with this report. The information will be submitted to RSC for review and incorporation into our database.</p>'},
        {id : 'cpqp-add-person-info',information : '</p>Click if you wish to make complaints against multiple CPs/QPs associated with this report.</p>'}
    ],

    // Initialize once
    initComplaint : function(){
        var that = this;
        //cache
        this.$ratingDiv = $('div.complaint-content');

        // Load Reviewer Personal Detail
        this.getReviewerDetail();
        //Initialize expendable div
        this.toggleSlides();
        // Add Personal Organisation
        this.addPersonalOrganisation();
        // Add CPQP Person, Organisation
        this.addPersonCPQP();
        this.addOrganisationCPQP();

        // Complaint Info
        this.complaintInfo();

        // Display uploaded file name
        $('input[type=file]#upload-attach-file').change(function (e) {
            $('#customFileUpload').html($(this).val()).show();
        });

        // Upload File to server
        this.uploadFile();

        // Personal Detail
        $("#auto-fill-personal").change(function(){
            if ($(this).prop('checked')) {
                that.setReviewerDetail();
            }else{
                that.resetReviewerDetail();
            }
        });
    },

    init : function(){
        $('#submit-review-complaint-modal').modal('hide');
        $('#complaint-modal').modal('show');
        this.getReviewerDetail();
        this.showReportDetail();
        this.checkNotApplicableResponsibility();
    },

    featureNotFound : function(){
        this.closeComplaint();
        $('#feature-not-found-modal').modal('show');
        setTimeout(function(){
            $('#feature-not-found-modal').modal('hide');
        },3000);
    },

    checkNotApplicableResponsibility :  function(){
        for (var i = 0; i < this._responsibility.length; i++) {
            if (this._reportType == 'Resource Estimation' && this._responsibility[i].resource_estimation == 'disabled') {
                $('.'+this._responsibility[i].id).prop('disabled', true);

            } else if (this._reportType == 'Exploration/Drilling Update' && this._responsibility[i].exploration_update == 'disabled') {
                $('.'+this._responsibility[i].id).prop('disabled', true);
            }else{
                $('.'+this._responsibility[i].id).prop('disabled', false);
            }
        }
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

    complaintInfo : function(){
        // Info Link
        var that = this, id;
        var $div = $("div.review-info-popup");
        var $modal = $('#complaint-modal');
        $modal.on('mouseover', '.tooltip-complaint', function() {
            id = this.id;
            var position = $(this).offset();
            var top =position.top - $(document).scrollTop() - 22;
            var left =position.left + 25;

            if(id == 'cpqp-organisation-info')
                $div.css({'top': top, 'left': left, 'display': 'inline', 'z-index':999999, 'width':'36%'} );
            else
                $div.css({'top': top, 'left': left, 'display': 'inline', 'z-index':999999, 'width':'30%'} );

            var complaintInfo = oReview.getObjById(that._info,id);
            complaintInfo = complaintInfo[0];
            var popupContent = '<img class="callout" src="images/arrow.png" />';
            if(id == 'cpqp-organisation-info')
                popupContent += '<button onclick="javascript:oReview.closeInfoPopup();" type="button" class="close" aria-hidden="true">&times;</button>';

            popupContent += '<div>';

            if(id == 'cpqp-organisation-info'){
                var _docHeight = (document.height !== undefined) ? document.height : document.body.offsetHeight;
                var tableHeight = _docHeight - top - 100;
                tableHeight = tableHeight + 'px';
                var html = complaintInfo.information;
                html += '<table id="tblOrganisationInfo" style="max-height: '+tableHeight+'">';
                html += complaintInfo.table;
                html += '</table>';
                popupContent += html;
            }else{
                popupContent += complaintInfo.information;
            }



            popupContent += '</div>';

            $div.html(popupContent);
        });

        $modal.on('mouseout', '.tooltip-complaint', function(){
            if(id != 'cpqp-organisation-info')
                oReview.closeInfoPopup();
        });
    },

    getReviewerDetail : function(){
        var that = this;
        var url = SCRIPT_PATH + "?action=getReviewerDetail";
        $.post(url, function(response){
            if(response.success){
                if(response.success){
                    that._reviewerDetail = response.reviewer;
                    that.setReviewerDetail();
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    setReviewerDetail : function(){
        var reviewer = this._reviewerDetail;
        var name = reviewer.firstname + ' ' + reviewer.lastname;
        $('#complaint-name').val(name);
        $('#complaint-email').val(reviewer.email);
        $('#complaint-telephone').val(reviewer.phone);
        $('#complaint-organization').val(reviewer.company);
    },

    resetReviewerDetail : function(){
        $('#complaint-name').val('');
        $('#preferred-address').val('');
        $('#preferred-address-1').val('');
        $('#preferred-address-2').val('');
        $('#complaint-email').val('');
        $('#complaint-telephone').val('');
        $('#complaint-prefer-contacted').val('');
        $('#complaint-organization').val('');
        $('#complaint-membership-number').val('');
    },

    showReportDetail : function(){
        var report_id = $('#review-report-id').val();
        this.getReportById(report_id);
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
                    that.checkNotApplicableResponsibility();
                }
            }else{
                //Todo: Display some error
            }
        }, 'json');
    },

    setReportDetail : function(feature){
        $('#project-complaint').html(feature.project);
        $('#company-complaint').html(feature.company);
        $('#code-complaint').html(feature.code);
        $('#type-complaint').html(feature.type);
        $('#cpqp-complaint').html(oReview.cleanString(feature.cpqp));
        $('#date-complaint').html(feature.date);

        $('#txt-project-complaint').val(feature.project);
        $('#txt-company-complaint').val(feature.company);
        $('#txt-code-complaint').val(feature.code);
        $('#txt-type-complaint').val(feature.type);
        $('#txt-cpqp-complaint').val(oReview.cleanString(feature.cpqp));
        $('#txt-date-complaint').val(feature.date);
        $('#txt-download-complaint').val(feature.download);
    },

    closeComplaint : function (){
        $('#confirm-close-complaint-modal').modal('hide');
        $('#complaint-modal').modal('hide');
    },

    addPersonalOrganisation : function(){
        var $membership = $('#membership');
        var organisation, div, label, input;
        organisation  = $('<div class="organisation"></div>');
        // Organisation
        div = $('<div></div>');
        label = $('<label>Organisation '+this._personalOrganisation+': </label>');
        input = $('<input type="text" name="complaint-organization[]" id="complaint-organization" />');
        div.append(label).append(input);
        organisation.append(div);
        // Membership No
        div = $('<div></div>');
        label = $('<label>Membership No: </label>');
        input = $(' <input type="text" name="complaint-membership-number[]" id="complaint-membership-number" />');
        div.append(label).append(input);
        organisation.append(div);

        $membership.append(organisation);

        this._personalOrganisation += 1;

    },

    addPersonCPQP : function(){
        var $cpqpConatainer = $('#cpqp-person');
        var $cpqpPerson = $('<div id="cpqp-person-'+this._cpqpPerson+'"></div>');
        var h3, div, label, input, p, imgInfo, responsibility,leftDiv,rightDiv,disabledLeft,disabledRight;

        h3 = $('<h3>Competent/Qualified Person '+this._cpqpPerson+':</h3>');
        $cpqpPerson.append(h3);

        // Name
        div = $('<div></div>');
        label = $('<label>Name: </label>');
        input = $('<input type="text" name="complaint-cpqp-name[]" id="complaint-cpqp-name-'+this._cpqpPerson+'" class="complaint-name" />');
        div.append(label).append(input);
        $cpqpPerson.append(div);
        // Company
        div = $('<div></div>');
        label = $('<label>Company: </label>');
        input = $('<input type="text" name="complaint-company[]" id="complaint-company-'+this._cpqpPerson+'" />');
        div.append(label).append(input);
        $cpqpPerson.append(div);
        //  Report Responsibility
        p = $('<p></p>');
        imgInfo = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-responsibility-info" />');
        p.append(imgInfo);
        p.append('Report Responsibility:');
        $cpqpPerson.append(p);

        //complaint-responsibility
        responsibility = $('<div id="complaint-responsibility"></div>');
        for (var i = 0; i < this._responsibility.length; i+=2) {
            if(this._reportType == 'Resource Estimation'){
                disabledLeft = this._responsibility[i].resource_estimation;
                disabledRight = this._responsibility[i+1].resource_estimation;
            }else if(this._reportType == 'Exploration/Drilling Update'){
                disabledLeft = this._responsibility[i].exploration_update;
                disabledRight = this._responsibility[i+1].exploration_update;
            }else{
                disabledLeft = '';
                disabledRight = '';
            }

            div = $('<div></div>');
            leftDiv = $('<div class="left-responsibility"></div>');
            label = $('<label>'+this._responsibility[i].name+': </label>');
            input = $('<input type="checkbox" '+disabledLeft+' class="required not-left-nav '+this._responsibility[i].id+'" id="'+this._responsibility[i].id+'" name="'+this._responsibility[i].id+'[]" />');
            leftDiv.append(label).append(input);


            rightDiv = $('<div class="right-responsibility">');
            if (typeof this._responsibility[i+1] != 'undefined'){
                label = $('<label>'+ this._responsibility[i+1].name +': </label>');
                input = $('<input type="checkbox" '+disabledRight+' class="required not-left-nav '+this._responsibility[i+1].id+'" id="'+this._responsibility[i+1].id+'" name="'+this._responsibility[i+1].id+'" />');
                rightDiv.append(label).append(input);
            }
            div.append(leftDiv).append(rightDiv);
            responsibility.append(div);
        }
        //Other
        div = $('<div></div>');
        leftDiv = $('<div class="other-responsibility"></div>');
        label = $('<label>Other: </label>');
        input = $('<textarea id="cpqp-other" name="cpqp-other[]" cols="57" rows="2" placeholder="Please Specify..."></textarea>');
        leftDiv.append(label).append(input);
        div.append(leftDiv);
        responsibility.append(div);

        $cpqpPerson.append(responsibility);
        $cpqpConatainer.append($cpqpPerson);

        this._cpqpPerson += 1;
    },

    addOrganisationCPQP : function(){
        var div,label,input,img, p, a,conBreach;
        var $cpqpConatainer = $('#cpqp-organisation');

        var $cpqpOrganisation = $('<div id="cpqp-organisation-'+this._cpqpOrganisation+'"></div>');
        div = $('<div></div>');
        label = $('<label>Membership/Organisation '+this._cpqpOrganisation+':</label>');
        input = $('<select class="required" id="cpqp-membership-organisation" name="cpqp-membership-organisation[]"></select>');
        input.append('<option value="">Please choose..</option>');
        $.each(this._membership, function(i, mem){
            input.append('<option>'+mem.name+'</option>');
        });
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-organisation-info">');
        div.append(label).append(input).append(img);
        $cpqpOrganisation.append(div);


        div = $('<div class="cpqp-detail-complaint"></div>');
        label = $('<label>Complaint:</label>');
        div.append(label);
        p = $('<p class="member-issue"></p>');
        label = $('<label>Membership Issue</label>');
        input = $('<input type="checkbox" class="required not-left-nav" id="cpqp-membership-issue" name="cpqp-membership-issue[]" />');
        p.append(label).append(input);
        div.append(p);
        p = $('<p></p>');
        label = $('<label>Breach of Conduct/Ethics</label>');
        input = $('<input type="checkbox" class="required not-left-nav" id="cpqp-breach-ethics" name="cpqp-breach-ethics[]" />');
        p.append(label).append(input);
        div.append(p);
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-detail-complaint-info">');
        div.append(img);
        $cpqpOrganisation.append(div);


        // Member Issue
        div = $('<div class="cpqp-organisation-complaint"></div>');
        p = $('<p>Membership Issue</p>');
        label = $('<label>This Person is:</label>');
        input = $('<select id="member-issue-complaint" name="member-issue-contacted[]"></select>');
        input.append('<option value="">Please choose..</option>');
        $.each(this._memberIssue, function(i, mem){
            input.append('<option value="'+mem.id+'">'+mem.name+'</option>');
        });
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-member-issue-info">');
        div.append(p).append(label).append(input).append(img);
        $cpqpOrganisation.append(div);

        // Breach of Conduct/Ethics
        conBreach = $('<div class="breach-conduct-'+this._cpqpOrganisation+'"></div>');
        div = this.addBreachCPQP(this._cpqpOrganisation);
        conBreach.append(div);
        $cpqpOrganisation.append(conBreach);


        $cpqpConatainer.append($cpqpOrganisation);

        div = $('<div class="add-organisation-complaint"></div>');
        a = $('<a href="#" onclick="javascript:oComplaint.addOrganisationCPQP();">+ add organisation</a>');
        label = $('<label>This Person is:</label>');
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-add-organisation-info">');
        div.append(a).append(img);
        $cpqpConatainer.append(div);


        this._cpqpOrganisation += 1;
    },

    addBreachCPQP :  function(con){
        var conBreach,div,label,input,img, p, a, divBreach,divClr;
        conBreach = $('<div></div>');
        divBreach = $('<div class="cpqp-organisation-complaint"></div>');
        div = $('<div></div>');
        p = $('<p>Breach of Conduct/Ethics</p>');
        label = $('<label>Breached Regulation:</label>');
        input = $('<select id="breach-conduct-contacted" name="breach-conduct-contacted[]"></select>');
        input.append('<option>Please choose..</option>');
        $.each(this._breachConduct, function(i, mem){
            input.append('<option value="'+mem.name+'">'+mem.name+'</option>');
        });
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-breached-regulation-info">');
        div.append(p).append(label).append(input).append(img);
        divBreach.append(div);
        conBreach.append(divBreach);

        divClr = $('<div style="clear:both"></div>');
        divBreach.append(divClr);
        div = $('<div></div>');
        label = $('<label>Code/Guideline:</label>');
        input = $('<input type="text" name="cpqp-code-guideline[]" id="cpqp-code-guideline" placeholder="Please Specify..." />');
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-code-guideline-info">');
        div.append(label).append(input).append(img);
        divBreach.append(div);
        conBreach.append(divBreach);

        divClr = $('<div style="clear:both"></div>');
        divBreach.append(divClr);
        div = $('<div></div>');
        label = $('<label>Specific Clause:</label>');
        input = $('<textarea name="cpqp-specific-clause[]" id="cpqp-specific-clause" cols="37" rows="3" placeholder="Please Specify..."></textarea>');
        img = $('<img src="images/info.png" class="tooltip-complaint" id="cpqp-specific-clause-info">');
        div.append(label).append(input).append(img);
        divBreach.append(div);
        conBreach.append(divBreach);

        divClr = $('<div style="clear:both"></div>');
        divBreach.append(divClr);
        div = $('<div></div>');
        a= $('<a href="#" onclick="javascript:oComplaint.addBreach('+con+');">+ add breach</a>');
        div.append(a);
        conBreach.append(div);

        return conBreach;
    },

    addBreach : function(conID){
        var conBreach,div;
        conBreach = $('.breach-conduct-'+conID);
        div = this.addBreachCPQP(conID);
        conBreach.append(div);
    },

    submitComplaint : function(){
        if(oRsc.checkUserLoggedIn()){
            this.disable();
            var fields = $('#frm-complaint-form').serialize();
            //var fields = new FormData($('#frm-complaint-form')[0]);
            var url = SCRIPT_PATH + '?action=saveComplaint';
            var that = this;
            $.post(url, fields, function(response){
                if(response.success){
                    that.enable();
                    $('#complaint-modal').modal('hide');
                    $('#complaint-thankyou-modal').modal('show');
                    setTimeout(function(){
                        $('#complaint-thankyou-modal').modal('hide');
                    },3000);
                }else{
                    // Todo: Display error msg
                    that.enable();
                }
            },'json');
        }
    },

    disable : function (){
        $('#progress-bar img').show();
        $("#complaint-submit-btn").prop("disabled",true);
        $("#complaint-save-btn").prop("disabled",true);
    },

    enable : function (){
        $('.modal-body').scrollTop(0);
        $('#progress-bar img').hide();
        $("#complaint-submit-btn").prop("disabled",false);
        $("#complaint-save-btn").prop("disabled",false);
    },

    saveComplaintForLaterEdit : function(){

    },

    uploadFile : function(){
        $('#uploadAttachForm').ajaxForm({
            success:function(response){
                var objResponse = JSON.parse(response);
                $('#attchedFileName').val(objResponse.file_name);
            }
        },'json');

        $('#upload-attach-file').change(function() {
            $('#uploadAttachForm').submit();
        });
    }

};