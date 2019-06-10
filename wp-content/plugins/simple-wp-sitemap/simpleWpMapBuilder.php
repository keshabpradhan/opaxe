<?php defined('ABSPATH') or die;

/*
 * Simple Wp Sitemap builder
 */

class SimpleWpMapBuilder {
    private $home = null;
    private $xml = false;
    private $html = false;
    private $posts = '';
    private $pages = '';
    private $other = false;
    private $blockedUrls = null;
    private $tags;
    private $authors;
    private $orderby;
    private $pattern;
    private $homeUrl;
    private $pluginUrl;
    private $categories;
    private $lastUpdated;
    private $custom_date;

    // Constructor
    public function __construct () {
        $this->homeUrl = esc_url(home_url('/'));
        $this->pluginUrl = esc_url(plugin_dir_url(__FILE__));
        $this->categories = get_option('simple_wp_disp_categories') ? array(0 => 0) : false;
        $this->tags = get_option('simple_wp_disp_tags') ? array(0 => 0) : false;
        $this->authors = get_option('simple_wp_disp_authors') ? array(0 => 0) : false;
        $this->orderby = get_option('simple_wp_order_by');
        @date_default_timezone_set(get_option('timezone_string'));
    }

    // Generates an xml or html sitemap
    public function generateSitemap ($type) {
        if ($type === 'xml' || $type === 'html') {
            $this->$type = true;
            $this->pattern = $this->xml ? 'Y-m-d\TH:i:sP' : 'Y-m-d H:i';
            $this->getOtherPages();
            $this->setUpBlockedUrls();
            $this->setLastUpdated();
            $this->generateContent();
            $this->printOutput();
        }
    }

    // Gets custom urls
    public function getOtherPages () {
        if ($others = get_option('simple_wp_other_urls')) {
            if ($this->orderby === 'modified') {
                uasort($others, array($this, 'sortDate'));
            }
            $xml = array();
            foreach ($others as $other) {
                if ($other && is_array($other)) {
                    $this->custom_date=date($this->pattern, is_int($other['date']) ? $other['date'] : strtotime($other['date']));
                    $xml[] = $this->getXml(esc_url($other['url']), date($this->pattern, is_int($other['date']) ? $other['date'] : strtotime($other['date'])));
                }
            }
            $this->other = $this->sortToString($xml);
        }
    }

    // Sets up blocked urls into an array
    public function setUpBlockedUrls () {
        if (($blocked = get_option('simple_wp_block_urls')) && is_array($blocked)) {
            $this->blockedUrls = array();
            foreach ($blocked as $block) {
                $this->blockedUrls[$block['url']] = true;
            }
        }
    }

    // Sets the "last updated" text
    public function setLastUpdated () {
        $this->lastUpdated = esc_html(($updated = get_option('simple_wp_last_updated')) ? $updated : __('Last updated', 'simple-wp-sitemap'));
    }

    // Checks if blocked url that shouldn't be displayed
    public function isBlockedUrl($url) {
        return $this->blockedUrls && isset($this->blockedUrls[$url]);
    }

    // Returns xml or html
    public function getXml ($url, $date) {
        return $this->xml ? "<url>\n\t<loc>$url</loc>\n\t<lastmod>$date</lastmod>\n</url>\n" : "<li><a href=\"$url\"><span class=\"link\">$url</span><span class=\"date\">$date</span></a></li>";
    }

    // Filters out unnecessary fields
    public function filterPostFields () {
        global $wpdb;
        $p = $wpdb->posts;
        return "$p.ID, $p.post_author, $p.post_date, $p.post_date_gmt, $p.post_title, $p.post_status, $p.post_name, $p.post_modified, $p.post_modified_gmt, $p.post_parent, $p.post_type, $p.comment_count";
    }

    // Generates the sitemaps content
    public function generateContent () {
        add_filter('posts_fields', array($this, 'filterPostFields'));

        $q = new WP_Query(array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'posts_per_page' => 50000, // limit 50k posts
            'has_password' => false,
            'orderby' => $this->orderby ? ($this->orderby === 'parent' ? array('type' => 'DESC', 'parent' => 'DESC') : sanitize_text_field($this->orderby)) : 'date',
            'order' => $this->orderby === 'name' ? 'ASC' : 'DESC',
            'lang' => ''
        ));

        remove_filter('posts_fields', array($this, 'filterPostFields'));

        while ($q->have_posts()) {
            $q->the_post();

            $url = esc_url(get_permalink());
            $date = get_the_modified_date($this->pattern);
            $this->getCategoriesTagsAndAuthor($date);

            if (!$this->isBlockedUrl($url)) {
                if (!$this->home && $url === $this->homeUrl) {
                    $this->home = $this->getXml($url, $date);

                } elseif (get_post_type() === 'page') {
                    $this->pages .= $this->getXml($url, $date);

                } else { // posts (also all custom post types are added here)
                    $this->posts .= $this->getXml($url, $date);
                }
            }
        }
        wp_reset_postdata();
    }

    // Gets a posts categories, tags and author, and compares for last modified date
    public function getCategoriesTagsAndAuthor ($date) {
        if ($this->categories && ($categories = get_the_category())) {
            foreach ($categories as $category) {
                if (!isset($this->categories[($id = $category->term_id)]) || $this->categories[$id] < $date) {
                    $this->categories[$id] = $date;
                }
            }
        }
        if ($this->tags && ($tags = get_the_tags())) {
            foreach ($tags as $tag) {
                if (!isset($this->tags[($id = $tag->term_id)]) || $this->tags[$id] < $date) {
                    $this->tags[$id] = $date;
                }
            }
        }
        if ($this->authors && ($id = get_the_author_meta('ID'))) {
            if (!isset($this->authors[$id]) || $this->authors[$id] < $date) {
                $this->authors[$id] = $date;
            }
        }
    }

    // Prints sitemap xml or html output
    public function printOutput () {
        if ($this->xml) {
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<?xml-stylesheet type=\"text/css\" href=\"", $this->pluginUrl, "css/xml.css\"?>\n<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n\thttp://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
            $this->sortAndPrintSections();
            $this->custom_gen_xml();
            echo '</urlset>';

        } else {
            $title = esc_html(get_option('simple_wp_sitemap_title'));
            echo '<!doctype html><html lang="', get_locale(), '"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>', $title ? $title : esc_html(get_bloginfo('name') . ' ' . __('Html Sitemap', 'simple-wp-sitemap')), '</title><link rel="stylesheet" href="', $this->pluginUrl, 'css/html.css"></head><body><div id="wrapper"><h1>', $title ? $title : sprintf('<a href="%s">%s</a> %s', $this->homeUrl, esc_html(get_bloginfo('name')), esc_html__('Html Sitemap', 'simple-wp-sitemap')), '</h1>';
            $this->sortAndPrintSections();
                $this->custom_gen_html();
            echo '</div></body></html>';
        }
    }

    // Prints sections after sort order
    public function sortAndPrintSections () {
        $orderArray = get_option('simple_wp_disp_sitemap_order');

        if (!$orderArray || !isset($orderArray['home'])) { // Fix for old versions
            require_once 'simpleWpMapOptions.php';
            $ops = new SimpleWpMapOptions();
            $orderArray = $ops->migrateFromOld();
        }
        if (!$this->home) {
            $this->home = $this->getXml($this->homeUrl, date($this->pattern));
        }

        array_walk($orderArray, array($this, 'printSection'));
        $this->attributionLink();
    }

    // Prints a sections xml/html
    public function printSection ($arr, $type) {
        if ($this->$type) {
            $xml = $this->$type;
            unset($this->$type);

            if (in_array($type, array('categories', 'tags', 'authors'))) { // Categories, tags or authors
                $urls = array();
                foreach ($xml as $id => $date) {
                    if ($date) {
                        $url = esc_url($type === 'tags' ? get_tag_link($id) : ($type === 'categories' ? get_category_link($id) : get_author_posts_url($id)));
                        if (!$this->isBlockedUrl($url)) {
                            $urls[] = $this->getXml($url, $date);
                        }
                    }
                }
                $xml = $this->sortToString($urls);
            }
            if ($xml) {
                if ($this->html) {
                    echo '<div class="header"><p class="header-txt">', esc_html($arr['title']), '</p><p class="header-date">', $this->lastUpdated, '</p></div><ul>', $xml, '</ul>';
                } else {
                    echo $xml;
                }
            }
        }
    }

    // Displays attribution link if option is checked
    public function attributionLink () {
        if ($this->html && get_option('simple_wp_attr_link')) {
            echo '<p id="attr"><a id="attr-a" href="', esc_url('https://www.webbjocke.com/simple-wp-sitemap/'), '" target="_blank" rel="noopener">', esc_html__('Generated by: Simple Wp Sitemap', 'simple-wp-sitemap'), '</a></p>';
        }
    }

    // Sorts or shuffles array and returns as string
    public function sortToString ($urls) {
        switch ($this->orderby) {
            case 'name': natcasesort($urls); break;
            case 'rand': shuffle($urls); break;
        }
        return implode('', $urls);
    }

    // Sort function for last modified date
    public function sortDate ($a, $b) {
        return $b['date'] - $a['date'];
    }

    public function custom_gen_xml()
    {
/*
        $url=get_template_directory_uri();
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "$url/intel/lib/all.php?action=getreportXml",
        ));
        $resp = curl_exec($curl);
        $report_urls = json_decode($resp, true);
        foreach($report_urls['success'] as $value){
            $report_url=$value['url_name'];
            $domain_url=get_site_url();
            $date=$value['created_at'];
            $formated_date = date("Y-m-d H:i", strtotime($date));  
        //  echo "<li><a href='$domain_url/report/$report_url'><span class='link'>$domain_url/report/$report_url></span><span class='date'>$date</span></a>"; 
            echo  "<url>\n\t<loc>$domain_url/report/$report_url</loc>\n\t<lastmod>$this->custom_date</lastmod>\n</url>\n";
        }
*/
}
    public function custom_gen_html()
    {
/*
        $url=get_template_directory_uri();
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "$url/intel/lib/all.php?action=getreportXml",
        ));
        $resp = curl_exec($curl);
        $report_urls = json_decode($resp, true);
        foreach($report_urls['success'] as $value){
            $report_url=$value['url_name'];
            $domain_url=get_site_url();
            $date=$value['created_at'];
            $formated_date = date("Y-m-d H:i", strtotime($date));
            echo "<ul><li><a href='$domain_url/report/$report_url'><span class='link'>$domain_url/report/$report_url</span><span class='date'>
            $formated_date
             </span></ul>";
   }
*/
}
}
