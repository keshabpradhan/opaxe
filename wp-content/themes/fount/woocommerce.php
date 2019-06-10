<?php 
  get_header();
  $show_sidebar=$prk_fount_options['woo_sidebar_display'];
  if ($show_sidebar=="1")
      $show_sidebar=true;
  else
      $show_sidebar=false;
  if (isset($_GET["sidebar"])) {
    if ($_GET["sidebar"]=="y") {
      $show_sidebar=true;
    }
    if ($_GET["sidebar"]=="n") {
      $show_sidebar=false;
    }
  }
  $show_title=true;
  $featured_style=' class="forced_menu"';
  $extra_class="";
  if ($prk_fount_options['woo_col_nr']!="") {
    $woo_col_nr=$prk_fount_options['woo_col_nr'];
  } else 
  $woo_col_nr="4";
?>
<div id="centered_block"<?php echo $featured_style; ?>>
<div id="main_block" class="fount_cols-<?php echo $woo_col_nr; ?> fount_woo_page woocommerce block_with_sections page-<?php echo get_the_ID(); ?>">
    <?php
      if ($show_title==true)
      {
        echo '<div class="prk_inner_block small-12 small-centered columns">';
        prk_output_title($prk_fount_options['woo_subheading']);
        $extra_class=" with_title";
        echo '</div>';
      }
      else
      {
        if (get_field('featured_header')=="0")
          $extra_class=" untitled_main";
      }
    ?>
    <div id="content">
        <div id="main" role="main" class="row<?php echo $extra_class; ?>">
            <?php
                if ($show_sidebar)
                {
                  echo '<div class="small-centered columns prk_inner_block small-12">';
                  echo '<div class="row">';
                  echo '<div class="small-9 columns">';
                  echo '<div id="fount_sidebared_sections">';
                  echo '<div class="prk_composer_extra prk_inner_block small-12 small-centered columns">';
                }
                else
                {
                  echo '<div id="fount_super_sections" class="row">';
                  echo '<div class="prk_inner_block small-12 small-centered columns">';
                  echo '<div class="small_woo">';
                }
                add_filter( 'loop_shop_columns', 'wc_loop_shop_columns', 1, 10 );

                /*
                 * Return a new number of maximum columns for shop archives
                 * @param int Original value
                 * @return int New number of columns
                 */
                function wc_loop_shop_columns( $number_columns ) {
                  global $woo_col_nr;
                  return $woo_col_nr;
                }
                woocommerce_content();
                echo '</div>';
                echo '<div class="clearfix"></div>';
                echo '</div>';
                if ($show_sidebar)
                {
                  echo '</div>';
                    ?>
                    <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
                      <?php 
                        if (function_exists('dynamic_sidebar') && dynamic_sidebar('prk-woo-sidebar')) {

                        }
                      ?>
                    </aside>
                  <?php
                  echo '</div>';
                  echo '</div>';
                }
                else
                {
                  echo '</div>';
                }
                ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>