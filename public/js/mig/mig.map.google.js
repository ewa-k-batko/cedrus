var mig = mig || {};
mig.map = mig.map || {};
mig.map.google = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, height, width, root, confDef, conf, device,
            int = function (s) {
                return parseInt(s, 10);
            },
            showMap = function (name, obj) {
                obj.map = root.find('.js-map-' + name);
                obj.title = root.find('.js-map-title-' + name);
                obj.map.attr('src', obj.src);
                obj.map.attr('width', width);
                obj.map.attr('height', height);
                var interv = setInterval(function () {                    
                    obj.map.ready(function () {
                        obj.map.show();
                        obj.title.show();
                        clearInterval(interv);
                    });

                }, 200);
            };

    confDef = {
        rate: 0.75,
        width: 600,
        root: '.contact-maps'
    };

    conf = jQuery.extend(confDef, confApp);
    device = int(jQuery(window).width());
    root = jQuery(conf.root);

    if (device < conf.limitDevice) {
        conf.width = Math.round(device * 0.8);
    }
    height = Math.round(conf.width * conf.rate);
    width = conf.width;
    jQuery(conf.list).each(function (index) {
        var obj = jQuery(this)[0];
        showMap(obj.name, obj);
    });
};



