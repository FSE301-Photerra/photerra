'use strict';

var app = (function(document, $, Handlebars) {
	var docElem = document.documentElement,
        _state = {
            openWindow: null,
            currMarker: null
        },
		_userAgentInit = function() {
			docElem.setAttribute('data-useragent', navigator.userAgent);
		},
        _initializeMap = function() {
            var nearbyTemplate = Handlebars.compile($('#nearby-template').html()),
                pinTemplate = Handlebars.compile($('#pin-template').html()),
                points = [
                    {
                        name: 'A super cool spot',
                        location: [32.7150,-117.1625],
                        imagePath: 'assets/images/sandiego7.jpg'
                    }
                ],
                nearbyData = {
                    featuredImage: {
                        name: 'Featured Image', path: 'assets/images/sandiego1.jpg'
                    },
                    trendingImages: [
                        {name: 'Trending Image 1', path: 'assets/images/sandiego2.jpg'},
                        {name: 'Trending Image 2', path: 'assets/images/sandiego3.jpg'}
                    ],
                    images: [
                        {name: 'Image 1', path: 'assets/images/sandiego4.jpg'},
                        {name: 'Image 2', path: 'assets/images/sandiego5.jpg'},
                        {name: 'Image 3', path: 'assets/images/sandiego6.jpg'},
                    ]
                };

            //Set map options
            var mapOptions = {
                center: { lat: 30, lng: -90},
                zoom: 4,
                disableDefaultUI: true,
                zoomControl: true,
                zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
                keyboardShortcuts: false,
                minZoom: 3
            };

            // Create map
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            // Set map styles
            var styles = [
                {
                    featureType: "poi",
                    stylers: [
                        { visibility: "off" }
                    ]
                },
                {
                    featureType: "landscape",
                    stylers: [
                        { visibility: "off" }
                    ]
                },
                {
                    featureType: "water",
                    stylers: [
                        { hue: "#10253f" },
                        { "lightness": -80 },
                        { saturation: -50 }
                    ]
                },
                {
                    featureType: "road",
                    stylers: [
                        { hue: "#584528" },
                        { "lightness": -50 }
                    ]
                }
            ];

            // Create a new StyledMapType object, passing it the array of styles,
            // as well as the name to be displayed on the map type control.
            var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

            //Associate the styled map with the MapTypeId and set it to display.
            map.mapTypes.set('map_style', styledMap);
            map.setMapTypeId('map_style');

            google.maps.event.addListener(map, 'click', function(event){
                var contentString = nearbyTemplate(nearbyData);

                // clean up if needed
                if (_state.openWindow) _state.openWindow.close();
                if (_state.currMarker) _state.currMarker.setMap(null);

                // Generate a new point where the user clicked.
                _state.currMarker = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    visible: false
                });

                // Move the marker to the center of the map
                map.panTo(_state.currMarker.getPosition());

                // Create and open a new info window
                _state.openWindow = new google.maps.InfoWindow({
                    content: contentString
                })
                
                _state.openWindow.open(map, _state.currMarker);
            });

            // Add all of the points to the map
            for (var i=0; i<points.length; i++) {
                // Create a new point
                var mark = new google.maps.Marker({
                    icon: '/assets/images/green_dot.png',
                    position: new google.maps.LatLng(points[i].location[0], points[i].location[1]),
                    map: map,
                    title: points[i].name
                });

                if (_state.openWindow) _state.openWindow.close();
                if (_state.currMarker) _state.currMarker.setMap(null);

                google.maps.event.addListener(mark, 'click', function() {

                    // Create and open a new info window to display the points picture
                    _state.openWindow = new google.maps.InfoWindow({
                        content: pinTemplate(points[i])
                    });

                    _state.openWindow.open(map, this);
                });
            }
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
		init: _init,
        state: _state
	};
})(document, jQuery, Handlebars);
(function() {
	app.init();
})();
