'use strict';

var app = (function(document, $) {
    var docElem = document.documentElement,
        _userAgentInit = function() {
            docElem.setAttribute('data-useragent', navigator.userAgent);
        },
        _initializeMap = function() {

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

            google.maps.event.addListener(map, 'click', function(event){
                //computeDistanceBetween()

                var numPics = 0;
                var out = "Number of photos to display = " + numPics;

                var myWindow = window.open("", "Display Images", "width=200, height=100");
                myWindow.document.write(out);
            });


            var contentString = '<div id="content" class="map-popup"> <div id="siteNotice"> </div> <div id="bodyContent"> <div class="row"> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/comet-th.jpg"> </a> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/comet-th.jpg"> </a> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/launch-th.jpg"> </a> </div> <div class="row"> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/launch-th.jpg"> </a> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/space-th.jpg"> </a> <a href="#" class="th large-4 columns"> <img src="http://foundation.zurb.com/docs/assets/img/examples/spacewalk-th.jpg"> </a> </div> <div class="row"> <div class="large-4 large-push-8 columns"> <a href="#" class="add-image"> <i class="add-icon"></i> Add Image</a> </div> </div> </div> </div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(30,-90),
                map: map,
                title: 'A super cool spot'
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
