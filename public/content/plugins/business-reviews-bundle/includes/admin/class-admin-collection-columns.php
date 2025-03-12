<?php

namespace WP_Business_Reviews_Bundle\Includes\Admin;

class Admin_Collection_Columns {

    private $collection_deserializer;

    private static $plugin_themes = array(
        'flash'        => 'Flash',
        'list'         => 'List',
        'list_thin'    => 'Thin list',
        'grid4'        => 'Grid: 4 columns',
        'grid3'        => 'Grid: 3 columns',
        'grid2'        => 'Grid: 2 columns',
        'slider_lite'  => 'Slider lite',
        'slider'       => 'Slider swiper',
        'badge_inner'  => 'Badge: embed',
        'badge'        => 'Badge: float right',
        'badge_left'   => 'Badge: float left',
        'tag'          => 'Tag',
        'temp'         => 'Rating template',
    );

    public function __construct($collection_deserializer) {
        $this->collection_deserializer = $collection_deserializer;
    }

    public function register() {
        add_filter('get_edit_post_link', array($this, 'modify_edit_post_link'), 10, 3);
        add_filter('manage_edit-brb_collection_columns', array($this, 'get_columns'));
        add_action('manage_brb_collection_posts_custom_column', array($this, 'render'), 10, 2);
        add_filter('post_row_actions', array($this, 'modify_post_row_actions'), 10, 2);
    }

    public function modify_edit_post_link($link, $id, $context) {
        if (function_exists('get_current_screen')) {
            $screen = get_current_screen();
            if (empty($screen) || $screen->post_type !== 'brb_collection') {
                return $link;
            }
            return admin_url('admin.php?page=brb-builder&brb_collection_id=' . $id);
        } else {
            return;
        }
    }

    public function get_columns($columns) {
        $columns = $columns;
        $columns =  array(
            'cb'            => '<input type="checkbox">',
            'title'         => __('Title', 'business-reviews-bundle'),
            'ID'            => __('ID', 'business-reviews-bundle'),
            'brb_theme'     => __('Theme', 'business-reviews-bundle'),
            'brb_shortcode' => __('Shortcode', 'business-reviews-bundle'),
            'date'          => __('Date', 'business-reviews-bundle'),
        );
        return $columns;
    }

    public function render($column_name, $post_id) {
        $args = array();

        if (isset($_GET['post_status'])) {
            $post_status = sanitize_text_field(wp_unslash($_GET['post_status']));

            if ($post_status === 'trash') {
                $args['post_status'] = array('trash');
            }
        }

        $coll = $this->collection_deserializer->get_collection($post_id, $args);
        if (!$coll) {
            return null;
        }

        $connection = json_decode($coll->post_content);

        switch ($column_name) {
            case 'ID':
                echo $coll->ID;
                break;
            case 'brb_theme':
                echo isset($connection->options->view_mode) ? self::$plugin_themes[$connection->options->view_mode] : '';
                break;
            case 'brb_shortcode':
                //echo '[brb_collection id=' . $coll->ID . ']';
                echo '<input type="text" value="[brb_collection id=' . $coll->ID . ']" onclick="this.select(); document.execCommand(\'copy\');var sm=this.nextSibling;sm.className=\'\';setTimeout(function() {sm.className=\'brb_hide\';},10);" readonly=""><small>shortcode copied</small>';
                break;
        }
    }

    public function modify_post_row_actions($actions, $post) {
        if (isset($actions) && $post->post_type === "brb_collection") {
            /*$pre_actions = array(
                'post-id' => '<span class="brb-admin-column-action">ID: ' . $post->ID . '</span>',
            );*/
            $custom_actions = array(
                'post-clone' => '<a href="' . admin_url('admin.php?page=brb-builder&brb_clone=true&brb_collection_id=' . $post->ID) . '">Clone</a>',
            );
            array_splice($actions, 1, 0, $custom_actions);
        }
        return $actions;
    }

}
