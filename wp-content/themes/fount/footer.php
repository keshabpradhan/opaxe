                    <?php 
                        global $prk_fount_options; 
                    ?>
                </div>
            </div>
            <?php
                if ($prk_fount_options['use_footer']=="1")
                {
                    if ($prk_fount_options['footer_reveal']=="1")
                    {
                        echo '<div id="footer_mirror" class="columns small-12" data-0-bottom-top="opacity:0" data--350-bottom-top="opacity:1" data-emit-events></div>';
                        $wrapper_class="";
                    }
                    else
                    {
                        $wrapper_class=" no_mirror";
                    }
                    wp_reset_query();
                    $footer_sidebar_id='sidebar-footer';
                    if (get_field('footer_sidebar_id')!="")
                        $footer_sidebar_id=get_field('footer_sidebar_id');
                    if (isset($prk_fount_options['fount_active_skin']) && (is_single() || $prk_fount_options['fount_active_skin']=="fount_multipage_skin" || $prk_fount_options['fount_active_skin']=="fount_shop_skin"))
                    {
                        $footer_sidebar_id=$prk_fount_options['fount_current_footer'];
                    }
                    if ($prk_fount_options['bottom_sidebar']=="1" && is_active_sidebar($footer_sidebar_id))
                    {
                        $extra_class="";
                    }
                    else
                    {
                        $extra_class=" prk_no_footer";
                    }
                    ?>
                    <div id="prk_footer_wrapper" class="small-12 row<?php echo $wrapper_class; ?>">
                        <div id="prk_footer" class="container<?php echo $extra_class; ?>" data-layout="<?php echo $prk_fount_options['widgets_nr']; ?>">
                            <div id="footer_revealer">
                                <?php 
                                    if ($prk_fount_options['bottom_page']=="1")
                                    {
                                        ?>
                                            <div id="paged_footer">
                                            <?php echo do_shortcode(get_post_field('post_content', $prk_fount_options['bottom_page_id'], 'raw' )); ?>
                                            </div>
                                        <?php
                                    } 
                                    if ($prk_fount_options['bottom_sidebar']=="1" && is_active_sidebar($footer_sidebar_id))
                                    {
                                        ?>
                                        <div id="footer_bk" class="columns small-12 prk_inner_block small-centered">
                                            <div id="footer_in" class="row">
                                                <?php
                                                    $extra_class="";
                                                    if ($prk_fount_options['bottom_sidebar']=="1" && function_exists('dynamic_sidebar') && dynamic_sidebar($footer_sidebar_id)) : 
                                                    else :
                                                    endif; 
                                                ?>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>
                                        <?php
                                    }
                                ?>
                                <div id="after_widgets">
                                    <div class="columns small-12 prk_inner_block small-centered">
                                            <div class="small-12">
                                                    <?php
                                                        if ($prk_fount_options['footer_text_extra']=='')
                                                        {
                                                            echo '<div class="copy small-12 fount_centered_text wpb_text_column">'.$prk_fount_options['footer_text'].'</div>';
                                                        }
                                                        else
                                                        {
                                                            echo '<div class="copy small-6 wpb_text_column">'.$prk_fount_options['footer_text'].'</div>';
                                                            echo '<div class="copy right_sided small-6 wpb_text_column">'.$prk_fount_options['footer_text_extra'].'</div>';
                                                        }  
                                                    ?>
                                            </div>
                                        </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php 
            if (isset($prk_fount_options['ganalytics_text']) && $prk_fount_options['ganalytics_text']!="") {
                echo $prk_fount_options['ganalytics_text'];
            }
            wp_footer(); 
        ?>
    </body>
</html>