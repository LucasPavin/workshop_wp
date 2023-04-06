let contact = {

    load() {
        let map = document.getElementById("contact-map");
        //only load contact map if page map wrapper #contact-map exist
        if (map) {
            document.addEventListener("DOMContentLoaded", function() {
                getScript("https://maps.googleapis.com/maps/api/js?key=" + wp_data.options.maps_google_api_key, function () {
                    contact.loaded();
                });
            });
        }
    },

    loaded() {

        google_new_map('contact-map');

        // Create a Google Map
        function google_new_map(element) {
            let mapElement = document.getElementById(element);
            let markersList = mapElement.querySelectorAll('.marker');
            try {

                let styles = [];
                if (wp_data.options.maps_snazzy !== '') {
                    styles = JSON.parse(wp_data.options.maps_snazzy);
                }

                let args = {
                    zoom: 16,
                    center: new google.maps.LatLng(mapElement.getAttribute('data-center-lat'), mapElement.getAttribute('data-center-lng')),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: styles,
                };

                let map = new google.maps.Map(mapElement, args);
                // Default Icon
                let icon = {
                    url: wp_data.images_path + 'pin.png',
                    size: new google.maps.Size(40, 50),
                    scaledSize: new google.maps.Size(40, 50),
                    anchor: new google.maps.Point(20, 50)
                };

                // Custom Icon
                if (wp_data.options.maps_pin !== false) {
                    icon = {
                        url: wp_data.options.maps_pin,
                        size: new google.maps.Size(wp_data.options.maps_pin_width, wp_data.options.maps_pin_height),
                        scaledSize: new google.maps.Size(wp_data.options.maps_pin_width, wp_data.options.maps_pin_height),
                        anchor: new google.maps.Point(Math.round(wp_data.options.maps_pin_width / 2), wp_data.options.maps_pin_height)
                    };
                }
                map.markers = [];
                markersList.forEach(el => {
                    google_add_marker(el, map, icon);
                });

                google_center_map(map);

                return map;
            } catch (e) {
                console.warn('Cannot add map yet.');
            }

        }

        function google_add_marker(markerElement, map, icon) {

            try {
                let latlng = new google.maps.LatLng(markerElement.getAttribute('data-lat'), markerElement.getAttribute('data-lng'));

                // create marker
                let marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: icon,
                });

                // add to array
                map.markers.push(marker);

                // if marker contains HTML, add it to an infoWindow
                if (markerElement.innerHTML) {
                    // create info window
                    let infowindow = new google.maps.InfoWindow({
                        content: markerElement.innerHTML
                    });

                    // show info window when marker is clicked
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }
            } catch (e) {
                console.warn('Cannot add markers yet.');
            }
        }

        function google_center_map(map) {

            try {
                let bounds = new google.maps.LatLngBounds();
                
                // loop through all markers and create bounds
                map.markers.forEach(marker => {
                    let latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());

                    bounds.extend(latlng);

                });

                // only 1 marker?
                if (map.markers.length === 1) {
                    // set center of map
                    map.setCenter(bounds.getCenter());
                    map.setZoom(16);
                } else {
                    // fit to bounds
                    map.fitBounds(bounds);
                }
            } catch (e) {
                console.warn('Cannot center map.');
            }
        }
    }
};

function getScript(scriptUrl, callback) {
    const script = document.createElement('script');
    script.src = scriptUrl;
    script.onload = callback;

    document.body.appendChild(script);
}

export default contact;