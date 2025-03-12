<?php

namespace WP_Business_Reviews_Bundle\Includes;

use WP_Business_Reviews_Bundle\Includes\Core\Core;
use WP_Business_Reviews_Bundle\Includes\View\View;

class Collection_Shortcode {

    private $core;
    private $view;
    private $assets;
    private $collection_deserializer;

    public function __construct(Collection_Deserializer $collection_deserializer, Core $core, View $view, Assets $assets) {
        $this->collection_deserializer = $collection_deserializer;
        $this->core = $core;
        $this->view = $view;
        $this->assets = $assets;
    }

    public function register() {
        add_shortcode('brb_collection', array($this, 'init'));
    }

    public function init($atts) {
        if (get_option('brb_active') === '0') {
            return '';
        }

        $pair = array('id' => 0);
        foreach (Core::get_default_settings() as $opt_name => $opt_val) {
            if (array_key_exists($opt_name, $atts)) {
                $pair[$opt_name] = strip_tags(stripslashes($atts[$opt_name]));
            }
        }

        $atts = shortcode_atts($pair, $atts, 'brb_collection');

        $collection = $this->collection_deserializer->get_collection($atts['id']);

        if (!$collection) {
            return null;
        }

        // If atts has only ID param, call get_reviews without atts to support cache from the reviews collection builder
        $data = count($atts) > 1 ? $this->core->get_reviews($collection, $atts) : $this->core->get_reviews($collection);

        // Error handling
        if ($data === false) {
            return null;
        }

        $businesses = $data['businesses'];
        $reviews = $data['reviews'];
        $options = $data['options'];

        if (isset($options->page_include) && strlen($options->page_include) > 0 && !$this->page_found($options->page_include)) {
            return null;
        }

        if (isset($options->page_exclude) && strlen($options->page_exclude) > 0 && $this->page_found($options->page_exclude)) {
            return null;
        }

        $brb_demand_assets = get_option('brb_demand_assets');
        if ($brb_demand_assets || $brb_demand_assets == 'true') {
            $this->assets->enqueue_public_styles();
            $this->assets->enqueue_public_scripts();
        }

        return $this->view->render($collection->ID, $businesses, $reviews, $options);
    }

    public function page_found($page_opt) {
        $url_path = $this->get_current_path();
        $page_opt = urldecode($page_opt);
        $pages = explode(',', $page_opt);
        foreach ($pages as $page) {
            $page = trim(urldecode($page));
            if (fnmatch($page, $url_path)) {
                return true;
            }
        }
        return false;
    }

    private function get_current_path() {
        $url = parse_url(home_url($_SERVER['REQUEST_URI']));
        $url_path = $url['path'];
        if ($url_path === '/wp-admin/admin-ajax.php') {
            $url = parse_url(wp_get_referer());
            $url_path = $url['path'];
        }
        return $url_path;
    }
}
