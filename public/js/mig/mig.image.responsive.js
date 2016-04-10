var mig = mig || {};
mig.image = mig.image || {};
mig.image.responsive = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf, device, imgs, selector,
            threshold = {sm: 600, rs: 480, xs: 320},
            int = function (s) {
                return parseInt(s, 10);
            },
            show = function () {
                
            };

    confDef = {
        root: '.body-page'
    };
    
    
    conf = jQuery.extend(confDef, confApp);
    device = int(jQuery(window).width());
    conf.selector = conf.selector || '.plant-image';
    
    //if (device < conf.screen) {
        root = jQuery(conf.root);
        imgs = root.find(conf.selector);
        
        //console.debug(imgs, 'imgs');
        
        imgs.each(function () {
            
            var img = jQuery(this);
            var res = JSON.parse(img.attr('data-src'));
            //console.debug(res, 'res');
            //res = res.replace("'",'');
            //console.debug(res, 'res');
            //console.debug(jQuery.parseJSON(res), 'res');
            //JSON.parse
           //console.debug(threshold, 'threshold'); 
            var tres;
            for(var r in threshold) {
                
                //console.debug(threshold[r], r);
                  if( threshold[r] <= device ) {
                      tres = r;
                      break;
                  }
            }
           // console.debug(tres, 'tres'); 
            img.attr({src: res[tres]});
        });
        
        
        //menu = root.find(conf.menu);
        //show(switcher, menu);
   // }
};



