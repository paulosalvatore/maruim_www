;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3;
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
				var excluirKeys = [9, 16, 17, 18, 19, 27, 33, 34, 35, 36, 37, 38, 39, 40, 44, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 144, 145];
				var liberarCtrlKeys = [46];
                $el.is(":input") && $el.on("keyup keydown keypress",function(e){
					if(($.inArray(e.keyCode, excluirKeys) != -1))
						return;
					if((e.ctrlKey) && ($.inArray(e.keyCode, liberarCtrlKeys) == -1))
						return;
					if(e.keyCode == 13)
						return doneTyping(el);
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        doneTyping(el);
                    }, timeout);
                }).on("blur",function(){
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);