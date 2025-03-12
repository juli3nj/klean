<?php

namespace WP_Business_Reviews_Bundle\Includes\Admin;

class Admin_Notice_License {

    public function register() {
        add_action('admin_notices', array($this, 'license'));
    }

    public function license() {

        $later = isset($_GET['brb_license_later']) ? $_GET['brb_license_later'] : '';
        if ($later == 'later') {
            update_option('brb_license_later', time() + 60 * 60 * 24);
            return;
        }

        $brb_license_later = get_option('brb_license_later');
        if ($brb_license_later > time()) {
            return;
        }

        $brb_license_status = get_option('brb_license_status');
        $brb_license_expired = get_option('brb_license_expired');
        $license_is_active = round(microtime(true) * 1000) < $brb_license_expired;

        if (!$brb_license_status || !$license_is_active) {
            $class = 'notice notice-error is-dismissible';
            $url = remove_query_arg(array('taction', 'tid', 'sortby', 'sortdir', 'opt'));
            $url_later = esc_url(add_query_arg('brb_license_later', 'later', $url));

            $notice = '<p style="font-weight:600;font-size:15px;">' .
                          'Your Business license for the <u>Reviews Bundle</u> plugin is not activated in this case your plugin is not automatically updated.' .
                      '</p>' .
                      '<p style="font-weight:normal;font-size:15px;">' .
                          'It is mandatory to have your license activated because if Google or Facebook updates their reviews API, your plugin does not get new version with this change and may stop working.' .
                      '</p>' .
                      '<p style="font-weight:normal;font-size:15px;">' .
                          'To activate your business license go to the <a href="https://admin.richplugins.com/licenses" target="_blank">Admin Panel</a> (<b>Licenses tab</b>), copy your license code and save on the Settings page:' .
                      '</p>' .
                      '<p>' .
                          '<a href="' . admin_url('admin.php?page=brb-settings&brb_tab=license') . '" style="text-decoration:none;margin:0 10px 0 0;">' .
                              '<button class="button button-primary">Go to Settings page and activate license</button>' .
                          '</a>' .
                          '<a href="' . $url_later . '" style="text-decoration:none;">' .
                              '<button class="button button-secondary">Not now, I will do it later</button>' .
                          '</a>' .
                      '</p>';

            printf('<div class="%1$s" style="position:fixed;top:50px;right:20px;padding-right:30px;z-index:2;margin-left:20px;max-width:600px">%2$s</div>', esc_attr($class), $notice);
        }
    }
}
