jQuery(document).ready(function() {
	'use strict';

	var timer = null, ymaps_ready = false;

	if (typeof ymaps !== 'undefined') {
		ymaps.ready(function() {
			ymaps_ready = true;
		});
	}

	// Use object to store all maps separately
	var MapObject = function (map_wrapper) {
		this.map_wrapper = map_wrapper;
		this.map_type = map_wrapper.hasClass('sc_googlemap') ? 'google' : 'yandex';
	};

	MapObject.prototype = {
		// Init all elements
		init: function() {

			if (this.map_type == 'yandex' && !ymaps_ready) {
				var map_object = this;
				if (timer !== null) clearTimeout(timer);
				timer = setTimeout(function() {
					map_object.init();
				}, 100);
				return;
			}

			var coords = (this.map_wrapper.data('coords') || '').split(',');
			this.lat  = coords.length>=1 ? coords[0] : '';
			this.lng  = coords.length>=2 ? coords[1] : '';
			this.zoom = coords.length>=3 ? coords[2] : '';
			if (this.lat && this.lng)
				this.initMapElements();
			else
				this.geoLocation();
		},

		// Init find address
		initMapElements: function() {
			var lat = this.lat || '34.05536166179949',
				lng = this.lng || '-118.24996948242188',
				zoom = this.zoom || 14,
				center;
			if (this.map_type == 'google') {
				center = new google.maps.LatLng(lat, lng);
				this.map = new google.maps.Map( this.map_wrapper.get(0), {
					center           : center,
					zoom             : zoom*1,
					streetViewControl: false,
					mapTypeId        : google.maps.MapTypeId.ROADMAP
				} );
				this.marker = new google.maps.Marker( { position: center, map: this.map, draggable: true } );
				this.geocoder = new google.maps.Geocoder();
			} else if (this.map_type == 'yandex') {
				center = [lat, lng].map(parseFloat);
				this.map = new ymaps.Map(
									this.map_wrapper.attr('id'),
									{
										center: center,
										zoom: zoom*1,
									},
									{
										searchControlProvider: 'yandex#search'
									}
								);
				this.marker = new ymaps.Placemark(
													center,
													{},
													{
														draggable: true
													}
												);
				this.map.geoObjects.add(this.marker);	
			}
			this.addListeners();
		},
		
		// Detect current user position
		geoLocation: function() {
			if (navigator.geolocation) {
				var map_object = this;
				// If user not answer for geo location request - init map with default location
				var geolocation_finished = false;
				navigator.geolocation.getCurrentPosition(
					// If geolocation success
					function(position) {
						map_object.lat = position.coords.latitude;
						map_object.lng = position.coords.longitude;
						if (!geolocation_finished) {
							geolocation_finished = true;
							map_object.initMapElements();
						} else {
							if (map_object.map_type == 'google') {
								var latlng = new google.maps.LatLng(map_object.lat, map_object.lng);
								map_object.map.setCenter(latlng);
								map_object.marker.setPosition(latlng);
							} else if (map_object.map_type == 'yandex') {
								var latlng = [map_object.lat, map_object.lng];
								map_object.map.setCenter(latlng);
								map_object.marker.setPosition(latlng);
							}
						}
					},
					// If geolocation failed
					function(error) {
						if (!geolocation_finished) {
							geolocation_finished = true;
							map_object.initMapElements();
						}
					}
				);
				setTimeout(function() {
					if (!geolocation_finished) {
						geolocation_finished = true;
						map_object.initMapElements();
					}
				}, 10000);
			} else {
				this.initMapElements();
			}
		},

		// Add event listeners
		addListeners: function() {
			var map_object = this;

			if (map_object.map_type == 'google') {
				google.maps.event.addListener( this.map, 'click', function(e) {
					map_object.marker.setPosition(e.latLng);
					map_object.updateParams(e.latLng);
				});

				google.maps.event.addListener( this.map, 'zoom_changed', function(e) {
					map_object.updateParams(map_object.marker.getPosition());
				});

				google.maps.event.addListener( this.marker, 'drag', function (e) {
					map_object.updateParams(e.latLng);
				});
			} else if (map_object.map_type == 'yandex') {
				map_object.marker.events.add("dragend", function (e) {
						var coords = this.geometry.getCoordinates();
						map_object.updateParams(coords);
					}, this.marker);
				map_object.map.events.add('click', function (e) {        
					map_object.updateParams(e.get('coords'));
				});	
				map_object.map.events.add('boundschange', function (e) {
					if (e.get('newZoom') != e.get('oldZoom') || e.get('newCenter') != e.get('oldCenter')) {
						map_object.updateParams(map_object.marker.geometry.getCoordinates());
					}
				});	

			}

			this.map_wrapper.parent().find('.trx_addons_options_map_search_text').on( 'keydown', function (e) {
				if (e.keyCode == 13) {
					jQuery(this).next().trigger('click');
					e.preventDefault();
					return false;
				}
			});
			this.map_wrapper.parent().find('.trx_addons_options_map_search_button').on( 'click', function () {
				map_object.geocodeAddress();
				return false;
			} );

			jQuery(document).on('admin_action.init_hidden_elements', function(e, container) {
				if (container === undefined) container = jQuery('.trx_addons_options');
				container.find('.trx_addons_options_map').each(function() {
					var map_object = jQuery(this).data('map-object');
					if (map_object) map_object.refresh();
				});
			});
		},

		refresh: function() {
			var map_object = this;
			if (this.map) {
				var zoom = this.map.getZoom(),
					center = this.map.getCenter();
				if (map_object.map_type == 'google') {
					google.maps.event.trigger(this.map, 'resize');
				}
				this.map.setZoom(zoom);
				this.map.setCenter(center);
			}
		},

		// Update coordinate to input field
		updateParams: function(latLng) {
			var coords = this.map_type == 'google'
							? latLng.lat() + ',' + latLng.lng() + ',' + this.map.getZoom()
							: (this.map_type == 'yandex'
								? latLng[0] + ',' + latLng[1] + ',' + this.map.getZoom()
								: ''
								);
			if (this.map_type == 'yandex') {
				this.marker.getOverlaySync().getData().geometry.setCoordinates(latLng);
			}
			if (coords != '') {
				this.map_wrapper.siblings('input[type="hidden"]').val(coords);
			}
		},

		// Find coordinates by address
		geocodeAddress: function() {
			var map_object = this,
				address = this.map_wrapper.parent().find('.trx_addons_options_map_search_text').val();
			if (address) {
				if (map_object.map_type == 'google') {
					this.geocoder.geocode({'address': address}, function(results, status) {
						if (status === google.maps.GeocoderStatus.OK) {
							map_object.map.setCenter(results[0].geometry.location);
							map_object.marker.setPosition(results[0].geometry.location);
							map_object.updateParams(results[0].geometry.location);
						}
					});
				} else if (map_object.map_type == 'yandex') {
					ymaps
						.geocode(address)
						.then(
							function (res) {
								var coords = false;
								try {
									coords = res.geoObjects.properties.get('metaDataProperty').GeocoderResponseMetaData.Point.coordinates;
									map_object.map.setCenter([ coords[1], coords[0] ]);
									map_object.updateParams([ coords[1], coords[0] ]);
								} catch (e) {
									// Do nothing
									console.log('Error detect coords for "'+address+'"');
								}
							},
							function (err) {
								// Error handling
								console.log(TRX_ADDONS_STORAGE['msg_sc_yandexmap_geocoder_error']);
								console.log(err);
							}
						);					
				}
			}
		}
	};


	// First time init all maps
	//-------------------------------------------------
	jQuery('.trx_addons_options_map:not(.inited)').each(function() {
		var map_object = new MapObject(jQuery(this));
		map_object.init();
		jQuery(this).addClass('inited').data('map-object', map_object);
	});

});