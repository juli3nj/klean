<?php

namespace WP_Business_Reviews_Bundle\Includes\View;

class View2 {

    private $view_helper;
    private $view_reviews;

    public function __construct(View_Reviews $view_reviews, View_Helper $view_helper) {
        $this->view_reviews = $view_reviews;
        $this->view_helper = $view_helper;
    }

    public function render($coll_id, $bizs, $revs, $opts) {
        ?><r-p><?php
        switch ($opts->view_mode) {
            case 'tag':
                $this->render_tag($coll_id, $bizs, $revs, $opts);
                break;
        }
        switch ($opts->view_mode) {
            case 'slider_lite':
                $this->render_slider($coll_id, $bizs, $revs, $opts);
                break;
        }
        ?></r-p><?php
    }

    public function render_tag($coll_id, $bizs, $revs, $opts) {
        $tag_cls = array();
        if ($opts->tag_popup > 0) {
            array_push($tag_cls, 'rplg-pop');
        }
        if (strlen($opts->tag_pos) > 0) {
            array_push($tag_cls, $opts->tag_pos);
        }
        if ($opts->tag_push) {
            array_push($tag_cls, 'push');
        }
        if ($opts->tag_expand) {
            array_push($tag_cls, 'expand');
        }

        $inner_cls = array();
        if ($opts->tag_review) {
            array_push($inner_cls, 'rplg-tag-review');
        }

        $stars_info = implode(',', array($bizs[0]->rating, '', $opts->tag_color_stars));
        $stars_info2 = implode(',', array(5, '', $opts->tag_color_stars));
        ?>
        <rp-tag data-id="<?php echo $coll_id; ?>" data-opts='<?php echo $this->tag_options($opts); ?>' class="<?php echo implode(' ', $tag_cls); ?> "data-exec="">
            <?php if ($opts->tag_text) { ?><rp-tag-text><?php echo $opts->tag_text; ?></rp-tag-text><?php } ?>
            <rp-tag-inner class="<?php echo implode(' ', $inner_cls); ?>" <?php $this->render_tag_click($bizs, $opts); ?>>
                <?php $this->logo($bizs[0]->platform); ?>
                <rp-stars-wrap>
                    <rp-stars data-info="<?php echo $stars_info; ?>">
                        <?php echo $this->stars2($bizs[0]->rating); ?>
                    </rp-stars>
                    <?php if ($opts->tag_review) { ?>
                    <rp-stars data-info="<?php echo $stars_info2; ?>" data-reviewus="<?php echo $this->get_writereview_url($bizs[0]); ?>"></rp-stars>
                    <?php } ?>
                </rp-stars-wrap>
                <rp-rating><?php echo $bizs[0]->rating; ?></rp-rating>
            </rp-tag-inner>
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="js_loader" onload="(function(el) { var t = setInterval(function() {if (window.RichPlugins && !el.getAttribute('data-exec')) { RichPlugins.Tag(el).init(); el.setAttribute('data-exec', '1'); clearInterval(t) }}, 200)})(this.parentNode)" width="1" height="1" style="display:none">
        </rp-tag>
        <?php
        if ($opts->tag_click == 'sidebar') {
        ?>
        <rp-sb style="display:none">
            <rp-sbb></rp-sbb>
            <rp-sbc>
                <rp-sbci></rp-sbci>
            </rp-sbc>
            <rp-sbx>×</rp-sbx>
        </rp-sb>
        <?php
        }
    }

    public function render_tag_click($bizs, $opts) {
        switch ($opts->tag_click) {
            case 'reviews':
                $this->view_helper->window_open($this->get_allreview_url($bizs[0]), $opts);
                break;
            case 'link':
                $this->view_helper->window_open($opts->tag_link, $opts);
                break;
        }
    }

    public function render_slider($coll_id, $bizs, $revs, $opts) {
        $count = count($revs);
        $brb_ajax_off = get_option('brb_ajax_off');
        $reviews = $brb_ajax_off != 'true' && $count > 0 && $opts->pagination > 0 ? array_slice($revs, 0, $opts->pagination) : $revs;
        $offset  = count($reviews);
        ?>
        <rp-slider data-id="<?php echo $coll_id; ?>" data-count="<?php echo $count; ?>" data-offset="<?php echo $offset; ?>" data-rs="<?php echo $opts->review_style; ?>" data-opts='<?php echo $this->slider_options($opts); ?>' data-exec="" <?php if ($opts->dark_theme) { ?>data-color="dark"<?php } ?>>
            <?php if (!$opts->slider_hide_head && count($bizs) > 0) { $biz = $bizs[0]; ?>
            <rp-header>

                <?php if (!$opts->header_hide_photo) { ?>
                <rp-flex class="rplg-center">
                    <img class="rplg-img" src="<?php echo $biz->photo; ?>" <?php if ($opts->lazy_load_img) { ?>loading="lazy"<?php } ?> alt="<?php echo $biz->name; ?>">
                    <rp-flex class="rplg-column">
                        <?php $this->header_info($biz, $opts); ?>
                    </rp-flex>
                </rp-flex>
                <?php } else { ?>
                    <?php $this->header_info($biz, $opts); ?>
                <?php } ?>

                <?php if (!$opts->header_hide_count) { ?>
                <rp-based>
                    <?php printf(esc_html__('Based on %s reviews from', 'brb'), $biz->review_count); $this->logo($biz->platform); ?>
                </rp-based>
                <?php }
                if (!$opts->header_hide_seeall) {
                    $this->reviews_all($biz);
                }
                if (!$opts->header_hide_write) {
                    $this->review_us_on($biz);
                }
                ?>
            </rp-header>
            <?php } if ($count > 0) { ?>
            <rp-content>
                <rp-reviews>
                    <?php
                    foreach ($reviews as $review) {
                        $this->review($review, $opts);
                    }
                    ?>
                </rp-reviews>
                <?php if (!$opts->slider_hide_nextprev) { ?>
                <rp-controls>
                    <rp-btn-prev>
                        <svg viewBox="0 0 24 24"><path d="M14.6,18.4L8.3,12l6.4-6.4l0.7,0.7L9.7,12l5.6,5.6L14.6,18.4z"></path></svg>
                    </rp-btn-prev>
                    <rp-btn-next>
                        <svg viewBox="0 0 24 24"><path d="M9.4,18.4l-0.7-0.7l5.6-5.6L8.6,6.4l0.7-0.7l6.4,6.4L9.4,18.4z"></path></svg>
                    </rp-btn-next>
                </rp-controls>
                <?php } if (!$opts->slider_hide_pagin) { ?>
                <rp-dots></rp-dots>
                <?php } ?>
            </rp-content>
            <?php } ?>
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="js_loader" onload="(function(el) { var t = setInterval(function() {if (window.RichPlugins && !el.getAttribute('data-exec')) { RichPlugins.Slider(el).init(); el.setAttribute('data-exec', '1'); clearInterval(t) }}, 200)})(this.parentNode)" width="1" height="1" style="display:none">
        </rp-slider>
        <?php
    }

    private function header_info($biz, $opts) {
        if (!$opts->header_hide_scale) { ?>
        <rp-scale><?php echo __($this->scale($biz->rating), 'brb'); ?></rp-scale>
        <?php } ?>
        <?php if (!$opts->header_hide_name) { ?>
        <rp-name><?php echo $biz->name; ?></rp-name>
        <?php } ?>
        <rp-score>
            <rp-rating><?php echo $biz->rating; ?></rp-rating>
            <rp-stars data-info="<?php echo implode(',', array($biz->rating, '', $opts->color_stars)); ?>">
                <?php echo $this->stars2($biz->rating); ?>
            </rp-stars>
        </rp-score>
        <?php
    }

    private function review($review, $opts) {
        ?>
        <rp-review>
            <rp-review-inner>
                <?php if ($opts->review_style == 1) { $this->review_head($review, $opts); } ?>
                <rp-stars data-info="<?php echo implode(',', array($review->rating, $review->provider, $opts->color_stars)); ?>">
                    <?php $this->stars($review->rating); ?>
                </rp-stars>
                <rp-body>

                    <rp-review-text class="rplg-scroll"><?php echo $review->text; ?></rp-review-text>

                    <?php if  (isset($review->media)) { ?>
                    <rp-media>
                    <?php foreach ($review->media as $media) { ?>
                        <rp-thumb onclick="_rplg_popup('<?php echo $media->googleUrl; ?>', 800, 600)"
                                  style="background-image:url(<?php echo str_replace('=s300', '=s50', $media->thumbnailUrl); ?>)"
                                  class="rplg-clickable"></rp-thumb>
                    <?php } ?>
                    </rp-media>
                    <?php } ?>

                    <?php if  (isset($review->reply)) { ?>
                    <rp-reply class="rplg-scroll">
                        <rp-b>Response from the owner</rp-b><?php echo $review->reply; ?>
                    </rp-reply>
                    <?php } ?>

                </rp-body>
                <rp-logo data-provider="<?php echo $review->provider; ?>"></rp-logo>
            </rp-review-inner>
            <?php if ($opts->review_style == 2) { $this->review_head($review, $opts); } ?>
        </rp-review>
        <?php
    }

    private function review_head($review, $opts) {
        ?>
        <rp-flex>
            <?php if (isset($review->author_avatar)) { ?>
            <img class="rplg-img" src="<?php echo $review->author_avatar; ?>" <?php if ($opts->lazy_load_img) { ?>loading="lazy"<?php } ?> alt="<?php echo isset($review->author_name) ? $review->author_name : 'Review author'; ?>">
            <?php } ?>
            <rp-review-info><?php
                if (isset($review->author_name)) $this->review_name($review, $opts);
                if (isset($review->time)) { ?><rp-review-time data-time="<?php echo $review->time; ?>"></rp-review-time><?php } ?>
            </rp-review-info>
        </rp-flex>
        <?php
    }

    private function review_name($review, $opts) {
        ?><rp-review-name title="<?php echo $review->author_name; ?>"><?php
        if (isset($review->author_url) && strlen($review->author_url) > 0) {
            $this->view_helper->anchor($review->author_url, '', $review->author_name, $opts->open_link, $opts->nofollow_link);
        } else {
            echo $review->author_name;
        }
        ?></rp-review-name><?php
    }

    private function tag_options($opts) {
        return json_encode(
            array(
                'tag_expand'       => $opts->tag_expand,
                'tag_popup'        => $opts->tag_popup,
                'tag_color'        => $opts->tag_color,
                'tag_color_text'   => $opts->tag_color_text,
                'tag_color_rating' => $opts->tag_color_rating,
                'tag_size_logo'    => $opts->tag_size_logo,
                'tag_size_star'    => $opts->tag_size_star,
                'tag_size_rating'  => $opts->tag_size_rating,
                'tag_click'        => $opts->tag_click,
                'tag_sidebar'      => $opts->tag_sidebar
            )
        );
    }

    private function slider_options($opts) {
        return json_encode(
            array(
                'speed'                => $opts->slider_speed ? $opts->slider_speed : 5,
                'autoplay'             => $opts->slider_autoplay,
                'wheelscroll'          => $opts->slider_wheelscroll,
                'mousestop'            => $opts->slider_mousestop,
                'clickstop'            => $opts->slider_clickstop,
                'swipe_step'           => $opts->slider_swipe_step,
                'swipe_per_btn'        => $opts->slider_swipe_per_btn,
                'swipe_per_dot'        => $opts->slider_swipe_per_dot,
                'pagination'           => $opts->pagination,
                'text_size'            => $opts->text_size,
                'time_format'          => $opts->time_format,
                'hide_avatar'          => $opts->hide_avatar,
                'hide_name'            => $opts->hide_name,
                'disable_review_time'  => $opts->disable_review_time,
                'disable_user_link'    => $opts->disable_user_link,
                'disable_google_link'  => $opts->disable_google_link,
                'open_link'            => $opts->open_link,
                'nofollow_link'        => $opts->nofollow_link,
                'lazy_load_img'        => $opts->lazy_load_img,
                'color_review'         => $opts->color_review,
                'color_border'         => $opts->color_border,
                'color_text'           => $opts->color_text,
                'color_scale'          => $opts->color_scale,
                'color_based'          => $opts->color_based,
                'color_name'           => $opts->color_name,
                'color_time'           => $opts->color_time,
                'color_stars'          => $opts->color_stars,
                'color_btn'            => $opts->color_btn,
                'color_prev_next'      => $opts->color_prev_next,
                'color_dot'            => $opts->color_dot,
                'slider_space_between' => $opts->slider_space_between,
                'slider_review_height' => $opts->slider_review_height,
                'slider_breakpoints'   => $opts->slider_breakpoints,
                'trans'                => array(
                    'read more' => __('read more', 'brb')
                )
            )
        );
    }

    private function scale($rating) {
        if ($rating > 4.2) {
            return 'Excellent';
        } elseif ($rating > 3.7) {
            return 'Great';
        } elseif ($rating > 2.7) {
            return 'Good';
        } elseif ($rating > 1.7) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }

    private function logo($platform) {
        if (is_array($platform)) {
            foreach ($platform as $p) {
                echo '<rp-logo data-provider="' . $p . '"></rp-logo>';
            }
        } else {
            echo '<rp-logo data-provider="' . $platform . '"></rp-logo>';
        }
    }

    private function reviews_all($biz) {
        if ($biz->id == 'summary' && strlen($biz->wr) > 0) {
            $pair = explode(':', $biz->wr);
            $biz->provider = $pair[0];
            $biz->id = $pair[1];
        }
        ?>
        <rp-review_us class="rplg-clickable">
            <a href="<?php echo $this->get_allreview_url($biz); ?>" target="_blank" rel="noopener"><?php echo __('See all reviews', 'brb'); ?></a>
        </rp-review_us>
        <?php
    }

    private function review_us_on($biz) {
        if ($biz->id == 'summary' && strlen($biz->wr) > 0) {
            $pair = explode(':', $biz->wr);
            $biz->provider = $pair[0];
            $biz->id = $pair[1];
        }
        ?>
        <rp-review_us class="rplg-clickable" onclick="_rplg_popup('<?php echo $this->get_writereview_url($biz); ?>', 800, 600)">
            <?php echo __('review us on', 'brb'); ?><?php $this->logo($biz->provider); ?>
        </rp-review_us>
        <?php
    }

    private function get_writereview_url($biz) {
        $id = $biz->id;
        switch ($biz->provider) {
            case 'google':
                return 'https://search.google.com/local/writereview?placeid=' . $id;
            case 'facebook':
                return 'https://facebook.com/' . $id . '/reviews';
            case 'yelp':
                return 'https://www.yelp.com/writeareview/biz/' . $id;
        }
    }

    private function get_allreview_url($biz) {
        if ($biz->id == 'summary' && strlen($biz->wr) > 0) {
            $pair = explode(':', $biz->wr);
            $biz->provider = $pair[0];
            $biz->id = $pair[1];
        }
        switch ($biz->provider) {
            case 'google':
                return 'https://search.google.com/local/reviews?placeid=' . $biz->id;
            case 'facebook':
                return 'https://facebook.com/' . $biz->id . '/reviews';
            case 'yelp':
                return $biz->url;
        }
    }

    private function stars($rating) {
        for ($i = 0; $i < 5; $i++) echo $i < $rating ? '★' : '☆';
    }

    private function stars2($rating) {
        $stars = '';
        for ($i = 0; $i < 5; $i++) {
            $score = $rating - $i;
            if ($score < 0) {
                $stars .= '<rp-star>☆</rp-star>';
            } elseif ($score > 0 && $score < 1) {
                if ($score < 0.25) {
                    $stars .= '<rp-star>☆</rp-star>';
                } elseif ($score > 0.75) {
                    $stars .= '<rp-star>★</rp-star>';
                } else {
                    $stars .= '<rp-star class="rp-sh">☆</rp-star>';
                }
            } else {
                $stars .= '<rp-star>★</rp-star>';
            }
        }
        return $stars;
    }

}
