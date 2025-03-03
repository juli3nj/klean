<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApcServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /**
         * Disable admin bar
         */
        add_filter('show_admin_bar', '__return_false');

        add_filter('excerpt_length', function () {
            return 10;
        });

        add_filter('wp_is_mobile', function ($is_mobile) {
            if ($is_mobile) {
                return true;
            }

            // Détection des tablettes via user-agent
            $tablet_agents = [
                'iPad',
                'Android',
                'Silk',
                'Tablet',
                'PlayBook',
                'Kindle',
                'Nexus 7',
                'Nexus 10',
            ];

            foreach ($tablet_agents as $tablet_agent) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], $tablet_agent) !== false) {
                    return true;
                }
            }

            return false; // Si aucun match, on considère que ce n'est pas mobile/tablette
        });

        add_filter('tiny_mce_before_init', function ($init) {

            $custom_colours = '
                 "FF7D1A", "primary-800",
                 "FF9340", "primary-600",
                 "FFCDA7", "primary",
                 "FCDFC9", "primary-200",
                 "FFF3EA", "primary-100",
                 "242424", "secondary-1000",
                 "353434", "secondary-900",
                 "6A6A6C", "secondary-800",
                 "989899", "secondary",
                 "DDDDDE", "secondary-200",
                 "F3F3F3", "secondary-100"
            ';
            $init['textcolor_map'] = '['.$custom_colours.']';
            $init['textcolor_rows'] = 2;

            return $init;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
