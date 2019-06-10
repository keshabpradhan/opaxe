<?php
/*Todo: RSC-MI taking parts down*/
header("Location: http://intel.rscmme.com");
?>
<html>
    <head lang="en">
    <meta charset="UTF-8">
    <title>RSC RESOURCE REPORTING INTELLIGENCE — RSC</title>

    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">


        <?php include 'header-inc.php';?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/site.css"/>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/custom.css?118"/>

        <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script>

    <style type="text/css">
        .title-desc-wrapper.no-main-image {display: none;}
        .rating-head > div {padding-bottom: 5px;padding-top: 5px;}
        #review-modal .modal-dialog {font-size: 0.9em;}
        .expendable > p {padding-top: 7px;}
        .modal-footer {padding-bottom: 7px !important;}
        body {background-color: #ffffff !important;}

    </style>

</head>
    <body>
        <div class="site-inner-wrapper">
            <?php include 'header.php';?>
            <?php include 'modals.php';?>

            <div class="left-navigation" >
                <div class="expert-panel-left-link">
                    <a href="signup.php" id="RP-4">Join the Panel</a>
                </div>
                <div class="expert-panel-left-link">
                    <a href="faq.php" id="RP-4">FAQ</a>
                </div>
                <div class="expert-panel-left-link">
                    <a href="#" onclick = "javascript:self.close();" id="RP-4">
                        Return to Map
                    </a>
                </div>
            </div>

            <section id="content-wrapper">
                <div id="review-panel-main">

                    <div id="expert-panel-paragraph">
                        <h3>RSC-MI Reviewing Panel – How it Works</h3>
                        <p>
                            As part of our efforts to help promote high quality resource reporting, RSC relies on the volunteer work of a panel of international experts from around the world to review public reports. Reviewers are screened based on their demonstrated skills and relevant experience by a committee consisting of public reporting specialists. Please check the <a href="faq.php">FAQ</a> page for more information on how RSC-MI works.
                        </p>
                        <p>If you wish to become a reviewer then please register <a href="signup.php">here</a>. </p>

                        <p>
                            If you do not meet the requirements to become a reviewer, then you can still review reports under a training scheme. This means that your rankings and review will not be used in averaging and publicly displaying a total score for a report. However, you will be able to compare your findings with those of the panel, and in due time, and after having carried out a number of these reviews, you may be included into the reviewing panel.
                        </p>

                        <p>
                            The reviewers review reports at their discretion, in accordance with their own areas of expertise. The reviews are designed to provide a quick indication of expert peer-review opinion to help stimulate discussion and promote high standards of reporting across the full range of mineral commodities and stages of project development.
                        </p>

                        <p>
                            While they have the option to review anonymously you can find out more about individual reviewers from their short biography below.
                        </p>

                        <p>
                            We are always looking for more experts to help review more reports, so if you would like to apply to join our expert panel please <a href="#">contact us</a>.
                        </p>

                        <h3 style="margin-bottom:-17px;">REVIEWERS</h3>
                    <div id="panel-biography">
                        <div id="userBiographyImage"> <img src="<?php bloginfo('template_url'); ?>/intel/images/loadingAnimation.gif"></div>

                    </div>
                    
                </div>
        </section>
        </div>
        
<script type="text/javascript">                  
$(document).ready(function() {
    oRsc.loadExpertPanel();
//    oRsc.populateCountries();
//    oRsc.populateCommodity();
    
});

$(document).ready(function () {

            window.multiselect = $('.multiSelect').SumoSelect();
        });
        
        $('#stocks').change(function() {
            var test=$(this).val();
            //var partsOfStr = string.split(',');
            $('#other').val(null);
           if(test.indexOf("Other") >= 0){

            $('#other').css('display', ($(this).val()) ? 'block' : 'none');
            $('#other').val(test);

            $('#stocks-div .CaptionCont').hide();
            
           }
      
    
    
});

function AddCommodity(){
    var commodityName = document.getElementById('commodity-name').value;
    
    var commodityExperience = document.getElementById('commodity-experience').value;
    var concatinatedValue=commodityName+':\t\t'+commodityExperience;
    
    var commodity = document.getElementById('commodity').value;
    if(commodity){
    var finalValue=commodity+'\n'+concatinatedValue;
    }
    else{
        var finalValue=concatinatedValue;
    }
    $('#commodity').val(finalValue);

};
</script>
    </body>
</html>