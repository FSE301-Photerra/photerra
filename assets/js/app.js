'use strict';

var app = (function(document, $, Handlebars) {
	var docElem = document.documentElement,
        _map = null,
        _state = {
            openWindow: null,
            currMarker: null,
            points: []
        },
        _getPoints = function() {
            // get the latest points dataset and redraw
            $.getJSON('getPoints.php', function(data) {
                _state.points = data;
                _drawPoints();
            });
        },
        _drawPoints = function() {
            var pinTemplate = Handlebars.compile($('#pin-template').html());

            // Add all of the points to the map
            for (var i=0; i<_state.points.length; i++) {

                // Create a new point
                // Note that I had to hack the object and pass it the path property even though it is not used by
                // google maps. The closure scoping was giving my fits on the callback function for the click event.
                var mark = new google.maps.Marker({
                    icon: '/assets/images/' + ((_state.points[i].currUser) ? 'green' : 'red') + '_dot.png',
                    position: new google.maps.LatLng(_state.points[i].lat, _state.points[i].lng),
                    map: _map,
                    title: _state.points[i].name,
                    path: _state.points[i].path
                });

                // bind the events to the points
                google.maps.event.addListener(mark, 'click', function() {
                    // Clean up the map if needed
                    if (_state.openWindow) _state.openWindow.close();
                    if (_state.currMarker) _state.currMarker.setMap(null);

                    // Create and open a new info window to display the points picture
                    _state.openWindow = new google.maps.InfoWindow({
                        content: pinTemplate({name: this.title, path: this.path})
                    });

                    _state.openWindow.open(_map, this);
                });
            }

        },
        _getNearbyPoints = function(p1) {
            var clickPoint = new google.maps.Data.Point(p1),
                nearbyData = {
                    featuredImage: {},
                    trendingImages: [],
                    images: []
                },
                nearbyPoints = [],
                closestPremium = {},
                rad = function(x) {
                  return x * Math.PI / 180;
                };

            // TODO: optimize this algorithm (closest pair?)

            for (var i = 0; i < _state.points.length; i++) {
              var p2 = _state.points[i];
              var R = 6378137; // Earth’s mean radius in meter
              var dLat = rad(p2.lat - p1.lat());
              var dLong = rad(p2.lng - p1.lng());
              var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat)) *
                Math.sin(dLong / 2) * Math.sin(dLong / 2);
              var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
              var d = R * c;

              if (d < 250000) {
                  nearbyPoints.push({point: p2, distance: d});
              }
            }
            
            // Sort the points
            nearbyPoints.sort(function(a, b) {
                return a.distance - b.distance;
            });

            var imageCount = 0,
                featuredSet = false;
            for (var i = 0; i < nearbyPoints.length; i++) {
                if (!featuredSet && nearbyPoints[i].point.isPremium) {
                    nearbyData.featuredImage = nearbyPoints[i].point;
                    featuredSet = true;
                    imageCount++;
                } else if (imageCount < 2) {
                    nearbyData.trendingImages.push(nearbyPoints[i].point);
                    imageCount++;
                } else {
                    nearbyData.images.push(nearbyPoints[i].point);
                    imageCount++;
                }
            }

            return nearbyData;

        },
		_userAgentInit = function() {
			docElem.setAttribute('data-useragent', navigator.userAgent);
		},
        _initializeMap = function() {
            var nearbyTemplate = Handlebars.compile($('#nearby-template').html());

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

                // Get the nearbyPoints
                var contentString = nearbyTemplate(_getNearbyPoints(_state.currMarker.position));

                // Create and open a new info window
                _state.openWindow = new google.maps.InfoWindow({
                    content: contentString
                })

                // Update the lat lng in the upload form
                $('input[name=lat]').val(_state.currMarker.getPosition().lat());
                $('input[name=lng]').val(_state.currMarker.getPosition().lng());
                
                _state.openWindow.open(map, _state.currMarker);
            });

            return map;
        },
        _init = function() {
            $(document).foundation();

            $(document).on('click', '#close-form', function () {
                $(document).foundation('reveal', 'close');
            });

            _userAgentInit();

            _map = _initializeMap();
            // Initialize the points on page load
            _getPoints();
        };
	return {
		init: _init,
        state: _state
	};
})(document, jQuery, Handlebars);
(function() {
	app.init();
})();
