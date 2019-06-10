/**
 * Created by ARslan on 12/15/2017.
 */

oRsc.buildMap = function(){
    L.mapbox.accessToken = 'pk.eyJ1IjoibXJjbGFya3NvbiIsImEiOiJuTmlPaTM0In0.hImtadsV4kMLI_iihZkILg';
    // this.map = L.mapbox.map('map', 'mrclarkson.led029e4', {
    //     zoomControl: false,
    //    // maxBounds: [[-90,-180], [90,180]],
    //     tileLayer: {
    //         continuousWorld: false,
    //         noWrap: true
    //     },
    //     minZoom:2
    // });

this.map = L.mapbox.map('map',null,{
    minZoom: 2,
    zoomControl: false
});
    new L.Control.Zoom({
        position: 'topright'
    }).addTo(this.map);

    L.mapbox.styleLayer("mapbox://styles/mapbox/light-v10", {
        continuousWorld: false,
        noWrap: true,
        bounds: [[-90, -180],[200, 180]]
    }).addTo(this.map);

    this.terrainLayer = L.mapbox.tileLayer('mrclarkson.l4be5cih', {
        continuousWorld: false,
        noWrap: true
    });

    this.geoJsonLayer = L.geoJson([], {onEachFeature: this.featureAdd});
    this.featureLayer = L.mapbox.featureLayer().addTo(this.map);
    var that = this;
    this.terrainLayer.on('ready', function(layer) {
        that.overlayReports();
    });
};