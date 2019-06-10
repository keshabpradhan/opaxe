<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
/* Default comment here */ 

jQuery(window).resize(function() {
    console.log(jQuery(window).height());
    jQuery('iframe.pdfjs-viewer').css('height',jQuery(window).height());
    });</script>
<!-- end Simple Custom CSS and JS -->
