'use strict';

var app = (function(document, $) {
	var docElem = document.documentElement,
		_userAgentInit = function() {
			docElem.setAttribute('data-useragent', navigator.userAgent);
		},
        _init = function() {
            $(document).foundation();

            $('.photo').change(function() {
                if ($('.photo:checked').length > parseInt($('#limit').val())) {
                    $('[type=submit]').attr('disabled', true);
                    $('.error').show();
                } else {
                    $('[type=submit]').removeAttr('disabled');
                    $('.error').hide();
                }
            });
        };
	return {
		init: _init
	};
})(document, jQuery);
(function() {
	app.init();
})();
