<?php

/* Custom Options Arrays ----------------------------------------------------- */

// Used in "Button", "Call __( 'Blue', 'js_composer' )to Action", "Pie chart" blocks
$colors_arr = array(
    __( 'Grey', 'js_composer' ) => 'wpb_button',
    __( 'Blue', 'js_composer' ) => 'btn-primary',
    __( 'Turquoise', 'js_composer' ) => 'btn-info',
    __( 'Green', 'js_composer' ) => 'btn-success',
    __( 'Orange', 'js_composer' ) => 'btn-warning',
    __( 'Red', 'js_composer' ) => 'btn-danger',
    __( 'Black', 'js_composer' ) => "btn-inverse"
);
// Used in "Button" and "Call to Action" blocks
$size_arr = array(
    __( 'Regular size', 'js_composer' ) => 'wpb_regularsize',
    __( 'Large', 'js_composer' ) => 'btn-large',
    __( 'Small', 'js_composer' ) => 'btn-small',
    __( 'Mini', 'js_composer' ) => "btn-mini"
);
$rotator_arr = array(
    __( 'Smooth shift', 'js_composer' ) => "old_timey",
    __( '3D effect', 'js_composer' ) => "rotate-1",
    __( 'Fast character rotation', 'js_composer' ) => "rotate-2 letters",
    __( 'Slide', 'js_composer' ) => "slide",
    __( 'Zoom', 'js_composer' ) => "rotate-3 letters",
    __( 'Character shift', 'js_composer' ) => "scale letters",
    __( 'Scale', 'js_composer' ) => "scale letters"
);
// Used in Icons
$fount_icons_arr = array(
  __( '<div class="fount_icon_selector"><i class="fount_fa-adjust"></i></div>', 'js_composer' ) => 'fount_fa-adjust',
__( '<div class="fount_icon_selector"><i class="fount_fa-anchor"></i></div>', 'js_composer' ) => 'fount_fa-anchor',
__( '<div class="fount_icon_selector"><i class="fount_fa-archive"></i></div>', 'js_composer' ) => 'fount_fa-archive',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows"></i></div>', 'js_composer' ) => 'fount_fa-arrows',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-h"></i></div>', 'js_composer' ) => 'fount_fa-arrows-h',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-v"></i></div>', 'js_composer' ) => 'fount_fa-arrows-v',
__( '<div class="fount_icon_selector"><i class="fount_fa-asterisk"></i></div>', 'js_composer' ) => 'fount_fa-asterisk',
__( '<div class="fount_icon_selector"><i class="fount_fa-automobile"></i></div>', 'js_composer' ) => 'fount_fa-automobile',
__( '<div class="fount_icon_selector"><i class="fount_fa-ban"></i></div>', 'js_composer' ) => 'fount_fa-ban',
__( '<div class="fount_icon_selector"><i class="fount_fa-bank"></i></div>', 'js_composer' ) => 'fount_fa-bank',
__( '<div class="fount_icon_selector"><i class="fount_fa-bar-chart-o"></i></div>', 'js_composer' ) => 'fount_fa-bar-chart-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-barcode"></i></div>', 'js_composer' ) => 'fount_fa-barcode',
__( '<div class="fount_icon_selector"><i class="fount_fa-bars"></i></div>', 'js_composer' ) => 'fount_fa-bars',
__( '<div class="fount_icon_selector"><i class="fount_fa-beer"></i></div>', 'js_composer' ) => 'fount_fa-beer',
__( '<div class="fount_icon_selector"><i class="fount_fa-bell"></i></div>', 'js_composer' ) => 'fount_fa-bell',
__( '<div class="fount_icon_selector"><i class="fount_fa-bell-o"></i></div>', 'js_composer' ) => 'fount_fa-bell-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-bolt"></i></div>', 'js_composer' ) => 'fount_fa-bolt',
__( '<div class="fount_icon_selector"><i class="fount_fa-bomb"></i></div>', 'js_composer' ) => 'fount_fa-bomb',
__( '<div class="fount_icon_selector"><i class="fount_fa-book"></i></div>', 'js_composer' ) => 'fount_fa-book',
__( '<div class="fount_icon_selector"><i class="fount_fa-bookmark"></i></div>', 'js_composer' ) => 'fount_fa-bookmark',
__( '<div class="fount_icon_selector"><i class="fount_fa-bookmark-o"></i></div>', 'js_composer' ) => 'fount_fa-bookmark-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-briefcase"></i></div>', 'js_composer' ) => 'fount_fa-briefcase',
__( '<div class="fount_icon_selector"><i class="fount_fa-bug"></i></div>', 'js_composer' ) => 'fount_fa-bug',
__( '<div class="fount_icon_selector"><i class="fount_fa-building"></i></div>', 'js_composer' ) => 'fount_fa-building',
__( '<div class="fount_icon_selector"><i class="fount_fa-building-o"></i></div>', 'js_composer' ) => 'fount_fa-building-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-bullhorn"></i></div>', 'js_composer' ) => 'fount_fa-bullhorn',
__( '<div class="fount_icon_selector"><i class="fount_fa-bullseye"></i></div>', 'js_composer' ) => 'fount_fa-bullseye',
__( '<div class="fount_icon_selector"><i class="fount_fa-cab"></i></div>', 'js_composer' ) => 'fount_fa-cab',
__( '<div class="fount_icon_selector"><i class="fount_fa-calendar"></i></div>', 'js_composer' ) => 'fount_fa-calendar',
__( '<div class="fount_icon_selector"><i class="fount_fa-calendar-o"></i></div>', 'js_composer' ) => 'fount_fa-calendar-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-camera"></i></div>', 'js_composer' ) => 'fount_fa-camera',
__( '<div class="fount_icon_selector"><i class="fount_fa-camera-retro"></i></div>', 'js_composer' ) => 'fount_fa-camera-retro',
__( '<div class="fount_icon_selector"><i class="fount_fa-car"></i></div>', 'js_composer' ) => 'fount_fa-car',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-down"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-left"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-right"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-up"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-certificate"></i></div>', 'js_composer' ) => 'fount_fa-certificate',
__( '<div class="fount_icon_selector"><i class="fount_fa-check"></i></div>', 'js_composer' ) => 'fount_fa-check',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-circle"></i></div>', 'js_composer' ) => 'fount_fa-check-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-check-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-square"></i></div>', 'js_composer' ) => 'fount_fa-check-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-square-o"></i></div>', 'js_composer' ) => 'fount_fa-check-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-child"></i></div>', 'js_composer' ) => 'fount_fa-child',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle"></i></div>', 'js_composer' ) => 'fount_fa-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle-o-notch"></i></div>', 'js_composer' ) => 'fount_fa-circle-o-notch',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle-thin"></i></div>', 'js_composer' ) => 'fount_fa-circle-thin',
__( '<div class="fount_icon_selector"><i class="fount_fa-clock-o"></i></div>', 'js_composer' ) => 'fount_fa-clock-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-cloud"></i></div>', 'js_composer' ) => 'fount_fa-cloud',
__( '<div class="fount_icon_selector"><i class="fount_fa-cloud-download"></i></div>', 'js_composer' ) => 'fount_fa-cloud-download',
__( '<div class="fount_icon_selector"><i class="fount_fa-cloud-upload"></i></div>', 'js_composer' ) => 'fount_fa-cloud-upload',
__( '<div class="fount_icon_selector"><i class="fount_fa-code"></i></div>', 'js_composer' ) => 'fount_fa-code',
__( '<div class="fount_icon_selector"><i class="fount_fa-code-fork"></i></div>', 'js_composer' ) => 'fount_fa-code-fork',
__( '<div class="fount_icon_selector"><i class="fount_fa-coffee"></i></div>', 'js_composer' ) => 'fount_fa-coffee',
__( '<div class="fount_icon_selector"><i class="fount_fa-cog"></i></div>', 'js_composer' ) => 'fount_fa-cog',
__( '<div class="fount_icon_selector"><i class="fount_fa-cogs"></i></div>', 'js_composer' ) => 'fount_fa-cogs',
__( '<div class="fount_icon_selector"><i class="fount_fa-comment"></i></div>', 'js_composer' ) => 'fount_fa-comment',
__( '<div class="fount_icon_selector"><i class="fount_fa-comment-o"></i></div>', 'js_composer' ) => 'fount_fa-comment-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-comments"></i></div>', 'js_composer' ) => 'fount_fa-comments',
__( '<div class="fount_icon_selector"><i class="fount_fa-comments-o"></i></div>', 'js_composer' ) => 'fount_fa-comments-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-compass"></i></div>', 'js_composer' ) => 'fount_fa-compass',
__( '<div class="fount_icon_selector"><i class="fount_fa-credit-card"></i></div>', 'js_composer' ) => 'fount_fa-credit-card',
__( '<div class="fount_icon_selector"><i class="fount_fa-crop"></i></div>', 'js_composer' ) => 'fount_fa-crop',
__( '<div class="fount_icon_selector"><i class="fount_fa-crosshairs"></i></div>', 'js_composer' ) => 'fount_fa-crosshairs',
__( '<div class="fount_icon_selector"><i class="fount_fa-cube"></i></div>', 'js_composer' ) => 'fount_fa-cube',
__( '<div class="fount_icon_selector"><i class="fount_fa-cubes"></i></div>', 'js_composer' ) => 'fount_fa-cubes',
__( '<div class="fount_icon_selector"><i class="fount_fa-cutlery"></i></div>', 'js_composer' ) => 'fount_fa-cutlery',
__( '<div class="fount_icon_selector"><i class="fount_fa-dashboard"></i></div>', 'js_composer' ) => 'fount_fa-dashboard',
__( '<div class="fount_icon_selector"><i class="fount_fa-database"></i></div>', 'js_composer' ) => 'fount_fa-database',
__( '<div class="fount_icon_selector"><i class="fount_fa-desktop"></i></div>', 'js_composer' ) => 'fount_fa-desktop',
__( '<div class="fount_icon_selector"><i class="fount_fa-dot-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-dot-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-download"></i></div>', 'js_composer' ) => 'fount_fa-download',
__( '<div class="fount_icon_selector"><i class="fount_fa-edit"></i></div>', 'js_composer' ) => 'fount_fa-edit',
__( '<div class="fount_icon_selector"><i class="fount_fa-ellipsis-h"></i></div>', 'js_composer' ) => 'fount_fa-ellipsis-h',
__( '<div class="fount_icon_selector"><i class="fount_fa-ellipsis-v"></i></div>', 'js_composer' ) => 'fount_fa-ellipsis-v',
__( '<div class="fount_icon_selector"><i class="fount_fa-envelope"></i></div>', 'js_composer' ) => 'fount_fa-envelope',
__( '<div class="fount_icon_selector"><i class="fount_fa-envelope-o"></i></div>', 'js_composer' ) => 'fount_fa-envelope-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-envelope-square"></i></div>', 'js_composer' ) => 'fount_fa-envelope-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-eraser"></i></div>', 'js_composer' ) => 'fount_fa-eraser',
__( '<div class="fount_icon_selector"><i class="fount_fa-exchange"></i></div>', 'js_composer' ) => 'fount_fa-exchange',
__( '<div class="fount_icon_selector"><i class="fount_fa-exclamation"></i></div>', 'js_composer' ) => 'fount_fa-exclamation',
__( '<div class="fount_icon_selector"><i class="fount_fa-exclamation-circle"></i></div>', 'js_composer' ) => 'fount_fa-exclamation-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-exclamation-triangle"></i></div>', 'js_composer' ) => 'fount_fa-exclamation-triangle',
__( '<div class="fount_icon_selector"><i class="fount_fa-external-link"></i></div>', 'js_composer' ) => 'fount_fa-external-link',
__( '<div class="fount_icon_selector"><i class="fount_fa-external-link-square"></i></div>', 'js_composer' ) => 'fount_fa-external-link-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-eye"></i></div>', 'js_composer' ) => 'fount_fa-eye',
__( '<div class="fount_icon_selector"><i class="fount_fa-eye-slash"></i></div>', 'js_composer' ) => 'fount_fa-eye-slash',
__( '<div class="fount_icon_selector"><i class="fount_fa-fax"></i></div>', 'js_composer' ) => 'fount_fa-fax',
__( '<div class="fount_icon_selector"><i class="fount_fa-female"></i></div>', 'js_composer' ) => 'fount_fa-female',
__( '<div class="fount_icon_selector"><i class="fount_fa-fighter-jet"></i></div>', 'js_composer' ) => 'fount_fa-fighter-jet',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-archive-o"></i></div>', 'js_composer' ) => 'fount_fa-file-archive-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-audio-o"></i></div>', 'js_composer' ) => 'fount_fa-file-audio-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-code-o"></i></div>', 'js_composer' ) => 'fount_fa-file-code-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-excel-o"></i></div>', 'js_composer' ) => 'fount_fa-file-excel-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-image-o"></i></div>', 'js_composer' ) => 'fount_fa-file-image-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-movie-o"></i></div>', 'js_composer' ) => 'fount_fa-file-movie-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-pdf-o"></i></div>', 'js_composer' ) => 'fount_fa-file-pdf-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-photo-o"></i></div>', 'js_composer' ) => 'fount_fa-file-photo-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-picture-o"></i></div>', 'js_composer' ) => 'fount_fa-file-picture-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-powerpoint-o"></i></div>', 'js_composer' ) => 'fount_fa-file-powerpoint-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-sound-o"></i></div>', 'js_composer' ) => 'fount_fa-file-sound-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-video-o"></i></div>', 'js_composer' ) => 'fount_fa-file-video-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-word-o"></i></div>', 'js_composer' ) => 'fount_fa-file-word-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-zip-o"></i></div>', 'js_composer' ) => 'fount_fa-file-zip-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-film"></i></div>', 'js_composer' ) => 'fount_fa-film',
__( '<div class="fount_icon_selector"><i class="fount_fa-filter"></i></div>', 'js_composer' ) => 'fount_fa-filter',
__( '<div class="fount_icon_selector"><i class="fount_fa-fire"></i></div>', 'js_composer' ) => 'fount_fa-fire',
__( '<div class="fount_icon_selector"><i class="fount_fa-fire-extinguisher"></i></div>', 'js_composer' ) => 'fount_fa-fire-extinguisher',
__( '<div class="fount_icon_selector"><i class="fount_fa-flag"></i></div>', 'js_composer' ) => 'fount_fa-flag',
__( '<div class="fount_icon_selector"><i class="fount_fa-flag-checkered"></i></div>', 'js_composer' ) => 'fount_fa-flag-checkered',
__( '<div class="fount_icon_selector"><i class="fount_fa-flag-o"></i></div>', 'js_composer' ) => 'fount_fa-flag-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-flash"></i></div>', 'js_composer' ) => 'fount_fa-flash',
__( '<div class="fount_icon_selector"><i class="fount_fa-flask"></i></div>', 'js_composer' ) => 'fount_fa-flask',
__( '<div class="fount_icon_selector"><i class="fount_fa-folder"></i></div>', 'js_composer' ) => 'fount_fa-folder',
__( '<div class="fount_icon_selector"><i class="fount_fa-folder-o"></i></div>', 'js_composer' ) => 'fount_fa-folder-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-folder-open"></i></div>', 'js_composer' ) => 'fount_fa-folder-open',
__( '<div class="fount_icon_selector"><i class="fount_fa-folder-open-o"></i></div>', 'js_composer' ) => 'fount_fa-folder-open-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-frown-o"></i></div>', 'js_composer' ) => 'fount_fa-frown-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-gamepad"></i></div>', 'js_composer' ) => 'fount_fa-gamepad',
__( '<div class="fount_icon_selector"><i class="fount_fa-gavel"></i></div>', 'js_composer' ) => 'fount_fa-gavel',
__( '<div class="fount_icon_selector"><i class="fount_fa-gear"></i></div>', 'js_composer' ) => 'fount_fa-gear',
__( '<div class="fount_icon_selector"><i class="fount_fa-gears"></i></div>', 'js_composer' ) => 'fount_fa-gears',
__( '<div class="fount_icon_selector"><i class="fount_fa-gift"></i></div>', 'js_composer' ) => 'fount_fa-gift',
__( '<div class="fount_icon_selector"><i class="fount_fa-glass"></i></div>', 'js_composer' ) => 'fount_fa-glass',
__( '<div class="fount_icon_selector"><i class="fount_fa-globe"></i></div>', 'js_composer' ) => 'fount_fa-globe',
__( '<div class="fount_icon_selector"><i class="fount_fa-graduation-cap"></i></div>', 'js_composer' ) => 'fount_fa-graduation-cap',
__( '<div class="fount_icon_selector"><i class="fount_fa-group"></i></div>', 'js_composer' ) => 'fount_fa-group',
__( '<div class="fount_icon_selector"><i class="fount_fa-hdd-o"></i></div>', 'js_composer' ) => 'fount_fa-hdd-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-headphones"></i></div>', 'js_composer' ) => 'fount_fa-headphones',
__( '<div class="fount_icon_selector"><i class="fount_fa-heart"></i></div>', 'js_composer' ) => 'fount_fa-heart',
__( '<div class="fount_icon_selector"><i class="fount_fa-heart-o"></i></div>', 'js_composer' ) => 'fount_fa-heart-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-history"></i></div>', 'js_composer' ) => 'fount_fa-history',
__( '<div class="fount_icon_selector"><i class="fount_fa-home"></i></div>', 'js_composer' ) => 'fount_fa-home',
__( '<div class="fount_icon_selector"><i class="fount_fa-image"></i></div>', 'js_composer' ) => 'fount_fa-image',
__( '<div class="fount_icon_selector"><i class="fount_fa-inbox"></i></div>', 'js_composer' ) => 'fount_fa-inbox',
__( '<div class="fount_icon_selector"><i class="fount_fa-info"></i></div>', 'js_composer' ) => 'fount_fa-info',
__( '<div class="fount_icon_selector"><i class="fount_fa-info-circle"></i></div>', 'js_composer' ) => 'fount_fa-info-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-institution"></i></div>', 'js_composer' ) => 'fount_fa-institution',
__( '<div class="fount_icon_selector"><i class="fount_fa-key"></i></div>', 'js_composer' ) => 'fount_fa-key',
__( '<div class="fount_icon_selector"><i class="fount_fa-keyboard-o"></i></div>', 'js_composer' ) => 'fount_fa-keyboard-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-language"></i></div>', 'js_composer' ) => 'fount_fa-language',
__( '<div class="fount_icon_selector"><i class="fount_fa-laptop"></i></div>', 'js_composer' ) => 'fount_fa-laptop',
__( '<div class="fount_icon_selector"><i class="fount_fa-leaf"></i></div>', 'js_composer' ) => 'fount_fa-leaf',
__( '<div class="fount_icon_selector"><i class="fount_fa-legal"></i></div>', 'js_composer' ) => 'fount_fa-legal',
__( '<div class="fount_icon_selector"><i class="fount_fa-lemon-o"></i></div>', 'js_composer' ) => 'fount_fa-lemon-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-level-down"></i></div>', 'js_composer' ) => 'fount_fa-level-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-level-up"></i></div>', 'js_composer' ) => 'fount_fa-level-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-life-bouy"></i></div>', 'js_composer' ) => 'fount_fa-life-bouy',
__( '<div class="fount_icon_selector"><i class="fount_fa-life-ring"></i></div>', 'js_composer' ) => 'fount_fa-life-ring',
__( '<div class="fount_icon_selector"><i class="fount_fa-life-saver"></i></div>', 'js_composer' ) => 'fount_fa-life-saver',
__( '<div class="fount_icon_selector"><i class="fount_fa-lightbulb-o"></i></div>', 'js_composer' ) => 'fount_fa-lightbulb-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-location-arrow"></i></div>', 'js_composer' ) => 'fount_fa-location-arrow',
__( '<div class="fount_icon_selector"><i class="fount_fa-lock"></i></div>', 'js_composer' ) => 'fount_fa-lock',
__( '<div class="fount_icon_selector"><i class="fount_fa-magic"></i></div>', 'js_composer' ) => 'fount_fa-magic',
__( '<div class="fount_icon_selector"><i class="fount_fa-magnet"></i></div>', 'js_composer' ) => 'fount_fa-magnet',
__( '<div class="fount_icon_selector"><i class="fount_fa-mail-forward"></i></div>', 'js_composer' ) => 'fount_fa-mail-forward',
__( '<div class="fount_icon_selector"><i class="fount_fa-mail-reply"></i></div>', 'js_composer' ) => 'fount_fa-mail-reply',
__( '<div class="fount_icon_selector"><i class="fount_fa-mail-reply-all"></i></div>', 'js_composer' ) => 'fount_fa-mail-reply-all',
__( '<div class="fount_icon_selector"><i class="fount_fa-male"></i></div>', 'js_composer' ) => 'fount_fa-male',
__( '<div class="fount_icon_selector"><i class="fount_fa-map-marker"></i></div>', 'js_composer' ) => 'fount_fa-map-marker',
__( '<div class="fount_icon_selector"><i class="fount_fa-meh-o"></i></div>', 'js_composer' ) => 'fount_fa-meh-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-microphone"></i></div>', 'js_composer' ) => 'fount_fa-microphone',
__( '<div class="fount_icon_selector"><i class="fount_fa-microphone-slash"></i></div>', 'js_composer' ) => 'fount_fa-microphone-slash',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus"></i></div>', 'js_composer' ) => 'fount_fa-minus',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus-circle"></i></div>', 'js_composer' ) => 'fount_fa-minus-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus-square"></i></div>', 'js_composer' ) => 'fount_fa-minus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus-square-o"></i></div>', 'js_composer' ) => 'fount_fa-minus-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-mobile"></i></div>', 'js_composer' ) => 'fount_fa-mobile',
__( '<div class="fount_icon_selector"><i class="fount_fa-mobile-phone"></i></div>', 'js_composer' ) => 'fount_fa-mobile-phone',
__( '<div class="fount_icon_selector"><i class="fount_fa-money"></i></div>', 'js_composer' ) => 'fount_fa-money',
__( '<div class="fount_icon_selector"><i class="fount_fa-moon-o"></i></div>', 'js_composer' ) => 'fount_fa-moon-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-mortar-board"></i></div>', 'js_composer' ) => 'fount_fa-mortar-board',
__( '<div class="fount_icon_selector"><i class="fount_fa-music"></i></div>', 'js_composer' ) => 'fount_fa-music',
__( '<div class="fount_icon_selector"><i class="fount_fa-navicon"></i></div>', 'js_composer' ) => 'fount_fa-navicon',
__( '<div class="fount_icon_selector"><i class="fount_fa-paper-plane"></i></div>', 'js_composer' ) => 'fount_fa-paper-plane',
__( '<div class="fount_icon_selector"><i class="fount_fa-paper-plane-o"></i></div>', 'js_composer' ) => 'fount_fa-paper-plane-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-paw"></i></div>', 'js_composer' ) => 'fount_fa-paw',
__( '<div class="fount_icon_selector"><i class="fount_fa-pencil"></i></div>', 'js_composer' ) => 'fount_fa-pencil',
__( '<div class="fount_icon_selector"><i class="fount_fa-pencil-square"></i></div>', 'js_composer' ) => 'fount_fa-pencil-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-pencil-square-o"></i></div>', 'js_composer' ) => 'fount_fa-pencil-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-phone"></i></div>', 'js_composer' ) => 'fount_fa-phone',
__( '<div class="fount_icon_selector"><i class="fount_fa-phone-square"></i></div>', 'js_composer' ) => 'fount_fa-phone-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-photo"></i></div>', 'js_composer' ) => 'fount_fa-photo',
__( '<div class="fount_icon_selector"><i class="fount_fa-picture-o"></i></div>', 'js_composer' ) => 'fount_fa-picture-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-plane"></i></div>', 'js_composer' ) => 'fount_fa-plane',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus"></i></div>', 'js_composer' ) => 'fount_fa-plus',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-circle"></i></div>', 'js_composer' ) => 'fount_fa-plus-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-square"></i></div>', 'js_composer' ) => 'fount_fa-plus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-square-o"></i></div>', 'js_composer' ) => 'fount_fa-plus-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-power-off"></i></div>', 'js_composer' ) => 'fount_fa-power-off',
__( '<div class="fount_icon_selector"><i class="fount_fa-print"></i></div>', 'js_composer' ) => 'fount_fa-print',
__( '<div class="fount_icon_selector"><i class="fount_fa-puzzle-piece"></i></div>', 'js_composer' ) => 'fount_fa-puzzle-piece',
__( '<div class="fount_icon_selector"><i class="fount_fa-qrcode"></i></div>', 'js_composer' ) => 'fount_fa-qrcode',
__( '<div class="fount_icon_selector"><i class="fount_fa-question"></i></div>', 'js_composer' ) => 'fount_fa-question',
__( '<div class="fount_icon_selector"><i class="fount_fa-question-circle"></i></div>', 'js_composer' ) => 'fount_fa-question-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-quote-left"></i></div>', 'js_composer' ) => 'fount_fa-quote-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-quote-right"></i></div>', 'js_composer' ) => 'fount_fa-quote-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-random"></i></div>', 'js_composer' ) => 'fount_fa-random',
__( '<div class="fount_icon_selector"><i class="fount_fa-recycle"></i></div>', 'js_composer' ) => 'fount_fa-recycle',
__( '<div class="fount_icon_selector"><i class="fount_fa-refresh"></i></div>', 'js_composer' ) => 'fount_fa-refresh',
__( '<div class="fount_icon_selector"><i class="fount_fa-reorder"></i></div>', 'js_composer' ) => 'fount_fa-reorder',
__( '<div class="fount_icon_selector"><i class="fount_fa-reply"></i></div>', 'js_composer' ) => 'fount_fa-reply',
__( '<div class="fount_icon_selector"><i class="fount_fa-reply-all"></i></div>', 'js_composer' ) => 'fount_fa-reply-all',
__( '<div class="fount_icon_selector"><i class="fount_fa-retweet"></i></div>', 'js_composer' ) => 'fount_fa-retweet',
__( '<div class="fount_icon_selector"><i class="fount_fa-road"></i></div>', 'js_composer' ) => 'fount_fa-road',
__( '<div class="fount_icon_selector"><i class="fount_fa-rocket"></i></div>', 'js_composer' ) => 'fount_fa-rocket',
__( '<div class="fount_icon_selector"><i class="fount_fa-rss"></i></div>', 'js_composer' ) => 'fount_fa-rss',
__( '<div class="fount_icon_selector"><i class="fount_fa-rss-square"></i></div>', 'js_composer' ) => 'fount_fa-rss-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-search"></i></div>', 'js_composer' ) => 'fount_fa-search',
__( '<div class="fount_icon_selector"><i class="fount_fa-search-minus"></i></div>', 'js_composer' ) => 'fount_fa-search-minus',
__( '<div class="fount_icon_selector"><i class="fount_fa-search-plus"></i></div>', 'js_composer' ) => 'fount_fa-search-plus',
__( '<div class="fount_icon_selector"><i class="fount_fa-send"></i></div>', 'js_composer' ) => 'fount_fa-send',
__( '<div class="fount_icon_selector"><i class="fount_fa-send-o"></i></div>', 'js_composer' ) => 'fount_fa-send-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-share"></i></div>', 'js_composer' ) => 'fount_fa-share',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-alt"></i></div>', 'js_composer' ) => 'fount_fa-share-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-alt-square"></i></div>', 'js_composer' ) => 'fount_fa-share-alt-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-square"></i></div>', 'js_composer' ) => 'fount_fa-share-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-square-o"></i></div>', 'js_composer' ) => 'fount_fa-share-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-shield"></i></div>', 'js_composer' ) => 'fount_fa-shield',
__( '<div class="fount_icon_selector"><i class="fount_fa-shopping-cart"></i></div>', 'js_composer' ) => 'fount_fa-shopping-cart',
__( '<div class="fount_icon_selector"><i class="fount_fa-sign-in"></i></div>', 'js_composer' ) => 'fount_fa-sign-in',
__( '<div class="fount_icon_selector"><i class="fount_fa-sign-out"></i></div>', 'js_composer' ) => 'fount_fa-sign-out',
__( '<div class="fount_icon_selector"><i class="fount_fa-signal"></i></div>', 'js_composer' ) => 'fount_fa-signal',
__( '<div class="fount_icon_selector"><i class="fount_fa-sitemap"></i></div>', 'js_composer' ) => 'fount_fa-sitemap',
__( '<div class="fount_icon_selector"><i class="fount_fa-sliders"></i></div>', 'js_composer' ) => 'fount_fa-sliders',
__( '<div class="fount_icon_selector"><i class="fount_fa-smile-o"></i></div>', 'js_composer' ) => 'fount_fa-smile-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort"></i></div>', 'js_composer' ) => 'fount_fa-sort',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-alpha-asc"></i></div>', 'js_composer' ) => 'fount_fa-sort-alpha-asc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-alpha-desc"></i></div>', 'js_composer' ) => 'fount_fa-sort-alpha-desc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-amount-asc"></i></div>', 'js_composer' ) => 'fount_fa-sort-amount-asc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-amount-desc"></i></div>', 'js_composer' ) => 'fount_fa-sort-amount-desc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-asc"></i></div>', 'js_composer' ) => 'fount_fa-sort-asc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-desc"></i></div>', 'js_composer' ) => 'fount_fa-sort-desc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-down"></i></div>', 'js_composer' ) => 'fount_fa-sort-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-numeric-asc"></i></div>', 'js_composer' ) => 'fount_fa-sort-numeric-asc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-numeric-desc"></i></div>', 'js_composer' ) => 'fount_fa-sort-numeric-desc',
__( '<div class="fount_icon_selector"><i class="fount_fa-sort-up"></i></div>', 'js_composer' ) => 'fount_fa-sort-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-space-shuttle"></i></div>', 'js_composer' ) => 'fount_fa-space-shuttle',
__( '<div class="fount_icon_selector"><i class="fount_fa-spinner"></i></div>', 'js_composer' ) => 'fount_fa-spinner',
__( '<div class="fount_icon_selector"><i class="fount_fa-spoon"></i></div>', 'js_composer' ) => 'fount_fa-spoon',
__( '<div class="fount_icon_selector"><i class="fount_fa-square"></i></div>', 'js_composer' ) => 'fount_fa-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-square-o"></i></div>', 'js_composer' ) => 'fount_fa-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-star"></i></div>', 'js_composer' ) => 'fount_fa-star',
__( '<div class="fount_icon_selector"><i class="fount_fa-star-half"></i></div>', 'js_composer' ) => 'fount_fa-star-half',
__( '<div class="fount_icon_selector"><i class="fount_fa-star-half-empty"></i></div>', 'js_composer' ) => 'fount_fa-star-half-empty',
__( '<div class="fount_icon_selector"><i class="fount_fa-star-half-full"></i></div>', 'js_composer' ) => 'fount_fa-star-half-full',
__( '<div class="fount_icon_selector"><i class="fount_fa-star-half-o"></i></div>', 'js_composer' ) => 'fount_fa-star-half-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-star-o"></i></div>', 'js_composer' ) => 'fount_fa-star-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-suitcase"></i></div>', 'js_composer' ) => 'fount_fa-suitcase',
__( '<div class="fount_icon_selector"><i class="fount_fa-sun-o"></i></div>', 'js_composer' ) => 'fount_fa-sun-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-support"></i></div>', 'js_composer' ) => 'fount_fa-support',
__( '<div class="fount_icon_selector"><i class="fount_fa-tablet"></i></div>', 'js_composer' ) => 'fount_fa-tablet',
__( '<div class="fount_icon_selector"><i class="fount_fa-tachometer"></i></div>', 'js_composer' ) => 'fount_fa-tachometer',
__( '<div class="fount_icon_selector"><i class="fount_fa-tag"></i></div>', 'js_composer' ) => 'fount_fa-tag',
__( '<div class="fount_icon_selector"><i class="fount_fa-tags"></i></div>', 'js_composer' ) => 'fount_fa-tags',
__( '<div class="fount_icon_selector"><i class="fount_fa-tasks"></i></div>', 'js_composer' ) => 'fount_fa-tasks',
__( '<div class="fount_icon_selector"><i class="fount_fa-taxi"></i></div>', 'js_composer' ) => 'fount_fa-taxi',
__( '<div class="fount_icon_selector"><i class="fount_fa-terminal"></i></div>', 'js_composer' ) => 'fount_fa-terminal',
__( '<div class="fount_icon_selector"><i class="fount_fa-thumb-tack"></i></div>', 'js_composer' ) => 'fount_fa-thumb-tack',
__( '<div class="fount_icon_selector"><i class="fount_fa-thumbs-down"></i></div>', 'js_composer' ) => 'fount_fa-thumbs-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-thumbs-o-down"></i></div>', 'js_composer' ) => 'fount_fa-thumbs-o-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-thumbs-o-up"></i></div>', 'js_composer' ) => 'fount_fa-thumbs-o-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-thumbs-up"></i></div>', 'js_composer' ) => 'fount_fa-thumbs-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-ticket"></i></div>', 'js_composer' ) => 'fount_fa-ticket',
__( '<div class="fount_icon_selector"><i class="fount_fa-times"></i></div>', 'js_composer' ) => 'fount_fa-times',
__( '<div class="fount_icon_selector"><i class="fount_fa-times-circle"></i></div>', 'js_composer' ) => 'fount_fa-times-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-times-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-times-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-tint"></i></div>', 'js_composer' ) => 'fount_fa-tint',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-down"></i></div>', 'js_composer' ) => 'fount_fa-toggle-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-left"></i></div>', 'js_composer' ) => 'fount_fa-toggle-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-right"></i></div>', 'js_composer' ) => 'fount_fa-toggle-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-up"></i></div>', 'js_composer' ) => 'fount_fa-toggle-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-trash-o"></i></div>', 'js_composer' ) => 'fount_fa-trash-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-tree"></i></div>', 'js_composer' ) => 'fount_fa-tree',
__( '<div class="fount_icon_selector"><i class="fount_fa-trophy"></i></div>', 'js_composer' ) => 'fount_fa-trophy',
__( '<div class="fount_icon_selector"><i class="fount_fa-truck"></i></div>', 'js_composer' ) => 'fount_fa-truck',
__( '<div class="fount_icon_selector"><i class="fount_fa-umbrella"></i></div>', 'js_composer' ) => 'fount_fa-umbrella',
__( '<div class="fount_icon_selector"><i class="fount_fa-university"></i></div>', 'js_composer' ) => 'fount_fa-university',
__( '<div class="fount_icon_selector"><i class="fount_fa-unlock"></i></div>', 'js_composer' ) => 'fount_fa-unlock',
__( '<div class="fount_icon_selector"><i class="fount_fa-unlock-alt"></i></div>', 'js_composer' ) => 'fount_fa-unlock-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-unsorted"></i></div>', 'js_composer' ) => 'fount_fa-unsorted',
__( '<div class="fount_icon_selector"><i class="fount_fa-upload"></i></div>', 'js_composer' ) => 'fount_fa-upload',
__( '<div class="fount_icon_selector"><i class="fount_fa-user"></i></div>', 'js_composer' ) => 'fount_fa-user',
__( '<div class="fount_icon_selector"><i class="fount_fa-users"></i></div>', 'js_composer' ) => 'fount_fa-users',
__( '<div class="fount_icon_selector"><i class="fount_fa-video-camera"></i></div>', 'js_composer' ) => 'fount_fa-video-camera',
__( '<div class="fount_icon_selector"><i class="fount_fa-volume-down"></i></div>', 'js_composer' ) => 'fount_fa-volume-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-volume-off"></i></div>', 'js_composer' ) => 'fount_fa-volume-off',
__( '<div class="fount_icon_selector"><i class="fount_fa-volume-up"></i></div>', 'js_composer' ) => 'fount_fa-volume-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-warning"></i></div>', 'js_composer' ) => 'fount_fa-warning',
__( '<div class="fount_icon_selector"><i class="fount_fa-wheelchair"></i></div>', 'js_composer' ) => 'fount_fa-wheelchair',
__( '<div class="fount_icon_selector"><i class="fount_fa-wrench"></i></div>', 'js_composer' ) => 'fount_fa-wrench',
__( '<div class="fount_icon_selector"><i class="fount_fa-file"></i></div>', 'js_composer' ) => 'fount_fa-file',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-archive-o"></i></div>', 'js_composer' ) => 'fount_fa-file-archive-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-audio-o"></i></div>', 'js_composer' ) => 'fount_fa-file-audio-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-code-o"></i></div>', 'js_composer' ) => 'fount_fa-file-code-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-excel-o"></i></div>', 'js_composer' ) => 'fount_fa-file-excel-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-image-o"></i></div>', 'js_composer' ) => 'fount_fa-file-image-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-movie-o"></i></div>', 'js_composer' ) => 'fount_fa-file-movie-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-o"></i></div>', 'js_composer' ) => 'fount_fa-file-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-pdf-o"></i></div>', 'js_composer' ) => 'fount_fa-file-pdf-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-photo-o"></i></div>', 'js_composer' ) => 'fount_fa-file-photo-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-picture-o"></i></div>', 'js_composer' ) => 'fount_fa-file-picture-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-powerpoint-o"></i></div>', 'js_composer' ) => 'fount_fa-file-powerpoint-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-sound-o"></i></div>', 'js_composer' ) => 'fount_fa-file-sound-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-text"></i></div>', 'js_composer' ) => 'fount_fa-file-text',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-text-o"></i></div>', 'js_composer' ) => 'fount_fa-file-text-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-video-o"></i></div>', 'js_composer' ) => 'fount_fa-file-video-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-word-o"></i></div>', 'js_composer' ) => 'fount_fa-file-word-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-zip-o"></i></div>', 'js_composer' ) => 'fount_fa-file-zip-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle-o-notch"></i></div>', 'js_composer' ) => 'fount_fa-circle-o-notch',
__( '<div class="fount_icon_selector"><i class="fount_fa-cog"></i></div>', 'js_composer' ) => 'fount_fa-cog',
__( '<div class="fount_icon_selector"><i class="fount_fa-gear"></i></div>', 'js_composer' ) => 'fount_fa-gear',
__( '<div class="fount_icon_selector"><i class="fount_fa-refresh"></i></div>', 'js_composer' ) => 'fount_fa-refresh',
__( '<div class="fount_icon_selector"><i class="fount_fa-spinner"></i></div>', 'js_composer' ) => 'fount_fa-spinner',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-square"></i></div>', 'js_composer' ) => 'fount_fa-check-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-check-square-o"></i></div>', 'js_composer' ) => 'fount_fa-check-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle"></i></div>', 'js_composer' ) => 'fount_fa-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-dot-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-dot-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus-square"></i></div>', 'js_composer' ) => 'fount_fa-minus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-minus-square-o"></i></div>', 'js_composer' ) => 'fount_fa-minus-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-square"></i></div>', 'js_composer' ) => 'fount_fa-plus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-square-o"></i></div>', 'js_composer' ) => 'fount_fa-plus-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-square"></i></div>', 'js_composer' ) => 'fount_fa-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-square-o"></i></div>', 'js_composer' ) => 'fount_fa-square-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-bitcoin"></i></div>', 'js_composer' ) => 'fount_fa-bitcoin',
__( '<div class="fount_icon_selector"><i class="fount_fa-btc"></i></div>', 'js_composer' ) => 'fount_fa-btc',
__( '<div class="fount_icon_selector"><i class="fount_fa-cny"></i></div>', 'js_composer' ) => 'fount_fa-cny',
__( '<div class="fount_icon_selector"><i class="fount_fa-dollar"></i></div>', 'js_composer' ) => 'fount_fa-dollar',
__( '<div class="fount_icon_selector"><i class="fount_fa-eur"></i></div>', 'js_composer' ) => 'fount_fa-eur',
__( '<div class="fount_icon_selector"><i class="fount_fa-euro"></i></div>', 'js_composer' ) => 'fount_fa-euro',
__( '<div class="fount_icon_selector"><i class="fount_fa-gbp"></i></div>', 'js_composer' ) => 'fount_fa-gbp',
__( '<div class="fount_icon_selector"><i class="fount_fa-inr"></i></div>', 'js_composer' ) => 'fount_fa-inr',
__( '<div class="fount_icon_selector"><i class="fount_fa-jpy"></i></div>', 'js_composer' ) => 'fount_fa-jpy',
__( '<div class="fount_icon_selector"><i class="fount_fa-krw"></i></div>', 'js_composer' ) => 'fount_fa-krw',
__( '<div class="fount_icon_selector"><i class="fount_fa-money"></i></div>', 'js_composer' ) => 'fount_fa-money',
__( '<div class="fount_icon_selector"><i class="fount_fa-rmb"></i></div>', 'js_composer' ) => 'fount_fa-rmb',
__( '<div class="fount_icon_selector"><i class="fount_fa-rouble"></i></div>', 'js_composer' ) => 'fount_fa-rouble',
__( '<div class="fount_icon_selector"><i class="fount_fa-rub"></i></div>', 'js_composer' ) => 'fount_fa-rub',
__( '<div class="fount_icon_selector"><i class="fount_fa-ruble"></i></div>', 'js_composer' ) => 'fount_fa-ruble',
__( '<div class="fount_icon_selector"><i class="fount_fa-rupee"></i></div>', 'js_composer' ) => 'fount_fa-rupee',
__( '<div class="fount_icon_selector"><i class="fount_fa-try"></i></div>', 'js_composer' ) => 'fount_fa-try',
__( '<div class="fount_icon_selector"><i class="fount_fa-turkish-lira"></i></div>', 'js_composer' ) => 'fount_fa-turkish-lira',
__( '<div class="fount_icon_selector"><i class="fount_fa-usd"></i></div>', 'js_composer' ) => 'fount_fa-usd',
__( '<div class="fount_icon_selector"><i class="fount_fa-won"></i></div>', 'js_composer' ) => 'fount_fa-won',
__( '<div class="fount_icon_selector"><i class="fount_fa-yen"></i></div>', 'js_composer' ) => 'fount_fa-yen',
__( '<div class="fount_icon_selector"><i class="fount_fa-align-center"></i></div>', 'js_composer' ) => 'fount_fa-align-center',
__( '<div class="fount_icon_selector"><i class="fount_fa-align-justify"></i></div>', 'js_composer' ) => 'fount_fa-align-justify',
__( '<div class="fount_icon_selector"><i class="fount_fa-align-left"></i></div>', 'js_composer' ) => 'fount_fa-align-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-align-right"></i></div>', 'js_composer' ) => 'fount_fa-align-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-bold"></i></div>', 'js_composer' ) => 'fount_fa-bold',
__( '<div class="fount_icon_selector"><i class="fount_fa-chain"></i></div>', 'js_composer' ) => 'fount_fa-chain',
__( '<div class="fount_icon_selector"><i class="fount_fa-chain-broken"></i></div>', 'js_composer' ) => 'fount_fa-chain-broken',
__( '<div class="fount_icon_selector"><i class="fount_fa-clipboard"></i></div>', 'js_composer' ) => 'fount_fa-clipboard',
__( '<div class="fount_icon_selector"><i class="fount_fa-columns"></i></div>', 'js_composer' ) => 'fount_fa-columns',
__( '<div class="fount_icon_selector"><i class="fount_fa-copy"></i></div>', 'js_composer' ) => 'fount_fa-copy',
__( '<div class="fount_icon_selector"><i class="fount_fa-cut"></i></div>', 'js_composer' ) => 'fount_fa-cut',
__( '<div class="fount_icon_selector"><i class="fount_fa-dedent"></i></div>', 'js_composer' ) => 'fount_fa-dedent',
__( '<div class="fount_icon_selector"><i class="fount_fa-eraser"></i></div>', 'js_composer' ) => 'fount_fa-eraser',
__( '<div class="fount_icon_selector"><i class="fount_fa-file"></i></div>', 'js_composer' ) => 'fount_fa-file',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-o"></i></div>', 'js_composer' ) => 'fount_fa-file-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-text"></i></div>', 'js_composer' ) => 'fount_fa-file-text',
__( '<div class="fount_icon_selector"><i class="fount_fa-file-text-o"></i></div>', 'js_composer' ) => 'fount_fa-file-text-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-files-o"></i></div>', 'js_composer' ) => 'fount_fa-files-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-floppy-o"></i></div>', 'js_composer' ) => 'fount_fa-floppy-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-font"></i></div>', 'js_composer' ) => 'fount_fa-font',
__( '<div class="fount_icon_selector"><i class="fount_fa-header"></i></div>', 'js_composer' ) => 'fount_fa-header',
__( '<div class="fount_icon_selector"><i class="fount_fa-indent"></i></div>', 'js_composer' ) => 'fount_fa-indent',
__( '<div class="fount_icon_selector"><i class="fount_fa-italic"></i></div>', 'js_composer' ) => 'fount_fa-italic',
__( '<div class="fount_icon_selector"><i class="fount_fa-link"></i></div>', 'js_composer' ) => 'fount_fa-link',
__( '<div class="fount_icon_selector"><i class="fount_fa-list"></i></div>', 'js_composer' ) => 'fount_fa-list',
__( '<div class="fount_icon_selector"><i class="fount_fa-list-alt"></i></div>', 'js_composer' ) => 'fount_fa-list-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-list-ol"></i></div>', 'js_composer' ) => 'fount_fa-list-ol',
__( '<div class="fount_icon_selector"><i class="fount_fa-list-ul"></i></div>', 'js_composer' ) => 'fount_fa-list-ul',
__( '<div class="fount_icon_selector"><i class="fount_fa-outdent"></i></div>', 'js_composer' ) => 'fount_fa-outdent',
__( '<div class="fount_icon_selector"><i class="fount_fa-paperclip"></i></div>', 'js_composer' ) => 'fount_fa-paperclip',
__( '<div class="fount_icon_selector"><i class="fount_fa-paragraph"></i></div>', 'js_composer' ) => 'fount_fa-paragraph',
__( '<div class="fount_icon_selector"><i class="fount_fa-paste"></i></div>', 'js_composer' ) => 'fount_fa-paste',
__( '<div class="fount_icon_selector"><i class="fount_fa-repeat"></i></div>', 'js_composer' ) => 'fount_fa-repeat',
__( '<div class="fount_icon_selector"><i class="fount_fa-rotate-left"></i></div>', 'js_composer' ) => 'fount_fa-rotate-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-rotate-right"></i></div>', 'js_composer' ) => 'fount_fa-rotate-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-save"></i></div>', 'js_composer' ) => 'fount_fa-save',
__( '<div class="fount_icon_selector"><i class="fount_fa-scissors"></i></div>', 'js_composer' ) => 'fount_fa-scissors',
__( '<div class="fount_icon_selector"><i class="fount_fa-strikethrough"></i></div>', 'js_composer' ) => 'fount_fa-strikethrough',
__( '<div class="fount_icon_selector"><i class="fount_fa-subscript"></i></div>', 'js_composer' ) => 'fount_fa-subscript',
__( '<div class="fount_icon_selector"><i class="fount_fa-superscript"></i></div>', 'js_composer' ) => 'fount_fa-superscript',
__( '<div class="fount_icon_selector"><i class="fount_fa-table"></i></div>', 'js_composer' ) => 'fount_fa-table',
__( '<div class="fount_icon_selector"><i class="fount_fa-text-height"></i></div>', 'js_composer' ) => 'fount_fa-text-height',
__( '<div class="fount_icon_selector"><i class="fount_fa-text-width"></i></div>', 'js_composer' ) => 'fount_fa-text-width',
__( '<div class="fount_icon_selector"><i class="fount_fa-th"></i></div>', 'js_composer' ) => 'fount_fa-th',
__( '<div class="fount_icon_selector"><i class="fount_fa-th-large"></i></div>', 'js_composer' ) => 'fount_fa-th-large',
__( '<div class="fount_icon_selector"><i class="fount_fa-th-list"></i></div>', 'js_composer' ) => 'fount_fa-th-list',
__( '<div class="fount_icon_selector"><i class="fount_fa-underline"></i></div>', 'js_composer' ) => 'fount_fa-underline',
__( '<div class="fount_icon_selector"><i class="fount_fa-undo"></i></div>', 'js_composer' ) => 'fount_fa-undo',
__( '<div class="fount_icon_selector"><i class="fount_fa-unlink"></i></div>', 'js_composer' ) => 'fount_fa-unlink',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-double-down"></i></div>', 'js_composer' ) => 'fount_fa-angle-double-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-double-left"></i></div>', 'js_composer' ) => 'fount_fa-angle-double-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-double-right"></i></div>', 'js_composer' ) => 'fount_fa-angle-double-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-double-up"></i></div>', 'js_composer' ) => 'fount_fa-angle-double-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-down"></i></div>', 'js_composer' ) => 'fount_fa-angle-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-left"></i></div>', 'js_composer' ) => 'fount_fa-angle-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-right"></i></div>', 'js_composer' ) => 'fount_fa-angle-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-angle-up"></i></div>', 'js_composer' ) => 'fount_fa-angle-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-down"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-left"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-o-down"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-o-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-o-left"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-o-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-o-right"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-o-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-o-up"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-o-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-right"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-circle-up"></i></div>', 'js_composer' ) => 'fount_fa-arrow-circle-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-down"></i></div>', 'js_composer' ) => 'fount_fa-arrow-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-left"></i></div>', 'js_composer' ) => 'fount_fa-arrow-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-right"></i></div>', 'js_composer' ) => 'fount_fa-arrow-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrow-up"></i></div>', 'js_composer' ) => 'fount_fa-arrow-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows"></i></div>', 'js_composer' ) => 'fount_fa-arrows',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-alt"></i></div>', 'js_composer' ) => 'fount_fa-arrows-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-h"></i></div>', 'js_composer' ) => 'fount_fa-arrows-h',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-v"></i></div>', 'js_composer' ) => 'fount_fa-arrows-v',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-down"></i></div>', 'js_composer' ) => 'fount_fa-caret-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-left"></i></div>', 'js_composer' ) => 'fount_fa-caret-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-right"></i></div>', 'js_composer' ) => 'fount_fa-caret-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-down"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-left"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-right"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-square-o-up"></i></div>', 'js_composer' ) => 'fount_fa-caret-square-o-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-caret-up"></i></div>', 'js_composer' ) => 'fount_fa-caret-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-circle-down"></i></div>', 'js_composer' ) => 'fount_fa-chevron-circle-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-circle-left"></i></div>', 'js_composer' ) => 'fount_fa-chevron-circle-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-circle-right"></i></div>', 'js_composer' ) => 'fount_fa-chevron-circle-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-circle-up"></i></div>', 'js_composer' ) => 'fount_fa-chevron-circle-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-down"></i></div>', 'js_composer' ) => 'fount_fa-chevron-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-left"></i></div>', 'js_composer' ) => 'fount_fa-chevron-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-right"></i></div>', 'js_composer' ) => 'fount_fa-chevron-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-chevron-up"></i></div>', 'js_composer' ) => 'fount_fa-chevron-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-hand-o-down"></i></div>', 'js_composer' ) => 'fount_fa-hand-o-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-hand-o-left"></i></div>', 'js_composer' ) => 'fount_fa-hand-o-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-hand-o-right"></i></div>', 'js_composer' ) => 'fount_fa-hand-o-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-hand-o-up"></i></div>', 'js_composer' ) => 'fount_fa-hand-o-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-long-arrow-down"></i></div>', 'js_composer' ) => 'fount_fa-long-arrow-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-long-arrow-left"></i></div>', 'js_composer' ) => 'fount_fa-long-arrow-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-long-arrow-right"></i></div>', 'js_composer' ) => 'fount_fa-long-arrow-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-long-arrow-up"></i></div>', 'js_composer' ) => 'fount_fa-long-arrow-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-down"></i></div>', 'js_composer' ) => 'fount_fa-toggle-down',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-left"></i></div>', 'js_composer' ) => 'fount_fa-toggle-left',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-right"></i></div>', 'js_composer' ) => 'fount_fa-toggle-right',
__( '<div class="fount_icon_selector"><i class="fount_fa-toggle-up"></i></div>', 'js_composer' ) => 'fount_fa-toggle-up',
__( '<div class="fount_icon_selector"><i class="fount_fa-arrows-alt"></i></div>', 'js_composer' ) => 'fount_fa-arrows-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-backward"></i></div>', 'js_composer' ) => 'fount_fa-backward',
__( '<div class="fount_icon_selector"><i class="fount_fa-compress"></i></div>', 'js_composer' ) => 'fount_fa-compress',
__( '<div class="fount_icon_selector"><i class="fount_fa-eject"></i></div>', 'js_composer' ) => 'fount_fa-eject',
__( '<div class="fount_icon_selector"><i class="fount_fa-expand"></i></div>', 'js_composer' ) => 'fount_fa-expand',
__( '<div class="fount_icon_selector"><i class="fount_fa-fast-backward"></i></div>', 'js_composer' ) => 'fount_fa-fast-backward',
__( '<div class="fount_icon_selector"><i class="fount_fa-fast-forward"></i></div>', 'js_composer' ) => 'fount_fa-fast-forward',
__( '<div class="fount_icon_selector"><i class="fount_fa-forward"></i></div>', 'js_composer' ) => 'fount_fa-forward',
__( '<div class="fount_icon_selector"><i class="fount_fa-pause"></i></div>', 'js_composer' ) => 'fount_fa-pause',
__( '<div class="fount_icon_selector"><i class="fount_fa-play"></i></div>', 'js_composer' ) => 'fount_fa-play',
__( '<div class="fount_icon_selector"><i class="fount_fa-play-circle"></i></div>', 'js_composer' ) => 'fount_fa-play-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-play-circle-o"></i></div>', 'js_composer' ) => 'fount_fa-play-circle-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-step-backward"></i></div>', 'js_composer' ) => 'fount_fa-step-backward',
__( '<div class="fount_icon_selector"><i class="fount_fa-step-forward"></i></div>', 'js_composer' ) => 'fount_fa-step-forward',
__( '<div class="fount_icon_selector"><i class="fount_fa-stop"></i></div>', 'js_composer' ) => 'fount_fa-stop',
__( '<div class="fount_icon_selector"><i class="fount_fa-youtube-play"></i></div>', 'js_composer' ) => 'fount_fa-youtube-play',
__( '<div class="fount_icon_selector"><i class="fount_fa-adn"></i></div>', 'js_composer' ) => 'fount_fa-adn',
__( '<div class="fount_icon_selector"><i class="fount_fa-android"></i></div>', 'js_composer' ) => 'fount_fa-android',
__( '<div class="fount_icon_selector"><i class="fount_fa-apple"></i></div>', 'js_composer' ) => 'fount_fa-apple',
__( '<div class="fount_icon_selector"><i class="fount_fa-behance"></i></div>', 'js_composer' ) => 'fount_fa-behance',
__( '<div class="fount_icon_selector"><i class="fount_fa-behance-square"></i></div>', 'js_composer' ) => 'fount_fa-behance-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-bitbucket"></i></div>', 'js_composer' ) => 'fount_fa-bitbucket',
__( '<div class="fount_icon_selector"><i class="fount_fa-bitbucket-square"></i></div>', 'js_composer' ) => 'fount_fa-bitbucket-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-bitcoin"></i></div>', 'js_composer' ) => 'fount_fa-bitcoin',
__( '<div class="fount_icon_selector"><i class="fount_fa-btc"></i></div>', 'js_composer' ) => 'fount_fa-btc',
__( '<div class="fount_icon_selector"><i class="fount_fa-codepen"></i></div>', 'js_composer' ) => 'fount_fa-codepen',
__( '<div class="fount_icon_selector"><i class="fount_fa-css3"></i></div>', 'js_composer' ) => 'fount_fa-css3',
__( '<div class="fount_icon_selector"><i class="fount_fa-delicious"></i></div>', 'js_composer' ) => 'fount_fa-delicious',
__( '<div class="fount_icon_selector"><i class="fount_fa-deviantart"></i></div>', 'js_composer' ) => 'fount_fa-deviantart',
__( '<div class="fount_icon_selector"><i class="fount_fa-digg"></i></div>', 'js_composer' ) => 'fount_fa-digg',
__( '<div class="fount_icon_selector"><i class="fount_fa-dribbble"></i></div>', 'js_composer' ) => 'fount_fa-dribbble',
__( '<div class="fount_icon_selector"><i class="fount_fa-dropbox"></i></div>', 'js_composer' ) => 'fount_fa-dropbox',
__( '<div class="fount_icon_selector"><i class="fount_fa-drupal"></i></div>', 'js_composer' ) => 'fount_fa-drupal',
__( '<div class="fount_icon_selector"><i class="fount_fa-empire"></i></div>', 'js_composer' ) => 'fount_fa-empire',
__( '<div class="fount_icon_selector"><i class="fount_fa-facebook"></i></div>', 'js_composer' ) => 'fount_fa-facebook',
__( '<div class="fount_icon_selector"><i class="fount_fa-facebook-square"></i></div>', 'js_composer' ) => 'fount_fa-facebook-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-flickr"></i></div>', 'js_composer' ) => 'fount_fa-flickr',
__( '<div class="fount_icon_selector"><i class="fount_fa-foursquare"></i></div>', 'js_composer' ) => 'fount_fa-foursquare',
__( '<div class="fount_icon_selector"><i class="fount_fa-ge"></i></div>', 'js_composer' ) => 'fount_fa-ge',
__( '<div class="fount_icon_selector"><i class="fount_fa-git"></i></div>', 'js_composer' ) => 'fount_fa-git',
__( '<div class="fount_icon_selector"><i class="fount_fa-git-square"></i></div>', 'js_composer' ) => 'fount_fa-git-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-github"></i></div>', 'js_composer' ) => 'fount_fa-github',
__( '<div class="fount_icon_selector"><i class="fount_fa-github-alt"></i></div>', 'js_composer' ) => 'fount_fa-github-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-github-square"></i></div>', 'js_composer' ) => 'fount_fa-github-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-gittip"></i></div>', 'js_composer' ) => 'fount_fa-gittip',
__( '<div class="fount_icon_selector"><i class="fount_fa-google"></i></div>', 'js_composer' ) => 'fount_fa-google',
__( '<div class="fount_icon_selector"><i class="fount_fa-google-plus"></i></div>', 'js_composer' ) => 'fount_fa-google-plus',
__( '<div class="fount_icon_selector"><i class="fount_fa-google-plus-square"></i></div>', 'js_composer' ) => 'fount_fa-google-plus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-hacker-news"></i></div>', 'js_composer' ) => 'fount_fa-hacker-news',
__( '<div class="fount_icon_selector"><i class="fount_fa-html5"></i></div>', 'js_composer' ) => 'fount_fa-html5',
__( '<div class="fount_icon_selector"><i class="fount_fa-instagram"></i></div>', 'js_composer' ) => 'fount_fa-instagram',
__( '<div class="fount_icon_selector"><i class="fount_fa-joomla"></i></div>', 'js_composer' ) => 'fount_fa-joomla',
__( '<div class="fount_icon_selector"><i class="fount_fa-jsfiddle"></i></div>', 'js_composer' ) => 'fount_fa-jsfiddle',
__( '<div class="fount_icon_selector"><i class="fount_fa-linkedin"></i></div>', 'js_composer' ) => 'fount_fa-linkedin',
__( '<div class="fount_icon_selector"><i class="fount_fa-linkedin-square"></i></div>', 'js_composer' ) => 'fount_fa-linkedin-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-linux"></i></div>', 'js_composer' ) => 'fount_fa-linux',
__( '<div class="fount_icon_selector"><i class="fount_fa-maxcdn"></i></div>', 'js_composer' ) => 'fount_fa-maxcdn',
__( '<div class="fount_icon_selector"><i class="fount_fa-openid"></i></div>', 'js_composer' ) => 'fount_fa-openid',
__( '<div class="fount_icon_selector"><i class="fount_fa-pagelines"></i></div>', 'js_composer' ) => 'fount_fa-pagelines',
__( '<div class="fount_icon_selector"><i class="fount_fa-pied-piper"></i></div>', 'js_composer' ) => 'fount_fa-pied-piper',
__( '<div class="fount_icon_selector"><i class="fount_fa-pied-piper-alt"></i></div>', 'js_composer' ) => 'fount_fa-pied-piper-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-pied-piper-square"></i></div>', 'js_composer' ) => 'fount_fa-pied-piper-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-pinterest"></i></div>', 'js_composer' ) => 'fount_fa-pinterest',
__( '<div class="fount_icon_selector"><i class="fount_fa-pinterest-square"></i></div>', 'js_composer' ) => 'fount_fa-pinterest-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-qq"></i></div>', 'js_composer' ) => 'fount_fa-qq',
__( '<div class="fount_icon_selector"><i class="fount_fa-ra"></i></div>', 'js_composer' ) => 'fount_fa-ra',
__( '<div class="fount_icon_selector"><i class="fount_fa-rebel"></i></div>', 'js_composer' ) => 'fount_fa-rebel',
__( '<div class="fount_icon_selector"><i class="fount_fa-reddit"></i></div>', 'js_composer' ) => 'fount_fa-reddit',
__( '<div class="fount_icon_selector"><i class="fount_fa-reddit-square"></i></div>', 'js_composer' ) => 'fount_fa-reddit-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-renren"></i></div>', 'js_composer' ) => 'fount_fa-renren',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-alt"></i></div>', 'js_composer' ) => 'fount_fa-share-alt',
__( '<div class="fount_icon_selector"><i class="fount_fa-share-alt-square"></i></div>', 'js_composer' ) => 'fount_fa-share-alt-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-skype"></i></div>', 'js_composer' ) => 'fount_fa-skype',
__( '<div class="fount_icon_selector"><i class="fount_fa-slack"></i></div>', 'js_composer' ) => 'fount_fa-slack',
__( '<div class="fount_icon_selector"><i class="fount_fa-soundcloud"></i></div>', 'js_composer' ) => 'fount_fa-soundcloud',
__( '<div class="fount_icon_selector"><i class="fount_fa-spotify"></i></div>', 'js_composer' ) => 'fount_fa-spotify',
__( '<div class="fount_icon_selector"><i class="fount_fa-stack-exchange"></i></div>', 'js_composer' ) => 'fount_fa-stack-exchange',
__( '<div class="fount_icon_selector"><i class="fount_fa-stack-overflow"></i></div>', 'js_composer' ) => 'fount_fa-stack-overflow',
__( '<div class="fount_icon_selector"><i class="fount_fa-steam"></i></div>', 'js_composer' ) => 'fount_fa-steam',
__( '<div class="fount_icon_selector"><i class="fount_fa-steam-square"></i></div>', 'js_composer' ) => 'fount_fa-steam-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-stumbleupon"></i></div>', 'js_composer' ) => 'fount_fa-stumbleupon',
__( '<div class="fount_icon_selector"><i class="fount_fa-stumbleupon-circle"></i></div>', 'js_composer' ) => 'fount_fa-stumbleupon-circle',
__( '<div class="fount_icon_selector"><i class="fount_fa-tencent-weibo"></i></div>', 'js_composer' ) => 'fount_fa-tencent-weibo',
__( '<div class="fount_icon_selector"><i class="fount_fa-trello"></i></div>', 'js_composer' ) => 'fount_fa-trello',
__( '<div class="fount_icon_selector"><i class="fount_fa-tumblr"></i></div>', 'js_composer' ) => 'fount_fa-tumblr',
__( '<div class="fount_icon_selector"><i class="fount_fa-tumblr-square"></i></div>', 'js_composer' ) => 'fount_fa-tumblr-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-twitter"></i></div>', 'js_composer' ) => 'fount_fa-twitter',
__( '<div class="fount_icon_selector"><i class="fount_fa-twitter-square"></i></div>', 'js_composer' ) => 'fount_fa-twitter-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-vimeo-square"></i></div>', 'js_composer' ) => 'fount_fa-vimeo-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-vine"></i></div>', 'js_composer' ) => 'fount_fa-vine',
__( '<div class="fount_icon_selector"><i class="fount_fa-vk"></i></div>', 'js_composer' ) => 'fount_fa-vk',
__( '<div class="fount_icon_selector"><i class="fount_fa-wechat"></i></div>', 'js_composer' ) => 'fount_fa-wechat',
__( '<div class="fount_icon_selector"><i class="fount_fa-weibo"></i></div>', 'js_composer' ) => 'fount_fa-weibo',
__( '<div class="fount_icon_selector"><i class="fount_fa-weixin"></i></div>', 'js_composer' ) => 'fount_fa-weixin',
__( '<div class="fount_icon_selector"><i class="fount_fa-windows"></i></div>', 'js_composer' ) => 'fount_fa-windows',
__( '<div class="fount_icon_selector"><i class="fount_fa-wordpress"></i></div>', 'js_composer' ) => 'fount_fa-wordpress',
__( '<div class="fount_icon_selector"><i class="fount_fa-xing"></i></div>', 'js_composer' ) => 'fount_fa-xing',
__( '<div class="fount_icon_selector"><i class="fount_fa-xing-square"></i></div>', 'js_composer' ) => 'fount_fa-xing-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-yahoo"></i></div>', 'js_composer' ) => 'fount_fa-yahoo',
__( '<div class="fount_icon_selector"><i class="fount_fa-youtube"></i></div>', 'js_composer' ) => 'fount_fa-youtube',
__( '<div class="fount_icon_selector"><i class="fount_fa-youtube-play"></i></div>', 'js_composer' ) => 'fount_fa-youtube-play',
__( '<div class="fount_icon_selector"><i class="fount_fa-youtube-square"></i></div>', 'js_composer' ) => 'fount_fa-youtube-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-ambulance"></i></div>', 'js_composer' ) => 'fount_fa-ambulance',
__( '<div class="fount_icon_selector"><i class="fount_fa-h-square"></i></div>', 'js_composer' ) => 'fount_fa-h-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-hospital-o"></i></div>', 'js_composer' ) => 'fount_fa-hospital-o',
__( '<div class="fount_icon_selector"><i class="fount_fa-medkit"></i></div>', 'js_composer' ) => 'fount_fa-medkit',
__( '<div class="fount_icon_selector"><i class="fount_fa-plus-square"></i></div>', 'js_composer' ) => 'fount_fa-plus-square',
__( '<div class="fount_icon_selector"><i class="fount_fa-stethoscope"></i></div>', 'js_composer' ) => 'fount_fa-stethoscope',
__( '<div class="fount_icon_selector"><i class="fount_fa-user-md"></i></div>', 'js_composer' ) => 'fount_fa-user-md',
__( '<div class="fount_icon_selector"><i class="fount_fa-wheelchair"></i></div>', 'js_composer' ) => 'fount_fa-wheelchair',
);

$target_arr = array(
    __( 'Same window', 'js_composer' ) => '_self',
    __( 'New window', 'js_composer' ) => "_blank"
);

$add_css_animation = array(
    'type' => 'dropdown',
    'heading' => __( 'CSS Animation', 'js_composer' ),
    'param_name' => 'css_animation',
    'admin_label' => true,
    'value' => array(
        __( 'No', 'js_composer' ) => '',
        __("Simple fade", "js_composer") => 'fount_fade_waypoint',
        __( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        __( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        __( 'Left to right', 'js_composer' ) => 'left-to-right',
        __( 'Right to left', 'js_composer' ) => 'right-to-left',
        __( 'Appear from center', 'js_composer' ) => "appear",
        __( 'Flip In X', 'js_composer' ) => "flipin_x",
        __( 'Flip In Y', 'js_composer' ) => "flipin_y",
    ),
    'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
);
$add_css_hide = array(
    'type' => 'checkbox',
    'heading' => __( 'Hide on certain screens:', 'js_composer' ),
    'param_name' => 'hide_with_css',
    'admin_label' => true,
    'group' => __( 'Viewports', 'js_composer' ),
    'value' => array(
        __("Large screens - Over 768px wide<br>", "js_composer") => 'show_later',
        __("Small screens - Under 768px wide<br>", "js_composer") => 'hide_later',
        __("Smaller screens - Under 480px wide", "js_composer") => 'hide_much_later',
    ),
    'description' => __( 'Tick the screen sizes on wich this element should be hidden.', 'js_composer' )
);
$add_mobile_mode = array(
    'type' => 'dropdown',
    'heading' => __( 'Activate mobile mode', 'js_composer' ),
    'param_name' => 'mobile_mode',
    'admin_label' => true,
    'group' => __( 'Responsiveness', 'js_composer' ),
    'value' => array(
        __("Screens under 768px wide", "js_composer") => '',
        __("Screens under 1024px wide", "js_composer") => 'fnt_sooner',
    ),
    'description' => __( 'Default value is 768px.', 'js_composer' )
);
$add_custom_css = array(
    "type" => "textfield",
    "heading" => __("Apply custom CSS to this element", "js_composer"),
    "param_name" => "custom_css",
    "value" => '',
    "description" => "Example: margin-left:90px;",
    "weight" => "0",
);
$yes_no_arr = array(__('Yes', "js_composer") => "yes",__('No', "js_composer") => "no");
$no_yes_arr = array(__('No', "js_composer") => "no",__('Yes', "js_composer") => "yes");
function fount_integrateWithVC() {

    global $add_css_animation,$nets_array,$yes_no_arr,$no_yes_arr,$rotator_arr,$target_arr,$colors_arr,$size_arr,$add_custom_css,$add_mobile_mode,$add_css_hide,$prk_fount_options,$fount_icons_arr;
    $cpts_array=get_post_types('', 'names'); 
    /* Page Elements Removal ----------------------------------------------------- */
    vc_remove_element("vc_masonry_media_grid");
    vc_remove_element("vc_empty_space");
    vc_remove_element("vc_basic_grid");
    vc_remove_element("vc_media_grid");
    vc_remove_element("vc_masonry_grid");
    vc_remove_element("vc_separator");
    vc_remove_element("vc_posts_slider");
    vc_remove_element("vc_images_carousel");
    vc_remove_element("vc_carousel");
    vc_remove_element("vc_toggle");
    vc_remove_element("vc_cta_button");
    //vc_remove_element("vc_gallery");
    vc_remove_element("vc_posts_grid");
    vc_remove_element("vc_pie");
    vc_remove_element("vc_icon");
    vc_remove_element("vc_round_chart");
    vc_remove_element("vc_line_chart");
    vc_remove_element("vc_button2");
    vc_remove_element("vc_btn");
    vc_remove_element("vc_tta_pageable");
    vc_remove_element("vc_text_separator");
    vc_remove_element("vc_cta");


    /* Row Overrides ----------------------------------------------------- */
    vc_remove_param('vc_row', 'parallax_speed_video');
    vc_remove_param('vc_row', 'parallax_speed_bg');
    vc_remove_param('vc_row', 'equal_height');
    vc_remove_param('vc_row', 'gap');
    vc_remove_param('vc_row', 'columns_placement');
    vc_remove_param('vc_row', 'el_id');
    vc_remove_param('vc_row', 'full_height');
    vc_remove_param('vc_row', 'video_bg');
    vc_remove_param('vc_row', 'content_placement');
    vc_remove_param('vc_row', 'video_bg_url');
    vc_remove_param('vc_row', 'video_bg_parallax');
    vc_remove_param('vc_row', 'full_width');
    vc_remove_param('vc_row', 'parallax');
    vc_remove_param('vc_row', 'parallax_image');
    vc_remove_param('vc_row', 'font_color');
    vc_remove_param('vc_row', 'el_class');
    vc_remove_param('vc_row', 'css');

    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Row type", "js_composer"),
        "param_name" => "bk_type",
        "value" => array(
            __("Regular size", "js_composer") => "fount_boxed_row", 
            __("Full width (content is displayed with no horizontal size restrictions)", "js_composer") => "fount_full_row"),
        "description" => __("This option determines the general size of the whole row section.", "js_composer")
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Row type", "js_composer"),
        "param_name" => "bk_type",
        "value" => array(__("Optimized for colored sections (extra vertical padding)", "js_composer") => "full_width", __("Regular size (no extra vertical padding)", "js_composer") => "boxed_look", __("Full width (content is displayed with no horizontal size restrictions)", "js_composer") => "pirenko_super_width"),
        "description" => __("This option determines the general size of the whole row section.", "js_composer")
    ));
    vc_add_param("vc_row", array(
      "type" => "textfield",
      "heading" => __('Row anchor id', 'wpb'),
      "param_name" => "anchor_id",
      "description" => __("Optional - Useful for mini site pages.", "wpb")
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Row Height", "js_composer"),
        "param_name" => "row_height",
        "value" => array(
            __("Regular", 'wpb') => '',
            __("Force 100%", 'wpb') => 'forced_row',
            __('Force 100% and center content vertically', 'wpb') => 'forced_row vertical_forced_row',
        ),
        "description" => __("", "js_composer"),
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Append slide down arrow on bottom of this row?", "js_composer"),
        "param_name" => "append_arrow",
        "value" => $no_yes_arr,
        "description" => "On click will make the browser scroll to the next row",
        "dependency" => Array('element' => "row_height", 'value' => array('forced_row','forced_row vertical_forced_row'))
    ));
    vc_add_param("vc_row", array(
      "type" => "textfield",
      "heading" => __('Bottom margin', 'wpb'),
      "param_name" => "margin_bottom",
      "description" => __("You can use px, em, %, etc. or enter just number and pixels will be used. ", "wpb")
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Background type", "js_composer"),
        "param_name" => "bk_element",
        "value" => array(
            __("Transparent", 'wpb') => '',
            __("Solid Color", 'wpb') => 'colored',
            __('Image', 'wpb') => 'image',
            __('Video', 'wpb') => 'video',
        ),
        "description" => __("", "js_composer"),
    ));
    vc_add_param("vc_row", array(
      "type" => "colorpicker",
      "heading" => __("Custom Background Color", "wpb"),
      "param_name" => "bg_color",
      "description" => __("Select backgound color for your row", "wpb"),
      "dependency" => Array('element' => "bk_element", 'value' => 'colored')
    ));
    vc_add_param("vc_row", array(
      "type" => "attach_image",
      "heading" => __('Background Image', 'wpb'),
      "param_name" => "bg_image",
      "description" => __("Select background image for your row", "wpb"),
      "dependency" => Array('element' => "bk_element", 'value' => 'image')
    ));
    vc_add_param("vc_row", array(
      "type" => "dropdown",
      "heading" => __('Background Repeat', 'wpb'),
      "param_name" => "bg_image_repeat",
      "value" => array(
            __("Default", 'wpb') => '',
            __("Cover - background image aligned with top", 'wpb') => 'fount_cover_top',
            __("Cover - background image centered", 'wpb') => 'cover',
            __("Cover - background image aligned with bottom", 'wpb') => 'fount_cover_bottom',
            __("Cover with fixed postion", 'wpb') => 'fixed_cover',
            __('Cover with parallax effect', 'wpb') => 'parallax',
            __('Contain', 'wpb') => 'contain',
            __('No Repeat', 'wpb') => 'no-repeat'
     ),
      "description" => __("Select how a background image will be repeated", "wpb"),
      "dependency" => Array('element' => "bk_element", 'value' => 'image')
    ));
    vc_add_param("vc_row", array(
      "type" => "textfield",
      "heading" => __("Video MP4 file path", "js_composer"),
      "param_name" => "vid_mp4",
      "description" => __("", "js_composer"),
      "dependency" => Array('element' => "bk_element", 'value' => 'video')
    ));
    vc_add_param("vc_row", array(
      "type" => "textfield",
      "heading" => __("Video webm file path", "js_composer"),
      "param_name" => "vid_webm",
      "description" => __("", "js_composer"),
      "dependency" => Array('element' => "bk_element", 'value' => 'video')
    ));
    vc_add_param("vc_row", array(
      "type" => "attach_image",
      "heading" => __('Video image fallback', 'wpb'),
      "param_name" => "vid_image",
      "description" => __("Will be shown if the browser does not support video (optional)", "wpb"),
      "dependency" => Array('element' => "bk_element", 'value' => 'video')
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Video parallax effect?", "js_composer"),
        "param_name" => "vid_parallax",
        "value" => $no_yes_arr,
        "description" => "",
        "dependency" => Array('element' => "bk_element", 'value' => 'video')
    ));
    vc_add_param("vc_row", array(
      "type" => "dropdown",
      "heading" => __('Background overlay', 'wpb'),
      "param_name" => "bk_overlay",
      "value" => array(
        __("None", 'wpb') => '',
        __("Dots", 'wpb') => 'dots.png',
        __("Vertical lines", 'wpb') => 'vertical-line.png',
        __("Horizontal lines", 'wpb') => 'horizontal-line.png',
        __("Oblique lines", 'wpb') => 'oblique.png',
      ),
      "description" => __("Useful to darken backgrounds", "wpb")
    ));
    vc_add_param("vc_row", array(
        "type" => "dropdown",
        "heading" => __("Text alignment", "js_composer"),
        "param_name" => "align",
        "value" => array("Left","Center","Right"),
        "description" => __("Can be overriden by individual elements settings", "js_composer")
    ));
    vc_add_param("vc_row", array(
       "type" => "colorpicker",
       "holder" => "div",
       "class" => "",
       "heading" => __("Text color"),
       "param_name" => "font_color",
       "value" => __(""),
       "description" => __("Optional")
    ));
    vc_add_param("vc_row", $add_css_animation);
    vc_add_param("vc_row", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));
    //vc_add_param("vc_row", $add_custom_css);


    /* Inner Row Overrides ----------------------------------------------------- */
    vc_remove_param('vc_row_inner', 'equal_height');
    vc_remove_param('vc_row_inner', 'gap');
    vc_remove_param('vc_row_inner', 'el_id');
    vc_remove_param('vc_row_inner', 'full_height');
    vc_remove_param('vc_row_inner', 'video_bg');
    vc_remove_param('vc_row_inner', 'content_placement');
    vc_remove_param('vc_row_inner', 'columns_placement');
    vc_remove_param('vc_row_inner', 'video_bg_url');
    vc_remove_param('vc_row_inner', 'video_bg_parallax');
    vc_remove_param('vc_row_inner', 'full_width');
    vc_remove_param('vc_row_inner', 'parallax');
    vc_remove_param('vc_row_inner', 'parallax_image');
    vc_remove_param('vc_row_inner', 'font_color');
    vc_remove_param('vc_row_inner', 'el_class');
    vc_remove_param('vc_row_inner', 'css');
    vc_add_param("vc_row_inner", array(
      "type" => "textfield",
      "heading" => __('Row anchor id', 'wpb'),
      "param_name" => "anchor_id",
      "description" => __("Optional - Useful for mini site pages.", "wpb")
    ));
    vc_add_param("vc_row_inner", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));

    /* Column Overrides ----------------------------------------------------- */
    vc_remove_param('vc_column', 'font_color');
    vc_remove_param('vc_column', 'css');
    vc_remove_param('vc_column', 'el_class');
    vc_remove_param('vc_column', 'width');
    vc_remove_param('vc_column', 'offset');
    vc_add_param("vc_column", $add_css_animation);
    vc_add_param("vc_column", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));
    //vc_add_param("vc_column", $add_custom_css);

    /* Inner Column Overrides ----------------------------------------------------- */
    vc_remove_param('vc_column_inner', 'font_color');
    vc_remove_param('vc_column_inner', 'css');
    vc_remove_param('vc_column_inner', 'el_class');
    vc_remove_param('vc_column_inner', 'width');
    vc_remove_param('vc_column_inner', 'offset');
    vc_add_param("vc_column_inner", $add_css_animation);
    vc_add_param("vc_column_inner", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));
    //vc_add_param("vc_column_inner", $add_custom_css);

    /* Text Block Overrides ----------------------------------------------------- */
    //vc_remove_param('vc_column_text', 'el_class');
    //vc_remove_param('vc_column_text', 'css');
    vc_add_param("vc_column_text", $add_css_animation);
    /*vc_add_param("vc_column_text", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));*/
    //vc_add_param("vc_column_text", $add_custom_css);

    /* Empty Space Overrides --------------------------------------------------------- */
    /*vc_remove_param('vc_empty_space', 'el_class');
    vc_remove_param('vc_empty_space', 'height');
    vc_add_param("vc_empty_space", array(
        "type" => "textfield",
        'heading' => __( 'Vertical adjustment', 'js_composer' ),
        "param_name" => "height",
        "value"=> "32px",
        "description" => "Use negative values to pull elements up."
    ));
    vc_add_param("vc_empty_space", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));*/

    /* Message Box Overrides ----------------------------------------------------- */
    vc_remove_param('vc_message', 'el_class');
    vc_remove_param('vc_message', 'css');
    vc_remove_param('vc_message', 'message_box_style');
    vc_remove_param('vc_message', 'message_box_color');
    vc_remove_param('vc_message', 'color');
    vc_remove_param('vc_message', 'icon_type');
    vc_remove_param('vc_message', 'icon_fontawesome');
    vc_remove_param('vc_message', 'icon_openiconic');
    vc_remove_param('vc_message', 'icon_typicons');
    vc_remove_param('vc_message', 'icon_entypo');
    vc_remove_param('vc_message', 'icon_linecons');
    vc_remove_param('vc_message', 'icon_pixelicons');
    vc_remove_param('vc_message', 'style');


    vc_add_param("vc_message", array(
       "type" => "dropdown",
       "class" => "",
       "heading" => __("Style",'fount'),
       "param_name" => "message_box_color",
       "value" => array(
            __('Info', "js_composer") => "info",
            __('Warning', "js_composer") => "warning",
            __('Danger', "js_composer") => "danger",
            __('Success', "js_composer") => "success",
        ),
       "description" => __("Set up a font face according to the theme options",'fount')
    ));
    vc_add_param("vc_message", array(
        'type' => 'dropdown',
        'heading' => __( 'Shape', 'js_composer' ),
        'param_name' => 'style', // due to backward compatibility message_box_shape
        'std' => 'rounded',
        'value' => array(
            __( 'Square', 'js_composer' ) => 'square',
            __( 'Rounded', 'js_composer' ) => 'rounded',
            __( 'Round', 'js_composer' ) => 'round',
        ),
        'description' => __( 'Select message box shape.', 'js_composer' ),
    ));

    vc_add_param("vc_message", array(
        'type' => 'dropdown',
        'heading' => __( 'CSS Animation', 'js_composer' ),
        'param_name' => 'css_animation',
        'value' => array(
            __( 'No', 'js_composer' ) => '',
            __("Simple fade", "js_composer") => 'fount_fade_waypoint',
            __( 'Zoom in', 'js_composer' ) => "appear",
            __( 'Flash', 'js_composer' ) => "fnt_flash",
            __( 'Shake', 'js_composer' ) => "fnt_shake",
            __( 'Flip in - vertical', 'js_composer' ) => "flipin_x",
            __( 'Flip in - horizontal', 'js_composer' ) => "flipin_y",
            __( 'Flip in - horizontal', 'js_composer' ) => "flipin_y",
            __( 'Top to bottom - Move Down', 'js_composer' ) => 'top-to-bottom',
            __( 'Top to bottom - Bounce Down', 'js_composer' ) => 'fnt_fadeInDownBig',
            __( 'Bottom to top - Move Up', 'js_composer' ) => 'bottom-to-top',
            __( 'Bottom to top - Bounce Up', 'js_composer' ) => 'fnt_fadeInUpBig',
            __( 'Left to right', 'js_composer' ) => 'left-to-right',
            __( 'Left to right - Bounce in from left', 'js_composer' ) => 'fnt_fadeInLeftBig',
            __( 'Right to left', 'js_composer' ) => 'right-to-left',
            __( 'Right to left - Bounce in from right', 'js_composer' ) => 'fnt_fadeInRightBig',
        ),
        'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
    ));
    vc_add_param("vc_message", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));


    /* Single Image Overrides ----------------------------------------------------- */
    vc_remove_param('vc_single_image', 'onclick');
    vc_remove_param('vc_single_image', 'img_link_target');
    vc_remove_param('vc_single_image', 'link');
    vc_remove_param('vc_single_image', 'style');
    vc_remove_param('vc_single_image', 'add_caption');
    vc_remove_param('vc_single_image', 'border_color');
    vc_remove_param('vc_single_image', 'el_class');
    vc_remove_param('vc_single_image', 'css');
    vc_add_param("vc_single_image", array(
        'type' => 'dropdown',
        'heading' => __( 'On click action', 'js_composer' ),
        'param_name' => 'onclick', // due to backward compatibility message_box_shape
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Link to large image', 'js_composer' ) => 'img_link_large',
            __( 'Open custom link', 'js_composer' ) => 'custom_link',
        ),
        'description' => __( '', 'js_composer' ),
    ));
    vc_add_param("vc_single_image", array(
        'type' => 'href',
        'heading' => __( 'Image link', 'js_composer' ),
        'param_name' => 'link',
        'description' => __( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'js_composer' ),
        'dependency' => array(
            'element' => 'onclick',
            'value' => 'custom_link',
        )
    ));
    vc_add_param("vc_single_image", array(
        'type' => 'dropdown',
        'heading' => __( 'Link Target', 'js_composer' ),
        'param_name' => 'img_link_target',
        'value' => $target_arr,
        'dependency' => array(
            'element' => 'onclick',
            'value' => array( 'custom_link'),
        ),
    ));
    vc_add_param("vc_single_image", $add_css_animation);
    vc_add_param("vc_single_image", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => "",
        "weight" => "0"
    ));
    //vc_add_param("vc_single_image", $add_custom_css);

    /* Call to Action Overrides ----------------------------------------------------- */
    /*vc_remove_param('vc_cta', 'use_custom_fonts_h2');
    vc_remove_param('vc_cta', 'use_custom_fonts_h4');
    vc_remove_param('vc_cta', 'style');
    vc_remove_param('vc_cta', 'color');
    vc_remove_param('vc_cta', 'shape');
    vc_remove_param('vc_cta', 'el_width');
    vc_remove_param('vc_cta', 'add_icon');
    vc_remove_param('vc_cta', 'h2_font_container');
    vc_remove_param('vc_cta', 'h2_link');
    vc_remove_param('vc_cta', 'h2_use_theme_fonts');
    vc_remove_param('vc_cta', 'h2_google_fonts');
    vc_remove_param('vc_cta', 'h4_font_container');
    vc_remove_param('vc_cta', 'h4_link');
    vc_remove_param('vc_cta', 'h4_use_theme_fonts');
    vc_remove_param('vc_cta', 'h4_google_fonts');

    vc_remove_param('vc_cta', 'btn_style');
    vc_remove_param('vc_cta', 'btn_custom_background');
    vc_remove_param('vc_cta', 'btn_custom_text');
    vc_remove_param('vc_cta', 'btn_outline_custom_color');
    vc_remove_param('vc_cta', 'btn_outline_custom_hover_background');
    vc_remove_param('vc_cta', 'btn_outline_custom_hover_text');
    vc_remove_param('vc_cta', 'btn_shape');
    vc_remove_param('vc_cta', 'btn_color');
    vc_remove_param('vc_cta', 'btn_size');
    vc_remove_param('vc_cta', 'btn_button_block');
    vc_remove_param('vc_cta', 'btn_add_icon');
    vc_remove_param('vc_cta', 'btn_i_align');
    vc_remove_param('vc_cta', 'btn_i_type');
    vc_remove_param('vc_cta', 'btn_i_icon_fontawesome');
    vc_remove_param('vc_cta', 'btn_i_icon_openiconic');
    vc_remove_param('vc_cta', 'btn_i_icon_typicons');
    vc_remove_param('vc_cta', 'btn_i_icon_entypo');
    vc_remove_param('vc_cta', 'btn_i_icon_linecons');
    vc_remove_param('vc_cta', 'btn_i_icon_pixelicons');


    vc_remove_param('vc_cta', 'i_on_border');
    vc_remove_param('vc_cta', 'i_type');
    vc_remove_param('vc_cta', 'i_icon_fontawesome');
    vc_remove_param('vc_cta', 'i_icon_openiconic');
    vc_remove_param('vc_cta', 'i_icon_typicons');
    vc_remove_param('vc_cta', 'i_icon_entypo');
    vc_remove_param('vc_cta', 'i_icon_linecons');
    vc_remove_param('vc_cta', 'i_color');
    vc_remove_param('vc_cta', 'i_custom_color');
    vc_remove_param('vc_cta', 'i_background_style');
    vc_remove_param('vc_cta', 'i_background_color');
    vc_remove_param('vc_cta', 'i_custom_background_color');
    vc_remove_param('vc_cta', 'i_size');
    vc_remove_param('vc_cta', 'i_link');
    vc_remove_param('vc_cta', 'i_el_class');
    vc_remove_param('vc_cta', 'i_css_animation');

    vc_remove_param('vc_cta', 'custom_background');
    vc_remove_param('vc_cta', 'custom_text');
    vc_remove_param('vc_cta', 'content');
    vc_remove_param('vc_cta', 'add_button');
    vc_remove_param('vc_cta', 'css_animation');
    vc_remove_param('vc_cta', 'el_class');*/


    /* Call to Action Button
    ---------------------------------------------------------- */
    /*vc_add_param("vc_cta",array(
        'type' => 'dropdown',
        'heading' => __( 'Shape', 'js_composer' ),
        'param_name' => 'shape',
        'std' => 'rounded',
        'value' => array(
            __( 'Square', 'js_composer' ) => 'square',
            __( 'Rounded', 'js_composer' ) => 'rounded',
        ),
        'description' => __( 'Select call to action shape.', 'js_composer' ),
    ));

    vc_add_param("vc_cta",array(
        'type' => 'dropdown',
        'heading' => __( 'Style', 'js_composer' ),
        'param_name' => 'style',
        'value' => array(
            __( 'Default', 'js_composer' ) => 'classic',
            __( 'Custom', 'js_composer' ) => 'custom',
        ),
        'std' => 'classic',
        'description' => __( 'Select call to action display style.', 'js_composer' ),
    ));
    vc_add_param("vc_cta", array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', 'js_composer' ),
        'param_name' => 'custom_background',
        'description' => __( 'Select custom background color.', 'js_composer' ),
        'dependency' => array(
            'element' => 'style',
            'value' => array( 'custom' )
        ),
        'edit_field_class' => 'vc_col-sm-6 vc_column',
    ));
    vc_add_param("vc_cta", array(
        'type' => 'colorpicker',
        'heading' => __( 'Headings color', 'js_composer' ),
        'param_name' => 'custom_text',
        'description' => __( 'Select custom text color.', 'js_composer' ),
        'dependency' => array(
            'element' => 'style',
            'value' => array( 'custom' )
        ),
        'edit_field_class' => 'vc_col-sm-6 vc_column',
    ));
    vc_add_param("vc_cta", array(
        'type' => 'textarea_html',
        //holder' => 'div',
        //'admin_label' => true,
        'heading' => __( 'Text', 'js_composer' ),
        'param_name' => 'content',
        'value' => __( 'I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'js_composer' )
    ));
    vc_add_param("vc_cta", array(
        'type' => 'dropdown',
        'heading' => __( 'Add button', 'js_composer' ) . '?',
        'description' => __( 'Add button for call to action.', 'js_composer' ),
        'param_name' => 'add_button',
        'value' => array(
            __( 'No', 'js_composer' ) => '',
            __( 'Top', 'js_composer' ) => 'top',
            __( 'Bottom', 'js_composer' ) => 'bottom',
            __( 'Left', 'js_composer' ) => 'left',
            __( 'Right', 'js_composer' ) => 'right',
        ),
    ));
    vc_add_param("vc_cta", $add_css_animation);
    vc_add_param("vc_cta", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));*/

    /* Google Maps Overrides ----------------------------------------------------- */
    vc_remove_param('vc_gmaps', 'link');
    vc_remove_param('vc_gmaps', 'size');
    vc_remove_param('vc_gmaps', 'css');
    vc_remove_param('vc_gmaps', 'el_class');

    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Google map latitude", "js_composer"),
    "param_name" => "map_latitude",
    "admin_label" => true,
    "description" => __("", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Google map longitude", "js_composer"),
    "param_name" => "map_longitude",
    "admin_label" => true,
    "description" => __("", "js_composer")
    ));
    vc_add_param("vc_gmaps",array(
        "type" => "dropdown",
        "heading" => __("Map Type", "js_composer"),
        "param_name" => "map_type",
        "value" => array(
        __("Roadmap", "js_composer") => "roadmap", 
        __("Hybrid", "js_composer") => "hybrid", 
        __("Terrain", "js_composer") => "terrain",
        __("Satellite", "js_composer") => "satellite"),
        "description" => __("", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "dropdown",
    "heading" => __("Map Style", "js_composer"),
    "param_name" => "map_style",
    "value" => array(
        __("Default", "js_composer") => "default", 
        __("Almost Gray", "js_composer") => "almost_gray", 
        __("Subtle Grayscale", "js_composer") => "subtle_grayscale",
        __("Cobalt", "js_composer") => "cobalt", 
        __("Midnight Commander", "js_composer") => "midnight", 
        __("Old Timey", "js_composer") => "old_timey", 
        __("Greenish", "js_composer") => "green",
    ),
    "description" => __("", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Map height", "js_composer"),
    "param_name" => "size",
    "description" => __('Enter map height in pixels. Example: 200.', "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "dropdown",
    "heading" => __("Map Zoom", "js_composer"),
    "param_name" => "zoom",
    "value" => array(__("14 - Default", "js_composer") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "attach_image",
    "heading" => __("Marker Image", "js_composer"),
    "param_name" => "marker_image",
    "value" => "",
    "description" => __("Optional", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Marker image latitude", "js_composer"),
    "param_name" => "marker_image_lat",
    "description" => __("Optional", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Marker image longitude", "js_composer"),
    "param_name" => "marker_image_long",
    "description" => __("Optional", "js_composer")
    ));
    vc_add_param("vc_gmaps", array(
    "type" => "textfield",
    "heading" => __("Extra class name", "js_composer"),
    "param_name" => "el_class",
    "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    ));

    /* Tabs Overrides ---------------------------------------------------------- */
    vc_remove_param('vc_tta_tabs', 'style');
    vc_remove_param('vc_tta_tabs', 'shape');
    vc_remove_param('vc_tta_tabs', 'color');
    vc_remove_param('vc_tta_tabs', 'gap');
    vc_remove_param('vc_tta_tabs', 'spacing');
    vc_remove_param('vc_tta_tabs', 'pagination_style');
    vc_remove_param('vc_tta_tabs', 'pagination_color');
    //vc_remove_param('vc_tta_tabs', 'tab_position');
    //vc_remove_param('vc_tta_tabs', 'no_fill_content_area');
    //vc_remove_param('vc_tta_tabs', 'alignment');

    vc_remove_param('vc_tta_section', 'i_type');
    vc_add_param("vc_tta_section", array(
        'type' => 'dropdown',
        'heading' => __( 'Icon library', 'js_composer' ),
        'value' => array(
            __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
        ),
        'admin_label' => false,
        'param_name' => 'i_type',
        'description' => __( 'Select icon library.', 'js_composer' ),
    ));

    /* Tour Overrides ---------------------------------------------------------- */
    vc_remove_param('vc_tta_tour', 'style');
    vc_remove_param('vc_tta_tour', 'shape');
    vc_remove_param('vc_tta_tour', 'color');
    vc_remove_param('vc_tta_tour', 'gap');
    vc_remove_param('vc_tta_tour', 'spacing');
    vc_remove_param('vc_tta_tour', 'pagination_style');
    vc_remove_param('vc_tta_tour', 'pagination_color');

    /* Accordion Overrides ---------------------------------------------------------- */
    vc_remove_param('vc_tta_accordion', 'style');
    vc_remove_param('vc_tta_accordion', 'shape');
    vc_remove_param('vc_tta_accordion', 'color');
    vc_remove_param('vc_tta_accordion', 'gap');
    vc_remove_param('vc_tta_accordion', 'c_icon');
    vc_remove_param('vc_tta_accordion', 'c_position');
    vc_remove_param('vc_tta_accordion', 'spacing');
    vc_remove_param('vc_tta_accordion', 'pagination_style');
    vc_remove_param('vc_tta_accordion', 'pagination_color');
    vc_remove_param('vc_tta_accordion', 'el_class');
    vc_add_param("vc_tta_accordion", array(
        'type' => 'dropdown',
        'param_name' => 'c_icon',
        'value' => array(
            __( 'None', 'js_composer' ) => '',
            __( 'Chevron', 'js_composer' ) => 'chevron',
            //__( 'Plus', 'js_composer' ) => 'plus',
            //__( 'Triangle', 'js_composer' ) => 'triangle',
        ),
        'std' => 'chevron',
        'heading' => __( 'Icon', 'js_composer' ),
        'description' => __( 'Select accordion navigation icon.', 'js_composer' ),
    ));
    vc_add_param("vc_tta_accordion", array(
        'type' => 'dropdown',
        'param_name' => 'c_position',
        'value' => array(
            __( 'Left', 'js_composer' ) => 'left',
            __( 'Right', 'js_composer' ) => 'right',
        ),
        'dependency' => array(
            'element' => 'c_icon',
            'not_empty' => true,
        ),
        'heading' => __( 'Position', 'js_composer' ),
        'description' => __( 'Select accordion navigation icon position.', 'js_composer' ),
    ));
    vc_add_param("vc_tta_accordion", array(
        "type" => "textfield",
        'heading' => __( 'Extra class name', 'js_composer' ),
        "param_name" => "el_class",
        "value"=> "",
        "description" => ""
    ));
    //vc_add_param("vc_tta_accordion", $add_custom_css);

    /* Progress Bar Overrides ---------------------------------------------------------- */
    vc_remove_param('vc_progress_bar', 'options');
    vc_remove_param('vc_progress_bar', 'el_class');
    vc_add_param("vc_progress_bar", array(
        "type" => "colorpicker",
        "heading" => __("Bars custom background color", "js_composer"),
        "param_name" => "custombgcolor_back",
        "description" => __("Select custom background color for bars - leave blank for theme default value", "js_composer"),
    ));
    vc_add_param("vc_progress_bar", array(
        "type" => "textfield",
        "heading" => __('Bars bottom margin', 'js_composer'),
        "param_name" => "margin_bottom_2", 
        "value" => "50px",
        "description" => __("Value in px.", "js_composer")
    ));
    vc_add_param("vc_progress_bar", $add_css_animation);
    vc_add_param("vc_progress_bar", array(
    "type" => "textfield",
    "heading" => __("Extra class name", "js_composer"),
    "param_name" => "el_class",
    "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    ));

    /* WP Custom Menu ---------------------------------------------------------- */
    vc_add_param("vc_wp_custommenu", array(
        "type" => "dropdown",
        "heading" => __("Text alignment", "js_composer"),
        "param_name" => "align",
        "value" => array(
            __("Left", 'js_composer') => 'fount_left_align',
            __("Centered", 'js_composer') => 'fount_center_align',
            __('Right', 'js_composer') => 'fount_right_align',
        ),
        "description" => __("Can be overriden by individual elements settings", "js_composer")
    ));
    $posts_terms=get_terms('category','hide_empty=0');
    $posts_terms_array=array();
    if (count($posts_terms)) {
        foreach ($posts_terms as $inner_term) {
            $posts_terms_array[$inner_term->name] = $inner_term->slug;
        }
    }
    $portfolio_terms=get_terms('pirenko_skills','hide_empty=0');
    $portfolio_terms_array=array();
    if (count($portfolio_terms)) {
        foreach ($portfolio_terms as $inner_term) {
            $portfolio_terms_array[$inner_term->name] = $inner_term->slug;
        }
    }
    $slides_terms=get_terms('pirenko_slide_set','hide_empty=0');
    $slides_terms_array=array();
    if (count($slides_terms)) {
        foreach ($slides_terms as $inner_term) {
            $slides_terms_array[$inner_term->name] = $inner_term->slug;
        }
    }
    $member_terms=get_terms('pirenko_member_group','hide_empty=0');
    $member_terms_array=array();
    if (count($member_terms)) {
        foreach ($member_terms as $inner_term) {
            $member_terms_array[$inner_term->name] = $inner_term->slug;
        }
    }
    $authors_terms=get_users();
    $authors_terms_array=array();
    if (count($authors_terms)) {
        foreach ($authors_terms as $inner_term) {
            $authors_terms_array[$inner_term->user_nicename] = $inner_term->ID;
        }
    }
    $testimonials_terms=get_terms('pirenko_testimonial_set','hide_empty=0');
    $testimonials_terms_array=array();
    if (count($testimonials_terms)) {
        foreach ($testimonials_terms as $inner_term) {
            $testimonials_terms_array[$inner_term->name] = $inner_term->slug;
        }
    }
    
    /* Vertical Spacer ----------------------------------------------------- */
    //SPACER
  function prkwp_spacer_func( $atts ) {
     extract( shortcode_atts( array(
        'size' => '',
        'el_class' => ''
     ), $atts ) );
   
     return do_shortcode('[pirenko_spacer size="'.$size.'" el_class="'.$el_class.'"][/pirenko_spacer]');
  }
  add_shortcode( 'prkwp_spacer', 'prkwp_spacer_func' );

  vc_map( array(
     "name" => __("Vertical Spacer",'fount'),
     "base" => "prkwp_spacer",
     "class" => "fount_scodes_editor",
     "description" => __('Control vertical space between elements', 'js_composer'),
     "icon" => "icon-wpb-toggle-small-expand",
     "category" => __('Content','fount'),
     "params" => array(
      array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Vertical size in pixels (use negative values to pull elements up)",'fount'),
           "param_name" => "size",
           "value" => "10",
           "description" => "This element creates a vertical space between adjacent elements."
        ),
      array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

   //STYLED TITLE
  function prkwp_styled_title_func( $atts ) {
     extract( shortcode_atts( array(
        'prk_in' => '',
        'align' => '',
        'text_color' => '',
        'title_size' => '',
        'use_italic' => '',
        'show_lines' => '',
        'line_color' => '',
        'fount_show_line' => '',
        'underlined' => '',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
   
     return do_shortcode('[prk_styled_title align="'.strtolower($align).'" text_color="'.strtolower($text_color).'" underlined="'.strtolower($underlined).'" title_size="'.strtolower($title_size).'" fount_show_line="'.strtolower($fount_show_line).'" line_color="'.strtolower($line_color).'" use_italic="'.strtolower($use_italic).'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_styled_title]');
  }
  add_shortcode( 'prkwp_styled_title', 'prkwp_styled_title_func' );

  vc_map( array(
     "name" => __("Styled title",'fount'),
     "base" => "prkwp_styled_title",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-ui-separator-label",
     "description" => __('Display theme like titles', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
      array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Text",'fount'),
           "param_name" => "prk_in",
           "value" => "",
           "description" => ""
        ),
      array(
            "type" => "dropdown",
            "heading" => __("Alignment", "js_composer"),
            "param_name" => "align",
            "value" => array("Left","Center","Right"),
            "description" => ""
        ),
      array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Color",'fount'),
           "param_name" => "text_color",
           "value" => "",
           "description" => __("Optional - If blank the theme default headings color will be used",'fount')
        ),
      array(
            "type" => "dropdown",
            "heading" => __("Title size", "js_composer"),
            "param_name" => "title_size",
            "value" => array(
                __('Extra Large', "js_composer") => "h1",
                __('Large', "js_composer") => "h2",
                __('Medium', "js_composer") => "h3",
                __('Small', "js_composer") => "h4"
            ),
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Italic font style?", "js_composer"),
            "param_name" => "use_italic",
            "value" => array("No","Yes"),
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Append lines to title?", "js_composer"),
            "param_name" => "fount_show_line",
            "value" => array(
                __('No', "js_composer") => "no",
                __('Yes, a thin line above', "js_composer") => "above thin",
                __('Yes, a thick line above', "js_composer") => "above thick",
                __('Yes, a thicker line above', "js_composer") => "above thicker",
                __('Yes, a thin line under', "js_composer") => "thin",
                __('Yes, a thick line under', "js_composer") => "thick",
                __('Yes, a thicker line under', "js_composer") => "thicker",
                __('Yes, two lines on the sides', "js_composer") => "double_lined"),
            "description" => ""
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Appended line color","seven_lang"),
           "param_name" => "line_color",
           "value" => "",
           "dependency" => Array('element' => "seven_show_line", 'value' => array('above thin','above thick','above thicker','thin','thick','thicker')),
           "description" => __("Optional - If blank the theme default headings color will be used","seven_lang")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Underline title?", "js_composer"),
            "param_name" => "underlined",
            "value" => array(__('No', "js_composer") => "",__('Yes, thin line', "js_composer") => "small_underline",__('Yes, thick line', "js_composer") => "large_underline"),
            "description" => __("", "js_composer")
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )     
     )
  ));

    /* Separator (Divider)
---------------------------------------------------------- */
vc_map( array(
  "name"    => __("Separator", "js_composer"),
  "base"    => "prk_line",
  'icon'    => 'icon-wpb-ui-separator',
  "show_settings_on_create" => false,
  "category"  => __('Content', 'js_composer'),
  "description" => __('Horizontal separator line', 'js_composer'),
  "params" => array(
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Divider color",'fount'),
           "param_name" => "color",
           "value" => "",
           "description" => __("Optional - If blank the theme default headings color will be used",'fount')
        ),
        array(
          "type" => "iconpicker",
          "heading" => __("Font Awesome icon selector", "js_composer"),
          "param_name" => "icon",
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
          ),
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Icon color",'fount'),
           "param_name" => "icon_color",
           "value" => "",
           "description" => __("",'fount'),
           "dependency" => Array('element' => "icon", 'not_empty' => true)
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Icon background color",'fount'),
           "param_name" => "icon_bk_color",
           "value" => "#FFFFFF",
           "description" => __("",'fount'),
           "dependency" => Array('element' => "icon", 'not_empty' => true)
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer"),
        )
    )
) );


//BLOCKQUOTE
  function bquote_func( $atts ) {
     extract( shortcode_atts( array(
        'prk_in' => '',
        'author' => '',
        'after_author' => '',
        'type' => '',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
    if ($type=="") {
        $type="plain";
    }
     return do_shortcode("<div class='wpb_content_element'>[pirenko_blockquote author='{$author}' after_author='{$after_author}' type='{$type}' css_animation='{$css_animation}' el_class='{$el_class}']{$prk_in}[/pirenko_blockquote]</div>");
  }
  add_shortcode( 'bquote', 'bquote_func' );

  vc_map( array(
     "name" => __("Blockquote",'fount'),
     "base" => "bquote",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-quote-prk",
     "description" => __('Stylish quotes that stand out', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Blockquote type", "js_composer"),
            "param_name" => "type",
             "value" => array(
              __('Tooltip', "js_composer") => "plain", 
              __('Cropped corners', "js_composer") => "cropped_corners",
              __('Colored background', "js_composer") => "colored_background"
            ),
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Author",'fount'),
           "param_name" => "author",
           "value" => __("",'fount'),
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("After author text",'fount'),
           "param_name" => "after_author",
           "value" => __("",'fount'),
           "description" => __("Optional",'fount')
        ),
        array(
           "type" => "textarea",
           "holder" => "div",
           "class" => "",
           "heading" => __("Content",'fount'),
           "param_name" => "prk_in",
           "value" => __("",'fount'),
           "description" => __("",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

    //COUNTER
  function prkwp_counter_func( $atts ) {
     extract( shortcode_atts( array(
        'counter_origin' => '0',
        'counter_number' => '',
        'prk_in' => '',
        'align' => '',
        'image' => '',
        'serv_image' => '',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
      if ($align=="center_smaller")
      {
        $align="prk_counter_center fount_smaller_counter";
      }
      else
      {
        $align="prk_counter_center";
      }
    $image_attributes = wp_get_attachment_image_src( $serv_image,'full' );
     return do_shortcode('[prk_counter counter_origin="'.$counter_origin.'" counter_number="'.$counter_number.'" align="'.$align.'" image="'.$image.'" serv_image="'.$image_attributes[0].'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_counter]');
  }
  add_shortcode( 'prkwp_counter', 'prkwp_counter_func' );
  vc_map( array(
     "name" => __("Counter",'fount'),
     "base" => "prkwp_counter",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-call-to-action",
     "description" => __('Easy animated counter', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Counter origin number",'fount'),
           "param_name" => "counter_origin",
           "value" => "0",
           "description" => "The value that will be displayed when the animation starts"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Counter final number",'fount'),
           "param_name" => "counter_number",
           "value" => "1000",
           "description" => "The value that will be displayed when the animation ends"
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Size", "js_composer"),
            "param_name" => "align",
            "value" => array(
              __('Regular', "js_composer") => "center",
              __('Smaller', "js_composer") => "center_smaller"
            ),
            "description" => ""
        ),
        array(
          "type" => "attach_image",
          "heading" => __("Counter image", "js_composer"),
          "param_name" => "serv_image",
          "value" => "",
          "description" => __("Select image from media library. Has priority over icon class value below.", "js_composer")
        ),
        array(
          "type" => "iconpicker",
          "heading" => __("Font Awesome icon selector", "js_composer"),
          "param_name" => "image",
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
          ),
        ),
        array(
           "type" => "textarea",
           "holder" => "div",
           "class" => "",
           "heading" => __("Content",'fount'),
           "param_name" => "prk_in",
           "value" => "",
           "description" => "Will be displayed under the animated counter"
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ) );

    //TEXT ROTATOR
  function prk_text_rotator_func( $atts ) {
     extract( shortcode_atts( array(
        'prk_in' => '',
        'text_color' => '',
        'title_size' => '',
        'effect' => '',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
     return do_shortcode('[prk_text_rotator text_color="'.strtolower($text_color).'" effect="'.strtolower($effect).'" title_size="'.strtolower($title_size).'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_text_rotator]');
  }
  add_shortcode( 'prk_wptext_rotator', 'prk_text_rotator_func' );
vc_map( array(
  "name" => __("Text Rotator", "js_composer"),
  "base" => "prk_wptext_rotator",
  "icon" => "icon-wpb-ui-button",
  "category" => __('Content', 'js_composer'),
  "description" => __('Animated titles with custom effects', 'js_composer'),
  "params" => array(
    array(
          "type" => "dropdown",
          "heading" => __("Text size", "js_composer"),
          "param_name" => "title_size",
          "value" => array(
            __('Extra Large', "js_composer") => "h1",
            __('Large', "js_composer") => "h2",
            __('Medium', "js_composer") => "h3",
            __('Small', "js_composer") => "h4"),
          "description" => ""
      ),
    array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Color",'fount'),
         "param_name" => "text_color",
         "value" => "",
         "description" => __("Optional - If blank the theme default color will be used",'fount')
      ),
    array(
      "type" => "dropdown",
      "heading" => __("Text rotator effect", "js_composer"),
      "param_name" => "effect",
      "value" => $rotator_arr,
      "description" => __("", "js_composer")
    ),
    array(
       "type" => "textarea",
       "holder" => "div",
       "class" => "",
       "heading" => __("Content",'fount'),
       "param_name" => "prk_in",
       "value" => "",
       "description" => "Separate strings with a plus (+) sign."
    ),
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
  ),
  "js_view" => 'VcButtonView'
) );

    //CONTDOWN TIMER
  function prk_countdown_func( $atts ) {
     extract( shortcode_atts( array(
        'text_color' => '',
        'year' => '2030',
        'month' => '1',
        'day' => '1',
        'hour' => '1',
        'minute' => '1',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
     return do_shortcode('[prk_countdown text_color="'.strtolower($text_color).'" year="'.$year.'" month="'.$month.'" day="'.$day.'" hour="'.$hour.'" minute="'.$minute.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"][/prk_countdown]');
  }
  add_shortcode( 'prk_wpcountdown', 'prk_countdown_func' );
vc_map( array(
  "name" => __("Countdown Timer", "js_composer"),
  "base" => "prk_wpcountdown",
  "icon" => "icon-wpb-call-to-action",
  "category" => __('Content', 'js_composer'),
  "description" => __('Animated titles with custom effects', 'js_composer'),
  "params" => array(
    array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text color",'fount'),
         "param_name" => "text_color",
         "value" => "",
         "description" => __("Optional - If blank the row default color will be used",'fount')
      ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Year",'fount'),
       "param_name" => "year",
       "value" => "2030",
       "description" => ""
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Month",'fount'),
       "param_name" => "month",
       "value" => "1",
       "description" => "Acceptable values [1,12]"
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Day",'fount'),
       "param_name" => "day",
       "value" => "1",
       "description" => "Acceptable values [1,31]"
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Hours",'fount'),
       "param_name" => "hour",
       "value" => "1",
       "description" => "Acceptable values [0,23]"
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Minutes",'fount'),
       "param_name" => "minute",
       "value" => "0",
       "description" => "Acceptable values [0,59]"
    ),
    $add_css_animation,
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
  ),
  "js_view" => 'VcButtonView'
) );

  //SERVICES
  function prkwp_service_func( $atts ) {
     extract( shortcode_atts( array(
        'prk_in' => '',
        'name' => '',
        'align' => '',
        'image' => '',
        'bk_color' => '',
        'link' => '',
        'serv_image' => '',
        'link_text' => '',
        'text_color' => '',
        'icon_color' => '',
        'icon_up_color' => '',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
      if ($align=="center")
      {
        $align="prk_service_center";
      }
      else if ($align=="center_smaller")
      {
        $align="prk_service_center fount_smaller_service";
      }
      else if ($align=="right_bigger")
      {
        $align="prk_service_right fount_bigger_service";
      }
      else if ($align=="right")
      {
        $align="prk_service_right";
      }
      else if ($align=="left_bigger" || $align=="")
      {
        $align="prk_service_left fount_bigger_service";
      }
      else
      {
        $align="prk_service_left";
      }
    $image_attributes = wp_get_attachment_image_src( $serv_image,'full' );
     return do_shortcode('[prk_service name="'.$name.'" align="'.$align.'" text_color="'.$text_color.'" icon_up_color="'.$icon_up_color.'" icon_color="'.$icon_color.'" image="'.$image.'" serv_image="'.$image_attributes[0].'" link="'.$link.'" bk_color="'.$bk_color.'" link_text="'.$link_text.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"]'.$prk_in.'[/prk_service]');
  }
  add_shortcode( 'prkwp_service', 'prkwp_service_func' );
  vc_map( array(
     "name" => __("Service",'fount'),
     "base" => "prkwp_service",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-call-to-action",
     "description" => __('Easy information blocks with images', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title",'fount'),
           "param_name" => "name",
           "value" => "",
           "description" => ""
        ),
        array(
          "type" => "attach_image",
          "heading" => __("Service image", "js_composer"),
          "param_name" => "serv_image",
          "value" => "",
          "description" => __("Select image from media library. Has priority over icon class value below.", "js_composer")
    ),
        array(
          "type" => "iconpicker",
          "heading" => __("Font Awesome icon selector", "js_composer"),
          "param_name" => "image",
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
          ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Alignment", "js_composer"),
            "param_name" => "align",
            "value" => array(
              __('Left', "js_composer") => "left_bigger",
              __('Left with smaller icon/image', "js_composer") => "left",
              __('Centered', "js_composer") => "center",
              __('Centered with smaller icon/image', "js_composer") => "center_smaller",
              __('Right', "js_composer") => "right_bigger",
              __('Right with smaller icon/image', "js_composer") => "right",
            ),
            "description" => ""
        ),
        array(
           "type" => "textarea",
           "holder" => "div",
           "class" => "",
           "heading" => __("Content",'fount'),
           "param_name" => "prk_in",
           "value" => "",
           "description" => ""
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Text color",'fount'),
           "param_name" => "text_color",
           "value" => "",
           "description" => __("Optional - Will force all service content to have this color",'fount')
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Icon up color",'fount'),
           "param_name" => "icon_up_color",
           "value" => "",
           "description" => __("Optional",'fount'),
           "dependency" => Array('element' => "href", 'not_empty' => false)
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Icon rollover color",'fount'),
           "param_name" => "icon_color",
           "value" => "",
           "description" => __("Optional",'fount'),
           "dependency" => Array('element' => "href", 'not_empty' => false)
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Background color",'fount'),
           "param_name" => "bk_color",
           "value" => "",
           "description" => __("Optional",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("URL link",'fount'),
           "param_name" => "link",
           "value" => "",
           "description" => __("Optional",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("URL link text",'fount'),
           "param_name" => "link_text",
           "value" => "",
           "description" => __("Leave blank for theme default Read More text.",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ) );

    /* Informational Board ----------------------------------------------------- */
    /*function prkwp_board_func( $atts ) {
       extract( shortcode_atts( array(
          'values' => '',
          'cols_width' => '',
          'board_header' => '',
          'link_text' => '',
          'css_animation' => '',
          'el_class' => ''
       ), $atts ) );
       return do_shortcode('[prk_board values="'.$values.'" cols_width="'.$cols_width.'" link_text="'.$link_text.'" board_header="'.$board_header.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"][/prk_board]');
    }
    add_shortcode( 'prkwp_board', 'prkwp_board_func' );
    vc_map( array(
       "name" => __("Informational Board",'fount'),
       "base" => "prkwp_board",
       "class" => "fount_scodes_editor",
       "icon" => "icon-wpb-toggle-small-expand",
       "description" => __('Display info - table style', 'js_composer'),
       "category" => __('Theme: Special','fount'),
       "params" => array(
            array(
            "type" => "textfield",
            "heading" => __("Columns width", "js_composer"),
            "param_name" => "cols_width",
            "description" => __('Separate columns with "|". Example:20%|50%|30%', "js_composer"),
            'value' => "20%|50%|30%"
          ),
            array(
            "type" => "textfield",
            "heading" => __("Board header titles", "js_composer"),
            "param_name" => "board_header",
            "description" => __('Separate strings with "|". Example:Title|Description|Date', "js_composer"),
            'value' => "Title|Description|Date"
          ),
          array(
            'type' => 'exploded_textarea',
            'heading' => __( 'Values', 'js_composer' ),
            'param_name' => 'values',
            'description' => __( 'Separate strings with "|".Enter values for each line according to the numbers of columns defined above. Divide value sets with linebreak "Enter".', 'js_composer' ),
            'value' => "First entry column A|First entry column B|First entry column C,Second entry column A|Second entry column B|Second entry column C"
          ),
          array(
            "type" => "textfield",
            "heading" => __("Link text", "js_composer"),
            "param_name" => "link_text",
            "description" => __('If a link is detected this text will appear as the button label.', "js_composer"),
            'value' => "Link text"
          ),
          $add_css_animation,
          array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
          )
       )
    ) );*/

    /* Timeline ----------------------------------------------------- */
    /*function prkwp_timeline_func( $atts ) {
       extract( shortcode_atts( array(
          'values' => '',
          'text_color' => '',
          'css_animation' => '',
          'el_class' => ''
       ), $atts ) );
       return do_shortcode('[prk_timeline values="'.$values.'" text_color="'.$text_color.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"][/prk_timeline]');
    }
    add_shortcode( 'prkwp_timeline', 'prkwp_timeline_func' );
    vc_map( array(
       "name" => __("Timeline",'fount'),
       "base" => "prkwp_timeline",
       "class" => "fount_scodes_editor",
       "icon" => "icon-wpb-toggle-small-expand",
       "description" => __('Sequential Organized Text', 'js_composer'),
       "category" => __('Theme: Special','fount'),
       "params" => array(
          array(
            'type' => 'exploded_textarea',
            'heading' => __( 'Values', 'js_composer' ),
            'param_name' => 'values',
            'description' => __( 'Enter values for each line - date and description. Divide value sets with linebreak "Enter".', 'js_composer' ),
            'value' => "2000|Started working at company A,2010|Started working at company B,2015|Started working at company C"
          ),
          array(
             "type" => "colorpicker",
             "holder" => "div",
             "class" => "",
             "heading" => __("Text color",'fount'),
             "param_name" => "text_color",
             "value" => "",
             "description" => __("Optional - Will force content to have this color",'fount')
          ),
          $add_css_animation,
          array(
            "type" => "textfield",
            "heading" => __("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
          )
       )
    ) );*/
    /* Theme Icon ----------------------------------------------------- */
   function prk_wp_icon_func( $atts ) {
extract( shortcode_atts( array(
    'icon_size' => '',
    'text_color' => '',
    'align' => '',
    'css_animation' => '',
    'el_class' => '',
    'icon' => ''
 ), $atts ) );

 return do_shortcode('[pirenko_theme_icon icon_size="'.$icon_size.'" align="'.$align.'" icon="'.$icon.'" text_color="'.$text_color.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'"][/pirenko_theme_icon]');
}
add_shortcode( 'prk_wp_icon', 'prk_wp_icon_func' );
vc_map( array(
  "name" => __("Theme icon", "js_composer"),
  "base" => "prk_wp_icon",
  "icon" => "icon-wpb-prk-icon",
  "category" => __('Content', 'js_composer'),
  "description" => __('Awesome icons in any size.', 'js_composer'),
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Icon size", "js_composer"),
      "param_name" => "icon_size",
      "description" => __("Enter icon size. Default is 14px. Examples: 32px or 2em", "js_composer")
    ),
    array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Icon color",'fount'),
           "param_name" => "text_color",
           "value" => "",
           "description" => __("Optional - If blank the theme default color will be used",'fount')
        ),
    array(
        "type" => "dropdown",
        "heading" => __("Icon alignment", "js_composer"),
        "param_name" => "align",
        "value" => array("Left","Center","Right"),
        "description" => __("", "js_composer")
    ),
    array(
      "type" => "iconpicker",
      "heading" => __("Font Awesome icon selector", "js_composer"),
      "param_name" => "icon",
      'settings' => array(
        'emptyIcon' => false, // default true, display an "EMPTY" icon?
        'iconsPerPage' => 200, // default 100, how many icons per/page to display
      ),
    ),
    $add_css_animation,
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer"),
    )
  ),
) );

 //THEME BUTTON
  function theme_button_func( $atts ) {
    extract( shortcode_atts( array(
        'prk_in' => '',
        'type' => '',
        'window' => '',
        'link' => '',
        'el_class' => '',
        'css_animation' => '',
        'button_icon' => '',
        'button_bk_color' =>''
      ), $atts ) );
      if ($window=="Yes")
        $window="_blank";
      else
        $window="_self";
   
     return do_shortcode('[theme_button type="'.$type.'" button_icon="'.$button_icon.'" link="'.$link.'" window="'.$window.'" css_animation="'.$css_animation.'" el_class="'.$el_class.'" button_bk_color="'.$button_bk_color.'"]'.$prk_in.'[/theme_button]');
  }
  add_shortcode( 'prk_wp_theme_button', 'theme_button_func' );

  vc_map( array(
     "name" => __("Theme Button",'fount'),
     "base" => "prk_wp_theme_button",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-ui-button",
     "description" => __('Buttons with the theme default styling', 'js_composer'),
     "category" => __('Content','fount'),
     //'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
     //'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
     "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Button type", "js_composer"),
            "param_name" => "type",
             "value" => array(
              __('Large Theme Button', "js_composer") => "theme_button large", 
              __('Medium Theme Button', "js_composer") => "theme_button medium",
              __('Small Theme Button', "js_composer") => "theme_button small", 
              __('Tiny Theme Button', "js_composer") => "theme_button tiny",
              __('Large Theme Button - Inverted Colors', "js_composer") => "theme_button_inverted large", 
              __('Medium Theme Button - Inverted Colors', "js_composer") => "theme_button_inverted medium",
              __('Small Theme Button - Inverted Colors', "js_composer") => "theme_button_inverted small", 
              __('Tiny Theme Button - Inverted Colors', "js_composer") => "theme_button_inverted tiny",
            ),
            "description" => ""
        ),
      array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Button up color",'fount'),
           "param_name" => "button_bk_color",
           "value" => "",
           "description" => __("Optional - will override the button up color",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Button text",'fount'),
           "param_name" => "prk_in",
           "value" => __("",'fount'),
           "description" => __("",'fount')
        ),
        array(
          "type" => "iconpicker",
          "heading" => __("Font Awesome icon selector", "js_composer"),
          "param_name" => "button_icon",
          'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
          ),
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Link",'fount'),
           "param_name" => "link",
           "value" => __("",'fount'),
           "description" => __("",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Open link in a new window?", "js_composer"),
            "param_name" => "window",
            "value" => array("No","Yes"),
            "description" => __("", "js_composer",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

    /* Image Gallery ----------------------------------------------------- */
   vc_map( array(
  "name" => __("Image Gallery", "js_composer"),
  "description" => __('Multiple images from Media Library', 'js_composer'),
  "base" => "pirenko_gallery",
  "icon" => "icon-wpb-images-stack",
  "category" => __('Content', 'js_composer'),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => __("Gallery type", "js_composer"),
      "param_name" => "type",
      "value" => array(__("Masonry", "js_composer") => "masonry", __("Grid (rectangles)", "js_composer") => "grid", __("Grid (squares)", "js_composer") => "squares"),
      "description" => __("Select grid type.", "js_composer")
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Columns number",'fount'),
       "param_name" => "cols_number",
       "value" => "0",
       "description" => "Use 0 for variable number"
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Show image title on rollover?", "js_composer"),
      "param_name" => "show_titles",
      "value" => $yes_no_arr,
      "description" => __("Will be shown when mouse is over.", "js_composer")
    ),
    array(
       "type" => "textfield",
       "holder" => "div",
       "class" => "",
       "heading" => __("Thumbnails margin","astro_lang"),
       "param_name" => "thumbs_mg",
       "value" => "",
       "description" => __("Default value is 10","astro_lang")
    ),
    array(
      "type" => "attach_images",
      "heading" => __("Images", "js_composer"),
      "param_name" => "images",
      "value" => "",
      "description" => __("Select images from media library.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __("On click", "js_composer"),
      "param_name" => "onclick",
      "value" => array(
        __("Open lightbox", "js_composer") => "fount_link_image", 
        __("Do nothing", "js_composer") => "fount_no_link"
    ),
      "description" => __("What to do when slide is clicked?", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
  )
) );

    vc_map( array(
  "name" => __("Quick Slider", "js_composer"),
  "base" => "vc_gallery",
  "icon" => "icon-wpb-images-stack",
  "category" => __('Content', 'js_composer'),
  "description" => __('Display images selected directly from library', 'js_composer'),
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __("Widget title", "js_composer"),
      "param_name" => "title",
      "description" => __("What text use as a widget title. Leave blank if no title is needed.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Auto rotate slides", "js_composer"),
      "param_name" => "interval",
      "value" => array(3000,4000,5000,6000,7000,8000,9000,10000,15000, __("Disable", "js_composer") => 0),
      "description" => __("Auto rotate slides each X miliseconds.", "js_composer"),
    ),
    array(
      "type" => "attach_images",
      "heading" => __("Images", "js_composer"),
      "param_name" => "images",
      "value" => "",
      "description" => __("Select images from media library.", "js_composer")
    ),
    array(
      "type" => "textfield",
      "heading" => __("Image size", "js_composer"),
      "param_name" => "img_size",
      "description" => __("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "js_composer")
    ),
    array(
      "type" => "dropdown",
      "heading" => __("On click", "js_composer"),
      "param_name" => "onclick",
      "value" => array(__("Open lightbox", "js_composer") => "link_image", __("Do nothing", "js_composer") => "link_no"),
      "description" => __("What to do when slide is clicked?", "js_composer")
    ),
    array(
      "type" => "exploded_textarea",
      "heading" => __("Custom links", "js_composer"),
      "param_name" => "custom_links",
      "description" => __('Enter links for each slide here. Divide links with linebreaks (Enter).', 'js_composer'),
      "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Custom link target", "js_composer"),
      "param_name" => "custom_links_target",
      "description" => __('Select where to open  custom links.', 'js_composer'),
      "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
      'value' => $target_arr
    ),
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
  )
) );

   //THEME SLIDER
  vc_map( array(
     "name" => __("Theme slider",'fount'),
     "base" => "prk_slider",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-images-stack",
     "category" => __('Content','fount'),
     "description" => __('Display theme slides using Flexslider', 'js_composer'),
     "params" => array(
      array(
           "type" => "checkbox",
           "holder" => "div",
           "class" => "",
           "heading" => __("Groups filter",'fount'),
           "param_name" => "category",
           "value" => $slides_terms_array,
           "description" => __("Optional - leave blank for all",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Autoplay slider?", "js_composer"),
            "param_name" => "autoplay",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Slider delay",'fount'),
           "param_name" => "delay",
           "value" => "",
           "description" => __("In miliseconds - If blank the theme default value will be used",'fount')
        ),
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ) );


  //PRICING TALBES
  function prkwp_price_table_func( $atts ) {
     extract( shortcode_atts( array(
        'prk_in' => '',
        'featured' => '',
        'header' => '',
        'color' => '',
        'price' => '',
        'under_price' => '',
        'button_label' => '',
        'button_link' => '',
        'featured_text' =>'',
        'css_animation' => '',
        'el_class' => ''
     ), $atts ) );
    $lines_output="<ul>";
    $prk_edited = str_replace(", ", "prkwrdoff", $prk_in);
    $arr=explode(",",$prk_edited);
    if (count($arr)>0) 
    {
      foreach ($arr as $single) {
        $lines_output.='<li>'.str_replace("prkwrdoff", ", ",$single).'</li>';
      }
    }
    $lines_output.="</ul>";
     return do_shortcode('[prk_price_table header="'.$featured.'" featured="'.$header.'" el_class="'.$el_class.'" css_animation="'.$css_animation.'" featured_text="'.$featured_text.'" color="'.$color.'" price="'.$price.'" under_price="'.$under_price.'" button_label="'.$button_label.'" button_link="'.$button_link.'"]'.$lines_output.'[/prk_price_table]');
  }
  add_shortcode( 'prkwp_price_table', 'prkwp_price_table_func' );
  
  vc_map( array(
     "name" => __("Pricing table",'fount'),
     "base" => "prkwp_price_table",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-table",
     "description" => __('Informational tables with multiple content fields', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title",'fount'),
           "param_name" => "featured",
           "value" => "",
           "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Header description text",'fount'),
           "param_name" => "header",
           "value" => "",
           "description" => __("Optional - Will be displayed under the title",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Featured text",'fount'),
           "param_name" => "featured_text",
           "value" => "",
           "description" => __("Optional - Will be displayed on a ribbon on the right side",'fount')
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Color",'fount'),
           "param_name" => "color",
           "value" => "",
           "description" => __("Optional - If blank the theme active color will be used",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Price text",'fount'),
           "param_name" => "price",
           "value" => "",
           "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Under price text",'fount'),
           "param_name" => "under_price",
           "value" => "",
           "description" => __("Example: per month",'fount')
        ),
        array(
           "type" => "exploded_textarea",
           "holder" => "div",
           "class" => "",
           "heading" => __("Description text",'fount'),
           "param_name" => "prk_in",
           "value" => "",
           "description" => __("Enter descriptions for this table here. Divide them with linebreaks (Enter).",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Button text",'fount'),
           "param_name" => "button_label",
           "value" => "",
           "description" => __("Leave blank if no button is needed",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Button URL",'fount'),
           "param_name" => "button_link",
           "value" => "",
           "description" => __("Leave blank if no button is needed",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ) );
    
    //LATEST POSTS
    vc_map( array(
     "name" => __("Latest Posts",'fount'),
     "base" => "pirenko_last_posts",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-vc_carousel",
     "description" => __('Show blog entries', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Appearance", "js_composer"),
            "param_name" => "general_style",
            "value" => array(
                __("Classic style - fixed size thumbs and content with transparent background", "js_composer") => "classic", 
                __("Classic style with slider - show all posts in a single row with navigation arrows", "js_composer") => "slider", 
                __("Masonry style - variable size thumbs with a border around each post", "js_composer") => "masonry",
                __("Masonry style with slider - show all posts in a single row with navigation arrows", "js_composer") => "slider_ms"), 
            "description" => ""
          ),
        array(
           "type" => "checkbox",
           "heading" => __("Category filter",'fount'),
           "param_name" => "cat_filter",
           "value" => $posts_terms_array,
           "description" => __("Optional - leave blank for all",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Items number",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => __("Optional - Default is three",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Rows number",'fount'),
           "param_name" => "rows_number",
           "value" => "1",
           "description" => "",
           "dependency" => Array('element' => "general_style", 'value' => 'classic')
        ),
        array(
          "type" => "colorpicker",
          "heading" => __("Background color", "js_composer"),
          "param_name" => "bg_color",
          "description" => __("Optional Select custom background color for each post", "js_composer"),
          "dependency" => Array('element' => "general_style", 'value' => array('masonry','slider_ms'))
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
    ));

  //LATEST PORTFOLIO
  vc_map( array(
     "name" => __("Latest Portfolio",'fount'),
     "base" => "pirenko_last_portfolios",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-layerslider",
     "description" => __('Show portfolio entries', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Layout type?", "js_composer"),
            "param_name" => "layout_type_folio",
            "value" => array(
                __("Grid with horizontal rectangular images", "js_composer") => "grid",
                __("Grid with vertical rectangular images", "js_composer") => "grid_vertical",
                __("Grid with squared images", "js_composer") => "squares", 
                __("Grid without image crop - Masonry", "js_composer") => "masonry"),
            "description" => ""
          ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Columns number",'fount'),
           "param_name" => "cols_number",
           "value" => "3",
           "description" => "Use 0 for variable number"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Items number",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => __("Optional - default value is 9",'fount')
        ),
        array(
           "type" => "checkbox",
           "heading" => __("Skills filter",'fount'),
           "param_name" => "cat_filter",
           "value" => $portfolio_terms_array,
           "description" => __("Optional - leave blank for all",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show filter above thumbnails?", "js_composer"),
            "param_name" => "show_filter",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Thumbnails click behavior?", "js_composer"),
            "param_name" => "thumbs_type_folio",
            "value" => array(__("Show project with an overlay and hide page content", "js_composer") => "overlayed",__("Show project above the thumbnails", "js_composer") => "aboved", __("Open lightbox", "js_composer") => "lightboxed", __("Open project on a different page", "js_composer") => "classiqued"),
            "description" => ""
        ),
        /*array(
            "type" => "dropdown",
            "heading" => __("Make thumbnails black and white?", "js_composer"),
            "param_name" => "grayscale",
            "value" => $no_yes_arr, 
            "description" => "On mouse over the original image will be shown."
        ),*/
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Thumbnails margin",'fount'),
           "param_name" => "thumbs_mg",
           "value" => "",
           "description" => __("Default value is 10",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Multi-colored thumbs on rollover?", "js_composer"),
            "param_name" => "multicolored_thumbs",
            "value" => $yes_no_arr,
            "description" => "If yes the portfolio default color will be applied to each thumb."
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Always show project info?", "js_composer"),
            "param_name" => "titled_portfolio",
            "value" => $no_yes_arr, 
            "description" => "Will be shown under the thumbnail."
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show project information on rollover?", "js_composer"),
            "param_name" => "fount_show_skills",
            "value" => array(__("Title and skills", "js_composer") => "folio_title_and_skills", __("Title only", "js_composer") => "folio_title_only"),
            "description" => "",
            "dependency" => Array('element' => "titled_portfolio", 'value' => array('no'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show icons inside thumbnail?", "js_composer"),
            "param_name" => "icons_display",
            "value" => array(__("Yes, show lightbox and link", "js_composer") => "both_icon", __("No", "js_composer") => "no"),
            "description" => "",
            "dependency" => Array('element' => "titled_portfolio", 'value' => array('no'))
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("View portfolio button text",'fount'),
           "param_name" => "button_label",
           "value" => "",
           "description" => __("Leave blank if no button is needed",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("View portfolio button URL",'fount'),
           "param_name" => "button_url",
           "value" => "",
           "description" => __("Leave blank if no button is needed",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

    //LATEST CUSTOMS POST TYPE
    vc_map( array(
     "name" => __("Latest CPT's",'fount'),
     "base" => "pirenko_last_cpts",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-vc_carousel",
     "description" => __("Show latest entries of Custom Post Types", 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Post type", "js_composer"),
            "param_name" => "cpt",
            "value" => $cpts_array,
            "description" => "Only posts with a featured image will be displayed."
        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Columns number",'fount'),
             "param_name" => "cols_number",
             "value" => "3",
             "description" => "Use 0 for variable number"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Items number",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => __("Optional - Default is three",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("After thumb information?", "js_composer"),
            "param_name" => "thumbs_low_type",
            "value" => array(
                __("Show title and excerpt", "js_composer") => "fount_low_both", 
                __("Show title only", "js_composer") => "fount_low_title",
                __("Don't show anything", "js_composer") => "fount_low_nothing"),
            "description" => "Will be shown under the thumbnail"
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Thumbnails click behavior?", "js_composer"),
            "param_name" => "thumbs_type_folio",
            "value" => array(
                __("Open lightbox with featured image", "js_composer") => "lightboxed", 
                __("Open entry on a different page", "js_composer") => "classiqued"),
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Thumbnails roll over information?", "js_composer"),
            "param_name" => "thumbs_roll_type",
            "value" => array(
                __("Show title and overlay", "js_composer") => "fount_roll_both", 
                __("Show overlay only", "js_composer") => "fount_roll_overlay",
                __("Don't show anything", "js_composer") => "fount_roll_nothing"),
            "description" => ""
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
    ));

     //TEAM MEMBERS
  vc_map( array(
     "name" => __("Team members",'fount'),
     "base" => "prk_members",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-user",
     "description" => __('Display team members info', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Appearance", "js_composer"),
            "param_name" => "general_style",
            "value" => array(
                __("Classic style - show members across multiple rows and columns", "js_composer") => "classic", 
                __("Slider style - show all members in a single row with navigation arrows", "js_composer") => "slider"), 
            "description" => ""
          ),
        array(
           "type" => "checkbox",
           "heading" => __("Team filter",'fount'),
           "param_name" => "category",
           "value" => $member_terms_array,
           "description" => __("Optional - leave blank for all",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Number of members to be displayed",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => __("Optional - If empty all members will be shown",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Number of members per row",'fount'),
           "param_name" => "columns",
           "value" => "3",
           "description" => "",
           "dependency" => Array('element' => "general_style", 'value' => 'classic')
        ),
        array(
          "type" => "dropdown",
          "heading" => __("Text alignment", "js_composer"),
          "param_name" => "text_align",
          "value" => array(__("Center", "js_composer") => "text_center", __("Left", "js_composer") => "text_left",__("Right", "js_composer") => "text_right"),
          "description" => __("", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Member information display", "js_composer"),
            "param_name" => "content_amount",
            "value" => array(
                __("Show excerpt only", "js_composer") => "compressed", 
                __("Show all content", "js_composer") => "everything"), 
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social icons position", "js_composer"),
            "param_name" => "icons_position",
            "value" => array(
                __("Under content", "js_composer") => "under", 
                __("Inside member image", "js_composer") => "inside"), 
            "description" => ""
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

  //TESTIMONIALS
  vc_map( array(
     "name" => __("Testimonials",'fount'),
     "base" => "prk_testimonials",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-testimonials",
     "description" => __('Display Testimonials', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
        array(
           "type" => "checkbox",
           "heading" => __("Testimonials group filter",'fount'),
           "param_name" => "category",
           "value" => $testimonials_terms_array,
           "description" => __("Optional - leave blank for all",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Maximum number of testimonials",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => "Optional - leave blank for all"
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Text color",'fount'),
           "param_name" => "color",
           "value" => "",
           "description" => __("Optional - If blank the theme active color will be used",'fount')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("General alignment", "js_composer"),
            "param_name" => "align",
            "value" => array("Left","Center"),
            "description" => ""
        ),
         array(
            "type" => "dropdown",
            "heading" => __("Display mode?", "js_composer"),
            "param_name" => "layout",
            "value" => array(
                __("Slider", "js_composer") => "testimonials_slider", 
                __("Stacked", "js_composer") => "testimonials_stack",
             ),
            "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show navigation arrows?", "js_composer"),
            "param_name" => "show_controls",
            "value" => $yes_no_arr,
            "description" => "",
            "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Autoplay slider?", "js_composer"),
            "param_name" => "autoplay",
            "value" => $yes_no_arr,
            "description" => "",
            "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Slider delay",'fount'),
           "param_name" => "delay",
           "value" => "",
           "description" => __("In miliseconds - If blank the theme default value will be used",'fount'),
           "dependency" => Array('element' => "layout", 'value' => 'testimonials_slider')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

  //COMMENTS
  vc_map( array(
     "name" => __("Comments",'fount'),
     "base" => "pirenko_comments",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-comments",
     "description" => __('Display comments from users', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title",'fount'),
           "param_name" => "title",
           "value" => "",
           "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Number of comments",'fount'),
           "param_name" => "items_number",
           "value" => "",
           "description" => ""
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

    /* Contact Information ---------------------------------------------------------- */
     vc_map( array(
     "name" => __("Contact Information",'fount'),
     "base" => "pirenko_contact_info",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-vcard",
     "description" => __('Display general contact info', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
        array(
        "type" => "attach_image",
        "heading" => __("Logo Image", "js_composer"),
        "param_name" => "image_path",
        "value" => "",
        "description" => __("Optional", "js_composer")
      ),
        array(
          "type" => "textarea_html",
          "holder" => "div",
          "class" => "messagebox_text",
          "heading" => __("Description (will be displayed above the address (optional)", "js_composer"),
          "param_name" => "content",
          "value" => __("", "js_composer"),
          "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Company Name",'fount'),
           "param_name" => "company_name",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Street Address",'fount'),
           "param_name" => "street_address",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("City",'fount'),
           "param_name" => "locality",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Zipcode",'fount'),
           "param_name" => "postal_code",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Telephone",'fount'),
           "param_name" => "tel",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Fax",'fount'),
           "param_name" => "fax",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Opening hours",'fount'),
           "param_name" => "hours",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Email",'fount'),
           "param_name" => "email",
           "value" => "",
           "description" => "Optional"
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Forced text color",'fount'),
           "param_name" => "text_color",
           "value" => "",
           "description" => __("Optional - If blank the theme default color scheme will be used",'fount')
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));
      
    /* Theme Contact Form ---------------------------------------------------------- */
   vc_map( array(
  "name"    => __("Theme Contact Form", "js_composer"),
  "base"    => "prk_contact_form",
  'icon'    => 'icon-wpb-vc_gravityform',
  "category"  => __('Content', 'js_composer'),
  "description" => __('Regular contact form', 'js_composer'),
  "params" => array(
    array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "admin_label" => true,
           "heading" => __("Receiving email address",'fount'),
           "param_name" => "email_adr",
           "value" => "youremail@somthing.com",
           "description" => "The email that will receive messages through this form."
        ),
    )
) );

 $nets_array = array (
    'None' => 'none',
    'VSCO' => 'vsco',
    'Behance' => 'behance',
    'Delicious' => 'delicious',
    'Deviantart' => 'deviantart',
    'Dribbble' => 'dribbble',
    'Facebook' => 'facebook',
    'Flickr' => 'flickr',
    'Google Plus' => 'gplus',
    'Instagram' => 'instagram-filled',
    'Linkedin' => 'linkedin',
    'Pinterest' => 'pinterest',
    'Soundcloud' => 'soundcloud',
    'Skype' => 'skype',
    'Twitter' => 'twitter',
    'Vimeo' => 'vimeo',
    'Yahoo' => 'yahoo',
     'Youtube' => 'youtube',
     'RSS' => 'rss-1',
     'vCard' => 'book',
);

/* Theme Social Networks Element
---------------------------------------------------------- */
  vc_map( array(
     "name" => __("Social Networks Links",'fount'),
     "base" => "pirenko_social_nets",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-vcard",
     "description" => __('Display links to Social Networks', 'js_composer'),
     "category" => __('Content','fount'),
     "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 1", "js_composer"),
            "param_name" => "net_1",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 1 link", "js_composer"),
          "param_name" => "link_1",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_1", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 2", "js_composer"),
            "param_name" => "net_2",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 2 link", "js_composer"),
          "param_name" => "link_2",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_2", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 3", "js_composer"),
            "param_name" => "net_3",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 3 link", "js_composer"),
          "param_name" => "link_3",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_3", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 4", "js_composer"),
            "param_name" => "net_4",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 4 link", "js_composer"),
          "param_name" => "link_4",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_4", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 5", "js_composer"),
            "param_name" => "net_5",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 5 link", "js_composer"),
          "param_name" => "link_5",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_5", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 6", "js_composer"),
            "param_name" => "net_6",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 6 link", "js_composer"),
          "param_name" => "link_6",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_6", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 7", "js_composer"),
            "param_name" => "net_7",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 7 link", "js_composer"),
          "param_name" => "link_7",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_7", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Social Network 8", "js_composer"),
            "param_name" => "net_8",
            "value" => $nets_array,
            "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Social Network 8 link", "js_composer"),
          "param_name" => "link_8",
          "description" => __("", "js_composer"),
          "dependency" => Array('element' => "net_8", 'value' => array('vsco','behance','soundcloud','delicious','deviantart','dribbble','facebook','flickr','gplus','instagram-filled','linkedin','pinterest','skype','twitter','vimeo','yahoo','youtube','rss-1','book'))
        ),
        $add_css_animation,
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

//TWITTER FEED
/*vc_map( array(
 "name" => __("Twitter feed",'fount'),
 "base" => "prk_twt",
 "class" => "fount_scodes_editor",
 "icon" => "icon-wpb-application-icon-large",
 "description" => __('Customized for the theme', 'js_composer'),
 "category" => __('Theme: Special','fount'),
 "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title",'fount'),
           "param_name" => "title",
           "value" => "",
           "description" => __("Optional - will be shown above the feed",'fount')
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title color",'fount'),
           "param_name" => "title_color",
           "value" => "",
           "description" => __("Optional",'fount'),
           "dependency" => Array('element' => "title", 'not_empty' => true)
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Username",'fount'),
           "param_name" => "username",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Consumer key",'fount'),
           "param_name" => "consumerkey",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Consumer Secret",'fount'),
           "param_name" => "consumersecret",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Access Token",'fount'),
           "param_name" => "accesstoken",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Access Token Secret",'fount'),
           "param_name" => "accesstokensecret",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Cache Tweets in every",'fount'),
           "param_name" => "cachetime",
           "value" => "",
           "description" => __("",'fount')
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Tweets to display",'fount'),
           "param_name" => "tweetstoshow",
           "value" => "",
           "description" => __("",'fount')
        ),                           
    $add_css_animation,
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
 )
));*/

//INSTAGRAM FEED
vc_map( array(
 "name" => esc_html__("Instagram feed",'fount'),
 "base" => "prk_instagram",
 "class" => "verve_scodes_editor",
 "icon" => "icon-wpb-application-icon-large",
 "description" => esc_html__('Customized for the theme', 'js_composer'),
 "category" => esc_html__('Theme: Special','fount'),
 "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_html__("Title",'fount'),
           "param_name" => "title",
           "value" => "",
           "description" => esc_html__("Optional - will be shown above the images",'fount')
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_html__("Title color",'fount'),
           "param_name" => "title_color",
           "value" => "",
           "description" => esc_html__("Optional",'fount'),
           "dependency" => Array('element' => "title", 'not_empty' => true)
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_html__("Username",'fount'),
           "param_name" => "user",
           "value" => "",
           "description" => esc_html__("",'fount')
        ),
        /*array(
           "type" => "dropdown",
           "heading" => esc_html__("Display", "js_composer"),
           "param_name" => "gen_display",
           "value" => array(
                esc_html__("Show images in grid", "js_composer") => "fnt_insta_grid", 
                esc_html__("Show images with a slider", "js_composer") => "fnt_insta_slider",
            ),
           "description" => ""
        ),*/
        array(
           "type" => "dropdown",
           "heading" => esc_html__("Columns number", "js_composer"),
           "param_name" => "items",
           "value" => array(
                esc_html__("One", "js_composer") => "1", 
                esc_html__("Two", "js_composer") => "2",
                esc_html__("Three", "js_composer") => "3",
                esc_html__("Four", "js_composer") => "4",
                esc_html__("Six", "js_composer") => "6"
            ),
           "description" => "",
        ),
        array(
           "type" => "dropdown",
           "heading" => esc_html__("Rows number", "js_composer"),
           "param_name" => "rows",
           "value" => array(
                esc_html__("One", "js_composer") => "1", 
                esc_html__("Two", "js_composer") => "2",
                esc_html__("Three", "js_composer") => "3",
                esc_html__("Four", "js_composer") => "4",
            ),
           "description" => "",
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_html__("Images margin",'fount'),
           "param_name" => "img_margin",
           "value" => "0",
           "description" => esc_html__("",'fount')
        ),
    $add_css_animation,
    array(
      "type" => "textfield",
      "heading" => esc_html__("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    )
 )
));

    /* Sitemap ---------------------------------------------------------- */
  vc_map( array(
     "name" => __("Sitemap",'fount'),
     "base" => "prk_sitemap",
     "class" => "fount_scodes_editor",
     "icon" => "icon-wpb-prk-sitemap",
     "description" => __('Complete sitemap with all post types', 'js_composer'),
     "category" => __('Feeds','fount'),
     "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Show Pages?", "js_composer"),
            "param_name" => "show_pages",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title for Pages",'fount'),
           "param_name" => "txt_pages",
           "value" => "",
           "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show blog categories?", "js_composer"),
            "param_name" => "show_blog_cats",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title for blog categories",'fount'),
           "param_name" => "txt_blog_cats",
           "value" => "",
           "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show blog posts?", "js_composer"),
            "param_name" => "show_posts",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title for blog posts",'fount'),
           "param_name" => "txt_posts",
           "value" => "",
           "description" => ""
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show portfolio posts?", "js_composer"),
            "param_name" => "show_port_posts",
            "value" => $yes_no_arr,
            "description" => ""
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Title for portfolio posts",'fount'),
           "param_name" => "txt_port_posts",
           "value" => "",
           "description" => ""
        ),
        array(
          "type" => "textfield",
          "heading" => __("Extra class name", "js_composer"),
          "param_name" => "el_class",
          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        )
     )
  ));

if (PRK_WOO=="true") {
          //FEATURED PRODUCTS
            vc_map( array(
             "name" => __("Woo Products Slider",'fount'),
             "base" => "prk_woo_featured",
             "class" => "fount_scodes_editor",
             "icon" => "icon-wpb-vc_carousel",
             "description" => __('Show featured products in style', 'js_composer'),
             "category" => __('Feeds','fount'),
             "params" => array(
                    array(
                       "type" => "dropdown",
                       "heading" => __("Order", "js_composer"),
                       "param_name" => "order_by",
                       "value" => array(
                        __("Best selling", "js_composer") => "best_sellers", 
                        __("Date added", "js_composer") => "date",
                        __("Rating", "js_composer") => "rating",
                        __("On sale only", "js_composer") => "sale_only"), 
                       "description" => ""
                   ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Appearance", "js_composer"),
                    "param_name" => "general_style",
                    "value" => array(
                        __("Classic style - show products across multiple rows and columns", "js_composer") => "classic", 
                        __("Slider style - show all products in a single row with navigation arrows", "js_composer") => "slider"), 
                    "description" => ""
                ),
                array(
                   "type" => "textfield",
                   "holder" => "div",
                   "class" => "",
                   "heading" => __("Number of products to be displayed",'fount'),
                   "param_name" => "items_number",
                   "value" => "",
                   "description" => __("Optional - default is 8",'fount')
                ),
                array(
                   "type" => "textfield",
                   "holder" => "div",
                   "class" => "",
                   "heading" => __("Number of columns",'fount'),
                   "param_name" => "columns",
                   "value" => "3",
                   "description" => __("Optional - default is 4",'fount')
                ),
                $add_css_animation,
                array(
                  "type" => "textfield",
                  "heading" => __("Extra class name", "js_composer"),
                  "param_name" => "el_class",
                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
                )
             )
        ));
          //WIDGET PRODUCTS
          vc_map( array(
             "name" => __("Woo Products Widget",'fount'),
             "base" => "prk_woo_widget",
             "class" => "fount_scodes_editor",
             "icon" => "icon-wpb-vc_carousel",
             "description" => __('Show best selling products in style', 'js_composer'),
             "category" => __('Feeds','fount'),
             "params" => array(
                array(
                       "type" => "dropdown",
                       "heading" => __("Order", "js_composer"),
                       "param_name" => "order_by",
                       "value" => array(
                        __("Best selling", "js_composer") => "best_sellers", 
                        __("Date added", "js_composer") => "date",
                        __("Rating", "js_composer") => "rating",
                        __("On sale only", "js_composer") => "sale_only"), 
                       "description" => ""
                ),
                array(
                   "type" => "textfield",
                   "holder" => "div",
                   "class" => "",
                   "heading" => __("Number of products to be displayed",'fount'),
                   "param_name" => "items_number",
                   "value" => "",
                   "description" => __("Optional - default is 3",'fount')
                ),
                $add_css_animation,
                array(
                  "type" => "textfield",
                  "heading" => __("Extra class name", "js_composer"),
                  "param_name" => "el_class",
                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
                )
             )
          ));
    }

}
add_action( 'vc_before_init', 'fount_integrateWithVC' ); 


