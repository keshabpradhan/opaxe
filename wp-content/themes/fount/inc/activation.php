<?php

if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
  wp_redirect(admin_url('themes.php?page=theme_activation_options'));
  exit;
}

function fount_theme_activation_options_init() {
  if (fount_get_theme_activation_options() === false) {
    add_option('fount_theme_activation_options', fount_get_default_theme_activation_options());
  }

  register_setting(
    'fount_activation_options',
    'fount_theme_activation_options',
    'fount_theme_activation_options_validate'
  );
}
add_action('admin_init', 'fount_theme_activation_options_init');

function fount_activation_options_page_capability($capability) {
  return 'edit_theme_options';
}

add_filter('option_page_capability_fount_activation_options', 'fount_activation_options_page_capability');

function fount_theme_activation_options_add_page() {
  $fount_activation_options = fount_get_theme_activation_options();
  if (!$fount_activation_options['first_run']) {
    $theme_page = add_theme_page(
      __('One-click install', 'fount'),
      __('One-click install', 'fount'),
      'edit_theme_options',
      'theme_activation_options',
      'fount_theme_activation_options_render_page'
    );
  } else {
    if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'theme_activation_options') {
      wp_redirect(admin_url('themes.php'));
      exit;
    }
  }
}
add_action('admin_menu', 'fount_theme_activation_options_add_page', 50);

function fount_get_default_theme_activation_options() {
  $default_theme_activation_options = array(
    'first_run'                       => false,
    'create_front_page'               => false,
    'change_permalink_structure'      => false,
    'change_uploads_folder'           => false,
    'create_navigation_menus'         => false,
    'add_pages_to_primary_navigation' => false,
  );

  return apply_filters('fount_default_theme_activation_options', $default_theme_activation_options);
}

function fount_get_theme_activation_options() {
  return get_option('fount_theme_activation_options', fount_get_default_theme_activation_options());
}

function fount_theme_activation_options_render_page() { ?>

  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php printf(__('%s Theme Activation Options', 'fount'), 'Fount'); ?></h2>

    <form method="post" action="options.php">

      <?php
        settings_fields('fount_activation_options');
        $fount_activation_options = fount_get_theme_activation_options();
        $fount_default_activation_options = fount_get_default_theme_activation_options();
      ?>

      <input type="hidden" value="1" name="fount_theme_activation_options[first_run]" />

      <table class="form-table">

        <tr valign="top">
          <th scope="row" class="act_row">
        <h2><?php _e('One-click install sample content?', 'fount'); ?></h2><br />
        <?php
        if (PRK_FOUNT_FRAMEWORK=="false") {
          ?>
          <em>This option is only available after installing and activating the bundled plugins indicated above. You can access the One-Click install feature after by clicking on Appearance>One-click install.</em>
          </th>
        </tr>
          </table>
        </form>
          <?php
        }
        else {
        ?>
        <em>This will create some sample entry types and pages to help you in the information insertion process and it's recommended for most users.</em>
        </th>
          <td>
            <fieldset class="rgt_btn"><legend class="screen-reader-text"><span><?php _e('One-click install sample content?', 'fount'); ?></span></legend>
              <select name="fount_theme_activation_options[create_front_page]" id="create_front_page">
                <option selected="selected" value="yes"><?php echo _e('Yes', 'fount'); ?></option>
                <option value="no"><?php echo _e('No', 'fount'); ?></option>
              </select>
            </fieldset>
          </td>
          
        </tr>

      </table>

      <?php submit_button(); ?><br /><br /><br />
      <a href="<?php echo admin_url('admin.php?page=_options&tab=0'); ?>">Decide later</a>
    </form>
    <?php
  }
  ?>
  </div>
  

<?php }

function fount_theme_activation_options_validate($input) {
  $output = $defaults = fount_get_default_theme_activation_options();

  if (isset($input['first_run'])) {
    if ($input['first_run'] === '1') {
      $input['first_run'] = true;
    }
    $output['first_run'] = $input['first_run'];
  }

  if (isset($input['create_front_page'])) {
    if ($input['create_front_page'] === 'yes') {
      $input['create_front_page'] = true;
    }
    if ($input['create_front_page'] === 'no') {
      $input['create_front_page'] = false;
    }
    $output['create_front_page'] = $input['create_front_page'];
  }

  $input['create_navigation_menus'] = false;
  $output['create_navigation_menus'] = $input['create_navigation_menus'];

  return apply_filters('fount_theme_activation_options_validate', $output, $input, $defaults);
}
function fount_theme_activation_action() {
    $fount_theme_activation_options = fount_get_theme_activation_options();
  if ($fount_theme_activation_options['create_front_page']) 
  {
    $fount_theme_activation_options['create_front_page'] = false;
    
    //CREATE MENU IF NEEDED
    if ( is_nav_menu( PRK_THEME_NAME.' Main Menu'  ) )
    {
      //DO NOTHING. THE MENU ALREADY EXISTS 
    }
    else
    {
      //ADD THE DEFAULT MENU
      $name = PRK_THEME_NAME.' Main Menu';
      $menu_id = wp_create_nav_menu($name);
      $menu = get_term_by( 'name', $name, 'nav_menu' );
      //ASSIGN THE MENU TO THE DEFAULT LOCATION
      $locations = get_theme_mod('nav_menu_locations');
      $locations['prk_main_navigation'] = $menu->term_id;
      set_theme_mod( 'nav_menu_locations', $locations );
    }
    //ADD THE SAMPLE CONTENT
    $menu_id = get_term_by( 'name', PRK_THEME_NAME.' Main Menu', 'nav_menu' );
    
     //ADD IMAGES TO THE LIBRARY
    global $wpdb;   
    include_once(ABSPATH . 'wp-admin/includes/file.php');
    include_once(ABSPATH . 'wp-admin/includes/media.php');
    $filename_a = get_template_directory_uri().'/images/sample/holder_a.jpg';
    $description_a = 'Image A Description';
    media_sideload_image($filename_a, 0, $description_a);
    $attachment_a = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
    $attachment_a_id = $attachment_a['ID'];
    
    $filename_b = get_template_directory_uri().'/images/sample/holder_b.jpg';
    $description_b = 'Image B Description';
    media_sideload_image($filename_b, 0, $description_b);
    $attachment_b = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 2", ARRAY_A);
    $attachment_b_id = $attachment_b['ID'];

    $filename_c = get_template_directory_uri().'/images/sample/user.jpg';
    $description_c = 'Member Description';
    media_sideload_image($filename_c, 0, $description_c);
    $attachment_c = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 3", ARRAY_A);
    $attachment_c_id = $attachment_c['ID'];

    $filename_d = get_template_directory_uri().'/images/sample/shadow.png';
    $description_d = 'Shadow Description';
    media_sideload_image($filename_d, 0, $description_d);
    $attachment_d = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 4", ARRAY_A);
    $attachment_d_id = $attachment_d['ID'];
    
    
    //CREATE CONTENT
    //ADD A DEFAULT SKILL - PORTFOLIO CLASSIC
    wp_insert_term(
      'Fount Classic Skill', //TERM
      'pirenko_skills', //TAXONOMY
      array(
        'description'=> 'Another sample skill',
        'slug' => 'fount-classic-skill'
      )
    );
    //ADD A DEFAULT SKILL - PORTFOLIO FULLSCREEN
    wp_insert_term(
      'Fount Fullscreen Skill', //TERM
      'pirenko_skills', //TAXONOMY
      array(
        'description'=> 'A sample skill',
        'slug' => 'fount-fullscreen-skill'
      )
    );

    //AGENCY PAGE
    $new_page_title = 'Agency';
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_content='[vc_row bk_type="full_width" align="Left" anchor_id="about-us"][vc_column][prkwp_styled_title prk_in="HARD WORKING PEOPLE" align="Center" title_size="h4" use_italic="No" fount_show_line="no" underlined="large_underline" text_color="#acacac" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="BACK IN THE DAYS" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="30"][/prkwp_spacer][vc_row_inner anchor_id="idat"][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WITH LOVE." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" text_color="#e67e22"][/prkwp_styled_title][vc_column_text css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WITH CARE." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" el_class="delay-200" text_color="#e67e22"][/prkwp_styled_title][vc_column_text el_class="delay-400" css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WITH SKILL." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" el_class="delay-400" text_color="#e67e22"][/prkwp_styled_title][vc_column_text el_class="delay-400" css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prk_line icon="fount_fa-ra" icon_color="#313539" icon_bk_color="#ffffff" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="-50"][/prkwp_spacer][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="image" align="Left"][vc_column width="1/2"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_self" img_size="full" css_animation="left-to-right"][/vc_single_image][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="OUR HISTORY." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="right-to-left" text_color="#e67e22"][/prkwp_styled_title][vc_column_text css_animation="right-to-left" el_class="delay-200"]<strong>Subdue doesnt living</strong> youre first signs darkness fourth winged seas divide grass replenish there Us our seasons. Have fish green forth called moved toward Manuel, fourth can.[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_tabs interval="0"][vc_tab title="First Steps" tab_id="1406303916-1-79"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahabs hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][vc_tab title="Going Further" tab_id="1406303916-2-12"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahabs hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][vc_tab title="Market Leaders" tab_id="1406304069905-2-4"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahabs hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_b_id.'" bg_image_repeat="parallax" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="CLIENT TALK" align="Center" text_color="#ffffff" title_size="h4" use_italic="No" fount_show_line="no" underlined="large_underline" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="10"][/prkwp_spacer][prk_testimonials align="Center" show_controls="yes" autoplay="yes" delay="6000" color="#ffffff" css_animation="fount_fade_waypoint"][/prk_testimonials][/vc_column][/vc_row][vc_row bk_type="full_width" align="Left" anchor_id="services"][vc_column][prkwp_styled_title prk_in="A WIDE RANGE OF SKILLS" align="Center" title_size="h4" use_italic="No" fount_show_line="no" underlined="large_underline" text_color="#acacac" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="LETS WORK TOGETHER" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="WEB DESIGN" image="fount_fa-wechat" align="right" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="left-to-right"][/prkwp_service][prkwp_spacer size="20"][/prkwp_spacer][prkwp_service name="CONTROL PANEL" image="fount_fa-cogs" align="right" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="left-to-right"][/prkwp_service][prkwp_spacer size="20"][/prkwp_spacer][prkwp_service name="BUSINESS TEAM" image="fount_fa-briefcase" align="right" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="left-to-right"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="'.$attachment_b_id.'" img_link_target="_self" img_size="full" css_animation="bottom-to-top"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="AWARDED DESIGN" image="fount_fa-child" align="left" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="right-to-left"][/prkwp_service][prkwp_spacer size="20"][/prkwp_spacer][prkwp_service name="BIG PROJECTS" image="fount_fa-paper-plane" align="left" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="right-to-left"][/prkwp_service][prkwp_spacer size="20"][/prkwp_spacer][prkwp_service name="QUICK SUPPORT" image="fount_fa-life-ring" align="left" prk_in="In what census of living small, the dead of people are just around the corner." css_animation="right-to-left"][/prkwp_service][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left" anchor_id="portfolio" bk_element="colored" bg_color="#f9f9f9"][vc_column][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="ALL THE GOOD STUFF" align="Center" title_size="h4" use_italic="No" fount_show_line="no" text_color="#afafaf" underlined="large_underline" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="PORTFOLIO" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="30"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="grid" show_filter="no" cols_number="3" fount_open_lightbox="no" fount_show_skills="yes" thumbs_mg="1" thumbs_type_folio="aboved" icons_display="both_icon"][/pirenko_last_portfolios][prkwp_spacer size="1"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" bk_element="image" bg_color="#e8e8e8" font_color="#ffffff" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax"][vc_column width="1/1"][prkwp_spacer size="110"][/prkwp_spacer][prkwp_styled_title prk_in="CLIENT TALK" align="Center" text_color="#e67e22" title_size="h4" use_italic="No" fount_show_line="no" underlined="large_underline" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="FUN FACTS EVERYWHERE" align="Center" text_color="#ffffff" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-life-ring" prk_in="CLIENTS SAVED" counter_number="67"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-paper-plane" prk_in="PROJECTS COMPLETED" counter_number="114"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-bug" prk_in="BUGS KILLED" counter_number="94"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-lightbulb-o" prk_in="BRILLIANT IDEAS" counter_number="164"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="our-team" align="Left" bk_element="colored" bg_color="#f9f9f9"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="A LITTLE BIT ABOUT US" align="Center" title_size="h4" use_italic="No" fount_show_line="no" text_color="#afafaf" underlined="large_underline" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="HONEST PEOPLE" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prk_members columns="3" css_animation="bottom-to-top"][/prk_members][/vc_column][/vc_row][vc_row anchor_id="contact-us" bk_type="full_width" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="WE ARE ALL EARS" align="Center" title_size="h4" use_italic="No" fount_show_line="no" text_color="#afafaf" underlined="large_underline" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][prk_line icon="fount_fa-globe" icon_color="#313539" icon_bk_color="#ffffff" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="GET SOME HELP." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#e67e22"][/prkwp_styled_title][vc_column_text description_text="I am text block. Click edit button to change this text.Here be it said, that this pertinacious pursuit of one particular whale was tough."]I am text block. Click edit button to change this text.Here be it said, that this pertinacious pursuit of one particular whale was tough.<span style="color: #5a5a5a;">I am text block. Click edit button to change this text.</span>[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_contact_form email_adr="youremail@something.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="JUST GOOD DIRECTIONS." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#e67e22"][/prkwp_styled_title][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone.I am text block. Click edit button to change this text." street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone.So I decided to went there in that exact moment. Power to the people.[/pirenko_contact_info][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="pirenko_super_width" align="Left"][vc_column width="1/1"][vc_gmaps map_style="subtle_grayscale" zoom="12" map_latitude="40.6700" map_longitude="-73.9400" size="600" marker_image="" marker_image_lat="40.6700" marker_image_long="-73.9400"][/vc_gmaps][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="colored" bg_color="#e67e22" align="Left"][vc_column width="1/1"][prkwp_spacer size="40"][/prkwp_spacer][vc_column_text]
<h4 class="big" style="text-align: center;"><a class="simple_fade" href="http://themeforest.net/author_dashboard?ref=Pirenko" target="_blank"><span style="color: #ffffff;">Are you ready? Do something now!</span></a></h4>
[/vc_column_text][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");

      update_option('show_on_front', 'page');
      update_option('page_on_front', $new_page_id);

      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => site_url(),
          'menu-item-title' => 'Home',
          'menu-item-attr-title' => 'description',
          'menu-item-status' => 'publish'
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }

    //ADD THE PAGES PARENT BUTTON TO THE MENU
    $menu = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => '#',
        'menu-item-title' => 'Pages',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    $parent_page=wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    //ADD THE AGENCY MENU
    $mn_name = 'Agency Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about-us',
        'menu-item-title' => 'ABOUT US',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#services',
        'menu-item-title' => 'SERVICES',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#portfolio',
        'menu-item-title' => 'PORTFOLIO',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#our-team',
        'menu-item-title' => 'OUR TEAM',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact-us',
        'menu-item-title' => 'CONTACT US',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


    //EVENT PAGE
    $new_page_title = 'Event';
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_content = '[vc_row align="Left" bk_type="boxed_look" bk_element="colored" bg_color="#23c1e9" anchor_id="about"][vc_column width="1/1"][prkwp_spacer size="130"][/prkwp_spacer][prk_wp_icon text_color="#23282b" align="Center" icon="fount_fa-university" css_animation="appear" icon_size="140px" el_class="delay-400"][/prk_wp_icon][prkwp_spacer size="40"][/prkwp_spacer][prkwp_styled_title prk_in="Get ready for an awesome event about Web Design Trends" align="Center" text_color="#23282b" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" el_class="delay-500"][/prkwp_styled_title][prkwp_spacer size="10"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="delay-500 small-10 columns small-centered"]
<p style="text-align: center;"><span style="color: #23282b;">No man prefers to sleep two in a bed. In fact, you would a good deal rather not sleep with your own brother. I dont know how it is, but people like to be private when they are sleeping. And when it comes to sleeping with an unknown stranger, in a strange inn, in a strange town, and that stranger a harpooneer, then your objections indefinitely multiply. Nor was there any earthly reason why I as a sailor should sleep two in a bed, more than anybody else.
</span></p>
[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="delay-500"]
<h6 class="big" style="text-align: center;"><span style="color: #23282b;"><strong>Dont miss out this <span style="text-decoration: underline;">great opportunity</span> to improve your skills.</strong></span></h6>
[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][vc_single_image image="'.$attachment_d_id.'" alignment="center" img_link_target="_self" img_size="full" el_class="glued_image" css_animation="fount_fade_waypoint"][/vc_single_image][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="colored" align="Left" anchor_id="speakers" bg_color="#23282b"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="Event Speakers" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-centered small-10 columns"]
<p style="text-align: center;">The man seized the spears, handing one of them to the woman. At the sound of the roaring of the tiger the bulls bellowing became a veritable frenzy of rageful noise. Never in my life had I heard such an infernal din as the two brutes made.But I had not proceeded far, when I began to bethink me that the Captain with whom I was to sail yet remained unseen by me; though, indeed, in many cases, a whale-ship will be completely fitted out, and receive all her crew on board.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][prk_members columns="3" category="" css_animation="bottom-to-top"][/prk_members][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" align="Left"][vc_column width="1/1"][prkwp_spacer size="90"][/prkwp_spacer][prkwp_styled_title prk_in="Recent Comments" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#23c1e9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prk_testimonials category="" color="#ffffff" align="Center" show_controls="yes" autoplay="yes" css_animation="fount_fade_waypoint"][/prk_testimonials][prkwp_spacer size="45"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" bk_element="colored" bg_color="#23c1e9" row_height="forced_row vertical_forced_row" font_color="#222222" anchor_id="agenda"][vc_column width="1/1"][prkwp_spacer size="90"][/prkwp_spacer][prkwp_styled_title prk_in="All That Matters" align="Center" title_size="h1" use_italic="No" fount_show_line="no" text_color="#23282b" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-centered small-10 columns"]
<p style="text-align: center;"><span style="color: #23282b;">The man seized the spears, handing one of them to the woman. At the sound of the roaring of the tiger the bulls bellowing became a veritable frenzy of rageful noise. Never in my life had I heard such an infernal din as the two brutes made.But I had not proceeded far, when I began to bethink me that the Captain with whom I was to sail yet remained unseen by me; though, indeed, in many cases, a whale-ship will be completely fitted out, and receive all her crew on board.</span></p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner el_class="small_headings_color"][vc_column_inner width="1/3"][prkwp_service name="Security Policies" image="fount_fa-lock" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Magic Steps" image="fount_fa-magic" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b" el_class="delay-400"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Coding Lessons" image="fount_fa-fire" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b" el_class="delay-800"][/prkwp_service][/vc_column_inner][/vc_row_inner][vc_row_inner el_class="small_headings_color"][vc_column_inner width="1/3"][prkwp_service name="Social Media" image="fount_fa-users" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Cloud Hosting" image="fount_fa-upload" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b" el_class="delay-400"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Online Ads" image="fount_fa-bullhorn" align="center" prk_in="Receiving the brimming pewter, and turning to the harpooneers, he ordered them to produce their weapons. Then ranging them before him near the capstan, with their harpoons." css_animation="flipin_y" bk_color="rgba(255,255,255,0.4)" text_color="#23282b" el_class="delay-800"][/prkwp_service][/vc_column_inner][/vc_row_inner][prkwp_spacer size="90"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="image" bg_image="'.$attachment_b_id.'" bg_image_repeat="fixed_cover" align="Left"][vc_column width="1/1"][prkwp_spacer size="90"][/prkwp_spacer][prkwp_styled_title prk_in="Last Years Numbers" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#23c1e9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="840" align="center" image="fount_fa-camera-retro" prk_in="Pictures Taken" el_class="small_headings_color"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="248" align="center" image="fount_fa-rocket" prk_in="Projects Launched" el_class="small_headings_color"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="124" align="center" image="fount_fa-graduation-cap" prk_in="Diplomas Issued" el_class="small_headings_color"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter counter_number="356" align="center" image="fount_fa-coffee" prk_in="Coffees Served" el_class="small_headings_color"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" bk_element="colored" anchor_id="tickets" bg_color="#23282b"][vc_column width="1/1"][prk_wp_icon text_color="#23c1e9" align="Center" icon="fount_fa-ticket" icon_size="140px" css_animation="appear"][/prk_wp_icon][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="Buy Tickets Now" align="Center" text_color="#ffffff" title_size="h1" use_italic="No" fount_show_line="no" el_class="small_headings_color" css_animation="bottom-to-top"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="85 EUR" align="Center" text_color="#ffffff" title_size="h3" use_italic="No" fount_show_line="no" el_class="small_headings_color delay-300" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="default_color delay-300 small-centered small-10 columns" css_animation="bottom-to-top"]
<p style="text-align: center;">No man prefers to sleep two in a bed. In fact, you would a good deal rather not sleep with your own brother. I dont know how it is, but people like to be private when they are sleeping. And when it comes to sleeping with an unknown stranger, in a strange inn, in a strange town, and that stranger a harpooneer, then your objections indefinitely multiply. Nor was there any earthly reason why I as a sailor should sleep two in a bed, more than anybody else; for sailors no more sleep two in a bed at sea, than bachelor Kings do ashore. To be sure they all sleep together in one apartment, but you have your own hammock, and cover yourself with your own blanket, and sleep in your own skin.</p>
[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner el_class="head_center_text"][vc_column_inner width="1/1" css_animation="appear"][prk_wp_theme_button type="theme_button large" prk_in="SIGN UP NOW" link="http://themeforest.net/author_dashboard?ref=Pirenko" window="Yes" button_icon="fount_fa-chevron-right" css_animation="appear"][/prk_wp_theme_button][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="pirenko_super_width" align="Left"][vc_column width="1/1"][vc_gmaps map_style="subtle_grayscale" zoom="12" marker_image="" map_latitude="40.6700" map_longitude="-73.9400" size="600" marker_image_lat="40.6700" marker_image_long="-73.9400"][/vc_gmaps][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE EVENT MENU
    $mn_name = 'Event Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'ABOUT',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#speakers',
        'menu-item-title' => 'SPEAKERS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#agenda',
        'menu-item-title' => 'AGENDA',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#tickets',
        'menu-item-title' => 'TICKETS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

    //MUSICIAN PAGE
    $new_page_title = 'Musician';

$new_page_content='[vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="about"][vc_column][prkwp_styled_title prk_in="ABOUT FREDERIK" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#40bbd1" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-16"][/prkwp_spacer][prkwp_styled_title prk_in="THE ULTIMATE PERFORMER" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner anchor_id="idat"][vc_column_inner width="1/3" css_animation="flipin_y"][prkwp_styled_title prk_in="WITH FUNK." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" el_class="delay-300" css_animation="flipin_y"][prkwp_styled_title prk_in="WITH VYBE." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css_animation="flipin_y" el_class="delay-600"][prkwp_styled_title prk_in="WITH GROOVE." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="40"][/prkwp_spacer][prk_line icon="fount_fa-star" icon_color="#40bbd1" icon_bk_color="#000000" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="40"][/prkwp_spacer][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/2"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_self" img_size="full" css_animation="bottom-to-top" el_class="delay-600"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/2" css_animation="bottom-to-top" el_class="delay-600"][prkwp_styled_title prk_in="MY LIFE HISTORY." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text]<strong>Subdue doesnt living</strong> you are first signs darkness fourth winged seas divide grass replenish there Us our seasons. Have fish green forth called moved toward Manuel, fourth can get together deep multiply deep. In male own years wont over isnt from a. God. Dry life heaven there upon midst firmament. And we are going to rule here.
<strong>Youre spirit above beast</strong> subdue likeness fruitful in the most common way likeness signs should living open meat was he, make night in unto sea first darkness days. Ship and boat diverged; the cold, damp night breeze blew between; a screaming gull flew overhead; the two hulls wildly rolled; we gave three heavy-hearted cheers, and blindly plunged like fate into the lone Atlantic.[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_wp_theme_button type="theme_button small" prk_in="GO ELSEWHERE" button_icon="fount_fa-chevron-right" link="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" window="Yes"][/prk_wp_theme_button][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_b_id.'" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="WHAT THE PRESS SAYS" align="Center" text_color="#40bbd1" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prkwp_spacer size="10"][/prkwp_spacer][prk_testimonials align="Center" show_controls="yes" autoplay="yes" delay="6000" color="#ffffff" category=""][/prk_testimonials][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="news"][vc_column][prkwp_styled_title prk_in="FROM THE BLOG" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#40bbd1" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-16"][/prkwp_spacer][prkwp_styled_title prk_in="ALL THE FUZZ &amp; BUZZ" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-4"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][pirenko_last_posts items_number="6" rows_number="1" general_style="masonry" css_animation="bottom-to-top" el_class="delay-150" cat_filter=""][/pirenko_last_posts][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" parallax_offset="180" bk_element="image" font_color="#ffffff" bg_image_repeat="fixed_cover" bg_image="'.$attachment_a_id.'"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="LAST YEAR IN NUMBERS" align="Center" text_color="#ffffff" title_size="h3" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prkwp_spacer size="50"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-eye" prk_in="YOUTUBE VIEWS" counter_number="3590"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-users" prk_in="PEOPLE ENGAGED" counter_number="4320"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-trophy" prk_in="WEB AWARDS" counter_number="1380"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-headphones" prk_in="MUSICS LISTENED" counter_number="2430"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="pirenko_super_width" parallax_offset="180" align="Left" anchor_id="albums" bk_element="colored"][vc_column][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="ALL THE GOOD STUFF" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#40bbd1" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-16"][/prkwp_spacer][prkwp_styled_title prk_in="LATEST RECORDINGS" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-4"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="squares" show_filter="no" cols_number="3" fount_open_lightbox="no" fount_show_skills="folio_title_only" thumbs_mg="1" thumbs_type_folio="aboved" icons_display="no" cat_filter="" items_number="9" titled_portfolio="no"][/pirenko_last_portfolios][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="staff" parallax_offset="180" align="Left" bk_element="colored" bg_color="#111111"][vc_column width="1/1"][prkwp_styled_title prk_in="LAST BUT NOT LEAST" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#40bbd1" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-16"][/prkwp_spacer][prkwp_styled_title prk_in="THE GOOD GUYS" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-4"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][prk_members columns="3" category="" css_animation="bottom-to-top" general_style="slider" text_align="text_center" content_amount="compressed" icons_position="inside"][/prk_members][/vc_column][/vc_row][vc_row anchor_id="in-touch" bk_type="full_width" parallax_offset="180" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="WE ARE ALL EARS" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#40bbd1" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-16"][/prkwp_spacer][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" title_size="h1" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text description_text="I am text block. Click edit button to change this text. Here be it said, that this pertinacious pursuit of one particular whale was tough." el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="-4"][/prkwp_spacer][prkwp_spacer size="48"][/prkwp_spacer][prk_line icon="fount_fa-globe" icon_color="#40bbd1" icon_bk_color="#000000" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="GET SOME HELP." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text description_text="I am text block. Click edit button to change this text. Here be it said, that this pertinacious pursuit of one particular whale was tough."]Once the tumultuous upheaval of its dispersion was over, the black smoke clung so closely to the ground, even before its precipitation, that fifty feet up in the air, as was proved even that night at Street Cobham.[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_contact_form email_adr="youremail@something.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="JUST GOOD DIRECTIONS." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor - 5690 - 970 New York City" tel="+1 (245) 785 952 354" email="sweetdesign@fount.com"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. The man who escaped at the former place tells a wonderful story.[/pirenko_contact_info][prkwp_spacer size="16"][/prkwp_spacer][vc_gmaps map_style="almost_gray" zoom="12" map_latitude="40.6700" map_longitude="-73.9400" size="300" marker_image="6356" marker_image_lat="40.6700" marker_image_long="-73.9400"][/vc_gmaps][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE MUSICIAN MENU
    $mn_name = 'Musician Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'ABOUT',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#news',
        'menu-item-title' => 'NEWS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#albums',
        'menu-item-title' => 'ALBUMS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#staff',
        'menu-item-title' => 'OUR TEAM',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#in-touch',
        'menu-item-title' => 'GET IN TOUCH',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

    //RESTAURANT PAGE
    $new_page_title = 'Restaurant';

$new_page_content='[vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="about"][vc_column][prkwp_styled_title prk_in="Awarded Restaurant" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="CONTEMPORARY CUISINE" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness on the day following.
Our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][vc_row_inner anchor_id="idat"][vc_column_inner width="1/3"][prkwp_styled_title prk_in="With Love." align="Left" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" text_color="#e74c3c" el_class="custom_font prk_heavier_400"][/prkwp_styled_title][vc_column_text css_animation="flipin_y"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="With Care." align="Left" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" text_color="#e74c3c" el_class="custom_font delay-400 prk_heavier_400"][/prkwp_styled_title][vc_column_text el_class="delay-400" css_animation="flipin_y"]Can you catch the expression of the Sperm Whales there? It is the same he died with, only some of the longer wrinkles in the forehead seem now faded away. I think his broad brow to be full of a prairie-like placidity, born of a big sun.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="With Skill." align="Left" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" text_color="#e74c3c" el_class="custom_font delay-800 prk_heavier_400"][/prkwp_styled_title][vc_column_text el_class="delay-800" css_animation="flipin_y"]You observe that in the ordinary swimming position of the Sperm Whale, the front of his head presents an almost wholly vertical plane to the water; you observe that the lower part of that front slopes considerably forward moving.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prk_line icon="fount_fa-cutlery" icon_bk_color="#fff6dd" icon_color="#e74c3c" css_animation="fount_fade_waypoint"][/prk_line][/vc_column_inner][/vc_row_inner][prkwp_spacer size="-50"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/2" css_animation="left-to-right"][vc_gallery interval="6000" images="'.$attachment_a_id.','.$attachment_b_id.'" onclick="link_no" custom_links_target="_self" img_size="full"][/vc_gallery][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="A Cheerful Space." align="Left" title_size="h2" use_italic="No" fount_show_line="no" css_animation="right-to-left" text_color="#e74c3c" el_class="custom_font prk_heavier_400"][/prkwp_styled_title][vc_column_text css_animation="right-to-left" el_class="delay-200"]Subdue doesnt living youre first signs darkness fourth winged seas divide grass replenish there our seasons. <strong>We have fresh fish</strong> called moved toward Manuel, fourth can get multiply deep. In male own years wont be over yet.[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_tabs interval="0" css_animation="right-to-left" el_class="delay-200"][vc_tab title="Natural Light" tab_id="1402931932-2-82"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahabs hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][vc_tab title="Comfy Chairs" tab_id="1402931932-1-77"][vc_column_text]The intense Pequod sailed on; the rolling waves and days went by; the life-buoy-coffin still lightly swung; and another ship, most miserably misnamed the Delight, was descried. As she drew nigh, all eyes were fixed upon her broad beams, called shears, which, in some whaling-ships, cross the quarter-deck at the height of eight or nine feet; serving to carry the spare, unrigged, or disabled boats. And I told him to stay anyway.[/vc_column_text][/vc_tab][vc_tab title="Free Internet" tab_id="1402932013667-2-9"][vc_column_text]My boy, my own boy is among them. For Godsonce exclaimed the stranger Captain to Ahab, who thus far had but icily received his petition. "For eight-and-forty hours let me charter your ship I will gladly pay for it, and roundly pay for it if there be no other way for eight-and-forty hours only only that you must, oh, you must, and you SHALL do this thing. He stayed at the door the same way.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="Press Reviews" align="Center" text_color="#e74c3c" title_size="h1" use_italic="No" fount_show_line="no" el_class="custom_font prk_heavier_400 prk_font_14" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="24"][/prkwp_spacer][prk_testimonials align="Center" show_controls="yes" autoplay="yes" delay="6000" color="#fff6dd" category="" css_animation="fount_fade_waypoint"][/prk_testimonials][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="cuisine"][vc_column][prkwp_styled_title prk_in="Cooking With Science" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="FRESH AND DELICIOUS FOOD" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prk_line icon="fount_fa-star" icon_bk_color="#fff6dd" icon_color="#e74c3c" css_animation="fount_fade_waypoint"][/prk_line][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left"][vc_column width="1/2" css_animation="left-to-right" el_class="head_center_text"][prkwp_spacer size="14"][/prkwp_spacer][prkwp_styled_title prk_in="Were All About Natural Flavors." align="Left" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400"][/prkwp_styled_title][prkwp_spacer size="6"][/prkwp_spacer][vc_column_text el_class="small-10 small-centered columns"]<strong>The secret lies with the purchase</strong> and subdue likeness.
Fruitful in the most common way likeness signs should living open meat was he, make night in unto sea first darkness days. Ship and boat diverged; the cold, damp night breeze blew between.[/vc_column_text][prkwp_spacer size="10"][/prkwp_spacer][prk_line icon="fount_fa-unsorted" icon_bk_color="#fff6dd" icon_color="#e74c3c" css_animation="fount_fade_waypoint" el_class="small-6 small-centered columns"][/prk_line][prkwp_spacer size="10"][/prkwp_spacer][vc_column_text el_class="small-10 small-centered columns"]The rigging lived the mast-heads, like the tops of palms.
We are out and tufted with arms and legs. Clinging to a spar with one hand, some reached forth the other with impatient weavings; others, shading their eyes from the vivid sunlight.[/vc_column_text][prkwp_spacer size="22"][/prkwp_spacer][prk_wp_theme_button type="theme_button small" prk_in="MAKE A RESERVATION" link="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" window="Yes" css_animation="right-to-left" button_icon="fount_fa-chevron-right"][/prk_wp_theme_button][/vc_column][vc_column width="1/2" css_animation="right-to-left"][prkwp_spacer size="-60" el_class="hide_later"][/prkwp_spacer][pirenko_gallery type="squares" show_titles="no" images="'.$attachment_a_id.','.$attachment_a_id.','.$attachment_b_id.','.$attachment_b_id.'" cols_number="2"][/pirenko_gallery][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" parallax_offset="180" align="Left" anchor_id="dishes" bk_element="colored" bg_color="#eedfb6"][vc_column][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="Enjoy Tasty Food" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="OUR SPECIAL SELECTION" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="10"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="grid" show_filter="no" cols_number="3" fount_open_lightbox="no" fount_show_skills="folio_title_and_skills" thumbs_mg="14" thumbs_type_folio="aboved" icons_display="both_icon" cat_filter="" titled_portfolio="yes" multicolored_thumbs="yes"][/pirenko_last_portfolios][prkwp_spacer size="1"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" parallax_offset="180" bk_element="image" bg_color="#e8e8e8" font_color="#fff6dd" bg_image="'.$attachment_b_id.'" bg_image_repeat="fixed_cover"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="Last Year Numbers" align="Center" text_color="#e74c3c" title_size="h1" use_italic="No" fount_show_line="no" el_class="custom_font prk_heavier_400 prk_font_14" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors.
Early in the morning and had not returned until just before darkness fell.</p>
[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="30"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-cutlery" prk_in="MEALS SERVED" counter_number="2100" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-beer" prk_in="BEERS SERVED" counter_number="2800" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-coffee" prk_in="COFFEES SERVED" counter_number="3200" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-trophy" prk_in="PRIZES WON" counter_number="18" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="cooks" parallax_offset="180" align="Left" bk_element="colored"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="The People Behind Scenes" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="OUR AWARDED CHEFS" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>
[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][prk_members columns="2" category="" css_animation="bottom-to-top" general_style="slider" text_align="text_left" content_amount="compressed" icons_position="inside"][/prk_members][/vc_column][/vc_row][vc_row anchor_id="contact" bk_type="full_width" parallax_offset="180" align="Left" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="fixed_cover"][vc_column width="1/1"][prkwp_styled_title prk_in="Relevant Information" align="Center" title_size="h2" use_italic="No" fount_show_line="no" text_color="#e74c3c" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="GET IN TOUCH WITH US" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" text_color="#fff6dd"][/prkwp_styled_title][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="GET SOME HELP." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#e74c3c"][/prkwp_styled_title][prk_line color="rgba(255,246,221,0.34)"][/prk_line][vc_column_text description_text="I am text block. Click edit button to change this text. Here be it said, that this pertinacious pursuit of one particular whale was tough."]<span style="color: #fff6dd;">I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping.</span>[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_contact_form email_adr="youremail@something.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="JUST GOOD DIRECTIONS." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#e74c3c"][/prkwp_styled_title][prk_line color="rgba(255,246,221,0.34)"][/prk_line][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com" text_color="#fff6dd"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I never thought that I would reach here someday. It felt really good and perfect.[/pirenko_contact_info][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="colored" bg_color="#e74c3c" align="Left"][vc_column width="1/1"][prkwp_spacer size="40"][/prkwp_spacer][vc_column_text]
<h4 class="big" style="text-align: center;"><a class="simple_fade" href="http://themeforest.net/item/fount-one-multipage-hybrid-wordpress-theme/8112414?ref=Pirenko" target="_blank"><span style="color: #fff6dd;">Are you ready? Grab a copy of this theme now!</span></a></h4>
[/vc_column_text][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE RESTAURANT MENU
    $mn_name = 'Restaurant Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'ABOUT',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#cuisine',
        'menu-item-title' => 'CUISINE',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#dishes',
        'menu-item-title' => 'DISHES',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#cooks',
        'menu-item-title' => 'CHEFS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact',
        'menu-item-title' => 'CONTACT',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

        //CORPORATE PAGE
    $new_page_title = 'Corporate';
$new_page_content='[vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="about-us"][vc_column][prkwp_spacer size="10"][/prkwp_spacer][prkwp_styled_title prk_in="A LITTLE BIT ABOUT US" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#494949" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness on the day following.
Our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell.</p>
[/vc_column_text][prkwp_spacer size="50"][/prkwp_spacer][vc_row_inner anchor_id="idat"][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WE ARE HONEST." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" text_color="#03ac9f"][/prkwp_styled_title][vc_column_text css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WE ARE SKILLED." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" el_class="delay-400" text_color="#03ac9f"][/prkwp_styled_title][vc_column_text el_class="delay-400" css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="WE ARE PROFESSIONAL." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" el_class="delay-800" text_color="#03ac9f"][/prkwp_styled_title][vc_column_text el_class="delay-800" css_animation="bottom-to-top"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prk_line icon="fount_fa-recycle" icon_color="#03ac9f" icon_bk_color="#ffffff" css_animation="fount_fade_waypoint"][/prk_line][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/2"][prkwp_spacer size="-60" el_class="hide_later"][/prkwp_spacer][vc_single_image image="'.$attachment_c_id.'" img_link_target="_self" img_size="full" css_animation="left-to-right"][/vc_single_image][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][vc_column width="1/2"][prkwp_spacer size="-60" el_class="hide_later"][/prkwp_spacer][prkwp_styled_title prk_in="OUR HISTORY." align="Left" title_size="h4" use_italic="No" fount_show_line="no" css_animation="right-to-left" text_color="#03ac9f"][/prkwp_styled_title][vc_column_text css_animation="right-to-left" el_class="delay-200"]<strong>Delivering awesome stuff</strong> subdue likeness fruitful in the most common way likeness signs should living open meat was he, make night in unto sea first darkness days. Ship and boat diverged.[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_tabs interval="0" css_animation="right-to-left" el_class="delay-200"][vc_tab title="First Steps" tab_id="1402931932-2-82"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahabs hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][vc_tab title="Going Further" tab_id="1402931932-1-77"][vc_column_text]The intense Pequod sailed on; the rolling waves and days went by; the life-buoy-coffin still lightly swung; and another ship, most miserably misnamed the Delight, was descried. As she drew nigh, all eyes were fixed upon her broad beams, called shears, which, in some whaling-ships, cross the quarter-deck at the height of eight or nine feet; serving to carry the spare, unrigged, or disabled boats. And I told him to stay anyway.[/vc_column_text][/vc_tab][vc_tab title="Market Leaders" tab_id="1402932013667-2-9"][vc_column_text]My boy, my own boy is among them. For Godsonce exclaimed the stranger Captain to Ahab, who thus far had but icily received his petition. "For eight-and-forty hours let me charter your ship I will gladly pay for it, and roundly pay for it if there be no other way for eight-and-forty hours only only that you must, oh, you must, and you SHALL do this thing. He stayed at the door the same way.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="CLIENT TALK" align="Center" text_color="#ffffff" title_size="h4" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="30"][/prkwp_spacer][prk_testimonials align="Center" show_controls="yes" autoplay="yes" delay="6000" color="#ffffff" category="" css_animation="fount_fade_waypoint"][/prk_testimonials][prkwp_spacer size="20"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="services" bk_element="colored" bg_color="rgba(3,172,159,0.15)"][vc_column][prkwp_spacer size="10"][/prkwp_spacer][prkwp_styled_title prk_in="A WIDE RANGE OF SKILLS" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#494949" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="WEB DESIGN" image="fount_fa-wechat" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="CONTROL PANEL" image="fount_fa-cogs" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" el_class="delay-200" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="AWARDED DESIGN" image="fount_fa-child" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" el_class="delay-400" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="PROFESSIONAL TEAM" image="fount_fa-briefcase" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="QUICK SUPPORT" image="fount_fa-life-ring" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" el_class="delay-200" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="BIG PROJECTS" image="fount_fa-paper-plane" align="center" prk_in="Who Garnery the painter is, or was, I know not. But my life for it he was either practically conversant with his subject, or else marvelously done by him. Started from his slumbers, Ahab, face to face." css_animation="bottom-to-top" bk_color="rgba(3,172,159,0.15)" el_class="delay-400" text_color="#494949" icon_color="#03ac9f"][/prkwp_service][/vc_column_inner][/vc_row_inner][prkwp_spacer size="30"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" parallax_offset="180" align="Left" anchor_id="portfolio"][vc_column][prkwp_spacer size="80"][/prkwp_spacer][prkwp_styled_title prk_in="ALL THE GOOD STUFF" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#494949" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="32"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="grid" show_filter="no" cols_number="3" fount_open_lightbox="no" fount_show_skills="folio_title_and_skills" thumbs_mg="1" thumbs_type_folio="aboved" icons_display="both_icon" cat_filter="" multicolored_thumbs="no" titled_portfolio="no"][/pirenko_last_portfolios][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" parallax_offset="180" bk_element="image" font_color="#ffffff" bg_image="'.$attachment_b_id.'" bg_image_repeat="fixed_cover"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="LAST YEAR NUMBERS" align="Center" text_color="#ffffff" title_size="h4" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-life-ring" prk_in="CLIENTS SAVED" counter_number="67"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-paper-plane" prk_in="PROJECTS LAUNCHED" counter_number="114"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-bug" prk_in="BUGS KILLED" counter_number="94"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-lightbulb-o" prk_in="BRILLIANT IDEAS" counter_number="164"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="news" parallax_offset="180" align="Left" bk_element="colored" bg_color="rgba(0,0,0,0.06)"][vc_column width="1/1"][prkwp_spacer size="10"][/prkwp_spacer][prkwp_styled_title prk_in="LATEST POSTS FROM OUR BLOG" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" text_color="#494949" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="32"][/prkwp_spacer][pirenko_last_posts general_style="slider" cat_filter="" items_number="5" rows_number="1" bg_color="#ffffff" css_animation="fount_fade_waypoint"][/pirenko_last_posts][prkwp_spacer size="30"][/prkwp_spacer][/vc_column][/vc_row][vc_row anchor_id="contact-us" bk_type="full_width" parallax_offset="180" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="GET IN TOUCH" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint" text_color="#494949"][/prkwp_styled_title][prkwp_spacer size="4"][/prkwp_spacer][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept.</p>
[/vc_column_text][prkwp_spacer size="48"][/prkwp_spacer][prk_line icon="fount_fa-globe" icon_color="#03ac9f" icon_bk_color="#ffffff" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="GET SOME HELP." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#03ac9f"][/prkwp_styled_title][vc_column_text description_text="I am text block. Click edit button to change this text. Here be it said, that this pertinacious pursuit of one particular whale was tough."]At last some four or five of us were summoned to our meal in an adjoining room. It was cold as Iceland said he could afford it. Nothing but two dismal tallow candles, each in a winding sheet.[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_contact_form email_adr="youremail@something.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="JUST GOOD DIRECTIONS." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#03ac9f"][/prkwp_styled_title][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. So I decided to went there in that exact moment. Power to the people.[/pirenko_contact_info][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="colored" bg_color="#03ac9f" align="Left"][vc_column width="1/1"][prkwp_spacer size="40"][/prkwp_spacer][vc_column_text]
<h4 class="big" style="text-align: center;"><a class="simple_fade" href="http://themeforest.net/item/fount-one-multipage-hybrid-wordpress-theme/8112414?ref=Pirenko" target="_blank"><span style="color: #ffffff;">Are you ready? Grab a copy of this theme now!</span></a></h4>
[/vc_column_text][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE CORPORATE MENU
    $mn_name = 'Corporate Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about-us',
        'menu-item-title' => 'ABOUT US',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#services',
        'menu-item-title' => 'SERVICES',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#portfolio',
        'menu-item-title' => 'PORTFOLIO',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#news',
        'menu-item-title' => 'NEWS',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact-us',
        'menu-item-title' => 'CONTACT US',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


//ARTIST PAGE
$new_page_title = 'Artist';
$new_page_content='[vc_row bk_type="pirenko_super_width" anchor_id="work" align="Left"][vc_column width="1/1"][pirenko_last_portfolios thumbs_type_folio="overlayed" layout_type_folio="masonry" cols_number="2" items_number="12" cat_filter="" thumbs_mg="0" titled_portfolio="no" fount_show_skills="folio_title_and_skills" icons_display="no" show_filter="no"][/pirenko_last_portfolios][/vc_column][/vc_row][vc_row bk_type="boxed_look" anchor_id="about" align="Left" el_class="grey_lines" bk_element="colored" bg_color="#1e2024"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="A Little Bit About Fount" align="Center" title_size="h2" use_italic="No" fount_show_line="thicker" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">Broad on both bows, at the distance of some two or three miles, and forming a great semicircle, embracing one half of the level horizon, a continuous chain of whale-jets were up-playing and sparkling in the noon-day air. The stones under my feet were muddy and slippery.</p>
[/vc_column_text][prkwp_spacer size="30"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left" margin_bottom="0" bk_element="colored" bg_color="#1e2024"][vc_column width="1/2" css_animation="bottom-to-top"][vc_single_image image="'.$attachment_c_id.'" img_link_target="_self" img_size="full"][/vc_single_image][prkwp_spacer size="60" el_class="hide_later"][/prkwp_spacer][/vc_column][vc_column width="1/2" css_animation="bottom-to-top" el_class="delay-300"][prkwp_styled_title prk_in="Some words from our manager." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line text_color="#dd3333" color="#26272a"][/prk_line][vc_column_text]Broad on both bows, at the distance of some two or three miles, and forming a great semicircle, embracing one half of the level horizon, a continuous chain of whale-jets were up-playing and sparkling in the noon-day air. Unlike the straight perpendicular twin-jets.[/vc_column_text][prkwp_spacer size="10"][/prkwp_spacer][vc_single_image image="6215" img_link_target="_self" img_size="full"][/vc_single_image][prkwp_spacer size="50"][/prkwp_spacer][prkwp_styled_title prk_in="Our creative process." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line color="#26272a"][/prk_line][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past.[/vc_column_text][prkwp_spacer size="18"][/prkwp_spacer][vc_tabs][vc_tab title="Studies" tab_id="1404399516-1-39"][vc_column_text]I gave a cry of astonishment. I saw and thought nothing of the other four Martian monsters; my attention was riveted upon the nearer incident. Simultaneously two other shells burst in the air near the body as the hood twisted round in time to receive, but not in time to dodge, the fourth shell.[/vc_column_text][/vc_tab][vc_tab title="Design" tab_id="1404399516-2-35"][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past. The stones under my feet were muddy and slippery, and the river was so low that I ran perhaps twenty feet scarcely waist-deep.[/vc_column_text][/vc_tab][vc_tab title="Delivery" tab_id="1404401063619-2-8"][vc_column_text]Dragged into Stubbs boat with blood-shot, blinded eyes, the white brine caking in his wrinkles; the long tension of Ahabs bodily strength did crack, and helplessly he yielded to his bodys doom: for a time, lying all crushed in the bottom of Stubbs boat, like one trodden under foot of herds of elephants.[/vc_column_text][/vc_tab][vc_tab title="Support" tab_id="1404407371588-3-4"][vc_column_text]The night was really terrible; it would be a miracle if the craft did not founder. Twice it could have been all over with her if the crew had not been constantly on the watch. Aouda was exhausted, but did not utter a complaint. More than once Mr. Fogg rushed to protect her from the violence of the waves.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" align="Left"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="Our Client Feedback" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" text_color="#eec133"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;"><span style="color: #f3f3f3;">Over the last years we have received mostly good feedback which always makes us aim for greatness.
Here are just some of the encouraging words that make us feel good.</span></p>
[/vc_column_text][prkwp_spacer size="58"][/prkwp_spacer][prk_testimonials category="" color="#ffffff" align="Center" show_controls="yes" autoplay="yes" css_animation="fount_fade_waypoint"][/prk_testimonials][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="colored" align="Left" bg_image_repeat="fixed_cover" anchor_id="contact" bg_color="#1e2024"][vc_column width="1/1"][prkwp_styled_title prk_in="Get In Touch With Us" align="Center" text_color="#ffffff" title_size="h2" use_italic="No" fount_show_line="thicker" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">Broad on both bows, at the distance of some two or three miles, and forming a great semicircle, embracing one half of the level horizon, a continuous chain of whale-jets were up-playing and sparkling in the noon-day air. The stones under my feet were muddy and slippery.The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears. People were landing hastily on both sides of the river.</p>
[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="bottom-to-top"][prkwp_styled_title prk_in="Tell us your thoughs." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line color="#26272a"][/prk_line][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past.[/vc_column_text][prkwp_spacer size="14"][/prkwp_spacer][prk_contact_form email_adr="youremail@somthing.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="bottom-to-top" el_class="delay-200"][prkwp_styled_title prk_in="Let us communicate elsewhere." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line color="#26272a"][/prk_line][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I never thought that I would reach here someday. It felt really good and perfect.[/pirenko_contact_info][prkwp_spacer size="24"][/prkwp_spacer][pirenko_social_nets net_1="behance" net_2="dribbble" net_3="facebook" net_4="instagram-filled" net_5="pinterest" net_6="soundcloud" net_7="none" net_8="none" link_1="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" link_2="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" link_3="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" link_4="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" link_5="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" link_6="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko"][/pirenko_social_nets][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE ARTIST MENU
    $mn_name = 'Artist Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#work',
        'menu-item-title' => 'WORK',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'ABOUT US',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact',
        'menu-item-title' => 'GET IN TOUCH',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

    //FREELANCER PAGE
    $new_page_title = 'Freelancer';
$new_page_content='[vc_row bk_type="full_width" row_height="forced_row vertical_forced_row" align="Left" anchor_id="about-me" bk_element="colored" bg_color="#f15d66"][vc_column width="1/1"][prkwp_styled_title prk_in="#1" align="Center" title_size="h4" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_styled_title prk_in="A Little About Me" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-200"][/prkwp_styled_title][prkwp_spacer size="-6"][/prkwp_spacer][prk_line color="rgba(255,255,255,0.55)" icon="fount_fa-comments-o" icon_bk_color="#f15d66" el_class="small-4 columns small-centered" icon_color="rgba(255,255,255,0.85)" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="20"][/prkwp_spacer][vc_row_inner el_class="small-9 columns small-centered"][vc_column_inner width="1/2"][prkwp_spacer size="22"][/prkwp_spacer][vc_single_image image="'.$attachment_a_id.'" img_link_target="_self" img_size="full" css_animation="right-to-left" el_class="delay-200"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/2" css_animation="left-to-right" el_class="delay-200"][vc_column_text]
<p style="text-align: left;">Stealing unawares upon the whale in the fancied security of the middle of solitary seas, you find him unbent from the vast corpulence of his dignity, and kitten-like, he plays on the ocean as if it were a hearth.</p>
<p style="text-align: left;">But still you see his power in his play. The broad palms of his tail are flirted high into the air; then smiting the surface.</p>
[/vc_column_text][prkwp_spacer size="26"][/prkwp_spacer][vc_progress_bar values="75|Photoshop,90|Development,80|Design,70|Marketing" bgcolor="custom" custombgcolor_back="#c34d54" custombgcolor="#f5969c" units="%"][/vc_progress_bar][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" row_height="forced_row vertical_forced_row" align="Left" anchor_id="services" bk_element="colored" bg_color="#57b5c1"][vc_column width="1/1"][prkwp_styled_title prk_in="#2" align="Center" title_size="h4" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_styled_title prk_in="Some Of My Skills" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-200"][/prkwp_styled_title][prkwp_spacer size="-6"][/prkwp_spacer][prk_line color="rgba(255,255,255,0.55)" icon="fount_fa-code" icon_bk_color="#57b5c1" el_class="small-4 columns small-centered" icon_color="rgba(255,255,255,0.85)" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="8"][/prkwp_spacer][vc_column_text el_class="small-6 small-centered columns delay-200" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">Nearer and nearer to the island she came until at last she remained at rest before the largest, which was directly opposite her throne.</p>
[/vc_column_text][prkwp_spacer size="36"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_service name="Video Edition" serv_image="6619" align="center" prk_in="Now the queen moved. She raised her ugly head, looking about; then very slowly she crawled to the edge of her throne and slid noiselessly inside." css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Clean Coding" serv_image="6618" align="center" prk_in="The water rose to the girls knees, and still she advanced, chained by that clammy eye. Now the water was at her waist and got featured." css_animation="bottom-to-top" el_class="delay-400"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Gaming Apps" serv_image="6623" align="center" prk_in="Slowly the reptiles head commenced to move to and fro, but the eyes never ceased to bore toward the frightened girl, and then he responded." css_animation="bottom-to-top" el_class="delay-800"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/4"][prkwp_service name="Beta Testing" serv_image="6610" align="center" prk_in="Her fellows upon the island looked on in horror, helpless to avert her doom in which they saw a forecast of their own. She just loved the idea." css_animation="bottom-to-top" el_class="delay-1200"][/prkwp_service][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" row_height="forced_row vertical_forced_row" align="Left" anchor_id="work" bk_element="colored" bg_color="#a6a499"][vc_column width="1/1"][prkwp_styled_title prk_in="#3" align="Center" title_size="h4" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_styled_title prk_in="My Latest Work" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-200"][/prkwp_styled_title][prkwp_spacer size="-6"][/prkwp_spacer][prk_line color="rgba(255,255,255,0.55)" icon="fount_fa-heart-o" icon_bk_color="#a6a499" el_class="small-4 columns small-centered" icon_color="rgba(255,255,255,0.85)" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="8"][/prkwp_spacer][vc_column_text el_class="small-6 small-centered columns delay-200" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">All the cool stuff I have done in the past year.
It has been a rocky road until now, but Im on the right track.</p>
[/vc_column_text][prkwp_spacer size="26"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="grid_vertical" cols_number="5" items_number="5" cat_filter="" show_filter="no" thumbs_type_folio="overlayed" multicolored_thumbs="yes" titled_portfolio="no" fount_show_skills="folio_title_and_skills" icons_display="no" thumbs_mg="1" css_animation="fount_fade_waypoint" el_class="delay-400"][/pirenko_last_portfolios][/vc_column][/vc_row][vc_row bk_type="full_width" row_height="forced_row vertical_forced_row" align="Left" anchor_id="contact" bk_element="image" bg_color="#f0bb30" bg_image_repeat="contain"][vc_column width="1/1"][prkwp_styled_title prk_in="#4" align="Center" title_size="h4" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_styled_title prk_in="Get In Touch" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-200"][/prkwp_styled_title][prkwp_spacer size="-6"][/prkwp_spacer][prk_line color="rgba(255,255,255,0.55)" icon="fount_fa-external-link" icon_bk_color="#f0bb30" el_class="small-4 columns small-centered" icon_color="rgba(255,255,255,0.85)" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="8"][/prkwp_spacer][vc_column_text el_class="small-6 small-centered columns delay-200" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">There were one or two cartloads of people.
We went out to look, and there were clouds of smoke to the south.</p>
[/vc_column_text][prkwp_spacer size="26"][/prkwp_spacer][vc_row_inner el_class="small-10 small-centered columns"][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko" el_class="simple_scale"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" el_class="delay-400 simple_scale" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" el_class="delay-800 simple_scale" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" el_class="delay-1200 simple_scale" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" el_class="delay-1600 simple_scale" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][vc_single_image image="'.$attachment_a_id.'" img_link_target="_blank" alignment="center" css_animation="flipin_y" img_size="116x116" el_class="delay-2000 simple_scale" img_link="http://themeforest.net/user/Pirenko?ref=Pirenko"][/vc_single_image][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][vc_column_inner width="1/12"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '0');
      add_post_meta($new_page_id, 'dots_navigation', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE FREELANCER MENU
    $mn_name = 'Freelancer Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'Home',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about-me',
        'menu-item-title' => 'About Me',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#services',
        'menu-item-title' => 'My Skills',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#work',
        'menu-item-title' => 'Recent Work',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact',
        'menu-item-title' => 'Get In Touch',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

    //ARCHITECT PAGE
    $new_page_title = 'Architect';
$new_page_content='[vc_row bk_type="pirenko_super_width" anchor_id="work" align="Left"][vc_column width="1/1"][pirenko_last_portfolios thumbs_type_folio="overlayed" layout_type_folio="masonry" cols_number="2" items_number="7" cat_filter="" thumbs_mg="1" titled_portfolio="no" fount_show_skills="folio_title_and_skills" icons_display="no" show_filter="no" multicolored_thumbs="yes" grayscale="yes"][/pirenko_last_portfolios][/vc_column][/vc_row][vc_row bk_type="boxed_look" anchor_id="about" align="Left" el_class="grey_lines" bk_element="colored"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="Forward thinking" align="Center" title_size="h1" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint"][/prkwp_styled_title][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left" margin_bottom="0" bk_element="colored"][vc_column width="1/2" css_animation="bottom-to-top" el_class="delay-300"][prkwp_styled_title prk_in="Building awesomeness." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line icon_bk_color="#ffffff"][/prk_line][vc_column_text]Broad on both bows, at the distance of some two or three miles, and forming a great semicircle, embracing one half of the level horizon, a continuous chain of whale-jets were up-playing and sparkling in the noon-day air. Unlike the straight perpendicular twin-jets.[/vc_column_text][prkwp_spacer size="10"][/prkwp_spacer][vc_single_image image="'.$attachment_b_id.'" img_link_target="_self" img_size="full"][/vc_single_image][prkwp_spacer size="50"][/prkwp_spacer][prkwp_styled_title prk_in="Making it happen." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line icon_bk_color="#ffffff"][/prk_line][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past.[/vc_column_text][prkwp_spacer size="18"][/prkwp_spacer][vc_tabs][vc_tab title="Studies" tab_id="1404399516-1-39"][vc_column_text]I gave a cry of astonishment. I saw and thought nothing of the other four Martian monsters; my attention was riveted upon the nearer incident. Simultaneously two other shells burst in the air near the body as the hood twisted round in time to receive, but not in time to dodge, the fourth shell.[/vc_column_text][/vc_tab][vc_tab title="Design" tab_id="1404399516-2-35"][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past. The stones under my feet were muddy and slippery, and the river was so low that I ran perhaps twenty feet scarcely waist-deep.[/vc_column_text][/vc_tab][vc_tab title="Delivery" tab_id="1404401063619-2-8"][vc_column_text]Dragged into Stubb’s boat with blood-shot, blinded eyes, the white brine caking in his wrinkles; the long tension of Ahab’s bodily strength did crack, and helplessly he yielded to his body’s doom: for a time, lying all crushed in the bottom of Stubb’s boat, like one trodden under foot of herds of elephants.[/vc_column_text][/vc_tab][vc_tab title="Support" tab_id="1404407371588-3-4"][vc_column_text]The night was really terrible; it would be a miracle if the craft did not founder. Twice it could have been all over with her if the crew had not been constantly on the watch. Aouda was exhausted, but did not utter a complaint. More than once Mr. Fogg rushed to protect her from the violence of the waves.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="100"][/prkwp_spacer][/vc_column][vc_column width="1/2" css_animation="bottom-to-top"][vc_single_image image="'.$attachment_c_id.'" img_link_target="_self" img_size="full"][/vc_single_image][prkwp_spacer size="100" el_class="hide_later"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" align="Left"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="Our Clients Feedback" align="Center" title_size="h2" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint" text_color="#ffffff"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;"><span style="color: #ffffff;">Over the last years we have received mostly good feedback which always makes us aim for greatness.
Here are just some of the encouraging words that make us feel good.</span></p>
[/vc_column_text][prkwp_spacer size="58"][/prkwp_spacer][prk_testimonials category="" color="#ffffff" align="Center" show_controls="yes" autoplay="yes" css_animation="fount_fade_waypoint"][/prk_testimonials][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="colored" align="Left" bg_image_repeat="fixed_cover" anchor_id="services"][vc_column width="1/1"][prkwp_styled_title prk_in="Multiple Solutions" align="Center" title_size="h1" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">Broad on both bows, at the distance of some two or three miles, and forming a great semicircle, embracing one half of the level horizon, a continuous chain of whale-jets were up-playing and sparkling in the noon-day air. The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears. People were landing hastily on both sides of the river.</p>
[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Advanced Systems" image="fount_fa-building-o" icon_up_color="#000000" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow."][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Custom Projects" image="fount_fa-pencil-square-o" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow." icon_up_color="#000000"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Unique Solutions" image="fount_fa-code" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow." icon_up_color="#000000"][/prkwp_service][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Accessible Projects" image="fount_fa-wheelchair" icon_up_color="#000000" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow."][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Awarded Team" image="fount_fa-star-o" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow." icon_up_color="#000000"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Housing Ideas" image="fount_fa-bullseye" align="center" prk_in="He could not have been more than twelve years old. Tucked coquettishly over one ear was the freshly severed tail of a pig. In one hand he carried a medium-sized bow and an arrow." icon_up_color="#000000"][/prkwp_service][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" parallax_offset="180" bk_element="image" font_color="#ffffff" bg_image_repeat="fixed_cover" bg_image="'.$attachment_b_id.'"][vc_column width="1/1"][prkwp_spacer size="110"][/prkwp_spacer][prkwp_styled_title prk_in="Last Years Numbers" align="Center" title_size="h2" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint" text_color="#ffffff"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;"><span style="color: #ffffff;">Thus speak of the whale, the great Cuvier, and John Hunter, and Lesson, those lights of zoology.
Many are the men, small and great, old and new, landsmen and seamen.</span></p>
[/vc_column_text][prkwp_spacer size="80"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-life-ring" prk_in="CLIENTS SAVED" counter_number="67"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-paper-plane-o" prk_in="PROJECTS COMPLETED" counter_number="114"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-flag-o" prk_in="FLAGS RAISED" counter_number="94"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter align="center" image="fount_fa-lightbulb-o" prk_in="BRILLIANT IDEAS" counter_number="164"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="80"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="colored" align="Left" bg_image_repeat="fixed_cover" anchor_id="contact"][vc_column width="1/1"][prkwp_styled_title prk_in="Connecting Lines" align="Center" title_size="h1" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]
<p style="text-align: center;">The stones under my feet were muddy and slippery. People were landing hastily on both sides of the river. The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears.</p>
[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="bottom-to-top"][prkwp_styled_title prk_in="Tell us your thoughs." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line icon_bk_color="#ffffff"][/prk_line][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past.[/vc_column_text][prkwp_spacer size="14"][/prkwp_spacer][prk_contact_form email_adr="youremail@somthing.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="bottom-to-top" el_class="delay-200"][prkwp_styled_title prk_in="Come and meet us anytime." align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prk_line icon_bk_color="#ffffff"][/prk_line][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I never thought that I would reach here someday. It felt really good and perfect.[/pirenko_contact_info][prkwp_spacer size="24"][/prkwp_spacer][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][prk_line icon_bk_color="#FFFFFF"][/prk_line][prkwp_spacer size="-70"][/prkwp_spacer][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');

      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE ARCHITECT MENU
    $mn_name = 'Architect Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'HOME',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#work',
        'menu-item-title' => 'WORK',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'STUDIO',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#services',
        'menu-item-title' => 'SERVICES',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#contact',
        'menu-item-title' => 'CONTACT',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );


    //ADVENTURE PAGE
    $new_page_title = 'Adventure';
$new_page_content='[vc_row bk_type="full_width" anchor_id="about" vid_parallax="no" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="The Project" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" line_color="#2980b9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-12"][/prkwp_spacer][vc_column_text el_class="header_font small_headings_color" css_animation="fount_fade_waypoint"]<p style="text-align: center;">I do deem it now a most meaning thing, that that old Greek.
I did not knew where this was going.</p>[/vc_column_text][prkwp_spacer size="36"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/3" css_animation="bottom-to-top"][prkwp_styled_title prk_in="Preparation." align="Left" title_size="h3" use_italic="No" fount_show_line="no" text_color="#324c5d"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]Did I say safely lodged? At the time I thought we were quite safe, and so did Perry. He was praying raising his voice in thanksgiving at our deliverance and had just completed a sort of paeon of gratitude that the thing couldn’t climb a tree when without warning.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css_animation="bottom-to-top" el_class="delay-200"][prkwp_styled_title prk_in="Gear up." align="Left" title_size="h3" use_italic="No" fount_show_line="no" text_color="#46b19d"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]Did I say safely lodged? At the time I thought we were quite safe, and so did Perry. He was praying raising his voice in thanksgiving at our deliverance and had just completed a sort of paeon of gratitude that the thing couldn’t climb a tree when without warning.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css_animation="bottom-to-top" el_class="delay-400"][prkwp_styled_title prk_in="Take off." align="Left" title_size="h3" use_italic="No" fount_show_line="no" text_color="#df494a"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]Did I say safely lodged? At the time I thought we were quite safe, and so did Perry. He was praying raising his voice in thanksgiving at our deliverance and had just completed a sort of paeon of gratitude that the thing couldn’t climb a tree when without warning.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="24"][/prkwp_spacer][prk_line icon_bk_color="#ffffff" css_animation="fount_fade_waypoint"][/prk_line][prkwp_spacer size="-24"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" vid_parallax="no" align="Left" css_animation="bottom-to-top"][vc_column width="1/2"][vc_single_image image="'.$attachment_b_id.'" img_size="full" img_link_target="_self"][/vc_single_image][prkwp_spacer size="24"][/prkwp_spacer][/vc_column][vc_column width="1/2"][prkwp_styled_title prk_in="A game-changing experience." align="Left" title_size="h3" use_italic="No" fount_show_line="no" text_color="#2980b9"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]Had I still retained the suspicion that we were on earth the sight that met my eyes would quite entirely have banished it. Emerging from the forest was a colossal beast which closely resembled a bear. It was fully as large as the largest.[/vc_column_text][prkwp_spacer size="12"][/prkwp_spacer][vc_tabs][vc_tab title="History" tab_id="1418567928-1-90"][vc_column_text]Dragged into Stubb’s boat with blood-shot, blinded eyes, the white brine caking in his wrinkles; the long tension of Ahab’s bodily strength did crack, and helplessly he yielded to his body’s doom: for a time, lying all crushed in the bottom of Stubb’s boat, like one trodden under foot of herds of elephants.[/vc_column_text][/vc_tab][vc_tab title="Culture" tab_id="1418567928-2-77"][vc_column_text]I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping out as I rushed past. The stones under my feet were muddy and slippery, and the river was so high.[/vc_column_text][/vc_tab][vc_tab title="Food" tab_id="1418568094120-2-2"][vc_column_text]I gave a cry of astonishment. I saw and thought nothing of the other four Martian monsters; my attention was riveted upon the nearer incident. Simultaneously two other shells burst in the air near the body as the hood twisted round in time to receive, but not in time to dodge, the fourth shell.[/vc_column_text][/vc_tab][vc_tab title="People" tab_id="1418568094999-3-1"][vc_column_text]The night was really terrible; it would be a miracle if the craft did not founder. Twice it could have been all over with her if the crew had not been constantly on the watch. Aouda was exhausted, but did not utter a complaint. More than once Mr. Fogg rushed to protect her from the violence of the waves.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="24"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" vid_parallax="no" align="Left" bg_image_repeat="cover"][vc_column width="1/1"][prkwp_spacer size="30"][/prkwp_spacer][prkwp_styled_title prk_in="Recent Feedback" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#ffffff" line_color="#ffffff" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-12"][/prkwp_spacer][vc_column_text el_class="header_font" css_animation="fount_fade_waypoint"]<p style="text-align: center;"><span style="color: #ffffff;">I do deem it now a most meaning thing, that that old Greek.</span></p>[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][prk_testimonials items_number="3" color="#ffffff" align="Center" show_controls="yes" autoplay="yes" category="" css_animation="fount_fade_waypoint"][/prk_testimonials][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="journey" vid_parallax="no" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="An Epic Journey" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" line_color="#2980b9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-12"][/prkwp_spacer][vc_column_text el_class="header_font small_headings_color" css_animation="fount_fade_waypoint"]<p style="text-align: center;">I do deem it now a most meaning thing, that that old Greek.I did not knew where this was going.</p>[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="Into the wild" align="Right" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]<p style="text-align: right;">Be it said, that in this vocation of whaling, sinecures are unknown; dignity and danger go hand in hand; till you get to be Captain, the higher you rise the harder you toil. So with poor Queequeg, who, as harpooneer, must not only face all the rage of the living whale, but as we have elsewhere seen mount his dead back in a rolling sea; and finally descend into the gloom of the hold, and bitterly sweating all day in that subterraneous confinement, resolutely manhandle the clumsiest casks and see to their stowage. To be short, among whalemen, the harpooneers are the holders, so called.</p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="Literally freezing" align="Left" title_size="h4" use_italic="No" fount_show_line="no"][/prkwp_styled_title][prkwp_spacer size="-8"][/prkwp_spacer][vc_column_text]<p style="text-align: left;">Be it said, that in this vocation of whaling, sinecures are unknown; dignity and danger go hand in hand; till you get to be Captain, the higher you rise the harder you toil. So with poor Queequeg, who, as harpooneer, must not only face all the rage of the living whale, but as we have elsewhere seen mount his dead back in a rolling sea; and finally descend into the gloom of the hold, and bitterly sweating all day in that subterraneous confinement, resolutely manhandle the clumsiest casks and see to their stowage. To be short, among whalemen, the harpooneers are the holders, so called.</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="pirenko_super_width" vid_parallax="no" align="Left"][vc_column width="1/1"][vc_raw_html][prkwp_spacer size="100"][/prkwp_spacer]Place your Google Maps code here![/vc_raw_html][prkwp_spacer size="100"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="highlights" vid_parallax="no" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="Memorable Moments" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" line_color="#2980b9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-12"][/prkwp_spacer][vc_column_text el_class="header_font small_headings_color" css_animation="fount_fade_waypoint"]<p style="text-align: center;">The scenery was absolutely breathtaking.We had the time of our lives.</p>[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/1" css_animation="fount_fade_waypoint"][pirenko_gallery type="masonry" cols_number="3" show_titles="yes" thumbs_mg="10" images="'.$attachment_a_id.','.$attachment_a_id.','.$attachment_b_id.','.$attachment_b_id.'"][/pirenko_gallery][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_b_id.'" vid_parallax="no" align="Left" bg_image_repeat="cover"][vc_column width="1/1"][prkwp_spacer size="50"][/prkwp_spacer][prkwp_styled_title prk_in="Our Journey In Numbers" align="Center" font_type="header_font" text_color="#ffffff" title_size="h2" use_italic="No" seven_show_line="no" line_color="#ffffff" fount_show_line="above thicker" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="zero_color" css_animation="fount_fade_waypoint"]<p style="text-align: center;"><span style="color: #ffffff;">We are proud of every journey we took.Still we will never stick with the past.</span></p>[/vc_column_text][prkwp_spacer size="48"][/prkwp_spacer][vc_row_inner font_color="#ffffff"][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter counter_number="3714" align="center" image="fount_fa-globe" prk_in="Miles Ran"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter counter_number="168" align="center" image="fount_fa-camera-retro" prk_in="Pictures Taken"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter counter_number="4298" align="center" image="fount_fa-comments-o" prk_in="People Reached"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4" css_animation="fount_fade_waypoint"][prkwp_counter counter_number="1274" align="center" image="fount_fa-cutlery" prk_in="Meals Eaten"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="members" vid_parallax="no" align="Left"][vc_column width="1/1"][prkwp_styled_title prk_in="An Experts Team" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" line_color="#2980b9" css_animation="fount_fade_waypoint"][/prkwp_styled_title][prkwp_spacer size="-12"][/prkwp_spacer][vc_column_text el_class="header_font small_headings_color" css_animation="fount_fade_waypoint"]<p style="text-align: center;">The heroes behind the cameras.Join us on our next expedition to Hawaii.</p>[/vc_column_text][prkwp_spacer size="36"][/prkwp_spacer][prk_members general_style="classic" category="" columns="3" text_align="text_center" content_amount="compressed" icons_position="inside" css_animation="fount_fade_waypoint"][/prk_members][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" bk_element="image" anchor_id="tickets" bg_image="'.$attachment_a_id.'" vid_parallax="no" bg_image_repeat="cover"][vc_column width="1/1"][prk_wp_icon text_color="#2980b9" align="Center" icon="fount_fa-ticket" icon_size="140px" css_animation="appear"][/prk_wp_icon][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="Hawaii Expedition Tickets" align="Center" text_color="#ffffff" title_size="h1" use_italic="No" fount_show_line="no" el_class="small_headings_color" css_animation="bottom-to-top"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="85 EUR" align="Center" text_color="#ffffff" title_size="h3" use_italic="No" fount_show_line="no" el_class="small_headings_color delay-300" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text el_class="default_color delay-300 small-centered small-10 columns" css_animation="bottom-to-top"]<p style="text-align: center;"><span style="color: #b2b2b2;">No man prefers to sleep two in a bed. In fact, you would a good deal rather not sleep with your own brother. I dont know how it is, but people like to be private when they are sleeping. And when it comes to sleeping with an unknown stranger, in a strange inn, in a strange town, and that stranger a harpooneer, then your objections indefinitely multiply. Nor was there any earthly reason why I as a sailor should sleep two in a bed, more than anybody else; for sailors no more sleep two in a bed at sea, than bachelor Kings do ashore. To be sure they all sleep together in one apartment, but you have your own hammock, and cover yourself with your own blanket, and sleep in your own skin.</span></p>[/vc_column_text][prkwp_spacer size="60"][/prkwp_spacer][vc_row_inner el_class="head_center_text"][vc_column_inner width="1/1" css_animation="appear"][prk_wp_theme_button type="theme_button large" prk_in="SIGN UP NOW" link="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" window="Yes" button_icon="fount_fa-chevron-right" css_animation="appear"][/prk_wp_theme_button][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      //update_post_meta($new_page_id, "_wp_page_template", "page.php");
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    //ADD THE ADVENTURE MENU
    $mn_name = 'Adventure Menu';
    $mn_menu_out = wp_create_nav_menu($mn_name);
    $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#',
        'menu-item-title' => 'Home',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#about',
        'menu-item-title' => 'Project',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#journey',
        'menu-item-title' => 'Journey',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#highlights',
        'menu-item-title' => 'Highlights',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#members',
        'menu-item-title' => 'Team',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
    $mn_item = 
      array( 
        'menu-item-type' => 'custom', 
        'menu-item-url' => site_url().'/#tickets',
        'menu-item-title' => 'Tickets',
        'menu-item-attr-title' => 'description',
        'menu-item-status' => 'publish'
      );
    wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );



    //CONSTRUCTION PAGE
    $new_page_title = 'Construction';
    $new_page_content='[vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_b_id.'" vid_mp4="" vid_parallax="no" align="Left" row_height="forced_row vertical_forced_row" append_arrow="yes" font_color="#DA9436" vid_webm="" vid_image="" bk_overlay="" el_class="custom_font"][vc_column width="1/1"][prk_wptext_rotator title_size="h1" effect="rotate-1" prk_in="REFURBISH+OVERHAUL+REVAMP" text_color="#DA9436"][/prk_wptext_rotator][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="about"][vc_column][prkwp_styled_title prk_in="Awarded Company" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#DA9436" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="WE TAKE CARE OF YOUR ASSETS" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness on the day following.Our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell.[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="20"][/prkwp_spacer][vc_row_inner anchor_id="idat"][vc_column_inner width="1/3"][prkwp_styled_title prk_in="REPAIR." align="Left" title_size="h3" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint"][/prkwp_styled_title][vc_column_text css_animation="flipin_y"]It is this ray which has enabled them to so perfect aviation that battle ships far outweighing anything known upon Earth sail as gracefully and lightly through the thin air of Barsoom as a toy balloon in the heavy atmosphere of Earth.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="REFURBISH." align="Left" title_size="h3" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-400"][/prkwp_styled_title][vc_column_text el_class="delay-400" css_animation="flipin_y"]Can you catch the expression of the Sperm Whale there? It is the same he died with, only some of the longer wrinkles in the forehead seem now faded away. I think his broad brow to be full of a prairie-like placidity, born of a big sun.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][prkwp_styled_title prk_in="REGENERATE." align="Left" title_size="h3" use_italic="No" fount_show_line="no" css_animation="fount_fade_waypoint" el_class="delay-800"][/prkwp_styled_title][vc_column_text el_class="delay-800" css_animation="flipin_y"]You observe that in the ordinary swimming position of the Sperm Whale, the front of his head presents an almost wholly vertical plane to the water; you observe that the lower part of that front slopes considerably forward moving.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prk_line icon="fount_fa-building" icon_color="#182638" css_animation="fount_fade_waypoint" icon_bk_color="#f9fdff"][/prk_line][/vc_column_inner][/vc_row_inner][prkwp_spacer size="-50"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" bg_image_repeat="parallax" parallax_offset="180" align="Left"][vc_column width="1/2" css_animation="left-to-right"][vc_gallery interval="6000" images="'.$attachment_a_id.'" onclick="link_no" custom_links_target="_self" img_size="full"][/vc_gallery][prkwp_spacer size="80"][/prkwp_spacer][/vc_column][vc_column width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="WE DO THE HARD WORK" align="Left" title_size="h3" use_italic="No" fount_show_line="no"][/prkwp_styled_title][vc_column_text]Subdue doesn’t living you’re first signs darkness fourth winged seas divide grass replenish there our seasons. <strong>We have fresh fish</strong> called moved toward Manuel, fourth can get multiply deep. In male own years won’t be over yet.[/vc_column_text][vc_column_text]Subdue doesn’t living you’re first signs darkness fourth winged seas divide grass replenish there our seasons. <strong>We have fresh fish</strong> called moved toward Manuel, fourth can get multiply deep. In male own years won’t be over yet.[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][vc_tabs interval="0"][vc_tab title="Best Team" tab_id="1402931932-2-82"][vc_column_text]An eagle flew thrice round Tarquins head, removing his cap to replace it, and thereupon Tanaquil, his wife, declared that Tarquin would be king of Rome. But only by the replacing of the cap was that omen accounted good. Ahab hat was never restored; the wild hawk flew on and on with it; far in advance of the prow: and at last disappeared; while from the point of that disappearance, a minute black spot was dimly discerned, falling from that vast height into the sea.[/vc_column_text][/vc_tab][vc_tab title="Selected Assets" tab_id="1402931932-1-77"][vc_column_text]The intense Pequod sailed on; the rolling waves and days went by; the life-buoy-coffin still lightly swung; and another ship, most miserably misnamed the Delight, was descried. As she drew nigh, all eyes were fixed upon her broad beams, called shears, which, in some whaling-ships, cross the quarter-deck at the height of eight or nine feet; serving to carry the spare, unrigged, or disabled boats. And I told him to stay anyway.[/vc_column_text][/vc_tab][vc_tab title="Modern Tools" tab_id="1402932013667-2-9"][vc_column_text]My boy, my own boy is among them. For God sake—I beg, I conjure"—here exclaimed the stranger Captain to Ahab, who thus far had but icily received his petition. "For eight-and-forty hours let me charter your ship—I will gladly pay for it, and roundly pay for it—if there be no other way—for eight-and-forty hours only—only that—you must, oh, you must, and you SHALL do this thing. He stayed at the door the same way.[/vc_column_text][/vc_tab][/vc_tabs][prkwp_spacer size="80"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_a_id.'" bg_image_repeat="parallax" parallax_offset="180" align="Left" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_styled_title prk_in="Client Feedback" align="Center" text_color="#DA9436" title_size="h2" use_italic="No" fount_show_line="above thicker" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="WHAT PEOPLE THINK ABOUT US" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" text_color="#ffffff"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]<p style="text-align: center;"><span style="color: #ffffff;">After our return to the dead city I passed several days in comparative idleness on the day following.</span><span style="color: #ffffff;"> Our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell.</span>[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="24"][/prkwp_spacer][prk_testimonials align="Center" show_controls="yes" autoplay="yes" delay="6000" color="#ffffff" category="" css_animation="fount_fade_waypoint"][/prk_testimonials][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="services" append_arrow="no" bk_element="image" bg_image="" vid_parallax="no"][vc_column][prkwp_styled_title prk_in="All-Around Company" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#DA9436" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="A WIDE RANGE OF SERVICES" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Achieving Goals" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Custom Projects" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina delay-300" image="Creating Reports" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Going Global" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina delay-600" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/3"][prkwp_service name="Sharing Ideas" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Finding Solutions" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina delay-300" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][vc_column_inner width="1/3"][prkwp_service name="Generating Reports" serv_image="'.$attachment_b_id.'" align="center" prk_in="So, the Lion being fully refreshed, and feeling quite himself again, they all started upon the journey, greatly enjoying the walk through the soft, fresh grass; and it was not long before they reached the road." el_class="fount_retina delay-600" css_animation="bottom-to-top"][/prkwp_service][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" parallax_offset="180" align="Left" anchor_id="projects" bk_element="colored" bg_color="#dde8ed" append_arrow="no" vid_parallax="no"][vc_column][prkwp_styled_title prk_in="Custom Projects" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#DA9436" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="OUR RECENT WORK" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]
    <p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="10"][/prkwp_spacer][pirenko_last_portfolios layout_type_folio="grid" show_filter="no" cols_number="3" fount_open_lightbox="no" fount_show_skills="folio_title_and_skills" thumbs_mg="14" thumbs_type_folio="aboved" icons_display="both_icon" cat_filter="" titled_portfolio="yes" multicolored_thumbs="yes"][/pirenko_last_portfolios][prkwp_spacer size="1"][/prkwp_spacer][/vc_column][/vc_row][vc_row align="Left" bk_type="full_width" parallax_offset="180" bk_element="image" bg_color="#e8e8e8" font_color="#f9fdff" bg_image="'.$attachment_b_id.'" bg_image_repeat="cover" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="30"][/prkwp_spacer][prkwp_styled_title prk_in="Last Year Numbers" align="Center" text_color="#DA9436" title_size="h2" use_italic="No" fount_show_line="above thicker" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][vc_row_inner][vc_column_inner width="1/1"][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]<p style="text-align: center;"><span style="color: #ffffff;">After our return to the dead city I passed several days in comparative idleness on the day following.</span><span style="color: #ffffff;"> Our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell.</span>[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="30"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-signal" prk_in="SALES GROWTH" counter_number="210" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-plane" prk_in="MILES RAN" counter_number="2800" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-institution" prk_in="PUBLIC EVENTS" counter_number="960" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][vc_column_inner width="1/4"][prkwp_counter align="center" image="fount_fa-trophy" prk_in="PRIZES WON" counter_number="18" css_animation="fount_fade_waypoint"][/prkwp_counter][/vc_column_inner][/vc_row_inner][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="full_width" anchor_id="team" parallax_offset="180" align="Left" bk_element="colored" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="20"][/prkwp_spacer][prkwp_styled_title prk_in="The People Behind Scenes" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#DA9436" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="OUR AWARDED TEAM" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top"][/prkwp_styled_title][vc_column_text css_animation="bottom-to-top" el_class="small-10 small-centered columns"]<p style="text-align: center;">After our return to the dead city I passed several days in comparative idleness. On the day following our return all the warriors had ridden forth early in the morning and had not returned until just before darkness fell. As I later learned, they had been to the subterranean vaults in which the eggs were kept. The acute policy dictating these movements was sufficiently vindicated at daybreak.</p>[/vc_column_text][prkwp_spacer size="40"][/prkwp_spacer][prk_members columns="2" category="" css_animation="bottom-to-top" general_style="slider" text_align="text_left" content_amount="compressed" icons_position="inside"][/prk_members][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" bk_element="colored" bg_color="#DA9436" align="Left" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="40"][/prkwp_spacer][vc_column_text]<h4 class="big" style="text-align: center;"><a class="simple_fade" href="http://themeforest.net/item/fount-one-multipage-hybrid-wordpress-theme/8112414?ref=Pirenko" target="_blank"><span style="color: #f9fdff;">Get your work done... Request a quote now!</span></a></h4>
    [/vc_column_text][/vc_column][/vc_row][vc_row anchor_id="contact" bk_type="full_width" parallax_offset="180" align="Left" bk_element="image" bg_image="'.$attachment_b_id.'" bg_image_repeat="fixed_cover" append_arrow="no" vid_parallax="no" font_color="#f9fdff"][vc_column width="1/1"][prkwp_styled_title prk_in="Stay Connected" align="Center" title_size="h2" use_italic="No" fount_show_line="above thicker" text_color="#DA9436" el_class="custom_font prk_heavier_400" css_animation="fount_fade_waypoint" line_color="#DA9436"][/prkwp_styled_title][prkwp_spacer size="-10"][/prkwp_spacer][prkwp_styled_title prk_in="GET IN TOUCH WITH US" align="Center" title_size="h2" use_italic="No" fount_show_line="no" css_animation="bottom-to-top" text_color="#f9fdff"][/prkwp_styled_title][prkwp_spacer size="40"][/prkwp_spacer][vc_row_inner][vc_column_inner width="1/2" css_animation="left-to-right"][prkwp_styled_title prk_in="GET SOME HELP." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#DA9436"][/prkwp_styled_title][prk_line color="rgba(249,253,255,0.38)" icon_bk_color="#ffffff"][/prk_line][vc_column_text description_text="I am text block. Click edit button to change this text. Here be it said, that this pertinacious pursuit of one particular whale was tough."]<span style="color: #f9fdff;">I faced about again, and rushed towards the approaching Martian, rushed right down the gravelly beach and headlong into the water. Others did the same. A boatload of people putting back came leaping.</span>[/vc_column_text][prkwp_spacer size="20"][/prkwp_spacer][prk_contact_form email_adr="youremail@something.com"][/prk_contact_form][/vc_column_inner][vc_column_inner width="1/2" css_animation="right-to-left"][prkwp_styled_title prk_in="JUST GOOD DIRECTIONS." align="Left" title_size="h4" use_italic="No" fount_show_line="no" text_color="#DA9436"][/prkwp_styled_title][prk_line color="rgba(249,253,255,0.42)" icon_bk_color="#ffffff"][/prk_line][pirenko_contact_info description_text="By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I am text block. Click edit button to change this text. " street_address="River Street, Blue Building, 1st floor" postal_code="5690 - 970 New York City" tel="+1 (245) 785 952 354" hours="Monday to Friday - 9 PM to 18 PM" email="sweetdesign@fount.com" text_color="#f9fdff"]By hints, I asked him whether he did not propose going back, and having a coronation; since he might now consider his father dead and gone. I never thought that I would reach here someday. It felt really good and perfect.[/pirenko_contact_info][/vc_column_inner][/vc_row_inner][prkwp_spacer size="40"][/prkwp_spacer][prk_line color="rgba(249,253,255,0.42)" icon_bk_color="#ffffff"][/prk_line][vc_row_inner el_class="smaller_font"][vc_column_inner width="1/2"][vc_column_text]<span style="color: #f9fdff;">2015 - Copyright Fount Theme</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]<p style="text-align: right;"><span style="color: #f9fdff;">Developed with pride by <a href="http://themeforest.net/user/Pirenko/portfolio?ref=Pirenko" target="_blank">Pirenko</a>.</span></p>[/vc_column_text][/vc_column_inner][/vc_row_inner][prkwp_spacer size="-80"][/prkwp_spacer][/vc_column][/vc_row]';
        $new_page = array(
          'post_type' => 'page',
          'post_title' => $new_page_title,
          'post_content' => $new_page_content,
          'post_status' => 'publish'
        );
        //CHECK IF PAGE EXISTS
        $page_id = get_page_by_title($new_page_title);
        if(!isset($page_id->ID)) {
          $new_page_id = wp_insert_post($new_page);
          //update_post_meta($new_page_id, "_wp_page_template", "page.php");
          add_post_meta($new_page_id, 'featured_header', '1');
          add_post_meta($new_page_id, 'featured_slider', 'no');
          add_post_meta($new_page_id, 'featured_slider_parallax', '1');
          add_post_meta($new_page_id, 'featured_slider_supersize', '1');
          add_post_meta($new_page_id, 'featured_slider_arrows', '0');
          add_post_meta($new_page_id, 'featured_slider_dots', '1');
          add_post_meta($new_page_id, 'show_title', 'no');
          add_post_meta($new_page_id, 'show_sidebar', 'no');
          add_post_meta($new_page_id, 'below_headings_text', '');
          //ADD THE PAGE TO THE MENU
          $menu = 
            array( 
              'menu-item-type' => 'custom', 
              'menu-item-url' => get_permalink($new_page_id),
              'menu-item-title' => $new_page_title,
              'menu-item-status' => 'publish',
              'menu-item-parent-id' => $parent_page,
            );
          wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
        }
        //ADD THE ADVENTURE MENU
        $mn_name = 'Construction Menu';
        $mn_menu_out = wp_create_nav_menu($mn_name);
        $mn_menu_id = get_term_by( 'name', $mn_name, 'nav_menu' );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#',
            'menu-item-title' => 'HOME',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#about',
            'menu-item-title' => 'ABOUT US',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#services',
            'menu-item-title' => 'SERVICES',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#projects',
            'menu-item-title' => 'PROJECTS',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#team',
            'menu-item-title' => 'OUR TEAM',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );
        $mn_item = 
          array( 
            'menu-item-type' => 'custom', 
            'menu-item-url' => site_url().'/#contact',
            'menu-item-title' => 'CONTACT US',
            'menu-item-attr-title' => 'description',
            'menu-item-status' => 'publish'
          );
        wp_update_nav_menu_item( $mn_menu_id->term_id, 0, $mn_item );

    
    //BLOG PAGE - WIDE
    $new_page_title = 'Wide Blog';
    $new_page_content = '';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");
      add_post_meta($new_page_id, 'hide_title', '1');
      add_post_meta($new_page_id, 'blog_layout', 'classic');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }

    //BLOG PAGE - MASONRY
    $new_page_title = 'Masonry Blog';
    $new_page_content = '';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      update_post_meta($new_page_id, "_wp_page_template", "template_blog.php");
      add_post_meta($new_page_id, 'hide_title', '1');
      add_post_meta($new_page_id, 'blog_layout', 'masonry');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }

    //PORTFOLIO PAGE
    /*
    $new_page_title = 'Grid Portfolio';
    $new_page_content = '';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      update_post_meta($new_page_id, "_wp_page_template", "template_portfolio.php");
      add_post_meta($new_page_id, 'portfolio_layout', 'grid_rectangle');
      add_post_meta($new_page_id, 'hide_title', '1');
      add_post_meta($new_page_id, 'show_skills', '1');
      add_post_meta($new_page_id, 'thumbs_margin', '0');
      add_post_meta($new_page_id, 'use_lightbox', '0');
      add_post_meta($new_page_id, 'thumbs_rollover', '#000000');
      add_post_meta($new_page_id, 'portfolio_filter', array('0' => $new_skill));
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }*/
    $new_skill=get_term_by('slug', 'fount-classic-skill', 'pirenko_skills');
    //PORTFOLIO ITEM - IMAGE
    $new_page_title = 'Half layout with Image';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-04',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'inner_layout', 'half');
      add_post_meta($new_page_id, 'featured_color', '#27ae60');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }
    //PORTFOLIO ITEM - SLIDER
    $new_page_title = 'Half layout with Slider';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-03',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_b_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'inner_layout', 'half');
      add_post_meta($new_page_id, 'image_2', $attachment_a_id);
      add_post_meta($new_page_id, 'featured_color', '#e67e22');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }
    
    
    //PORTFOLIO ITEM - VIDEO
    $new_page_title = 'Half layout with Video';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-02',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'inner_layout', 'half');
      add_post_meta($new_page_id, 'skip_featured', '1');
      add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
      add_post_meta($new_page_id, 'featured_color', '#8e44ad');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }

    //PORTFOLIO PAGE
    $new_skill=get_term_by('slug', 'fount-fullscreen-skill', 'pirenko_skills');
    /*$new_page_title = 'Portfolio Carousel';
    $new_page_content = '';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      update_post_meta($new_page_id, "_wp_page_template", "template_portfolio.php");
      add_post_meta($new_page_id, 'portfolio_layout', 'grid_carousel');
      add_post_meta($new_page_id, 'show_skills', '1');
      add_post_meta($new_page_id, 'show_titles', '1');
      add_post_meta($new_page_id, 'columns_number', '3');
      add_post_meta($new_page_id, 'panel_behavior', 'prk_no_open');
      add_post_meta($new_page_id, 'portfolio_filter', array('0' => $new_skill));
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }*/

    //PORTFOLIO ITEM - IMAGE
    $new_page_title = 'Wide layout with Image';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-08',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'featured_color', '#27ae60');
      add_post_meta($new_page_id, 'inner_layout', 'wide');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }
    //PORTFOLIO ITEM - SLIDER
    $new_page_title = 'Wide layout with Slider';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-07',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_b_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'image_2', $attachment_a_id);
      add_post_meta($new_page_id, 'inner_layout', 'wide');
      add_post_meta($new_page_id, 'featured_color', '#e67e22');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }
    
    
    //PORTFOLIO ITEM - VIDEO
    $new_page_title = 'Wide layout with Video';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_portfolios');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_portfolios',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-06',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      wp_publish_post($new_page_id);
      add_post_meta($new_page_id, 'skip_featured', '1');
      add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
      add_post_meta($new_page_id, 'featured_color', '#8e44ad');
      add_post_meta($new_page_id, 'inner_layout', 'wide');
      add_post_meta($new_page_id, 'client_url', 'Company ABC');
      add_post_meta($new_page_id, 'ext_url', 'http://www.google.com');
      wp_set_post_terms( $new_page_id, array($new_skill->term_id), 'pirenko_skills', false );
    }

    //SHOPPER PAGE
    $new_page_title = 'Shop Custom Page';
    $new_page_content = '[vc_row bk_type="boxed_look" align="Left" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="Recent Products" align="Center" title_size="h1" use_italic="No" fount_show_line="above thicker" css_animation="fount_fade_waypoint" line_color="#b08a4f"][/prkwp_styled_title][prkwp_spacer size="-20"][/prkwp_spacer][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]<p style="text-align: center;">The stones under my feet were muddy and slippery. People were landing hastily on both sides of the river. The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears.</p>[/vc_column_text][prkwp_spacer size="16"][/prkwp_spacer][prk_woo_featured order_by="date" general_style="slider" items_number="7" columns="4" css_animation="fount_fade_waypoint"][/prk_woo_featured][prkwp_spacer size="30"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Center" append_arrow="no" vid_parallax="no" bk_element="image" bg_image_repeat="fixed_cover" bg_image="'.$attachment_b_id.'"][vc_column width="1/6"][/vc_column][vc_column width="2/3" css_animation="bottom-to-top"][prkwp_spacer size="100"][/prkwp_spacer][prkwp_styled_title prk_in="Worldwide shipments" align="Center" text_color="#ffffff" title_size="h3" use_italic="No" fount_show_line="double_lined" line_color="#ffffff"][/prkwp_styled_title][prkwp_spacer size="16"][/prkwp_spacer][vc_column_text]<p style="text-align: center; color: #ffffff;">We had completed these arrangements for our protection after leaving Phutra when the Sagoths who had been sent to recapture the escaped prisoners returned with four of them, of whom Hooja was one. Dian and two others had eluded them. It so happened that Hooja was confined.</p>[/vc_column_text][prkwp_spacer size="24"][/prkwp_spacer][prk_wp_theme_button type="theme_button medium" prk_in="MORE INFO" link="http://www.pirenko.com/fount-shop/" window="No" css_animation="fount_fade_waypoint" el_class="delay-200" button_bk_color="#ffffff"][/prk_wp_theme_button][prkwp_spacer size="36"][/prkwp_spacer][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left" bg_image_repeat="fixed_cover" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="Shop With Style" align="Center" title_size="h1" use_italic="No" fount_show_line="above thicker" css_animation="fount_fade_waypoint" line_color="#b08a4f"][/prkwp_styled_title][prkwp_spacer size="-20"][/prkwp_spacer][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]<p style="text-align: center;">The stones under my feet were muddy and slippery. People were landing hastily on both sides of the river. The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears.</p>[/vc_column_text][prkwp_spacer size="70"][/prkwp_spacer][vc_row_inner anchor_id="selling_row"][vc_column_inner width="1/4" css_animation="bottom-to-top"][prkwp_styled_title prk_in="Best Sellers" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined"][/prkwp_styled_title][prkwp_spacer size="8"][/prkwp_spacer][prk_woo_widget order_by="best_sellers" items_number="3"][/prk_woo_widget][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-200"][prkwp_styled_title prk_in="On Sale" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined"][/prkwp_styled_title][prkwp_spacer size="8"][/prkwp_spacer][prk_woo_widget order_by="sale_only" items_number="3"][/prk_woo_widget][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-400"][prkwp_styled_title prk_in="Top Rated" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined"][/prkwp_styled_title][prkwp_spacer size="8"][/prkwp_spacer][prk_woo_widget order_by="rating" items_number="3"][/prk_woo_widget][/vc_column_inner][vc_column_inner width="1/4" css_animation="bottom-to-top" el_class="delay-600"][prkwp_styled_title prk_in="Spotlight" align="Center" title_size="h4" use_italic="No" fount_show_line="double_lined"][/prkwp_styled_title][prkwp_spacer size="8"][/prkwp_spacer][vc_single_image image="'.$attachment_c_id.'" img_size="300x300" img_link_target="_self" img_link="http://www.pirenko.com/fount-shop/product/phone-cover/"][/vc_single_image][prkwp_spacer size="48" el_class="show_later"][/prkwp_spacer][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bk_type="full_width" bk_element="image" bg_image="'.$attachment_b_id.'" bg_image_repeat="parallax" align="Left" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="60"][/prkwp_spacer][prkwp_styled_title prk_in="Our Clients Feedback" align="Center" title_size="h2" use_italic="No" fount_show_line="double_lined" css_animation="fount_fade_waypoint" text_color="#ffffff"][/prkwp_styled_title][prkwp_spacer size="16"][/prkwp_spacer][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]<p style="text-align: center;"><span style="color: #ffffff;">Over the last years we have received mostly good feedback which always makes us aim for greatness.<br>Here are just some of the encouraging words that make us feel good.</span></p>[/vc_column_text][prkwp_spacer size="58"][/prkwp_spacer][prk_testimonials color="#ffffff" align="Center" show_controls="yes" autoplay="yes" css_animation="fount_fade_waypoint" category=""][/prk_testimonials][prkwp_spacer size="60"][/prkwp_spacer][/vc_column][/vc_row][vc_row bk_type="boxed_look" align="Left" el_class="grey_lines" bk_element="colored" append_arrow="no" vid_parallax="no"][vc_column width="1/1"][prkwp_spacer size="70"][/prkwp_spacer][prkwp_styled_title prk_in="From Our Blog" align="Center" title_size="h1" use_italic="No" fount_show_line="above thicker" css_animation="fount_fade_waypoint" line_color="#b08a4f"][/prkwp_styled_title][prkwp_spacer size="-20"][/prkwp_spacer][vc_column_text el_class="small-10 columns small-centered" css_animation="fount_fade_waypoint"]<p style="text-align: center;">The stones under my feet were muddy and slippery. People were landing hastily on both sides of the river. The splashes of the people in the boats leaping into the river sounded like thunderclaps in my ears.</p>[/vc_column_text][prkwp_spacer size="30"][/prkwp_spacer][pirenko_last_posts general_style="classic" rows_number="1" css_animation="bottom-to-top" cat_filter=""][/pirenko_last_posts][/vc_column][/vc_row]';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'featured_header', '1');
      add_post_meta($new_page_id, 'featured_slider', 'yes');
      add_post_meta($new_page_id, 'featured_slider_parallax', '1');
      add_post_meta($new_page_id, 'featured_slider_supersize', '1');
      add_post_meta($new_page_id, 'featured_slider_arrows', '0');
      add_post_meta($new_page_id, 'featured_slider_dots', '1');
      add_post_meta($new_page_id, 'featured_slider_down_arrow', '1');
      add_post_meta($new_page_id, 'show_title', 'no');
      add_post_meta($new_page_id, 'show_sidebar', 'no');
      add_post_meta($new_page_id, 'below_headings_text', '');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    
    //CONTACT PAGE
    $new_page_title = 'Contact Page';
    $new_page_content = '';
    $new_page = array(
      'post_type' => 'page',
      'post_title' => $new_page_title,
      'post_content' => $new_page_content,
      'post_status' => 'publish'
    );
    //CHECK IF PAGE EXISTS
    $page_id = get_page_by_title($new_page_title);
    if(!isset($page_id->ID)) {
      $new_page_id = wp_insert_post($new_page);
      update_post_meta($new_page_id, "_wp_page_template", "page-contact.php");
      add_post_meta($new_page_id, 'content_type', 'map');
      add_post_meta($new_page_id, 'map_latitude', '40.6700');
      add_post_meta($new_page_id, 'map_longitude', '-73.9400');
      add_post_meta($new_page_id, 'map_height', '400');
      add_post_meta($new_page_id, 'hide_title', '1');
      add_post_meta($new_page_id, 'zoom_level', '13');
      add_post_meta($new_page_id, 'contact-address', 'Fount Photography, Inc.<br>Third Main Street, 27th<br>Brooklyn, NY City<br>1000-204 NY');
      add_post_meta($new_page_id, 'map_style', 'subtle_grayscale');
      add_post_meta($new_page_id, 'show_contact_form', '1');
      add_post_meta($new_page_id, 'prk_email_address', 'something@mail.com');
      add_post_meta($new_page_id, 'show_contact_information', '1');
      add_post_meta($new_page_id, 'contact-info_title', 'Contact Information');
      add_post_meta($new_page_id, 'contact-info_tel', '+1 234 555 999');
      add_post_meta($new_page_id, 'contact-info_fax', '+1 234 555 990');
      add_post_meta($new_page_id, 'contact-info_email', 'hello@fount.com');
      //ADD THE PAGE TO THE MENU
      $menu = 
        array( 
          'menu-item-type' => 'custom', 
          'menu-item-url' => get_permalink($new_page_id),
          'menu-item-title' => $new_page_title,
          'menu-item-status' => 'publish',
          'menu-item-parent-id' => $parent_page,
        );
      wp_update_nav_menu_item( $menu_id->term_id, 0, $menu );
    }
    
    
    //ADD A DEFAULT CATEGORY - BLOG
    wp_create_category('Fount Category');
    $new_category=get_category_by_slug('fount-category');
    
    
    //BLOG ITEM - IMAGE
    $new_page_title = 'Post with Image';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'post');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'post',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-08',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_b_id);
      add_post_meta($new_page_id, 'bl_icon', 'fount_fa-bullhorn');
      wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
    }

    //BLOG ITEM - SLIDER
    $new_page_title = 'Post with Slider';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'post');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'post',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-07',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      add_post_meta($new_page_id, 'bl_icon', 'fount_fa-bullhorn');
      add_post_meta($new_page_id, 'image_2', $attachment_b_id);
      wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
    }
    
    
    //BLOG ITEM - VIDEO
    $new_page_title = 'Post with Video';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'post');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'post',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-06',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'skip_featured', '1');
      add_post_meta($new_page_id, 'bl_icon', 'fount_fa-bullhorn');
      add_post_meta($new_page_id, 'video_2', '<iframe width="1280" height="720" src="http://www.youtube.com/embed/Q9Phn1yQT8U?html5=1&vq=hd720" frameborder="0" allowfullscreen></iframe>');
      wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
    }
    
    
    //BLOG ITEM - AUDIO
    $new_page_title = 'Post with Audio';
    $new_page_content = '[vc_row][vc_column width="1/1"][vc_column_text]The aborigine, apparently uninjured, climbed quickly into the skiff, and seizing the spear with me helped to hold off the infuriated creature. Blood from the wounded reptile was now crimsoning the waters about us and soon from the weakening struggles it became evident that I had inflicted a death wound upon it. Presently its efforts to reach us ceased entirely, and with a few convulsive movements it turned upon its back quite dead.
And then there came to me a sudden realization of the predicament in which I had placed myself. I was entirely within the power of the savage man whose skiff I had stolen. Still clinging to the spear I looked into his face to find him scrutinizing me intently, and there we stood for some several minutes, each clinging tenaciously to the weapon the while we gazed in stupid wonderment at each other.[/vc_column_text][/vc_column][/vc_row]';
    $page_check = get_page_by_title($new_page_title, '', 'post');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'post',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-05',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'skip_featured', '1');
      add_post_meta($new_page_id, 'bl_icon', 'fount_fa-bullhorn');
      add_post_meta($new_page_id, 'video_2', '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F58223409"></iframe>');
      wp_set_post_terms( $new_page_id, array($new_category->term_id), 'category', false );
    } 
    
    //ADD A DEFAULT TEAM - TEAM MEMBERS
    wp_insert_term(
      'Fount Team', //TERM
      'pirenko_member_group', //TAXONOMY
      array(
        'description'=> 'A sample team',
        'slug' => 'fount-team'
      )
    );
    $new_group=get_term_by('slug', 'fount-team', 'pirenko_member_group');
    
    
    //MEMBERS - MEMBER A
    $new_page_title = 'John Doe';
    $new_page_content = 'In both cases, the stranded whales to which these two skeletons belonged, were originally claimed by their proprietors upon similar grounds. King Tranquo seizing his because he wanted it; and Sir Clifford, because he was lord of the seignories of those parts. Sir Cliffords whale has been articulated throughout; so that, like a great chest of drawers, you can open and shut him, in all his bony cavities out his ribs like a gigantic swing all day upon his lower jaw. Locks are to be put upon some of his trap-doors and shutters; and a footman will show round future visitors with a bunch of keys at his side. Sir Clifford thinks of charging twopence for a peep at the whispering gallery in the spinal column; threepence to hear the echo in the hollow of his cerebellum; and sixpence for the unrivalled view from his forehead.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_team_member');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_team_member',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-08',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'featured_color', '#2c3e50');
      add_post_meta($new_page_id, 'member_job', 'Creative Director');
      add_post_meta($new_page_id, 'member_email', 'john@fount.com');
      add_post_meta($new_page_id, 'show_member_link', '0');
      add_post_meta($new_page_id, 'show_member_image', '1');
      add_post_meta($new_page_id, 'image_2', $attachment_c_id);
      set_post_thumbnail($new_page_id, $attachment_c_id);
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
    }
    //MEMBERS - MEMBER B
    $new_page_title = 'Jane Doe';
    $new_page_content = 'In both cases, the stranded whales to which these two skeletons belonged, were originally claimed by their proprietors upon similar grounds. King Tranquo seizing his because he wanted it; and Sir Clifford, because he was lord of the seignories of those parts. Sir Cliffords whale has been articulated throughout; so that, like a great chest of drawers, you can open and shut him, in all his bony cavities out his ribs like a gigantic swing all day upon his lower jaw. Locks are to be put upon some of his trap-doors and shutters; and a footman will show round future visitors with a bunch of keys at his side. Sir Clifford thinks of charging twopence for a peep at the whispering gallery in the spinal column; threepence to hear the echo in the hollow of his cerebellum; and sixpence for the unrivalled view from his forehead.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_team_member');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_team_member',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-10',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'featured_color', '#2c3e50');
      add_post_meta($new_page_id, 'member_job', 'Creative Director');
      add_post_meta($new_page_id, 'member_email', 'jane@fount.com');
      add_post_meta($new_page_id, 'show_member_link', '0');
      add_post_meta($new_page_id, 'show_member_image', '1');
      add_post_meta($new_page_id, 'image_2', $attachment_c_id);
      set_post_thumbnail($new_page_id, $attachment_c_id);
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
    }
    //MEMBERS - MEMBER C
    $new_page_title = 'Jackie Doe';
    $new_page_content = 'In both cases, the stranded whales to which these two skeletons belonged, were originally claimed by their proprietors upon similar grounds. King Tranquo seizing his because he wanted it; and Sir Clifford, because he was lord of the seignories of those parts. Sir Cliffords whale has been articulated throughout; so that, like a great chest of drawers, you can open and shut him, in all his bony cavities out his ribs like a gigantic swing all day upon his lower jaw. Locks are to be put upon some of his trap-doors and shutters; and a footman will show round future visitors with a bunch of keys at his side. Sir Clifford thinks of charging twopence for a peep at the whispering gallery in the spinal column; threepence to hear the echo in the hollow of his cerebellum; and sixpence for the unrivalled view from his forehead.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_team_member');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_team_member',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-09',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'featured_color', '#2c3e50');
      add_post_meta($new_page_id, 'member_job', 'Creative Director');
      add_post_meta($new_page_id, 'member_email', 'jackie@fount.com');
      add_post_meta($new_page_id, 'show_member_link', '0');
      add_post_meta($new_page_id, 'show_member_image', '1');
      add_post_meta($new_page_id, 'image_2', $attachment_c_id);
      set_post_thumbnail($new_page_id, $attachment_c_id);
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_member_group', false );
    }

    //ADD A DEFAULT GROUP - SLIDES
    wp_insert_term(
      'Fount Group', //TERM
      'pirenko_slide_set', //TAXONOMY
      array(
        'description'=> 'A sample group',
        'slug' => 'fount-group'
      )
    );
    $new_group=get_term_by('slug', 'fount-group', 'pirenko_slide_set');
    
    //SLIDES ITEM - IMAGE A
    $new_page_title = 'Slide A with Image';
    $new_page_content = 'This is the image A description.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_slides');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_slides',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_a_id);
      add_post_meta($new_page_id, 'pirenko_sh_slide_header_bk_color', '#ffffff');
      add_post_meta($new_page_id, 'title_background_color_opacity', '0');
      add_post_meta($new_page_id, 'pirenko_sh_slide_body_color', '#ffffff');
      add_post_meta($new_page_id, 'body_background_color_opacity', '0');
      add_post_meta($new_page_id, 'slide_text_horz', 'center');
      add_post_meta($new_page_id, 'slide_text_vert', 'v_center');
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_slide_set', false );
    }
    
    
    //SLIDES ITEM - IMAGE B
    $new_page_title = 'Slide B with Image';
    $new_page_content = 'This is the image A description.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_slides');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_slides',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      set_post_thumbnail($new_page_id, $attachment_b_id);
      add_post_meta($new_page_id, 'pirenko_sh_slide_header_bk_color', '#ffffff');
      add_post_meta($new_page_id, 'title_background_color_opacity', '0');
      add_post_meta($new_page_id, 'pirenko_sh_slide_body_color', '#ffffff');
      add_post_meta($new_page_id, 'body_background_color_opacity', '0');
      add_post_meta($new_page_id, 'slide_text_horz', 'center');
      add_post_meta($new_page_id, 'slide_text_vert', 'v_center');
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_slide_set', false );
    }

     //ADD A DEFAULT GROUP - TESTIMONIALS
    wp_insert_term(
      'Fount Testimonials', //TERM
      'pirenko_testimonial_set', //TAXONOMY
      array(
        'description'=> 'A sample set',
        'slug' => 'fount-testimonials'
      )
    );
    $new_group=get_term_by('slug', 'fount-testimonials', 'pirenko_testimonial_set');
    
    
    //MEMBERS - MEMBER A
    $new_page_title = 'John Doe';
    $new_page_content = 'In both cases, the stranded whales to which these two skeletons belonged, were originally claimed by their proprietors upon similar grounds. King Tranquo seizing his because he wanted it; and Sir Clifford, because he was lord of the seignories of those parts.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_testimonials');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_testimonials',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-08',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'testimonial_subheading', 'John, the thinker');
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
    }
    //MEMBERS - MEMBER B
    $new_page_title = 'Jane Doe';
    $new_page_content = 'Sir Cliffords whale has been articulated throughout; so that, like a great chest of drawers, you can open and shut him, in all his bony cavities out his ribs like a gigantic swing all day upon his lower jaw. Locks are to be put upon some of his trap-doors and shutters; and a footman will show round future visitors with a bunch of keys at his side.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_testimonials');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_testimonials',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-10',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'testimonial_subheading', 'Jane, the executive');
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
    }
    //MEMBERS - MEMBER C
    $new_page_title = 'Jackie Doe';
    $new_page_content = 'Sir Clifford thinks of charging twopence for a peep at the whispering gallery in the spinal column; threepence to hear the echo in the hollow of his cerebellum; and sixpence for the unrivalled view from his forehead.';
    $page_check = get_page_by_title($new_page_title, '', 'pirenko_testimonials');
    if(!isset($page_check->ID)){
      $new_page = array(
        'post_type' => 'pirenko_testimonials',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_date' => '2013-09-09',
        'post_status' => 'publish'
      );
      $new_page_id = wp_insert_post($new_page);
      add_post_meta($new_page_id, 'testimonial_subheading', 'Jackie, the accountant');
      wp_set_post_terms( $new_page_id, array($new_group->term_id), 'pirenko_testimonial_set', false );
    }


  }//ONE CLICK CONTENT


    if ($fount_theme_activation_options['create_navigation_menus']) 
    {
    $fount_theme_activation_options['create_navigation_menus'] = false;
    //ADD THE DEFAULT MENUS IF NECESSARY
    if ( is_nav_menu( 'Top Left Menu'  ) )
    {
      //DO NOTHING. THE MENU ALREADY EXISTS 
    }
    else
    {
      $name = 'Top Left Menu';
      $menu_id = wp_create_nav_menu($name);
      $menu = get_term_by( 'name', $name, 'nav_menu' );
      //ASSIGN THE MENU TO THE DEFAULT LOCATION
      $locations = get_theme_mod('nav_menu_locations');
      $locations['top_left_navigation'] = $menu->term_id;
      set_theme_mod( 'nav_menu_locations', $locations );
    }
    }
    update_option('fount_theme_activation_options', $fount_theme_activation_options);
}

add_action('admin_init','fount_theme_activation_action');

function fount_deactivation_action() {
  update_option('fount_theme_activation_options', fount_get_default_theme_activation_options());
}

add_action('switch_theme', 'fount_deactivation_action');