var mig = mig || {};
mig.image = mig.image || {};
mig.image.responsive = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf, device, imgs, selector,
            threshold = {sm: 600, rs: 480, xs: 320},
    int = function (s) {
        return parseInt(s, 10);
    };
    confDef = {
        root: '.body-page'
    };

    conf = jQuery.extend(confDef, confApp);
    device = int(jQuery(window).width());
    conf.selector = conf.selector || '.plant-image';
    root = jQuery(conf.root);
    imgs = root.find(conf.selector);

    imgs.each(function () {

        var img = jQuery(this),tres,r,
        res = img.attr('data-src');

        if (res && res.length > 0) {
            res = JSON.parse(res);
        }
        for (r in threshold) {
            if (threshold[r] && threshold[r] <= device) {
                tres = r;
                break;
            }
        }
        if (res && res[tres]) {
            var imgn = new Image();
            jQuery(imgn).bind('load', function () {
                img.attr({src: res[tres]});
                jQuery(window).trigger('loadedImg');
            }).each(function () {
                if (this.complete) {
                    img.attr({src: res[tres]});
                    jQuery(window).trigger('loadedImg');
                }
            });
        }
    });
};