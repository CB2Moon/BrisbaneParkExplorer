// Agafonkin, V.(2011)Leaflet(Version 1.9.2)[Source code] https://github.com/Leaflet/Leaflet
// OpenStreetMap(2004)OpenStreetMap[Source code] https://www.openstreetmap.org/
// Dave, L.(2012)Leaflet.markercluster(Version 1.5.3)[Source code]https://github.com/Leaflet/Leaflet.markercluster
// jQuery(2006)jQuery(Version 3.6.1)[Source code] https://github.com/jquery
function goSearch() {
    let input = $("#search-input").val();
    if (input === '') input = 'NULL';
    $.get(`./search-result/${input}`, function (data) {
        $("#search-suggestions").html(data);
    });
}

function goGet(want) {
    var res;
    $.ajax({
        url: `./search/map/${want}`,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function (data) { res = data; }
    });
    return res;
}

function parkMarkers(redIcon) {
    var parksMarkerGroup = L.markerClusterGroup();
    goGet('0allParks').forEach((park) => {
        parksMarkerGroup.addLayer(makeParkMarker(park, redIcon));
    });
    return parksMarkerGroup;
}
function makeParkMarker(park, redIcon) {
    const lat = park['lat'];
    const lng = park['lng'];
    const park_id = park['park_id'];
    const park_name = park['park_name'];
    var marker = L.marker([lat, lng], { icon: redIcon }).bindPopup(park_name);
    marker.on('click', () => {showParkInfo(park_id)});
    return marker;
}
function showParkInfo(park_id) {
    $('#no-marker-clicked').hide();
    $('#marker-clicked').css('display', 'flex');
    $.get(`./search/park/${park_id}`, (data) => {
        $('#marker-clicked').html(data);
    });
}

function activityMarkers() {
    var activitiesMarkerGroup = L.markerClusterGroup();
    goGet('0allActivities').forEach((activity) => {
        activitiesMarkerGroup.addLayer(makeActivityMarker(activity));
    });
    return activitiesMarkerGroup;
}
function makeActivityMarker(activity) {
    const lat = activity['lat'];
    const lng = activity['lng'];
    const park_id = activity['park_id'];
    const activity_name = activity['name'];

    var marker = L.marker([lat, lng]).bindPopup(activity_name);
    marker.on('click', () => {showAcitivityInfo(park_id, activity_name)});
    return marker;
}
function showAcitivityInfo(park_id, activity_name) {
    $('#no-marker-clicked').hide();
    $('#marker-clicked').css('display', 'flex');
    $.get(`./search/activity/${park_id}${activity_name.replaceAll(' ', '_')}`, (data) => {
        $('#marker-clicked').html(data);
    });
}

function facilityMarkers(orangeIcon) {
    var facilitiesMarkerGroup = L.markerClusterGroup();
    goGet('0allFacilities').forEach((facility) => {
        facilitiesMarkerGroup.addLayer(makeFacilityMarker(facility, orangeIcon));
    });
    return facilitiesMarkerGroup;
}
function makeFacilityMarker(facility, orangeIcon) {
    const item_type = facility['item_type'];
    const lat = facility['lat'];
    const lng = facility['lng'];
    const park_id = facility['park_id'];

    var marker = L.marker([lat, lng], { icon: orangeIcon }).bindPopup(item_type);
    marker.on('click', () => {showFacilityInfo(park_id, item_type)});
    return marker;
}
function showFacilityInfo(park_id, item_type) {
    $('#no-marker-clicked').hide();
    $('#marker-clicked').css('display', 'flex');
    $.get(`./search/facility/${park_id}${item_type.replaceAll(' ', '_').replaceAll("/", '___')}`, (data) => {
        $('#marker-clicked').html(data);
    });
}

function markerEvent(parksOverlay, activitiesOverlay, facilitiesOverlay, dynamicOverlay) {
    var monochromeStyle = L.tileLayer(
        "https://stamen-tiles.a.ssl.fastly.net/toner/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; <a href=""https://www.openstreetmap.org/copyright>OpenStreetMap</a> contributors'
    }
    );
    var colorfulStyle = L.tileLayer(
        "https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 18,
            attribution: '&copy; <a href=""https://www.openstreetmap.org/copyright>OpenStreetMap</a> contributors'
        }
    );
    var myMap = L.map("map", {
        center: [-27.4, 153],
        zoom: 10,
        layers: [monochromeStyle, dynamicOverlay, parksOverlay]
    });
    // For More Map Style, go to https://wiki.openstreetmap.org/wiki/Tile_servers

    var baseMaps = {
        "Monochrome Style": monochromeStyle,
        "Chromatic Style": colorfulStyle
    };
    var overlayMaps = {
        "Search results": dynamicOverlay,
        "Parks": parksOverlay,
        "Activities": activitiesOverlay,
        "Facilities": facilitiesOverlay
    };
    return L.control.layers(baseMaps, overlayMaps).addTo(myMap);
}


$(document).ready(function () {
    goSearch();
    $("#search-input").focus(function () {
        $("#search-suggestions").fadeIn("fast");
        $("#search-main form").addClass("active");
    });
    $("#search-input").blur(function () {
        $("#search-suggestions").fadeOut("fast");
        $("#search-main form").removeClass("active");
    });
    $("#search-input").keyup(goSearch);
    var LeafIcon = L.Icon.extend({
        options: {
            shadowUrl: './css/images/leaf-shadow.png',
            iconSize: [25, 75],
            shadowSize: [40, 54],
            iconAnchor: [12, 74],
            shadowAnchor: [4, 55],
            popupAnchor: [-3, -76]
        }
    });
    // greenIcon = new LeafIcon({ iconUrl: './css/images/leaf-green.png' }),
    var redIcon = new LeafIcon({ iconUrl: './css/images/leaf-red.png' }),
        orangeIcon = new LeafIcon({ iconUrl: './css/images/leaf-orange.png' });
    
    // markers repository, not gonna change
    var basicOverlayOrigin = {
        "Parks": parkMarkers(redIcon),
        "Activities": activityMarkers(),
        "Facilities": facilityMarkers(orangeIcon)
    };

    // for the actual display
    var parksOverlay = L.markerClusterGroup();
    basicOverlayOrigin['Parks'].getLayers().forEach(layer => parksOverlay.addLayer(layer));
    var activitiesOverlay = L.markerClusterGroup();
    basicOverlayOrigin['Activities'].getLayers().forEach(layer => activitiesOverlay.addLayer(layer));
    var facilitiesOverlay = L.markerClusterGroup();
    basicOverlayOrigin['Facilities'].getLayers().forEach(layer => facilitiesOverlay.addLayer(layer));
    var dynamicOverlay = L.markerClusterGroup();
    var layerControl = markerEvent(parksOverlay, activitiesOverlay, facilitiesOverlay, dynamicOverlay);

    $(document).on('click', '.suggestion-option', (e)=>{
        console.log(e.target);
        parksOverlay.clearLayers();
        activitiesOverlay.clearLayers();
        facilitiesOverlay.clearLayers();
        dynamicOverlay.clearLayers();
        switch ($(e.target).data('tagtype')) {
            case 'park':{
                park_id = $(e.target).data('name');
                park = goGet('1' + park_id)[0];
                dynamicOverlay.addLayer(makeParkMarker(park, redIcon));
                showParkInfo(park['park_id']);
                break;
            }
            case 'activity':{
                activity_name = $(e.target).data('name');
                activities = goGet('2' + activity_name.replaceAll(' ', '_'));
                activities.forEach(activity => {
                    dynamicOverlay.addLayer(makeActivityMarker(activity))
                });
                break;
            }
            case 'facility':{
                item_type = $(e.target).data('name');
                parksHaveItemType = goGet('3' + item_type.replaceAll(' ', '_').replaceAll("/", '___'));
                parksHaveItemType.forEach(parkHasItemType => {
                    dynamicOverlay.addLayer(makeParkMarker(parkHasItemType, redIcon))
                });
                break;
            }
            default:{
                basicOverlayOrigin['Parks'].getLayers().forEach(layer => parksOverlay.addLayer(layer));
                basicOverlayOrigin['Activities'].getLayers().forEach(layer => activitiesOverlay.addLayer(layer));
                basicOverlayOrigin['Facilities'].getLayers().forEach(layer => facilitiesOverlay.addLayer(layer));
                break;
            }
        }
    });
});