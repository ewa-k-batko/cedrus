var mig = mig || {};
mig.gallery = function (window, confApp) {
    "use strict";
    var jQuery = window.$j, root, confDef, conf,
            int = function (s) {
                return parseInt(s, 10);
            },
            confDef = {
                root: '.gallery-list',
                image: '.gallery-img',
                pos: 0
            },
    init = function () {
        if (!conf.screen) {
            jQuery('body').append('<div class="screen"><a class="a-close"/><a class="a-prev"/><a class="a-next"/><div class="screen-img prevout"></div><div class="screen-img prev"></div><div class="screen-img current"></div><div class="screen-img next"></div><div class="screen-img nextin"></div></div>');
            conf.body = jQuery('.body-page');
            conf.screen = jQuery('.screen');

            calculateSize();

            /* var h = int(jQuery(window).height());
             
             conf.screen.css({'height': h * 0.8, 'perspective': h * 1.1});*/

            conf.curr = conf.curr || {};
            conf.pos = conf.pos || 0;

            conf.list = root.find(conf.image);

            conf.aprev = conf.screen.find('.a-prev');
            conf.anext = conf.screen.find('.a-next');
            conf.aclose = conf.screen.find('.a-close');
            setNav();
            root.delegate(conf.image, 'click', function () {
                makeStart(jQuery(this));
            });

        }
    },
            calculateSize = function () {

                var h, w, p, n;
                h = int(jQuery(window).height());
                w = int(jQuery(window).width());
                //p = h/w;
                var n = w * .4 * .8;


                //console.log(i);

                //n = (w/3)*p;
                //console.log( w/3 + '/' + w + '/' + h +'/' + p + '/' + n);
                conf.screen.css({'height': n, 'perspective': n * 1.2});
            },
            setCurrent = function (step) {
                conf.pos = conf.pos + step;
                if (conf.pos < 0) {
                    conf.pos = 0;
                }
                if (conf.pos > conf.list.length - 1) {
                    conf.pos = conf.list.length - 1;
                }
            },
            setNext = function () {
                conf.posNext = conf.pos + 1 <= conf.list.length - 1 ? conf.pos + 1 : -1;
            },
            setPrev = function () {
                conf.posPrev = conf.pos - 1 >= 0 ? conf.pos - 1 : -1;
            },
            setPos = function (step) {
                setCurrent(step);
                setPrev();
                setNext();
            },
            setNav = function () {
                conf.prev = conf.screen.find('.prev');
                conf.prevout = conf.screen.find('.prevout');
                conf.current = conf.screen.find('.current');
                conf.next = conf.screen.find('.next');
                conf.nextin = conf.screen.find('.nextin');

                console.debug(conf, '====conf===');

                if (conf.pos == 0) {
                    conf.aprev.hide();
                } else {
                    conf.aprev.show();
                }

                if (conf.pos == conf.list.length - 1) {
                    conf.anext.hide();
                } else {
                    conf.anext.show();
                }

                //conf.prevout.html('').removeAttr('data-pos');
                //conf.nextin.html('').removeAttr('data-pos');
            },
            setEven = function () {
                conf.aprev.on('click', function (e) {
                    prevMake(jQuery(e.currentTarget));
                });
                conf.anext.on('click', function (e) {
                    nextMake(jQuery(e.currentTarget));
                });
               conf.aclose.on('dblclick', function (e) {
                 currentMake(jQuery(e.currentTarget));
                 }); /* */
                /*conf.nextin.on('click',function (e) {
                 e.stopPropagation();
                 });
                 conf.prevout.on('click',function (e) {
                 e.stopPropagation();
                 });*/
            },
            currentMake = function () {
                conf.body.fadeTo("slow", 1);
                //conf.screen.addClass('hide');
                conf.screen.hide();
                conf.prevout.html('');
                conf.prev.html('');
                conf.current.html('');
                conf.next.html('');
                conf.nextin.html('');

                conf.pos = 0;
                setPrev();
                setNext();
                //stop eventy  na nav

                //@todozoptymalizowac
               /* root.delegate(conf.image, 'dblclick', function () {
                    makeStart(jQuery(this));
                });*/
            },
            prevMake = function (curr) {
                setPos(-1);
                //conf.pos = int(curr.attr('data-pos'));
                //setPrev();
                // setNext();
                console.debug(conf, 'conf');

                conf.nextin.removeClass('nextin').addClass('noshow');
                conf.next.removeClass('next').addClass('nextin');
                conf.current.removeClass('current').addClass('next');
                //curr.removeClass('prev').addClass('current');
                //jQuery(conf.list[conf.pos]).removeClass('prev').addClass('current');

                conf.prev.removeClass('prev').addClass('current');

                conf.noshow = conf.screen.find('.noshow');


                if (conf.posPrev >= 0) {
                    var prevSrc = jQuery(conf.list[conf.posPrev]).attr('src');
                    console.debug(prevSrc, 'prevSrc');
                    //if (!conf.prevout.has('img')) {
                    conf.prevout.html(jQuery(new Image()).attr({'src': prevSrc}).addClass('new-img  p-img'));
                    // }
                    conf.prevout.removeClass('prevout').addClass('prev').attr({'data-pos': conf.posPrev});
                    conf.noshow.removeClass('noshow').addClass('prevout').removeAttr('data-pos').html('');
                    //.attr({'data-pos': (conf.posPrev - 1 >= 0 conf.posPrev - 1)});

                } else {
                    conf.prevout.removeClass('prevout').addClass('prev').removeAttr('data-pos').html('');
                    conf.noshow.removeClass('noshow').addClass('prevout').removeAttr('data-pos').html('');
                }

                setNav();
                //setEven();
            },
            nextMake = function (curr) {

                setPos(1);
                //conf.pos = int(curr.attr('data-pos'));


                //setPrev();
                // setNext();

                console.debug(conf, 'conf');

                conf.prevout.removeClass('prevout').addClass('noshow');
                conf.prev.removeClass('prev').addClass('prevout');
                conf.current.removeClass('current').addClass('prev');
                //curr.removeClass('next').addClass('current');

                //console.debug(conf.list[conf.pos], 'list');

                //jQuery(conf.list[conf.pos]).removeClass('next').addClass('current');

                conf.next.removeClass('next').addClass('current');

                conf.noshow = conf.screen.find('.noshow');


                if (conf.posNext >= 0) {
                    var nextSrc = jQuery(conf.list[conf.posNext]).attr('src');
                    console.debug(nextSrc, 'nextSrc');
                    //if (!conf.prevout.has('img')) {
                    conf.nextin.html(jQuery(new Image()).attr({'src': nextSrc}).addClass('new-img  p-img'));
                    // }
                    conf.nextin.removeClass('nextin').addClass('next').attr({'data-pos': conf.posNext});
                    conf.noshow.removeClass('noshow').addClass('nextin').removeAttr('data-pos').html('');
                } else {
                    conf.nextin.removeClass('nextin').addClass('next').removeAttr('data-pos').html('');
                    conf.noshow.removeClass('noshow').addClass('nextin').removeAttr('data-pos').html('');
                }

                setNav();
                // setEven();
            },
            makeStart = function (curr) {
                conf.curr.src = curr.attr('src');


                // console.debug(curr.attr('src'), 'init-curr');

                conf.pos = int(curr.attr('data-pos'));
                setPos(0);
                //setPrev();
                //setNext();


                if (conf.posPrev >= 0) {
                    conf.curr.prev = jQuery(conf.list[conf.posPrev]).attr('src');
                    conf.prev.attr({'data-pos': conf.posPrev});
                    var pic_width, pic_height;


                    jQuery(new Image()).attr({'src': conf.curr.prev}).load(function () {
                        pic_width = this.width;   // Note: $(this).width() will not
                        pic_height = this.height; // work for in memory images.
                    })

                   // console.log();


                    //alert(pic_height);

                    conf.prev.html(jQuery(new Image()).attr({'src': conf.curr.prev}).addClass('new-img p-img'));

                    conf.aprev.show();
                } else {
                    conf.aprev.hide();
                }
                if (conf.posNext >= 0) {
                    conf.curr.next = jQuery(conf.list[conf.posNext]).attr('src');
                    conf.next.attr({'data-pos': conf.posNext});
                    conf.next.html(jQuery(new Image()).attr({'src': conf.curr.next}).addClass('new-img  p-img'));
                    conf.anext.show();
                } else {
                    conf.anext.hide();
                }


                conf.current.attr({'data-pos': conf.pos});
                conf.current.html(jQuery(new Image()).attr({'src': conf.curr.src}).addClass('new-img  p-img'));


                //console.debug(conf.list[conf.curr.pos], 'pos-5');


                //console.debug(conf.curr.prev, 'conf-2-next');






                conf.screen.show();

                conf.body.fadeTo("slow", 0.33);
                window.scrollTo(0, 0);

                setEven();

            };
    conf = jQuery.extend(confDef, confApp);
    root = jQuery(conf.root);
    init();





};



