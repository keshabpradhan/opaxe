<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>RSC RESOURCE REPORTING INTELLIGENCE — RSC</title>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <?php include 'header-inc.php';?>

    <link rel="stylesheet" href="css/site.css?109">
    <link rel="stylesheet" href="css/custom.css?113">
    <link rel="stylesheet" href="css/review-form.css?109">
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.form.js"></script>

    <!-------------------------TINYMCE TEXT EDITOR------------------------>
    <script type="text/javascript" src="js/tinymce/tinymce.min.js" ></script>

    <script src="js/star-rating.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
   
    <style type="text/css">
       html, body {margin: 0; height: 100%; font-family: sans-serif;}
        .main-nav ul li a span, .main-nav ul li a:visited span {font-family: sans-serif;font-size: 0.9em;}
       select {font-family: sans-serif;font-size: 0.9em;}
        .title-desc-wrapper.no-main-image {
            display: none;
        }

       .conflict-of-interest-span, .review-right-span {display: inline !important;}
       #review-modal .modal-dialog, .complaint-modal .modal-dialog {font-size: 12px;line-height: 1.6;}
       #review-modal button,#review-modal input,#review-modal select,#review-modal textarea {font-family: sans-serif;font-size: 12px !important;}
       #review-modal #close-review-btn{font-size: 21px !important;}
       #review-modal #close-review-show-btn {font-size: 21px !important;}
    </style>
</head>

</head>
<body>
<div class="site-inner-wrapper">
    <?php include 'header.php';?>
    <?php include 'modals.php';?>

    <div class="left-navigation" >
        <div class="expert-panel-left-link">
            <a onclick="javascript:oRsc.signuppopup();" href="#" id="RP-4">Join the Panel</a>
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
                <h2 style="margin: 0 0 0.5em;">REPORT REVIEWS</h2>

        <div id="summary-container" class="leaflet-popup-content">

            <div id="report-detail">
                <h3 style="margin:0 0 14px;">REPORT DETAILS:</h3>
                <table id="table-1">
                    <tr>
                        <td class="color-class">Date :</td>
                        <td id="date1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">Company Name :</td>
                        <td id="company1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">Project :</td>
                        <td id="project1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">Report Code :</td>
                        <td id="code1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">Report Type :</td>
                        <td id="type1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">CP/QP :</td>
                        <td id="cpqp1" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                    <tr>
                        <td class="color-class">OVERALL RATING :</td>
                        <td id="summary-overall-report-rating" class="data-to-filled"><img src="images/loadingAnimation.gif"></td>
                    </tr>
                </table>
            </div>

            <div id="review-summary" >
                <p>This report has been reviewed by the following reviewers:</p>
                <br>
                <div id="reviewed-by">
                    <div id="userdataimage"> <img src="images/loadingAnimation.gif"></div>
                </div>

                <div style="clear: both"></div>
                <div id="review-scale">
                    

                </div>
            </div>

        </div>

        <div style="clear: both"></div>
        <h3 style="margin: 0px">REVIEW:</h3>
        <div id="reviews">
             <div id="userreviewdataimage"> <img src="images/loadingAnimation.gif"></div>
        </div>

            </div>
    </section>
</div>
<?php include 'review.php';?>
<script type="application/javascript">
//    Parse.initialize("CroCUrbGQVQZgMz3wdZzH6tNerAo4yCt80E2l0rq", "hqYOi2j8hdyIwlc0XOTCe2kQrv80FAItwDGVOB10");
    $(document).ready(function() {
        oReviewSummary.init();
        oReview.initReview();
        oReview.fullReviewHidden();
    });
</script>

</body>
</html>