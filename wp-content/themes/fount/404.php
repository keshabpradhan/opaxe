<?php 
  get_header(); 
?>
<div id="centered_block" class="forced_menu">
  <div id="main_block" class="block_with_sections">
      <div id="content">
          <div id="main" class="row error_404">
            <div class="single_page_title">
                  <h1 class="header_font bd_headings_text_shadow zero_color huge">
                    404
                </h1>
                <h3 class="header_font active_text_shadow not_zero_color">
                    <?php 
                          echo esc_attr($prk_translations['404_title_text']);
                     ?>
                </h3>
          </div>
            <div class="columns row small-12 prk_inner_block small-centered fount_centered_text">
              <div class="simple_line columns small-centered"></div>
              <p>
                <?php 
                    echo esc_attr($prk_translations['404_body_text']);
                ?>
              </p>
            </div>
          </div>
      </div>
  </div>
</div>
<?php get_footer(); ?>