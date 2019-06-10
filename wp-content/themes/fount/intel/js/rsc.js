
    var clusterGroup;
    var geoJson;
    var geoJsonLayer;
    var map;
    var politicalLayer;
    var featureLayer;

    $(document).ready(function() {
        //Initialize
        oRsc.init();

        $('#tabs').tab();
        $('#mobileMenu').click(function(){
           $('.nav-wrapper').toggleClass("responsive-menu");
           $('#header').toggleClass("responsive-header");
           $('.site-title').toggleClass("responsive-logo");
        });
        
        $('.folder-parent a').click(function(){
           $(this).parent().find('ul').toggleClass("responsive-sub-menu");
           $(this).toggleClass("responsive-menu-collaps");
        });

        var action = oRsc.getUrlParameter('action');
        if(action == 'unsubscribe'){
            // Show Thanku popup
            $('#un-subscribe-modal').modal('show');
        }

        // Validate Form
        // $("#frm-subscribe-form").validate({
        //     rules: {
        //         field: {
        //             required: true,
        //             email: true
        //         },
        //         errorPlacement: function (error, element) {
        //         }
        //     }
        // });
    });

