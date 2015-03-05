'use strict';

var app = (function(document, $, Handlebars) {
	var docElem = document.documentElement,
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
                },
                lastOpenWindow = null;

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

            //Create map
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            //Set styles
            var styles = [
                {
                stylers: [
                    //{ visibility: 'simplified' }
                ]
                },{
                    featureType: "poi",
                    stylers: [
                        { visibility: "off" }
                    ]
                    },{
                    featureType: "landscape",
                    stylers: [
                        { visibility: "off" }
                    ]
                    },{
                    featureType: "water",
                    stylers: [
                        { hue: "#10253f" },
                        { "lightness": -80 },
                        { saturation: -50 }
                    ]
                },{
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

            /* For now the upload will be triggered via the link
            google.maps.event.addListener(map, 'rightclick', function(event){
                var marker = new google.maps.Marker({
                    icon: '/assets/images/dot.png',
                    size: new google.maps.Size(20,32),
                    position: event.latLng,
                    map: map,
                    title: 'Hello World'
                });

                newwindow=window.open('uploadpic.html','Upload Picture','toolbar=no, scrollbars=no, \n\
                    resizable=no, top=0, left=0, height=200, width=350,\n\
                    location=no, menubar=no, status=no, titlebar=no');
                if (window.focus) {newwindow.focus();}

                google.maps.event.addListener(marker, 'click', function(event){
                    var out = "This is the photo at location: " + marker.getPosition();
                    var myWindow = window.open("", "Display Images", "width=200, height=100");
                    myWindow.document.write(out);
                });
            });
            */

            google.maps.event.addListener(map, 'click', function(event){
                //computeDistanceBetween()

                var contentString = nearbyTemplate(nearbyData);

                // Generate a new point where the user clicked.
                var m = new google.maps.Marker({
                    icon: '/assets/images/dot.png',
                    position: event.latLng,
                    map: map
                });

                // Move the marker to the center of the map
                map.panTo(m.getPosition());

                // Create and open a new info window
                var iw = new google.maps.InfoWindow({
                    content: contentString
                }).open(map, m);
            });

            // Add all of the points to the map
            for (var i=0; i<points.length; i++) {
                // Create a new point
                var mark = new google.maps.Marker({
                    icon: '/assets/images/dot.png',
                    position: new google.maps.LatLng(points[i].location[0], points[i].location[1]),
                    map: map,
                    title: points[i].name
                });

                google.maps.event.addListener(mark, 'click', function() {
                    // Create and open a new info window to display the points picture
                    new google.maps.InfoWindow({
                        content: pinTemplate(points[0])
                    }).open(map, this);
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
		init: _init
	};
})(document, jQuery, Handlebars);
(function() {
	app.init();
})();
