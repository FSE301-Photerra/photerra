'use strict';

var app = (function(document, $) {
	var docElem = document.documentElement,
		_userAgentInit = function() {
			docElem.setAttribute('data-useragent', navigator.userAgent);
		},
        _initializeMap = function() {
            // Initialize the google map
            var myLatlng = new google.maps.LatLng(  33.4294,  -111.9431);
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
              center: myLatlng,
              zoom: 8
            });


              var contentString = '<div id="content" class="map-popup"> <div id="siteNotice"> </div> <div id="bodyContent"> <div class="row"> <a href="#" class="th large-12 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/comet-th.jpg"> </a> </div> <div class="row"> <a href="#" class="th large-6 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/comet-th.jpg"> </a> <a href="#" class="th large-6 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/launch-th.jpg"> </a> </div> <div class="row"> <a href="#" class="th large-3 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/comet-th.jpg"> </a> <a href="#" class="th large-3 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/launch-th.jpg"> </a> <a href="#" class="th large-3 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/space-th.jpg"> </a> <a href="#" class="th large-3 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/spacewalk-th.jpg"> </a> </div> <div class="row"> <div class="large-4 large-push-8 columns"> <a href="#" class="add-image"><i class="add-icon"></i> Add Image</a> </div> </div> </div> </div>';

              var infowindow = new google.maps.InfoWindow({
                  content: contentString
              });

              var marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  title: 'Uluru (Ayers Rock)'
              });
              google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
              });
        },
		_init = function() {
			$(document).foundation();
            // needed to use joyride
            // doc: http://foundation.zurb.com/docs/components/joyride.html
            $(document).on('click', '#start-jr', function () {
                $(document).foundation('joyride', 'start');
            });
            $(document).on('click', '#close-form', function () {
                $(document).foundation('reveal', 'close');
            });
			_userAgentInit();
            _initializeMap();
        };
	return {
		init: _init
	};
})(document, jQuery);

(function() {
	app.init();
})();
