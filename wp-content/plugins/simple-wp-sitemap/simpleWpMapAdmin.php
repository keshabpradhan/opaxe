<?php defined('ABSPATH') or die;

/*
 * Simple Wp Sitemap admin interface
 */

?>
<div class="wrap">

    <h2 id="simple-wp-sitemap-h2">
        <img src="<?php echo esc_url(plugins_url('sign.png', __FILE__)); ?>" alt="<?php esc_attr_e('Simple Wp Sitemap logo', 'simple-wp-sitemap'); ?>" width="40" height="40">
        <span><?php _e('Simple Wp Sitemap settings', 'simple-wp-sitemap'); ?></span>
    </h2>

    <p><?php _e('Your two sitemaps are active! Here you can change and customize them.', 'simple-wp-sitemap'); ?></p>
    <p><b><?php _e('Links to your xml and html sitemap:', 'simple-wp-sitemap'); ?></b></p>

    <ul id="sitemap-links">
        <li><?php printf('%1$s <a href="%2$s">%2$s</a>', __('Xml sitemap:', 'simple-wp-sitemap'), $ops->getSitemapUrl('xml')); ?></li>
        <li>
            <?php _e('Html sitemap:', 'simple-wp-sitemap'); ?>
            <?php echo get_option('simple_wp_block_html') ? __('(disabled)', 'simple-wp-sitemap') : sprintf('<a href="%1$s">%1$s</a>', $ops->getSitemapUrl('html')); ?>
        </li>
    </ul>

    <noscript><?php _e('(Please enable javascript to edit options)', 'simple-wp-sitemap'); ?></noscript>

    <form method="post" action="<?php echo esc_url(admin_url('options-general.php?page=simpleWpSitemapSettings')); ?>" id="simple-wp-sitemap-form">

        <ul id="sitemap-settings">
            <li><a href="#sitemap-general"><?php _e('General', 'simple-wp-sitemap'); ?></a></li>
            <li><a href="#sitemap-order"><?php _e('Order', 'simple-wp-sitemap'); ?></a></li>
            <li><a href="#sitemap-premium"><?php _e('Premium', 'simple-wp-sitemap'); ?></a></li>
        </ul>

        <div id="sitemap-general" class="sitemap-table">

            <h3><?php _e('Add pages', 'simple-wp-sitemap'); ?></h3>
            <p>
                <?php printf(
                    __('Add pages to the sitemaps in addition to your normal WordPress ones. Just paste "full" urls in the textarea like: %s. Each link on a new row (this will affect both your xml and html sitemap).', 'simple-wp-sitemap'),
                    sprintf('<b>%s</b>', esc_url('http://www.example.com/a-page/'))
                ); ?>
            </p>

            <p><textarea rows="7" name="simple_wp_other_urls" placeholder="<?php echo esc_url('http://www.example.com/a-page/'); ?>" class="large-text code" id="swsp-add-pages-textarea"><?php $ops->printUrls('simple_wp_other_urls'); ?></textarea></p>

            <h3 class="sitemap-section"><?php _e('Block pages', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('Add pages you want to block from showing up in the sitemaps. Same as above, just paste every link on a new row. (Tip: copy paste links from one of your sitemaps to get correct urls).', 'simple-wp-sitemap'); ?></p>

            <p><textarea rows="7" name="simple_wp_block_urls" placeholder="<?php echo esc_url('http://www.example.com/block-this-page/'); ?>" class="large-text code"><?php $ops->printUrls('simple_wp_block_urls'); ?></textarea></p>

            <h3 class="sitemap-section"><?php _e('Extra sitemap includes', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('Check if you want to include categories, tags and/or author pages in the sitemaps.', 'simple-wp-sitemap'); ?></p>

            <div>
                <p><input type="checkbox" name="simple_wp_disp_categories" id="simple_wp_cat" <?php checked(get_option('simple_wp_disp_categories')); ?>><label for="simple_wp_cat"> <?php _e('Include categories', 'simple-wp-sitemap'); ?></label></p>
                <p><input type="checkbox" name="simple_wp_disp_tags" id="simple_wp_tags" <?php checked(get_option('simple_wp_disp_tags')); ?>><label for="simple_wp_tags"> <?php _e('Include tags', 'simple-wp-sitemap'); ?></label></p>
                <p><input type="checkbox" name="simple_wp_disp_authors" id="simple_wp_authors" <?php checked(get_option('simple_wp_disp_authors')); ?>><label for="simple_wp_authors"> <?php _e('Include authors', 'simple-wp-sitemap'); ?></label></p>
            </div>

            <h3 class="sitemap-section"><?php _e('Html sitemap', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('Enable or disable your html sitemap. This will not effect your xml sitemap.', 'simple-wp-sitemap'); ?></p>

            <div>
                <?php _e('Title in html sitemap', 'simple-wp-sitemap'); ?>:
                <input type="text" name="simple_wp_sitemap_title" placeholder="<?php echo esc_attr(get_bloginfo('name') . ' ' . __('Html Sitemap', 'simple-wp-sitemap')); ?>" value="<?php echo esc_attr(get_option('simple_wp_sitemap_title')); ?>">
            </div>

            <div>
                <select name="simple_wp_block_html" id="simple_wp_block_html">
                    <?php foreach (array('' => __('Enable', 'simple-wp-sitemap'), '1' => __('Disable', 'simple-wp-sitemap'), '404' => __('Disable and set to 404', 'simple-wp-sitemap')) as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php selected(get_option('simple_wp_block_html'), $key); ?>><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </div>

            <h3 class="sitemap-section"><?php _e('Like the plugin?', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('Show your support by rating the plugin at wordpress.org, and/or by adding an attribution link to the sitemap.html file :)', 'simple-wp-sitemap'); ?></p>

            <p><input type="checkbox" name="simple_wp_attr_link" id="simple_wp_check" <?php checked(get_option('simple_wp_attr_link')); ?>><label for="simple_wp_check"> <?php _e('Add "Generated by Simple Wp Sitemap" link at bottom of sitemap.html', 'simple-wp-sitemap'); ?></label></p>

        </div><!-- sitemap-general -->

        <div id="sitemap-order" class="sitemap-table">

            <h3><?php _e('Display order and titles', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('If you want to change the display order in your sitemaps, click the arrows to move sections up or down. They will be displayed as ordered below (highest up is displayed first and lowest down last)', 'simple-wp-sitemap'); ?></p>

            <ul id="sitemap-display-order">
                <?php if (!($orderArray = $ops->checkOrder(get_option('simple_wp_disp_sitemap_order')))) {
                    $orderArray = $ops->getDefaultOrder();
                }
                foreach ($orderArray as $key => $val) { ?>
                    <li>
                        <input type="text" class="swp-name" data-name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val['title']); ?>">
                        <span class="sitemap-down" title="<?php esc_attr_e('Move down', 'simple-wp-sitemap'); ?>"></span>
                        <span class="sitemap-up" title="<?php esc_attr_e('Move up', 'simple-wp-sitemap'); ?>"></span>
                        <input type="hidden" name="simple_wp_<?php echo esc_attr($key); ?>_n" value="<?php echo esc_attr($val['i']); ?>">
                    </li>
                <?php } ?>
            </ul>

            <div>
                <b><?php _e('Last updated text:', 'simple-wp-sitemap'); ?></b>
                <input type="text" name="simple_wp_last_updated" placeholder="<?php esc_attr_e('Last updated', 'simple-wp-sitemap'); ?>" value="<?php echo esc_attr(get_option('simple_wp_last_updated')); ?>" id="simple_wp_last_updated">
            </div>

            <div>
                <b><?php _e('Sort posts and pages:', 'simple-wp-sitemap'); ?></b>
                <select id="simple_wp_order_by" name="simple_wp_order_by">
                    <?php foreach (array('' => __('Posted date', 'simple-wp-sitemap'), 'modified' => __('Last updated date', 'simple-wp-sitemap'), 'name' => __('Alphabetical', 'simple-wp-sitemap'), 'rand' => __('Random', 'simple-wp-sitemap'), 'comment_count' => __('Comments', 'simple-wp-sitemap'), 'parent' => __('Parents', 'simple-wp-sitemap')) as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php selected(get_option('simple_wp_order_by'), $key); ?>><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </div>

            <p><input type="button" id="sitemap-defaults" class="button-secondary" value="<?php esc_attr_e('Restore default order', 'simple-wp-sitemap'); ?>"></p>

        </div><!-- sitemap-order -->

        <div id="sitemap-premium" class="sitemap-table">

            <h3><?php _e('Simple Wp Sitemap Premium', 'simple-wp-sitemap'); ?></h3>
            <p><?php _e('There\'s a premium version of Simple Wp Sitemap available which includes:', 'simple-wp-sitemap'); ?></p>

            <ul class="simple-wp-sitemap-includes">
                <li><?php _e('Split sitemaps', 'simple-wp-sitemap'); ?></li>
                <li><?php _e('Image sitemaps', 'simple-wp-sitemap'); ?></li>
                <li><?php _e('Display with shortcode', 'simple-wp-sitemap'); ?></li>
                <li><?php _e('Exclude directories', 'simple-wp-sitemap'); ?></li>
                <li><?php _e('And much more!', 'simple-wp-sitemap'); ?></li>
            </ul>

            <p><a target="_blank" rel="noopener" class="button-secondary" href="<?php echo esc_url('https://www.webbjocke.com/downloads/simple-wp-sitemap-premium/'); ?>"><?php _e('Get Simple Wp Sitemap Premium!', 'simple-wp-sitemap'); ?></a></p>

        </div><!-- sitemap-premium -->

        <p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'simple-wp-sitemap'); ?>"></p>

        <p><i><?php _e('(If you have a caching plugin, you might have to clear cache before changes will be shown in the sitemaps)', 'simple-wp-sitemap'); ?></i></p>

    </form><!-- simple-wp-sitemap-form -->

</div><!-- wrap -->
