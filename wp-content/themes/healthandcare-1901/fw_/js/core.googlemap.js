function healthandcare_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof HEALTHANDCARE_GLOBALS['googlemap_init_obj'] == 'undefined') healthandcare_googlemap_init_styles();
	HEALTHANDCARE_GLOBALS['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: HEALTHANDCARE_GLOBALS['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		healthandcare_googlemap_create(id);

	} catch (e) {
		
		dcl(HEALTHANDCARE_GLOBALS['strings']['googlemap_not_avail']);

	};
}

function healthandcare_googlemap_create(id) {
	"use strict";

	// Create map
	HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map = new google.maps.Map(HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].dom, HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers)
		HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].inited = false;
	healthandcare_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map)
			HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map.setCenter(HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].opt.center);
	});
}

function healthandcare_googlemap_add_markers(id) {
	"use strict";
	for (var i in HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers) {
		
		if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'].geocoder == '') HEALTHANDCARE_GLOBALS['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].geocoder_request = i;
			HEALTHANDCARE_GLOBALS['googlemap_init_obj'].geocoder.geocode({address: HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].geocoder_request = false;
					healthandcare_googlemap_add_markers(id);
				} else
					dcl(HEALTHANDCARE_GLOBALS['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].point) markerInit.icon = HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].point;
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].title) markerInit.title = HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].title;
			HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].opt.center == null) {
				HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].opt.center = markerInit.position;
				HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map.setCenter(HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].opt.center);
			}
			
			// Add description window
			if (HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].description!='') {
				HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers) {
						if (latlng == HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].latlng) {
							HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].infowindow.open(
								HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].map,
								HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			HEALTHANDCARE_GLOBALS['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function healthandcare_googlemap_refresh() {
	"use strict";
	for (id in HEALTHANDCARE_GLOBALS['googlemap_init_obj']) {
		healthandcare_googlemap_create(id);
	}
}

function healthandcare_googlemap_init_styles() {
	// Init Google map
	HEALTHANDCARE_GLOBALS['googlemap_init_obj'] = {};
	HEALTHANDCARE_GLOBALS['googlemap_styles'] = {
		'default': [],
		'invert': [ { "stylers": [ { "invert_lightness": true }, { "visibility": "on" } ] } ],
		'dark': [{"featureType":"landscape","stylers":[{ "invert_lightness": true },{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
		'simple': [
				{
				  stylers: [
					{ hue: "#00ffe6" },
					{ saturation: -20 }
				  ]
				},{
				  featureType: "road",
				  elementType: "geometry",
				  stylers: [
					{ lightness: 100 },
					{ visibility: "simplified" }
				  ]
				},{
				  featureType: "road",
				  elementType: "labels",
				  stylers: [
					{ visibility: "off" }
				  ]
				}
			  ],
	'greyscale': [
					{
						"stylers": [
							{ "saturation": -100 }
						]
					}
				],
	'greyscale2': [
				{
				 "featureType": "landscape",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": 20.4705882352941 },
				  { "gamma": 1 }
				 ]
				},
				{
				 "featureType": "road.highway",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": 25.59999999999998 },
				  { "gamma": 1 }
				 ]
				},
				{
				 "featureType": "road.arterial",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": -22 },
				  { "gamma": 1 }
				 ]
				},
				{
				 "featureType": "road.local",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": 21.411764705882348 },
				  { "gamma": 1 }
				 ]
				},
				{
				 "featureType": "water",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": 21.411764705882348 },
				  { "gamma": 1 }
				 ]
				},
				{
				 "featureType": "poi",
				 "stylers": [
				  { "hue": "#FF0300" },
				  { "saturation": -100 },
				  { "lightness": 4.941176470588232 },
				  { "gamma": 1 }
				 ]
				}
			   ],
	'style1': [{
					"featureType": "landscape",
					"stylers": [
						{ "hue": "#FF0300"	},
						{ "saturation": -100 },
						{ "lightness": 20.4705882352941 },
						{ "gamma": 1 }
					]
				},
				{
					"featureType": "road.highway",
					"stylers": [
						{ "hue": "#FF0300" },
						{ "saturation": -100 },
						{ "lightness": 25.59999999999998 },
						{ "gamma": 1 }
					]
				},
				{
					"featureType": "road.arterial",
					"stylers": [
						{ "hue": "#FF0300" },
						{ "saturation": -100 },
						{ "lightness": -22 },
						{ "gamma": 1 }
					]
				},
				{
					"featureType": "road.local",
					"stylers": [
						{ "hue": "#FF0300" },
						{ "saturation": -100 },
						{ "lightness": 21.411764705882348 },
						{ "gamma": 1 }
					]
				},
				{
					"featureType": "water",
					"stylers": [
						{ "hue": "#FF0300" },
						{ "saturation": -100 },
						{ "lightness": 21.411764705882348 },
						{ "gamma": 1 }
					]
				},
				{
					"featureType": "poi",
					"stylers": [
						{ "hue": "#FF0300" },
						{ "saturation": -100 },
						{ "lightness": 4.941176470588232 },
						{ "gamma": 1 }
					]
				}
			],
	'style2': [
        {
            "featureType": "administrative",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#fcfcfc"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#fcfcfc"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#dddddd"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#dddddd"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#eeeeee"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#dddddd"
                }
            ]
        }
    ],
	'style3':  [
 {
  "featureType": "landscape",
  "stylers": [
   {
    "hue": "#FFA800"
   },
   {
    "saturation": 17.799999999999997
   },
   {
    "lightness": 152.20000000000002
   },
   {
    "gamma": 1
   }
  ]
 },
 {
  "featureType": "road.highway",
  "stylers": [
   {
    "hue": "#007FFF"
   },
   {
    "saturation": -77.41935483870967
   },
   {
    "lightness": 47.19999999999999
   },
   {
    "gamma": 1
   }
  ]
 },
 {
  "featureType": "road.arterial",
  "stylers": [
   {
    "hue": "#FBFF00"
   },
   {
    "saturation": -78
   },
   {
    "lightness": 39.19999999999999
   },
   {
    "gamma": 1
   }
  ]
 },
 {
  "featureType": "road.local",
  "stylers": [
   {
    "hue": "#00FFFD"
   },
   {
    "saturation": 0
   },
   {
    "lightness": 0
   },
   {
    "gamma": 1
   }
  ]
 },
 {
  "featureType": "water",
  "stylers": [
   {
    "hue": "#007FFF"
   },
   {
    "saturation": -77.41935483870967
   },
   {
    "lightness": -14.599999999999994
   },
   {
    "gamma": 1
   }
  ]
 },
 {
  "featureType": "poi",
  "stylers": [
   {
    "hue": "#007FFF"
   },
   {
    "saturation": -77.41935483870967
   },
   {
    "lightness": 42.79999999999998
   },
   {
    "gamma": 1
   }
  ]
 }
]
}
}