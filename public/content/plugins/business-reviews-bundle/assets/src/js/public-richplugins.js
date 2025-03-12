var RichPlugins = RichPlugins || {

    Instances: {
        Tags: {},
        Sliders: {}
    },

    Utils: {

        __: function(text, trans) {
            return trans[text] || text;
        },

        ajax: function(url, cb) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
              if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                cb(JSON.parse(xhr.responseText));
              }
            };
            xhr.send();
        },

        time: function(time, format) {
            return format ? time : WPacTime.getTimeAgo(parseInt(time) * 1000, _rplg_lang());
        },

        trimtext: function(text, size, trans) {
            if (text && size && text.length > size) {
                var subtext = text.substring(0, size),
                    idx = subtext.indexOf(' ') + 1;

                if (idx < 1 || size - idx > (size / 2)) {
                    idx = size;
                }

                var vtext = '', invtext = '';
                if (idx > 0) {
                    vtext = text.substring(0, idx - 1);
                    invtext = text.substring(idx - 1, text.length);
                }

                return vtext + (invtext ? '<rp-s>... </rp-s><rp-h>'+invtext+'</rp-h><rp-readmore>'+this.__('read more', trans)+'</rp-readmore>' : '');
            } else {
                return text;
            }
        },

        opentext: function() {
            var a = this.previousSibling.previousSibling,
                show = a.tagName == 'RP-S' ? true : false,
                b = document.createElement(show ? 'rp-h' : 'rp-s');
            b.innerHTML = a.innerHTML;
            a.replaceWith(b);

            var c = this.previousSibling,
                d = document.createElement(show ? 'rp-s' : 'rp-h');
            d.innerHTML = c.innerHTML;
            c.replaceWith(d);

            RichPlugins.Utils.rm(this);
        },

        anchor: function(url, text, opts) {
            let rel = [];
            if (opts.open_link) {
                rel.push('noopener');
            }
            if (opts.nofollow_link) {
                rel.push('nofollow');
            }
            rel = rel.length ? 'rel="' + rel.join(' ') + '"' : '';
            return '<a href="' + url + '" ' + (opts.open_link ? 'target="_blank"' : '') + ' ' + rel + '>' + text + '</a>';
        },

        media: function(media) {
            var el = document.createElement('rp-media');
            for (let i = 0; i < media.length; i++) {
                var thumb = document.createElement('rp-thumb');
                thumb.setAttribute('onclick', '_rplg_popup(\'' + media[i].googleUrl + '\', 800, 600)');
                thumb.setAttribute('style', 'background-image:url(' + media[i].thumbnailUrl + ')');
                thumb.className = 'rplg-clickable';
                el.appendChild(thumb);
            }
            return el;
        },

        reply: function(reply) {
            var el = document.createElement('rp-reply');
            el.className = 'rplg-scroll';
            el.innerHTML = '<rp-b>Response from the owner</rp-b>' + reply;
            return el;
        },

        rm: function(el) {
            el && el.parentNode.removeChild(el);
        },

        brsCompare: function(a, b) {
            return parseInt(a.split(':')[0]) > parseInt(b.split(':')[0]) ? 1 : -1;
        },

        reviewsInit: function(el, options) {
            let reviewsEl = el.querySelectorAll('rp-review');
            for (let i = 0; i < reviewsEl.length; i++) {
                RichPlugins.Utils.reviewInit(reviewsEl[i], options);
            }
        },

        reviewInit: function(reviewEl, options) {
            let timeEl  = reviewEl.querySelector('rp-review-time'),
                textEl  = reviewEl.querySelector('rp-review-text'),
                starsEl = reviewEl.querySelector('rp-stars'),
                logoEl  = reviewEl.querySelector('rp-logo');

            /*if (options.color_review) {
                let innerEl  = reviewEl.querySelector('rp-review-inner');
                innerEl.style.background = options.color_review;
            }*/

            /*if (options.color_name) {
                let nameEl  = reviewEl.querySelector('rp-review-name');
                nameEl.style.color = options.color_name;
            }*/

            RichPlugins.Utils.starsInit(starsEl);

            logoEl.innerHTML = render_logo(logoEl.getAttribute('data-provider'));

            if (timeEl) {
                timeEl.innerHTML = RichPlugins.Utils.time(timeEl.getAttribute('data-time'), options.time_format);
            }

            if (textEl.innerHTML) {
                textEl.innerHTML = RichPlugins.Utils.trimtext(textEl.innerHTML, options.text_size, options.trans);
                var readmoreEl = textEl.querySelector('rp-readmore')
                if (readmoreEl) {
                    readmoreEl.onclick = RichPlugins.Utils.opentext;
                }
            }
        },

        starsInit: function(starsEl) {
            let starsInfo = starsEl.getAttribute('data-info').split(',');
            starsEl.innerHTML = render_stars(starsInfo[0], starsInfo[1], starsInfo[2]);
        }
    },

    /**
     * Tag layout
     */
    Tag: function(rootEl) {

        const collId = rootEl.getAttribute('data-id'),
            options  = JSON.parse(rootEl.getAttribute('data-opts'));

        var THIS = RichPlugins.Instances.Tags[collId];

        return THIS = {

            init: function() {
                _rplg_add_svg();

                let logoEls = rootEl.querySelectorAll('rp-logo'),
                    starsEl = rootEl.querySelector('rp-stars'),
                    starsReviewUsEl = rootEl.querySelector('rp-stars[data-reviewus]');

                if (starsEl) {
                    RichPlugins.Utils.starsInit(starsEl);
                }

                if (starsReviewUsEl) {
                    RichPlugins.Utils.starsInit(starsReviewUsEl);

                    starsReviewUsEl.onclick = function(e) {
                        var svg = e.target.tagName == 'svg' ? e.target : e.target.parentNode,
                            idx = [...svg.parentNode.children].indexOf(svg);
                        _rplg_popup(idx > 2 ? this.getAttribute('data-reviewus') : 'https://app.richplugins.com/feedback?s=' + idx, 800, 600);
                    };
                }

                for (let i = 0; i < logoEls.length; i++) {
                    logoEls[i].innerHTML = render_logo(logoEls[i].getAttribute('data-provider'));
                }

                if (options.tag_popup > 0) {
                    setTimeout(function() {
                        rootEl.className += ' rplg-pop-up';
                    }, options.tag_popup * 1000);
                }

                if (options.tag_click == 'sidebar') {
                    let sbEl = rootEl.parentNode.querySelector('rp-sb'),
                        sbxEl = sbEl.querySelector('rp-sbx');

                    sbxEl.onclick = function(e) {
                        sbEl.style.display = sbEl.style.display == 'none' ? 'block' : 'none';
                    };

                    rootEl.onclick = function(e) {
                        sbEl.style.display = sbEl.style.display == 'none' ? 'block' : 'none';

                        let sbciEl = sbEl.querySelector('rp-sbci');
                        if (sbciEl.innerHTML == '') {
                            let url  = brb_vars.ajaxurl + '?action=brb_embed&id=' + collId + '&brb_view_mode=' + options.tag_sidebar;
                            RichPlugins.Utils.ajax(url, function(json) {
                                sbciEl.innerHTML = json.data;

                                let sliderEl = sbciEl.querySelector('rp-slider');
                                sliderEl.setAttribute('data-exec', 1);
                                RichPlugins.Slider(sliderEl).init();
                            });
                        }
                    };
                }

                THIS.stylesInit();

                RichPlugins.Instances.Tags[collId] = THIS;
                console.log('RichPlugins slider initialized');
            },

            stylesInit: function() {
                let style = '',
                    styleEl = document.getElementById('rplg-style') || document.createElement('style');
                styleEl.id = 'rplg-style';

                if (options.tag_color) {
                    style += 'r-p rp-tag-inner' +
                             '{background:' + options.tag_color + '!important}';
                }

                if (options.tag_color_text) {
                    style += 'r-p rp-tag rp-tag-text' +
                             '{color:' + options.tag_color_text + '!important}';
                }

                if (options.tag_color_rating) {
                    style += 'r-p rp-tag-inner rp-rating' +
                             '{color:' + options.tag_color_rating + '!important}';
                }

                if (options.tag_size_logo) {
                    style += 'r-p rp-tag rp-logo svg' +
                             '{width:' + options.tag_size_logo + '!important;height:' + options.tag_size_logo + '!important}';
                }

                if (options.tag_size_star) {
                    style += 'r-p rp-tag rp-stars svg' +
                             '{width:' + options.tag_size_star + '!important;height:' + options.tag_size_star + '!important}';
                }

                if (options.tag_size_rating) {
                    style += 'r-p rp-tag rp-rating' +
                             '{font-size:' + options.tag_size_rating + '!important}';
                }

                styleEl.innerHTML = style;
                document.head.appendChild(styleEl);
            }

        }
    },

    /**
     * Slider lite layout
     */
    Slider: function(rootEl) {

        const TIMEOUT_INIT        = 300,
            TIMEOUT_RESIZE        = 150,
            TIMEOUT_RESIZE_COLUMN = 200,
            TIMEOUT_SCROLL        = 150,

            collId       = rootEl.getAttribute('data-id'),
            contentEl    = rootEl.querySelector('rp-content'),
            reviewsEl    = rootEl.querySelector('rp-reviews'),
            ctrlEl       = rootEl.querySelector('rp-controls'),
            dotsEl       = rootEl.querySelector('rp-dots'),
            reviewsCount = parseInt(rootEl.getAttribute('data-count')),
            options      = JSON.parse(rootEl.getAttribute('data-opts'));

        var THIS            = RichPlugins.Instances.Sliders[collId],
            reviewsList     = rootEl.querySelectorAll('rp-review'),
            rootElSize      = '',
            resizeTimout    = null,
            swipeAutoTimout = null,
            scrollTimeout   = null,
            wheelTimeout    = null,

            mouseOver   = false,
            btnClickWas = false,

            wheelSpeed  = 0,
            reviewsBack = 0;

        if (THIS != null) {
            THIS.clear();
        }

        return THIS = {

            init: function() {
                if (THIS.isVisible(rootEl)) {
                    setTimeout(function() {
                        THIS.resize();
                        THIS.actions();
                    }, 1);
                    if (reviewsList.length) {
                        THIS.swipeAutoStart();
                    }
                } else {
                    setTimeout(THIS.init, TIMEOUT_INIT);
                }

                RichPlugins.Instances.Sliders[collId] = THIS;
                console.log('RichPlugins slider initialized');
            },

            isVisible: function(el) {
                return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length) && window.getComputedStyle(el).visibility !== 'hidden';
            },

            resize: function(vv) {
                var size,
                    offsetWidth = rootEl.offsetWidth,
                    currBrPoint = rootEl.getAttribute('data-col');

                if (offsetWidth < 510) {
                    size = 'xs';
                } else if (offsetWidth < 750) {
                    size = 'x';
                } else if (offsetWidth < 1100) {
                    size = 's';
                } else if (offsetWidth < 1450) {
                    size = 'm';
                } else if (offsetWidth < 1800) {
                    size = 'l';
                } else {
                    size = 'xl';
                }
                rootEl.className = 'rp-col-' + size;

                if (options.slider_breakpoints) {
                    var brs = options.slider_breakpoints.split(',');
                    brs.sort(RichPlugins.Utils.brsCompare);

                    for (var i = 0; i < brs.length; i++) {
                        var vals = brs[i].split(':');
                        if (offsetWidth < parseInt(vals[0])) {
                            rootEl.setAttribute('data-col', vals[1]);
                            break;
                        }
                    }
                }

                if (reviewsList.length && (rootElSize != size || currBrPoint != rootEl.getAttribute('data-col'))) {
                    setTimeout(function() {

                        if (reviewsEl.scrollLeft != vv * THIS.reviewWidth()) {
                            reviewsEl.scrollLeft = vv * THIS.reviewWidth();
                        }

                        THIS.dotsInit();
                        THIS.setActiveDot();
                        rootElSize = size;
                    }, TIMEOUT_RESIZE_COLUMN);
                }

                if (ctrlEl) {
                    ctrlEl.style.top = parseInt(THIS.reviewHeight() / 2) + 'px';
                }
            },

            actions: function() {
                _rplg_add_svg();

                THIS.stylesInit();

                THIS.headerInit();

                RichPlugins.Utils.reviewsInit(rootEl, options);

                if (options.mousestop) {
                    THIS.addMouseEvents();
                }

                window.addEventListener('resize', THIS.resizeListener);

                if (reviewsEl) {
                    reviewsEl.addEventListener('scroll', THIS.scrollListener, false);

                    if (options.wheelscroll) {
                        contentEl.addEventListener('wheel', THIS.wheelListener, false);
                    }
                }

                var prev = rootEl.querySelector('rp-btn-prev');
                if (prev) {
                    prev.onclick = function() {
                        THIS.btnClick(-1);
                    };
                }

                var next = rootEl.querySelector('rp-btn-next');
                if (next) {
                    next.onclick = function() {
                        THIS.btnClick(1);
                    };
                }
            },

            resizeListener: function() {
                var vv = reviewsBack;
                clearTimeout(resizeTimout);
                resizeTimout = setTimeout(THIS.resize, TIMEOUT_RESIZE, vv);
            },

            scrollListener: function() {
                clearTimeout(swipeAutoTimout);
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(THIS.scrollEnd, TIMEOUT_SCROLL);
                THIS.setActiveDot();
            },

            wheelListener: function(e) {
                var t = e.target,
                    textEl = t.tagName == 'RP-REVIEW-TEXT' ? t : (t.parentNode.tagName == 'RP-REVIEW-TEXT' ? t.parentNode : null);
                if (textEl && textEl.scrollHeight > textEl.clientHeight) {
                    return true;
                }
                e.preventDefault();
                wheelSpeed++;
                clearTimeout(wheelTimeout);
                wheelTimeout = setTimeout(THIS.wheelEnd, TIMEOUT_SCROLL, e);
            },

            stylesInit: function() {
                let style = '',
                    styleEl = document.getElementById('rplg-style') || document.createElement('style');
                styleEl.id = 'rplg-style';

                if (options.color_review) {
                    style += 'r-p rp-review rp-review-inner' +
                             '{background:' + options.color_review + '!important}';
                }
                if (options.color_border) {
                    style += 'r-p rp-review rp-review-inner' +
                             '{box-shadow:none!important;border:1px solid ' + options.color_border + '!important}';
                }
                if (options.color_text) {
                    style += 'r-p rp-review rp-review-inner' +
                             '{color:' + options.color_text + '!important}';
                }
                if (options.slider_space_between) {
                    style += 'r-p rp-review rp-review-inner' +
                             '{margin:0 ' + options.slider_space_between + '!important}';
                }
                if (options.slider_review_height) {
                    style += 'r-p [data-rs] rp-review rp-body' +
                             '{height:' + options.slider_review_height + '!important}';
                }
                if (options.color_scale) {
                    style += 'r-p rp-header rp-scale' +
                             '{color:' + options.color_scale + '!important}';
                }
                if (options.color_based) {
                    style += 'r-p rp-header rp-based' +
                             '{color:' + options.color_based + '!important}';
                }
                if (options.color_name) {
                    style += 'r-p rp-review rp-review-name,' +
                             'r-p rp-review rp-review-name a' +
                             '{color:' + options.color_name + '!important}';
                }
                if (options.color_time) {
                    style += 'r-p rp-review rp-review-time' +
                             '{color:' + options.color_time + '!important}';
                }
                if (options.color_stars) {
                    style += 'r-p rp-header rp-rating' +
                             '{color:' + options.color_stars + '!important}';
                }
                if (options.color_btn) {
                    style += 'r-p rp-header rp-review_us,' +
                             'r-p rp-header rp-review_us:hover,' +
                             'r-p rp-header rp-review_us:active' +
                             '{background:' + options.color_btn + '!important}';
                }
                if (options.color_prev_next) {
                    style += 'r-p rp-slider rp-btn-prev svg path,' +
                             'r-p rp-slider rp-btn-next svg path' +
                             '{fill:' + options.color_prev_next + '}';
                }
                if (options.color_dot) {
                    style += 'r-p rp-dot.active {background:' + options.color_dot + '}';
                }
                styleEl.innerHTML = style;
                document.head.appendChild(styleEl);
            },

            headerInit: function() {
                let //scaleEl  = rootEl.querySelector('rp-header rp-scale'),
                    //ratingEl = rootEl.querySelector('rp-header rp-rating'),
                    starsEl  = rootEl.querySelector('rp-header rp-stars'),
                    //btnEl    = rootEl.querySelector('rp-header rp-review_us'),
                    logoEls  = rootEl.querySelectorAll('rp-header rp-logo');

                /*if (options.color_scale) {
                    scaleEl.style.color = options.color_scale;
                }
                if (options.color_stars) {
                    ratingEl.style.color = options.color_stars;
                }
                if (options.color_btn) {
                    btnEl.style.background = options.color_btn;
                }*/
                if (starsEl) {
                    RichPlugins.Utils.starsInit(starsEl);
                }
                for (let i = 0; i < logoEls.length; i++) {
                    logoEls[i].innerHTML = render_logo(logoEls[i].getAttribute('data-provider'));
                }
            },

            addMouseEvents: function() {
                rootEl.addEventListener('mouseover', THIS.mouseOver, false);
                rootEl.addEventListener('mouseleave', THIS.mouseLeave, false);
            },

            delMouseEvents: function() {
                rootEl.removeEventListener('mouseover', THIS.mouseOver);
                rootEl.removeEventListener('mouseleave', THIS.mouseLeave);
            },

            mouseOver: function() {
                mouseOver = 1;
                THIS.swipeAutoStop();
            },

            mouseLeave: function() {
                mouseOver = 0;
                THIS.swipeAutoStart();
            },

            btnClick: function(d) {
                THIS.swipeHand(d * THIS.swipePerBtn());
            },

            wheelEnd: function(e) {
                THIS.swipeHand(Math.sign(e.wheelDelta) * wheelSpeed * THIS.swipeStep());
                wheelSpeed = 0;
            },

            swipeHand: function(step) {
                btnClickWas = true;

                THIS.loadNextReviews();
                THIS.scroll(step);

                if (options.clickstop) {
                    THIS.swipeAutoStop();
                    THIS.delMouseEvents();
                }
            },

            scroll: function(steps) {
                reviewsEl.scrollBy(THIS.reviewWidth() * steps, 0);
            },

            scrollEnd: function() {
                // reviewsBack variable is needed for correctly positioning when resize event called
                reviewsBack = THIS.reviewsBack();

                if (btnClickWas) {
                    btnClickWas = false;
                } else {
                    THIS.loadNextReviews();
                }

                if ((options.mousestop && !mouseOver || !options.mousestop) && (options.clickstop && !btnClickWas || !options.clickstop)) {
                    THIS.swipeAutoStart();
                }
            },

            loadNextReviews: function() {
                let offset = parseInt(rootEl.getAttribute('data-offset')),
                    dotAct = rootEl.querySelector('rp-dot.active'),
                    // If dots enabled get dot active index OR reviews back
                    reviewsLeft = dotAct ? parseInt(dotAct.getAttribute('data-index')) * THIS.swipePerDot() : THIS.reviewsBack(),
                    size   = THIS.getAjaxSize(reviewsLeft);

                if (size > 0) {
                    let list = [];
                    THIS.preloadReviews(list, offset, size);
                    THIS.loadAjaxReviews(list, offset, size);
                }
            },

            /**
            * This function returns how many reviews should be requested in Ajax call
            *
            * This size is positive only if:
            *
            * 1) Not ALL reviews loaded (reviewsCount > offset)
            * 2) NEAR to offset with some ratio(3) (Math.abs(diff) < 3 * THIS.swipePerDot())
            * 3) OR Go to FAR dot (diff)
            *
            * reviewsCount - total reviews reviewsCount
            * offset       - how many reviews already loaded
            * reviewsLeft  - total number of requested reviews (newActiveDotIndex * THIS.swipePerDot())
            * diff         - different between requested and already loaded reviews
            * needsLoad    - how many reviews to request based on pagination
            */
            getAjaxSize: function(reviewsLeft) {
                let size = 0;
                const offset = parseInt(rootEl.getAttribute('data-offset')),
                      pagination = parseInt(options.pagination);

                if (reviewsCount > offset) {

                    let diff = reviewsLeft - offset;

                    if (Math.abs(diff) < 3 * THIS.swipePerDot()) {
                        size = pagination;

                    } else if (diff) {
                        let needsLoad = Math.ceil(reviewsLeft / pagination) * pagination;
                        size = needsLoad - offset;
                    }
                }

                // In case if AJAX call returns more then total reviews count reviews
                let diffBetweenNextAndTotalReviewsCount = (offset + size) - reviewsCount;
                return diffBetweenNextAndTotalReviewsCount > 0 ? size - diffBetweenNextAndTotalReviewsCount : size;
            },

            preloadReviews: function(list, offset, size) {
                var len = reviewsList.length - 1;
                rootEl.setAttribute('data-offset', offset + size);
                for (var i = 0; i < size; i++) {
                    let randReviewEl = reviewsList[Math.round(Math.random() * len)],
                        cloneEl = randReviewEl.cloneNode(true);
                    cloneEl.style = 'filter: blur(4px);';
                    reviewsEl.appendChild(cloneEl);
                    list.push(cloneEl);
                }
                reviewsList = rootEl.querySelectorAll('rp-review');
            },

            loadAjaxReviews: function(list, offset, size) {
                let url  = brb_vars.ajaxurl + '?action=brb_get_reviews&id=' + collId + '&offset=' + offset + '&size=' + size;
                RichPlugins.Utils.ajax(url, function(json) {
                    let len = json.reviews.length;
                    for (var i = 0; i < len; i++) {
                        let el = list.shift();
                        RichPlugins.Utils.reviewInit(THIS.convertReviewEl(el, json.reviews[i]), options);
                    }
                    while(list.length) {
                        let el = list.shift();
                        RichPlugins.Utils.rm(el);
                    }

                    // In case if AJAX returns wrong number of reviews (very rare: server timeout or cache issues)
                    if (offset + size != offset + len) {
                        rootEl.setAttribute('data-offset', offset + len);
                    }
                });
            },

            convertReviewEl: function(el, review) {
                let body  = el.querySelector('rp-body'),
                    img   = el.querySelector('img'),
                    name  = el.querySelector('rp-review-name'),
                    time  = el.querySelector('rp-review-time'),
                    stars = el.querySelector('rp-stars'),
                    text  = el.querySelector('rp-review-text'),
                    media = el.querySelector('rp-media'),
                    reply = el.querySelector('rp-reply'),
                    logo  = el.querySelector('rp-logo');

                el.style = '';

                if (img) {
                    img.src = review.author_avatar;
                    img.alt = review.author_name;
                }
                if (name) {
                    name.outerHTML  = THIS.reviewName(review);
                }
                if (time) {
                    time.setAttribute('data-time', review.time);
                }
                RichPlugins.Utils.rm(media);
                if (review.media) {
                    body.appendChild(RichPlugins.Utils.media(review.media));
                }
                RichPlugins.Utils.rm(reply);
                if (review.reply) {
                    body.appendChild(RichPlugins.Utils.reply(review.reply));
                }
                text.innerHTML = review.text;
                logo.setAttribute('data-provider', review.provider);
                stars.setAttribute('data-info', [review.rating, review.provider, options.color_stars].join(','));
                return el;
            },

            dotsInit: function() {
                if (!dotsEl) return;

                let dotsCount = Math.round(reviewsCount / THIS.swipePerDot());

                dotsEl.innerHTML = '';
                for (let i = 1; i <= dotsCount; i++) {
                    let dot = document.createElement('rp-dot');
                    dot.setAttribute('data-index', i);
                    dot.setAttribute('title', i);
                    dot.onclick = THIS.dotClick;
                    dotsEl.appendChild(dot);
                }

                let dotsHeight = dotsEl.getBoundingClientRect().height;
                rootEl.style.paddingBottom = dotsHeight + 'px';
            },

            dotClick: function() {
                let dotNew = this,
                    idxNew = parseInt(dotNew.getAttribute('data-index')),
                    dotOld = rootEl.querySelector('rp-dot.active'),
                    idxOld = parseInt(dotOld.getAttribute('data-index')),
                    idxDiff = Math.abs(idxNew - idxOld);

                dotOld.className = '';
                dotNew.className = 'active';

                THIS.swipeHand(idxDiff * THIS.swipePerDot() * Math.sign(idxNew - idxOld));
            },

            setActiveDot: function() {
                let idxNew = Math.round(THIS.reviewsBack() / THIS.swipePerDot()) + 1,
                    dotNew = rootEl.querySelector('rp-dot[data-index="' + idxNew + '"]'),
                    dotOld = rootEl.querySelector('rp-dot.active');

                if (dotOld) dotOld.className = '';
                if (dotNew) dotNew.className = 'active';
            },

            swipeAuto: function() {
                if (THIS.isScrollEnd()) {
                    // To return back a reviews count should be subtracted by visible reviews (per view)
                    THIS.scroll(-(reviewsCount - THIS.reviewsPerView()));
                } else {
                    // If reviews ahead less then swipe step, use reviews ahead count
                    let step = THIS.swipeStep() < THIS.reviewsAhead() ? THIS.swipeStep() : THIS.reviewsAhead();
                    THIS.scroll(step);
                }
                THIS.swipeAutoStart();
            },

            swipeAutoStart: function() {
                if (options.autoplay) {
                    swipeAutoTimout = setTimeout(THIS.swipeAuto, parseInt(options.speed) * 1000);
                }
            },

            swipeAutoStop: function() {
                clearTimeout(swipeAutoTimout);
                if (scrollTimeout) {
                    setTimeout(function() { clearTimeout(scrollTimeout) }, 100);
                }
            },

            isScrollEnd: function() {
                var lastReview = reviewsEl.querySelector('rp-review:last-child'),
                    elemRect   = lastReview.getBoundingClientRect(),
                    parentRect = lastReview.parentNode.getBoundingClientRect();

                return (Math.abs(parentRect.left - elemRect.left) < 2 || parentRect.left <= elemRect.left) && elemRect.left < parentRect.right &&
                       (Math.abs(parentRect.right - elemRect.right) < 2 || parentRect.right >= elemRect.right) && elemRect.right > parentRect.left;
            },

            swipeStep: function() {
                return options.swipe_step || THIS.reviewsPerView();
            },

            swipePerBtn: function() {
                return options.swipe_per_btn || THIS.reviewsPerView();
            },

            swipePerDot: function() {
                return options.swipe_per_dot || THIS.reviewsPerView();
            },

            reviewWidth: function() {
                return reviewsList[0].offsetWidth;
            },

            reviewHeight: function() {
                return reviewsList[0].offsetHeight;
            },

            reviewsPerView: function() {
                return Math.round(reviewsEl.offsetWidth / THIS.reviewWidth());
            },

            reviewsBack: function() {
                return Math.round(reviewsEl.scrollLeft / THIS.reviewWidth());
            },

            reviewsAhead: function() {
                return reviewsList.length - (THIS.reviewsBack() + THIS.reviewsPerView());
            },

            reviewName: function(review) {
                return '' +
                    '<rp-review-name title="' + review.author_name + '">' +
                        (review.author_url ? RichPlugins.Utils.anchor(review.author_url, review.author_name, options) : review.author_name) +
                    '</rp-review-name>';
            },

            clear: function() {
                clearTimeout(resizeTimout);
                clearTimeout(swipeAutoTimout);
                clearTimeout(scrollTimeout);
                clearTimeout(wheelTimeout);
                window.removeEventListener('resize', THIS.resizeListener);
                reviewsEl.removeEventListener('scroll', THIS.scrollListener);
                contentEl.removeEventListener('wheel', THIS.wheelListener);
            }

        }

    }

};

document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('rp-slider[data-exec=""]');
    for (var i = 0; i < sliders.length; i++) {
        RichPlugins.Slider(sliders[i]).init();
        sliders[i].setAttribute('data-exec', '1');
    }
});