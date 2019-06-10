
<?php get_header(); ?>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon"/>

    <?php include 'header-inc.php';?>

    <style type="text/css">


        .leaflet-top.leaflet-right {
            top: 7em;
        }
        .title-desc-wrapper.no-main-image {
            display: none;
        }
        .leaflet-bottom.leaflet-left {
            z-index: 50;
        }
        /*body{
            background-color: #75D2E3;
        }*/

div#prk_footer_wrapper { display: none; }
section#content-wrapper { display: none; }
div#fount_ajax_back { display: none; }
div#report-pdf-modal { z-index: 999; }
.modal-backdrop.fade.in { z-index: 2; }
    </style>
<!--#if expr="$HTTP_COOKIE=/fonts\-loaded\=true/" -->
<html lang="en" class="fonts-loaded">
<!--#else -->
<html lang="en">
<!-- Load Mapbox JS + CSS -->
<link href='<?php bloginfo('template_url'); ?>/intel/css/mapbox.css' rel='stylesheet' />
<script  type="text/javascript" src="<?php bloginfo('template_url'); ?>/intel/js/mapbox.js"></script>
<leaflet markers="markers" watch-markers="no"></leaflet>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/opaxe.css"/>
<body>

<div class="site-inner-wrapper">

    <?php //include 'header.php';?>
<!--    --><?php include 'OpaxeModals.php';?>

    <section id="content-wrapper">
        <?php include 'content.php';?>
    </section>

    <?php //include 'review.php';?>
    <?php //include 'report-pdf-modal.php';?>
</div>
</body>

<?php
$url = get_query_var('url');
if($url){
?>
<script>
   localStorage.setItem("pdf_Url", <?= '"' . $url . '"' ?>);
</script>
<?php
}
get_footer();
 ?>
