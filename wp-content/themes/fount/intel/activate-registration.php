<?php get_header(); ?>
<html>
<head>
    <style type="text/css">
        body {
            font: 14px/20px Arial, sans-serif;
            margin: 0;
            padding: 75px 0 0 0;
            text-align: center;
            -webkit-text-size-adjust: none;
            background-color: #999999;
        }

        p {
            padding: 0 0 10px 0;
        }

        h1 img {
            max-width: 100%;
            height: auto !important;
            vertical-align: bottom;
        }

        h2 {
            font-size: 22px;
            line-height: 28px;
            margin: 0 0 12px 0;
        }

        h3 {
            margin: 0 0 12px 0;
        }

        .headerBar {
            background: none;
            padding: 20px;
            border: none;
            background-color: #CCCCCC;
            border-bottom: 0px solid #000000;
        }

        .wrapper {
            width: 600px;
            margin: 0 auto 10px auto;
            text-align: left;
        }

        .formEmailButton {
            display: inline-block;
            font-weight: 500;
            font-size: 16px;
            line-height: 42px;
            font-family: Arial, sans-serif;
            width: auto;
            white-space: nowrap;
            height: 42px;
            margin: 12px 5px 12px 0;
            padding: 0 22px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            border: 0;
            border-radius: 3px;
            vertical-align: top;
        }

        body, #bodyTable {
            background-color: #eeeeee;
        }

        h1 {
            font-size: 28px;
            line-height: 110%;
            margin-bottom: 30px;
            margin-top: 0;
            padding: 0;
        }

        #templateContainer, #templateContainer2 {
            display: none;
        }

        #templateBody {
            background-color: #ffffff;
        }

        .bodyContent {
            line-height: 150%;
            font-family: Helvetica;
            font-size: 14px;
            color: #333333;
            padding: 20px;
        }

        a:link, a:active, a:visited, a {
            color: #0000FF;
        }

        .formEmailButton:link, .formEmailButton:active, .formEmailButton:visited, .formEmailButton, .formEmailButton span {
            background-color: #5d5d5d !important;
            color: #ffffff !important;
        }

        div#prk_responsive_menu {
            display: none;
        }
        #prk_footer{
            display: none;
        }
    </style>

</head>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-ui.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php bloginfo('template_url'); ?>/intel/js/reset-password.js"></script>
<?php $email = $GLOBALS['_GET']['email'];
$status = $GLOBALS['_GET']['status'];
if (!is_user_logged_in() && $email != null) {
    ?>

    <body onload="activateReg('<?php echo $email; ?>')">
    <div class="wrapper rounded6" id="templateContainer">
        <h1 class="masthead"><img src="/wp-content/uploads/2019/04/opaxe-logo.png" alt="" border="0" style="border:0px  ; border-color:; border-style:; border-width: 0px; height: 247px; width: 955px; margin: 0; padding: 0;" width="955" height="247"></h1>
        <div id="templateBody" class="bodyContent rounded6">
            <h2 style="color:#FC2020">Registration Confirmed</h2>
            <div>
                <p>Thank you for your registration. Your account to opaxe has been activated.</p>
                <p>You can now login and explore the additional features. Enjoy!</p>
                <!--<div class="vcard"><span class="org fn">RSCMME Ltd.</   span><div class="adr"><div class="street-address">Suite 5 Level 3 1111 Hay Street</div><span class="locality">West Perth</span>, <span class="region">WA</span>  <span class="postal-code">6005</span> <div class="country-name">Australia</div></div><br><a href="//rscmme.us5.list-manage.com/vcard?u=2ccf06e2022ac43c8d1935fa5&id=7a7174148c" class="hcard-download">Add us to your address book</a></div>-->
                <!--</div>-->
                <br>
                <a class="formEmailButton" href="https://www.opaxe.com/?login=true">&laquo; return to our website</a>
            </div>
        </div>
    </div>

    <div class="wrapper rounded6" id="templateContainer2">
        <h1 class="masthead"><img src="https://gallery.mailchimp.com/2ccf06e2022ac43c8d1935fa5/images/banner.jpg" alt="" border="0" style="border:0px  ; border-color:; border-style:; border-width: 0px; height: 247px; width: 955px; margin: 0; padding: 0;" width="955" height="247"></h1>
        <div id="templateBody" class="bodyContent rounded6">

            <h2>Already Registered</h2>
            <div>
                <p>You are already subscribed to our mailchimp list.</p>
                <p>You can update your profile below!</p>
                <br>
                <a class="formEmailButton" href="http://intel.rscmme.com">&laquo; return to our website</a>
            </div>
        </div>
    </div>

    </body>
<?php } else if ($status == 'subscribed') {
    $key = $_GET['key'];
    ?>
    <div class="wrapper rounded6">
        <h1 class="masthead"><img src="https://gallery.mailchimp.com/2ccf06e2022ac43c8d1935fa5/images/banner.jpg" alt="" border="0" style="border:0px  ; border-color:; border-style:; border-width: 0px; height: 247px; width: 955px; margin: 0; padding: 0;" width="955" height="247"></h1>

        <div id="templateBody" class="bodyContent rounded6">

            <h2>Already Registered</h2>
            <div>
                <p>You are already subscribed to our mailchimp list.</p>
                <p>You can update your profile below!</p>
                <br>
                <a class="formEmailButton" href="http://intel.rscmme.com">&laquo; return to our website</a>
            </div>
        </div>
    </div>
<?php } else {

    ?>
    <body>
    <div style="margin: 238px">
        <div class="alert alert-danger">
            <strong>Admin Info!</strong> You are not allowed to access this page.
        </div>
    </div>
    </body>
<?php } ?>
</html>