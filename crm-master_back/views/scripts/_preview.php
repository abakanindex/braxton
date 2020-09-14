<?php
$script = <<<JS
var latitude = $model->latitude;
var longitude = $model->longitude;
var defaultMarker = {lat: latitude, lng: longitude};

var mapOptions = {
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: defaultMarker
};
var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
placeMarker(new google.maps.LatLng(latitude, longitude));

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
    map.setCenter(location);
}
JS;

$this->registerJs($script);
?>