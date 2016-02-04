/* ***********************************************************
   ****************** CODESLIDER SCRIPT **********************
   *********************************************************** */

(function($) {

    'use strict';

    $.codeslider = function(element, o) {


        /* Varibles global
        ================================================== */
        var $cs = element
          , $w  = $(window)

          , cs  = {}
          , va  = {}
          , ds  = {}
          , id  = {}
          , xt  = {}
          , is  = {}
          , da  = {}

          , $canvas, $viewport, $s
          , $nav, $prev, $next, $playpause
          , $pag, $pagItem, $thumb, $thumbItem, $timer, $timerItem, $cap

          , num
          , speed, delay
          , hCanvas, mCanvas, wViewport, hViewport, rCanvas, wTranslate
          , xCanvas
          , tf, cssTf, cssTs, cssD, cssD0, cssD1, cssT, tranEnd
          , numS0, numSn     // layout dash
          , tDelay, xTimer;





        /* Init
        ================================================== */
        var init = {
            check : function() {

                var _child = $cs.children();
                if( _child.length ) {
                    prop.get();                             // Slider: get properties in data
                    m.cssName();                            // CSS: get name-style
                }
                if( is.show ) init.ready();                 // Init ready
                else          $cs.remove();
            },

            ready : function() {

                m.abbr();                                   // Slider abbreviate
                render.structure();                         // Slider: create canvas

                prop.slider();                              // Slider: get properties
                prop.slide();                               // Slide: properties

                o.isNav && render.nav();                    // Slider: render Navigation
                o.isPag && render.pag();                    // Slider: render Pagnation
                o.isCap && render.cap();                    // Slider: render Pagnation
                render.timer();                             // Slider: render Timer

                !$playpause && o.isPlayPause
                && o.isSlideshow && render.play();          // Slider: render playpause
                
                render.other();                             // Slider: render other elements
                size.codeWidth();                           // Slide: Set width

                load.slideBegin($s.eq(o.idCur));
            },

            load : function() {

                !is.showFrom && $cs.addClass(o.ns + 'hide') // Code: toggle hide
                $cs.addClass(o.ns + 'ready');               // Code: add class

                if( o.layout == 'dash' ) m.toggleDash();
                else                     m.toggle();        // First-item: add Actived

                o.idCur == 0 && cs.ev.trigger('start');    // Event start
                position.reLine();                          // Codeslider: reset position

                o.isNav && events.nav();                    // Navigation: click event
                o.isPag && events.pag();                    // Pagnation: click event
                // layer.run(o.idCur, 'start');

                events.resize();                            // Window resize
                events.touch();
                events.drag();
                events.keyboard();

                o.isSlideshow && slideshow.init();
            }
        },





        /* Methods
        ================================================== */
        m = {

            /* CSS prefixed
            ---------------------------------------------- */
            cssName : function() {

                // Browser detect
                is.ie = /*@cc_on!@*/false || document.documentMode;     // At least IE6
                is.safari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
                is.opera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
                is.chrome = !!window.chrome && !is.opera;               // Chrome 1+
                is.firefox = typeof InstallTrigger !== 'undefined';
                

                var _browser = ['ie', 'safari','opera', 'chrome', 'firefox'];
                for( var i = _browser.length; i >= 0 && !is.browser; i-- ) {
                    if( !!is[_browser[i]] ) is.browser = _browser[i];
                }



                // CSS check
                is.gesture = !!(window.navigator && window.navigator.msPointerEnabled && window.MSGesture);
                is.ontouch = !!(is.gesture || ("ontouchstart" in window) || (window.DocumentTouch && document instanceof DocumentTouch));
                o.isTouch  = is.ontouch && o.isTouch;
                is.ts      = m.prefixed('transition', 'is');
                
                // is.ts = 0;
                // is.tl3d    = m.prefixed('perspective', 'pre'); // Not precise
                is.cs      = m.isCanvas();

                
                // Event name
                va.clickName = (o.isTouch && !is.ie) ? 'touchend' : 'click.cs';



                // CSS: support transition
                if( is.ts ) {

                    var tranEndName = {
                        'WebkitTransition' : 'webkitTransitionEnd',
                        'msTransition'     : 'MSTransitionEnd',
                        'transition'       : 'transitionend'
                    };

                    cssTf = m.prefixed('transform', 'pre') + 'transform';
                    cssTs = m.prefixed('transition', 'pre') + 'transition';
                    cssD  = cssTs + '-duration';
                    cssT  = cssTs + '-timing-function';

                    tranEnd = tranEndName[m.prefixed('transition')];

                // CSS: not support transition
                } else { cssTf = 'left' }



                // Slider: show options
                if( (o.isTouch && o.show == 'desktop')
                ||  (!o.isTouch && o.show == 'mobile') ) is.show = 0;
                else                                     is.show = 1;
            },


            easeName : function(name) {
                if( name == 'linear' ) return 'linear';
                if( name == 'swing' )  return 'ease';

                var n; name = name.replace('ease', '');
                switch( name ) {
                    case 'InSine'       : n = '.47, 0,.745, .715'; break;
                    case 'OutSine'      : n = '.39, .575, .565, 1'; break;
                    case 'InOutSine'    : n = '.445, .05, .55, .95'; break;

                    case 'InQuad'       : n = '.55, .085, .68, .53'; break;
                    case 'OutQuad'      : n = '.25, .46, .45, .94'; break;
                    case 'InOutQuad'    : n = '.455, .03, .515, .955'; break;

                    case 'InCubic'      : n = '.55, .055, .675, .19'; break;
                    case 'OutCubic'     : n = '.215, .61, .355, 1'; break;
                    case 'InOutCubic'   : n = '.645, .045, .355, 1'; break;

                    case 'InQuart'      : n = '.895, .03, .685, .22'; break;
                    case 'OutQuart'     : n = '.165, .84, .44, 1'; break;
                    case 'InOutQuart'   : n = '.77, 0, .175, 1'; break;

                    case 'InQuint'      : n = '.755, .05, .855, .06'; break;
                    case 'OutQuint'     : n = '.23, 1, .32, 1'; break;
                    case 'InOutQuint'   : n = '.86, 0, .07, 1'; break;

                    case 'InExpo'       : n = '.95, .05, .795, .035'; break;
                    case 'OutExpo'      : n = '.19, 1, .22, 1'; break;
                    case 'InOutExpo'    : n = '1, 0, 0, 1'; break;

                    case 'InCirc'       : n = '.6, .04, .98, .335'; break;
                    case 'OutCirc'      : n = '.075, .82, .165, 1'; break;
                    case 'InOutCirc'    : n = '.785, .135, .15, .86'; break;

                    case 'InBack'       : n = '.6, -.28, .735, .045'; break;
                    case 'OutBack'      : n = '.175, .885, .32, 1.275'; break;
                    case 'InOutBack'    : n = '.68, -.55, .265, 1.55'; break;

                    case 'InElastic'    :
                    case 'OutElastic'   :
                    case 'InOutElastic' :

                    case 'InBounce'     :
                    case 'OutBounce'    :
                    case 'InOutBounce'  :

                    default : n = '.25, .1, .25, 1';
                }
                return 'cubic-bezier(' + n + ')';
            },



            /* Slide: clone
            ---------------------------------------------- */
            clone : function(opts, n) {

                // clone slide begin
                if( opts == 1 ) {

                    for(var i = 0; i < n; i++ )
                        $s.eq(numSn - i).prependTo($canvas);
                    
                    position.translateX(n, true);

                    if( numSn <= 0 ) numSn = num;
                    else numSn -= n;
                }

                else if ( opts == -1 ) {

                    $s.eq(numS0).appendTo($canvas);

                    for(var i = 0; i < n; i++ ) {
                        $s.eq(numS0 + i).appendTo($canvas);
                    }

                    position.translateX(-n, true);
                    
                    if( numS0 >= num ) numS0 = 0;
                    else numS0 += n;
                }
            },


            /* Slider & pag: toggle class
            ---------------------------------------------- */
            toggle : function() {

                // Slide: toggle class actived
                var _c = o.idCur
                  , $slCur = $s.eq(_c);

                $s.not($slCur).removeClass(o.current);
                $slCur.addClass(o.current);
                

                // Pag: toggle class actived
                if( o.isPag ) {

                    var $pagCur = $pagItem.eq(_c);
                    $pagItem.not($pagCur).removeClass(o.current);
                    $pagCur.addClass(o.current);
                }

                // Nav: toggle class inactive
                if( o.isNav ) {
                    var _i = o.inActived;

                    if( !o.isLoop ) {
                        if( _c == 0 )   $prev.addClass(_i);
                        if( _c == num ) $next.addClass(_i);
                        
                        if( _c != 0 && $prev.hasClass(_i) )   $prev.removeClass(_i);
                        if( _c != num && $next.hasClass(_i) ) $next.removeClass(_i);
                    }
                    else {
                        if( $prev.hasClass(_i) ) $prev.removeClass(_i)
                        if( $next.hasClass(_i) ) $next.removeClass(_i)
                    }
                }


                // Cap: toggle Content
                if( o.isCap ) $cap.html(va.aCap[_c]);


                // Slide: add to load
                load.add($slCur);
            },




            toggleDash : function() {

                // Pag: toggle Class current
                if( o.isPag ) {
                    var i = ds.pagNum;

                    while ( ds.nEnd < ds.pagID[i] ) { i-- }

                    var $pActived = ds.pagItem0[ds.pagID[i]];

                    $pagItem.not($pActived).removeClass(o.current);
                    $pActived.addClass(o.current);
                }


                // Nav: toggle class inactive
                if( o.isNav && !o.isLoop ) {
                    if( ds.nBegin == 0 ) $prev.addClass(o.inActived);
                    if( ds.nEnd == num ) $next.addClass(o.inActived);

                    if( ds.nBegin != 0 && $prev.hasClass(o.inActived) ) $prev.removeClass(o.inActived);
                    if( ds.nEnd != num && $next.hasClass(o.inActived) ) $next.removeClass(o.inActived);
                }
            },



            toggleFree : function() {

                var _c = o.idCur
                  , _o = o.fName + '-out'
                  , _i = o.fName + '-in'

                  , $slCur = $s.eq(_c)
                  , $slLast = $s.eq(o.idLast);


                if( $slCur.hasClass(_o) )  $slCur.removeClass(_o);
                if( !$slCur.hasClass(_i) ) $slCur.addClass(_i);

                if( !$slLast.hasClass(_o) )  $slLast.addClass(_o);
                if( $slLast.hasClass(_i) )   $slLast.removeClass(_i);
            },


            toggleClass : function(_type, _is) {

                var _a = o.className[_type]
                  , _add = _is ? _a[0] : _a[1]
                  , _re  = _is ? _a[1] : _a[0]
                  , _v   = $viewport;       // Shortcut $viewport

                // Remove all
                if( _is == -1 ) {
                    if( _v.hasClass(_a[0]) ) $viewport.removeClass(_a[0]);
                    if( _v.hasClass(_a[1]) ) $viewport.removeClass(_a[1]);
                }
                else {
                    if( _v.hasClass(_re) )   $viewport.removeClass(_re);
                    if( !_v.hasClass(_add) ) $viewport.addClass(_add);
                }
            },





            /* CSS: get value
            ---------------------------------------------- */
            valueX : function(str) {

                // Array: get value
                var a = str.substr(7, str.length - 8).split(', ');

                // Array: return value 5
                return parseInt( a[4] );
            },


            /* Properties: get Value of string
            ---------------------------------------------- */
            valueName : function(str, prefix, back, aName, isArray) {

                var _numF = '\\d*\\.?\\d+(\\-+\\d*\\.?\\d+){0,3}'   // number int + float
                  , _numT = '\\w*(\\-+\\w*){0,2}'                   // text + number

                  , _hex  = '#[0-9a-f]{3}([0-9a-f]{3})?'
                  , _a    = '(\\s*(1|0?\\.?\\d*))?\\s*'
                  , _rgba = '(rgba|rgb)\\(\\s*((\\d{1,2}|1\\d+\\d|2([0-4]\\d|5[0-5]))\\s*,?){3}'+ _a +'\\)'
                  , _hsla = '(hsla|hsl)\\(\\s*(\\d{1,2}|[1-2]\\d{2}|3[0-5]\\d)\\s*,(\\s*(\\d{1,2}|100)\\%\\s*,?){2}' + _a +'\\)'


                  // Uu tien value phuc tap truoc
                  // Ki tu nao cung them dau //
                  , reStr = prefix + '\\-+('+ _hex +'|'+ _rgba +'|'+ _hsla +'|'+ _numF +'|'+ _numT +')'
                  , reInt = /^\-?\d+$/g
                  , re, value;

                var _check = function(_v) {
                    _v = _v.replace(prefix + '-', '');   // Get value only

                    // opt Array: check exist
                    if( typeof aName == 'object' ) {

                        if( aName.indexOf(_v) != -1 ) return _v;
                        else                          return back;
                    }
                    else return reInt.test(_v) ? parseInt(_v) : _v;
                },

                _numSplit = function(_v) {

                    if( /\w+\-+\w+/g.test(_v) ) {

                        var _n = str.match(/\-+\d*\.?\d*/g);
                        if( _n[0] != '-' && _n[1] != '-' ) {
                            for (var i = _n.length-1; i >= 0; i--) {

                                _n[i] = _n[i].replace(/^\-/g, '');
                                _n[i] = parseFloat(_n[i]);
                            }
                        }
                        else {
                            _n = str.match(/\-+\w+/g);

                            for (var i = _n.length-1; i >= 0; i--) {
                                _n[i] = _n[i].replace(/^\-/g, '');
                                if( /\d*\.?\d+/g.test(_n[i]) ) _n[i] = parseFloat(_n[i]);
                            }
                        }
                        _v = _n;
                    }
                    else if( /\d*\.?\d+/g.test(_v) ) _v = parseFloat(_v);
                    return _v;
                };



                // Value: check
                re = new RegExp(reStr, 'g');
                value = str.match(re);

                if( value != null ) {
                    var _length = value.length, _r = [];
                    for (var i = 0; i < _length; i++) {

                        // Value get
                        _r[i] = _check(value[i]);
                        // if(prefix == 'scale') console.log(_r[i]);
                        
                        // Value convert to number - double convert
                        if     ( reInt.test(_r[i]) )               _r[i] = parseInt(_r[i]);
                        else if( _r[i] == '' && back != undefined) _r[i] = back;

                        // Data layer: String with '-' convert to array, only on datalayer
                        if( !!isArray )                _r[i] = _numSplit(_r[i]);
                    }

                    // Array only 1 value: convert without array
                    if( _length == 1 ) _r = _r[0];
                    return _r;
                }
                else {
                    if( back != undefined ) return back;
                    else                    return false;
                }
            },




            is : function(str, s, back) {

                if( back !== undefined ) {
                    var name = m.valueName(str, s);
                    if( typeof name == 'string' || typeof name == 'number' ) {
                        if( 'on true 1'.indexOf(name) != -1 )
                            return (typeof back == 'number' ? 1 : true);
                        else if( 'off false 1'.indexOf(name) != -1 )
                            return (typeof back == 'number' ? 0 : false);
                        else  return back;
                    }
                    else return back;
                } 
                else return (str.indexOf(s) != -1 ? 1 : 0);
            },


            isCanvas : function() {
                var ele = document.createElement('canvas');
                return !!(ele.getContext && ele.getContext('2d'));
            },


            // Opts: ['is', 'pre']
            prefixed : function(_prop, opts) {
                var s = document.createElement('p').style
                  , v = ['Webkit','Moz', 'ms', 'O']
                  , p  = [ '-webkit-', '-moz-', '-ms-', '-o-'];

                if( s[prop] === '' )
                    return opts == 'is' ? 1 : (opts == 'pre' ? '' : prop);

                _prop = _prop.charAt(0).toUpperCase() + _prop.slice(1);
                for( var i = v.length; i--; )
                    if( s[v[i] + _prop] === '' )
                        return opts == 'is' ? 1 : (opts == 'pre' ? p[i] : v[i] + _prop);
                        
                return 0;
            },



            /* Canvas: reset position original
            ---------------------------------------------- */
            re0 : function() {
                o.idCur = 0;
                size.codeWidth();
                position.reLine();

                !!console && console.log('m.re0');
            },



            /* Array.indexOf: fixed =< IE8
            ---------------------------------------------- */
            proto : {
                array : function() {

                    Array.prototype.indexOf = function(elt) {
                        var len = this.length >>> 0
                          , from =  0;

                        for (; from < len; from++) {
                          if (from in this && this[from] === elt)
                            return from;
                        }
                        return -1;
                    }
                }
            },





            /* Short method and value
            ---------------------------------------------- */
            r     : function(v)         { return Math.round(v) },
            r6    : function(v)         { return Math.round(v*1000000)/1000000 },
            c     : function(v)         { return Math.ceil(v) },
            ra    : function()          { return Math.random() },
            rm    : function(_m,_n)     { return Math.random()*(_n-_m)+_m },
            cssD1 : function()          { cssD1[cssD] = speed[o.idCur] + 'ms'; },
            tl    : function(x,y,u)     { var u = u ? u : 'px'; return va.tl0 + x + u +', ' + y + u + va.tl1 },
            tlx   : function(x,u)       { var u = u ? u : 'px'; return va.tlx0 + x + u + va.tlx1 },
            tly   : function(y,u)       { var u = u ? u : 'px'; return va.tly0 + y + u + va.tly1 },
            ts    : function(p, s, a, d) {
                a = a ? ' ' + a : '';
                d = d ? ' ' + d + 'ms' : '';
                var t = {}; t[cssTs] = p.toString() + ' ' + s + 'ms' + a + d;
                return t;
            },

            // fix later! - too slow
            tlx2  : function(x,u){
                var u = u ? u : 'px';
                return is.ts ? va.tlx0 + x + u + va.tlx1 : x + u;
            },

            mConvert : function(M) { return [ [M[0],M[2],M[4]], [M[1],M[3],M[5]], [0,0,1] ]},
            mReturn  : function(M) { return [ m.r6(M[0][0]),m.r6(M[1][0]),m.r6(M[0][1]),m.r6(M[1][1]),M[0][2],M[1][2] ]},
            mCombine : function(M0,M1) {
                var M = [ [1,0,0],[0,1,0],[0,0,1] ], a = 2, b = 3;

                // console.log(M0, M1);
                for (var i = 0; i < a; i++) {
                    for (var j = 0; j < b; j++) {
                        M[i][j] = (M0[i][0]*M1[0][j]) + (M0[i][1]*M1[1][j]) + (M0[i][2]*M1[2][j]);
                    }
                }
                return M;
            },
            



            // NOTE:
            // Abbreviate value
            // ds: shortcut 'dash', varible for layout dash
            // st: shortcut 'slideTo', store value in method slideTo()
            // xt: x value of touch
            // m : shortcut method function
            // o.wRes : shortcut of width responsive
            // va: đối tượng lưu trữ value, nếu key muốn giữ ở 'o' thì luu trữ trên 'va.'
            // is.ts: có hỗ trợ transition css3 hay không
            // va.tlx0/1 : shorutcut string 'translateX' & ')'
            // is.tl3d : shortcut isTranslate3d
            // is.into : check slider into window.document
            // o.hCanvas != hCanvas.
            // da: shortcut data store
            // is.ontouch: check touch on device
            
            // shortcut value
            abbr : function() { o.ns = o.namespace; }
        },





        /* Properties
        ================================================== */
        prop = {

            /* setup
            ---------------------------------------------- */
            split : function(opts, data, onlyName, isShort) {

                // Data is array: data[str direct, name of data]
                // isShort: vua get short value, vua convert to array
                var str = !!data[0] ? data[0] : $cs.data(data[1]);
                if( str != undefined && str != '' ) {

                    var _str = str.replace(/\s+/g, ' ').replace(/^\s*|\s*$/g, '').split(' ');
                    for( var i = 0; i < _str.length; i++ ) {

                        var _n    = _str[i].match(/^\w*/g)[0]           // Shortcut name
                          , _v    = _str[i].replace(_n + '-', '')       // Shortcut value
                          , _is   = (_n.substr(0, 2) == 'is') ? 1 : 0
                          , _only = onlyName[_n]                        // Shortcut onlyName
                          , _s    = isShort ? _str[i] : str;            // Short value, focus in layer

                        // Value: check
                        if( _v != '' ) {

                            // Value: 'is'
                            if( _is ) {
                                if( 'ontrue1'.indexOf(_v) !== -1 )       opts[_n] = 1;
                                else if( 'offalse0'.indexOf(_v) !== -1 ) opts[_n] = 0;
                            }
                            // Value others
                            else {
                                _only = (!!_only) ? _only : 0;
                                opts[_n] = m.valueName(_s, _n, opts[_n], _only[_n], isShort);
                            }
                        }
                    }
                    // Store value
                    if( !isShort ) opts.strData = str;
                }
            },


            get : function() {

                // prototype: Array.indexOf
                !Array.prototype.indexOf && m.proto.array();


                // Slider options
                var optsName = {
                    layout    : ['line', 'dot', 'dash', 'free'],
                    fx        : o.fxName,
                    height    : ['auto', 'fixed', 'max', 'min'],
                    imgWidth  : ['none', 'autofit', 'smallfit', 'largefit'],
                    imgHeight : ['none', 'autofit', 'smallfit', 'largefit'],
                    img       : ['autofit', 'autofill', 'smallfit', 'largefit', 'smallfill', 'largefill'],
                    thumb     : ['none', 'list', 'bar'],
                    timer     : ['none', 'bar', 'arc', 'number']
                };

                prop.split(o, ['', o.dataSlider], optsName);
                prop.split(o.arc, ['', 'arc'], {});
            },



            setup : function() {

                // Options store init
                if( !is.setupInit ) {
                    o.height0 = o.height;
                }


                // Touch: check
                if( is.setupInit ) o.isTouch = is.ontouch && o.isTouch;



                // Type & TypeFx function: auto convert
                if(     o.layout == 'line' && o.fx != 'carousel') o.layout = 'dot';
                else if( o.layout == 'dot' && o.fx == 'carousel') o.layout = 'line';


                // Layout free auto convert
                if( o.layout == 'free' && !is.ts ) {
                    o.layout = o.layoutFall;
                }



                // Slide: number
                num = $s.length - 1;

                // Slide: only 1
                if( num == 0 ) {
                    if( o.isNav ) o.isNav = 0;
                    if( o.isPag ) o.isPag = 0;
                }

                // Slide: only 2
                // Below type auto convert && above Layout line setting
                // when update isLoop --> error
                if( num == 1 && o.layout == 'line' ) o.isLoop = 0;



                // Timer
                is.timer = (o.timer != 'none') ? 1 : 0;
                if( o.timer == 'arc' && !is.cs ) o.timer = 'bar';



                /* Pag name: get value */
                var _text = $cs.data('pagtext');
                if( _text != undefined ) { o.isPag = 1; o.pagText = _text; }
                if( o.thumb != 'none' )  { o.isPag = 1; is.thumb = 1; }
                else                     { is.thumb = 0; }




                // Speed, delay: minimun
                if( o.speed < 200 ) o.speed = 200;
                if( o.delay < 500 ) o.delay = 500;



                // CSS duration options
                // Note: before position.translateX() func
                tf = {}; cssD0 = {}; cssD1 = {};
                cssD0[cssD] = '0s';
                xTimer = 100;


                // Canvas: set Transition timing function
                if( o.layout != 'free' ) {
                    if( is.ts ) {
                        var _t = {}; _t[cssT] = m.easeName(o.easeTouch);
                        $canvas.css(_t);
                    }
                    else {
                        is.jEase = !!$.easing
                        va.ease = is.jEase ? o.easeTouch : 'swing';
                    }
                    is.ease = is.easeLast = 'touch';
                }


                // Translate type: fix in safari mobile and ie
                // Shortcut translate begin/end
                var _3d = 'translate3d(';
                va.tl0  = is.ie ? 'translate(' : _3d;
                va.tl1  = is.ie ? ')' : ',0)';
                va.tlx0 = is.ie ? 'translateX(' : _3d;
                va.tlx1 = is.ie ? ')' : ',0,0)';
                va.tly0 = is.ie ? 'translateY(0,' : _3d + '0,';
                va.tly1 = is.ie ? ')' : ',0)';





                // Layout line: setting
                is.rePosLine = (o.layout == 'line' && o.isLoop && num) ? 1 : 0;     // Num of slide > 0

                // Fixed: reset position when update isloop = 0 && idCur = 0;
                (o.layout == 'line' && !is.rePosLine && o.idCur == 0 && xCanvas != 0) && position.translateX(0, true, true);

                if( is.rePosLine && is.begin == undefined  ) is.begin = 1;


                

                // Layout dash: properties
                if( o.layout == 'dash' ) {
                    is.thumb = 0;

                    // n shortcut 'number', p shortcut  'position'
                    ds.nBegin = 0;
                    ds.nEnd   = 0;
                    ds.pMin   = 0;
                    ds.pMax   = 0;
                    // if( isPag ) ds.pagItem0 = $();
                }

                // Layout line & dot
                else {
                    o.stepNav = 1;
                    o.stepPlay = 1;
                }



                // Height type swap
                if( !!o.hCanvas && o.height != 'fixed' ) o.height = 'fixed';




                // Responsive: get value
                var _res = o.responsive;      // Shortcut o.responsive
                if( !!_res ) {

                    if( typeof _res == 'number' ) {
                        o.wRes = _res;
                        o.hRes = 0;
                    }
                    else if( typeof _res == 'string' ) {
                        var _r = _res.split('-');
                        o.wRes = parseInt(_r[0]);
                        o.hRes = parseInt(_r[1]);

                        // Height type: auto convert
                        if( !!o.hRes ) o.height = 'fixed';
                    }

                    // Update fix: height-type restore
                    if( is.setupInit && !o.hRes && o.height0 != o.height ) o.height = o.height0;
                }
                is.res = !!_res ? 1 : 0;




                // Media: setup
                va.mCanvas = o.mCanvas;
                if( !!o.media ) {

                    // Convert to array again
                    if( typeof o.media == 'string' ) { var _temp = o.media; o.media = [_temp]; }

                    va.media = {};
                    va.media.num = o.media.length;
                    var _wMax = 0;
                    for (var i = va.media.num-1; i >= 0; i--) {

                        var a = o.media[i].split('-');
                        va.media[i] = {
                            'width' : parseInt(a[0]),
                            'from'  : parseInt(a[1]),
                            'to'    : parseInt(a[2])
                        };

                        _wMax = (_wMax < parseInt(a[2])) ? a[2] : _wMax;
                    }
                    va.media.wMax = parseInt(_wMax);
                }



                // Rate: init
                // Update fix: setup only one at init
                if( !is.setupInit ) {
                    if( is.res ) {
                        res.varible();
                        va.rateLast = va.rate;      // Get rateLast at first va.rate setup
                    }
                    else va.rate = 1;
                }



                // Show: setup
                if( !!o.showFrom ) {

                    // Convert to array again
                    if( typeof o.showFrom == 'string' )      { var _temp = o.showFrom; o.showFrom = [_temp]; }
                    else if( typeof o.showFrom == 'number' ) { var _temp = o.showFrom; o.showFrom = [_temp+'-100000']; }

                    va.showFrom = {};
                    va.showFrom.num = o.showFrom.length;

                    for (var i = va.showFrom.num-1; i >=0; i--) {
                        var a = [], _n = o.showFrom[i];      // Shortcut number o.showFrom

                        if( typeof _n == 'number' ) { a[0] = _n; a[1] = 100000; }
                        else                        a = _n.split('-');

                        va.showFrom[i] = {
                            'from' : parseInt(a[0]),
                            'to'   : parseInt(a[1])
                        };
                    }
                    size.codeShow();
                }
                else is.showFrom = 1;




                // Grab cursor: toggle class
                if( o.isDrag ) m.toggleClass('grab', 1);
                else           m.toggleClass('grab', -1);

                // Grab stop
                if( o.isViewGrabStop ) $viewport.addClass(o.ns+'grabstop');
                else                   $viewport.removeClass(o.ns+'grabstop');



                // Loadway: init
                !is.setupInit && load.way();



                // Update fixed: remove Canvas-height inline
                if( !!is.setupInit && o.height == 'fixed' ) $canvas.css('height', '');


                // Others:
                if( !is.setupInit ) id.layer = [];
            },


            storeLast : function() {

                is.overlay1 = o.isOverlay;
                is.shadow1 = o.isShadow;

                is.slideshow1 = o.isSlideshow;
                is.hoverPause1 = o.isHoverPause;
                va.timer1 = o.timer;
            },





            /* Slider properties
            ---------------------------------------------- */
            slider : function() {

                // Properties setup
                prop.setup();
                if( is.setupInit == undefined ) is.setupInit = 1;


                // Slider: clear datas
                $cs.removeAttr('data-slider data-pagtext data-arc')
                   .removeData('slider pagtext arc');


                // Codeslide: add layout & fx
                // class0 unnessary when update properite, review!!
                // $cs.attr('class', o.class0);
                $cs.addClass(o.ns + o.layout)
                   .addClass('fx-' + o.fx)
                   .addClass('height-' + o.height);

                !is.ts && $cs.addClass(o.ns + 'old');
                !is.showFrom && $cs.addClass(o.ns + 'hide');
                !!o.isLoadAll && $cs.addClass(o.ns + 'ready');
            },






            /* Slide properties
            ---------------------------------------------- */
            slide : function() {

                // Slide: store value
                var n = 0
                  , delayArray = []
                  , speedArray = []
                  , fxArray    = []
                  , slotArray  = [];

                is.fxLine = (o.fx == 'carousel');


                // Slide: each slide
                $s.each(function() {
                    var $el = $(this)
                      , str = $el.data(o.dataSlide);

                    // slide: get number
                    if( is.setupInit == 1 ) {
                        if( n == 0 )   va.$s0 = $el;
                        if( n == 1 )   va.$s1 = $el;
                        if( n == 2 )   va.$s2 = $el;
                        if( n == num ) va.$sn = $el;
                    }


                    // Slide: store data
                    $el.data({ 'id' : n });
                    n++;


                    // Fx type - speed - delay
                    if( str != undefined && str != '' ) {

                        if( is.fxLine ) fxArray.push(o.fx);
                        else            fxArray.push( m.valueName(str, 'fx', o.fx) );

                        slotArray.push(  m.valueName(str, 'slot', o.slot) );
                        speedArray.push( m.valueName(str, 'speed', o.speed) );
                        delayArray.push( m.valueName(str, 'delay', o.delay) );
                    }
                    else {

                        fxArray.push(o.fx);
                        slotArray.push(o.slot);
                        speedArray.push(o.speed);
                        delayArray.push(o.delay);
                    }
                });

                
                // Slide: addon
                (o.layout == 'free') && prop.slideAddon();


                // Properties: swap value
                va.fx   = fxArray;
                va.slot = slotArray;
                o.fxNum = o.fxName.length - 1;
                speed   = speedArray;
                delay   = delayArray;

                tDelay  = delay[o.idCur];


                // is SetupInit
                // value 1: for init slider; value 2: for init slide
                if( is.setupInit == 1 ) is.setupInit = 2;
            },





            /* Slide: layout free addon
            ---------------------------------------------- */
            slideAddon : function() {

                var _nLoop = 0
                  , _num   = (o.fLoop > 1) ? (o.fLoop-1) : num
                  , _nLast = 0
                  , _n     = 0

                  , _ra = function() {
                        _nLast = _n;
                        _n = m.r( m.ra()* _num);
                };

                
                for( var i = 0; i <= num; i++ ) {
                    var $el = $s.eq(i);

                    // Slide: add number
                    $el.addClass(o.fName + i);


                    // Slide: add 'in' 'out' at begin
                    if( o.isInOutBegin ) {
                        if( i == o.idCur ) $el.addClass(o.fName + '-in');
                        else               $el.addClass(o.fName + '-out');
                    }


                    // Slide: add fx number
                    if( o.isClassRandom ) {

                        do { _ra() } while (_n == _nLast && o.fLoop > 2);
                        $el.addClass('fx' + _n );
                    }

                    else {
                        if( o.fLoop > 1 ) {
                            $el.addClass('fx' + _nLoop);

                            _nLoop++;
                            if( _nLoop >= o.fLoop ) _nLoop = 0;
                        }
                    }
                }



                
                // Slide: as pag
                if( o.isSlAsPag ) {

                    // PagItem: check exist
                    if( !o.isPag ) $pagItem = $('');

                    // PagItem: add item
                    for( var i = 0; i <= num; i++ ) {
                        $pagItem = $pagItem.add($s.eq(i));
                    }

                    // PagItem: event
                    if( !o.isPag ) events.pag();

                    // Code: add class
                    $cs.addClass('slide-as-pag');
                }
            }
        },





        /* Load method
        ================================================== */
        load = {

            /* Load way
            ---------------------------------------------- */
            way : function() {

                va.aLoad = [];                                          // Shortcut array load
                va.nLoad = (va.nLoad == undefined) ? 0 : va.nLoad;      // Shortcut number loading
                va.loadNext = o.preload - 1;                            // ID load amount next
                is.preload = 0;
                if( o.preload == 'all' ) o.preload = num+1;


                // Load: linear
                if( o.idCur > num ) o.idCur = 0;
                if( o.idCur == 0 ) {
                    for( var i = 0; i <= num; i++)
                        va.aLoad[i] = i;
                }

                // Load: zigzag
                else {

                    var _right = 1      // Default: load right first
                      , _n = 1
                      , _lEnd = 0       // Shortcut leftEnd
                      , _rEnd = 0;      // Shortcut rightEnd

                    va.aLoad[0] = o.idCur;
                    for( var i = 1; i <= num; i++) {

                        if( (o.idCur != num) && (_right || _lEnd) ) {
                            va.aLoad[i] = o.idCur + _n;

                            // Left: end
                            if( _lEnd ) _n++;
                            else        _right = 0;

                            // Right: check end
                            if( va.aLoad[i] >= num ) _rEnd = 1;
                        }
                        else {
                            va.aLoad[i] = o.idCur - _n;
                            _n++;

                            // Right: end
                            _right = _rEnd ? 0 : 1;

                            // Left: check end
                            if( va.aLoad[i] <= 0 ) _lEnd = 1;
                        }
                    }
                }
            },





            /* Load: setup
               optimize code later !
            ---------------------------------------------- */
            setupBegin : function() {

                if( va.nLoad < va.loadNext && va.nLoad < num ) {

                    va.nLoad++;

                    // console.log('begin -> preload false -> load begin');
                    load.slideBegin( $s.eq(va.aLoad[va.nLoad]) );
                }
            },

            setupEnd : function() {

                // preload: check
                // Can't not conbine 2 case -> fix later!
                if( !is.preload ) {

                    is.preload = 1;
                    for( var i = 0; i < o.preload; i++ )
                        if( !$s.eq(va.aLoad[i]).data('img-load') ) is.preload = 0;


                    if( is.preload && va.nLoad < num ) {
                        va.loadNext += o.loadAmount;

                        va.nLoad++;

                        // console.log('end -> preload false -> load begin');
                        load.slideBegin( $s.eq(va.aLoad[va.nLoad]) );
                    }
                }

                else {

                    var _isLA = 1       // Shortcut is load amount
                    for( var i = va.loadNext-o.loadAmount; i <= va.loadNext; i++ )
                        if( !$s.eq(va.aLoad[i]).data('img-load') ) _isLA = 0;

                    
                    if( _isLA && va.nLoad < num ) {
                        va.loadNext += o.loadAmount;

                        va.nLoad++;

                        // console.log('end -> preload true -> load begin', va.nLoad, va.loadNext);
                        load.slideBegin( $s.eq(va.aLoad[va.nLoad]) );
                    }

                    else if( va.nLoad >= num ) { is.loadAll = 1 }
                }
            },





            /* Slide: add slide when goto
            ---------------------------------------------- */
            add : function($sl) {

                var _isLoaded = $sl.data('img-load')
                  , _isLoading = $sl.data('isLoading');

                if( !is.loadALL && !_isLoaded && !_isLoading ) {

                    for( var i = va.nLoad; i < num; i++ ) {
                        if( va.aLoad[i] == o.idCur ) {

                            // Load value: move
                            if( i != va.nLoad + 1)
                                va.aLoad.splice(va.nLoad+1, 0 , va.aLoad.splice(i, 1)[0]);

                            va.loadNext++;
                            va.nLoad++;

                            // console.log('add -> load begin');
                            load.slideBegin( $s.eq(va.aLoad[va.nLoad]) );
                        }
                    }
                }
            },






            /* Slide: load image
            ---------------------------------------------- */
            slideBegin : function($slide) {

                // Load: setup begin
                load.setupBegin();


                // Slide: store data image
                var $imgs  = $slide.find('img, a.'+ o.ns+o.imgName)
                  , imgNum = $imgs.length
                  , _nCur = 0;

                // slide: store data
                $slide.data({
                    'img-num'   : imgNum,
                    'img-load'  : 0,
                    'isLoading' : 1,
                    'height'    : 0
                });



                // Canvas: get height at first slide
                if( o.height == 'fixed' && $slide.data('id') == va.aLoad[o.preload-1] ) {
                    size.canvasHeightFix();
                }



                // Slide: get all image
                if( imgNum ) {

                    // Icon loader: render
                    image.icon.render($slide);

                    // Image
                    $imgs.each(function() {

                        // ImgBack: tag swap
                        var $i  = $(this);
                        if( this.tagName.toLowerCase() == 'a' )
                            $i = image.tagSwap($i);


                        // ImgBack: check
                        var _isBack = $i.data(o.layerName) == undefined
                                   && $i.parent('.' + o.ns + o.slideName).length
                                   && o.layout != 'dash'
                                    ? 1 : 0;

                        $i.data('isImgBack', _isBack);

                        // ImgBack: wrap
                        if( _isBack ) image.wrap($i);

                        // Video: add element
                        if( !!$i.data('csvideo') ) image.videoAdd($i);



                        // Image lazy: setup
                        var _src = $i.attr('data-'+ o.lazyName)
                          , i    = new Image();

                        // Image: all image loaded - important
                        var _loadAll = function() {

                            _nCur++;
                            if( _nCur == imgNum ) setTimeout(function() { load.slideEnd($slide); }, 1);
                        };


                        // Image loaded
                        i.onload = function() {

                            // Image: set properties
                            image.prop($slide, $i, i);


                            // Image: all image loaded
                            _loadAll();
                        }

                        // Image: load error
                        i.onerror = function() {

                            // Image: change alt
                            $i.attr('alt', '[ img load fail ]');
                            !!console && console.warn('[ codeslider: img load fail ] -> ('+_src +')');

                            // Image: all image loaded
                            _loadAll();
                        }


                        // Image src: get
                        if( _src == undefined ) {
                            _src = $i.attr('src');
                            if( _src == '' ) _src = '//:0';
                            i.src = _src;
                        }
                        else {
                            i.src = _src;
                            $i.attr('src', _src).removeAttr('data-'+ o.lazyName);
                        }
                    });
                }   

                // Slide: no image
                else load.slideEnd($slide);
            },


            slideEnd : function($slide) {

                var _h   = $slide.height()
                  , _id  = $slide.data('id')                // Shortcut id slide
                  , cond = _id == va.aLoad[o.preload-1];    // Fisrt slide


                // Slide current: setting data
                $slide.data({ 'img-load' : 1, 'height' : _h });
                if( cond ) {

                    // Canvas: set height first
                    if( o.height != 'fixed' ) { hCanvas = _h; $canvas.css('height', _h); }

                    // Slide 0: set center vertical
                    if( o.height == 'fixed') size._slideVerCenter($slide);
                }

                // Init: load continue
                if( cond ) init.load();


                // layer
                $slide.addClass(o.ns + 'ready');
                layer.init( $s.eq($slide.data('id')) );     // Layer: init, need hCanvas first!
                if( _id == o.idCur ) layer.run(_id, 'start');
                
                  

                // Icon loader: remove
                image.icon.remove($slide);

                // Slide: load next
                load.setupEnd();



                // SLideshow: play next
                !!$slide.data('isPlayNext') && cs.play();


                // Loaded slide
                var _nLoad = 'loadSlide.' + _id;
                cs.ev.trigger(_nLoad);
                if( _id == va.aLoad[num] ) { o.isLoadAll = 1; cs.ev.trigger('loadAll'); }
            }
        },






        /* Image of slide
        ================================================== */
        image = {

            /* Image properties
            ---------------------------------------------- */
            prop : function($slide, $i, i) {

                var wImg = i.width, hImg = i.height, rImg = wImg/hImg;

                // Image: store true width/height
                $i.data({'width':wImg, 'height':hImg, 'rate':rImg});


                // Responsive: set size image-bg + image-layer
                if( is.res && va.rate < 1 )
                    $i.css({ 'width' : m.r(wImg*va.rate), 'height': m.r(hImg*va.rate) });


                // Image background: set size
                if( $i.data('isImgBack') ) {

                    // Image Width/Height fit, included responsive image
                    // Slide: vertical center -> no needed!
                    o.hRes && image._fit($i);

                    // height image-bg > height slide ----> muc dich ??
                    // if( o.height == 'fixed' && _hCSS > hCanvas ) $slide.addClass('sl-hfit');
                }



                // Thumbnail: setup image
                if( is.thumb && !$slide.data('isGetThumb') ) {

                    // Function core
                    var core = function(_i) {

                        var _t    = $thumbItem.eq($slide.data('id'))
                          , _w    = !!o.wThumb ? o.wThumb : _t.width()    // shortcut width thumbnail container
                          , _h    = !!o.hThumb ? o.hThumb : _t.height()   // shortcut height thumbnail container
                          , _r    = _w /_h                                // shortcut rate thumbnail container
                          , _rImg = _i.data('rate')                       // shorcut rate thumbnail image
                          , _s    = {}                                    // shortcut style thumbnail
                          , _c;                                           // shortcut class Thumbnail

                        
                        if(      _w && !_h ) { _s = {'width': _w };  _c = o.fitWidth; }
                        else if( !_w && _h ) { _s = {'height': _h }; _c = o.fitHeight; }
                        else if(  _w && _h ) {
                            _s = { 'width' : _w, 'height': _h };

                            if( _rImg > _r ) {
                                _c = o.fitHeight;
                                _i.css({'left' : -m.r( (_rImg*_h - _w)/2 ) });   // Image: set center
                            }
                            else {
                                _c = o.fitWidth;
                                _i.css({'top': -m.r( (_w/_rImg - _h)/2 ) });      // Image: set center
                            }
                        }

                        // Image: remove style size
                        _i.css({'width': '', 'height': ''});

                        // Thumbnail: append image
                        _t.css(_s).addClass(_c).append(_i);
                    };



                    // Thumbnail src: get
                    var _src  = $slide.data('imgthumb')
                      , _type = 'data';

                    if( !_src ) _src = $i.data('imgthumb');
                    if( !_src && $i.data('isImgBack') ) { _src = $i.attr('src'); _type = 'bg'; }


                    // Thumbnail check
                    if( !!_src ) {

                        if( _type == 'data' ) {
                            var _iThumb = new Image(), _i;
                            _iThumb.onload = function() {

                                _i = $('<img></img>', {'src': _src}).data('rate', _iThumb.width/_iThumb.height);
                                core(_i);
                            }
                            _iThumb.onerror = function() {
                                !!console && console.warn('[ codeslider: thumb load fail ] -> ('+_src +')');
                            }

                            // Image thumbnail: set src
                            _iThumb.src = _src;
                        }
                        else {
                            _i = $i.clone().data('rate', rImg);
                            core(_i);
                        }
                    }
                }
            },






            /* Tag Swap: <a> -> <img>
            ---------------------------------------------- */
            tagSwap : function($a) {

                var _d = {}; _d['data-'+ o.lazyName] = $a.attr('href')          // Data lazy Name
                var _c = $a.attr('class')               // class
                  , _i = $a.attr('id')                  // id
                  , _s = $a.attr('style')               // style
                  , _v = $a.attr('data-csvideo')        // video
                  , _t = $a.attr('data-imgthumb')       // thumbnail
                  , _a = o.isCap ? '[img]' : $a.text()  // alt of image
                  , _n = o.ns + o.imgName               // Shortcut imgName
                  , _r = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
                  

                // Image: setup
                var _img = $('<img>', {'src': _r, 'alt': _a}).attr(_d);

                // Image: add elements
                (_c != _n) && _img.addClass(_c).removeClass(_n);
                _i && _img.attr('id', _i);
                _s && _img.attr('style', _s);
                _v && _img.data('csvideo', _v);
                _t && _img.attr('data-imgthumb', _t);

                
                // Image: add data-layer
                var _ln = 'data-' + o.layerName // layer name
                  , _la = $a.attr(_ln);         // layer attribute

                if( _la ) { var _l = {}; _l[_ln] = _la; _img.attr(_l); }


                // IE fix: remove attr width/height
                is.ie && _img.removeAttr('width height');


                // Image: append
                $a.after(_img).remove();
                return _img;
            },




            /* ImgBack: wrap
            ---------------------------------------------- */
            wrap : function($i) {

                var _c = o.ns + o.imgName
                  , $iWrap = $('<div></div>', {'class': _c});

                (o.layout != 'dash') && $i.wrap($iWrap).removeClass(_c);
            },


            videoAdd : function($i) {

                var _play = $('<div></div>', {'class': 'cs-citeplay'});
                $i.after(_play);
            },





            /* Icon loader
               Layout dash error:! fix later
            ---------------------------------------------- */
            icon : {
                render : function($slide) {

                    var $icon = $('<div></div>', {'class': o.ns + 'loader', 'text': 'loading'});
                    $slide
                        .data('loader', $icon)
                        .append($icon);
                },

                remove : function($slide) {

                    var _loader = $slide.data('loader');
                    _loader && _loader.remove();
                }
            },






            /* Slide image fit
            ================================================== */
            slideWH : function() {
                $s.each(function() {

                    var $sl = $(this)
                      , $i = $sl.find('.' + o.ns + o.imgName + '> img');
                    if( $i.length && $i.data(o.layerName) == undefined ) {
                        image._fit($i);

                        // Fix layer in slide when o.height = fixed, and height img-bg > hCanvas
                        if( o.height == 'fix' && o.imgHeight != 'autofit' && o.img != 'autofill' ) {
                            if( $i.height() > hCanvas && !$sl.hasClass('sl-hfit') )
                                $sl.addClass('sl-hfit');
                            else if( $i.height() < hCanvas && $sl.hasClass('sl-hfit') )
                                $sl.removeClass('sl-hfit');
                        }
                    }
                });
            },



            _fit : function($i) {

                var _r = $i.data('rate')        // Shortcut rate image
                  , _w = $i.data('width')       // Shortcut width image
                  , _h = $i.data('height');     // Shortcut height image

                var fitW = function() { $i.css({'width': wViewport, 'height': m.r(wViewport/_r)}); }
                  , fitH = function() { $i.css({'width': m.r(hCanvas*_r),'height': hCanvas}); }
                  , fit0 = function() {

                        // Remove width/height inline
                        if( !(is.res && va.rate < 1) ) $i.css({'width': '', 'height': ''});
                  };


                // Image Width
                if( (o.imgWidth == 'autofit')
                ||  (o.imgWidth == 'smallfit' && _w < wViewport)
                ||  (o.imgWidth == 'largefit' && _w > wViewport) )
                    { fitW($i) }


                else if( o.height == 'fixed' || o.hRes ) {

                    // Image Height
                    if( (o.imgHeight == 'autofit')
                    ||  (o.imgHeight == 'smallfit' && _h < hCanvas)
                    ||  (o.imgHeight == 'largefit' && _h > hCanvas) )
                        { fitH($i) }


                    // Image WH
                    else if( o.img == 'autofit' )
                        (_r > rCanvas) ? fitW($i) : fitH($i);

                    else if( o.img == 'smallfit' && _w < wViewport && _h < hCanvas )
                        (_r > rCanvas) ? fitW($i) : fitH($i);

                    else if( o.img == 'largefit' && _w > wViewport && _h > hCanvas )
                        (_r > rCanvas) ? fitW($i) : fitH($i);


                    else if( o.img == 'autofill' )
                        (_r > rCanvas) ? fitH($i) : fitW($i);

                    else if( o.img == 'smallfill' && _w < wViewport && _h < hCanvas )
                        (_r > rCanvas) ? fitH($i) : fitW($i);

                    else if( o.img == 'largefill' && _w > wViewport && _h > hCanvas )
                        (_r > rCanvas) ? fitH($i) : fitW($i);

                    else fit0($i);
                }
                else fit0($i);
            },




            /* Layout line: image background fix auto hide
               fixed for firefox
            ================================================== */
            autoShow : function() {

                var _img = $s.eq(o.idCur).find('.'+ o.ns+ o.imgName + '> img');
                if( _img.length ) {

                    _img.css('position', 'static');
                    setTimeout(function() { _img.css('position', '') }, 1);
                }
            }
        },






        /* Render
        ================================================== */
        render = {

            /* Structure
            ---------------------------------------------- */
            structure : function() {

                var _cn     = o.ns + o.canvasName       // Shortcut canvasName
                  , _sn     = o.ns + o.slideName        // Shortcut slideName
                  , _vn     = o.ns + o.viewportName     // Shortcut viewportName
                  , _child  = $cs.children()
                  , _cTag   = 'div';


                // Canvas: setup
                $canvas = $cs.find('.' + _cn)
                if( $canvas.length ) {

                    _child = $canvas.children();
                    _cTag = $canvas[0].tagName.toLowerCase();

                    if( _cTag == 'ul' ) $s = $canvas.children('li');
                }
                else {
                    _child.wrapAll( $('<div></div>', {'class': _cn}) );
                    $canvas = $cs.find('.' + _cn);
                }



                // Slide: setup
                $canvas.children().each(function() {

                    var $el  = $(this)
                      , _tag = (_cTag == 'ul') ? '<li></li>' : '<div></div>'
                      , _tn  = this.tagName.toLowerCase();      // Shortcut tagName

                    // isSlide = true
                    if( _tn == 'li' || _tn == 'div' || $el.hasClass(_sn) ) {

                        // Slide: add class
                        !$el.hasClass(_sn) && $el.addClass(_sn);

                        // Slide empty -> remove
                        !$el.children().length && $el.removeClass(_sn);
                    }
                        
                    else
                        $el.wrap( $(_tag, {'class': _sn}) );
                });

                $s = $canvas.find('.' + _sn);




                // Caption, Pagitem, imgback: setup
                va.aCap = []; va.aPag = [];
                for (var i = 0; i < $s.length; i++) {

                    var $sl  = $s.eq(i)
                      , $img = $sl.find('img, a.' + o.ns + o.imgName)
                      , _cap = ''
                      , _pag = '';

                    // Caption, imgBack: find in image
                    if( $img.length 
                    &&  $img.data(o.layerName) == undefined
                    &&  $img.parent('.' + o.ns + o.slideName).length ) {

                        $img.each(function() {

                            var $el = $(this)
                              , _tn = this.tagName.toLowerCase();       // Shortcut TagName
                            
                            // Caption: get
                            if( _tn == 'img' )    _cap = $el.attr('alt');
                            else if( _tn == 'a' ) _cap = $el.html();
                        });
                    }

                    // Caption: find next
                    var $capItem = $sl.find('.' + o.ns + 'capitem');
                    if( $capItem.length ) { _cap = $capItem.html(); $capItem.remove(); }

                    // Caption: past value
                    va.aCap[i] = _cap;



                    // Pagination item: find
                    var $pagItem = $sl.find('.' + o.ns + 'pagitem');
                    if( $pagItem.length ) { _pag = $pagItem.html(); $pagItem.remove(); }

                    // Caption: past value
                    va.aPag[i] = _pag;
                }




                // Viewport: create
                $canvas.wrap( $('<div></div>', {'class' : _vn}) );
                $viewport = $cs.find('.' + _vn);
            },






            /* Search: navigation, pagination
            ---------------------------------------------- */
            searchDOM : function(_class) {

                var _el = $();
                if( !!o.name || (o.name >= 0 && o.name != null) ) {

                    var $el = $(_class);
                    if( $el.length ) {
                        $el.each(function() {

                            var _str = $(this).data(o.dataSlider)
                              , _name;

                            if( _str != undefined && _str != '' )
                                _name = m.valueName(_str, 'name');

                            if( _name == o.name ) _el = $(this);
                        });
                    }
                }

                if( _el.length ) return _el;
                else             return $cs.find(_class);
            },




            /* Navigation
            ---------------------------------------------- */
            nav : function() {

                // Navigation: search DOM
                var _c = '.' + o.ns + o.navName
                  , $navHTML = render.searchDOM(_c);
                

                // Navigation check HTML
                if( $navHTML.length ) {

                    $nav      = $navHTML;
                    var $n    = $cs.find('.'+ o.ns + o.nextName)
                      , $p    = $cs.find('.'+ o.ns + o.prevName)
                      , $play = $cs.find('.'+ o.ns + o.playName);

                    if( $n.length ) $next = $n;
                    if( $p.length ) $prev = $p;
                    if( $play.length) { $playpause = $play; o.isPlayPause = 1; }
                }

                
                // Navigation: created if not HTML exist
                if( $nav == undefined )
                    $nav = $('<div></div>', {'class' : o.ns + o.navName });

                if( $prev == undefined ) {
                    $prev = $('<div></div>', {'class' : o.ns+o.prevName, 'text' : 'prev'});
                    $nav.append($prev);
                }

                if( $next == undefined ) {
                    $next = $('<div></div>', {'class' : o.ns+o.nextName, 'text' : 'next'});
                    $nav.append($next);
                }

                // if( $playpause == undefined && o.isPlayPause && o.isSlideshow ) {
                //     $playpause = $('<div></div>', {'class' : o.ns+o.playName, 'text' : 'play/pause'});
                //     $nav.append($playpause);
                // }


                // Navigation: add to codeslide
                if( !$navHTML.length ) $nav.appendTo($cs);
            },


            play : function() {

                // Navigation: search DOM
                var _c = '.' + o.ns + o.playName
                  , $playHTML = render.searchDOM(_c);

                if( $playHTML.length ) $playpause = $playHTML;
                else {

                    $playpause = $('<div></div>', {'class' : o.ns+o.playName, 'text' : 'play/pause'});
                    if( !$nav ) {
                        $nav = $('<div></div>', {'class' : o.ns + o.navName }).append($playpause).appendTo($cs);
                    }
                    else $nav.append($playpause);
                }
            },




            /* Pagation
            ---------------------------------------------- */
            pag : function() {

                // Pagination: search DOM
                var _c = '.' + o.ns + o.pagName
                  , $pagHTML = render.searchDOM(_c);



                // Pagination: create
                if( $pagHTML.length ) $pag = $pagHTML;
                else                  $pag = $('<div></div>', {'class' : o.ns + o.pagName});

                if( is.thumb ) $thumb = $pag.addClass(o.ns + o.thumbName);


                // Pagination: init
                // ds.pagItem0 : object javascripts
                if( o.layout == 'dash' ) ds.pagItem0 = {};

                    

                // Pagination items
                $pagItem = $(''); $thumbItem = $('');
                for( var i = 0; i <= num; i++ ) {

                    // Pag: add list
                    var _pNum = o.isPagNum ? i : ''; 
                    var $p = $('<div></div>', {'class': o.ns + 'pagitem', 'html': '<span class="pagnum">'+ o.pagText + _pNum +'</span>'});
                    $p.data({'id' : i}).append(va.aPag[i]);

                    // Pagnation item: add object
                    $pagItem = $pagItem.add($p);

                    // Pag item: append to Pag
                    if( o.layout == 'dash' ) ds.pagItem0[i] = $p;
                    else                     $p.appendTo($pag);


                    // Thumbnail item: add object
                    if( is.thumb ) {
                        var $t = $('<div></div>', {'class' : o.thumbWrap});
                        $p.append($t);
                        $thumbItem = $thumbItem.add($t);
                    }
                }


                // Pag: add to slider
                if( !$pagHTML.length ) $pag.appendTo($cs);
                if( o.isPagWrap )      $pag.wrap( $('<div></div>', {'class' : o.ns + 'pagwrap'}) );
            },  




            /* Captions
            ---------------------------------------------- */
            cap : function() {

                // Caption: search DOM
                var _c = '.' + o.ns + o.capName
                  , $capHTML = render.searchDOM(_c);

                if( $capHTML.length ) $cap = $capHTML;
                else                  $cap = $('<div></div', {'class' : o.ns + o.capName});


                // Cap: add to slider
                if( !$capHTML.length ) $cap.appendTo($cs);
            },




            /* Timer
            ---------------------------------------------- */
            timer : function() {

                // Timer: remove last timer
                !!$timer && $timer.remove();
                if( o.timer != 'none' ) {


                    // Timer: search DOM
                    var _cn = o.ns + o.timerName                    // Class name
                      , _ct = o.timerName + '-' + o.timer           // Class type
                      , $timerHTML = render.searchDOM('.'+ _cn);


                    // Timer: create
                    if( $timerHTML.length ) $timer = $timerHTML.addClass(_ct);
                    else {
                        $timer = $('<div></div>', {'class' : _cn +' '+_ct});
                        $timer.appendTo($cs);
                    }


                    // Timer bar
                    if( o.timer == 'bar' ) {
                        $timerItem = $('<span></span>', {'class' : o.timer});
                        $timer.append($timerItem);

                        // Properties init
                        slideshow.setup.bar();
                    }


                    // Timer arc
                    else if( o.timer == 'arc' ) {
                        $timerItem = $('<canvas></canvas>');
                        $timer.append($timerItem);

                        // Arc setup properties
                        var _arcOther = {
                            angCur : 0,     // Angle Current
                            pi     : Math.PI/180,
                            width  : (o.arc.width == null)  ? $timer.width()  : o.arc.width,
                            height : (o.arc.height == null) ? $timer.height() : o.arc.height
                        };
                        va.arc = $.extend(o.arc, _arcOther);

                        // Arc size
                        $timerItem.attr({'width' : va.arc.width, 'height' : va.arc.height});
                        

                        // Arc: style draw
                        va.tContext = $timerItem[0].getContext('2d');
                        var arcSet = function() {
                            var c = va.tContext;
                            c.setTransform(1,0,0,1,0,0);
                            c.translate(va.arc.width/2, va.arc.height/2);
                            c.rotate(-va.arc.pi*(90-va.arc.rotate));

                            c.strokeStyle = va.arc.stroke;
                            c.fillStyle = va.arc.fill;
                            c.lineWidth = va.arc.weight;
                        };
                        arcSet();

                        window.reqAnimFrame = (function() {
                            return  window.requestAnimationFrame ||
                                    window.webkitRequestAnimationFrame ||
                                    window.mozRequestAnimationFrame ||
                                    function(callback) { return setTimeout(callback, va.arc.update) };
                        })();
                    }


                    // Timer number
                    else if( o.timer == 'number' ) {
                        $timer
                            .attr('data-num', 0)
                            .text(0);
                    }
                }
            },





            /* Toggle simple div+image: overlay & shadow
            ---------------------------------------------- */
            divImg : function(_name, _parent) {

                var _c = o[_name+'Name']; _c = o.ns + _c;
                var _Na = _name.charAt(0).toUpperCase() + _name.slice(1)
                  , _is = o['is'+_Na];        // _Na: overlay -> Overlay

                va[_name] = $cs.find('.' + _c);
                if( _is ) {
                    if( !va[_name].length ) {

                        // Check image in container
                        var _src = $cs.data('img'+_name);
                        var _tag = (!!_src) ? '<div class="' +_c + '"><img src="' + _src + '" alt="['+_name+']"></div>'
                                            : '<div class="' +_c + '"></div>';
                        _parent.after( $(_tag) );
                    }
                }
                else if( va[_name].length ) va[_name].remove();
            },


            refresh : function() {

                (is.overlay1 != o.isOverlay) && render.divImg('overlay', $canvas);
                (is.shadow1  != o.isShadow ) && render.divImg('shadow', $viewport);
            },




            /* Other elements
            ---------------------------------------------- */
            other : function() {

                // Layer: add class
                var $layer = $s.find('[data-layer]');
                if( $layer.length ) $layer.addClass(o.ns + o.layerName);


                // Overlay & shadow
                render.refresh();
            }
        },





        /* Position
        ================================================== */
        position = {

            /* Slide: Layout Line reset
            ---------------------------------------------- */
            reLine : function() {
                if( is.rePosLine ) {

                    /* Slide 0
                    ------------------------------------------ */
                    if( o.idCur == 0 ) {

                        // Canvas: pull to right
                        if( !is.begin && !is.pull0 ) { position.translateX( num + 1, true ); }

                        // Slide 0: pull to right
                        if( !is.pull0 ) { position.objTranslateX(va.$s0, num + 1, 1); is.pull0 = 1; }

                        // Slide 1: pull to right
                        if( !is.pull1 ) { position.objTranslateX(va.$s1, num + 1, 1); is.pull1 = 1; }

                        // Init: Check begin
                        if( is.begin ) { position.translateX( num + 1, true ); is.pull = 1; is.begin = 0; }

                        is.pull = 1;
                    }


                    /* Slide 1
                    ------------------------------------------ */
                    if( o.idCur == 1 ) {

                        // Canvas: move to begin
                        if( is.pull ) { position.translateX( -(num + 1), true ); is.pull = 0; }

                        // Slide 0: move to begin
                        if( is.pull0 ) { position.objTranslateX(va.$s0, -(num + 1), 1); is.pull0 = 0; }

                        // Slide 1: move to begin
                        if( is.pull1 ) { position.objTranslateX(va.$s1, -(num + 1), 1); is.pull1 = 0; }
                    }


                    /* Slide n
                    ------------------------------------------ */
                    if( o.idCur == num ) {

                        // slide 0: pull to right
                        if( !is.pull0 ) { position.objTranslateX(va.$s0, num + 1, 1); is.pull0 = 1; }

                        // Slide 1: move to begin
                        if( is.pull1 ) { position.objTranslateX(va.$s1, -(num + 1), 1); is.pull1 = 0; }

                        is.pull = 0;
                    }
                }
            },


            // Slide: reset position
            reLineAZ : function(nx) {

                if( is.pull ) {
                    position.translateX( -(num + 1), 1);
                    is.pull = 0;
                }
                if( is.pull0 ) {
                    position.objTranslateX(va.$s0, -(num + 1), 1);
                    is.pull0 = 0;
                }
                if( is.pull1 ) {
                    position.objTranslateX(va.$s1, -(num + 1), 1);
                    is.pull1 = 0;
                }
            },



            /* Slide: Type 'center' move to position
            ================================================== */
            preSlide : function() {

                if( o.idCur == 0 ) {

                    // slide 1: pull to right
                    if( !is.pull1 && is.pull0 ) { position.objTranslateX(va.$s1, num + 1, 1);  is.pull1 = 1; }
                    
                    // slide n: pull to left
                    if( !is.pulln && !is.pull0 ) { position.objTranslateX(va.$sn, -(num + 1), 1); is.pulln = 1; }
                }


                if( o.idCur == 1 ) {

                    // slide 0: move to begin
                    if( is.pull0 && !is.pull1 ) { position.objTranslateX(va.$s0, -(num + 1), 1); is.pull0 = 0; }

                    // slide 2: pull to right
                    if( !is.pull2 && is.pull1 ) { position.objTranslateX(va.$s2, num + 1, 1); is.pull2 = 1; }
                }


                if( o.idCur == num ) {

                    // slide 0: pull to right
                    if( !is.pull0 ) { position.objTranslateX(va.$s0, num + 1, 1); is.pull0 = 1; }

                    // slide 1: move to begin
                    if( is.pull1 ) { position.objTranslateX(va.$s1, -(num + 1), 1); is.pull1 = 0; }
                }
            },



            /* Canvas: css translate
            ================================================== */
            translateX : function(nx, isNoAnim, isPosFixed, _speed) {

                var _w  = wTranslate
                  , _x  = isPosFixed ? nx : xCanvas + (- nx * _w)
                  , _tf = {};


                var _transition = function() {

                    // Canvas: remove duration
                    if( isNoAnim ) $canvas.css(cssD0);

                    
                    // Speed transition
                    if( !!_speed ) {
                        var _s = {}; _s[cssD] = _speed +'ms';
                        $canvas.css(_s);
                    }

                    
                    // Canvas: set transform - important
                    // _tf[cssTf] = m.tlx(_x);
                    _tf[cssTf] = va.tlx0 + _x + 'px' + va.tlx1;        // Faster than m.tlx();
                    $canvas.css(_tf);

                    
                    // Canvas: restore default duration
                    if( isNoAnim ) {

                        // necessitate delay 1s
                        // > 2s -> pagination not animate from 0 to n
                        setTimeout(function() { m.cssD1(); $canvas.css(cssD1); }, 0);
                    }
                }

                , _jTransition = function() {
                    _tf[cssTf] = _x;

                    if( isNoAnim ) $canvas.stop(true, true).css(_tf);
                    else           $canvas.animate(_tf, {duration:speed[o.idCur], queue:false, easing: va.ease});
                };


                // xCanvas: set current value
                xCanvas = _x;

                if( is.ts ) _transition();
                else        _jTransition();

                
                // Canvas: check move out viewport
                if( va.wMin > -xCanvas || -xCanvas > va.wMax ) m.re0();
            },


            stopX : function() {
                m.cssD1();
                $canvas.css(cssD0).css(cssD1);
            },



            /* CSS: Object translate
            ================================================== */
            objTranslateX : function($obj, nx, isPlusPosSelf, xPlus) {

                var x = (o.layout == 'dash') ? ds.pBegin[nx] : nx * wTranslate;

                var _tfValue = function() {
                    if( isPlusPosSelf )  x += m.valueX( $obj.css(cssTf) );
                }

                , _jValue = function() {
                    if( isPlusPosSelf ) {

                        var _p = parseInt( $obj.css(cssTf) );   //remove 'px'
                        if( _p == 'auto' ) _p = 0;
                        x  += _p;
                    }
                };


                is.ts ? _tfValue() : _jValue();

                // Transform: add xPlus
                if( typeof xPlus == 'number' ) x += xPlus;

                // Object: set transform
                var _tf = {}; _tf[cssTf] = is.ts ? m.tlx(x) : x;
                $obj.css(_tf);
            },


            /* Canvas: buffer translate
            ================================================== */
            bufferX : function() {

                // Layout dot: slow drag
                if( o.layout == 'dot' ) xt.offset /= 2;


                // Loop edge: slow drag ++
                if( !o.isLoop || (o.isLoop && !num) ) {
                    if( (o.idCur == 0 && xt.offset > 0)
                    ||  (o.idCur == num && xt.offset < 0) )
                        xt.offset /= 4;


                    // Grab stop view
                    if( o.isViewGrabStop ) {

                        if     ( o.idCur == 0 && xt.offset > 0 )   m.toggleClass('stop', 1);
                        else if( o.idCur == num && xt.offset < 0 ) m.toggleClass('stop', 0);
                    }
                }


                // Layout free: no move
                if( o.layout != 'free' ) {
                    xt.buffer = xCanvas + xt.offset;

                    // Canvas: move temporary
                    var _tf = {}; _tf[cssTf] = m.tlx2(xt.buffer);
                    $canvas.css(_tf);
                }
            },


            /* Canvas: move to nearly position
            ================================================== */
            nearX : function() {

                // x: Drag how many px
                var x = xt.offset;
                is.ease = 'touch';


                // Position: reset xCanvas
                // Function increase performace
                if( o.layout == 'line' && !o.isLoop && is.ts ) {
                    xCanvas = va.pBegin[o.idCur];
                }


                // Layout dash
                if( o.layout == 'dash' ) {

                    // Drag: x > 0 -> prev, x < 0 -> next
                    var _i = ds.nBegin, _isID;
                    if( x < 0 ) {
                        while( ds.pBegin[_i] < -xt.buffer ) { _i++; }
                    }

                    else if ( x > 0 ) {
                        while( ds.pBegin[_i] > -xt.buffer ) { _i--; }
                    }

                    var _isID = (_i == ds.nBegin) ? 0 : 1;
                    slideTo.run(_i, _isID);
                }

                // Layout other
                else {

                    // Width in fullwidth and touch screen
                    var _w = !!va.mCanvas ? wTranslate - (va.mCanvas*2) : wTranslate
                      , _t = o.isTouch ? 600 : 300;

                    // Width drag: select
                    var w2  = m.r(_w/2)
                      , w4  = m.r(_w/4)
                      , w10 = m.r(_w/10)
                      , w = (va.tDrag1 - va.tDrag0 < _t) ? w10 : ((o.layout == 'dot') ? w4 : w2);


                    // Canvas: restore duration
                    var _duration = function(isRestore) {

                        if( is.ts ) {
                            if( o.layout == 'dot' ) cssD1[cssD] = isRestore ? '600ms' : '0ms';
                            else                    m.cssD1();

                            $canvas.css(cssD1);
                        }
                    };



                    // Canvas: next slide
                    if( x < -w && (o.isLoop || (!o.isLoop && o.idCur < num)) && num ) {
                        _duration(0);
                        (o.layout == 'dot') && position.translateX(0);

                        slideTo.run(1, 0);
                    }

                    // Canvas: prev slide
                    else if( x > w && (o.isLoop || (!o.isLoop && o.idCur > 0)) && num ) {
                        _duration(0);
                        (o.layout == 'dot') && position.translateX(0);

                        slideTo.run(-1, 0);
                    }

                    // Canvas: restore position
                    else {
                        _duration(1);
                        // position.reLine();       // Unnecessary
                        position.translateX(0);
                    }
                    

                    // PlayAuto: reset when drag action
                    if( (x < -w || x > w) && o.isSlideshow ) {
                        is.hoverAction = 1;
                    }
                }
            },


            /* Translate: width
            ================================================== */
            translateW : function() {

                if( o.layout == 'line' || o.layout == 'dot' || o.layout == 'free' ) {
                    wTranslate = wViewport;
                    xCanvas = 0;
                }

                if( o.layout == 'dash' ) {
                    xCanvas = 0;
                }
            },


            /* Animate end
            ================================================== */
            animRebound : function(opts) {
                if( o.isAnimRebound ) {

                    // Animate: reset
                    if( o.layout == 'dot' ) xCanvas = 0;
                    else if( o.layout == 'line' || o.layout == 'free' ) xCanvas = va.pBegin[o.idCur];
                    m.cssD1(); $canvas.css(cssD1);

                    // Options: 0 -> prev, 1 -> next
                    var _t     = 150        // time delay
                      , _x     = 0.1       // x value, unit %
                      , _xGo   = (opts == 'next') ? _x : -_x
                      , _xBack = (opts == 'next') ? -_x : _x;


                    // Animate: run
                    position.translateX(_xGo, 0, 0, _t);

                    clearTimeout(id.rebound);
                    id.rebound = setTimeout(function() {

                        m.cssD1(); $canvas.css(cssD1);
                        position.translateX(_xBack);
                    }, _t);
                }
            }
        },







        /* Sizes
        ================================================== */
        size = {

            /* Codeslide: set width
            ============================================== */
            codeWidth : function() {

                // Codeslide: get width
                // If is.res == 1 -> seted in res.setup
                if( !is.res ) wViewport = $viewport.width();
                position.translateW();


                // Slide: set width
                if( o.layout == 'line' || o.layout == 'dot' ) $s.css('width', wTranslate);

                // Slide: other setting
                if( o.layout == 'line' ) size._lineWidth();
                if( o.layout == 'dash' ) size._dashWidth();
                
                va.wMax = (num+2) * wViewport;
                va.wMin = -wViewport;
            },


            _lineWidth : function() {

                // Function increase performance
                // Review later!
                if( o.layout == 'line' && !o.isLoop && is.ts ) {
                    va.pBegin = [];

                    for( var j = 0, _snum = $s.length; j < _snum; j++ )
                        va.pBegin[j] = -wViewport*j;
                }




                // Slide: set position
                for( var i = $s.length - 1; i >= 0; i-- ) {
                    position.objTranslateX( $s.eq(i), i, 0);
                }


                // position.reLine: reset attribute
                is.pull = is.pull0 = is.pull1 = 0;

                // Special slide: first slide
                if( o.idCur == 0 ) is.begin = 1;
                else                { is.begin = 0; position.translateX(o.idCur, true); }
            },


            _dashWidth : function() {

                // Slide: set position
                ds.pBegin   = [];
                ds.pEnd     = [];
                ds.width    = [];
                ds.mCanvas  = parseInt($canvas.css('margin-left'));
                is.canvasEnd = 0;

                var _snum = $s.length
                  , _x    = 0;



                // Width slide not true, waiting image loaded, fix later!
                for( var i = 0; i < _snum; i++ ) {
                    var $el = $s.eq(i)
                      , _w  = $el.outerWidth(true);

                    ds.pBegin[i] = _x;
                    _x += _w;
                    ds.pEnd[i] = _x;

                    ds.width[i] = _w;
                    position.objTranslateX($el, i, 0);
                }



                // Pag Item update
                // ds.pag will delete
                if( o.isPag ) {
                    ds.pagID = [0];
                    $pagItem.remove();
                    ds.pagItem0[0].data({'id' : 0}).appendTo($pag);

                    for( var i = 0, _wSlide = 0; i < _snum; i++ ) {

                        _wSlide += ds.width[i];
                        if( _wSlide > wViewport - ds.mCanvas ) {

                            ds.pagItem0[i].data({'id': i}).appendTo($pag);
                            ds.pagID.push(i);
                            _wSlide = ds.width[i];
                        }
                    }

                    // console.log($pag);

                    $pagItem  = $pag.find('li');
                    ds.pagNum = ds.pagID.length - 1;
                    events.pag();
                }


                // Pos Max: get
                ds.pMax = -(ds.pEnd[_snum-1] - wViewport + ds.mCanvas);

                
                // Canvas: goto current number begin
                ds.lastBegin = ds.nBegin;
                ds.nBegin = 0;
                slideTo.run(ds.lastBegin, 0);



                // Slide: clone if o.isLoop == true
                // Fix later
                if( o.isLoop ) {

                    var _nCloneBegin = ds.pagID[1] - ds.pagID[0];
                    for( var i = 0; i < _nCloneBegin; i++ ) {

                        var $_clone = $s.eq(i).clone();
                        $_clone.data({'id': -1}).appendTo($canvas);
                    }
                }

                // console.log(ds.pBegin, ds.pEnd, xCanvas, ds.pMax);
                // console.log(ds.width);
                // console.log(ds.pagID);
                // console.log(ds.pBegin, ds.pEnd);
            },





            /* Codeslide: reset height
            ============================================== */
            canvasHeight : function() {

                var $el = $s.eq(o.idCur)
                  , h   = $el.data('height')

                  , _heightFunc = function() {
                        hCanvas = h;

                        setTimeout(function() {

                            $canvas.animate({ 'height' : h }, { duration: o.heightSpeed, queue: false });
                        }, 0);
                  };


                if( (o.height == 'auto' && hCanvas != h && h > 0)
                ||  (o.height == 'max' && hCanvas < h && h > 0)
                ||  (o.height == 'min' && hCanvas > h && h > 0) )
                    _heightFunc();


                // Slide: set vertical center
                if( o.height != 'auto' && $el.data('img-load') ) size._slideVerCenter($el);
            },



            /* Canvas height at layout fix */
            canvasHeightFix : function() {

                // Responsive
                if( o.hRes ) {
                    hCanvas = m.r(o.hRes*va.rate);
                    $canvas.css('height', hCanvas);
                }
                else {

                    // Height value in css, priority in css -> next to o.hValue
                    var _h = $canvas.height();

                    if( !_h && !!o.hCanvas ) {
                       _h = o.hCanvas;
                       $canvas.css('height', _h);
                    }
                    if( !_h ) _h = 0;
                    hCanvas = _h;
                }
                
                if( !is.res ) wViewport = $viewport.width();    // wViewport: get when is.res = 0
                rCanvas = wViewport/hCanvas;
            },






            /* Slides: set all slide at time
            ============================================== */
            slideHeight : function() {

                // hCanvas: reset
                if( o.height == 'max' ) hCanvas = 0;
                if( o.height == 'min' ) hCanvas = 10000;


                // Update prop fix: height-type -> reset image background
                (!is.res && o.height == 'auto') && image.slideWH();
                

                // Slide: properties
                $s.each(function() {

                    var $el = $(this);

                    if( $el.data('img-load') )
                        $el.css('top', '').data('height', $el.height());
                });
            },



            _slideVerCenter : function($sl) {

                var _top = m.r( (hCanvas - $sl.height())/2 );
                if( _top != 0 ) $sl.css('top', _top );
            },





            /* Codeslide: toggle show/hide
            ============================================== */
            codeShow : function() {

                var _s = va.showFrom, _w = $w.width();
                is.showFrom = 0;

                // Check is.showFrom
                for( var i = _s.num-1; i >= 0 && !is.showFrom; i-- ) {
                    if( _w >= _s[i].from && _w <= _s[i].to ) is.showFrom = 1;
                }
            }
        },







        /* Slide to
        ================================================== */
        slideTo = {


            /* Layout
            ---------------------------------------------- */
            line : function(st) {
                position.stopX();
                position.reLine();
                st.isID && position.reLineAZ();

                slideTo.idCur(st);
                is.firefox && image.autoShow();

                clearTimeout(id.line);
                id.line = setTimeout(function() {

                    size.canvasHeight();
                    position.translateX(st.num);                // TranslateX next item

                    slideTo.lineEnd(speed[o.idLast] + 10);     // Slide: end animate
                }, 1);                                          // need delay 1;
            },

            lineEnd : function(_timer) {
                clearTimeout(id.lineEnd);
                id.lineEnd = setTimeout(function() {

                    position.reLine();

                    cs.ev.trigger('after');                     // Event after()
                    (o.idCur == num) && cs.ev.trigger('end');  // Event end()

                    layer.slideStart(o.idCur);
                    slideTo.end();

                }, _timer);
            },




            dash : function(st) {

                // Position: reset when drag immediately
                position.stopX();


                // Number: setup
                slideTo.dashNum(st);
                m.toggleDash();


                // Goto end position
                if( !o.isLoop && st.num > 0 && ds.nEnd == num ) {
                    position.translateX(ds.pMax, 0, 1);
                    is.canvasEnd = 1;
                }

                // prev after end position
                else if( !o.isLoop && st.num < 0 && is.canvasEnd ) {
                    position.translateX(-ds.pBegin[ds.nBegin], 0, 1 );
                    is.canvasEnd = 0;
                }

                // Other position
                else position.translateX(-ds.pBegin[ds.nBegin], 0, 1);


                // Transition End: set properties
                setTimeout( slideTo.end, speed[0] + 10 );
            },



            dot : function(st) {
                // Layer: double clear timeout
                // layer.run(o.idCur, 'initless');

                var f    = {};
                f.$sCur  = $s.eq(o.idCur);
                f.$sLast = $s.eq(o.idLast);
                f.$tar   = f.$sCur.find('.' + o.ns + o.imgName);
                f.direct = (st.num > 0) ? 'in' : 'out';

                if( f.$tar.length ) fxFunc.init(f);

                size.canvasHeight();
            },



            free : function(st) {
                slideTo.idCur(st);
                m.toggleFree();
            },




            /* Number Current: setup
            ---------------------------------------------- */
            idCur : function(st) {
                o.idLast = o.idCur;
                o.idCur += st.num;

                if( o.isLoop ) {
                    if(      st.num < 0 && o.idCur < 0 )   o.idCur = num;
                    else if( st.num > 0 && o.idCur > num ) o.idCur = 0;
                }

                // Add delay: layout dot in chrome running effect -> slide shake.
                if( o.layout == 'dot') setTimeout(m.toggle, 30);
                else                   m.toggle();
            },


            dashNum : function(st) {

                // Number Begin: get
                var _begin0 = ds.nBegin
                  , _sum = _begin0 + st.num;

                if( !o.isLoop && st.num < 0 && _sum < 0 ) {
                    st.num = - _begin0;
                    ds.nBegin = 0;
                }
                else if( !o.isLoop && st.num > 0 && _sum > num ) {
                    st.num = num - _begin0;
                    ds.nBegin = num;
                }
                else ds.nBegin += st.num;


                // Position Begin: get
                var _xBegin = 0, i = 0;
                if( st.num > 0 ) for (; i < st.num; i++) _xBegin += ds.width[_begin0 + 1];
                else             for (; i > st.num; i--) _xBegin -= ds.width[_begin0 - 1];


                // Number End: find
                var _i    = ds.nBegin
                  , _xEnd = -xCanvas - ds.mCanvas + wViewport + _xBegin;

                while ( ds.pEnd[_i] <= _xEnd ) { _i++ }
                ds.nEnd = _i-1;

                // console.log(_xEnd, ds.pEnd, ds.nEnd);
                // console.log(ds.nEnd);



                // Number begin: update
                if( ds.nEnd == num ) {
                    var _x = ds.pEnd[num] - wViewport + ds.mCanvas
                      , _j = num;

                    // console.log(_x, ds.pBegin, ds.nBegin);
                    while ( ds.pBegin[_j] >= _x ) { _j-- }
                    ds.nBegin = _j+1;
                }


                // Number current: update
                // NumCur will remove - fix later!
                o.idCur = (st.num > 0) ? ds.nEnd : ds.nBegin;
            },





            /* Run: goto slide
            ---------------------------------------------- */
            run : function(nSlide, isID) {
                
                // Layout: swape o.idCur value
                var _nCur = (o.layout == 'dash') ? ds.nBegin : o.idCur;


                // Check action
                if( !isID || (isID && _nCur != nSlide) ) {

                    // slideTo: store properties
                    var st = {
                        num  : nSlide,
                        isID : !!isID
                    };


                    var core = function() {

                        // Callback func: start && before
                        st.isID ? (st.num == 0) && cs.ev.trigger('start')
                                : (_nCur + st.num == 0 || _nCur + st.num - num == 1 ) && cs.ev.trigger('start');
                        cs.ev.trigger('before');


                        // ID: convert to st.num
                        if( st.isID ) st.num -= _nCur;
                        
                        // NumCur fix: when have delay in layout dot -> run first
                        if( o.layout == 'dot') slideTo.idCur(st);


                        // Canvas: set Transition timing function
                        if( o.layout != 'free' ) {

                            var _t = {}, _ease;
                            if     ( is.ease == 'touch' && is.easeLast == 'move' ) _ease = o.easeTouch;
                            else if( is.ease == 'move' && is.easeLast == 'touch' ) _ease = o.easeMove;

                            if( !!_ease ) {
                                if( is.ts ) {
                                    _t[cssT] = m.easeName(_ease);
                                    $canvas.css(_t);
                                }
                                else if( is.jEase ) va.ease = _ease;
                                is.easeLast = is.ease;
                            }
                        }


                        // Layout: select
                        switch (o.layout) {
                            case 'dot'    : slideTo.dot(st); break;
                            case 'line'   : slideTo.line(st); break;
                            case 'dash'   : slideTo.dash(st); break;
                            case 'free'   : slideTo.free(st); break;
                        }
                    };


                    // Layer: run
                    if( o.layout != 'dash') layer.slidePause(_nCur);

                    // Core func
                    core();
                }
            },




            /* End of effect
            ---------------------------------------------- */
            end : function() {
                is.fxRun = 0;

                // Playauto: reset when click nav, pag, drag
                if( o.isSlideshow ) {
                    is.hoverAction = 1;
                    !o.isHoverPause && slideshow.go();
                }
            }
        },







        /* Events
        ================================================== */
        events = {

            prev : function() {

                var _step;
                if( o.stepNav == 'visible' ) {
                    var _nb   = ds.nBegin-1
                      , _view = wViewport-ds.mCanvas
                      , _sum  = 0;

                    if( ds.pEnd[_nb] < _view ) _step = ds.nBegin;
                    else {

                        while ( _sum <= _view ) { _sum += ds.width[_nb--] }
                        _step = ds.nBegin - (_nb+2);
                    }
                }
                else _step = o.stepNav;

                is.ease = 'move';
                if( o.isLoop || (!o.isLoop && o.idCur > 0) ) slideTo.run( -_step);
                else                                          position.animRebound('prev');
                return false;
            },

            next : function(_isSlideshow) {

                var _o = _isSlideshow ? o.stepPlay : o.stepNav;
                var _step = (_o == 'visible') ? (ds.nEnd - ds.nBegin + 1) : _o;

                is.ease = 'move';
                if( o.isLoop || (!o.isLoop && o.idCur < num) ) slideTo.run(_step);
                else                                            position.animRebound('next');

                return false;
            },


            nav : function() {

                $prev.on(va.clickName, function(e) { events.prev(); return false; });
                $next.on(va.clickName, function(e) { events.next(); return false; });
            },

            pag : function() {

                $pagItem.off(va.clickName);
                $pagItem.on(va.clickName, function(e) {

                    is.ease = 'move';
                    slideTo.run($(this).data('id'), 1);
                    return false;
                });
            },





            touch : function() {
                events.touchOFF();
                o.isTouch && events.touchON();     
            },

            touchON : function() {

                /* Touch move
                ---------------------------------------------- */
                $viewport.on('touchmove.cs', function(e) {

                    // Offset: get
                    var i = e.originalEvent.touches[0];
                    xt.offset = i.pageX - xt.o;

                    // Scroll page and touch slider
                    xt.y = Math.abs(xt.y0 - i.pageY);
                    if( va.touchmove == null && xt.y > 5 )                va.touchmove = 'page';
                    if( va.touchmove == null && Math.abs(xt.offset) > 5 ) va.touchmove = 'slider';

                    if( va.touchmove == null || va.touchmove == 'slider' ) {
                        e.preventDefault();                     // Fix stop Android
                        position.bufferX();
                    }
                    

                    var $output = $('#output');
                    if( $output.length ) {
                        $output.text( va.touchmove );
                    }
                });


                /* Touch start
                ---------------------------------------------- */
                $viewport.on('touchstart.cs', function(e) {

                    // Touch: get Time begin
                    va.tDrag0 = va.tDrag1 = +new Date();

                    // X0: get value
                    var i = e.originalEvent.touches[0];
                    xt.o  = i.pageX;

                    // Y0 get value
                    xt.y0 = i.pageY;
                    va.touchmove = null;

                    // x offset : reset value
                    xt.offset = 0;

                    // Canvas: stop duration
                    $canvas.css(cssD0);
                });


                /* Touch end
                ---------------------------------------------- */
                $viewport.on('touchend.cs', function(e) {
                    va.tDrag1 = +new Date();   // Touch: get Time end

                    position.nearX();
                });
            },

            touchOFF : function() {
                $viewport.off('touchmove.cs touchstart.cs touchend.cs');
            },






            drag : function() {
                is.move = 0;

                events.dragOFF()
                o.isDrag && events.dragON();
            },


            dragEnd : function() {

                va.tDrag1 = +new Date();
                is.move = 0;

                // console.log('nearx mouseUp', is.move);
                position.nearX();

                // Cursor: toggle class
                o.isDrag && m.toggleClass('grab', 1);
                o.isViewGrabStop && m.toggleClass('stop', -1);
            },

            dragON : function() {


                /* Darg start
                ---------------------------------------------- */
                $viewport.on('dragstart', function(e) { return false });





                /* Mouse move
                ---------------------------------------------- */
                $viewport.on('mousemove.cs', function(e) {

                    if( is.move ) {
                        xt.offset = e.pageX - xt.o;
                        position.bufferX();
                    }
                });


                /* Mouse down
                ---------------------------------------------- */
                $viewport.on('mousedown.cs', function(e) {

                    if( !is.move ) {

                        // Touch: get Time end
                        va.tDrag0 = +new Date();

                        // X0: get value
                        xt.o = e.pageX;

                        // x offset : reset value
                        xt.offset = 0;

                        // Canvas: stop duration
                        $canvas.css(cssD0);
                        is.move = 1;


                        // Canvas: get xCanvas
                        // increase performance
                        if( o.layout == 'line' && !o.isLoop && is.ts ) {
                            var _x = $canvas.css(cssTf);
                            xCanvas = (_x == 'none') ? 0 : m.valueX(_x);
                        }


                        // Cursor: toggle class
                        o.isDrag && m.toggleClass('grab', 0);
                    }
                });


                /* Mouse up/leave
                ---------------------------------------------- */
                $viewport.on('mouseup.cs', function(e) {

                    // Touch: get Time end
                    if( is.move ) events.dragEnd();
                });


                $viewport.on('mouseleave.cs', function(e) {

                    if( is.move ) events.dragEnd();
                });
            },

            dragOFF : function() {
                $viewport.off('dragstart mousemove.cs mousedown.cs mouseup.cs mouseleave.cs');
            },




            keyboard : function() {
                $(document).off('keyup.cs');

                if( o.isKeyboard ) {
                    $(document).on('keyup.cs', function(e) {

                        // Check slideInto
                        slideshow.scroll.check(1);
                        if( is.into ) {

                            var keycode = e.keyCode;
                            is.ease = 'move';
                            if( keycode == 37 ) {
                                if( o.isLoop || (!o.isLoop && o.idCur > 0) )   slideTo.run(-1);
                                else                                            position.animRebound('prev');
                            }
                            else if( keycode == 39 ) {
                                if( o.isLoop || (!o.isLoop && o.idCur < num) ) slideTo.run(1);
                                else                                            position.animRebound('next');
                            }
                        }
                    });
                }
            },





            resize : function() {
                var _tCheck = o.isTouch ? 100 : 300;

                var _check = function() {

                    clearTimeout(id.resize);
                    id.resize = setTimeout(function() {

                        // Event trigger 'resize'
                        cs.ev.trigger('resize');

                        // Code: toggle showFrom
                        if( !!o.showFrom ) {
                            size.codeShow();
                            var _c = o.ns + 'hide';    // Shortcut class showhide

                            if( !is.showFrom && !$cs.hasClass(_c) ) $cs.addClass(_c);
                            if( is.showFrom && $cs.hasClass(_c) )   $cs.removeClass(_c);
                        }

                        if( ($viewport.width() != wViewport) || ($canvas.height() != hCanvas) ) {
                            update.resize();

                            // Setup: recheck
                            if( o.layout == 'line' || o.layout == 'dot' ) _reCheck();
                        }
                    }, _tCheck);
                };

                var _reCheck = function() {

                    clearTimeout(id.resize);
                    id.resize = setTimeout(function() {

                        if( $viewport.width() != wViewport ) update.resize();
                    }, o.heightSpeed + 10);
                };


                // Resize: event
                $w.on('resize.cs', function() { _check() });
            }
        },





        /* Update
        ================================================== */
        update = {
            removeClass : function() {

                var _t = o.ns + 'one ' + o.ns + 'multi'
                  , _l = o.ns + 'line ' + o.ns + 'dot ' + o.ns + 'dash';

                $cs.removeClass(_t +' '+ _l);
            },


            slide : function() {

                // Layout dot: remove translate
                if( o.layout == 'dot' ) {
                    var _tf = {}; _tf[cssTf] = '';
                    $s.css(_tf);

                    position.translateX(0, 1, 1);
                }
            },



            resize : function() {

                // Func: order function important!
                // !!console && console.log('update resize');

                is.res && res.setup();

                // Fixed in height fix -> for image autofit/autofill
                (o.height == 'fixed') && size.canvasHeightFix();

                size.slideHeight();
                size.codeWidth();
                is.rePosLine && position.reLine();

                !is.res && image.slideWH();                 // Update image background without is.res
                setTimeout(layer.update, 0);                // Need delay
                setTimeout(size.canvasHeight, 10);          // canvasHeight func : update make image shake
            }
        },





        /* Effects
        ================================================== */
        fxFunc = {

            init : function(f) {

                var _fx = (va.fx[o.idCur] == 'random') ? o.fxName[m.r(m.rm(2,o.fxNum))] : va.fx[o.idCur];

                // console.log(typeof _fx, _fx, va.fx[o.idCur], o.idCur);
                fxFunc[_fx](f);
            },



            /* Effect Core function
            ---------------------------------------------- */
            setup : function(f, noInvert, isSizeSquare, isImgFading) {

                // FxOver: in slide numberLast -> remove
                var _fxLast = f.$sLast.find('.fx-overlay')
                  , _imgC = '.' + o.ns + o.imgName      // Shortcut image class
                  , _imgLast = f.$sLast.find(_imgC +'> img');

                if( _imgLast.length ) _imgLast.css('visibility', '');
                if( _fxLast.length )  _fxLast.remove();



                // Direction
                f.d = {};
                switch( f.direct ) {
                    case 'in'  : f.d = { is: 1, fade : 1, reFade : 0, mark: -1 }; break;
                    case 'out' : f.d = { is: 0, fade : 0, reFade : 1, mark: 1  }; break;
                }

                if( noInvert ) f.d.is = 1;


                // Properties
                var nTar = o.idCur
                  , d    = '<div></div>';

                f.$cur  = f.$sLast.find(_imgC);
                f.wCur0 = f.$cur.width();
                f.wTar0 = f.$tar.width();       // Shortcut true width width image background current
                f.hTar  = f.$tar.height();      // Shortcut true width height image background current
                f.wCur  = (f.wCur0 < wViewport) ? f.wCur0 : wViewport;
                f.wTar  = (f.wTar0 < wViewport) ? f.wTar0 : wViewport;

                f.isW        = f.wCur > f.wTar;
                f.wLarge     = f.isW ? f.wCur : f.wTar;
                f.wSmall     = f.isW ? f.wTar : f.wCur;

                f.$wrapBack  = f.d.is ? f.$cur.clone() : f.$tar.clone();
                f.$wrapFront = f.d.is ? f.$tar.clone() : f.$cur.clone();
                f.$fxOver    = $(d, {'class': 'fx-overlay'}).css('width', f.wLarge);
                f.$fxInner   = $(d, {'class': 'fx-inner'}).css({'width' : f.wLarge, 'height' : f.hTar});
                f.$fxBack    = $(d, {'class': 'fx-back'});
                f.$fxFront   = $(d, {'class': 'fx-front'});


                // Image back: remove visible hidden, run first -> not usefull
                f.$wrapBack
                    .add(f.$wrapFront)
                    .find('img')
                    .css('visibility', '');


                // fx: append
                f.$fxOver
                    .append(f.$fxInner)
                    .appendTo($s.eq(o.idCur));

                f.$fxBack
                    .append(f.$wrapBack)
                    .appendTo(f.$fxInner);
                

                // Fx Style
                var _bgName = 'background-color'
                  , _bg = {}; _bg[_bgName] = $viewport.css(_bgName);


                f.$fxInner.css(_bg);
                if( f.wCur != f.wTar ) f.$wrapFront.css(_bg);



                // Image Back: position & fading
                if( isImgFading ) {
                    var _oBegin = f.d.is ? 1 : 0.5
                      , _oEnd   = f.d.is ? 0.5 : 1;
                    f.$fxBack
                        .find('img')
                        .css('opacity', _oBegin)
                        .animate({'opacity' : _oEnd}, speed[o.idCur]);
                }




                // Image: fit-width, fit-height
                var _wb  = f.$wrapBack
                  , _wf  = f.$wrapFront
                  , _wbi = _wb.find('img')
                  , _wfi = _wf.find('img')
                  , _fw  = { 'width': wViewport, 'height': 'auto' }
                  , _fh  = { 'width': 'auto', 'height': hCanvas };

                if( _wb.hasClass(o.fitWidth) )       _wbi.css(_fw);
                else if( _wb.hasClass(o.fitHeight) ) _wbi.css(_fh);

                if( _wf.hasClass(o.fitWidth) )       _wfi.css(_fw);
                else if( _wf.hasClass(o.fitHeight) ) _wfi.css(_fh);




                // Wrapslot: append 
                f.$wrapFront.appendTo(f.$fxFront);



                // Slot: size
                if( isSizeSquare ) {
                   var ba;
                    f.hSlot   = m.c(f.hTar / f.slot);
                    f.slotHor = m.r(f.wLarge / f.hSlot);
                    ba        = f.wLarge - (f.hSlot * f.slotHor);
                    f.wFront   = f.hSlot + m.c(ba / f.slotHor);

                    f.$fxFront.css({'width' : f.wFront, 'height' : f.hSlot});
                    f.$wrapFront.css({'width': '100%', 'height' : '100%'});
                }
                else {
                    f.wFront = m.c(f.wLarge/f.slot);
                    f.$fxFront.css({'width': f.wFront, 'height': '100%'});
                    f.$wrapFront.css({'width': f.wFront, 'height': '100%'});
                }



                // Padding: setup
                f.pSlideView = m.c((wViewport-f.wLarge)/2);
                f.pTarView   = (f.wTar0 > wViewport) ? m.r((f.wTar0-wViewport)/2) : 0;  // Shortcut padding image target 0 & viewport
                f.pCurView   = (f.wCur0 > wViewport) ? m.r((f.wCur0-wViewport)/2) : 0;  // Shortcut padding image current 0 & viewport
                f.pFView     = f.d.is ? f.pTarView : f.pCurView;        // Shortcut padding image front & viewport
                f.pBView     = f.d.is ? f.pCurView : f.pTarView;        // Shortcut padding image back & viewport

                var _isW = f.d.is ? f.isW : !f.isW
                  , _a = (f.wLarge - f.wSmall)/2;
                f.pImgBack  = _isW ? 0 : _a;
                f.pImgFront = _isW ? _a : 0;


                // Image center: set left
                f.$fxBack.find('img').css('left', - f.pBView + f.pImgBack);


                // Image center: set top
                f.top = m.r( (f.$sCur.height() - f.$sLast.height())/2 );

                if( isSizeSquare ) {
                    if( f.d.is ) { f.$fxBack.css('top', f.top); f.top = 0; }
                }
                else {

                    if( f.d.is ) f.$fxBack.css('top', f.top);
                    else         f.$wrapFront.find('img').css('top', f.top);
                }



                // Image Background: hidden -> hide image current
                if( f.d.is ) f.$tar.find('img').css('visibility', 'hidden');
            },



            transformEnd : function(f, opts) {

                // Dragstart stop
                f.$fxInner.on('dragstart', function(e) { return false });

                va.fxTime0 = +new Date();

                // Easing: setup
                var _esIn = f.easeIn ? f.easeIn : 'easeOutCubic'
                  , _esOut = f.easeOut ? f.easeOut : 'easeInCubic'
                  , _es = f.d.is ? m.easeName(_esIn) : m.easeName(_esOut);

                // FxSlot: animate end
                f.$fxFront = f.$fxInner.find('.fx-front');
                f.$fxFront.each(function() {

                    var $el = $(this)
                      , _sp = $el.data('speed')
                      , _tf = $el.data('tfEnd')
                      , _ts = (typeof _tf['opacity'] != 'number') ? m.ts(cssTf, _sp, _es) : m.ts('opacity', _sp, _es)
                      , $obj;

                    if( opts == 'this' ) $obj = $el;
                    if( opts == 'wrap' ) $obj = $el.find('.' + o.ns + o.imgName);

                    setTimeout(function() {
                        
                        if( is.ts ) $obj.css(_ts).css(_tf);
                        else        $obj.animate(_tf, _sp);

                    }, $el.data('delay'));
                });

                

                // Fx animation end
                // Add time + 100 -> effect avoid shake
                setTimeout(function() {fxFunc.end(f)}, speed[o.idCur]);
            },



            end : function(f) {
                if( !!f ) {

                    // Image-background: restore visible
                    if( f.d.is ) f.$tar.find('img').css('visibility', '');
                    f.$fxOver.remove();
                }

                cs.ev.trigger('after');
                (o.idCur == num) && cs.ev.trigger('end');

                layer.slideStart(o.idCur);
                slideTo.end();
            },





            /* Effect basic
            ---------------------------------------------- */
            fade : function(f) {
                
                // Fx setup
                f.slot  = 1;
                fxFunc.setup(f, false, false, false);

                // FxSlot: set Opacity
                var _tfBegin = {}; _tfBegin['opacity'] = f.d.reFade;
                f.$fxFront.css(_tfBegin);


                // Image front setting
                f.$wrapFront
                    .find('img')
                    .css({'left': - f.pFView + f.pImgFront, 'top': f.top});


                // FxFront
                var _tfEnd = {}; _tfEnd['opacity'] = f.d.fade;
                f.$fxFront
                    .data({'speed' : speed[o.idCur], 'delay' : 0, 'tfEnd' : _tfEnd})
                    .appendTo(f.$fxInner);

                // Easing: setup
                f.easeIn  = 'linear';
                f.easeOut = 'linear';


                // Transform end
                fxFunc.transformEnd(f, 'this');
            },








            /* Structure
            -------------------------------------------

                .fx-overlayer
                    .fx-inner
                        
                        .fx-back
                            .img-wrap
                                img
                        
                        .slot * n
                            .img-wrap
                                img

            ------------------------------------------- */
            rectMove : function(f, _slot) {
                
                // Fx slot: get
                if( _slot == undefined ) {
                    var _nSlot = (wViewport > 768) ? 5 : 3
                      , _sCur = va.slot[o.idCur];   // Shortcut slotCurrent

                    f.slot = (_sCur == 'auto') ? m.r(m.rm(0,_nSlot+3)) : parseInt(_sCur);
                }
                else f.slot = _slot;


                // Fx setup
                fxFunc.setup(f, true, false, false);



                // Wrap Slot: transform
                var _tfBegin = {}, _tfEnd = {};
                _tfBegin[cssTf] = is.ts ? m.tlx(f.d.mark*f.wFront) : f.d.mark*f.wFront;
                _tfEnd[cssTf]   = is.ts ? m.tlx(0) : 0;

                f.$wrapFront.css(_tfBegin);


                // Slot position start & Image Slot position
                for (var i = 0; i < f.slot; i++) {
                    f.$wrapFront
                        .find('img')
                        .css('left', -(i * f.wFront) - f.pFView + f.pImgFront );

                    f.$fxFront.clone()
                        .css({'left' : i*f.wFront, 'top' : 0 })
                        .data({'speed': speed[o.idCur], 'delay': 0, 'tfEnd': _tfEnd})
                        .appendTo(f.$fxInner);
                }


                // Wrap Back : transform end
                var _tfEndBack = {};
                _tfEndBack[cssTf] = is.ts ? m.tlx(-f.d.mark*f.wFront) : -f.d.mark*f.wFront;

                if( is.ts) {
                    // Easing: set
                    f.easeIn = 'easeOutCubic';
                    f.easeOut = 'easeInCubic';
                    var _es = f.d.is ? m.easeName(f.easeIn) : m.easeName(f.easeOut);

                    var _ts = {}; _ts = m.ts(cssTf, speed[o.idCur], _es);
                    f.$wrapBack.css(_ts);
                    setTimeout(function() { f.$wrapBack.css(_tfEndBack) }, 1);
                }
                else {
                    f.$wrapBack.animate(_tfEndBack, speed[o.idCur]);
                }

                fxFunc.transformEnd(f, 'wrap');
            },

            move : function(f) { fxFunc.rectMove(f, 1) },





            /* Structure
            -------------------------------------------

                Direct leftRight:
                    $slot: startPos = -(p.slotView + wSlot)
                    $slot: endPos = i * wSlot
                    $imgSlot: x = -(i * wSlot) - p.imgView + p.imgSlot
                    $imgBack: x = - p.imgView + p.imgBack

            ------------------------------------------- */
            rectRun : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(3,6)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, false, true);


                // Timer setup
                var t = {};
                t.speed    = speed[o.idCur] / 4;
                t.delayAll = speed[o.idCur] - t.speed;
                t.delay    = t.delayAll / f.slot;


                // FxSlot clone & Image Slot position
                var _tfBegin, _tfEnd, _delay;
                for (var i = 0; i < f.slot; i++) {
                    f.$wrapFront
                        .find('img')
                        .css({'left': -(i*f.wFront) - f.pFView + f.pImgFront});


                    // Timer
                    var _delay = t.delayAll - (i*t.delay);


                    // FxSlot: transform begin
                    var _xBegin = f.d.is ? -(f.wFront + f.pSlideView) : i*f.wFront
                      , _xEnd   = f.d.is ? m.r(i*f.wFront) : f.wLarge + f.pSlideView;

                    _tfBegin = {}; _tfBegin[cssTf] = is.ts ? m.tlx(_xBegin) : _xBegin;
                    f.$fxFront.css(_tfBegin);


                    // FxSlot: transform end
                    _tfEnd = {}; _tfEnd[cssTf] = is.ts ? m.tlx(_xEnd) : _xEnd;
                    
                    f.$fxFront.clone()
                        .data({'speed': t.speed, 'delay' : _delay, 'tfEnd': _tfEnd})
                        .appendTo(f.$fxInner);
                }

                fxFunc.transformEnd(f, 'this');
            },






            rectSlice : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(4,10)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, false, true);


                // Timer setup
                var t = {};
                t.speed    = speed[o.idCur] / 4;
                t.delayAll = speed[o.idCur] - t.speed;
                t.delay    = t.delayAll / f.slot;


                // FxSlot clone & Image Slot position
                var _tfBegin, _tfEnd, _delay;
                for (var i = 0; i < f.slot; i++) {
                    f.$wrapFront
                        .find('img')
                        .css({'left': -(i*f.wFront) - f.pFView + f.pImgFront});


                    // Timer
                    _delay = f.d.is ? i*t.delay : t.delayAll - (i*t.delay);


                    // FxSlot: transform begin
                    var _y      = (m.r(i/2) > i/2) ? 100 : -100
                      , _yBegin = f.d.is ? _y : 0
                      , _yEnd   = f.d.is ? 0 : _y;

                    _tfBegin = {};
                    if( is.ts ) _tfBegin[cssTf] = m.tly(_yBegin, '%');
                    else       _tfBegin['top'] = _yBegin + '%';

                    f.$fxFront.css({'left': i * f.wFront}).css(_tfBegin);


                    // FxSlot: transform end
                    _tfEnd = {};
                    if( is.ts ) _tfEnd[cssTf] = m.tly(_yEnd, '%');
                    else       _tfEnd['top'] = _yEnd + '%';

                    f.$fxFront.clone()
                        .data({'speed': t.speed , 'delay' : _delay, 'tfEnd': _tfEnd})
                        .appendTo(f.$fxInner);
                }

                fxFunc.transformEnd(f, 'this');
            },





            /* Structure
            -------------------------------------------

                $wrapBack = $tar.clone() -> p.imgBack  = !isW ? 0 : _a;
                $wrapBack = $cur.clone() _> p.imgBack  = isW ? 0 : _a;

            ------------------------------------------- */
            rubyFade : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(2, 4)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, true, false);


                // FxSlot: set Opacity
                f.$fxFront.css('opacity', f.d.reFade);


                // FxSlot & Image Slot: Position | Timer setup
                var t = {}, _tfEnd;
                for (var i = 0; i < f.slot; i++) {
                    for (var j = 0; j < f.slotHor; j++) {

                        f.$wrapFront
                            .find('img')
                            .css({'left': -(j*f.wFront) - f.pFView + f.pImgFront, 'top': -(i*f.hSlot) + f.top});


                        t.speed = m.r( m.rm(100, speed[o.idCur]) );
                        t.delay = speed[o.idCur] - t.speed;

                        // t.speed = 200;
                        // t.delay = m.ra()*([speed[o.idCur] - t.speed]);
                        // t.delay = m.ra()*speed[o.idCur];


                        // Transform end
                        _tfEnd = {}; _tfEnd['opacity'] = f.d.fade;

                        f.$fxFront.clone()
                            .css({'left' : j*f.wFront, 'top' : i*f.hSlot})
                            .data({'speed' : t.speed, 'delay' : t.delay, 'tfEnd' : _tfEnd})
                            .appendTo(f.$fxInner);
                    }
                }

                f.easeOut = 'easeOutCubic';
                fxFunc.transformEnd(f, 'this');
            },





            rubyMove : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(2, 4)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, true, false);


                // Position random
                function _pos(v) {
                    var x, y, a = {};
                    switch (v) {
                        case 0: a.x = 0; a.y = -100; break;
                        case 1: a.x = 100; a.y = 0; break;
                        case 2: a.x = 0; a.y = 100; break;
                        case 3: a.x = -100; a.y = 0; break;
                    }
                    return a;
                }



                // FxSlot & Image Slot: Position | Timer setup
                var t = {}, xy, tfBegin, tfEnd;
                for (var i = 0; i < f.slot; i++) {
                    for (var j = 0; j < f.slotHor; j++) {

                        f.$wrapFront
                            .find('img')
                            .css({'left': -(j*f.wFront) - f.pFView + f.pImgFront, 'top': -(i*f.hSlot) + f.top});


                        xy = _pos(m.r(m.ra()*3));
                        if( is.ts ) { 
                            tfBegin = {}; tfBegin[cssTf] = m.tl(xy.x, xy.y, '%');
                            tfEnd   = {}; tfEnd[cssTf] = m.tl(0, 0, '%'); 
                        }
                        else {
                            tfBegin = {}; tfBegin['left'] = xy.x; tfBegin['top'] = xy.y;
                            tfEnd   = {}; tfEnd['left'] = 0; tfEnd['top'] = 0;
                        }
                        
                        if( f.d.is ) f.$wrapFront.css(tfBegin);
                        else         f.$wrapFront.css(tfEnd);



                        // t.speed = m.r( m.ra()*(speed[o.idCur]-100) + 100);
                        // t.delay = speed[o.idCur] - t.speed;

                        t.speed = m.rm(100, 300);
                        t.delay = m.ra()*(speed[o.idCur] - t.speed);
                        // t.delay = m.ra()*speed[o.idCur];


                        f.$fxFront.clone()
                            .css({'left' : j*f.wFront, 'top' : i*f.hSlot})
                            .data({'speed' : t.speed, 'delay' : t.delay, 'tfEnd' : f.d.is ? tfEnd : tfBegin})
                            .appendTo(f.$fxInner);

                    }
                }
                fxFunc.transformEnd(f, 'wrap');
            },





            rubyRun : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(2,4)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, true, false);


                // FxSlot & Image Slot: Position | Timer setup
                var t = {}, xy = {}, tfBegin, tfEnd;
                for (var i = 0; i < f.slot; i++) {
                    for (var j = 0; j < f.slotHor; j++) {

                        f.$wrapFront
                            .find('img')
                            .css({'left': -(j*f.wFront) - f.pFView + f.pImgFront, 'top': -(i*f.hSlot) + f.top});


                        switch (m.r(m.ra()*3)) {
                            case 0: xy.x = j*f.wFront; xy.y = -f.hSlot; break;
                            case 1: xy.x = f.wLarge + f.pSlideView; xy.y = i*f.hSlot; break;
                            case 2: xy.x = j*f.wFront; xy.y = f.hTar; break;
                            case 3: xy.x = -f.wFront - f.pSlideView; xy.y = i*f.hSlot; break;
                        }

                        if( is.ts ) {
                            tfBegin = {}; tfBegin[cssTf] = m.tl(xy.x, xy.y);
                            tfEnd   = {}; tfEnd[cssTf] = m.tl(j*f.wFront, i*f.hSlot);
                        }
                        else {
                            tfBegin = {}; tfBegin['left'] = xy.x; tfBegin['top'] = xy.y;
                            tfEnd   = {}; tfEnd['left'] = j*f.wFront; tfEnd['top'] = i*f.hSlot;
                        }
                        
                        if( f.d.is ) f.$fxFront.css(tfBegin);
                        else         f.$fxFront.css(tfEnd);


                        // Timer
                        t.speed = m.rm(100, 300);
                        t.delay = m.ra()*(speed[o.idCur] - t.speed);


                        // FxSlot: appedn
                        f.$fxFront.clone()
                            .data({'speed' : t.speed, 'delay' : t.delay, 'tfEnd' : f.d.is ? tfEnd : tfBegin})
                            .appendTo(f.$fxInner);
                    }
                }
                fxFunc.transformEnd(f, 'this');
            },





            rubyScale : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(2,4)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, true, false);


                // wrapSlot: scale begin
                var _scaleBegin = f.d.is ? 0 : 1
                  , _scaleEnd   = f.d.is ? 1 : 0;

                if( is.ts ) {
                    tf = {}; tf[cssTf] = 'scale(' + _scaleBegin + ')';
                    f.$wrapFront.css({'width': '100%', 'height' : '100%'}).css(tf);

                    tf = {}; tf[cssTf] = 'scale(' + _scaleEnd + ')';
                    _scaleEnd = tf;
                }
                else {
                    f.$wrapFront.css({
                        'width' : _scaleBegin*100 +'%',
                        'height': _scaleBegin*100 +'%',
                        'left'  : _scaleEnd*50 +'%',
                        'top'   : _scaleEnd*50 +'%'
                    });

                    tf = {};
                    tf['width']  = _scaleEnd*100 +'%';
                    tf['height'] = _scaleEnd*100 +'%';
                    tf['left']   = _scaleBegin*50 +'%';
                    tf['top']    = _scaleBegin*50 +'%';
                    _scaleEnd = tf;
                }



                // FxSlot & Image Slot: Position | Timer setup
                var t = {}, xy = {}, tfBegin, tfEnd;
                for (var i = 0; i < f.slot; i++) {
                    for (var j = 0; j < f.slotHor; j++) {

                        // Image Wrap
                        f.$wrapFront
                            .find('img')
                            .css({'left': -(j*f.wFront) - f.pFView + f.pImgFront, 'top': -(i*f.hSlot) + f.top});

                        // Timer
                        t.speed = m.rm(100, 300);
                        t.delay = m.ra()*(speed[o.idCur] - t.speed);

                        // Append
                        f.$fxFront.css({'left': j*f.wFront, 'top': i*f.hSlot});
                        f.$fxFront.clone()
                            .data({'speed' : t.speed, 'delay' : t.delay, 'tfEnd': _scaleEnd})
                            .appendTo(f.$fxInner);
                    }
                }
                fxFunc.transformEnd(f, 'wrap');
            },





            /* Structure
            -------------------------------------------
            Delay: > 1500ms
                
            ID: set

                dk: var _j = m - j
                      , _i = ((m.r(_j/2)) > (_j/2)) ? i : n-i-1;

                id: _i + (n * (m -j -1))

            ------------------------------------------- */

            zigzagRun : function(f) {

                // Fx slot: get
                var _sCur = va.slot[o.idCur];   // Shortcut slotCurrent
                f.slot = (_sCur == 'auto') ? m.r(m.rm(2,5)) : parseInt(_sCur);

                // Fx setup
                fxFunc.setup(f, false, true, false);


                // Timer setup
                var t = {};
                t.speed = m.r(speed[o.idCur] / (f.slot * f.slotHor) - 0.5);
                t.delay = t.speed;



                // FxSlot & Image Slot: Position | Timer setup
                var _n          = f.slot
                  , _m          = f.slotHor
                  , _id         = 0
                  , _delay
                  , _i, _j
                  , _tfBegin, _tfEnd, _xBegin, _xEnd;

                for (var i = 0; i < f.slot; i++) {
                    for (var j = 0; j < f.slotHor; j++) {

                        f.$wrapFront
                            .find('img')
                            .css({'left': -(j*f.wFront) - f.pFView + f.pImgFront, 'top': -(i*f.hSlot) + f.top});


                        // ID: get
                        _j  = _m - j;
                        _i  =  (m.r(_j/2) > _j/2) ? i : _n-i-1;
                        _id = _i + (_n * (_m-j-1));


                        // FxSlot: position left begin
                        _xBegin = f.d.is ? -(f.pSlideView + f.wFront) : j*f.wFront;

                        _tfBegin = {}; _tfBegin[cssTf] = is.ts ? m.tlx(_xBegin) : _xBegin;
                        f.$fxFront.css(_tfBegin);



                        // FxSlot: position left end & delay
                        _xEnd  = f.d.is ? j*f.wFront : (f.pSlideView + f.wLarge);

                        _tfEnd = {}; _tfEnd[cssTf] = is.ts ? m.tlx(_xEnd) : _xEnd;
                        _delay = t.delay*_id;

                        f.$fxFront.clone()
                            .css({'top': i*f.hSlot})
                            .data({'speed' : t.speed, 'delay' : _delay, 'tfEnd' : _tfEnd })
                            .appendTo(f.$fxInner);
                    }
                }
                fxFunc.transformEnd(f, 'this');
            }
        },





        /* Layer
        ================================================== */
        layer = {

            init : function($slide) {

                var $layer = $slide.find('[data-' + o.dataLayer +']');
                var _dataSL = { is : 0 };

                if( $layer.length ) {

                    // Slide: shortcut data 'layer' in slide
                    _dataSL = $.extend(_dataSL, { num : 0, maxspeed : 0, isLayerRunComplete: 0});
                    var _select = $('');

                    // Each layer
                    $layer.each(function() {

                        var $el = $(this)
                          , str = $el.data(o.dataLayer);


                        // Layer: setup value
                        if( str != '' ) {
                            _select = _select.add($el);
                            _dataSL.num++;

                            str = str.replace(/\s+/g, ' ').replace(/^\s*|\s*$/g, '');   // Remove whitespace
                            var l = {
                                data     : str,
                                xyValue  : null,
                                xyOut    : [],
                                update   : { rValue : [] },
                                is       : {},
                                idSlide  : $slide.data('id'),
                                tagName  : $el[0].tagName.toLowerCase(),
                                animSet  : {
                                    count    : m.valueName(str, 'count', 1),
                                    direction: m.valueName(str, 'direction', 'normal'),
                                    delay    : m.valueName(str, 'delay', 0)
                                }
                            };


                            // Random update check
                            var _isRaUp = m.valueName(str, 'isRaUp');
                            l.is['raUp'] = (_isRaUp === false) ? o.isLayerRaUp : _isRaUp;


                            // Layer: add style
                            l.css = {
                                fontsize    : parseInt( $el.css('font-size') ),
                                lineheight  : parseInt( $el.css('line-height') ),
                                width       : m.valueName(str, 'width'),    // Width
                                height      : m.valueName(str, 'height')    // Height
                            };

                            var _name   = ['left', 'right', 'top', 'bottom']
                              , _style  = ['border', 'margin', 'padding']
                              , _suffix = ['-width', '', '']
                              , _prop   = {}
                              , _s, _n;

                            for (var i = 0; i < 3; i++) {
                                _prop = {}; _s = _style[i]; l.css['is' + _s] = 0;

                                for(var j = 0; j < 4; j++) {
                                    _n = _name[j];

                                    // Shortcut of: _prop.left = parseInt( $el.css('border-left-width'))
                                    _prop[_n] = parseInt( $el.css(_s + '-' + _name[j] + _suffix[i]));
                                    l.css['is' + _s] += Math.abs(_prop[_n]);
                                }
                                l.css[_s] = _prop;
                            }


                            // Layer: add properties
                            // if( is.res && tagName != 'img' && va.rate < 1 )
                            is.res && layer.style($el, l);


                            // Layer: get transfrom, transition
                            layer.animRaw(l);
                            layer.animPre(l);
                            layer.tfSetup(l);
                            layer.tfPre(l);
                            layer.tfOut($el, l);
                            layer.tsOut(l);
                            // console.log(l);


                            // Layer: position init
                            $el.css(l.tfOut[0]);


                            // Layer: set & remove data attribute
                            $el .data(o.dataLayer, l)
                                .removeAttr('data-'+ o.dataLayer, '');
                        }
                    });


                    // Slide: data layer setting
                    _dataSL.is     = (_dataSL.num > 0) ? 1 : 0;
                    _dataSL.select = _select;
                }

                // Slide: store data
                $slide.data('layer', _dataSL);
            },




            /* Layer: style
               Style support:

                    font-size
                    line-height
                    border
                    margin
                    padding
            ---------------------------------------------- */
            style : function($el, l) {

                var r    = va.rate
                  , name = ['left', 'right', 'top', 'bottom']
                  , _c   = l.css        // Shortcut l.css
                  , _s   = {};


                // Font size
                if( l.tagName != 'img' ) {

                    _s['font-size'] = (r != 1) ? m.r(_c.fontsize * r) + 'px' : '';
                    _s['line-height'] = (r != 1) ? m.r(_c.lineheight * r) + 'px' : '';
                }


                // Style: width-height
                if( _c['width'] )  _s['width']  = m.r(_c['width'] * r) + 'px';
                if( _c['height'] )  _s['height'] = m.r(_c['height'] * r) + 'px';


                if ( _c.isborder )
                    for (var i = 0; i < 4; i++) {
                        var bo, _b = 'border-' + name[i] + '-width';

                        if( _c.border[name[i]] != 0 ) {
                            bo = m.r(_c.border[name[i]] * r);
                            _s[_b] = (bo > 1) ? bo + 'px' : '1px';
                        }
                    }

                if ( _c.ismargin )
                    for (var i = 0; i < 4; i++) {
                        if( _c.margin[name[i]] != 0 )
                            _s['margin-' + name[i]] = m.r(_c.margin[name[i]] * r) + 'px';
                    }

                if ( _c.ispadding )
                    for (var i = 0; i < 4; i++) {
                        if( _c.padding[name[i]] != 0 )
                            _s['padding-' + name[i]] = m.r(_c.padding[name[i]] * r) + 'px';
                    }

                $el.css(_s);
            },




            /* Animation Raw & Pre
            -------------------------------------------- */
            animRaw : function(l) {

                var _str = l.data
                  , _va  = _str.split(';');

                var _num = 0, _opts = [], _length = _va.length;
                for (var i = 0; i < _length; i++) {

                    var _o = {};
                    if( !(/^\s*$/g).test(_va[i]) || i == 0 ) {

                        prop.split(_o, [_va[i], ''], {}, 1);
                        _opts[_num] = _o;
                        _num++;
                    }
                }

                // Fixed: for 1 Animation & without ';'
                if( _num == 1 ) { _opts = [{}, _opts[0]]; _num = 2; };

                // Data: get value
                l.animRaw = _opts;
                l.animNum = _num-1;
            },


            animPre : function(l) {
                var _r  = l.animRaw             // Shortcut animRaw of data layer
                   ,_lr = _r.length;            // Shortcut length animRaw

                var _n  = ['x','y','rotate','scale','skew','opacity','start','speed','es']  // Shortcut name of animation
                  , _p0 = [0, 0, 0, [1,1], [0,0], 1, o.layerStart, o.layerSpeed, 'ease']    // Value default of animation
                  , _ln = _n.length;                                                        // Shortcut length of animPre

                var _p = [], _pCur, _pLast;     // Shortcut animPre, preCurrent, preLast
                for (var i = 0; i < _lr; i++) { _p[i] = {} }


                // Loop i for name, loop j for number animation
                for (var i = 0; i < _ln; i++) {
                    _pCur = _p0[i];
                    for (var j = 0; j < _lr; j++) {

                        _pLast = _pCur;
                        _pCur = _r[j][_n[i]];

                        if( _pCur == undefined ) _pCur = _pLast;
                        _p[j][_n[i]] = _pCur;
                    }
                }


                // Opacity: check begin & last
                if( _r[0]['opacity']     == undefined ) _p[0]['opacity'] = 0;
                if( _r[_lr-1]['opacity'] == undefined && l.animNum > 1 ) _p[_lr-1]['opacity'] = 0;


                // Easing: convert
                if( is.ts ) {
                    for (var i = 0; i < _lr; i++) { _p[i]['es'] = m.easeName(_p[i]['es']); }
                }
                else {
                    for (var i = 0; i < _lr; i++) { if( _p[i]['es'] == 'ease' ) _p[i]['es'] = 'swing'; }
                }


                // xy anim[0]: if none, copy value at anim[1]
                if( _r[0]['x'] == undefined ) _p[0]['x'] = _p[1]['x'];
                if( _r[0]['y'] == undefined ) _p[0]['y'] = _p[1]['y'];


                // Animate pre: get value
                l.animPre = _p;
            },





            /* Transform element
            -------------------------------------------- */
            xy : function( _x, _y) {
                var _xy = [1,0,0,1,0,0];

                _xy[4] = _x; _xy[5] = _y;
                return _xy;
            },

            rotate : function(_deg) {
                var _r = [1,0,0,1,0,0]
                  , _rad = parseInt(_deg)*Math.PI/180;

                var _cos = Math.cos(_rad)
                  , _sin = Math.sin(_rad);
                _r[0] = _cos;  _r[1] = _sin;
                _r[2] = -_sin; _r[3] = _cos;

                return _r;
            },

            scale : function(_x, _y) {
                var _s = [1,0,0,1,0,0];

                if( _y == undefined ) _y = _x;
                _s[0] = _x; _s[3] = _y;

                return _s;
            },


            skew : function(_xdeg, _ydeg) {
                var _s = [1,0,0,1,0,0];

                var _xrad = parseInt(_xdeg)*Math.PI/180
                  , _yrad = parseInt(_ydeg)*Math.PI/180;
                _xrad = Math.tan(_xrad);
                _yrad = Math.tan(_yrad);

                _s[2] = _xrad;
                _s[1] = _yrad;

                return _s;
            },





            /* Transform Setup & Pre
            -------------------------------------------- */
            tfSetup : function(l) {

                var _aPre = l.animPre
                  , _tf = [], _ra = []
                  , _rName = 'ra', _isR = 0;

                for (var i = 0; i <= l.animNum; i++) {

                    // Random: init
                    _ra[i] = [];


                    // XY
                    var _x = _aPre[i]['x']
                      , _y = _aPre[i]['y']
                      , _xy;

                    if( typeof _x == 'string' && _x == _rName ) { _isR = 1; _ra[i].push('x'); }
                    if( typeof _y == 'string' && _y == _rName ) { _isR = 1; _ra[i].push('y'); }
                    _xy = layer.xy(_x, _y);



                    // Rotation: check value, include random
                    var _deg = _aPre[i]['rotate'], _r;
                    if     ( typeof _deg == 'object' && typeof _deg[0] == 'number' ) _deg = _deg[0];
                    else if( typeof _deg == 'string' || typeof _deg[0] == 'string' ) {

                        // Rotation random check
                        if( _deg == _rName || _deg[0] == _rName ) { _isR = 1; _ra[i].push('rotate'); }
                        // Rotation: reset
                        _deg = 0;
                    }
                    else if( typeof _deg == 'boolean' ) _deg = 0;

                    _r = layer.rotate(_deg);



                    // Scale: check value, include random
                    var _as = _aPre[i]['scale'], _s, _sx, _sy;
                    if( typeof _as == 'object') {
                        if( typeof _as[0] == 'number' ) _sx = _as[0];
                        else {
                            if( _as[0] == _rName ) { _isR = 1; _ra[i].push('scaleX'); }
                            _sx = 1;
                        }

                        if( typeof _as[1] == 'number' ) _sy = _as[1];
                        else {
                            if( _as[1] == _rName ) { _isR = 1; _ra[i].push('scaleY'); }
                            _sy = 1;
                        }
                    }
                    else if( typeof _as == 'string' ) {

                        // Scale random check
                        if( _as == _rName ) { _isR = 1; _ra[i].push('scale'); }
                        // Scale: reset
                        _sx = _sy = 1;
                    }
                    else if( typeof _as == 'boolean') _sx = _sy = 1;
                    else                              _sx = _sy = _as;

                    _s = layer.scale(_sx, _sy);



                    // Skew: check value, include random, same scale
                    var _aw = _aPre[i]['skew'], _xdeg, _ydeg, _w;

                    if( typeof _aw == 'object' ) {

                        if( typeof _aw[0] == 'number' ) _xdeg = _aw[0];
                        else {
                            if( _aw[0] == _rName ) { _isR = 1; _ra[i].push('skewX') }
                            _xdeg = 0;
                        }

                        if( typeof _aw[1] == 'number') _ydeg = _aw[1];
                        else {
                            if( _aw[1] == _rName ) { _isR = 1; _ra[i].push('skewY') }
                            _ydeg = 0;
                        }
                    }
                    else if( typeof _aw == 'string' ) {
                        if( _aw == _rName ) { _isR = 1; _ra[i].push('skew') }
                        _xdeg = _ydeg = 0;
                    }
                    else if( typeof _aw == 'boolean') { _xdeg = _ydeg = 0; }
                    else                              { _xdeg = _aw; _ydeg = 0; }

                    _w = layer.skew(_xdeg, _ydeg);



                    // Transform: get value
                    _tf[i] = [_xy, _r, _s, _w];


                    // Random array: reset
                    _ra[i] = !!_ra[i].length ? _ra[i] : 0;
                }

                l.tfSetup = _tf;
                l.update['random'] = _ra;
                l.is['random'] = _isR;
            },


            // Transform Pre: combine all attribute matrix to on matrix
            tfPre : function(l) {
                var _tf = l.tfSetup     // Shortcut transform setup
                  , _a  = [];           // Shortcut animation value

                for (var i = 0; i <= l.animNum; i++) {

                    var _m0 = m.mConvert( _tf[i][1] );
                    for (var j = 2; j < _tf[i].length; j++) {

                        var _m1 = m.mConvert( _tf[i][j] );
                        _m0 = m.mCombine(_m0, _m1);
                    }
                    _a[i] = m.mReturn(_m0);

                    // Matrix: add xy in end -> keep xy align
                    _a[i][4] = _tf[i][0][4];
                    _a[i][5] = _tf[i][0][5];
                }

                // Transform: get value
                l.tfPre = _a;
            },




            /* Random
            -------------------------------------------- */
            randomUpdate : function(l) {

                var _rName = l.update['random']
                  , _p     = l.tfPre
                  , _t     = []
                  , _ra    = [];

                for (var i = 0; i <= l.animNum; i++) {

                    // Random each property
                    if( typeof _rName[i] == 'object' ) {

                        // Transform each animation -> convert to matrix9
                        var _tf = [ [_p[i][0],_p[i][2],0], [_p[i][1],_p[i][3], 0], [0,0,1] ]
                          , _rValue;

                        for( var j = _rName[i].length-1; j >= 0; j-- ) {
                            _rValue = layer.randomValue(_rName[i][j]);

                            // xy case -> only paste value
                            if     ( _rName[i][j] == 'x' ) _tf[0][2] = _rValue[0][2];
                            else if( _rName[i][j] == 'y' ) _tf[1][2] = _rValue[1][2];

                            // Other transform
                            else _tf = m.mCombine(_tf, _rValue);
                        }
                        _ra[i] = m.mReturn(_tf);
                    }
                    else _ra[i] = 0;
                }

                // Random: store value
                l.update['rValue'] = _ra;
            },


            randomValue : function(_name) {
                var _vx, _vy, _m;

                switch( _name ) {

                    case 'x' :
                        _vx = m.r( m.rm(0, wViewport) );
                        _m = layer.xy(_vx, 0);
                        break;

                    case 'y' :
                        _vy = m.r( m.rm(0, hCanvas) );
                        _m = layer.xy(0, _vy);
                        break;


                    case 'rotate' :
                        _vx = m.rm(-360, 360);
                        _m = layer.rotate(_vx);
                        break;


                    case 'scale' :
                        _vx = (m.ra() > 0.5) ? m.rm(1, 5) : m.rm(0.2, 1);
                        _m = layer.scale(_vx);
                        break;

                    case 'scaleX' :
                        _vx = (m.ra() > 0.5) ? m.rm(1, 5) : m.rm(0.2, 1);
                        _m = layer.scale(_vx, 1);
                        break;

                    case 'scaleY' :
                        _vy = (m.ra() > 0.5) ? m.rm(1, 5) : m.rm(0.2, 1);
                        _m = layer.scale(1, _vy);
                        break;


                    case 'skew'  :
                    case 'skewX' :
                        _vx = m.rm(-60, 60);
                        _m = layer.skew(_vx, 0);
                        break;

                    case 'skewY' :
                        _vy = m.rm(-60, 60);
                        _m = layer.skew(0, _vy);
                        break;
                }

                return m.mConvert(_m);
            },






            /* XY value
            -------------------------------------------- */
            xyValue : function($layer, l) {

                if( l.xyValue == null ) l.xyValue = {};
                var _a = l.xyValue, _mc = va.mCanvas;

                // Shortcut: widthSlide, heightSlide, widthLayer, heightLayer
                // Xem lai a.hs khi o.height = 'auto', 'fixed', 'min', 'max'
                // if( _a['ws'] == undefined ) _a['ws'] = wViewport - (_mc*2);  // khong can thiet
                if( _a['hs'] == undefined ) _a['hs'] = $s.eq(l.idSlide).data('height');
                if( _a['wl'] == undefined ) _a['wl'] = $layer.outerWidth();
                if( _a['hl'] == undefined ) _a['hl'] = $layer.outerHeight();


                // Shortcut: xLeft, xCenter, xRight, yTop, yCenter, yBottom
                if( _a['xl'] == undefined ) _a['xl'] = _mc;
                if( _a['xc'] == undefined ) _a['xc'] = m.r( (wViewport - _a.wl)/2 );
                if( _a['xr'] == undefined ) _a['xr'] = wViewport - _mc - _a.wl;
                if( _a['yt'] == undefined ) _a['yt'] = 0;
                if( _a['yc'] == undefined ) _a['yc'] = m.r( (_a.hs - _a.hl)/2 );
                if( _a['yb'] == undefined ) _a['yb'] = _a.hs - _a.hl;
            },


            xyGet : function($layer, l, _name, _isXY) {

                if( l.xyValue == null ) layer.xyValue($layer, l);
                var _a = l.xyValue
                  , _n = _name.charAt(0);

                return _a[_isXY + _n];
            },


            xyShort : function($layer, l, _n, _id)  {

                var _xyV = l.xyValue    // Shortcut xyValue
                  , _xyO = l.xyOut      // Shortcut xyOut
                  , _x   = null         // x default
                  , _y   = null         // y default
                  , _d   = 10;          // Shortcut distance

                // Tranform pre: get value include random
                var _r = l.update['rValue'][_id]
                  , _p = !!_r ? _r : l.tfPre[_id];      // Shortcut transform Pre


                // Check transform && is.ts
                var tfCheck = function() {

                    if( is.ts && (_p[0] != 1 || _p[1] != 0 || _p[2] != 0 || _p[3] != 1) ) return 1;
                    else return 0;
                }
                , getBound = function($el) {

                    // layer ghost: select
                    var $lghost;
                    if( l.layerGhost == undefined ) {

                        $lghost = $el.clone().addClass(o.ns+'layerghost').appendTo($s.eq(l.idSlide));
                        l.layerGhost = $lghost;
                    }
                    else $lghost = l.layerGhost;


                    // Layer ghost: get bounding rect
                    var _tf = {}; _tf[cssTf] = 'matrix('+ _p[0] +','+ _p[1] +','+ _p[2] +','+ _p[3] +',0,0)';
                    $lghost.css(cssD0).css(_tf);

                    return $lghost[0].getBoundingClientRect();
                };


                // Function core
                var short = function() {
                    var _isTf = tfCheck();

                    // width, height layer: select
                    var _r = _isTf ? getBound($layer)  : 0
                      , _w = _isTf ? m.r(_r['width'])  : _xyV['wl']
                      , _h = _isTf ? m.r(_r['height']) : _xyV['hl'];


                    // Type short, moveOut include transformed
                    switch( _n ) {
                        case 'leftOut' :
                            _x = - _w + (_w-_xyV['wl'])/2 - _d;
                            _y = _xyO[_id][1];
                            break;

                        case 'rightOut' :
                            _x = wViewport + (_w-_xyV['wl'])/2 + _d;
                            _y = _xyO[_id][1];
                            break;

                        case 'topOut' : 
                            _x = _xyO[_id][0];
                            _y = - _h + (_h-_xyV['hl'])/2 - _d;
                            break;

                        case 'bottomOut' :
                            _x = _xyO[_id][0];
                            _y = _xyV['hs'] + (_h-_xyV['hl'])/2 + _d;
                            break;
                    }
                };

                // Id: select
                if( _id == 0 ) short(_id+1);
                else           short(_id);

                return (_x != null && _y != null) ? [_x, _y] : null;
            },




            /* Transform, transition Output
            -------------------------------------------- */
            tfOut : function($layer, l) {
                var _tf = l.tfPre, xyOut = l.xyOut;

                // Random: update
                layer.randomUpdate(l);


                // xy: Align & Random convert
                for (var i = 0; i <= l.animNum; i++) {
                    var _m = _tf[i];
                    xyOut[i] = [];

                    if( typeof _m[4] == 'string' ) {
                        if( _m[4] == 'ra' ) xyOut[i][0] = l.update.rValue[i][4];
                        else                xyOut[i][0] = layer.xyGet($layer, l, _m[4], 'x');
                    }
                    else { xyOut[i][0] = m.r(_m[4] * va.rate) + va.mCanvas; }

                    if( typeof _m[5] == 'string' ) {
                        if( _m[5] == 'ra' ) xyOut[i][1] = l.update.rValue[i][5];
                        else                xyOut[i][1] = layer.xyGet($layer, l, _m[5], 'y');
                    }
                    else { xyOut[i][1] = m.r(_m[5] * va.rate); }
                }


                // xy short value, after xyValue()
                for (var i = 0; i <= l.animNum; i++) {

                    var xyRaw = l.animRaw[i]['xy'];
                    if( typeof xyRaw == 'string' ) {

                        // xyValue: check
                        if( l.xyValue == null ) layer.xyValue($layer, l);

                        var xy = layer.xyShort($layer, l, xyRaw, i);
                        if( xy != null ) {
                            xyOut[i][0] = xy[0];
                            xyOut[i][1] = xy[1];
                        }
                    }

                    // Layer ghost: remove
                    if( i == l.animNum && l.layerGhost != undefined ) {
                        l.layerGhost.remove();
                        l.layerGhost = undefined;
                    }
                }



                // Matrix convert to string
                var _a = [], _r = l.update['rValue'];
                if( is.ts ) {
                    for (var i = 0; i <= l.animNum; i++) {

                        // Tranform: select with pre & random
                        var _m = !!_r[i] ? _r[i] : _tf[i];

                        _a[i] = {};
                        _a[i][cssTf] = 'matrix('+_m[0]+','+_m[1]+','+_m[2]+','+_m[3]+','+xyOut[i][0]+','+xyOut[i][1]+')';
                        _a[i]['opacity'] = l.animPre[i]['opacity'];
                    }
                }
                else {
                    for (var i = 0; i <= l.animNum; i++) {

                        _a[i] = {};
                        _a[i]['left'] = xyOut[i][0] + 'px';
                        _a[i]['top'] = xyOut[i][1] + 'px';
                        _a[i]['opacity'] = l.animPre[i]['opacity'];
                    }
                }

                // TfOut: store
                l.tfOut = _a;
            },


            tsOut : function(l) {

                var _ts = [];
                for (var i = 0; i <= l.animNum; i++) {

                    _ts[i] = {};
                    _ts[i][cssD] = l.animPre[i]['speed'] +'ms';
                    _ts[i][cssT] = l.animPre[i]['es'];
                }

                // Transition: get value
                l.tsOut = _ts;
            },





            /* Layer run, start & clear
            -------------------------------------------- */
            run : function(_id_layer, opts) {

                // _id_layer: separate
                if( typeof _id_layer == 'number' ) {
                    var _layer= $s.eq(_id_layer).data('layer');

                    if( _layer && _layer.is ) {
                        _layer['select'].each(function(e) { layer.start($(this), opts) });
                    }
                }
                else if( typeof _id_layer == 'object' ) layer.start(_id_layer, opts);
            },



            start : function($el, opts) {

                var l  = $el.data(o.dataLayer)
                  , _set = l.animSet          // Shortcut for animSet {}
                  , _pre = l.animPre;         // Shortcut for animPre {}


                // Start Function
                var _repeat = function(_time) {

                    var _idRepeat = setTimeout(function() {
                        _set.countCur++;

                        // Animation: direction check
                        if( _set.direction == 'normal' ) {
                            if( is.ts ) $el.css(cssD0).css(l.tfOut[0]);
                            else {
                                $el.stop(true);
                                $el.css(l.tfOut[0]);
                            }

                            start0();
                        }
                        else if (_set.direction == 'alternate') {

                            var _is = _set.countCur/2 == m.r(_set.countCur/2);
                            if( _is ) start1();
                            else      start0();
                        }
                    }, _time);

                    // Store id setTimeout
                    id.layer.push(_idRepeat);
                };


                var _chain = function(_i, _time ) { 

                    var _idChain = setTimeout(function() {

                        // Tranform chain: main function
                        if( is.ts ) $el.css(l.tsOut[_i]).css(l.tfOut[_i]);
                        else        $el.animate(l.tfOut[_i], _pre[_i]['speed'], _pre[_i]['es']);


                        // Animation: check repeat
                        var _d = _set.direction, _isCount = (_set.count == 'infinite')||(_set.countCur < _set.count);
                        if(  ( (_d == 'normal' && _i == l.animNum)
                            || (_d == 'alternate' && _set.startDirect == 0 && _i == l.animNum)
                            || (_d == 'alternate' && _set.startDirect == 1 && _i == 0)
                             ) && _isCount ) {

                            // Random: check
                            l.is['raUp'] && l.is['random'] && layer.tfOut($el, l);

                            // Repeat function
                            _repeat(l.animPre[_i]['speed']);
                        }
                    }, _time);

                    // Store id setTimerout
                    id.layer.push(_idChain);
                };

                // Animation direction: 'normal' -> 0, 'alternate' -> 1
                var start0 = function() {

                    _set.startDirect = 0;
                    var _time = _pre[1]['start'];

                    for (var i = 1; i <= l.animNum; i++) {

                        _chain(i, _time);
                        if( i < l.animNum ) _time += _pre[i+1]['start'];
                    }
                };
                var start1 = function() {

                    _set.startDirect = 1;
                    var _n    = l.animNum
                      , _time = _pre[_n-1]['start'];

                    for (var i = _n-1; i >= 0; i--) {

                        _chain(i, _time);
                        if( i >= 1 ) _time += _pre[i-1]['start'];
                    }
                };


                // Choose action
                switch( opts ) {

                    // Layer: goto position
                    case 'start' :

                        var _idStart = setTimeout(function() {
                            _set.countCur = 1;
                            start0();
                        }, l.animSet['delay']);

                        id.layer.push(_idStart);
                        break;


                    // Layer: restore position without transiton
                    case 'initless' :

                        if( is.ts ) {
                            $el.css(cssD0);
                            setTimeout(function() { $el.css(l.tfOut[0]) }, 1);
                        }
                        else {
                            $el.stop(true);
                            $el.css(l.tfOut[0]);
                        }
                        break;
                }
            },



            // slide start, pause: short function
            slidePause : function(_id) {

                layer.clear();
                layer.run(_id, 'initless');
            },

            slideStart : function(_id) {

                layer.clear();
                layer.run(_id, 'initless');
                setTimeout(function() { layer.run(_id, 'start') }, 50);
            },



            // Layer: clear all setTimeout
            clear : function() {

                if( id.layer ) {
                    while( id.layer.length > 0 ) clearTimeout(id.layer.pop());
                }
            },





            /* Layer udpate
            -------------------------------------------- */
            update : function() {

                $s.each(function() {
                    var $slide = $(this)
                      , _dataSL = $slide.data('layer');

                    if( !!_dataSL && _dataSL['is'] ) {
                        _dataSL['select'].each(function() {

                            var $el = $(this)
                              , l = $el.data(o.dataLayer);

                            // Responsive update
                            if( is.res ) {
                                // Layer: update style
                                (va.rateLast != va.rate) && layer.style($el, l);

                                // Layer: is img
                                if( l.tagName == 'img' ) res.updateImgSize($el);

                                // Layer: other img
                                else {

                                    // Layer: update image child size
                                    var $img = $el.find('img');
                                    if( $img.length )
                                        $img.each(function() { res.updateImgSize($(this)) });
                                }
                            }

                            // Layer: reset properties
                            l.xyValue = null;

                            // Layer: update position properties
                            layer.tfOut($el, l);
                        });
                        

                        // Layer: start init
                        var _id = $slide.data('id');
                        if( _id == o.idCur ) layer.slideStart(_id);
                        else                  layer.slidePause(_id);
                    }
                });
            }
        },





        /* Responsive
        ================================================== */
        res = {
            setup : function() {

                res.varible();  // Varibles: get
                res.updateImgWrap();
            },



            // mCanvas & va.rate: control all relative function!
            varible : function() {
                wViewport = $viewport.width();


                // Media && Canvas margin
                if( o.media ) {

                    var _setup = function() {
                        var _m = va.media       // Shortcut va.media
                          , _mc;                // Shortcut margin Canvas

                        for (var i = _m.num-1; i >= 0; i--) {
                            if( _m[i].from <= wViewport && wViewport <= _m[i].to )
                                _mc = (wViewport - _m[i].width) / 2;
                        }
                        va.mCanvas = (_mc != undefined) ? _mc : o.mCanvas;
                    };


                    // Condition
                    var _wMax = va.media.wMax
                      , cond = (_wMax > o.wRes) ? (_wMax >= wViewport) : (o.wRes > wViewport);

                    if( cond ) {
                        var _m = va.media       // Shortcut va.media
                          , _mc;                // Shortcut margin Canvas

                        for (var i = _m.num-1; i >= 0; i--) {
                            if( _m[i].from <= wViewport && wViewport <= _m[i].to )
                                _mc = (wViewport - _m[i].width) / 2;
                        }
                        va.mCanvas = (_mc != undefined) ? _mc : o.mCanvas;
                    }
                    else       va.mCanvas = (wViewport-o.wRes)/2;
                }

                // No media
                else va.mCanvas = (o.wRes > wViewport) ? o.mCanvas : (wViewport-o.wRes)/2;
                va.mCanvas = m.r(va.mCanvas);       // Round number



                /* Rate */
                va.rateLast = va.rate;

                if( o.media && (_wMax > o.wRes) && (_wMax >= wViewport) )
                    va.rate0 = va.rate = (wViewport - (va.mCanvas*2))/o.wRes;
                else {
                    va.rate0 = wViewport/o.wRes;
                    va.rate  = (va.rate0 > 1) ? 1 : va.rate0 - (va.mCanvas*2/o.wRes);
                }
            },





            updateImgWrap : function() {

                // Image: update size
                var $img = $canvas.find('.' + o.ns + o.imgName + '> img');
                if( $img.length ) {
                    $img.each(function() { res.updateImgSize($(this)) });
                }
            },


            updateImgSize : function($el) {

                if( va.rate < 1 ) {
                    $el.css({
                        'width' : m.r( $el.data('width') * va.rate ),
                        'height': m.r( $el.data('height') * va.rate )
                    });
                }
                else $el.css({'width' : '', 'height' : ''});
            }
        },





        /* Slideshow
         * tDelay: control all relative function
        ================================================== */
        slideshow = {

            init : function() {
                is.hoverAction = 0;

                slideshow.focus();
                slideshow.scroll.setup();
                slideshow.hover();
                o.isPlayPause && slideshow.toggle();

                is.stop = 0; // for button stop
                slideshow.go();
            },

            go : function() {
                // console.log(is.stop, is.focus, is.into, is.hover, is.playing, is.fxRun);
                // console.log(is.into, is.fxRun);

                // Choose action
                if( !is.stop ) {
                    if( is.pauseActive ) is.playing && slideshow.pause();
                    else {
                        if( !is.focus || !is.into || is.hover ) { is.playing && slideshow.pause(); }
                        // else if( !is.playing && !is.fxRun ) {
                        else if( !is.fxRun ) {
                            is.hoverAction ? slideshow.reset() : slideshow.play();
                        }
                    }
                }
            },



            /* Slideshow: update properties
            ---------------------------------------------- */
            update : function() {

                // Timer toggle
                if( !!va.timer1 && va.timer1 != o.timer ) {
                    clearInterval(id.timer);
                    render.timer();
                    !!va.tTimer0 && slideshow.pause(); // no check if first auto slideshow.
                    slideshow.play();
                }

                // Slideshow toggle
                // after timer update
                if( is.slideshow1 != undefined && is.slideshow1 != o.isSlideshow ) {

                    if( o.isSlideshow ) slideshow.init();
                    else {
                        slideshow.pause(1);
                        $w.off('focus.cs blur.cs scroll.cs');
                        $cs.off('mouseenter.cs mouseleave.cs');
                    }
                }

                // Hoverstop toggle
                (is.hoverPause1 != o.isHoverPause) && slideshow.hover();
            },





            setup : {
                bar : function() {

                    var _tf = {}; _tf[cssTf] = m.tlx2(-100, '%');
                    if( is.ts ) {
                        var _ts = {}; _ts = m.ts(cssTf, 0, 'linear');
                        $timerItem.css(_ts).css(_tf);
                    }
                    else $timerItem.css(_tf);
                },


                arc : function() {
                    var c = va.tContext;
                },


                number : function() {

                    $timer.text(0);
                },

                none : function() {}
            },




            /* Play - pause
               tDelay: important!
            ---------------------------------------------- */
            play : function() {

                // Next play function:
                var _nextPlay = function() {
                    clearTimeout(id.play);
                    id.play = setTimeout(slideshow.reset, speed[o.idCur] + 10);
                };


                is.playing = 1;
                va.tTimer0 = +new Date();
                is.timer && slideshow.updateTimer[o.timer]();

                clearTimeout(id.play);
                id.play = setTimeout(function() {


                    var _nCur = (o.layout == 'dash') ? ds.nEnd : o.idCur;
                    var _next = (_nCur >= num) ? 0 : _nCur+1
                      , $next = $s.eq(_next);

                    // Play: next slide
                    if( $next.data('img-load') ) {

                        is.fxRun = 1;
                        if( !o.isLoop && _nCur == num ) slideTo.run(0, 1);
                        else                            events.next(1);

                        // Next play
                        _nextPlay();
                    }

                    // Play: loading next slide
                    else {

                        $next.data({'isPlayNext': 1});
                        cs.stop();
                    }
                }, tDelay);
            },

            reset : function() {
                if( tDelay != delay[o.idCur] ) tDelay = delay[o.idCur];

                if( o.timer == 'bar' && xTimer != 100 ) xTimer = 100;
                else if( o.timer == 'arc' ) va.arc.angCur = 0;
                else if( o.timer == 'number' && xTimer != 0 ) xTimer = 0;

                // console.log('reset', tDelay, is.hoverAction);
                slideshow.play();
            },

            pause : function(_isStop) {
                is.playing = 0;
                is.hoverAction = 0;


                if( _isStop ) {
                    tDelay = delay[o.idCur];
                    slideshow.setup[o.timer]();
                }

                // pause: tDelay get
                else {

                    var t0  = tDelay;
                    va.tTimer1 = +new Date();
                    tDelay  = delay[o.idCur] - (va.tTimer1 - va.tTimer0);

                    if( delay[o.idCur] != t0 ) tDelay -= delay[o.idCur] - t0;
                    if( tDelay < 0 )          { tDelay = 0; is.hoverAction = 1; }    // is.hoverAction = 1 -> !important to solve hover slideshow when fxrunning
                }
                
                is.timer && slideshow.stopTimer();  // Timer: stop
                clearTimeout(id.play);              // PlayAuto: clears
            },




            /* Timer
            ---------------------------------------------- */
            updateTimer : {

                bar : function() {
                    var _reTimer = function() {

                        var _tf = {}; _tf[cssTf] = m.tlx2(-xTimer, '%');
                        if( is.ts ) {

                            $timerItem.hide().show();   // Fixed IE: refresh obj
                            $timerItem.css(cssD0).css(_tf);
                        }
                        else $timerItem.css(_tf);
                    }

                    , _beginTimer = function() {

                        var _tf = {}; _tf[cssTf] = m.tlx2(0);
                        if( is.ts ) {

                            var _ts = {}; _ts[cssD] = tDelay + 'ms';

                            $timerItem.hide().show();   // Fixed IE: refresh obj
                            $timerItem.css(_ts).css(_tf);
                        }
                        else $timerItem.animate(_tf, {duration: tDelay, easing: 'linear'});
                    };

                    _reTimer();                    // Timer: remove transition
                    setTimeout(_beginTimer, 20);   // Timer: set transition, need delay > 50
                },


                arc : function() {
                    var arcDraw = function() {

                        // Canvas: clear
                        var c = va.tContext;
                        c.clearRect(-va.arc.width/2, -va.arc.height/2, va.arc.width, va.arc.height);
                        
                        // Out circle
                        c.beginPath();
                        c.arc(0, 0, va.arc.oRadius, 0, va.arc.pi*360, false);
                        c.lineWidth = va.arc.oWeight;
                        c.strokeStyle = va.arc.oStroke;
                        c.fillStyle = va.arc.oFill;
                        
                        c.stroke();
                        c.fill();
                        c.closePath();

                        // In circle
                        c.beginPath();
                        c.arc(0, 0, va.arc.radius, 0, va.arc.pi * va.arc.angCur, false);
                        c.lineWidth = va.arc.weight;
                        c.strokeStyle = va.arc.stroke;
                        c.fillStyle = va.arc.fill;

                        c.stroke();
                        c.fill();
                        c.closePath();

                        reqAnimFrame(arcDraw);
                    };

                    arcDraw();

                    clearInterval(id.timer);
                    id.timer = setInterval(function() {

                        va.arc.angCur += 360/delay[o.idCur]*va.arc.update;
                        if( va.arc.angCur > 360 ) clearInterval(id.timer);

                    }, va.arc.update);
                },



                number : function() {
                    var t0 = tDelay;

                    var _setup = function() {
                        t0 -= 100;

                        xTimer = 100 - (t0 / delay[o.idCur]*100);
                        xTimer = m.r(xTimer);
                        if( xTimer > 100 ) xTimer = 0;

                        $timer.attr('data-num', xTimer).text(xTimer);
                    };

                    clearInterval(id.timer);
                    id.timer = setInterval(_setup, 100);
                }
            },




            stopTimer : function() {

                if( o.timer == 'bar' ) {
                    xTimer = tDelay/delay[o.idCur] * 100;

                    var _tf = {}; _tf[cssTf] = m.tlx(-xTimer, '%');

                    if( is.ts ) $timerItem.css(cssD0).css(_tf);
                    else        $timerItem.stop(true).css(_tf);
                }

                else if( o.timer == 'arc' ) {
                    va.arc.angCur = 360 - (tDelay/delay[o.idCur] * 360);
                    clearInterval(id.timer);
                }

                else if( o.timer == 'number' ) {
                    // xTimer = 100 - (tDelay/delay[o.idCur] * 100);
                    clearInterval(id.timer);
                }
            },




            /* Slideshow events
            ---------------------------------------------- */
            focus : function() {
                is.focus = 1;

                $w.on('focus.cs', function(e) { if( !is.focus ) { is.focus = 1; slideshow.go(); } })
                  .on('blur.cs',  function(e) { if( is.focus )  { is.focus = 0; slideshow.go(); } });
            },

            
            scroll : {

                setup : function() {
                    is.into = 0;
                    slideshow.scroll.check();

                    var t = 200;
                    $w.on('scroll.cs', function() {
                        clearTimeout(id.scroll);
                        id.scroll = setTimeout(function() { !is.pauseActive && slideshow.scroll.check() }, t);
                    });
                },

                check : function(isNoGo) {
                    slideshow.scroll.position();

                    // Code: into window with vary 100px
                    if( (va.topW <= va.topCS + 100) && (va.botW >= va.botCS - 100) ) {
                        if( !is.into ) { is.into = 1; !isNoGo && slideshow.go(); }
                    }
                    else {
                        if( is.into ) { is.into = 0; !isNoGo && slideshow.go(); }
                    }

                    // !isNoGo && slideshow.go();
                },

                position : function() {
                    var d = document;
                    va.topW  = Math.max(d.body.scrollTop, d.documentElement.scrollTop);

                    if( window.innerHeight ) { va.hW = window.innerHeight }
                    else                     { va.hW = d.documentElement.clientHeight }

                    va.botW = va.hW + va.topW;

                    // Slider offset
                    va.topCS = $cs.offset().top;
                    va.botCS = va.topCS + hCanvas;
                }
            },


            hover : function() {
                if( o.isHoverPause ) {
                    is.hover = 0;

                    $cs .off('mouseenter.cs mouseleave.cs')
                        .on('mouseenter.cs', function() { slideshow.hover1() })
                        .on('mouseleave.cs', function() { slideshow.hover0() });
                }
                else $cs.off('mouseenter.cs mouseleave.cs');
            },

            hover0 : function() { is.hover = 0; slideshow.go(); },
            hover1 : function() { is.hover = 1; slideshow.go(); },


            toggle : function() {
                is.pauseActive = 0;

                $playpause.on(va.clickName, function(e) {
                    if( $playpause.hasClass(o.actived) ) {

                        is.pauseActive = 0;
                        $playpause.removeClass(o.actived);

                    } else {

                        is.pauseActive = 1;
                        $playpause.addClass(o.actived);
                    }

                    slideshow.go();
                    return false;
                });
            }
        };






        /* Init
        ================================================== */
        init.check();






        /* Public
        ================================================== */
        cs = {

            /* Public methods
            ============================================== */

            // Method navigation
            prev : function() { events.prev() },
            next : function() { events.next() },
            goTo : function(_id) { if( _id >= 0 && _id <= num ) slideTo.run(_id, 1); },


            // Method slideshow
            play : function() {
                if( o.isSlideshow ) {
                    if( is.stop && !is.playing && !is.fxRun ) { is.stop = 0; slideshow.reset(); }
                    else                                      { slideshow.play() }
                }
                else { o.isSlideshow = 1; slideshow.init(); }
            },

            pause : function() { is.playing && slideshow.pause() },

            // Fix Late - not working correct
            // when translateX call, not working!
            stop : function() {
                if( !is.stop ) { is.stop = 1; slideshow.pause(1); }
                if( o.isSlideshow ) o.isSlideshow = 0;
            },



            // Method update properties
            prop : function(options, isNoRefresh) {
                // Prop store last value
                prop.storeLast();

                // Prop extend
                o = $.extend(o, options);
                !isNoRefresh && cs.refresh();
            },
            refresh : function() {
                update.removeClass();

                prop.slider();
                prop.slide();
                m.toggle();

                update.slide();
                update.resize();

                //Other
                render.refresh();
                events.touch();
                events.drag();
                events.keyboard();
                slideshow.update();
            },



            /* Public properties
            ============================================== */
            width       : function() { return wViewport },
            height      : function() { return hCanvas },
            curId       : function() { return o.idCur },
            slideLength : function() { return num + 1 },
            slideCur    : function() { return $s.eq(o.idCur) },
            opts        : function() { return o },
            varible     : function() { return va },
            browser     : function() { return is.browser },




            /* Events
               list ['start', 'end', 'before', 'after', 'loadAll', 'loadSlide.id', 'resize']
            ============================================== */
            ev : $('<div></div>', {'class': 'cs-event'})

        };
        is.show && $.data(element[0], 'codeslider', cs);
    };



    $.fn.codeslider = function() {
        var args = arguments;       // args[0] : options, args[1]: value

        return $(this).each(function() {
            var self = $(this), cs = self.data('codeslider');

            if( args[0] == undefined ) args[0] = {};
            if( typeof args[0] === 'object' ) {

                if( !cs ) {
                    var opts = $.extend({}, $.fn.codeslider.defaults, args[0]);

                    opts.class0 = self.attr('class');
                    new $.codeslider(self, opts);
                }
                else cs.prop(args[0]);    // Update properties
            }

            else {
                try      { cs[args[0]](args[1]) }
                catch(e) { if( console != undefined ) console.warn('[ codeslider: function not exist! ]'); }
            }
        });
    };


    $.fn.codeslider.defaults = {

        namespace       : 'cs-',
        canvasName      : 'canvas',
        viewportName    : 'viewport',
        slideName       : 'slide',
        navName         : 'nav',
        nextName        : 'next',
        prevName        : 'prev',
        playName        : 'playpause',
        pagName         : 'pag',
        pagText         : '',
        capName         : 'cap',
        thumbName       : 'thumb',
        timerName       : 'timer',
        layerName       : 'layer',
        overlayName     : 'overlay',
        shadowName      : 'shadow',
        imgName         : 'img',
        lazyName        : 'src',

        className       : { 'grab' : ['cursor-grab', 'cursor-grabbing'],
                            'stop' : ['stop-left', 'stop-right'] },

        fxName          : ['carousel', 'random',
                           'fade', 'move',
                           'rectMove', 'rectRun', 'rectSlice',
                           'rubyFade', 'rubyMove', 'rubyRun', 'rubyScale',
                           'zigzagRun'],

        name            : null,
        dataSlider      : 'slider',
        dataSlide       : 'slide',
        dataLayer       : 'layer',
        layout          : 'line',           // line, dot, dash, free
        fx              : 'carousel',       // carousel, fade, move...
        height          : 'auto',           // auto, max, min, fixed
        imgWidth        : 'none',           // none, autofit, largefit, smallfit -> Width type
        imgHeight       : 'none',           // none, autofit, largefit, smallfit -> Height type
        img             : 'none',           // none, autofit, autofill
        thumb           : 'none',           // none, list, bar
        timer           : 'none',           // none, bar, arc, number

        current         : 'sl-cur',
        last            : 'sl-last',
        thumbWrap       : 'thumb',
        fitWidth        : 'fit-width',
        fitHeight       : 'fit-height',
        actived         : 'actived',
        inActived       : 'in-actived',
        easeTouch       : 'easeOutQuint',
        easeMove        : 'easeOutQuad',

        speed           : 400,
        layerSpeed      : 400,
        layerStart      : 400,
        heightSpeed     : 200,
        delay           : 8000,
        slot            : 'auto',           // ['auto', number]
        stepNav         : 'visible',        // ['visible', number 1-n]
        stepPlay        : 1,
        responsive      : null,             // Default responsive-off
        media           : null,             // media-748-768-920 -> media-width-wMin-wMax
        mCanvas         : 0,                // Default: 0
        hCanvas         : null,             // Height value in height-type fixed
        wThumb          : null,             // Width value of thumb
        hThumb          : null,             // Height value of thumb
        idCur           : 0,                // Number current display
        preload         : 1,                // Number slide preload -> show cs; ['all']
        loadAmount      : 2,
        show            : 'all',            // ['all', 'desktop', 'mobile']
        showFrom        : 0,

        isNav           : 1,
        isPag           : 0,
        isPagNum        : 0,
        isPagWrap       : 1,
        isCap           : 0,
        isLayerRaUp     : 1,
        isSlideshow     : 0,
        isPlayPause     : 0,
        isHoverPause    : 0,
        isTouch         : 1,
        isDrag          : 1,
        isLoop          : 1,
        isAnimRebound   : 1,
        isKeyboard      : 0,
        isOverlay       : 0,
        isShadow        : 0,
        isViewGrabStop  : 0,

        arc             : { width   : null,
                            height  : null,
                            update  : 30,
                            rotate  : 0,

                            radius  : 7,
                            weight  : 2,
                            stroke  : '#fff',
                            fill    : 'transparent',

                            oRadius : 6,
                            oWeight : 10,
                            oStroke : 'hsla(0,0%,0%,.2)',
                            oFill   : 'transparent'
                          },

        // Layout free
        layoutFall      : 'line',       // For browser not support css3
        fName           : 'sl',         // Custom namespace on slide
        fLoop           : 1,            // Loop class effect
        isInOutBegin    : 0,            // Add class 'in' 'out' at begin
        isClassRandom   : 0,            // Random class effect
        isSlAsPag       : 0             // Toggle click slide
    };


    /* jQuery Easing */
    $.extend(jQuery.easing, {
        easeOutQuad: function (x, t, b, c, d) {
            return -c *(t/=d)*(t-2) + b;
        },
        easeOutQuint: function (x, t, b, c, d) {
            return c*((t=t/d-1)*t*t*t*t + 1) + b;
        },
        easeInCubic: function (x, t, b, c, d) {
            return c*(t/=d)*t*t + b;
        },
        easeOutCubic: function (x, t, b, c, d) {
            return c*((t=t/d-1)*t*t + 1) + b;
        }
    });

})(jQuery);