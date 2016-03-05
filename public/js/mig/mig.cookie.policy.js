var mig = mig || {};
mig.cookie = mig.cookie || {};
mig.cookie.policy = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf, device, switcher, box, agree,
            
           show = function () {
                if (!jQuery.cookie(conf.cooktxt)) {
                    root = jQuery(conf.root);                    
                    root.append(conf.tmpl);
                    box = root.find(conf.box);
                    switcher = box.find(conf.close);
                    switcher.on('click', function () {
                        box.addClass('hide');
                    });
                    agree = box.find(conf.agree);
                    agree.on('click', function () {                        
                         jQuery.cookie(conf.cooktxt, (new Date()).getTime(), conf.expires);
                         box.addClass('hide');
                    });
                }
            };
    confDef = {
        expires:   {expires: 740},
        root: '.body-page',
        cooktxt: 'migcpol',
        tmpl: '<div class="cookie-box"><p class="cookie-info">Strona korzysta z plików cookies w celu realizacji usług. Korzystanie z serwisu oznacza zgodę na zapis lub odczyt plików cookie zgodnie z ustawieniami Twojej przeglądarki. Możesz zmieniać te ustawienia. <a class="cookie-link" href="/polityka-cookie/">O Polityce Plików Cookies</a>. <a class="cookie-agree" href="#">Rozumiem</a><a class="cookie-close" href="#">zamknij</a></p></div>',
        box: '.cookie-box',
        close: '.cookie-close',
        agree: '.cookie-agree'
    };
    conf = jQuery.extend(confDef, confApp);    
    show();
};
