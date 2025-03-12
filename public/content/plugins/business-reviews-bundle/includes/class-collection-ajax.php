<?php

namespace WP_Business_Reviews_Bundle\Includes;

use WP_Business_Reviews_Bundle\Includes\Core\Core;

class Collection_Ajax {

    private $core;
    private $assets;
    private $coll_shortcode;
    private $coll_deserializer;

    public function __construct(Assets $assets, Core $core, Collection_Deserializer $coll_deserializer, Collection_Shortcode $coll_shortcode) {

        $this->assets = $assets;
        $this->core = $core;
        $this->coll_deserializer = $coll_deserializer;
        $this->coll_shortcode = $coll_shortcode;

        $brb_ajax_off = get_option('brb_ajax_off');
        if ($brb_ajax_off != 'true') {
            add_action('wp_ajax_brb_get_reviews', array($this, 'get_reviews'));
            add_action('wp_ajax_nopriv_brb_get_reviews', array($this, 'get_reviews'));

            add_action('wp_ajax_brb_embed', array($this, 'embed'));
            add_action('wp_ajax_nopriv_brb_embed', array($this, 'embed'));
        }
    }

    public function get_reviews() {
        $id = $_GET['id'];
        if (isset($id)) {
            $collection = $this->coll_deserializer->get_collection($id);
            $data = $this->core->get_reviews($collection);

            $offset = $_GET['offset'] ? $_GET['offset'] : 0;
            $size = $_GET['size'] ? $_GET['size'] : 10;
            $reviews = array_slice($data['reviews'], $offset, $size);

            wp_send_json(array('reviews' => $reviews));
        }
    }

    public function embed() {
        header('Content-type: application/javascript');
        header('Access-Control-Allow-Origin: *');

        $collection_id = $_GET['brb_collection_id'];
        $view_mode = $_GET['brb_view_mode'];
        $callback = $_GET['brb_callback'];
        $atts = array('id' => $collection_id);

        if (!empty($view_mode)) {
            $atts['view_mode'] = $view_mode;
        }

        $response = $this->coll_shortcode->init($atts);

        if (strlen($response) > 0) {
            $result = array(
                'status' => 'success',
                'data'   => $response
            );
        } else {
            $result = array(
                'status' => 'error'
            );
        }

        if (empty($callback)) {
            echo json_encode($result);
        } else {
            $result['css'] = $this->assets->get_public_styles();
            $result['js'] = $this->assets->get_public_scripts();
            echo $this->embed_code($collection_id, $callback) . $callback . "(" . json_encode($result) . ");";
        }
        die();
    }

    private function embed_code($id, $cb) {
        return 'function ' . $cb . '(e){document.body.querySelector("#brb_collection_' . $id . '").innerHTML=e.data;if(e.css)for(var t=0;t<e.css.length;t++)brb_load_css(e.css[t]);if(e.js)for(var n=0;n<e.js.length;n++)brb_load_js(e.js[n])}function brb_load_js(e,t){var n=document.createElement("script");n.type="text/javascript",n.src=e,n.async="true",t&&n.addEventListener("load",function(e){t(null,e)},!1),document.getElementsByTagName("head")[0].appendChild(n)}function brb_load_css(e){var t=document.createElement("link");t.rel="stylesheet",t.href=e,document.getElementsByTagName("head")[0].appendChild(t)}';
    }
}
