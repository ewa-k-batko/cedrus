var mig = mig || {};
mig.nav = mig.nav || {};
mig.nav.service = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf, device, switcher, menu,
            int = function (s) {
                return parseInt(s, 10);
            },
            show = function (switcher, menu) {
                switcher.on('click', function () {
                    if (menu.hasClass('active')) {
                        menu.addClass('deactive');
                        menu.removeClass('active');
                    } else {
                        menu.addClass('active');
                        menu.removeClass('deactive');
                    }
                });
            };

    confDef = {
        root: '.panel-body'
    };
    conf = jQuery.extend(confDef, confApp);
    device = int(jQuery(window).width());
    if (device < conf.screen) {
        root = jQuery(conf.root);
        switcher = root.find(conf.switcher);
        menu = root.find(conf.menu);
        show(switcher, menu);
    }
};



