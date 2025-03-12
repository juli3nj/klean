<?php

namespace WP_Business_Reviews_Bundle\Includes;

use WP_Business_Reviews_Bundle\Includes\Core\Database;

class Plugin_Updates {

    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function update_1_9_18() {
        $wp_query = new \WP_Query();

        $wp_query->query(array(
            'post_type'      => 'brb_collection',
            'fields'         => array('ID', 'post_title', 'post_content'),
            'posts_per_page' => 300,
            'no_found_rows'  => true,
        ));
        $collections = $wp_query->posts;

        foreach ($collections as $coll) {

            $conn = json_decode($coll->post_content);

            if (!isset($conn->connections)) {

                $conn->connections = array();

                if (isset($conn->google)) {
                    foreach ($conn->google as $g) {
                        $g->platform = 'google';
                        array_push($conn->connections, $g);
                    }
                    unset($conn->google);
                }

                if (isset($conn->facebook)) {
                    foreach ($conn->facebook as $f) {
                        $f->platform = 'facebook';
                        array_push($conn->connections, $f);
                    }
                    unset($conn->facebook);
                }

                if (isset($conn->yelp)) {
                    foreach ($conn->yelp as $y) {
                        $y->platform = 'yelp';
                        array_push($conn->connections, $y);
                    }
                    unset($conn->yelp);
                }

                if (count($conn->connections) > 0) {
                    $post_id = wp_insert_post(array(
                        'ID'           => $coll->ID,
                        'post_title'   => $coll->post_title,
                        'post_content' => json_encode($conn, JSON_UNESCAPED_UNICODE),
                        'post_type'    => 'brb_collection',
                        'post_status'  => 'publish',
                    ));
                }
            }
        }
    }
}
