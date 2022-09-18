// map process
function viewmap(kelompok, latitude, longitude) {
    // mapbox
    let zoom_map = 0;
    let provisi = "";
    switch (kelompok) {
        case "provinsi":
            zoom_map = 4;
            break;
        case "kota":
            zoom_map = 6;
            provisi = $("#provinsi").val();
            break;
    }
    mapboxgl.accessToken = 'pk.eyJ1IjoidXRhbTEzIiwiYSI6ImNrZHd1Y3I5NDJkcW8ydmxqMXkwZWkzMWkifQ.Z-zmtvcgrLtSZspPkKrFjw';
    let geojson = {
        'type': kelompok,
        'features': [{
            'type': 'marker',
            "properties": {
                "iconSize": [35, 38]
            },
            'geometry': {
                'type': 'Point',
                'coordinates': [longitude, latitude]
            }
        }]
    };

    let map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [longitude, latitude],
        zoom: zoom_map
    });

    // Create a default Marker and add it to the map.
    $.ajax({
        url: loc + 'monitoring_penyedia/koordinat/' + kelompok + '/' + provisi,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);
            // add markers to map
            for(let i = 0; i < response.length; i++) {
                let obj = response[i];
                let marker = new mapboxgl.Marker()
                    .setLngLat([obj.longitude, obj.latitude])
                    .addTo(map);
            }
        }
    });
}
// end map proses