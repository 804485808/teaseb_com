(function($) {
    // IE6 Fix
    var pos, $popup_overlay, ie6;
    ie6 = false;
    if($.browser.msie && parseInt($.browser.version) <= 6 ){
        ie6 = true;
        pos = 'absolute';
        $popup_overlay   = $('<iframe id="popup_overlay" src="javascript:;" frameborder="0" tabindex="-1" style="display:block;" />');
    }else{
        pos = 'fixed';
        $popup_overlay   = $('<div id="popup_overlay" />');
    }

    var $popup_container = $('<table><tr><td id="popup_container">'+
                             '<div id="popup_title"></div>'+
                             '<div id="popup_clear"></div>'+
                             '<div id="popup_message"></div>'+
                             '<div id="popup_clear"></div>'+
                             '<div id="popup_panel"><a id="popup_ok" style="cursor:pointer"> OK </a><a id="popup_cancel"> Cancel </a></div>'+
                           '</td></tr></table>');
    var $popup_title     = $('#popup_title', $popup_container);
    var $popup_close     = $('<a id="popup_close" />');
    var $popup_message   = $('#popup_message', $popup_container);
    var $popup_panel     = $('#popup_panel', $popup_container);
    var $popup_ok        = $('#popup_ok', $popup_container);
    var $popup_cancel    = $('#popup_cancel', $popup_container);
    var $popup_ie6       = $('<div />');

    /**
     * $.popup({..});
     */
    $.popup = function(data, options){
        $._popup._show(data, options);
        return $._popup;
    };

    /**
     * $('#button').popup({..});
     */
    $.fn.popup = function(options){
        $._popup._show(this, options);
        return $._popup;
    };

	$._popup = {
        opt: {
            repositionOnResize: true,
            overlayOpacity: 0.8,
            overlayColor: '#000',
            draggable: true,
            button: {ok:true},
            modal: true,
            title: 'System info',
            onOpened: false,
            onOpen: false,
            onClose: false,
            onClosed: false
        },
        data: null,
        persist: false,
        olddata:null,

		_show: function(data, options) {
            $._popup.opt = $.extend({}, $._popup.opt, options);
            $._popup._clean(false);
            $._popup.persist = false;
            $._popup.olddata = null;

            $popup_overlay.css({
                position: 'absolute',
                zIndex: 99998,
                top: '0px',
                left: '0px',
                width: '100%',
                height: $(document).height(),
                background: $._popup.opt.overlayColor,
                opacity: ie6 ? 0 : $._popup.opt.overlayOpacity
            });

            if(ie6){
                $popup_ie6.css({
                    position: 'absolute',
                    zIndex: 99998,
                    top: '0px',
                    left: '0px',
                    width: '100%',
                    height: $(document).height(),
                    background: $._popup.opt.overlayColor,
                    opacity: $._popup.opt.overlayOpacity
                });
                $("body").append($popup_ie6);
            }

            $("body").append($popup_overlay);

            /**
             * 打开之前
             */
            if($._popup.opt.onOpen){
                $._popup.opt.onOpen();
            }

            var minWidth = $popup_container.outerWidth();

			$popup_container.css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0,
                minWidth: 300,
                maxWidth: $(window).width() - 120
			});
            $popup_title.text($._popup.opt.title);

            $("body").append($popup_container.hide());

            if($._popup.opt.modal){
               $popup_close.remove();
            }else{
                $popup_title.append($popup_close);
            }

            /**
             * 事件绑定
             */
            $popup_close.bind('click', function(){
                $._popup._close();
            });

            $popup_overlay.bind('click', function(){
               if(!$._popup.opt.modal) $._popup._close();
            });

            if($._popup.opt.button.ok) {
                $popup_ok.show();
                $popup_ok.click( function() {
                    if($._popup.opt.ok_callback) {
                        if($._popup.opt.ok_callback($._popup)) {
                            $._popup._close();
                            return true;
                        }
                    }
                    $._popup._close();
                    return true;
                });
            }else{
                $popup_ok.hide().unbind('click');
            }

            if($._popup.opt.button.cancel) {
                $popup_cancel.show();
                $popup_cancel.click( function() {
                    if($._popup.opt.cancel_callback) {
                        if($._popup.opt.cancel_callback($._popup)) {
                            $._popup._close();
                            return true;
                        }
                    }
                    $._popup._close();
                    return false;
                });
            }else{
                $popup_cancel.hide().unbind('click');
            }

            /**
             * 装填数据
             */
            $popup_message.html('');
            if(typeof data == 'string' || typeof data == 'number'){
                $._popup.data = $('<div />').html(data);
                $popup_message.append($._popup.data);
                $._popup._reposition();
            }else if(data instanceof jQuery){
                data.before($('<span></span>')
						.attr('id', 'popup-placeholder')
						.css({display: 'none'}));
                $._popup.data    = data;
                $._popup.olddata = data.clone(true);
                $._popup.persist = true;
                $popup_message.append($._popup.data.show());
                $._popup._reposition();
                data = null;
            }else if(typeof data == 'object'){
                $._popup.data = data;
                if($._popup.data.href){
                    $.ajax({
                        type: $._popup.data.type ? $._popup.data.type : 'POST',
                        url:  $._popup.data.href,
                        dataType: $._popup.data.dataType ? $._popup.data.dataType : 'html',
                        data: $._popup.data.data,
                        success: function(resource){
                            $popup_message.append(resource);
                            if($._popup.opt.callback){
                                $._popup.opt.callback(resource, $._popup.data);
                            }
                            $._popup._reposition();
                        },
                        error: function(e){
                            console.dir(e);
                            alert('error');
                            return false;
                        }
                    });
                }else if($._popup.data.src){
                    var $iframe = $('<iframe id="popup_iframe" scrolling="no" frameborder="0" />');
                    $iframe.attr('src', $._popup.data.src).css({width:$._popup.data.width, height:$._popup.data.height, padding:0, margin:0});
                    $popup_message.append($iframe);
                    $._popup._reposition($._popup.data.width);
                }
            }

			// Make draggable
			if($._popup.opt.draggable) {
				try {
					$popup_container.draggable({handle:$popup_title});
					$popup_title.css({ cursor: 'move' });
				} catch(e) {}
			}

            $popup_container.show();
			$._popup._maintainPosition(true);

            /**
             * after opened
             */
            if($._popup.opt.onOpened){
                $._popup.opt.onOpened();
            }

		},

		_close: function() {
            if($._popup.opt.onClose){
                if($._popup.opt.onClose($popup_message, $._popup)){
                    $._popup._clean(true);
                    return true;
                }
            }else{
                $._popup._clean(true);
                return true;
            }
		},

        _clean: function(persist){
            if($._popup.persist && persist){
                $('#popup-placeholder').replaceWith($._popup.data.hide());
            }
            $popup_container.remove();
            $popup_overlay.remove();
            $popup_ie6.remove();
            $._popup._maintainPosition(false);
        },

		_reposition: function(w) {
            var ww = $(window).width();
            var wh = $(window).height();
            var ow = $popup_container.outerWidth();
            var oh = $popup_container.outerHeight();
            var wt = $(window).scrollTop();

            if(wh < oh){
                // $popup_message.css({'overflowY':'auto', height:wh - 168});
                // $popup_message.width($popup_message.width() + 27);
                // oh = $popup_container.outerHeight();
            }else{
                // $popup_message.css({'overflowY':'auto'});
                // $popup_container.outerHeight(oh);
                // $popup_container.outerWidth(ow);
            }

            if(ow > 700 || w > 700){
                $popup_message.css({'word-wrap':'break-word', 'word-break':'normal', width:700});
                w = $popup_container.outerWidth();
            }

            w = w | $popup_container.outerWidth();
			var top = ((wh / 2) - (oh / 2)) - 0;
			var left = ((ww / 2) - (w / 2)) - 0;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;

			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) {
                top = top + wt;
            }

			$popup_container.animate({
				top: top + 'px',
				left: left + 'px'
			});
		},

		_maintainPosition: function(status) {
			if($._popup.opt.repositionOnResize) {
				switch(status) {
					case true:
						$(window).bind('resize', $._popup._reposition);
					break;
					case false:
						$(window).unbind('resize', $._popup._reposition);
					break;
				}
			}
		}
	};
})(jQuery);