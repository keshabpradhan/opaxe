<?php
/**
 * Created by shahzaib on 11/02/2019.
 */

/*
Plugin Name: Wpbakery remover
Description:  Removes wp bakery plugin from pages where we don't need this
*/

add_filter( 'option_active_plugins', 'lg_disable_cart66_plugin' );

function lg_disable_cart66_plugin($plugins){

    if((strpos($_SERVER['REQUEST_URI'], '/intel') ==true) ||  (strpos($_SERVER['REQUEST_URI'], 'register-redirect')==true) || (strpos($_SERVER['REQUEST_URI'], 'activate-registration')==true)) {
        $key = array_search( 'js_composer/js_composer.php' , $plugins );

        if ( false !== $key ) {
            unset( $plugins[$key] );
        }
    }

    return $plugins;
}
?>
