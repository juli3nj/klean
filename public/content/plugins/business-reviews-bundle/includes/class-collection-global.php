<?php

namespace WP_Business_Reviews_Bundle\Includes;

class Collection_Global {

    public function register() {
        add_action('wp_footer', array($this, 'global_shortcode'));
    }

    public function global_shortcode() {
        $glob_colls = get_option('brb_glob_colls');
        if (!empty($glob_colls)) {
            $ids = explode(",", $glob_colls);
            foreach ($ids as $id) {
                echo do_shortcode('[brb_collection id=' . $id . ']');
            }
        }
    }
}
