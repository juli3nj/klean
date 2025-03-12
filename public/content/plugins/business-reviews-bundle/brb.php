<?php
/*
Plugin Name: Business Reviews Bundle
Plugin URI: https://richplugins.com/
Description: Business Reviews Bundle is a WordPress plugin to merges and displays any reviews from Google, Facebook and Yelp in the single feed.
Author: RichPlugins <support@richplugins.com>
Version: 1.9.33
Author URI: https://richplugins.com/
*/

namespace WP_Business_Reviews_Bundle;

if (!defined('ABSPATH')) {
    exit;
}

require(ABSPATH . 'wp-includes/version.php');

define('BRB_VERSION'         , '1.9.33');
define('BRB_PLUGIN_FILE',    __FILE__ );
define('BRB_DEBUG'           , get_option('brb_debug'));
define('BRB_PLUGIN_URL'      , plugins_url(basename(plugin_dir_path(__FILE__ )), basename(__FILE__)));
define('BRB_ASSETS_URL'      , BRB_PLUGIN_URL . '/assets/');

define('BRB_GOOGLE_API'      , 'https://maps.googleapis.com/maps/api/place/');
define('BRB_FACEBOOK_API'    , 'https://graph.facebook.com/v16.0/');
define('BRB_YELP_API'        , 'https://api.yelp.com/v3/businesses');

define('BRB_GMB_API_LIMIT'   , 50);
define('BRB_FB_API_LIMIT'    , 25);

define('BRB_AVATAR_SIZE'     , '56');
define('BRB_GOOGLE_AVATAR'   , BRB_ASSETS_URL . 'img/google_avatar.png');
define('BRB_FACEBOOK_AVATAR' , BRB_ASSETS_URL . 'img/fb_avatar.png');
define('BRB_YELP_AVATAR'     , BRB_ASSETS_URL . 'img/yelp_avatar.png');

define('BRB_NEW_LAYOUTS'     , array('tag', 'slider_lite'));

require_once __DIR__ . '/autoloader.php';

$brb_plugin = new Includes\Plugin();
$brb_plugin->register();

?>