var MODULE_CONFIG = {
    screenfull: [
        'libs/screenfull/dist/screenfull.min.js'
    ],
    stick_in_parent: [
        'libs/sticky-kit/jquery.sticky-kit.min.js'
    ]
};

// jQuery plugin default options
var JP_CONFIG = {};

/**
 * 0.1.1
 * Deferred load js/css file, used for ui-jq.js and Lazy Loading.
 * 
 * @ flatfull.com All Rights Reserved.
 * Author url: http://themeforest.net/user/flatfull
 */
var uiLoad = uiLoad || {};

(function ($, $document, uiLoad) {
    "use strict";

    var loaded = [],
        promise = false,
        deferred = $.Deferred();

    /**
     * Chain loads the given sources
     * @param srcs array, script or css
     * @returns {*} Promise that will be resolved once the sources has been loaded.
     */
    uiLoad.load = function (srcs) {
        srcs = $.isArray(srcs) ? srcs : srcs.split(/\s+/);
        if (!promise) {
            promise = deferred.promise();
        }

        $.each(srcs, function (index, src) {
            promise = promise.then(function () {
                return loaded[src] ? loaded[src].promise() : (src.indexOf('.css') >= 0 ? loadCSS(src) : loadScript(src));
            });
        });
        deferred.resolve();
        return promise;
    };

    uiLoad.remove = function (srcs) {
        srcs = $.isArray(srcs) ? srcs : srcs.split(/\s+/);
        $.each(srcs, function (index, src) {
            src.indexOf('.css') >= 0 ? $('link[href="' + src + '"]').remove() : $('script[src="' + src + '"]').remove();
            delete loaded[src];
        });
    };

    /**
     * Dynamically loads the given script
     * @param src The url of the script to load dynamically
     * @returns {*} Promise that will be resolved once the script has been loaded.
     */
    var loadScript = function (src) {
        var deferred = $.Deferred();
        var script = $document.createElement('script');
        script.src = src;
        script.onload = function (e) {
            deferred.resolve(e);
        };
        script.onerror = function (e) {
            deferred.reject(e);
        };
        $document.body.appendChild(script);
        loaded[src] = deferred;

        return deferred.promise();
    };

    /**
     * Dynamically loads the given CSS file
     * @param href The url of the CSS to load dynamically
     * @returns {*} Promise that will be resolved once the CSS file has been loaded.
     */
    var loadCSS = function (href) {
        var deferred = $.Deferred();
        var style = $document.createElement('link');
        style.rel = 'stylesheet';
        style.type = 'text/css';
        style.href = href;
        style.onload = function (e) {
            deferred.resolve(e);
        };
        style.onerror = function (e) {
            deferred.reject(e);
        };
        $document.head.appendChild(style);
        loaded[href] = deferred;

        return deferred.promise();
    };

})(jQuery, document, uiLoad);

(function ($, MODULE_CONFIG) {
    "use strict";

    $.fn.uiJp = function () {

        return this.each(function () {
            var self = $(this);
            var opts = self.attr('ui-options') || self.attr('data-ui-options');
            var attr = self.attr('ui-jp') || self.attr('data-ui-jp');
            var options = opts && eval('[' + opts + ']');
            if (options && $.isPlainObject(options[0])) {
                options[0] = $.extend({}, JP_CONFIG[attr], options[0]);
            }

            if (self[attr]) {
                self[attr].apply(self, options);
            } else {
                uiLoad.load(MODULE_CONFIG[attr]).then(function () {
                    self[attr].apply(self, options);
                });
            }
        });
    }

})(jQuery, MODULE_CONFIG);

(function ($) {
    "use strict";

    var promise = false,
        deferred = $.Deferred();
    $.fn.uiInclude = function () {
        if (!promise) {
            promise = deferred.promise();
        }
        //console.log('start: includes');

        compile(this);

        function compile(node) {
            node.find('[ui-include], [data-ui-include]').each(function () {
                var that = $(this),
                    url = that.attr('ui-include') || that.attr('data-ui-include');
                promise = promise.then(
                    function () {
                        //console.log('start: compile '+ url);
                        var request = $.ajax({
                            url: eval(url),
                            method: "GET",
                            dataType: "text"
                        });
                        //console.log('start: loading '+ url);
                        var chained = request.then(
                            function (text) {
                                //console.log('done: loading '+ url);
                                var ui = that.replaceWithPush(text);
                                ui.find('[ui-jp], [data-ui-jp]').uiJp();
                                ui.find('[ui-include], [data-ui-include]').length && compile(ui);
                            }
                        );
                        return chained;
                    }
                );
            });
        }

        deferred.resolve();
        return promise;
    }

    $.fn.replaceWithPush = function (o) {
        var $o = $(o);
        this.replaceWith($o);
        return $o;
    }

})(jQuery);

(function ($) {
    "use strict";

    // Checks for ie
    if (!!navigator.userAgent.match(/MSIE/i) || !!navigator.userAgent.match(/Trident.*rv:11\./)) {
        $('body').addClass('ie');
    }

    // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
    var ua = window['navigator']['userAgent'] || window['navigator']['vendor'] || window['opera'];
    if ((/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua)) {
        $('body').addClass('smart');
    }

})(jQuery);

(function ($) {
    "use strict";

    $(document).on('blur', 'input, textarea', function (e) {
        $(this).val() ? $(this).addClass('has-value') : $(this).removeClass('has-value');
    });

})(jQuery);

(function ($) {
    "use strict";

    $(document).on('click', '[ui-nav] a, [data-ui-nav] a', function (e) {
        var $this = $(e.target),
            $active, $li;
        $this.is('a') || ($this = $this.closest('a'));

        $li = $this.parent();
        $active = $li.siblings(".active");
        $li.addClass('active');
        $active.removeClass('active');
        if ($this.attr('href') && $this.attr('href') != '') {
            $(document).trigger('Nav:changed');
        }
    });

    // init the active class when page reload\
    $('[ui-nav] a, [data-ui-nav] a').filter(function () {
        return location.href.indexOf($(this).attr('href')) != -1;
    }).parent().addClass('active');

})(jQuery);


(function ($) {
    "use strict";
    $.extend(jQuery.easing, {
        def: 'easeOutQuad',
        easeInOutExpo: function (x, t, b, c, d) {
            if (t == 0) return b;
            if (t == d) return b + c;
            if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
            return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
        }
    });

    $(document).on('click', '[ui-scroll-to], [data-ui-scroll-to]', function (e) {
        e.preventDefault();
        var target = $('#' + $(this).attr('ui-scroll-to')) || $('#' + $(this).attr('data-ui-scroll-to'));
        $('html,body').animate({
            scrollTop: target.offset().top
        }, 600, 'easeInOutExpo');
    });
})(jQuery);

(function ($) {
    "use strict";

    $(document).on('click', '[ui-toggle-class], [data-ui-toggle-class]', function (e) {
        e.preventDefault();
        var $self = $(this);
        var attr = $self.attr('data-ui-toggle-class') || $self.attr('ui-toggle-class');
        var target = $self.attr('data-ui-target') || $self.attr('ui-target');
        var classes = attr.split(','),
            targets = (target && target.split(',')) || Array($self),
            key = 0;
        $.each(classes, function (index, value) {
            var target = $(targets[(targets.length && key)]),
                current = target.attr('data-ui-class'),
                _class = classes[index];

            (current != _class) && target.removeClass(target.attr('data-ui-class'));
            target.toggleClass(classes[index]);
            target.attr('data-ui-class', _class);
            key++;
        });
        $self.toggleClass('active');

    });
})(jQuery);

(function ($, MODULE_CONFIG) {
    "use strict";

    $.fn.taburl = function () {

        var plugin = this;

        plugin.each(function () {
            update();
            $(document).on("Nav:changed", function () {
                setTimeout(update, 50);
            });

            function update() {
                $('[data-toggle="tab"]').filter(function () {
                    return location.href.indexOf($(this).attr('data-target')) != -1;
                }).trigger('click');
            }
        });

        return plugin;
    }

})(jQuery);
