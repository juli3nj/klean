<?php

namespace WP_Business_Reviews_Bundle\Includes;

use WP_Business_Reviews_Bundle\Includes\Core\Core;
use WP_Business_Reviews_Bundle\Includes\View\View;

class Collection_Serializer_Ajax {

    private $core;
    private $view;
    private $serializer;
    private $deserializer;

    public function __construct(Collection_Serializer $serializer, Collection_Deserializer $deserializer, Core $core, View $view) {
        $this->serializer = $serializer;
        $this->deserializer = $deserializer;
        $this->core = $core;
        $this->view = $view;

        add_action('wp_ajax_brb_collection_save_ajax', array($this, 'save_ajax'));
    }

    public function save_ajax() {

        $post_id = $this->serializer->save($_POST['post_id'], $_POST['title'], $_POST['content']);

        if (isset($post_id)) {
            $collection = $this->deserializer->get_collection($post_id);

            $data = $this->core->get_reviews($collection);
            $businesses = $data['businesses'];
            $reviews = $data['reviews'];
            $options = $data['options'];

            wp_send_json(['html' => $this->view->render($collection->ID, $businesses, $reviews, $options), 'errors' => $data['errors']]);

            //echo $this->view->render($collection->ID, $businesses, $reviews, $options);
        }

        wp_die();
    }

}
