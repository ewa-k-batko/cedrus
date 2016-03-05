var mig = mig || {};
mig.nav = mig.nav || {};
mig.nav.offer = mig.nav.offer || {};
mig.nav.offer.view = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf, device, items, list,
            int = function (s) {
                return parseInt(s, 10);
            },
            show = function (list, items) {
                jQuery(list).each(function (index) {
                    jQuery(this).on('click', function (e, name) {
                        var name = jQuery(this).attr('data-link');
                        name = 'offer-item plant ' + name;
                        jQuery(items).each(function (index) {

                            //jQuery(this).animate({opacity: 0.95}, "1000", "linear", function () {

                                jQuery(this).removeAttr('class').addClass(name).delay(300);

                           // });

                        });
                    });
                });
            };
    confDef = {
        root: '.offer'
    };
    conf = jQuery.extend(confDef, confApp);
    device = int(jQuery(window).width());
    if (device > conf.screen) {
        root = jQuery(conf.root);
        items = root.find('.offer-list .plant');
        list = root.find('.js-view-switch .js-view-link');
        show(list, items);
    }
};



