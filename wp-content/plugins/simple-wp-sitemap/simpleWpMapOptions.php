<?php defined('ABSPATH') or die;

/*
 * Simple Wp Sitemap options
 */

class SimpleWpMapOptions {

    // Returns a sitemap url
    public function getSitemapUrl ($type) {
        return esc_url(home_url('/') . (get_option('permalink_structure') ? 'sitemap.' : '?thesimplewpsitemap=') . $type);
    }

    // Returns default order option
    public function getDefaultOrder () {
        return array('home' => array('title' => __('Home', 'simple-wp-sitemap'), 'i' => 1), 'posts' => array('title' => __('Posts', 'simple-wp-sitemap'), 'i' => 2), 'pages' => array('title' => __('Pages', 'simple-wp-sitemap'), 'i' => 3), 'other' => array('title' => __('Other', 'simple-wp-sitemap'), 'i' => 4), 'categories' => array('title' => __('Categories', 'simple-wp-sitemap'), 'i' => 5), 'tags' => array('title' => __('Tags', 'simple-wp-sitemap'), 'i' => 6), 'authors' => array('title' => __('Authors', 'simple-wp-sitemap'), 'i' => 7));
    }

    // Updates all options
    public function setOptions ($otherUrls, $blockUrls, $attrLink, $categories, $tags, $authors, $orderArray, $lastUpdated, $blockHtml, $orderby, $title) {
        @date_default_timezone_set(get_option('timezone_string'));
        update_option('simple_wp_other_urls', $this->addUrls($otherUrls, get_option('simple_wp_other_urls')));
        update_option('simple_wp_block_urls', $this->addUrls($blockUrls));
        update_option('simple_wp_attr_link', intval($attrLink));
        update_option('simple_wp_disp_categories', intval($categories));
        update_option('simple_wp_disp_tags', intval($tags));
        update_option('simple_wp_disp_authors', intval($authors));
        update_option('simple_wp_block_html', sanitize_text_field($blockHtml));
        update_option('simple_wp_last_updated', sanitize_text_field(stripslashes($lastUpdated)));
        update_option('simple_wp_order_by', sanitize_text_field($orderby));
        update_option('simple_wp_sitemap_title', sanitize_text_field(stripslashes($title)));

        if (($orderArray = $this->checkOrder($orderArray)) && uasort($orderArray, array($this, 'sortArr'))) { // sort the array here
            update_option('simple_wp_disp_sitemap_order', $orderArray);
        }
    }

    // Prints urls in textarea
    public function printUrls ($opt) {
        if (is_array($urls = get_option($opt))) {
            foreach ($urls as $url) {
                echo esc_url($url['url']), "\n";
            }
        }
    }

    // Adds new urls to add and block pages
    public function addUrls ($urls, $oldUrls = null) {
        $newUrls = array();

        if ($urls = explode("\n", trim($urls))) {
            foreach ($urls as $url){
                if ($url = esc_url(trim($url))) {
                    $isOld = false;
                    if ($oldUrls && is_array($oldUrls)) {
                        foreach ($oldUrls as $oldUrl) {
                            if ($oldUrl['url'] === $url && !$isOld) {
                                array_push($newUrls, $oldUrl);
                                $isOld = true;
                            }
                        }
                    }
                    if (!$isOld && strlen($url) < 2000) {
                        array_push($newUrls, array('url' => $url, 'date' => time()));
                    }
                }
            }
        }
        return $newUrls;
    }

    // Checks if orderArray is valid
    public function checkOrder ($orderArray) {
        if (is_array($orderArray)) {
            foreach ($orderArray as $key => $val) {
                if (!is_array($val) || !preg_match('/^[1-7]{1}$/', $val['i']) || (!($orderArray[$key]['title'] = sanitize_text_field(stripslashes($val['title']))))) {
                    return false;
                }
            }
            return $orderArray;
        }
        return false;
    }

    // Sort function for order option
    public function sortArr ($a, $b) {
        return $a['i'] - $b['i'];
    }

    // Deletes old or current sitemap files and fixes order option for older plugin versions
    public function migrateFromOld () {
        if (function_exists('get_home_path')) {
            $path = get_home_path() . 'sitemap.';

            if (file_exists($path . 'xml')) {
                unlink($path . 'xml');
            }
            if (file_exists($path . 'html') && !get_option('simple_wp_block_html')) {
                unlink($path . 'html');
            }
        }

        if ($order = get_option('simple_wp_disp_sitemap_order')) {
            foreach ($order as $key => $val) {
                if (!is_array($val)) {
                    unset($order[$key]);
                    $order[lcfirst($key)] = array('title' => $key, 'i' => $val);
                }
            }
        } else {
            $order = $this->getDefaultOrder();
        }
        update_option('simple_wp_disp_sitemap_order', $order);
        return $order;
    }
}
