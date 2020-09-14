<?php
use yii\web\View;

$script = <<<JS
        var locations    = $locations;
        var subLocations = $subLocations;

        $(document).ready(function() {
            var latitude = parseFloat($('#latitude').val());
            var longitude = parseFloat($('#longitude').val());
            var markers = [];
            var defaultMarker = {lat: latitude, lng: longitude};

            var mapOptions = {
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: defaultMarker
            };
            var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
            placeMarker(new google.maps.LatLng(latitude, longitude));

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            function removeMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
            }

            function placeMarker(location) {
                removeMarkers();
                $('#latitude').val(location.lat());
                $('#longitude').val(location.lng());


                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markers.push(marker);
                map.setCenter(location);
            }

            function changeGeocoder() {
                var geocoder = new google.maps.Geocoder();
                var request = {
                    address: $('#emirateDropDown option:selected').text() + ' ' + $('#locationDropDown option:selected').text() + ' ' + $('#subLocationDropDown option:selected').text(),
                    componentRestrictions: {
                        country: 'AE'
                    }
                };

                geocoder.geocode(request, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        removeMarkers();
                        map.setCenter(results[0].geometry.location);
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
                        $('#latitude').val(latitude);
                        $('#longitude').val(longitude);

                        placeMarker(results[0].geometry.location);
                    } else {
                    }
                });
            }

            $('body').on('change', '#emirateDropDown', function() {
                var val = $('#emirateDropDown option:selected').val();
                var text = $('#emirateDropDown option:selected').text();
                $('#locationDropDown').find('option').not(':first').remove();
                $('#subLocationDropDown').find('option').not(':first').remove();

                if (val > 0) {
                    changeGeocoder();
                    var emirateLocations = locations[val];
                    for (var i = 0; i < emirateLocations.length; i++) {
                        $('#locationDropDown').append($('<option>', {
                            value: emirateLocations[i].id,
                            text : emirateLocations[i].name
                        }));
                    }
                }
            })

            $('body').on('change', '#locationDropDown', function() {
                changeGeocoder();
                var val = $(this).val();
                $('#subLocationDropDown').find('option').not(':first').remove();

                if (val > 0) {
                    var subLocationData = subLocations[val];
                    for (var i = 0; i < subLocationData.length; i++) {
                        $('#subLocationDropDown').append($('<option>', {
                            value: subLocationData[i].id,
                            text : subLocationData[i].name
                        }));
                    }
                }
            })

            $('body').on('change', '#subLocationDropDown', function() {
                changeGeocoder();
                var val = $(this).val();
                var text = $('#subLocationDropDown option:selected').text();
            });

            changeGeocoder();
        })
JS;

$this->registerJs($script, View::POS_READY)
?>